<?php 

extract($_REQUEST);

include_once('../../jackus.php');

reguser_protect();

		$selectpo_itemlist = sqlQUERY_LABEL("select count(*) as po_itemcount, SUM(vpo_after_discount_item_total) AS po_after_discounted_item_total, SUM(vpo_item_total) AS po_totalpaid, SUM(vpo_item_qty) AS po_totalqty, SUM(vpo_item_tax1) AS po_totaltax1, SUM(vpo_item_tax2) AS po_totaltax2 FROM `js_vendor_po_items` where `vpo_id`='$vpo_id_ref'") or die(sqlERROR_LABEL());
		//$count_vpo_itemlist = sqlNUMOFROW_LABEL($selectpo_itemlist);
		$collect_itemlist_data = sqlFETCHOBJECT_LABEL($selectpo_itemlist);
		?>
        <div class="investment-summary" style="float:left; padding-right: 20px;">
			<span class="info-label" style="display:inline;">Total:</span>
			<span class="inv-green"><strong><?php echo number_format($collect_itemlist_data->po_after_discounted_item_total, 2); ?></strong></span>
		</div>
        <div class="investment-summary" style="float:left; padding-right: 20px;">
			<span class="info-label" style="display:inline;">Total Tax:</span>
			<span class="inv-green"><strong><?php echo number_format(($collect_itemlist_data->po_totaltax1 + $collect_itemlist_data->po_totaltax2), 2); ?></strong></span>
		</div>
		<div class="investment-summary" style="float:left; padding-right: 20px;">
			<span class="info-label" style="display:inline;">Total Item:</span>
			<span class="inv-green"><strong><?php echo $collect_itemlist_data->po_itemcount; ?></strong></span>
		</div>
		<div class="investment-summary" >
			<span class="info-label" style="display:inline;">Total Qty:</span>
			<span class="inv-green
			"><strong><?php echo $collect_itemlist_data->po_totalqty; ?></strong></span>
		</div>
		<input type="hidden" id="vpo_id_for_list" name="vpo_id_for_list" value="<?php echo $vpo_id_ref; ?>" />
        <input type="hidden" value="<?php echo $collect_itemlist_data->po_after_discounted_item_total; ?>" name="total_po_amount" />
        <input type="hidden" value="<?php echo ($collect_itemlist_data->po_totaltax1 + $collect_itemlist_data->po_totaltax2); ?>" name="total_po_tax" />
        <input type="hidden" value="<?php echo $collect_itemlist_data->po_itemcount; ?>" name="total_po_item" />
        <input type="hidden" value="<?php echo $collect_itemlist_data->po_totalqty; ?>" name="total_po_qty" />                        
        <?php
	exit();

?>
