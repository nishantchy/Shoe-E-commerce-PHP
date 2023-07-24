<?php
include "../databaseconnection/dbconnect.php";

// Retrieve the product ID from the URL
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Fetch the product details from the database
    $sql = "SELECT * FROM products WHERE product_id = $product_id";
    $result = $conn->query($sql);

    if ($result) {
        // Fetch the product details
        $product = $result->fetch_assoc();

        // Insert the product details into the orders table
        $orderProductName = $product['productName'];
        $orderPrice = $product['price'];
        $orderImage = $product['productImage'];

        $insertSql = "INSERT INTO orders (o_name, o_price,  o_image) VALUES ('$orderProductName', $orderPrice, '$orderImage')";
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
