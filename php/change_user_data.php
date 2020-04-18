<?php
include_once("DatabaseConnection.php");
include_once("check_user.php");

$user = $_POST['id'];
if (!check_user($user))
{
	echo "User is not verificated";
	return;
}

$name = $_POST['name'];
$surname = $_POST['surname'];

$pdo = new DatabaseConnection();
$conn = $pdo->connection();



$valid_extensions = array("jpg","jpeg","png");
$file_name = $_FILES['file']['name'];

$location = "";

$file_name = $_FILES['file']['name'];


if ($name == "" and $surname == 0){
	$result = array(
    	'status' => "OK",
	'msg' => "wrong user credentials"
	);
	exit(json_encode($result));
}


if ($file_name != ""){
	$location = $_SERVER['DOCUMENT_ROOT'] . "/pics/users_avatars/" . $user . '_' . $file_name;
	$imageFileType = pathinfo($location, PATHINFO_EXTENSION);
	if( !in_array(strtolower($imageFileType), $valid_extensions)) {
		echo $location;
	   	$result = array(
	    		'status' => "NOT OK",
			'msg' => "Wrong avatar data format!"
		);
		exit(json_encode($result));
	}


	$upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/pics/users_avatars/";
	if (!is_dir($upload_dir)){
	   	$result = array(
	    		'status' => "NOT OK",
			'msg' => "no such dir: " . $upload_dir
		);
		exit(json_encode($result));
	}

	if (!is_writable($upload_dir))
	{
	   	$result = array(
	    		'status' => "NOT OK",
			'msg' => "permission error"
		);
		exit(json_encode($result));
	}

	if(!move_uploaded_file($_FILES['file']['tmp_name'], $location))
	{
	      echo "moving error ". $file_name . "  ";
	      exit($location);
	}

	$location = "/pics/users_avatars/" . $user . '_' . $file_name;
	$query = "UPDATE users set name = '$name', surname = '$surname', avatar = '$location' where id=$user";
}
else
{
	$query = "UPDATE users set name = '$name', surname = '$surname' where id=$user";
}
if( !$conn->query($query))
{
	exit("query error");
	
}

$result = array(
    	'status' => "OK",
	'msg' => "",
	'avatar' => $location
	);
echo json_encode($result);

?>

