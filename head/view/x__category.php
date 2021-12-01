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
	
	$get_categoryID = sqlQUERY_LABEL("select categoryID from js_category where categoryID = '$delete_id'") or die(mysql_error());
	
	$count_rows = sqlNUMOFROW_LABEL($get_categoryID);
	
	if($count_rows == '1' ) { 
		
		//check parent of child category
		$check_parentcategoryAVAILABLE = commonNOOFROWS_COUNT('js_category', "`categoryparentID`='$delete_id'");
		
		//check any product created under this catgeory
		if($check_parentcategoryAVAILABLE == '0') {
			echo "<div class='col-lg-12'>This action cannot be revoked...!!!<br /><br />";
			echo "<hr><a href='category.php?action=delete&id=".$delete_id."' class='btn btn-success btn-sm'>Delete</a>";
			echo "<a href='javascript:;' class='btn btn-danger btn-sm' data-dismiss='modal' style='margin-left:20px'> Close</a></div>";
		} else { 
			echo "<div class='col-lg-12 ht-100'>Sorry cannot delete category<br /><br />
			<b class='text-danger'>Reason</b>
			- Remove Sub-Category before deleting parent category.<br /><br />
			</div>";
			//check category used in any products..!!!
			echo "<hr><a href='javascript:;' class='btn btn-danger btn-sm' data-dismiss='modal' style='margin-left:20px'> Close</a></div>";
		}
	} else {
		echo "<div class='col-lg-12'>Sorry cannot delete category<br /><br />
			<b class='text-danger'>Reason</b>
			- No category available to delete.<br /><br />
			</div>";
		echo "<hr><a href='javascript:;' class='btn btn-danger btn-sm' data-dismiss='modal' style='margin-left:20px'> Close</a></div>";
	}
	
}

if($type == 'changestatus') {
	
	if($oldstatus == '1') {
		$category_status = '0';
	} elseif($oldstatus == '0') {
		$category_status = '1';
	}
	
	//Update query
	$arrFields=array('`status`');

	$arrValues=array("$category_status");

	$sqlWhere= "categoryID=$categoryID";

	return sqlACTIONS("UPDATE","js_category",$arrFields,$arrValues, $sqlWhere);
}