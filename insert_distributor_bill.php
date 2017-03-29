<?php
// distributor bill insertion logic here 

include 'database_connection.php';

$bill_id = $_POST['bill_id'];

$bill_date = $_POST['date'];

// $amount_bd = $_POST['amount_bd'];

$product_name = $_POST['product_name'];

$product_rate =$_POST['product_rate'];

$product_discount = $_POST['product_discount'];

$total_amount = $_POST['total_amount']; 

$product_quantity = $_POST['product_quantity'];

$product_mrp = $_POST['product_mrp'];

$total_amount = $_POST['total_amount'];

$conn = DatabaseConnection::connect('billing_project');


$stmt = $conn->prepare("INSERT INTO distributor_bill (bill_id, distributor_info_id, `date`, amountBD, discount, total_amount) VALUES (?,?,?,?,?,?)");
$stmt->execute([ $bill_id, 1, $bill_date, 0 , 0 , $total_amount]);

//insert in to distribuor bill details 

if($stmt->rowCount() == 0){
	die("bill is not inserted properly try again");
}


$bill_details_insertion = $conn->prepare("INSERT INTO distributor_bill_details (distributor_bill_id, product_name, product_quantity, product_mrp, product_rate, product_discount, product_total, product_id) VALUES (?,?,?,?,?,?,?,?)");
$product_list_updates = $conn->prepare("UPDATE product_list SET available_quantity = available_quantity + ? WHERE name = ?");
$product_list_insert = $conn->prepare("INSERT INTO product_list (name,available_quantity,mrp) VALUES (?,?,?) ");

for($i= 0 ; $i < sizeof($product_name); $i++){
	// insert into the distributor bill details
	$bill_details_insertion->execute([ $bill_id, $product_name[$i], $product_quantity[$i], $product_mrp[$i],  $product_rate[$i], $product_discount[$i], $total_amount, 1 ]);
	if($bill_details_insertion->rowCount() < 0){
		die("details insertion fail try again");
	}

	$product_list_updates->execute([$product_quantity[$i], $product_name[$i]]);

	if( $product_list_updates->rowCount() == 0 ){

		$product_list_insert->execute([ $product_name[$i], $product_quantity[$i], $product_mrp[$i] ]);
	}
}