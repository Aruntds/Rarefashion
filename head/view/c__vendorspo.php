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
if($action == 'import'){$po_session_id = session_id();}

//Insert Operation
if($save == "setting_purchaseorder") {
	

	$prdt_type = $validation_globalclass->sanitize($_REQUEST['prdt_type']);

	$vendor_id = $validation_globalclass->sanitize(ucwords($_REQUEST['vendor_id']));
	
	$vpo_date = $validation_globalclass->sanitize(ucwords($_REQUEST['vpo_date']));
	
	$vpo_reasonid = $validation_globalclass->sanitize(ucwords($_REQUEST['vpo_reasonid']));
	
	$sale_order_reason = $validation_globalclass->sanitize(ucwords($_REQUEST['sale_order_reason']));
	
	$stock_reason = $validation_globalclass->sanitize(ucwords($_REQUEST['stock_reason']));
	
	$vpo_date = dateformat_database($vpo_date);
	
		
    if($vpo_id == ''){
	$vpo_refno = getnewVENDORPOCOUNT($getvendor_porefno); 

	$grn_refno = getnewGENERATEGRNCOUNT($generate_grn_no); 

	//Insert query
	$arrFields=array('`vpo_no`','`generate_grn_no`','`prdttype_id`','`vendor_id`','`vpo_reasonid`','`vpo_sale_order_reason`','`vpo_stock_reason`','`vpo_date`','`createdby`','`status`');

	$arrValues=array("$vpo_refno","$grn_refno","$prdt_type","$vendor_id","$vpo_reasonid","$sale_order_reason","$stock_reason","$vpo_date","$logged_user_id","0");
	//print_r($arrValues);
	if(sqlACTIONS("INSERT","js_vendorpo",$arrFields,$arrValues,'')) {
	
		//log
		$vpo_id = sqlINSERTID_LABEL();	
		$log_description = "PO #$vpo_refno Created";
		//$createddate = date('Y-m-d H:i:s');
		$arrFields=array('`vpo_no`','`vpolog_desc`','`vpolog_createdby`');

		$arrValues=array("$vpo_refno","$log_description","$logged_user_id");
		//print_r($arrValues);
		//echo $vendorpo_id;exit();
		if(sqlACTIONS("INSERT","js_vendor_polog",$arrFields,$arrValues,'')) {
			//notification message
			//notificationid,title,msg,user_id,status
			//$log_msg ="New Vendor Po Created #".$vpo_refno;
			//$notification_insert = create_notification('4','Vendor PO',$log_msg,$logged_user_id,'1');
			?>
		<script type="text/javascript">window.location = 'vendorspo.php?route=add&id=<?php echo $vpo_id; ?>&code=1&switch=Y' </script>
		<?php
		}
		
	
} }else {
			
			$arrFields=array('`vendor_id`','`prdttype_id`','`vpo_date`','`vpo_reasonid`','`vpo_sale_order_reason`','`vpo_stock_reason`',);

			$arrValues=array("$vendor_id","$prdt_type","$vpo_date","$vpo_reasonid","$sale_order_reason","$stock_reason");
			$sqlWhere= "vpo_id='$vpo_id'";
			
			
			if(sqlACTIONS("UPDATE","js_vendorpo",$arrFields,$arrValues, $sqlWhere)) {
				
				//$vendorpo_id = sqlINSERTID_LABEL();	
				$log_description = "PO #$vpo_refno Updated";
				
				$arrFields=array('`vpo_no`','`vpolog_desc`','`vpolog_createdby`','`createdon`');

				$arrValues=array("$vpo_refno","$log_description","$logged_user_id","$createddate");
				//echo $vendorpo_id;exit();
				if(sqlACTIONS("INSERT","js_vendor_polog",$arrFields,$arrValues,'')) {
					?>
				<script type="text/javascript">window.location = 'vendorspo.php?route=add&id=<?php echo $vpo_id; ?>&code=1&switch=Y' </script>
				<?php
				}
			}
		
	} 
	
	
	}

//Create Vendor PO
if($save == "save-createnew" || $save == "save-draft") {

	$vpo_bill_company_name = $validation_globalclass->sanitize($_REQUEST['vpo_bill_company_name']);
	
	$vpo_bill_company_address = $validation_globalclass->sanitize(ucwords($_REQUEST['vpo_bill_company_address']));
	
	$vpo_bill_pincode = $validation_globalclass->sanitize(ucwords($_REQUEST['vpo_bill_pincode']));
	
	$vpo_bill_gstin = $validation_globalclass->sanitize(ucwords($_REQUEST['vpo_bill_gstin']));
	
	$vpo_bill_contact_no = $validation_globalclass->sanitize(ucwords($_REQUEST['vpo_bill_contact_no']));
	
	$vpo_bill_email = $validation_globalclass->sanitize(ucwords($_REQUEST['vpo_bill_email']));
	
	$vpo_ship_company_name = $validation_globalclass->sanitize($_REQUEST['vpo_ship_company_name']);
	
	$vpo_ship_company_address = $validation_globalclass->sanitize(ucwords($_REQUEST['vpo_ship_company_address']));
	
	$vpo_ship_pincode = $validation_globalclass->sanitize(ucwords($_REQUEST['vpo_ship_pincode']));
	
	$vpo_ship_gstin = $validation_globalclass->sanitize(ucwords($_REQUEST['vpo_ship_gstin']));
	
	$vpo_ship_contact_no = $validation_globalclass->sanitize(ucwords($_REQUEST['vpo_ship_contact_no']));
	
	$vpo_ship_email = $validation_globalclass->sanitize(ucwords($_REQUEST['vpo_ship_email']));
	
	$addtional_charge = $validation_globalclass->sanitize(ucwords($_REQUEST['addtional_charge']));
	
	$payment_terms = $validation_globalclass->sanitize(ucwords($_REQUEST['payment_terms']));

	$delivery_lead_time = $validation_globalclass->sanitize(ucwords($_REQUEST['delivery_lead_time']));

	$packaging = $validation_globalclass->sanitize(ucwords($_REQUEST['packaging']));
	
	$warranty = $validation_globalclass->sanitize(ucwords($_REQUEST['warranty']));
	
	$vpo_terms_and_conditions = htmlspecialchars($_REQUEST['vpo_terms_and_conditions']);
		
		$vendor_id = $validation_globalclass->sanitize($_REQUEST['vpo_id_for_list']);
		$selectpo_itemlist = sqlQUERY_LABEL("select count(*) as po_itemcount, SUM(vpo_after_discount_item_total) AS po_after_discounted_item_total, SUM(vpo_item_total) AS po_totalpaid, SUM(vpo_item_qty) AS po_totalqty, SUM(vpo_item_tax1) AS po_totaltax1, SUM(vpo_item_tax2) AS po_totaltax2 FROM `js_vendor_po_items` where `vpo_id`='$vendor_id'") or die(sqlERROR_LABEL());
				 while($collect_poitem_lists = sqlFETCHARRAY_LABEL($selectpo_itemlist)) {
					$po_itemcount = $collect_poitem_lists['po_itemcount'];
					$product_item_qty = $collect_poitem_lists['po_totalqty'];
					$po_totalpaid = $collect_poitem_lists['po_totalpaid'];
					$po_after_discounted_item_total = $collect_poitem_lists['po_after_discounted_item_total'];
					$po_totaltax1 = $collect_poitem_lists['po_totaltax1'];
					$po_totaltax2 = $collect_poitem_lists['po_totaltax2'];
					$po_totaltaxadded = $po_totaltax1 + $po_totaltax2;
					 }		
		//$po_itemcount = $validation_globalclass->sanitize($_REQUEST['po_itemcount']);
		
		//$product_item_qty = $validation_globalclass->sanitize($_REQUEST['product_item_qty']);
		
		//$po_totalpaid = $validation_globalclass->sanitize($_REQUEST['po_totalpaid']);
		
		//$po_totaltaxadded = $validation_globalclass->sanitize($_REQUEST['po_totaltaxadded']);	
		
		$total_po_paid = ($po_after_discounted_item_total + $addtional_charge);
		$total_po_balance = ($po_after_discounted_item_total + $addtional_charge);
		if($save == 'save-createnew'){
		$po_status = 1;	
		$vpo_sent = date('Y-m-d');
		}else{
		$po_status = 0;	
		}
		if($po_status == '1'){
			$selectinvoice_itemlist = sqlQUERY_LABEL("SELECT * FROM `js_vendor_po_items` WHERE `vpo_id` = '$vendor_id'") or die(sqlERROR_LABEL());
			$count_invoice_itemlist = sqlNUMOFROW_LABEL($selectinvoice_itemlist);
			if($count_invoice_itemlist == '0'){
			$err[] = 'Choose Item for Vendor PO';
			}
		}
	//Update query
	if(empty($err)){
		$arrFields=array('`vpo_tot_items`','`vpo_tot_qty`','`addtional_charge`','`payment_terms`','`delivery_lead_time`','`packaging`','`warranty`','`vpo_tot_value`','`vpo_tot_tax`','`vpo_tot_balance`','`status`','`vpo_sent`','`vpo_bill_company_name`','`vpo_bill_company_address`','`vpo_bill_pincode`','`vpo_bill_gstin`','`vpo_bill_contact_no`','`vpo_bill_email`','`vpo_ship_company_name`','`vpo_ship_company_address`','`vpo_ship_pincode`','`vpo_ship_gstin`','`vpo_ship_contact_no`','`vpo_ship_email`','`vpo_terms_and_conditions`');

		$arrValues=array("$po_itemcount","$product_item_qty","$addtional_charge","$payment_terms","$delivery_lead_time","$packaging","$warranty","$total_po_paid","$po_totaltaxadded","$total_po_balance","$po_status","$vpo_sent","$vpo_bill_company_name","$vpo_bill_company_address","$vpo_bill_pincode","$vpo_bill_gstin","$vpo_bill_contact_no","$vpo_bill_email","$vpo_ship_company_name","$vpo_ship_company_address","$vpo_ship_pincode","$vpo_ship_gstin","$vpo_ship_contact_no","$vpo_ship_email","$vpo_terms_and_conditions");
		
		$sqlWhere= "vpo_id=$vendor_id";

	  // print_r($arrValues); exit();

		
		if(sqlACTIONS("UPDATE","js_vendorpo",$arrFields,$arrValues,$sqlWhere)) {
					
					if($po_status == 0){
					$log_description = "PO #$po_vendor_no saved as draft";
					}else{
						$log_description = "PO #$po_vendor_no Sent";
					}
					$arrFields=array('`vpo_no`','`vpolog_desc`','`vpolog_createdby`','`createdon`');

					$arrValues=array("$po_vendor_no","$log_description","$logged_user_id","$createddate");
					//echo $vendorpo_id;exit();
					if(sqlACTIONS("INSERT","js_vendor_polog",$arrFields,$arrValues,'')) {
						?>
					<script type="text/javascript">window.location = 'vendorspo.php' </script>
					<?php
					}
			
		}
	}		
	
}

if( $upload == "import") {

	

	$file_name 		= $_FILES['csv']['name'];

	$file_type 		= $_FILES['csv']['type'];

	$file_temp_loc 	= $_FILES['csv']['tmp_name'];

	$file_error_msg = $_FILES['csv']['error'];

	$file_size 		= $_FILES['csv']['size'];

	

	/* 1. file upload handling */

	if(!$file_temp_loc) { // if not file selected

		echo "Error: please browse for a file before clicking the upload button.";

		exit();	

	} 

	if(!preg_match("/\.(csv)$/i", $file_name)) { // check file extension

		echo 'Error: your file is not CSV.';

		@unlink($file_temp_loc); // remove to the temp folder

		exit();

	}

	if($file_size > 5242880) { // file check size

		echo "Error: you file was larger than 5 Megabytes in size.";

		exit();	

	}

	if($file_error_msg == 1) { // 

		echo "Error: an error occured while processing the file, try agian.";

		exit();	

	}  

	

	$move_file = move_uploaded_file($file_temp_loc, "public/uploadedexcels/{$file_name}"); // temp loc, file name

	if($move_file != true) { // if not move to the temp location

		echo 'Error: File not uploaded, try again.';

		@unlink($file_temp_loc); // remove to the temp folder

		exit();

	}

	

	$csvFile  = 'public/uploadedexcels/'.$file_name;

	$csvFileLength = filesize($csvFile);

	$csvSeparator = ",";

	$handle = fopen($csvFile, 'r'); 

	$flag = true;

	$count = '';

	while(($data = fgetcsv($handle, $csvFileLength, $csvSeparator)) !== FALSE) { // while for each row

		if(!$flag) {

		$count += count($data[0]); // count imported

					

		/****************************

		Checking if record is empty

		****************************/

		if($data[0] != '') {

		

			foreach($_POST as $key => $value) {

			$data[$key] = filter($value);

			}	



			$product_code = $data['0'];

            $prdt_code = filter_import($product_code);

			$po_product_qty = filter_import($data['1']);

			$po_product_price = filter_import($data['2']);

			$po_product_tax = filter_import($data['3']);
					

		$result_datas = sqlQUERY_LABEL("SELECT * FROM `js_product` where  `prdt_code`= '$prdt_code' and `deleted`='0'") or die("Unable to get Prdt Code:".mysql_error());

		$fetch_row = sqlNUMOFROW_LABEL($result_datas);
		
		if($fetch_row > 0){
			$po_product_id = getPRODUCTDETAIL($prdt_code,'');
			$arrFields=array('`csvtype`','`sessionID`','`field1`','`field2`','`field3`','`field4`','`status`');
			$arrValues=array("4","$po_session_id","$prdt_code","$po_product_qty","$po_product_price","$po_product_tax","2");
					if(sqlACTIONS("INSERT","js_tempcsv",$arrFields,$arrValues,'')) {
					
					//total price
					$new_totalprice = ($po_product_price * $po_product_qty);
					//tax split
					$tax_split_amount = ($new_totalprice * ($po_product_tax/100))/2;
					//echo $tax_split_amount ;exit();
					$new_totalprice = $new_totalprice + $tax_split_amount  + $tax_split_amount;
					//checking  if purchasing product already added
					$get_selected_product_id = sqlQUERY_LABEL("select `vpo_item_id`, `vpo_item_qty`, `vpo_item_price`, `vpo_item_tax`, `vpo_item_tax1`, `vpo_item_tax2`, `vpo_item_total` from `js_vendor_po_items` where `prdt_id`='$po_product_id' and `vpo_id`='$po_main_refid'") or die(sqlERROR_LABEL());
					$counting_available_product = sqlNUMOFROW_LABEL($get_selected_product_id);
					
					if($counting_available_product == 0) {
						sqlQUERY_LABEL("INSERT into `js_vendor_po_items` (`vpo_id`, `prdt_id`, `vpo_item_qty`, `vpo_item_price`, `vpo_item_tax`, `vpo_item_tax1`, `vpo_item_tax2`, `vpo_item_total`, `status`, `vpo_item_updatedon`) VALUES ('$po_main_refid', '$po_product_id', '$po_product_qty', '$po_product_price', '$po_product_tax', '$tax_split_amount', '$tax_split_amount', '$new_totalprice', '1', '".date('Y-m-d H:i:s')."')") or die("#1 Unable to add PO Item:" . sqlERROR_LABEL());
						$get_poitem_id = sqlINSERTID_LABEL();
					} else {
						
						while($fetch_productid = sqlFETCHARRAY_LABEL($get_selected_product_id)) {
							$old_item_id = $fetch_productid['vpo_item_id'];
							$old_item_qty = $fetch_productid['vpo_item_qty'];
							$old_item_total = $fetch_productid['vpo_item_total'];
							$old_item_tax1 = $fetch_productid['vpo_item_tax1'];
							$old_item_tax2 = $fetch_productid['vpo_item_tax2'];
						}
						
							$add_newqty = ($old_item_qty+$po_product_qty);
							$add_newprice = ($old_item_total) + ($po_product_price * $po_product_qty);
							$add_newtax_split = ($old_item_tax1 + $old_item_tax2) + ($new_totalprice * ($po_product_tax/100))/2;;

						$get_poitem_id = sqlQUERY_LABEL("UPDATE `js_vendor_po_items` SET `vpo_item_qty`='$add_newqty', `vpo_item_total`='$add_newprice',  `vpo_item_tax1`='$add_newtax_split', `vpo_item_tax2`='$add_newtax_split' WHERE vpo_item_id = '$old_item_id'") or die(sqlERROR_LABEL());
					}
							
							}
				}else{
					$arrFields=array('`csvtype`','`sessionID`','`field1`','`field2`','`field3`','`field4`','`status`');
					$arrValues=array("4","$po_session_id","$prdt_code","$po_product_qty","$po_product_price","$po_product_tax","3");
					if(sqlACTIONS("INSERT","js_tempcsv",$arrFields,$arrValues,'')) {
					// print_r($arrValues);
					
					}
				}


		} //end of checking data

		

		} 

		$flag = false;

	}

	fclose($handle);

	unlink($csvFile); // delete cvs after imported



		echo "<div style='width: 350px; text-align: center; margin: 20% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we import loading...</div>";

		echo "<script type='text/javascript'>window.location = 'vendorspo.php?route=add&id=$po_main_refid&switch=Y'</script>";

		exit();

}


	//getting vendor id
	if($id != '') {
							
		$getvendor_polist = sqlQUERY_LABEL("select * from `js_vendorpo` where `vpo_id` = '$id' and deleted='0'") or die("Unable to get VENDOR detail: ".sqlERROR_LABEL());
		while($collect_vendor_polist = sqlFETCHARRAY_LABEL($getvendor_polist)) {
		   $prdttype_id = $collect_vendor_polist['prdttype_id'];
		   $vpo_id = $collect_vendor_polist['vpo_id'];		   
		   $product_type = getPRODUCTTYPE($prdttype_id,'label');	
		   $vpo_date = dateformat_datepicker($collect_vendor_polist['vpo_date']);	
		   $vpo_refno = $collect_vendor_polist['vpo_no'];	
		   $vendor_id = $collect_vendor_polist['vendor_id'];	
		   $vendor_status = $collect_vendor_polist['status'];	
		  $vendor_name = getVENDORNAME($vendor_id,'vendorname');
		$selected_vpo_id = $collect_vendor_polist['vpo_id'];
		$vpo_reasonid = $collect_vendor_polist['vpo_reasonid'];
		$vpo_stock_reason = $collect_vendor_polist['vpo_stock_reason'];
		$vpo_sale_order_reason = $collect_vendor_polist['vpo_sale_order_reason'];
		if($vpo_reasonid =='1'){ $vpo_reason = $vpo_sale_order_reason; }
		if($vpo_reasonid =='2'){ $vpo_reason = $vpo_stock_reason; }
		if($vpo_reasonid =='3'){ $vpo_reason = "N/A"; }
		$selected_vpo_no = $collect_vendor_polist['vpo_no'];	
		$addtional_charge = $collect_vendor_polist['addtional_charge'];	
		$payment_terms = $collect_vendor_polist['payment_terms'];	
		$delivery_lead_time = $collect_vendor_polist['delivery_lead_time'];	
		$packaging = $collect_vendor_polist['packaging'];	
		$warranty = $collect_vendor_polist['warranty'];	
		$selected_vpo_date = dateformat_datepicker($collect_vendor_polist['vpo_date']);	
		$selected_vpo_vendor_id = $collect_vendor_polist['vendor_id'];	
		$selected_vpo_prdttype_id = $collect_vendor_polist['prdttype_id'];	
		$selected_vpo_status = $collect_vendor_polist['status'];	
		}
	}

?>

    <div class="content">
      <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="row">
          <div class="col-lg-12">
            <div class="mg-b-25">

				<form method="post" enctype="multipart/form-data" data-parsley-validate>
				  
				<!-- BASIC Starting -->
				<div id="basic">
				  
					<?php if($action == ''){if($id != ''  && $switch == 'Y') {  
					
					
?>	
			     <div class="divider-text"><?php echo $__hbasicinfo ?></div>

				<input type="hidden" id="vpo_id_for_list" name="vpo_id_for_list" value="<?php echo $selected_vpo_id; ?>" />
					<div class="card mb-3">
						<div class="card-body">	
							<div class="row col-md-12 ">
								<div class="col-md-2">
									PO No: <b><?php echo $selected_vpo_no ;?></b>
								</div>
								<!--
								<div class="col-md-2">
									PO Type:  <b><?php echo getPRODUCTTYPE($selected_vpo_prdttype_id,'label'); ?></b>
								</div>-->
								<div class="col-md-2">
									PO Date: <b><?php echo $selected_vpo_date ;?></b>
								</div>
								<div class="col-md-2">
									Vendor: <b><?php echo getVENDORNAME($selected_vpo_vendor_id,'label'); ;?></b><br />
								</div>
								<div class="col-md-2">
									PO Type: <b><?php echo getVPOREASON($vpo_reasonid,'label');?></b><br />
								</div>
								<div class="col-md-2">
									Reason: <b><?php echo $vpo_reason;?></b><br />
								</div>
								<div class="col-md-2 pull-right">
								 <a href="vendorspo.php?route=add&id=<?php echo $id; ?>&switch=N" class="text-danger">Exit Compact Mode</a>
								</div>
							</div>
						</div>
					</div>
					 <?php
							} else {
		
								
							?>  
						<div class="row col-md-12">
						<!--<div class="form-group col-md-3">
							<!--<label for="prdt_type" class="control-label">Product Type <span class="text-danger">*</span></label>
							<select name="prdt_type" id="prdt_type" class="form-control selectpicker" data-live-search="true" required>
								 <?php echo getPRODUCTTYPE($selected_vpo_prdttype_id, 'select'); ?>
							</select>
			
						</div>-->
						<div class="form-group col-md-3">
							<label for="vendor_id" class="control-label">Vendor <span class="text-danger">*</span></label>
							<select name="vendor_id" id="vendor_id" class="form-control selectpicker select2" data-live-search="true" required>
								<?php echo getVENDORNAME($selected_vpo_vendor_id, 'select'); ?>
								
							</select>
						</div>                                
						<div class="form-group col-sm-3">
							<label for="vpo_date" class="control-label">P.O Date <span class="text-danger">*</span></label>
							<input type="text" class="form-control" placeholder="DD/MM/YYYY" name="vpo_date" id="vpo_date" value="<?php echo $selected_vpo_date ; ?>" required>
						</div>
						 <div class="form-group col-md-3">
						 <label for="vpo_reasonid" class="control-label">Reason <span class="text-danger">*</span></label>
							 <select name="vpo_reasonid" id="vpo_reasonid" class="form-control custom-select" onchange="reason_change();" required>
							 <?php echo getVPOREASON($vpo_reasonid, 'select'); ?>
							 </select>
						 </div>
						<div class="col-3" style="display:none;" id="show_sale_order">
							<label for="sale_order_reason" class="control-label">Enter Reason <span class="text-danger">*</span></label>
							 <div class="input-group">
							  <input type="text" class="form-control" aria-label="Username" name="sale_order_reason" id="sale_order_reason" value="<?php echo $vpo_sale_order_reason; ?>" aria-describedby="basic-addon2">  
							 </div>				      
						</div>
						<div class="col-3" style="display:none;" id="show_stock">
							<label for="stock_reason" class="control-label">Enter Reason <span class="text-danger">*</span></label>
							 <div class="input-group">
							  <input type="text" class="form-control" aria-label="Username" name="stock_reason" id="stock_reason" value="<?php echo $vpo_stock_reason; ?>" aria-describedby="basic-addon2">  
							 </div>				      
						</div>
						<div class="form-group col-md-3 mg-md-t-30">
							<input type="hidden" name="vpo_id" value="<?php echo $id; ?>" />
							<?php if($id != '') { ?>
								<button type="submit" name="save" value="setting_purchaseorder"  class="btn btn-success"> Update</button>
								<a href="vendorspo.php?route=add&id=<?php echo $id; ?>&switch=Y" class="text-danger">
								Switch to Compact Mode
								</a>
							<?php }  else { ?>
								<button type="submit" id="save" name="save" value="setting_purchaseorder" class="btn btn-primary ember-view">Save & Continue</button>
							<?php } ?>
						</div>

					</div>
					 <?php 
					}}
							?>
						<div class="clearfix"></div>
						<?php 
								if($id != '' && $action == "") { ?>
							<div class="row">		
								<h4 class="mg-l-15">Add Products <span class="text-danger">*</span></h4>
							</div>							
							<div class="row">
								<div class="form-group col-md-5">
								
								  <?php
									// //echo "select `prdt_id`, `prdt_code`, `prdt_name` from js_product where `prdt_type`='$prdttype_id'  and `status` = '1' and `deleted` = '0'  ORDER BY prdt_name asc";exit();
									// $productlist = sqlQUERY_LABEL("select `prdt_id`, `prdt_code`, `prdt_name` from js_product where `prdt_type`='$prdttype_id'  and `status` = '1' and `deleted` = '0'  ORDER BY prdt_name asc") or die(sqlERROR_LABEL());
									// $count_productlist_records = sqlNUMOFROW_LABEL($productlist);
									
									// if($count_productlist_records > 0) {
									?>
								<input type="text" class="form-control" style="width: 278.5px;" name="product-data" placeholder="Start typing or scanning..." id="product-data">
								</div>
								 <?php
									// } else {
										// echo "<span class='text-danger small'>No Product Available for the selected Product Type and Vendor.<span>";
									// }
									
									?>
								 <div class="col-lg-2">

                                            <a href="vendorspo.php?route=add&action=import&id=<?php echo $id; ?>" class="btn btn-sm btn-outline-danger">Import</a>

                                 </div> 
								</div>
													
								 <!-- ajax for getting choosen product -->
								   <div id="quickbill_offer_details">
									<div id="hidden_productcode">
									<div class="row">		
									<div class="form-group col-sm-2">
									<label class="control-label">Product Code</label>
									<input type="text" class="form-control" readonly="readonly" name="prdt_code" id="prdt_code">
									</div>
									<div class="form-group col-sm-4">
									<label class="control-label">Product Name</label>
									<input type="text" class="form-control" placeholder="Product Name" readonly="readonly" name="prdt_name" id="prdt_name">
									</div>
									<div class="form-group col-sm-2">
									<label class="control-label">Product Qty<span class="text-danger">*</span></label>
									<input type="text" class="form-control" placeholder="Qty" readonly="readonly" name="prdt_roq" id="prdt_roq">
									</div>
									<div class="form-group col-sm-2">
									<label class="control-label">Product Price</label>
									<input type="text" class="form-control" placeholder="Price" readonly="readonly" name="prdt_purchase_price" id="prdt_purchase_price">
									</div>
									<div class="form-group col-sm-2">
									<label class="control-label">TAX (in %)</label>
									<input type="text" class="form-control" placeholder="Tax" readonly="readonly" name="prdt_tax" id="prdt_tax">
									</div>                          
								 </div>
								 </div>
								
								 <!-- end of ajax -->    
							</div>
							</div>
							 
						<div id="progress_table" style="display:none;" class="text-center">Loading...</div>

						<table class="table table-bordered table-responsive">
							<thead >
							<tr>
								<th rowspan="2" class="text-center">#</th>
								<th rowspan="2" class="wd-10p">Product Code</th>
								<th rowspan="2" class="wd-20p">Product Name</th>
								<th rowspan="2" class="text-center wd-5p">Qty</th>
								<th class="text-center wd-20p">Item Price</th>
								<th colspan="2" class="text-center">Tax</th>
								<th class="text-center wd-20p">Item Total</th>
								<th rowspan="2" class="wd-10p">Option</th>
							</tr>
							<tr>
								<th class="text-center small">(in INR)</th>
								<th class="text-center small">CGST (INR)</th>
								<th class="text-center small">SGST (INR)</th>
								<th class="text-center small" style="border-right-width:1px;">(in INR)</th>
							</tr>
							</thead>
							<tbody id="show_po_product_list">
										<?php
										
                                            $selectpo_itemlist = sqlQUERY_LABEL("select `vpo_item_id`, `prdt_serialno`, `prdt_id`, `vpo_item_qty`, `vpo_item_price`, `vpo_discount_value`, `vpo_discount_amt`, `vpo_after_discount_price`, `vpo_after_discount_item_total`, `vpo_item_tax`, `vpo_item_tax1`, `vpo_item_tax2`, `vpo_item_total` FROM `js_vendor_po_items` where `vpo_id`='$id' ORDER BY `vpo_item_id` DESC") or die(sqlERROR_LABEL());
                                            $count_vpo_itemlist = sqlNUMOFROW_LABEL($selectpo_itemlist);
                                            
                                            if($count_vpo_itemlist > 0) {
                                                while($collect_poitem_list = sqlFETCHARRAY_LABEL($selectpo_itemlist)) {
                                                    $counter++;
                                                    $item_id = $collect_poitem_list['vpo_item_id'];
                                                    $product_id = $collect_poitem_list['prdt_id'];
                                                    $prdt_serialno = $collect_poitem_list['prdt_serialno'];
                                                    $product_item_qty = $collect_poitem_list['vpo_item_qty'];
                                                    $product_item_price = $collect_poitem_list['vpo_item_price'];
													$vpo_discount_value = $collect_poitem_list['vpo_discount_value'];
													$vpo_discount_amt = $collect_poitem_list['vpo_discount_amt'];
													$vpo_after_discount_price = $collect_poitem_list['vpo_after_discount_price'];
													$vpo_dicounted_item_price = ($vpo_after_discount_price/$product_item_qty);
													$vpo_after_discount_item_total = $collect_poitem_list['vpo_after_discount_item_total'];
                                                    $product_item_tax = $collect_poitem_list['vpo_item_tax'];
													$product_item_tax1 = $collect_poitem_list['vpo_item_tax1'];
													$product_item_tax2 = $collect_poitem_list['vpo_item_tax2'];
                                                    $product_item_total = $collect_poitem_list['vpo_item_total'];
                                                    ?>
                                                    <tr id="dummy_po_list_<?php echo $item_id; ?>">
                                                        <td class="text-center"><?php echo $counter; ?></td>
                                                        <td><?php echo getPRODUCTDETAIL($product_id, 'code'); ?></td>
                                                        <td><?php echo getPRODUCTDETAIL($product_id, 'name'); ?></td>
                                                        <td class="text-center"><?php echo $product_item_qty; ?></td>
														<td class="text-right">
														<?php if($vpo_discount_value !='0' && $vpo_discount_value !='') { ?>
														<del><?php echo moneyFormatIndia($product_item_price); ?></del><br>
														<?php echo moneyFormatIndia($vpo_dicounted_item_price); ?>
														<?php } else { ?>
														<?php echo moneyFormatIndia($product_item_price); ?>
														<?php } ?>
														</td>
                                                        <td class="text-right"><?php echo moneyFormatIndia($product_item_tax1); ?></td>
                                                        <td class="text-right"><?php echo moneyFormatIndia($product_item_tax2); ?></td>
                                                        <td class="text-right">
														<?php if($vpo_discount_value !='0' && $vpo_discount_value !='') { ?>
														<del><?php echo number_format($product_item_total, 2); ?></del><br>
														<?php echo number_format($vpo_after_discount_item_total, 2); ?>
														<?php } else { ?>
														<?php echo number_format($product_item_total, 2); ?>
														<?php } ?>
														</td>
                                                        <td>
                                                            <a href="javascript:;" onClick="remove_po_productitem_List(<?php echo $item_id; ?>);">
                                                            Delete
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }  //end of vendor po item while loop
                                            } else {
                                                echo '<tr id="dummy_po_list"><td colspan="8" align="center">"Start adding Products"</td></tr>';
                                            }
                                        ?>
							</tbody>
						</table>                             

						<div class="bottom-60px"></div>
						<?php 
					
					$selectpo_itemlist = sqlQUERY_LABEL("select count(*) as po_itemcount, SUM(vpo_after_discount_item_total) AS po_after_discounted_item_total, SUM(vpo_item_total) AS po_totalpaid, SUM(vpo_item_qty) AS po_totalqty, SUM(vpo_item_tax1) AS po_totaltax1, SUM(vpo_item_tax2) AS po_totaltax2 FROM `js_vendor_po_items` where `vpo_id`='$id'") or die(sqlERROR_LABEL());

					// $collect_itemlist_data = sqlFETCHOBJECT_LABEL($selectpo_itemlist);
					
					 while($collect_poitem_lists = sqlFETCHARRAY_LABEL($selectpo_itemlist)) {
														

					$po_itemcount = $collect_poitem_lists['po_itemcount'];
					$product_item_qty = $collect_poitem_lists['po_totalqty'];
					$po_totalpaid = $collect_poitem_lists['po_totalpaid'];
					$po_after_discounted_item_total = $collect_poitem_lists['po_after_discounted_item_total'];
					$product_item_price = $collect_poitem_lists['vpo_item_price'];
					$po_totaltax1 = $collect_poitem_lists['po_totaltax1'];
					$po_totaltax2 = $collect_poitem_lists['po_totaltax2'];
					$po_totaltaxadded = $po_totaltax1 + $po_totaltax2;

																
					 }
		 		// echo $po_totalpaid; exit();
		
						?>
						<div class="row fixed-actions mg-l-2">
							<div class="col-md-6 col-sm-12" id="show_po_product_total_list">
								<div class="investment-summary" style="float:left; padding-right: 20px;">
									<span class="info-label" style="display:inline;">Total:</span>
									<span class="inv-green"><strong><?php echo  moneyFormatIndia($po_after_discounted_item_total); ?></strong></span>
								</div>
								 <div class="investment-summary" style="float:left; padding-right: 20px;">
									<span class="info-label" style="display:inline;">Total Tax:</span>
									<span class="inv-green"><strong><?php echo  moneyFormatIndia($po_totaltaxadded); ?></strong></span>
								</div>
								<div class="investment-summary" style="float:left; padding-right: 20px;">
									<span class="info-label" style="display:inline;">Total Item:</span>
									<span class="inv-green"><strong><?php echo $po_itemcount; ?></strong></span>
								</div>
								<div class="investment-summary" style="float:left;">
									<span class="info-label" style="display:inline;">Total Qty:</span>
									<span class="inv-green"><strong><?php echo $product_item_qty ?></strong></span>
								</div>
							<input type="hidden" id="po_totalpaid" name="po_totalpaid" value="<?php echo $po_after_discounted_item_total; ?>" />
							<input type="hidden" id="po_totaltaxadded" name="po_totaltaxadded" value="<?php echo $po_totaltaxadded; ?>" />
							<input type="hidden" id="po_itemcount" name="po_itemcount" value="<?php echo $po_itemcount; ?>" />
							<input type="hidden" id="product_item_qty" name="product_item_qty" value="<?php echo $product_item_qty; ?>" />
							</div>			
							<?php
							$list_printsettings_data = sqlQUERY_LABEL("SELECT * FROM `js_printsettings` where deleted = '0'") or die("#1-Unable to get PRODUCT CATEGORY:".sqlERROR_LABEL());

							  $count_printsettings_list = sqlNUMOFROW_LABEL($list_printsettings_data);

							  while($row = sqlFETCHARRAY_LABEL($list_printsettings_data)){
								  $printsettings_id = $row["printsettings_id"];
								  $bill_company_name = $row["bill_company_name"];
								  $bill_company_address = $row["bill_company_address"];
								  $bill_pincode = $row["bill_pincode"];
								  $bill_gstin = $row["bill_gstin"];
								  $bill_contact_no = $row["bill_contact_no"];
								  $bill_email = $row["bill_email"];
								  $ship_company_name = $row["ship_company_name"];
								  $ship_company_address = $row["ship_company_address"];
								  $ship_pincode = $row["ship_pincode"];
								  $ship_gstin = $row["ship_gstin"];
								  $ship_contact_no = $row["ship_contact_no"];
								  $ship_email = $row["ship_email"];
								  $terms_and_conditions = $row["terms_and_conditions"];
								  //$terms_and_conditions = stripslashes(xml_entity_decode($terms_and_conditions, 'Windows-1525'));
								  $terms_and_conditions = html_entity_decode($terms_and_conditions);
								  $status = $row["status"];
								}							
							?>
						<input type="hidden" name="vpo_bill_company_name" id="vpo_bill_company_name" value="<?php echo $bill_company_name; ?>">
						<input type="hidden" name="vpo_bill_company_address" id="vpo_bill_company_address" value="<?php echo $bill_company_address; ?>">
						<input type="hidden" name="vpo_bill_pincode" id="vpo_bill_pincode" value="<?php echo $bill_pincode; ?>">
						<input type="hidden" name="vpo_bill_gstin" id="vpo_bill_gstin" value="<?php echo $bill_gstin; ?>">
						<input type="hidden" name="vpo_bill_contact_no" id="vpo_bill_contact_no" value="<?php echo $bill_contact_no; ?>">
						<input type="hidden" name="vpo_bill_email" id="vpo_bill_email" value="<?php echo $bill_email; ?>">
						
						<input type="hidden" name="vpo_ship_company_name" id="vpo_ship_company_name" value="<?php echo $ship_company_name; ?>">
						<input type="hidden" name="vpo_ship_company_address" id="vpo_ship_company_address" value="<?php echo $ship_company_address; ?>">
						<input type="hidden" name="vpo_ship_pincode" id="vpo_ship_pincode" value="<?php echo $ship_pincode; ?>">
						<input type="hidden" name="vpo_ship_gstin" id="vpo_ship_gstin" value="<?php echo $ship_gstin; ?>">
						<input type="hidden" name="vpo_ship_contact_no" id="vpo_ship_contact_no" value="<?php echo $ship_contact_no; ?>">
						<input type="hidden" name="vpo_ship_email" id="vpo_ship_email" value="<?php echo $ship_email; ?>">
						
						<!--<div class="col-md-12 col-sm-12 mt-3">
						<h6><u>Additional Charges & Other Details :-</u></h6>						
						<div class="row">
						<div class="form-group col-sm-2 mt-3">
							<label class="control-label">Additional Charges in Rs.</label>
							<input type="text" class="form-control" placeholder="Additional Charges" name="addtional_charge" id="addtional_charge" value="<?php echo $addtional_charge; ?>">
						</div>
						<div class="form-group col-sm-2 mt-3">
							<label class="control-label">Payment Terms :</label>
							<input type="text" class="form-control" placeholder="Payment Terms" name="payment_terms" id="payment_terms" value="<?php echo $payment_terms; ?>">
						</div>
						<div class="form-group col-sm-2 mt-3">
							<label class="control-label">Delivery Lead Time :</label>
							<input type="text" class="form-control" placeholder="Delivery Lead Time" name="delivery_lead_time" id="delivery_lead_time" value="<?php echo $delivery_lead_time; ?>">
						</div>
						<div class="form-group col-sm-2 mt-3">
							<label class="control-label">Packaging :</label>
							<input type="text" class="form-control" placeholder="Packaging" name="packaging" id="packaging" value="<?php echo $packaging; ?>">
						</div>
						<div class="form-group col-sm-2 mt-3">
							<label class="control-label">Warranty :</label>
							<input type="text" class="form-control" placeholder="Warranty" name="warranty" id="warranty" value="<?php echo $warranty; ?>">
						</div>
						</div>

						</div>-->
						<div class="col-sm-4 mg-t-10 mg-md-t-0 ml-auto md-text-right text-center">
								<input type="hidden" id="vpo_id_for_list" name="vpo_id_for_list" value="<?php echo $id; ?>" />
								<input type="hidden" id="po_vendor_no" name="po_vendor_no" value="<?php echo $selected_vpo_no; ?>" />
								<input type="hidden" id="po_vendor_id" name="po_vendor_id" value="<?php echo $selected_vpo_vendor_id; ?>" />
								<input type="hidden" id="po_vendor_status" name="po_vendor_status" value="<?php echo $selected_vpo_status; ?>" />
								
								<input type="hidden" id="po_created_date" name="po_created_date" value="<?php echo $selected_vpo_date; ?>" />
								
								<?php if($prdt_id != '') { ?>
								<input type="hidden" name="selected_prdt_id" value="<?php echo $prdt_id; ?>" />
								<button type="submit" id="save" name="update" value="update-record" class="btn btn-success ember-view">Update</button>
								<?php } else { ?>
								<button type="submit" id="save" name="save" value="save-draft" class="btn btn-success ember-view mg-md-r-1 mg-t-20">Save as Draft</button>
								<button type="submit" id="save" name="save" value="save-createnew" class="btn btn-success ember-view mg-t-20">Save & Send</button>
								<?php } ?>
								<a href="vendorspo.php" class="btn btn-secondary mg-t-20 mg-md-t-20 mg-md-l-1">Cancel</a>
							</div>
						</div>
				</div>
				<!-- End of BASIC -->
					<?php } elseif($action == '') { ?>
					<p class="col-md-12 well well-sm text-center">
					You need to "SAVE VENDOR DETAILS" to proceed.
					</p>
				<?php } if($action == 'import') {

					?> 

    

                            <div class="col-md-4 col-lg-4 col-xl-4 mx-auto">

            

                                <div class="card mb-4">

                                    <div class="card-body">

                                        <div class="form-group">                                

                                            <div class="row">  

                                            

                                             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 

                                                 <div class="form-group">

                                                       <label class="control-label">Upload your file  <span class="text-danger">*</span></label>

                                                          <div class="valitor">

                                                             <input name="csv" type="file" class="span6 m-wrap" /><br>

                                                             <span class="help-block"> Import .CSV format files only. Allowed size 5MB.<br> <a href="sample_vdr.csv">Click to download sample</a><br /></span>

                                                           </div>

                                                    </div>

                                             </div>

                                             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
												<input type="hidden" id="po_main_refid" name="po_main_refid" value="<?php echo $id; ?>" />
                                                <button class="btn btn-primary buttonalign_save" type="submit" name="upload" value="import">

                                                <i class="fa fa-upload">&nbsp;</i> Upload

                                                </button>

                                                <a href="vendorspo.php?route=add&id=<?php echo $id; ?>&switch=Y"  class="btn btn-default">Return</a>

                                             </div>

                                            

                                            </div> 

                                        </div>                      

                                    </div>

                                </div>

            

                            </div>

                    

                    <?php } ?>
				</form>

          </div><!-- col -->
          
          <?php 
	          // $vendorspo_sidebar_view_type='create';
	          // include viewpath('__vendorsposidebar.php'); 
          ?>
            </div><!-- row -->
			</div><!-- row -->
            </div><!-- row -->
        </div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->   
	
