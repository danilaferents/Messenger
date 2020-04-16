<?php
include_once("DatabaseConnection.php");
include_once("check_user.php");

$asking_user = $_GET['id'];
if (!check_user($asking_user))
{
	echo "User is not verificated";
	return;
}

$user = $_GET['user'];
$pdo = new DatabaseConnection();
$conn = $pdo->connection();


$query = "SELECT name, surname, phone, avatar FROM users where id = $user";
$result = $conn->query($query);


if (!$result) {
    $message  = 'Неверный запрос: ' . "\n";
    $message .= 'Запрос целиком: ' . $query;
    die($message);
}

echo json_encode($result->fetch_array(MYSQLI_ASSOC));


?>


