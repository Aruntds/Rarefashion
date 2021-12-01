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
  $list_category_data = sqlQUERY_LABEL("SELECT * FROM `js_vendor` where deleted = '0'") or die("#1-Unable to get PRODUCT CATEGORY:".sqlERROR_LABEL());

  $count_cateogry_list = sqlNUMOFROW_LABEL($list_category_data);

  while($row = sqlFETCHARRAY_LABEL($list_category_data)){
	  $counter++;
	  $vendor_id = $row["vendor_id"];
	  $vendor_name = $row["vendor_name"];
	  $vendor_code = $row["vendor_code"];
	  $vendor_contactperson = $row["vendor_contactperson"];
	  $vendor_contactnumber = $row["vendor_contactnumber"];
	  $vendor_contactemail = $row["vendor_contactemail"];
	  $vendor_address = $row["vendor_address"];
  	  $vendor_address = htmlspecialchars_decode($vendor_address);
	  $vendor_address = preg_replace('/\s\s+/', '<br>', $vendor_address);
	  $vendor_address = html_entity_decode($vendor_address);
	  $vendor_address = str_replace('&amp;', '&', $vendor_address);
	  $vendor_address = str_replace('&nbsp;', '', $vendor_address);
	  $status = $row["status"];
	  $status_label = $row["status"];
	  if($vendor_contactperson != ''){ $vendor_contactperson = $vendor_contactperson;} else { $vendor_contactperson = '--';}
	  if($vendor_contactnumber != ''){ $vendor_contactnumber = $vendor_contactnumber;} else { $vendor_contactnumber = '--';}
	  if($vendor_contactemail != ''){ $vendor_contactemail = $vendor_contactemail;} else { $vendor_contactemail = '--';}
	  if($vendor_address != ''){ $vendor_address = $vendor_address;} else { $vendor_address = '--';}
	
			
		     $datas .= "{";
			   $datas .= '"count": "'.$counter.'",';
			   $datas .= '"vendor_name": "'.$vendor_name.'",';
			   $datas .= '"vendor_code": "'.$vendor_code.'",';
			   $datas .= '"vendor_contactperson": "'.$vendor_contactperson.'",';
			   $datas .= '"vendor_contactnumber": "'.$vendor_contactnumber.'",';
			   $datas .= '"vendor_contactemail": "'.$vendor_contactemail.'",';
			   $datas .= '"vendor_address": "'.$vendor_address.'",';
			   $datas .= '"status": "'.$status.'",';
			   $datas .= '"status_label": "'.$status_label.'",';
			   $datas .= '"modify": "'.$vendor_id.'"';
		   $datas .= " },";
	
			} //end of while loop
		
	
//echo '{"count":"", "categoryname":"", "status":"", "modify":"" }';
$data_formatted = substr(trim($datas), 0, -1);
echo $data_formatted;
echo "]}";
?>