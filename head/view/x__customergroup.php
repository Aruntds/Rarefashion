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

//`categoryID`, `categoryparentID`, `categoryname`, `categoryimage`, `categorydescrption`, `categoryseourl`, `categorymetatitle`, `categorymetakeywords`, `categorymetadescrption`, `categorydesignsettings`, `createdby`, `createdon`, `updatedon`, `status`, `deleted` FROM `js_category`
if($type == 'delete') {
	
	$get_categoryID = sqlQUERY_LABEL("select customergrouptitle from js_customergroup where customergroupID = '$delete_id'") or die(mysql_error());
	while($row = sqlFETCHARRAY_LABEL($get_categoryID)){
	  $customergroup = $row["customergrouptitle"];
	 }
	 
	$check_parentcategoryAVAILABLE = sqlQUERY_LABEL("select * from js_customergroup where`customergroupID`='$customergroup' and status='0'") or die(mysql_error());
	
	 
	// $check_parentcategoryAVAILABLE = commonNOOFROWS_COUNT('js_customergroup', "customergroupID ='$customergroup' and status='1'");
	$count_rows = sqlNUMOFROW_LABEL($check_parentcategoryAVAILABLE);
	
	if($count_rows == '0' ) { 
		
			echo "<div class='col-lg-12'>This action cannot be revoked...!!!<br /><br />";
			echo "<hr><a href='customergroup.php?action=delete&id=".$delete_id."' class='btn btn-success btn-sm'>Delete</a>";
			echo "<a href='javascript:;' class='btn btn-danger btn-sm' data-dismiss='modal' style='margin-left:20px'> Close</a></div>";
	
	} else {
		echo "<div class='col-lg-12'>Sorry cannot delete this Customer Group<br /><br />
			<b class='text-danger'>Reason</b>
			- Customer group is active.<br /><br />
			</div>";
		echo "<hr><a href='javascript:;' class='btn btn-danger btn-sm' data-dismiss='modal' style='margin-left:20px'> Close</a></div>";
	}
	
}

if($type == 'changestatus') {
	
	if($oldstatus == '1') {
		$customergroupstatus = '0';
	} elseif($oldstatus == '0') {
		$customergroupstatus = '1';
	}
	
	//Update query
	$arrFields=array('`status`');

	$arrValues=array("$customergroupstatus");

	$sqlWhere= "customergroupID=$customergroupID";

	return sqlACTIONS("UPDATE","js_customergroup",$arrFields,$arrValues, $sqlWhere);
}