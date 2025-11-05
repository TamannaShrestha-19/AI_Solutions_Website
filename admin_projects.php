<?php
require 'includes/db_connect.php';
include 'includes/admin_header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'])) {
    $title = trim($_POST['title']);
    $desc = trim($_POST['description']);
    $stmt = $conn->prepare("INSERT INTO projects (title, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $desc);
    $stmt->execute();
    $stmt->close();
}

$projects = $conn->query("SELECT * FROM projects ORDER BY id DESC");
?>
<div class="container" style="padding:100px 50px;">
    <h1>Manage Projects</h1>
    <form method="post" style="margin-bottom:30px; background:rgba(0,0,0,0.6); padding:20px; border-radius:15px;">
        <input type="text" name="title" placeholder="Project Title" required style="margin-bottom:10px; width:100%;">
        <textarea name="description" placeholder="Project Description" required style="width:100%; height:100px; margin-bottom:10px;"></textarea>
        <input type="submit" value="Add Project" class="cta-btn">
    </form>
    <h2>Existing Projects</h2>
    <ul>
        <?php while($row = $projects->fetch_assoc()): ?>
            <li><strong><?php echo $row['title']; ?></strong> - <?php echo substr($row['description'],0,50).'...'; ?></li>
        <?php endwhile; ?>
    </ul>
</div>
