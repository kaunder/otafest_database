<?php
//Get the cookie from the browser if one exists, else create new cookie
session_start();
unset($_SESSION["username"]);  
header("Location: index.php");
?>

