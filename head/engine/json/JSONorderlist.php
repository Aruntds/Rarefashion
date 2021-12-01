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
    $filter_customer_user_ID = getCUSTOMER_DATA($filter_customer,'user_id');
	$filter_customer_user_id = " and od_userid = '$filter_customer_user_ID' ";
}

if($since_from !='' && $since_to !=''){
	$filterby_date = " and DATE(od_date) between '$since_from' and '$since_to'";
}

//echo "SELECT od_id, od_refno, od_date, od_userid, od_shipping_address1, od_total, od_discount_type, od_payment_status, od_status FROM `js_shop_order` where deleted = '0' {$filterby_date} {$filter_customer_user_id} order by od_id desc";
echo "{";
echo '"data":[';
	
  $list_producttype_data = sqlQUERY_LABEL("SELECT od_id, od_refno, od_date, od_userid, od_shipping_address1, od_total, od_discount_type, od_payment_status, od_status FROM `js_shop_order` where deleted = '0' {$filterby_date} {$filter_customer_user_id} order by od_id desc") or die("#1-Unable to get PRODUCT UNIT:".sqlERROR_LABEL());

  $count_producttype_list = sqlNUMOFROW_LABEL($list_producttype_data);

  while($row = sqlFETCHARRAY_LABEL($list_producttype_data)){
	  $counter++;
	  $od_id = $row["od_id"];
	  $ref_no = $row["od_refno"];
	  $od_userid = $row["od_userid"];
	  $od_date = dateformat_datepicker($row["od_date"]);
	  $total_item = getORDER_COUNT($row["od_userid"],'customers_name');
	  $overall_price = general_currency_symbol.' '.($row["od_total"]);
	  $tax =  $row["od_discount_type"];
	  $discount = $row["od_discount_type"];
	  $payement_status = getorder_paymentSTATUS(1,'',$row["od_payment_status"],'label');
	  $order_status = getorder_paymentSTATUS(2,'',$row["od_status"],'label');
	  $customers_name = getCUSTOMERDETAILS($row["od_userid"],'name');
	  $customer_total_order = customerTOTALSALES($od_userid, 'customer_order');
		$total_orders += $customer_total_order;
	  if($customers_name == ''){
		  $customers_name = 'Self';
	  }	  
	  if($discount == '0'){
		  $discount = EMPTYFIELD;
	  }	    
	  if($tax == '0'){
		  $tax = EMPTYFIELD;
	  }	 
	  if($ref_no == ''){
		  $ref_no = EMPTYFIELD;
	  }
	  if($total_item == ''){
		  $total_item = EMPTYFIELD;
	  }
	  if($order_status == ''){
		  $order_status = EMPTYFIELD;
	  } 
	  if($payement_status == ''){
		  $payement_status = EMPTYFIELD;
	  }
	  
		   $datas .= "{";
			   $datas .= '"count": "'.$counter.'",';
			   $datas .= '"ref_no": "'.$ref_no.'",';
			   $datas .= '"od_date": "'.$od_date.'",';
			   $datas .= '"customers_name": "'.$customers_name.'",';
			   $datas .= '"total_item": "'.$customer_total_order.'",';
			   $datas .= '"overall_price": "'.$overall_price.'",';
			   $datas .= '"tax": "'.$tax.'",';
			   $datas .= '"discount": "'.$discount.'",';
			   $datas .= '"payement_status": "'.$payement_status.'",';
			   $datas .= '"order_status": "'.$order_status.'",';
			   $datas .= '"modify": "'.$od_id.'"';
		   $datas .= " },";
	
			} //end of while loop
		
	
//echo '{"count":"", "categoryname":"", "status":"", "modify":"" }';
$data_formatted = substr(trim($datas), 0, -1);
echo $data_formatted;
console.log($data_formatted);
echo "]}";
?>