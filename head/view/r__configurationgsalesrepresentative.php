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

if($save == 'save'){			
		
		$arrFields=array('`_general_salesemailsendername`','`_general_salesemailsenderemail`');
		$arrValues=array("$salesemail_sendername","$salesemail_senderemail");

		if(sqlACTIONS("INSERT","js_settinggeneral",$arrFields,$arrValues,''))
		{	
			?>
			<script type="text/javascript">window.location = 'configurationgsalesrepresentative.php?code=1' </script>
			<?php		
			
		}

}

if($update == "update" && $hidden_id != '') {

		$arrFields=array('`_general_salesemailsendername`','`_general_salesemailsenderemail`');
		$arrValues=array("$salesemail_sendername","$salesemail_senderemail");

		$sqlWhere= "createdby=$hidden_id";

		if(sqlACTIONS("UPDATE","js_settinggeneral",$arrFields,$arrValues, $sqlWhere)) {
			
			echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
				?>
				<script type="text/javascript">window.location = 'configurationgsalesrepresentative.php?code=2' </script>
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
				     </button>
				    </div>
				  </div>

				<!-- BASIC Starting -->
				<div id="basic">
			<?php 	
				if($logged_user_id != '') {
					
					$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_settinggeneral` where deleted = '0' and `createdby`='$logged_user_id'") or die("Unable to get records:".mysql_error());			
					$check_record_availabity = sqlNUMOFROW_LABEL($list_datas);			

					while($row = sqlFETCHARRAY_LABEL($list_datas)){
					  $general_salesemailsendername = $row["_general_salesemailsendername"];
					  $general_salesemailsenderemail =$row["_general_salesemailsenderemail"];
				
					}
				}
			?>
	<div class="divider-text">Basic Info</div>
		<div id="emailsettings">
		    <div class="form-group row">
				<label for="categorymetakeywords" class="col-sm-2 col-form-label"><?php echo $__gsalesemail ?></label>
				<div class="col-sm-7">
                  <fieldset class="form-fieldset">
                          <div class="form-group">
                            <label for="salesemail_sendername" class="d-block"><?php echo $__gsendername ?></label>
                                <input type="text" class="form-control" placeholder="Enter the Sales Name" name="salesemail_sendername" id="salesemail_sendername" value="<?php echo $general_salesemailsendername ;?>">
                          </div>
                          <div class="form-group">
                            <label for="salesemail_senderemail"  class="d-block"><?php echo $__gsenderemail ?></label>
                                <input type="text" class="form-control" placeholder="Enter the Sales Email" name="salesemail_senderemail" id="salesemail_senderemail"  value="<?php echo $general_salesemailsenderemail ;?>">
                          </div>
                    </fieldset>
				</div>
			</div>
		</div>
				<!-- End of BASIC -->

				</form>
				</div>
            </div><!-- row -->
          </div><!-- col -->
          
          <?php 
	          $__configurationgsalesrepresentative_sidebar_view_type='create';
	          include viewpath('__configurationgsalesrepresentativesidebar.php'); 
          ?>

        </div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->   