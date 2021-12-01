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
reguser_protect();

if($type == 'show_remarks') {

	$list_datas = sqlQUERY_LABEL("SELECT prdt_remarks FROM `js_vendor_po_items` where vpo_item_id = '$vpo_item_ID' and deleted = '0'") or die("Unable to get records:".sqlERROR_LABEL());		
	while($row_value = sqlFETCHARRAY_LABEL($list_datas)){
	  $prdt_remarks = $row_value['prdt_remarks'];
	}
	echo 'Remarks : '.$prdt_remarks;
}
?>