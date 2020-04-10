
<?php
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "wordpress";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "insert into test_messages (message) values (?);";


$stmt = $conn->prepare($query);
$stmt->bind_param("s", $_GET['mes']);
$stmt->execute();



$conn->close();
?>



