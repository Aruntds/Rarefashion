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

//Insert Operation
if($save == "save") {

	$product_category = $_REQUEST['productcategory'];
	
	if( is_array($product_category)) {
		while (list ($mkey, $mval) = each ($product_category)) {
			$mstring .= $mval.",";
			$productcategory_list = substr($mstring,0,strlen($mstring)-1);
		}
	}
	
	$productsku = $validation_globalclass->sanitize($_REQUEST['productsku']);
	$productestore_code = $validation_globalclass->sanitize($_REQUEST['productestore_code']);
	$producttitle = htmlentities($_REQUEST['producttitle'], ENT_QUOTES);
	trim ($producttitle);
	$product_descrption = htmlentities($_REQUEST['productdescrption'], ENT_QUOTES);
	trim ($product_descrption);
	$productproperty_descrption = htmlentities($_REQUEST['productpropertydescrption'], ENT_QUOTES);
	trim ($productproperty_descrption);
	$productspecial_notes = htmlentities($_REQUEST['productspecialnotes'], ENT_QUOTES);
	trim ($productspecial_notes);

	$productsellingprice = removenumberFORMATTING($_REQUEST['productsellingprice']);
	$productMRPprice = removenumberFORMATTING($_REQUEST['productMRPprice']);
	$productpurchaseprice = removenumberFORMATTING($_REQUEST['productpurchaseprice']);
	$producttax = $validation_globalclass->sanitize($_REQUEST['producttax']);
	$producttaxtype = $validation_globalclass->sanitize($_REQUEST['producttaxtype']);
	$productopeningstock = $validation_globalclass->sanitize($_REQUEST['productopeningstock']);
	$productavailablestock = $validation_globalclass->sanitize($_REQUEST['productavailablestock']);
	
	//units
	$productheight = $validation_globalclass->sanitize($_REQUEST['productheight']);
	$productheightunit = $validation_globalclass->sanitize($_REQUEST['productheightunit']);
	$productwidth = $validation_globalclass->sanitize($_REQUEST['productwidth']);
	$productwidthunit = $validation_globalclass->sanitize($_REQUEST['productwidthunit']);
	$productdepth = $validation_globalclass->sanitize($_REQUEST['productdepth']);
	$productdepthunit = $validation_globalclass->sanitize($_REQUEST['productdepthunit']);
	$productweight = $validation_globalclass->sanitize($_REQUEST['productweight']);
	$productweightunit = $validation_globalclass->sanitize($_REQUEST['productweightunit']);
	if($productstockstatus_ajax){
	if($productstockstatus_ajax == 'on') { $productstock_status = '1'; } else { $productstock_status = '0'; }
	} else {
	$productstockstatus = $_REQUEST['productstockstatus'];
	if($productstockstatus == 'on') { $productstock_status = '1'; } else { $productstock_status = '0'; }
	}
	$product_status = $_REQUEST['productstatus']; //value='on' == 1 || value='' == 0
	if($product_status == 'on') { $product_status = '1'; } else { $_status = '0'; }
	
	//check purchase price - selling price
	$yousave = ($productMRPprice-$productsellingprice);
	
	//check if for edit or not
	if($hidden_parentproductID == '') {
		
		//check if SKU already used
		$check_duplicateSKU = commonNOOFROWS_COUNT('js_product', "createdby='$logged_user_id' and productsku='$productsku' ");
		if($check_duplicateSKU > 0) {
			$err[] = 'Product SKU already used.'	;
		}
		
	if(empty($err)) {
		//Insert Query
		$arrFields=array('`productcategory`','`productsku`','`producttitle`','`productdescrption`','`productpropertydescrption`','`productspecialnotes`','`productsellingprice`','`productMRPprice`','`productpurchaseprice`','`productyousaveprice`','`producttaxtype`','`producttax`','`productstockstatus`','`productopeningstock`','`productavailablestock`','`productheight`', '`productheightunit`', '`productwidth`', '`productwidthunit`', '`productdepth`', '`productdepthunit`', '`productweight`', '`productweightunit`','`createdby`','`status`');

		$arrValues=array("$productcategory_list","$productsku","$producttitle","$product_descrption","$productproperty_descrption","$productspecial_notes","$productsellingprice","$productMRPprice","$productpurchaseprice","$yousave","$producttaxtype","$producttax","$productstock_status","$productopeningstock","$productavailablestock","$productheight", "$productheightunit", "$productwidth", "$productwidthunit", "$productdepth", "$productdepthunit", "$productweight", "$productweightunit","$logged_user_id","$product_status");
		// print_r($arrValues);
		// exit();
		if(sqlACTIONS("INSERT","js_product",$arrFields,$arrValues,'')) {
			$productid = sqlINSERTID_LABEL();
			echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";

				?>
				<script type="text/javascript">window.location = 'product.php?route=step2&parentproduct=<?php echo $productid; ?>&code=1' </script>
				<?php

			exit();

		} else {

			$err[] =  "Unable to Insert Record"; 

		}
		
	} 
	} else {
	if(empty($err)) {
		//Update Query
		$arrFields=array('`productcategory`','`productsku`','`producttitle`','`productdescrption`','`productpropertydescrption`','`productspecialnotes`','`productsellingprice`','`productMRPprice`','`productpurchaseprice`','`productyousaveprice`','`producttaxtype`','`producttax`','`productstockstatus`','`productopeningstock`','`productavailablestock`','`productheight`', '`productheightunit`', '`productwidth`', '`productwidthunit`', '`productdepth`', '`productdepthunit`', '`productweight`', '`productweightunit`','`createdby`','`status`');

		$arrValues=array("$productcategory_list","$productsku","$producttitle","$product_descrption","$productproperty_descrption","$productspecial_notes","$productsellingprice","$productMRPprice","$productpurchaseprice","$yousave","$producttaxtype","$producttax","$productstock_status","$productopeningstock","$productavailablestock","$productheight", "$productheightunit", "$productwidth", "$productwidthunit", "$productdepth", "$productdepthunit", "$productweight", "$productweightunit","$logged_user_id","$product_status");

		$sqlWhere= "productID=$hidden_parentproductID";

		if(sqlACTIONS("UPDATE","js_product",$arrFields,$arrValues,$sqlWhere)) {
			$productid = sqlINSERTID_LABEL();
			echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";

				?>
				<script type="text/javascript">window.location = 'product.php?route=step1&parentproduct=<?php echo $hidden_parentproductID; ?>&code=11' </script>
				<?php

			exit();

		} else {

			$err[] =  "Unable to Insert Record"; 

		}
		
	} 	
	}

}

//get product details before update
if($parentproduct != '') {
//'`productcategory`','`productsku`','`producttitle`','`productdescrption`','`productpropertydescrption`','`productspecialnotes`','`productsellingprice`','`productMRPprice`','`productpurchaseprice`','`productyousaveprice`','`producttax`','`productstockstatus`','`productopeningstock`','`productavailablestock`','`productheight`', '`productheightunit`', '`productwidth`', '`productwidthunit`', '`productdepth`', '`productdepthunit`', '`productweight`', '`productweightunit`','`createdby`','`status`'
	$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_product` where deleted = '0' and `productID`='$parentproduct'") or die("Unable to get records:".mysql_error());			
	$check_record_availabity = sqlNUMOFROW_LABEL($list_datas);			

	while($row = sqlFETCHARRAY_LABEL($list_datas)){
	  $productID = $row["productID"];
	  $productcategory = $row["productcategory"];
	  $productsku = $row["productsku"];
	  $productestore_code = $row["productestore_code"];
	  $producttitle = html_entity_decode($row["producttitle"], ENT_QUOTES, "UTF-8"); //$row["producttitle"];
	  $producttitle = str_replace("\'","'",$producttitle); //$row["producttitle"];
	  $productdescrption = html_entity_decode($row["productdescrption"], ENT_QUOTES, "UTF-8");
	  $productdescrption = str_replace("\'","'",$productdescrption); //$row["producttitle"];
	  $productpropertydescrption = html_entity_decode($row["productpropertydescrption"], ENT_QUOTES, "UTF-8");
	  $productpropertydescrption = str_replace("\'","'",$productpropertydescrption); //$row["producttitle"];
	  $productspecialnotes = html_entity_decode($row["productspecialnotes"], ENT_QUOTES, "UTF-8");
	  $productspecialnotes = str_replace("\'","'",$productspecialnotes); //$row["producttitle"];
	  $productsellingprice = $row["productsellingprice"];
	  $productMRPprice = $row["productMRPprice"];
	  $productpurchaseprice = $row["productpurchaseprice"];
	  $producttax = $row["producttax"];
	  $producttaxtype = $row["producttaxtype"];
	  $productopeningstock = $row["productopeningstock"];
	  $productavailablestock = $row["productavailablestock"];
	  
	  $productheight = $row["productheight"];
	  $productheightunitID = $row["productheightunit"];
	  $productwidth = $row["productwidth"];
	  $productwidthunitID = $row["productwidthunit"];
	  $productdepth = $row["productdepth"];
	  $productdepthunitID = $row["productdepthunit"];
	  $productweight = $row["productweight"];
	  $productweightunitID = $row["productweightunit"];
	  
	  $productstockstatus = $row["productstockstatus"];  //stock status
	  $status = $row["status"];  //product status	  
	}
	
}


?>

    <div class="content">
      <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="row">
          <?php 
	          $product_sidebar_view_type='s1';
	          include viewpath('__productsidebar.php');
          ?>
          <div class="col-lg-9 pd-t-40 bd">
            <div class="mg-b-25">

				<form method="post" enctype="multipart/form-data" data-parsley-validate>
				  
				  <div id="stick-here"></div>
				  <div id="stickThis" class="form-group row mg-b-0">
					<div class="col-3 col-sm-6">
				  		<?php pageCANCEL($currentpage, $__back); ?>
				    </div>
				    <div class="col-9 col-sm-6 text-right">
                      <?php if($parentproduct != '') { ?>
                      <input type="hidden" name="hidden_parentproductID" value="<?php echo $parentproduct; ?>" />
 				      <button type="submit" name="save" value="save" class="btn btn-warning">Update </button>
                     <?php } else { ?>
 				      <button type="submit" name="save" value="save" class="btn btn-success">Save & Continue </button>
                      <?php } ?>
				    </div>
				  </div>

				<!-- BASIC Starting -->
				<div id="basic">
				  <div class="divider-text">Product Info</div>
                      
                      <div class="form-group row">
                        <label for="productstatus" class="col-sm-2 col-form-label">Active</label>
                        <div class="col-sm-7">
                            <div class="custom-control custom-switch">
                              <input type="checkbox" class="custom-control-input" name="productstatus" id="productstatus" <?php if($status == '1') { echo 'checked=""'; } ?>>
                              <label class="custom-control-label" for="productstatus">Yes</label>
                            </div>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="productcategory" class="col-sm-2 col-form-label">Product Category</label>
                        <div class="col-sm-7">
                         <select name="productcategory[]" id="productcategory" multiple="multiple" size="6" class="custom-select">
                              <?php 
							  if($parentproduct != '') { 
							  	getPRODUCTCATEGORY($productcategory, 'multiselect', 'select'); 
							  } else { 
							  	getPRODUCTCATEGORY($productcategory, '', 'select');
							  }
							  ?>
                            </select>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="productsku" class="col-sm-2 col-form-label">SKU Code<span class="tx-danger">*</span></label>
                        <div class="col-sm-7">
                              <input type="text" class="form-control" placeholder="SKU Code" name="productsku" id="productsku" value="<?php echo $productsku; ?>" required>
                        </div>
                      </div>

					<span id="hide_defalut_prdt_title">
					<div class="divider-text">Product Info</div>
                      <div class="form-group row">
                        <label for="producttitle" class="col-sm-2 col-form-label">Product Title<span class="tx-danger">*</span></label>
                        <div class="col-sm-7">
                              <input type="text" class="form-control" placeholder="Product Title" name="producttitle" id="producttitle" value="<?php echo $producttitle; ?>" required>
                        </div>
                      </div>
					  
					  <div class="form-group row">
						<label for="productMRPprice" class="col-sm-2 col-form-label">MRP Price<span class="tx-danger">*</span></label>
						<div class="col-sm-7">
							  <input type="text" class="form-control" placeholder="MRP Price" name="productMRPprice" id="productMRPprice" value="<?php echo $productMRPprice; ?>" required>
						</div>
					  </div>

					  <div class="form-group row">
						<label for="productsellingprice" class="col-sm-2 col-form-label">Selling Price<span class="tx-danger">*</span></label>
						<div class="col-sm-7">
							  <input type="text" class="form-control" placeholder="Selling Price" name="productsellingprice" id="productsellingprice" value="<?php echo $productsellingprice; ?>" required>
						</div>
					  </div>
					  
					   <div class="form-group row">
						<label for="productsellingprice" class="col-sm-2 col-form-label">Product opening stock<span class="tx-danger">*</span></label>
						<div class="col-sm-7">
							  <input type="text" class="form-control" placeholder="Product opening stock" name="productopeningstock" id="productopeningstock" value="<?php echo $productopeningstock; ?>" required>
						</div>
					  </div>
					  
					   <div class="form-group row">
						<label for="productsellingprice" class="col-sm-2 col-form-label">Product available stock<span class="tx-danger">*</span></label>
						<div class="col-sm-7">
							  <input type="text" class="form-control" placeholder="Product available stock" name="productavailablestock" id="productavailablestock" value="<?php echo $productavailablestock; ?>" required>
						</div>
					  </div> 
					  
					  <div class="form-group row">
						<label for="productpurchaseprice" class="col-sm-2 col-form-label">Purchase/Manufacturing Price<span class="tx-danger">*</span></label>
						<div class="col-sm-7">
							  <input type="text" class="form-control" placeholder="Our Price" name="productpurchaseprice" id="productpurchaseprice" value="<?php echo $productpurchaseprice; ?>" required>
						</div>
					  </div>
						
					  <div class="form-group row">
						<label for="producttaxtype" class="col-sm-2 col-form-label">GST Included</label>
						<div class="col-sm-7">
							  <select class="custom-select" name="producttaxtype" id="producttaxtype">
								<option value="Y" <?php if($producttaxtype == 'Y'){ echo 'selected'; } ?>>Yes</option>
								<option value="N" <?php if($producttaxtype == 'N'){ echo 'selected'; } ?>>No</option>
							  </select>
						</div>
					  </div>
					  <div class="form-group row">
						<label for="producttax" class="col-sm-2 col-form-label">GST %<span class="tx-danger">*</span></label>
						<div class="col-sm-7">
							  <input type="text" class="form-control" placeholder="GST %" name="producttax" id="producttax" value="<?php echo $producttax; ?>" required>
						</div>
					  </div>

                      <div class="form-group row">
                        <label for="productstockstatus" class="col-sm-2 col-form-label">In-Stock</label>
                        <div class="col-sm-7">
                            <div class="custom-control custom-switch">
                              <input type="checkbox" class="custom-control-input" name="productstockstatus" id="productstockstatus"  <?php if($productstockstatus == '1') { echo 'checked=""'; } ?>>
                              <label class="custom-control-label mg-t-10" for="productstockstatus">Yes</label>
                            </div>
                        </div>
                      </div>
					</span>

					  <span id="show_ajax_prdt_title"></span>

					<div class="divider-text">Product Descrption Details</div>

                      <div class="form-group row">
                        <label for="productdescrption" class="col-sm-2 col-form-label">Product Descrption</label>
                        <div class="col-sm-7">
                            <textarea class="form-control producteditor" rows="2" placeholder="Product Descrption..."  name="productdescrption" id="productdescrption"><?php echo $productdescrption; ?></textarea>
                        </div>
                      </div>                   
                    
                      <div class="form-group row">
                        <label for="productpropertydescrption" class="col-sm-2 col-form-label">Product Property Descrption</label>
                        <div class="col-sm-7">
                            <textarea class="form-control producteditor" rows="2" placeholder="Product Property..."  name="productpropertydescrption" id="productpropertydescrption"><?php echo $productpropertydescrption; ?></textarea>
                        </div>
                      </div>  
                    
                      <div class="form-group row">
                        <label for="productspecialnotes" class="col-sm-2 col-form-label">Special Notes</label>
                        <div class="col-sm-7">
                            <textarea class="form-control" rows="2" placeholder="eg. 10 days shipping guarantee / Avail 0% EMI of this product"  name="productspecialnotes" id="productspecialnotes"><?php echo $productspecialnotes; ?></textarea>
                        </div>
                      </div>  
                                          
				  <!--<div class="divider-text">Product Stock</div>
                      
                      <div class="form-group row">
                        <label for="productstockstatus" class="col-sm-2 col-form-label">In-Stock</label>
                        <div class="col-sm-7">
                            <div class="custom-control custom-switch">
                              <input type="checkbox" class="custom-control-input" name="productstockstatus" id="productstockstatus"  <?php //if($productstockstatus == '1') { echo 'checked=""'; } ?>>
                              <label class="custom-control-label" for="productstockstatus">Yes</label>
                            </div>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="productopeningstock" class="col-sm-2 col-form-label">Opening Stock</label>
                        <div class="col-sm-7">
                              <input type="text" class="form-control" placeholder="Opening Stock" name="productopeningstock" id="productopeningstock" value="<?php //echo $productopeningstock; ?>">
                        </div>
                      </div>
                      
                      <div class="form-group row">
                        <label for="productavailablestock" class="col-sm-2 col-form-label">Available Stock</label>
                        <div class="col-sm-7">
                              <input type="text" class="form-control" placeholder="Available Stock" name="productavailablestock" id="productavailablestock" value="<?php //echo $productavailablestock; ?>">
                        </div>
                      </div>
                      
				  <div class="divider-text">Product Measurement</div>
                      
                     <!-- <div class="form-group row">
                        <label for="productheight" class="col-sm-2 col-form-label">Height</label>
                        
                        <div class="col-sm-5 pd-r-0">
                              <input type="text" class="form-control" placeholder="Height" name="productheight" id="productheight" value="<?php// echo $productheight; ?>">
                        </div>
                    
                        <div class="form-group col-md-2 pd-l-0 d-flex align-items-end">
                          <select class="custom-select" name="productheightunit" id="productheightunit">
                            <?php //echo getproductCOMMONUNITS('1',$productheightunitID, 'select'); ?>
                          </select>
                        </div>
                        
                      </div>
                      
                      <div class="form-group row">
                        <label for="productwidth" class="col-sm-2 col-form-label">Width</label>
                        
                        <div class="col-sm-5 pd-r-0">
                              <input type="text" class="form-control" placeholder="Width" name="productwidth" id="productwidth" value="<?php //echo $productwidth; ?>">
                        </div>
                    
                        <div class="form-group col-md-2 pd-l-0 d-flex align-items-end">
                          <select class="custom-select" name="productwidthunit" id="productwidthunit">
                            <?php //echo getproductCOMMONUNITS('2',$productwidthunitID, 'select'); ?>
                          </select>
                        </div>
                        
                      </div>
                      
                      <div class="form-group row">
                        <label for="productdepth" class="col-sm-2 col-form-label">Depth</label>
                        
                        <div class="col-sm-5 pd-r-0">
                              <input type="text" class="form-control" placeholder="Depth" name="productdepth" id="productdepth" value="<?php// echo $productdepth; ?>">
                        </div>
                    
                        <div class="form-group col-md-2 pd-l-0 d-flex align-items-end">
                          <select class="custom-select" name="productdepthunit" id="productdepthunit">
                            <?php //echo getproductCOMMONUNITS('3',$productdepthunitID, 'select'); ?>
                          </select>
                        </div>
                        
                      </div>
                      
                      <div class="form-group row">
                        <label for="productweight" class="col-sm-2 col-form-label">Weight</label>
                        
                        <div class="col-sm-5 pd-r-0">
                              <input type="text" class="form-control" placeholder="Weight" name="productweight" id="productweight" value="<?php //echo $productweight; ?>">
                        </div>
                    
                        <div class="form-group col-md-2 pd-l-0 d-flex align-items-end">
                          <select class="custom-select" name="productweightunit" id="productweightunit">
                            <?php //echo getproductCOMMONUNITS('4',$productweightunitID, 'select'); ?>
                          </select>
                        </div>
                        
                      </div>     -->            


				</div>
				<!-- End of BASIC -->

				</form>

            </div><!-- row -->
          </div><!-- col -->
          

        </div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->   