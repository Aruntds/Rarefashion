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
if($save == 'save')

{

		$enabled = $_REQUEST['enabled']; //value='on' == 1 || value='' == 0
		if($enabled == 'on') { $enabled = '1'; } else { $enabled = '0'; }
		
		$allowguestallert = $_REQUEST['allowguestallert']; //value='on' == 1 || value='' == 0
		if($allowguestallert == 'on') { $allowguestallert = '1'; } else { $allowguestallert = '0'; }
		
		$lowstate_alert = $_REQUEST['lowstate_alert']; //value='on' == 1 || value='' == 0
		if($lowstate_alert == 'on') { $lowstate_alert = '1'; } else { $lowstate_alert = '0'; }
		
		$email = $_REQUEST['email']; //value='on' == 1 || value='' == 0
		if($email == 'on') { $email = '1'; } else { $email = '0'; }
		
		$arrFields=array('`_catalog_displaymode`','`_catalog_productperpage`','`_catalog_productsortby`','`_catalog_enabled`','`_allowguestallert`','`_catalog_lowstateallert`','`_catalog_no_of_productalert`','`_catalog_email`','`_catalog_to`','`_catalog_subject`','`_catalog_template`','`createdby`');
		$arrValues=array("$display_mode","$product_perpage","$productsortby","$enabled","$allowguestallert","$lowstate_alert","$minnoofallert","$email","$to_email","$subject","$template","$logged_user_id");

		if(sqlACTIONS("INSERT","js_settingcatalog",$arrFields,$arrValues,''))
		{	
			?>
			<script type="text/javascript">window.location = 'configurationcatalog.php?code=1' </script>
			<?php		
			
		}
}

//Update
if($update == "update" && $hidden_id != '') {

		$enabled = $_REQUEST['enabled']; //value='on' == 1 || value='' == 0
		if($enabled == 'on') { $enabled = '1'; } else { $enabled = '0'; }
		
		$allowguestallert = $_REQUEST['allowguestallert']; //value='on' == 1 || value='' == 0
		if($allowguestallert == 'on') { $allowguestallert = '1'; } else { $allowguestallert = '0'; }
		
		$lowstate_alert = $_REQUEST['lowstate_alert']; //value='on' == 1 || value='' == 0
		if($lowstate_alert == 'on') { $lowstate_alert = '1'; } else { $lowstate_alert = '0'; }
		
		$email = $_REQUEST['email']; //value='on' == 1 || value='' == 0
		if($email == 'on') { $email = '1'; } else { $email = '0'; }
		
		$arrFields=array('`_catalog_displaymode`','`_catalog_productperpage`','`_catalog_productsortby`','`_catalog_enabled`','`_allowguestallert`','`_catalog_lowstateallert`','`_catalog_no_of_productalert`','`_catalog_email`','`_catalog_to`','`_catalog_subject`','`_catalog_template`','`createdby`');
		$arrValues=array("$display_mode","$product_perpage","$productsortby","$enabled","$allowguestallert","$lowstate_alert","$minnoofallert","$email","$to_email","$subject","$template","$logged_user_id");
		$sqlWhere= "createdby=$hidden_id";

		if(sqlACTIONS("UPDATE","js_settingcatalog",$arrFields,$arrValues, $sqlWhere)) {
			
			echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
				?>
				<script type="text/javascript">window.location = 'configurationcatalog.php?code=2' </script>
				<?php
				//header("Location:category.php?code=1");
				
			exit();

		} else {

			$err[] =  "Unable to Update Record"; 

		}

}
?>

    <!-- container -->
   
    <div class="content">
      <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="row">
          <div class="col-lg-9">
            <div class="mg-b-25">

          <form method="post" enctype="multipart/form-data" data-parsley-validate>
			<?php 
				$gettinglast_updated = getSINGLEDBVALUE('updatedon', "createdby=$logged_user_id", 'js_settingcatalog', 'label');
				$formated_lastupdate_time = strtotime($gettinglast_updated);
			?>
            <div id="stick-here"></div>
            <div id="stickThis" class="form-group row mg-b-0">
                <div class="col-3 col-sm-6">
                  <p class="text-muted">Last Updated on : <?php echo time_stamp($formated_lastupdate_time); ?></p>
                </div>
                <div class="col-9 col-sm-6 text-right">
                    <?php if($logged_user_id == '') { ?>
                      <button type="submit" name="save" value="save" class="btn btn-success">Save</button>
                    <?php } else { ?>
                    <button type="submit" name="update" value="update" class="btn btn-warning">Update</button>
                      <input type="hidden" name="hidden_id" value="<?php echo $logged_user_id; ?>" />
                    <?php } ?>
                     </button>
                </div>
            </div>
            
			<?php 	
                 if($logged_user_id != '') {
                    $list_datas = sqlQUERY_LABEL("SELECT * FROM `js_settingcatalog` where deleted = '0' and `createdby`='$logged_user_id'") or die("Unable to get records:".mysql_error());			
                    $check_record_availabity = sqlNUMOFROW_LABEL($list_datas);			
                    while($row = sqlFETCHARRAY_LABEL($list_datas)){
                      $createdby = $row["createdby"];
                      $catalogID = $row["_catalogID"];
                      $catalog_displaymode = $row["_catalog_displaymode"];
                      $catalog_productperpage =$row["_catalog_productperpage"];
                      $catalog_productsortby =$row["_catalog_productsortby"];
                      $catalog_enabled =$row["_catalog_enabled"];
                      $catalog_lowstateallert =$row["_catalog_lowstateallert"];
                      $allowguestallert =$row["_allowguestallert"];
                      $catalog_no_of_productalert =$row["_catalog_no_of_productalert"];
                      $catalog_email =$row["_catalog_email"];
                      $catalog_to =$row["_catalog_to"];
                      $catalog_subject =$row["_catalog_subject"];
                      $catalog_template =$row["_catalog_template"];					
                    }
                }
            ?>
                
            <!--  Store Front-->
            <div id="storefront">
              <div class="divider-text">Catalogue Page</div>
             
              <div class="form-group row">
                <label for ="display_mode" class="col-sm-4 col-form-label"><?php echo $__listmode ?><span class="tx-danger">*</span></label>
                <div class="col-sm-8">
                 <select name="display_mode" id="display_mode" class="custom-select">              
                  <?php echo getDISPLAYMODE($catalog_displaymode,'select'); ?>
                 </select>             
                </div>
              </div>
    
              <div class="form-group row">
                <label for="product_perpage" class="col-sm-4 col-form-label"><?php echo $__prdperpage ?><span class="tx-danger">*</span></label>
                <div class="col-sm-8">
                      <input type="text" class="form-control" placeholder="Product Per Page" name="product_perpage" id="product_perpage" required data-parsley-error-message="Please enter Product per page" value="<?php echo $catalog_productperpage ; ?>">
                </div>
              </div>
              
              <div class="form-group row">
                <label for="productsortby" class="col-sm-4 col-form-label"><?php echo $__prdsortby ?><span class="tx-danger">*</span></label>
                <div class="col-sm-8">
                    <select class="custom-select" name="productsortby" id="productsortby">
                        <?php echo getPRODUCTSORTBY($catalog_productsortby, 'select'); ?>
                    </select>
                </div>
               </div>
            </div>
            <!-- End of Store Front -->
    
            <!-- Review -->
            <div id="review">
    
                <div class="divider-text">Review</div>
    
                <div class="form-group row">
                <label for="enabled" class="col-sm-4 col-form-label"><?php echo $__enabled ?><span class="tx-danger">*</span></label>
                <div class="col-sm-8">
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" name="enabled" id="enabled" <?php if($catalog_enabled == '1') { echo 'checked=""'; } ?>>
                      <label class="custom-control-label" for="enabled">Yes</label>
                    </div>
                </div>
                </div>
                
                <div class="form-group row">
                <label for="allowguestallert" class="col-sm-4 col-form-label"><?php echo $__allowguestreview ?><span class="tx-danger">*</span></label>
                <div class="col-sm-8">
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" name="allowguestallert" id="allowguestallert" <?php if($allowguestallert == '1') { echo 'checked=""'; } ?>>
                      <label class="custom-control-label" for="allowguestallert">Yes</label>
                    </div>
                </div>
                </div>
    
            </div>
            <!-- End of Review -->
    
            <!-- Product Allert -->
            <div id="productallert">
    
                <div class="divider-text">Product Alert</div>
    
                <div class="form-group row">
                    <label for="lowstate_alert" class="col-sm-4 col-form-label"><?php echo $__lowstate ?><span class="tx-danger">*</span></label>
                    <div class="col-sm-8">
                        <div class="custom-control custom-switch">
                          <input type="checkbox" class="custom-control-input" name="lowstate_alert" id="lowstate_alert" <?php if($catalog_lowstateallert == '1') { echo 'checked=""'; } ?>>
                          <label class="custom-control-label" for="lowstate_alert">Yes</label>
                        </div>
                    </div>
                </div>
     
                <div class="form-group row">
                    <label for="minnoofallert" class="col-sm-4 col-form-label"><?php echo $__minnoofallert ?><span class="tx-danger">*</span></label>
                    <div class="col-sm-8">
                          <input type="text" class="form-control" placeholder="Minimum Alert" name="minnoofallert" id="minnoofallert" required data-parsley-error-message="Please enter Number of Product Allert"  value="<?php echo $catalog_no_of_productalert ; ?>">
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="email" class="col-sm-4 col-form-label"><?php echo $__sendalertemail ?><span class="tx-danger">*</span></label>
                    <div class="col-sm-8">
                        <div class="custom-control custom-switch">
                          <input type="checkbox" class="custom-control-input" name="email" id="email" <?php if($catalog_email == '1') { echo 'checked=""'; } ?>>
                          <label class="custom-control-label" for="email">Yes</label>
                        </div>
                    </div>
                </div>
    
                
                <div class="form-group row">
                    <label for="to_email" class="col-sm-4 col-form-label"><?php echo $__to ?><span class="tx-danger">*</span></label>
                    <div class="col-sm-8">
                          <input type="text" class="form-control" placeholder="Email ID" name="to_email" id="to_email" required data-parsley-error-message="Please enter Email" value="<?php echo $catalog_to ; ?>">
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="subject" class="col-sm-4 col-form-label"><?php echo $__subject ?><span class="tx-danger">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" placeholder="Subject" name="subject" id="subject" required data-parsley-error-message="Please enter Subject" value="<?php echo $catalog_subject ; ?>">            
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="template" class="col-sm-4 col-form-label"><?php echo $__template ?><span class="tx-danger">*</span></label>
                    <div class="col-sm-8">
                        <select class="custom-select" name="template" id="template">
                        <?php echo getPARENTCategory($categoryID, 'select'); ?>
                        </select>
                    </div>
                </div>
    
            </div>
            <!-- End of Product Allert -->
        </form>

        </div><!-- row -->
      </div><!-- col -->
          
	  <?php 
        $catalog_sidebar_view_type='create';
        include viewpath('__configurationcatalogsidebar.php'); 
      ?>

    </div><!-- row -->
  </div><!-- container -->
</div><!-- content -->