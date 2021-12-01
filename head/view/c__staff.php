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

	$staff_code = $validation_globalclass->sanitize($_REQUEST['staff_code']);
	$first_name = $validation_globalclass->sanitize(ucwords($_REQUEST['first_name']));
	$last_name = $validation_globalclass->sanitize(ucwords($_REQUEST['last_name']));
	$staff_email = $validation_globalclass->sanitize(strtolower($_REQUEST['staff_email']));
	$staff_mobile = $validation_globalclass->sanitize(ucwords($_REQUEST['staff_mobile']));
	$staff_gender = $validation_globalclass->sanitize(ucwords($_REQUEST['staff_gender']));
	$address1 = $validation_globalclass->sanitize(ucwords($_REQUEST['address1']));
	$address2 = $validation_globalclass->sanitize(ucwords($_REQUEST['address2']));
	$postal_code = $validation_globalclass->sanitize(ucwords($_REQUEST['postal_code']));
	$state = $validation_globalclass->sanitize(ucwords($_REQUEST['state']));
	$city = $validation_globalclass->sanitize(ucwords($_REQUEST['city']));
	$staff_country = $validation_globalclass->sanitize(ucwords($_REQUEST['staff_country']));
	$staffroleid = $validation_globalclass->sanitize(ucwords($_REQUEST['staffroleid']));

	$staff_aadhar = $validation_globalclass->sanitize(ucwords($_REQUEST['staff_aadhar']));
	$staff_pf = $validation_globalclass->sanitize(ucwords($_REQUEST['staff_pf']));
	$staff_pan = $validation_globalclass->sanitize(ucwords($_REQUEST['staff_pan']));
	$staff_proof = $validation_globalclass->sanitize(ucwords($_REQUEST['staff_proof']));
	$staff_profile = $validation_globalclass->sanitize(ucwords($_REQUEST['staff_profile']));
	$staff_comments = $validation_globalclass->sanitize(ucwords($_REQUEST['staff_comments']));
	$bankname = $validation_globalclass->sanitize(ucwords($_REQUEST['staff_bankdetails_bank']));
	$branchname = $validation_globalclass->sanitize(ucwords($_REQUEST['staff_bankdetails_bank_branch']));
	$accountnumber = $validation_globalclass->sanitize(ucwords($_REQUEST['staff_bankdetails_bank_ac']));
	$neftcode = $validation_globalclass->sanitize(ucwords($_REQUEST['staff_bankdetails_bank_neft']));
	$staff_altemail = $validation_globalclass->sanitize(ucwords($_REQUEST['staff_altemail']));

	$staff_userpassword = $_REQUEST['staff_userpassword'];
	$staff_username = $validation_globalclass->sanitize(strtolower($_REQUEST['staff_username']));
	$staff_password = $validation_globalclass->sanitize($_REQUEST['staff_password']);
	$staffside_email = $validation_globalclass->sanitize($_REQUEST['staffside_email']);
	$adminside_email = $validation_globalclass->sanitize($_REQUEST['adminside_email']);
	$status = $_REQUEST['status']; //value='on' == 1 || value='' == 0
	if($status == 'on') { $status = '1'; } else { $status = '0'; }
	if($staff_userpassword == 'on') { $staff_userpassword = '1';  } else { $staff_userpassword = '0'; }

		if($staffside_email == 'on') { $staffside_email = '1'; } else { $staffside_email = '0'; }
		if($adminside_email == 'on') { $adminside_email = '1'; } else { $adminside_email = '0'; }
		if($staff_userpassword == '1' && $staff_password != ''){
			$enc_pwd = PwdHash($staff_password);
		}

	$media_path = "uploads/staffprofile/";
	$valid_formats = array("jpg", "jpeg", "png", "gif");
	$media_name = $_FILES['staff_profile']['name'];
	$media_size = $_FILES['staff_profile']['size'];
	
		if(strlen($media_name))
	{


		list($txt, $ext) = explode(".", $media_name);
		if(in_array($ext,$valid_formats))
		{
		if($media_size<(1000*1000))
		{
	
			$staff_profile = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
			$tmp = $_FILES['staff_profile']['tmp_name'];

		if(move_uploaded_file($tmp, $media_path.$staff_profile)) 
		{
	   }
	}
}
}
	$exist_username = CHECK_USERNAME($staff_username,'username','');	
	if($exist_username == '0'){

		//Insert query 
		$arrFields=array('`staff_code`','`staffroleid`','`staff_fname`','`staff_lname`','`staff_email`','`staff_mobile`','`staff_gender`','`staff_address1`','`staff_address2`','`staff_postalcode`','`staff_state`','`staff_city`','`staff_country`','`staff_staffemail`','`staff_adminemail`','`staff_userpassword`','`staff_username`','`staff_password`','`staff_aadhar`','`staff_pf`','`staff_pan`','`staff_proof`','`staff_profile`','`staff_comments`','`staff_bankdetails_bank`','`staff_bankdetails_bank_branch`','`staff_bankdetails_bank_ac`','`staff_bankdetails_bank_neft`','`staff_altemail`','`createdby`','`status`');

		$arrValues=array("$staff_code","$staffroleid","$first_name","$last_name","$staff_email","$staff_mobile","$staff_gender","$address1","$address2","$postal_code","$state","$city","$staff_country","$staffside_email","$adminside_email","$staff_userpassword","$staff_username","$enc_pwd","$staff_aadhar","$staff_pf","$staff_pan","$staff_proof","$staff_profile","$staff_comments","$staff_bankdetails_bank","$staff_bankdetails_bank_branch","$staff_bankdetails_bank_ac","$staff_bankdetails_bank_neft","$staff_altemail","$logged_user_id","$status");
		
		if(sqlACTIONS("INSERT","js_staff",$arrFields,$arrValues,'')) {
			
			$staff_id = sqlINSERTID_LABEL();
			$token = md5($enc_pwd);

			 if($staff_userpassword == '1' && $staff_password != '' && $staff_username != ''){
				$arrFields=array('`staff_id`','`usertoken`','`user_phone`','`username`','`useremail`','`password`','`roleID`','`userapproved`','`createdby`','`status`');

				$arrValues=array("$staff_id","$token","$staff_mobile","$staff_username","$staff_email","$enc_pwd","$staffroleid","1","$logged_user_id","1");
				
				if(sqlACTIONS("INSERT","js_users",$arrFields,$arrValues,'')) {
				}
			 }
			 //notification message
			//notificationid,title,msg,user_id,status
			//$log_msg ="New Staff ".$first_name." added for role ".getrole($staffroleid, 'label');
			//$notification_insert = create_notification('7','Staff',$log_msg,$logged_user_id,'1');
			//create user if enable
			
			 
			echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
						
			if($save == 'save'){
				?>
				<script type="text/javascript">window.location = 'staff.php?route=preview&formtype=preview&id=<?php echo $staff_id; ?>&code=1' </script>
				<?php
				
			} else {
				?>
				<script type="text/javascript">window.location = 'staff.php?route=preview&formtype=preview&id=<?php echo $staff_id; ?>&code=1' </script>
				<?php
				
			}

			exit();

		} else {

			$err[] =  "Unable to Insert Record"; 

		}
		
	} else {
	  
	$err[] =  "User Name Already Exists";
	
  }		
}
?>

    <div class="content">
      <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="row">
          <div class="col-lg-10">
            <div class="mg-b-25">

				<form method="post" enctype="multipart/form-data" data-parsley-validate>
				  
				  <div id="stick-here"></div>
				  <div id="stickThis" class="form-group row mg-b-0">
					<div class="col-3 col-sm-6">
				  		<?php pageCANCEL($currentpage, $__cancel); ?>
				    </div>
				    <div class="col-9 col-sm-6 text-right">
				      <button type="submit" name="save" value="save" class="btn btn-success"><?php echo $__save ?></button>
				      <button type="submit" name="save_close" value="save_close" class="btn btn-success"><?php echo $__save_close ?></</button>
				    </div>
				  </div>

				<!-- BASIC Starting -->
				<div id="basic">
				  <div class="divider-text"><?php echo $__hbasicinfo ?></div>
				  <div class="form-group row">
				  	<label for="status" class="col-sm-3 col-form-label"><?php echo $__active ?></label>
					<div class="col-sm-7">
						<div class="custom-control custom-switch mg-t-10">
						  <input type="checkbox" class="custom-control-input" name="status" id="status" checked="">
						  <label class="custom-control-label" for="status">Yes</label>
						</div>
					</div>
				  </div>

				  <div class="form-group row" id="staff_code_individual1">
					<label for="staff_code" class="col-sm-3 control-label">Staff CODE<span class="tx-danger"> *</span></label>
					<div class="col-sm-7">

						<input type="text" class="form-control" name="staff_code" id="staff_code" required value="<?php if($id ==""){ echo getnewSTAFF('staff',$staff_code); } else{ echo $staff_code;} ?>" required data-parsley-trigger="keyup" data-parsley-pattern="^[a-zA-Z0-9 ,-/]*$" data-parsley-whitespace="trim" data-parsley-checkcode data-parsley-checkcode-message="Staff code already Exists">
					</div>
				</div>
		
					<div class="form-group row">
				  	<label for="staffroleid" class="col-sm-3 col-form-label">Staff Role<span class="tx-danger"> *</span></label>
					<div class="col-sm-7">
						  <select name="staffroleid" id="staffroleid" class="custom-select" required data-parsley-trigger="keyup">						  
						  <?php echo getrole('', 'select'); ?>
                          </select>
					</div>
				  </div>
				 
					<div class="form-group row" id="staff_code_individual1">
						<label for="first-name" class="col-sm-3 control-label">First Name<span class="tx-danger"> *</span></label>
						<div class="col-sm-7">
							<input type="text" class="form-control"
							name="first_name" id="first_name" placeholder="First Name" required data-parsley-pattern="^[a-zA-Z ]+$" data-parsley-trigger="keyup" data-parsley-whitespace="trim" autocomplete="off">
						</div>
					</div>
					<div class="form-group row" id="staff_code_individual2">
						<label for="last-name" class="col-sm-3 control-label">Last Name</label>
						<div class="col-sm-7">
							<input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" data-parsley-pattern="^[a-zA-Z ]+$" data-parsley-trigger="keyup" data-parsley-whitespace="trim" autocomplete="off">
						</div>
					</div>
				<!-- end of staff type section -->
				
				<div class="form-group row">
					<label for="staff_email" class="col-sm-3 control-label">Email <span class="tx-danger"> *</span></label>
					<div class="col-sm-7">
					<input type="email" class="form-control text-lowercase" onchange="generateusername()" data-parsley-checkemail data-parsley-checkemail-message="Email Address already Exists" value="<?php echo $staff_email ?>" name="staff_email" id="staff_email" placeholder="Email" required data-parsley-type="Email" data-parsley-trigger="keyup" data-parsley-whitespace="trim" data-parsley-checkemail data-parsley-checkemail-message="Email Address already Exists" autocomplete="off" required>
					<input type="hidden" name="existing_staff_email" id="existing_staff_email" value="">
					</div>
				</div>
				
				<div class="form-group row">
						<label for="staff-mobile" class="col-sm-3 control-label">Mobile Number<span class="tx-danger"> *</span></label>
					<div class="col-sm-7">
						<input type="text" class="form-control" name="staff_mobile" id="staff_mobile" placeholder="Mobile Number" required data-parsley-type="number" data-parsley-trigger="keyup" maxlength="10" data-parsley-whitespace="trim" data-parsley-checkmobile data-parsley-checkmobile-message="Mobile Number already Exists" autocomplete="off">
					<input type="hidden" name="existing_staff_mobile" id="existing_staff_mobile" value="">
					</div>
				</div>
				
				<div class="form-group row">
				    <label for="staff_gender" class="col-sm-3 col-form-label">Gender</label>
				    <div class="col-sm-7">
					<select name="staff_gender" id="staff_gender" class="custom-select">						  
						  <?php echo getGENDERTYPE('', 'select'); ?>
                          </select>			
				  </div>
				</div>

			   <div class="form-group row">
					<label for="address1" class="col-sm-3 control-label">Address (Line 1)</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" name="address1" id="address1" placeholder="Address" data-parsley-whitespace="trim" autocomplete="off">
					</div>
				</div>
				<div class="form-group row">
					<label for="address2" class="col-sm-3 control-label">Address (Line 2)</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" name="address2" id="address2" placeholder="Address" data-parsley-whitespace="trim" autocomplete="off">
					</div>
				</div>
				<div class="form-group row">
					<label for="postal-code" class="col-sm-3 control-label">Postal Code</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" name="postal_code" maxlength="6" id="postal_code" placeholder="Postal Code" data-parsley-trigger="keyup" data-parsley-type="number" data-parsley-whitespace="trim" autocomplete="off">
					</div>
				</div>
                  <div class="form-group row">
				  	<label for="staff_userpassword" class="col-sm-3 col-form-label">Staff Name & Password</label>
					<div class="col-sm-7">
						<div class="custom-control custom-switch">
						  <input type="checkbox" class="custom-control-input" name="staff_userpassword" id="staff_userpassword" onchange="show_restriction();">
						  <label class="custom-control-label" for="staff_userpassword">Yes</label>
						</div>
					</div>
				  </div>
                  
                  <div style="display:none;" id="show_resdiv">
                  <div class="form-group row">
				    <label for="staff_username" class="col-sm-3 col-form-label">Staff Username</label>
				    <div class="col-sm-7">
				      <input type="text" class="form-control text-lowercase" name="staff_username" id="staff_username" placeholder="Enter Staff Username" data-parsley-error-message="Please Enter Correct Username" readonly>
				    </div>
				  </div>
                  <div class="form-group row">
				    <label for="staff_password" class="col-sm-3 col-form-label">Staff Password<br><small class="tx-danger">Minimum 5 characters</small></label>
				    <div class="col-sm-7">
				      <input type="password" class="form-control" name="staff_password" id="staff_password" placeholder="Enter Staff Password" data-parsley-minlength="5" data-parsley-error-message="Please Enter Correct Password" autocomplete="off">
				    </div>
				  </div>
                  </div>
			</div>
				<!-- End of BASIC -->

		</form>

            </div><!-- row -->
          </div><!-- col -->
          
          <?php 
	          //$vendor_sidebar_view_type='create';
	         //include viewpath('__staffsidebar.php'); 
          ?>

        </div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->   