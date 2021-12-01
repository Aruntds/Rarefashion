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
//Dont place PHP Close tag at the bottom

extract($_REQUEST);
include_once('../jackus.php');

if($type == 'delete') {
	
	$get_productID = sqlQUERY_LABEL("select productID from js_product where productID = '$delete_id' and deleted='0'") or die(mysql_error());
	
	$count_rows = sqlNUMOFROW_LABEL($get_productID);
	
	if($count_rows == '1' ) { 
		
			echo "<div class='col-lg-12'>This action cannot be revoked...!!!<br /><br />";
			echo "<hr><a href='product.php?action=delete&id=".$delete_id."' class='btn btn-success btn-sm'>Delete</a>";
			echo "<a href='javascript:;' class='btn btn-danger btn-sm' data-dismiss='modal' style='margin-left:20px'> Close</a></div>";
			
	} else {
		echo "<div class='col-lg-12'>Sorry cannot delete Product<br /><br />
			<b class='text-danger'>Reason</b>
			- No Product available to delete.<br /><br />
			</div>";
		echo "<hr><a href='javascript:;' class='btn btn-danger btn-sm' data-dismiss='modal' style='margin-left:20px'> Close</a></div>";
	}
	
}

if($type == 'variant_delete') {
	
	echo "<div class='col-lg-12'>This action cannot be revoked...!!!<br /><br />";
	echo "<hr><a href='product.php?action=delete_variant&id=".$delete_id."&parant_prdt_id=".$parant_prdt_id."' class='btn btn-success btn-sm'>Delete</a>";
	echo "<a href='javascript:;' class='btn btn-danger btn-sm' data-dismiss='modal' style='margin-left:20px'> Close</a></div>";
	

}

if($type == 'changestatus') {
	
	if($oldstatus == '1') {
		$product_status = '0';
	} elseif($oldstatus == '0') {
		$product_status = '1';
	}
	
	//Update query
	$arrFields=array('`status`');

	$arrValues=array("$product_status");

	$sqlWhere= "productID=$productID";

	return sqlACTIONS("UPDATE","js_product",$arrFields,$arrValues, $sqlWhere);
}

if($type == 'changestockstatus') {
	
	if($oldstatus == '1') {
		$productstock_status = '0';
	} elseif($oldstatus == '0') {
		$productstock_status = '1';
	}
	
	//Update query
	$arrFields=array('`productstockstatus`');

	$arrValues=array("$productstock_status");

	$sqlWhere= "productID=$productID";

	return sqlACTIONS("UPDATE","js_product",$arrFields,$arrValues, $sqlWhere);
}