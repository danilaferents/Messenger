<?php
include_once('check_user.php');


$user = $_GET['id'];
if (!check_user($user))
{
	echo "User is not verificated";
	return;
}


session_start();
unset($_SESSION['password']);
unset($_SESSION['email']);
unset($_SESSION['id']);


?>

