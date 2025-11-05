<?php
include('includes/header.php');

$blogs = [
    1 => [
        'title' => 'How AI is Transforming Businesses in 2025',
        'image' => 'images/blog/blog 1.png',
        'date' => 'September 15, 2025',
        'content' => '... (same as your original content) ...'
    ],
    2 => [
        'title' => 'Top 5 AI Tools for Virtual Assistants',
        'image' => 'images/blog/blog 2.png',
        'date' => 'August 28, 2025',
        'content' => '...'
    ],
    3 => [
        'title' => 'Innovating Employee Experiences with AI',
        'image' => 'images/blog/blog 3.png',
        'date' => 'July 12, 2025',
        'content' => '...'
    ],
    4 => [
        'title' => 'Upcoming AI Conferences and Workshops in 2025',
        'image' => 'images/blog/blog 4.png',
        'date' => 'June 5, 2025',
        'content' => '...'
    ],
    5 => [
        'title' => 'AI Solutions Launches Smart Analytics Suite',
        'image' => 'images/blog/blog5.jpg',
        'date' => 'October 1, 2025',
        'content' => '
            AI Solutions proudly unveils its latest innovation – the Smart Analytics Suite, designed to help businesses harness the power of data through intelligent automation and predictive modeling.<br><br>
            Built with cutting-edge machine learning algorithms, the suite enables organizations to visualize performance metrics in real time, detect operational inefficiencies, and forecast future outcomes with remarkable accuracy.<br><br>
            According to our CTO, Tamanna Shrestha, “Smart Analytics Suite simplifies AI adoption for enterprises, helping them make data-driven decisions faster and more confidently.”<br><br>
            The platform integrates seamlessly with existing systems and offers customizable dashboards for industries such as finance, retail, and healthcare, marking another milestone in AI Solutions’ mission to make AI accessible for all.'
    ],
    6 => [
        'title' => 'Partnership Spotlight: AI Solutions Collaborates with TechNepal',
        'image' => 'images/blog/blog6.jpeg',
        'date' => 'September 25, 2025',
        'content' => '
            AI Solutions is proud to announce a strategic partnership with TechNepal to accelerate AI adoption across South Asia. The collaboration focuses on education, training, and joint innovation projects that enable local businesses to leverage artificial intelligence for growth and sustainability.<br><br>
            Together, the two organizations are developing workshops, online certification programs, and AI-powered community tools to strengthen the region’s technology ecosystem.<br><br>
            CEO Prakash Dahal stated, “This partnership represents our commitment to building an inclusive AI future where knowledge and innovation are shared to create lasting impact.”<br><br>
            With shared expertise and a focus on responsible AI, the collaboration aims to inspire new talent and bring AI Solutions’ cutting-edge technologies closer to regional enterprises.'
    ]
];

$post_id = $_GET['post'] ?? 1;
$post = $blogs[$post_id] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?> | AI Solutions Blog</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>

<section class="hero hero-short">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1><?php echo htmlspecialchars($post['title']); ?></h1>
        <p><?php echo htmlspecialchars($post['date']); ?></p>
    </div>
</section>

<section class="blog-detail page-section" style="background:rgba(11,30,51,0.88);">
    <div class="container">
        <div class="blog-detail-content" style="color:#cfd8e3;">
            <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="Blog Image" class="blog-detail-image" style="border-radius:10px; margin-bottom:25px;">
            <div class="blog-text" style="line-height:1.8;">
                <p><?php echo $post['content']; ?></p>
            </div>
            <a href="blog.php" class="btn-back"><i class="fa fa-arrow-left"></i> Back to Blog</a>
        </div>
    </div>
</section>

<?php include('includes/footer.php'); ?>
</body>
</html>
