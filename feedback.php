<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AI Solutions | Customer Feedback</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body style="background:#eef3f7; font-family: 'Segoe UI', sans-serif;">
<?php
require 'includes/db_connect.php';
$msg = '';

// --- Handle form submission ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $company = trim($_POST['company'] ?? '');
    $rating = (int)($_POST['rating'] ?? 0);
    $message = trim($_POST['message'] ?? '');

    if ($name && $rating >= 1 && $rating <= 5 && $message) {
        $stmt = $conn->prepare("INSERT INTO feedback (name, company, rating, message) VALUES (?,?,?,?)");
        $stmt->bind_param("ssis", $name, $company, $rating, $message);
        if ($stmt->execute()) {
            $stmt->close();
            // --- Redirect after successful insertion to prevent duplicates ---
            header("Location: feedback.php?success=1");
            exit;
        }
        $stmt->close();
    } else {
        $msg = "⚠️ Please fill all required fields correctly.";
    }
}

// --- Show success message after redirect ---
if (isset($_GET['success']) && $_GET['success'] == 1) {
    $msg = "✅ Thank you for your feedback!";
}

// --- Dummy feedbacks ---
$dummy_feedbacks = [
    ["name" => "Sujan Shrestha", "company" => "TechWare Pvt. Ltd.", "rating" => 5, "message" => "Excellent service and professional team!", "created_at" => "2025-09-12"],
    ["name" => "Priya Adhikari", "company" => "DataLogic Nepal", "rating" => 4, "message" => "Timely project delivery and great support.", "created_at" => "2025-08-18"],
    ["name" => "Ramesh KC", "company" => "SkyNet Solutions", "rating" => 5, "message" => "Very satisfied with the AI software solution.", "created_at" => "2025-07-02"],
    ["name" => "Nisha Sharma", "company" => "NextGen IT", "rating" => 4, "message" => "User-friendly interface and smooth performance.", "created_at" => "2025-06-15"],
    ["name" => "Anil Gurung", "company" => "CloudEra", "rating" => 5, "message" => "Highly recommended for enterprise solutions.", "created_at" => "2025-05-29"]
];

// --- Fetch feedback from DB ---
$feedbacks_from_db = [];
$result = $conn->query("SELECT name, company, rating, message, created_at FROM feedback ORDER BY created_at DESC");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $feedbacks_from_db[] = $row;
    }
}

// --- Merge dummy + DB feedbacks ---
$feedbacks = array_merge($dummy_feedbacks, $feedbacks_from_db);
?>

<?php include 'includes/header.php'; ?>

<!-- 🌟 Feedback Display Section -->
<section class="feedback-list" style="padding:140px 20px 80px;">
  <div class="container" style="max-width:950px; margin:0 auto;">
    <h1 style="text-align:center; color:#FFFFFF;">What Our Clients Say</h1>
    <p style="text-align:center; color:#FFFFFF;">Real experiences from satisfied clients who trusted our AI-powered solutions.</p>

    <div class="feedback-grid" style="display:grid; grid-template-columns:repeat(auto-fit,minmax(280px,1fr)); gap:25px; margin-top:50px;">
      <?php foreach ($feedbacks as $f): ?>
        <div style="
          background: linear-gradient(135deg, #ffffff 0%, #f0f4fa 100%);
          border-radius:12px;
          padding:25px;
          box-shadow:0 4px 12px rgba(0,0,0,0.08);
          transition:transform 0.25s ease, box-shadow 0.25s ease;
        " onmouseover="this.style.transform='translateY(-5px)';this.style.boxShadow='0 6px 18px rgba(0,0,0,0.15)';"
          onmouseout="this.style.transform='none';this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)';">
          <h3 style="margin:0; color:#1f3b73;"><?php echo htmlspecialchars($f['name']); ?></h3>
          <p style="color:#6b7a8f; font-size:0.9em;"><?php echo htmlspecialchars($f['company']); ?></p>
          <p style="color:#f5b301; font-size:1.2em; margin:8px 0;">
            <?php echo str_repeat('★', $f['rating']); ?>
            <?php echo str_repeat('☆', 5 - $f['rating']); ?>
          </p>
          <p style="font-style:italic; color:#2e3d55;">"<?php echo htmlspecialchars($f['message']); ?>"</p>
          <p style="font-size:0.8em; color:#8a98a8; text-align:right;"><?php echo date('F j, Y', strtotime($f['created_at'])); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ✍️ Feedback Form Section -->
<section class="page-section" style="
  padding:80px 20px;
  background:linear-gradient(135deg, #5f6e8978 0%, #5f6e8978 100%);
  color:#fff;
">
  <div class="container" style="max-width:700px; margin:0 auto; text-align:center;">
    <h2 style="color:#ffffff;">Submit Your Feedback</h2>
    <p style="color:#dce3f1;">Your insights help us grow and continue delivering exceptional AI-driven solutions.</p>

    <?php if ($msg): ?>
      <p style="color:#a3f7bf; font-weight:bold; margin:15px 0;"><?php echo htmlspecialchars($msg); ?></p>
    <?php endif; ?>

    <form method="post" style="margin-top:30px; text-align:left;">
      <label style="color:#fff;">Your Name:</label>
      <input type="text" name="name" placeholder="Your Name" required 
        style="width:100%; padding:12px; margin:10px 0; border-radius:8px; border:none; background:#f7f9fb; color:#000;">

      <label style="color:#fff;">Company (optional):</label>
      <input type="text" name="company" placeholder="Company (optional)" 
        style="width:100%; padding:12px; margin:10px 0; border-radius:8px; border:none; background:#f7f9fb; color:#000;">

      <label style="color:#fff;">Rating:</label>
      <select name="rating" required 
        style="width:100%; padding:12px; margin:10px 0; border-radius:8px; border:none; background:#f7f9fb; color:#000;">
        <option value="">Select</option>
        <option value="5">★★★★★</option>
        <option value="4">★★★★</option>
        <option value="3">★★★</option>
        <option value="2">★★</option>
        <option value="1">★</option>
      </select>

      <label style="color:#fff;">Your Feedback:</label>
      <textarea name="message" placeholder="Your Feedback" rows="5" required 
        style="width:100%; padding:12px; margin:10px 0; border-radius:8px; border:none; background:#f7f9fb; color:#000;"></textarea>

      <input type="submit" value="Submit Feedback" 
        style="padding:12px 25px; background:#1f8ef1; color:#fff; border:none; border-radius:8px; cursor:pointer; transition:background 0.3s;">
    </form>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
</body>
</html>
