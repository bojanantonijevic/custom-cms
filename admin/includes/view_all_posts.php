<?php 
include ("delete_modal.php");
if(isset($_POST['checkBoxArray'])){

    foreach($_POST['checkBoxArray'] as $postValueId ){

        $bulk_options = escape($_POST['bulk_options']);

        switch ($bulk_options) {
            case 'published':
                
            $query ="UPDATE posts SET post_status = '{$bulk_options}' WHERE id={$postValueId}";
            $update_to_published_status = mysqli_query($connection, $query);

                break;

                case 'draft':
                    
                $query ="UPDATE posts SET post_status = '{$bulk_options}' WHERE id={$postValueId}";
                $update_to_draft_status = mysqli_query($connection, $query);

                break;

                case 'delete':
                    
                $query ="DELETE FROM posts WHERE id={$postValueId}";
                $delete_bulk_post = mysqli_query($connection, $query);

                break;

                case 'clone':

                $query = "SELECT * FROM posts WHERE id = '{$postValueId}' ";
                $select_post_query = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_array($select_post_query)){

                    $post_title = $row['post_title'].' CLONED!';
                    $post_category_id = $row['post_category_id'];
                    @$post_date = $row['post_date'];
                    $post_author = $row['post_author'];
                    $post_user = $row['post_user'];
                    $post_status = $row['post_status'];
                    $post_image = $row['post_image'];
                    $post_tag = $row['post_tag'];
                    $post_content = $row['post_content'];
                    $post_comment_count = $row['post_comment_count'];
                    $post_views_count = $row['post_views_count'];

                }

                $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_user, post_date, post_status, post_image, post_tag, post_content, post_comment_count, post_views_count)  VALUES({$post_category_id}, '{$post_title}', '{$post_author}', '{$post_user}',now(), '{$post_status}', '{$post_image}', '{$post_tag}', '{$post_content}', 0, 0) ";

                $copy_query = mysqli_query($connection, $query);

                confirmQuery($copy_query);


                break;
            
            default:
                
                break;
        }
    }
}


 ?>
<form action="" method="post">

<table class="table table-bordered table-hover">



    <div id="bulkOptionContainer" class="col-xs-4">
        
        <select class="form-control" name="bulk_options" id="">
            
            <option value="">Select Option</option>
            <option value="published">Publish</option>
            <option value="draft">Draft</option>
            <option value="delete">Delete</option>
             <option value="clone">Clone</option>

        </select>

    </div>
    <div class="col-xs-4">
        
        <input type="submit" name="submit" class="btn btn-success" value="Apply">
        <a href="posts.php?source=add_post" class="btn btn-primary">Add New</a>
    </div><br><br>
                                <thead>
                                    <tr>
                                        <th><input id="selectAllBoxes" type="checkbox"></th>
                                        <th>Id</th>
                                        <th>Users</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Image</th>
                                        <th>Tags</th>
                                        <th>Comments</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Preview</th>
                                        <th colspan="2" style="text-align:center;">Tools</th>
                                        <th># of views</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    
  <?php  

  $query = "SELECT * FROM posts ORDER BY id DESC";
  $select_posts = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($select_posts)){
        /*print_r($row);*/
        $post_id = $row['id'];
        $post_author = $row['post_author'];
        $post_user = $row['post_user'];
        $post_title = $row['post_title'];
        $post_category_id = $row['post_category_id']; 

        $query = "SELECT * FROM categories WHERE id = {$post_category_id}";
        $select_categories_id = mysqli_query($connection, $query); 

        while($row_cat = mysqli_fetch_assoc($select_categories_id)){
        $cat_id = $row_cat['id'];
        $cat_title = $row_cat['cat_title'];
        
         
        
        }

        $post_image = $row['post_image'];
        
        $post_tags = $row['post_tag'];
        $post_comments = $row['post_comment_count'];
        $post_date = $row['post_date'];
        $post_status = $row['post_status'];
        $post_views_count = $row['post_views_count'];
        
        

        echo "<tr>";
        ?>
            <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id; ?>'></td>

        <?php    
            echo "<td>$post_id</td>";

            if(!empty($post_author)){

                echo "<td>$post_author</td>";

            }elseif(!empty($post_user)){

                echo "<td>$post_user</td>";

            }

          
            



            echo "<td>$post_title</td>";
            echo "<td>{$cat_title}</td>"; //------>>>>From the Categories Table  <<<<------
            /*echo "<td>$post_category_id</td>";*/
            
            if($post_image == ''){echo "<td>No image chosen for this post. <br />Placeholder has been used.</td>";}else{echo "<td><img width='100px' src='../admin/images/$post_image'></td>";};
            
            echo "<td>$post_tags</td>";
            echo "<td>$post_comments</td>";
            echo "<td>$post_date</td>";
            echo "<td>$post_status</td>";
            echo "<td><a href ='../post.php?p_id={$post_id}'>View Post</a></td>";
            echo "<td><a class='btn btn-primary' href ='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";

            ?>
            <form method="post">
                <input type="hidden" name ="post_id" value="<?php echo $post_id; ?>">

            <?php

            echo '<td><input class="btn btn-danger delete_link" type="submit" name="delete" value="Delete"></td>';
            ?>
            
            </form>

            <?php
            // echo "<td><a rel='$post_id' href='javascript:void(0)' class='delete_link'>Delete</a></td>";

             echo "<td><a href = 'posts.php?reset={$post_id}'>$post_views_count</a></td>";

        echo "</tr>";


}

  ?>

                                    
</tbody>
</table>
</form>


<?php  

  if(isset($_POST['delete'])){

         
     $the_post_id = $_POST['post_id'];
     $query = "DELETE FROM posts WHERE id = {$the_post_id}";

     $delete_query = mysqli_query($connection, $query);

        confirmQuery($delete_query);
        header('Location: posts.php');
    
  }  

  if(isset($_GET['reset'])){

    $the_post_id = escape($_GET['reset']);

    $query = "UPDATE posts SET post_views_count = 0 WHERE id =".mysqli_real_escape_string($connection, $_GET['reset'])." ";
    $reset_query = mysqli_query($connection, $query);
    confirmQuery($reset_query);
    header("Location: posts.php");
  }  


?>

<script>
    
$(document).ready(function(){

    $(".delete_link").on('click', function(){
        var id = $(this).attr("rel");
        var delete_url = "posts.php?delete="+ id +" ";


       $(".delete_modal_link").attr("href", delete_url); 

       $("#myModal").modal('show');

    });


});
</script>
