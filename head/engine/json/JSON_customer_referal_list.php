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

//conditioning
if(!empty($show)) {
	$showcondition = "and `status`='$show'";
}

if($customer_id !='' && $customer_id !='0'){
	$get_referal_code = getCUSTOMER_DATA($customer_id,'reference_code');
	$filterby_referal_customer = " and referral_code = '$get_referal_code'";
}
//'`customergroup`','`customerfirst`','`customerlast`','`customeremail`','`customerdob`','`customergender`','`customerphone`','`customeraddress1`','`customeraddress2`','`customerpincode`','`customerstate`','`customercountry`','`status`'

echo "{";
echo '"data":[';
  $list_parentcategory_datas = sqlQUERY_LABEL("SELECT * FROM `js_customer` where deleted = '0' {$filterby_referal_customer} {$showcondition} order by customerID desc") or die("#1-Unable to get records:".mysql_error());

  $count_parentcateogry_list = sqlNUMOFROW_LABEL($list_parentcategory_datas);

  while($row = sqlFETCHARRAY_LABEL($list_parentcategory_datas)){
	  $counter++;
	  $customerID = $row["customerID"];
	  $user_id = $row["user_id"];
	 // $customergroup = $row["customergroup"];
	  $customerfirst = $row["customerfirst"];
	  $customerlast = $row["customerlast"];
	  $customeremail = $row["customeremail"];
	  $customerdob = dateformat_datepicker($row["customerdob"]);
	  $total_orders = CUSTOMERWISE_ORDER_DETAILS($user_id,'total_orders');
	  $total_sales = CUSTOMERWISE_ORDER_DETAILS($user_id, 'total_sales');
	  $customergender = $row["customergender"];
	  $customerphone = $row["customerphone"];
	  $customeraddress1 = $row["customeraddress1"];
	  $customeraddress2 = $row["customeraddress2"];
	  $customerpincode = $row["customerpincode"];
	  $customerstate = $row["customerstate"];
	  $status = $row["status"];
	  if($customergender == '1'){$customergender = "Male";}elseif($customergender == '2'){$customergender = 'Female';}elseif($customergender == '3'){$customergender = "Transgender";} else{$customergender = "--";}
	  $name = $customerfirst." ".$customerlast;
	  $address = $customeraddress1."-".$customeraddress2."-".$customerpincode."-".$customerstate;
	  if($status == '1'){
		  $status = "<span class='text-success tx-bold'>Active</span>";
	  } else if($status == '0'){
		  $status = "<span class='text-danger tx-bold'>In-Active</span>";
	  }
			
		   $datas .= "{";
			   $datas .= '"count": "'.$counter.'",';
			 //  $datas .= '"customergroup": "'.getcustomerGROUP($customergroup, 'label').'",';
			   $datas .= '"name": "'.$name.'",';
			   $datas .= '"customeremail": "'.$customeremail.'",';
			   $datas .= '"customerdob": "'.$customerdob.'",';
			   $datas .= '"customergender": "'.$customergender.'",';
			   $datas .= '"customerphone": "'.$customerphone.'",';
			   $datas .= '"address": "'.$address.'",';
			   $datas .= '"total_orders": "'.$total_orders.'",';
			   $datas .= '"total_sales": "'.$total_sales.'",';
			   $datas .= '"status": "'.$status.'",';
			   $datas .= '"modify": "'.$customerID.'"';
		   $datas .= " },";
	
			} //end of while loop
		
	
//echo '{"count":"", "categoryname":"", "status":"", "modify":"" }';
$data_formatted = substr(trim($datas), 0, -1);
echo $data_formatted;
echo "]}";
?>