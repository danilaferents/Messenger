<?php
session_start();

include_once("DatabaseConnection.php");

function prepare_for_db(&$str)
{
  $str = trim(htmlspecialchars(stripslashes($str)));
}
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
if (isset($_POST['rep_password'])) {
    $rep_password=$_POST['rep_password']; 
    if ($rep_password =='') {
        unset($rep_password);
        exit ("Введите пароль второй раз");
    }
}
if (isset($_POST['phone'])) {
    $phone=$_POST['phone']; 
}
 
if (isset($_POST['name'])) {
    $name=$_POST['name']; 
    if ($name =='') {
        unset($name);
        exit ("Введите имя");
    }
}
if (isset($_POST['surname'])) {
    $surname=$_POST['surname']; 
    if ($surname =='') {
        unset($surname);
        exit ("Введите фамилию");
    }
}
 
prepare_for_db($email);
prepare_for_db($password);
prepare_for_db($rep_password);
prepare_for_db($phone);
prepare_for_db($name);
prepare_for_db($surname);
 
//$password = md5($password);

$pdo = new DatabaseConnection();
$conn = $pdo->connection();
$query = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($query);

if ($result->num_rows>0){
	$result = array(
    	'status' => "NOT OK",
    	'url' => "",
	'id' => "",
	'msg' => "email is already used"
    ); 
}
else {
   $query1 = "INSERT INTO users (email, password, name, surname, phone) VALUES   ('$email','$password','$name','$surname','$phone')" ;
    $conn->query($query1);
    $query2 = "SELECT id from users where email='$email'";
    $result = $conn->query($query2);
    $id_user = $result->fetch_array(MYSQLI_ASSOC);
    $_SESSION['password']=$password; 
    $_SESSION['email']=$email; 
    $_SESSION['id']=$id_user['id'];
    session_write_close();
    $result = array(
    	'status' => "OK",
    	'url' => "messanges.html",
	'id' => $id_user['id'],
	'msg' => ""	
    ); 
}

 $query3 = "INSERT INTO chanels_users (chanel, user) VALUES (1, $id_user['id'])" ;
 $conn->query($query3);
 echo json_encode($result);
          

//echo "<meta http-equiv='Refresh' content='0; URL=index.php'>";

?>

