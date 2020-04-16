<?php
function check_user($id)
{
	session_start();
	session_write_close();
	include_once("DatabaseConnection.php");
	$pdo = new DatabaseConnection();
	$conn = $pdo->connection();
	$query = "SELECT email, password FROM users WHERE id = $id";
	$result = $conn->query($query);
	if (!$result) {
    		$message  = 'Неверный запрос: ' . "\n";
    		$message .= 'Запрос целиком: ' . $query;
   		 die($message);
	}
	$user = $result->fetch_array(MYSQLI_ASSOC);
	if ($user == NULL)
	{
		exit('No such user');
	}
	if (($_SESSION["password"] == $user['password']) and ($_SESSION["email"] == $user['email']))
	{
		return true;
	}
	else
	{
		echo $_SESSION["password"];
		echo $_SESSION["email"];
		echo "User is not verificated ";
		return false;
	}
}

?>
