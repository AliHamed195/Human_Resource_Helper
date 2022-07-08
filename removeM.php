<?php
session_start();
include("connection.php");

$true = $_SESSION['true'];

if($true){
    $ID = $_GET['id'];
    $_SESSION['true'] = false;
    $_SESSION['num'] = $ID;
}

if(isset($_POST['delete'])){
    $ID = $_SESSION['num'];
    $query = "DELETE FROM usermessage WHERE messageID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $ID);
    $stmt->execute();

    $q2 = "DELETE FROM repmessage WHERE messageID = ?";
    $s2 = $conn->prepare($q2);
    $s2->bind_param('i', $ID);
    $s2->execute();

    if($_SESSION['ID'] != null || $_SESSION['ID'] != 0){
        header('Location: secondpage.php');
        die();
    }else{
        header('Location: hr.php');
        die();
    }
}

if(isset($_POST['back'])){
    if($_SESSION['ID'] != null || $_SESSION['ID'] != 0){
        header('Location: secondpage.php');
        die();
    }else{
        header('Location: hr.php');
        die();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <title>Document</title>
</head>
<body>
    <div class="container py-5">
        <div class="alert alert-danger py-5">
            <h1>Be Carful !!!!</h1>
            <h5>By deleteing this message you are delete all the replaies also. <br> the other party will not be able to see the message or to replay to it anymore.</h5>
            <hr>
            <h6>If you want to cancel this prosses press on the back button.</h6>
        </div>
        <div class="row">
            <div class="col-xl-9"></div>
            <div class="col-xl-2">
                <form action="removeM.php" method="POST">
                    <input class="btn btn-info" type="submit" name="back" value="Back">
                    <input class="btn btn-danger" type="submit" name="delete" value="Delete">
                </form>
            </div>
        </div>
    </div>
    <script src="bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
</body>
</html>