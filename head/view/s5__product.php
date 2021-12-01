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
protectpg_includes();

//Skip to next step
if($save == "next") {

	if(empty($err)) {
		echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";	
		?>
		<script type="text/javascript">window.location = 'product.php?route=step6&parentproduct=<?php echo $parentproduct; ?>' </script>
		<?php		
		exit();	
	}
	
}

//save filter option
if($save == "save") {

	echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
	
		?>
		<script type="text/javascript">window.location = 'product.php?route=preview&parentproduct=<?php echo $hidden_parentproductID; ?>&code=1' </script>
		<?php

	exit();

	$producttype = $_REQUEST['producttype'];
	if( is_array($producttype)) {
		while (list ($mkey, $mval) = each ($producttype)) {
			$mstring .= $mval.",";
			$producttype_list = substr($mstring,0,strlen($mstring)-1);
		}
	}

	$productcolor = $_REQUEST['productcolor'];
	if( is_array($productcolor)) {
		while (list ($mkey, $mval) = each ($productcolor)) {
			$mstring .= $mval.",";
			$productcolor_list = substr($mstring,0,strlen($mstring)-1);
		}
	}

	$productmaterial = $_REQUEST['productmaterial'];
	if( is_array($productmaterial)) {
		while (list ($mkey, $mval) = each ($productmaterial)) {
			$mstring .= $mval.",";
			$productmaterial_list = substr($mstring,0,strlen($mstring)-1);
		}
	}

		//Insert query
		$arrFields=array('`producttype`','`productcolor`','`productmaterial`');

		$arrValues=array("$producttype_list","$productcolor_list","$productmaterial_list");

		$sqlWhere= "productID=$hidden_parentproductID";

		if(sqlACTIONS("UPDATE","js_product",$arrFields,$arrValues, $sqlWhere)) {
			
			echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
			
				?>
				<script type="text/javascript">window.location = 'product.php?route=step5&parentproduct=<?php echo $hidden_parentproductID; ?>&code=1' </script>
				<?php

			exit();

		} else {

			$err[] =  "Unable to Insert Record"; 

		}

}

//get product gift wrapping
if($parentproduct != '') {

	$list_datas = sqlQUERY_LABEL("SELECT `producttype`, `productcolor`, `productmaterial` FROM `js_product` where deleted = '0' and `productID`='$parentproduct'") or die("Unable to get records:".mysqli_error());			
	$check_record_availabity = sqlNUMOFROW_LABEL($list_datas);			

	while($row = sqlFETCHARRAY_LABEL($list_datas)){
	  $productfiltertypeID = $row["producttype"];
	  $productfiltercolorID = $row["productcolor"];
	  $productfiltermaterialID = $row["productmaterial"];
	}
	
}

if($save_ajax_variant == 'save_ajax_variant'){

	if($ajax_variant_taxtype == 'Y') {
		$taxsplit_price = ($ajax_selling_price * ($ajax_variant_tax_value/100))/2;
		$final_selling_price = ($ajax_selling_price - ($taxsplit_price* 2));
	} else {
		$taxsplit_price = (($ajax_selling_price * ($ajax_variant_tax_value/100))/2);
		$final_selling_price = $ajax_selling_price;
	}
	//Insert query
	$arrFields=array('`variant_name`', '`parentproduct`', '`variant_code`', '`variantstockstatus`', '`variant_mrp_price`','`variant_msp_price`', '`variant_available_stock`', '`variant_opening_stock`', '`variant_tax_value`', '`variant_taxtype`', '`variant_taxsplit1`', '`variant_taxsplit2`', '`createdby`', '`status`');

	$arrValues=array("$ajax_variant_name","$parentproduct","$sku_code","$ajax_stock_in_status","$ajax_mrp_price","$final_selling_price","$available_stock","$opening_stock","$ajax_variant_tax_value","$ajax_variant_taxtype","$taxsplit_price","$taxsplit_price","$logged_user_id","1");
	// print_r($arrValues);
	// exit();
	if($ajax_hidden_variant_ID !=''){
	
	$sqlWhere= " variant_ID = $ajax_hidden_variant_ID";

	if(sqlACTIONS("UPDATE","js_productvariants",$arrFields,$arrValues, $sqlWhere)) {
		
		echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
		
			?>
			<script type="text/javascript">window.location = 'product.php?route=step5&parentproduct=<?php echo $parentproduct; ?>&code=1' </script>
			<?php
		exit();

	} else {

		$err[] =  "Unable to Insert Record"; 

	}
	
	} else {
	if(sqlACTIONS("INSERT","js_productvariants",$arrFields,$arrValues, '')) {
		
		echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
		
			?>
			<script type="text/javascript">window.location = 'product.php?route=step5&parentproduct=<?php echo $parentproduct; ?>&code=1' </script>
			<?php
		exit();

	} else {

		$err[] =  "Unable to Insert Record"; 

	}
	}
}

if($update_variant == 'update_variant'){

	if($ajax_variant_taxtype == 'Y') {
		$taxsplit_price = ($selling_price * ($variant_tax_value/100))/2;
		$final_selling_price = ($selling_price - ($taxsplit_price* 2));
	} else {
		$taxsplit_price = (($selling_price * ($variant_tax_value/100))/2);
		$final_selling_price = $selling_price;
	}
	//Insert query
	$arrFields=array('`variant_name`','`parentproduct`','`variant_code`','`variantstockstatus`','`variant_mrp_price`','`variant_msp_price`','`variant_tax_value`','`variant_taxtype`','`variant_taxsplit1`','`variant_taxsplit2`','`createdby`','`status`');

	$arrValues=array("$variant_name","$parentproduct","$sku_code","$stock_in_status","$mrp_price","$final_selling_price","$variant_tax_value","$variant_taxtype","$taxsplit_price","$taxsplit_price","$logged_user_id","1");
	// print_r($arrValues);
	// exit();
	
	$sqlWhere= "variant_ID=$hidden_variant_ID";

	if(sqlACTIONS("UPDATE","js_productvariants",$arrFields,$arrValues, $sqlWhere)) {
		
		echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
		
			?>
			<script type="text/javascript">window.location = 'product.php?route=step5&parentproduct=<?php echo $parentproduct; ?>&code=1' </script>
			<?php
		exit();

	} else {

		$err[] =  "Unable to Insert Record"; 

	}
	
}

if($variantid != '') {

	$list_prdt_variant_datas = sqlQUERY_LABEL("SELECT `variant_code`, `variantstockstatus`, `variant_ID`, `variant_name`, `variant_mrp_price`, `variant_msp_price`,`variant_tax_value`,`variant_taxtype`,`variant_taxsplit1`,`variant_taxsplit2` FROM `js_productvariants` where deleted = '0' and status = '1' and `variant_ID`='$variantid'") or die("Unable to get records:".mysqli_error());			
	$check_variant_record_availabity = sqlNUMOFROW_LABEL($list_prdt_variant_datas);			

	while($row = sqlFETCHARRAY_LABEL($list_prdt_variant_datas)){
	  $variant_ID = $row["variant_ID"];
	  $variant_name = $row["variant_name"];
	  $variant_code = $row["variant_code"];
	  $variantstockstatus = $row["variantstockstatus"];
	  $variant_mrp_price = $row["variant_mrp_price"];
	  $variant_msp_price = $row["variant_msp_price"];
	  $variant_tax_value = $row["variant_tax_value"];
	  $variant_taxtype = $row["variant_taxtype"];
	  $variant_taxsplit1 = $row["variant_taxsplit1"];
	  $variant_taxsplit2 = $row["variant_taxsplit2"];
	}
	
}

?>

    <div class="content">
      <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="row">
          <?php 
	          $product_sidebar_view_type='s5';
	          include viewpath('__productsidebar.php');
          ?>
          <div class="col-lg-9 pd-t-40 bd">
            <div class="mg-b-25">

				<form method="post" enctype="multipart/form-data" data-parsley-validate>
				  
				  <div id="stick-here"></div>
				  <div id="stickThis" class="form-group row mg-b-20">
					<div class="col-3 col-sm-6">
				  		<a href="<?php echo $currentpage; ?>?route=step4&parentproduct=<?php echo $parentproduct; ?>" class="btn btn-secondary" type="cancel"><?php echo $__back; ?></a>
				    </div>
				    <div class="col-9 col-sm-6 text-right">
                          
                      <input type="hidden" name="hidden_parentproductID" value="<?php echo $parentproduct; ?>" />
                      <button type="submit" name="save" value="save" class="btn btn-success">Save</button>                  
				      <button type="submit" name="save" value="next" class="btn btn-success">Next</button>
				    </div>
				  </div>
					
				<?php if($route == 'step5' && $formtype == '' && $variantid =='') { ?>
				<a href="?route=step5&parentproduct=<?php echo $parentproduct; ?>&formtype=addvariant" class="btn btn-primary btn-sm float-right mg-b-10">+ Add Variant</a>

				<div data-label="Example" class="df-example demo-table table-responsive">
				  <table id="variantLIST" class="table table-bordered" width="99%">
					<thead>
						<tr>
							<th class="wd-5p">S.No</th>
							<th class="wd-15p">Variant Name</th>
							<th class="wd-20p">Variant Code</th>
							<th class="wd-20p">Stock</th>
							<th class="wd-10p">MRP Price</th>
							<th class="wd-10p">Selling Price</th>
							<th class="wd-10p">Options</th>
						</tr>
					</thead>
				  </table>
				</div>

				<?php } else if($route == 'step5' && ($formtype == '' || $variantid !='')){ ?>

				<div id="basic" class="mg-l-20">
				  <div class="divider-text">Basic Info</div>
                  <div class="form-group row">
				  	<label for="status" class="col-sm-2 col-form-label">Active</label>
					<div class="col-sm-7">
						<div class="custom-control custom-switch">
						  <input type="checkbox" class="custom-control-input" name="status" id="status" checked="">
						  <label class="custom-control-label mg-t-10" for="status">Yes</label>
						</div>
					</div>
				  </div>
				  <span id="additem"></span>
				  <span id="hide_default">
				  <div class="row">
					<div class="form-group col-md-6">
						<label for="sku_code" class="col-form-label">SKU Code<span class="tx-danger">*</span></label>
						<div class="">
							<input type="text" class="form-control" name="sku_code" id="sku_code" placeholder="" value="<?php echo $variant_code; ?>">				      
						</div>
					</div>
					<div class="form-group col-md-6">
						<label for="variant_name" class="col-form-label">Variant Name<span class="tx-danger">*</span></label>
						<div class="">
							<input type="text" class="form-control" name="variant_name" id="variant_name" placeholder=" "  value="<?php echo $variant_name; ?>">				      
						</div>
					</div>
				  </div>
				  <div class="row">
					<div class="form-group col-md-4">
						<label for="purchase_price" class="col-form-label">In Stock<span class="tx-danger">*</span></label>
						<div class="">
							<select class="form-control custom-select" name="stock_in_status" id="stock_in_status">
							<option value="0" <?php if($variantstockstatus == '0'){ echo 'selected'; } ?>>No</option>
							<option value="1" <?php if($variantstockstatus == '1'){ echo 'selected'; } ?>>Yes</option>
							</select>
						</div>
					</div>
					<div class="form-group col-md-4">
						<label for="mrp_price" class="col-form-label">MRP Price<span class="tx-danger">*</span></label>
						<div class="">
							<input type="text" class="form-control" name="mrp_price" id="mrp_price" placeholder=" "  value="<?php echo $variant_mrp_price; ?>">				      
						</div>
					</div>
					<div class="form-group col-md-4">
						<label for="selling_price" class="col-form-label">Selling Price<span class="tx-danger">*</span></label>
						<div class="">
							<input type="text" class="form-control" name="selling_price" id="selling_price" placeholder=" "  value="<?php echo $variant_msp_price; ?>">				      
						</div>
					</div>
					<div class="form-group col-md-4">
						<label for="opening_stock" class="col-form-label">Opening Stock<span class="tx-danger">*</span></label>
						<div class="">
							<input type="text" class="form-control" name="opening_stock" id="opening_stock" placeholder=" "  value="<?php echo $variant_opening_stock; ?>">				      
						</div>
					</div>
					<div class="form-group col-md-4">
						<label for="available_stock" class="col-form-label">Available Stock<span class="tx-danger">*</span></label>
						<div class="">
							<input type="text" class="form-control" name="available_stock" id="available_stock" placeholder=" "  value="<?php echo $variant_available_stock; ?>">				      
						</div>
					</div>
					<div class="form-group col-md-4">
						<label for="variant_taxtype" class="col-form-label">GST Included</label>
						<div class="">
							  <select class="custom-select" name="variant_taxtype" id="variant_taxtype">
								<option value="Y" <?php if($variant_taxtype == 'Y'){ echo 'selected'; } ?>>Yes</option>
								<option value="N" <?php if($variant_taxtype == 'N'){ echo 'selected'; } ?>>No</option>
							  </select>
						</div>
					</div>
					<div class="form-group col-md-4">
						<label for="variant_tax_value" class="col-form-label">GST %</label>
						<div class="">
							  <input type="text" class="form-control" placeholder="GST %" name="variant_tax_value" id="variant_tax_value" value="<?php echo $variant_tax_value; ?>">
						</div>
					</div>
				  </div>
				<div class="row">
					<div class="form-group col-md-12">
					<input type="hidden" name="hidden_variant_ID" id="hidden_variant_ID" value="<?php echo $variant_ID; ?>">
						<button type="submit" name="update_variant" value="update_variant" class="btn btn-warning float-right">Update</button>
					</div>
				</div>
				  </span>
				</div>
					
					<?php } ?>
                   <!-- <div class="divider-text">Variant - Type</div>
                      <div class="form-group row">
                        <label for="producttype" class="col-sm-2 col-form-label">Product Type</label>
                        <div class="col-sm-7">
                         <select name="producttype[]" id="producttype" multiple="multiple" size="6" class="custom-select">
                              <?php //getproductFILTERTYPE($productfiltertypeID, '', 'select'); ?>
                            </select>
                        </div>
                      </div>

                    <div class="divider-text">Variant - Brand</div>
                                            
                      <div class="form-group row">
                        <label for="productcolor" class="col-sm-2 col-form-label">Product Brand</label>
                        <div class="col-sm-7">
                         <select name="productcolor[]" id="productcolor" multiple="multiple" size="6" class="custom-select">
                              <?php //getproductFILTERCOLOR($productfiltercolorID, '', 'select'); ?>
                            </select>
                        </div>
                      </div>

                    <div class="divider-text">Variant - Material</div>
                                            
                      <div class="form-group row">
                        <label for="productmaterial" class="col-sm-2 col-form-label">Product Material</label>
                        <div class="col-sm-7">
                         <select name="productmaterial[]" id="productmaterial" multiple="multiple" size="6" class="custom-select">
                              <?php //getproductFILTERMATERIAL($productfiltermaterialID, 'multiple', 'select'); ?>
                            </select>
                        </div>
                      </div>-->
				<?php if($formtype == 'addvariant' && $route == 'step5'){?>
				
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
			<label for="opening_stock" class="col-form-label">Opening Stock<span class="tx-danger">*</span></label>
			<div class="">
				<input type="text" class="form-control" name="opening_stock" id="opening_stock" placeholder=" "  value="<?php echo $variant_opening_stock; ?>">				      
			</div>
		</div>
		<div class="form-group col-md-4">
			<label for="available_stock" class="col-form-label">Available Stock<span class="tx-danger">*</span></label>
			<div class="">
				<input type="text" class="form-control" name="available_stock" id="available_stock" placeholder=" "  value="<?php echo $variant_available_stock; ?>">				      
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
				
				<?php } ?>
				</div>
				<!-- End of BASIC -->

				</form>

            </div><!-- row -->
          </div><!-- col -->
        </div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->   
