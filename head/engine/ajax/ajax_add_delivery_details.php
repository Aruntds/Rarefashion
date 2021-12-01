<?php 
extract($_REQUEST);

include '../../jackus.php';
	
	if($count > '0') {
		
	$shipping_date = dateformat_database($shipping_date);
	$delivery_date = dateformat_database($delivery_date);
	
	//Time From
	$new_time_from = DateTime::createFromFormat('h:i A', $time_from);
	$time_from_24 = $new_time_from->format('H:i:s');
	
	//Time To
	$new_time_to = DateTime::createFromFormat('h:i A', $time_to);
	$time_to_24 = $new_time_to->format('H:i:s');
	
	/* $time_from = date('h:i:s',$time_from);
	$time_to = date('h:i:s',$time_to); */
	
	$arrFields = array('`od_id`', '`carrier_name`', '`shipping_date`', '`delivery_date`', '`time_from`', '`time_to`', '`status`');

	$arrValues = array("$id", "$carrier", "$shipping_date", "$delivery_date", "$time_from_24", "$time_to_24", "1");

	$sqlWhere = "od_id = '$id'";
	
	if(sqlACTIONS("UPDATE","js_delivery_details",$arrFields,$arrValues, $sqlWhere)){
		
	
		$data = array('status' => 'Success', 'msg' => 'order_details_saved' );
		
		$description = "Delivery Details Updated";
		
		$arrFields_log = array('`pd_id`', '`od_id`', '`log_description`','`status`');
		
		$arrValues_log = array("$product_id", "$id", "$description", "1");

		if(sqlACTIONS("INSERT","js_shop_order_log",$arrFields_log,$arrValues_log, '')){
			
			
			
		}
		
		
	}
	
		
	} else{
		
		$shipping_date = dateformat_database($shipping_date);
	$delivery_date = dateformat_database($delivery_date);
	
	//Time From
	$new_time_from = DateTime::createFromFormat('h:i A', $time_from);
	$time_from_24 = $new_time_from->format('H:i:s');
	
	//Time To
	$new_time_to = DateTime::createFromFormat('h:i A', $time_to);
	$time_to_24 = $new_time_to->format('H:i:s');
	
	/* $time_from = date('h:i:s',$time_from);
	$time_to = date('h:i:s',$time_to); */
	
	$arrFields = array('`od_id`', '`carrier_name`', '`shipping_date`', '`delivery_date`', '`time_from`', '`time_to`', '`status`');

	$arrValues = array("$id", "$carrier", "$shipping_date", "$delivery_date", "$time_from_24", "$time_to_24", "1");

	//$sqlWhere = "od_id = '$id'";
	
	if(sqlACTIONS("INSERT","js_delivery_details",$arrFields,$arrValues, '')){
		
	
		$data = array('status' => 'Success', 'msg' => 'order_details_saved' );
		
		$description = "Delivery Details Inserted";
		
		$arrFields_log = array('`pd_id`', '`od_id`', '`log_description`','`status`');
		
		$arrValues_log = array("$product_id", "$id", "$description", "1");

		if(sqlACTIONS("INSERT","js_shop_order_log",$arrFields_log,$arrValues_log, '')){
			
			
			
		}
		
		
	}
		
	}
	

header('Content-Type: application/json');
echo json_encode($data);


?>