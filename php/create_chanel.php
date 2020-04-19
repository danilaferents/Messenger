<?php
include_once("DatabaseConnection.php");
include_once("check_user.php");

$user = $_POST['id'];
if (!check_user($user))
{
	echo "User is not verificated";
	return;
}

$chanelname = $_POST['chanelname'];

$pdo = new DatabaseConnection();
$conn = $pdo->connection();
$query = "SELECT id FROM chanels WHERE chanelname='$chanelname'";
$chanels = $conn->query($query);

$chanel_file_name = "ch_avatar_" . $chanelname;
if ($chanels->num_rows > 0){
	$result = array(
    	'status' => "NOT OK",
	'msg' => "This channel name is already taken!"
	);
        exit(json_encode($result));	
}

$valid_extensions = array("jpg","jpeg","png");
$file_name = $_FILES['file']['name'];

$location = "";
if ($file_name != ""){
	$location = $_SERVER['DOCUMENT_ROOT'] . "/pics/chanels_avatars/" . $chanelname . '_' . $_FILES['file']['name'];
	$imageFileType = pathinfo($location, PATHINFO_EXTENSION);
	if( !in_array(strtolower($imageFileType), $valid_extensions)) {
		echo $location;
	   	$result = array(
	    		'status' => "NOT OK",
			'msg' => "Wrong channel avatar data format!"
		);
		exit(json_encode($result));
	}




	$upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/pics/chanels_avatars/";
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
	      echo "moving error ".$_FILES["file"]["error"] . "  ";
	      exit($location);
	}

	$location = "/pics/chanels_avatars/" . $chanelname . '_' . $_FILES['file']['name'];

	$query = "INSERT INTO chanels (chanelname, chanelavatar) VALUES ('$chanelname', '$location')";
}
else
{
	$query = "INSERT INTO chanels (chanelname) VALUES ('$chanelname')";
}
if( !$conn->query($query))
{
	exit("query error");
	
}

$result = array(
    	'status' => "OK",
	'msg' => ""
	);
echo json_encode($result);

?>

