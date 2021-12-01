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

	$customergrouptitle = $validation_globalclass->sanitize($_REQUEST['customergrouptitle']);
	
	$customergroupstatus = $_REQUEST['customergroupstatus']; //value='on' == 1 || value='' == 0
	if($customergroupstatus == 'on') { $customergroupstatus = '1'; } else { $customergroupstatus = '0'; }
	
					//Insert query
					$arrFields=array('`customergrouptitle`','`status`');

					$arrValues=array("$customergrouptitle","$customergroupstatus");

					if(sqlACTIONS("INSERT","js_customergroup",$arrFields,$arrValues,'')) {
						
						echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";

						if( $save == "save"	) {
							?>
							<script type="text/javascript">window.location = 'customergroup.php?route=add&code=1' </script>
							<?php
							//header("Location:category.php?route=add&code=1");
						} else {
							?>
							<script type="text/javascript">window.location = 'customergroup.php?code=1' </script>
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
				    </div>
				  </div>

				<!-- BASIC Starting -->
				<div id="basic">
				  <div class="divider-text">Basic Info</div>
                  
				  <div class="form-group row">
				  	<label for="customergroupstatus" class="col-sm-2 col-form-label">Active</label>
					<div class="col-sm-7">
						<div class="custom-control custom-switch">
						  <input type="checkbox" class="custom-control-input" name="customergroupstatus" id="customergroupstatus" checked="">
						  <label class="custom-control-label" for="customergroupstatus">Yes</label>
						</div>
					</div>
				  </div>

				  <div class="form-group row">
				    <label for="customergrouptitle" class="col-sm-2 col-form-label">Title<span class="tx-danger">*</span></label>
				    <div class="col-sm-7">
						 <input type="text" class="form-control" name="customergrouptitle" id="customergrouptitle" placeholder="Customer Group Title" required data-parsley-error-message="Please enter customer group title">				      
				    </div>
				  </div>
                  
				</div>
				<!-- End of BASIC -->
				</form>

            </div><!-- row -->
          </div><!-- col -->
          
          <?php 
	          $customergroup_sidebar_view_type='create';
	          include viewpath('__customergroupsidebar.php'); 
          ?>

        </div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->   