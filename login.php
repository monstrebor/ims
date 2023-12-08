<?php
session_start();
if(isset($_SESSION['user'])) header('location: dashboard.php');

$error_message = '';

if($_POST){
    include('database/connection.php');

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = 'SELECT * FROM users WHERE users.email="'. $username . '" AND users.password="'. $password . '" LIMIT 1';
    $stmt = $conn->prepare($query);
    $stmt->execute();

    if($stmt->rowCount() > 0){
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $user = $stmt->fetchAll()[0];

        //it captures the data of current login users
        $_SESSION['user'] = $user;

        header("Location: dashboard.php");
    }else $error_message = 'Please make sure that username and password are correct.';
}

// if(!isset($_SESSION)){
//     session_start();
// } 

// include_once("connections/connection.php");
// $conn = connection();

// if(isset($_POST['login'])){

//     $first_name = mysqli_real_escape_string($con, $_POST['first_name']);
//     $password = mysqli_real_escape_string($con, $_POST['password']);

//     $sql = "SELECT * FROM users WHERE first_name = '$first_name' AND password = '$password'";
//     $user = $con->query($sql) or die ($con->error);
//     $row = $user->fetch_assoc();
//     $total = $user->num_rows;

// if($total > 0){
//     $_SESSION['UserLogin'] = $row['first_name'];
//     $_SESSION['Access'] = $row['access'];
//     echo header("Location: index.php");
// }else{
//     echo '<div class="warning"><h4>No User Found<h4></div>';
// }
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body  background="img/background.jpg" >

    <?php
        if(!empty($error_message)) {  ?>
        <div id="errorMessage">
        <strong>ERROR:</strong><p><?= $error_message?></p>
        </div>
    <?php  } ?>
    
    <div>
        <div class="loginHeader">
            <h1>IMS</h1>
            <h2>Inventory Management System</h2>
        </div>
        <div class="loginBody">
            <form action="login.php" method="POST">
                <div class="innerborderbox">
                <h3>Login Form</h3>
                        <label for="email">Email</label>
                        <br>
                        <input type="text" name="username" placeholder="enter Email">
                    <div class="innerborderbox">
                    </div>
                        <label for="password">Password</label>
                        <br>
                        <input type="password" name="password" placeholder="enter password">
                    <div class="btn">
                        <br>
                        <button id="submit" name="login">Login</button>
                    </div>
                        <a href="register.php">create an account?</a>
                    </div>
            </form>   
        </div>
    </div>
</body>
</html>