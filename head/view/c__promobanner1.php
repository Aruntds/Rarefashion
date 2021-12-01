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
if($save == 'save' || $save_close == "save_close"){			
		
$promobanner_status = $_REQUEST['promobanner_status']; //value='on' == 1 || value='' == 0
if($promobanner_status == 'on') { $promobannerstatus = '1'; } else { $promobannerstatus = '0'; }
	
	//upload PATH
	$media_path = "../uploads/promobanner1/";

	$valid_formats = array("jpg", "jpeg", "png", "gif", "bmp");
	$media_name = $_FILES['banner_image']['name'];
	$media_size = $_FILES['banner_image']['size'];

	if(strlen($media_name))
	{
		list($txt, $ext) = explode(".", $media_name);
		if(in_array($ext,$valid_formats))
		{
		if($media_size<(1000*1000))
			{
				$promobanner1_image = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
				$tmp = $_FILES['banner_image']['tmp_name'];

				if(move_uploaded_file($tmp, $media_path.$promobanner1_image)) {

					//Insert query
					$arrFields=array('`promobannerTYPE`','`promobanner_title`','`display_order`','`display_size`','`promobanner_image`','`banner_link`','`link_open_type`','`banner_offertype`','`banner_link_type`','`status`','`createdby`');
					$arrValues=array('1',"$promobanner_title","$displayorder","$display_size","$promobanner1_image","$banner_link","$link_open_type","$banner_offertype","$banner_link_type","$promobannerstatus","$logged_user_id");

					if(sqlACTIONS("INSERT","js_promobanner",$arrFields,$arrValues,'')) {
						
						echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";

						if( $save == "save"	) {
							?>
							<script type="text/javascript">window.location = 'promobanner1.php?route=add&code=1' </script>
							<?php
							//header("Location:category.php?route=add&code=1");
							} else {
							?>
							<script type="text/javascript">window.location = 'promobanner1.php?code=1' </script>
							<?php
							//header("Location:category.php?code=1");
						}
	
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

		//Insert Query
		$arrFields=array('`promobanner_title`','`display_order`','`display_size`','`banner_link`','`link_open_type`','`banner_offertype`','`banner_link_type`','`status`');
		$arrValues=array("$promobanner_title","$displayorder","$display_size","$banner_link","$link_open_type","$banner_offertype","$banner_link_type","$promobannerstatus");
		
		if(sqlACTIONS("INSERT","js_promobanner",$arrFields,$arrValues,'')) {
			
			echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";

			if( $save == "save"	) {
				?>
				<script type="text/javascript">window.location = 'promobanner1.php?route=add&code=1' </script>
				<?php
				//header("Location:category.php?route=add&code=1");
			} else {
				?>
				<script type="text/javascript">window.location = 'promobanner1.php?code=1' </script>
				<?php
				//header("Location:category.php?code=1");
			}

			exit();

		} else {

			$err[] =  "Unable to Insert Record"; 

		}

	}

}
?>

    <div class="content">
      <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="row">
          <div class="col-lg-9">
            <div class="mg-b-25">

				<form method="post" enctype="multipart/form-data" data-parsley-validate>
				  
				  <div id="stick-here"></div>
				  <div id="stickThis" class="form-group row mg-b-0">
					<div class="col-3 col-sm-6">
				  		<?php pageCANCEL($currentpage, $__cancel); ?>
				    </div>
				    <div class="col-9 col-sm-6 text-right">
				      <button type="submit" name="save" value="save" class="btn btn-success">Save</button>
				      <button type="submit" name="save_close" value="save_close" class="btn btn-success">Save & Close</button>
				    </div>
				  </div>

				<!-- BASIC Starting -->
				<div id="basic">
				  <div class="divider-text">Promo Banner #1</div>
				  <div class="form-group row">
				  	<label for="promobanner_status" class="col-sm-2 col-form-label"><?php echo $__active; ?></label>
					<div class="col-sm-7">
						<div class="custom-control custom-switch">
						  <input type="checkbox" class="custom-control-input" name="promobanner_status" id="promobanner_status" checked="">
						  <label class="custom-control-label" for="promobanner_status">Yes</label>
						</div>
					</div>
				  </div>
				  
				   <div class="form-group row">
				  	<label for="promobanner_title" class="col-sm-2 col-form-label"><?php echo $__promobannertitle ;?></label>
					<div class="col-sm-7">
						  <input type="text" class="form-control" placeholder="Banner Title" name="promobanner_title" id="promobanner_title" >
					</div>
				  </div>
				  
				   <div class="form-group row">
				  	<label for="displayorder" class="col-sm-2 col-form-label"><?php echo $__displayorder ;?><span class="tx-danger">*</span></label>
					<div class="col-sm-7">
						  <input type="text" class="form-control" placeholder="Display Order" name="displayorder" id="displayorder" required data-parsley-error-message="Please enter Display Order">
					</div>
				  </div>
				
				 <div class="form-group row">
				    <label for="display_size" class="col-sm-2 col-form-label"><?php echo $__displaysize ;?><span class="tx-danger">*</span></label>
				    <div class="col-sm-7">
						<select name="display_size" id="display_size" class="custom-select">						  
						  <?php echo getDISPLAYIMAGESIZE('', 'select'); ?>
						</select>				      
				    </div>
				  </div>
				
 				  <div class="form-group row">
				    <label for="imageupload" class="col-sm-2 col-form-label"><?php echo $__banner ;?><span class="tx-danger">*</span></label>
				    				    
				    <div class="col-sm-7">

						<div class="custom-file">
						  <input type="file" class="custom-file-input" name="banner_image" id="banner_image" required data-parsley-error-message="Please Select Banner1 Image">
						  <label class="custom-file-label" for="customFile">Choose file</label>
						  <input type="hidden" name="old_probannerimage" value="<?php echo $promobanner_image; ?>">
						</div>

						<div class="media-upload">
						    <div class="avatar-preview">
						        <div id="imagePreview" style="background-image: url(public/img/blank-placeholder.jpg);">
						        </div>
						    </div>
						</div>

					</div>

				  </div>

				   <div class="form-group row">
				  	<label for="banner_link_type" class="col-sm-2 col-form-label"><?php echo $__bannerlinktype ;?></label>
					<div class="col-sm-7">
						  <select name="banner_link_type" id="banner_link_type" class="custom-select">						  
						  <option <?php if($banner_link_type == '0'){ echo "selected"; } ?> value="0">Custom Link</option>
						  <option <?php if($banner_link_type == '1'){ echo "selected"; } ?> value="1">Offer Link</option>
 						  </select>
					</div>
				  </div>
					<div class="form-group row" id="offer_div" style="display:none">
							<label for="categoryparentID" class="col-sm-2 col-form-label"><?php echo $__offertype; ?> <span class="tx-danger">*</span></label>
							<div class="col-sm-7">
								<select name="banner_offertype" id="banner_offertype" class="custom-select" required>
								<?php echo getOFFERS($banner_offertype,'select');?>
								</select>
							</div>
					</div>
					<div class="form-group row">
						<label for="banner_link_type" class="col-sm-2 col-form-label"><?php echo $__bannerlinktype ;?></label>
					<div class="col-sm-7">
						  <select name="link_open_type" id="link_open_type" class="custom-select">						  
						  <option <?php if($link_open_type == '0'){ echo "selected"; } ?> value="0">Same Tab</option>
						  <option <?php if($link_open_type == '1'){ echo "selected"; } ?> value="1">New Tab</option>
 						  </select>
					</div>
					</div>
					  <div class="form-group row">
						<label for="banner_link" class="col-sm-2 col-form-label"><?php echo $__bannerlink ;?></label>
						<div class="col-sm-7">
							  <input type="text" class="form-control" placeholder="Banner Link" name="banner_link" id="banner_link" >
						</div>
					  </div>
				 

				</div>
				<!-- End of BASIC -->

				</form>

            </div><!-- row -->
          </div><!-- col -->
          
          <?php 
		  
	         $promobanner1_sidebar_view_type='create';
	          include viewpath('__promobanner1sidebar.php'); 
          ?>

        </div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->   