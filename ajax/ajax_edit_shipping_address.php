<?php
extract($_REQUEST);

include '../head/jackus.php';

	if($_GET['type'] == 'getaddress_info') {
		
		$cardid = trim($_POST['cardid']);
		$customer_id = trim($_POST['customer_id']);
		//echo "SELECT COUNT(*) AS COUNT FROM js_customer AS CUS, js_shop_order AS SHOP WHERE SHOP.od_userid = CUS.user_id and CUS.customeremail = '$order_EMAIL' and SHOP.od_id ='$order_record' ";
		$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_shipping_address` where deleted = '0' and `customerID`='$customer_id' and Id=$cardid") or die("Unable to get records:".sqlERROR_LABEL());			
		$check_record_availabity = sqlNUMOFROW_LABEL($list_datas);	
		if($check_record_availabity !=0){
			while($row_ship = sqlFETCHARRAY_LABEL($list_datas)){
			  $card_id = $row_ship["Id"];
			  $ship_fname_edit = $row_ship["ship_fname"];
			  $ship_lname_edit = $row_ship["ship_lname"];
			  $ship_company_edit = $row_ship["ship_company"];
			  $ship_country_edit = $row_ship["ship_country"];
			  $ship_street1_edit = $row_ship["ship_street1"];
			  $ship_street2_edit = $row_ship["ship_street2"];
			  $ship_city_edit = $row_ship["ship_city"];
			  $ship_state_edit = $row_ship["ship_state"];
			  $ship_pin_edit = $row_ship["ship_pin"];
			  $ship_phone = $row_ship["ship_phone"];
			  ?>		
			<form method='post' data-parsley-validate>
				<div class="row">
					<div class="form-group col-6" >	
						<label for="ship_fname">First Name <span class="text-danger">*</span></label>									 
						<!--<input type="text" class="form-control" id="ship_fname" name="ship_fname" value="<?php //echo $ship_fname_edit ?>" required>-->
						<input type="text" class="form-control" id="ship_fname" name="ship_fname" value="<?php echo $ship_fname_edit ?>" required data-parsley-trigger="keyup" autocomplete="off" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" data-parsley-whitespace="trim" autocomplete="off">
					</div>
					<div class="form-group col-6" >	
						<label for="ship_lname">Last Name</label>									 
						<input type="text" class="form-control" id="ship_lname" name="ship_lname" value="<?php echo $ship_lname_edit ?>" autocomplete="off" data-parsley-trigger="keyup" autocomplete="off" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" data-parsley-whitespace="trim">
					</div>
					<div class="form-group col-6" >	
						<label for="ship_street1">Address #1 <span class="text-danger">*</span></label>									 
						<input type="text" class="form-control" id="ship_street" name="ship_street1" value="<?php echo $ship_street1_edit ?>" required autocomplete="off" data-parsley-whitespace="trim" data-parsley-trigger="keyup">
					</div>
					<div class="form-group col-6" >	
						<label for="ship_street2">Address #2</label>									 
						<input type="text" class="form-control" id="ship_street2" name="ship_street2" value="<?php echo $ship_street2_edit ?>" autocomplete="off" data-parsley-whitespace="trim" data-parsley-trigger="keyup">
					</div>
					<div class="form-group col-6" >	
						<label for="ship_city">City <span class="text-danger">*</span></label>									 
						<input type="text" class="form-control" id="ship_city" name="ship_city" value="<?php echo $ship_city_edit ?>" required autocomplete="off" data-parsley-whitespace="trim" data-parsley-trigger="keyup">
					</div>
					<div class="form-group col-6" >	
						<label for="ship_state">State <span class="text-danger">*</span></label>									 
						<input type="text" class="form-control" id="ship_state" name="ship_state" value="<?php echo $ship_state_edit ?>" required autocomplete="off" data-parsley-whitespace="trim" data-parsley-trigger="keyup">
					</div>
					<div class="form-group col-6" >	
						<label for="ship_country">Country <span class="text-danger">*</span></label>									 
						<input type="text" class="form-control" id="ship_country" name="ship_country" value="<?php echo $ship_country_edit ?>" required autocomplete="off" data-parsley-whitespace="trim" data-parsley-trigger="keyup">
					</div>
										<div class="form-group col-6" >	
						<label for="ship_phone">Mobile Number<span class="text-danger">*</span></label>									 
						<input type="text" class="form-control" id="ship_phone" name="ship_phone" value="<?php echo $ship_phone ?>" required maxlength='10' autocomplete="off">
					</div>
					<div class="form-group col-6" >	
						<label for="ship_pin">Pin Code <span class="text-danger">*</span></label>									 
						<input type="text" class="form-control" id="ship_pin" name="ship_pin" value="<?php echo $ship_pin_edit ?>" required maxlength='6' autocomplete="off">
					</div>
				</div>
					<input type="hidden" name="card_id" value="<?php echo $card_id;?>"/>
					   <button type="submit" class="btn button btn-outline-primary-2 col-12" name="editshiping_address" value="edit_shiping_address">Save</button>			  
					   
			</form>
			  <?php
			}
		}
	}
?>
