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

if($since_from !='' && $since_to !=''){
	$filterby_date = " and DATE(createdon) between '$since_from' and '$since_to'";
}


echo "{";
echo '"data":[';

	$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_shop_order` where deleted = '0' and od_status != '0' and od_payment_status != '0' {$filterby_date} order by od_id desc") or die("Unable to get records:".sqlERROR_LABEL());

	$fetch_list = sqlNUMOFROW_LABEL($list_datas);

	while($fetch_records = sqlFETCHARRAY_LABEL($list_datas)){

		$counter++;
		
		$id = $fetch_records['od_id'];
		$od_userid = $fetch_records['od_userid'];
		$od_qty = getORDERQTY($id, $od_userid);
		$customer_name = getCUSTOMERDETAILS($od_userid, 'name');
		$od_refno = $fetch_records['od_refno'];
		$firstName = $fetch_records['od_shipping_first_name'];	
		$od_refno = $od_refno;
		$shipping = getCUSTOMERADDRESS($id,'shipping');	
		$billing = getCUSTOMERADDRESS($id,'billing');	
		$status = getorder_paymentSTATUS(2,'',$fetch_records['od_status'],'label');
		$paymentstatus = getorder_paymentSTATUS(1,'',$fetch_records['od_payment_status'], 'label');
		//echo $fetch_records['od_status'];
		$payment ="<span class='text-primary'>fulfilled</span></br>";	
		$itemDiscount = $fetch_records['itemDiscount'];
		$subTotal = $fetch_records['od_total'];
		$line1 = $fetch_records['line1'];
		$city = $fetch_records['city'];
		$od_date = $fetch_records['od_date'];

		$date = dateformat_datepicker($od_date);
		
		if($customer_name == ''){$customer_name = 'N/A';}
		if($od_refno == ''){$od_refno = 'N/A';}
		if($driver_email == ''){$driver_email = 'N/A';}
			if($od_qty == '' || $od_qty == '0'){$od_qty = 'N/A';}
	 	   $datas .= "{";
			   $datas .= '"count": "'.$counter.'",';
			   $datas .= '"order": " '.$od_refno.'",';
			   $datas .= '"date": "'.$date.'",';
			   $datas .= '"customer_name": "'.$customer_name.'",';
			   $datas .= '"od_qty": "'.$od_qty.'",';
			   $datas .= '"shipping": "'.$shipping.'",';
			   $datas .= '"orderstatus": "'.$status.'",';
			   $datas .= '"payment": "'.$paymentstatus.'",';
			   $datas .= '"total": "'.general_currency_symbol.' '.($subTotal).'",';
			   $datas .= '"modify": "'.$id.'"';
		   $datas .= "},";
			} //end of while loop

//echo '{"count":"", "categoryname":"", "status":"", "modify":"" }';
$data_formatted = substr(trim($datas), 0, -1);
echo $data_formatted;
echo "]}";

?>