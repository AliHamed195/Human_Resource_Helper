<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Update</title>

    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-decoration: none;
            font-family: poppins;
        }

        form{
            background-color: #f0f0f0;
            width: 350px;
            border-radius: 5px;
            padding: 20px 25px 30px 25px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
        }

        form h3{
            margin-bottom: 15px;
        }

        form input{
            width: 100%;
            margin-bottom: 20px;
            background-color: transparent;
            border: none;
            border-bottom: 2px solid black;
            border-radius: 0;
            padding: 5px 0;
            font-weight: 550;
            font-size: 14px;
            outline: none;
        }

        form button{
            font-weight: 550;
            font-style: 15px;
            color: aliceblue;
            background-color: brown;
            padding: 4px 10px;
            border: none;
            outline: none;
        }
    </style>
</head>
<body>
    
    <?php
    
    require('connection.php');

    if(isset($_GET['email']) && isset($_GET['reset'])){
        date_default_timezone_set('Asia/Kolkata');
        $date = date("Y-m-d");
        $query ="SELECT * FROM login WHERE 'email'=$_GET[email] AND 'reset'=$_GET[reset] AND 'reset ex' = $date";
        $result = mysqli_query($conn,$query);
        if($result){
            if(mysqli_num_rows($result)==1){
                
            }else{
                echo
                "
                <form method='POST'>
                <h3>create new password</h3>
                <input type='password' placeholder='new password' name='password'><br><br>
                <button type='submit' name='updatepassword'>Update</button>
                <input type='hidden' name='email' value='$_GET[email]'>
                </form>
                ";
            }
        }else{
            echo "<script>
                alert('Invalid or expierd link')
                window.location.href=''
                </script>";
        }
    }
    
    ?>


    <?php
    
    if(isset($_POST['updatepassword'])){
        $email = $_POST['email'];
        $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $query ="UPDATE login SET 'passwordd'=$pass , `reset`=NULL,`reset ex`=NULL WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();

        if($stmt->execute()){
            echo "<script>
                alert('Password Updated successfully')
                window.location.href=''
                </script>";
        }else{
            echo "<script>
                alert('Invalid or expierd link')
                window.location.href=''
                </script>";
        }
    }
    
    ?>

</body>
</html>