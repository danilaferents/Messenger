<?php
include_once("DatabaseConnection.php");
include_once("check_user.php");

$chanel = $_GET['ch'];

$pdo = new DatabaseConnection();
$conn = $pdo->connection();

$user = $_GET['id'];

if (!check_user($user))
{
	echo "User is not verificated";
	return;
}
if (!is_user_in_chanel($user, $chanel)){
	exit("permission error");
}


$query = "DELETE FROM chanels_users WHERE chanel=$chanel and user = $user";
if(!$conn->query($query))
{
	echo "error";
    	echo 'Запрос целиком: ' . $query;
}
else
{
	echo "success";
}
?>


