<?php include("connect.php");
	$mfp->mf_isadmin();
	$filename=time()."_customers.csv";
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Content-Type: text/csv; charset=UTF-16LE");
	$out = fopen("php://output", 'w');
	$flag = false;
	
	$exportDataLbl=array();
	$exportDataLbl[]="License ID";
	$exportDataLbl[]="Order ID";
	$exportDataLbl[]="License Number";
	$exportDataLbl[]="Reseller Code";
	$exportDataLbl[]="Purchase Type";
	$exportDataLbl[]="Qty Seats";
	$exportDataLbl[]="Seats";
	$exportDataLbl[]="Reseller Company";
	$exportDataLbl[]="Reseller Status";
	$exportDataLbl[]="reseller Country";
	$exportDataLbl[]="Customer Company";
	$exportDataLbl[]="Customer Email";
	$exportDataLbl[]="Customer Phone";
	$exportDataLbl[]="Customer Address";
	$exportDataLbl[]="Zipcode";
	$exportDataLbl[]="State";
	$exportDataLbl[]="Account Manager";
	$exportDataLbl[]="Customer Country";
	$exportDataLbl[]="Validity";
	$exportDataLbl[]="Date Expired";
	$exportDataLbl[]="Revenue";
	$exportDataLbl[]="EDU Discount";
	$exportDataLbl[]="Discount";
	$exportDataLbl[]="Channel";
	$exportDataLbl[]="License Status";
	$exportDataLbl[]="Is Renewed?";
	$exportDataLbl[]="Product";
	$exportDataLbl[]="Next License ID";
	
	fputcsv($out, array_values($exportDataLbl));  
	
  	$result=mysql_query("SELECT * FROM customers order by id");
	if(mysql_affected_rows()>0)
	{
		while($row=mysql_fetch_array($result))
		{		
			$exportData=array();
			$exportData[]=$row['license_id'];
			$exportData[]=$row['order_id'];
			$exportData[]=$row['license_number'];
			$exportData[]=$row['reseller_code'];
			$exportData[]=$row['purchase_type'];
			$exportData[]=$row['qty_seats'];
			$exportData[]=$row['seats'];
			$exportData[]=$row['reseller_company'];
			$exportData[]=$row['reseller_status'];
			$exportData[]=$row['reseller_country'];
			$exportData[]=$row['customer_company'];
			$exportData[]=$row['customer_email'];
			$exportData[]=$row['customer_phone'];
			$exportData[]=$row['customer_address'];
			$exportData[]=$row['zipcode'];
			$exportData[]=$row['state'];
			$exportData[]=$row['account_manager'];
			$exportData[]=$row['customer_country'];
			$exportData[]=$row['validity'];
			$exportData[]=$row['date_expired'];
			$exportData[]=$row['revenue'];
			$exportData[]=$row['edu_discount'];
			$exportData[]=$row['discount'];
			$exportData[]=$row['channel'];
			$exportData[]=$row['license_status'];
			$exportData[]=$row['is_renewed'];
			$exportData[]=$row['product'];
			$exportData[]=$row['next_license_id'];
			fputcsv($out, array_values($exportData));
		}
	}
?>
