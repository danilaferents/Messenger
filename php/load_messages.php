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
if (!is_user_in_chanel){
	exit("permission error");
}
$query = "SELECT id, senderid, text, created, content, chanel FROM messages where chanel = $chanel order by created desc limit 50";
$time_wait = 0;
$result = $conn->query($query);
while ($result->num_rows == 0)
{
	usleep(100000);
	$time_wait += 0.1;
	$result = $conn->query($query);
	if ($time_wait > 10)
	{
		break;
	}
}



if (!$result) {
    $message  = 'Неверный запрос: ' . "\n";
    $message .= 'Запрос целиком: ' . $query;
    die($message);
}

$myArray = array();

while($row = $result->fetch_assoc()) {
        $myArray[] = $row;
    }

echo json_encode($myArray);

?>


