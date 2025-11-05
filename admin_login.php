<?php
session_start();

// Hardcoded admin credentials (proper hashed password)
$admin_username = 'tamanna';
$admin_password_hash = '$2y$10$GDRJMhBmDhKQkruEqWewe.ZlsKw3ghFlUazC51NayEfAoaSs89U5u';

$error = '';

// Check if logout message exists
$logout_msg = '';
if (isset($_GET['status']) && $_GET['status'] === 'logged_out') {
    $logout_msg = '✅ You have successfully logged out.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === $admin_username && password_verify($password, $admin_password_hash)) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_user'] = $username;
        header('Location: admin_dashboard.php');
        exit;
    } else {
        $error = "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Login | AI Solutions</title>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
<style>
.login-container {
    max-width: 400px;
    margin: 120px auto;
    padding: 30px;
    background: rgba(0, 0, 0, 0.55);
    border-radius: 20px;
    color: #fff;
    text-align: center;
}
.login-container input[type="text"],
.login-container input[type="password"] {
    width: 100%;
    padding: 12px 40px 12px 12px;
    margin-bottom: 15px;
    border-radius: 10px;
    border: none;
    font-size: 16px;
    outline: none;
}
.login-container input[type="submit"] {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: none;
    background: linear-gradient(135deg, #0ff0ff, #00aaff);
    color: #000;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}
.login-container input[type="submit"]:hover {
    box-shadow: 0 0 25px rgba(0,255,224,0.8);
    transform: translateY(-2px) scale(1.05);
}
.error-msg {
    color: #ff4d4d;
    margin-bottom: 15px;
}
.logout-msg {
    color: #00ff99;
    margin-bottom: 15px;
    font-weight: 600;
}
.password-wrapper {
    position: relative;
}
.password-wrapper .toggle-password {
    position: absolute;
    top: 50%;
    right: 12px;
    transform: translateY(-50%);
    cursor: pointer;
    color: #000;
    font-size: 18px;
}
.forgot-password {
    text-align: right;
    margin-bottom: 15px;
}
.forgot-password a {
    color: #0ff0ff;
    font-size: 0.9em;
    text-decoration: none;
    transition: color 0.3s ease;
}
.forgot-password a:hover {
    color: #00aaff;
    text-decoration: underline;
}
.back-link {
    display:block;
    margin-bottom: 20px;
    font-size: 1em;
    color: #1f8ef1;
    text-decoration: underline;
}
.back-link:hover {
    color: #0aaaff;
}
</style>
</head>
<body>
<div class="login-container">

    <!-- Back to Website Link (above form) -->
    <a class="back-link" href="home.php">← Back to Website</a>

    <!-- Logout success message -->
    <?php if($logout_msg): ?>
        <p class="logout-msg"><?php echo $logout_msg; ?></p>
    <?php endif; ?>

    <!-- Login error message -->
    <?php if ($error): ?>
        <p class="error-msg"><?php echo $error; ?></p>
    <?php endif; ?>

    <h2>Admin Login</h2>
    <form method="post">
        <div class="input-group">
            <input type="text" name="username" placeholder="Username" required>
        </div>
        <div class="input-group password-wrapper">
            <input type="password" name="password" id="password" placeholder="Password" required>
            <i class="fa-regular fa-eye toggle-password" id="togglePwd"></i>
        </div>
        <div class="forgot-password">
            <a href="admin_forgot_password.php">Forgot Password?</a>
        </div>
        <input type="submit" value="Login">
    </form>
</div>

<script>
const togglePwd = document.getElementById('togglePwd');
const passwordInput = document.getElementById('password');

// Initially show eye-slash icon
togglePwd.classList.add('fa-eye-slash');

togglePwd.addEventListener('click', () => {
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        togglePwd.classList.remove('fa-eye-slash');
        togglePwd.classList.add('fa-eye');
    } else {
        passwordInput.type = 'password';
        togglePwd.classList.remove('fa-eye');
        togglePwd.classList.add('fa-eye-slash');
    }
});
</script>

</body>
</html>
