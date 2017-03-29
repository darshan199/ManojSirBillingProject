<?php
	
/**
* 
*/
class Products
{
	
	
	public static function getAllProducts($conn)
	{
		$stmt = $conn->prepare("SELECT * FROM product_list");
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_CLASS, 'DistributorBilling');

		return json_encode($result);
	}

}