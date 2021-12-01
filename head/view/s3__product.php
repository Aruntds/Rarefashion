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

//update related product
if($save == "next") {

	//Product - Related Settings
	$product_related_show = $_REQUEST['related_productshow']; //value='on' == 1 || value='' == 0
	if($product_related_show == 'on') { $relatedshow = '1'; } else { $relatedshow = '0'; }
	$productrelated_items_list = $_REQUEST['productrelated_items'];
	//print_r($productrelated_items_list);exit();
	if( is_array($productrelated_items_list)) {
		while (list ($mkey, $mval) = each ($productrelated_items_list)) {
			$mstring .= $mval.",";
			$related_product = substr($mstring,0,strlen($mstring)-1);
		}
	}
	
	//Product - Upsell Settings
	$product_upsell_show = $_REQUEST['upsell_productshow']; //value='on' == 1 || value='' == 0
	if($product_upsell_show == 'on') { $upsellshow = '1'; } else { $upsellshow = '0'; }

	$productupsell_items_list = $_REQUEST['productupsell_items'];
	if( is_array($productupsell_items_list)) {
		while (list ($ukey, $uval) = each ($productupsell_items_list)) {
			$ustring .= $uval.",";
			$upsell_product = substr($ustring,0,strlen($ustring)-1);
		}
	}
		
	$arrFields=array('`productrelated_show`','`productrelated_items`','`productupsell_show`','`productupsell_items`');
	$arrValues=array("$relatedshow","$related_product","$upsellshow","$upsell_product");
	
	$sqlWhere= "productID=$parentproduct";

	if(sqlACTIONS("UPDATE", "js_product", $arrFields, $arrValues, $sqlWhere)) {
		
		echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
			?>
			<script type="text/javascript">window.location = 'product.php?route=step4&parentproduct=<?php echo $parentproduct; ?>' </script>
			<?php
			//header("Location:category.php?code=1");
			
		exit();

	} else {

		$err[] =  "Unable to Update Record"; 

	}

}

//get product related / upsell details
	$list_datas = sqlQUERY_LABEL("SELECT productrelated_show, productrelated_items, productupsell_show, productupsell_items FROM `js_product` where deleted = '0' and `productID`='$parentproduct'") or die("Unable to get records:".mysql_error());			
	$check_record_availabity = sqlNUMOFROW_LABEL($list_datas);			
	while($row = sqlFETCHARRAY_LABEL($list_datas)){
		//Store Front Page - Category Settings
		$productrelated_show = $row["productrelated_show"];
		$productrelated_items = $row["productrelated_items"];
		//echo$productrelated_items;exit();
		$productupsell_show = $row["productupsell_show"];
		$productupsell_items = $row["productupsell_items"];
	}
?>

    <div class="content">
      <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="row">
          <?php 
	          $product_sidebar_view_type='s3';
	          include viewpath('__productsidebar.php');
          ?>
          <div class="col-lg-9 pd-t-40 bd">
            <div class="mg-b-25">

				<form method="post" enctype="multipart/form-data" data-parsley-validate>
				  
				  <div id="stick-here"></div>
				  <div id="stickThis" class="form-group row mg-b-0">
					<div class="col-3 col-sm-6">
				  		<a href="<?php echo $currentpage; ?>?route=step2&parentproduct=<?php echo $parentproduct; ?>" class="btn btn-secondary" type="cancel"><?php echo $__back; ?></a>
				    </div>
				    <div class="col-9 col-sm-6 text-right">
                      <input type="hidden" name="hidden_parentproduct" id="hidden_parentproduct" value="<?php echo $parentproduct; ?>" />
				      <button type="submit" name="save" value="next" class="btn btn-success">Next</button>
				    </div>
				  </div>

				<!-- BASIC Starting -->
				<div id="basic">
				
					<div class="divider-text">Related Color Product</div>

					<div class="form-group row">
						<label for="related_productshow" class="col-sm-4 col-form-label">Show Related Color Products<span class="tx-danger">*</span></label>
						<div class="col-sm-8">
						<div class="custom-control custom-switch">
						  <input type="checkbox" class="custom-control-input" name="related_productshow" id="related_productshow" <?php if($productrelated_show == '1') { echo 'checked=""'; } ?>>
						  <label class="custom-control-label" for="related_productshow">Yes</label>
						</div>
						</div>
					</div>

					<div id="related_listproducts" class="form-group row" <?php if($productrelated_show == '0') { echo 'style="display:none;"';  }?> >
						<label for="frontpage_featuredproducts" class="col-sm-4 col-form-label">Products</label>
						<div class="col-sm-8">
							 <select name="productrelated_items[]" id="productrelated_items" multiple="multiple" class="form-control related_product" style="width: 100%">
							 <?php echo (getsettingsFRONTPAGEPRODUCTS($productrelated_items, 'show_selected')); ?>
							 </select>
							<span class="tx-10 mg-t-5 tx-orange">You can add maximum of 10 products</span>
						</div>
					</div>				    

				</div>
				<!-- End of BASIC -->
				<div id="basic">
				
					<div class="divider-text">Upsell Product</div>

					<div class="form-group row">
						<label for="upsell_productshow" class="col-sm-4 col-form-label">Show Upselling Products<span class="tx-danger">*</span></label>
						<div class="col-sm-8">
						<div class="custom-control custom-switch">
						  <input type="checkbox" class="custom-control-input" name="upsell_productshow" id="upsell_productshow" <?php if($productupsell_show == '1') { echo 'checked=""'; } ?>>
						  <label class="custom-control-label" for="upsell_productshow">Yes</label>
						</div>
						</div>
					</div>

					<div id="upsell_listproducts" class="form-group row" <?php if($productupsell_show == '0') { echo 'style="display:none;"';  }?> >
						<label for="productupsell_items" class="col-sm-4 col-form-label">Products</label>
						<div class="col-sm-8">
							 <select name="productupsell_items[]" id="productupsell_items" multiple="multiple" class="form-control related_product" style="width: 100%">
							 <?php echo (getsettingsFRONTPAGEPRODUCTS($productupsell_items, 'show_selected')); ?>
							 </select>
							<span class="tx-10 mg-t-5 tx-orange">You can add maximum of 10 products</span>
						</div>
					</div>				    

				</div>
				<!-- End of BASIC -->
				</form>

            </div><!-- row -->
          </div><!-- col -->
        </div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->   