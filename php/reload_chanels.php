
<?php
include_once("DatabaseConnection.php");

$active_id = $_GET['act'];
$last_syn = $_GET['syn'];
$pdo = new DatabaseConnection();html
$conn = $pdo->connection();


$query = "SELECT id, lastsender, lasttext, lasttime FROM chanels where lasttime > $last_syn and id != $active_id";

$result = $conn->query($query);
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

echo json_encode($myArray)


?>


