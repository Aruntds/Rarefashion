<?php
/*
* JACKUS - An In-house Framework for TDS Apps
*
* Author: Touchmark Descience Private Limited. 
* https://touchmarkdes.com
* Version 4.0.1
* Copyright (c) 2018-2020 Touchmark De`Science
*
*/
extract($_REQUEST);
include_once('../../jackus.php');


if($since_from !='' && $since_to !=''){
	$filterby_date = " and DATE(CUSTOMER.createdon) between '$since_from' and '$since_to'";
}

echo "{";
echo '"data":[';

	$list_datas = sqlQUERY_LABEL("SELECT CUSTOMER.`customerID`, CUSTOMER.`customergroup`, CUSTOMER.`customerfirst`, CUSTOMER.`customerlast`, CUSTOMER.`customeremail`, CUSTOMER.`customerdob`, CUSTOMER.`customergender` , CUSTOMER.`customerphone`, CUSTOMER.`createdon`, CUSTOMER.`customeraddress1`, CUSTOMER.`customeraddress2`, CUSTOMER.`customerpincode`, CUSTOMER.`customerstate`, CUSTOMER.`status` FROM `js_customer` AS CUSTOMER WHERE CUSTOMER.`deleted`=0 AND DATEDIFF(CURRENT_DATE(),CUSTOMER.createdon) < 30 {$filterby_date} order by CUSTOMER.`customerfirst` ASC") or die("Unable to get records:".sqlERROR_LABEL());

	$fetch_list = sqlNUMOFROW_LABEL($list_datas);

	while($fetch_records = sqlFETCHARRAY_LABEL($list_datas)){

		$counter++;
		$customer_id = $fetch_records['customerID'];
		$customerfirst = $fetch_records['customerfirst'];
		$customerlast = $fetch_records['customerlast'];
		$customeremail = $fetch_records['customeremail'];
		$customerdob = dateformat_datepicker($fetch_records['customerdob']);
		$customergender = $fetch_records['customergender'];
		$customerphone = $fetch_records['customerphone'];
		$register_date = dateformat_datepicker($fetch_records['createdon']);
		$customer_name = $customerfirst.''.$customerlast;
		if($customergender == '1'){$customergender="Male"; }elseif($customergender == '2'){$customergender="Female";} else if($customergender == '3'){$customergender = "Transgender";}
		if($customergender == '' || $customergender == '0'){$customergender = 'N/A';}
	 	   $datas .= "{";
			   $datas .= '"count": "'.$counter.'",';
			   $datas .= '"customer_name": " '.$customer_name.'",';
			   $datas .= '"customeremail": "'.$customeremail.'",';
			   $datas .= '"customerphone": "'.$customerphone.'",';
			   $datas .= '"customerdob": "'.$customerdob.'",';
			   $datas .= '"register_date": "'.$register_date.'",';
			   $datas .= '"customergender": "'.$customergender.'"';
		   $datas .= "},";
			} //end of while loop

//echo '{"count":"", "categoryname":"", "status":"", "modify":"" }';
$data_formatted = substr(trim($datas), 0, -1);
echo $data_formatted;
echo "]}";

?>