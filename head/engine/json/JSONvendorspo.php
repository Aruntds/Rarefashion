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
include_once('../../jackus.php');

echo "{";
echo '"data":[';

  $list_category_data = sqlQUERY_LABEL("SELECT * FROM `js_vendorpo` where deleted = '0' order by vpo_id desc") or die("#1-Unable to get PRODUCT CATEGORY:".sqlERROR_LABEL());

  $count_cateogry_list = sqlNUMOFROW_LABEL($list_category_data);

  while($row = sqlFETCHARRAY_LABEL($list_category_data)){
	  $counter++;
	  $vpo_id = $row["vpo_id"];
	  $vpo_no = $row["vpo_no"];
	  $vpo_date = dateformat_datepicker($row["vpo_date"]);
	  $prdttype_id = $row["prdttype_id"];
	  $product_type = getPRODUCTTYPE($prdttype_id,'productype');	
	  $vendor_id = $row["vendor_id"];
	  $vendor_name = getVENDORNAME($vendor_id,'vendorname');
	  $vpo_tot_items = $row["vpo_tot_items"];
	  $vpo_tot_qty = $row["vpo_tot_qty"];
	  $vpo_item_received = getVENDOR_PO_ITEM_QTY($vpo_id, 'vpo_item_received');
	  $vpo_item_qty = getVENDOR_PO_ITEM_QTY($vpo_id, 'vpo_item_qty');
	  $vpo_item_approved = getVENDOR_PO_ITEM_QTY($vpo_id, 'vpo_item_approved');
	  $vpo_item_grn_status = getVENDOR_PO_ITEM_QTY($vpo_id, 'vpo_item_grn_status');
	  $vpo_tot_value = general_currency_symbol.' '.moneyFormatIndia($row["vpo_tot_value"]);
	  $vpo_tot_tax = general_currency_symbol.' '.moneyFormatIndia($row["vpo_tot_tax"]);
	  $vpo_grn_on = dateformat_datepicker($row["vpo_grn_on"]);
	  $vendor_name = getVENDORNAME($row["vendor_id"],'label');	
	  $status = getVendorStatus($row["status"],'vendorpo');	
	  $status_id = $row["status"];
	  $get_vpo_grn_status = "<span class='text-warning tx-bold'>GRN Partially Generated<span>";
	  $vpo_rejected = "<span class='text-danger tx-bold'>Rejected<span>";
	  
		   $datas .= "{";
			   $datas .= '"count": "'.$counter.'",';
			   $datas .= '"vpo_no": "'.$vpo_no.'",';
			   $datas .= '"vpo_date": "'.$vpo_date.'",';
			   $datas .= '"vpo_grn_on": "'.$vpo_grn_on.'",';
			   $datas .= '"product_type": "'.$product_type.'",';
			   $datas .= '"vendor_name": "'.$vendor_name.'",';
			   if($vpo_item_qty != $vpo_item_received && $vpo_item_grn_status !='0' && $vpo_item_approved == '1'){ 
			   $datas .= '"status": "'.$get_vpo_grn_status.'",';
			   } else if($status_id == '6') {
			   $datas .= '"status": "'.$vpo_rejected.'",';
			   } else {
			   $datas .= '"status": "'.$status.'",';
			   }
			   $datas .= '"status_id": "'.$status_id.'",';
			   $datas .= '"vpo_tot_items": "'.$vpo_tot_items.'",';
			   $datas .= '"vpo_tot_qty": "'.$vpo_tot_qty.'",';
			   $datas .= '"vpo_tot_value": "'.$vpo_tot_value.'",';
			   $datas .= '"vpo_tot_tax": "'.$vpo_tot_tax.'",';
			   
			   $datas .= '"modify": "'.$vpo_id.'"';                              
		   $datas .= " },";
	
			} //end of while loop
		
	
//echo '{"count":"", "categoryname":"", "status":"", "modify":"" }';
$data_formatted = substr(trim($datas), 0, -1);
echo $data_formatted;
echo "]}";
?>
