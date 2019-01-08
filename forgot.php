<?php session_start(); ?>
<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php include "admin/functions.php"; ?>

<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/autoload.php';
require './classes/config.php';

    if(!ifItIsMethod('get') && !isset($_GET['forgot'])){

        redirect('index');
    }

    if(ifItIsMethod('post')){

        if(isset($_POST['email'])){
            $email = trim($_POST['email']);

            $length = 50;

            $token = bin2hex(openssl_random_pseudo_bytes($length));

            if(email_exists($email)){
               
                if($stmt = mysqli_prepare($connection, "UPDATE users SET token='{$token}' WHERE user_email= ? ")){

                mysqli_stmt_bind_param($stmt,"s", $email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                //configure PHP MAILER
                //
                //
                //
                //configure PHP MAILER
                //
                try {
                $mail = new PHPMailer(true);
                                
                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = config::SMTP_HOST;  // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = config::SMTP_USERNAME;                 // SMTP username
                $mail->Password = config::SMTP_PASSWORD;                           // SMTP password
                $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = config::SMTP_PORT;  
                $mail->isHTML(true);  
                $mail->CharSet = 'UTF-8';

                $mail->setFrom('boki@live.com', 'Bojan PHP');
                $mail->addAddress($email);
                $mail->Subject = 'This is a test email';
                $mail->Body ='<p>Please click to reset your password

                <a href="http://localhost/cms/reset.php?email='.$email.'&token='.$token.'">href="http://localhost/cms/reset.php?email='.$email.'&token='.$token.'"</a>

                </p>';

                if($mail->send()){
                    $emailsent = true;
                }else{
                    echo "Not sent!!!!";
                }

            } catch (Exception $e){
                echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
            }

              
            }


        }

    }
}    


 ?>


<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">


                                <?php if(!isset($emailsent)): ?>


                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">




                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="email" name="email" placeholder="email address" class="form-control"  type="email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div>

                            <?php else: ?>

                                <h4>Please check your email</h4>
                            <?php endif; ?>

                                

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->

