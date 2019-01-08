<?php 

if(isset($_POST['create_user'])){

   
  $user_firstname = escape($_POST['user_firstname']);
  $user_lastname = escape($_POST['user_lastname']);
  $user_role = escape($_POST['user_role']);

  /*$post_image = $_FILES['image']['name'];
  $post_image_temp = $_FILES['image']['tmp_name']*/;

  $user_email = escape($_POST['user_email']);
  $username = escape($_POST['username']);
  $user_password = escape($_POST['user_password']);
  /*move_uploaded_file($post_image_temp, "../images/$post_image" );*/
  $user_image = 1;
  //$randSalt = 1;

    $username = mysqli_real_escape_string($connection, $username);
    $user_email    = mysqli_real_escape_string($connection, $user_email);
    $user_password = mysqli_real_escape_string($connection, $user_password);

 if(!empty($username) && !empty($user_email) && !empty($user_password)){

        $query = "SELECT randSalt from users ";
        $select_randsalt_query =  mysqli_query($connection, $query);


        if(!$select_randsalt_query){
            die("query failed" . mysqli_error($connection));
       }

     $row = mysqli_fetch_array($select_randsalt_query);
     $salt = $row['randSalt'];
     $user_password = crypt($user_password, $salt);
     


     //new user query
     $query = "INSERT INTO users (username, user_password, user_firstname, user_lastname, user_email, user_role, user_image) VALUES ('{$username}','{$user_password}','{$user_firstname}','{$user_lastname}','{$user_email}','{$user_role}', {$user_image}) ";

     $create_user = mysqli_query($connection, $query);

    confirmQuery($create_user);
    $message = "New user has been created!";
    header( "refresh:2; url=users.php" );
      echo "<h2>User has been created!</h2>";

    }else{
        $message = "Fields cannot be empty.";
    }

}else {
    $message = '';
}
  

 

 ?>


<form action="" method="post" enctype="multipart/form-data">    
   <div class="form-group">
         <label for="title">First name</label>
          <input type="text" class="form-control" name="user_firstname">
    </div>

     <div class="form-group">
         <label for="title">Last name</label>
          <input type="text" class="form-control" name="user_lastname">
    </div> 
     
      <div class="form-group">
         <label for="category">Category</label>

        <select name="user_role" id="">
          <option value="sbscriber">Select Options</option>
          <option value="admin">Admin</option>
          <option value="subscriber">Subscriber</option>

       </select>

        </div>


    <!--    <div class="form-group">
      <select name="post_status" id="">
          <option value="draft">Last name </option>
          <option value="published">Published</option>
          <option value="draft">Draft</option>
      </select>
          </div> -->


     
      <div class="form-group">
         <label for="post_tag">Username</label>
          <input type="text" class="form-control" name="username">
      </div>
      
      <div class="form-group">
         <label for="post_content">Email</label>
         <input type="email" class="form-control" name="user_email">
      </div>

      <div class="form-group">
         <label for="post_content">Password</label>
         <input type="password" class="form-control" name="user_password">
      </div>
      
      

       <div class="form-group">
          <input class="btn btn-primary" type="submit" name="create_user" value="+Add User">
      </div>


</form>