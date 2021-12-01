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
		<script type="text/javascript">window.location = 'product.php?code=1' </script>
		<?php
		
		exit();	
	}
	
}

//save filter option
if($save == "save") {

	$producttype = $_REQUEST['producttype'];
	if( is_array($producttype)) {
		while (list ($mkey, $mval) = each ($producttype)) {
			$mstring_type .= $mval.",";
			$producttype_list = substr($mstring_type,0,strlen($mstring_type)-1);
		}
	}

	$productcolor = $_REQUEST['productcolor'];
	if( is_array($productcolor)) {
		while (list ($mkey, $mval) = each ($productcolor)) {
			$mstring_color .= $mval.",";
			$productcolor_list = substr($mstring_color,0,strlen($mstring_color)-1);
		}
	}

	$productmaterial = $_REQUEST['productmaterial'];
	if( is_array($productmaterial)) {
		while (list ($mkey, $mval) = each ($productmaterial)) {
			$mstring_material .= $mval.",";
			$productmaterial_list = substr($mstring_material,0,strlen($mstring_material)-1);
		}
	}

		//Insert query
		$arrFields=array('`producttype`','`productcolor`','`productmaterial`');

		$arrValues=array("$producttype_list","$productcolor_list","$productmaterial_list");

		$sqlWhere= "productID=$hidden_parentproductID";

		if(sqlACTIONS("UPDATE","js_product",$arrFields,$arrValues, $sqlWhere)) {
			
			echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
			
				?>
				<script type="text/javascript">window.location = 'product.php?route=step6&parentproduct=<?php echo $hidden_parentproductID; ?>&code=1' </script>
				<?php

			exit();

		} else {

			$err[] =  "Unable to Insert Record"; 

		}

}

//get product gift wrapping
if($parentproduct != '') {

	$list_datas = sqlQUERY_LABEL("SELECT `producttype`, `productcolor`, `productmaterial` FROM `js_product` where deleted = '0' and `productID`='$parentproduct'") or die("Unable to get records:".mysql_error());			
	$check_record_availabity = sqlNUMOFROW_LABEL($list_datas);			

	while($row = sqlFETCHARRAY_LABEL($list_datas)){
	  $productfiltertypeID = $row["producttype"];
	  $productfiltercolorID = $row["productcolor"];
	  $productfiltermaterialID = $row["productmaterial"];
	}
	
}

?>

    <div class="content">
      <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="row">
          <?php 
	          $product_sidebar_view_type='s6';
	          include viewpath('__productsidebar.php');
          ?>
          <div class="col-lg-9 pd-t-40 bd">
            <div class="mg-b-25">

				<form method="post" enctype="multipart/form-data" data-parsley-validate>
				  
				  <div id="stick-here"></div>
				  <div id="stickThis" class="form-group row mg-b-0">
					<div class="col-3 col-sm-6">
				  		<a href="<?php echo $currentpage; ?>?route=step4&parentproduct=<?php echo $parentproduct; ?>" class="btn btn-secondary" type="cancel"><?php echo $__back; ?></a>
				    </div>
				    <div class="col-9 col-sm-6 text-right">
                          
                      <input type="hidden" name="hidden_parentproductID" value="<?php echo $parentproduct; ?>" />
                      <button type="submit" name="save" value="save" class="btn btn-success">Save</button>                  
				      <button type="submit" name="save" value="next" class="btn btn-success">Next</button>
				    </div>
				  </div>

				<!-- BASIC Starting -->
				<div id="basic">
                    <div class="divider-text">Variant - Type</div>
                                            
                      <div class="form-group row">
                        <label for="producttype" class="col-sm-2 col-form-label">Product Type</label>
                        <div class="col-sm-7">
                         <select name="producttype[]" id="producttype" multiple="multiple" size="6" class="custom-select">
                              <?php 
							  if($parentproduct != '') { 
							  	getproductFILTERTYPE($productfiltertypeID, 'multiselect', 'select'); 
							  } else { 
							  	getproductFILTERTYPE($productfiltertypeID, '', 'select');
							  }
							  // getproductFILTERTYPE($productfiltertypeID, 'select'); ?>
                            </select>
                        </div>
                      </div>

                    <div class="divider-text">Variant - Color</div>
                                            
                      <div class="form-group row">
                        <label for="productcolor" class="col-sm-2 col-form-label">Product Color</label>
                        <div class="col-sm-7">
                         <select name="productcolor[]" id="productcolor" multiple="multiple" size="6" class="custom-select">
                              <?php 
							  if($parentproduct != '') { 
							  	getproductFILTERCOLOR($productfiltercolorID, 'multiselect', 'select'); 
							  } else { 
							  	getproductFILTERCOLOR($productfiltercolorID, '', 'select');
							  }
							  // getproductFILTERCOLOR($productfiltercolorID, 'select'); ?>
                            </select>
                        </div>
                      </div>

                    <div class="divider-text">Variant - Material</div>
                                            
                      <div class="form-group row">
                        <label for="productmaterial" class="col-sm-2 col-form-label">Product Material</label>
                        <div class="col-sm-7">
                         <select name="productmaterial[]" id="productmaterial" multiple="multiple" size="6" class="custom-select">
                              <?php 
							  if($parentproduct != '') { 
							  	getproductFILTERMATERIAL($productfiltermaterialID, 'multiselect', 'select'); 
							  } else { 
							  	getproductFILTERMATERIAL($productfiltermaterialID, '', 'select');
							  }
							  // getproductFILTERMATERIAL($productfiltermaterialID, 'multiple', 'select'); ?>
                            </select>
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