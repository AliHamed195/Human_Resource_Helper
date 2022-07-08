<?php
session_start();
include("connection.php");


?>


<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="Login.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>

        $(document).ready(function () {
            $("#SignUp").on("click", function () {
                $('#cont1').css("display", "none");
                $("#cont2").css("display", "flex");
            });

            $("#login").click(function () {
                $("#cont2").css("display", "none");
                $('#cont1').css("display", "flex");
            });

        });

    </script>
    <title>
        Login&SignUp
    </title>
</head>

<body>

<div>
            <?php
            if(isset($_SESSION['ID'])){
                $ID = $_SESSION['ID'];

                if(isset($_POST['out'])){
                    $_SESSION['ID'] = 0;
                    header("Location: Home.php");
                    die();
                }
                
                if(isset($_POST['my'])){
                    $query = "SELECT ID FROM info WHERE ID= ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param('i', $_SESSION['ID']);
                    $stmt->execute();
                    $row = $stmt->get_result();
                    $use = $row->fetch_assoc();

                    if($_SESSION['ID']==$use['ID']){
                        // $_SESSION['ID'] = $ID;
                        header('Location: secondpage.php');
                        exit();
                    }else{
                        // $_SESSION['ID'] = $ID;
                        header('Location: firstpage.php');
                        exit();
                    }
                }

            }
            
            if(isset($_POST['up'])){
                $name=$_POST['name'];
                $email = $_POST['email'];
                $password =$_POST['password'];
                
                $query = 'SELECT * FROM log WHERE email=?';
                $stmt = $conn->prepare($query);
                $stmt->bind_param('s', $email);
                $stmt->execute();
                $row = $stmt->get_result();
                $user = $row->fetch_assoc();

                if ($user) {
                    echo '<script>alert("Email is already exists")</script>';
                } else {
                    if($name != '' && $email != '' && $password != ''){
                        $name = filter_var($name, FILTER_SANITIZE_STRING);
                        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
                        $password = filter_var($password, FILTER_SANITIZE_STRING);
                                       
                        $sql_query = "INSERT INTO log(email, passwordd, namee) VALUES(?,?,?)";                
                        $stmt = $conn->prepare($sql_query);                
                        $pass = password_hash($password, PASSWORD_DEFAULT);               
                        $stmt->bind_param('sss', $email, $pass, $name);               
                        $stmt->execute();   
                        if($stmt){
                            header('Location: Login.php');
                            exit();
                        }else{
                            echo '<script>alert("Server Down")</script>';
                        }
                    }else{
                        echo '<script>alert("Please fill the filds")</script>';
                    }
                } 
            }
            
            if(isset($_POST['in'])){

                $email = $_POST['email'];
                $password = $_POST['password'];

                $email = filter_var($email, FILTER_SANITIZE_EMAIL);
                $password = filter_var($password, FILTER_SANITIZE_STRING);

                if($email == 'admin@gmail.com'){
                    if($password == '123'){
                        header('Location: hr.php');
                        exit();
                    }else{
                        echo "<script>alert('password wrong')</script>";
                    }
                }else{
                    if($email != '' && $password != ''){
                        $query = 'SELECT * FROM log WHERE email=?';
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param('s', $email);
                        $stmt->execute();
                        $row = $stmt->get_result();
                        $user = $row->fetch_assoc();
        
                        if($user){
        
                            if(password_verify($password, $user["passwordd"])){
                                $_SESSION['email'] = $user['email'];
                                $query = "SELECT ID FROM log WHERE email= ?";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param('s', $_SESSION['email']);
                                $stmt->execute();
                                $row = $stmt->get_result();
                                $userr = $row->fetch_assoc();
        
                                $query = "SELECT ID FROM info WHERE ID= ?";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param('i', $userr['ID']);
                                $stmt->execute();
                                $row = $stmt->get_result();
                                $use = $row->fetch_assoc();
        
                                if($userr['ID']==$use['ID']){
                                    $_SESSION['ID'] = $userr['ID'];
                                    header('Location: secondpage.php');
                                    exit();
                                }else{
                                $_SESSION['ID'] = $userr['ID'];
                                header('Location: firstpage.php');
                                exit();
                                }
                            }
                            else{
                                echo "<script>alert('password wrong')</script>";
                            }
                                
                        }
                        else{
                            echo '<script>alert("USER NOT FOUND")</script>';
                        }
                    }else{
                        echo '<script>alert("Please fill the filds")</script>';
                    }
                }    
            }
            ?>

        </div>

    <div class="navbar">
        <img src="photos/55.png" class="logo">
        <nav>
            <ul id="menulist">
                <li><a href="Home.php">Home</a></li>
                <li><a href="about.php">About As</a></li>
                <li><a href="Login.php">Sign Up</a></li>
            </ul>
        </nav>
        <img src="photos/11.png" class="menu-icon" onclick="togglemenu()">
    </div>


    <div class="container">
        <div style="display: flex; margin-bottom:20px">
            <button class="button-top" id="login" type="button">Login</button>
            <button class="button-top" id="SignUp" type="button">Sign Up</button>
        </div>
        <div id="cont1">
            <div class="c0">

                <img src="photos/password.gif" width="70%" height="55%" />

            </div>

            <div class="c1">

                <div class="form--heading">Welcome Back!</div>

                <form action="Login.php" method="POST">
                <input type="email" placeholder="Email" name="email">
                    <input type="password" placeholder="Password" name="password">
                    <input class="button" type="submit" value="Log in" name="in">
                    <label><a href="forgot_pass.php" class="a">Forget password</a></label>
                </form>
                    <div>
                    <form action="Login.php" method="POST">
                        <?php 
                        if(isset($_SESSION['ID'])){
                            if($_SESSION['ID']!= 0){
                                echo'<div class = "listbtn">
                                    <input class="bt" id="l" type="submit" name="out" value="Log out">
                                    <input class="bt" id="m" type="submit" name="my" value="My Page">
                                </div>';
                            }
                        }
                        ?>
                    </form>
                    </div>
            </div>
        </div>
        <div id="cont2">
            <div class="c0">

                <img src="photos/password.gif" width="70%" height="55%" />

            </div>

            <div class="c1">

                <div class="form--heading">Welcome! Sign Up</div>

                <form action="Login.php" method="POST">
                    <input type="text" id="name" name="name" placeholder="name" required/>
                    <input id="email" type="email" name="email" placeholder="Email" required>
                    <input id="pass" type="password" name="password" placeholder="Password" required>
                    <input class="button" type="submit" value="Sign up" name="up">
                </form>

            </div>

        </div>

    </div>

    <script>


        var menulist = document.getElementById("menulist");
        menulist.style.maxHeight = "0px";

        function togglemenu() {
            if (menulist.style.maxHeight === "0px") {

                menulist.style.maxHeight = "130px";
            }
            else {
                menulist.style.maxHeight = "0px";
            }
        }

    </script>

</body>

</html>