<?php

extract($_REQUEST);

include '../head/jackus.php';


//echo "$customer_id","$product_id";
//echo $product_qty.','.$product_ID; exit();

$arrFields=array('`deleted`');

$arrValues=array("1");

//print_r ($arrValues); exit();

$sqlWhere = "pd_id='$product_ID'";

if(sqlACTIONS("UPDATE","js_shop_order_item",$arrFields, $arrValues, $sqlWhere)){

	// $query= "SELECT SUM(od_qty) AS totalsum FROM `js_shop_order_item`";
	// $result = sqlQUERY_LABEL($query);
	
	/*while($row = sqlFETCHARRAY_LABEL($result))
	{
		echo  $row['totalsum'];
	}
	$cart_query= "SELECT * FROM `js_shop_order_item` ORDER BY pd_id";
	$cart_result = sqlQUERY_LABEL($cart_query);
	
	while($cart_row = sqlFETCHARRAY_LABEL($cart_result))
	{
		//$product_ID = $cart_row['pd_id'];
		echo $cart_row['od_qty'];
	
		echo $cart_row['od_price'];
		
		echo $cart_row['od_qty'] * $cart_row['od_price'];
		
		$cart_product = sqlQUERY_LABEL("SELECT `productmetatitle`, sum(productsellingprice) as subtotal FROM `js_product` where productID='$product_ID' and deleted = '0' and status = '1'") or die("#1-Unable to get records:".mysql_error());
		while($featured_product = sqlFETCHARRAY_LABEL($cart_product)){
		//$product_title = $featured_product["productmetatitle"];
		
		$total_cart_price += ($product_qty * $product_price);
		}
	}*/
	
}

?>