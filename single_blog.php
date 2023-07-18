<?php  include('config.php'); ?>
<?php  include('includes/public_functions.php'); ?>
<?php 
	
	$blog = getBlog($_GET['blog_desc']);
	$topics = getAllTopics();
?>
<?php include('includes/head_section.php'); ?>
<title> <?php echo $blog['title'] ?> | LifestyleBlog</title>
</head>
<body>
<div class="container">
	<!-- Navbar -->
		<?php include( ROOT_PATH . '/includes/navbar.php'); ?>
	<!-- // Navbar -->
	
	<div class="content" >
		<!-- Page wrapper -->
		<div class="post-wrapper">
			<!-- full post div -->
			<div class="full-post-div">
				<h2 class="post-title"><?php echo $blog['title']; ?></h2>
				<img src="<?php echo BASE_URL . '/static/images/' . $blog['image']; ?>" class="post_image" alt="blog_image">
				<h3 class="post-desc"><?php echo $blog['blog_desc']; ?></h3>
				<div class="post-body-div">
					<?php echo html_entity_decode($blog['content']); ?>
				</div>
			</div>
			<!-- // full post div -->
			
			<!-- comments section -->
		</div>
		<!-- // Page wrapper -->

		<!-- post sidebar -->
		<div class="post-sidebar">
			<div class="card">
				<div class="card-header">
					<h2>Topics</h2>
				</div>
				<div class="card-content">
					<?php foreach ($topics as $topic): ?>
						<a 
							href="<?php echo BASE_URL . 'filtered_blogs.php?topic=' . $topic['bcat_id'] ?>">
							<?php echo $topic['bcat_title']; ?>
						</a> 
					<?php endforeach ?>
				</div>
			</div>
		</div>
		<!-- // post sidebar -->
	</div>
</div>
<!-- // content -->

<?php include( ROOT_PATH . '/includes/footer.php'); ?>
