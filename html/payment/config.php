<?php
require ('stripe-php-master/init.php');

$publishableKey="pk_test_51NGiXoAKnbzcuO2Tmcrt1GPoUvEBs7xrl2phjmVpLAgmh0E0zRvQrkjz2LcUAVonvMiNRI26FFLftoeVnHd5g5VX00MQdlQAWc";
$secretKey="sk_test_51NGiXoAKnbzcuO2TnqsWbELGxNmhPF6YyGVXevQjxeiP6PX3SUZ4BqzCKi5St5fqXoQZOrUALVLiG4pN7wcQWM6e00hXxy1z5X";


\Stripe\Stripe::setApiKey($secretKey);
?>