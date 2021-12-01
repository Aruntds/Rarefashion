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
	if(strpos($title,':')){
		$product_id = trim(strbefore($title, ':'));
		$vendorpor = trim(strafter($title, ':'));
		$vendorpoid = getVENDORPOdetails($vendorpor,'vpoid',''); 
		//$filter_produt = "vpo_id = '$vendorpo_id' and  prdt_id = '$product_id' and vpo_item_received != '0' and deleted = '0' ";
	}
  //else{
	//$filter_produt =  " (prdt_name like '%$title%' or prdt_code like '%$title%') ";
//}
 $getprdbrand_query = sqlQUERY_LABEL("SELECT `prdt_id`,vpo_no FROM `js_vendor_po_items` as poitem,js_vendorpo as po WHERE po.status = 3 and (vpo_no like '%$vendorpor%' or poitem.prdt_id like '%$product_id%') and po.vendor_id = '$prvendor_id' and po.vpo_id = poitem.vpo_id and poitem.vpo_item_received != '0' and po.deleted = 0 and poitem.vpo_item_grn_status ='1'") or die("#particular title CODE: ".sqlERROR_LABEL());
 
 if(sqlNUMOFROW_LABEL($getprdbrand_query)) {
	while ($fetched_customer_record = sqlFETCHARRAY_LABEL($getprdbrand_query, MYSQL_ASSOC)) {
	
			$prdt_id = $fetched_customer_record['prdt_id'];
			$vpo_no = $fetched_customer_record['vpo_no'];
			$customer_data_array['title'] = $prdt_id.':'.$vpo_no;
		//$row_array['prdt_name'] = $row['prdt_name'];
		array_push($return_arr,$customer_data_array);
	}
} 
// else {
	// $customer_data_array['title'] = "$title-No Products found";
	// array_push($return_arr,$customer_data_array);
// }

  echo json_encode($return_arr);

?>