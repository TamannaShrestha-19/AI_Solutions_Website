<?php
// process_contact.php

// Database connection
$servername = "localhost";
$username = "root";
$password = "btsarmytamu#18";
$dbname = "ai_solutions_db"; // consistent with other files

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create table if it doesn't exist (prototype)
$conn->query("CREATE TABLE IF NOT EXISTS inquiries (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    company VARCHAR(255),
    country VARCHAR(100),
    job_title VARCHAR(255),
    job_description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $company = trim($_POST['company'] ?? '');
    $country = trim($_POST['country'] ?? '');
    $job_title = trim($_POST['job_title'] ?? '');
    $job_description = trim($_POST['job_description'] ?? '');

    // Basic validation
    if ($name === '' || $email === '' || $phone === '') {
        header('Location: contact.php?submitted=false'); 
        exit;
    }

    // Prepare and execute insert
    $stmt = $conn->prepare("INSERT INTO inquiries (name, email, phone, company, country, job_title, job_description) VALUES (?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssss", $name, $email, $phone, $company, $country, $job_title, $job_description);

    if ($stmt->execute()) {
        $stmt->close();
        // Redirect to contact.php with success flag
        header('Location: contact.php?submitted=true'); 
        exit;
    } else {
        $stmt->close();
        // Redirect to contact.php with failure flag
        header('Location: contact.php?submitted=false'); 
        exit;
    }
} else {
    header('Location: contact.php'); 
    exit;
}
?>
