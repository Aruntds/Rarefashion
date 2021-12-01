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

//Update
if($update == "update" && $hidden_id != '') {
		
		$arrFields=array('`__general_facebook`','`__general_instagram`','`__general_twitter`','`__general_pintrest`','`createdby`');
		$arrValues=array("$facebook","$instagram","$twitter","$pinterest","$logged_user_id");
		$sqlWhere= "createdby=$hidden_id";

		if(sqlACTIONS("UPDATE","js_settinggeneral",$arrFields,$arrValues, $sqlWhere)) {
			
			echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
				?>
				<script type="text/javascript">window.location = 'socialmedia.php?code=2' </script>
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
                 
                 //echo "select * FROM `js_settinggeneral` where `createdby`='$logged_id'";exit();
						 $select_itemlist = sqlQUERY_LABEL("select * FROM `js_settinggeneral` where `_generalID`='1'") or die(sqlERROR_LABEL());
								$result_count = sqlNUMOFROW_LABEL($select_itemlist);
								 while($collect_item_list = sqlFETCHARRAY_LABEL($select_itemlist)) {
									$facebook = $collect_item_list['__general_facebook'];
									$instagram = $collect_item_list['__general_instagram'];
									$twitter = $collect_item_list['__general_twitter'];
									$pinterest = $collect_item_list['__general_pintrest'];
									
								}
					}
            ?>
                
      
    
            <!-- Product Allert -->
            <div class="divider-text">Social Media Info</div>

                <div class="form-group row">
                    <label for="facebook" class="col-sm-4 col-form-label">Facebook<span class="tx-danger">*</span></label>
                    <div class="col-sm-8">
                          <input type="text" class="form-control" placeholder="Email ID" name="facebook" id="facebook" value="<?php echo $facebook ; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="instagram" class="col-sm-4 col-form-label">Instagram<span class="tx-danger">*</span></label>
                    <div class="col-sm-8">
                          <input type="text" class="form-control" placeholder="Email ID" name="instagram" id="instagram" value="<?php echo $instagram ; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="twitter" class="col-sm-4 col-form-label">Twitter <span class="tx-danger">*</span></label>
                    <div class="col-sm-8">
                          <input type="text" class="form-control" placeholder="Email ID" name="twitter" id="twitter" value="<?php echo $twitter ; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="pinterest" class="col-sm-4 col-form-label">Pinterest<span class="tx-danger">*</span></label>
                    <div class="col-sm-8">
                          <input type="text" class="form-control" placeholder="Email ID" name="pinterest" id="pinterest" value="<?php echo $pinterest ; ?>">
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