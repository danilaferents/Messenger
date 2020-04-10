
<!DOCTYPE html> 
<html>
<head> 
    <title> 
        How to call PHP function 
        on the click of a Button ? 
    </title> 
</head> 
 <body>
    <h1 style="color:green;"> 
        Chanel creator 
    </h1> 
<form method="POST"><input name="create_chanel" type="submit" value="Create chanel" /></form>
<form method="POST"><input name="show_chanels" type="submit" value="Show chanels" /></form>

<?php
if (isset($_POST['show_chanels'])){

require_once('DatabaseConnection.php');
// Instantiate connection class
$pdo = new DatabaseConnection();
// Assign the connection to $con (or whatever variable you like)
$conn = $pdo->connection();
$query = "SELECT id, last_message FROM chanels";

// Выполняем запрос
$result = $conn->query($query);

// Это показывает реальный запрос, посланный к MySQL, а также ошибку. Удобно при отладке.
if (!$result) {
    $message  = 'Неверный запрос: ' . mysql_error() . "\n";
    $message .= 'Запрос целиком: ' . $query;
    die($message);
}

// Используем результат
// Попытка напечатать $result не выведет информацию, которая в нем хранится
// Необходимо использовать какую-либо mysql-функцию, работающую с результатом запроса
// См. также mysql_result(), mysql_fetch_array(), mysql_fetch_row() и т.п.
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - last_message: " . $row["last_message"]. "<br>";
    }
} else {
    echo "0 results";
}


$conn->close();
}
?>


<?php
if (isset($_POST['create_chanel'])){
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

$query = "INSERT INTO chanels (last_message) VALUES ('start message')";

if ($conn->query($query) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
}
$conn->close();
}
?>

 </body>
</html>
