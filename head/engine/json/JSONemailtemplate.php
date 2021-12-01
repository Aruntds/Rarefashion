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
  $list_parentcategory_datas = sqlQUERY_LABEL("SELECT * FROM `js_emailtemplate` where deleted = '0'") or die("#1-Unable to get records:".mysql_error());
  
  while($row = sqlFETCHARRAY_LABEL($list_parentcategory_datas)){
	  $counter++;
	  $template_ID = $row["template_ID"];
	  $template_name = $row["template_name"];
	  $email_subject = $row["email_subject"];
	  $default_message = $row["default_message"];
	  $custom_message = $row["custom_message"];
	  $status = $row["status"];

			
		   $datas .= "{";
			   $datas .= '"count": "'.$counter.'",';
			   $datas .= '"template_name": "'.$template_name.'",';
			   $datas .= '"email_subject": "'.$email_subject.'",';
			   $datas .= '"default_message": "'.$default_message.'",';
			   $datas .= '"custom_message": "'.$custom_message.'",';
			   $datas .= '"status": "'.$status.'",';
			   $datas .= '"modify": "'.$template_ID.'"';
		   $datas .= " },";
	
			} //end of while loop
			
			
			
		
//echo '{"count":"", "categoryname":"", "status":"", "modify":"" }';
$data_formatted = substr(trim($datas), 0, -1);
echo $data_formatted;
echo "]}";
?>