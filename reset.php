<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php include "includes/navigation.php"; ?>


<?php 
    
    

    if(!isset($_GET['email']) && !isset($_GET['token'])){

        redirect('index');
    }
    
    
    
    // $token = '203f37d34d44d43ad2415089932c6bc0dfd6238fc8f9ef2982def3ecd0e55b38b15920701b3ccd7b2f4683d9fb3a3d6f988f'; 
    
    // $email = "sad@aase.se";

    $message = '';
    
    if($stmt = mysqli_prepare($connection, 'SELECT username, user_email, token FROM users WHERE token = ? ')){

        mysqli_stmt_bind_param($stmt, "s", $token);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_bind_result($stmt, $username, $user_email, $_GET['token']);

        mysqli_stmt_fetch($stmt);

        mysqli_stmt_close($stmt);

        // if($_GET['token'] !== $token || $_GET['email'] !== $email){
        //     redirect('index');
        // }
        // 
        
        if(isset($_POST['password']) && isset($_POST['confirmPassword'])){

            if(!empty($_POST['password']) || !empty($_POST['confirmPassword'])){

            if($_POST['password'] == $_POST['confirmPassword']){

            $message = "<h3>Your password has been changed.</h3>";

            $password = $_POST['password'];
            $password = trim($password);
            $password = mysqli_real_escape_string($connection, $password);

            $query = "SELECT randSalt from users ";
            $select_randsalt_query =  mysqli_query($connection, $query); 
            
            $row = mysqli_fetch_array($select_randsalt_query);
            $salt = $row['randSalt'];
            $password = crypt($password, $salt);

            if($stmt = mysqli_prepare($connection, "UPDATE users SET token='', user_password='{$password}' WHERE user_email = ? ")){

                mysqli_stmt_bind_param($stmt, "s", $_GET['email']);
                mysqli_stmt_execute($stmt);

                if(mysqli_stmt_affected_rows($stmt) >= 1){
                   redirect('login.php');

                }

                mysqli_stmt_close($stmt);
                

            }


            }else { 

                $message = "<h3>Please make sure password match. </h3>";


            } 

        }else{
            $message = "<h3>Fileds can't be empty. </h3>";
        }

      }  
        

    }    


 ?>



<!-- Page Content -->


<div class="container">

    

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">

                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">

                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
                                                <input id="password" name="password" placeholder="enter new password" class="form-control"  type="password">
                                            </div>
                                            <br>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
                                                <input id="confirmPassword" name="confirmPassword" placeholder="confirm password" class="form-control"  type="password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- Body-->

                                <?php echo $message; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->

