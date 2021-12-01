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
if( $save == "update" && $hidden_customerID != '') {

	//$customergroup = $validation_globalclass->sanitize($_REQUEST['customergroup']);

	$customerfirst = $validation_globalclass->sanitize(ucwords($_REQUEST['customerfirst']));
	$customerlast = $validation_globalclass->sanitize($_REQUEST['customerlast']);

	$customeremail = $validation_globalclass->sanitize(strtolower($_REQUEST['customeremail']));
	$datepicker3 = $validation_globalclass->sanitize($_REQUEST['datepicker3']);
	$customergender = $validation_globalclass->sanitize($_REQUEST['customergender']);
	$customerphone = $validation_globalclass->sanitize($_REQUEST['customerphone']);
	$customeraddress1 = $validation_globalclass->sanitize($_REQUEST['customeraddress1']);
	$customeraddress2 = $validation_globalclass->sanitize($_REQUEST['customeraddress2']);
	$customercity = $validation_globalclass->sanitize($_REQUEST['customercity']);
	$customerpin = $validation_globalclass->sanitize($_REQUEST['customerpin']);
	$customerstate = $validation_globalclass->sanitize($_REQUEST['customerstate']);
	$customercountry = $validation_globalclass->sanitize($_REQUEST['customercountry']);
   $datepicker3 = dateformat_database($datepicker3);

	$status = $_REQUEST['status']; //value='on' == 1 || value='' == 0
	if($status == 'on') { $status = '1'; } else { $status = '0'; }
	

		//Insert query
		//Insert Query
		$arrFields=array('`customerfirst`','`customerlast`','`customeremail`','`customerdob`','`customergender`','`customerphone`','`customeraddress1`','`customeraddress2`','`customercity`','`customerpincode`','`customerstate`','`customercountry`','`status`');

		$arrValues=array("$customerfirst","$customerlast","$customeremail","$datepicker3","$customergender","$customerphone","$customeraddress1","$customeraddress2","$customercity","$customerpin","$customerstate","$customercountry","1");

		$sqlWhere= "customerID=$hidden_customerID";

		if(sqlACTIONS("UPDATE","js_customer",$arrFields,$arrValues, $sqlWhere)) {
			
	
			if($new_pwd !='' && $confirm_pwd !='' && $current_pwd !=''){
				

			if($new_pwd == $confirm_pwd){
			
				// echo $new_pwd.'-'.$confirm_pwd.'-'.$current_pwd; exit();

				$pwd = PwdHash($current_pwd,substr('',0,9));
				$new_pwd = PwdHash($new_pwd,substr('',0,9));
				
					$query= "SELECT `password` FROM js_users WHERE `password` = '$pwd' AND `userID`='$hidden_user_id' and `deleted` = '0'";
	// echo $query; 
					$result = sqlQUERY_LABEL($query);
					$num = sqlNUMOFROW_LABEL($result);
				// echo $num,$user_email; exit();
					// Match row found with more than 1 results  - the user is authenticated. 
					if ( $num > 0 ) { 
						$arrFields=array('`password`');

						$arrValues=array("$new_pwd");

						$sqlWhere= "userID=$hidden_user_id";
						if(sqlACTIONS("UPDATE","js_users",$arrFields,$arrValues, $sqlWhere)) {
							
								echo '<script type="text/javascript">window.location = "customer.php?code=2" </script>'; 
								
								exit();
						}
				}else{
					$err[] =  "Old Password is Incorrect"; 

				}
			
				}else{
					$err[] =  "Passwords are mismatched"; 

				}
			}else{
			echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
				?>
				<script type="text/javascript">window.location = 'customer.php?code=2' </script>
				<?php
				//header("Location:category.php?code=1");
				
			exit();
			}
		} else {

			$err[] =  "Unable to Insert Record"; 

		}

	}



if($route == 'edit' && $id != '') {

	//`categoryID`, `categoryparentID`, `categoryname`, `categoryimage`, `categorydescrption`, `categoryseourl`, `categorymetatitle`, `categorymetakeywords`, `categorymetadescrption`, `categorydesignsettings`, `createdby`, `createdon`, `updatedon`, `status`, `deleted` FROM `js_category`
	$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_customer` where deleted = '0' and `customerID`='$id'") or die("Unable to get records:".mysql_error());			
	$check_record_availabity = sqlNUMOFROW_LABEL($list_datas);			

	while($row = sqlFETCHARRAY_LABEL($list_datas)){
	  $user_id = $row["user_id"];
	  $customerID = $row["customerID"];
	  //$referral_code = $row["referral_code"];
	  //$reference_code = $row["reference_code"];
	  //$customergroup = $row["customergroup"];
	  $customerfirst = $row["customerfirst"];
	  $customerlast = $row["customerlast"];
	  $customeremail = $row["customeremail"];
	  $customerdob = dateformat_datepicker($row["customerdob"]);
	  $customergender = $row["customergender"];
	  $customerphone = $row["customerphone"];
	  $customeraddress1 = $row["customeraddress1"];
	  $customeraddress2 = $row["customeraddress2"];
	  $customercity      = $row["customercity"];
	  $customerpincode = $row["customerpincode"];
	  $customerstate = $row["customerstate"];
	  $customercountry = $row["customercountry"];
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
                      <input type="hidden" name="hidden_customerID" value="<?php echo $customerID; ?>" />
                      <input type="hidden" name="hidden_user_id" value="<?php echo $user_id; ?>" />
				    </div>
				  </div>

				<!-- BASIC Starting -->
                
                <div id="basic">
				  <div class="divider-text">Basic Info</div>
                  <div class="form-group row">
				  	<label for="status" class="col-sm-2 col-form-label">Active</label>
					<div class="col-sm-7">
						<div class="custom-control custom-switch">
						  <input type="checkbox" class="custom-control-input" name="status" id="status" <?php if($status == '1') { echo 'checked=""'; } ?>>
						  <label class="custom-control-label" for="status">Yes</label>
						</div>
					</div>
				  </div>
                  
				  <!--<div class="form-group row">
				  	<label for="customergroup" class="col-sm-2 col-form-label">Group<span class="tx-danger">*</span></label>
					<div class="col-sm-7" readonly="">
						<select name="customergroup" id="customergroup" class="custom-select" disabled="true" style="background-color: #f5f6fa; color: #1b2e4b;">
						 					  
						  <?php echo getcustomerGROUP('', 'select'); ?>
						  </select>
					
					</div>
				  </div>
				  
				  <div class="form-group row">
				    <label for="referral_code" class="col-sm-2 col-form-label">Referral Code<span class="tx-danger">*</span></label>
				    <div class="col-sm-7">
						 <input type="text" class="form-control" name="referral_code" id="referral_code" placeholder="Please enter Referral Code" data-parsley-error-message="Please enter Referral Code" readonly="" value="<?php echo $referral_code; ?>">				      
				    </div>
				  </div>
				   <div class="form-group row">
				    <label for="reference_code" class="col-sm-2 col-form-label">Reference Number<span class="tx-danger">*</span></label>
				    <div class="col-sm-7">
						 <input type="text" class="form-control" name="reference_code" id="reference_code" placeholder="Please enter Reference Number"  data-parsley-error-message="Please enter Reference Number" readonly="" value="<?php echo $reference_code; ?>">				      
				    </div>
				  </div> -->
				  
				  <div class="form-group row">
				    <label for="customerfirst" class="col-sm-2 col-form-label">First Name<span class="tx-danger">*</span></label>
				    <div class="col-sm-7">
						 <input type="text" class="form-control" name="customerfirst" id="customerfirst" placeholder="Please enter first Name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" data-parsley-error-message="Please enter First name" required value="<?php echo $customerfirst; ?>">				      
				    </div>
				  </div>

				  <div class="form-group row">
				    <label for="customerlast" class="col-sm-2 col-form-label">Last Name<span class="tx-danger">*</span></label>
				    <div class="col-sm-7">
				      <input type="text" class="form-control" name="customerlast" id="customerlast" placeholder="Customer last Name" required onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" data-parsley-error-message="Please enter last name" value="<?php echo $customerlast; ?>">
				    </div>
				  </div>

				  <div class="form-group row">
				    <label for="customeremail" class="col-sm-2 col-form-label">Email<span class="tx-danger">*</span></label>
				    				    
				    <div class="col-sm-7">

						<input type="text" class="form-control" name="customeremail" id="customeremail" placeholder="Custome Email" required data-parsley-error-message="Please enter email" value="<?php echo $customeremail; ?>">

					</div>
				  </div>

				  <div class="form-group row">
				    <label for="datepicker3" class="col-sm-2 col-form-label">D.O.B</label>
				    <div class="col-sm-7">
                        <input type="text" class="form-control" name="datepicker3" id="datepicker3" placeholder="DD/MM/YY" value="<?php echo $customerdob; ?>">				
				  </div>
				</div>
                
                <div class="form-group row">
				    <label for="customergender" class="col-sm-2 col-form-label">Gender</label>
				    <div class="col-sm-7"> 
						  <select name="customergender" id="customergender" class="custom-select" required>
						  <?php echo getGENDER($customergender, 'select'); ?>
						  </select>				
				  </div>
				</div>
                
                <div class="form-group row">
				    <label for="customerphone" class="col-sm-2 col-form-label">Phone</label>
				    <div class="col-sm-7">
                        <input type="text" class="form-control" name="customerphone" id="customerphone" placeholder="Phone" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="10" value="<?php echo $customerphone; ?>">				
				  </div>
				</div>
                
                <div class="form-group row">
				    <label for="customeraddress1" class="col-sm-2 col-form-label">Address 1</label>
				    <div class="col-sm-7">
                        <input type="text" class="form-control" name="customeraddress1" id="customeraddress1" placeholder="address1" value="<?php echo $customeraddress1; ?>">				
				  </div>
				</div>
                
                <div class="form-group row">
				    <label for="customeraddress2" class="col-sm-2 col-form-label">Address 2</label>
				    <div class="col-sm-7">
                        <input type="text" class="form-control" name="customeraddress2" id="customeraddress2" placeholder="address2" value="<?php echo $customeraddress2; ?>">				
				  </div>
				</div>
                
				
				 <div class="form-group row">
				    <label for="customercity" class="col-sm-2 col-form-label">City</label>
				    <div class="col-sm-7">
                        <input type="text" class="form-control" name="customercity" id="customercity" placeholder="City" value="<?php echo $customercity;?>">				
				  </div>
				</div>
                
				
                <div class="form-group row">
				    <label for="customerpin" class="col-sm-2 col-form-label">Pin Code</label>
				    <div class="col-sm-7">
                        <input type="text" class="form-control" name="customerpin" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="6"  id="customerpin" placeholder="Pin Code" value="<?php echo $customerpincode; ?>">				
				  </div>
				</div>
                
                <div class="form-group row">
				    <label for="customerstate" class="col-sm-2 col-form-label">State</label>
				    <div class="col-sm-7">
                        <input type="text" class="form-control" name="customerstate" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" id="customerstate" placeholder="State" value="<?php echo $customerstate; ?>">				
				  </div>
				</div>
                
                <div class="form-group row">
				    <label for="customercountry" class="col-sm-2 col-form-label">Country</label>
				    <div class="col-sm-7">
                        <input type="text" class="form-control" name="customercountry" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" id="customercountry" placeholder="Country" value="<?php echo $customercountry; ?>">				
				  </div>
				</div>
				 <div class="divider-text"> Change Password</div>

				<div class="form-group row">
				    <label for="current_pwd" class="col-sm-2 col-form-label">Current Password</label>
				    <div class="col-sm-7">
                        <input type="text" class="form-control" name="current_pwd" id="current_pwd" placeholder="Current Password">				
				  </div>
				</div><div class="form-group row">
				    <label for="new_pwd" class="col-sm-2 col-form-label">New Password</label>
				    <div class="col-sm-7">
                        <input type="text" class="form-control" name="new_pwd" id="new_pwd" placeholder="Password">				
				  </div>
				</div>
                
                <div class="form-group row">
				    <label for="confirm_pwd" class="col-sm-2 col-form-label">Confirm Password</label>
				    <div class="col-sm-7">
                        <input type="text" class="form-control" name="confirm_pwd" id="confirm_pwd" placeholder="Confirm Password">				
				  </div>
				</div>
                
				<!-- End of BASIC -->

				</div>
                
				<!-- End of BASIC -->

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