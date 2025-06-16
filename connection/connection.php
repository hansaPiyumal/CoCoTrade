<?php
$servername = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'cocotrade';

$connection = mysqli_connect($servername,$username,$password,$database);


if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

//echo "Connected successfully";
?>