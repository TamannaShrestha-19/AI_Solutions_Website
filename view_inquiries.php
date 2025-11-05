<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php'); 
    exit;
}
require 'includes/db_connect.php';

// Handle filter/search input
$filter = trim($_GET['filter'] ?? '');

// Prepare SQL query with optional filter
$sql = "SELECT * FROM inquiries";
if ($filter) {
    $sql .= " WHERE name LIKE ? OR email LIKE ? OR company LIKE ? OR job_title LIKE ?";
}
$sql .= " ORDER BY submitted_at DESC";

$stmt = $conn->prepare($sql);
if ($filter) {
    $likeFilter = "%$filter%";
    $stmt->bind_param("ssss", $likeFilter, $likeFilter, $likeFilter, $likeFilter);
}
$stmt->execute();
$res = $stmt->get_result();

$admin_user = $_SESSION['admin_user'] ?? 'Admin';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Inquiries | AI Solutions</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
<style>
body {
    font-family: 'Segoe UI', sans-serif;
    margin:0;
    background:#f0f2f5;
    display:flex;
    flex-direction:column;
    min-height:100vh;
}
.header {
    position: fixed;
    top:0;
    left:0;
    right:0;
    height:80px;
    background: linear-gradient(135deg, #75aad8, #4d6b99);
    display:flex;
    justify-content: space-between;
    align-items: center;
    padding:0 30px;
    color:#fff;
    box-shadow:0 4px 15px rgba(0,0,0,0.2);
    z-index:1000;
}
.header .logo {display:flex; align-items:center; font-size:1.8rem; font-weight:700;}
.header .logo img {height:70px; margin-right:15px; border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,0.3);}
.header .user-actions {display:flex; align-items:center; gap:15px; font-weight:600;}
.header .logout-btn {background:#ff4d4d; color:#fff; padding:8px 20px; border-radius:8px; text-decoration:none; font-weight:bold; transition:0.3s;}
.header .logout-btn:hover { background:#e60000; }

main {padding:140px 20px 120px; max-width:1200px; margin:0 auto; flex:1;}
.hero {background: linear-gradient(135deg, #4d6b99, #75aad8); border-radius: 20px; color: #fff; text-align: center; padding: 40px 20px; margin-bottom:20px; box-shadow:0 8px 25px rgba(0,0,0,0.25);}
.hero h1 { font-size:2.8rem; margin-bottom:10px; }
.hero p { font-size:1.2rem; color:#d9faff; }

.filter-form {margin-bottom:15px; display:flex; gap:10px;}
.filter-form input[type=text] {flex:1; padding:8px; border-radius:6px; border:1px solid #ccc;}
.filter-form button {padding:8px 15px; border:none; border-radius:6px; background:#1f8ef1; color:#fff; cursor:pointer; font-weight:bold; transition:0.3s;}
.filter-form button:hover {background:#0f6ac0;}

.table-container {overflow-x:auto; max-height:600px;}
.table {width:100%; border-collapse:collapse; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 8px 20px rgba(0,0,0,0.1);}
.table thead tr {background:#1f8ef1; color:#fff; text-align:left; position:sticky; top:0; z-index:10;}
.table th, .table td {padding:12px 15px; font-size:0.95rem;}
.table tbody tr:nth-child(even) {background:#f4f7f9;}
.table tbody tr:hover {background:#d0e7ff;}
.table tbody tr.newest {background: #fffae6 !important; font-weight: 600;}

.footer {background:#75aad8; color:#fff; text-align:center; padding:20px; box-shadow:0 -2px 8px rgba(0,0,0,0.15); font-weight:600; position: relative; bottom:0; width:100%; border-top-left-radius:15px; border-top-right-radius:15px;}
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
        <h1>Customer Inquiries</h1>
        <p>View all contact inquiries submitted by users</p>
    </div>

    <!-- Filter Form -->
    <form class="filter-form" method="get">
        <input type="text" name="filter" placeholder="Search by name, email, company, or job title" value="<?php echo htmlspecialchars($filter); ?>">
        <button type="submit"><i class="fas fa-search"></i> Filter</button>
    </form>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Company</th><th>Country</th><th>Job Title</th><th>Submitted At</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $now = new DateTime();
                while($r = $res->fetch_assoc()): 
                    $submitted = new DateTime($r['submitted_at']);
                    $diff = $now->diff($submitted);
                    $row_class = ($diff->days == 0) ? 'newest' : '';
                ?>
                <tr class="<?php echo $row_class; ?>">
                    <td><?php echo $r['id']; ?></td>
                    <td><?php echo htmlspecialchars($r['name']); ?></td>
                    <td><?php echo htmlspecialchars($r['email']); ?></td>
                    <td><?php echo htmlspecialchars($r['phone']); ?></td>
                    <td><?php echo htmlspecialchars($r['company']); ?></td>
                    <td><?php echo htmlspecialchars($r['country']); ?></td>
                    <td><?php echo htmlspecialchars($r['job_title']); ?></td>
                    <td><?php echo $r['submitted_at']; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</main>

<div class="footer">
    &copy; <?php echo date('Y'); ?> AI Solutions. All rights reserved.
</div>

</body>
</html>
