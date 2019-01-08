<div class="col-md-4">

                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    
                <form action="search.php" method="post">
                <div class="input-group">
                        <input name="search" type="text"  class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-default" name ="submit" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>
                </form><!-- search form ends here -->
                    <!-- /.input-group -->
                </div>


                <!-- login -->
                <div class="well">
                <?php if(isset($_SESSION['user_role'])) : ?>
                    <h4> You're logged in as <?php echo strtoupper($_SESSION['username']) ;?></h4>
                    <a href="includes/logout.php" class="btn btn-primary">Logout</a>

                <?php else : ?>

                    <h4>Login</h4>
                    <form action="login.php" method="post">
                    <div class="form-group">
                    
                    <input name="username" type="text"  class="form-control" placeholder="Enter Username">
                        
                    </div>

                    <div class="input-group">
                    
                    <input name="password" type="password"  class="form-control" placeholder="Enter Password">
                    <span class="input-group-btn">

                        <button class="btn btn-primary" name="login" type="submit">Login</button>
                     
                    </span>
                        
                    </div>
                    
                    <div class="form-group">
                        
                    <a href="forgot.php?forgot= <?php echo uniqid(true); ?>">Forgot Password</a>


                    </div>      



                </form><!-- search form ends here -->

                <?php  endif; ?>



                    
                    <!-- /.input-group -->
                </div>





                   

                <!-- Blog Categories Well -->
                <div class="well">

                     <?php
                        $query = "SELECT * FROM categories";
                        $select_categories_sidebar = mysqli_query($connection, $query);
                        
                    ?>

                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                                <?php 
                                    while($row = mysqli_fetch_assoc($select_categories_sidebar)){

                                    $cat_id = $row['id'];    
                                    $cat_title = $row['cat_title'];

                                    echo "<li><a href='category.php?category=$cat_id'>{$cat_title}</a></li>";
                                }
                                ?>
                            </ul>
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.col-lg-6 -->
                    </div>
                    <!-- /.row -->
                </div>

                <!-- Side Widget Well -->
                <?php include "widget.php"; ?>

            </div>