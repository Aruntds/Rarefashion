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

$return_arr = array();
// OR `contact_fname` LIKE '%$customer%'
 $getprdbrand_query = sqlQUERY_LABEL("SELECT `vpo_no` FROM `js_vendorpo` where (vpo_no like '%$title%') and `status`='3' and vpo_grn_status='1' and deleted='0'") or die("#particular title CODE: ".sqlERROR_LABEL());
 
 if(sqlNUMOFROW_LABEL($getprdbrand_query)) {
	while ($fetched_customer_record = sqlFETCHARRAY_LABEL($getprdbrand_query, MYSQL_ASSOC)) {

			$vpo_no = $fetched_customer_record['vpo_no'];
			$customer_data_array['title'] = $vpo_no;

		//$row_array['prdt_name'] = $row['prdt_name'];
		array_push($return_arr,$customer_data_array);
	}
} else {
	$customer_data_array['title'] = "$title-No Records";
	array_push($return_arr,$customer_data_array);
}

echo json_encode($return_arr);

?>