<?php
header('Access-Control-Allow-Origin: *');
include("connection.php");

$query = $mysqli->prepare('SELECT * FROM products');
$query->execute();
$result = $query->get_result();

$response = ['products' => []];

while ($product = $result->fetch_assoc()) {
    $response['products'][] = $product;
}

echo json_encode($response);
