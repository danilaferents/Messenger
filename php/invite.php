<?php
include_once("DatabaseConnection.php");
include_once("check_user.php");

$chanel = $_GET['ch'];

$pdo = new DatabaseConnection();
$conn = $pdo->connection();


$user = $_GET['id'];
$inv_user = $_GET['inv'];
if (!check_user($user))
{
	echo "User is not verificated";
	return;
}
if (!is_user_in_chanel){
	exit("permission error");
}
$query1 = "select id from users where email = $inv_user";
$result = $conn->query($query1);
if (!$result) {
    $message  = 'Неверный запрос: ' . "\n";
    $message .= 'Запрос целиком: ' . $query;
    die($message);
}
if ($result->num_rows == 0)
{
	exit("no such user");
}
else
{
	$inv_id = $result->fetch_array(MYSQLI_ASSOC)['id'];
}

$query = "INSERT INTO chanels_users (chanel, user) VALUES ($chanel, $inv_id)";
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

echo json_encode($myArray);

?>


