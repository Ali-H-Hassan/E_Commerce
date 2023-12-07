<?php
header('Access-Control-Allow-Origin: *');
include("connection.php");
require __DIR__ . '/vendor/autoload.php';

use Firebase\JWT\JWT;

$username = $_POST['username'];
$password = $_POST['password'];
$query = $mysqli->prepare('SELECT UserID, Username, Password, UserType FROM users WHERE Username = ?');
$query->bind_param('s', $username);
$query->execute();
$query->store_result();
$num_rows = $query->num_rows;
$query->bind_result($id, $username, $hashed_password, $user_type);
$query->fetch();

$response = [];
if ($num_rows == 0) {
    $response['status'] = 'user not found';
} else {
    if (password_verify($password, $hashed_password)) {
        $key = "your_secret";
        $payload_array = [];
        $payload_array["user_id"] = $id;
        $payload_array["username"] = $username;
        $payload_array["usertype"] = $user_type;
        $payload_array["exp"] = time() + 3600;
        $payload = $payload_array;
        $response['status'] = 'logged in';
        $response['jwt'] = JWT::encode($payload, $key, 'HS256');
    } else {
        $response['status'] = 'wrong credentials';
    }
}

echo json_encode($response);
