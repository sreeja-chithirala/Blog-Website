<?php include('config.php'); ?>
<?php include('includes/public_functions.php'); ?>
<?php include('includes/head_section.php'); ?>
<?php 
	// Get posts under a particular topic
	if (isset($_GET['topic'])) {
		$bcat_id = $_GET['topic'];
		$blogs = getPublishedBlogsByTopic($bcat_id);
	}
?>
	<title>LifeStyleBlog | Home </title>
</head>
<body>
<div class="container">
<!-- Navbar -->
	<?php include( ROOT_PATH . '/includes/navbar.php'); ?>
<!-- // Navbar -->
<!-- content -->
<div class="content">
	<h2 class="content-title">
		Articles on <u><?php echo getTopicNameById($bcat_id); ?></u>
	</h2>
	<hr>
	<?php foreach ($blogs as $blog): ?>
		<div class="post" style="margin-left: 0px;">
			<img src="<?php echo BASE_URL . '/static/images/' . $blog['image']; ?>" class="post_image" alt="blog-image">
			<a href="single_blog.php?blog_desc=<?php echo $blog['blog_desc']; ?>">
				<div class="post_info">
					<h3><?php echo $blog['title'] ?></h3>
					<div class="info">
						<span class="read_more">Read more...</span>
					</div>
				</div>
			</a>
		</div>
	<?php endforeach ?>
</div>
<!-- // content -->
</div>
<!-- // container -->

<!-- Footer -->
	<?php include( ROOT_PATH . '/includes/footer.php'); ?>
<!-- // Footer -->