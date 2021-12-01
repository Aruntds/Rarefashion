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
if( $save == "update" && $hidden_ID != '') {

	$promocode_id = $validation_globalclass->sanitize($_REQUEST['promocode_id']);
	$promocode_name = $validation_globalclass->sanitize($_REQUEST['promocode_name']);
	$promocode_value = $validation_globalclass->sanitize($_REQUEST['promocode_value']);
	$promocode_type = $validation_globalclass->sanitize($_REQUEST['promocode_type']);
	$min_order_amount = $validation_globalclass->sanitize($_REQUEST['min_order_amount']);
	$max_discount_amt = $validation_globalclass->sanitize($_REQUEST['max_discount_amt']);
	$promocode_option = $validation_globalclass->sanitize($_REQUEST['promocode_option']);
	$promocode_expiry_date = $validation_globalclass->sanitize($_REQUEST['promocode_expiry_date']);
	$status = $validation_globalclass->sanitize($_REQUEST['status']);
	$promocode_expiry_date = dateformat_database($promocode_expiry_date);
	$status = $_REQUEST['status']; //value='on' == 1 || value='' == 0
	if($status == 'on') { $status = '1'; } else { $status = '0'; }

		//Insert query
		$arrFields=array('`promocode_name`','`promocode_code`','`promocode_value`','`promocode_type`','`min_order_amount`','`max_discount_amt`','`promocode_option`','`promocode_expiry_date`','`status`','`createdby`');

		$arrValues=array("$promocode_name","$promocode_code","$promocode_value","$promocode_type","$min_order_amount","$max_discount_amt","$promocode_option","$promocode_expiry_date","$status","$logged_user_id");

		$sqlWhere= "promocode_id = $hidden_ID";
		
		//echo $hidden_people_ID;exit();

		if(sqlACTIONS("UPDATE","js_promocode",$arrFields,$arrValues, $sqlWhere)) {
			
			echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
				?>
				<script type="text/javascript">window.location = 'promocode.php?code=2' </script>
				<?php
				//header("Location:category.php?code=1");
				
			exit();

		} else {

			$err[] =  "Unable to Insert Record"; 

		}
}

if($route == 'edit' && $id != '') {

	$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_promocode` where deleted = '0' and `promocode_id`='$id'") or die("Unable to get records:".mysql_error());			
	$check_record_availabity = sqlNUMOFROW_LABEL($list_datas);			

	while($row = sqlFETCHARRAY_LABEL($list_datas)){
	  $promocode_id = $row["promocode_id"];
	  $promocode_name = $row["promocode_name"];
	  $promocode_code = $row["promocode_code"];
	  $promocode_value = $row["promocode_value"];
	  $promocode_type = $row["promocode_type"];
	  $min_order_amount = $row["min_order_amount"];
	  $max_discount_amt = $row["max_discount_amt"];
	  $promocode_option = $row["promocode_option"];
	  $promocode_expiry_date = dateformat_datepicker($row["promocode_expiry_date"]);
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
				      <button type="submit" name="save" value="update" class="btn btn-warning"><?php echo $__update ?></button>
                      <input type="hidden" name="hidden_ID" value="<?php echo $promocode_id; ?>" />
				    </div>
				  </div>

				<!-- BASIC Starting -->
				<div id="basic">
				  <div class="divider-text">PROMOCODE INFO</div>
				  <div class="form-group row">
				  	<label for="status" class="col-sm-2 col-form-label"><?php echo $__active ?></label>
					<div class="col-sm-7">
						<div class="custom-control custom-switch">
						  <input type="checkbox" class="custom-control-input" name="status" id="status" <?php if($status == '1') { echo 'checked=""'; } ?>>
						  <label class="custom-control-label" for="status">Yes</label>
						</div>
					</div>
				  </div>

                   <div class="form-group row">
                    <label for="promocode_name" class="col-sm-3 col-form-label">Promocode Name <span class="tx-danger">*</span></label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" name="promocode_name" id="promocode_name" placeholder="Promocode Name" value="<?php echo $promocode_name;?>" required>
                    </div>
                  </div>
				  <div class="form-group row">
                    <label for="promocode_code" class="col-sm-3 col-form-label">Promocode Code <span class="tx-danger">*</span></label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" name="promocode_code" id="promocode_code" placeholder="Promocode Code" value="<?php echo $promocode_code;?>" required>
                    </div>
                  </div>
                  
                   <div class="form-group row">
				    <label for="promocode_value" class="col-sm-3 col-form-label">Promocode Value </label>
				    <div class="col-sm-7">
				    	<input type="text" class="form-control" name="promocode_value" id="promocode_value" placeholder="Promocode Value" value="<?php echo $promocode_value;?>" required>
				    </div>
				  </div>
				  
				  <div class="form-group row">
				    <label for="promocode_type" class="col-sm-3 col-form-label">Promocode Type</label>
				    <div class="col-sm-7">
				    	<select class="form-control custom-select" id="promocode_type" name="promocode_type">
						<option value="">--</option>
						<option value="1" <?php if($promocode_type == '1'){ echo 'selected'; } ?> onclick = "hidemindiscamount();">Fixed Rate</option>
						<option value="2" <?php if($promocode_type == '2'){ echo 'selected'; } ?> onclick = "showmindiscamount();">Percentage</option>
						</select>
				    </div>
				  </div>
				  
				  <div class="form-group row">
				    <label for="min_order_amount" class="col-sm-3 col-form-label">Minimum Order Amount <span class="tx-danger">*</span></label>
				    <div class="col-sm-7">
				    	<input type="text" class="form-control" name="min_order_amount" id="min_order_amount" placeholder="Minimum Order Amount" required data-parsley-pattern="^[0-9]*$" data-parsley-trigger="keyup" value="<?php echo $min_order_amount; ?>">
				    </div>
				  </div>
				  
				   <div class="form-group row" id="maximum_dis_amount">
				    <label for="max_discount_amt" class="col-sm-3 col-form-label">Maximum Discount Amount <span class="tx-danger">*</span></label>
				    <div class="col-sm-7">
				    	<input type="text" class="form-control" name="max_discount_amt" id="max_discount_amt" placeholder="Maximum Discount Amount" data-parsley-pattern="^[0-9]*$" data-parsley-trigger="keyup" value="<?php echo $max_discount_amt; ?>">
				    </div>
				  </div>
				  
				  <div class="form-group row">
				    <label for="promocode_option" class="col-sm-3 col-form-label">Option</label>
				    <div class="col-sm-7">
				    	<select class="form-control custom-select" id="promocode_option" name="promocode_option" value="">
						<option value="1" <?php if($promocode_option == '1'){ echo 'selected'; } ?>>Multiple Option</option>
						</select>
				    </div>
				  </div>
				  
				  <div class="form-group row">
				    <label for="promocode_expiry_date" class="col-sm-3 col-form-label">Promocode Expiry Date</label>
				    <div class="col-sm-7">
				    	<input type="text" class="form-control" name="promocode_expiry_date" id="promocode_expiry_date" placeholder="DD/MM/YYYY" value="<?php echo $promocode_expiry_date; ?>"required>
				    </div>
				  </div>

				  </div>

				</div>
				<!-- End of BASIC -->
	
				</form>

            </div><!-- row -->
          </div><!-- col -->
          
          <?php 
	          // $homeicon_sidebar_view_type='create';
	          // include viewpath('__categorysidebar.php'); 
          ?>

        </div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->   