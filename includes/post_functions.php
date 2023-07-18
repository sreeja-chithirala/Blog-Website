<? //contains functions that perform operations on posts such as querying them from the database and returning them to the posts.php file. ?>
<?php 
// Post variables
$blog_id = 0;
$isEditingBlog = false;
$title = "";
$blog_desc = "";
$content = "";
$image = "";


/* - - - - - - - - - - 
-  Post functions
- - - - - - - - - - -*/
// get all blogs from DB
function getAllBlogs()
{
	global $conn;
	
	// Admin can view all posts
	//  Manager can only view their posts
	if ($_SESSION['user']['role'] == "Admin") {
		$sql = "SELECT * FROM blogs";
	} elseif ($_SESSION['user']['role'] == "Manager") {
		$user_id = $_SESSION['user']['id'];
		$sql = "SELECT * FROM blogs WHERE user_id=$user_id";
	}
	$result = mysqli_query($conn, $sql);
	$blogs = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$final_blogs = array();
	foreach ($blogs as $blog) {
		$blog['Manager'] = getPostManagerById($blog['user_id']);
		array_push($final_blogs, $blog);
	}
	return $final_blogs;
}
// get the author/username of a post
function getPostManagerById($user_id)
{
	global $conn;
	$sql = "SELECT username FROM users WHERE id=$user_id";
	$result = mysqli_query($conn, $sql);
	if ($result) {
		// return username
		return mysqli_fetch_assoc($result)['username'];
	} else {
		return null;
	}
}


/* - - - - - - - - - - 
-  Post actions
- - - - - - - - - - -*/
// if user clicks the create post button
if (isset($_POST['create_blog'])) {
    createBlog($_POST); 
}
// if user clicks the Edit post button
if (isset($_GET['edit_blog'])) {
	$isEditingBlog = true;
	$blog_id = $_GET['edit_blog'];
	editBlog($blog_id);
}
// if user clicks the update post button
if (isset($_POST['update_blog'])) {
	updateBlog($_POST);
}
// if user clicks the Delete post button
if (isset($_GET['delete_blog'])) {
	$blog_id = $_GET['delete_blog'];
	deleteBlog($blog_id);
}

/* - - - - - - - - - - 
-  Post functions
- - - - - - - - - - -*/
function createBlog($request_values)
{
    global $conn, $errors, $title, $image, $bcat_id, $content, $blog_desc;
    $title = esc($request_values['title']);
    $image = esc($request_values['image']);
    $content = htmlentities(esc($request_values['content']));
    $blog_desc = htmlentities(esc($request_values['blog_desc']));
    $user_id = $_SESSION['user']['id'];
    if (isset($request_values['bcat_id'])) {
        $bcat_id = esc($request_values['bcat_id']);
    }
    // validate form
    if (empty($title)) { array_push($errors, "Blog title is required"); }
    if (empty($content)) { array_push($errors, "Blog content is required"); }
    if (empty($blog_desc)) { array_push($errors, "Blog description is required"); }
    if (empty($bcat_id)) { array_push($errors, "Blog catogary is required"); }
    if (empty($image)) { array_push($errors, "Featured image is required"); }

    // Ensure that no blog is saved twice. 
    $post_check_query = "SELECT * FROM blogs WHERE title='$title' LIMIT 1";
    $result = mysqli_query($conn, $post_check_query);

    if (mysqli_num_rows($result) > 0) { // if blog exists
        array_push($errors, "A blog already exists with that title.");
    }
    // create blog if there are no errors in the form
    if (count($errors) == 0) {
        $query = "INSERT INTO blogs (user_id, title, likes , image, blog_desc, content) 
        VALUES($user_id , '$title', 0, '$image', '$blog_desc', '$content')";
        if(mysqli_query($conn, $query)){ // if blog created successfully
            $inserted_blog_id = mysqli_insert_id($conn);
            // create relationship between post and topic
            $sql = "INSERT INTO blog_topic (blog_id, bcat_id) VALUES($inserted_blog_id, $bcat_id)";
            mysqli_query($conn, $sql);

            $_SESSION['message'] = "Blog created successfully";
            header('location: posts.php');
            exit(0);
        }
    }
}

/* * * * * * * * * * * * * * * * * * * * *
* - Takes post id as parameter
* - Fetches the post from database
* - sets post fields on form for editing
* * * * * * * * * * * * * * * * * * * * * */
function editBlog($blog_id)
{
    global $conn, $errors, $title, $image, $bcat_id, $isEditingPost, $content, $blog_desc;
    $sql = "SELECT * FROM blogs WHERE blog_id=$blog_id LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $blog = mysqli_fetch_assoc($result);
    // set form values on the form to be updated
    $title = $blog['title'];
    $content = $blog['content'];
    $blog_desc = $blog['blog_desc'];
    $image = $blog['image'];
}

function updateBlog($request_values)
{
    global $conn, $errors, $blog_id, $title, $image, $bcat_id, $blog_desc, $content;

    $title = esc($request_values['title']);
    $image = esc($request_values['image']);
    $content = esc($request_values['content']);
    $blog_desc = esc($request_values['blog_desc']);
    $blog_id = esc($request_values['blog_id']);
    if (isset($request_values['bcat_id'])) {
        $bcat_id = esc($request_values['bcat_id']);
    }
    if (empty($title)) { array_push($errors, "Blog title is required"); }
    if (empty($content)) { array_push($errors, "Blog content is required"); }
    if (empty($image)) { array_push($errors, "Blog image is required"); }
    if (empty($blog_desc)) { array_push($errors, "Blog description is required"); }
    // if new featured image has been provided

    // register topic if there are no errors in the form
    if (count($errors) == 0) {
        $query = "UPDATE blogs SET title='$title', likes=0, image='$image',blog_desc='$blog_desc', content='$content' WHERE blog_id=$blog_id";
        $_SESSION['message'] = "Blog updated successfully";
        header('location: posts.php');
        exit(0);
    }
}
// delete blog post
function deleteBlog($blog_id)
{
    global $conn;
    $sql = "DELETE FROM blogs WHERE blog_id=$blog_id";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "Blog successfully deleted";
        header("location: posts.php");
        exit(0);
    }
}

?>