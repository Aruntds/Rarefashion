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

//Insert

if($save == 'save' || $save_close == "save_close"){			
	$custom_message = htmlentities($_REQUEST['custom_message']);
	trim ($custom_message);
		$arrFields=array('`template_name`','`email_subject`','`default_message`','`custom_message`','`status`');
		$arrValues=array("$templatename","$subject","$default_message","$custom_message","$status");

		if(sqlACTIONS("INSERT","js_emailtemplate",$arrFields,$arrValues,''))
		{	
			echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
			if( $save == "save"	) {
			?>
			  <script type="text/javascript">window.location = 'emailtemplate.php?route=add&code=1' </script>
			<?php
			//header("Location:category.php?route=add&code=1");
			} else {
			?>
			  <script type="text/javascript">window.location = 'emailtemplate.php?code=1' </script>
			<?php
			//header("Location:category.php?code=1");
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
				     </button>
				    </div>
				  </div>

				<!-- BASIC Starting -->
				<div id="basic">
				  <div class="divider-text">Basic Info</div>
				  
				   <div class="form-group row">
						<label for="status" class="col-sm-2 col-form-label"><?php echo $__status ;?><span class="text-danger">*</span></label>
						<div class="col-sm-7">
							<div class="custom-control custom-switch">
								  <input type="checkbox" class="custom-control-input" name="status" id="status" value="1"checked="">
								  <label class="custom-control-label" for="status">Yes</label>
							</div>

						</div>
				  </div>

				  <div class="form-group row">
				    <label for="templatename" class="col-sm-2 col-form-label"><?php echo $__templatename ;?><span class="text-danger">*</span></label>
				    <div class="col-sm-7">
				      <input type="text" class="form-control" name="templatename" id="templatename" placeholder="Template Name" required data-parsley-error-message="Please Enter Template Name">
				    </div>
				  </div>
				
				 <div class="form-group row">
				    <label for="subject" class="col-sm-2 col-form-label"><?php echo $__subject ;?><span class="text-danger">*</span></label>
				    <div class="col-sm-7">
				      <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required data-parsley-error-message="Please Enter Subject">
				    </div>
				  </div>
				
				 <div class="form-group row">
				    <label for="custom_message" class="col-sm-2 col-form-label"><?php echo $__customtmessage ;?><span class="text-danger">*</span></label>
				    <div class="col-sm-7">
				      <textarea class="form-control" rows="4" cols="40" name="custom_message" id="custom_message" placeholder="Custom Message" required data-parsley-error-message="Please Enter Custom Message"><?php echo $default_message; ?></textarea> 
				    </div>
				  </div>
				</div>
				<!-- End of BASIC -->

				</form>

            </div><!-- row -->
          </div><!-- col -->
          
          <?php 
	          $emailtemplate_sidebar_view_type='create';
	          include viewpath('__emailtemplatesidebar.php'); 
          ?>

        </div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->   