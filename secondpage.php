<?php
session_start();
$_SESSION['true'] = true;
include("connection.php");

$query = "SELECT * FROM info WHERE ID= ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $_SESSION['ID']);
$stmt->execute();
$row = $stmt->get_result();
$userr = $row->fetch_assoc();
$ID= $userr['ID'];
$city = $userr['city'];
$age = $userr['age'];
$phone = $userr['phone'];
$major = $userr['major'];
$GPA=$userr['GPA'];
$university = $userr['university'];
$experiance = $userr['experiance'];
$salery= $userr['salery'];


if(isset($_POST['save'])){
    $ID= $userr['ID'];
    $city1 = $_POST['city'];
    $age1 = $_POST['age'];
    $phone1 = $_POST['phone'];
    $major1 = $_POST['major'];
    $GPA1=$_POST['GPA'];
    $university1 = $_POST['university'];
    $experiance1 = $_POST['experiance'];
    $salery1= $_POST['salery'];


    $city1 = filter_var($city1, FILTER_SANITIZE_STRING);
    $age1=filter_var($age1, FILTER_SANITIZE_NUMBER_INT);
    $phone1=filter_var($phone1, FILTER_SANITIZE_STRING);
    $major1=filter_var($major1, FILTER_SANITIZE_STRING);
    $GPA1=filter_var($GPA1, FILTER_SANITIZE_NUMBER_FLOAT);
    $university1=filter_var($university1, FILTER_SANITIZE_STRING);
    $experiance1= filter_var($experiance1, FILTER_SANITIZE_NUMBER_INT);
    $salery1=filter_var($salery1, FILTER_SANITIZE_NUMBER_INT);


    $query ="UPDATE `info` SET `city`='$city1', `age`='$age1',`phone`='$phone1',`major`='$major1',`GPA`='$GPA1',`university`='$university1',`experiance`='$experiance1',`salery`='$salery1' WHERE ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $_SESSION['ID']);
    $stmt->execute();

    if($stmt){
        header("Location: secondpage.php");
    }else{
        echo "<script>
            alert('Server Down!! Please try again later')
            </script>";
    }
}

if(isset($_POST['out'])){
    header("Location: Home.php");
    session_destroy();
}


if(isset($_POST['send'])){
    date_default_timezone_set('Asia/Kolkata');
    $date = date("Y-m-d");
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $subject = filter_var($subject, FILTER_SANITIZE_STRING);
    $message = filter_var($message, FILTER_SANITIZE_STRING);

    $query = 'SELECT * FROM log WHERE ID=?';
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $_SESSION['ID']);
    $stmt->execute();
    $row = $stmt->get_result();
    $user = $row->fetch_assoc();

    $name = $user['namee'];
    $ID = $userr['ID'];

    $sql_query = "INSERT INTO usermessage(ID, name, subject,message,usermdate) VALUES(?,?,?,?,?)";                
    $stmt = $conn->prepare($sql_query);                            
    $stmt->bind_param('issss',$ID ,$name,$subject,$message,$date);               
    $stmt->execute(); 

    if($stmt){
        header("Location: secondpage.php");
    }else{
        echo "<script>
            alert('Server Down!! Please try again later')
            </script>";
    }

}

?>

<style>
    h1{
        
    }
</style>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="secondpage.css">
	<title>Second Page</title>

    <style>
        .message{
            display: none;
            z-index: 100000000;
            position: absolute;
            left: 30%;
            top: 60%;
            transform: translate(-10%,-70%);
            padding: 1%;
            background-color: gray;
            height: fit-content;
            border: 10px solid black;
        }
        .options{
            display: flex;
        }
        #l0{
            cursor: pointer;
        }
        #cansel{
            margin-left: 20px;
        }
        #sub{
            width: 60%;
            height: 50px;
        }
        .msms{
            border: 3px solid black;
            margin-bottom: 3%;
        }
    </style>
</head>
<body>
	<div class="bd">
        <div class="navbar">
            <img src="photos/55.png" class="logo">
            <nav>
                <ul id="menulist">
                    <li><a href="Home.php">Home</a></li>
                    <li><a href="about.php">About As</a></li>
                    <li id="l0" onclick="view()"><a>Contact Us</a></li>
                    <li><a href="Login.php">Sign Up</a></li>
                </ul>
            </nav>
            <img src="photos/11.png" class="menu-icon" onclick="togglemenu()">
        </div>
    </div>
    <div class="message" id="mmm">
        <h3>Please write for us :</h3>
        <form action="secondpage.php" method="POST">
            <div class="details">
                <input id="sub" type="text" name="subject" placeholder="Subject"><br><br>
                <textarea name="message" id="message" cols="110" rows="10" placeholder="Your Message"></textarea>
            </div>
            <div class="options">
                <input class="btn1" type="submit" name="send" value="Send">
                <button class="btn1" id="cansel" onclick="hide()">Cansle</button>
            </div>
        </form>
    </div>
    <section class="contact">
        <div class="container">
            <div class="row py-5">
                <div class="col-xl-10 mx-auto py-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="head text-center text-white py-3">
                                        <h3>Your Information</h3>
                                    </div>
                                </div>
                            </div>
                            <form action="secondpage.php" method="POST">
                                <div class="form p-3">
                                    <div class="form-row my-5">
                                        <div class="r1">
                                            <div class="col-lg-4">
                                                <label for="City">City :</label> 
                                                <input class="effect-1" type="text" id="City" name="city" value="<?php echo (isset($city))?$city:'';?>" required />
                                                <span class="Focus-border"></span>
                                            </div>
                                            <div class="col-lg-4">
                                                <label for="name">Your age :</label>
                                                <input class="effect-1" type="number" id="age" name="age" value="<?php echo (isset($age))?$age:'';?>" required/>
                                                <span class="Focus-border"></span>
                                            </div>
                                            <div class="col-lg-4">
                                                <label for="name">Phone number :</label> 
                                                <input class="effect-1" type="text" id="phone" name="phone" value="<?php echo (isset($phone))?$phone:'';?>" required/>
                                                <span class="Focus-border"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row pb-4">
                                        <div class="r1">
                                            <div class="col-lg-4">
                                                <label for="name">Your major :</label> 
                                                <input class="effect-1" type="text" id="major" name="major" value="<?php echo (isset($major))?$major:'';?>" required/> 
                                                <span class="Focus-border"></span>
                                            </div>
                                            <div class="col-lg-4">
                                                <label for="name">GPA :</label> 
                                                <input class="effect-1" type="number" id="GPA" name="GPA" value="<?php echo (isset($GPA))?$GPA:'';?>" required/>
                                                <span class="Focus-border"></span>
                                            </div>
                                            <div class="col-lg-4">
                                            <label for="name">University name :</label> 
                                                <input class="effect-1" type="text" id="university" name="university" value="<?php echo (isset($university))?$university:'';?>" required/>
                                                <span class="Focus-border"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row pt-5">
                                        <div class="r1">
                                            <div class="col-lg-4">
                                                <label for="name">Year of Experiance :</label> 
                                                <input class="effect-1" type="number" id="experiance" name="experiance" value="<?php echo (isset($experiance))?$experiance:'';?>" required/>
                                                <span class="Focus-border"></span>
                                            </div>
                                            <div class="col-xl-5">
                                                <label for="name">Expectation salary :</label>
                                                <input class="effect-1" type="number" id="salery" name="salery" value="<?php echo (isset($salery))?$salery:'';?>" required/>
                                                <span class="Focus-border"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row pt-4">
                                        <div class="r2">
                                            <div class="col-lg-6">
                                                <input class="btn1" type="submit" name="out" value="Log out">
                                            </div>
                                            <div class="offset-2 col-lg-4">
                                                <input class="btn1" type="submit" name="save" value="Save Edit">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="contact">
        <div class="container">
            <div class="row ">
                <div class="col-xl-10 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="head text-center text-white py-3">
                                        <h3>Your Messages</h3>
                                    </div>
                                </div>
                            </div>
                            <form action="secondpage.php" method="POST">
                                <div class="scroll">
                                        <?php
                                                    $sql = "SELECT * FROM usermessage where ID = $_SESSION[ID] ORDER BY messageID DESC";
                                                    $result = $conn->query($sql);
                                                    while($row = $result->fetch_assoc()){
                                                
                                                echo'<div class="msms">
                                                    <h3><b>'.$row['subject'].'</b></h3>
                                                    <p>'.$row['message'].'</p>
                                                    <div class="r2">
                                                    <div class="col-lg-8"></div>
                                                        <div class="col-lg-3 py-3" style="display: flex;">    
                                                            <a href="replay.php?id='.$row['messageID'].'" class="btn1" style= "margin-right: 3px; text-decoration: none;">View & Reply</a>
                                                            <a href="removeM.php?id='.$row['messageID'].'" class="btn1" style= "text-decoration: none;">End Discussion</a>
                                                        </div>
                                                    </div>
                                                </div>';

                                                    }
                                        ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <script src="bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    <script>
        function view(){
            document.getElementById("mmm").style.display = "block";
        }
        function hide(){
            document.getElementById("cansel").style.display = "none";
        }
    </script>
</body>
</html>