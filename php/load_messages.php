
<?php
include_once("DatabaseConnection.php");

$chanel = $_GET['ch'];
$syn = $_GET['syn'];
$pdo = new DatabaseConnection();
$conn = $pdo->connection();

if ($syn == "")
{
$query = "SELECT senderid, sendername, text, created, content FROM messages where chanel = $chanel order by created desc limit 50";
}
else
{
$query = "SELECT senderid, sendername, text, created, content FROM messages where chanel = $chanel and created > '$syn' order by created desc limit 50";
}
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


