<?php
header('Access-Control-Allow-Origin: *');
include("connection.php");
require __DIR__ . '/vendor/autoload.php';
use Firebase\JWT\JWT;

if ($mysqli->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection error: ' . $mysqli->connect_error]);
    exit();
}

try {
    
    $productId = $_POST['productId'];
    $query = $mysqli->prepare('DELETE FROM products WHERE ProductID=?');
    $query->bind_param('i', $productId);

    if ($query->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['error' => 'Database query error: ' . $mysqli->error]);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Internal server error: ' . $e->getMessage()]);
}
?>
