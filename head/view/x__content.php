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

//`contentID`, `contentname`, `contentimage`, `contentdescrption`, `contentseourl`, `contentmetatitle`, `contentmetakeywords`, `contentmetadescrption`, `contentdesignsettings`, `createdby`, `createdon`, `updatedon`, `status`, `deleted` FROM `js_content`
if($type == 'delete') {
	
	$get_contentID = sqlQUERY_LABEL("select contentID from js_content where contentID = '$delete_id'") or die(mysql_error());
	
	$count_rows = sqlNUMOFROW_LABEL($get_contentID);
	
	if($count_rows == '1' ) { 
		
			echo "<div class='col-lg-12'>This action cannot be revoked...!!!<br /><br />";
			echo "<hr><a href='content.php?action=delete&id=".$delete_id."' class='btn btn-success btn-sm'>Delete</a>";
			echo "<a href='javascript:;' class='btn btn-danger btn-sm' data-dismiss='modal' style='margin-left:20px'> Close</a></div>";

	} else {
		echo "<div class='col-lg-12'>Sorry cannot delete content<br /><br />
			<b class='text-danger'>Reason</b>
			- No content available to delete.<br /><br />
			</div>";
		echo "<hr><a href='javascript:;' class='btn btn-danger btn-sm' data-dismiss='modal' style='margin-left:20px'> Close</a></div>";
	}
	
}

if($type == 'changestatus') {
	
	if($oldstatus == '1') {
		$content_status = '0';
	} elseif($oldstatus == '0') {
		$content_status = '1';
	}
	
	//Update query
	$arrFields=array('`status`');

	$arrValues=array("$content_status");

	$sqlWhere= "contentID=$contentID";

	return sqlACTIONS("UPDATE","js_content",$arrFields,$arrValues, $sqlWhere);
}