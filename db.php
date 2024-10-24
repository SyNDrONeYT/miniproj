<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>database</title>
</head>

<body>
<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}
else
{
	echo"Connetcion established<br>";
}
$sql="CREATE DATABASE sportsstore";
if ($conn->query($sql)==true)
{
	echo"Database created successfully<br>";
}
else
{
	die($conn->error);
}
mysqli_select_db($conn,"sportsstore");
$q="CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
	dob DATE NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    address VARCHAR(255) NOT NULL,
    phone_number VARCHAR(15) NOT NULL,
    password VARCHAR(255) NOT NULL)";
if($conn->multi_query($q)==true)
{
	echo"Table created <br>";
}
else
{
	die($conn->error);
}
$conn->close();
?>
</body>
</html>