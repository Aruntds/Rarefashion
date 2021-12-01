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

echo "{";
echo '"data":[';

  $list_staff_data = sqlQUERY_LABEL("select * from `js_staff` where deleted='0' order by staff_id desc") or die("#1-Unable to get PRODUCT CATEGORY:".sqlERROR_LABEL());

  $count_staff_list = sqlNUMOFROW_LABEL($list_staff_data);

  while($row = sqlFETCHARRAY_LABEL($list_staff_data)){
		
		$counter++;
		$staff_id = $row['staff_id'];
		$staff_code = $row['staff_code'];
		$staff_fname = $row['staff_fname'];
		$staff_lname = $row['staff_lname'];
		$fullname = $staff_fname.' '.$staff_lname;
		$staff_email = strtolower($row['staff_email']);
		$staff_mobile = $row['staff_mobile'];
		$staffroleid = $row['staffroleid'];
		$staffrole = getrole($staffroleid, 'label');

		$status = $row['status'];
		$status_label = $row['status'];
		if($staff_email != '') { $staff_email = $staff_email; } else { $staff_email = '--'; }

		
	   echo "{";
	   echo '"counter": "'.$counter.'",';
	   echo '"staff_code": "'.$staff_code.'",';
	   echo '"staffname": "'.$fullname.'",';
	   echo '"staff_email": "'.$staff_email.'",';
	   echo '"staff_mobile": "'.$staff_mobile.'",';
	   echo '"staffroleid": "'.$staffrole.'",';
	   echo '"status": "'.$status.'",';
	   echo '"status_label": "'.$status_label.'",';
	   echo '"modify": "'.$staff_id.'"';	   
	
		if ($counter > 0 && $counter != $count_staff_list) {
		   echo ' },';
		} else {
		   echo ' }';
		}
	
			} //end of while loop
		
	
//echo '{"count":"", "categoryname":"", "status":"", "modify":"" }';
$data_formatted = substr(trim($datas), 0, -1);
echo $data_formatted;
echo "]}";
?>