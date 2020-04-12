
<?php
include_once("DatabaseConnection.php");

$user_id = $_GET['id'];
$pdo = new DatabaseConnection();
$conn = $pdo->connection();


$query = "SELECT name, surname, phone, avatar FROM users where id = $user_id";
$result = $conn->query($query);


if (!$result) {
    $message  = 'Неверный запрос: ' . "\n";
    $message .= 'Запрос целиком: ' . $query;
    die($message);
}

echo json_encode($result->fetch_array(MYSQLI_ASSOC));


?>


