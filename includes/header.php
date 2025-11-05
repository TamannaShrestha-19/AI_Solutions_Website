<?php $currentPage = basename($_SERVER['PHP_SELF']); ?>
<header>
    <a href="home.php" class="logo">
        <img src="images/aisolutionslogo.jpeg" alt="AI Solutions Logo">
    </a>
    <nav>
        <a href="home.php" class="<?= ($currentPage == 'home.php') ? 'active' : '' ?>">Home</a>
        <a href="about.php" class="<?= ($currentPage == 'about.php') ? 'active' : '' ?>">About Us</a>
        <a href="services.php" class="<?= ($currentPage == 'services.php') ? 'active' : '' ?>">Services</a>
        <a href="gallery.php" class="<?= ($currentPage == 'gallery.php') ? 'active' : '' ?>">Gallery</a>
        <a href="projects.php" class="<?= ($currentPage == 'projects.php') ? 'active' : '' ?>">Projects</a>
        <a href="blog.php" class="<?= ($currentPage == 'blog.php') ? 'active' : '' ?>">Blog</a>
         <a href="feedback.php" class="<?= ($currentPage == 'feedback.php') ? 'active' : '' ?>">Feedback</a>
        <a href="contact.php" class="<?= ($currentPage == 'contact.php') ? 'active' : '' ?>">Contact Us</a>
        <a href="admin_login.php" class="btn-login">Login</a>
    </nav>
</header>
