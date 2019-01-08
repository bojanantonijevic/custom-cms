<?php include "includes/header.php"; ?>
<?php 

if(isset($_SESSION['username'])){
     $username = $_SESSION['username'];

     $query ="SELECT * FROM users WHERE username = '{$username}' ";
     $select_user_profile = mysqli_query($connection, $query);

      while($row = mysqli_fetch_array($select_user_profile)){
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
  $randSalt = 1;

 
        $query = "UPDATE users SET ";
        $query .="user_firstname = '{$user_firstname}', ";
        $query .="user_lastname  = '{$user_lastname}', ";
        $query .="username       = '{$username}', ";
        $query .="user_role      = '{$user_role}', ";
        $query .="user_email     = '{$user_email}', ";
        $query .="user_password  = '{$user_password}', ";
        $query .="user_image     = '{$user_image}', ";
        $query .="randSalt       = '{$randSalt}' ";
        $query .="WHERE username = '{$username}' ";
        


        $update_user = mysqli_query($connection, $query);
        confirmQuery($update_user);

        header('location: users.php');

 
}


 ?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/navigation.php"; ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">
                                Edit User
                                <small>(<?php echo strtoupper($_SESSION['username']); ?>)</small>
                            </h1>
                            
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
          <option value="subscriber"><?php echo $user_role; ?></option>

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
          <input  type="text" class="form-control" name="username" value="<?php echo $username;?>">
      </div>
      
      <div class="form-group">
         <label for="post_content">Email</label>
         <input type="email" class="form-control" name="user_email" value="<?php echo $user_email;?>">
      </div>

      <div class="form-group">
         <label for="post_content">Password</label>
         <input type="password" class="form-control" name="user_password" value="<?php echo $user_password; ?>">
      </div>
      
      

       <div class="form-group">
          <input class="btn btn-primary" type="submit" name="edit_user" value="+Update Profile">
      </div>


</form>

                            

                           
                        </div>
                    </div>
                    <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

<?php include "includes/footer.php" ?>