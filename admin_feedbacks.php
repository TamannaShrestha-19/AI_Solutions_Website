<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header('Location: admin_login.php');
  exit;
}

require 'includes/db_connect.php';
$admin_user = $_SESSION['admin_user'] ?? 'Admin';

// --- Dummy feedback data (IDs 1–5) ---
$dummy_feedbacks = [
  ["id" => 1, "name" => "Sujan Shrestha", "company" => "TechWare Pvt. Ltd.", "rating" => 5, "message" => "Excellent service and professional team!", "created_at" => "2025-09-12"],
  ["id" => 2, "name" => "Priya Adhikari", "company" => "DataLogic Nepal", "rating" => 4, "message" => "Timely project delivery and great support.", "created_at" => "2025-08-18"],
  ["id" => 3, "name" => "Ramesh KC", "company" => "SkyNet Solutions", "rating" => 5, "message" => "Very satisfied with the AI software solution.", "created_at" => "2025-07-02"],
  ["id" => 4, "name" => "Nisha Sharma", "company" => "NextGen IT", "rating" => 4, "message" => "User-friendly interface and smooth performance.", "created_at" => "2025-06-15"],
  ["id" => 5, "name" => "Anil Gurung", "company" => "CloudEra", "rating" => 5, "message" => "Highly recommended for enterprise solutions.", "created_at" => "2025-05-29"]
];

// --- Handle edit or delete actions ---
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['edit_id'])) {
    $db_id = (int)$_POST['edit_id'];
    $name = trim($_POST['name']);
    $company = trim($_POST['company']);
    $rating = (int)$_POST['rating'];
    $message = trim($_POST['message']);
    if ($name && $rating >= 1 && $rating <= 5 && $message) {
      $stmt = $conn->prepare("UPDATE feedback SET name=?, company=?, rating=?, message=? WHERE id=?");
      $stmt->bind_param("ssisi", $name, $company, $rating, $message, $db_id);
      if ($stmt->execute()) $msg = "✅ Feedback updated successfully!";
      $stmt->close();
    } else {
      $msg = "⚠️ Fill all fields correctly for edit.";
    }
  } elseif (isset($_POST['delete_id'])) {
    $db_id = (int)$_POST['delete_id'];
    $stmt = $conn->prepare("DELETE FROM feedback WHERE id=?");
    $stmt->bind_param("i", $db_id);
    if ($stmt->execute()) $msg = "🗑️ Feedback deleted successfully!";
    $stmt->close();
  }
}

// --- Fetch real feedback from DB ---
$feedbacks = [];
$res = $conn->query("SELECT id AS db_id, name, company, rating, message, created_at FROM feedback ORDER BY created_at DESC");
if ($res && $res->num_rows > 0) {
  while ($row = $res->fetch_assoc()) {
    $feedbacks[] = $row;
  }
}

// --- Merge dummy + real feedbacks ---
$all_feedbacks = array_merge($dummy_feedbacks, $feedbacks);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Feedbacks | AI Solutions</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      background: #f0f2f5;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      height: 80px;
      background: linear-gradient(135deg, #75aad8, #4d6b99);
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 30px;
      color: #fff;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
      z-index: 1000;
    }

    .header .logo {
      display: flex;
      align-items: center;
      font-size: 1.8rem;
      font-weight: 700;
    }

    .header .logo img {
      height: 70px;
      margin-right: 15px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }

    .header .user-actions {
      display: flex;
      align-items: center;
      gap: 15px;
      font-weight: 600;
    }

    .header .logout-btn {
      background: #ff4d4d;
      color: #fff;
      padding: 8px 20px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
      transition: 0.3s;
    }

    .header .logout-btn:hover {
      background: #e60000;
    }

    main {
      padding: 140px 20px 120px;
      max-width: 1200px;
      margin: 0 auto;
      flex: 1;
    }

    .hero {
      background: linear-gradient(135deg, #4d6b99, #75aad8);
      border-radius: 20px;
      color: #fff;
      text-align: center;
      padding: 40px 20px;
      margin-bottom: 40px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
    }

    .hero h1 {
      font-size: 2.8rem;
      margin-bottom: 10px;
    }

    .hero p {
      font-size: 1.2rem;
      color: #d9faff;
    }

    .table-container {
      overflow-x: auto;
    }

    .table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .table thead tr {
      background: #1f8ef1;
      color: #fff;
      text-align: left;
    }

    .table th,
    .table td {
      padding: 12px 15px;
      font-size: 0.95rem;
    }

    .table tbody tr:nth-child(even) {
      background: #f4f7f9;
    }

    .table tbody tr:hover {
      background: #d0e7ff;
    }

    .table tbody tr.newest {
      background: #fffae6 !important;
      font-weight: 600;
    }

    .rating {
      color: #f5b301;
      font-weight: bold;
    }

    .action-btn {
      padding: 5px 10px;
      margin-right: 5px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      color: #fff;
    }

    .edit-btn {
      background: #1f8ef1;
    }

    .delete-btn {
      background: #ff4d4d;
    }

    .msg {
      margin: 10px 0;
      font-weight: bold;
      color: green;
    }

    input,
    select,
    textarea {
      width: 100%;
      font-size: 0.9rem;
      padding: 4px;
      border-radius: 4px;
      border: 1px solid #ccc;
    }

    textarea {
      resize: none;
    }
  </style>
</head>

<body>

  <div class="header">
    <div class="logo"><img src="images/aisolutionslogo.jpeg"></div>
    <div class="user-actions">
      <span>Welcome, <?php echo htmlspecialchars($admin_user); ?></span>
      <a href="logout.php" class="logout-btn">Logout</a>
    </div>
  </div>

  <main>
    <a href="admin_dashboard.php"
      style="display:inline-block; margin-bottom:20px; padding:8px 15px; background:#1f8ef1; color:#fff; border-radius:6px; text-decoration:none; font-weight:bold;">
      ← Back to Dashboard
    </a>

    <div class="hero">
      <h1>Customer Feedbacks</h1>
      <p>View all feedback submitted by clients</p>
      <?php if ($msg) echo "<p class='msg'>$msg</p>"; ?>
    </div>

    <div class="table-container">
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Company</th>
            <th>Rating</th>
            <th>Feedback</th>
            <th>Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($all_feedbacks as $f):
            $is_dummy = isset($f['id']);
            $display_id = $is_dummy ? $f['id'] : $f['db_id'];
          ?>
            <tr class="<?php echo isset($f['db_id']) && $f === end($all_feedbacks) ? 'newest' : ''; ?>">
              <form method="post">
                <td><?php echo $display_id; ?></td>
                <td><input type="text" name="name" value="<?php echo htmlspecialchars($f['name']); ?>" <?php echo $is_dummy ? 'readonly' : ''; ?>></td>
                <td><input type="text" name="company" value="<?php echo htmlspecialchars($f['company']); ?>" <?php echo $is_dummy ? 'readonly' : ''; ?>></td>
                <td>
                  <select name="rating" <?php echo $is_dummy ? 'disabled' : ''; ?>>
                    <?php for ($i = 5; $i >= 1; $i--): ?>
                      <option value="<?php echo $i; ?>" <?php echo $f['rating'] == $i ? 'selected' : ''; ?>><?php echo str_repeat('★', $i) . str_repeat('☆', 5 - $i); ?></option>
                    <?php endfor; ?>
                  </select>
                </td>
                <td><textarea name="message" <?php echo $is_dummy ? 'readonly' : ''; ?>><?php echo htmlspecialchars($f['message']); ?></textarea></td>
                <td><?php echo date('F j, Y', strtotime($f['created_at'])); ?></td>
                <td>
                  <?php if (!$is_dummy): ?>
                    <input type="hidden" name="edit_id" value="<?php echo $f['db_id']; ?>">
                    <button type="submit" class="action-btn edit-btn">Edit</button>
              </form>
              <form method="post" style="display:inline;">
                <input type="hidden" name="delete_id" value="<?php echo $f['db_id']; ?>">
                <button type="submit" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this feedback?');">Delete</button>
              </form>
            <?php else: ?>
              <span style="color:#999;">—</span>
            <?php endif; ?>
            </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </main>

  <div class="footer">
    &copy; <?php echo date('Y'); ?> AI Solutions. All rights reserved.
  </div>

</body>

</html>