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

	if($_POST['button'] == 'quick_update')
	{
		$quick_status = $_POST['quick_status'];
		$receivedamt = $_POST['receivedamt'];
		$payment_receiveddate = $_POST['payment_date'];
		$vpor_id = $_POST['vpor_id'];
		$changed_receiveddate = dateformat_database($payment_receiveddate);
		
		$payment_type = $_POST['payment_type'];
		$balance = $_POST['balance'];
		$bill_log = $_POST['bill_log'];

		$request_status = $_POST['request_status'];
		$request_vpor_no = $_POST['request_vpor_no'];
		$request_totalamount = $_POST['request_totalamount'];
		$request_paid = $_POST['request_paid'];
		$request_balance = $_POST['request_balance'];
		$request_sentdate = $_POST['request_sentdate'];

		if($receivedamt >0 && $receivedamt > $request_balance) {
			$err[] = "Please check RECEIVED AMOUNT ($receivedamt) is Greater than BALANCE ($request_balance)";
		}		
		
		if($receivedamt == '0') {
			$new_paidamt = $request_paid;
			$new_balance = $request_balance;
		} else if($receivedamt > 0) {
			$new_paidamt = $request_paid+$receivedamt;			
			$new_balance = $balance;
		}
		
	if(empty($err)) {	
		
		
		if($receivedamt > 0) {
			
			//updating payment status
			$updated_payment_log = "Received ".$receivedamt." on ".date('d-m-Y');			
		
			//updating payment received LOG
			if($updated_payment_log) {
				$updated_payment_log = htmlentities($updated_payment_log, ENT_COMPAT, "UTF-8");
				trim ($updated_payment_log);
		
				//`vporlog_id`, `vpor_no`, `vporlog_type`, `vporlog_desc`, `vporlog_createdby`, `vporlog_createdon`, `deleted` FROM `adisil_vendor_po_returnlog`
				$update_bill_log = sqlQUERY_LABEL("INSERT INTO `js_vendor_po_returnlog`(`vpor_no`, `vporlog_type`, `vporlog_desc`, `vporlog_createdby`, `createdon`) VALUES ('$request_vpor_no','1','$updated_payment_log','$logged_user_id', now())") or die("unable to create log:". sqlERROR_LABEL());			
			}

			//`vpor_id`, `vpor_no`, `vpor_date`, `vpor_sent`, `vpor_received`, `vendor_id`, `prdttype_id`, `vpor_tot_items`, `vpor_tot_qty`, `vpor_tot_value`, `vpor_tot_discount`, `vpor_tot_tax`, `vpor_tot_paid`, `vpor_tot_balance`, `vpor_createdon`, `vpor_updatedon`, `status`, `deleted` FROM `adisil_vendor_po_return`					
			sqlQUERY_LABEL("UPDATE `js_vendor_po_return` SET `vpor_tot_paid`='$new_paidamt', `vpor_tot_balance`='$new_balance' WHERE vpor_no = '$request_vpor_no'") or die("unable to update po: ".sqlERROR_LABEL());
				

			/**************** UPDATING PAYMENT DETAILS ************************/
						
				//`vpor_payment_id`, `vpor_no`, `au_id`, `vendor_id`, `vpor_payment_amt`, `vpor_payment_no`, `vpor_payment_date`, `vpor_payment_mode`, `vpor_payment_status`, `vpor_payment_memo`, `createdon`, `deleted` FROM `adisil_vendor_po_return_payments`
				sqlQUERY_LABEL("INSERT into `js_vendor_po_return_payments` (`vpor_no`, `au_id`, `vendor_id`, `vpor_payment_amt`, `vpor_payment_date`, `vpor_payment_mode`, `createdby`, `status`,  `vpor_payment_memo`, `createdon`) VALUES  ('$request_vpor_no', '$logged_user_id', '$vendor_id', '$receivedamt', '$changed_receiveddate', '$payment_type','$logged_user_id','1', '$bill_log', '".date('Y-m-d H:i:s')."')") or die("Unable to insert PO: ".sqlERROR_LABEL());
							
				//UPDATING LOG
				$payment_received_description = "Payment Received for Invoice #$request_vpor_no on $payment_receiveddate";
					
				//`vporlog_id`, `vpor_no`, `vporlog_type`, `vporlog_desc`, `vporlog_createdby`, `vporlog_createdon`, `deleted` FROM `adisil_vendor_po_returnlog`
				$update_invoice_log = sqlQUERY_LABEL("INSERT INTO `js_vendor_po_returnlog`(`vpor_no`, `vporlog_type`, `vporlog_desc`, `vporlog_createdby`, `createdon`) VALUES ('$request_vpor_no', '1', '$payment_received_description', '$logged_user_id', now())") or die("unable to create log:". sqlERROR_LABEL());			
														
			/**************** END OF UPDATING PAYMENT DETAILS ************************/							
		}	
		
		//check if status updated
		// if($request_status != $quick_status || $vposent_date != $request_sentdate) {
			
			// if($vporeceived_date != $request_receiveddate) {
				// $filterreceived_date = ", `vpor_received`='$vporeceived_date'";
			// }			
			// if($vposent_date != $request_sentdate) {
				// $filtersent_date = ", `vpor_sent`='$vposent_date'";
			// }

			// $vendor_po_update = sqlQUERY_LABEL("UPDATE `js_vendor_po_return` SET `status`='$quick_status'{$filterreceived_date} {$filtersent_date} WHERE vpor_no = '$request_vpor_no'") or die("unable to update vpo status: ".sqlERROR_LABEL());			
			
			// if($vendor_po_update) {
				// if($bill_log =='' && $request_status != $quick_status) {
					// $updated_bill_log = "Vendor PO status changed to REturned ";
				// } elseif($bill_log !='') {
					// $updated_bill_log = $bill_log;			
				// }
				
				// //updating LOG
				// $updated_bill_log = htmlentities($updated_bill_log, ENT_COMPAT, "UTF-8");
				// trim ($updated_bill_log);
				
				// //updating status change log
				// $update_bill_log = sqlQUERY_LABEL("INSERT INTO `js_vendor_po_returnlog`(`vpor_no`, `vporlog_type`, `vporlog_desc`, `vporlog_createdby`, `createdon`) VALUES ('$request_vpor_no','1','$updated_bill_log','$customer_id', now())") or die("unable to create log:". sqlERROR_LABEL());			
			// }
		// }
		
		//starr of master stocck
		
		if($quick_status == '1' && $request_status != $quick_status) {
		/************
		Reducing stock from branch stock
		************/
			$selectinvoice_itemlist = sqlQUERY_LABEL("SELECT `vpor_item_id`, `prdt_id`, `vpor_item_qty` FROM `js_vendor_po_return_items` WHERE `vpor_id` = '$vpor_id'") or die(sqlERROR_LABEL());
			$count_invoice_itemlist = sqlNUMOFROW_LABEL($selectinvoice_itemlist);
		
			if($count_invoice_itemlist > 0) {
				
				while($collect_invoiceitem_list = sqlFETCHARRAY_LABEL($selectinvoice_itemlist)) {
					
					$product_branchstock_id = $collect_invoiceitem_list['vpor_item_id'];
					$product_id = $collect_invoiceitem_list['prdt_id'];
					$product_item_qty = $collect_invoiceitem_list['vpor_item_qty'];					
					
					if($product_item_qty > '0') {
						
							//Update master stock		
						
								$check_product_stock = sqlQUERY_LABEL("select `prdt_openingstock`, `prdt_remaining`, `prdt_returned` from js_product where prdt_id='$product_id'") or die(sqlERROR_LABEL());
								while($collect_product_stock = sqlFETCHARRAY_LABEL($check_product_stock)) {
									$old_openingmstock = $collect_product_stock['prdt_openingstock'];
									$old_remainingmstock = $collect_product_stock['prdt_remaining'];
									$old_pdtreturnedmstock = $collect_product_stock['prdt_returned'];	
										//adding new stock data
										//$new_openingstock = ($old_openingstock + $selected_QTY);
										$new_remainingmstock = ($old_remainingmstock - $product_item_qty);
										$new_returnedmstock = ($old_pdtreturnedmstock + $product_item_qty);
										//echo "Update adisil_product set `prdt_remaining`='$new_remainingstock' where `prdt_id`='$product_id'";
										//echo '<br />';
										
										$productmaster_stock_item = sqlQUERY_LABEL("Update js_product set `prdt_remaining`='$new_remainingmstock',`prdt_returned`='$new_returnedmstock' where `prdt_id`='$product_id'") or die("unable to update ITEM STOCK".sqlERROR_LABEL());
										
										//Product Log
										$log_description = "$product_item_qty - Stock reduced for VendorPO return request #$request_vpor_no";
										
										//echo 'LOG : <br />';
										//echo "INSERT into `adisil_product_log` (`prdt_id`, `prdtlog_desc`, `prdtlog_createdby`) VALUES  ('$selected_PRDTID', '$log_description', '$customer_id')<br />";
										$sql_insert = sqlQUERY_LABEL("INSERT into `js_product_log` (`prdt_id`, `prdtlog_desc`, `prdtlog_createdby`) VALUES  ('$product_id', '$log_description', '$logged_user_id')") or die("Product Logs Insertion: ".sqlERROR_LABEL());
								
							}
																
						}
						
					} //END OF GRNS STATUS
				
				} //END OF WHILE LOOP - PURCHASE RETURN ITEM	
				
			} //END OF PURCHASE RETURN COUNT
		
		//end of master stock
			
			echo "<div style='width: 350px; text-align: center; margin: 20% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update loading...</div>";
			echo "<script type='text/javascript'>window.location = 'vendorsporeturn.php?route=list&formtype=preview&id=$vpor_id'</script>";	
			exit();

		}
	}			   	   


?>
    <div class="content">
      <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
	     <?php  if($formtype==''){ ?>
        <div class="row">
          <div class="col-lg-12">
            <div class="row row-xs mg-b-25">

			<div data-label="Example" class="df-example demo-table table-responsive">
			  <table id="returnLIST" class="table table-bordered" width="100%">
			    <thead>
			        <tr>
                  <th class="wd-5p"><?php echo $__contentsno ?></th>
			            <th>POR.No</th>
			            <th>POR Date</th>
			            <th>VPO. Ref. No</th>
			            <th>Status</th>
			            <th class="wd-15p"><?php echo $__options ?></th>
			        </tr>
			    </thead>
			</table>
			</div>

            </div><!-- row -->
          </div><!-- col -->

          <?php 
	          //include viewpath('__vendorsporeturnsidebar.php'); 
          ?>

        </div><!-- row -->
		<?php } if($formtype=='preview'){ 
		
  $list_parentcategory_datas = sqlQUERY_LABEL("SELECT * FROM `js_vendor_po_return` where `vpor_id` = '$id'") or die("#1-Unable to get records:".sqlERROR_LABEL());

  $count_parentcateogry_list = sqlNUMOFROW_LABEL($list_parentcategory_datas);

	  while($row = sqlFETCHARRAY_LABEL($list_parentcategory_datas)){
		  	
	  $vpor_id = $row["vpor_id"];
	  $vpor_no = $row["vpor_no"];
	  $vpor_vpo_ref_no = $row['vpo_ref_no'];
	  $get_vpo_id = getVENDORPOdetails($vpor_vpo_ref_no,'vpoid','');
	  //$split_vpo_ref_no_1 = (explode("-",$vpor_vpo_ref_no)[0]);
	  //$split_vpo_ref_no_2 = (explode("-",$vpor_vpo_ref_no)[1]);
	  //$split_vpo_id = (explode("-",$vpor_vpo_ref_no)[2]);
	  //$selected_vpor_vpo_ref_no = $split_vpo_ref_no_1.'-'.$split_vpo_ref_no_2;
	  $vendor_id = $row["vendor_id"];
	  $vpor_date = dateformat_datepicker($row["vpor_date"]);
	  $vpor_sent = dateformat_datepicker($row["vpor_sent"]);
	  $vpor_received = $row["vpor_received"];
	  $vpor_returnedby = $row["vpor_returnedby"];
	  $vpor_grn_on = $row["vpor_grn_on"];
	  $vpor_grn_status = $row["vpor_grn_status"];
	  $prdttype_id = $row["prdttype_id"];
	  $vpor_tot_items = $row["vpor_tot_items"];
	  $vpor_tot_qty = $row["vpor_tot_qty"];
	  $vpor_tot_value = $row["vpor_tot_value"];
	  $vpor_tot_discount = $row["vpor_tot_discount"];
	  $vpor_tot_tax = $row["vpor_tot_tax"];
	  $vpor_tot_paid = $row["vpor_tot_paid"];
	  $vpor_tot_balance = $row["vpor_tot_balance"];
	  $vpor_dispatchthrough = $row["vpor_dispatchthrough"];
	  $vpor_approvedby = $row["vpor_approvedby"];
	  $vpor_deliveredby = $row["vpor_deliveredby"];
	  $vpor_receivedby = $row["vpor_receivedby"];
	  $status = $row["status"]; 
	  $vendorname = getVENDORNAME($vendor_id,'label');
	  
	  }

			$list_vendorpoitems_data = sqlQUERY_LABEL("SELECT sum(vpo_item_returned_qty) as PO_RETURNED_ITEM, sum(vpo_item_qty) as PO_ITEM_QTY, vpo_item_grn_status FROM `js_vendor_po_items` where vpo_id='$get_vpo_id' and deleted = '0'") or die("#1-Unable to get PRODUCT CATEGORY:".sqlERROR_LABEL());

			$count_cateogry_list = sqlNUMOFROW_LABEL($list_vendorpoitems_data);
			//$counter_value = '1';
			while($row_value = sqlFETCHARRAY_LABEL($list_vendorpoitems_data)){
			  $counter_value++;
			  $vpo_item_qty = $row_value["PO_ITEM_QTY"];
			  $vpo_item_received = $row_value["vpo_item_received"];
			  $vpo_item_available = $row_value["vpo_item_available"];
			  $vpo_item_returned_qty = $row_value["PO_RETURNED_ITEM"];
			  $vpo_item_grn_status = $row_value["vpo_item_grn_status"];
			} ?>
		
						<style>
							@media only screen and (max-width: 576px) {
							.sm-quick-update{
							margin-top:20px;
							margin-bottom:10px;
							width:100%;
							}
							.sm-quick-update-hide{
							display:none;
							}
							.sm-vendor-info-hide{
							display:none;
							}
							.sm-po-date-hide{
							display:none;
							}
							.sm-po-sent-hide{
							display:none;
							}
							.sm-po-receive-hide{
							display:none;
							}
							}
							@media only screen and (min-width: 1280px) {
							.md-quick-update-hide{
							display:none;
							}
							.md-vendor-info-hide{
							display:none;
							}
							.md-po-date-hide{
							display:none;
							}
							.md-po-sent-hide{
							display:none;
							}
							.md-po-receive-hide{
							display:none;
							}
							}
							</style>
		<div id="stick-here"></div>
		
		<div id="stickThis" class="form-group row mg-b-0">
			
			<div class="col-3 col-sm-6">
			
					<?php pageCANCEL($currentpage, $__cancel); ?>
					
			</div>
					
			<div class="col-9 col-sm-6 text-right">
				<div class="row">
					<div class="col-12 ml-auto">
					<?php if($vpo_item_qty != $vpo_item_returned_qty){ ?>
					<a href="vendorsporeturn.php?route=add&id=<?php echo $id;?>" data-toggle="tooltip" data-original-title="Click to Print" class="btn btn-info btn-md mg-r-2"><i class="fas fa-pencil-alt"></i></a>
					<?php } ?>
						<button class="btn btn-outline-light dropdown-toggle mg-r-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
						<div class="dropdown-menu tx-13">
						  <a class="dropdown-item" href="#" onClick="printINVOICE()">Preview PDF</a>
						  <!-- <a class="dropdown-item" href="#">Send PO</a> -->
						  <a class="dropdown-item" href="#poactivity">PO Activity</a>
						  <!--<a class="dropdown-item" href="#payment-history">Manage Payment</a>-->
						</div>
					
						<a href="javascript:;" onClick="printINVOICE()" data-toggle="tooltip" data-original-title="Click to Print" class="btn btn-warning btn-md mg-r-2"><i class="fa fa-print"></i></a>
						
						<a href="javascript:;" onClick="downloadBILL()" data-toggle="tooltip" data-original-title="Click to Download" class="btn btn-warning btn-md mg-r-2"><i class="fa fa-download"></i></a>
						
						<!--<?php if($vpor_tot_balance > '0'){ ?>
						 <a href="javascript:;" data-toggle="modal" data-target="#quickupdate" data-toggle="tooltip" data-original-title="Click to Download" class="btn btn-success sm-quick-update-hide btn-md"><i class="fa fa-credit-card"></i> Quick Update</a>
						<?php }else { ?>
						<a href="#poactivity" onClick="managepayment()" data-toggle="tooltip" data-original-title="Click to Download" class="btn btn-success sm-quick-update-hide btn-md"><i class="fa fa-credit-card"></i> Manage Payment</a>
						<?php } ?>-->
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<?php if($vpor_tot_balance > '0'){ ?>
				 <a href="javascript:;" data-toggle="modal" data-target="#quickupdate" data-toggle="tooltip" data-original-title="Click to Download" class="btn btn-success md-quick-update-hide sm-quick-update btn-md"><i class="fa fa-credit-card"></i> Quick Update</a>
				<?php }else { ?>
				<a href="#poactivity" onClick="managepayment()" data-toggle="tooltip" data-original-title="Click to Download" class="btn btn-success md-quick-update-hide sm-quick-update btn-md"><i class="fa fa-credit-card"></i> Manage Payment</a>
				<?php } ?>
			</div>
		</div>
				<div class="modal fade" id="quickupdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					<form  method="post" action="">
					  <div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Update PO Status</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					  </div>
					  <div class="modal-body">
							<h6 class="text-left">Payment Details :</h6>
							
							<div class="row">
								<div class="col-12">
								
								<table class="table-bordered table-striped table-hover table">
									<tr >
										<th>Total</th>
										<th>Paid</th>
										<th>Balance</th>
									</tr>
									<tr>
										<td><?php echo general_currency_symbol.' '.moneyFormatIndia($vpor_tot_value); ?></td>
										<td><?php echo general_currency_symbol.' '.moneyFormatIndia($vpor_tot_paid); ?></td>
										<td><?php echo general_currency_symbol.' '.moneyFormatIndia($vpor_tot_balance); ?></td>
									</tr>
								</table>
								
								</div>
							</div>
							
							<div class="row">
							
								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
								
									<div class="form-group">
												
										<label for="payment_date" class="control-label  mg-r-45">Payment Date</label>
										<input type="text" class="form-control" placeholder="DD/MM/YYYY" name="payment_date" id="payment_date" value="<?php echo $payment_date ; ?>">
				
									</div>
									
								</div>
							
								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
								
									<div class="form-group">
												
										<label for="vpo_date" class="control-label  mg-r-45">Payment type</label>
										<select name="payment_type" id="payment_type" class="form-control">
										<?php echo getPAYMENTMODE($vpo_id,'select'); ?>
										</select>
									</div>
									
								</div>
							</div>
							
							<div class="row">
						
								<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"> 
								
									<div class="form-group">
							
									<label for="receivedamt" class="control-label mg-r-20">Received Amount</label>
									<input type="text" class="form-control pay-amt" name="receivedamt" id="receivedamt" onKeyUp="CalcBALACNE(this.form)">
							
								 </div>
								 </div>
								 
								 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 mg-t-10 mg-r-30"> 
									<h5 class="info-label">Total:</h5>
								
									   <input type="hidden" class="form-control" name="balance" id="balance" value="<?php echo general_currency_symbol.' '.moneyFormatIndia($vpor_tot_balance); ?>" required/>

									   <br /><span id="total_balance" style="font-size: 20px; font-weight: bolder;"><?php echo general_currency_symbol.' '.moneyFormatIndia($vpor_tot_balance); ?></span></strong></span>
								 </div>
								 
							</div>
							<div class="row">
						
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								
									<label class="control-label mg-r-90">Notes</label>
									<textarea id="bill_log" class="form-control bill_log" rows="2"> </textarea>
									<input type="hidden" name="request_vpo_no" value="<?php echo $vpor_no; ?>" />

									<input type="hidden" name="vpor_id" value="<?php echo $vpor_id; ?>" />
									<input type="hidden" name="request_vpor_no" value="<?php echo $vpor_no; ?>" />
									<input type="hidden" name="request_status" value="<?php echo $status; ?>" />
									<input type="hidden" name="request_totalamount" value="<?php echo $vpor_tot_value; ?>" />
									<input type="hidden" name="request_paid" value="<?php echo $vpor_tot_paid; ?>" />
									<input type="hidden" name="request_sentdate" value="<?php echo $vpor_sent; ?>" />
									<input type="hidden" name="request_balance" id="request_balance" value="<?php echo $vpor_tot_balance; ?>" />
								</div>
							 </div>
							 
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" name="button" id="save" value="quick_update" class="btn btn-primary">Save</button>
					  </div>
					  </form>
					</div>
				  </div>
				</div>

	<div class="divider-text">Item Particulars</div>

	<div class="row">
	
		<div class="col-md-2 col-sm-12">
			<div class="avatar avatar-xxl mg-b-10"><img src="public/img/signin.png" class="img rounded-circle" alt="Responsive image">
			</div>
		
		</div>

		<div class="col-md-10 mg-t-30">

			<div class="row mg-md-l-100">	
				
				<div class="col-md-auto mg-t-10">
				
					<span><span>Return #:</span> <span class="mg-l-50 mg-md-l-0"><b><?php echo $vpor_no; ?></b></span></span>
					
				</div>
				
				<div class="col-md-auto mg-t-10">		
				
					<span><span>POR Date: </span> <span class="mg-l-60 mg-md-l-0"><b><?php echo $vpor_date; ?></b></span></span>
					
				</div>
				
				<div class="col-md-auto mg-t-10">		
				
					<span><span>VPO Ref. No: </span> <span class="mg-l-60 mg-md-l-0"><b><?php echo $vpor_vpo_ref_no; ?></b></span></span>
					
				</div>
				
				<!--<div class="col-md-auto mg-t-10">	
				
					<span><span>Total Amount: </span> <span class="mg-l-35 mg-md-l-0"><b><?php echo general_currency_symbol.' '.moneyFormatIndia($vpor_tot_value); ?></b></span></span>	
					
				</div>
				
				<div class="col-md-auto mg-t-10">			
				
					<span><span>Balance Amount: </span> <span class="mg-l-15 mg-md-l-0"><b><?php echo general_currency_symbol.' '.moneyFormatIndia($vpor_tot_balance); ?></b></span></span>	
					
				</div>-->
			
			</div>
			
		</div>
		
	</div>

<div class="divider-text">Item Particulars</div>

	<div class="card">
	
		<div class="card-body">
		
			<div class="form-group row">
			
				<div class="col-md-4 mg-b-10 mg-md-b-0 mg-t-40 mg-md-l-50 mg-md-t-0 row md-border-right">
				
					<div class="text-uppercase">
					
					  <span class="col-sm-6 sm-vendor-info-hide text-muted">Vendor Info</span>
					  <span class="col-sm-6 md-vendor-info-hide text-muted">Vendor</span>
					  
					</div>
					
					<div class="mg-md-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
					
					  <span class="mg-md-r-70 mg-md-l-15 mg-l-55"><?php echo $vendorname; ?></span>
					  
					</div>
					
				</div>
				
				<div class="col-md-3 mg-md-l-50 md-border-right sm-po-date-hide">
				
					<div class="text-uppercase">
					
					  <span class="text-muted">P.O.R Date</span>
					  
					</div>
					
					<div class=" mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
					
						  <span class="text-bold"><?php echo ($vpor_date); ?></span>
						  
						</div>
						
				</div>
				
				<div class="col-md-3 row mg-b-10 mg-md-b-0 md-border-right md-po-date-hide">
				
					<div class="text-uppercase">
					
					  <span class="col-sm-6 text-muted mg-md-l-30">P.O.R Date</span>
					  
					</div>
					
					<div class="mg-md-t-10 mg-l-25 text-uppercase" style="letter-spacing: 0.0825em;">
					
						  <span class="col-sm-6"><?php echo ($vpor_date); ?></span>   
					</div>
						
				</div>
				
				<!--<div class="col-md-3 md-border-right sm-po-sent-hide">
				
					<div class="text-uppercase">
					
					  <span class="text-muted" >Returned on</span>
					  
					</div>
					
					<div class=" mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
					
					  <span><?php echo ($vpor_sent); ?></span>
					  
					</div>
					
				</div>
				
				<div class="col-md-3 row mg-b-10 mg-md-b-0 md-border-right md-po-sent-hide">
				
					<div class="text-uppercase">
					
					  <span class="col-sm-6 text-muted">Returned on</span>
					  
					</div>
					
					<div class="mg-md-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
					
					  <span class="col-sm-6"><?php echo ($vpor_sent); ?></span>
					  
					</div>
					
				</div>-->
				<?php if($vpo_item_returned_qty == '0'){ ?>
				<div class="marker  marker-ribbon p-2 marker-secondary marker-top-right pos-absolute t-10 r-0">
				Draft - PO </div>
				<?php } elseif($vpo_item_grn_status != '0' && $vpo_item_returned_qty < $vpo_item_qty && $vpo_item_returned_qty !='0'){ ?>
				<div class="marker  marker-ribbon p-2 marker-warning marker-top-right pos-absolute t-10 r-0">
				Partially Returend - PO </div>
				<?php }elseif($vpo_item_qty == $vpo_item_returned_qty){ ?>
				<div class="marker  marker-ribbon p-2 marker-danger marker-top-right pos-absolute t-10 r-0">
				Returned - PO </div>
				<?php } ?>
				<div class="col-md-3 sm-po-receive-hide">
				
					<div class="text-uppercase">
					
					  <span class="text-muted">Returned By</span>
					  
					</div>
					
					<div class=" mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
					
					  <span><?php echo $vpor_returnedby ?></span>
					  
					</div>
					
				</div>
				
				<div class="col-md-3 md-po-receive-hide">
				
					<div class="text-uppercase">
					
					  <span class="text-muted">Returned By :</span>
					  
					</div>
					
					<div class="mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
					
					  <span><?php echo $vpor_returnedby; ?></span>
					  
					</div>
					
				</div>
			
				
			</div>
			
		</div>
		
	</div>
	
									
				<div class="divider-text">payment receiving details</div>				
						<div class="mg-t-20">
							<table class="table table-bordered table-hover mg-r-0 table-responsive">
							   <thead class="thead bg-gray-200">
								  <tr>
                                        <th rowspan="2" class="text-center wd-5p">#</th>
                                        <th class="wd-15p" rowspan="2">Product Code</th>
                                        <th class="wd-20p" rowspan="2">Product Name</th>
                                        <th colspan="4" class="text-center">Qty</th>
                                        <th class="text-center wd-10p">Item Price</th>
                                        <th colspan="3" class="text-center wd-5p">Tax</th>
                                        <th class="text-center wd-10p">Item Total</th>
                                        
                                    </tr>
                                    <tr>
                                        <th class="text-center wd-5p small">Requested</th>
                                        <th class="text-center wd-5p small">Received</th>
                                        <th class="text-center wd-5p small">Available</th>
                                        <th class="text-center wd-5p small">Returned</th>
                                        <th class="text-center wd-10p small">(in ₹)</th>
                                        <th class="text-center wd-5p small">%</th>
                                        <th class="text-center wd-10p small">CGST</th>
                                        <th class="text-center wd-10p small">SGST</th>
                                        <th class="text-center wd-10p small" style="border-right-width:1px;">(in ₹)</th>
                                    </tr>
							   </thead>
	
							   <tbody id="fetch_amcparticular">
				
			   <?php  
			$list_vendorpoitems_data = sqlQUERY_LABEL("SELECT * FROM `js_vendor_po_items` where vpo_id='$get_vpo_id' and deleted = '0'") or die("#1-Unable to get PRODUCT CATEGORY:".sqlERROR_LABEL());

			$count_cateogry_list = sqlNUMOFROW_LABEL($list_vendorpoitems_data);
			//$counter_value = '1';
			while($row_value = sqlFETCHARRAY_LABEL($list_vendorpoitems_data)){
			  $counter_value_new++;
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
									<td><?php echo $counter_value_new; ?></td>
									<td><?php echo $product_code; ?></td>
									<td><?php echo $product_name; ?></td>
									<td class="text-center"><?php echo $vpo_item_qty; ?></td>
									<td class="text-center"><?php echo $vpo_item_received; ?></td>
									<td class="text-center"><?php echo $vpo_item_available; ?></td>
									<td class="text-center"><?php echo $vpo_item_returned_qty; ?></td>
									<td class="text-right"><?php echo moneyFormatIndia($vpo_item_price); ?></td>
									<td><?php echo $vpo_item_tax; ?></td>
									<td class="text-right"><?php echo moneyFormatIndia($vpo_item_tax1); ?></td>
									<td class="text-right"><?php echo moneyFormatIndia($vpo_item_tax2); ?></td>
									<td class="text-right"><?php echo moneyFormatIndia($vpo_item_total); ?></td>
								</tr>
								
			<?php } ?>
							   </tbody>
				
							</table>
						</div>	
						
	<div class="row ">
		<div class="col-md-12 col-sm-12">
							
			<button type="button" class="btn btn-warning mg-r-10 btn-icon float-right" onClick="printINVOICE()">
			  <i class="fa fa-print"></i>
			</button>
			
			<button type="button" class="btn btn-warning mg-r-10  btn-icon float-right" onClick="downloadBILL()">
			  <i class="fa fa-download"></i>
			</button>
			
		</div>
		
	</div>
	
	<div class="row">
		
		<div class="col-md-12 col-sm-12">
		
			<div class="divider-text">Activity Log</div>
			

			<div class="card">
			
				<div class="card-header tx-bold bg-gray-300 ">
				
				PO Activity

				</div>
			
				<div class="card-body tx-dark bg-light" id="poactivity">
				
					<?php
							
			  $list_poactivity_datas = sqlQUERY_LABEL("SELECT * FROM `js_vendor_po_returnlog` where vpor_no = '$vpor_no' order by vporlog_id desc") or die("#1-Unable to get records:".sqlERROR_LABEL());
			  
			  $count_parentcategory_list = sqlNUMOFROW_LABEL($list_poactivity_datas);

				  while($row_data = sqlFETCHARRAY_LABEL($list_poactivity_datas)){
					
				  $vporlog_id = $row_data["vporlog_id"];
				  $vporlog_type = $row_data["vporlog_type"];
				  $vpor_no = $row_data["vpor_no"];
				  $vporlog_desc = $row_data["vporlog_desc"];
				  $vporlog_remarks = $row_data["vporlog_remarks"];
				  $vporlog_createdby = $row_data["vporlog_createdby"];
				  $status = $row_data["status"];
				  $logdate = date("D, d M, Y h:i:s");
				  
	  ?>

	  <?php echo $logdate; ?> - <?php echo $vporlog_desc;  ?> by <?php echo getUSERNAME($vporlog_createdby,'user_name'); ?> <br><br>
	  <?php echo $logdate; ?> - <?php echo $vporlog_remarks;  ?> by <?php echo getUSERNAME($vporlog_createdby,'user_name'); ?> <br><br>

	  <?php } ?>
				
				</div>
				
			</div>
			
		</div>
		
	</div>
	
	<!--<div class="row mg-t-10">
		
		<div class="col-md-12 col-sm-12">
			
			<div class="card tx-dark bg-light">
				
				<div class="card-header tx-bold bg-gray-300">
				PO Payment History
				</div>
				
				<div class="card-body tx-dark bg-light" id="payment-history">
					<ul class="list-unstyled">
						<?php
								//echo "SELECT * FROM `js_vendor_po_payments`  where vpo_no='$vpo_no' order by vpo_payment_id DESC" ;exit();
								$collect_payment_details =sqlQUERY_LABEL("SELECT * FROM `js_vendor_po_return_payments` where vpor_no = '$vpor_no' order by vpor_payment_id DESC") or die("#1-Unable to get records:".sqlERROR_LABEL());
                              $count_parentcategory_list = sqlNUMOFROW_LABEL($collect_payment_details); 
                               while($row_data = sqlFETCHARRAY_LABEL($collect_payment_details)) 
								 {
									
									$vpor_payment_amt = $general_currency_code.' '.moneyFormatIndia($row_data['vpor_payment_amt']); 
									$vpor_payment_date = $row_data['vpor_payment_date'];
									$vpor_payment_mode = $row_data['vpor_payment_mode'];
									$vpor_payment_memo = $row_data['vpor_payment_memo'];
									$vporlog_createdon= $row_data['createdon'];
									$createon_timestamp = strtotime($vporlog_createdon);
									$create_ON = date('D, d M, Y H:i:s', $createon_timestamp);
								?>
								<li class="col-md-10">
								<p>
								<span class="small"><?php echo dateformat_datepicker($vpor_payment_date).' - '.$vpor_payment_amt.' - '.$vpor_payment_mode; ?></span>
                                <span class="small"><?php echo $create_ON; ?></span>
                                 - <?php echo $vpor_payment_memo; ?> <span class="text-muted">by <?php echo getUSERNAME($vporlog_createdby,'user_name'); ?></span> 
								</p>
								</li>
								<?php
								}
								?>	
					</ul>
				</div>
			</div>
			
		</div>
		
	</div>-->
		
	</div>	
		
		<?php } ?>
      </div><!-- container -->
    </div><!-- content -->