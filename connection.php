<?php

$servername= "localhost";
$db_name= "dbp";
$username = "root";
$password = "";


$conn = mysqli_connect($servername, $username, $password, $db_name,"3308");

if(!$conn){
    echo "Not connected";
}



?>