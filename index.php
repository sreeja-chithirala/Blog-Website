<!-- At first our include should be config.php -->

<?php require_once('config.php') ?>


<?php require( ROOT_PATH . '/includes/public_functions.php') ?>

<?php require_once( ROOT_PATH . '/includes/registration_login.php') ?>

<!-- Retrieve all blogs from database  -->
<?php $blogs = getPublishedPosts(); ?>
<?php require_once( ROOT_PATH . '/includes/head_section.php') ?>
	<title>LifeStyle Blog | Home </title>
</head>
<body>
	<!-- container - wraps whole page -->
	<div class="container">
		<!-- navbar -->
		<?php include( ROOT_PATH . '/includes/navbar.php') ?>
		<!-- // navbar -->

		<!-- banner -->
		<?php include( ROOT_PATH . '/includes/banner.php') ?>
		<!-- // banner -->

		<!-- Page content -->
		<div class="content">
			<h2 class="content-title">Recent Articles</h2>
			<hr>
			
			<?php foreach ($blogs as $blog): ?>
				<div class="post" style="margin-left: 0px;">
					<img src="<?php echo BASE_URL . '/static/images/' . $blog['image']; ?>" class="post_image" alt="blog_image">
					
					<?php if (isset($blog['topic']['bcat_title'])): ?>
						<a 
							href="<?php echo BASE_URL . 'filtered_blogs.php?topic=' . $blog['topic']['bcat_id'] ?>"
							class="btn category">
							<?php echo $blog['topic']['bcat_title'] ?>
						</a>
					<?php endif ?>

					<!-- filtered_posts.php is a page that lists all the posts under a particular topic when the user clicks on that topic. -->
					<!-- single_post.php is a page that displays the full post in detail together with comments when the user clicks on the post thumbnail. -->

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
		<!-- // Page content -->

		<!-- footer -->
		<?php include( ROOT_PATH . '/includes/footer.php') ?>
		<!-- // footer -->