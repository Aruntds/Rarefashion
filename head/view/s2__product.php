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

//check if product image is added or not
$check_productimageAVAILABLE = commonNOOFROWS_COUNT('js_productmediagallery', "`productID`='$parentproduct' and `productmediagallerytype`='1' and `createdby`='$logged_user_id'");

//check if product video is added or not
$check_productvideoAVAILABLE = commonNOOFROWS_COUNT('js_productmediagallery', "`productID`='$parentproduct' and `productmediagallerytype`='2' and `createdby`='$logged_user_id'");

//upload product images or video
if($save == "next") {
	
	if($check_productimageAVAILABLE== 0) {
		$err[] = 'Cannot Proceed without product image';	
	}
	
	if(empty($err)) {
		echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";	
		?>
		<script type="text/javascript">window.location = 'product.php?route=step3&parentproduct=<?php echo $parentproduct; ?>' </script>
		<?php
		
		exit();	
	}
	
}

//1. Product Image
if($save == "save_image") {

	$hidden_parentproduct = $_REQUEST['hidden_parentproduct'];
	$productmediagallery_order = $validation_globalclass->sanitize($_REQUEST['productmediagalleryorder']);
	
	//get from number of rows calcualted from line 15
	$productmedia_name_counter = $check_productimageAVAILABLE+1; //counter to update image
		
	//convert_product_image_name
	//getSINGLEDBVALUE($requested_fieldvalue, $request_wherecondition, $requested_table,$requesttype)
	$orginal_producttitle = getSINGLEDBVALUE('producttitle', "productID='$parentproduct' and status='1' and deleted=0", 'js_product', 'label');
	$converted_producttitle = convertSEOURL($orginal_producttitle); //_for_productimage
	//$converted_producttitle = limit_words($converted_producttitle,5); //_for_productimage

	//upload PATH
	$media_path = "../uploads/productmediagallery/";

	$valid_formats = array("jpg", "jpeg", "png", "gif", "bmp");
	$media_name = $_FILES['productmediagalleryurl']['name'];
	$media_size = $_FILES['productmediagalleryurl']['size'];

	if(strlen($media_name))
	{
		list($txt, $ext) = explode(".", $media_name);
		if(in_array($ext,$valid_formats))
		{
		if($media_size<(1000*1000))
			{
				$productmediagallery_image = $converted_producttitle.'-'.$productmedia_name_counter.".".$ext;  //time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
				$tmp = $_FILES['productmediagalleryurl']['tmp_name'];
				if(move_uploaded_file($tmp, $media_path.$productmediagallery_image)) {

					//Insert query
					//`productmediagalleryID`, `productID`, `productmediagallerytype`, `productmediagallerytitle`, `productmediagalleryurl`, `productmediagalleryorder`, `createdby`, `createdon`, `updatedon`, `status`, `deleted` FROM `js_productmediagallery`	

					$arrFields=array('`productID`','`productmediagallerytype`','`productmediagalleryurl`','`productmediagalleryorder`','`createdby`','`status`');

					$arrValues=array("$hidden_parentproduct","1","$productmediagallery_image","$productmediagallery_order","$logged_user_id","1");

					if(sqlACTIONS("INSERT","js_productmediagallery",$arrFields,$arrValues,'')) {
						
						echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";

						?>
						<script type="text/javascript">window.location = 'product.php?route=step2&parentproduct=<?php echo $hidden_parentproduct; ?>&code=22' </script>
						<?php

						exit();

					} else {

						$err[] =  "Unable to Insert Record"; 

					}

				} else { 
					$err[] =  "failed"; 
				}
			} else { 
				$err[] = "Image file size max 1 MB";	 
			}
		} else { 
			$err[] =  "Invalid file format..";	 
		}
	} else { 
		$err[] =  "No Image Selected to upload";	 
	}
	
}

//2. Product Video
if($save == "save_video") {

	$hidden_parentproduct = $_REQUEST['hidden_parentproduct'];
	$productmediagallery_title = $validation_globalclass->sanitize($_REQUEST['productmediagallerytitle']);
	$productmediagallery_url = $validation_globalclass->sanitize($_REQUEST['productmediagalleryurl']);  //youtube video - id

	$update_productgallery_ID = $_REQUEST['productgallery_ID'];

	$arrFields=array('`productID`','`productmediagallerytype`','`productmediagallerytitle`','`productmediagalleryurl`','`createdby`','`status`');
	$arrValues=array("$hidden_parentproduct","2","$productmediagallery_title","$productmediagallery_url","$logged_user_id","1");
	
	if($update_productgallery_ID == '') {
	
		if(sqlACTIONS("INSERT","js_productmediagallery",$arrFields,$arrValues,'')) {
			
			echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
	
			?>
			<script type="text/javascript">window.location = 'product.php?route=step2&parentproduct=<?php echo $hidden_parentproduct; ?>&code=4#product-video' </script>
			<?php
	
			exit();
		}
	} else {

		$sqlWhere= "productmediagalleryID=$update_productgallery_ID";	
	
		if(sqlACTIONS("UPDATE","js_productmediagallery",$arrFields,$arrValues,$sqlWhere)) {
			
			echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
	
			?>
			<script type="text/javascript">window.location = 'product.php?route=step2&parentproduct=<?php echo $hidden_parentproduct; ?>&code=4#product-video' </script>
			<?php
	
			exit();
		}
		
	}
	
}

//delete media gallery
if ($action == "deleteimage" && $id != '') {

	//checking if logo changed
	$old_productimage_name = getSINGLEDBVALUE('productmediagalleryurl', "`productmediagalleryID` = $id and `productID` = '$parentproduct'", 'js_productmediagallery', 'label');
	//upload PATH
	//remove_oldimage before updating
	if($old_productimage_name !='') {
		$media_path = "uploads/productmediagallery/";
		$oldimage_path = $media_path.$old_productimage_name;
		unlink($oldimage_path);
	}

	$sqlWhere= "`productmediagalleryID` = $id and `productID` = '$parentproduct'";  //parentproduct received from url

	if(sqlACTIONS("DELETE","js_productmediagallery",'','', $sqlWhere)) {
		echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
		?>
		<script type='text/javascript'>window.location = 'product.php?route=step2&parentproduct=<?php echo $parentproduct; ?>&code=2'; </script>
        <?php
	}
}

//
if ($action == "setfeatured" && $id != '') {
	
	//Update selected record query
	$arrFields=array('`productmediagalleryfeatured`');
	$arrValues=array("1");

	$sqlWhere= "`productmediagalleryID` = $id and `productID` = '$parentproduct'";
	
	//reset all featured to null
	$arrFields_common=array('`productmediagalleryfeatured`');
	$arrValues_common=array("0");

	$sqlWhere_common = "`productID` = '$parentproduct' and `productmediagalleryfeatured` = '1'";

	if(sqlACTIONS("UPDATE","js_productmediagallery",$arrFields_common,$arrValues_common, $sqlWhere_common)) {
		
		sqlACTIONS("UPDATE","js_productmediagallery",$arrFields,$arrValues, $sqlWhere);
		
		echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
		echo "<script type='text/javascript'>window.location = 'product.php?route=step2&parentproduct=$parentproduct&code=3#product-image'; </script>";
	}
	
}

/**************  GETTING INDIVIDUAL VALUES  *****************/
//get order value
$orginal_productmediagalleryorder = getSINGLEDBVALUE('productmediagalleryorder', "productID='$parentproduct' and status='1' and deleted=0 order by productmediagalleryorder DESC", 'js_productmediagallery', 'label');

//get video-title
$productmediagallery_ID = getSINGLEDBVALUE('productmediagalleryID', "productID='$parentproduct' and productmediagallerytype=2 and status='1' and deleted=0", 'js_productmediagallery', 'label');

//get video-title
$productmedia_title = getSINGLEDBVALUE('productmediagallerytitle', "productID='$parentproduct' and productmediagallerytype=2 and status='1' and deleted=0", 'js_productmediagallery', 'label');

//get video-id
$productmediavideo_id = getSINGLEDBVALUE('productmediagalleryurl', "productID='$parentproduct' and productmediagallerytype=2 and status='1' and deleted=0", 'js_productmediagallery', 'label');


?>

    <div class="content">
      <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="row">
          <?php 
	          $product_sidebar_view_type='s2';
	          include viewpath('__productsidebar.php');
          ?>
          <div class="col-lg-9 pd-t-40 bd">
            <div class="mg-b-25">

				<form method="post" enctype="multipart/form-data" data-parsley-validate>
				  
				  <div id="stick-here"></div>
				  <div id="stickThis" class="form-group row mg-b-0">
					<div class="col-3 col-sm-6">
				  		<a href="<?php echo $currentpage; ?>?route=step1&parentproduct=<?php echo $parentproduct; ?>" class="btn btn-secondary" type="cancel"><?php echo $__back; ?></a>
				    </div>
				    <div class="col-9 col-sm-6 text-right">
                      <input type="hidden" name="hidden_parentproduct" id="hidden_parentproduct" value="<?php echo $parentproduct; ?>" />
				      <button type="submit" name="save" value="next" class="btn btn-success">Next</button>
				    </div>
				  </div>

				<!-- BASIC Starting -->
				<div id="basic">
				  <div class="divider-text">Product Image(s)</div>

				  <div class="form-group row">
				    <label for="productmediagalleryorder" class="col-sm-2 col-form-label">Display Order</label>
				    <div class="col-sm-7">
				      <input type="text" class="form-control" name="productmediagalleryorder" value="<?php echo ($orginal_productmediagalleryorder+1); ?>" id="productmediagalleryorder" placeholder="Product Image Order">
				    </div>
				  </div>
                  
				  <div class="form-group row">
				    <label for="productmediagalleryurl" class="col-sm-2 col-form-label">Product Image</label>
				    				    
				    <div class="col-sm-7">

						<div class="custom-file">
						  <input type="file" class="custom-file-input" name="productmediagalleryurl" id="productmediagalleryurl">
						  <label class="custom-file-label" for="customFile">Choose Banner Image</label>
						</div>

						<div class="media-upload">
						    <div class="homeslider-preview">
						        <div id="imagePreview" style="background-image: url(public/img/blank-placeholder.jpg);">
						        </div>
						    </div>
						</div>
                        <button type="submit" name="save" value="save_image" class="btn mg-t-5 btn-success">Save Image</button>
                        <div class="tx-gray-600">
                        <p class="pd-l-0 pd-t-10 pd-b-0 mg-b-5"><b>Notes:</b></p>
                            <ul class="tx-7 pd-l-15 pd-t-0 pd-b-20">
                            	<li>Press "Save Image" button to upload.</li>
                                <li>Minimum 3 Images requested for better presentation.</li>
                            	<li>Allowed image formats are .jpg, .jpeg, .png</li>
                                <li>File size must be less than 1 MB.</li>
                                <li>You can set the "Default image" after saving by click this <i class="icon ion-md-heart"></i> icon .</li>
                            </ul>
                        </div>
					</div>
                    
				  </div>
                  
                  <?php if($check_productimageAVAILABLE == 0) { ?>
                  <div class="tx-gray-400 text-center tx-24">** Start uploading product images **</div>
                  <?php } else { ?>
                  <div class="row pd-0" id="product-image">
                  	<?php
					//`productmediagalleryID`, `productID`, `productmediagallerytype`, `productmediagallerytitle`, `productmediagalleryurl`, `productmediagalleryorder`, `productmediagalleryfeatured`, `createdby`, `createdon`, `updatedon`, `status`, `deleted` FROM `js_productmediagallery`	

					  $productmedia_datas = sqlQUERY_LABEL("SELECT * FROM `js_productmediagallery` where productID='$parentproduct' and productmediagallerytype='1' and createdby='$logged_user_id' and deleted = '0' order by productmediagalleryorder ASC") or die("#1-Unable to get records:".mysql_error());
					
					 $count_productmedia_availablecount = sqlNUMOFROW_LABEL($productmedia_datas);
					
					if($count_productmedia_availablecount > 0) {
					  while($row = sqlFETCHARRAY_LABEL($productmedia_datas)){
						  $productmediagalleryID = $row["productmediagalleryID"];
						  $productmediagalleryurl = $row["productmediagalleryurl"];
						  $productmediagalleryfeatured = $row["productmediagalleryfeatured"];
					  	  //image path
						  $media_path = "../uploads/productmediagallery/$productmediagalleryurl";
						  
						  //update featured icon
						  if($productmediagalleryfeatured == '1') {
							$featured_icon_select = '<i class="icon ion-md-heart text-warning"></i>';  
						  } else {
							$featured_icon_select = '<i class="icon ion-md-heart"></i>';  
						  }
						  
					?>
                        <div class="col-lg-3 col-sm-6 pd-5">
                            <figure class="pos-relative mg-b-0 pd-2 wd-lg-100p">
                              <img src="<?php echo $media_path; ?>" class="img-fit-cover img-thumbnail" alt="<?php echo $orginal_producttitle; ?>">
                              <figcaption class="pos-absolute b-0 l-0 wd-100p pd-20 d-flex justify-content-center">
                                <div class="btn-group">
                                  <a href="product.php?action=setfeatured&route=step2&parentproduct=<?php echo $parentproduct; ?>&id=<?php echo $productmediagalleryID; ?>" class="btn btn-dark btn-icon" title="Set as Default"><?php echo $featured_icon_select; ?></a>
                                  <a href="<?php echo $media_path; ?>" target="_blank" class="btn btn-dark btn-icon" title="Download"><i data-feather="download"></i></a>
                                  <a href="javascript:;"  onClick="deleteRECORD('product.php?action=deleteimage&route=step2&parentproduct=<?php echo $parentproduct; ?>&id=<?php echo $productmediagalleryID; ?>')" class="btn btn-dark btn-icon" title="Delete"><i data-feather="trash-2"></i></a>
                                </div>
                              </figcaption>
                            </figure>   
                        </div>
                    <?php } } ?>
                  </div>
                  <?php } ?>
                  
				</div>
				<!-- End of BASIC -->

				<!-- Video Starting -->
				<div id="product-video">
				  <div class="divider-text">Product Video</div>
                  
					  <?php 
                      if($attribute == 'video') {
                      ?>
                      
                      <div class="form-group row">
                        <label for="productmediagallerytitle" class="col-sm-2 col-form-label">Title</label>
                        <div class="col-sm-7">
                              <input type="text" class="form-control" placeholder="Product Video Title" name="productmediagallerytitle" id="productmediagallerytitle" value="<?php echo $productmedia_title; ?>" >
                        </div>
                      </div>
                      
                      <div class="form-group row">
                        <label for="productmediagalleryurl" class="col-sm-2 col-form-label">Url</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" placeholder="Upload Youtube 'VIDEO-ID'" name="productmediagalleryurl" id="productmediagalleryurl" value="<?php echo $productmediavideo_id; ?>" >

                            <div class="tx-gray-600">
                            <p class="pd-l-0 pd-t-10 pd-b-0 mg-b-5"><b>Notes:</b></p>
                                <ul class="tx-7 pd-l-15 pd-t-0 pd-b-0 mg-b-0">
                                    <li>Youtube URL: youtube.com/watch?v=<b>{VIDEO-ID}</b></li>
                                </ul>
                            </div>

                        </div>
                      </div>
                      
                      <a href="product.php?route=step2&parentproduct=<?php echo $parentproduct; ?>#product-video" class="btn btn-sm btn-dark mg-t-5 mg-r-10">Cancel</a>
                      <?php if($productmediagallery_ID != '--') { ?>
                      <input type="hidden" value="<?php echo $productmediagallery_ID; ?>" name="productgallery_ID" id="productgallery_ID" />
                      <?php } ?>
                      <button type="submit" name="save" value="save_video" class="btn mg-t-5 btn-success">Save Video</button>
                      <?php } else {
						  
						  //check if video updated
						  if($check_productvideoAVAILABLE == 0) { 
						  ?>
						  <div class="text-center">
						  <a href="product.php?route=step2&parentproduct=<?php echo $parentproduct; ?>&attribute=video#product-video" class="btn btn-sm btn-dark mg-t-40 mg-b-60">
                          Add Video
                          </a>
						  </div>
						  <?php
						  } else {
						  ?>
                          
                          <div class="text-center mg-t-40">
                          <a href="https://www.youtube.com/watch?v=<?php echo $productmediavideo_id; ?>" target="_blank">
                          <img src="https://img.youtube.com/vi/<?php echo $productmediavideo_id; ?>/mqdefault.jpg" class="img-thumbnail mg-t-5 mg-b-10" />
                          </a>
                          </div>
						  <div class="text-center">
						  <a href="product.php?route=step2&parentproduct=<?php echo $parentproduct; ?>&attribute=video#product-video" class="btn btn-sm btn-warning mg-b-60">
                          Update Video
                          </a>
						  </div>
						  <?php
						  }
					  
					   } ?>

                </div>
				<!-- Video Starting -->

				</form>

            </div><!-- row -->
          </div><!-- col -->

        </div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->   