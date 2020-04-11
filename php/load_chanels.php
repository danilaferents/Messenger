
<?php
include_once("DatabaseConnection.php");

$pdo = new DatabaseConnection();
$conn = $pdo->connection();


$query = "SELECT id, lastsender, lasttext, lasttime, chanelavatar, chanelname FROM chanels";

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


