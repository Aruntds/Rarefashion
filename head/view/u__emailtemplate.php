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
if( $save == "update" && $hidden_template_ID != '') {

	$customergrouptitle = $validation_globalclass->sanitize(ucwords($_REQUEST['customergrouptitle']));
	$custom_message = htmlentities($_REQUEST['custom_message']);
	trim ($custom_message);

	$customergroupstatus = $_REQUEST['customergroupstatus']; //value='on' == 1 || value='' == 0
	if($customergroupstatus == 'on') { $customergroupstatus = '1'; } else { $customergroupstatus = '0'; }
	
		//Insert query
		$arrFields=array('`template_name`','`email_subject`','`default_message`','`custom_message`','`status`');
		$arrValues=array("$templatename","$subject","$default_message","$custom_message","$status");

		$sqlWhere= "template_ID=$hidden_template_ID";

		if(sqlACTIONS("UPDATE","js_emailtemplate",$arrFields,$arrValues, $sqlWhere)) {
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
			exit();

		} else {

			$err[] =  "Unable to Insert Record"; 

		}

}

if($route == 'edit' && $id != '') {

	//`categoryID`, `categoryparentID`, `categoryname`, `categoryimage`, `categorydescrption`, `categoryseourl`, `categorymetatitle`, `categorymetakeywords`, `categorymetadescrption`, `categorydesignsettings`, `createdby`, `createdon`, `updatedon`, `status`, `deleted` FROM `js_category`
	$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_emailtemplate` where deleted = '0' and `template_ID`='$id'") or die("Unable to get records:".mysql_error());			
	$check_record_availabity = sqlNUMOFROW_LABEL($list_datas);			

	while($row = sqlFETCHARRAY_LABEL($list_datas)){
	  $template_ID = $row["template_ID"];
	  $template_name = $row["template_name"];
	  $email_subject = $row["email_subject"];
	  $custom_message = html_entity_decode($row["custom_message"], ENT_QUOTES, "UTF-8");
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
				      <button type="submit" name="save" value="update" class="btn btn-warning">Update</button>
                      <input type="hidden" name="hidden_template_ID" value="<?php echo $template_ID; ?>" />
				    </div>
				  </div>

				<!-- BASIC Starting -->
				<div id="basic">
				  <div class="divider-text">Basic Info</div>
				  
				   <div class="form-group row">
						<label for="status" class="col-sm-2 col-form-label"><?php echo $__status ;?></label>
						<div class="col-sm-7">
							<div class="custom-control custom-switch">
								  <input type="checkbox" class="custom-control-input" name="status" id="status" value="1" <?php if($status == '1') { echo 'checked=""'; } ?>>
								  <label class="custom-control-label" for="status">Yes</label>
							</div>

						</div>
				  </div>

				 <div class="form-group row">
				    <label for="templatename" class="col-sm-2 col-form-label"><?php echo $__templatename ;?></label>
				    <div class="col-sm-7">
				      <input type="text" class="form-control" name="templatename" id="templatename" placeholder="Template Name" value="<?php echo $template_name; ?>">
				    </div>
				  </div>
				
				 <div class="form-group row">
				    <label for="subject" class="col-sm-2 col-form-label"><?php echo $__subject ;?></label>
				    <div class="col-sm-7">
				      <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" value="<?php echo $email_subject; ?>">
				    </div>
				  </div>
				
				 <div class="form-group row">
				    <label for="custom_message" class="col-sm-2 col-form-label"><?php echo $__customtmessage ;?></label>
				    <div class="col-sm-7">
				      <textarea class="form-control" rows="4" cols="40" name="custom_message" id="custom_message" placeholder="Custom Message"><?php echo $custom_message; ?></textarea> 
				    </div>
				  </div>
				</div>
				</form>

            </div><!-- row -->
          </div><!-- col -->
          
          <?php 
	          $emailtemplate_sidebar_view_type='create';
	          include viewpath('__customergroupsidebar.php'); 
          ?>

        </div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->   