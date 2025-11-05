<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit;
}

require 'includes/db_connect.php';

// Fetch total inquiries
$res = $conn->query("SELECT COUNT(*) AS total FROM inquiries");
$total_inquiries = ($res) ? (int)$res->fetch_assoc()['total'] : 0;

$admin_user = $_SESSION['admin_user'] ?? 'Admin';

// Capture logout message if redirected
$logout_msg = '';
if (isset($_GET['status']) && $_GET['status'] === 'logged_out') {
    $logout_msg = '✅ You have successfully logged out.';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard | AI Solutions</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
<style>
/* ---------- Body & Global ---------- */
body {
    font-family: 'Segoe UI', sans-serif;
    margin:0;
    background: #4d6b99ff;
    display:flex;
    flex-direction:column;
    min-height:100vh;
}

/* ---------- Header ---------- */
.header {
    position: fixed;
    top:0;
    left:0;
    right:0;
    height:80px;
    background: linear-gradient(135deg, #75aad895, #75aad895);
    display:flex;
    justify-content: space-between;
    align-items: center;
    padding:0 30px;
    color:#fff;
    box-shadow:0 4px 15px rgba(0,0,0,0.2);
    z-index:1000;
}
.header .logo {
    display:flex;
    align-items:center;
    font-size:1.8rem;
    font-weight:700;
}
.header .logo img {
    height:70px;
    margin-right:15px;
    border-radius:10px;
    box-shadow:0 4px 10px rgba(0,0,0,0.3);
}
.header .user-actions {
    display:flex;
    align-items:center;
    gap:15px;
    font-weight:600;
}
.header .logout-btn {
    background:#ff4d4d;
    color:#fff;
    padding:8px 20px;
    border-radius:8px;
    text-decoration:none;
    font-weight:bold;
    transition:0.3s;
}
.header .logout-btn:hover { background:#e60000; }

/* ---------- Main ---------- */
main {
    padding:140px 20px 120px;
    max-width:1200px;
    margin:0 auto;
    flex:1;
}

/* ---------- Hero ---------- */
.hero {
    background: linear-gradient(135deg, #6ba8ddff, #69b5deff);
    border-radius: 20px;
    color: #ffffffff;
    text-align: center;
    padding: 50px 20px;
    margin-bottom:40px;
    box-shadow:0 8px 25px rgba(0,0,0,0.25);
}
.hero h1 { font-size:3rem; margin-bottom:15px; letter-spacing:1px; }
.hero p { font-size:1.3rem; color:#d9faff; }

/* ---------- Logout Message ---------- */
.logout-msg {
    text-align:center;
    font-size:1rem;
    color:#00ff99;
    margin-bottom:20px;
}

/* ---------- Cards ---------- */
.cards {
    display:flex;
    flex-wrap:wrap;
    gap:20px;
    justify-content: center;
    margin-bottom:40px;
}
.card {
    flex:1 1 220px;
    max-width: 250px;
    padding:30px 20px;
    border-radius:20px;
    text-align:center;
    color:#fff;
    box-shadow:0 8px 25px rgba(0,0,0,0.2);
    transition:0.3s;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
}
.card:hover {
    transform: translateY(-8px);
    box-shadow:0 15px 30px rgba(0,0,0,0.35);
}
.card i {
    font-size:2.5rem;
    margin-bottom:15px;
}

/* Card colors */
.card.inquiries { background:#1f8ef1; }
.card.blog { background:#00cc66; }
.card.gallery { background:#ff9933; }
.card.projects { background:#9933ff; }
.card.feedbacks { background:#F98B88; }

.card h2 { font-size:2.2rem; margin:10px 0; }
.card p { font-size:1.1rem; margin-bottom:15px; }
.card a { text-decoration:none; color:#fff; font-weight:bold; transition:0.3s; }
.card a:hover { text-decoration:underline; }

/* ---------- Quick Links ---------- */
.section-links {
    text-align:center;
    margin-top:20px;
}
.section-links a {
    display:inline-block;
    margin:0 15px;
    padding:10px 20px;
    background:#1f8ef1;
    color:#fff;
    border-radius:10px;
    font-weight:600;
    text-decoration:none;
    transition:0.3s;
}
.section-links a:hover { background:#0aaaff; }

/* ---------- Footer ---------- */
.footer {
    background:#75aad895;
    color:#fff;
    text-align:center;
    padding:20px;
    box-shadow:0 -2px 8px rgba(0,0,0,0.15);
    font-weight:600;
    position: relative;
    bottom:0;
    width:100%;
    border-top-left-radius:15px;
    border-top-right-radius:15px;
}
</style>
</head>
<body>

<!-- Header -->
<div class="header">
    <div class="logo">
        <img src="images/aisolutionslogo.jpeg">
    </div>
    <div class="user-actions">
        <span>Welcome, <?php echo htmlspecialchars($admin_user); ?></span>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</div>

<main>
    <!-- Logout Message -->
    <?php if($logout_msg): ?>
        <div class="logout-msg"><?php echo $logout_msg; ?></div>
    <?php endif; ?>

    <!-- Hero -->
    <div class="hero">
        <h1>Welcome, <?php echo htmlspecialchars($admin_user); ?>!</h1>
        <p>Here is your website overview</p>
    </div>

    <!-- Stats Cards -->
    <div class="cards">
        <div class="card inquiries">
            <i class="fa-solid fa-envelope"></i>
            <h2><?php echo $total_inquiries; ?></h2>
            <p>Total Inquiries</p>
            <a href="view_inquiries.php">View Details →</a>
        </div>
        <div class="card blog">
            <i class="fa-solid fa-blog"></i>
            <h2>4</h2>
            <p>Blog Posts</p>
            <a href="admin_blog.php">Manage →</a>
        </div>
        <div class="card gallery">
            <i class="fa-solid fa-image"></i>
            <h2>7</h2>
            <p>Gallery Images</p>
            <a href="admin_gallery.php">Manage →</a>
        </div>
        <div class="card projects">
            <i class="fa-solid fa-diagram-project"></i>
            <h2>5</h2>
            <p>Projects</p>
            <a href="admin_projects.php">Manage →</a>
        </div>
         <div class="card feedbacks">
            <i class="fa-solid fa-diagram-feedbacks"></i>
            <h2>5</h2>
            <p> Feedbacks</p>
            <a href="admin_feedbacks.php">Manage →</a>
        </div>
    </div>

</main>

<!-- Footer -->
<div class="footer">
    &copy; <?php echo date('Y'); ?> AI Solutions. All rights reserved.
</div>

</body>
</html>
