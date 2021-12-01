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

	$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_shop_order` WHERE od_payment_status = '1' and deleted = '0' ORDER BY od_id DESC") or die("Unable to get records:".sqlERROR_LABEL());

	$fetch_list = sqlNUMOFROW_LABEL($list_datas);

	while($fetch_records = sqlFETCHARRAY_LABEL($list_datas)){

		$counter++;
		$id = $fetch_records['od_id'];
		$od_userid = $fetch_records['od_userid'];
		$od_qty = getORDERQTY($id, $od_userid);
		$customer_name = getCUSTOMERDETAILS($od_userid, 'name');
		$od_refno = $fetch_records['od_refno'];
		$od_payment_id = $fetch_records['od_razorpay_payment_id'];
		$od_payment_mode = $fetch_records['od_payment_mode'];
		$status = getorder_paymentSTATUS(2,'',$fetch_records['od_status'],'label');
		$paymentstatus = getorder_paymentSTATUS(1,'',$fetch_records['od_payment_status'], 'label');
		//echo $fetch_records['od_status'];
		$payment ="<span class='text-primary'>fulfilled</span></br>";	
		$itemDiscount = $fetch_records['itemDiscount'];
		$subTotal = $fetch_records['od_total'];
		$od_date = $fetch_records['od_date'];
		$od_date = date('jS M, Y, h:m A',strtotime($od_date));
		if($od_payment_id == ''){
			$od_payment_id = "N/A";
		}
		if($driver_email == ''){$driver_email = 'N/A';}
			if($od_qty == '' || $od_qty == '0'){$od_qty = 'N/A';}
	 	   $datas .= "{";
			   $datas .= '"count": "'.$counter.'",';
			   $datas .= '"od_refno": " '.$od_refno.'",';
			   $datas .= '"od_date": "'.$od_date.'",';
			   $datas .= '"customer_name": "'.$customer_name.'",';
			   $datas .= '"payment_id": "'.$od_payment_id.'",';
			   $datas .= '"orderstatus": "'.$status.'",';
			   $datas .= '"payment": "'.$paymentstatus.'",';
			   $datas .= '"payment_mode": "'.$od_payment_mode.'",';
			   $datas .= '"total": "'.general_currency_symbol.' '.formatCASH($subTotal).'",';
			   $datas .= '"modify": "'.$id.'"';
		   $datas .= "},";
			} //end of while loop

//echo '{"count":"", "categoryname":"", "status":"", "modify":"" }';
$data_formatted = substr(trim($datas), 0, -1);
echo $data_formatted;
echo "]}";

?>