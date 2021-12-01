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

if($type == 'addproduct') {

	$sku_code = trim($product_info);
	
	/* $list_producttype_data = curl_multiple(GENERALAPIPATH_SELECT_ESTORE_PRDT_DATA, ['sku_code' => $sku_code] );
 
	$characters = json_decode($list_producttype_data); // decode the JSON feed

	$count_producttype_list = count($characters);
		
	if($count_producttype_list > 0){
			
		foreach ($characters as $character) {
			
			$counter++;
			$estore_prdt_name = $character->estore_prdt_name;
			$estore_prdt_code = $character->estore_prdt_code;
			$estore_prdt_unit_price = $character->estore_prdt_unit_price;
			$estore_prdt_mrp = $character->estore_prdt_mrp;
			$estore_prdt_msp = $character->estore_prdt_msp;
			$e_store_prdt_tax = $character->e_store_prdt_tax;
			$e_store_prdt_taxsplit1 = $character->e_store_prdt_taxsplit1;
			$e_store_prdt_taxsplit2 = $character->e_store_prdt_taxsplit2;
			$e_store_prdt_gst_type = $character->e_store_prdt_gst_type;
			$final_selling_price = $estore_prdt_msp + $e_store_prdt_taxsplit1 + $e_store_prdt_taxsplit2;
		}
	} */
	
	$list_product_datas = sqlQUERY_LABEL("SELECT * FROM `js_product` WHERE productsku = '$sku_code'") or die("Unable to get records:".sqlERROR_LABEL());

	$count_product_list = sqlNUMOFROW_LABEL($list_product_datas);

	while($fetch_records = sqlFETCHARRAY_LABEL($list_product_datas)){
		
			$estore_prdt_name = $fetch_records[''];
			$estore_prdt_code = $fetch_records[''];
			$estore_prdt_unit_price = $fetch_records[''];
			$estore_prdt_mrp = $fetch_records[''];
			$estore_prdt_msp = $fetch_records[''];
			$e_store_prdt_tax = $fetch_records[''];
			$e_store_prdt_taxsplit1 = $fetch_records[''];
			$e_store_prdt_taxsplit2 = $fetch_records[''];
			$e_store_prdt_gst_type = $fetch_records[''];
			$final_selling_price = $estore_prdt_msp + $e_store_prdt_taxsplit1 + $e_store_prdt_taxsplit2;
		
	}
	

if($variantID != '') {

	$list_prdt_variant_datas = sqlQUERY_LABEL("SELECT `variant_code`, `variantstockstatus`, `variant_ID`, `variant_name`, `variant_mrp_price`, `variant_msp_price` FROM `js_productvariants` where deleted = '0' and status = '1' and `variant_ID`='$variantID'") or die("Unable to get records:".mysqli_error());			
	$check_variant_record_availabity = sqlNUMOFROW_LABEL($list_prdt_variant_datas);			

	while($row = sqlFETCHARRAY_LABEL($list_prdt_variant_datas)){
	  $variant_ID = $row["variant_ID"];
	  $variant_name = $row["variant_name"];
	  $variant_code = $row["variant_code"];
	  $variantstockstatus = $row["variantstockstatus"];
	  $variant_mrp_price = $row["variant_mrp_price"];
	  $variant_msp_price = $row["variant_msp_price"];
	}
	
}

		?>
		<!--<span class="text-primary">Product Name : <?php echo $prdt_name; ?></span>-->
		<div class="row">
		<div class="form-group col-md-6">
			<label for="sku_code" class="col-form-label">SKU Code<span class="tx-danger">*</span></label>
			<div class="">
				<input type="text" class="form-control" name="sku_code" id="sku_code" placeholder="" value="<?php echo $estore_prdt_code; ?>">				      
			</div>
		</div>
		<div class="form-group col-md-6">
			<label for="variant_name" class="col-form-label">Variant Name<span class="tx-danger">*</span></label>
			<div class="">
				<input type="text" class="form-control" name="ajax_variant_name" id="ajax_variant_name" placeholder=" "  value="<?php echo $estore_prdt_name; ?>">				      
			</div>
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-4">
			<label for="purchase_price" class="col-form-label">In Stock<span class="tx-danger">*</span></label>
			<div class="">
				<select class="form-control custom-select" name="ajax_stock_in_status" id="ajax_stock_in_status">
					<option value="1" <?php if($variantstockstatus == '1'){ echo 'selected'; } ?>>Yes</option>
					<option value="0" <?php if($variantstockstatus == '0'){ echo 'selected'; } ?>>No</option>
				</select>
			</div>
		</div>
		<div class="form-group col-md-4">
			<label for="mrp_price" class="col-form-label">MRP Price<span class="tx-danger">*</span></label>
			<div class="">
				<input type="text" class="form-control" name="ajax_mrp_price" id="ajax_mrp_price" placeholder=" "  value="<?php echo $estore_prdt_mrp; ?>">				      
			</div>
		</div>
		<div class="form-group col-md-4">
			<label for="selling_price" class="col-form-label">Selling Price<span class="tx-danger">*</span></label>
			<div class="">
				<input type="text" class="form-control" name="ajax_selling_price" id="ajax_selling_price" placeholder=" "  value="<?php echo $final_selling_price; ?>">				      
			</div>
		</div>
		<div class="form-group col-md-4">
			<label for="variant_taxtype" class="col-form-label">GST Included</label>
			<div class="">
				  <select class="custom-select" name="ajax_variant_taxtype" id="ajax_variant_taxtype">
					<option value="Y" <?php if($e_store_prdt_gst_type == 'Y'){ echo 'selected'; } ?>>Yes</option>
					<option value="N" <?php if($e_store_prdt_gst_type == 'N'){ echo 'selected'; } ?>>No</option>
				  </select>
			</div>
		</div>
		<div class="form-group col-md-4">
			<label for="variant_tax_value" class="col-form-label">GST %</label>
			<div class="">
				  <input type="text" class="form-control" placeholder="GST %" name="ajax_variant_tax_value" id="ajax_variant_tax_value" value="<?php echo $e_store_prdt_tax; ?>">
			</div>
		</div>
		</div>
		<div class="row">
			<div class="form-group col-md-12">
				<input type="hidden" name="ajax_hidden_variant_ID" id="ajax_hidden_variant_ID" value="<?php echo $variantID; ?>">
				<?php if($variantID){
					$button_class= 'btn-warning';
					$label = 'Update';
				} else {
					$button_class= 'btn-success';
					$label= 'Save';
				}
				?>
				<button type="submit" name="save_ajax_variant" value="save_ajax_variant" class="btn <?php echo $button_class; ?> float-right"><?php echo $label; ?></button>
			</div>
		</div>
<?php 
}
?>

<?php

if($type == 'getestoreproductinfo'){

	$sku_code = trim($product_info);
	
	$list_producttype_data = curl_multiple(GENERALAPIPATH_SELECT_ESTORE_PRDT_DATA, ['sku_code' => $sku_code] );
 
	$characters = json_decode($list_producttype_data); // decode the JSON feed

	$count_producttype_list = count($characters);
		
	if($count_producttype_list > 0){
			
		foreach ($characters as $character) {
			
			$counter++;
			$estore_prdt_name = $character->estore_prdt_name;
			$estore_prdt_code = $character->estore_prdt_code;
			$estore_prdt_unit_price = $character->estore_prdt_unit_price;
			$estore_prdt_mrp = $character->estore_prdt_mrp;
			$estore_prdt_msp = $character->estore_prdt_msp;
			$e_store_prdt_tax = $character->e_store_prdt_tax;			
			$e_store_prdt_taxsplit1 = $character->e_store_prdt_taxsplit1;
			$e_store_prdt_taxsplit2 = $character->e_store_prdt_taxsplit2;
			$e_store_prdt_gst_type = $character->e_store_prdt_gst_type;
			$final_selling_price = $estore_prdt_msp + $e_store_prdt_taxsplit1 + $e_store_prdt_taxsplit2;

		}
	}
	?>
	<div class="divider-text">Product Info</div>

	  <div class="form-group row">
		<label for="producttitle" class="col-sm-2 col-form-label">Product Title</label>
		<div class="col-sm-7">
			  <input type="text" class="form-control" placeholder="Product Title" name="producttitle" id="producttitle" value="<?php echo $estore_prdt_name; ?>">
		</div>
	  </div>
	  <div class="form-group row">
		<label for="productMRPprice" class="col-sm-2 col-form-label">MRP Price</label>
		<div class="col-sm-7">
			  <input type="text" class="form-control" placeholder="MRP Price" name="productMRPprice" id="productMRPprice" value="<?php echo $estore_prdt_mrp; ?>">
		</div>
	  </div>

	  <div class="form-group row">
		<label for="productsellingprice" class="col-sm-2 col-form-label">Selling Price</label>
		<div class="col-sm-7">
			  <input type="text" class="form-control" placeholder="Selling Price" name="productsellingprice" id="productsellingprice" value="<?php echo $final_selling_price; ?>">
		</div>
	  </div>
	  
	  <div class="form-group row">
		<label for="productpurchaseprice" class="col-sm-2 col-form-label">Purchase/Manufacturing Price</label>
		<div class="col-sm-7">
			  <input type="text" class="form-control" placeholder="Our Price" name="productpurchaseprice" id="productpurchaseprice" value="<?php echo $estore_prdt_unit_price; ?>">
		</div>
	  </div>

	  <div class="form-group row">
		<label for="producttaxtype" class="col-sm-2 col-form-label">GST Included</label>
		<div class="col-sm-7">
			  <select class="custom-select" name="producttaxtype" id="producttaxtype">
				<option value="Y" <?php if($e_store_prdt_gst_type == 'Y'){ echo 'selected'; } ?>>Yes</option>
				<option value="N" <?php if($e_store_prdt_gst_type == 'N'){ echo 'selected'; } ?>>No</option>
			  </select>
		</div>
	  </div>
	  <div class="form-group row">
		<label for="producttax" class="col-sm-2 col-form-label">GST %</label>
		<div class="col-sm-7">
			  <input type="text" class="form-control" placeholder="GST %" name="producttax" id="producttax" value="<?php echo $e_store_prdt_tax; ?>">
		</div>
	  </div>
	  <div class="form-group row">
		<label for="productstockstatus_ajax" class="col-sm-2 col-form-label">In-Stock</label>
		<div class="col-sm-7">
			<div class="custom-control custom-switch">
			  <input type="checkbox" class="custom-control-input" name="productstockstatus_ajax" id="productstockstatus_ajax"  <?php if($productstockstatus == '1') { echo 'checked=""'; } ?>>
			  <label class="custom-control-label mg-t-10" for="productstockstatus_ajax">Yes</label>
			</div>
		</div>
	  </div>
<?php }
?>
<script>

	var sku_options = {
	url: function(phrase) {
		return "engine/json/JSONestoreprdtsearch.php?title=" + encodeURIComponent(phrase) + "&format=json";
	},
		getValue: "title", //prdt_name
		list: {
			onChooseEvent: function() {
				showProduct_RECORD();
			},	
			match: {
				enabled: false
			},
			hideOnEmptyPhrase: true
		},
		theme: "square"
	};
	$("#sku_code").easyAutocomplete(sku_options);
	
</script>
