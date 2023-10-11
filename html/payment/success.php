<?php
include "../databaseconnection/dbconnect.php";
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        // $product_id = $product['product_id'];
    }}
require('config.php');

if(isset($_POST['stripeToken'])){
\Stripe\Stripe::setVerifySslCerts(false);
$token = $_POST['stripeToken'];
$total = $_POST['total'];
$data = \Stripe\Charge::create(array(
    "amount" => $total*100,
    "currency" => "NPR",
    "description" => $token, 
    "source" => $token,
));

    header('Location: receipt.php?product_id=' . $product_id);
    exit();
}

?>
<!-- 4242424242424242 -->