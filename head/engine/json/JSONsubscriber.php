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

echo "{";
echo '"data":[';
  $list_parentcategory_datas = sqlQUERY_LABEL("SELECT * FROM `js_subscriber` where deleted = '0' order by subscriber_ID desc") or die("#1-Unable to get records:".mysqli_error());

  $count_parentcateogry_list = sqlNUMOFROW_LABEL($list_parentcategory_datas);

  while($row = sqlFETCHARRAY_LABEL($list_parentcategory_datas)){
	  $counter++;
	  $subscriber_ID = $row["subscriber_ID"];
	  $subscriber_registered_email = $row["subscriber_email"];
	  $subscriber_redgistered_date = dateformat_datepicker($row["createdon"]);
	  $status = $row["status"];
	
			
		   $datas .= "{";
			   $datas .= '"count": "'.$counter.'",';
			   $datas .= '"registered_email": "'.$subscriber_registered_email.'",';		
			   $datas .= '"registered_date": "'.$subscriber_redgistered_date.'",';
			   $datas .= '"modify": "'.$subscriber_ID.'"';
		   $datas .= " },";
	
			} //end of while loop
		
	
$data_formatted = substr(trim($datas), 0, -1);
echo $data_formatted;
echo "]}";
?>