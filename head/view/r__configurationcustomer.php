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
if($save == "save") 

{		
		$allow_required = $_REQUEST['allow_required']; //value='on' == 1 || value='' == 0
		if($allow_required == 'on') { $allow_required = '1'; } else { $allow_required = '0'; }
		
		$emailverificationrequest = $_REQUEST['emailverificationrequest']; //value='on' == 1 || value='' == 0
		if($emailverificationrequest == 'on') { $emailverificationrequest = '1'; } else { $emailverificationrequest = '0'; }
		
		$verificationemail_template = $_REQUEST['verificationemail_template']; //value='on' == 1 || value='' == 0
		if($verificationemail_template == 'on') { $verificationemail_template = '1'; } else { $verificationemail_template = '0'; }
		
		$wishlist_enabled = $_REQUEST['wishlist_enabled']; //value='on' == 1 || value='' == 0
		if($wishlist_enabled == 'on') { $wishlist_enabled = '1'; } else { $wishlist_enabled = '0'; }

		$arrFields=array('`_customer_allowrequired`','`_customer_emailverificationrequest`','`_customer_verificationemailtemplate`','`_customer_enabled`','`createdby`');

		$arrValues=array("$allow_required","$emailverificationrequest","$verificationemail_template","$wishlist_enabled","$logged_user_id");
		
		

		if(sqlACTIONS("INSERT","js_settingscustomer",$arrFields,$arrValues,''))
		{	
			
		?>
			<script type="text/javascript">window.location = 'configurationcustomer.php?code=1' </script>
			<?php	

		}
}

//Update
if($update == "update" && $hidden_id != '') {

		$allow_required = $_REQUEST['allow_required']; //value='on' == 1 || value='' == 0
		if($allow_required == 'on') { $allow_required = '1'; } else { $allow_required = '0'; }
		
		$emailverificationrequest = $_REQUEST['emailverificationrequest']; //value='on' == 1 || value='' == 0
		if($emailverificationrequest == 'on') { $emailverificationrequest = '1'; } else { $emailverificationrequest = '0'; }
		
		$verificationemail_template = $_REQUEST['verificationemail_template']; //value='on' == 1 || value='' == 0
		if($verificationemail_template == 'on') { $verificationemail_template = '1'; } else { $verificationemail_template = '0'; }
		
		$wishlist_enabled = $_REQUEST['wishlist_enabled']; //value='on' == 1 || value='' == 0
		if($wishlist_enabled == 'on') { $wishlist_enabled = '1'; } else { $wishlist_enabled = '0'; }

		$arrFields=array('`_customer_allowrequired`','`_customer_emailverificationrequest`','`_customer_verificationemailtemplate`','`_customer_enabled`','`createdby`');

		$arrValues=array("$allow_required","$emailverificationrequest","$verificationemail_template","$wishlist_enabled","$logged_user_id");

		$sqlWhere= "createdby=$hidden_id";

		if(sqlACTIONS("UPDATE","js_settingscustomer",$arrFields,$arrValues, $sqlWhere)) {
			
			echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
				?>
				<script type="text/javascript">window.location = 'configurationcustomer.php?code=2' </script>
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
				$gettinglast_updated = getSINGLEDBVALUE('updatedon', "createdby=$logged_user_id", 'js_settingscustomer', 'label');
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

        <!-- BASIC Starting -->
        <div id="basic">
          <div class="divider-text">Basic Info</div>
			<?php 	
				if($logged_user_id != '') {
					
					$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_settingscustomer` where deleted = '0' and `createdby`='$logged_user_id'") or die("Unable to get records:".mysql_error());			
					$check_record_availabity = sqlNUMOFROW_LABEL($list_datas);			

					while($row = sqlFETCHARRAY_LABEL($list_datas)){
					  $customer_allowrequired = $row["_customer_allowrequired"];
					  $customer_emailverificationrequest =$row["_customer_emailverificationrequest"];
					  $customer_verificationemailtemplate =$row["_customer_verificationemailtemplate"];
					  $customer_enabled =$row["_customer_enabled"];
				
					}
				}
			?>
		<div class="form-group row">
				  	<label for="allow_required" class="col-sm-4 col-form-label"><?php echo $__allowregistration ?><span class="text-danger">*</span></label>
					<div class="col-sm-8">
						<div class="custom-control custom-switch">
						  <input type="checkbox" class="custom-control-input" name="allow_required" id="allow_required" <?php if($customer_allowrequired == '1') { echo 'checked=""'; } ?>>
						  <label class="custom-control-label" for="allow_required">Yes</label>
						</div>
					</div>
			</div>
		
		<div class="form-group row">
				  	<label for="emailverificationrequest" class="col-sm-4 col-form-label"><?php echo $__emailverificationrequest ?><span class="text-danger">*</span></label>
					<div class="col-sm-8">
						<div class="custom-control custom-switch">
						  <input type="checkbox" class="custom-control-input" name="emailverificationrequest" id="emailverificationrequest" <?php if($customer_emailverificationrequest == '1') { echo 'checked=""'; } ?>>
						  <label class="custom-control-label" for="emailverificationrequest">Yes</label>
						</div>
					</div>
			</div>

		<div class="form-group row">
				  	<label for="display_size" class="col-sm-4 col-form-label"><?php echo $__verificationemailtemplate ?><span class="text-danger">*</span></label>
					<div class="col-sm-7">
						<select name="display_size" id="display_size" class="custom-select">						  
						  <?php echo getEMAILTEMPLATE($customer_verificationemailtemplate,'select'); ?>
						</select>				      
				    </div>
			</div>
	
        </div>
        <!-- End of BASIC -->

        <!-- SEO Settings -->
        <div id="Wishlist">

          <div class="divider-text">Wish list</div>
			
			
			<div class="form-group row">
				  	<label for="wishlist_enabled" class="col-sm-4 col-form-label"><?php echo $__enabled ?><span class="text-danger">*</span></label>
					<div class="col-sm-8">
						<div class="custom-control custom-switch">
						  <input type="checkbox" class="custom-control-input" name="wishlist_enabled" id="wishlist_enabled" <?php if($customer_enabled == '1') { echo 'checked=""'; } ?>>
						  <label class="custom-control-label" for="wishlist_enabled">Yes</label>
						</div>
					</div>
			</div>
        </div>

        </form>

            </div><!-- row -->
          </div><!-- col -->
          
          <?php 
            $customer_sidebar_view_type='create';
          include viewpath('__customersidebar.php'); 
           ?>

        </div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->   
