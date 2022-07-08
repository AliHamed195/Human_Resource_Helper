<?php

include("connection.php");
session_start();
$b = 0;
$g = 0;
$e = 0;
$nulls = false;
$_SESSION['boolean'] = true;
$_SESSION['true'] = true;
$_SESSION['ID'] = 0;
$table= 0;
function loop($user,$sl,$table) {
    $count = 0;
    while($row = $user->fetch_assoc()){
        $sl++;
        $pass = password_hash($row['ID'], PASSWORD_DEFAULT);
    echo'<tr>
        <td>'. $sl.'</td>
        <td>'. $row['namee'].'</td>
        <td>'. $row['email'].'</td>
        <td style="display: flex ;">
            <a href="seemore.php?id='.$pass.'" ><input class= "btn btn-primary btn-lm" type="submit" value="see more" name="seeMore"></a>
            <a style="margin-left: 2%;" href="delete.php?id='.$pass.'"><input class= "btn btn-danger btn-lm" type="submit" value="Delete" name="delete"></a>
        </td>
    </tr>';
        }
        $count = $sl;
        if( $table == 1){
            echo'<tr><td></td></tr>
            <tr>
                <td id="tdf">Total :</td>
                <td id="tdf">'. $count.'</td>
            </tr> ';
        }
        
        
            $table= 0;
    }

if(isset($_POST['out'])){
    header('Location: Home.php');
    session_destroy();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="hr.css">
    <title>HR Page</title>
</head>
<body>

    <div class="container">
        <div class="row py-3">
            <div class="col-xl-1">
                <form action="hr.php" method="POST">
                    <input class= "btn btn-danger btn-lm" type="submit" value="Log out" name="out">
                </form>
            </div>
        </div>
        <div class="row py-1" style="text-align: center;">
            <div class="col-xl-12 mx-auto py-1">
                <h1>Welcome To The HR Page</h1>
            </div>
        </div>
        
        <div class="row py-3">
            <form action="hr.php" method="GET" style="display: flex;">
                <div class="col-xl-2">
                    <h3 style="color: brown;">Search Option</h3>
                </div>
                <div class="col-xl-3">
                    <label for="GPA">GPA :</label>
                    <input style="width: 60%;" type="number" name="GPA" min="1" max="4">
                    <input class="btn btn-success" type="submit" name="subgpa" value="GO">
                </div>
                <div class="col-xl-4">
                    <label for="experience">Experience :</label>
                    <input style="width: 60%;" type="number" name="experience">
                    <input class="btn btn-success" type="submit" name="subexp" value="GO">
                </div>
                <div class="col-xl-2">
                    <input class="btn btn-success" type="submit" name="both" value="Search for Both">
                </div>
                <div class="col-xl-1">
                        <input class="btn btn-success" type="submit" name="reset" value="Reset">
                </div>
            </form>
        </div>
        <div class="row py-3">
            <div class="table-responsive py-4" style="border: 1px solid black;">
                <table class="table table-bordered">
                    <div class="row">
                        <form action="hr.php" method="GET">
                            <div class="col-xl-8" style="display: flex;">
                                <div class="col-xl-3" style="margin-right: 2%;">
                                    <div class="active-cyan-3 active-cyan-4 mb-4">
                                        <input class="form-control" type="text" name="namesearch" placeholder="Search By Name" aria-label="Search">
                                    </div>
                                </div>
                                <div class="col-xl-2">
                                    <input class="btn btn-outline-secondary" type="submit" name="search" value="Search">
                                </div>
                            </div>
                        </form>
                    </div>
                    <thead>
                        <tr>
                        <th scope="col">Register Number</th>
                        <th scope="col">Nmae</th>
                        <th scope="col">Email</th>
                        <th scope="col">More Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(isset($_GET['both'])){
                                $g = 0;
                                $e= 0;
                                $b = 1;
                                $exp = $_GET['experience'];
                                $gpa = $_GET['GPA'];
                                if(is_null($exp)||is_null($gpa)){
                                    echo '<script>alert("Please enter number")</script>';
                                }else{
                                    $exp = filter_var($exp, FILTER_SANITIZE_NUMBER_INT);
                                    $gpa = filter_var($gpa, FILTER_SANITIZE_NUMBER_FLOAT);
                                    $sl=0;
                                    $sql = "SELECT * FROM info where experiance = $exp AND GPA = $gpa";
                                    $stmt = $conn->query($sql);  
                                    $r = $stmt->fetch_assoc();
                                    if(is_null($r)){
                                         $nulls = true;
                                    }else{
                                        $nulls = false;
                                        $sql = 'SELECT * FROM log where ID = ?';
                                        $stmt = $conn->prepare($sql);  
                                        $stmt->bind_param('i', $r['ID']);
                                        $stmt->execute();
                                        $user = $stmt->get_result();
                                    }

                                }
                            }else if(isset($_GET['subexp'])){
                                    $b = 0;
                                    $g = 0;
                                    $e= 1;
                                    $nulls = false;
                                    $exp = $_GET['experience'];
                                    if(is_null($exp)){
                                        echo '<script>alert("Please enter number")</script>';
                                    }else{
                                        $exp = filter_var($exp, FILTER_SANITIZE_NUMBER_INT);
                                        $sl=0;
                                        $sql = 'SELECT * FROM info where experiance >= ?';
                                        $stmt = $conn->prepare($sql);  
                                        $stmt->bind_param('i', $exp);
                                        $stmt->execute();
                                        $userr = $stmt->get_result();
                                    }

                            }else if(isset($_GET['subgpa'])){
                                    $b = 0;
                                    $e= 0;
                                    $g = 1;
                                    $nulls = false;
                                    $gpa = $_GET['GPA'];
                                    if(is_null($gpa)){
                                        echo '<script>alert("Please enter number")</script>';
                                    }else{
                                        $gpa = filter_var($gpa, FILTER_SANITIZE_NUMBER_FLOAT);
                                        $sl=0;
                                        $sql = 'SELECT * FROM info where GPA >= ?';
                                        $stmt = $conn->prepare($sql);  
                                        $stmt->bind_param('i', $gpa);
                                        $stmt->execute();
                                        $userr = $stmt->get_result();
                                    }

                            }else if(isset($_GET['search'])){
                                    $nulls = false;
                                    $name=$_GET['namesearch'];
                                    if($name == ''){
                                        echo '<script>alert("Please enter number")</script>';
                                    }else{
                                        $name = filter_var($name, FILTER_SANITIZE_STRING);
                                        $sl=0;
                                        $sql = "SELECT * FROM log where namee LIKE '%$name%' OR namee = ?";
                                        $stmt = $conn->prepare($sql);  
                                        $stmt->bind_param('s', $name);
                                        $stmt->execute();
                                        $user = $stmt->get_result();
                                    }
                            }else if(isset($_GET['reset']) || !isset($_GET['reset'])){
                                $nulls = false;
                                $sl=0;
                                $sql = 'SELECT * FROM log';
                                $user = $conn->query($sql);
                            }
                            if($nulls){

                            }else{
                                    if($e == 1 ^ $g == 1){
                                    while($r = $userr->fetch_assoc()){
                                        $sql = 'SELECT * FROM log where ID = ?';
                                        $stmt = $conn->prepare($sql);  
                                        $stmt->bind_param('i', $r['ID']);
                                        $stmt->execute();
                                        $user = $stmt->get_result(); 
                                        loop($user,$sl,$table);
                                    }
                                }else{
                                    $table= 1;
                                    loop($user,$sl,$table);
                                }
                            }
                            ?>  
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row py-3">
            <div class="row py-3 scrolll" id="scrolll">
                <?php
                $sql = 'SELECT * FROM usermessage';
                $user = $conn->query($sql);
                while($row = $user->fetch_assoc()){
                ?>
                <div class="row py-2" style="margin:auto; margin-bottom: 4px;">
                <div class="col-xl-12 py-2">
                    <div class="row py-1">
                        <div class="col-xl-3">
                            <p><?php echo $row['name'];?></p>
                        </div>
                        <div class="col-xl-5">
                        </div>
                        <?php
                        echo '<div class="col-xl-4">
                            <a href="replay.php?id='.$row['messageID'].'" class="btn btn-outline-primary">View & Reply</a>
                            <a href="removeM.php?id='.$row['messageID'].'" class="btn btn-outline-danger">End Discussion</a>
                            </div>';
                        ?>  
                    </div>
                    <div class="row ">
                        <div class="col-xl-12" style="text-align: center;">
                            <h3><?php echo $row['subject'];?></h3><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12" style="text-align: center;">
                            <p><?php echo $row['message'];?></p>
                        </div>
                    </div>
                </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    
    <script src="bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
</body>
</html>

