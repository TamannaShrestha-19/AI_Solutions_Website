<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Solutions | Gallery</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
</head>
<body>
<?php include('includes/header.php'); ?>

<!-- Hero Section -->
<section class="hero hero-short">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1>Our Gallery</h1>
        <p>Explore photos from our AI solutions, events, and innovation projects.</p>
    </div>
</section>

<!-- Gallery Section -->
<section class="gallery page-section" style="background:rgba(11,30,51,0.88); padding:100px 40px;">
    <div class="container">
        <h2 style="text-align:center; color:#fff; margin-bottom:50px;">Promotional & Event Highlights</h2>
        <div class="gallery-grid">
            <figure class="gallery-item"><img src="images/gallery/gallery1.png" alt="AI Robotics"><figcaption>AI Robotics in Action</figcaption></figure>
            <figure class="gallery-item"><img src="images/gallery/gallery2.png" alt="Team Collaboration"><figcaption>Team Collaboration</figcaption></figure>
            <figure class="gallery-item"><img src="images/gallery/gallery3.png" alt="AI Events"><figcaption>AI Workshops and Demos</figcaption></figure>
            <figure class="gallery-item"><img src="images/gallery/gallery4.png" alt="AI Conferences"><figcaption>AI Expo 2024 Showcase</figcaption></figure>
            <figure class="gallery-item"><img src="images/gallery/gallery5.png" alt="Virtual Assistant"><figcaption>Virtual Assistant Interface</figcaption></figure>
            <figure class="gallery-item"><img src="images/gallery/gallery6.png" alt="Healthcare AI"><figcaption>Healthcare AI Solutions</figcaption></figure>
            <figure class="gallery-item"><img src="images/gallery/gallery7.png" alt="AI Summit"><figcaption>AI Business Summit 2025</figcaption></figure>
        </div>
    </div>
</section>

<!-- Upcoming Events Section -->
<section style="padding:100px 40px; background:rgba(15,39,68,0.9);">
  <div class="container" style="max-width:900px; margin:auto; text-align:center;">
    <h2 style="color:#fff;">Upcoming Events</h2>
    <p style="color:#cfd8e3;">Stay tuned for our upcoming AI-focused conferences, product launches, and workshops.</p>

    <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(250px,1fr)); gap:30px; margin-top:40px;">
      <div style="background:rgba(255,255,255,0.06); padding:20px; border-radius:12px;">
        <img src="images/gallery/AI expo.jpg" alt="AI Workshop Kathmandu" style="width:100%; border-radius:10px; margin-bottom:10px;">
        <h4 style="color:#fff;">AI Workshop Kathmandu</h4>
        <p style="color:#cfd8e3;">December 2025</p>
      </div>
      <div style="background:rgba(255,255,255,0.06); padding:20px; border-radius:12px;">
        <img src="images/gallery/smart.jpg" alt="Smart Analytics Launch" style="width:100%; border-radius:10px; margin-bottom:10px;">
        <h4 style="color:#fff;">Smart Analytics Suite Launch</h4>
        <p style="color:#cfd8e3;">February 2026</p>
      </div>
      <div style="background:rgba(255,255,255,0.06); padding:20px; border-radius:12px;">
        <img src="images/gallery/ai conference.jpeg" alt="AI Education Conference" style="width:100%; border-radius:10px; margin-bottom:10px;">
        <h4 style="color:#fff;">AI in Education Conference</h4>
        <p style="color:#cfd8e3;">April 2026</p>
      </div>
    </div>
  </div>
</section>

<?php include('includes/footer.php'); ?>
</body>
</html>
