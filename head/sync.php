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
include_once('jackus.php');

extract($_GET);

if(isset($action) && $action=='search_estore_product'){
	$info=array();
	$data = json_decode($_POST['data'] , true);
	$where="";
	
	if(isset($data['sku_code']) && $data['sku_code']!=''){
	$result = sqlQUERY_LABEL("SELECT estore_item_ID, estore_prdt_ID, estore_vpo_item_ID, estore_prdt_name, estore_prdt_code, estore_prdt_unit_price, estore_prdt_mrp, estore_prdt_msp, estore_prdt_size, estore_prdt_qty, estore_prdt_uom, estore_prdt_expiry_on, status FROM js_estock_prdt_list WHERE (estore_prdt_code like '%".$data['sku_code']."%') and deleted ='0'",$link);
	}
	
	//echo "SELECT * FROM oc_membership_package_details ".$where."";
	while($row = sqlFETCHARRAY_LABEL($result,MYSQLI_ASSOC)){
	array_push($info,$row);
	}
	echo json_encode($info);
	exit;
}

if(isset($action) && $action=='select_estore_product_data'){
	$info=array();
	$data = json_decode($_POST['data'] , true);
	$where="";
	
	if(isset($data['sku_code']) && $data['sku_code']!=''){
	$result = sqlQUERY_LABEL("SELECT estore_item_ID, estore_prdt_ID, estore_vpo_item_ID, estore_prdt_name, estore_prdt_code, estore_prdt_unit_price, estore_prdt_mrp, estore_prdt_msp, estore_prdt_size, estore_prdt_qty, estore_prdt_uom, estore_prdt_expiry_on, status FROM js_estock_prdt_list WHERE deleted ='0' and estore_prdt_code='".$data['sku_code']."'",$link);
	}
	
	//echo "SELECT * FROM oc_membership_package_details ".$where."";
	while($row = sqlFETCHARRAY_LABEL($result,MYSQLI_ASSOC)){
	array_push($info,$row);
	}
	echo json_encode($info);
	exit;
}

?>
