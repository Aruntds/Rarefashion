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
	
		$check_pagemenu_AVAILABLE = sqlQUERY_LABEL("select * from  js_pagemenu where `page_ID`='$delete_id' and status='1'") or die(sqlERROR_LABEL());
	
			$count_rows = sqlNUMOFROW_LABEL($check_pagemenu_AVAILABLE);
		
			echo "<div class='col-lg-12'>This action cannot be revoked...!!!<br /><br />";
			echo "<hr><a href='pagemenu.php?action=delete&id=".$delete_id."' class='btn btn-success btn-sm'>Delete</a>";
			echo "<a href='javascript:;' class='btn btn-danger btn-sm' data-dismiss='modal' style='margin-left:20px'> Close</a></div>";
	
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

	$sqlWhere= "page_ID=$page_ID";
	return sqlACTIONS("UPDATE","js_pagemenu",$arrFields,$arrValues, $sqlWhere);
}