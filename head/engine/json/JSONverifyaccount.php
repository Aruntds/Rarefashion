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

if($filter_customer !='' && $filter_customer !='0'){
	$filter_by_customer = " and user_id = '$filter_customer' ";
}

if($since_from !='' && $since_to !=''){
	$since_from = dateformat_database($since_from);
	$since_to = dateformat_database($since_to);
	$filterby_date = " and DATE(createdon) between '$since_from' and '$since_to'";
}


echo "{";
echo '"data":[';
//echo "SELECT * FROM js_customer WHERE deleted = '0' {$filter_by_customer} {$filterby_date}";
  $list_producttype_data = sqlQUERY_LABEL("SELECT * FROM js_customer WHERE deleted = '0' {$filter_by_customer} {$filterby_date}") or die("#1-Unable to get PRODUCT UNIT:".sqlERROR_LABEL());

  $count_producttype_list = sqlNUMOFROW_LABEL($list_producttype_data);

  while($row = sqlFETCHARRAY_LABEL($list_producttype_data)){
	  $counter++;
	  $userID = $row["user_id"];
	  $useremail = $row["customeremail"];
	  $user_phone = $row["customerphone"];
	  $email = getVERIFIED_EMAIL_MOBILE($row["user_id"], 'email');
	  if($useremail == ''){
		$useremail = EMPTYFIELD;
		} else {
		$useremail = $useremail;
		}
	  $mobilenumber = getVERIFIED_EMAIL_MOBILE($row["user_id"], 'mobile_no');
	  if($user_phone == ''){
		$user_phone = EMPTYFIELD;
		} else {
		$user_phone = $user_phone;
		}
	  $dateofbirth = $row['customerdob']; //getCUSTOMERDETAILS($userID,'dob');
	  if(($dateofbirth == '') || $dateofbirth == '0000-00-00'){
			$dateofbirth = EMPTYFIELD;
		} else {
			$dateofbirth = $dateofbirth;
		}
	  $customerfirst = $row['customerfirst'];//getCUSTOMERDETAILS($userID,'name');
	  $customerlast = $row['customerlast'];
	  $customer_name = $customerfirst.''.$customerlast;
	  if($customer_name == ''){
		  $customer_name = 'Self';
	  }
	  
		   $datas .= "{";
			   $datas .= '"count": "'.$counter.'",';
			   $datas .= '"customer_name": "'.$customer_name.'",';
			   $datas .= '"email": "'.$email.'",';
			   $datas .= '"useremail": "'.$useremail.'",';
			   $datas .= '"user_phone": "'.$user_phone.'",';
			   $datas .= '"mobilenumber": "'.$mobilenumber.'",';
			   $datas .= '"dateofbirth": "'.$dateofbirth.'"';
		   $datas .= " },";
	
			} //end of while loop
		
	
//echo '{"count":"", "categoryname":"", "status":"", "modify":"" }';
$data_formatted = substr(trim($datas), 0, -1);
echo $data_formatted;
echo "]}";
?>