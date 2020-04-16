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


$query = "SELECT MAX(created) as time FROM messages";
$result = $conn->query($query);


if (!$result) {
    $message  = 'Неверный запрос: ' . "\n";
    $message .= 'Запрос целиком: ' . $query;
    die($message);
}

$last_mes_syn = $result->fetch_array(MYSQLI_ASSOC)["time"];



$query = "SELECT MAX(created) as time FROM chanels";
$result = $conn->query($query);

if (!$result) {
    $message  = 'Неверный запрос: ' . "\n";
    $message .= 'Запрос целиком: ' . $query;
    die($message);
}

$last_chan_syn = $result->fetch_array(MYSQLI_ASSOC)["time"];
$result = array('time' => max($last_mes_syn, $last_chan_syn));


echo json_encode($result);

?>


