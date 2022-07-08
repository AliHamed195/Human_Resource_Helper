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
    <meta name="viewport" content="width=divice-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleHome.css">
    <title>
        Home Page
    </title>
</head>

<body>
    <div class="container">
        <?php 
        if(isset($_SESSION['ID'])){
            if($ID != 0){
            echo'<form action="Home.php" method="POST">
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

        <div class="row">
            <div class="col-1">
                <h1>You apply <br> We choose</h1>
                <h3>Welcome...</h3>
                <p>We are glad to meet you</p>
                <h4>(enjoy your time)</h4>
                <button type="button" id="bt1" onclick="Go()">Login<img src="photos/22.png"></button>
            </div>
            <div class="col-2">
                <img src="photos/rr.png" class="controller">
                <div class="color-box"></div>
            </div>
        </div>

        <div class="social-links">
            <a href="https://www.facebook.com/"><img src="photos/facebook.png" alt="facebook"></a>
            <a href="https://www.instagram.com/"><img src="photos/insta.png" alt="insta"></a>
            <a href="https://web.whatsapp.com/"><img src="photos/whatsapp.png" alt="whatsapp"></a>
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

        function Go(){
            window.location='Login.php';
        }
    
    </script>

</body>

</html>