<?php 
extract($_REQUEST);

include '../head/jackus.php';

if($product_var_id != '' || $product_var_id != '0'){
	
	$cart_product = sqlQUERY_LABEL("SELECT `variant_ID`, `parentproduct`, `variant_msp_price`, FROM `js_productvariants` where variant_ID='$product_var_id' and deleted = '0' and status = '1'") or die("#1-Unable to get records:".mysqli_error());
	while($variant_product = sqlFETCHARRAY_LABEL($cart_product)){
		
		$variant_product_price = $variant_product['variant_msp_price'];
		
	}
	
	//$get_shop_order_item_variant = sqlQUERY_LABEL("SELECT ")
	
} else {
	
	
	
}
$arrFields=array('`deleted`');

$arrValues=array("1");

//print_r ($arrValues); exit();

$sqlWhere = "pd_id='$product_ID'";

if(sqlACTIONS("UPDATE","js_shop_order_item",$arrFields, $arrValues, $sqlWhere)){


}

?>