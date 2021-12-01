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
if( $save == "update" && $hidden_homeiconID != '') {

	$footer_ID = $validation_globalclass->sanitize($_REQUEST['footer_ID']);

	$footer_description = htmlentities($_REQUEST['footer_description']);
	//trim ($footer_description);

		$status = $_REQUEST['status']; //value='on' == 1 || value='' == 0
		if($status == 'on') { $status = '1'; } else { $status = '0'; }
	
		$footer_show = $_REQUEST['footer_show']; //value='on' == 1 || value='' == 0
		if($footer_show == 'on') { $footer_show = '1'; } else { $footer_show = '0'; }

		//Insert Query
		$arrFields=array('`footer_displayorder`', '`footer_title`','`footer_show`', '`footer_description`', '`footer_displaysize`', '`status`');
		$arrValues=array("$footer_displayorder","$footer_title","$footer_show","$footer_description","$footer_displaysize","$status");

		$sqlWhere= "footer_ID=$hidden_homeiconID";

		if(sqlACTIONS("UPDATE","js_footer",$arrFields,$arrValues, $sqlWhere)) {
			
			echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
				?>
				<script type="text/javascript">window.location = 'footer.php?code=2' </script>
				<?php
				
			exit();

		} else {

			$err[] =  "Unable to Insert Record"; 

		}

	}



if($route == 'edit' && $id != '') {

	$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_footer` where deleted = '0' and `footer_ID`='$id'") or die("Unable to get records:".mysql_error());			
	$check_record_availabity = sqlNUMOFROW_LABEL($list_datas);			

	while($row = sqlFETCHARRAY_LABEL($list_datas)){
	  $footer_ID = $row["footer_ID"];
	  $footer_displayorder = $row["footer_displayorder"];
	  $footer_title = stripslashes($row["footer_title"]);
	  $footer_displaysize = $row["footer_displaysize"];
	  $footer_description = html_entity_decode($row["footer_description"]);
	  $footer_show = stripslashes($row["footer_show"]);

	  $status = $row["status"];
		
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
                      <input type="hidden" name="hidden_homeiconID" value="<?php echo $footer_ID; ?>" />
				    </div>
				  </div>

				<!-- BASIC Starting -->
				<div id="basic">
				  <div class="divider-text"><?php echo $__hbasicinfo ?></div>
				  <div class="form-group row">
				  	<label for="status" class="col-sm-2 col-form-label"><?php echo $__active ?></label>
					<div class="col-sm-7">
						<div class="custom-control custom-switch">
						  <input type="checkbox" class="custom-control-input" name="status" id="status" <?php if($status == '1') { echo 'checked=""'; } ?>>
						  <label class="custom-control-label" for="status">Yes</label>
						</div>
					</div>
				  </div>

				  <div class="form-group row">
				    <label for="footer_displayorder" class="col-sm-2 col-form-label">Display Order <span class="tx-danger">*</span></label>
				    <div class="col-sm-7">
						<input type="text" class="form-control" name="footer_displayorder" id="footer_displayorder" placeholder="Display Order" required data-parsley-error-message="Please enter valid data" value="<?php echo $footer_displayorder ?>">				      
				    </div>
				  </div>

                  <div class="form-group row">
                    <label for="footer_title" class="col-sm-2 col-form-label"><?php echo $__title ?> <span class="tx-danger">*</span></label>
                    <div class="col-sm-5">
                      <input type="text" class="form-control" name="footer_title" id="footer_title" placeholder="Title" required data-parsley-error-message="Please enter Title name" value="<?php echo $footer_title ?>" >
                    </div>
                    </div>
                    <div class="form-group row">
                    <label for="footer_show" class="col-sm-2 col-form-label"><?php echo $__foshowtitle ?></label>
				    <div class="col-sm-2">
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" id="footer_show" name="footer_show" <?php if($footer_show=='1') { echo 'checked="checked"'; } ?> >
                              <label class="custom-control-label" for="footer_show"><?php echo $__footeroneshowtitle ?></label>
                            </div>
				    </div>
				  </div>

				  <div class="form-group row">
				    <label for="footer_description" class="col-sm-2 col-form-label"><?php echo $__description ?></label>
				    <div class="col-sm-7">
						 <textarea class="form-control" rows="2" placeholder="Product Descrption..."  name="footer_description" id="footer_description"> <?php echo $footer_description ?> </textarea>
					</div>

				  </div>
				
				 <div class="form-group row">
				    <label for="footer_displaysize" class="col-sm-2 col-form-label">Display Size  <span class="tx-danger">*</span></label>
				    <div class="col-sm-7">
						<select name="footer_displaysize" id="footer_displaysize" class="custom-select">						  
						  <?php echo getDISPLAYFOOTERSIZE($footer_displaysize, 'select'); ?>
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