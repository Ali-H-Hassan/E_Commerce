<?php
header('Access-Control-Allow-Origin: *');
include("connection.php");

$username = $_POST['username'];
$password = $_POST['password'];

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$userType = 'Normal';

$query = $mysqli->prepare('INSERT INTO users (Username, Password, UserType) VALUES (?, ?, ?)');
$query->bind_param('sss', $username, $hashed_password, $userType);
$query->execute();

$response = [];
$response["status"] = "true";

echo json_encode($response);
