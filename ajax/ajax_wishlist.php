<?php 

extract($_REQUEST);

include '../head/jackus.php';


$cart_product = sqlQUERY_LABEL("SELECT * FROM `js_wishlist` where wish_userid='$customer_id' and wish_prdtid ='$product_id' and product_variant_id = '$product_size' and deleted = '0' and status = '1'") or die("#1-Unable to get records:".mysqli_error());

 $count_wishlist_list = sqlNUMOFROW_LABEL($cart_product);
if($count_wishlist_list > 0) {

$data = array('status' => 'Error', 'msg' => 'Updated');
		  								 								  
}else{
	 
$arrFields=array('`wish_userid`','`wish_prdtid`','`product_variant_id`','`status`');

$arrValues=array("$customer_id","$product_id","$product_size","1");

if(sqlACTIONS("INSERT","js_wishlist",$arrFields,$arrValues, '')){

$data = array('status' => 'Success', 'msg' => 'INSERT');

}
	 
 }
	
	

header('Content-Type: application/json');
echo json_encode($data);
?>