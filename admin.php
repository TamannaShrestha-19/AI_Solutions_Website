<?php
session_start();
$servername = "localhost";
$username = "root";  
$password = "btsarmytamu#18";      
$dbname = "ai_solutions_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Simple password for prototype
$admin_password = "admin123";
$error = "";

if(isset($_POST['password'])){
    if($_POST['password'] === $admin_password){
        $_SESSION['admin_logged_in'] = true;
    } else {
        $error = "Incorrect password!";
    }
}

// Redirect if logged in
$logged_in = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'];
?>

<?php include 'includes/header.php'; ?>

<div class="container">
  <h1>Admin Area</h1>

  <?php if(!$logged_in): ?>
    <p>Enter password to view customer inquiries:</p>
    <?php if($error) echo '<p class="error">❌ '.$error.'</p>'; ?>
    <form method="post">
      <input type="password" name="password" placeholder="Admin Password" required>
      <input type="submit" class="btn" value="Login">
    </form>
  <?php else: ?>
    <?php
        $result = $conn->query("SELECT COUNT(*) as total FROM inquiries");
        $row = $result->fetch_assoc();
        $total_inquiries = $row['total'];
    ?>
    <p>✅ Total Customer Inquiries Submitted: <strong><?php echo $total_inquiries; ?></strong></p>
    <form method="post" action="logout.php">
        <input type="submit" class="btn" value="Logout">
    </form>
  <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
