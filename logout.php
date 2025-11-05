<?php
session_start();
// Destroy session
session_unset();
session_destroy();

// Redirect to login page with logout message
header('Location: admin_login.php?status=logged_out');
exit;
?>
