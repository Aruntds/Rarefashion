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


if($type == 'changestatus') {
	
	if($oldstatus == '1') {
		$rating_status = '0';
	} elseif($oldstatus == '0') {
		$rating_status = '1';
	}
	
	//Update query
	$arrFields=array('`status`');

	$arrValues=array("$rating_status");

	$sqlWhere= "review_ID=$ratingID";

	return sqlACTIONS("UPDATE","js_review",$arrFields,$arrValues, $sqlWhere);
}