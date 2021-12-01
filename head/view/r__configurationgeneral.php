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
if($save == "save" && $hidden_id == '') 

{		
		$arrFields=array('`_general_timezone`','`_general_language`','`_general_currency`','`_general_storename`','`_general_storephone`','`_general_storeworkinghours`','`_general_storecountry`','`_general_storestate`','`_general_storepostal`','`_general_storecity`','`_general_storeaddress1`','`_general_stroreaddress2`','`image_thumb_width`','`image_thumb_height`','`image_medium_width`','`image_medium_height`','`image_large_width`','`image_large_height`','`image_extralarge_width`','`image_extralarge_height`','`createdby`');
		
		
		$arrValues=array("$timezone","$language","$general_currency","$store_name","$store_phone","$store_hours","$country","$region_state","$zip_postal","$city","$address1","$address2","$image_thumb_width","$image_thumb_height","$image_medium_width","$image_medium_height","$image_large_width","$image_large_height","$image_extralarge_width","$image_extralarge_height","$logged_user_id");

		if(sqlACTIONS("INSERT","js_settinggeneral",$arrFields,$arrValues,''))
		{	
				header("Location:configurationgeneral.php"); 	
		}
}

//Update
if($update == "update" && $hidden_id != '') {

		$arrFields=array('`_general_timezone`','`_general_language`','`_general_currency`','`_general_storename`','`_general_storephone`','`_general_storeworkinghours`','`_general_storecountry`','`_general_storestate`','`_general_storepostal`','`_general_storecity`','`_general_storeaddress1`','`_general_stroreaddress2`','`image_thumb_width`','`image_thumb_height`','`image_medium_width`','`image_medium_height`','`image_large_width`','`image_large_height`','`image_extralarge_width`','`image_extralarge_height`');

		$arrValues=array("$timezone","$language","$general_currency","$store_name","$store_phone","$store_hours","$country","$region_state","$zip_postal","$city","$address1","$address2","$image_thumb_width","$image_thumb_height","$image_medium_width","$image_medium_height","$image_large_width","$image_large_height","$image_extralarge_width","$image_extralarge_height");

		$sqlWhere= "createdby=$hidden_id";

		if(sqlACTIONS("UPDATE","js_settinggeneral",$arrFields,$arrValues, $sqlWhere)) {
			
			echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
				?>
				<script type="text/javascript">window.location = 'configurationgeneral.php?code=2' </script>
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
				$gettinglast_updated = getSINGLEDBVALUE('updatedon', "createdby=$logged_user_id", 'js_settinggeneral', 'label');
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
            </div>
          </div>

        <!-- Local Starting -->
        <div id="local">
			
          <div class="divider-text">Locale Option</div>
			<?php 	
				if($logged_user_id != '') {
					
					$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_settinggeneral` where deleted = '0' and `createdby`='$logged_user_id'") or die("Unable to get records:".mysql_error());			
					$check_record_availabity = sqlNUMOFROW_LABEL($list_datas);			

					while($row = sqlFETCHARRAY_LABEL($list_datas)){
					  $createdby = $row["createdby"];
					  $generalID = $row["_generalID"];
					  $general_timezone = $row["_general_timezone"];
					  $general_language =$row["_general_language"];
					  $general_currency =$row["_general_currency"];
					  //echo $general_currency ;exit();
					  $general_storename =$row["_general_storename"];
					  $general_storephone =$row["_general_storephone"];
					  $general_storeworkinghours =$row["_general_storeworkinghours"];
					  $general_storecountry =$row["_general_storecountry"];
					  $general_storestate =$row["_general_storestate"];
					  $general_storepostal =$row["_general_storepostal"];
					  $general_storecity =$row["_general_storecity"];
					  $general_storeaddress1 =$row["_general_storeaddress1"];
					  $general_stroreaddress2 =$row["_general_stroreaddress2"];
					  $image_thumb_width =$row["image_thumb_width"];
					  $image_thumb_height =$row["image_thumb_height"];
					  $image_medium_width =$row["image_medium_width"];
					  $image_medium_height =$row["image_medium_height"];
					  $image_large_width =$row["image_large_width"];
					  $image_large_height =$row["image_large_height"];
					  $image_extralarge_width =$row["image_extralarge_width"];
					  $image_extralarge_height =$row["image_extralarge_height"];
				
					}
				}
			?>
          <div class="form-group row">
            <label for="timezone" class="col-sm-2 col-form-label"><?php echo $__gtimezone ?><span class="text-danger">*</span></label>
            <div class="col-sm-7">
             <select name="timezone" id="timezone" class="custom-select">              
              <?php echo getTIMEZONE($general_timezone, 'select'); ?>
             </select>             
            </div>
          </div>

          <div class="form-group row">
            <label for="language" class="col-sm-2 col-form-label"><?php echo $__glanguage ?><span class="text-danger">*</span></label>
            <div class="col-sm-7">
              <select name="language" id="language" class="custom-select">              
               <?php echo getLANGUAGE($general_language, 'select'); ?>
              </select> 
            </div>
          </div>
          
          <div class="form-group row">
            <label for="general_currency" class="col-sm-2 col-form-label"><?php echo $__gcurrency ?><span class="text-danger">*</span></label>
            <div class="col-sm-7">
              <select name="general_currency" id="general_currency" class="custom-select">              
               <?php echo getCUREENCY('', 'select'); ?>
              </select> 
            </div>
          </div>
		</div>
      
        <!-- End of Local -->

        <!-- Store Settings -->
        <div id="store">

          <div class="divider-text">Store Settings</div>

          <div class="form-group row">
            <label for="store_name" class="col-sm-2 col-form-label"><?php echo $__gstorename ?><span class="text-danger">*</span></label>
            <div class="col-sm-7">
              <input type="text" class="form-control" name="store_name" id="store_name" placeholder="Store Name" required data-parsley-error-message="Please enter Store name" value="<?php echo $general_storename ;?>">
            </div>
          </div>

          <div class="form-group row">
            <label for="store_phone" class="col-sm-2 col-form-label"><?php echo $__gstorephonenumber ?><span class="tx-danger">*</span></label>
          <div class="col-sm-7">
              <input type="text" class="form-control" placeholder="Phone Number" name="store_phone" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="store_phone" required data-parsley-error-message="Please enter Store Mobile Number" value="<?php echo $general_storephone ;?>">
          </div>
          </div>

        			
           <div class="form-group row">
            <label for="country" class="col-sm-2 col-form-label"><?php echo $__gcountry ?><span class="tx-danger">*</span></label>
            <div class="col-sm-7">
              <select name="country" id="country" class="custom-select">              
               <?php echo getCOUNTRY($general_storecountry, 'select'); ?>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <label for="region_state" class="col-sm-2 col-form-label"><?php echo $__gregion ?><span class="tx-danger">*</span></label>
          <div class="col-sm-7">
              <input type="text" class="form-control" placeholder="Region" name="region_state" id="region_state" required data-parsley-error-message="Please enter Region" value="<?php echo $general_storestate ;?>">
          </div>
          </div>

          <div class="form-group row">
            <label for="zip_postal" class="col-sm-2 col-form-label"><?php echo $__gzippostal ?><span class="tx-danger">*</span></label>
          <div class="col-sm-7">
              <input type="text" class="form-control" placeholder="Zip / Postal" name="zip_postal" id="zip_postal"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required data-parsley-error-message="Please enter Postal Code" value="<?php echo $general_storepostal ;?>">
          </div>
          </div>
          
           <div class="form-group row">
            <label for="city" class="col-sm-2 col-form-label"><?php echo $__gcity ?><span class="tx-danger">*</span></label>
            <div class="col-sm-7">
              <input type="text" class="form-control" name="city" id="city" placeholder="City" required data-parsley-error-message="Please enter City" value="<?php echo $general_storecity ;?>">
            </div>
          </div>

          <div class="form-group row">
            <label for="address1" class="col-sm-2 col-form-label"><?php echo $__gaddress1 ?><span class="tx-danger">*</span></label>
          <div class="col-sm-7">
              <input type="text" class="form-control" placeholder="Address 1" name="address1" id="address1" required data-parsley-error-message="Please enter Address" value="<?php echo $general_storeaddress1 ;?>">
          </div>
          </div>

          <div class="form-group row">
            <label for="address2" class="col-sm-2 col-form-label"><?php echo $__gaddress2 ?></label>
          <div class="col-sm-7">
              <input type="text" class="form-control" placeholder="Address 2" name="address2" id="address2" value="<?php echo $general_stroreaddress2 ;?>">
          </div>
          </div>  
        

        </div>
        <!-- End of Store Settings -->

        <!-- Image Settings -->
        <div id="imagesetting">

          <div class="divider-text">Image Settings</div>

          <div class="form-group row mg-b-5">
            <label for="categorydesignsettings" class="col-sm-2 col-form-label"></label>
            <div class="col-sm-7">
            <div class="form-row">
                <div class="col-md-2 pd-b-0">
                  <span>Width (px)</span>
                </div>
                <div class="col-md-2 pd-b-0">
                 <span>Height (px)</span>
                </div>
            </div>
           </div>
          </div>
          
          <div class="form-group row">
            <label for="image_thumb_height" class="col-sm-2 col-form-label"><?php echo $__gimagethumb ?><span class="tx-danger">*</span></label>
            <div class="col-sm-7">
            <div class="form-row">
                <div class="col-md-2">
                  <input type="text" class="form-control" placeholder="" name="image_thumb_width" id="image_thumb_width" value="<?php echo $image_thumb_width ;?>">
                </div>
                <div class="col-md-2">
                 <input type="text" class="form-control" placeholder="" name="image_thumb_height" id="image_thumb_height" value="<?php echo $image_thumb_height ;?>">
                </div>
              </div>            
            </div>
          </div>
          <div class="form-group row">
            <label for="image_medium_height" class="col-sm-2 col-form-label"><?php echo $__gimagemargin ?><span class="tx-danger">*</span></label>
            <div class="col-sm-7">
            <div class="form-row">
                <div class="col-md-2">
                  <input type="text" class="form-control" placeholder="" name="image_medium_width" id="image_medium_width" value="<?php echo $image_medium_width ;?>">
                </div>
                <div class="col-md-2">
                 <input type="text" class="form-control" placeholder="" name="image_medium_height" id="image_medium_height" value="<?php echo $image_medium_height ;?>">
                </div>
            </div>
          </div>
	     </div>	
         <div class="form-group row">
            <label for="image_large_width" class="col-sm-2 col-form-label"><?php echo $__gimagelarge ?><span class="tx-danger">*</span></label>
            <div class="col-sm-7">
            <div class="form-row">
                <div class="col-md-2">
                  <input type="text" class="form-control" placeholder="" name="image_large_width" id="image_large_width" value="<?php echo $image_large_width ;?>">
                </div>
                <div class="col-md-2">
                 <input type="text" class="form-control" placeholder="" name="image_large_height" id="image_large_height" value="<?php echo $image_large_height ;?>">
                </div>
            </div>
          </div>
	     </div>
         <div class="form-group row">
            <label for="image_extralarge_width" class="col-sm-2 col-form-label"><?php echo $__gimagextralarge ?><span class="tx-danger">*</span></label>
            <div class="col-sm-7">
            <div class="form-row">
                <div class="col-md-2">
                  <input type="text" class="form-control" placeholder="" name="image_extralarge_width" id="image_extralarge_width" value="<?php echo $image_extralarge_width ;?>">
                </div>
                <div class="col-md-2">
                 <input type="text" class="form-control" placeholder="" name="image_extralarge_height" id="image_extralarge_height" value="<?php echo $image_extralarge_height ;?>">
                </div>
            </div>
          </div>
	     </div>
         	
        </div>
        <!-- End of Image Settings -->
        
          <!--<div class="form-group row">
            <label for="categorymetakeywords" class="col-sm-2 col-form-label"><?php echo $__gcustomemail ?></label>
              <div class="col-sm-7">
                  <fieldset class="form-fieldset">
                          <div class="form-group">
                            <label class="d-block"><?php echo $__gsendername ?></label>
                                <input type="text" class="form-control" placeholder="Enter the Custom Name" name="customemail_sendername" id="customemail_sendername">
                          </div>
                          <div class="form-group">
                            <label class="d-block"><?php echo $__gsenderemail ?></label>
                                <input type="text" class="form-control" placeholder="Enter the Custom Email" name="customemail_senderemail" id="customemail_senderemail">
                          </div>
                    </fieldset>
              </div>
          </div>-->
            
       
      
        <!-- End of Store email Settings -->
        </form>

            </div><!-- row -->
          </div><!-- col -->
          
          <?php 
            $category_sidebar_view_type='create';
            include viewpath('__generalsidebar.php'); 
          ?>

        </div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->   
