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

if (isset($_GET['syn'])) {
    $syn = $_GET['syn']; 
}
else
{
	exit ("Неопознана дата синхронизации!");
}


if ($syn == "")
{
	$query = "SELECT id, chanelavatar, chanelname, created FROM chanels where id in (select chanel from chanels_users where user = $user) order by created desc";
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
else
{
	$query = $query = "SELECT id, chanelavatar, chanelname, created FROM chanels where created > '$syn' and id in (select chanel from chanels_users where user = $user)order by created desc";
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

echo json_encode($myArray)


?>


