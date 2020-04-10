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

$query = "SELECT message, send_time FROM test_messages order by send_time desc limit 10";

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
        echo $row["message"]. "  " . $row["send_time"]. "<br>";
    }
} else {
    echo "0 results";
}


$conn->close();
?>

 </body>
</html>

