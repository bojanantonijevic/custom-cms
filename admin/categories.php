<?php include "includes/header.php"; ?>


    <div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/navigation.php"; ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">
                                Set Categories
                                <small>(<?php echo strtoupper($_SESSION['username']); ?>)</small>
                            </h1>
                            

                            <!-- BREADCRUMBS -->
                            <!-- <ol class="breadcrumb">
                                <li>
                                    <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                                </li>
                                <li class="active">
                                    <i class="fa fa-file"></i> Blank Page
                                </li>
                            </ol> -->

                            
                            <div class="col-xs-6">

                                <?php insert_categories(); ?>

                                <form action="" method="post">
                                    <div class="form-group">
                                        <label for="cat-title">Add A Category</label>
                                        
                                        <input class="form-control" type="text" name="cat_title">
                                    </div>

                                    <div class="form-group">
                                    
                                        <input class="btn btn-primary" type="submit" name="submit" value="Add Category">
                                    </div>

                                </form>

                                <!-- UPDATE and Include -->
                                <?php 
                                    if(isset($_GET['update'])){
                                        $cat_id = escape($_GET['update']);
                                        include "includes/update.php";    
                                    }
                                ?>
                            </div>

                            <div class="col-xs-6">
                            

                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <th>ID</th>
                                        <th>Categoty Title</th>
                                    </thead>
                                    <tbody>
                                        <!-- find all categories -->

                                        <?php  findAllCategories(); ?>
                                        <!-- delete category -->
                                        <?php deleteCategory(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

<?php include "includes/footer.php" ?>