<table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Author</th>
                                        <th>Comment</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>In Rensponse to</th>
                                        <th>Date</th>
                                        <th colspan="3" style="text-align:center;">Tools</th>
                                        
                                        
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    
  <?php  

    $query = "SELECT * FROM comments";
    $select_comments = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($select_comments)){
        /*print_r($row);*/
        $comment_id = $row['comment_id'];
        $comment_post_id = $row['comment_post_id'];
        $comment_date = $row['comment_date'];
        $comment_author = $row['comment_author'];
        $comment_email = $row['comment_email'];
        $comment_content = $row['comment_content'];
        $comment_status = $row['comment_status']; 
        

        echo "<tr>";
            echo "<td>$comment_id</td>";
            echo "<td>$comment_author</td>";
            echo "<td>$comment_content</td>";


        /*$query = "SELECT * FROM categories WHERE id = {$post_category_id}";
        $select_categories_id = mysqli_query($connection, $query); 

        while($row_cat = mysqli_fetch_assoc($select_categories_id)){
        $cat_id = $row_cat['id'];
        $cat_title = $row_cat['cat_title'];
                
        }

        $post_image = $row['post_image'];
        $post_tags = $row['post_tag'];
        $post_comments = $row['post_comment_count'];
        $post_date = $row['post_date'];
        $post_status = $row['post_status'];*/

        
            echo "<td>$comment_email</td>"; 
            echo "<td>$comment_status</td>";
            
            $query = "SELECT * FROM posts WHERE id = $comment_post_id" ;
            $select_post_id_query = mysqli_query($connection, $query);
            

            while($row = mysqli_fetch_assoc($select_post_id_query)){
                $post_id = $row['id'];
                $post_title = $row['post_title'];

            }
            if(empty($post_id) ){
                  echo '<td>This post is no longer active.</td>';
                }else{

                echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
              
            }

            



            echo "<td>$comment_date</td>";

            echo "<td style='text-align:center;'><a class='btn btn-success' href ='comments.php?approve=$comment_id'>Approve</a></td>";
            echo "<td style='text-align:center;'><a class='btn btn-warning' href ='comments.php?unapprove=$comment_id'>Unapprove</a></td>";

            // echo "<td><a href ='comments.php?delete=$comment_id'>Delete</a></td>";

            ?>
            <form method="post">
                <input type="hidden" name ="comment_id" value="<?php echo $comment_id; ?>">

            <?php

            echo '<td style="text-align:center;"><input class="btn btn-danger delete_link" type="submit" name="delete" value="Delete"></td>';
            ?>
            
            </form>

            <?php



        echo "</tr>";


}

  ?>

                                    
                                </tbody>
                            </table>


<?php  

  if(isset($_POST['delete'])){
     
     $the_comment_id = escape($_POST['comment_id']);
     $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id}";

     $delete_query = mysqli_query($connection, $query);

        confirmQuery($delete_query);
        header('Location: comments.php');


  }  
   if(isset($_GET['unapprove'])){
     
     $the_comment_id = escape($_GET['unapprove']);
     $unapprove_comment_query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = $the_comment_id";

     $unapprove_query = mysqli_query($connection, $unapprove_comment_query);

        confirmQuery($unapprove_query);
        header('Location: comments.php');

               
  }

     if(isset($_GET['approve'])){
     
     $the_comment_id = escape($_GET['approve']);
     $approve_comment_query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = $the_comment_id";

     $delete_query = mysqli_query($connection, $approve_comment_query );

        confirmQuery($approve_comment_query);
        header('Location: comments.php');

               
  }



?>