<?php

use Exception;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;

require("connection.php");


function sendMail($email,$reset_token){
    require_once('PHPMailer/PHPMailer.php');
    require_once('PHPMailer/SMTP.php');
    require_once('PHPMailer/Exception.php');

    $mail = new PHPMailer(true);
    try {
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER; 
        $mail->isSMTP();                                            
        $mail->Host       = 'smtp.gmail.com';                     
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = 'your email ';                     
        $mail->Password   = 'put your email the passwprd';                              
        $mail->Port       = 465; #587   465   25   2525                           
    
        
        $mail->setFrom('alihamed.cg@gmail.com', 'Ali web');
        $mail->addAddress($email);     
    
        
        $mail->isHTML(true);                                  
        $mail->Subject = 'Password reset';
        $mail->Body    = "we got a request from you to reset your password <br> 
                            Click the link below: <br>
                            <a href='https://localhost/Newfolder/updatepassword.php?email= $email &reset = $reset_token'>Reset Password</a>";
    
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

if(isset($_POST['send'])){
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $query = 'SELECT * FROM login WHERE email=?';

    $stmt = $conn->prepare($query);

    $stmt->bind_param('s', $email);

    $stmt->execute();

    $result = $stmt->get_result();
    
    if($result){
        if(mysqli_num_rows($result)==1){
            $reset_token = bin2hex(random_bytes(16));
            date_default_timezone_set('Asia/Kolkata');
            $date = date("Y-m-d");
            $query ="UPDATE login SET resett='$reset_token', reset_ex='$date' WHERE email = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('s', $email);
            $stmt->execute();
            sendMail($email,$reset_token);
            if($stmt->execute()&& sendMail($email,$reset_token)){  #&& sendMail($email,$reset_token)
                echo "<script>
                alert('done please check your email....')
                window.location.href=''
                </script>";
            }else{
                echo "<script>
                alert('server down! try again later')
                window.location.href=''
                </script>";
            }
        }else{
            echo "<script>
                alert('Email not found')
                window.location.href=''
                </script>";
        }
    }else{
        echo "<script>
            alert('can not run query')
            window.location.href=''
            </script>";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="forgot_pass.css">
    <title>Forgot Password</title>
</head>
<body>
    <div class="container py-5">
        <div class="row py-5">
            <div class="col-xl-6 offset-xl-2 py-5">
                <div class="form-group">
                    <form action="forgot_pass.php" method="POST">
                        <h2>
                            <span>
                                Reset Password
                            </span>
                            <button type="reset" id="btn1"><a href="">X</a></button>
                        </h2>
                        <input type="text" placeholder="email" name="email"><br><br>
                        <button type="submit" class="reset-btn" name="send"id="btn2">Send Link</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>