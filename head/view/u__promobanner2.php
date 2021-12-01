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

//Update
if( $save == "update" && $hidden_promobannerID != '') {

	$promobanner_status = $_REQUEST['promobanner_status']; //value='on' == 1 || value='' == 0
	if($promobanner_status == 'on') { $promobannerstatus = '1'; } else { $promobannerstatus = '0'; }
	
	//upload PATH
	$media_path = "../uploads/promobanner2/";
	
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
					
					//checking if logo changed
					if($old_probannerimage != '') {					
						//remove_oldimage before updating
						$oldimage_path = $media_path.$old_probannerimage;
						unlink($oldimage_path);
					}

					//Insert query
					//Insert query
					$arrFields=array('`promobanner_title`','`display_order`','`display_size`','`promobanner_image`','`banner_link`','`status`');
					$arrValues=array("$promobanner_title","$displayorder","$display_size","$promobanner1_image","$banner_link","$promobannerstatus");


					$sqlWhere= "promobannerID=$hidden_promobannerID";

					if(sqlACTIONS("UPDATE","js_promobanner",$arrFields,$arrValues, $sqlWhere)) {
						
						echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";

						?>
						<script type="text/javascript">window.location = 'promobanner2.php?code=1' </script>
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

		//Insert query
		$arrFields=array('`promobanner_title`','`display_order`','`display_size`','`banner_link`','`status`');
		$arrValues=array("$promobanner_title","$displayorder","$display_size","$banner_link","$promobannerstatus");

		$sqlWhere= "promobannerID=$hidden_promobannerID";

		if(sqlACTIONS("UPDATE","js_promobanner",$arrFields,$arrValues, $sqlWhere)) {
			
			echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
				?>
				<script type="text/javascript">window.location = 'promobanner2.php?code=1' </script>
				<?php
				//header("Location:category.php?code=1");
				
			exit();

		} else {

			$err[] =  "Unable to Insert Record"; 

		}

	}

}


//Sellect
if($route == 'edit' && $id != '') {

	$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_promobanner` where deleted = '0' and `promobannerID`='$id'") or die("#1-Unable to get records:".mysql_error());
	$check_record_availabity = sqlNUMOFROW_LABEL($list_datas);			

	while($row = sqlFETCHARRAY_LABEL($list_datas)){
		
	  $promobannerID = $row["promobannerID"];
	  $promobannerTYPE = $row["promobannerTYPE"];
	  $promobanner_title = $row["promobanner_title"];
	  $promobanner_image = $row["promobanner_image"];
	 //echo $promobanner_image;exit();
	  $display_order = $row["display_order"];
	  $display_size = $row["display_size"];
	  $banner_link = $row["banner_link"];
	  $status = $row["status"];
	 

		
		if(!empty($promobanner_image)) {
			//upload PATH
			$media_path = "../uploads/promobanner2/".$promobanner_image;
		} else {
			//upload PATH
			$media_path = "public/img/blank-placeholder.jpg";
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
				      <button type="submit" name="save" value="update" class="btn btn-warning">Update</button>
                      <input type="hidden" name="hidden_promobannerID" value="<?php echo $promobannerID; ?>" />
				    </div>
				  </div>

				<!-- BASIC Starting -->
				<div id="basic">
				  <div class="divider-text">Promo Banner #2</div>
				  <div class="form-group row">
				  	<label for="promobanner_status" class="col-sm-2 col-form-label"><?php echo $__active; ?></label>
					<div class="col-sm-7">
						<div class="custom-control custom-switch">
						  <input type="checkbox" class="custom-control-input" name="promobanner_status" id="promobanner_status"  <?php if($status == '1') { echo 'checked=""'; } ?>>
						  <label class="custom-control-label" for="promobanner_status">Yes</label>
						</div>
					</div>
				  </div>
				  
				   <div class="form-group row">
				  	<label for="promobanner_title" class="col-sm-2 col-form-label"><?php echo $__promobannertitle ;?></label>
					<div class="col-sm-7">
						  <input type="text" class="form-control" placeholder="Banner Title" name="promobanner_title" id="promobanner_title"  value="<?php echo $promobanner_title; ?>">
					</div>
				  </div>
				  
				   <div class="form-group row">
				  	<label for="displayorder" class="col-sm-2 col-form-label"><?php echo $__displayorder ;?><span class="tx-danger">*</span></label>
					<div class="col-sm-7">
						  <input type="text" class="form-control" placeholder="Display Order" name="displayorder" id="displayorder" value="<?php echo $display_order; ?>">
					</div>
				  </div>
				
				 <div class="form-group row">
				    <label for="display_size" class="col-sm-2 col-form-label"><?php echo $__displaysize ;?><span class="tx-danger">*</span></label>
				    <div class="col-sm-7">
						<select name="display_size" id="display_size" class="custom-select">						  
						  <?php echo getDISPLAYIMAGESIZE($display_size,'select'); ?>
						</select>				      
				    </div>
				  </div>
				
				  <div class="form-group row">
				    <label for="imageupload" class="col-sm-2 col-form-label"><?php echo $__banner ;?><span class="tx-danger">*</span></label>
				    				    
				    <div class="col-sm-7">

						<div class="custom-file">
						  <input type="file" class="custom-file-input" name="banner_image" id="banner_image" required data-parsley-error-message="Please Select Banner2 Image">
						  <label class="custom-file-label" for="customFile">Choose file</label>
						   <input type="hidden" name="old_probannerimage" value="<?php echo $promobanner_image; ?>">
						</div>

						<div class="media-upload">
						    <div class="avatar-preview">
						        <div id="imagePreview" style="background-image: url(<?php echo $media_path; ?>);">
						        </div>
						    </div>
						</div>

					</div>

				  </div>

				  <div class="form-group row">
				  	<label for="banner_link" class="col-sm-2 col-form-label"><?php echo $__bannerlink ;?></label>
					<div class="col-sm-7">
						  <input type="text" class="form-control" placeholder="Banner Link" name="banner_link" id="banner_link" value="<?php echo $banner_link ; ?>">
					</div>
				  </div>

				</div>
				<!-- End of BASIC -->
				  

				</form>

            </div><!-- row -->
          </div><!-- col -->
          
          <?php 
	          $promobanner2_sidebar_view_type='create';
	          include viewpath('__promobanner2sidebar.php'); 
          ?>

        </div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->   