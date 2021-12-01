<?php 


extract($_REQUEST);

include_once('../../jackus.php');


reguser_protect();

	$po_vpor_id = $_POST['po_main_refid'];
	//$po_product_type = $_POST['po_product_type'];
	$po_vendor_type = $_POST['po_vendor_type'];
	$po_product_id = $_POST['po_product_id'];
	$po_product_qty = $_POST['po_product_qty'];
	$po_product_price = $_POST['po_product_price'];
	$po_product_tax = $_POST['po_product_tax'];
	
	//`vpor_item_id`, `vpor_id`, `prdt_id`, `vpor_item_qty`, `vpor_item_price`, `vpor_item_tax`, `vpor_item_tax1`, `vpor_item_tax2`, `vpor_item_total`, `vpor_item_grn_status`, `vpor_item_createdon`, `vpor_item_updatedon`, `status` FROM `adisil_vendor_po_return_items`
	if($_GET['type'] == 'vendorpo')
	{
		if($po_vendor_type != '0' && $po_product_id != '0') {
			
			//total price
			$new_totalprice = ($po_product_price * $po_product_qty);
			//tax split
			$tax_split_amount = ($new_totalprice * ($po_product_tax/100))/2;
			$new_totalprice = $new_totalprice + $tax_split_amount  + $tax_split_amount;
			//checking  if purchasing product already added
			$get_selected_product_id = sqlQUERY_LABEL("select `vpor_item_id`, `vpor_item_qty`, `vpor_item_price`, `vpor_item_tax`, `vpor_item_tax1`, `vpor_item_tax2`, `vpor_item_total` from `js_vendor_po_return_items` where `prdt_id`='$po_product_id' and `vpor_id`='$po_vpor_id' and vpo_id='$vpo_id'") or die(sqlERROR_LABEL());
			$counting_available_product = sqlNUMOFROW_LABEL($get_selected_product_id);
			
			if($counting_available_product == 0) {
				$arrFields=array('`vpor_id`','`prdt_id`','`vpor_item_qty`','`vpor_item_price`','`vpor_item_tax`','`vpor_item_tax1`','`vpor_item_tax2`','`vpor_item_total`','`status`','`vpo_id`');

				$arrValues=array("$po_vpor_id","$po_product_id","$po_product_qty","$po_product_price","$po_product_tax","$tax_split_amount","$tax_split_amount","$new_totalprice","1","$vpo_id");

				if(sqlACTIONS("INSERT","js_vendor_po_return_items",$arrFields,$arrValues,'')) {
				$get_poitem_id = sqlINSERTID_LABEL();
				
				}
			} else {
				
				while($fetch_productid = sqlFETCHARRAY_LABEL($get_selected_product_id)) {
					$get_poitem_id = $fetch_productid['vpor_item_id'];
					$old_item_qty = $fetch_productid['vpor_item_qty'];
					$old_item_total = $fetch_productid['vpor_item_total'];
					$old_item_tax1 = $fetch_productid['vpor_item_tax1'];
					$old_item_tax2 = $fetch_productid['vpor_item_tax2'];
				}
				
					$add_newqty = ($old_item_qty+$po_product_qty);
					$add_newprice = ($old_item_total) + ($po_product_price * $po_product_qty);
					$add_newtax_split = ($old_item_tax1 + $old_item_tax2) + ($new_totalprice * ($po_product_tax/100))/2;;
				$arrFields=array('`vpor_item_qty`','`vpor_item_total`','`vpor_item_tax1`','`vpor_item_tax2`');

				$arrValues=array("$add_newqty","$add_newprice","$add_newtax_split","$add_newtax_split");
				$sqlwhere = "vpor_item_id = '$get_poitem_id'";
				if(sqlACTIONS("UPDATE","js_vendor_po_return_items",$arrFields,$arrValues,$sqlwhere)) {
				}
			}
			
			if($get_poitem_id) {
				
			/*	$selectpo_itemlist = sqlQUERY_LABEL("select `prdt_id`, `vpor_item_qty`, `vpor_item_price`, `vpor_item_tax`, `vpor_item_total` FROM `adisil_vendor_po_return_items` where `vpor_item_id`='$get_poitem_id'") or die(sqlERROR_LABEL());
				while($collect_poitem_list = sqlFETCHARRAY_LABEL($selectpo_itemlist)) {
					$counter++;
					$product_id = $collect_poitem_list['prdt_id'];
					$product_item_qty = $collect_poitem_list['vpor_item_qty'];
					$product_item_price = $collect_poitem_list['vpor_item_price'];
					$product_item_tax = $collect_poitem_list['vpor_item_tax'];
					$product_item_total = $collect_poitem_list['vpor_item_total'];
			?>
            <tr>
                <td><?php echo $counter; ?></td>
                <td><?php echo getPRODUCTDETAIL($product_id, 'code'); ?></td>
                <td><?php echo getPRODUCTDETAIL($product_id, 'name'); ?></td>
                <td><?php echo $product_item_qty; ?></td>
                <td><?php echo number_format($product_item_price, 2); ?></td>
                <td><?php echo $product_item_tax.' %'; ?></td>
                <td><?php echo number_format($product_item_total, 2); ?></td>
                <td>Edit</td>
            </tr>
            <?php
			}  //end of vendor po item */
			?>
                <div id="hidden_productcode">
				<div class="row">
                    <div class="form-group col-sm-2">
                    <label class="control-label">Product Code</label>
                    <input type="text" class="form-control" readonly="readonly" name="prdt_code" id="prdt_code">
                    </div>
                    <div class="form-group col-sm-4">
                    <label class="control-label">Product Name</label>
                    <input type="text" class="form-control" placeholder="Product Name" readonly="readonly" name="prdt_name" id="prdt_name">
                    </div>
                    <div class="form-group col-sm-2">
                    <label class="control-label">Product Qty</label>
                    <input type="text" class="form-control" placeholder="Qty" readonly="readonly" name="prdt_roq" id="prdt_roq">
                    </div>
                    <div class="form-group col-sm-2">
                    <label class="control-label">Product Price</label>
                    <input type="text" class="form-control" placeholder="Price" readonly="readonly" name="prdt_purchase_price" id="prdt_purchase_price">
                    </div>
                    <?php /*?><div class="form-group col-sm-1">
                    <label class="control-label">TAX (in %)</label>
                    <input type="text" class="form-control" placeholder="Tax" readonly="readonly" name="prdt_tax" id="prdt_tax">
                    </div><?php */?>
                    <div class="form-group col-sm-1">
                    <br />
                    </div>
				</div>
                </div>        
                <div class="clearfix"></div>                        
                <script type="text/javascript">
					fetchvpor_data();
					fetchvpor_totals_data();
				</script>                                       
            <?php
			
			}
		} else {
			echo "<span class='text-danger small'>Unable to add PO Item record<span>";
		}
		 exit();
	}
	
	if($_GET['type'] == 'removepo') {

		$po_item_id = $_POST['po_product_id'];

		$remove_vendor_po_return_id =  sqlQUERY_LABEL("DELETE FROM js_vendor_po_return_items WHERE vpor_item_id = '$po_item_id'")or die("There was a problem while deleting: ". sqlERROR_LABEL());
		echo "Record Deleted";
	?>
		<script type="text/javascript">
            fetchvpor_data();
            fetchvpor_totals_data();
        </script>                                           
    <?php
	}
?>