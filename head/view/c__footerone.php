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

	$footeroneID = $validation_globalclass->sanitize($_REQUEST['footeroneID']);

	$footeroneorder = $validation_globalclass->sanitize(ucwords($_REQUEST['footeroneorder']));
	$footertitle = $validation_globalclass->sanitize($_REQUEST['footertitle']);

	$footerone_description = htmlentities($_REQUEST['footeronedescription']);
	trim ($footerone_description);

	$status = $_REQUEST['status']; //value='on' == 1 || value='' == 0
	if($status == 'on') { $footeronestatus = '1'; } else { $footeronestatus = '0'; }
	
		$footeroneshow = $_REQUEST['footeroneshow']; //value='on' == 1 || value='' == 0
	if($footeroneshow == 'on') { $footeroneshow = '1'; } else { $footeroneshow = '0'; }
	
		//Insert Query
		$arrFields=array('`footeroneorder`','`footeronetitle`','`footeroneshow`','`footeronedescription`','`display_size`','`status`');

		$arrValues=array("$footeroneorder","$footeronetitle","$footeroneshow","$footerone_description","$display_size","$footeronestatus");

		if(sqlACTIONS("INSERT","js_footerone",$arrFields,$arrValues,'')) {
			
			echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";

			if( $save == "save"	) {
				?>
				<script type="text/javascript">window.location = 'footerone.php?route=add&code=1' </script>
				<?php
				//header("Location:category.php?route=add&code=1");
			} else {
				?>
				<script type="text/javascript">window.location = 'footerone.php?code=1' </script>
				<?php
				//header("Location:category.php?code=1");
			}

			exit();

		} else {

			$err[] =  "Unable to Insert Record"; 

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
				    <label for="footeroneorder" class="col-sm-2 col-form-label"><?php echo $__homeicondisporders ?><span class="tx-danger">*</span></label>
				    <div class="col-sm-7">
						<input type="text" class="form-control" name="footeroneorder" id="footeroneorder" placeholder="Display Order" required data-parsley-error-message="Please enter valid data">				      
				    </div>
				  </div>

                  <div class="form-group row">
                    <label for="footeronetitle" class="col-sm-2 col-form-label"><?php echo $__title ?><span class="tx-danger">*</span></label>
                    <div class="col-sm-5">
                      <input type="text" class="form-control" name="footeronetitle" id="footeronetitle" placeholder="Title" required data-parsley-error-message="Please enter Title name">
                    </div>
                    </div>
                    <div class="form-group row">
                    <label for="footeroneshow" class="col-sm-2 col-form-label"><?php echo $__foshowtitle ?></label>
				    <div class="col-sm-2">
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" id="footeroneshow" name="footeroneshow" checked="">
                              <label class="custom-control-label" for="footeroneshow"><?php echo $__footeroneshowtitle ?></label>
                            </div>
				    </div>
				  </div>

				  <div class="form-group row">
				    <label for="footeronedescrption" class="col-sm-2 col-form-label"><?php echo $__description ?></label>
				    <div class="col-sm-7">
						 <textarea class="form-control" rows="2" placeholder="Product Descrption..."  name="footeronedescription" id="footeronedescription"></textarea>
					</div>

				  </div>
				
				 <div class="form-group row">
				    <label for="display_size" class="col-sm-2 col-form-label"><?php echo $__displaysize ;?><span class="tx-danger">*</span></label>
				    <div class="col-sm-7">
						<select name="display_size" id="display_size" class="custom-select">						  
						  <?php echo getDISPLAYFOOTERSIZE('', 'select'); ?>
						</select>				      
				    </div>
				  </div>
                  
				 </div>
				<!-- End of BASIC -->

	     		</form>

            </div><!-- row -->
          </div><!-- col -->
          
          <?php 
	          $footerone_sidebar_view_type='create';
	          include viewpath('__footeronesidebar.php'); 
          ?>

        </div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->   