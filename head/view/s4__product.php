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
		<script type="text/javascript">window.location = 'product.php?route=step5&parentproduct=<?php echo $parentproduct; ?>' </script>
		<?php
		
		exit();	
	}
	
}

//Update SEO Details
if($save == "save_seo") {

	$productseourl = $validation_globalclass->sanitize($_REQUEST['productseourl']);
	$productmetatitle = htmlentities($_REQUEST['productmetatitle'], ENT_QUOTES);
	trim ($productmetatitle);
	$productmetakeywords = $validation_globalclass->sanitize($_REQUEST['productmetakeywords']);
	$productmetadescrption = $validation_globalclass->sanitize($_REQUEST['productmetadescrption']);

	//Insert Query
	$arrFields=array('`productseourl`','`productmetatitle`','`productmetakeywords`','`productmetadescrption`');
	$arrValues=array("$productseourl","$productmetatitle","$productmetakeywords","$productmetadescrption");
	
	$sqlWhere= "productID=$parentproduct";

	if(sqlACTIONS("UPDATE","js_product",$arrFields,$arrValues,$sqlWhere)) {
		
		echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
		?>
		<script type="text/javascript">window.location = 'product.php?route=step4&parentproduct=<?php echo $parentproduct; ?>' </script>
		<?php
		exit();
	} else {
		$err[] =  "Unable to Update Record"; 
	}

}

if($parentproduct != '') {
	$product_datas = sqlQUERY_LABEL("SELECT `producttitle`, `productseourl`, `productmetatitle`, `productmetakeywords`, `productmetadescrption` FROM `js_product` where productID='$parentproduct' and deleted = '0'") or die("#1-Unable to get records:".mysql_error());
	
	$count_product_availablecount = sqlNUMOFROW_LABEL($product_datas);
	
	if($count_product_availablecount > 0) {
		while($row = sqlFETCHARRAY_LABEL($product_datas)){
		  $producttitle_decoded = html_entity_decode($row["producttitle"], ENT_QUOTES, "UTF-8");
		  $producttitle = preg_replace("/&#?[a-z0-9]+;/i","",$producttitle_decoded); 
		  $productseourl = $row["productseourl"];
		  $productmetatitle = html_entity_decode($row["productmetatitle"], ENT_QUOTES, "UTF-8");
		  $productmetakeywords = $row["productmetakeywords"];
		  $productmetadescrption = $row["productmetadescrption"];
		  
		  if($productseourl == '') {
			 $product_title_url = $producttitle;
		  } else {
			 $product_title_url = $productseourl;
		  }

		  //meta title		  
		  if($productmetatitle == '') {
			 $product_meta_title = $producttitle_decoded;
		  } else {
			 $product_meta_title = $productmetatitle;
		  }
		  
		}
	}
}
	
?>

    <div class="product">
      <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="row">
          <?php 
	          $product_sidebar_view_type='s4';
	          include viewpath('__productsidebar.php');
          ?>
          <div class="col-lg-9 pd-t-40 bd">
            <div class="mg-b-25">

				<form method="post" enctype="multipart/form-data" data-parsley-validate>
				  
				  <div id="stick-here"></div>
				  <div id="stickThis" class="form-group row mg-b-0">
					<div class="col-3 col-sm-6">
				  		<a href="<?php echo $currentpage; ?>?route=step3&parentproduct=<?php echo $parentproduct; ?>" class="btn btn-secondary" type="cancel"><?php echo $__back; ?></a>
				    </div>
				    <div class="col-9 col-sm-6 text-right">
				      <button type="submit" name="save" value="next" class="btn btn-success">Next</button>
				    </div>
				  </div>

				<!-- SEO Settings -->
				<div id="seo">

				  <div class="divider-text">SEO Settings</div>

				  <div class="form-group row">
				    <label for="productseourl" class="col-sm-2 col-form-label">SEO URL</label>
				    <div class="col-sm-7">
				      <input type="text" class="form-control" name="productseourl" id="productseourl" placeholder="SEO URL" value="<?php echo convertSEOURL($product_title_url); ?>">
				    </div>
				  </div>

				  <div class="form-group row">
				  	<label for="productmetatitle" class="col-sm-2 col-form-label">Meta Title</label>
					<div class="col-sm-7">
						  <input type="text" class="form-control" placeholder="Meta Title" name="productmetatitle" id="productmetatitle" value="<?php echo $product_meta_title; ?>" >
					</div>
				  </div>

				  <div class="form-group row">
				  	<label for="productmetakeywords" class="col-sm-2 col-form-label">Meta Keywords</label>
					<div class="col-sm-7">
						  <input type="text" class="form-control" placeholder="Meta Keywords" name="productmetakeywords" id="productmetakeywords" value="<?php echo $productmetakeywords; ?>" >
					</div>
				  </div>

				  <div class="form-group row">
				  	<label for="productmetadescrption" class="col-sm-2 col-form-label">Meta Description</label>
					<div class="col-sm-7">
						  <textarea class="form-control" rows="2"  name="productmetadescrption" id="productmetadescrption"><?php echo $productmetadescrption; ?></textarea>
					</div>
				  </div>

                  <button type="submit" name="save" value="save_seo" class="btn mg-t-5 btn-success">Save</button>                  

				</div>
				<!-- End of SEO Settings -->

				</form>

            </div><!-- row -->
          </div><!-- col -->
        </div><!-- row -->
      </div><!-- container -->
    </div><!-- product -->   