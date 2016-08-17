<?php
//initialize the session


// ** Logout the current user. **


header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

header("Cache-Control: private");

//create or continue a session

session_start();

// Clear destroy the session
session_destroy();
/*if(@$_SESSION["uname"]){

$_SESSION["uname"] = false;

$_SESSION["pword"] = false;

session_destroy();

}*/

//finally redirect the user to the start page
$logoutGoTo = "login.php";
header("Location: $logoutGoTo");

?>
