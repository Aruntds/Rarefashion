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

//'`customergroup`','`customerfirst`','`customerlast`','`customeremail`','`customerdob`','`customergender`','`customerphone`','`customeraddress1`','`customeraddress2`','`customerpincode`','`customerstate`','`customercountry`','`status`'

echo "{";
echo '"data":[';
  $list_parentcategory_datas = sqlQUERY_LABEL("SELECT * FROM `js_customer` where deleted = '0' {$showcondition} order by customerID desc") or die("#1-Unable to get records:".mysql_error());

  $count_parentcateogry_list = sqlNUMOFROW_LABEL($list_parentcategory_datas);

  while($row = sqlFETCHARRAY_LABEL($list_parentcategory_datas)){
	  $counter++;
	  $customerID       = $row["customerID"];
	  $customergroup    = $row["customergroup"];
	  $customerfirst    = $row["customerfirst"];
	  $customerlast     = $row["customerlast"];
	  $customeremail    = $row["customeremail"];
	  $customerdob      = dateformat_datepicker($row["customerdob"]);
	  $customergender   = $row["customergender"];
	  $customerphone    = $row["customerphone"];
	  $customeraddress1 = $row["customeraddress1"];
	  $customeraddress2 = $row["customeraddress2"];
	  $customercity     = $row["customercity"];
	  $customerpincode  = $row["customerpincode"];
	  $customerstate  = $row["customerstate"];
	  $customercountry  = $row["customercountry"];
	  $customerstate = $row["customerstate"];
	  $status = $row["status"];
	  $name = $customerfirst."-".$customerlast;
	  $address = $customeraddress1."-".$customeraddress2."-".$customerpincode."-".$customerstate;
	
			
		   $datas .= "{";
			   $datas .= '"count": "'.$counter.'",';
			   //$datas .= '"customergroup": "'.getcustomerGROUP($customergroup, 'label').'",';
			   $datas .= '"name": "'.$name.'",';
			   $datas .= '"customeremail": "'.$customeremail.'",';
			   $datas .= '"customerdob": "'.$customerdob.'",';
			   $datas .= '"customergender": "'.$customergender.'",';
			   $datas .= '"customerphone": "'.$customerphone.'",';
			   $datas .= '"customercity": "'.$customercity.'",';
			   $datas .= '"address": "'.$address.'",';
			   $datas .= '"customercountry": "'.$customercountry.'",';
			   $datas .= '"customerstate": "'.$customerstate.'",';
			   $datas .= '"status": "'.$status.'",';
			   $datas .= '"modify": "'.$customerID.'"';
		   $datas .= " },";
	
			} //end of while loop
		
	
//echo '{"count":"", "categoryname":"", "status":"", "modify":"" }';
$data_formatted = substr(trim($datas), 0, -1);
echo $data_formatted;
echo "]}";
?>