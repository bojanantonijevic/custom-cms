<?php 

if(isset($_GET['p_id'])){

$the_post_id = escape($_GET['p_id']);

}

$query = "SELECT * FROM posts WHERE id = $the_post_id ";
    $select_post_by_id = mysqli_query($connection, $query);


    while($row = mysqli_fetch_assoc($select_post_by_id)){
        /*print_r($row);*/
        
        $post_id = $row['id'];
        $post_user = $row['post_user'];
        $post_title = $row['post_title'];
        $post_category_id = $row['post_category_id'];
        $post_image = $row['post_image'];
        $post_tags = $row['post_tag'];
        $post_comments =$row['post_comment_count'];

        $post_date = $row['post_date'];
        $post_status = $row['post_status'];
        $post_content = $row['post_content'];

      }

      if(isset($_POST['update_post'])){

        $post_title = escape($_POST['title']);
        $post_user = escape($_POST['post_user']);
        $post_category_id = escape($_POST['post_category']);
        $post_status = escape($_POST['post_status']);

        $post_image = $_FILES['image']['name'];
        $post_image_temp = $_FILES['image']['tmp_name'];

        $post_tag = escape($_POST['post_tag']);
        $post_content = escape($_POST['post_content']);
        move_uploaded_file($post_image_temp, "images/$post_image" );

        if(empty($post_image)){
          $select_image = mysqli_query($connection, $query);

          while($row = mysqli_fetch_assoc($select_image)){
            $post_image = $row['post_image'];
          }
        }


        $query = "UPDATE posts SET ";
        $query .="post_title = '{$post_title}', ";
        $query .="post_date = now(), ";
        $query .="post_image ='{$post_image}', ";
        $query .="post_category_id ='{$post_category_id}', ";
        $query .="post_user = '{$post_user}', ";
        $query .="post_status = '{$post_status}', ";
        $query .="post_tag = '{$post_tag}', ";
        $query .="post_content = '{$post_content}' ";
        $query .="WHERE id = '{$the_post_id}'";


        $update_post = mysqli_query($connection, $query);
        confirmQuery($update_post);

        /*header('location: posts.php');*/
       
        echo "<p class='bg-success'>Your post has been updated! <a href='../post.php?p_id=$the_post_id'> View Your Post</a> or <a href='posts.php'> View All Posts</a></p>";
        
      }
    

 ?>

<form action="" method="post" enctype="multipart/form-data">    
     
     
      <div class="form-group">
         <label for="title">Post Title</label>
          <input type="text" class="form-control" value = "<?php echo $post_title;?>" name="title">
      </div>

        <div class="form-group">
       <label for="category">Category</label>

      <select name="post_category" id="post_category">
        <?php 

        $query = "SELECT * FROM categories";
        $select_categories = mysqli_query($connection, $query);

        confirmQuery($select_categories);

        while($row = mysqli_fetch_assoc($select_categories)){
          /*print_r($row);*/
        $cat_id = $row['id'];
        $cat_title = $row['cat_title'];

        

          if($cat_id == $post_category_id){
            echo "<option selected value='{$cat_id}'>{$cat_title}</option>";
          }else{
            echo "<option value='{$cat_id}'>{$cat_title}</option>";
          }

      }

      ?>
      

     </select>

        </div>



      <div class="form-group">
         <label for="users">Users</label>

        <select class="form-control" name="post_user" id="">

          <?php echo "<option selected value='{$post_user}'>{$post_user}</option>"; ?>



          
          <?php 

          $query = "SELECT * FROM users";
          $select_users = mysqli_query($connection, $query);

          confirmQuery($select_users);

          while($row = mysqli_fetch_assoc($select_users)){
            /*print_r($row);*/
          $user_id = $row['user_id'];
          $username = $row['username'];

          echo "<option value='{$username}'>{$username}</option>";



        }

        ?>
        

       </select>

        </div>
      
      
    <div class="form-group">
    <select name="post_status" id="">
      <option value='<?php echo $post_status; ?>'><?php echo $post_status; ?></option>
      <?php 
        if($post_status == 'published'){
          echo "<option value='draft'>Draft</option>";
        }else{
          echo "<option value='published'>Published</option>";
        }
       ?>
    </select>
  </div>


    <div class="form-group">
        <label for="post_image">Post Image</label><br />
        Current picture: <img width="150" src="../admin/images/<?php echo $post_image ?>" alt=""><br /><br />
         <input type="file"  name="image">
     </div>

      <div class="form-group">
         <label for="post_tag">Post Tags</label>
          <input type="text" class="form-control" value = "<?php echo $post_tags;?>" name="post_tag">
      </div>
      
      <div class="form-group">
         <label for="post_content">Post Content</label>
         <textarea class="form-control " name="post_content" id="editor" cols="30" rows="10"><?php echo str_replace('\r\n','<br/>',$post_content);?>
         </textarea>
      </div>

       <div class="form-group">
          <input class="btn btn-primary" type="submit" name="update_post" value="Update Post">
      </div>


</form>