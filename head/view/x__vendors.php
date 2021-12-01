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
	
		$check_categoryAVAILABLE = sqlQUERY_LABEL("select * from js_brand where `vendor_id`='$delete_id' and deleted='0'") or die(sqlERROR_LABEL());
	   if(sqlNUMOFROW_LABEL($check_categoryAVAILABLE)  == '0'){

			echo "<div class='col-lg-12'>This action cannot be revoked...!!!<br /><br />";
			echo "<hr><a href='vendors.php?route=delete&id=".$delete_id."' class='btn btn-success btn-sm'>Delete</a>";
			echo "<a href='javascript:;' class='btn btn-danger btn-sm' data-dismiss='modal' style='margin-left:20px'> Close</a></div>";
	   }else{
		  echo "<div class='col-lg-12'>Sorry cannot delete Vendor--!!!<br /><br />
			<b class='text-danger'>Reason</b>
			- Vendor is used in Brand. <br /><br />
			</div>";
		echo "<hr><a href='javascript:;' class='btn btn-danger btn-sm' data-dismiss='modal' style='margin-left:20px'> Close</a></div>"; 
		   
	   }
	}

if($type == 'changestatus') {
	
	if($oldstatus == '1') {
		$status = '0';
	} elseif($oldstatus == '0') {
		$status = '1';
	}
	
	//Update query
	$arrFields=array('`status`');

	$arrValues=array("$status");

	$sqlWhere= "vendor_id=$vendor_id";
	return sqlACTIONS("UPDATE","js_vendor",$arrFields,$arrValues, $sqlWhere);
}