<?php
include "../databaseconnection/dbconnect.php";
session_start();
// Retrieve the product ID from the URL
if (isset($_SESSION['user_id'])) {
    if (isset($_GET['id'])) {
        $product_id = $_GET['id'];
        $sql = "SELECT product_id,productName, price,details, productImage FROM products WHERE product_id = $product_id";
        $result = $conn->query($sql);
        if ($result) {
           $product = $result->fetch_assoc();
           $orderProductName = $product['productName'];
           $orderPrice = $product['price'];
           $orderImage = $product['productImage'];
        //    $user_id = $_SESSION['user_id'];
   
        //    $insertSql = "INSERT INTO orders (o_name, o_price, o_image, user_id) VALUES ('$orderProductName', $orderPrice, '$orderImage', '$user_id')";
           $insertSql = "INSERT INTO orders (o_name, o_price, o_image) VALUES ('$orderProductName', $orderPrice, '$orderImage')";
           $insertResult = $conn->query($insertSql);
   
           if ($insertResult) {
               // echo "Order details inserted successfully.";
           } else {
               echo "Error inserting order details: " . $conn->error;
           }
       } else {
           echo "Error fetching product details: " . $conn->error;
       }
   }
   
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction</title>
    <style>
        body p {
            display: flex;
            justify-content: center;
            font-size: 30px;
            align-items: center;
        }
    </style>
</head>
<body>
    <p>Payment Successful.</p>
</body>
</html>
