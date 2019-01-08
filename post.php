<?php
session_start();
include('includes/db.php');
include('includes/header.php');
// include('admin/functions.php');

?>

    <!-- Navigation -->
<?php 
include("includes/navigation.php");
?>

<?php


        $result = query("SELECT * FROM users WHERE  username ='" . $_SESSION['username'] ."'" );
        confirmQuery($result);
        $user = mysqli_fetch_array($result);
        if(mysqli_num_rows($result) >= 1){
            $user_id = $user['user_id'];
        }
        

    //LIKING
    

    if(isset($_POST['liked'])){
        //getting this from Ajax
        $post_id = $_POST['post_id'];
        $user_id = $_POST['user_id'];

        //1. get the right post

        $query = "SELECT * FROM posts WHERE id = $post_id ";
        $postResult = mysqli_query($connection, $query);
        $post = mysqli_fetch_array($postResult);
        $likes = $post['likes'];

        //2. UPDATE likes
        
        mysqli_query($connection, "UPDATE posts SET likes = $likes+1 WHERE id = $post_id");

        //3. CREATE likes for post
        //
        mysqli_query($connection, "INSERT INTO likes(user_id, post_id) VALUES ($user_id, $post_id)");

        exit();

        redirect('post.php');

        
    }

        //UNLIKING

    if(isset($_POST['unliked'])){
        //getting this from Ajax
        $post_id = $_POST['post_id'];
        $user_id = $_POST['user_id'];

        //1. get the right post

        $query = "SELECT * FROM posts WHERE id = $post_id ";
        $postResult = mysqli_query($connection, $query);
        $post = mysqli_fetch_array($postResult);
        $likes = $post['likes'];

        //2. DELETE likes
        
        mysqli_query($connection, "DELETE FROM likes  WHERE post_id = $post_id AND user_id = $user_id ");

        //3. CREATE likes for post
        
        mysqli_query($connection, "UPDATE posts SET likes =  $likes-1 WHERE id = $post_id");

        exit();

        
    }

 ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

    <?php

    if(isset($_GET['p_id'])){
        $the_post_id = escape($_GET['p_id']);

    $view_query = "UPDATE posts SET post_views_count = post_views_count +1 WHERE id = $the_post_id";
    $send_query = mysqli_query($connection, $view_query);
    confirmQuery($send_query);




    if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'){
        $query = "SELECT * FROM posts WHERE id= $the_post_id";
    }else{
        $query = "SELECT * FROM posts WHERE id= $the_post_id AND post_status = 'published' ";
    }

    //$query = "SELECT * FROM posts WHERE id= $the_post_id";
    $select_all_posts_query = mysqli_query($connection, $query);
    confirmQuery($select_all_posts_query);

    if(mysqli_num_rows($select_all_posts_query) < 1){

        echo "<h1 class='text-center'>No posts available!</h1>" ;

    }else{

    

                        while($row = mysqli_fetch_assoc($select_all_posts_query)){

                            $post_id = $row['id'];
                            $post_title = $row['post_title'];
                            $post_author = $row['post_user'];
                            $post_date = $row['post_date'];
                            $post_image = $row['post_image'];
                            $post_content = $row['post_content'];
                        ?>

                <h1 class="page-header">
                    Posts
                    <!-- <small>Secondary Text</small> -->
                </h1>

                <!-- First Blog Post -->
                <h2>
                    <a href='post.php?p_id=<?php echo $post_id;?>'><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    by <a href="author_posts.php?author=<?php echo $post_author; ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo imagePlaceHolder($post_image); ?></p>
                <hr>
                <img class="img-responsive" src="admin/images/<?php echo $post_image; ?>" alt="">
                <hr>
                <p><?php echo $post_content ?></p>

                 <hr>

                <?php 

                if(isLoggedIn()){ ?>

                
                    
                <div class="row">
                    <p class="pull-right">
                        <a href="" class="<?php echo userLiked($the_post_id) ?'unlike' : 'like';?>">
                            <span class="glyphicon glyphicon-thumbs-up"></span>

                            <?php echo userLiked($the_post_id) ?' Dislike' : ' Like'; ?></a>
                    </p>
                </div>

               <?php }else{ ?> 

               <!-- if not logged in  -->

                <div class="row">
                    <p class="pull-right">
                       <a href="login.php">Login</a> to like this post.   
                    </p>
                </div>

               <?php }

                ?>

                

                 <!-- <div class="row">
                    <p class="pull-right">
                        <a href="#" class="unlike"><span class="glyphicon glyphicon-thumbs-down"></span> Unlike</a>
                    </p>
                </div> -->

                <div class="row">
                    <p class="pull-right">
                        <span class="glyphicon glyphicon-heart" style="color:red;"></span> <?php getPostLikes($the_post_id); ?>
                    </p>
                </div>



                <div class="clearfix"></div>

                 

    <?php  } 

?>

                


            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php
            include("includes/sidebar.php");
            ?>

        </div>
        <!-- /.row -->

        <hr>


<!-- Blog Comments -->

<?php 
if(isset($_POST['create_comment'])){

    $comment_author = $_POST['comment_author'];
    $comment_email = $_POST['comment_email'];
    $comment_content = $_POST['comment_content'];

    if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)){

    $the_post_id = $_GET['p_id'];

  

    $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) VALUES ($the_post_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'unapproved', now() )";

    $create_comment_commnet = mysqli_query($connection, $query);
    confirmQuery($create_comment_commnet);


    $count_query = "UPDATE posts SET post_comment_count = post_comment_count + 1 WHERE id = $the_post_id";
    $update_comment_count = mysqli_query($connection, $count_query);

    }else{
        echo "<script>alert('Fields cannot be empty!');</script>";
    }

}


 ?>




                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="post" role="form">

                        <div class="form-group">
                            <label for="Author">Author</label>
                            <input class="form-control" type="text" name="comment_author">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="form-control" type="email" name="comment_email">
                        </div>



                        <div class="form-group">
                            <label for="Comment">Your Comment</label>
                            <textarea name="comment_content" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

<?php

$query = "SELECT * FROM comments WHERE comment_post_id = {$the_post_id} AND comment_status = 'approved' ORDER BY comment_id DESC";
$select_comment_query = mysqli_query($connection, $query);
confirmQuery($select_comment_query);

while($row = mysqli_fetch_assoc($select_comment_query)){
$comment_date = $row['comment_date'];
$comment_content = $row['comment_content'];
$comment_author = $row['comment_author'];

?>

<!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author ?>
                            <small><?php echo $comment_date ?></small>
                        </h4>
                        <?php echo $comment_content ?>
                    </div>
                </div>


    <?php } } } else {
        header('Location: index.php');
    }

include("includes/footer.php");    
?>


</div>

<script>
    $(document).ready(function(){

        var post_id = <?php echo $the_post_id; ?>;
        var user_id = <?php if(isLoggedIn()){
            echo $user_id; }else{
                echo 'false';
            }    
            ?>;


         $('.like').click(function(){

                
        //LIKE 
        //

            $.ajax({

                url:"post.php?p_id= <?php echo $the_post_id; ?>",
                type: 'POST',
                data: {
                    'liked': 1,
                    'post_id': post_id,
                    'user_id': user_id
                }

            });

        }); 

        //UNLIKE
        

        $('.unlike').click(function(){

                      
            $.ajax({

                url:"post.php?p_id=<?php echo $the_post_id; ?>",
                type: 'POST',
                data: {
                    'unliked': 1,
                    'post_id': post_id,
                    'user_id': user_id
                }

            });

        });
        
   

});

</script>