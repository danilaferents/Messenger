
<?php
include_once("DatabaseConnection.php");
include_once("check_user.php");


$user = $_GET['id'];
if (!check_user($user))
{
	echo "User is not verificated";
	return;
}
$pdo = new DatabaseConnection();
$conn = $pdo->connection();


$query = "SELECT id, chanelavatar, chanelname FROM chanels";

$result = $conn->query($query);

if (!$result) {
    $message  = 'Неверный запрос: ' . "\n";
    $message .= 'Запрос целиком: ' . $query;
    die($message);
}

$myArray = array();

while($row = $result->fetch_assoc()) {
        $myArray[] = $row;
    }

echo json_encode($myArray)


?>


