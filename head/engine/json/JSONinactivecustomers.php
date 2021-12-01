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
	$filterby_date = " and DATE(createdon) between '$since_from' and '$since_to'";
}

echo "{";
echo '"data":[';

	$list_datas = sqlQUERY_LABEL("SELECT * FROM js_customer WHERE DATEDIFF(CURRENT_DATE(),js_customer.createdon) > 30 and js_customer.customerID NOT IN ( SELECT js_shop_order.od_userid FROM js_shop_order) {$filterby_date} and deleted='0'") or die("Unable to get records:".sqlERROR_LABEL());

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