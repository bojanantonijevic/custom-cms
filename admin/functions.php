<?php 


function loggedInUserID(){

	if(isLoggedIn()){

		$result = query("SELECT * FROM users WHERE  username ='" . $_SESSION['username'] ."'" );
		confirmQuery($result);
		$user = mysqli_fetch_array($result);
		return mysqli_num_rows($result) >= 1 ? $user['user_id'] : false;
		

	}
	return false;
}

function userLiked($post_id){

	$result = query("SELECT * FROM likes WHERE user_id =" . loggedInUserID() . " AND post_id =  {$post_id} ");
	confirmQuery($result);
	return mysqli_num_rows($result) >=1 ? true : false;

}


function query($query){
	global $connection;
	return mysqli_query($connection, $query);
}

function getPostLikes($post_id){

	$result = query("SELECT * FROM likes where post_id = $post_id");
	confirmQuery($result);
	echo mysqli_num_rows($result);
}


function escape($string){
	global $connection;

	return mysqli_real_escape_string($connection, trim($string));
}

function redirect($location){
	header("Location:" . $location);
	exit;
}


function ifItIsMethod($method = null){
	if($_SERVER['REQUEST_METHOD'] == strtoupper($method)){
		return true;
	}else{
		return false;
	}
}


function isLoggedIn(){
	if(isset($_SESSION['user_role'])){
		return true;
	} 
	return false; 
}

function checkIfUserIsLoggedInAndRedirect($redirectLocation = null){
	if(isLoggedIn()){
		redirect($redirectLocation);
	}
}


function insert_categories(){

	global $connection;

	if(isset($_POST['submit'])){
	$cat_title = $_POST['cat_title' ];

		if($cat_title == "" || empty($cat_title)){
			echo "Can't be empty! ";

			}else {

				$stmt = mysqli_prepare($connection, "INSERT INTO categories(cat_title) VALUES (?) ");
				
				mysqli_stmt_bind_param($stmt, 's', $cat_title);
				mysqli_stmt_execute($stmt);


				if(!$stmt){
					die('QUERY FAILED' . mysqli_error($connection));
				}
			}
		}
	}

function findAllCategories(){

	global $connection;

	$query = "SELECT * FROM categories";
	$select_categories = mysqli_query($connection, $query);

	while($row = mysqli_fetch_assoc($select_categories)){
    	
		$cat_id = $row['id'];
		$cat_title = $row['cat_title'];

		echo "<tr>";
		echo "<td>{$cat_id}</td> <td>{$cat_title}</td>";
		echo "<td><a class='btn btn-danger' href='categories.php?delete={$cat_id}'>Delete</a></td>";
		echo "<td><a class='btn btn-primary' href='categories.php?update={$cat_id}'>Edit</a></td>";
		echo "</tr>";
	}	
}

function deleteCategory(){
	global $connection;

	if(isset($_GET['delete'])){
		$cat_id = $_GET['delete'];
		$del_query = "DELETE FROM categories WHERE id = {$cat_id} ";
		$delete_query = mysqli_query($connection, $del_query);
		header('location: categories.php');
	}
}

function confirmQuery($result){
	global $connection;

	 if(!$result){
	 	die("Query failed." . mysqli_error($connection));
	 }
	 
}

function imagePlaceHolder($image = ''){

	if(!$image){
		return 'code.jpg';
	}else {
		return $image;
	}

}

function recordCount($table){
	global $connection;

	$query = "SELECT * FROM " .$table;
    $select_all_post = mysqli_query($connection, $query);
    $result = mysqli_num_rows($select_all_post);

    confirmQuery($result);

    return $result;

}


function checkStatus($table, $column, $status){
	global $connection;

	$query = "SELECT * FROM $table WHERE $column = '$status'";
    $result = mysqli_query($connection, $query);
    return mysqli_num_rows($result);


}

function checkUserRole($table, $column, $role){
	global $connection;

	$query = "SELECT * FROM $table WHERE $column = '$role'";
	$result = mysqli_query($connection, $query);
    return mysqli_num_rows($result);


}

function online_users(){

	if(isset($_GET['onlineusers'])){

	global $connection;

	if(!$connection){
		session_start();
		include("../includes/db.php");

	$session = session_id();
    $time = time();
    $time_out_in_seconds = 30;
    $time_out =  $time - $time_out_in_seconds;

    $query = "SELECT * FROM users_online WHERE session = '$session'";
    $send_query = mysqli_query($connection, $query);
    $count = mysqli_num_rows($send_query);

    if($count ==NULL){
        mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session','$time')");
    }else{
        mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
    }

    $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out' ");
    echo $count_user = mysqli_num_rows($users_online_query);
		} //if !connection
	}//get request
}//function end
online_users();



function isAdmin($username){
	global $connection;
	$query =  "SELECT user_role FROM users WHERE username = '$username' ";
	$result = mysqli_query($connection	, $query);
	confirmQuery($result);

	$row = mysqli_fetch_array($result);
	$echo = $row['user_role'];

	if($row['user_role'] == 'admin'){
		return true;
	}else{
		return false;
	}
}


function username_exists($username){
	global $connection;

	$query =  "SELECT username FROM users WHERE username = '$username' ";
	$result = mysqli_query($connection	, $query);
	confirmQuery($result);

	if(mysqli_num_rows($result) > 0){
		return true;
	}else{
		false;
	}

}

function email_exists($email){

	global $connection;

	$query =  "SELECT username FROM users WHERE user_email = '$email' ";
	$result = mysqli_query($connection	, $query);
	confirmQuery($result);

	if(mysqli_num_rows($result) > 0){
		return true;
	}else{
		false;
	}

}

function register_user($username, $email, $password){
	global $connection;


    $username = mysqli_real_escape_string($connection, $username);
    $email    = mysqli_real_escape_string($connection, $email);
    $password = mysqli_real_escape_string($connection, $password);


    if(username_exists($username)){
      $message =  "Username exists.";
    }

    	$query = "SELECT randSalt from users ";
    	$select_randsalt_query =  mysqli_query($connection, $query);


        if(!$select_randsalt_query){
            die("query failed" . mysqli_error($connection));
        }

	     $row = mysqli_fetch_array($select_randsalt_query);
	     $salt = $row['randSalt'];
	     $password = crypt($password, $salt);
     
	     //new user query
	     $query = "INSERT INTO users (username, user_email, user_password, user_role, user_firstname, user_lastname, user_image) ";
	     $query.="VALUES ('{$username}', '{$email}', '{$password}', 'subscriber', '', '', '') ";
	     $register_query = mysqli_query($connection, $query);

		 confirmQuery($register_query);
    	// $message = "Registration has been submitted!";
    

}

function login_user($username, $password){

	global $connection;


	$username = $username;
	$password = $password;

	$username = mysqli_real_escape_string($connection, $username);
	$password = mysqli_real_escape_string($connection, $password);


	$query = "SELECT * FROM users WHERE username = '{$username}'";
	$select_user_query = mysqli_query($connection, $query);

	confirmQuery($select_user_query);

	while ($row = mysqli_fetch_array($select_user_query)){

		$db_user_id 	   = $row['user_id'];
		$db_username 	   = $row['username'];
		$db_user_password  = $row['user_password'];
		$db_user_firstname = $row['user_firstname'];
		$db_user_lastname  = $row['user_lastname'];
		$db_user_role 	   = $row['user_role'];
	}

	$password = crypt($password, $db_user_password);


	if($username === $db_username && $password === $db_user_password){

		$_SESSION['username']  = $db_username;
		$_SESSION['firstname'] = $db_user_firstname;
		$_SESSION['lastname']  = $db_user_lastname;
		$_SESSION['user_role'] = $db_user_role;

		redirect("admin/index.php");


	}else{

		redirect("index.php");

	}   
}

