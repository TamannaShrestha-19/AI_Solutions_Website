<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) { header('Location: admin_login.php'); exit; }
require 'includes/db_connect.php';

$msg = '';

// Add Image
if(isset($_POST['add'])) {
    $title = trim($_POST['title']);
    $image = $_FILES['image']['name'] ?? '';
    if($image){
        $target = 'uploads/' . basename($image);
        if(move_uploaded_file($_FILES['image']['tmp_name'], $target)){
            $stmt = $conn->prepare("INSERT INTO gallery_images (title, image) VALUES (?, ?)");
            $stmt->bind_param("ss", $title, $image);
            $stmt->execute();
            $stmt->close();
            $msg = "Image added successfully!";
        } else { $msg = "Image upload failed"; }
    }
}

// Delete Image
if(isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $res = $conn->query("SELECT image FROM gallery_images WHERE id=$id");
    $img = $res->fetch_assoc()['image'];
    if($img && file_exists('uploads/'.$img)) unlink('uploads/'.$img);
    $conn->query("DELETE FROM gallery_images WHERE id=$id");
    header("Location: admin_gallery.php");
    exit;
}

// Fetch all images
$res = $conn->query("SELECT * FROM gallery_images ORDER BY created_at DESC");
?>
<div class="container">
    <h1>Manage Gallery</h1>
    <?php if($msg) echo '<p class="success">'.htmlspecialchars($msg).'</p>'; ?>
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Title" required>
        <input type="file" name="image" required>
        <input type="submit" name="add" value="Add Image">
    </form>

    <h2>Existing Images</h2>
    <table>
        <tr><th>ID</th><th>Title</th><th>Image</th><th>Actions</th></tr>
        <?php while($row = $res->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td><img src="uploads/<?php echo $row['image']; ?>" width="80"></td>
            <td>
                <a href="admin_gallery.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete this image?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
