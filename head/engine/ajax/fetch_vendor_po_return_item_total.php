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
include_once('../../jackus.php');
protectpg_includes();

	$vpor_id_ref = $_GET['vpor_id_ref'];
	
	//`vpor_item_id`, `vpor_id`, `prdt_id`, `vpor_item_qty`, `vpor_item_price`, `vpor_item_tax`, `vpor_item_tax1`, `vpor_item_tax2`, `vpor_item_total`, `vpor_item_grn_status`, `vpor_item_createdon`, `vpor_item_updatedon`, `status` FROM `adisil_vendor_po_return_items`
		$selectpo_itemlist = sqlQUERY_LABEL("select count(*) as po_itemcount, SUM(vpor_item_total) AS po_totalpaid, SUM(vpor_item_qty) AS po_totalqty, SUM(vpor_item_tax1) AS po_totaltax1, SUM(vpor_item_tax2) AS po_totaltax2 FROM `js_vendor_po_return_items` where `vpor_id`='$vpor_id_ref'") or die(sqlERROR_LABEL());
		//$count_vpor_itemlist = sqlNUMOFROW_LABEL($selectpo_itemlist);
		$collect_itemlist_data = sqlFETCHOBJECT_LABEL($selectpo_itemlist);
		?>
		
        <div class="investment-summary" style="float:left; padding-right: 20px;">
			<span class="info-label" style="display:inline;">Total:</span>
			<span class="inv-green"><strong><?php echo number_format($collect_itemlist_data->po_totalpaid, 2); ?></strong></span>
		</div>
		<div class="investment-summary" style="float:left; padding-right: 20px;">
			<span class="info-label" style="display:inline;">Total Item:</span>
			<span class="inv-green"><strong><?php echo $collect_itemlist_data->po_itemcount; ?></strong></span>
		</div>
		<div class="investment-summary" >
			<span class="info-label" style="display:inline;">Total Qty:</span>
			<span class="inv-green"><strong><?php echo $collect_itemlist_data->po_totalqty; ?></strong></span>
		</div>
        <input type="hidden" name="total_po_amount"  value="<?php echo $collect_itemlist_data->po_totalpaid; ?>" />
        <input type="hidden" name="total_po_tax" value="<?php echo ($collect_itemlist_data->po_totaltax1 + $collect_itemlist_data->po_totaltax2); ?>"  />
        <input type="hidden" name="total_po_item" value="<?php echo $collect_itemlist_data->po_itemcount; ?>"/>
        <input type="hidden" name="total_po_qty" value="<?php echo $collect_itemlist_data->po_totalqty; ?>" />                        
        <?php
?>