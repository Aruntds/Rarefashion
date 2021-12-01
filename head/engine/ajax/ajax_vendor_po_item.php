

<?php 

extract($_REQUEST);

include_once('../../jackus.php');

reguser_protect();

	// $po_main_refid;
	// $po_product_type;
	// $po_vendor_type;
	// $po_product_id;
	// $po_product_qty;
	// $po_product_price;
	// $po_product_tax;
	//echo $po_product_type .'-'.$po_vendor_type.'-'.$po_product_id;exit();
	if($type == 'vendorpo')
	{
		//if($po_product_type != '0' && $po_vendor_type != '0' && $po_product_id != '0') {
			if($po_vendor_type != '0' && $po_product_id != '0') {
			//total price
			
			if($po_tax_type == 'Y' && $po_product_tax !='0') {
			if($po_discount_value !='' && $po_discount_value !='0'){
			$new_totalprice = ($po_product_price * $po_product_qty);
			$po_discount_amt = (($new_totalprice * $po_discount_value)/100);
			$po_after_dicount_price = ($new_totalprice - $po_discount_amt);
			$tax_split_amount = ((($po_after_dicount_price * $po_product_tax)/100)/2);
			} else {
			$tax_amount_Y = (($po_product_price * $po_product_tax)/100);
			$po_product_price = ($po_product_price - $tax_amount_Y);
			$tax_split_amount = (($po_product_qty * $tax_amount_Y)/2);
			$new_totalprice = ($po_product_price * $po_product_qty);
			$po_discount_amt = ((($po_product_price * $po_product_qty) * $po_discount_value)/100);
			$po_after_dicount_price = ($new_totalprice - $po_discount_amt);
			}
			} else if($po_tax_type == 'Y' && $po_product_tax =='0') {
			if($po_discount_value !='' && $po_discount_value !='0'){
			$new_totalprice = ($po_product_price * $po_product_qty);
			$po_discount_amt = (($new_totalprice * $po_discount_value)/100);
			$po_after_dicount_price = ($new_totalprice - $po_discount_amt);
			$tax_split_amount = 0;
			} else {
				$new_totalprice = ($po_product_price * $po_product_qty);
				$po_product_price = $po_product_price;
				$tax_split_amount = 0;
			}
			} else {
			if($po_discount_value !='' && $po_discount_value !='0'){
			$new_totalprice = ($po_product_price * $po_product_qty);
			$po_discount_amt = (($new_totalprice * $po_discount_value)/100);
			$po_after_dicount_price = ($new_totalprice - $po_discount_amt);
			$tax_split_amount = ((($po_after_dicount_price * $po_product_tax)/100)/2);
			} else {
			$po_product_price = $po_product_price;
			$new_totalprice = ($po_product_price * $po_product_qty);
			//tax split
			$po_discount_amt = ((($po_product_price * $po_product_qty) * $po_discount_value)/100);
			$po_after_dicount_price = ($new_totalprice - $po_discount_amt);
			$tax_split_amount = ($new_totalprice * ($po_product_tax/100))/2;
			}
			}
			
			//$po_discount_amt = ((($po_product_price * $po_product_qty) * $po_discount_value)/100);
			
			//$po_after_dicount_price = ($new_totalprice - $po_discount_amt);
			
			$po_after_dicount_vpo_total = ($po_after_dicount_price + $tax_split_amount + $tax_split_amount);
			
			//echo $tax_split_amount ;exit();
			$new_totalprice = $new_totalprice + $tax_split_amount  + $tax_split_amount;
			//checking  if purchasing product already added
			$get_selected_product_id = sqlQUERY_LABEL("select `vpo_item_id`, `vpo_item_qty`, `vpo_item_price`, `vpo_item_tax`, `vpo_item_tax1`, `vpo_item_tax2`, `vpo_item_total` from `js_vendor_po_items` where `prdt_id`='$po_product_id' and `vpo_id`='$po_main_refid'") or die(sqlERROR_LABEL());
			$counting_available_product = sqlNUMOFROW_LABEL($get_selected_product_id);
			
			$po_prdt_remarks = htmlentities($po_prdt_remarks);
			
			if($counting_available_product == 0) {
				sqlQUERY_LABEL("INSERT into `js_vendor_po_items` (`vpo_id`, `prdt_id`, `prdt_serialno`, `vpo_item_qty`, `vpo_item_price`, `vpo_item_tax`, `vpo_item_tax1`, `vpo_item_tax2`, `vpo_item_total`, `vpo_discount_value`, `vpo_discount_amt`, `vpo_after_discount_price`, `vpo_after_discount_item_total`, `prdt_remarks`, `status`, `vpo_item_updatedon`) VALUES ('$po_main_refid', '$po_product_id', '$po_prdt_serialno', '$po_product_qty', '$po_product_price', '$po_product_tax', '$tax_split_amount', '$tax_split_amount', '$new_totalprice', '$po_discount_value', '$po_discount_amt', '$po_after_dicount_price', '$po_after_dicount_vpo_total', '$po_prdt_remarks', '1', '".date('Y-m-d H:i:s')."')") or die("#1 Unable to add PO Item:" . sqlERROR_LABEL());
				$get_poitem_id = sqlINSERTID_LABEL();
			} else {
				
				while($fetch_productid = sqlFETCHARRAY_LABEL($get_selected_product_id)) {
					$old_item_id = $fetch_productid['vpo_item_id'];
					$old_item_qty = $fetch_productid['vpo_item_qty'];
					$old_item_total = $fetch_productid['vpo_item_total'];
					$old_item_tax1 = $fetch_productid['vpo_item_tax1'];
					$old_item_tax2 = $fetch_productid['vpo_item_tax2'];
				}
				
					$add_newqty = ($old_item_qty+$po_product_qty);
					$add_newprice = ($old_item_total) + ($po_product_price * $po_product_qty);
					$add_newtax_split = ($old_item_tax1 + $old_item_tax2) + ($new_totalprice * ($po_product_tax/100))/2;;

				$get_poitem_id = sqlQUERY_LABEL("UPDATE `js_vendor_po_items` SET `vpo_item_qty`='$add_newqty', `vpo_item_total`='$add_newprice',  `vpo_item_tax1`='$add_newtax_split', `vpo_item_tax2`='$add_newtax_split' WHERE vpo_item_id = '$old_item_id'") or die(sqlERROR_LABEL());
			}
			
			if($get_poitem_id) {
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
					fetchvpo_data();
					fetchvpo_totals_data();
				</script>                                     
            <?php
			
			}
		} else {
			echo "<span class='text-danger small'>Unable to add PO Item record<span>";
		}
		 exit();
	}
	
	if($type == 'removepo') {

		$remove_vendor_po_id =  sqlQUERY_LABEL("DELETE FROM js_vendor_po_items WHERE vpo_item_id = '$po_product_id'")or die("There was a problem while deleting: ". sqlERROR_LABEL());
		echo "Record Deleted";
	?>
		<script type="text/javascript">
            fetchvpo_data();
            fetchvpo_totals_data();
        </script>                                           
    <?php
	}
?>
