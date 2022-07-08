<?php
session_start();
include("connection.php");
$_SESSION['true'] = true;
$_SESSION['ID'] = 0;
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
    }
}

$query = 'SELECT * FROM info WHERE ID=?';
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user['ID']);
$stmt->execute();
$row = $stmt->get_result();
$inf = $row->fetch_assoc();


if(isset($_POST['back'])){
    header('Location: hr.php');
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="seemore.css">
    <title>User Information</title>
</head>
<body>
    <div class="container">
        <div class="row py-5" style="text-align: center;">
            <div class="col-xl-12 mx-auto py-1">
                <h1>User Information</h1>
            </div>
        </div>
        <div class="row">
            <div class="table-responsive py-4">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                        <th scope="col">User ID</th>
                        <th scope="col">User Name</th>
                        <th scope="col">User Email</th>
                        </tr>
                    </thead>
                    <tbody>
            
                        <tr>
                            <td><?php echo $user['ID'];?></td>
                            <td><?php echo $user['namee'];?></td>
                            <td><?php echo $user['email'];?></td>
                        </tr> 
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="table-responsive py-4">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                        <th scope="col">User Age</th>
                        <th scope="col">User Phone</th>
                        <th scope="col">User City</th>
                        <th scope="col">User University</th>
                        </tr>
                    </thead>
                    <tbody>
            
                        <tr>
                            <td><?php echo $inf['age'];?></td>
                            <td><?php echo $inf['phone'];?></td>
                            <td><?php echo $inf['city'];?></td>
                            <td><?php echo $inf['university'];?></td>
                        </tr> 
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="table-responsive py-4">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                        <th scope="col">User Major</th>
                        <th scope="col">User GPA</th>
                        <th scope="col">User Experience</th>
                        <th scope="col">User Expected Salary</th>
                        </tr>
                    </thead>
                    <tbody>
            
                        <tr>
                            <td><?php echo $inf['major'];?></td>
                            <td><?php echo $inf['GPA'];?></td>
                            <td><?php echo $inf['experiance'];?></td>
                            <td><?php echo $inf['salery'];?></td>
                        </tr> 
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row py-2">
            <form action="seemore.php" method="POST">
                <input class="btn btn-outline-secondary" type="submit" value="Back to the your page" name="back" style="font-size: x-large; width:100%;">
            </form>
        </div>
        <div class="row py-2">
            <h3>User Messages :</h3>
        </div>
        <div class="row py-3">
            <div class="col-xl-12 py-4" id="scrolll">
                <?php
                    $sql = "SELECT * FROM usermessage where ID = $user[ID]";
                    $use = $conn->query($sql);
                    while($row = $use->fetch_assoc()){
                ?>
                <div class="row py-2">
                    <div class="col-xl-12 py-2" style="border: 1px solid black;">
                        <div class="row py-1">
                            <div class="col-xl-1"></div>
                            <div class="col-xl-3">
                                <p><?php echo $row['name'];?></p>
                            </div>
                            <div class="col-xl-3">
                            </div>
                            <div class="col-xl-4">
                            <?php
                                echo '
                                    <a href="replay.php?id='.$row['messageID'].'" class="btn btn-outline-primary">View & Reply</a>
                                    <a href="removeM.php?id='.$row['messageID'].'" class="btn btn-outline-danger">End Discussion</a>';
                            ?>
                            </div>
                        </div>
                        <div class="row" style="text-align: center;">
                            <div class="col-xl-3">
                                <h3><?php echo $row['subject'];?></h3>
                            </div>
                        </div>
                        <div class="row" style="text-align: center;">
                            <div class="col-xl-12">
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