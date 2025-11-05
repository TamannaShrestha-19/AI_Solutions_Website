<?php
session_start();
if (!isset($_SESSION['admin_user'])) { header('Location: admin_login.php'); exit; }
require 'includes/db_connect.php';

$msg = '';

// Handle Add Post
if(isset($_POST['submit'])){
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $image = $_FILES['image']['name'] ?? '';
    if ($image) {
        $target = 'uploads/' . basename($image);
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) $msg = "Image upload failed.";
    }
    $stmt = $conn->prepare("INSERT INTO blog_posts (title, content, image) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $content, $image);
    if($stmt->execute()) $msg = "Blog post added successfully!";
    $stmt->close();
}

// Handle Delete
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM blog_posts WHERE id=$id");
    header("Location: admin_blog.php");
    exit;
}

// Fetch all blog posts
$res = $conn->query("SELECT * FROM blog_posts ORDER BY created_at DESC");
$admin_user = $_SESSION['admin_user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Blog | AI Solutions</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
<style>
/* ---------- Global ---------- */
body { font-family: 'Segoe UI', sans-serif; margin:0; background:#f0f2f5; display:flex; flex-direction:column; min-height:100vh; }
.header { position: fixed; top:0; left:0; right:0; height:80px; background: linear-gradient(135deg,#75aad8,#4d6b99); display:flex; justify-content: space-between; align-items:center; padding:0 30px; color:#fff; box-shadow:0 4px 15px rgba(0,0,0,0.2); z-index:1000; }
.header .logo { display:flex; align-items:center; font-size:1.8rem; font-weight:700; }
.header .logo img { height:70px; margin-right:15px; border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,0.3); }
.header .user-actions { display:flex; align-items:center; gap:15px; font-weight:600; }
.header .logout-btn { background:#ff4d4d; color:#fff; padding:8px 20px; border-radius:8px; text-decoration:none; font-weight:bold; transition:0.3s; }
.header .logout-btn:hover { background:#e60000; }

/* ---------- Main ---------- */
main { padding:140px 20px 120px; max-width:1200px; margin:0 auto; flex:1; }

/* ---------- Hero ---------- */
.hero { background: linear-gradient(135deg, #4d6b99, #75aad8); border-radius: 20px; color: #fff; text-align:center; padding:40px 20px; margin-bottom:30px; box-shadow:0 8px 25px rgba(0,0,0,0.25); }
.hero h1 { font-size:2.8rem; margin-bottom:10px; letter-spacing:1px; }
.hero p { font-size:1.2rem; color:#d9faff; }

/* ---------- Form ---------- */
form { background:#fff; padding:20px; border-radius:15px; box-shadow:0 8px 20px rgba(0,0,0,0.1); margin-bottom:30px; display:flex; flex-direction:column; gap:15px; }
form input[type=text], form textarea, form input[type=file] { padding:10px; border-radius:8px; border:1px solid #ccc; font-size:1rem; width:100%; }
form input[type=submit] { width:150px; background:#1f8ef1; color:#fff; border:none; border-radius:8px; padding:10px; cursor:pointer; transition:0.3s; }
form input[type=submit]:hover { background:#0aaaff; }
.success { color:green; font-weight:600; }

/* ---------- Table ---------- */
.table-container { overflow-x:auto; }
.table { width:100%; border-collapse:collapse; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 8px 20px rgba(0,0,0,0.1); }
.table thead tr { background:#1f8ef1; color:#fff; text-align:left; }
.table th, .table td { padding:12px 15px; font-size:0.95rem; }
.table tbody tr:nth-child(even) { background:#f4f7f9; }
.table tbody tr:hover { background:#d0e7ff; }
.table a { text-decoration:none; margin-right:10px; color:#0a66cc; font-weight:600; }
.table a.delete { color:#ff4d4d; }

/* ---------- Footer ---------- */
.footer { background:#75aad8; color:#fff; text-align:center; padding:20px; box-shadow:0 -2px 8px rgba(0,0,0,0.15); font-weight:600; position: relative; bottom:0; width:100%; border-top-left-radius:15px; border-top-right-radius:15px; }
</style>
</head>
<body>

<div class="header">
    <div class="logo"><img src="images/aisolutionslogo.jpeg" alt="Logo"></div>
    <div class="user-actions">
        <span>Welcome, <?php echo htmlspecialchars($admin_user); ?></span>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</div>

<main>
    <div class="hero">
        <h1>Manage Blog Posts</h1>
        <p>Create, edit, or delete blog posts easily.</p>
    </div>

    <?php if($msg) echo '<p class="success">'.htmlspecialchars($msg).'</p>'; ?>

    <!-- Add New Post -->
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Title" required>
        <textarea name="content" placeholder="Content" rows="5" required></textarea>
        <input type="file" name="image">
        <input type="submit" name="submit" value="Add Post">
    </form>

    <!-- Existing Posts -->
    <div class="table-container">
        <table class="table">
            <thead>
                <tr><th>ID</th><th>Title</th><th>Image</th><th>Date</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php while($row = $res->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td>
                        <?php if($row['image']): ?>
                        <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Blog Image" style="height:50px; border-radius:5px;">
                        <?php endif; ?>
                    </td>
                    <td><?php echo $row['created_at']; ?></td>
                    <td>
                        <a href="edit_blog.php?id=<?php echo $row['id']; ?>"><i class="fa fa-edit"></i> Edit</a>
                        <a href="admin_blog.php?delete=<?php echo $row['id']; ?>" class="delete" onclick="return confirm('Are you sure?');"><i class="fa fa-trash"></i> Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</main>

<div class="footer">&copy; <?php echo date('Y'); ?> AI Solutions. All rights reserved.</div>
</body>
</html>
