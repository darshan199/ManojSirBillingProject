<?php

/**
* following calss is for distributor billing handling
*/
class DistributorBilling 
{
	
	//find distributor bill by bill id
	public function getDistributorBillByBillId($conn,$id)
	{
		$stmt = $conn->prepare("SELECT  distributor_bill.* , distributor_bill_details.* from distributor_bill_details INNER JOIN distributor_bill on distributor_bill_details.distributor_bill_id = distributor_bill.bill_id WHERE distributor_bill.bill_id = ?");

		$stmt->execute([$id]);
		return $result = $stmt->fetchAll(PDO::FETCH_CLASS, 'DistributorBilling');
	}

	//find distributor bill by distributor id
	public function getDistributorBillByDistributorId($conn,$id)
	{		
		// getting all information about distributor
		$stmt = $conn->prepare("SELECT * FROM distributor_info WHERE id = ?");
		$stmt->execute([$id]);
		$distributorInfo = $stmt->fetchAll(PDO::FETCH_CLASS, 'DistributorBilling');
		
		// getting the all bills of distributor
		$stmt2 = $conn->prepare("SELECT * FROM distributor_bill WHERE distributor_info_id = ?");
		$stmt2->execute([$id]);
		$distributorBills = $stmt2->fetchAll(PDO::FETCH_CLASS, 'DistributorBilling');

		$temp = [];

		if($stmt2->rowCount() > 0){

			for( $i=0; $i < $stmt2->rowCount(); $i++ ){

				$stmt3 = $conn->prepare("SELECT * FROM distributor_bill_details WHERE distributor_bill_id = ?");
				$stmt3->execute([$distributorBills[$i]->bill_id]);		
				$temp[$i]= [

					
						'bill_id' => $distributorBills[$i]->bill_id,
						'bill_date' => $distributorBills[$i]->date,
						'bill_amountBD' => $distributorBills[$i]->amountBD,
						'bill_discount' => $distributorBills[$i]->discount,
						'bill_total' => $distributorBills[$i]->total_amount,
						'bill_details' => $stmt3->fetchAll(PDO::FETCH_CLASS, 'DistributorBilling'),
				];
			}

		}

		 $result = [
				
					'distributor_name' => $distributorInfo[0]->name,
					'distributor_id' => $distributorInfo[0]->id,
					'distributor_address' => $distributorInfo[0]->address,
					'distributor_email' => $distributorInfo[0]->email,
					'distributor_contact' => $distributorInfo[0]->contact,

					'distributor_bills' => $temp
		];

		return json_encode($result);

	}


	public function insertDistributorBill($conn, $bill_id )
	{
			
	}


	public function testing()
	{
			
	
	}

	

}
