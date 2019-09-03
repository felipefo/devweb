<?php

$dbuser = $_ENV['MYSQL_USER'];
$dbpass = $_ENV['MYSQL_PASS'];

try {
    $pdo = new PDO("mysql:host=mysql;dbname=blog", $dbuser, $dbpass);    
	$sql = "INSERT INTO posts (title, body) VALUES ('" . $_POST['title'] . "','"  . $_POST['body'] . "')";	
    
	if ($pdo->query($sql) ==TRUE) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	

} catch(PDOException $e) {
    echo $e->getMessage();
}
