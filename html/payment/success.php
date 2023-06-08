<?php
include "../databaseconnection/dbconnect.php";
$sql = "SELECT * FROM products";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    }
require('config.php');

if(isset($_POST['stripeToken'])){
\Stripe\Stripe::setVerifySslCerts(false);
$token = $_POST['stripeToken'];
$data = \Stripe\Charge::create(array(
    "amount" => $product['price'],
    "currency" => "usd",
    "description" => $product['productName'], 
    "source" => $token,
));
// echo "<pre>";
// print_r($data);
    header('Location: receipt.php');
}

?>
<!-- 4242424242424242 -->