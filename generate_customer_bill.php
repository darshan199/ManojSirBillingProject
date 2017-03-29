<?php

include 'database_connection.php';
include 'distributor_bill.php';
include 'products.php';
include 'customer_bill.php';


$bill_date =  date('Y-m-d H:i:s');

$product_name = $_POST['product_name'];
$product_quantity = $_POST['product_quantity'];
$product_mrp = $_POST['product_mrp'];
$product_discount = $_POST['product_discount'];
$product_total = $_POST['product_total'];
$current_bill_id = $_POST['bill_id'] ;
// $data = $_POST['cust_details'];
// $product_id = $_POST['product_id'];

$conn = DatabaseConnection::connect('billing_project');


$stmt = $conn->prepare("SELECT * FROM customer_info WHERE shop_name = ? AND contact = ? ");
$stmt->execute([$_POST['shop_name'], $_POST['cust_contact']]);
$cust_id = $stmt->fetchAll(PDO::FETCH_CLASS, 'CustomerBilling');
				
if($stmt->rowCount() == 1){

	echo $current_cust_id = $cust_id[0]->id;
	echo "yes";
}
else{
	
	$stmt = $conn->prepare("SELECT MAX(id) as id FROM customer_info;");
	$stmt->execute();
	$MaxCustID = $stmt->fetchAll(PDO::FETCH_CLASS, 'CustomerBilling');

	$current_cust_id = $MaxCustID[0]->id;
	$current_cust_id += 1;

	$stmt = $conn->prepare("INSERT INTO customer_info (id, shop_name ,name, address, contact,email) VALUES (?,?,?,?,?,?)");
	$stmt->execute([ $current_cust_id, $_POST['shop_name'], $_POST['cust_name'], $_POST['cust_address'], $_POST['cust_contact'], $_POST['cust_name'] ]);
	echo "no";
}


$stmt = $conn->prepare("INSERT INTO customer_bill (bill_id, customer_info_id, `date`, amount, discount, total_amount) VALUES (?,?,?,?,?,?)");
$stmt->execute([ $_POST['bill_id'], $current_cust_id, '2017-03-03 12:43:00', $_POST['product_total'], 0 , $_POST['product_total'] ]);

echo "<br>";

if($stmt->rowCount() == 0){

	echo "Eroor..!! Bill Id should'nt be same";
	die();
}

for($i=0; $i < sizeof($_POST['product_name']); $i++){
		
	$stmt = $conn->prepare("INSERT INTO customer_bill_details (customer_bill_id, product_name, product_quantity, product_mrp, product_discount, product_total, product_id) VALUES (?,?,?,?,?,?,?)");
	$stmt->execute([ $current_bill_id, $product_name[$i] ,  $product_quantity[$i], $product_mrp[$i],  				$product_discount[$i], $product_total, 1 ]);
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Condensed Table</h2>
  <p>The .table-condensed class makes a table more compact by cutting cell padding in half:</p>            
  <table class="table table-condensed">
    <thead>
      <tr>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Email</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>John</td>
        <td>Doe</td>
        <td>john@example.com</td>
      </tr>
      <tr>
        <td>Mary</td>
        <td>Moe</td>
        <td>mary@example.com</td>
      </tr>
      <tr>
        <td>July</td>
        <td>Dooley</td>
        <td>july@example.com</td>
      </tr>
    </tbody>
  </table>
</div>

</body>
</html>

