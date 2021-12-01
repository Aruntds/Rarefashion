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

//UPDATE Operation
if( $save == "update" && $hidden_id != '') {

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
	$existing_staff_username = $_REQUEST['existing_staff_username'];  //exisiting username
	$staff_username = $validation_globalclass->sanitize(strtolower($_REQUEST['staff_username']));  //new username
	$staff_password = $validation_globalclass->sanitize($_REQUEST['staff_password']);
	$staff_userpassword = $_REQUEST['staff_userpassword'];
	$staff_aadhar = $validation_globalclass->sanitize(ucwords($_REQUEST['staff_aadhar']));
	$staff_pf = $validation_globalclass->sanitize(ucwords($_REQUEST['staff_pf']));
	$staff_pan = $validation_globalclass->sanitize(ucwords($_REQUEST['staff_pan']));
	$staff_proof = $validation_globalclass->sanitize(ucwords($_REQUEST['staff_proof']));
	$staff_profile = $validation_globalclass->sanitize(ucwords($_REQUEST['staff_profile']));
	
	$bankname = $validation_globalclass->sanitize(ucwords($_REQUEST['staff_bankdetails_bank']));
	$branchname = $validation_globalclass->sanitize(ucwords($_REQUEST['staff_bankdetails_bank_branch']));
	$accountnumber = $validation_globalclass->sanitize(ucwords($_REQUEST['staff_bankdetails_bank_ac']));
	$neftcode = $validation_globalclass->sanitize(ucwords($_REQUEST['staff_bankdetails_bank_neft']));
	$staff_altemail = $validation_globalclass->sanitize(ucwords($_REQUEST['staff_altemail']));

	$enc_pwd = PwdHash($staff_password);
	
	//echo $existing_staff_username; exit();
	$staff_comments = $validation_globalclass->sanitize(ucwords($_REQUEST['staff_comments']));
	$status = $_REQUEST['status']; //value='on' == 1 || value='' == 0
	if($status == 'on') { $status = '1'; } else { $status = '0'; }
	if($staff_userpassword == 'on') { $staff_userpassword = '1'; } else { $staff_userpassword = '0'; }
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
        			if($old_staffprofile != '') {					
                		//remove_oldimage before updating
                		$oldimage_path = $media_path.$old_staffprofile;
                		unlink($oldimage_path);
                	}
        	   }
    	    }
        }
    } else {
    	$staff_profile = $old_staffprofile;
    }
    
    //check if staff username exist when username is updated
    if($existing_staff_username != $staff_username) {
	    $exist_username = CHECK_USERNAME($staff_username,'username','');	
    } else {
        $exist_username = '0';
    }

	if($exist_username == '0'){
	    
    	//Insert query
    	if($staff_userpassword == '1' && $staff_password != '' && $staff_username != ''){
    		$arrFields=array('`staff_code`','`staffroleid`','`staff_fname`','`staff_lname`','`staff_email`','`staff_mobile`','`staff_gender`','`staff_address1`','`staff_address2`','`staff_postalcode`','`staff_state`','`staff_city`','`staff_country`','`staff_userpassword`','`staff_username`','`staff_password`','`staff_aadhar`','`staff_pf`','`staff_pan`','`staff_proof`','`staff_profile`','`staff_comments`','`staff_bankdetails_bank`','`staff_bankdetails_bank_branch`','`staff_bankdetails_bank_ac`','`staff_bankdetails_bank_neft`','`staff_altemail`','`createdby`','`status`');
    
    		$arrValues=array("$staff_code","$staffroleid","$first_name","$last_name","$staff_email","$staff_mobile","$staff_gender","$address1","$address2","$postal_code","$state","$city","$staff_country","$staff_userpassword","$staff_username","$enc_pwd","$staff_aadhar","$staff_pf","$staff_pan","$staff_proof","$staff_profile","$staff_comments","$staff_bankdetails_bank","$staff_bankdetails_bank_branch","$staff_bankdetails_bank_ac","$staff_bankdetails_bank_neft","$staff_altemail","$logged_user_id","$status");
    	} else{
        	$arrFields=array('`staff_code`','`staffroleid`','`staff_fname`','`staff_lname`','`staff_email`','`staff_mobile`','`staff_gender`','`staff_address1`','`staff_address2`','`staff_postalcode`','`staff_state`','`staff_city`','`staff_country`','`staff_username`','`staff_aadhar`','`staff_pf`','`staff_pan`','`staff_proof`','`staff_profile`','`staff_comments`','`staff_bankdetails_bank`','`staff_bankdetails_bank_branch`','`staff_bankdetails_bank_ac`','`staff_bankdetails_bank_neft`','`staff_altemail`','`createdby`','`status`');
        
        	$arrValues=array("$staff_code","$staffroleid","$first_name","$last_name","$staff_email","$staff_mobile","$staff_gender","$address1","$address2","$postal_code","$state","$city","$staff_country","$staff_username","$staff_aadhar","$staff_pf","$staff_pan","$staff_proof","$staff_profile","$staff_comments","$staff_bankdetails_bank","$staff_bankdetails_bank_branch","$staff_bankdetails_bank_ac","$staff_bankdetails_bank_neft","$staff_altemail","$logged_user_id","$status");
    	}
    	
		$sqlWhere= "staff_id=$hidden_id";

		if(sqlACTIONS("UPDATE","js_staff",$arrFields,$arrValues, $sqlWhere)) {
			echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
			 $list_users = sqlQUERY_LABEL("SELECT * FROM `js_users` where deleted = '0' and `staff_id`='$hidden_id'") or die("Unable to get records:".sqlERROR_LABEL());		
			$check_record = sqlNUMOFROW_LABEL($list_users);
			if($staffroleid != $old_staffroleid && $check_record > '0'){
				$arrFields=array('`roleID`');
				$arrValues=array("$staffroleid");
				$sqlwhere = "staff_id='$hidden_id'";
				if(sqlACTIONS("UPDATE","js_users",$arrFields,$arrValues,$sqlwhere)) { }
			}
			
			if($status == '0' && $check_record > '0'){
				$arrFields=array('`userbanned`');

				$arrValues=array("1");
				$sqlwhere = "staff_id='$hidden_id'";
				if(sqlACTIONS("UPDATE","js_users",$arrFields,$arrValues,$sqlwhere)) { }
			}elseif($check_record > '0'){
				$arrFields=array('`userbanned`');

				$arrValues=array("0");
				$sqlwhere = "staff_id='$hidden_id'";
				if(sqlACTIONS("UPDATE","js_users",$arrFields,$arrValues,$sqlwhere)) { }
			}
				
			 if($staff_userpassword == '1' && $staff_password != '' && $staff_username != ''){
				if($status == '0'){
					$userbanned  = 1;
				}
				$token = md5($enc_pwd);
				if($check_record == '0'){
					$arrFields=array('`staff_id`','`usertoken`','`user_phone`','`username`','`useremail`','`password`','`roleID`','`userapproved`','`createdby`','`status`','`userbanned`');

					$arrValues=array("$hidden_id","$token","$staff_mobile","$staff_username","$staff_email","$enc_pwd","$staffroleid","1","$logged_user_id","1","$userbanned");
					
					if(sqlACTIONS("INSERT","js_users",$arrFields,$arrValues,'')) {
					}
				} else {
					$arrFields=array('`username`','`usertoken`','`user_phone`','`useremail`','`password`','`roleID`','`userbanned`');

					$arrValues=array("$staff_username","$token","$staff_mobile","$staff_email","$enc_pwd","$staffroleid","$userbanned");
					$sqlwhere = "staff_id='$hidden_id'";
					if(sqlACTIONS("UPDATE","js_users",$arrFields,$arrValues,$sqlwhere)) {
					}
				}
			 }
			 
			 //updating username alone
			 if($existing_staff_username != $staff_username) {
					$arrFields=array('`username`','`roleID`');

					$arrValues=array("$staff_username","$staffroleid");
					$sqlwhere = "staff_id='$hidden_id'";
					if(sqlACTIONS("UPDATE","js_users",$arrFields,$arrValues,$sqlwhere)) {
					}			    
			 }
			 
			?>
			<script type="text/javascript">window.location = 'staff.php?route=preview&formtype=preview&id=<?php echo $hidden_id; ?>&code=1' </script>
			<?php
				
			exit();

		} else {

			$err[] =  "Unable to Insert Record"; 

		}
		
	} else {
	  
	    $err[] =  "- User Name Already Exists";
	
	}	
}

if($route == 'edit' && $id != '') {
	//echo "SELECT * FROM `js_staff` where deleted = '0' and `staff_id`='$id'";exit();
	$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_staff` where deleted = '0' and `staff_id`='$id'") or die("Unable to get records:".sqlERROR_LABEL());		
	$check_record_availabity = sqlNUMOFROW_LABEL($list_datas);			

	while($row = sqlFETCHARRAY_LABEL($list_datas)){
	  $staff_id = $row["staff_id"];
	  $staff_code = $row["staff_code"];
	  $first_name = $row["staff_fname"];
	  $last_name = $row["staff_lname"];
	  $staff_email = strtolower($row["staff_email"]);
	  $staff_mobile = $row["staff_mobile"];
	  $staff_gender = $row["staff_gender"];
	  $address1 = $row["staff_address1"];
	  $address2 = $row["staff_address2"];
	  $postal_code = $row["staff_postalcode"];
	  $state = $row["staff_state"];
	  $city = $row["staff_city"];
	  $staff_country = $row["staff_country"];
	  $staffroleid = $row["staffroleid"];
	  $status = $row["status"];
	  $staff_userpassword = $row["staff_userpassword"];
	  $staff_username = strtolower($row["staff_username"]);
	  $staff_password = $row["staff_password"];
	  $staff_aadhar = $row["staff_aadhar"];
	  $staff_pf = $row["staff_pf"];
	  $staff_pan = $row["staff_pan"];
	  $staff_proof = $row["staff_proof"];
	  $staff_profile = $row["staff_profile"];
	  $staff_comments = $row["staff_comments"];
	  $staff_bankdetails_bank = $row["staff_bankdetails_bank"];
	  $staff_bankdetails_bank_branch = $row["staff_bankdetails_bank_branch"];
	  $staff_bankdetails_bank_ac = $row["staff_bankdetails_bank_ac"];
	  $staff_bankdetails_bank_neft = $row["staff_bankdetails_bank_neft"];
	  $staff_altemail = $row["staff_altemail"];
	}
	//echo $first_name;exit();
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
						  <button type="submit" name="save" value="update" class="btn btn-warning"><?php echo $__update; ?></button>
							<input type="hidden" name="hidden_id" value="<?php echo $id; ?>" />
							<input type="hidden" name="existing_staff_email" id="existing_staff_email" value="<?php echo $staff_email; ?>">
							<input type="hidden" name="existing_staff_mobile" id="existing_staff_mobile" value="<?php echo $staff_mobile; ?>">
							<input type="hidden" name="existing_staff_username" id="existing_staff_username" value="<?php echo $staff_username; ?>">
						
						 </div>
					  </div>
					  <!-- BASIC Starting -->
				<div id="basic">
				 <div class="divider-text">Basic Info</div>
				  <div class="form-group row">
				  	<label for="status" class="col-sm-3 col-form-label"><?php echo $__active ?></label>
					<div class="col-sm-7">
						<div class="custom-control custom-switch mg-t-10">
						  <input type="checkbox" class="custom-control-input" name="status" id="status" <?php if($status == '1') { echo 'checked=""'; } ?>>
						  <label class="custom-control-label" for="status">Yes</label>
						</div>
					</div>
				  </div>

				  <div class="form-group row" id="staff_code_individual1">
					<label for="staff_code" class="col-sm-3 control-label">Staff CODE</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" name="staff_code" id="staff_code" value="<?php if($id ==""){ echo getnewSTAFF('staff',$staff_code); } else{ echo $staff_code;} ?>" required data-parsley-trigger="keyup" data-parsley-pattern="^[a-zA-Z0-9 ,-/]*$" data-parsley-whitespace="trim">
					</div>
				</div>
				
				<div class="form-group row">
				  	<label for="staffroleid" class="col-sm-3 col-form-label">Staff Role</label>
					<div class="col-sm-7">
						 <input type="hidden" name="old_staffroleid" value="<?php echo $staffroleid; ?>">
						  <select name="staffroleid" id="staffroleid" class="custom-select" required data-parsley-trigger="keyup">						  
						  <?php echo getrole($staffroleid, 'select'); ?>
						  
                          </select>
					
					</div>
				  </div>
				  
					<div class="form-group row" id="staff_code_individual1">
						<label for="first-name" class="col-sm-3 control-label">First Name</label>
						<div class="col-sm-7">
							<input type="text" class="form-control"
							name="first_name" id="first_name"  value="<?php echo $first_name ?>" placeholder="First Name" required data-parsley-pattern="^[a-zA-Z ]+$" data-parsley-trigger="keyup" data-parsley-whitespace="trim" autocomplete="off">
						</div>
					</div>
					<div class="form-group row" id="staff_code_individual2">
						<label for="last-name" class="col-sm-3 control-label">Last Name</label>
						<div class="col-sm-7">
							<input type="text" class="form-control" value="<?php echo $last_name ?>" name="last_name" id="last_name" placeholder="Last Name" data-parsley-pattern="^[a-zA-Z ]+$" data-parsley-trigger="keyup" data-parsley-whitespace="trim" autocomplete="off">
						</div>
					</div>
				<!-- end of staff type section -->
				
				<div class="form-group row">
					<label for="staff-email" class="col-sm-3 control-label">Email</label>
					<div class="col-sm-7">
						<input type="email" class="form-control text-lowercase" onchange="generateusername()"  data-parsley-checkemail data-parsley-checkemail-message="Email Address already Exists" value="<?php echo $staff_email ?>" name="staff_email" id="staff_email" placeholder="Email" required data-parsley-type="Email" data-parsley-trigger="keyup" data-parsley-whitespace="trim" data-parsley-checkemail data-parsley-checkemail-message="Email Address already Exists" autocomplete="off">
					
					<input type="hidden" name="existing_staff_email" id="existing_staff_email" value="<?php echo $staff_email; ?>">
					</div>
				</div>
				
				<div class="form-group row">
						<label for="staff-mobile" class="col-sm-3 control-label">Mobile Number</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" value="<?php echo $staff_mobile ?>" name="staff_mobile" id="staff_mobile" placeholder="Mobile Number" requireddata-parsley-checkmobile data-parsley-checkmobile-message="Mobile Number already Exists"  data-parsley-type="number" data-parsley-trigger="keyup" maxlength="10" data-parsley-whitespace="trim" data-parsley-checkmobile data-parsley-checkmobile-message="Mobile Number already Exists" autocomplete="off">
					<input type="hidden" name="existing_staff_mobile" id="existing_staff_mobile" value="<?php echo $staff_mobile; ?>">
					</div>
				</div>
													
				<div class="form-group row">
				    <label for="staff_gender" class="col-sm-3 col-form-label">Gender</label>
				    <div class="col-sm-7">
					<select name="staff_gender" id="staff_gender" class="custom-select">
						  <?php echo getGENDERTYPE($staff_gender, 'select'); ?>  
                    </select>			
				  </div>
				</div>

			   <div class="form-group row">
					<label for="address1" class="col-sm-3 control-label">Address (Line 1)</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" value="<?php echo $address1 ?>" name="address1" id="address1" placeholder="Address" data-parsley-whitespace="trim" autocomplete="off">
					</div>
				</div>
				<div class="form-group row">
					<label for="address2" class="col-sm-3 control-label">Address (Line 2)</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" value="<?php echo $address2 ?>" name="address2" id="address2" placeholder="Address" data-parsley-whitespace="trim" autocomplete="off">
					</div>
				</div>
				<div class="form-group row">
					<label for="postal-code" class="col-sm-3 control-label">Postal Code</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" value="<?php echo $postal_code ?>" name="postal_code" id="postal_code" maxlength="6" placeholder="Postal Code" data-parsley-trigger="keyup" data-parsley-type="number" data-parsley-whitespace="trim" autocomplete="off">
					</div>
				</div>
				</div>
            

			</div>
                     <div class="form-group row">
				  	<label for="staff_userpassword" class="col-sm-3 col-form-label">Staff Name & Password</label>
					<div class="col-sm-7">
						<div class="custom-control custom-switch">
						  <input type="checkbox" class="custom-control-input" name="staff_userpassword" id="staff_userpassword" onchange="show_restriction();" <?php if($staff_userpassword == '1') { echo 'checked';} ?>>
						  <label class="custom-control-label" for="staff_userpassword">Yes</label>
						</div>
					</div>
				  </div>
                  <?php
				  if($staff_userpassword == '0') {
					  $div_style = "display:none";
				  }else{
					  $div_style = "";
				  }
				  ?>
                  <div style="<?php echo $div_style;?>" id="show_resdiv">
                  <div class="form-group row">
				    <label for="staff_username" class="col-sm-3 col-form-label">Staff Username</label>
				    <div class="col-sm-7">
				      <input type="text" class="form-control text-lowercase" name="staff_username" id="staff_username" placeholder="Enter Staff Username" data-parsley-error-message="Please Enter Correct Username" value="<?php echo $staff_username ?>">
				    </div>
				  </div>
                  <div class="form-group row">
				    <label for="staff_password" class="col-sm-3 col-form-label">Staff Password<br><small class="tx-danger">Minimum 5 characters</small></label>
				    <div class="col-sm-7">
				      <input type="password" class="form-control" name="staff_password" id="staff_password" placeholder="Enter Staff Password" data-parsley-minlength="5" data-parsley-error-message="Please Enter Correct Password" autocomplete="off">
				    </div>
				  </div>
                  </div>

						 <!-- End of BASIC -->
					  
				   </form>
				</div>
				
			 </div>
			 <!-- col -->
		  </div>
		  <!-- row -->
	    </div>
	   <!-- container -->
	</div>
	<!-- content -->
