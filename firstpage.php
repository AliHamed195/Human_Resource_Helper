<?php
session_start();
include("connection.php");

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="stylefirst.css">
	<title>First Page</title>
</head>
<body>

<div>
            <?php
            if(isset($_POST['submit1'])){

                $city =$_POST['city'];
                $age=$_POST['age'];
                $phone=$_POST['phone'];
                $major=$_POST['major'];
                $GPA=$_POST['GPA'];
                $university=$_POST['university'];
                $experiance=$_POST['experiance'];
                $salery=$_POST['salery'];

				$city = filter_var($city, FILTER_SANITIZE_STRING);
                $age=filter_var($age, FILTER_SANITIZE_NUMBER_INT);
                $phone=filter_var($phone, FILTER_SANITIZE_STRING);
                $major=filter_var($major, FILTER_SANITIZE_STRING);
                $GPA=filter_var($GPA, FILTER_SANITIZE_NUMBER_FLOAT);
                $university=filter_var($university, FILTER_SANITIZE_STRING);
                $experiance= filter_var($experiance, FILTER_SANITIZE_NUMBER_INT);
                $salery=filter_var($salery, FILTER_SANITIZE_NUMBER_INT);

                               
                $sql_query = "INSERT INTO info(ID,city, age,phone,major,GPA,university,experiance,salery) VALUES(?,?,?,?,?,?,?,?,?)";                
                $stmt = $conn->prepare($sql_query);                              
                $stmt->bind_param('isissdsii',$_SESSION['ID'], $city, $age, $phone, $major, $GPA, $university, $experiance,$salery);               
                $stmt->execute();   
                if($stmt){
                    header("Location: secondpage.php");
                    exit();
                }else{
                    echo '<script>alert("Server Down")</script>';
                    header("Location: Login.php");
                    session_destroy();
                }
            }else{
				if(isset($_POST['submit2'])){
					header("Location: Home.php");
                    session_destroy();
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

	<div class="container-fluid py-5">
		<form action="firstpage.php" method="POST">
			<div class="row">
				<div class="col-xl-3"></div>
				<div class="col-xl-6 text-center">
					<h1>Registration Form</h1>
	            <h5><b>Welcome to your Page</b><br>Pleas do not write any wrong information</h5>
				</div>
				<div class="col-xl-3"></div>
			</div>
			<div class="row py-2">
				<div class="col-xl-3">				
					<label> City : </label>
					<input type="text" name="city" required>
				</div>
				<div class="col-xl-3">				
					<label> Age : </label>
					<input type="number" name="age" required>
				</div>
				<div class="col-xl-4">
					<label> Phone Number : </label>
					<input type="text" name="phone" required>
				</div>
			</div>
			<div class="row py-2">
				<div class="col-xl-1"></div>
				<div class="col-xl-3">				
					<label> Major : </label>
					<input type="text" name="major" required>	
				</div>
				<div class="col-xl-3">	
					<label> GPA : </label>
					<input type="number" name="GPA" required>		
				</div>
				<div class="col-xl-4">
					<label> University Name : </label>
					<input type="text" name="university" required>
				</div>
			</div>
			<div class="row py-2">
				<div class="col-xl-2"></div>	
				<div class="col-xl-4">				
					<label> Years of Experiance : </label>
					<input type="number" name="experiance" required>
				</div>
				<div class="col-xl-2"></div>
				<div class="col-xl-4">				
					<label> Expected Salary : </label>
					<input type="number" name="salery" required>
				</div>
			</div>
			<div class="row py-2">
				<div class="col-xl-4">				
				</div>
				<div class="col-xl-4 py-2">	
					<input class="btn" type="submit" name="submit1" value="Submit">	
					<input class="btn" type="submit" name="submit2" value="Log out">		
				</div>
				<div class="col-xl-4">			
				</div>
			</div>
		</div>
	</form>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>