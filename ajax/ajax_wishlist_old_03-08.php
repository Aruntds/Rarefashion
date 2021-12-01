<?php 

extract($_REQUEST);

include '../head/jackus.php';


//echo "$customer_id","$product_id";
$arrFields=array('`wish_userid`','`wish_prdtid`');

$arrValues=array("$customer_id","$product_id");

if(sqlACTIONS("INSERT","js_wishlist",$arrFields,$arrValues, '')){

$data = array('status' => 'Success', 'msg' => 'Updated');

}
header('Content-Type: application/json');
echo json_encode($data);
?>