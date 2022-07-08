<?php
session_start();
include("connection.php");
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
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="styleabout.css">
    <title>
        About Us
    </title>
    <style>
        .listbtn{
            margin-top: 1%;
            margin-left: 78%;
        }
        
        .btn1{
            background: linear-gradient(to right, rgb(221, 168, 34), rgb(248, 185, 26));
            color: black;
            outline: none;
            border: none;
            border-radius: 5px;
            height: 40px;
            width: 125px;
        }
    </style>
</head>

<body>

    <div class="container">
    <?php 
        if(isset($_SESSION['ID'])){
            if($ID != 0){
                echo'<form action="about.php" method="POST">
                        <div class = "listbtn">
                            <input class="btn1" type="submit" name="out" value="Log out">
                            <input class="btn1" type="submit" name="my" value="My Page">
                        </div>
                    </form>';
            }
        }
        ?>
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

        <div class="content">
            <h2>Human Resource Helper</h2>
            <h2>Human Resource Helper</h2>
        </div>

        <div class="center">
            
            <div class="r1">

                <div class="c1">
                    <h1>R</h1>
                </div>

                <div class="c2">
                    
                    <div class="p1">
                        <h1>H</h1>
                    </div>

                    <div class="p2">

                        <div class="text">
                            <p>The goal of this project is to help both
                                the <b>HR</b> and the espiring people to get a job in the company.
                                The content of the project is to provide an opportunity for the person 
                                to easily record information anywhere, and on the other hand, the program allows
                                the <b>HR</b> to choose the right person for the job through a filtering system without
                                the need to read and sort each application separately.</p>
                        </div>

                    </div>

                    <div class="p3">
                        <h1>H</h1>
                    </div>

                </div>

            </div>

            <div class="line2">
                <div class="wave2"></div>
            </div>

            <div class="end">

                <p>
                    This project was created by <b> Ali Hamed </b>and under the supervision
                    and direction of <b><br> Dr. Muhammad Al-Hajj</b>.
                </p>

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