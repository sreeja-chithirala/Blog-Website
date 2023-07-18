<? // file lists all the posts gotten from the database in a table format ?>
<?php  include('../config.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/post_functions.php'); ?>
<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>

<!-- Get all admin posts from DB -->
<?php $blogs = getAllBlogs(); ?>
	<title>Admin | Manage Blogs</title>
</head>
<body>
	<!-- admin navbar -->
	<?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>

	<div class="container content">
		<!-- Left side menu -->
		<?php include(ROOT_PATH . '/admin/includes/menu.php') ?>

		<!-- Display records from DB-->
		<div class="table-div"  style="width: 80%;">
			<!-- Display notification message -->
			<?php include(ROOT_PATH . '/includes/messages.php') ?>

			<?php if (empty($blogs)): ?>
				<h1 style="text-align: center; margin-top: 20px;">No blogs in the database.</h1>
			<?php else: ?>
				<table class="table">
						<thead>
						<th>N</th>
						<th>Manager</th>
                        <th>Blog Title</th>
						<th>Likes</th>
						<th><small>Edit</small></th>
						<th><small>Delete</small></th>
					</thead>
					<tbody>
					<?php foreach ($blogs as $key => $blog): ?>
						<tr>
							<td><?php echo $key + 1; ?></td>
							<td><?php echo $blog['Manager']; ?></td>
							<td>
								<a 	target="_blank"
								href="<?php echo BASE_URL . 'single_blog.php?blog_desc=' . $blog['blog_desc'] ?>">
									<?php echo $blog['title']; ?>	
								</a>
							</td>
							<td><?php echo $blog['likes']; ?></td>
							
							<td>
								<a class="fa fa-pencil btn edit"
									href="create_blog.php?edit_blog=<?php echo $blog['blog_id'] ?>">
								</a>
							</td>
							<td>
								<a  class="fa fa-trash btn delete" 
									href="create_blog.php?delete_blog=<?php echo $blog['blog_id'] ?>">
								</a>
							</td>
						</tr>
					<?php endforeach ?>
					</tbody>
				</table>
			<?php endif ?>
		</div>
		<!-- // Display records from DB -->
	</div>
</body>
</html>