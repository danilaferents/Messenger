<?php
session_start();


include_once("DatabaseConnection.php");
if (isset($_POST['email'])) {
    $email = $_POST['email']; 
    if ($email == '') {
        unset($email);
        exit ("Введите пожалуйста логин!");
    } 
}
if (isset($_POST['password'])) {
    $password=$_POST['password']; 
    if ($password =='') {
        unset($password);
        exit ("Введите пароль");
    }
}
 



$pdo = new DatabaseConnection();
$conn = $pdo->connection();
$query = "SELECT id FROM users WHERE email='$email' AND password='$password'";
$user = $conn->query($query);
$id_user = $user->fetch_array(MYSQLI_ASSOC);


if (empty($id_user['id'])){
    session_write_close();
    $result = array(
    	'status' => "NOT OK",
    	'url' => "",
	'id' => '',
	'msg' => "Incorrect email or password"
    ); 

}
else {

    $_SESSION['password']=$password; 
    $_SESSION['email']=$email; 
    $_SESSION['id']=$id_user['id'];
    session_write_close();
    $result = array(
    	'status' => "OK",
	'id' => $id_user['id'],
    	'url' => "messanges.html",
	'msg' => ""
    ); 
}
 echo json_encode($result);
          

//echo "<meta http-equiv='Refresh' content='0; URL=index.php'>";

?>

