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
	$filterby_date = " and DATE(createdon) between '$since_from' and '$since_to'";
}

echo "{";
echo '"data":[';
//echo "SELECT PRDT.producttitle AS PRODUCT_NAME, VARIANT.variant_name AS VARIANT_NAME, ORDER_ITEM.pd_id, SUM(ORDER_ITEM.od_qty) AS TOTAL_QTY, SUM(ORDER_ITEM.od_price) AS OD_PRICE, ORDER_ITEM.variant_id FROM `js_shop_order_item` ORDER_ITEM LEFT JOIN `js_shop_order` SHOP_ORDER ON SHOP_ORDER.od_id = ORDER_ITEM.od_id LEFT JOIN `js_product` PRDT ON PRDT.productID = ORDER_ITEM.pd_id and ORDER_ITEM.variant_id = '0' LEFT JOIN `js_productvariants` VARIANT ON VARIANT.variant_ID = ORDER_ITEM.variant_id GROUP BY ORDER_ITEM.pd_id,ORDER_ITEM.variant_id ORDER BY SUM(ORDER_ITEM.od_price) DESC";exit();
  $list_producttype_data = sqlQUERY_LABEL("SELECT PRDT.producttitle AS PRODUCT_NAME, VARIANT.variant_name AS VARIANT_NAME, ORDER_ITEM.pd_id, SUM(ORDER_ITEM.od_qty) AS TOTAL_QTY, SUM(ORDER_ITEM.od_price) AS OD_PRICE, ORDER_ITEM.variant_id FROM `js_shop_order_item` ORDER_ITEM LEFT JOIN `js_shop_order` SHOP_ORDER ON SHOP_ORDER.od_id = ORDER_ITEM.od_id LEFT JOIN `js_product` PRDT ON PRDT.productID = ORDER_ITEM.pd_id and ORDER_ITEM.variant_id = '0' LEFT JOIN `js_productvariants` VARIANT ON VARIANT.variant_ID = ORDER_ITEM.variant_id GROUP BY ORDER_ITEM.pd_id,ORDER_ITEM.variant_id ORDER BY SUM(ORDER_ITEM.od_price) DESC") or die("#1-Unable to get PRODUCT UNIT:".sqlERROR_LABEL());

  $count_producttype_list = sqlNUMOFROW_LABEL($list_producttype_data);

  while($row = sqlFETCHARRAY_LABEL($list_producttype_data)){
	  $counter++;
	  $order_quantity = $row["TOTAL_QTY"];
	  $order_price = general_currency_symbol.' '.convertCASH($row["OD_PRICE"]);
	  $product_name = $row["PRODUCT_NAME"];
	 // echo $product_name;exit();
	  $variant_name = $row["VARIANT_NAME"];
	  if($product_name != '' && $variant_name == ''){
		  $product_title = $product_name;
	  } else if($product_name == '' && $variant_name != ''){
		  $product_title = $variant_name;
	  } else if($product_name == '' && $variant_name == ''){
		  $product_title = 'Self';
	  }
	  
		   $datas .= "{";
			   $datas .= '"count": "'.$counter.'",';
			   $datas .= '"product_name": "'.$product_title.'",';
			   $datas .= '"order_quantity": "'.$order_quantity.'",';
			   $datas .= '"order_price": "'.$order_price.'"';
		   $datas .= " },";
	
			} //end of while loop
		
	
//echo '{"count":"", "categoryname":"", "status":"", "modify":"" }';
$data_formatted = substr(trim($datas), 0, -1);
echo $data_formatted;
echo "]}";
?>