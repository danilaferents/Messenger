
<?php
include_once("DatabaseConnection.php");

$user = $_GET['user'];
$username = $_GET['username'];
$text = $_GET['mes'];
$chanel = $_GET['ch'];

$pdo = new DatabaseConnection();
$conn = $pdo->connection();
$query = "insert into messages (senderid, sendername, text, content, chanel)
 values ($user, '$username', '$text', NULL, $chanel)";
if($conn->query($query))
{
	echo "success";
}
else
{
	echo "error";
}

?>



