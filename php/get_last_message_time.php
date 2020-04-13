
<?php
include_once("DatabaseConnection.php");


$pdo = new DatabaseConnection();
$conn = $pdo->connection();


$query = "SELECT MAX(created) as time FROM messages";
$result = $conn->query($query);


if (!$result) {
    $message  = 'Неверный запрос: ' . "\n";
    $message .= 'Запрос целиком: ' . $query;
    die($message);
}

echo json_encode($result->fetch_array(MYSQLI_ASSOC));


?>


