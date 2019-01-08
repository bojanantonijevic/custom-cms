<?php
ob_start();
include('includes/db.php');
include('includes/header.php');
session_start();
?>



    <!-- Navigation -->
<?php 
include("includes/navigation.php");
?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <?php
            include("includes/blog_content.php");
            ?>

            <!-- Blog Sidebar Widgets Column -->
            <?php
            include("includes/sidebar.php");
            ?>

        </div>
        <!-- /.row -->

        <hr>

        
<?php
include("includes/footer.php");
?>