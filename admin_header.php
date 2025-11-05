<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit;
}

// Ensure admin_user session exists
$admin_user = $_SESSION['admin_user'] ?? 'Admin';

require 'includes/db_connect.php';

// Fetch total inquiries
$res = $conn->query("SELECT COUNT(*) AS total FROM inquiries");
$total = ($res) ? (int)$res->fetch_assoc()['total'] : 0;

include 'includes/header.php';
?>

<section class="hero">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1>Admin Dashboard</h1>
        <p>Welcome, <?php echo htmlspecialchars($admin_user); ?>.</p>
    </div>
</section>

<section class="page-section">
    <div class="container">
        <p>Total inquiries: <strong><?php echo $total; ?></strong></p>
        <p>
            <a href="view_inquiries.php">View inquiries</a> |
            <a href="admin_blog.php">Manage blog</a> |
            <a href="admin_gallery.php">Manage gallery</a> |
            <a href="logout.php">Logout</a>
        </p>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
