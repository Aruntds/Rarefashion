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
if($button == "setting_purchaseorder") {
	$vpor_date = dateformat_database($vpor_date);
	if($vpor_id == ''){
	//
		$vpor_no = getnewVENDORPORCOUNT($vpor_no);
			   	
		$arrFields=array('`vpor_no`','`vpor_date`','`vpo_ref_no`','`vendor_id`','`prdttype_id`','`createdby`');

		$arrValues=array("$vpor_no","$vpor_date","$vpo_ref_no","$vendor_id","$prdt_type","$logged_user_id");

		if(sqlACTIONS("INSERT","js_vendor_po_return",$arrFields,$arrValues,'')) {
			$vpor_id = sqlINSERTID_LABEL();	
			//notification message
			//notificationid,title,msg,user_id,status
			//$log_msg ="New VendorPO Return Created #".$vpor_no;
			//$notification_insert = create_notification('5','Vendor PO Return',$log_msg,$logged_user_id,'1');
			echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";

				?>
				<script type="text/javascript">window.location = 'vendorsporeturn.php?route=add&id=<?php echo $vpor_id; ?>&switch=Y&code=1' </script>
				<?php
			
		} else {

			$err[] =  "Unable to Insert Record"; 

		} 
	}else{
		$arrFields=array('`vpor_date`','`vendor_id`','`vpo_ref_no`','`prdttype_id`','`createdby`');

		$arrValues=array("$vpor_date","$vendor_id","$vpo_ref_no","$prdt_type","$logged_user_id");
		$sqlwhere = "vpor_id = '$vpor_id'";
		if(sqlACTIONS("UPDATE","js_vendor_po_return",$arrFields,$arrValues,$sqlwhere)) {
			?>
			<script type="text/javascript">window.location = 'vendorsporeturn.php?route=add&id=<?php echo $vpor_id; ?>&switch=Y&code=1' </script>
			<?php
		}
		
	}
}

//updating vendor purchase order values
if($save == 'save-createnew' || $save == 'save-draft')
{
	//print_r($_REQUEST);
    $selected_po_id = $_POST['vpor_id_for_list'];
	$po_vendor_no = $_POST['po_vendor_no'];
	$po_vendor_id = $_POST['po_vendor_id'];
	$po_vendor_status = $_POST['po_vendor_status'];
	$po_created_date = dateformat_database($_POST['po_created_date']);
	$selectpo_itemlist = sqlQUERY_LABEL("select count(*) as po_itemcount, SUM(vpor_item_total) AS po_totalpaid, SUM(vpor_item_qty) AS po_totalqty, SUM(vpor_item_tax1) AS po_totaltax1, SUM(vpor_item_tax2) AS po_totaltax2 FROM `js_vendor_po_return_items` where `vpor_id`='$selected_po_id'") or die(sqlERROR_LABEL());
//$count_vpor_itemlist = sqlNUMOFROW_LABEL($selectpo_itemlist);
$collect_itemlist_data = sqlFETCHOBJECT_LABEL($selectpo_itemlist);
	$tot_po_amount = $collect_itemlist_data->po_totalpaid;;
	$tot_po_tax = ($collect_itemlist_data->po_totaltax1 + $collect_itemlist_data->po_totaltax2);
	$tot_po_item = $collect_itemlist_data->po_itemcount;
	$tot_po_qty = $collect_itemlist_data->po_totalqty;
	if($save == 'save-createnew'){
		$po_status = 1;	
	}else{
		$po_status = 0;	
	}
	$vpor_received = date('Y-m-d');
   $vpor_approvedby = $_POST['vpor_approvedby'];	
	$vpor_remarks = htmlentities($_POST['vpor_remarks'], ENT_COMPAT, "UTF-8");
	trim ($vpor_remarks);
	$err =  checkqtyavailable($selected_po_id,'vendorpor'); 
	if(empty($err) || $po_status=='0') {

		//`vpor_id`, `vpor_no`, `vpor_date`, `vpor_sent`, `vpor_received`, `vendor_id`, `prdttype_id`, `vpor_tot_items`, `vpor_tot_qty`, `vpor_tot_value`, `vpor_tot_discount`, `vpor_tot_tax`, `vpor_tot_paid`, `vpor_tot_balance`, `vpor_createdon`, `vpor_updatedon`, `status`, `deleted` FROM `adisil_vendor_po_return`
		$tot_po_balance = ($tot_po_amount);
		if($po_status == 1){
		$arrFields=array('`vpor_tot_items`','`vpor_tot_qty`','`vpor_tot_value`','`vpor_tot_tax`','`vpor_tot_balance`','`status`','`vpor_approvedby`','`vpor_remarks`','`vpor_sent`','`vpor_received`');
		$arrValues=array("$tot_po_item","$tot_po_qty","$tot_po_amount","$tot_po_tax","$tot_po_balance","$po_status","$vpor_approvedby","$vpor_remarks","$po_created_date","$vpor_received");
		}else{
		$arrFields=array('`vpor_tot_items`','`vpor_tot_qty`','`vpor_tot_value`','`vpor_tot_tax`','`vpor_tot_balance`','`status`','`vpor_approvedby`','`vpor_remarks`');
		$arrValues=array("$tot_po_item","$tot_po_qty","$tot_po_amount","$tot_po_tax","$tot_po_balance","$po_status","$vpor_approvedby","$vpor_remarks");
		}
		$sqlwhere = "vpor_id = '$selected_po_id'";
		if(sqlACTIONS("UPDATE","js_vendor_po_return",$arrFields,$arrValues,$sqlwhere)) {
		}
					
			if($po_vendor_status != $po_status) {
				$log_description = "PO #$po_vendor_no Status Updated";
			} else {
				$log_description = "PO #$po_vendor_no Updated";
			}
				//UPDATING LOG
				//`vporlog_id`, `vpor_no`, `vporlog_type`, `vporlog_desc`, `vporlog_createdby`, `vporlog_createdon`, `deleted` FROM `adisil_vendor_po_returnlog`
				$arrFields=array('`vpor_no`','`vporlog_type`','`vporlog_desc`','`vporlog_createdby`','`status`');
				$arrValues=array("$po_vendor_no","0","$log_description","$logged_user_id","1");
				if(sqlACTIONS("INSERT","js_vendor_po_returnlog",$arrFields,$arrValues,'')) {
				}
						
		/************
		Reducing stock from branch stock
		************/
		if($po_status == '1') {
			//`vpor_item_id`, `vpor_item_qty`, `vpor_item_price`, `vpor_item_tax`, `vpor_item_tax1`, `vpor_item_tax2`, `vpor_item_total` from `adisil_vendor_po_return_items` where `prdt_id`='$po_product_id' and `vpor_id`='$po_vpor_id'
			
			$selectinvoice_itemlist = sqlQUERY_LABEL("SELECT `prdt_id`, `vpor_item_qty`,vpo_id FROM `js_vendor_po_return_items` WHERE `vpor_id` = '$selected_po_id'") or die(sqlERROR_LABEL());
			$count_invoice_itemlist = sqlNUMOFROW_LABEL($selectinvoice_itemlist);
		
			if($count_invoice_itemlist > 0) {
				
				while($collect_invoiceitem_list = sqlFETCHARRAY_LABEL($selectinvoice_itemlist)) {
					
					$product_id = $collect_invoiceitem_list['prdt_id'];
					$vpo_id = $collect_invoiceitem_list['vpo_id'];
					$product_item_qty = $collect_invoiceitem_list['vpor_item_qty'];					
					
					if($product_item_qty > '0') {
						/******************
						GET BRANCH MASTER STOCK
						******************/
						
						$check_product_stock = sqlQUERY_LABEL("select `vpo_item_available` from js_vendor_po_items where vpo_id = '$vpo_id' and  prdt_id='$product_id' and vpo_item_received != '0' and deleted = '0'") or die(sqlERROR_LABEL());
						while($collect_product_stock = sqlFETCHARRAY_LABEL($check_product_stock)) {
							//$old_openingstock = $collect_product_stock['prdt_openingstock'];
							$old_remainingstock = $collect_product_stock['vpo_item_available'];
								
								//adding new stock data
								//$new_openingstock = ($old_openingstock - $product_item_qty);
								$new_remainingstock = ($old_remainingstock - $product_item_qty);
								
								$productmaster_stock_item = sqlQUERY_LABEL("Update js_vendor_po_items set `vpo_item_available`='$new_remainingstock' where vpo_id = '$vpo_id' and  prdt_id='$product_id' and vpo_item_received != '0' and deleted = '0'") or die("unable to update ITEM STOCK".sqlERROR_LABEL());
								
								//Product Log
								$log_description = "$product_item_qty - Stock removed for Vendor Purchase Return #$po_no";
								
								//echo 'LOG : <br />';
								//echo "INSERT into `adisil_product_log` (`prdt_id`, `prdtlog_desc`, `prdtlog_createdby`) VALUES  ('$selected_PRDTID', '$log_description', '$customer_id')<br />";
								$arrFields=array('`prdt_id`','`prdtlog_desc`','`prdtlog_createdby`','`status`');
								$arrValues=array("$product_id","$log_description","$logged_user_id","1");
								if(sqlACTIONS("INSERT","js_product_logs",$arrFields,$arrValues,'')) {
								}
								$po_no = getVENDORPOdetails($vpo_id,'vpoid',$product_id); 
								$update_bill_log = sqlQUERY_LABEL("INSERT INTO `js_vendor_polog`(`vpo_no`, `vpolog_type`, `vpolog_desc`, `vpolog_createdby`, `vpolog_createdon`) VALUES ('$po_no','1','$log_description','$logged_user_id', now())") or die("unable to create log:". sqlERROR_LABEL());	
								
																
						}
						
					} //END OF GRNS STATUS
				
				} //END OF WHILE LOOP - PURCHASE RETURN ITEM	
				
			} //END OF PURCHASE RETURN COUNT	
			
		}
			   	   
		echo "<div style='width: 350px; text-align: center; margin: 20% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while load this...</div>";
		echo "<script type='text/javascript'>window.location = 'vendorsporeturn.php?code=2'</script>";
		exit();
	}else{
		echo "<script type='text/javascript'>window.location = 'vendorsporeturn.php?route=add&id=$po_id&code=0'</script>";
	}
}

	if($_POST['save'] == 'generate-GRN') {

		$selected_itemid = $_POST['item_id'];

		$po_id = $_POST['po_id']; 

		$po_no = $_POST['po_no'];

		$po_vendor_id = $_POST['po_vendor_id'];

		$vpo_grn_on = date('Y/m/d');

		$vpo_grn_remarks = sqlREALESCAPESTRING_LABEL($_POST['vpo_grn_remarks']);

		if(empty($err)) {

			foreach ($selected_itemid as $key => $val) {

				$count = count($selected_itemid);

				$selected_ITEMID = $_POST['item_id'][$key];

				$selected_PRDTID = $_POST['prdt_id'][$key];

				$selected_QTY = $_POST['received_qty'][$key];

				$selected_REQUESTEDQTY = $_POST['requested_qty'][$key];

				$selected_GRNSTATUS = $_POST['grn_status'][$key];

				$selected_ITEMPRICE = $_POST['vpo_item_price'][$key];

				$selected_ITEMTAX = $_POST['vpo_item_tax'][$key];

				//$selected_EXPIRY = dateformat_database($_POST['expiry_date'][$key]);
				//echo $selected_QTY;
				if($selected_QTY !='' && $selected_QTY !='0') {
                //echo "select * from js_vendor_po_items where vpo_item_id='$selected_ITEMID' and vpo_id = '$po_id' and prdt_id='$selected_PRDTID'";
				 $check_product_new_stock = sqlQUERY_LABEL("select * from js_vendor_po_items where vpo_item_id='$selected_ITEMID' and vpo_id = '$po_id' and prdt_id='$selected_PRDTID'") or die(sqlERROR_LABEL());

					while($row_add_qty = sqlFETCHARRAY_LABEL($check_product_new_stock)){

						$vpo_item_received = $row_add_qty["vpo_item_received"];
						$vpo_item_available = $row_add_qty["vpo_item_available"];
						$vpo_item_returned_qty = $row_add_qty["vpo_item_returned_qty"];
							
							//AUTO-GENERATED VALUES
							$new_receive_qty = ($vpo_item_received - $selected_QTY);	
							$new_available_qty = ($vpo_item_available - $selected_QTY);
							$new_returned_qty = ($vpo_item_returned_qty + $selected_QTY);

					}

				 $check_product_new_stock_prdt_tbl = sqlQUERY_LABEL("select productavailablestock, productopeningstock from js_product where  productID='$selected_PRDTID'") or die(sqlERROR_LABEL());
				 //echo "select * from js_vendor_po_items where prdt_id='$selected_PRDTID'";
					//echo "select * from js_vendor_po_items where prdt_id='$selected_PRDTID'";
					while($row_add_qty_prdt_tbl = sqlFETCHARRAY_LABEL($check_product_new_stock_prdt_tbl)){

						$productopeningstock = $row_add_qty_prdt_tbl["productopeningstock"];
						$productavailablestock = $row_add_qty_prdt_tbl["productavailablestock"];
							
							//AUTO-GENERATED VALUES
							$new_prdt_tbl_opening_qty = ($productopeningstock - $selected_QTY);	

							$new_prdt_tbl_available_qty = ($productavailablestock - $selected_QTY);

					}
					

						$log_description = "$selected_QTY - Stock Return from PO #$po_no";

						$sql_insert = sqlQUERY_LABEL("INSERT into `js_product_logs` (`prdt_id`, `prdtlog_desc`, `prdtlog_createdby`) VALUES  ('$selected_PRDTID', '$log_description', '$logged_user_id')") or die("GRN Logs Insertion: ".sqlERROR_LABEL());
						
						// *** VPO STOCK UPDATE *** //
					
						$appstock_item = sqlQUERY_LABEL("Update js_vendor_po_items set `vpo_item_received`='$new_receive_qty',`vpo_item_available`='$new_available_qty', `vpo_item_returned_qty`='$new_returned_qty' where vpo_item_id='$selected_ITEMID' and vpo_id = '$po_id' and `prdt_id`='$selected_PRDTID'") or die("unable to update ITEM STOCK".sqlERROR_LABEL());

						$appstock_item_update_prdt_tbl = sqlQUERY_LABEL("Update js_product set `productavailablestock`='$new_prdt_tbl_available_qty', `productopeningstock`='$new_prdt_tbl_opening_qty' where `productID`='$selected_PRDTID'") or die("unable to update ITEM STOCK".sqlERROR_LABEL());

						//echo "Update js_vendor_po_items set `vpo_item_received`='$new_receive_qty',`vpo_item_available`='$new_available_qty', `vpo_item_returned_qty`='$new_returned_qty' where vpo_item_id='$selected_ITEMID' and vpo_id = '$po_id' and `prdt_id`='$selected_PRDTID'";

//exit();						
						$arrFields=array('`vpor_returnedby`');

						$arrValues=array("$vpor_returnedby");
						
						$sqlwhere = "vpor_id = '$id'";
						
						if(sqlACTIONS("UPDATE","js_vendor_po_return",$arrFields,$arrValues,$sqlwhere)) {
		
						}

						if($vpo_item_qty == $vpo_item_returned_qty){
						
						$arrFields=array('`status`');

						$arrValues=array("1");
						
						$sqlwhere = "vpor_id = '$po_id'";
						
						if(sqlACTIONS("UPDATE","js_vendor_po_return",$arrFields,$arrValues,$sqlwhere)) {
		
						}
						}
						$log_description = "$selected_QTY - Stock Return from PO #$po_no";
									
						//$update_bill_log = sqlQUERY_LABEL("INSERT INTO `js_vendor_po_returnlog`(`vpor_no`, `vporlog_type`, `vporlog_desc`,`vporlog_remarks`, `vporlog_createdby`, `createdon`) VALUES ('$po_no','1','$log_description','$vpo_grn_remarks','$logged_user_id', now())") or die("unable to create log:". sqlERROR_LABEL());

				} else {

						echo "<div style='width: 350px; text-align: center; margin: 20% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Nothing to update here, you will be taken back now. Please wait while load this...</div>";

						echo "<script type='text/javascript'>window.location = 'vendorsporeturn.php?route=list&formtype=preview&id=$id'</script>";

						exit(); 

				}
				
			}
//exit();			

		echo "<div style='width: 350px; text-align: center; margin: 20% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while load this...</div>";

		echo "<script type='text/javascript'>window.location = 'vendorsporeturn.php?route=list&formtype=preview&id=$id'</script>";

		exit();

		}

	}

if($id != '') {
	$getvendor_po_returnlist = sqlQUERY_LABEL("select * from js_vendor_po_return where vpor_id = '$id' and deleted='0'") or die("Unable to get VENDOR detail: ".sqlERROR_LABEL());
	while($collect_vendor_po_returnlist = sqlFETCHARRAY_LABEL($getvendor_po_returnlist)) {
	   $selected_vpor_id = $collect_vendor_po_returnlist['vpor_id'];	
	   $selected_vpor_no = $collect_vendor_po_returnlist['vpor_no'];	
	   $selected_vpor_date = dateformat_datepicker($collect_vendor_po_returnlist['vpor_date']);
	   $vpor_vpo_ref_no = $collect_vendor_po_returnlist['vpo_ref_no'];
	   $get_vpo_id = getVENDORPOdetails($vpor_vpo_ref_no,'vpoid','');
	   //$split_vpo_ref_no_1 = (explode("-",$vpor_vpo_ref_no)[0]);
       //$split_vpo_ref_no_2 = (explode("-",$vpor_vpo_ref_no)[1]);
	   //$split_vpo_id = (explode("-",$vpor_vpo_ref_no)[2]);
	   //$selected_vpor_vpo_ref_no = $split_vpo_ref_no_1.'-'.$split_vpo_ref_no_2;
	   $selected_vpor_vendor_id = $collect_vendor_po_returnlist['vendor_id'];
	   $selected_vpor_prdttype_id = $collect_vendor_po_returnlist['prdttype_id'];	
	   $selected_vpor_status = $collect_vendor_po_returnlist['status'];
	   $selected_vpor_approvedby = $collect_vendor_po_returnlist['vpor_approvedby'];
	   $selected_vpor_remarks = $collect_vendor_po_returnlist['vpor_remarks'];
	}

}
?>
    <div class="content">
      <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="row">
          <div class="col-lg-12">
            <div class="mg-b-25">

				<form method="post" enctype="multipart/form-data" data-parsley-validate>
				<input type="hidden" id="vpor_id_for_list" name="vpor_id_for_list" value="<?php echo $selected_vpor_id; ?>" />
				<!-- BASIC Starting
				<div id="basic">
				  <div class="divider-text"><?php echo $__hbasicinfo ?></div>
				  <div class="form-group row">
				  	<label for="categorystatus" class="col-sm-2 col-form-label"><?php echo $__active ?></label>
					<div class="col-sm-7">
						<div class="custom-control custom-switch mg-t-10">
						  <input type="checkbox" class="custom-control-input" name="categorystatus" id="categorystatus" checked="">
						  <label class="custom-control-label" for="categorystatus">Yes</label>
						</div>
					</div>
				  </div>  -->
					<?php
					//compact view
					if($id != '' && $switch == 'Y') { 
					?>
					<div class="card mb-3">
						<div class="card-body">	
							<div class="row col-md-12 ">
								<div class="col-md-3">
									VPOR No: <b><?php echo $selected_vpor_no; ?></b>
								</div>
								<!--<div class="col-md-2">
									PO Type: <?php echo getPRODUCTTYPE($selected_vpor_prdttype_id, 'label'); ?></b>
								</div>-->
								<div class="col-md-2">
									VPOR Date: <b><?php echo $selected_vpor_date; ?></b>
								</div>
								<div class="col-md-3">
									Vendor: <b><?php echo getVENDORNAME($selected_vpor_vendor_id, 'label'); ?></b><br />
								</div>
								<div class="col-md-2">
									VPO Ref. No: <b><?php echo $vpor_vpo_ref_no; ?></b>
								</div>
								<div class="col-md-2 pull-right">
								 <a href="vendorsporeturn.php?route=add&id=<?php echo $id; ?>&switch=N" class="text-danger">Exit Compact Mode</a>
								</div>
							</div>
						</div>
					</div>
					<?php
					} else {
					?>  
					<div class="row col-md-12">	 
						<!--<div class="form-group col-md-3">
							<label for="prdt_type" class="control-label">Product Type <span class="text-danger">*</span></label>
							<select name="prdt_type" id="prdt_type" class="form-control selectpicker" data-live-search="true" required>
								<?php echo getPRODUCTTYPE($selected_vpor_prdttype_id, 'select'); ?>
							</select>
						</div>-->
						<div class="form-group col-md-3"><!--onchange="get_product_list();" data-live-search="true"-->
							<label for="vendor_id" class="control-label">Vendor <span class="text-danger">*</span></label>
							<select name="vendor_id" id="vendor_id" class="form-control selectpicker select2" data-live-search="true" required>
								<?php echo getVENDORNAME($selected_vpor_vendor_id, 'select'); ?>
							</select>
						</div>                                
						<div class="form-group col-sm-3">
							<label for="vpor_date" class="control-label">VPO Return Date <span class="text-danger">*</span></label>
							<input type="text" class="form-control" placeholder="DD/MM/YYYY" name="vpor_date" id="vpor_date" value="<?php echo $selected_vpor_date; ?>" required>
						</div>
						
						<div class="form-group col-sm-3">
							<label for="vpo_ref_no" class="control-label">VPO Ref. No <span class="text-danger">*</span></label>
							<input type="text" class="form-control" placeholder="Search VPO Ref No."  name="vpo_ref_no" id="vpo_ref_no" value="<?php if($id!= ''){ echo $vpor_vpo_ref_no; } ?>" required>
						</div>

						<div class="form-group col-md-3 mg-t-30">
							<input type="hidden" name="vpor_id" value="<?php echo $id; ?>" />
							<?php if($id != '') { ?>
								<button type="submit" id="save" value="setting_purchaseorder" name="button" class="btn btn-success"> Update</button>
								<a href="vendorsporeturn.php?route=add&id=<?php echo $id; ?>&switch=Y" class="text-danger">
								Switch to Compact Mode
								</a>
							<?php }  else { ?>
								<button type="submit" id="save" name="button" value="setting_purchaseorder" class="btn btn-success ember-view">Save Vendor</button>
							<?php } ?>
						</div>

					</div>
					<?php 
					}
					?>
						<div class="clearfix"></div>
						<?php 
						if($id != '') { ?>
	<div class="divider-text">Product details</div>	
			
		<div class="mg-t-20">
			<table class="table table-bordered table-hover mg-r-0" width="100%">
			   <thead class="thead bg-gray-200">
				  <tr>
						<th  class="text-center">#</th>
						<th>Product Code</th>
						<th>Product Name</th>
						<th class="text-center">Received Qty</th>									   
						<th class="text-center">Available Qty</th>									   
						<th class="text-center">Previously <br> Returned Qty</th>
						<th class="text-center">Remaining Qty</th>
					</tr>
				
			   </thead>

			   <tbody id="fetch_amcparticular">
			   
			   <?php
			$list_vendorpoitems_data = sqlQUERY_LABEL("SELECT * FROM `js_vendor_po_items` where vpo_id='$get_vpo_id' and deleted = '0'") or die("#1-Unable to get PRODUCT CATEGORY:".sqlERROR_LABEL());

			$count_cateogry_list = sqlNUMOFROW_LABEL($list_vendorpoitems_data);
			//$counter_value = '1';
			while($row_value = sqlFETCHARRAY_LABEL($list_vendorpoitems_data)){
			  $counter_value++;
			  $vpo_item_id = $row_value["vpo_item_id"];
			  $vpo_id = $row_value["vpo_id"];
			  $prdt_id = $row_value["prdt_id"];
			  $vpo_item_qty = $row_value["vpo_item_qty"];
			  $vpo_item_price = $row_value["vpo_item_price"];
			  $vpo_item_tax = $row_value["vpo_item_tax"];
			  $vpo_item_tax1 = $row_value["vpo_item_tax1"];
			  $vpo_item_tax2 = $row_value["vpo_item_tax2"];
			  $vpo_item_total = $row_value["vpo_item_total"];
			  $vpo_item_received = $row_value["vpo_item_received"];
			  $vpo_item_available = $row_value["vpo_item_available"];
			  $vpo_item_returned_qty = $row_value["vpo_item_returned_qty"];
			  $vpo_item_difference = $row_value["vpo_item_difference"];
			  $vpo_item_expirydate = $row_value["vpo_item_expirydate"];
			  $vpo_item_grn_status = $row_value["vpo_item_grn_status"];
			  $status = $row_value["status"];
			  $product_code = getPRODUCTDETAIL($prdt_id, 'code');
			  $product_name = getPRODUCTDETAIL($prdt_id, 'name');
			  ?>
				<tr>
					<td class="wd-5p text-center">
						<?php echo $counter_value; ?>
						
						<input type="hidden" value="<?php echo $vpo_item_id; ?>" name="item_id[]" />

						<input type="hidden" value="<?php echo $vpo_item_grn_status; ?>" name="grn_status[]" />

						<input type="hidden" value="<?php echo $prdt_id; ?>" name="prdt_id[]" />

						<input type="hidden" value="<?php echo $vpo_item_qty; ?>" name="requested_qty[]" />
						
						<input type="hidden" value="<?php echo $vpo_item_price; ?>" name="vpo_item_price[]" />
						
						<input type="hidden" value="<?php echo $vpo_item_tax; ?>" name="vpo_item_tax[]" />
					</td>
					<td><?php echo $product_code; ?></td>
					<td><?php echo $product_name; ?></td>
					<td class="text-center"><?php echo $vpo_item_received; ?></td>
					<td class="text-center"><?php echo $vpo_item_available; ?></td>
					<?php if($vpo_item_grn_status == '1') { ?>
					<td class="text-center"><?php echo $vpo_item_returned_qty; ?></td>
					<?php } ?>
					<td class="wd-20p"><input type="text"  class="form-control" name="received_qty[]" max="<?php echo $vpo_item_received; ?>" id="received_qty[]" <?php if($vpo_item_qty == $vpo_item_returned_qty) { ?> readonly <?php } ?> value="<?php echo $vpo_item_available; ?> " autocomplete="off">
					</td>
				</tr>
			<?php } ?>
			   </tbody>
			</table>
		</div>
		<div class="row">
			<div class="form-group col-sm-4">
				<label class="control-label">Returned By<span class="text-danger">*</span></label>
				<input type="text" class="form-control" required data-parsley-pattern="^[a-zA-Z ]+$" data-parsley-whitespace="trim" data-parsley-trigger="keyup" name="vpor_returnedby" id="vpor_returnedby">
			</div>
		</div>	
		<div class="row">	
		
			<div class="form-group col-sm-8">
			
				<label class="control-label">Remarks</label>
				
				<textarea type="text" class="form-control"  name="vpo_grn_remarks" id="vpo_grn_remarks" rows="4"></textarea>
				
			</div>
			
		</div>
		<div class="row">	
			<div class="col-md-4 offset-sm-5">	
				<input type="hidden" id="po_id" name="po_id" value="<?php echo $get_vpo_id; ?>" />

				<input type="hidden" id="po_no" name="po_no" value="<?php echo $selected_vpor_no; ?>" />

				<input type="hidden" id="po_vendor_id" name="po_vendor_id" value="<?php echo $vendor_id; ?>" />

				<input type="hidden" id="po_vendor_status" name="po_vendor_status" value="<?php echo $status; ?>" />

				<button type="submit" id="save" name="save" value="generate-GRN" class="btn btn-primary ember-view">Confirm Return</button>
			
				<a href="vendorsporeturn.php" id="cancel" name="cancel" value="cancel" class="btn btn-secondary ember-view">Cancel</a>
			</div>
		</div>
						<?php } ?>
				<!-- End of BASIC -->
				</form>
			  </div><!-- col -->
            </div><!-- row -->
        </div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->   