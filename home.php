<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Solutions | Home</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <!-- Particles.js for hero effect -->
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            particlesJS("hero", {
              "particles": {
                "number": { "value": 60 },
                "color": { "value": "#0ff0ff" },
                "shape": { "type": "circle" },
                "opacity": { "value": 0.7 },
                "size": { "value": 3 },
                "line_linked": { "enable": true, "distance": 120, "color": "#0ff0ff", "opacity": 0.5, "width": 1 },
                "move": { "enable": true, "speed": 2 }
              },
              "interactivity": {
                "events": { "onhover": { "enable": true, "mode": "grab" } },
                "modes": { "grab": { "distance": 150, "line_linked": { "opacity": 0.7 } } }
              },
              "retina_detect": true
            });
        });
    </script>
</head>
<body>
    <?php include('includes/header.php'); ?>

    <!-- Hero Section -->
    <section class="hero" id="hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Empowering Businesses with Innovative AI Solutions</h1>
            <p>Enhancing digital employee experiences through intelligent automation, virtual assistants, and AI-driven insights.</p>
            <button class="cta-btn" onclick="window.location.href='services.php'">Explore Our Services</button>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services">
        <div class="container">
            <h2>Our Services</h2>
            <div class="service-cards">
                <div class="card">
                    <i class="fas fa-robot"></i>
                    <h3>AI Prototyping</h3>
                    <p>Create AI models quickly and efficiently for your projects.</p>
                </div>
                <div class="card">
                    <i class="fas fa-lightbulb"></i>
                    <h3>Digital Innovation</h3>
                    <p>Transform your business processes using AI-powered tools.</p>
                </div>
                <div class="card">
                    <i class="fas fa-handshake"></i>
                    <h3>Consulting & Support</h3>
                    <p>Expert guidance for integrating AI solutions in your workflow.</p>
                </div>
            </div>
        </div>
    </section>

    <?php include('includes/footer.php'); ?>
</body>
</html>
