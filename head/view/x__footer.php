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
	
	$get_homeiconID = sqlQUERY_LABEL("select * from js_footer where footer_ID = '$delete_id'") or die(mysql_error());
	
	$count_rows = sqlNUMOFROW_LABEL($get_homeiconID);
	
	if($count_rows != '0' ) { 
				
			echo "<div class='col-lg-12'>This action cannot be revoked...!!!<br /><br />";
			echo "<hr><a href='footer.php?action=delete&id=".$delete_id."' class='btn btn-success btn-sm'>Delete</a>";
			echo "<a href='javascript:;' class='btn btn-danger btn-sm' data-dismiss='modal' style='margin-left:20px'> Close</a></div>";
			
	} else {
		echo "<div class='col-lg-12'>Sorry cannot delete Slider<br /><br />
			<b class='text-danger'>Reason</b>
			- No Slider available to delete.<br /><br />
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

	$sqlWhere= "footer_ID=$footer_ID";

	return sqlACTIONS("UPDATE","js_footer",$arrFields,$arrValues, $sqlWhere);
}