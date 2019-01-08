<table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Username</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th colspan="2" style="text-align:center;">Change role</th>
                                        <th colspan="2" style="text-align:center;">Tools</th>
                                                                                
                                    </tr>
                                </thead>
                                <tbody>
                                    
  <?php  

    $query = "SELECT * FROM users";
    $select_users = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($select_users)){
        /*print_r($row);*/
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image']; 
        $user_role = $row['user_role'];  

        echo "<tr>";
            echo "<td>$user_id</td>";
            echo "<td>$username</td>";
            echo "<td>$user_firstname</td>";
            echo "<td>$user_lastname</td>";




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

        
            echo "<td>$user_email</td>"; 
            echo "<td>$user_role</td>";
            
           /* $query = "SELECT * FROM posts WHERE id = $comment_post_id" ;
            $select_post_id_query = mysqli_query($connection, $query);
            

            while($row = mysqli_fetch_assoc($select_post_id_query)){
                $post_id = $row['id'];
                $post_title = $row['post_title'];

                echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
            }*/

            



           
            echo "<td><a href ='users.php?change_to_admin=$user_id'>Make Admin</a></td>";
            echo "<td><a href ='users.php?change_to_subscriber=$user_id'>Make Subsriber</a></td>";
            echo "<td><a class='btn btn-primary' href ='users.php?source=edit_user&edit_user={$user_id}'>Edit</a></td>";

            // echo "<td><a href ='users.php?delete=$user_id'>Delete</a></td>";

            ?>
            <form method="post">
                <input type="hidden" name ="user_id" value="<?php echo $user_id; ?>">

            <?php

            echo '<td><input class="btn btn-danger" type="submit" name="delete" value="Delete"></td>';
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
     
     $the_user_id = $_POST['user_id'];
     $query = "DELETE FROM users WHERE user_id = {$the_user_id}";

     $delete_query = mysqli_query($connection, $query);

        confirmQuery($delete_query);
        header('Location: users.php');


  } 


   if(isset($_GET['change_to_admin'])){
     
     $the_user_id = escape($_GET['change_to_admin']);
     $to_admin = "UPDATE users SET user_role = 'admin' WHERE user_id = $the_user_id";

      $change_to_admin_query = mysqli_query($connection, $to_admin);

        confirmQuery($to_admin);
        header('Location: users.php');

               
  }

     if(isset($_GET['change_to_subscriber'])){
     
     $the_user_id = escape($_GET['change_to_subscriber']);
     $to_subscriber_query = "UPDATE users SET user_role = 'subscriber' WHERE user_id = $the_user_id";

     $to_subscriber = mysqli_query($connection, $to_subscriber_query);

        confirmQuery($to_subscriber);
        header('Location: users.php');

               
  }



?>