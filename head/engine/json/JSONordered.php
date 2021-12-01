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
	$filterby_date = " and DATE(A.createdon) between '$since_from' and '$since_to'";
}

echo "{";
echo '"data":[';
  $list_producttype_data = sqlQUERY_LABEL("SELECT A.od_refno, B.pd_id, B.od_qty, B.od_price, B.createdon FROM js_shop_order A, js_shop_order_item B WHERE A.od_id = B.od_id AND A.od_status = 1 {$filterby_date} GROUP BY B.pd_id" ) or die("#1-Unable to get PRODUCT UNIT:".sqlERROR_LABEL());

  $count_producttype_list = sqlNUMOFROW_LABEL($list_producttype_data);

  while($row = sqlFETCHARRAY_LABEL($list_producttype_data)){
	  $counter++;
	  $od_refno = $row["od_refno"];
	  $order_quantity = $row["od_qty"];
	  $order_price = general_currency_symbol.' '.convertCASH($row["od_price"]);
	  $od_date = dateformat_datepicker($row["createdon"]);
	  $product_name = getPRODUCTNAME($row["pd_id"]);
	  if($product_name == ''){
		  $product_name = 'Self';
	  }	  
	  
		   $datas .= "{";
			   $datas .= '"count": "'.$counter.'",';
			   $datas .= '"od_refno": "'.$od_refno.'",';
			   $datas .= '"product_name": "'.$product_name.'",';
			   $datas .= '"order_quantity": "'.$order_quantity.'",';
			   $datas .= '"order_price": "'.$order_price.'",';
			   $datas .= '"od_date": "'.$od_date.'"';
		   $datas .= " },";
	
			} //end of while loop
		
	
//echo '{"count":"", "categoryname":"", "status":"", "modify":"" }';
$data_formatted = substr(trim($datas), 0, -1);
echo $data_formatted;
echo "]}";
?>