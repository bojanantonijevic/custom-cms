<?php 

if(isset($_POST['create_post'])){

  $post_title = escape($_POST['title']);
  $post_user = escape($_POST['post_user']);

  $post_category_id = escape($_POST['post_category']);
  $post_status = escape($_POST['post_status']);

  $post_image = escape($_FILES['image']['name']);
  $post_image_temp = escape($_FILES['image']['tmp_name']);

  $post_tag = escape($_POST['post_tag']);
  $post_content = escape($_POST['post_content']);
  @$post_date = date('d-m-y');
  $post_comment_count = 0;
  $post_author = "";
  $post_views_count = 0;
  

 
  move_uploaded_file($post_image_temp, "../images/$post_image" );

 $query = "INSERT INTO posts(post_category_id, post_title, post_user, post_author, post_date, post_image, post_content, post_tag, post_status, post_comment_count, post_views_count) VALUES ({$post_category_id},'{$post_title}','{$post_user}','{$post_author}' ,now(),'{$post_image}','{$post_content}','{$post_tag}', '{$post_status}', '{$post_comment_count}', '{$post_views_count}') ";
             
  


      $create_post_query = mysqli_query($connection, $query);

      confirmQuery($create_post_query);

      $the_last_id = mysqli_insert_id($connection);
      /*header('Location: posts.php');*/
      header("Refresh: 3; url=posts.php");
        echo "<p class='bg-success'>Your post has been created! <a href='../post.php?p_id=$the_last_id'> View Your Post</a></p>";

}

 ?>






<form action="" method="post" enctype="multipart/form-data">    
     
     
      <div class="form-group">
         <label for="title">Post Title</label>
          <input type="text" class="form-control" name="title">
      </div>

      <div class="form-group">

         <label for="category">Category</label>

        <select class="form-control" name="post_category" id="post_category">
          <?php 

          $query = "SELECT * FROM categories";
          $select_categories = mysqli_query($connection, $query);

          confirmQuery($select_categories);

          while($row = mysqli_fetch_assoc($select_categories)){
            /*print_r($row);*/
          $cat_id = escape($row['id']);
          $cat_title = escape($row['cat_title']);

          echo "<option value='{$cat_id}'>{$cat_title}</option>";


        }

        ?>
        

       </select>

        </div>



     <!--  <div class="form-group">
        <label for="title">Post Author</label>
         <input type="text" class="form-control" name="author">
     </div> -->
    <div class="form-group">
         <label for="users">Users</label>

        <select class="form-control" name="post_user" id="">
          <?php 

          $query = "SELECT * FROM users";
          $select_users = mysqli_query($connection, $query);

          confirmQuery($select_users);

          while($row = mysqli_fetch_assoc($select_users)){
            /*print_r($row);*/
          $user_id = escape($row['user_id']);
          $username = escape($row['username']);

          echo "<option value='{$username}'>{$username}</option>";


        }

        ?>
        

       </select>

        </div>




      


       <div class="form-group">
         <label for="post_status">Post Status Set:</label>
         <select class="form-control" name="post_status" id="">
             <option value="draft">Post Status</option>
             <option value="published">Publish</option>
             <option value="draft">Draft</option>
         </select>
      </div>
      
      
      
    <div class="form-group">
         <label for="post_image">Post Image</label>
          <input type="file"  name="image">
      </div>

      <div class="form-group">
         <label for="post_tag">Post Tags</label>
          <input type="text" class="form-control" name="post_tag">
      </div>
      
      <div class="form-group">
         <label for="post_content">Post Content</label>
         <textarea id="editor" class="form-control "name="post_content" id="" cols="30" rows="10">
         </textarea>
      </div>
      
      

       <div class="form-group">
          <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
      </div>


</form>