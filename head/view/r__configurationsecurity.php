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
		$arrFields=array('`_security_googlerecaptcha_apiwebsitekey`','`_security_googlerecaptcha_apisecretkey`','`createdby`');
		$arrValues=array("$api_websitekey","$api_securitykey","$logged_user_id");

		if(sqlACTIONS("INSERT","js_settingsecurity",$arrFields,$arrValues,''))
		{	
			?>
			<script type="text/javascript">window.location = 'configurationsecurity.php?code=1' </script>
			<?php		
			
		}
}


//Update
if($update == "update" && $hidden_id != '') {

		$arrFields=array('`_security_googlerecaptcha_apiwebsitekey`','`_security_googlerecaptcha_apisecretkey`','`createdby`');
		$arrValues=array("$api_websitekey","$api_securitykey","$logged_user_id");

		$sqlWhere= "createdby=$hidden_id";

		if(sqlACTIONS("UPDATE","js_settingsecurity",$arrFields,$arrValues, $sqlWhere)) {
			
			echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
				?>
				<script type="text/javascript">window.location = 'configurationsecurity.php?code=2' </script>
				<?php
				//header("Location:category.php?code=1");
				
			exit();

		} else {

			$err[] =  "Unable to Update Record"; 

		}

}
?>
  <div class="content">
      <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="row">
          <div class="col-lg-9">
            <div class="mg-b-25">

        <form method="post" enctype="multipart/form-data" data-parsley-validate>
			<?php 
				$gettinglast_updated = getSINGLEDBVALUE('updatedon', "createdby=$logged_user_id", 'js_settingsecurity', 'label');
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
          <div class="divider-text">Google Recaptcha</div>
			<?php 	
				if($logged_user_id != '') {
					
					$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_settingsecurity` where deleted = '0' and `createdby`='$logged_user_id'") or die("Unable to get records:".mysql_error());			
					$check_record_availabity = sqlNUMOFROW_LABEL($list_datas);			

					while($row = sqlFETCHARRAY_LABEL($list_datas)){
					  $security_googlerecaptcha_apiwebsitekey = $row["_security_googlerecaptcha_apiwebsitekey"];
					  $security_googlerecaptcha_apisecretkey =$row["_security_googlerecaptcha_apisecretkey"];
				
					}
				}
			?>
          <div class="form-group row">
            <label for="api_websitekey" class="col-sm-2 col-form-label"><?php echo $__apiwebsitekey; ?><span class="text-danger"> *</span></label>
            <div class="col-sm-7">
			 
              <input type="text" class="form-control" name="api_websitekey" id="api_websitekey" placeholder="API Website Key" required data-parsley-error-message="Please enter API Website Key" value="<?php echo  $security_googlerecaptcha_apiwebsitekey; ?>">
            </div>
          </div>
		  
		   <div class="form-group row">
            <label for="api_securitykey" class="col-sm-2 col-form-label"><?php echo $__apiweebsecuritykey; ?><span class="text-danger"> *</span></label>
            <div class="col-sm-7">
              <input type="text" class="form-control" name="api_securitykey" id="api_securitykey" placeholder="API Security Key" required data-parsley-error-message="Please enter API Websecurity Key" value="<?php echo $security_googlerecaptcha_apisecretkey; ?>">
            </div>
          </div>

        </div>
       

        </form>

            </div><!-- row -->
          </div><!-- col -->
          
          <?php 
            $category_sidebar_view_type='create';
            include viewpath('__securitysidebar.php'); 
          ?>

        </div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->   