<?php 


if(isset($_GET['edit_user'])){

  $the_user_id = escape($_GET['edit_user']);


  $query = "SELECT * FROM users WHERE user_id = $the_user_id";

  $select_users_query = mysqli_query($connection, $query);
    confirmQuery($select_users_query);
    
    while($row = mysqli_fetch_assoc($select_users_query)){
        /*print_r($row);*/
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image']; 
        $user_role = $row['user_role'];  


      }



}


if(isset($_POST['edit_user'])){

   
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

  $salt_query = "SELECT randSalt FROM users";
  $select_randsalt_query = mysqli_query($connection, $salt_query);
  confirmQuery($select_randsalt_query);

  $row = mysqli_fetch_array($select_randsalt_query);
  $salt = $row['randSalt'];
  $hashed_password = crypt($user_password, $salt);
  

 
  $query = "UPDATE users SET ";
        $query .="user_firstname = '{$user_firstname}', ";
        $query .="user_lastname = '{$user_lastname}', ";
        $query .="username ='{$username}', ";
        $query .="user_role ='{$user_role}', ";
        $query .="user_email = '{$user_email}', ";
        $query .="user_password = '{$hashed_password}', ";
        $query .="user_image = '{$user_image}' ";
        //$query .="randSalt = '{$randSalt}' ";
        $query .="WHERE user_id='{$the_user_id}' ";
        


        $update_user = mysqli_query($connection, $query);
        confirmQuery($update_user);

        header('location: users.php');
 
}

 ?>


<form action="" method="post" enctype="multipart/form-data">    
   <div class="form-group">
         <label for="title">First name</label>
          <input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname;?>">
    </div>

     <div class="form-group">
         <label for="title">Last name</label>
          <input type="text" class="form-control" name="user_lastname" value="<?php echo $user_lastname;?>">
    </div> 
     
      <div class="form-group">
         <label for="category">Category</label>

        <select name="user_role" id="">
          <option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>

        <?php 
        if($user_role == 'admin'){
          echo "<option value='subscriber'>subscriber</option>";
        }else{
          echo "<option value='admin'>admin</option>";
        }

         ?>


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
          <input type="text" class="form-control" name="username" value="<?php echo $username;?>">
      </div>
      
      <div class="form-group">
         <label for="post_content">Email</label>
         <input type="email" class="form-control" name="user_email" value="<?php echo $user_email;?>">
      </div>

      <div class="form-group">
         <label for="post_content">Password</label>
         <input type="password" class="form-control" name="user_password" value="<?php echo $user_password;?>">
      </div>
      
      

       <div class="form-group">
          <input class="btn btn-primary" type="submit" name="edit_user" value="Edit User">
      </div>


</form>