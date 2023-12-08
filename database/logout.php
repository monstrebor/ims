<?php

session_start();

session_unset();

session_destroy();

header("Location: /ims/login.php");


?>

// session_start();
// unset($_SESSION['UserLogin']);
// unset($_SESSION['Access']);
// echo header("Location: index.php");