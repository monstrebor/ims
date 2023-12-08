<?php
include_once("database/registration.php");
$con = connections();
if(isset($_POST['submit'])){
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $error = array();



    
    $sql = "INSERT INTO `users` ( `first_name`,`last_name`,`password`,`email`) VALUES ('$first_name','$last_name','$password','$email')";
    $con->query($sql) or die($con->error);

    
    header("Location: login.php"); 

    echo $con;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/register.css">
    <title>Document</title>
</head>
<body background="img/background.jpg" >
    <div>
        <div class="loginHeader">
            <h1>IMS</h1>
            <h2>Inventory Management System</h2>
        </div>
        <div class="loginBody" action="login.php" >
            <form action="" method="post">
                <div class="innerborderbox">
                <h3 style="text-align: center; font-size: 40px;">Registration</h3>
                <label>First Name</label>
                <input type="text" name="first_name" id="first_name" required placeholder="Enter your First Name">
                <br>
                <label>Last name</label>
                <input type="text" name="last_name" id="last_name" required placeholder="Enter your Last Name">
                <label>Password</label>
                <input type="password" name="password" id="password" required placeholder="Enter your password"> 
                <br>
                <label>Email</label>
                <br>
                <input type="text" name="email" id="email" required placeholder="Enter your email">

                <div class="btn">
                    <button value="submit" id="submit" name="submit">Submit</button>
                </div>
                </div>
            </form>
        </div>
    </div>




</body>
</html>


    <!-- <script>        document.getElementById('toggleBtn').addEventListener('click', function () {
        document.getElementById('dashboard_sidebar').classList.toggle('sidebarActive');
        document.getElementById('dashboard_content_container').classList.toggle('contentContainerActive');
        });
        document.getElementById('dashboard_content_container').addEventListener('click', function () {
        document.getElementById('dashboard_sidebar').classList.remove('sidebarActive');
        document.getElementById('dashboard_content_container').classList.remove('contentContainerActive');
        });</script> -->

<!-- <div class="login-container">
        <h1 id="h">Login</h1>
        <div class="form-logo">
        <img style="margin-left: 3rem;"src="img/index.png" id="pic"alt="">
        <img src="img/index.png" id="pic"alt="">
        <img src="img/index.png" id="pic"alt="">
        </div>
        <br/>
        <form action="" method="post">
        <div class="form-element">
        <br/>
            <label>First Name</label>
            <input type="text" name="firstName" id="firstName" required placeholder="Enter your firstname nigga">
        <br/>
            <label>Last Name</label>
            <input type="text" name="lastName" id="lastName" required placeholder="Enter your lastname nigga">
        <br/>
        <label>Gender</label>
            <select name="gender" id="gender" style="font-size: 30px;">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Lesbian">Lesbian</option>
                <option value="Gay">Gay</option>
                <option value="Bisexual">Bisexual</option>
                <option value="Transgender">Transgender</option>
                <option value="Homosapien">Homosapien</option>
                <option value="Alopecia">Alopecia</option>
                <option value="Loperamide">Loperamide</option>
                <option value="Caterpillar">Caterpillar</option>
            </select>
        <br/>
            <label>Email</label>
            <input type="text" name="email" id="email" required placeholder="Enter your email nigga">
        <br/>
            <label>Password</label>
            <input type="password" name="password" id="password" required placeholder="Enter your password nigga">
        <br/>
            <label>Phone Number</label>
            <input type="text" name="number" id="number" required placeholder="Enter your number nigga">
        <br/>
            <button type="submit" name="submit" style="color: black; font-size: 18px;">Submit Form</button>
            </div>
            <a style="font-weight: bold; font-size: 30px; margin-left: auto;" href="login.php">Login as Admin?</a>
        </form>
    </div> -->