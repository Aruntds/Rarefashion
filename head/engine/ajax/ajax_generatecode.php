<?php 

extract($_REQUEST);

include_once('../../jackus.php');


if($_GET['type'] == 'product_type_search') { 
		
		$po_product_code_n_name = trim($product_id);
		$product_code = strbefore($po_product_code_n_name, ':');
		
		$list_product_name = sqlQUERY_LABEL("SELECT productID FROM js_product WHERE productsku = '$product_code'") or die("#1-Unable to get records:".sqlERROR_LABEL());
		while($row_cus = sqlFETCHARRAY_LABEL($list_product_name)){
		  $product_ID = $row_cus["productID"];
		}
		
		$getproduct_lists = sqlQUERY_LABEL("SELECT `productID`, `producttitle`, `productsku`,`productsellingprice` FROM `js_product` where productID='$product_ID' and deleted = '0' order by producttitle ASC") or die(sqlERROR_LABEL());
		$totalproduct_list = sqlNUMOFROW_LABEL($getproduct_lists);
		while($productrecord_lists=sqlFETCHARRAY_LABEL($getproduct_lists)) {
			$productID = $productrecord_lists['productID'];
			// $producttitle = htmlspecialchars($productrecord_lists['producttitle']); 
			$producttitle = html_entity_decode($productrecord_lists['producttitle'], ENT_QUOTES, "UTF-8");
			$producttitle = str_replace("\'","'",$producttitle);
			$productsku = $productrecord_lists['productsku'];
			$productsellingprice = $productrecord_lists['productsellingprice'];
		    
		}
		?>
        <div id="hidden_productcode">
		  <?php if($totalproduct_list > 0) {  //&& $check_vendor_brand_available > 0?>
			<div class="row">
				<div class="form-group col-sm-2">
					<label class="control-label">Product Code</label>
					<input type="text" class="form-control" onkeypress="return blockSpecialChar(event)" value="<?php echo $productsku; ?>" name="productsku" id="productsku" readonly>
				</div>
				<div class="form-group col-sm-3">
					<label class="control-label">Product Name</label>
					<input type="text" class="form-control" onkeypress="return blockSpecialChar(event)" placeholder="Product Name" value="<?php echo $producttitle; ?>" name="producttitle" id="producttitle" readonly>
				</div>
 				<div class="form-group col-sm-2">
					<label class="control-label">Product Price</label>
					<input type="text" class="form-control item_price" placeholder="Product Price" value="<?php echo $productsellingprice; ?>" name="prdt_purchase_price" id="prdt_purchase_price" readonly>
				</div>
				 
				<div class="form-group col-sm-1 mg-md-t-7">
					<br />
					<input type="hidden" value="<?php echo $productID; ?>" name="choosen_prdt_id" id="choosen_prdt_id" />
					<input type="hidden" value="<?php echo $prdt_gst_included; ?>" name="tax_type" id="tax_type" />
					<input type="button" class="btn btn-success" name="add_item" id="add_item" onclick="get_productitem_List();" value="ADD">
				</div>
				 <?php 
				} else { 
					echo "<p class='text-danger text-center'>No Product Available.<p>";
				}
				?>
            </div>			
        </div>        
        <div class="clearfix"></div>
       <?php
	}

if($_prdt_rs_id != '') {
	$invoice_choosen = getRETURN_STOCK_PRODUCT_DATA($_prdt_rs_id, 'invoice_id');  
	//getting choosen invoice id
	$defect_ticket_choosen = getRETURN_STOCK_PRODUCT_DATA($_prdt_rs_id, 'get_defect_ticket_id');
	//getting choosen ticket id
	$ticket_choosen = getRETURN_STOCK_PRODUCT_DATA($_prdt_rs_id, 'ticket_id');
//	$vpo_choosen = getRETURN_STOCK_PRODUCT_DATA($_prdt_rs_id, 'vpo_return_id');
	//getting choosen ticket id
    $tkt_others_id = getRETURN_STOCK_PRODUCT_DATA($_prdt_rs_id, 'rsdc_reasonid');
	//getting choosen ticket id
	$tkt_others_reason = getRETURN_STOCK_PRODUCT_DATA($_prdt_rs_id, 'rsdc_reason_notes');

	$defect_type_id = getRETURN_STOCK_PRODUCT_DATA($_prdt_rs_id, 'defect_type_id');
	
	$defect_others_reason = getRETURN_STOCK_PRODUCT_DATA($_prdt_rs_id, 'defect_reason_notes');
	
	//getting choosen ticket id
	$vpo_choosen = getRETURN_STOCK_PRODUCT_DATA($_prdt_rs_id, 'vpo_return_id');

}

if($_prdt_ts_id !=''){
	
	$taken_ticket_id = $taken_ticket_id;
}
//pr_branch_type
if($_GET['type'] == 'customer_product_po') {
		
		$po_product_code_n_name = trim($product_id);
		$product_code = strbefore($po_product_code_n_name, ':');
		$received_product_id = getPRODUCTDETAIL($product_code, '');
		
		//if (strpos($po_product_code_n_name, '-') !== false || strlen($po_product_code_n_name) <= 8) {
		if (strpos($po_product_code_n_name, ':') !== false) {
			
			$filter_barcode_phrase = "prdt_id = '$received_product_id' and";
			
		} elseif(strlen($po_product_code_n_name) > 15) {
			
			$filter_barcode_phrase = "default_barcode = '$po_product_code_n_name' and";
		}
		
		if($pr_branch_type != '') {
			$filterby_branch_type = "prdt_type = '$pr_branch_type' and";
		}
		
		//substr($str,3,3)
		//echo "SELECT `prdt_id`, `prdt_name`, `prdt_code`, `prdt_purchase_price`, `prdt_tax`, `prdt_roq` FROM `js_product` where {$filter_barcode_phrase} {$filterby_branch_type} deleted = '0' order by prdt_name ASC";
		$get_po_product_lists = sqlQUERY_LABEL("SELECT `prdt_id`, `prdt_name`, `prdt_code`, `prdt_purchase_price`, `prdt_tax`, `prdt_roq` FROM `js_product` where {$filter_barcode_phrase}  deleted = '0' order by prdt_name ASC") or die(sqlERROR_LABEL());
		$total_po_product_list = sqlNUMOFROW_LABEL($get_po_product_lists);
		while($product_po_record_lists=sqlFETCHARRAY_LABEL($get_po_product_lists)) {
			$prdt_id = $product_po_record_lists['prdt_id'];
			$prdt_name = htmlspecialchars($product_po_record_lists['prdt_name']); 
			$prdt_code = $product_po_record_lists['prdt_code'];
			$prdt_serial_number = $product_po_record_lists["prdt_serailno"];
			$prdt_purchase_price = $product_po_record_lists['prdt_purchase_price'];
			$prdt_tax = $product_po_record_lists['prdt_tax'];
			$prdt_roq = $product_po_record_lists['prdt_roq'];
		}
		//echo $po_product_code_n_name;
		//echo $product_code;
		//echo $prdt_id;
//echo $received_product_id;
		
		//exit();
		?>
        <div id="hidden_productcode">
		  <?php if($total_po_product_list > 0) {  //&& $check_vendor_brand_available > 0?>
			<div class="row">
            <div class="form-group col-sm-2">
            <label class="control-label">Product Code</label>
            <input type="text" class="form-control" onkeypress="return blockSpecialChar(event)" value="<?php echo $prdt_code; ?>" name="prdt_code" id="prdt_code">
            </div>
            <div class="form-group col-sm-3">
            <label class="control-label">Product Name</label>
            <input type="text" class="form-control" onkeypress="return blockSpecialChar(event)" placeholder="Product Name" value="<?php echo $prdt_name; ?>" name="prdt_name" id="prdt_name">
            </div>
            <div class="form-group col-sm-2">
            <label class="control-label">Product Qty</label>
            <input type="text" class="form-control" onkeypress="return mask(this,event);" placeholder="Qty" name="prdt_roq" id="prdt_roq">
            </div>
            <div class="form-group col-sm-2">
            <label class="control-label">Product Price</label>
            <input type="text" class="form-control item_price" placeholder="Price" value="<?php echo $prdt_purchase_price; ?>" name="prdt_purchase_price" id="prdt_purchase_price">
            </div>
            <div class="form-group col-sm-2">
            <label class="control-label">S.No</label>
            <input type="text" class="form-control item_price" placeholder="S.No" value="<?php echo $prdt_serial_number; ?>" name="prdt_serialno" id="prdt_serialno">
            </div>
            <div class="form-group col-sm-2">
            <label class="control-label">TAX (in %)</label>
			<select name="prdt_tax" id="prdt_tax" class="form-control selectpicker" data-live-search="true">
					<?php echo getGSTSETTINGS($prdt_tax, 'select'); ?>
			</select>
            <!--<input type="text" class="form-control" placeholder="Tax" value="<?php echo $prdt_tax; ?>" name="prdt_tax" id="prdt_tax">-->
            </div>
            <div class="form-group col-sm-1 mg-md-t-7">
            <br />
            <input type="hidden" value="<?php echo $prdt_id; ?>" name="choosen_prdt_id" id="choosen_prdt_id" />
            
            <input type="button" class="btn btn-success" name="add_item" id="add_item" onclick="get_productitem_List();" value="ADD">
			
            </div>
			 <?php 
			} else { 
			echo "<p class='text-danger text-center'>No Product Available. Product Type Not Matching.<p>";
			}
			?>
            </div>			
        </div>        
        <div class="clearfix"></div>
       <?php
									
	}

//pr_branch_type
if($_GET['type'] == 'supportticket_product') {
		
		$po_product_code_n_name = trim($product_id);
		$product_code = strbefore($po_product_code_n_name, ':');
		$received_product_id = getPRODUCTDETAIL($product_code, '');
		
		//if (strpos($po_product_code_n_name, '-') !== false || strlen($po_product_code_n_name) <= 8) {
		if (strpos($po_product_code_n_name, ':') !== false) {
			
			$filter_barcode_phrase = "prdt_id = '$received_product_id' and";
			
		} elseif(strlen($po_product_code_n_name) > 15) {
			
			$filter_barcode_phrase = "default_barcode = '$po_product_code_n_name' and";
		}
		
		if($pr_branch_type != '') {
			$filterby_branch_type = "prdt_type = '$pr_branch_type' and";
		}
		
		//substr($str,3,3)
		//echo "SELECT `prdt_id`, `prdt_name`, `prdt_code`, `prdt_purchase_price`, `prdt_tax`, `prdt_roq` FROM `js_product` where {$filter_barcode_phrase} {$filterby_branch_type} deleted = '0' order by prdt_name ASC";
		$get_po_product_lists = sqlQUERY_LABEL("SELECT `prdt_id`, `prdt_name`, `prdt_code`, `prdt_purchase_price`, `prdt_tax`, `prdt_roq` FROM `js_product` where {$filter_barcode_phrase}  deleted = '0' order by prdt_name ASC") or die(sqlERROR_LABEL());
		$total_po_product_list = sqlNUMOFROW_LABEL($get_po_product_lists);
		while($product_po_record_lists=sqlFETCHARRAY_LABEL($get_po_product_lists)) {
			$prdt_id = $product_po_record_lists['prdt_id'];
			$prdt_name = htmlspecialchars($product_po_record_lists['prdt_name']); 
			$prdt_code = $product_po_record_lists['prdt_code'];
			$prdt_purchase_price = $product_po_record_lists['prdt_purchase_price'];
			$prdt_tax = $product_po_record_lists['prdt_tax'];
			$prdt_roq = $product_po_record_lists['prdt_roq'];
		}
		//echo $po_product_code_n_name;
		//echo $product_code;
		//echo $prdt_id;
//echo $received_product_id;
		
		//exit();
		?>
        <div id="hidden_productcode">
		  <?php if($total_po_product_list > 0) {  //&& $check_vendor_brand_available > 0?>
			<div class="row ml-0">
            <div class="form-group col-sm-5">
            <label class="control-label">Product Code</label>
            <input type="text" class="form-control" onkeypress="return blockSpecialChar(event)" value="<?php echo $prdt_code; ?>" name="prdt_code" id="prdt_code">
            </div>
            <div class="form-group col-sm-5">
            <label class="control-label">Product Name</label>
            <input type="text" class="form-control" onkeypress="return blockSpecialChar(event)" placeholder="Product Name" value="<?php echo $prdt_name; ?>" name="prdt_name" id="prdt_name">
            </div>
            <div class="form-group col-sm-2">
            <label class="control-label">Product Qty</label>
            <input type="text" class="form-control" onkeypress="return mask(this,event);" placeholder="Qty" name="prdt_roq" id="prdt_roq" autocomplete="off">
            </div>
           <div class="form-group col-sm-1 mg-md-t-7">
            <br />
            <input type="hidden" value="<?php echo $prdt_id; ?>" name="choosen_prdt_id" id="choosen_prdt_id" />
            
            <input type="button" class="btn btn-success" name="add_item" id="add_item" onclick="get_productitem_List();" value="ADD">
			
            </div>
			 <?php 
			} else { 
			echo "<p class='text-danger text-center'>No Product Available. Product Type Not Matching.<p>";
			}
			?>
            </div>			
        </div>        
        <div class="clearfix"></div>
       <?php
									
	}
	
if($_GET['type'] == 'jobcard_product') {
		
		$po_product_code_n_name = trim($product_id);
		$product_code = strbefore($po_product_code_n_name, ':');
		$received_product_id = getPRODUCTDETAIL($product_code, '');
		
		//if (strpos($po_product_code_n_name, '-') !== false || strlen($po_product_code_n_name) <= 8) {
		if (strpos($po_product_code_n_name, ':') !== false) {
			
			$filter_barcode_phrase = "prdt_id = '$received_product_id' and";
			
		} elseif(strlen($po_product_code_n_name) > 15) {
			
			$filter_barcode_phrase = "default_barcode = '$po_product_code_n_name' and";
		}
		
		if($pr_branch_type != '') {
			$filterby_branch_type = "prdt_type = '$pr_branch_type' and";
		}
		
		//substr($str,3,3)
		//echo "SELECT `prdt_id`, `prdt_name`, `prdt_code`, `prdt_purchase_price`, `prdt_tax`, `prdt_roq` FROM `js_product` where {$filter_barcode_phrase} {$filterby_branch_type} deleted = '0' order by prdt_name ASC";
		$get_po_product_lists = sqlQUERY_LABEL("SELECT `prdt_id`, `prdt_name`, `prdt_code`, `prdt_purchase_price`, `prdt_tax`, `prdt_roq` FROM `js_product` where {$filter_barcode_phrase}  deleted = '0' order by prdt_name ASC") or die(sqlERROR_LABEL());
		$total_po_product_list = sqlNUMOFROW_LABEL($get_po_product_lists);
		while($product_po_record_lists=sqlFETCHARRAY_LABEL($get_po_product_lists)) {
			$prdt_id = $product_po_record_lists['prdt_id'];
			$prdt_name = htmlspecialchars($product_po_record_lists['prdt_name']); 
			$prdt_code = $product_po_record_lists['prdt_code'];
			$prdt_purchase_price = $product_po_record_lists['prdt_purchase_price'];
			$prdt_tax = $product_po_record_lists['prdt_tax'];
			$prdt_roq = $product_po_record_lists['prdt_roq'];
		}
		//echo $po_product_code_n_name;
		//echo $product_code;
		//echo $prdt_id;
//echo $received_product_id;
		
		//exit();
		?>
        <div id="hidden_productcode">
		  <?php if($total_po_product_list > 0) {  //&& $check_vendor_brand_available > 0?>
			<div class="row ml-0">
            <div class="form-group col-sm-5">
            <label class="control-label">Product Code</label>
            <input type="text" class="form-control" onkeypress="return blockSpecialChar(event)" value="<?php echo $prdt_code; ?>" name="prdt_code" id="prdt_code">
            </div>
            <div class="form-group col-sm-5">
            <label class="control-label">Product Name</label>
            <input type="text" class="form-control" onkeypress="return blockSpecialChar(event)" placeholder="Product Name" value="<?php echo $prdt_name; ?>" name="prdt_name" id="prdt_name">
            </div>
            <div class="form-group col-sm-2">
            <label class="control-label">Product Qty</label>
            <input type="text" class="form-control" onkeypress="return mask(this,event);" placeholder="Qty" name="prdt_roq" id="prdt_roq" autocomplete="off">
            </div>
           <div class="form-group col-sm-1 mg-md-t-7">
            <br />
            <input type="hidden" value="<?php echo $prdt_id; ?>" name="choosen_prdt_id" id="choosen_prdt_id" />
            
            <input type="button" class="btn btn-success" name="add_item" id="add_item" onclick="get_productitem_List();" value="ADD">
			
            </div>
			 <?php 
			} else { 
			echo "<p class='text-danger text-center'>No Product Available. Product Type Not Matching.<p>";
			}
			?>
            </div>			
        </div>        
        <div class="clearfix"></div>
       <?php
									
	}
	
//pr_branch_type
if($_GET['type'] == 'vendorpo') { 

		$po_product_code_n_name = trim($product_id);
		$product_code = strbefore($po_product_code_n_name, ':');
		$received_product_id = getPRODUCTDETAIL($product_code, '');

		//if (strpos($po_product_code_n_name, '-') !== false || strlen($po_product_code_n_name) <= 8) {
		if (strpos($po_product_code_n_name, ':') !== false) {
			
			$filter_barcode_phrase = "productsku = '$product_code' and";
			
		}
		
		//substr($str,3,3)
		//echo "SELECT `prdt_id`, `prdt_name`, `prdt_code`, `prdt_purchase_price`, `prdt_tax`, `prdt_roq` FROM `js_product` where {$filter_barcode_phrase} {$filterby_branch_type} deleted = '0' order by prdt_name ASC";

		$getproduct_lists = sqlQUERY_LABEL("SELECT `productID`, `producttitle`, `productsku`, `productpurchaseprice`, `producttax` FROM `js_product` where {$filter_barcode_phrase}  deleted = '0' order by producttitle ASC") or die(sqlERROR_LABEL());
		$totalproduct_list = sqlNUMOFROW_LABEL($getproduct_lists);
		while($productrecord_lists=sqlFETCHARRAY_LABEL($getproduct_lists)) {
			$prdt_id = $productrecord_lists['productID'];
			$prdt_name = htmlspecialchars($productrecord_lists['producttitle']); 
			$prdt_code = $productrecord_lists['productsku'];
			$prdt_purchase_price = $productrecord_lists['productpurchaseprice'];
			$prdt_tax = $productrecord_lists['producttax'];
		    
		}
		//echo $po_product_code_n_name;
		//echo $product_code;
//echo $received_product_id;
		
		//exit();
		?>
        <div id="hidden_productcode">
		  <?php if($totalproduct_list > 0) {  //&& $check_vendor_brand_available > 0?>
			<div class="row">
            <div class="form-group col-sm-2">
            <label class="control-label">Product Code</label>
            <input type="text" class="form-control" onkeypress="return blockSpecialChar(event)" value="<?php echo $prdt_code; ?>" name="prdt_code" id="prdt_code">
            </div>
            <div class="form-group col-sm-3">
            <label class="control-label">Product Name</label>
            <input type="text" class="form-control" onkeypress="return blockSpecialChar(event)" placeholder="Product Name" value="<?php echo $prdt_name; ?>" name="prdt_name" id="prdt_name">
            </div>
            <div class="form-group col-sm-2">
            <label class="control-label">Product Qty</label>
            <input type="text" class="form-control" onkeypress="return mask(this,event);" placeholder="Qty" name="prdt_roq" id="prdt_roq">
            </div>
            <div class="form-group col-sm-2">
            <label class="control-label">Product Price</label>
            <input type="text" class="form-control item_price" placeholder="Price" value="<?php echo $prdt_purchase_price; ?>" name="prdt_purchase_price" id="prdt_purchase_price">
            </div>
            <div class="form-group col-sm-2">
            <label class="control-label">TAX (in %)</label>
			<select name="prdt_tax" id="prdt_tax" class="form-control selectpicker" data-live-search="true">
					<?php echo getGSTSETTINGS($prdt_tax, 'select'); ?>
			</select>
            <!--<input type="text" class="form-control" placeholder="Tax" value="<?php echo $prdt_tax; ?>" name="prdt_tax" id="prdt_tax">-->
            </div>
            <div class="form-group col-sm-2">
            <label class="control-label">Discount in %</label>
            <input type="text" class="form-control" placeholder="Discount %" name="discount_value" value="0" id="discount_value">
            </div>
            <div class="form-group col-sm-1 mg-md-t-7">
            <br />
            <input type="hidden" value="<?php echo $prdt_id; ?>" name="choosen_prdt_id" id="choosen_prdt_id" />
            <input type="hidden" value="<?php echo $prdt_gst_included; ?>" name="tax_type" id="tax_type" />
            
            <input type="button" class="btn btn-success" name="add_item" id="add_item" onclick="get_productitem_List();" value="ADD">
			
            </div>
			 <?php 
			} else { 
			echo "<p class='text-danger text-center'>No Product Available. Product Type Not Matching.<p>";
			}
			?>
            </div>
             
			
        </div>        
        <div class="clearfix"></div>
       <?php
									
	}
	
	if($_GET['type'] == 'vendorpo_return')
	{
		if(strpos($product_vpo,':')){
	$product_id = trim(strbefore($product_vpo, ':'));
	$vendorpo_ref = trim(strafter($product_vpo, ':'));
	$vendorpo_id = getVENDORPOdetails($vendorpo_ref,'vpoid','');
	}
	$list_datas_vendorpo = sqlQUERY_LABEL("SELECT * FROM `js_vendor_po_items` where vpo_id = '$vendorpo_id' and  prdt_id = '$product_id' and vpo_item_received != '0' and vpo_item_grn_status ='1' and deleted = '0'") or die("Unable to get records:".sqlERROR_LABEL());
	 $total_vendorpo = sqlNUMOFROW_LABEL($list_datas_vendorpo);
	while($row_value = sqlFETCHARRAY_LABEL($list_datas_vendorpo)){
		  // $counter_value++;
		  $vpo_item_id = $row_value["vpo_item_id"];
		  $vpo_id = $row_value["vpo_id"];
		  $prdt_id = $row_value["prdt_id"];
		  $vpo_item_qty = $row_value["vpo_item_qty"];
		  $vpo_item_price = $row_value["vpo_item_price"];
		  $vpo_item_tax = $row_value["vpo_item_tax"];
		  $vpo_item_tax1 = $row_value["vpo_item_tax1"];
		  $vpo_item_tax2 = $row_value["vpo_item_tax2"];
		  $vpo_item_total = $row_value["vpo_item_total"];
		  $vpo_item_received = $row_value["vpo_item_received"];
		  $vpo_item_available = $row_value["vpo_item_available"];
		  $vpo_item_expirydate = $row_value["vpo_item_expirydate"];
		  $vpo_item_grn_status = $row_value["vpo_item_grn_status"];
		  $status = $row_value["status"];
		  $product_code = getPRODUCTDETAIL($prdt_id, 'code');
		  $product_name = getPRODUCTDETAIL($prdt_id, 'name');
	}
	
	$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_product` where prdt_id='$prdt_id' and deleted = '0'") or die("Unable to get records:".sqlERROR_LABEL());			
		while($row = sqlFETCHARRAY_LABEL($list_datas)){
		$prdt_name = htmlspecialchars($row['prdt_name']); 
		$prdt_code = $row['prdt_code'];
	
		}
	
		$selected_vendorid = $_GET['prvendor_id'];
	//	$selected_pr_branch_type = $_GET['pr_branch_type'];
		
		// $po_product_code_n_name = trim($_POST['product_id']);
			// $product_code = strbefore($po_product_code_n_name, '-');
			// $received_product_id = getPRODUCTDETAIL($product_code, '');
		
			// if (strpos($po_product_code_n_name, '-') !== false) {
			// $filter_barcode_phrase = "prdt_id = '$received_product_id' and";
			
			
		// } elseif(strlen($po_product_code_n_name) > 10) {
			
			// $filter_barcode_phrase = "default_barcode = '$po_product_code_n_name' and";
			
		// }
		
		// if($selected_pr_branch_type != '') {
			// $filterby_branch_type = "prdt_type = '$selected_pr_branch_type' and";
		// }
		
		// $getproduct_lists = sqlQUERY_LABEL("SELECT `prdt_id`, `prdt_name`, `prdt_code`, `prdt_purchase_price`, `prdt_tax`, `prdt_remaining` FROM `js_product` where {$filter_barcode_phrase} {$filterby_branch_type} {$filter_productbrand_code} deleted = '0' order by prdt_name ASC") or die(sqlERROR_LABEL());
		// $totalproduct_list = sqlNUMOFROW_LABEL($getproduct_lists);
		// while($productrecord_lists=sqlFETCHARRAY_LABEL($getproduct_lists)) {
			// $prdt_id = $productrecord_lists['prdt_id'];
			// $prdt_name = htmlspecialchars($productrecord_lists['prdt_name']); 
			// $prdt_code = $productrecord_lists['prdt_code'];
			// $prdt_purchase_price = $productrecord_lists['prdt_purchase_price'];
			// $prdt_tax = $productrecord_lists['prdt_tax'];
			// $prdt_remaining_stock = $productrecord_lists['prdt_remaining'];
		// }

		?>
        <div id="hidden_productcode">
            <?php if($total_vendorpo > 0) {  //&& $check_vendor_brand_available > 0?>
			<div class="row col-md-12">		
            <div class="form-group col-sm-2">
            <label class="control-label">Product Code</label>
            <input type="text" class="form-control" onkeypress="return blockSpecialChar(event)" value="<?php echo $prdt_code; ?>" name="prdt_code" id="prdt_code">
            </div>
            <div class="form-group col-sm-4">
            <label class="control-label">Product Name</label>
            <input type="text" class="form-control" onkeypress="return blockSpecialChar(event)" placeholder="Product Name" value="<?php echo $prdt_name; ?>" name="prdt_name" id="prdt_name">
            </div>
            <div class="form-group col-sm-2">
            <label class="control-label">Product Qty <span class="badge">Available: <?php echo $vpo_item_available; ?></span></label>
            <input type="text" class="form-control" onkeypress="return mask(this,event);" value="" <?php if($vpo_item_available <= 0) { echo 'disabled="disabled"  placeholder="Empty Stock"'; } else { echo ' placeholder="Qty"'; } ?> name="prdt_roq" id="prdt_roq">
            </div>
            <div class="form-group col-sm-2">
            <label class="control-label">Product Price</label>
            <input type="text" class="form-control item_price" placeholder="Price" value="<?php echo $vpo_item_price; ?>" name="prdt_purchase_price" id="prdt_purchase_price">
            </div>
            <div class="form-group col-sm-1" style="display: none">
            <label class="control-label">TAX (in %)</label>
			<select name="prdt_tax" id="prdt_tax" class="form-control selectpicker" data-live-search="true">
					<?php echo getGSTSETTINGS($vpo_item_tax, 'select'); ?>
			</select>
            <!--<input type="text" class="form-control" placeholder="Tax" value="<?php echo $prdt_tax; ?>" name="prdt_tax" id="prdt_tax">-->
            </div>
            <div class="form-group col-sm-1 mg-md-t-7">
            <br />
            <input type="hidden" value="<?php echo $prdt_id; ?>" name="choosen_prdt_id" id="choosen_prdt_id" />
			<input type="hidden" value="<?php echo $vpo_id; ?>" name="vpo_id" id="vpo_id" />
            <input type="button" class="btn btn-success" name="add_item" id="add_item" onclick="get_productitem_List();" value="ADD" <?php if($vpo_item_available <= 0) { echo 'disabled="disabled"'; } ?>>
            </div>
			</div>
            <?php 
			} else { 
			echo "<p class='text-danger text-center'>No Product Available. Vendor PO Not Matching.<p>";
			}
			?>
        </div>        
        <div class="clearfix"></div>
       <?php
									
	}
	
	
	if($_GET['type'] == 'takestockdc')
	{
			// $po_product_code_n_name = trim($_POST['product_id']);
			// $product_code = strbefore($po_product_code_n_name, '-');
			// $received_product_id = getPRODUCTDETAIL($product_code, '');
		////normal takestock from product
		// if (strpos($po_product_code_n_name, '-') !== false || strlen($po_product_code_n_name) <= 8) {
			
			// $filter_barcode_phrase = "prdt_id = '$received_product_id' and";
			
		// } elseif(strlen($po_product_code_n_name) > 8) {
			
			// $filter_barcode_phrase = "default_barcode = '$po_product_code_n_name' and";
			
		// }
		
		// if($selected_pr_branch_type != '') {
			// $filterby_branch_type = "prdt_type = '$selected_pr_branch_type' and";
		// }
		// $getproduct_lists = sqlQUERY_LABEL("SELECT `prdt_id`, `prdt_name`, `prdt_code`, `prdt_purchase_price`, `prdt_tax`, `prdt_remaining` FROM `js_product` where {$filter_barcode_phrase} {$filterby_branch_type} deleted = '0' order by prdt_name ASC") or die(sqlERROR_LABEL());
		// $totalproduct_list = sqlNUMOFROW_LABEL($getproduct_lists);
		// while($productrecord_lists=sqlFETCHARRAY_LABEL($getproduct_lists)) {
			// $prdt_id = $productrecord_lists['prdt_id'];
			// $prdt_name = htmlspecialchars($productrecord_lists['prdt_name']); 
			// $prdt_code = $productrecord_lists['prdt_code'];
			// $prdt_purchase_price = $productrecord_lists['prdt_purchase_price'];
			// $prdt_tax = $productrecord_lists['prdt_tax'];
			// $prdt_remaining_stock = $productrecord_lists['prdt_remaining'];
		// }
		
		if(strpos($product_vpo,':')){
	$product_id = trim(strbefore($product_vpo, ':'));
	$get_product_info = trim(strafter($product_vpo, '~'));
	$split_prdt_id = (explode(":",$get_product_info)[0]);
	$split_vpo_no = (explode(":",$get_product_info)[1]);
	//$get_vpo_after_value = trim(strbefore($product_vpo, '~'));
	$vendorpo_ref = trim(strafter($product_vpo, ':'));
	$vendorpo_id = getVENDORPOdetails($vendorpo_ref,'vpoid','');
	$takenstock_ref_no = $takenstock_ref_no;
	}
	//echo "SELECT * FROM `js_vendor_po_items` where vpo_id = '$vendorpo_id' and  prdt_id = '$split_prdt_id' and vpo_item_received != '0' and vpo_item_grn_status ='1' and deleted = '0'";
	$list_datas_vendorpo = sqlQUERY_LABEL("SELECT * FROM `js_vendor_po_items` where vpo_id = '$vendorpo_id' and  prdt_id = '$split_prdt_id' and deleted = '0'") or die("Unable to get records:".sqlERROR_LABEL());
	 $total_vendorpo = sqlNUMOFROW_LABEL($list_datas_vendorpo);
	while($row_value = sqlFETCHARRAY_LABEL($list_datas_vendorpo)){
		  // $counter_value++;
		  $vpo_item_id = $row_value["vpo_item_id"];
		  $vpo_id = $row_value["vpo_id"];
		  $prdt_id = $row_value["prdt_id"];
		  $vpo_item_qty = $row_value["vpo_item_qty"];
		  $vpo_item_price = $row_value["vpo_item_price"];
		  $vpo_item_tax = $row_value["vpo_item_tax"];
		  $vpo_item_tax1 = $row_value["vpo_item_tax1"];
		  $vpo_item_tax2 = $row_value["vpo_item_tax2"];
		  $vpo_item_total = $row_value["vpo_item_total"];
		  $vpo_item_received = $row_value["vpo_item_received"];
		  $vpo_item_available = $row_value["vpo_item_available"];
		  $check_item_quantity = $row_value["vpo_item_returned_qty"];
		  $vpo_item_expirydate = $row_value["vpo_item_expirydate"];
		  $vpo_item_grn_status = $row_value["vpo_item_grn_status"];
		  $status = $row_value["status"];
		  $product_code = getPRODUCTDETAIL($prdt_id, 'code');
		  $product_name = getPRODUCTDETAIL($prdt_id, 'name');
		  $product_hsncode = getPRODUCTDETAIL($prdt_id, 'hsn_code');
		  $prdt_purchase_price = getPRODUCTDETAIL($prdt_id, 'prdt_purchase_price');
		  $toadd = $vpo_item_received - $vpo_item_available ;
	}
	
	$list_datas = sqlQUERY_LABEL("SELECT prdt_name,prdt_code FROM `js_product` where prdt_id='$prdt_id' and deleted = '0'") or die("Unable to get records:".sqlERROR_LABEL());			
		while($row = sqlFETCHARRAY_LABEL($list_datas)){
		$prdt_name = htmlspecialchars($row['prdt_name']); 
		$prdt_code = $row['prdt_code'];
	
		}

		if($invoice_choosen !='' && $invoice_choosen !='0') {
			echo "A";
			$get_count_data_for_invoice = sqlQUERY_LABEL("SELECT item_quantity FROM `js_invoiceitem` where item_id='$prdt_id' and invoiceid='$invoice_choosen' and deleted = '0'") or die("Unable to get records:".sqlERROR_LABEL());
			while($row = sqlFETCHARRAY_LABEL($get_count_data_for_invoice)){
			$check_item_quantity = $row['item_quantity'];
			}
		}
		if($defect_ticket_choosen !='' && $defect_ticket_choosen !='0') {
			echo "B";
			$get_count_data_for_ticket = sqlQUERY_LABEL("SELECT tsdc_id FROM `js_takestockdc` where ticket_id='$defect_ticket_choosen' and deleted = '0'") or die("Unable to get records:".sqlERROR_LABEL());
			while($row = sqlFETCHARRAY_LABEL($get_count_data_for_ticket)){
			$tsdc_id = $row['tsdc_id'];
			}
			$get_count_data_for_invoice = sqlQUERY_LABEL("SELECT tsdc_receivedqty FROM `js_takestockdc_item` where tsdc_id='$tsdc_id' and prdt_id='$prdt_id' and deleted = '0'") or die("Unable to get records:".sqlERROR_LABEL());
			while($row = sqlFETCHARRAY_LABEL($get_count_data_for_invoice)){
			$check_item_quantity = $row['tsdc_receivedqty'];
			}
		}
		if($ticket_choosen !='' && $ticket_choosen !='0') {
			echo "C";			
			$get_count_data_for_ticket = sqlQUERY_LABEL("SELECT tsdc_id FROM `js_takestockdc` where ticket_id='$ticket_choosen' and deleted = '0'") or die("Unable to get records:".sqlERROR_LABEL());
			while($row = sqlFETCHARRAY_LABEL($get_count_data_for_ticket)){
			$tsdc_id = $row['tsdc_id'];
			}
			$get_count_data_for_invoice = sqlQUERY_LABEL("SELECT tsdc_receivedqty FROM `js_takestockdc_item` where tsdc_id='$tsdc_id' and prdt_id='$prdt_id' and deleted = '0'") or die("Unable to get records:".sqlERROR_LABEL());
			while($row = sqlFETCHARRAY_LABEL($get_count_data_for_invoice)){
			$check_item_quantity = $row['tsdc_receivedqty'];
			}
		}

    if($ticket_choosen !='' && $ticket_choosen !='0') {
					echo "D";
		$get_count_data_for_return_tkt = sqlQUERY_LABEL("SELECT rsdc_id FROM `js_returnstockdc` where ticket_id='$ticket_choosen' and deleted = '0'") or die("Unable to get records:".sqlERROR_LABEL());
    }
    
    if($tkt_others_id !='' && $tkt_others_id !='0' && $tkt_others_id !='5') {
					echo "E";
	$get_count_data_for_return_tkt = sqlQUERY_LABEL("SELECT rsdc_id FROM `js_returnstockdc` where rsdc_reason_notes = '$tkt_others_reason' and deleted = '0'") or die("Unable to get records:".sqlERROR_LABEL());
    }
    
    if($defect_type_id !='' && $defect_type_id !='0') {
					echo "F";
	$get_count_data_for_return_tkt = sqlQUERY_LABEL("SELECT rsdc_id FROM `js_returnstockdc` where defect_reason_notes = '$defect_others_reason' OR rsdc_reason_notes = '$defect_others_reason' and deleted = '0'") or die("Unable to get records:".sqlERROR_LABEL());
    }

    if($invoice_choosen !='' && $invoice_choosen !='0') {
					echo "G";
		$get_count_data_for_return_tkt = sqlQUERY_LABEL("SELECT rsdc_id FROM `js_returnstockdc` where invoice_id='$invoice_choosen' and deleted = '0'") or die("Unable to get records:".sqlERROR_LABEL());
    }

		while($row = sqlFETCHARRAY_LABEL($get_count_data_for_return_tkt)){
	    $get_rsdc_id = $row['rsdc_id'];

		$get_count_data_for_tkt_id = sqlQUERY_LABEL("SELECT rsdc_item_qty FROM `js_returnstockdc_item` where prdt_id = '$prdt_id' and rsdc_id='$get_rsdc_id' and deleted = '0'") or die("Unable to get records:".sqlERROR_LABEL());
		while($row_data = sqlFETCHARRAY_LABEL($get_count_data_for_tkt_id)){
		$rsdc_returned_item_qty = $row_data['rsdc_item_qty'];
		}
	}
	
		if($vpo_choosen !='' && $vpo_choosen !='0') {
						echo "H";
			$get_count_data_for_vpo_return = sqlQUERY_LABEL("SELECT vpo_item_received,vpo_item_returned_qty FROM `js_vendor_po_items` where prdt_id = '$prdt_id' and vpo_id='$vpo_choosen' and vpo_item_received != '0' and vpo_item_grn_status ='1' and deleted = '0'") or die("Unable to get records:".sqlERROR_LABEL());
			while($row = sqlFETCHARRAY_LABEL($get_count_data_for_vpo_return)){
			$check_item_quantity = $row['vpo_item_received'];
			$vpo_item_returned_qty = $row['vpo_item_returned_qty'];
			}
		}		
		if($tkt_others_id !='' && $tkt_others_id !='0' && $tkt_others_id !='5') {
						echo "I";
			$get_count_data_for_tkt_id = sqlQUERY_LABEL("SELECT tsdc_id FROM `js_takestockdc` where tsdc_reasonid='$tkt_others_id' and tsdc_reason_notes = '$tkt_others_reason' and deleted = '0'") or die("Unable to get records:".sqlERROR_LABEL());
			while($row_data = sqlFETCHARRAY_LABEL($get_count_data_for_tkt_id)){
			$get_tkt_tsdc_id = $row_data['tsdc_id'];
			//$get_prdt_id = getTAKEN_STOCK_PRODUCT_DATA($get_tkt_tsdc_id, 'get_tkt_prdt_id');
			}
			$get_count_data_for_tkt_prdt_id = sqlQUERY_LABEL("SELECT prdt_id FROM `js_takestockdc_item` where tsdc_id='$tsdc_id' and deleted = '0'") or die("Unable to get records:".sqlERROR_LABEL());
			while($row_data = sqlFETCHARRAY_LABEL($get_count_data_for_tkt_prdt_id)){
			$get_tkt_prdt_id = $row_data['prdt_id'];
			}
			$get_count_data_for_tkt_id = sqlQUERY_LABEL("SELECT tsdc_receivedqty FROM `js_takestockdc_item` where prdt_id = '$prdt_id' and tsdc_id='$get_tkt_tsdc_id' and deleted = '0'") or die("Unable to get records:".sqlERROR_LABEL());
			while($row_data = sqlFETCHARRAY_LABEL($get_count_data_for_tkt_id)){
			$check_item_quantity = $row_data['tsdc_receivedqty'];
			}
		}
		
		if($_prdt_ts_id !='' && $_prdt_ts_id !='0') {
			echo "J";
			$check_taken_approve_qty = sqlQUERY_LABEL("SELECT product_qty FROM `js_supportticket_prdt_list` where support_ticketid ='$taken_ticket_id' and product_id = '$prdt_id' and deleted = '0'") or die("Unable to get records:".sqlERROR_LABEL());
			while($row_data = sqlFETCHARRAY_LABEL($check_taken_approve_qty)){
			$product_qty = $row_data['product_qty'];
			}
			if($vpo_item_available < $product_qty){
				$check_item_quantity = $vpo_item_available;
			} else {
				$check_item_quantity = $product_qty;
			}
		}
		
	//	if($vpo_choosen !='' && $vpo_choosen !='0'){
	//	    $check_item_quantity = $vpo_item_returned_qty;
	//	}
		?>
		<?php 
		if($tkt_others_id !='5'){
		if($vpo_choosen ==''){
		if($takenstock_ref_no) { 
		if($rsdc_returned_item_qty != 0) { ?>
		<div style="margin-left: 510px;">
		<small class="text-danger tx-bold">Already Returned : <?php echo $rsdc_returned_item_qty; ?></small><br>
		<?php } } else { ?>
		<small class="text-danger tx-bold">To Return : <?php echo $check_item_quantity; ?></small>
		</div>
		<?php } } else { ?>
		<div style="margin-left: 510px;">
		 <?php
		 if($takenstock_ref_no) {
		 if($vpo_item_returned_qty !='' && $vpo_item_returned_qty!='0'){ ?>
		<small class="text-danger tx-bold">Already Returned : <?php echo $vpo_item_returned_qty; ?></small><br>
		<small class="text-danger tx-bold">Remaining Return : <?php echo ($check_item_quantity = $check_item_quantity-$vpo_item_returned_qty); ?>
		</small>
        <?php } } else { ?>
        <small class="text-danger tx-bold">To Return : <?php echo $check_item_quantity; ?></small>
        <?php } } }?>
		</div>
		
        <div id="hidden_productcode">
            <?php if($total_vendorpo > 0) {  //&& $check_vendor_brand_available > 0?>
			<div class="row col-md-12">		
            <div class="form-group col-sm-2">
            <label class="control-label">Product Code</label>
            <input type="text" class="form-control" onkeypress="return blockSpecialChar(event)" value="<?php echo $prdt_code; ?>" name="prdt_code" id="prdt_code">
            </div>
            <div class="form-group col-sm-4">
            <label class="control-label">Product Name</label>
            <input type="text" class="form-control" onkeypress="return blockSpecialChar(event)" placeholder="Product Name" value="<?php echo $prdt_name; ?>" name="prdt_name" id="prdt_name">
            </div>
            <div class="form-group col-sm-2">
			<?php if($takenstock_ref_no) { ?>
            <label class="control-label">Qty <span class="badge text-success">Available Qty: <?php echo $vpo_item_available; ?></span></label>
            <input type="text" class="form-control enter_qty" onkeypress="return mask(this,event);" value="" <?php if($vpo_item_available == 0) { echo 'disabled="disabled"  placeholder="Empty Stock"'; } else { echo ' placeholder="Qty"'; } ?>  name="prdt_roq" id="prdt_roq" autocomplete="off">
			<?php } else { ?>
			
			<label class="control-label">Qty </span></label>

		    <?php if($vpo_choosen !='') { ?>
		    
            <input type="text" class="form-control <?php if($tkt_others_id !='5'){ echo "enter_qty"; } ?>" onkeypress="return mask(this,event);" value="" <?php if($check_item_quantity == 0 && $tkt_others_id != '5') { echo 'disabled="disabled"  placeholder="Empty Stock"'; } else { echo ' placeholder="Qty"'; } ?> name="prdt_roq" id="prdt_roq" autocomplete="off">
            
            <?php } else { ?>
            
            <input type="text" class="form-control enter_qty" onkeypress="return mask(this,event);" value="" <?php if($check_item_quantity == 0 || $rsdc_returned_item_qty !=0) { echo 'disabled="disabled"  placeholder="Empty Stock"'; } else { echo ' placeholder="Qty"'; } ?> name="prdt_roq" id="prdt_roq" autocomplete="off">
            <?php } ?>
			<?php } ?>
            </div>
            <div class="form-group col-sm-2">
            <label class="control-label">Product Price</label>
			<?php if($takenstock_ref_no){ ?>
			<?php if($vpo_item_price !='0'){?>
            <input type="hidden" class="form-control item_price" placeholder="Price" value="<?php echo $vpo_item_price; ?>" name="prdt_purchase_price" id="prdt_purchase_price">
			<?php } else { ?>
            <input type="hidden" class="form-control item_price" placeholder="Price" value="<?php echo $prdt_purchase_price; ?>" name="prdt_purchase_price" id="prdt_purchase_price">
			<?php } ?>
            <input type="text" class="form-control item_price" placeholder="Price" name="prdt_dc_price" value="0" id="prdt_dc_price">
			<?php } else { ?>
            <input type="text" class="form-control item_price" placeholder="Price" value="<?php echo $vpo_item_price; ?>" name="prdt_purchase_price" id="prdt_purchase_price">
			<?php } ?>
            </div>
            <div class="form-group col-sm-2">
            <label class="control-label">S.No</label>
            <input type="text" class="form-control" placeholder="S.No" value="<?php echo $product_hsncode; ?>" name="prdt_serialno" id="prdt_serialno">
            </div>
            <div class="form-group col-sm-1" style="display: none">
            <label class="control-label">TAX (in %)</label>
            <input type="text" class="form-control" placeholder="Tax" value="<?php echo $vpo_item_tax; ?>" name="prdt_tax" id="prdt_tax">
            </div>
            <div class="form-group col-sm-1 mg-md-t-7">
            <br />
            <input type="hidden" value="<?php echo $prdt_id; ?>" name="choosen_prdt_id" id="choosen_prdt_id" />
			<input type="hidden" value="<?php echo $vpo_id; ?>" name="vpo_id" id="vpo_id" />
			<?php if($takenstock_ref_no) { ?> 
            <input type="button" class="btn btn-success" name="add_item" id="add_item" onclick="get_productitem_List();" value="ADD" <?php if($vpo_item_available == 0) { echo 'disabled="disabled"'; } ?>>
			<?php } else { ?>
			<input type="button" class="btn btn-success" name="add_item" id="add_item" onclick="get_productitem_List();" value="ADD" <?php if($check_item_quantity == 0 && $tkt_others_id !='5') { echo 'disabled="disabled"'; } ?>>
			<?php } ?>
            </div>
			</div>
            <?php 
			} else { 
			echo "<p class='text-danger text-center'>No Product Available. Vendor PO Not Matching.<p>";
			}
			?>
        </div>        
        <div class="clearfix"></div>
       <?php
									
	}
?>

    <script type="text/javascript">

		$('.enter_qty').on('keydown keyup', function(e){
			if ($(this).val() > <?php echo $check_item_quantity; ?> 
				&& e.keyCode !== 46 // keycode for delete
				&& e.keyCode !== 8 // keycode for backspace
			   ) {
			   e.preventDefault();
			   $(this).val(<?php echo $check_item_quantity; ?>);
			}
		});

    function blockSpecialChar(e){
        var k;
        document.all ? k = e.keyCode : k = e.which;
        return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57));
        }
	
	function mask(textbox, e) {

      var charCode = (e.which) ? e.which : e.keyCode;
      if (charCode == 46 || charCode > 31&& (charCode < 48 || charCode > 57)) 
         {
            alert("Only Numbers Allowed");
            return false;
         }
     else
         {
             return true;
         }
       }
	   
	$('.item_price').keypress(function(event) {
		if(event.which < 46
		|| event.which > 59) {
			event.preventDefault();
		} // prevent if not number/dot

		if(event.which == 46
		&& $(this).val().indexOf('.') != -1) {
			event.preventDefault();
		} // prevent if already dot
	});
    </script>
