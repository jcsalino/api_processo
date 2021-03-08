<?php
$servername = '{{.Env.DB_HOST}}';
$username = '{{.Env.DB_USERNAME}}';
$password = '{{.Env.DB_PASSWORD}}';

$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS api_test";
if ($conn->query($sql) === TRUE) {
  echo "Database created successfully";
} else {
  echo "Error creating database: " . $conn->error;
}

$conn->close();
?>