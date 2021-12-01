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

	
	// 
		//Insert query
		$arrFields=array('`recipient`','`Subject`','`email_heading`','`addtional_content`','`status`');
		$arrValues=array("$recipient","$Subject","$email_heading","$addtional_content","$status");

		$sqlWhere= "id=$hidden_template_ID";

		if(sqlACTIONS("UPDATE","js_email_notification",$arrFields,$arrValues, $sqlWhere)) {
			echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
			if( $save == "save"	) {
			?>
			  <script type="text/javascript">window.location = 'emailnotification.php?route=add&code=1' </script>
			<?php
			//header("Location:category.php?route=add&code=1");
			} else {
			?>
			  <script type="text/javascript">window.location = 'emailnotification.php?code=1' </script>
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
	$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_email_notification` where deleted = '0' and `id`='$id'") or die("Unable to get records:".mysql_error());			
	$check_record_availabity = sqlNUMOFROW_LABEL($list_datas);			

	while($row = sqlFETCHARRAY_LABEL($list_datas)){
	  $ids = $row["id"];
	  $recipient = $row["recipient"];
	  $Subject = $row["Subject"];
	  $email_heading = $row["email_heading"];
	  $addtional_content = $row["addtional_content"];
	  $email_type = $row["email_type"];
	 
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
                      <input type="hidden" name="hidden_template_ID" value="<?php echo $ids; ?>" />
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
				    <label for="recipient" class="col-sm-2 col-form-label"><?php echo $__recipient ;?></label>
				    <div class="col-sm-7">
				      <input type="text" class="form-control" name="recipient" id="recipient" placeholder="Recipient" value="<?php echo $recipient; ?>">
				    </div>
				  </div>
				
				 <div class="form-group row">
				    <label for="Subject" class="col-sm-2 col-form-label"><?php echo $__subject1 ;?></label>
				    <div class="col-sm-7">
				      <input type="text" class="form-control" name="Subject" id="Subject" placeholder="{Testing} : New order #{12345}" value="<?php echo $Subject; ?>">
				    </div>
				  </div>
				  
				   <div class="form-group row">
				    <label for="email_heading" class="col-sm-2 col-form-label"><?php echo $__email_heading ;?></label>
				    <div class="col-sm-7">
				      <input type="text" class="form-control" name="email_heading" id="email_heading" placeholder="New Order: #{12345}" value="<?php echo $email_heading; ?>">
				    </div>
				  </div>
				  
				
				 <div class="form-group row">
				    <label for="addtional_content" class="col-sm-2 col-form-label"><?php echo $__additional_content ;?></label>
				    <div class="col-sm-7">
				      <textarea class="form-control" rows="4" cols="40" name="addtional_content" id="addtional_content" placeholder="Addtional Content"><?php echo $addtional_content; ?></textarea> 
				    </div>
				  </div>
				</div>
				</form>

            </div><!-- row -->
          </div><!-- col -->
          
         

        </div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->   