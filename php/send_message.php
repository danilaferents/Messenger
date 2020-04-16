<?php
include_once("DatabaseConnection.php");
include_once("check_user.php");

$user = $_GET['id'];
if (!check_user($user))
{
	echo "User is not verificated";
	return;
}

$text = $_GET['mes'];
$chanel = $_GET['ch'];


$pdo = new DatabaseConnection();
$conn = $pdo->connection();

$query = "insert into messages (senderid, text, content, chanel)
 values ($user, '$text', NULL, $chanel)";
if($conn->query($query))
{
	echo "success";
}
else
{
	echo "error";
}

?>



