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
	
	
	if($confirm_pwd == $customer_pwd){
			$pwd = PwdHash($customer_pwd,substr('',0,9));

			$arrFields=array('`username`','`useremail`','`user_phone`','`roleID`','`password`','`userapproved`','`status`');

			$arrValues=array("$customerfirst","$customeremail","$customerphone","2","$pwd","1","1");

			if(sqlACTIONS("INSERT","js_users",$arrFields,$arrValues, $sqlWhere)){
			$id = sqlINSERTID_LABEL();
			
		//Insert Query
		$arrFields=array('`user_id`','`referral_code`','`reference_code`','`customerfirst`','`customerlast`','`customeremail`','`customerdob`','`customergender`','`customerphone`','`customeraddress1`','`customeraddress2`','`customercity`','`customerpincode`','`customerstate`','`customercountry`','`status`','`createdby`');

		$arrValues=array("$id","$referral_code","$reference_code","$customerfirst","$customerlast","$customeremail","$datepicker3","$customergender","$customerphone","$customeraddress1","$customeraddress2","$customercity","$customerpin","$customerstate","$customercountry","1","$logged_user_id");

		if(sqlACTIONS("INSERT","js_customer",$arrFields,$arrValues,'')) {
			
			echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";

			if( $save == "save"	) {
				?>
				<script type="text/javascript">window.location = 'customer.php?route=add&code=1' </script>
				<?php
				//header("Location:category.php?route=add&code=1");
			} else {
				?>
				<script type="text/javascript">window.location = 'customer.php?code=1' </script>
				<?php
				//header("Location:category.php?code=1");
			}

			exit();

		} else {

			$err[] =  "Unable to Insert Record"; 

		}
			}
	}else{
				$err[] =  "Passwords are not matched"; 
	
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
				      <button type="submit" name="save" value="save" class="btn btn-success">Save</button>
				      <button type="submit" name="save_close" value="save_close" class="btn btn-success">Save & Close</button>
				    </div>
				  </div>

				<!-- BASIC Starting -->
				<div id="basic">
				  <div class="divider-text">Basic Info</div>
                  <div class="form-group row">
				  	<label for="status" class="col-sm-2 col-form-label">Active</label>
					<div class="col-sm-7">
						<div class="custom-control custom-switch">
						  <input type="checkbox" class="custom-control-input" name="status" id="status" checked="">
						  <label class="custom-control-label" for="status">Yes</label>
						</div>
					</div>
				  </div>
                  
				 <!--<div class="form-group row">
				  	<label for="customergroup" class="col-sm-2 col-form-label">Group<span class="tx-danger"></span></label>
					<div class="col-sm-7">
						
						  <select name="customergroup" id="customergroup" class="custom-select">						  
						  <?php echo getcustomerGROUP('', 'select'); ?>
						  </select>
					
					</div>
				  </div>

				  <div class="form-group row">
				    <label for="referral_code" class="col-sm-2 col-form-label">Referral Code<span class="tx-danger">*</span></label>
				    <div class="col-sm-7">
						 <input type="text" class="form-control" name="referral_code" id="referral_code" placeholder="Referral Code" required data-parsley-error-message="Please enter Referral Code" >				      
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="reference_code" class="col-sm-2 col-form-label">Reference Number<span class="tx-danger">*</span></label>
				    <div class="col-sm-7">
						 <input type="text" class="form-control" name="reference_code" id="reference_code" placeholder="Reference Number" required data-parsley-error-message="Please enter Reference Number" value="<?php echo $reference_code; ?>">				      
				    </div>
				  </div> -->
				  <div class="form-group row">
				    <label for="customerfirst" class="col-sm-2 col-form-label">First Name<span class="tx-danger">*</span></label>
				    <div class="col-sm-7">
						 <input type="text" class="form-control" name="customerfirst" id="customerfirst" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" placeholder=" first Name" required data-parsley-error-message="Please enter first name">				      
				    </div>
				  </div>

				  <div class="form-group row">
				    <label for="customerlast" class="col-sm-2 col-form-label">Last Name<span class="tx-danger">*</span></label>
				    <div class="col-sm-7">
				      <input type="text" class="form-control" name="customerlast" id="customerlast" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" placeholder="last Name" required data-parsley-error-message="Please enter last name">
				    </div>
				  </div>

				  <div class="form-group row">
				    <label for="customeremail" class="col-sm-2 col-form-label">Email<span class="tx-danger">*</span></label>
				    				    
				    <div class="col-sm-7">

						<input type="text" class="form-control" name="customeremail" id="customeremail" placeholder="Email" required data-parsley-error-message="Please enter email">

					</div>
				  </div>

				  <div class="form-group row">
				    <label for="datepicker3" class="col-sm-2 col-form-label">D.O.B</label>
				    <div class="col-sm-7">
                        <input type="text" class="form-control" name="datepicker3" id="datepicker3" placeholder="DD/MM/YYYY">				
				  </div>
				</div>
                
                <div class="form-group row">
				    <label for="customergender" class="col-sm-2 col-form-label">Gender</label>
				    <div class="col-sm-7">
                         <select name="customergender" id="customergender" class="custom-select">						  
						  <?php echo getGENDER($customergender, 'select'); ?>
						  </select>				
				  </div>
				</div>
                
                <div class="form-group row">
				    <label for="customerphone" class="col-sm-2 col-form-label">Phone</label>
				    <div class="col-sm-7">
                        <input type="text" class="form-control" name="customerphone" id="customerphone" placeholder="Phone"oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="10">				
				  </div>
				</div>
                
                <div class="form-group row">
				    <label for="customeraddress1" class="col-sm-2 col-form-label">Address 1</label>
				    <div class="col-sm-7">
                        <input type="text" class="form-control" name="customeraddress1" id="customeraddress1" placeholder="address1">				
				  </div>
				</div>
                
                <div class="form-group row">
				    <label for="customeraddress2" class="col-sm-2 col-form-label">Address 2</label>
				    <div class="col-sm-7">
                        <input type="text" class="form-control" name="customeraddress2" id="customeraddress2" placeholder="address2">				
				  </div>
				</div>
				
				 <div class="form-group row">
				    <label for="customercity" class="col-sm-2 col-form-label">City</label>
				    <div class="col-sm-7">
                        <input type="text" class="form-control" name="customercity" id="customercity" placeholder="City">				
				  </div>
				</div>
                
                <div class="form-group row">
				    <label for="customerpin" class="col-sm-2 col-form-label">Pin Code</label>
				    <div class="col-sm-7">
                        <input type="text" class="form-control" name="customerpin" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="6" id="customerpin" placeholder="Pin">				
				  </div>
				</div>
                
                <div class="form-group row">
				    <label for="customerstate" class="col-sm-2 col-form-label">State</label>
				    <div class="col-sm-7">
                        <input type="text" class="form-control" name="customerstate" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" id="customerstate" placeholder="State">				
				  </div>
				</div>
                
                <div class="form-group row">
				    <label for="customercountry" class="col-sm-2 col-form-label">Country</label>
				    <div class="col-sm-7">
                        <input type="text" class="form-control" name="customercountry" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" id="customercountry" placeholder="Country">				
				  </div>
				</div>
                 <div class="divider-text">Password</div>
                <div class="form-group row">
				    <label for="customer_pwd" class="col-sm-2 col-form-label">Password</label>
				    <div class="col-sm-7">
                        <input type="text" class="form-control" name="customer_pwd" id="customer_pwd" placeholder="Password">				
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