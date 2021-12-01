<?php 

extract($_REQUEST);

include '../head/jackus.php';
if($type == 'delete'){
	
	$list_product_datas = sqlQUERY_LABEL("SELECT * FROM `js_shipping_address` where deleted = '0' and `customerID`='$customer_id' and Id=$cardid") or die("#1-Unable to get records:".sqlERROR_LABEL());
		
	$count_product_list = sqlNUMOFROW_LABEL($list_product_datas);
	 // echo $count_product_list;	exit();
	 
	if($count_product_list != '0'){
		//echo "$customer_id","$product_id";
		$arrFields=array('`deleted`');

		$arrValues=array("1");

		$sqlWhere= "`customerID`='$customer_id' and Id = $cardid";

		if(sqlACTIONS("UPDATE","js_shipping_address",$arrFields,$arrValues,$sqlWhere)){
			$data = array('status' => 'Success', 'msg' => 'Added' );
		}
	}
}

header('Content-Type: application/json');
echo json_encode($data);


?>