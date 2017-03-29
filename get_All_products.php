<?php
include 'database_connection.php';
include 'distributor_bill.php';
include 'products.php';
include 'customer_bill.php';

$conn = DatabaseConnection::connect('billing_project');

$allProducts = new CustomerBilling;

echo $allProducts->getProductList($conn);

