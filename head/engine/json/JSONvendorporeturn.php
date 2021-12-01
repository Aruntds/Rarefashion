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

//conditioning
if(!empty($show)) {
	$showcondition = "and `status`='$show'";
}

//'`customergroup`','`customerfirst`','`customerlast`','`customeremail`','`customerdob`','`customergender`','`customerphone`','`customeraddress1`','`customeraddress2`','`customerpincode`','`customerstate`','`customercountry`','`status`'

echo "{";
echo '"data":[';
  $list_category_data = sqlQUERY_LABEL("SELECT * FROM `js_vendor_po_return` where deleted = '0' {$showcondition} order by vpor_id desc") or die("#1-Unable to get PRODUCT CATEGORY:".sqlERROR_LABEL());

  $count_cateogry_list = sqlNUMOFROW_LABEL($list_category_data);

  while($row = sqlFETCHARRAY_LABEL($list_category_data)){
	  $counter++;
	  $vpor_id = $row["vpor_id"];
	  $vpor_no = $row["vpor_no"];
	  $vpor_vpo_ref_no = $row['vpo_ref_no'];
	  $get_vpo_id = getVENDORPOdetails($vpor_vpo_ref_no,'vpoid','');
	  //$split_vpo_ref_no_1 = (explode("-",$vpor_vpo_ref_no)[0]);
	  //$split_vpo_ref_no_2 = (explode("-",$vpor_vpo_ref_no)[1]);
	  //$split_vpo_id = (explode("-",$vpor_vpo_ref_no)[2]);
	  //$selected_vpor_vpo_ref_no = $split_vpo_ref_no_1.'-'.$split_vpo_ref_no_2;
	  $vpor_date = dateformat_datepicker($row["vpor_date"]);
	  $vpor_tot_items = $row["vpor_tot_items"];
	  $vpor_tot_qty = $row["vpor_tot_qty"];
	  $vpo_item_returned_qty = getVENDOR_PO_ITEM_QTY($get_vpo_id, 'sum_of_vpo_item_returned_qty');
	  $vpo_item_qty = getVENDOR_PO_ITEM_QTY($get_vpo_id, 'sum_of_vpo_item_qty');
	  $vpo_item_grn_status = getVENDOR_PO_ITEM_QTY($get_vpo_id, 'vpo_item_grn_status');
	  $vpor_tot_value = general_currency_symbol.' '.moneyFormatIndia($row["vpor_tot_value"],2);
	  $vpor_tot_tax = general_currency_symbol.' '.moneyFormatIndia($row["vpor_tot_tax"],2);  
	  $status_val = $row["status"];  
	  //$status = getVendorStatus($row["status"],'vendorpor');
	  $get_status_partial_return = "<span class='text-warning tx-bold'>Partially Returned<span>";
	  $get_status_draft = "<span class='text-secondary tx-bold'>Draft<span>";
	  $get_status_full_return = "<span class='text-danger tx-bold'>Full Qty Returned<span>";
	
		     $datas .= "{";
			   $datas .= '"count": "'.$counter.'",';
			   $datas .= '"vpor_no": "'.$vpor_no.'",';
			   $datas .= '"vpor_date": "'.$vpor_date.'",';			   
			   $datas .= '"selected_vpor_vpo_ref_no": "'.$vpor_vpo_ref_no.'",';
			   if($vpo_item_returned_qty == '0'){ 
			   $datas .= '"status": "'.$get_status_draft.'",';
			   } elseif($vpo_item_grn_status != '0' && $vpo_item_returned_qty < $vpo_item_qty && $vpo_item_returned_qty !='0') {
			   $datas .= '"status": "'.$get_status_partial_return.'",';
			   } elseif($vpo_item_qty == $vpo_item_returned_qty){
			   $datas .= '"status": "'.$get_status_full_return.'",';
			   }
			   $datas .= '"modify": "'.$vpor_id.'"';
		   $datas .= " },";
	
			} //end of while loop
		
	
//echo '{"count":"", "categoryname":"", "status":"", "modify":"" }';
$data_formatted = substr(trim($datas), 0, -1);
echo $data_formatted;
echo "]}";
?>