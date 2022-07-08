<?php
session_start();
include("connection.php");

$boolean = $_SESSION['boolean'];
if($boolean){
    $ID = $_GET['id'];

    $sql = 'SELECT * FROM log';
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()){
        if(password_verify($row['ID'], $ID)){
            $query = "SELECT * FROM log WHERE ID= ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('i', $row['ID']);
            $stmt->execute();
            $row = $stmt->get_result();
            $user = $row->fetch_assoc();
            $ID = $user['ID']; 
        }
    }
    
    $_SESSION['boolean'] = false;
    $_SESSION['ID'] = $ID;

}


if(isset($_POST['delete'])){

    $ID = $_SESSION['ID'];
    $q1 = "SELECT * FROM usermessage WHERE ID= ?";
    $s1 = $conn->prepare($q1);
    $s1->bind_param('i', $ID);
    $s1->execute();
    $r1 = $s1->get_result();
    $message = $r1->fetch_assoc(); 

    $q3 = "DELETE FROM repmessage WHERE messageID= ?";
    $s3 = $conn->prepare($q3);
    $s3->bind_param('i', $message['messageID']);
    $s3->execute();

    $q4 = "DELETE FROM usermessage WHERE ID= ?";
    $s4 = $conn->prepare($q4);
    $s4->bind_param('i', $ID);
    $s4->execute();

    $q5 = "DELETE FROM info WHERE ID=?";
    $s5 = $conn->prepare($q5);
    $s5->bind_param('i', $ID);
    $s5->execute();

    $q6 = "DELETE FROM log WHERE ID=?";
    $s6 = $conn->prepare($q6);
    $s6->bind_param('i', $ID);
    $s6->execute();

    header('Location: hr.php');
    die();
}

if(isset($_POST['back'])){
    header('Location: hr.php');
    die();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="delete.css">
    <title>Delete User</title>
</head>
<body>
    <div class="container py-lg-5">
        <div class="alert alert-danger py-5" role="alert">
            <h1 class="alert-heading">Be Carful !!!</h1>
            <h5>If you click on the delete button, the account of this user, including all data related to him, will be deleted.</h5>
            <hr>
            <h6 class="mb-0">If you want to cancel the process, press the back button.</h6>
        </div>
        <div class="row">
            <div class="col-xl-10"></div>
            <div class="col-xl-2">
                <form action="delete.php" method="POST">
                    <input class="btn btn-info" type="submit" value="Back" name="back" style="font-size: 120%;">
                    <input class="btn btn-danger" type="submit" value="Delete" name="delete" style="font-size: 120%;">
                </form>
            </div>

        </div>
    </div>
    <script src="bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
</body>
</html>