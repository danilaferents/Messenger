
<?php
include_once("DatabaseConnection.php");

$chanel = $_GET['ch'];
$syn = $_GET['syn'];
$pdo = new DatabaseConnection();
$conn = $pdo->connection();

if ($syn == "")
{
	$query = "SELECT senderid, sendername, text, created, content FROM messages where chanel = $chanel order by created 	desc limit 50";
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
}
else
{
	$query = "SELECT senderid, sendername, text, created, content FROM messages where chanel = $chanel and created > 	'$syn' order by created desc";
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


