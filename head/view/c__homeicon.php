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
if($save == "save" || $save_close == "save_close") {

	$homeiconID = $validation_globalclass->sanitize($_REQUEST['homeiconID']);

	$homeicondisplayorder = $validation_globalclass->sanitize(ucwords($_REQUEST['homeicondisplayorder']));
	$homeicontitle = $validation_globalclass->sanitize($_REQUEST['homeicontitle']);

	$homeicondesign = $validation_globalclass->sanitize(strtolower($_REQUEST['homeicondesign']));
	$homeiconimage = $validation_globalclass->sanitize($_REQUEST['homeiconimage']);
	


	$status = $_REQUEST['status']; //value='on' == 1 || value='' == 0
	if($status == 'on') { $homeiconstatus = '1'; } else { $homeiconstatus = '0'; }
	
	//upload PATH
	$media_path = "../uploads/homeicon/";

	$valid_formats = array("jpg", "jpeg", "png", "gif", "bmp");
	$media_name = $_FILES['homeiconimage']['name'];
	$media_size = $_FILES['homeiconimage']['size'];

	if(strlen($media_name))
	{
		list($txt, $ext) = explode(".", $media_name);
		if(in_array($ext,$valid_formats))
		{
		if($media_size<(1000*1000))
			{
				$homeicon_image = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
				$tmp = $_FILES['homeiconimage']['tmp_name'];

				if(move_uploaded_file($tmp, $media_path.$homeicon_image)) {

					//Insert query
					$arrFields=array('`homeiconID`','`homeicondisplayorder`','`homeicontitle`','`homeicondesign`','`homeiconimage`','`status`');

					$arrValues=array("$homeiconID","$homeicondisplayorder","$homeicontitle","$homeicondesign","$homeicon_image","$homeiconstatus");

					if(sqlACTIONS("INSERT","js_homeicon",$arrFields,$arrValues,'')) {
						
						echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";

						if( $save == "save"	) {
							?>
							<script type="text/javascript">window.location = 'homeicon.php?route=add&code=1' </script>
							<?php
							//header("Location:category.php?route=add&code=1");
						} else {
							?>
							<script type="text/javascript">window.location = 'homeicon.php?code=1' </script>
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
		$arrFields=array('`homeiconID`','`homeicondisplayorder`','`homeicontitle`','`homeicondesign`','`status`');

		$arrValues=array("$homeiconID","$homeicondisplayorder","$homeicontitle","$homeicondesign","$homeiconstatus");

		if(sqlACTIONS("INSERT","js_homeicon",$arrFields,$arrValues,'')) {
			
			echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";

			if( $save == "save"	) {
				?>
				<script type="text/javascript">window.location = 'homeicon.php?route=add&code=1' </script>
				<?php
				//header("Location:category.php?route=add&code=1");
			} else {
				?>
				<script type="text/javascript">window.location = 'homeicon.php?code=1' </script>
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
				      <button type="submit" name="save" value="save" class="btn btn-success"><?php echo $__save ?></button>
				      <button type="submit" name="save_close" value="save_close" class="btn btn-success"><?php echo $__save_close ?></button>
				    </div>
				  </div>

				<!-- BASIC Starting -->
				<div id="basic">
				  <div class="divider-text"><?php echo $__hbasicinfo ?></div>
				  <div class="form-group row">
				  	<label for="status" class="col-sm-2 col-form-label"><?php echo $__active ?></label>
					<div class="col-sm-7">
						<div class="custom-control custom-switch">
						  <input type="checkbox" class="custom-control-input" name="status" id="status" checked="">
						  <label class="custom-control-label" for="status">Yes</label>
						</div>
					</div>
				  </div>

				  <div class="form-group row">
				    <label for="homeicondisplayorder" class="col-sm-2 col-form-label"><?php echo $__homeicondisporders ?><span class="tx-danger">*</span></label>
				    <div class="col-sm-7">
						<input type="text" class="form-control" name="homeicondisplayorder" id="homeicondisplayorder" placeholder="Display Order" required data-parsley-error-message="Please enter Display Order">				      
				    </div>
				  </div>

                  <div class="form-group row">
                    <label for="homeicontitle" class="col-sm-2 col-form-label"><?php echo $__homeiconicontitle ?><span class="tx-danger">*</span></label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" name="homeicontitle" id="homeicontitle" placeholder="Title" required data-parsley-error-message="Please enter Title name">
                    </div>
                  </div>
                  
                   <div class="form-group row">
				    <label for="homeicondesign" class="col-sm-2 col-form-label"><?php echo $__homeiconicondescription ?></label>
				    <div class="col-sm-7">
				    	<textarea class="form-control" rows="2"  name="homeicondesign" id="homeicondesign"></textarea>
				    </div>
				  </div>
			

				  <div class="form-group row">
				    <label for="imageupload" class="col-sm-2 col-form-label"><?php echo $__homeiconiconimage ?><span class="tx-danger">*</span></label>
				    				    
				    <div class="col-sm-7">

						<div class="custom-file">
						  <input type="file" class="custom-file-input" name="homeiconimage" id="homeiconimage" required data-parsley-error-message="Please Select Icon Image">
						  <label class="custom-file-label" for="customFile"><?php echo $__categorieschoosefile ?></label>
						</div>

						<div class="media-upload">
						    <div class="avatar-preview">
						        <div id="imagePreview" style="background-image: url(public/img/blank-placeholder.jpg);">
						        </div>
						    </div>
						</div>

					</div>

				  </div>

				 </div>
				<!-- End of BASIC -->

	     		</form>

            </div><!-- row -->
          </div><!-- col -->
          
          <?php 
	          $homeicon_sidebar_view_type='create';
	          include viewpath('__homeiconsidebar.php'); 
          ?>

        </div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->   