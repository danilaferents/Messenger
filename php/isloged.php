<?php
include_once("DatabaseConnection.php");
session_start();
session_write_close();


if (empty($_SESSION['password']) or empty($_SESSION['email']) or empty($_SESSION['id'])){
    $result = array(
    	'status' => "NOT OK",
	'id' => '',
    ); 

}
else {
	$password = $_SESSION['password'];
	$email = $_SESSION['email'];
	$id = $_SESSION['id'];
	$pdo = new DatabaseConnection();
	$conn = $pdo->connection();
	$query = "SELECT id FROM users WHERE email='$email' AND password='$password' and id=$id";
	$user = $conn->query($query);
	if ($user->num_rows > 0){
		$id_user = $user->fetch_array(MYSQLI_ASSOC);
  		  $result = array(
    			'status' => "OK",
			'id' => $id_user['id'],
  		  ); 
	}
	else
	{
	     $result = array(
    		'status' => "NOT OK",
		'id' => '',
       	     ); 
	}
}

 echo json_encode($result);
          
?>

