<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Solutions | Contact Us</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <style>
        /* Thank You Message Overlay */
        .thank-you-message {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(11,30,51,0.95);
            color: #fff;
            padding: 40px 50px;
            border-radius: 15px;
            text-align: center;
            max-width: 500px;
            z-index: 1000;
            box-shadow: 0 8px 25px rgba(0,0,0,0.4);
            animation: fadeIn 0.6s ease;
        }

        .thank-you-message h2 {
            margin-bottom: 15px;
            color: #00d1b2;
        }

        .thank-you-message p {
            color: #cfd8e3;
            line-height: 1.6;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translate(-50%, -60%); }
            to { opacity: 1; transform: translate(-50%, -50%); }
        }
    </style>
</head>
<body>
<?php include('includes/header.php'); ?>

<section class="hero hero-short">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1>Contact Us</h1>
        <p>We'd love to hear from you. Tell us about your job requirement — no account needed.</p>
    </div>
</section>

<section class="contact page-section" style="background:rgba(11,30,51,0.88); padding:80px 40px;">
    <div class="container">
        <h2 style="color:#fff; text-align:center; margin-bottom:20px;">Send Us a Message</h2>
        <p class="contact-intro" style="color:#cfd8e3; text-align:center; margin-bottom:40px;">
            Have a software or AI project in mind? Fill out the form below, and our team will get back to you shortly.
        </p>
        <form action="process_contact.php" method="post" novalidate style="max-width:700px; margin:auto; display:flex; flex-direction:column; gap:15px;">
            <input type="text" name="name" placeholder="Name *" required>
            <input type="email" name="email" placeholder="Email *" required>
            <input type="text" name="phone" placeholder="Phone *" required>
            <input type="text" name="company" placeholder="Company">
            <input type="text" name="country" placeholder="Country">
            <input type="text" name="job_title" placeholder="Job Title">
            <textarea name="job_description" placeholder="Job / Project Description"></textarea>
            <input type="submit" class="btn" value="Submit Inquiry">
        </form>

        <div class="contact-info" style="text-align:center; margin-top:50px; color:#cfd8e3;">
            <h3 style="color:#fff;">Our Office</h3>
            <p><i class="fa-solid fa-location-dot"></i> Kathmandu, Nepal</p>
            <p><i class="fa-solid fa-envelope"></i> info@aisolutions.com</p>
            <p><i class="fa-solid fa-phone"></i> +977 9801234567</p>
        </div>
    </div>
</section>

<!-- Thank You Message -->
<div class="thank-you-message" id="thankYouMessage">
    <h2>✅ Thank You!</h2>
    <p>Your inquiry has been successfully submitted.<br>Our team will review it and get back to you shortly.</p>
</div>

<script>
    // Show thank-you message if URL has ?submitted=true
    const urlParams = new URLSearchParams(window.location.search);
    if(urlParams.get('submitted') === 'true'){
        const message = document.getElementById('thankYouMessage');
        message.style.display = 'block';
        // Auto-hide after 5 seconds
        setTimeout(() => { message.style.display = 'none'; }, 5000);
    }
</script>

<?php include('includes/footer.php'); ?>
</body>
</html>
