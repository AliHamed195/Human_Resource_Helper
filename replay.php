<?php
session_start();
include("connection.php");

$true = $_SESSION['true'];
if($true){
    $ID = $_GET['id'];
    $_SESSION['true'] = false;
    $_SESSION['num'] = $ID;

}

$query = 'SELECT * FROM usermessage WHERE messageID = ?';
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $_SESSION['num']);
$stmt->execute();
$row = $stmt->get_result();
$user = $row->fetch_assoc();

if(isset($_GET['back'])){
    if($_SESSION['ID'] != null || $_SESSION['ID'] != 0){
        header('Location: secondpage.php');
        die();
    }else{
        header('Location: hr.php');
        die();
    }
}

if(isset($_GET['send'])){
    $m = $_GET['rep'];

    if($m == ""){
        echo '<script>alert("Please write message first")</script>';
    }else{
        $m = filter_var($m, FILTER_SANITIZE_STRING);

        $q = 'SELECT * FROM log WHERE ID=?';
        $s = $conn->prepare($q);
        $s->bind_param('i', $user['ID']);
        $s->execute();
        $r = $s->get_result();
        $u = $r->fetch_assoc();
    
        if($_SESSION['ID'] != 0){
            $sql_query = "INSERT INTO repmessage(messageID, name, message,email) VALUES(?,?,?,?)";               
            $s3 = $conn->prepare($sql_query);                          
            $s3->bind_param('isss', $user['messageID'], $user['name'], $m,$u['email']);               
            $s3->execute();
        }else{
            $email = 'Admin';
            $sql_query = "INSERT INTO repmessage(messageID, name, message,email) VALUES(?,?,?,?)";               
            $s3 = $conn->prepare($sql_query);                          
            $s3->bind_param('isss', $user['messageID'], $user['name'], $m,$email);               
            $s3->execute();
        }
    
         
    
        header('Location: replay.php');
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
	<link rel="stylesheet" type="text/css" href="replay.css">
    <title>Replay</title>
</head>
<body>
    <div class="container py-3">
        <div class="row">
            <h1>All Descution Messages :</h1>
        </div>
        <div class="row card">
            <div class="row">
                <div class="col-xl-2">
                    <h5>Main Message :</h5>
                </div>
                <div class="col-xl-8"></div>
                <div class="col-xl-2">
                    <h5><?php echo $user['name'];?></h5>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12" style="text-align: center;">
                    <h6><?php echo $user['subject'];?></h6>
                    <p><?php echo $user['message'];?></p>
                </div>
            </div>
        </div>
        <div class="row py-2">
            <div class="col-xl-12">
                <div class="scroll card">
                    <?php
                        $q2 = 'SELECT * FROM repmessage WHERE messageID = ?';
                        $s2 = $conn->prepare($q2);
                        $s2->bind_param('i', $user['messageID']);
                        $s2->execute();
                        $r2 = $s2->get_result();

                    while($u2 = $r2->fetch_assoc()){

                    if($u2['repID'] != null && $u2['email'] == ''){
                        echo"
                            <h6>Admin</h6>
                            <p>".$u2['message']."</p>
                            ";
                    }else{
                        echo"
                            <h6>".$u2['email']."</h6>
                            <p>".$u2['message']."</p>
                            ";
                    }

                    }
                    ?>
                </div>
            </div>
        </div>
        <form action="replay.php" action="GET">
            <div class="row">
                    <textarea type="text" name="rep" id="rep" rows="3" placeholder="Your message" style="font-size: 140%;"></textarea>
            </div>
            <div class="row py-2">
                <div class="col-xl-1">
                    <input class="btn btn-success" type="submit" name="send" value="Send" style="font-size: 140%; width:140px;" >
                </div>
            </div>
        </form>
    </div>
    <hr>
    <div class="container">
        <div class="row">
            <div class="col-xl-10"></div>
            <div class="col-xl-2">
                <form action="replay.php" action="GET">
                    <input class="btn btn-primary" type="submit" name="back" value="Back" style="font-size: 140%; width:140px;" >
                </form>
            </div>
        </div>
    </div>
    <script src="bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
</body>
</html>