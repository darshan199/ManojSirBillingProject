<?php

/**
* following class is for customer related opration 
*/


class CustomerBilling
{
		
		public function getCustomerBillByBillId($conn,$id)
		{
			$stmt = $conn->prepare("SELECT  customer_bill.* , customer_bill_details.* from customer_bill_details INNER JOIN customer_bill on customer_bill_details.customer_bill_id = customer_bill.bill_id WHERE customer_bill.bill_id = ?");

			$stmt->execute([$id]);
			return $result = $stmt->fetchAll(PDO::FETCH_CLASS, 'CustomerBilling');
		}

		public function getCustomerBillByDistributorId($conn,$id)
		{		
			// getting all information about distributor
			$stmt = $conn->prepare("SELECT * FROM customer_info WHERE id = ?");
			$stmt->execute([$id]);
			$distributorInfo = $stmt->fetchAll(PDO::FETCH_CLASS, 'CustomerBilling');
			
			// getting the all bills of distributor
			$stmt2 = $conn->prepare("SELECT * FROM customer_bill WHERE customer_info_id = ?");
			$stmt2->execute([$id]);
			$distributorBills = $stmt2->fetchAll(PDO::FETCH_CLASS, 'CustomerBilling');

			$temp = [];

			if($stmt2->rowCount() > 0){

				for( $i=0; $i < $stmt2->rowCount(); $i++ ){

					$stmt3 = $conn->prepare("SELECT * FROM customer_bill_details WHERE customer_bill_id = ?");
					$stmt3->execute([$distributorBills[$i]->bill_id]);		
					$temp[$i]= [

						
							'bill_id' => $distributorBills[$i]->bill_id,
							'bill_date' => $distributorBills[$i]->date,
							'bill_amountBD' => $distributorBills[$i]->amount,
							'bill_discount' => $distributorBills[$i]->discount,
							'bill_total' => $distributorBills[$i]->total_amount,
							'bill_details' => $stmt3->fetchAll(PDO::FETCH_CLASS, 'CustomerBilling'),
					];
				}

			}

			 $result = [
					
						'customer_name' => $distributorInfo[0]->name,
						'customer_id' => $distributorInfo[0]->id,
						'customer_address' => $distributorInfo[0]->address,
						'customer_email' => $distributorInfo[0]->email,
						'customer_contact' => $distributorInfo[0]->contact,

						'customer_bills' => $temp
			];

			return json_encode($result);

		}

		public function NewCustomerBill($conn)
		{
				$stmt = $conn->prepare("SELECT MAX(id) as id FROM customer_info");
				$stmt->execute();
				$MaxCustID = $stmt->fetchAll(PDO::FETCH_CLASS, 'CustomerBilling');
				
				$stmt = $conn->prepare("SELECT MAX(bill_id) as id FROM customer_bill;");
				$stmt->execute();
				$MaxBillID = $stmt->fetchAll(PDO::FETCH_CLASS, 'CustomerBilling');

				return $result = [ 'max_cust_id' => $MaxCustID[0]->id, 'max_bill_id' => $MaxBillID[0]->id ];
		}

		public function getProductList($conn)
		{
				$stmt = $conn->prepare("SELECT * FROM product_list");
				$stmt->execute();
				$allProducts = $stmt->fetchAll(PDO::FETCH_CLASS, 'CustomerBilling');

				return json_encode($allProducts);
		}
}

