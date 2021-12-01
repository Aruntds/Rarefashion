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
if( $save == "update" && $hidden_id != '') {

	$vendorname = $validation_globalclass->sanitize($_REQUEST['vendorname']);
	$vendor_nickname = $validation_globalclass->sanitize($_REQUEST['vendor_nickname']);
	$vendor_code = $validation_globalclass->sanitize(ucwords($_REQUEST['vendor_code']));
	$contactperson = $validation_globalclass->sanitize(ucwords($_REQUEST['contactperson']));
	$contactnumber = $validation_globalclass->sanitize(ucwords($_REQUEST['contactnumber']));
	$contactemail = $validation_globalclass->sanitize(ucwords($_REQUEST['contactemail']));
	$address = $validation_globalclass->sanitize(htmlspecialchars(ucwords($_REQUEST['address'])));
	$gstin = $validation_globalclass->sanitize(ucwords($_REQUEST['gstin']));
	$pan = $validation_globalclass->sanitize(ucwords($_REQUEST['pan']));
	$tan = $validation_globalclass->sanitize(ucwords($_REQUEST['tan']));
	$msg = $validation_globalclass->sanitize(ucwords($_REQUEST['msg']));
	$payment_terms = $validation_globalclass->sanitize(ucwords($_REQUEST['payment_terms']));
	$comments = $validation_globalclass->sanitize(ucwords($_REQUEST['comments']));
	$bankname = $validation_globalclass->sanitize(ucwords($_REQUEST['bankname']));
	$accountnumber = $validation_globalclass->sanitize(ucwords($_REQUEST['accountnumber']));
	$neftcode = $validation_globalclass->sanitize(ucwords($_REQUEST['neftcode']));
	//$vendorstatus = $validation_globalclass->sanitize(ucwords($_REQUEST['vendorstatus']));
    $address = htmlspecialchars($address);

	$status = $_REQUEST['status']; //value='on' == 1 || value='' == 0
	if($status == 'on') { $status = '1'; } else { $status = '0'; }


					//Insert query
					$arrFields=array('`vendor_name`','`vendor_nickname`','`vendor_code`','`vendor_contactperson`','`vendor_contactnumber`',
					'`vendor_contactemail`','`vendor_address`','`vendor_gst`','`vendor_pan`','`vendor_tan`','`vendor_msg`','`vendor_bank`','`vendor_bank_ac`','`vendor_bank_neft`','`vendor_payment_terms`','`vendor_comments`','`createdby`','`status`');

					$arrValues=array("$vendorname","$vendor_nickname","$vendor_code","$contactperson","$contactnumber","$contactemail","$address","$gstin","$pan","$tan","$msg","$bankname","$accountnumber","$neftcode","$payment_terms","$comments","$logged_user_id","$status");
					
					$sqlWhere= "vendor_id=$hidden_id";

					if(sqlACTIONS("UPDATE","js_vendor",$arrFields,$arrValues, $sqlWhere)) {
						
						echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";

						?>
						<script type="text/javascript">window.location = 'vendors.php?code=1' </script>
						<?php

						exit();

					} else {

						$err[] =  "Unable to Insert Record"; 


	}

}

if($route == 'edit' && $id != '') {

	$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_vendor` where deleted = '0' and `vendor_id`='$id'") or die("Unable to get records:".sqlERROR_LABEL());			
	$check_record_availabity = sqlNUMOFROW_LABEL($list_datas);			

	while($row = sqlFETCHARRAY_LABEL($list_datas)){
	  $vendor_id = $row["vendor_id"];
	  $vendor_name = $row["vendor_name"];
	  $vendor_nickname = $row["vendor_nickname"];
	  $vendor_code = $row["vendor_code"];
	  $vendor_contactperson = $row["vendor_contactperson"];
	  $vendor_contactnumber = $row["vendor_contactnumber"];
	  $vendor_contactemail = $row["vendor_contactemail"];
	  $vendor_address = $row["vendor_address"];
	  $vendor_gst = $row["vendor_gst"];
	  $vendor_pan = $row["vendor_pan"];
	  $vendor_tan = $row["vendor_tan"];
	  $vendor_msg = $row["vendor_msg"];
	  $vendor_bank = $row["vendor_bank"];
	  $vendor_bank_ac = $row["vendor_bank_ac"];
	  $vendor_bank_neft = $row["vendor_bank_neft"];
	  $vendor_payment_terms = $row["vendor_payment_terms"];
	  $vendor_comments = $row["vendor_comments"];
	  $status = $row["status"];

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
				      <button type="submit" name="save" value="update" class="btn btn-warning"><?php echo $__update ?></button>
                      <input type="hidden" name="hidden_id" value="<?php echo $id; ?>" />
				    </div>
				  </div>

				<!-- BASIC Starting -->
				<div id="basic">
				  <div class="divider-text"><?php echo $__hbasicinfo ?></div>
				  <div class="form-group row">
				  	<label for="status" class="col-sm-2 col-form-label"><?php echo $__active ?></label>
					<div class="col-sm-7">
						<div class="custom-control custom-switch">
						  
						  <input type="checkbox" class="custom-control-input" name="status" id="status" 
						 <?php if($status == '1') { echo 'checked=""'; } ?>>
						  <label class="custom-control-label" for="status">Yes</label>
						</div>
					</div>
				  </div>

				  <div class="form-group row">
				    <label for="vendorname" class="col-sm-2 col-form-label">Vendor Name<span class="tx-danger"> *</span></label>
				    <div class="col-sm-7">
				      <input type="text" class="form-control" name="vendorname" id="vendorname" placeholder="Vendor Name" required data-parsley-pattern="^[a-zA-Z ]+$" data-parsley-trigger="keyup" value="<?php echo $vendor_name ; ?>" autocomplete="off">
				    </div>
				  </div>

				  <div class="form-group row">
				    <label for="vendor_nickname" class="col-sm-2 col-form-label">Nick Name<span class="tx-danger"> *</span></label>
				    <div class="col-sm-7">
				      <input type="text" class="form-control" name="vendor_nickname" id="vendor_nickname" placeholder="Vendor Nick Name" required data-parsley-pattern="^[a-zA-Z ]+$" data-parsley-trigger="keyup" value="<?php echo $vendor_nickname ; ?>" autocomplete="off">
				    </div>
				  </div>
				  
				  <div class="form-group row">
				    <label for="vendor_code" class="col-sm-2 col-form-label">Vendor Code<span class="tx-danger"> *</span></label>
				    <div class="col-sm-7">
				    	 <input type="text" class="form-control" name="vendor_code" id="vendor_code"  placeholder="Vendor Code" required data-parsley-trigger="keyup" data-parsley-pattern="^[a-zA-Z0-9 ,-/]*$" value="<?php echo $vendor_code ; ?>" autocomplete="off">
				    </div>
				  </div>
				  
				  <div class="form-group row">
				    <label for="contactperson" class="col-sm-2 col-form-label">Contact Person</label>
				    <div class="col-sm-7">
				    	 <input type="text" class="form-control" name="contactperson" id="contactperson"  placeholder="Contact Person" data-parsley-trigger="keyup"value="<?php echo $vendor_contactperson ; ?>" autocomplete="off">
				    </div>
				  </div>
				  
				  <div class="form-group row">
				    <label for="contactnumber" class="col-sm-2 col-form-label">Contact Number</label>
				    <div class="col-sm-7">
				    	 <input type="text" class="form-control" name="contactnumber" id="contactnumber"  placeholder="Contact Number" data-parsley-type="number" data-parsley-trigger="keyup" maxlength="10" value="<?php echo $vendor_contactnumber; ?>" autocomplete="off">
				    </div>
				  </div>
				  
				  <div class="form-group row">
				    <label for="contactemail" class="col-sm-2 col-form-label">Contact Email</label>
				    <div class="col-sm-7">
				    	 <input type="text" class="form-control" name="contactemail" id="contactemail"  placeholder="Contact Email" data-parsley-type="email" data-parsley-trigger="keyup" value="<?php echo $vendor_contactemail; ?>" autocomplete="off">
				    </div>
				  </div>
				  
				  <div class="form-group row">
				    <label for="address" class="col-sm-2 col-form-label">Address</label>
				    <div class="col-sm-7">
				    	 <textarea type="text" class="form-control" name="address" id="address"  placeholder="Address"><?php echo $vendor_address ;?></textarea>	 
				    </div>
				  </div>
				  
				  <div class="form-group row">
				    <label for="gstin" class="col-sm-2 col-form-label">GSTIN
					<span class="mg-t-10 mg-md-t-0" style="float:right;">
						<a href="javascript:void(0);" data-toggle="modal" data-target=".bd-examples-modal-lg"><i class="fas fa-info-circle"></i> <small class="text-dark">GST FORMAT</small></a>
					</span>
					</label>
				    <div class="col-sm-7">
				    	 <input type="text" class="form-control text-uppercase" name="gstin" id="gstin"  placeholder="GSTIN" maxlength="15" data-parsley-type="alphanum" data-parsley-trigger="keyup" value="<?php echo $vendor_gst ;?>" autocomplete="off">
				    </div>
					<div class="modal fade bd-examples-modal-lg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-lg">
						<div class="modal-content">
						<img src="<?php echo BASEPATH; ?>/public/img/gstin_format.jpg">
						</div>
					  </div>
					</div>
				  </div>
				  
				  <div class="form-group row">
				    <label for="pan" class="col-sm-2 col-form-label">PAN
					<span class="mg-t-10 mg-md-t-0" style="float:right;">
						<a href="javascript:void(0);" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-info-circle"></i> <small class="text-dark">PAN FORMAT</small></a>
					</span>
					</label>
				    <div class="col-sm-7">
				    	 <input type="text" class="form-control text-uppercase" name="pan" id="pan"  placeholder="PAN No" data-parsley-trigger="keyup" data-parsley-pattern="[A-Za-z]{5}\d{4}[A-Za-z]{1}" value="<?php echo $vendor_pan ;?>" maxlength="10" autocomplete="off">
					<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-lg">
						<div class="modal-content">
						<img src="<?php echo BASEPATH; ?>/public/img/pan-card_format.png">
						</div>
					  </div>
					</div>	
					</div>
				  </div>
				  <div class="form-group row">
				    <label for="tan" class="col-sm-2 col-form-label">TAN No</label>
				    <div class="col-sm-7">
				    	 <input type="text" class="form-control text-uppercase" name="tan" id="tan" placeholder="TAN No" data-parsley-type="alphanum" data-parsley-trigger="keyup" value="<?php echo $vendor_tan ;?>" autocomplete="off">
				    </div>
				  </div>
				  
				  <div class="form-group row">
				    <label for="msg" class="col-sm-2 col-form-label">MSG No</label>
				    <div class="col-sm-7">
				    	 <input type="text" class="form-control text-uppercase" name="msg" id="msg" placeholder="MSG No" data-parsley-type="alphanum" data-parsley-trigger="keyup" value="<?php echo $vendor_msg ;?>" autocomplete="off">
				    </div>
				  </div>
				  
				  <div class="form-group row">
				    <label for="bankname" class="col-sm-2 col-form-label">Bank Name</label>
				    <div class="col-sm-7">
				    	 <input type="text" class="form-control" name="bankname" id="bankname"  placeholder="Bank Name" data-parsley-pattern="^[a-zA-Z ]+$" data-parsley-trigger="keyup" value="<?php echo $vendor_bank ;?>" autocomplete="off">
				    </div>
				  </div>
				  
				  <div class="form-group row">
				    <label for="accountnumber" class="col-sm-2 col-form-label">A/C Number</label>
				    <div class="col-sm-7">
				    	 <input type="text" class="form-control" name="accountnumber" id="accountnumber"  placeholder="A/C Number" data-parsley-type="number" data-parsley-trigger="keyup" value="<?php echo $vendor_bank_ac ;?>" autocomplete="off">
				    </div>
				  </div>
				  
				  <div class="form-group row">
				    <label for="neftcode" class="col-sm-2 col-form-label">NEFT Code</label>
				    <div class="col-sm-7">
				    	 <input type="text" class="form-control" name="neftcode" id="neftcode"  placeholder="NEFT Code" data-parsley-trigger="keyup" data-parsley-type="alphanum" value="<?php echo $vendor_bank_neft ;?>" autocomplete="off">
				    </div>
				  </div>

				  <div class="form-group row">
				    <label for="payment_terms" class="col-sm-2 col-form-label">Payment Terms</label>
				    <div class="col-sm-7">
				    	 <textarea type="text" class="form-control" name="payment_terms" id="payment_terms" placeholder="Payment Terms"><?php echo $vendor_payment_terms ;?></textarea>
				    </div>
				  </div>
				  
				  <div class="form-group row">
				    <label for="comments" class="col-sm-2 col-form-label">Comments</label>
				    <div class="col-sm-7">
				    	 <textarea type="text" class="form-control" name="comments" id="comments" placeholder="Comments"><?php echo $vendor_comments ;?></textarea>
				    </div>
				  </div>

				</div>
				<!-- End of BASIC -->

				</form>


            </div><!-- row -->
          </div><!-- col -->
          
          <?php 
	          //$vendor_sidebar_view_type='create';
	          //include viewpath('__vendorsidebar.php'); 
          ?>

        </div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->   