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
echo "{";
echo '"data":[';
  $list_promocode_datas = sqlQUERY_LABEL("SELECT * FROM `js_promocode` where deleted = '0' order by promocode_id ASC") or die("#1-Unable to get Promocode Records:".mysql_error());

  $count_promocode_list = sqlNUMOFROW_LABEL($list_promocode_datas);

  while($row = sqlFETCHARRAY_LABEL($list_promocode_datas)){
	  $counter++;
	  $promocode_id = $row["promocode_id"];
	  $promocode_name = stripslashes($row["promocode_name"]);
	  $promocode_code = stripslashes($row["promocode_code"]);
	  $promocode_value = stripslashes($row["promocode_value"]);
	  $promocode_type = $row["promocode_type"];
	  $promocode_option = $row["promocode_option"];
	  $promocode_expiry_date = dateformat_datepicker($row["promocode_expiry_date"]);
	  $status = $row["status"];
		
		if($promocode_type == '1')
		{
			$promocode_type = 'Fixed Rate';
		} else 
		{
			$promocode_type = 'Percentage';
		}
		if($promocode_option == '1') {
			$promocode_option = 'Multiple Use';
		}
		
	   $datas .= "{";
		   $datas .= '"counter": "'.$counter.'",';
		   $datas .= '"promocode_name": "'.$promocode_name.'",';
		   $datas .= '"promocode_code": "'.$promocode_code.'",';
		   $datas .= '"promocode_value": "'.$promocode_value.'",';
		   $datas .= '"promocode_type": "'.$promocode_type.'",';
		   $datas .= '"promocode_option": "'.$promocode_option.'",';
		   $datas .= '"promocode_expiry_date": "'.$promocode_expiry_date.'",';
		   $datas .= '"status": "'.$status.'",';
		   $datas .= '"modify": "'.$promocode_id.'"';
	   $datas .= "},";
	
			} //end of while loop

//echo '{"count":"", "categoryname":"", "status":"", "modify":"" }';
$data_formatted = substr(trim($datas), 0, -1);
echo $data_formatted;
echo "]}";
?>