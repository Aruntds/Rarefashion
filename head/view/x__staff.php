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
	//echo "select * from  js_staff where `staff_id`='$delete_id' and deleted='0'";exit();
		$check_categoryAVAILABLE = sqlQUERY_LABEL("select * from  js_staff where `staff_id`='$delete_id' and deleted='0'") or die(sqlERROR_LABEL());
		
			echo "<div class='col-lg-12'>This action cannot be revoked...!!!<br /><br />";
			echo "<hr><a href='staff.php?action=delete&id=".$delete_id."' class='btn btn-success btn-sm'>Delete</a>";
			echo "<a href='javascript:;' class='btn btn-danger btn-sm' data-dismiss='modal' style='margin-left:20px'> Close</a></div>";
	
	}

if($type == 'changestatus') {
	
	if($oldstatus == '1') {
		$status = '0';
	} elseif($oldstatus == '0') {
		$status = '1';
	}
	//inactive user in user table
	$list_users = sqlQUERY_LABEL("SELECT * FROM `js_users` where deleted = '0' and `staff_id`='$staff_id'") or die("Unable to get records:".sqlERROR_LABEL());		
	$check_record = sqlNUMOFROW_LABEL($list_users);
	if($status == '0' && $check_record > '0'){
		$arrFields=array('`userbanned`');

		$arrValues=array("1");
		$sqlwhere = "staff_id='$staff_id'";
		if(sqlACTIONS("UPDATE","js_users",$arrFields,$arrValues,$sqlwhere)) {
		}
	}elseif($check_record > '0'){
		$arrFields=array('`userbanned`');

		$arrValues=array("0");
		$sqlwhere = "staff_id='$staff_id'";
		if(sqlACTIONS("UPDATE","js_users",$arrFields,$arrValues,$sqlwhere)) {
		}
	}
						
	//Update query
	$arrFields=array('`status`');

	$arrValues=array("$status");

	$sqlWhere= "staff_id=$staff_id";
	return sqlACTIONS("UPDATE","js_staff",$arrFields,$arrValues, $sqlWhere);
	
	
}