<?php
include_once("DatabaseConnection.php");
include_once("check_user.php");

$user = $_POST['id'];
if (!check_user($user))
{
	echo "User is not verificated";
	return;
}

if (isset($_POST['chanelname'])) {
    $chanelname = $_POST['chanelname']; 
    if ($chanelname == '') {
        unset($chanelname);
	$result = array(
    	'status' => "NOT OK",
	'msg' => "Введите пожалуйста логин!",
        );
	 exit(json_encode($result));
    } 
}
else
{
	 unset($chanelname);
	$result = array(
    	'status' => "NOT OK",
	'msg' => "Введите пожалуйста логин!",
	);
        exit(json_encode($result));
}
 

$pdo = new DatabaseConnection();
$conn = $pdo->connection();
$query = "SELECT id FROM chanels WHERE chanelname='$chanelname'";
$chanels = $conn->query($query);

if ($chanels->num_rows > 0){
	$result = array(
    	'status' => "OK",
	'msg' => "This chanel name is already taken!"
	);
        exit(json_encode($result));	
}

$query = "INSERT INTO chanels (chanelname) VALUES ('$chanelname')";
$conn->query($query);


$result = array(
    	'status' => "OK",
	'msg' => ""
	);
echo json_encode($result);

?>

