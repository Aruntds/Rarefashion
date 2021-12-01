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
if( $save == "update" && $hidden_homesliderID != '') {

	$homeslidertitle1 = $validation_globalclass->sanitize(ucwords($_REQUEST['homeslidertitle1']));
	$homeslidertitle2 = $validation_globalclass->sanitize($_REQUEST['homeslidertitle2']);

	$homeslidertext = htmlentities($_REQUEST['homeslidertext']);
	trim ($homeslidertext);

	$homesliderlink = $validation_globalclass->sanitize($_REQUEST['homesliderlink']);
	$homesliderlinktext = $validation_globalclass->sanitize($_REQUEST['homesliderlinktext']);

	$homesliderstatus = $_REQUEST['homesliderstatus']; //value='on' == 1 || value='' == 0
	if($homesliderstatus == 'on') { $homeslider_status = '1'; } else { $homeslider_status = '0'; }
	
	//upload PATH
	$media_path = "uploads/homeslider/";
	
	$valid_formats = array("jpg", "jpeg", "png", "gif", "bmp");
	$media_name = $_FILES['homesliderimage']['name'];
	$media_size = $_FILES['homesliderimage']['size'];

	if(strlen($media_name))
	{
		list($txt, $ext) = explode(".", $media_name);
		if(in_array($ext,$valid_formats))
		{
		if($media_size<(1000*1000))
			{
				$homeslider_image = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
				$tmp = $_FILES['homesliderimage']['tmp_name'];

				if(move_uploaded_file($tmp, $media_path.$homeslider_image)) {
					
					//checking if logo changed
					if($old_homesliderimage != '') {					
						//remove_oldimage before updating
						$oldimage_path = $media_path.$old_homesliderimage;
						unlink($oldimage_path);
					}

					//Insert query
					$arrFields=array('`homeslidertitle1`', '`homeslidertitle2`', '`homeslidertext`', '`homesliderlink`', '`homesliderlinktext`', '`homesliderimage`', '`display_order`', '`createdby`','`status`');
	
					$arrValues=array("$homeslidertitle1","$homeslidertitle2","$homeslidertext","$homesliderlink","$homesliderlinktext","$homeslider_image", "$display_order", "$logged_user_id","$homeslider_status");

					$sqlWhere= "homesliderID=$hidden_homesliderID";

					if(sqlACTIONS("UPDATE","js_homeslider",$arrFields,$arrValues, $sqlWhere)) {
						
						echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";

						?>
						<script type="text/javascript">window.location = 'homeslider.php?code=1' </script>
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
		$arrFields=array('`homeslidertitle1`', '`homeslidertitle2`', '`homeslidertext`', '`homesliderlink`', '`homesliderlinktext`', '`display_order`', '`createdby`','`status`');

		$arrValues=array("$homeslidertitle1","$homeslidertitle2","$homeslidertext","$homesliderlink","$homesliderlinktext", "$display_order", "$logged_user_id","$homeslider_status");

		$sqlWhere= "homesliderID=$hidden_homesliderID";

		if(sqlACTIONS("UPDATE","js_homeslider",$arrFields,$arrValues, $sqlWhere)) {
			
			echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
				?>
				<script type="text/javascript">window.location = 'homeslider.php?code=1' </script>
				<?php
				
			exit();

		} else {

			$err[] =  "Unable to Insert Record"; 

		}

	}

}

if($route == 'edit' && $id != '') {

	$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_homeslider` where deleted = '0' and `homesliderID`='$id'") or die("#1-Unable to get records:".mysql_error());
	$check_record_availabity = sqlNUMOFROW_LABEL($list_datas);			

	while($row = sqlFETCHARRAY_LABEL($list_datas)){
		
	  $homesliderID = $row["homesliderID"];
	  $homeslidertitle1 = $row["homeslidertitle1"];
	  $homeslidertitle2 = $row["homeslidertitle2"];
	  $homeslidertext = html_entity_decode($row["homeslidertext"]);
	  $display_order = $row["display_order"];
	  $homesliderlink = $row["homesliderlink"];
	  $homesliderlinktext = $row["homesliderlinktext"];
	  $homesliderimage = $row["homesliderimage"];
	  $status = $row["status"];
		
		if(!empty($homesliderimage)) {
			//upload PATH
			$media_path = "uploads/homeslider/$homesliderimage";
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
				      <button type="submit" name="save" value="update" class="btn btn-warning"><?php echo $__update ?></button>
                      <input type="hidden" name="hidden_homesliderID" value="<?php echo $homesliderID; ?>" />
				    </div>
				  </div>

				<!-- BASIC Starting -->
				<div id="basic">
				  <div class="divider-text"><?php echo $__hbasicinfo ?></div>
				  <div class="form-group row">
				  	<label for="homesliderstatus" class="col-sm-2 col-form-label"><?php echo $__active ?></label>
					<div class="col-sm-7">
						<div class="custom-control custom-switch">
						  <input type="checkbox" class="custom-control-input" name="homesliderstatus" id="homesliderstatus"  <?php if($status == '1') { echo 'checked=""'; } ?>>
						  <label class="custom-control-label" for="homesliderstatus">Yes</label>
						</div>
					</div>
				  </div>

				  <div class="form-group row">
				    <label for="imageupload" class="col-sm-2 col-form-label"><?php echo $__homesliderbanimage ?></label>
				    				    
				    <div class="col-sm-7">

						<div class="custom-file">
						  <input type="file" class="custom-file-input" name="homesliderimage" id="homesliderimage">
						  <label class="custom-file-label" for="customFile"><?php echo $__categorieschoosefile ?></label>
                          <input type="hidden" name="old_homesliderimage" value="<?php echo $homesliderimage; ?>">
						</div>

						<div class="media-upload">
						    <div class="homeslider-preview">
						        <div id="imagePreview" style="background-image: url(<?php echo $media_path; ?>);">
						        </div>
						    </div>
						</div>

					</div>

				  </div>

				  <div class="form-group row">
				  	<label for="homeslidertitle1" class="col-sm-2 col-form-label"><?php echo $__title ?> #1</label>
					<div class="col-sm-7">
						  <input type="text" class="form-control" placeholder="First Title" name="homeslidertitle1" id="homeslidertitle1" value="<?php echo $homeslidertitle1; ?>" >
					</div>
				  </div>

				  <div class="form-group row">
				  	<label for="homeslidertitle2" class="col-sm-2 col-form-label"><?php echo $__title ?> #2</label>
					<div class="col-sm-7">
						  <input type="text" class="form-control" placeholder="Second Bold Title" name="homeslidertitle2" id="homeslidertitle2" value="<?php echo $homeslidertitle2; ?>" >
					</div>
				  </div>
				  
				   <div class="form-group row">
				  	<label for="display_order" class="col-sm-2 col-form-label"><?php echo $__displayorder ;?><span class="tx-danger">*</span></label>
					<div class="col-sm-7">
						  <input type="text" class="form-control" placeholder="Display Order" name="display_order" id="display_order" required data-parsley-error-message="Please enter Display Order" value="<?php echo $display_order; ?>">
					</div>
				  </div>
                  
				  <div class="form-group row">
				  	<label for="homeslidertext" class="col-sm-2 col-form-label"><?php echo $__title ?> <?php echo $__description ?></label>
					<div class="col-sm-7">
						  <textarea class="form-control" rows="2"  name="homeslidertext" id="homeslidertext"><?php echo $homeslidertext; ?></textarea>
					</div>
				  </div>

				  <div class="form-group row">
				  	<label for="homesliderlink" class="col-sm-2 col-form-label"><?php echo $__homesliderslidlink ?></label>
					<div class="col-sm-7">
						  <input type="text" class="form-control" placeholder="Slider Link" name="homesliderlink" id="homesliderlink" value="<?php echo $homesliderlink; ?>" >
					</div>
				  </div>

				  <div class="form-group row">
				  	<label for="homesliderlinktext" class="col-sm-2 col-form-label"><?php echo $__homesliderlinktext ?></label>
					<div class="col-sm-7">
						  <input type="text" class="form-control" placeholder="Link Text" name="homesliderlinktext" id="homesliderlinktext" value="<?php echo $homesliderlinktext; ?>" >
					</div>
				  </div>
				  
				</div>
				<!-- End of BASIC -->

				</form>

            </div><!-- row -->
          </div><!-- col -->
          
          <?php 
	          $homeslider_sidebar_view_type='create';
	          include viewpath('__homeslidersidebar.php'); 
          ?>

        </div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->   