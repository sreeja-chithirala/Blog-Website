<?php  include('../config.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/post_functions.php'); ?>
<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
<!-- Get all topics -->
<?php $topics = getAllTopics();	?>
	<title>Admin | Create Blog</title>
</head>
<body>
	<!-- admin navbar -->
	<?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>

	<div class="container content">
		<!-- Left side menu -->
		<?php include(ROOT_PATH . '/admin/includes/menu.php') ?>

		<!-- Middle form - to create and edit  -->
		<div class="action create-post-div">
			<h1 class="page-title">Create/Edit Blog</h1>
			<form method="post" enctype="multipart/form-data" action="<?php echo BASE_URL . 'admin/create_blog.php'; ?>" >
				<!-- validation errors for the form -->
				<?php include(ROOT_PATH . '/includes/errors.php') ?>

				<!-- if editing blog, the id is required to identify that blog -->
				<?php if ($isEditingBlog === true): ?>
					<input type="hidden" name="blog_id" value="<?php echo $blog_id; ?>">
				<?php endif ?>

				<input type="text" name="title" value="<?php echo $title; ?>" placeholder="Title">
                <input type="text" name="image" value="<?php echo $image; ?>" placeholder="Image.jpg">
                <textarea name="blog_desc" id="blog_desc" cols="30" rows="10" placeholder="Description"></textarea><?php echo $blog_desc; ?></textarea>
				<textarea name="content" id="content" cols="30" rows="20" placeholder="Content"><?php echo $content; ?></textarea>
				<select name="bcat_id">
					<option value="" selected disabled>Choose Blog Catogary</option>
					<?php foreach ($topics as $topic): ?>
						<option value="<?php echo $topic['bcat_id']; ?>">
							<?php echo $topic['bcat_title']; ?>
						</option>
					<?php endforeach ?>
				</select>
				
				<!-- if editing post, display the update button instead of create button -->
				<?php if ($isEditingBlog === true): ?> 
					<button type="submit" class="btn" name="update_blog">UPDATE</button>
				<?php else: ?>
					<button type="submit" class="btn" name="create_blog">Save Blog</button>
				<?php endif ?>

			</form>
		</div>
		<!-- // Middle form - to create and edit -->
	</div>
</body>
</html>

<script>
	CKEDITOR.replace('body');
</script>