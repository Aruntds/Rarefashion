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

if($since_from !='' && $since_to !=''){
	$filterby_date = " and DATE(B.`createdon`) between '$since_from' and '$since_to'";
}

echo "{";
echo '"data":[';
  $list_producttype_data = sqlQUERY_LABEL("SELECT B.`od_price` as PRICE, B.`od_qty` as QTY, B.`item_tax_type` as TAX, B.`pd_id` as PD_ID FROM `js_shop_order` as A, `js_shop_order_item` as B WHERE B.`od_id` = A.`od_id` AND A.`status` = 0 AND A.`deleted` = 0 AND DATE(A.createdon) < CURRENT_DATE() {$filterby_date}") or die("#1-Unable to get Cart List:".sqlERROR_LABEL());

  $count_producttype_list = sqlNUMOFROW_LABEL($list_producttype_data);

  while($row = sqlFETCHARRAY_LABEL($list_producttype_data)){
	  $counter++;
	  $product_price = general_currency_symbol.' '.convertCASH($row["PRICE"]);
	  $order_quantity = $row["QTY"];
	  $item_tax = $row["TAX"];
	 // $product_name = getPRODUCTNAME($row["PD_ID"]);
	  $order_price = general_currency_symbol.' '.convertCASH($row["QTY"] * $row["PRICE"]);
	  if($product_name == ''){
		  $product_name = 'Self';
	  }	  
	  
		   $datas .= "{";
			   $datas .= '"count": "'.$counter.'",';
			   $datas .= '"product_name": "'.$product_name.'",';
			   $datas .= '"product_price": "'.$product_price.'",';
			   $datas .= '"order_quantity": "'.$order_quantity.'",';
			   $datas .= '"order_price": "'.$order_price.'"';
		   $datas .= " },";
	
			} //end of while loop
		
	
//echo '{"count":"", "categoryname":"", "status":"", "modify":"" }';
$data_formatted = substr(trim($datas), 0, -1);
echo $data_formatted;
echo "]}";
?>