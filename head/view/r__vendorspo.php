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

if($button == 'approve'){

	if(isset($vpo_item)){
		$count = count($_REQUEST["vpo_item"]);
 		foreach ($vpo_item as $key => $val) {
			$selected_ITEMID = $vpo_item[$key];
			$arrFields=array('`vpo_item_approved`');
			$arrValues=array("1");
			$sqlwhere = "vpo_item_id=$selected_ITEMID";
			//print_r($arrValues); exit();
			if(sqlACTIONS("UPDATE","js_vendor_po_items",$arrFields,$arrValues,$sqlwhere)) {
			}
			
		}
		//approve status 2
		$arrFields=array('`status`');
		$arrValues=array("5");
		$sqlwhere = "vpo_id=$id";
		//print_r($arrValues); exit();
		if(sqlACTIONS("UPDATE","js_vendorpo",$arrFields,$arrValues,$sqlwhere)) {
		}
		//notification message
			//notificationid,title,msg,user_id,status
			$vendorpo_no= getREFNO($id,'vendorpo');
			//$log_msg ="Requested Vendor PO is approved #".$vendorpo_no;
			//$notification_insert = create_notification('4','Vendor PO',$log_msg,$logged_user_id,'1');

			$update_po_log = sqlQUERY_LABEL("INSERT INTO `js_vendor_polog`(`vpo_no`, `vpolog_type`, `vpolog_desc`, `vpolog_createdby`, `vpolog_createdon`) VALUES ('$vendorpo_no','0','$log_msg','$logged_user_id', now())") or die("unable to create log:". sqlERROR_LABEL());			

			$list_emailtemplates_data = sqlQUERY_LABEL("SELECT * FROM `js_emailtemplate` where  `template_ID`='9' and deleted = '0' ") or die("Unable to get records:".sqlERROR_LABEL());			
	$check_record_availabity = sqlNUMOFROW_LABEL($list_emailtemplates_data);			

	while($row_et = sqlFETCHARRAY_LABEL($list_emailtemplates_data)){
	  $template_ID = $row_et["template_ID"];
	  $template_name = $row_et["template_name"];
	  $email_subject = $row_et["email_subject"];
	  $default_message = $row_et["default_message"];
	  $custom_message = html_entity_decode(stripslashes($row_et["custom_message"]));
	  
	}

		// $vpo_approval = getsettingSTATUS(13);
		// if($vpo_approval == '1'){
								

						// $pdf_name ='praveen';
						// $subject = 'Vendor PO Request Approved';
						// $to = $admin_emailid;//
						// $Bcc = $bcc_emailid;
					    // $cc = $cc_emailid;
					    // $from = "ArmTech ERP <notification@armtecherp.com>";
					   // $message_template = '<div style="padding: 0; margin: 0;">
// <table style="background: #dfe5e9; font-family: Arial; font-size: 14px; line-height: 20px;" border="0" width="100%" cellspacing="0" cellpadding="0">
// <tbody>
// <tr>
// <td height="50">&nbsp;</td>
// </tr>
// <tr>
// <td>
// <table border="0" width="100%" cellspacing="0" cellpadding="0">
// <tbody>
// <tr>
// <td>&nbsp;</td>
// <td style="background: white; padding: 35px 66px 32px 66px;" width="468">
// <table style="table-layout: fixed; word-wrap: break-word;" width="100%">
// <tbody>
// <tr>
// <td style="font-weight: bold;" align="center" valign="top" height="50"><u>'.$email_subject.'</u></td>
// </tr>
// <tr>
// <td style="font-weight: bold;"><p>Dear Staff,</p></td>
// </tr>

// <tr>

// <td style="padding-bottom: 5px;">'.$custom_message.'</td><br/><br/>
// </tr>


// </tbody>
// </table>
// </td>
// <td>&nbsp;</td>
// </tr>
// </tbody>
// </table>
// </td>
// </tr>
// <tr>
// <td>
// <table style="text-align: center; font-size: 12px;" border="0" width="100%" cellspacing="0" cellpadding="0">
// <tbody>
// <tr>
// <td style="padding: 20px 0 14px 0;">This is a product of Touchmark Descience Pvt Ltd.</td>
// </tr>
// <tr>
// <td style="padding-top: 16px;">&copy; 2010-2020. All rights reserved.</td>
// </tr>
// <tr>
// <td height="30">&nbsp;</td>
// </tr>
// </tbody>
// </table>
// </td>
// </tr>
// </tbody>
// </table>
// <div class="yj6qo">&nbsp;</div>
// <div class="adL">&nbsp;</div>
// </div>';
// //echo $message_template; exit();

						 
			// send_mail($from,$to,$cc,$Bcc,$subject,$message_template);
// //email ends

			// }
	
		
	}

  	echo "<div style='width: 350px; text-align: center; margin: 20% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Nothing to update here, you will be taken back now. Please wait while load this...</div>";
		echo "<script type='text/javascript'>window.location = 'vendorspo.php?route=preview&formtype=preview&id=$id'</script>";
}

	if($_POST['button'] == 'quick_update')

	{

		$quick_status = $_POST['quick_status'];

		$receivedamt = $_POST['receivedamt'];

		$payment_receiveddate = $_POST['payment_date'];

		$changed_receiveddate = dateformat_database($payment_receiveddate);

		

		if($_POST['vpo_sent'] == '--' || $_POST['vpo_sent'] == '') {

			$vposent_date = '0000-00-00';

		} else {

			$vposent_date = dateformat_database($_POST['vpo_sent']);

		}

		

		if($_POST['vpo_received'] == '--') {

			$vporeceived_date = '0000-00-00';

		} else {

			$vporeceived_date = dateformat_database($_POST['vpo_received']);

		}

		

		$payment_type = $_POST['payment_type'];

		$balance = $_POST['balance'];

		$bill_log = $_POST['bill_log'];



		$request_status = $_POST['request_status'];

		$request_vpo_no = $_POST['request_vpo_no'];

		$request_totalamount = $_POST['request_totalamount'];

		$request_paid = $_POST['request_paid'];

		$request_balance = $_POST['request_balance'];

		$request_sentdate = $_POST['request_sentdate'];

		$request_receiveddate = $_POST['request_receiveddate'];



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

				//`vpolog_id`, `vpo_no`, `vpolog_type`, `vpolog_desc`, `vpolog_createdby`, `vpolog_createdon`, `deleted` FROM `adisil_vendor_polog`

				$update_bill_log = sqlQUERY_LABEL("INSERT INTO `js_vendor_polog`(`vpo_no`, `vpolog_type`, `vpolog_desc`, `vpolog_createdby`, `vpolog_createdon`) VALUES ('$request_vpo_no','1','$updated_payment_log','$logged_user_id', now())") or die("unable to create log:". sqlERROR_LABEL());			

			}

			//`vpo_id`, `vpo_no`, `vpo_date`, `vpo_sent`, `vpo_received`, `vendor_id`, `prdttype_id`, `vpo_tot_items`, `vpo_tot_qty`, `vpo_tot_value`, `vpo_tot_discount`, `vpo_tot_tax`, `vpo_tot_paid`, `vpo_tot_balance`, `vpo_createdon`, `vpo_updatedon`, `status`, `deleted` FROM `adisil_vendor_po`					

			sqlQUERY_LABEL("UPDATE `js_vendorpo` SET `vpo_tot_paid`='$new_paidamt', `vpo_tot_balance`='$new_balance' WHERE vpo_no = '$request_vpo_no'") or die("unable to update po: ".sqlERROR_LABEL());

				
			/**************** UPDATING PAYMENT DETAILS ************************/

				//`vpo_payment_id`, `vpo_no`, `au_id`, `vendor_id`, `vpo_payment_amt`, `vpo_payment_no`, `vpo_payment_date`, `vpo_payment_mode`, `vpo_payment_status`, `vpo_payment_memo`, `createdon`, `deleted` FROM `adisil_vendor_po_payments`

				sqlQUERY_LABEL("INSERT into `js_vendor_po_payments` (`vpo_no`, `au_id`, `vendor_id`, `vpo_payment_amt`, `vpo_payment_date`, `vpo_payment_mode`,`createdby`,  `vpo_payment_memo`, `createdon`) VALUES  ('$request_vpo_no', '$logged_user_id', '$vendor_id','$receivedamt', '$changed_receiveddate', '$payment_type','$logged_user_id', '$bill_log', '".date('Y-m-d H:i:s')."')") or die("Unable to insert PO: ".sqlERROR_LABEL());

				//UPDATING LOG

				$payment_received_description = "Payment Received for Invoice #$request_vpo_no on $payment_receiveddate";

				//`vpolog_id`, `vpo_no`, `vpolog_type`, `vpolog_desc`, `vpolog_createdby`, `vpolog_createdon`, `deleted` FROM `adisil_vendor_polog`

				$update_invoice_log = sqlQUERY_LABEL("INSERT INTO `js_vendor_polog`(`vpo_no`, `vpolog_type`, `vpolog_desc`, `vpolog_createdby`, `vpolog_createdon`) VALUES ('$request_vpo_no', '1', '$payment_received_description', '$logged_user_id', now())") or die("unable to create log:". sqlERROR_LABEL());			

														

			/**************** END OF UPDATING PAYMENT DETAILS ************************/							

		}

		//check if status updated

		if($request_status != $quick_status || $vporeceived_date != $request_receiveddate || $vposent_date != $request_sentdate) {

			if($vporeceived_date != $request_receiveddate) {

				$filterreceived_date = ", `vpo_received`='$vporeceived_date'";

			}			

			if($vposent_date != $request_sentdate) {

				$filtersent_date = ", `vpo_sent`='$vposent_date'";

			}

			$vendor_po_update = sqlQUERY_LABEL("UPDATE `js_vendorpo` SET `status`='$quick_status'{$filterreceived_date} {$filtersent_date} WHERE vpo_no = '$request_vpo_no'") or die("unable to update vpo status: ".sqlERROR_LABEL());			

			if($vendor_po_update) {

				if($bill_log =='' && $request_status != $quick_status) {

					$updated_bill_log = "Vendor PO status changed to ".strtoupper(getVendorStatus($quick_status,'vendorpolabel'))."";

				} elseif($bill_log !='') {

					$updated_bill_log = $bill_log;			

				}

				//updating LOG

				$updated_bill_log = htmlentities($updated_bill_log, ENT_COMPAT, "UTF-8");

				trim ($updated_bill_log);

				//updating status change log

				$update_bill_log = sqlQUERY_LABEL("INSERT INTO `js_vendor_polog`(`vpo_no`, `vpolog_type`, `vpolog_desc`, `vpolog_createdby`, `vpolog_createdon`) VALUES ('$request_vpo_no','1','$updated_bill_log','$logged_user_id', now())") or die("unable to create log:". sqlERROR_LABEL());			

			}

		}

			

			echo "<div style='width: 350px; text-align: center; margin: 20% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update loading...</div>";

			echo "<script type='text/javascript'>window.location = 'vendorspo.php?route=list&formtype=preview&id=$vpo_id'</script>";	

			exit();



		}

	}	


	if($_POST['save'] == 'generate-GRN') {



		$selected_itemid = $_POST['item_id'];

		$po_id = $_POST['po_id']; 

		$po_no = $_POST['po_no'];

		$po_vendor_id = $_POST['po_vendor_id'];

		$vpo_grn_on = date('Y/m/d');

		$vpo_invoice_date = sqlREALESCAPESTRING_LABEL($_POST['vpo_invoice_date']);
		
		$vpo_invoice_date = dateformat_database($vpo_invoice_date);
		
		$vpo_invoice_ref_no = sqlREALESCAPESTRING_LABEL($_POST['vpo_invoice_ref_no']);
		
		$vpo_grn_ref_no = sqlREALESCAPESTRING_LABEL($_POST['vpo_grn_ref_no']);
		
		$vpo_dispatchthrough = sqlREALESCAPESTRING_LABEL($_POST['vpo_dispatchthrough']);

		$vpo_approvedby = sqlREALESCAPESTRING_LABEL($_POST['vpo_approvedby']);

		$vpo_deliveredby = sqlREALESCAPESTRING_LABEL($_POST['vpo_deliveredby']);

		$vpo_receivedby = sqlREALESCAPESTRING_LABEL($_POST['vpo_receivedby']);

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
				if($selected_ITEMID != '') { 
		
				//checking received & requested qty
				//echo "<br />step-1:<br />";
				//echo "SHAREDVALUE:".$selected_ITEMID.'--'.$selected_PRDTID.'--'.$selected_QTY.'--'.$selected_REQUESTEDQTY.'--'.$selected_GRNSTATUS.'--'.$selected_ITEMPRICE.'--'.$selected_ITEMTAX.'<br />';
				//echo "select * from js_vendor_po_items where vpo_item_id='$selected_ITEMID' and vpo_id = '$po_id' and prdt_id='$selected_PRDTID'<br />";

				 $check_product_new_stock = sqlQUERY_LABEL("select * from js_vendor_po_items where vpo_item_id='$selected_ITEMID' and vpo_id = '$po_id' and prdt_id='$selected_PRDTID'") or die(sqlERROR_LABEL());
				 //echo "select * from js_vendor_po_items where prdt_id='$selected_PRDTID'";
					//echo "select * from js_vendor_po_items where prdt_id='$selected_PRDTID'";
					while($row_add_qty = sqlFETCHARRAY_LABEL($check_product_new_stock)){

						$vpo_item_received = $row_add_qty["vpo_item_received"];
						$vpo_item_available = $row_add_qty["vpo_item_available"];
							
							//AUTO-GENERATED VALUES
							$new_receive_qty = ($selected_QTY + $vpo_item_received);	

							$new_received_qty_diff = ($selected_REQUESTEDQTY - $new_receive_qty);

							$new_vpo_item_available = ($selected_QTY + $vpo_item_available);

					}

				 $check_product_new_stock_prdt_tbl = sqlQUERY_LABEL("select productavailablestock, productopeningstock from js_product where  productID='$selected_PRDTID'") or die(sqlERROR_LABEL());
				 //echo "select * from js_vendor_po_items where prdt_id='$selected_PRDTID'";
					//echo "select * from js_vendor_po_items where prdt_id='$selected_PRDTID'";
					while($row_add_qty_prdt_tbl = sqlFETCHARRAY_LABEL($check_product_new_stock_prdt_tbl)){

						$productopeningstock = $row_add_qty_prdt_tbl["productopeningstock"];
						$productavailablestock = $row_add_qty_prdt_tbl["productavailablestock"];
							
							//AUTO-GENERATED VALUES
							$new_prdt_tbl_opening_qty = ($selected_QTY + $productopeningstock);	

							$new_prdt_tbl_available_qty = ($selected_QTY + $productavailablestock);

					}
					
					//echo "<br />step-2:<br />";
					//echo 'received:'.$selected_QTY.'+'.$vpo_item_received.'--Difference:'.$selected_REQUESTEDQTY.'-'.$new_receive_qty.'--Available:'.$selected_QTY.'+'.$vpo_item_available.'<br />';
						// *** Product Log *** //

						$log_description = "$selected_QTY - Stock added from PO #$po_no";

						$sql_insert = sqlQUERY_LABEL("INSERT into `js_product_logs` (`prdt_id`, `prdtlog_desc`, `prdtlog_createdby`) VALUES  ('$selected_PRDTID', '$log_description', '$logged_user_id')") or die("GRN Logs Insertion: ".sqlERROR_LABEL());
						
						// *** VPO STOCK UPDATE *** //

					//echo "<br />step-3:<br />";
					//echo "Update js_vendor_po_items set `vpo_item_received`='$new_receive_qty',`vpo_item_available`='$new_vpo_item_available',  `vpo_item_difference`='$new_received_qty_diff', `vpo_item_expirydate`='$selected_EXPIRY', `vpo_item_grn_status`='1' where vpo_item_id='$selected_ITEMID' and vpo_id = '$po_id' and `prdt_id`='$selected_PRDTID'<br />";
					
						$appstock_item = sqlQUERY_LABEL("Update js_vendor_po_items set `vpo_item_received`='$new_receive_qty',`vpo_item_available`='$new_vpo_item_available',  `vpo_item_difference`='$new_received_qty_diff', `vpo_item_expirydate`='$selected_EXPIRY', `vpo_item_grn_status`='1' where vpo_item_id='$selected_ITEMID' and vpo_id = '$po_id' and `prdt_id`='$selected_PRDTID'") or die("unable to update ITEM STOCK".sqlERROR_LABEL());

						$appstock_item_update_prdt_tbl = sqlQUERY_LABEL("Update js_product set `productavailablestock`='$new_prdt_tbl_available_qty', `productopeningstock`='$new_prdt_tbl_opening_qty' where `productID`='$selected_PRDTID'") or die("unable to update ITEM STOCK".sqlERROR_LABEL());

						// *** PARTIAL GRN STATUS INSERT *** //
					//echo "<br />step-4:<br />";
					//echo "INSERT INTO `js_vpo_prdt_grn_report`(`prdt_id`,`vpo_id`,`vpo_no`,`vpo_item_id`,`vpo_received_qty`, `vpo_grn_on`, `vpo_invoice_date`, `vpo_invoice_ref_no`, `vpo_grn_ref_no`, `vpo_dispatchthrough`, `vpo_approvedby`, `vpo_deliveredby`, `vpo_receivedby`, `vpo_grn_remarks`, `createdby`, `status`,`createdon`) VALUES ('$selected_PRDTID','$po_id','$po_no','$selected_ITEMID','$selected_QTY','$vpo_grn_on','$vpo_invoice_date','$vpo_invoice_ref_no','$vpo_grn_ref_no','$vpo_dispatchthrough','$vpo_approvedby','$vpo_deliveredby','$vpo_receivedby','$vpo_grn_remarks','$logged_user_id','1', now())<br /><br />";
						if($selected_QTY != '' && $selected_QTY != 0) { 
						$insert_vpo_prdt_grn = sqlQUERY_LABEL("INSERT INTO `js_vpo_prdt_grn_report`(`prdt_id`,`vpo_id`,`vpo_no`,`vpo_item_id`,`vpo_received_qty`, `vpo_grn_on`, `vpo_invoice_date`, `vpo_invoice_ref_no`, `vpo_grn_ref_no`, `vpo_dispatchthrough`, `vpo_approvedby`, `vpo_deliveredby`, `vpo_receivedby`, `vpo_grn_remarks`, `createdby`, `status`,`createdon`) VALUES ('$selected_PRDTID','$po_id','$po_no','$selected_ITEMID','$selected_QTY','$vpo_grn_on','$vpo_invoice_date','$vpo_invoice_ref_no','$vpo_grn_ref_no','$vpo_dispatchthrough','$vpo_approvedby','$vpo_deliveredby','$vpo_receivedby','$vpo_grn_remarks','$logged_user_id','1', now())") or die("unable to create log:". sqlERROR_LABEL());
						}
						
						// *** PRODUCT AGING *** //

						//update product price,tax in product table set, product aging for first stock
						 $check_productfirst_stock = sqlQUERY_LABEL("select * from js_vendor_po_items where prdt_id='$selected_PRDTID'") or die(sqlERROR_LABEL());

						if(sqlNUMOFROW_LABEL($check_productfirst_stock) == 1){
							$today = date('Y-m-d');
							$addprdt_age = ",prdt_age='$today'";
						}

						//$productmaster_stock_item = sqlQUERY_LABEL("Update js_product set `prdt_purchase_price`='$selected_ITEMPRICE',prdt_tax ='$selected_ITEMTAX' {$addprdt_age} where `prdt_id`='$selected_PRDTID'") or die("unable to update ITEM STOCK".sqlERROR_LABEL());
				
				
						//**** START LAST BUYING PRICE VALUE ****///
						
						  $collect_lastbuying_prdt_id = sqlQUERY_LABEL("SELECT prdt_id FROM js_vendor_po_items WHERE vpo_item_id = (SELECT MAX(vpo_item_id) FROM js_vendor_po_items WHERE vpo_item_grn_status='1')") or die(sqlERROR_LABEL());
						  
						  $count_collect_lastbuying_price_prdt_id = sqlNUMOFROW_LABEL($collect_lastbuying_prdt_id);
										  
						  while($row_prdt = sqlFETCHARRAY_LABEL($collect_lastbuying_prdt_id)){

								$last_buying_prdt_id = $row_prdt["prdt_id"];
						  }	  

						  $collect_lastbuying_price = sqlQUERY_LABEL("SELECT vpo_item_price FROM js_vendor_po_items WHERE vpo_item_id = (SELECT MAX(vpo_item_id) FROM js_vendor_po_items WHERE prdt_id='$last_buying_prdt_id' and vpo_item_grn_status='1')") or die(sqlERROR_LABEL());

						  $count_collect_lastbuying_price = sqlNUMOFROW_LABEL($collect_lastbuying_price);
										  
						  while($row_price = sqlFETCHARRAY_LABEL($collect_lastbuying_price)){

								$last_buying_price = $row_price["vpo_item_price"];
						 
								if($last_buying_price !=''){$last_buying_price = $last_buying_price; } else { $last_buying_price = 'N/A';}
							}

						//$update_last_buying_price = sqlQUERY_LABEL("UPDATE `js_product` SET `prdt_last_buying_price`='$last_buying_price' WHERE prdt_id = '$last_buying_prdt_id'") or die(sqlERROR_LABEL());

						//**** END OF LAST BUYING PRICE VALUE ****///

				} else { 



					echo "<div style='width: 350px; text-align: center; margin: 20% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Nothing to update here, you will be taken back now. Please wait while load this...</div>";

					echo "<script type='text/javascript'>window.location = 'vendorspo.php?route=list&formtype=preview&id=$po_id'</script>";



					exit(); 

				}

				

			}
//exit();			
			//END OF FOR LOOP


			/****** updating vendor - grn status and other info *******/
			$vendorgrn_item = sqlQUERY_LABEL("Update js_vendorpo set `vpo_grn_on`='$vpo_grn_on', `vpo_grn_status`='1', `vpo_invoice_ref_no`='$vpo_invoice_ref_no', `vpo_grn_ref_no`='$vpo_grn_ref_no', `vpo_invoice_date`='$vpo_invoice_date', `vpo_dispatchthrough`='$vpo_dispatchthrough', `vpo_approvedby`='$vpo_approvedby', `vpo_deliveredby`='$vpo_deliveredby', `vpo_receivedby`='$vpo_receivedby', `vpo_grn_remarks`='$vpo_grn_remarks',`status`='3' where vpo_id = '$po_id'") or die("unable to update VENDOR PO DETAILS: ".sqlERROR_LABEL());

			$updated_log = "GRN generated for #$po_no on $vpo_grn_on";

			//updating status change log

			$update_bill_log = sqlQUERY_LABEL("INSERT INTO `js_vendor_polog`(`vpo_no`, `vpolog_type`, `vpolog_desc`, `vpolog_createdby`, `vpolog_createdon`) VALUES ('$po_no','1','$updated_log','$logged_user_id', now())") or die("unable to create log:". sqlERROR_LABEL());
								

		echo "<div style='width: 350px; text-align: center; margin: 20% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while load this...</div>";

		echo "<script type='text/javascript'>window.location = 'vendorspo.php?route=list&formtype=preview&id=$po_id&check=Y'</script>";

		exit();

		}

	}	
	
	//import expenses -- uploading from excel
if($upload == 'import') {
	$file_name = $_FILES['cvs']['name'];
	$file_type 		= $_FILES['cvs']['type'];
	$file_temp_loc 	= $_FILES['cvs']['tmp_name'];
	$file_error_msg = $_FILES['cvs']['error'];
	$file_size 		= $_FILES['cvs']['size'];
	
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
	
	$move_file = move_uploaded_file($file_temp_loc, "uploadedexcels/{$file_name}"); // temp loc, file name
	if($move_file != true) { // if not move to the temp location
		echo 'Error: File not uploaded, try again.';
		@unlink($file_temp_loc); // remove to the temp folder
		exit();
	}


	
	$csvFile  = 'uploadedexcels/'.$file_name;
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
		
				
				
				  $vpo_no = $data[0];
				  $vpo_date = $data[1];
				  $vpo_sent = $data[2];
				  $vpo_received = $data[3];
				  $vpo_tot_items = $data[4];
				  $vpo_tot_qty = $data[5];
				  $vpo_tot_tax = $data[6];
				  $vpo_tot_value = $data[7];
				  $vpo_tot_balance = $data[8];
				  $vpo_dispatchthrough = $data[9];
				  $vpo_approvedby = $data[10];
				  $vpo_deliveredby = $data[11];
				  $vpo_receivedby = $data[12];
				  $status = $data[13]; 
				//  $vendorname = getVENDORNAME($vendor_id,'label');
			//if product code is empty
			// if($prdt_code == '') {
				// $getproductCODE = sqlQUERY_LABEL("SELECT `prdt_code` FROM  js_vendorpo WHERE `prdt_type` = '$prdt_type' and `catid` = '$catid' and `brandid` = '$brandid' and `deleted`='0'") or die("Unable to get Product: ".sqlERROR_LABEL());
				 // if(sqlNUMOFROW_LABEL($getproductCODE)>0)
				 // {
					// while($create_productCODE = sqlFETCHARRAY_LABEL($getproductCODE)) {
						// $prdt_code = $create_productCODE['prdt_code'];
					// }
					
					// $prdt_code++;
				 // } else {
					 // $productcategory_code = getPRODUCTCATEGORY($catid, 'code');
					 // $productbrand_code = getPRODUCTBRAND($brandid, 'code');
					 
					 // $prdt_code = $productcategory_code.''.$productbrand_code.''.'100';
				 // }
			// }
			
			$arrFields=array('`vpo_id`', '`vpo_no`', '`vpo_date`', '`vpo_sent`', '`vpo_received`', '`vpo_tot_items`', '`vpo_tot_qty`', '`vpo_tot_tax`', '`vpo_tot_value`', '`vpo_tot_balance`','`vpo_dispatchthrough`', '`vpo_approvedby`', '`vpo_deliveredby`', '`vpo_receivedby`','`status`');

	$arrValues=array("$vpo_id","$vpo_no","$vpo_date","$vpo_sent","$vpo_received","$vpo_tot_items","$vpo_tot_qty","$vpo_tot_tax","$vpo_tot_value","$vpo_tot_balance","$vpo_dispatchthrough","$vpo_approvedby","$vpo_deliveredby","$vpo_receivedby","$status");
//print_r ($arrFields);exit();
	if(sqlACTIONS("INSERT","js_vendorpo",$arrFields,$arrValues,'')) {
					}
							 
			}//end of checking data
		} 
		$flag = false;
	}
	fclose($handle);
	unlink($csvFile); // delete cvs after imported

		//RTW Product Log			
		echo "<div style='width: 350px; text-align: center; margin: 20% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we import loading...</div>";
		echo "<script type='text/javascript'>window.location = 'vendorspo.php'</script>";
		exit();
?>
		<div class="form-group" id="process" style="display:none;">
        <div class="progress">
         <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
          <span id="process_data">0</span>
         </div>
        </div>
	   </div>

<?php
}
?>
    <div class="content">
	
      <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
	  
	   <?php  if($formtype==''){ ?>
	   
    <div class="row">
		
        <div class="col-lg-12">
		  
            <div class="row row-xs mg-b-25">

				<div data-label="Example" class="df-example demo-table table-responsive">
				
					<table id="VendorpoLIST" class="table table-bordered" width="100%">
					  
						<thead>
						
							<tr>
							
								<th><?php echo $__contentsno ?></th>
						  
								<th>PO No</th>
								
								<th>PO Date</th>
								
								<th>GRN</th>
								
								<th>Vendor Name</th>
								
								<th>Total Items</th>
								
								<th>Total Qty</th>   
								
								<th>Total Price</th>
								
								<th>Total Tax</th>
								
								<th>Status</th>
								
								<th><?php echo $__options ?></th>
								
							</tr>
							
						</thead>
						
					</table>
				
				</div>

            </div><!-- row -->
			
        </div><!-- col -->
<style>
.table td:first-child, .table th:first-child {
min-width: 40px;
max-width: 40px;
text-align:center;
}
tbody>tr>:nth-child(8){
 width:100px;
 min-width: 100px;
 max-width: 100px;
 text-align:left;
}
tbody>tr>:nth-child(9){
 width:100px;
 min-width: 100px;
 max-width: 100px;
 text-align:left;
}
tbody>tr>:nth-child(11){
 width:100px;
 min-width: 100px;
 max-width: 100px;
 text-align:left;
}
</style>
          <?php 
	          //include viewpath('__vendorsposidebar.php'); 
          ?>

    </div><!-- row -->
		<?php } if($formtype =='preview' && $grngenerate != 'add' && $grngenerate != 'preview'){ 
		
		
   $list_parentcategory_datas = sqlQUERY_LABEL("SELECT * FROM `js_vendorpo` where `vpo_id` = '$id'") or die("#1-Unable to get records:".sqlERROR_LABEL());

  $count_parentcateogry_list = sqlNUMOFROW_LABEL($list_parentcategory_datas);

	  while($row = sqlFETCHARRAY_LABEL($list_parentcategory_datas))
	  {
		
	  $vpo_id = $row["vpo_id"];
	  $vendor_id = $row["vendor_id"];
	  $vpo_no = $row["vpo_no"];
	  $generate_grn_no = $row["generate_grn_no"];
	  $vpo_date = $row["vpo_date"];
	  $vpo_sent = $row["vpo_sent"];
	  $vpo_received = $row["vpo_received"];
	  $vpo_grn_ref_no = $row["vpo_grn_ref_no"];
	  $vpo_tot_items = $row["vpo_tot_items"];
	  $vpo_tot_qty = $row["vpo_tot_qty"];
	  $vpo_tot_tax = $row["vpo_tot_tax"];
	  $vpo_tot_paid = $row["vpo_tot_paid"];
	  $vpo_tot_value = $row["vpo_tot_value"];
	  $vpo_tot_balance = $row["vpo_tot_balance"];
	  $vpo_grn_status = $row["vpo_grn_status"];
	  $vpo_reject_reason = $row["vpo_reject_reason"];
	  $status = $row["status"]; 
	  $vendorname = getVENDORNAME($vendor_id,'label');
	  }
	  
	  
		$count_grn_status_list = sqlQUERY_LABEL("select `vpo_item_id` FROM `js_vendor_po_items` where `vpo_id`='$vpo_id'") or die(sqlERROR_LABEL());

		$count_vpo_grnlist = sqlNUMOFROW_LABEL($count_grn_status_list);

		

		//total item with grn updated count

		$count_grn_updated_list = sqlQUERY_LABEL("select `vpo_item_id` FROM `js_vendor_po_items` where `vpo_id`='$vpo_id' and `vpo_item_grn_status` = '1'") or die(sqlERROR_LABEL());

		$count_vpo_grnupdate = sqlNUMOFROW_LABEL($count_grn_updated_list);
		
?>
                            <div id="barcodereport" style="display: none;">
                                <table class="table" border="2px">
                                    <thead class="thead-light page-sub-title">
                                        <tr>
										<!--<th>#</th>-->
                                            <th>Barcode</th>
										</tr>
                                    </thead>
                                    <?php
									  $list_category_data = sqlQUERY_LABEL("SELECT * FROM `js_vendorpo` where deleted = '0' and vpo_id = '$id' order by vpo_id desc") or die("#1-Unable to get PRODUCT CATEGORY:".sqlERROR_LABEL());

									  $count_cateogry_list = sqlNUMOFROW_LABEL($list_category_data);

									  while($row = sqlFETCHARRAY_LABEL($list_category_data)){
										  $counter_vpono++;
										  $vpo_no = $row["vpo_no"];
									  } 
									  	$list_vendorpoitems_data = sqlQUERY_LABEL("SELECT * FROM `js_vendor_po_items` where vpo_id = '$id' and deleted = '0'") or die("#1-Unable to get PRODUCT CATEGORY:".sqlERROR_LABEL());

										$count_cateogry_list = sqlNUMOFROW_LABEL($list_vendorpoitems_data);
										while($row_value = sqlFETCHARRAY_LABEL($list_vendorpoitems_data)){
										  $counter_productcode++;
										  $prdt_id = $row_value["prdt_id"];
										  $product_code = getPRODUCTDETAIL($prdt_id, 'code');
										?>
									<tbody class="card-title">
                                        <tr>
                                            <td>
                                               <?php echo $product_code;?>&<?php echo $vpo_no; ?>
                                            </td>											
                                        </tr>
										<?php } ?>
                                    </tbody>
                                </table>
                            </div>
		<div id="stick-here"></div>
		<div id="myModal" class="modal fade">
			<div class="modal-dialog modal-xl" style="overflow-y: initial !important">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Vendor PO Product Remarks</h5>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body" style="max-height: calc(100vh - 200px);overflow-y: auto;">
					<form>
					  <table class="table table-bordered" width="100%">
						<thead>
							<tr>
								<th class="wd-5p"><?php echo $__contentsno ?></th>
								<th>Product Code</th>
								<th>Product Name</th>
								<th>Qty</th>
								<th>Remarks</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$list_vendorpoitems_data = sqlQUERY_LABEL("SELECT * FROM `js_vendor_po_items` where vpo_id = '$id' and deleted = '0'") or die("#1-Unable to get PRODUCT CATEGORY:".sqlERROR_LABEL());

						$count_cateogry_list = sqlNUMOFROW_LABEL($list_vendorpoitems_data);
						while($row_value = sqlFETCHARRAY_LABEL($list_vendorpoitems_data)){
						  $counter_remarks++;
						  $remark_prdt_id = $row_value["prdt_id"];
						  $prdt_remark_code = getPRODUCTDETAIL($remark_prdt_id, 'code');
						  $prdt_remark_name = getPRODUCTDETAIL($remark_prdt_id, 'name');
						  $prdt_remarks = $row_value["prdt_remarks"];
						  $prdt_remarks_item_qty = $row_value["vpo_item_qty"];
						 ?> 
						<tr>
							<td><?php echo $counter_remarks; ?></td>
							<td><?php echo $prdt_remark_code; ?></td>
							<td><?php echo $prdt_remark_name; ?></td>
							<td><?php echo $prdt_remarks_item_qty; ?></td>
							<td><?php echo $prdt_remarks; ?></td>
						</tr>
						<?php } ?>
						</tbody>
					</table>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div id="stickThis" class="form-group row mg-b-0">
			<div class="col-3 col-sm-5">
				<?php pageCANCEL($currentpage, $__cancel); ?>
			</div>
					
			<div class="col-9 col-sm-7 text-right">
				<div class="row">
					<div class="col-12 ml-auto">
						<?php if($status == '0'){ ?>
						<a href="vendorspo.php?route=add&id=<?php echo $id;?>" data-toggle="tooltip" data-original-title="Click to Print" class="btn btn-info btn-md mg-r-2"><i class="fas fa-pencil-alt"></i></a>
						<?php } if($status == '1' && $_SESSION['reg_user_name'] == 'mohan@touchmarkdes.com'){ ?>
						<a href="vendorspo.php?route=preview&formtype=preview&id=<?php echo $id;?>&formtype=approve" data-toggle="tooltip" data-original-title="Click to Print" class="btn btn-success btn-md mg-r-2">Approve</i></a>
						<!-- Button trigger modal -->
						<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
						  Reject
						</button>

						<!-- Modal -->
						<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						  <div class="modal-dialog" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">VPO Reject Reason</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							  <div class="modal-body">
								<div class="col-md-12 col-sm-12 mg-t-10 mg-md-t-0">
								<label class="float-left">Please Enter the Reject Reason</label>	
								<textarea type="text" data-parsley-trigger="keyup" class="form-control" name="vpo_reject_reason" id="vpo_reject_reason" placeholder="Please Enter the Reject Reason"></textarea>
								</div>
							  </div>
							  <div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
								<button type="button" onclick="vpo_reject_status(6)" class="btn btn-primary">Confirm Reject</button>
							  </div>
							</div>
						  </div>
						</div>
						<?php } ?>
						<?php if($status != '1'){ ?>
							<button type="button" id="btnExport" class="mr-2 align-items-right btn btn-success">Download Barcode</button>
							<button class="btn btn-outline-light dropdown-toggle mg-r-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
							<div class="dropdown-menu tx-13">
							  <a class="dropdown-item" href="#" onClick="printINVOICE()">Preview PDF</a>
							 <!-- <a class="dropdown-item" href="#">Send PO</a> -->
							  <a class="dropdown-item" href="#poactivity">PO Activity</a>
							  <a class="dropdown-item" href="#payment-history">Manage Payment</a>
							</div>
						<?php } ?>	
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
						<?php if($status != '1'){ ?>
						 <a href="javascript:;" onClick="printINVOICE()" data-toggle="tooltip" data-original-title="Click to Print" class="btn btn-warning btn-md mg-r-2"><i class="fa fa-print"></i></a>
						
						 <a href="javascript:;" onClick="downloadBILL()" data-toggle="tooltip" data-original-title="Click to Download" class="btn btn-warning btn-md mg-r-2"><i class="fa fa-download"></i></a>
						 <?php } ?>
						 <?php if($status == '5' || $status == '3' ||$status == '2'){ ?>
						 <?php if($vpo_tot_balance > '0' || $status != '3' ){ ?>
						 <a href="javascript:;" data-toggle="modal" data-target="#quickupdate" data-toggle="tooltip" data-original-title="Click to Download" class="btn btn-success sm-quick-update-hide btn-md"><i class="fa fa-credit-card"></i> Quick Update</a>
						 <?php }else { ?>
						 <a href="#poactivity" onClick="managepayment()" data-toggle="tooltip" data-original-title="Click to Download" class="btn btn-success sm-quick-update-hide btn-md"><i class="fa fa-credit-card"></i> Manage Payment</a>
						 <?php } }?>
					</div>
				</div>
			</div>	
			<div class="row col-sm-12 mg-l-1 mg-md-l-0">
				<?php if($status == '5' || $status == '3' ||$status == '2'){ ?>
				 <?php if($vpo_tot_balance > '0'){ ?>
				 <a href="javascript:;" data-toggle="modal" data-target="#quickupdate" data-toggle="tooltip" data-original-title="Click to Download" class="btn btn-success md-quick-update-hide sm-quick-update btn-md"><i class="fa fa-credit-card"></i> Quick Update</a>
				 <?php }else { ?>
				 <a href="#poactivity" onClick="managepayment()" data-toggle="tooltip" data-original-title="Click to Download" class="btn btn-success md-quick-update-hide sm-quick-update btn-md"><i class="fa fa-credit-card"></i> Manage Payment</a>
				<?php } }?>
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
					  <h6 class="text-left">General Update :</h6><br>
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"> 
							
								<div class="form-group">
								
									<label for="quick_status" class="control-label  mg-r-45">PO Status</label>
							     <?php if($status == '3'){ ?>
									<span class="text-bold"> GRN Generated</span>
									<input type="hidden" class="form-control" name="quick_status" id="quick_status" value="<?php echo $status; ?>" readonly>

								<?php }else{ ?>	
	
									<select name="quick_status" id="quick_status" class="form-control selectpicker" data-live-search="true">
									
										 <?php echo getVendorStatus($status,'selectpo'); ?>
										 
									</select>
								 <?php } ?>
								</div>
							
								</div>
								
								<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"> 
							
									<div class="form-group">
										
									<label for="vpo_sent" class="control-label  mg-r-80">P.O Sent</label>
									<input type="text" class="form-control" placeholder="DD/MM/YYYY" name="vpo_sent" id="vpo_sent" value="<?php if($vpo_sent != '0000-00-00') { echo dateformat_datepicker($vpo_sent); } ?>">
				
									</div>
							
								</div>
								
								<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"> 
							
									<div class="form-group">
										
									<label for="vpo_received" class="control-label  mg-r-50">P.O Received</label>
									<input type="text" class="form-control" placeholder="DD/MM/YYYY" name="vpo_received" id="vpo_received" value="<?php if($vpo_received != '0000-00-00') { echo dateformat_datepicker($vpo_received); } ?>">
				
									</div>
							
								</div>
								
							</div>
							
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
										<td><?php echo general_currency_symbol.' '.moneyFormatIndia($vpo_tot_value); ?></td>
										<td><?php echo general_currency_symbol.' '.moneyFormatIndia($vpo_tot_paid); ?></td>
										<td><?php echo general_currency_symbol.' '.moneyFormatIndia($vpo_tot_balance); ?></td>
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
									<input type="text" class="form-control pay-amt" name="receivedamt" id="receivedamt" onKeyUp="CalcBALACNE(this.form)" autocomplete="off">
									</div>
								</div>
								 
								 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 mg-t-10 mg-r-30"> 
									<h5 class="info-label">Total:</h5>
								
									   <input type="hidden" class="form-control pay-amt" name="balance" id="balance" value="<?php echo general_currency_symbol.' '.moneyFormatIndia($vpo_tot_balance,2); ?>" required/>

									   <br /><span id="total_balance" style="font-size: 20px; font-weight: bolder;"><?php echo general_currency_symbol.' '.moneyFormatIndia($vpo_tot_balance,2); ?></span></strong></span>
								 </div>
								 
							</div>
							<div class="row">
						
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								
									
										<label class="control-label mg-r-90">Notes</label>
									
										<textarea id="bill_log" class="form-control bill_log"></textarea>
										 <input type="hidden" name="request_vpo_no" value="<?php echo $vpo_no; ?>" />

										<input type="hidden" name="request_status" value="<?php echo $status; ?>" />

										<input type="hidden" name="request_totalamount" value="<?php echo $vpo_tot_value; ?>" />

										<input type="hidden" name="request_paid" value="<?php echo $vpo_tot_paid; ?>" />

										<input type="hidden" name="request_sentdate" value="<?php echo $vpo_sent; ?>" />

										<input type="hidden" name="request_receiveddate" value="<?php echo $vpo_received; ?>" />
										
										<input type="hidden" name="vpo_id" value="<?php echo $id; ?>" />
										
										<input type="hidden" name="seletced_vpo_id" id="seletced_vpo_id" value="<?php echo $id; ?>" />

										<input type="hidden" name="request_balance" id="request_balance" value="<?php echo $vpo_tot_balance; ?>" />
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


			
		
		</div>
		
	<div class="divider-text">Payment options</div>
				

	<div class="row">
	
		<div class="col-2">
	
			<div class="avatar avatar-xxl mg-b-10"><img src="public/img/signin.png" class="img rounded-circle" alt="Responsive image">
			</div>
		
		</div>

		<div class="col-md-10 mg-t-30">
			<div class="row mg-md-l-0">	
				
				<div class="col-md-auto col-sm-12 mg-t-10">
					<span><span>PO #:</span> <span class="mg-l-90 mg-md-l-0"><b><?php echo $vpo_no; ?></b></span></span>
				</div>
				
				<div class="col-md-auto mg-t-10">		
					<span><span>PO Date:</span> <span class="mg-l-70 mg-md-l-0"><b><?php echo dateformat_datepicker ($vpo_date); ?></b></span>
				</div>
				
				<div class="col-md-auto mg-t-10">
					<span><span>Total Amount:</span> <span class="mg-l-35 mg-md-l-0"><b><?php echo general_currency_symbol.' '.moneyFormatIndia($vpo_tot_value); ?></b></span>	
				</div>
				
				<div class="col-md-auto mg-t-10">
					<span><span>Balance Amount:</span> <span class="mg-l-15 mg-md-l-0"><b><?php echo general_currency_symbol.' '.moneyFormatIndia($vpo_tot_balance); ?></b></span>
				</div>
				<!--<?php if($count_vpo_grnlist == $count_vpo_grnupdate) { ?>
				<div class="col-md-auto col-sm-12 mg-t-10">
					<span><span>GRN-REF #:</span> <span class="mg-l-90 mg-md-l-0"><b><?php echo $vpo_grn_ref_no; ?></b></span></span>
				</div>
				<?php } ?>-->
			</div>
		</div>
	</div>

<div class="divider-text">Vendor Details</div>

	<div class="card">
	
		<div class="card-body">
		
			<div class="form-group row">
			
				<div class="col-md-3 mg-b-10 mg-md-b-0 mg-t-40 mg-md-t-0 row md-border-right">
				
					<div class="text-uppercase">
					
					  <span class="col-sm-6 sm-vendor-info-hide text-muted">Vendor Info</span>
					  <span class="col-sm-6 md-vendor-info-hide text-muted">Vendor</span>
					  
					</div>
					
					<div class="mg-md-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
					
					  <span class="mg-md-r-70 mg-md-l-15 mg-l-40"><?php echo $vendorname; ?></span>
					  
					</div>
					
				</div>
				
				<div class="col-md-3 mg-b-10 mg-md-b-0 md-border-right sm-po-date-hide">
				
					<div class="text-uppercase">
					
					  <span class="text-muted mg-md-l-30">P.O Date</span>
					  
					</div>
					
					<div class="mg-t-10 mg-l-30 text-uppercase" style="letter-spacing: 0.0825em;">
					
						  <span class=""><?php echo dateformat_datepicker ($vpo_date); ?></span>   
					</div>
						
				</div>
				
				<div class="col-md-3 row mg-b-10 mg-md-b-0 md-border-right md-po-date-hide">
				
					<div class="text-uppercase">
					
					  <span class="col-sm-6 text-muted mg-md-l-30">P.O Date</span>
					  
					</div>
					
					<div class="mg-md-t-10 mg-l-25 text-uppercase" style="letter-spacing: 0.0825em;">
					
						  <span class="col-sm-6"><?php echo dateformat_datepicker ($vpo_date); ?></span>   
					</div>
						
				</div>
				
				<div class="col-md-3 md-border-right sm-po-sent-hide">
				
					<div class="text-uppercase">
					
					  <span class="text-muted">P.O Sent on</span>
					  
					</div>
					
					<div class="mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
					
					  <span><?php echo dateformat_datepicker($vpo_sent); ?></span>
					  
					</div>
					
				</div>
				
				<div class="col-md-3 row mg-b-10 mg-md-b-0 md-border-right md-po-sent-hide">
				
					<div class="text-uppercase">
					
					  <span class="col-sm-6 text-muted">P.O Sent on</span>
					  
					</div>
					
					<div class="mg-md-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
					
					  <span class="col-sm-6"><?php echo dateformat_datepicker($vpo_sent); ?></span>
					  
					</div>
					
				</div>
			<?php if($status == '1'){?>
				
				<div class="marker  marker-ribbon p-2 marker-success marker-top-right pos-absolute t-10 r-0">
				
				Sent - PO </div>
				
			<?php }elseif($status == '5'){ ?>
				
				<div class="marker  marker-ribbon p-2 marker-success marker-top-right pos-absolute t-10 r-0">
				
				Approved - PO </div>
			
			<?php }elseif($status == '2'){ ?>
				
				<div class="marker  marker-ribbon p-2 marker-success marker-top-right pos-absolute t-10 r-0">
				
				Received - PO </div>
				
			<?php }elseif($status == '3'){ ?>
				
				<div class="marker  marker-ribbon p-2 marker-success marker-top-right pos-absolute t-10 r-0">
				
				GRN- Generated </div>
				
			<?php } elseif($status == '4'){ ?>
				
				<div class="marker  marker-ribbon p-2 marker-danger marker-top-right pos-absolute t-10 r-0">
				
				Cancelled </div>
				
			<?php } elseif($status == '6'){ ?>
				
				<div class="marker  marker-ribbon p-2 marker-danger marker-top-right pos-absolute t-10 r-0">
				
				Rejected </div>
				
			<?php } ?>

			<?php if($status == '6' && $vpo_reject_reason != '') { ?>

				<div class="col-md-3 row mg-b-10 mg-md-b-0">
				
					<div class="text-uppercase">
					
					  <span class="col-md-6 text-muted">Reject Reason</span>
					  
					</div>
					
					<div class="text-uppercase" style="letter-spacing: 0.0825em;">
					
					  <span class="col-sm-6"><?php echo $vpo_reject_reason; ?></span>
					  
					</div>
					
				</div>
			<?php } else { ?>	
			
				<div class="col-md-3 row mg-b-10 mg-md-b-0 md-po-receive-hide">
				
					<div class="text-uppercase">
					
					  <span class="col-sm-6 text-muted">P.O Received on</span>
					  
					</div>
					
					<div class="mg-md-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
					
					  <span class="col-sm-6"><?php echo dateformat_datepicker ($vpo_received); ?></span>
					  
					</div>
					
				</div>

				<div class="col-md-3 sm-po-receive-hide">
				
					<div class="text-uppercase">
					
					  <span class="text-muted">P.O Received on</span>
					  
					</div>
					
					<div class="mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
					
					  <span><?php echo dateformat_datepicker ($vpo_received); ?></span>
					  
					</div>
					
				</div>	
				
			<?php } ?>
			
			</div>
			<?php if($status == '6') { ?>
			<h5 class="text-danger tx-bold text-center">This Vendor PO has been Rejected by Admin</h5>
			<?php } ?>
		</div>
		
	</div>
			
		<?php
			$list_vendorpoitems_data = sqlQUERY_LABEL("SELECT * FROM `js_vendor_po_items` where vpo_id = '$id' and vpo_item_approved = '1' and deleted = '0'") or die("#1-Unable to get PRODUCT CATEGORY:".sqlERROR_LABEL());

			$count_cateogry_list = sqlNUMOFROW_LABEL($list_vendorpoitems_data);
			while($row_value = sqlFETCHARRAY_LABEL($list_vendorpoitems_data)){
			  $vpo_item_id = $row_value["vpo_item_id"];
			  $vpo_id = $row_value["vpo_id"];
			  $prdt_id = $row_value["prdt_id"];
			  $vpo_item_qty[] = $row_value["vpo_item_qty"];
			  $vpo_item_price = $row_value["vpo_item_price"];
			  $vpo_item_tax = $row_value["vpo_item_tax"];
			  $vpo_item_tax1 = $row_value["vpo_item_tax1"];
			  $vpo_item_tax2 = $row_value["vpo_item_tax2"];
			  $vpo_item_total = $row_value["vpo_item_total"];
			  $vpo_item_received[] = $row_value["vpo_item_received"];
			  $vpo_item_approved = $row_value["vpo_item_approved"];
			  $vpo_item_difference = $row_value["vpo_item_difference"];
			  $vpo_item_grn_status = $row_value["vpo_item_grn_status"];
			} 
			$requsted_qty = implode(",", $vpo_item_qty);
			$received_qty = implode(",", $vpo_item_received);
			?>
				<div class="divider-text">Product details</div>
				 <?php if($status == '3' || $status =='2'){ 
				 if($vpo_item_qty == $vpo_item_received) {
				 ?>
				 <a href="vendorspo.php?route=list&formtype=preview&grngenerate=preview&id=<?php echo $vpo_id; ?>" class="float-right btn btn-success btn-xs mg-b-5" data-toggle="tooltip" data-original-title="GRN Detail Report">

				<i class="fa fa-check-circle"></i> GRN Report

				</a>
				<?php 

				} else { ?>

				 <a href="vendorspo.php?route=list&formtype=preview&grngenerate=add&id=<?php echo $vpo_id; ?>" class="btn btn-xs btn-success float-right tx-white mg-b-10"><i class="fa fa-thumbs-up" aria-hidden="true"></i> Generate GRN</a>
				
				<?php } } else if($status == '5'){ ?>
				
				<a href="javascript:;" class="btn btn-xs btn-danger float-right tx-white mg-b-10"><i class="fas fa-ban"></i> Generate GRN</a>
				
				
				 <?php } ?>
				 
		<div class="mg-t-20">
			<table class="table table-bordered table-hover mg-r-0 table-responsive">
			   <thead class="thead bg-gray-200">
				  <tr>
						<th rowspan="2" class="text-center">#</th>
						<th rowspan="2">Product Code</th>
						<th class="wd-20p" rowspan="2">Product Name</th>
						<th colspan="3" class="wd-20p text-center">Qty</th>
						<th class="wd-10p text-center">Item Price</th>
						<th colspan="3" class="text-center">Tax</th>
						<th class="wd-10p text-center">Item Total</th>
					</tr>
					<tr>
						<th class="text-center small">Requested</th>
						<th class="text-center small">Received</th>
						<th class="text-center small">Difference</th>
						<th class="text-center small">(in ₹)</th>
						<th class="text-center small wd-5p">%</th>
						<th class="text-center small">CGST</th>
						<th class="text-center small">SGST</th>
						<th class="text-center small" style="border-right-width:1px;">(in ₹)</th>
					</tr>
			   </thead>

			   <tbody id="fetch_amcparticular">
			   
			<?php  
									   
			$list_vendorpoitems_data = sqlQUERY_LABEL("SELECT * FROM `js_vendor_po_items` where vpo_id = '$id' and deleted = '0'") or die("#1-Unable to get PRODUCT CATEGORY:".sqlERROR_LABEL());

			$count_cateogry_list = sqlNUMOFROW_LABEL($list_vendorpoitems_data);
			if($count_cateogry_list > 0){
			while($row_value = sqlFETCHARRAY_LABEL($list_vendorpoitems_data)){
			  $counter++;
			  $vpo_item_id = $row_value["vpo_item_id"];
			  $vpo_id = $row_value["vpo_id"];
			  $prdt_id = $row_value["prdt_id"];
			  $prdt_serialno = $row_value["prdt_serialno"];
			  $vpo_item_qty = $row_value["vpo_item_qty"];
			  $vpo_item_price = $row_value["vpo_item_price"];
			  $vpo_item_tax = $row_value["vpo_item_tax"];
			  $vpo_item_tax1 = $row_value["vpo_item_tax1"];
			  $vpo_item_tax2 = $row_value["vpo_item_tax2"];
			  $vpo_item_total = $row_value["vpo_item_total"];
			  $vpo_item_received = $row_value["vpo_item_received"];
			  $vpo_item_difference = $row_value["vpo_item_difference"];
			  $vpo_item_expirydate = $row_value["vpo_item_expirydate"];
			  $vpo_item_grn_status = $row_value["vpo_item_grn_status"];
			  $vpo_discount_value = $row_value['vpo_discount_value'];
			  $vpo_discount_amt = $row_value['vpo_discount_amt'];
			  $vpo_after_discount_price = $row_value['vpo_after_discount_price'];
			  $vpo_dicounted_item_price = ($vpo_after_discount_price/$vpo_item_qty);
			  $vpo_after_discount_item_total = $row_value['vpo_after_discount_item_total'];
			  $status = $row_value["status"];
			  $product_code = getPRODUCTDETAIL($prdt_id, 'code');
			  $product_name = getPRODUCTDETAIL($prdt_id, 'name');
			  
			  ?>
				<tr>
					<td><?php echo $counter; ?></td>
					<td class="wd-10p"><?php echo $product_code; ?></td>
					<td><?php echo $product_name; ?><br /><small class="text-muted">S.No: <?php echo $prdt_serialno; ?></small></td>
					<td class="text-center"><?php echo $vpo_item_qty; ?></td>
					<td class="text-center"><?php echo $vpo_item_received; ?></td>
					<td class="text-center"><?php echo $vpo_item_difference; ?></td>
					<!--<td class="text-right"><?php echo moneyFormatIndia($vpo_item_price); ?></td>-->
					<td class="text-right">
					<?php if($vpo_discount_value !='0' && $vpo_discount_value !='') { ?>
					<del><?php echo number_format($vpo_item_price, 2); ?></del><br>
					<?php echo number_format($vpo_dicounted_item_price, 2); ?>
					<?php } else { ?>
					<?php echo number_format($vpo_item_price, 2); ?>
					<?php } ?>
					</td>
					<td class="text-center"><?php echo $vpo_item_tax; ?></td>
					<td class="text-right"><?php echo moneyFormatIndia($vpo_item_tax1); ?></td>
					<td class="text-right"><?php echo moneyFormatIndia($vpo_item_tax2); ?></td>
					<!--<td class="text-right"><?php echo moneyFormatIndia($vpo_item_total); ?></td>-->
					<td class="text-right">
					<?php if($vpo_discount_value !='0' && $vpo_discount_value !='') { ?>
					<del><?php echo moneyFormatIndia($vpo_item_total); ?></del><br>
					<?php echo moneyFormatIndia($vpo_after_discount_item_total); ?>
					<?php } else { ?>
					<?php echo moneyFormatIndia($vpo_item_total); ?>
					<?php } ?>
					</td>
				</tr>
				
			<?php }}else{ ?>
				<tr><td colspan="11" class="text-center">No records Available</td></tr>
			<?php } ?>	
			   </tbody>

			</table>
		</div>	
						
	<div class="row">
	
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
		
		<div class="col-12" >
		
			<div class="divider-text">Activity Log</div>
			

			<div class="card">
			
				<div class="card-header tx-bold bg-gray-300">
				
				PO Activity

				</div>
			
				<div class="card-body tx-dark bg-light"  id="poactivity">
				<?php
				
  $list_poactivity_datas = sqlQUERY_LABEL("SELECT * FROM `js_vendor_polog` where vpo_no = '$vpo_no' order by vpolog_id desc") or die("#1-Unable to get records:".sqlERROR_LABEL());
  
  $count_parentcategory_list = sqlNUMOFROW_LABEL($list_poactivity_datas);

	  while($row_data = sqlFETCHARRAY_LABEL($list_poactivity_datas)){
		
	  $vpolog_id = $row_data["vpolog_id"];
	  $vpolog_type = $row_data["vpolog_type"];
	  $vpo_no = $row_data["vpo_no"];
	  $vpolog_desc = $row_data["vpolog_desc"];
	  $vpolog_createdby = $row_data["vpolog_createdby"];
	  $vpolog_createdon = strtotime($row_data["vpolog_createdon"]);
	  $status = $row_data["status"];
	  $logdate = date("D, d M, Y h:i:s", $vpolog_createdon);
	  
	  ?>

				<?php echo $logdate; ?> - <?php echo $vpolog_desc;  ?> by <?php echo getUSERNAME($vpolog_createdby,'user_name'); ?> <br><br>

	  <?php } ?>
				
				</div>
				
			</div>
			
		</div>
		
	</div>
	
	<div class="row mg-t-10">
		
		<div class="col-12">
			
			<div class="card tx-dark bg-light">
				
				
				<div class="card-header tx-bold bg-gray-300">
				
				PO Payment History

				
				</div>
				<div class="card-body tx-dark bg-light"  id="payment-history">
					<ul class="list-unstyled">
						<?php
								//echo "SELECT * FROM `js_vendor_po_payments`  where vpo_no='$vpo_no' order by vpo_payment_id DESC" ;exit();
								$collect_payment_details =sqlQUERY_LABEL("SELECT * FROM `js_vendor_po_payments` where vpo_no = '$vpo_no' order by vpo_payment_id DESC") or die("#1-Unable to get records:".sqlERROR_LABEL());
                              $count_parentcategory_list = sqlNUMOFROW_LABEL($collect_payment_details); 
                               while($row_data = sqlFETCHARRAY_LABEL($collect_payment_details)) 
								 {
									
									$vpo_payment_amt = moneyFormatIndia($row_data['vpo_payment_amt']); 
									$vpo_payment_date = $row_data['vpo_payment_date'];
									$vpo_payment_mode = $row_data['vpo_payment_mode'];
									$vpo_payment_memo = $row_data['vpo_payment_memo'];
									$createdby = $row_data['createdby'];
									$vpolog_createdon= $row_data['createdon'];
									$createon_timestamp = strtotime($vpolog_createdon);
									$create_ON = date('D, d M, Y H:i:s', $createon_timestamp);
								?>
								<li class="col-md-10">
								<p>
								<span class="small"><?php echo dateformat_datepicker($vpo_payment_date).' - '.$general_currency_code.' '.$vpo_payment_amt.' - '.$vpo_payment_mode; ?></span>
                                <span class="small"><?php echo $create_ON; ?></span>
                                 - <?php echo $vpo_payment_memo; ?> <span class="text-muted">by <?php echo getUSERNAME($createdby,'user_name'); ?></span> 
								</p>
								</li>
								<?php
								}
								?>	
					</ul>
				</div>
			</div>
		</div>
		
	</div>

<?php } if($formtype=='approve'){ 
		
	  $list_parentcategory_datas = sqlQUERY_LABEL("SELECT * FROM `js_vendorpo` where `vpo_id` = '$id'") or die("#1-Unable to get records:".sqlERROR_LABEL());
	  $count_parentcateogry_list = sqlNUMOFROW_LABEL($list_parentcategory_datas);

		  while($row = sqlFETCHARRAY_LABEL($list_parentcategory_datas)){
		  $vpo_id = $row["vpo_id"];
		  $vendor_id = $row["vendor_id"];
		  $vpo_no = $row["vpo_no"];
		  $generate_grn_no = $row["generate_grn_no"];
		  $vpo_date = $row["vpo_date"];
		  $vpo_sent = $row["vpo_sent"];
		  $vpo_received = $row["vpo_received"];
		  $vpo_reasonid = $row['vpo_reasonid'];
		  $vpo_stock_reason = $row['vpo_stock_reason'];
		  $vpo_sale_order_reason = $row['vpo_sale_order_reason'];
		  if($vpo_reasonid =='1'){ $vpo_reason = $vpo_sale_order_reason; }
		  if($vpo_reasonid =='2'){ $vpo_reason = $vpo_stock_reason; }
		  if($vpo_reasonid =='3'){ $vpo_reason = "N/A"; }
		  $vpo_tot_items = $row["vpo_tot_items"];
		  $vpo_tot_qty = $row["vpo_tot_qty"];
		  $vpo_tot_tax = $row["vpo_tot_tax"];
		  $vpo_tot_value = $row["vpo_tot_value"];
		  $vpo_tot_balance = $row["vpo_tot_balance"];
		  $vpo_dispatchthrough = $row["vpo_dispatchthrough"];
		  $vpo_approvedby = $row["vpo_approvedby"];
		  $vpo_deliveredby = $row["vpo_deliveredby"];
		  $vpo_receivedby = $row["vpo_receivedby"];
		  $status = $row["status"];
	  
		  }	?>
		<form method="post" action="">
		<div id="stick-here"></div>
		
		<div id="stickThis" class="form-group row mg-b-0" style="width: 1185px;">
			<div class="col-3 col-sm-6">
				<?php pageCANCEL($currentpage, $__cancel); ?>
			</div>
            <?php if($status !='1'){ ?>
			<div class="col-9 col-sm-6 text-right">
				<a href="javascript:;" onClick="print_taken_stock()" data-toggle="tooltip" data-original-title="Click to Print" class="btn btn-warning btn-md mg-r-2"><i class="fa fa-print"></i></a>
				<a href="javascript:;" onClick="download_taken_stock()" data-toggle="tooltip" data-original-title="Click to Download" class="btn btn-warning btn-md"><i class="fa fa-download"></i></a>
			</div>
			<?php } ?>
		</div>
		
	<div class="divider-text">Basic Info</div>
	<div class="row">
		<div class="col-2">
			<div class="avatar avatar-xxl mg-b-10"><img src="public/img/signin.png" class="img rounded-circle" alt="Responsive image">
			</div>
		</div>

		<div class="col-10 mg-t-30">
			<div class="row mg-l-200">				
				<div class="col-md-auto mg-t-10">
					<p class="">PO #:  <b><?php echo $vpo_no; ?></b></p>
				</div>
				
				<div class="col-md-auto mg-t-10">		
					<p class=" ">PO Date: <b><?php echo dateformat_datepicker($vpo_date); ?></b></p>
				</div>
				
				<div class="col-md-auto mg-t-10">	
					<p class="">Total Amount: <b><?php echo general_currency_symbol.' '.moneyFormatIndia($vpo_tot_value); ?></b></p>	
				</div>
				
				<div class="col-md-auto mg-t-10">	
					<p class="">Total Tax: <b><?php echo general_currency_symbol.' '.moneyFormatIndia($vpo_tot_tax); ?></b></p>	
				</div>
			</div>
		</div>
	</div>

<div class="divider-text">Item Particulars</div>
	<div class="card">
		<div class="card-body">
			<div class="form-group row mg-t-20 mg-l-80 mg-r-50">
				<div class="col-md-3 border-right ">
					<div class="text-uppercase">
					  <span class="text-uppercase text-muted">Reason</span>
					</div>
					
					<div class="mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
					
					  <span> <?php echo getVPOREASON($vpo_reasonid, 'label'); ?></span>
					  
					</div>
					
				</div>
				
				<div class="col-md-3 border-right mg-l-80 mg-r-50">
				
					<div class="text-uppercase text-muted ">
					
					  <span>P.O Sent On</span>
					  
					</div>
					
					<div class="mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
					
						  <span class="text-bold"><?php echo dateformat_datepicker($vpo_sent); ?></span>
						  
						</div>
						
				</div>
				
				<div class="col-md-3 mg-l-30">
				
					<div class="text-uppercase text-muted">
					
					  <span>Reason notes:</span>
					  
					</div>
					
					<div class="mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
					
					  <span><?php echo $vpo_reason; ?></span>
					  
					</div>
					
				</div>
				<?php if($status == '0'){ ?>
				<div class="marker  marker-ribbon p-2 marker-secondary marker-top-right pos-absolute t-10 r-0">
				DRAFT - PO </div>
				<?php }elseif($status == '1'){ ?>
				<div class="marker  marker-ribbon p-2 marker-success marker-top-right pos-absolute t-10 r-0">
				Sent - PO</div>
				<?php } elseif($status == '5'){ ?>
				<div class="marker  marker-ribbon p-2 marker-success marker-top-right pos-absolute t-10 r-0">
				Approved - PO</div>
				<?php } elseif($status == '3'){ ?>
				<div class="marker  marker-ribbon p-2 marker-success marker-top-right pos-absolute t-10 r-0">
				GRN Generated - PO</div>
				<?php } ?>
			</div>
			
		</div>
		
	</div>
	
					<div class="mg-t-20">
						<div class="divider-text">Item particulars details</div>
							<table class="table table-bordered table-hover mg-r-0">
							   <thead class="thead bg-gray-200">
								  <tr>
                                        <th rowspan="2" class="text-center"><input type="checkbox" id="cancel_check" value="0" class="group-checkable" data-set="#contacts_list .checkboxes" /></th>
                                        <th rowspan="2">Product Code</th>
                                        <th rowspan="2">Product Name</th>
                                        <th rowspan="2" class="text-center">Qty</th>
                                        <th class="text-center">Item Price</th>
                                        <th colspan="3" class="text-center">Tax</th>
                                        <th class="text-center">Item Total</th>
                                        
                                    </tr>
                                    <tr>
                                        <th class="text-center small">(in ₹)</th>
                                        <th class="text-center small">%</th>
                                        <th class="text-center small">CGST</th>
                                        <th class="text-center small">SGST</th>
                                        <th class="text-center small" style="border-right-width:1px;">(in ₹)</th>
                                    </tr>
							   </thead>
	
							   <tbody id="fetch_amcparticular">

								<?php  
								$list_vendorpoitems_data = sqlQUERY_LABEL("SELECT * FROM `js_vendor_po_items` where vpo_id='$id' and deleted = '0'") or die("#1-Unable to get PRODUCT CATEGORY:".sqlERROR_LABEL());

								$count_cateogry_list = sqlNUMOFROW_LABEL($list_vendorpoitems_data);
								//$counter_value = '1';
								while($row_value = sqlFETCHARRAY_LABEL($list_vendorpoitems_data)){
								  $counter_value++;
								  $vpo_item_id = $row_value["vpo_item_id"];
								  $vpo_id = $row_value["vpo_id"];
								  $prdt_id = $row_value["prdt_id"];
								  $prdt_serialno = $row_value["prdt_serialno"];
								  $vpo_item_qty = $row_value["vpo_item_qty"];
								  $vpo_item_price = $row_value["vpo_item_price"];
								  $vpo_item_tax = $row_value["vpo_item_tax"];
								  $vpo_item_tax1 = $row_value["vpo_item_tax1"];
								  $vpo_item_tax2 = $row_value["vpo_item_tax2"];
								  $vpo_item_total = $row_value["vpo_item_total"];
								  $vpo_item_received = $row_value["vpo_item_received"];
								  $vpo_item_approved = $row_value["vpo_item_approved"];
								  $vpo_item_difference = $row_value["vpo_item_difference"];
								  $vpo_item_expirydate = $row_value["vpo_item_expirydate"];
								  $vpo_item_grn_status = $row_value["vpo_item_grn_status"];
								  $vpo_discount_value = $row_value['vpo_discount_value'];
								  $vpo_discount_amt = $row_value['vpo_discount_amt'];
								  $vpo_after_discount_price = $row_value['vpo_after_discount_price'];
								  $vpo_dicounted_item_price = ($vpo_after_discount_price/$vpo_item_qty);
								  $vpo_after_discount_item_total = $row_value['vpo_after_discount_item_total'];
								  $status = $row_value["status"];
								  $product_code = getPRODUCTDETAIL($prdt_id, 'code');
								  $product_name = getPRODUCTDETAIL($prdt_id, 'name');
								  
								  ?>
								<tr>
									<?php if($vpo_item_approved == '0'){ ?>
									<td class="text-center"><input type="checkbox" name="vpo_item[]" id="cancel_check" value="<?php echo $vpo_item_id; ?>" class="checkboxes"/></td>
									<?php }else{ ?>
									<td class="text-danger">Not Approved</td>
									<?php } ?>
									<td><?php echo $product_code; ?></td>
									<td><?php echo $product_name; ?><br /><small class="text-muted">S.No: <?php echo $prdt_serialno; ?></small></td>
									<td class="text-center"><?php echo $vpo_item_qty; ?></td>
									<!--<td class="text-right"><?php echo moneyFormatIndia($vpo_item_price); ?></td>-->
									<td class="text-right">
									<?php if($vpo_discount_value !='0' && $vpo_discount_value !='') { ?>
									<del><?php echo moneyFormatIndia($vpo_item_price); ?></del><br>
									<?php echo moneyFormatIndia($vpo_dicounted_item_price); ?>
									<?php } else { ?>
									<?php echo moneyFormatIndia($vpo_item_price); ?>
									<?php } ?>
									</td>
									<td class="text-center"><?php echo $vpo_item_tax; ?></td>
									<td class="text-right"><?php echo moneyFormatIndia($vpo_item_tax1); ?></td>
									<td class="text-right"><?php echo moneyFormatIndia($vpo_item_tax2); ?></td>
									<!--<td class="text-right"><?php echo moneyFormatIndia($vpo_item_total); ?></td>-->
									<td class="text-right">
									<?php if($vpo_discount_value !='0' && $vpo_discount_value !='') { ?>
									<del><?php echo moneyFormatIndia($vpo_item_total); ?></del><br>
									<?php echo moneyFormatIndia($vpo_after_discount_item_total); ?>
									<?php } else { ?>
									<?php echo moneyFormatIndia($vpo_item_total); ?>
									<?php } ?>
									</td>
								</tr>
								
			<?php } ?>
							   </tbody>
				
							</table>
						</div>	

					<!-- Modal -->
					<div id="item_remarks_data" class="modal fade">
						<div class="modal-dialog modal-md" style="overflow-y: initial !important">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title">Vendor PO Checked Product Remarks</h5>
									<button type="button" class="close" data-dismiss="modal">&times;</button>
								</div>
								<div class="modal-body receiving-prdt-remarks" style="max-height: calc(100vh - 200px);overflow-y: auto;">
								</div>
							</div>
						</div>
					</div>

	<div class="col-9 col-sm-12 text-right">
	<input type="hidden" name="vpo_id" value="<?php echo $id; ?>">
	<button type="submit" name="button" id="save" value="approve" class="btn btn-primary">Approve</button>

    <a href="vendorspo.php?route=preview&formtype=preview&id=<?php echo $id;?>" data-toggle="tooltip" data-original-title="Click to Print" class="btn btn-warning">Cancel</a>

	</div>
		
	
	</div>	
	</form>
		<?php } if($grngenerate == 'add'){ ?>


		<form action="" method="post" data-parsley-validate>

	<div class="row">
	
		<div class="col-2">
	
			<div class="avatar avatar-xxl mg-b-10"><img src="public/img/signin.png" class="img rounded-circle" alt="Responsive image">
			</div>
		
		</div>
		

		<div class="col-10 mg-t-30">
		
			<div class="row offset-sm-2">	
			<?php
			
			  $list_parentcategory_datas = sqlQUERY_LABEL("SELECT * FROM `js_vendorpo` where `vpo_id` = '$id'") or die("#1-Unable to get records:".sqlERROR_LABEL());

			  $count_parentcateogry_list = sqlNUMOFROW_LABEL($list_parentcategory_datas);

				  while($row = sqlFETCHARRAY_LABEL($list_parentcategory_datas)){
					
				  $vpo_id = $row["vpo_id"];
				  $vendor_id = $row["vendor_id"];
				  $vpo_no = $row["vpo_no"];
				  $generate_grn_no = $row["generate_grn_no"];
				  $vpo_date = $row["vpo_date"];
				  $vpo_sent = $row["vpo_sent"];
				  $vpo_received = $row["vpo_received"];
				  $vpo_tot_items = $row["vpo_tot_items"];
				  $vpo_tot_qty = $row["vpo_tot_qty"];
				  $vpo_tot_tax = $row["vpo_tot_tax"];
				  $vpo_tot_value = $row["vpo_tot_value"];
				  $vpo_tot_balance = $row["vpo_tot_balance"];
				  $vpo_dispatchthrough = $row["vpo_dispatchthrough"];
				  $vpo_approvedby = $row["vpo_approvedby"];
				  $vpo_deliveredby = $row["vpo_deliveredby"];
				  $vpo_receivedby = $row["vpo_receivedby"];
				  $status = $row["status"]; 
				  $vendorname = getVENDORNAME($vendor_id,'label');
				  }

				  ?>
			
				<div class="col-md-auto mg-t-10">
				
					<p class="">PO #: <b><?php echo $vpo_no; ?></b></p>
					
				</div>
				
				<div class="col-md-auto mg-t-10">		
				
					<p class=" ">PO Date: <b><?php echo dateformat_datepicker ($vpo_date); ?></b></p>
					
				</div>
				
				<div class="col-md-auto mg-t-10">	
				
					<p class="">Total Amount: <b><?php echo moneyFormatIndia($vpo_tot_value); ?></b></p>	
					
				</div>
				
				<div class="col-md-auto mg-t-10">			
				
					<p class="">Balance Amount: <b><?php echo moneyFormatIndia($vpo_tot_balance); ?></b></p>	
					
				</div>
			
			</div>
			
		</div>
		
	</div>

	<div class="divider-text">Payment options</div>
				
	<div class="card">
	
		<div class="card-body">
		
			<div class="form-group row">
			
				<div class="col-md-3 border-right ">
				
					<div class="text-uppercase">
					
					  <span class="">Vendor Info</span>
					  
					</div>
					
					<div class="text-muted mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
					
					  <span><?php echo $vendorname; ?></span>
					  
					</div>
					
				</div>
				
				<div class="col-md-3 border-right ">
				
					<div class="text-uppercase">
					
					  <span>P.O Date</span>
					  
					</div>
					
					<div class="text-muted mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
					
						  <span class="text-bold"><?php echo dateformat_datepicker ($vpo_date); ?></span>
						   
						</div>
						
				</div>
				
				<div class="col-md-3 border-right ">
				
					<div class="text-uppercase">
					
					  <span>P.O Sent on</span>
					  
					</div>
					
					<div class="text-muted mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
					
					  <span><?php echo dateformat_datepicker($vpo_sent); ?></span>
					  
					</div>
					
				</div>
				
				<div class="marker  marker-ribbon p-2 marker-success marker-top-right pos-absolute t-10 r-0">
				Received </div>
				
				<div class="col-md-3">
				
					<div class="text-uppercase">
					
					  <span>P.O Received on</span>
					  
					</div>
					
					<div class="text-muted mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
					
					  <span><?php echo dateformat_datepicker($vpo_received); ?></span>
					  
					</div>
					
				</div>
			
				
			</div>
			
		</div>
		
	</div>

	<div class="divider-text">Product details</div>	
			
		<div class="mg-t-20">
			<table class="table table-bordered table-hover mg-r-0" width="100%">
			   <thead class="thead bg-gray-200">
				  <tr>
						<th  class="text-center">#</th>
						<th>Product Code</th>
						<th>Product Name</th>
						<th class="text-center">Requested</th>									   
						<?php  
						$list_vendorpoitems_data_status = sqlQUERY_LABEL("SELECT * FROM `js_vendor_po_items` where vpo_id='$id' and deleted = '0'") or die("#1-Unable to get PRODUCT CATEGORY:".sqlERROR_LABEL());

						$count_cateogry_list_status = sqlNUMOFROW_LABEL($list_vendorpoitems_data_status);
						//$counter_value = '1';
						while($row_value_status = sqlFETCHARRAY_LABEL($list_vendorpoitems_data_status)){
						  $vpo_item_grn_status = $row_value_status["vpo_item_grn_status"];
						} ?>
						<?php if($vpo_item_grn_status == '1') { ?>
						<th class="text-center">Previously <br> Received Qty</th>
						<th class="text-center">Remaining Qty</th>
						<?php } else {?>
						<th class="text-center">Received Qty</th>
						<?php } ?>
					</tr>
				
			   </thead>

			   <tbody id="fetch_amcparticular">
			   
			   <?php  
									   
			$list_vendorpoitems_data = sqlQUERY_LABEL("SELECT * FROM `js_vendor_po_items` where vpo_id='$id' and deleted = '0'") or die("#1-Unable to get PRODUCT CATEGORY:".sqlERROR_LABEL());

			$count_cateogry_list = sqlNUMOFROW_LABEL($list_vendorpoitems_data);
			//$counter_value = '1';
			while($row_value = sqlFETCHARRAY_LABEL($list_vendorpoitems_data)){
			  $counter_value++;
			  $vpo_item_id = $row_value["vpo_item_id"];
			  $vpo_id = $row_value["vpo_id"];
			  $prdt_id = $row_value["prdt_id"];
			  $prdt_serialno = $row_value["prdt_serialno"];
			  $vpo_item_qty = $row_value["vpo_item_qty"];
			  $vpo_item_price = $row_value["vpo_item_price"];
			  $vpo_item_tax = $row_value["vpo_item_tax"];
			  $vpo_item_tax1 = $row_value["vpo_item_tax1"];
			  $vpo_item_tax2 = $row_value["vpo_item_tax2"];
			  $vpo_item_total = $row_value["vpo_item_total"];
			  $vpo_item_received = $row_value["vpo_item_received"];
			  $vpo_item_approved = $row_value["vpo_item_approved"];
			  $vpo_item_difference = $row_value["vpo_item_difference"];
			  $vpo_item_expirydate = $row_value["vpo_item_expirydate"];
			  $vpo_item_grn_status = $row_value["vpo_item_grn_status"];
			  $status = $row_value["status"];
			  $product_code = getPRODUCTDETAIL($prdt_id, 'code');
			  $product_name = getPRODUCTDETAIL($prdt_id, 'name');
			  if($vpo_item_approved !='0'){$vpo_item_difference = $vpo_item_difference; }
			  if($vpo_item_approved =='0'){$vpo_item_difference = '0'; }
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
					<td><?php echo $product_name; ?><br /><small class="text-muted">S.No: <?php echo $prdt_serialno; ?></small><br><small class="text-danger"><?php if($vpo_item_approved == '0'){ echo "This Product was Rejected by Admin.";}?></small></td>
					<td class="text-center"><?php echo $vpo_item_qty; ?></td>
					<?php if($vpo_item_grn_status == '1') { ?>
					<td class="text-center"><?php echo $vpo_item_received; ?></td>
					<?php } ?>
					<td class="wd-20p"><input type="text"  class="form-control" name="received_qty[]" max="<?php if($vpo_item_difference == '0') {echo $vpo_item_qty; } else { echo $vpo_item_difference; } ?>" id="received_qty[]" <?php if($vpo_item_received==$vpo_item_qty || $vpo_item_approved == '0') { ?> readonly <?php } ?> value="<?php echo $vpo_item_difference; ?>" autocomplete="off">
					</td>
				</tr>
			<?php } ?>
			   </tbody>
			</table>
		</div>
<!--GRN REF LIST START -->
<?php if($vpo_item_grn_status == '1') { ?>
		<div data-label="Example" class="df-example demo-table table-responsive">
			<table id="VPO_GRN_LIST" class="table table-bordered" width="100%">
				<thead>
					<tr>
						<th><?php echo $__contentsno ?></th>
						<th>Product Code</th>
						<th>Invocie Date</th>
						<th>Invoice #</th>
						<th>GRN Date</th>
						<th>GRN Ref #</th>
						<th>Received Qty</th>
						<th>Dispatched Through</th>
						<th>Quality <br>Approved By</th>
						<th>Delivered By</th>
						<th>Received By</th>
						<th>Remarks</th>
					</tr>
				</thead>
				<tbody id="fetch_amcparticular">
			   <?php  
				$list_vendorpoitems_grn_report = sqlQUERY_LABEL("SELECT * FROM `js_vpo_prdt_grn_report` where vpo_id='$id' and deleted = '0'") or die("#1-Unable to get PRODUCT CATEGORY:".sqlERROR_LABEL());

				$count_grn_report_list = sqlNUMOFROW_LABEL($list_vendorpoitems_grn_report);
				//$counter_value = '1';
				while($row_grn_report = sqlFETCHARRAY_LABEL($list_vendorpoitems_grn_report)){
				  $counter_grn_report++;
				  $vpo_prdt_grn_id = $row_grn_report["vpo_prdt_grn_id"];
				  $vpo_id = $row_grn_report["vpo_id"];
				  $prdt_id = $row_grn_report["prdt_id"];
				  $vpo_grn_on = $row_grn_report["vpo_grn_on"];
				  $vpo_invoice_date = $row_grn_report["vpo_invoice_date"];
				  $vpo_invoice_ref_no = $row_grn_report["vpo_invoice_ref_no"];
				  $vpo_grn_ref_no = $row_grn_report["vpo_grn_ref_no"];
				  $vpo_received_qty = $row_grn_report["vpo_received_qty"];
				  $vpo_dispatchthrough = $row_grn_report["vpo_dispatchthrough"];
				  $vpo_approvedby = $row_grn_report["vpo_approvedby"];
				  $vpo_deliveredby = $row_grn_report["vpo_deliveredby"];
				  $vpo_receivedby = $row_grn_report["vpo_receivedby"];
				  $vpo_grn_remarks = $row_grn_report["vpo_grn_remarks"];
				  $status = $row_grn_report["status"];
				  $product_code = getPRODUCTDETAIL($prdt_id, 'code');
				  $product_name = getPRODUCTDETAIL($prdt_id, 'name');
				  if($vpo_grn_ref_no =='') { $vpo_grn_ref_no = '--';}
				  if($vpo_invoice_ref_no =='') { $vpo_invoice_ref_no = '--';}
				  if($vpo_invoice_date =='') { $vpo_invoice_date = '--';}
			  ?>
				<tr>
					<td class="wd-5p text-center"><?php echo $counter_grn_report; ?></td>
					<td class="wd-10p"><?php echo $product_code; ?></td>
					<td class="wd-10p"><?php echo dateformat_datepicker($vpo_invoice_date); ?></td>
					<td class="wd-10p"><?php echo $vpo_invoice_ref_no; ?></td>
					<td><?php echo dateformat_datepicker($vpo_grn_on); ?></td>
					<td class="wd-10p"><?php echo $vpo_grn_ref_no; ?></td>
					<td class="text-center wd-10p"><?php echo $vpo_received_qty; ?></td>
					<td><?php echo $vpo_dispatchthrough; ?></td>
					<td class="wd-10p"><?php echo $vpo_approvedby; ?></td>
					<td><?php echo $vpo_deliveredby; ?></td>
					<td><?php echo $vpo_receivedby; ?></td>
					<td><?php echo $vpo_grn_remarks; ?></td>
				</tr>
			<?php } ?>
			   </tbody>
			</table>
		</div>
<!--GRN REF LIST END -->
<?php } ?>
		<div class="row">
			<div class="form-group col-sm-2">
				<label class="control-label">Date</label>
				<input type="text" class="form-control" name="vpo_invoice_date" id="vpo_invoice_date">
			</div>
			<div class="form-group col-sm-2">
				<label class="control-label">Invoice No</label>
				<input type="text" class="form-control" onblur="get_grn_ref_no();" autocomplete="off" name="vpo_invoice_ref_no" id="vpo_invoice_ref_no">
			</div>

			<div class="form-group col-sm-2">
				<label class="control-label">GRN Ref. No</label>
				<input type="text" class="form-control" name="vpo_grn_ref_no" id="vpo_grn_ref_no" readonly>
			</div>	
		</div>	
		
		<div class="row">
			<div class="form-group col-sm-2">
				<label class="control-label">Dispatched Through<span class="text-danger">*</span></label>
				<input type="text" class="form-control" required data-parsley-pattern="^[a-zA-Z ]+$" data-parsley-whitespace="trim" data-parsley-trigger="keyup" name="vpo_dispatchthrough" id="vpo_dispatchthrough" autocomplete="off">
			</div>
			<div class="form-group col-sm-2">
				<label class="control-label">Quality Approved By<span class="text-danger">*</span></label>
				<input type="text" class="form-control" required data-parsley-pattern="^[a-zA-Z ]+$" data-parsley-whitespace="trim" data-parsley-trigger="keyup" name="vpo_approvedby" id="vpo_approvedby" autocomplete="off">
			</div>
			<div class="form-group col-sm-2">
				<label class="control-label">Delivered By<span class="text-danger">*</span></label>
				<input type="text" class="form-control"  required data-parsley-pattern="^[a-zA-Z ]+$" data-parsley-whitespace="trim" data-parsley-trigger="keyup"name="vpo_deliveredby" id="vpo_deliveredby" autocomplete="off">
			</div>	
			<div class="form-group col-sm-2">
				<label class="control-label">Received By<span class="text-danger">*</span></label>
				<input type="text" class="form-control" required data-parsley-pattern="^[a-zA-Z ]+$" data-parsley-whitespace="trim" data-parsley-trigger="keyup" name="vpo_receivedby" id="vpo_receivedby" autocomplete="off">
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
				<input type="hidden" id="po_id" name="po_id" value="<?php echo $vpo_id; ?>" />

				<input type="hidden" id="po_no" name="po_no" value="<?php echo $vpo_no; ?>" />

				<input type="hidden" id="po_vendor_id" name="po_vendor_id" value="<?php echo $vendor_id; ?>" />

				<input type="hidden" id="po_vendor_status" name="po_vendor_status" value="<?php echo $status; ?>" />

				<button type="submit" id="save" name="save" value="generate-GRN" class="btn btn-primary ember-view">Generate GRN</button>
			
				<a href="vendorspo.php?route=list&formtype=preview&id=<?php echo $vpo_id; ?>" id="cancel" name="cancel" value="cancel" class="btn btn-secondary ember-view">Cancel</a>
			</div>
		</div>
		</form>
<?php } if($grngenerate == 'preview'){ ?>
	
	<div class="row">
	
		<div class="col-2">
	
			<div class="avatar avatar-xxl mg-b-10"><img src="public/img/signin.png" class="img rounded-circle" alt="Responsive image">
			
			</div>
		
		</div>
		

		<div class="col-10 mg-t-30">
		
			<div class="row">	
			
			<?php
			
			  $list_parentcategory_datas = sqlQUERY_LABEL("SELECT * FROM `js_vendorpo` where `vpo_id` = '$id'") or die("#1-Unable to get records:".sqlERROR_LABEL());

			  $count_parentcateogry_list = sqlNUMOFROW_LABEL($list_parentcategory_datas);

				  while($row = sqlFETCHARRAY_LABEL($list_parentcategory_datas)){
					
				  $vpo_id = $row["vpo_id"];
				  $vendor_id = $row["vendor_id"];
				  $vpo_no = $row["vpo_no"];
				  $generate_grn_no = $row["generate_grn_no"];
				  $vpo_invoice_date = $row["vpo_invoice_date"];
				  $vpo_invoice_ref_no = $row["vpo_invoice_ref_no"];
				  $vpo_grn_ref_no = $row["vpo_grn_ref_no"];
				  $vpo_date = $row["vpo_date"];
				  $vpo_sent = $row["vpo_sent"];
				  $vpo_received = $row["vpo_received"];
				  $vpo_tot_items = $row["vpo_tot_items"];
				  $vpo_tot_qty = $row["vpo_tot_qty"];
				  $vpo_tot_tax = $row["vpo_tot_tax"];
				  $vpo_tot_value = $row["vpo_tot_value"];
				  $vpo_tot_balance = $row["vpo_tot_balance"];
				  $vpo_dispatchthrough = $row["vpo_dispatchthrough"];
				  $vpo_approvedby = $row["vpo_approvedby"];
				  $vpo_deliveredby = $row["vpo_deliveredby"];
				  $vpo_receivedby = $row["vpo_receivedby"];
				  $status = $row["status"]; 
				  $vendorname = getVENDORNAME($vendor_id,'label');
				  } 
				  ?>
			
				<div class="col-md-auto mg-t-10">
				
					<p class="">PO #: <b><?php echo $vpo_no; ?></b></p>
					
				</div>
				
				<div class="col-md-auto mg-t-10">		
				
					<p class=" ">PO Date: <b><?php echo dateformat_datepicker($vpo_date); ?></b></p>
					
				</div>
				
				<div class="col-md-auto mg-t-10">	
				
					<p class="">Total Amount: <b><?php echo moneyFormatIndia($vpo_tot_value); ?></b></p>	
					
				</div>
				
				<div class="col-md-auto mg-t-10">			
				
					<p class="">Balance Amount: <b><?php echo moneyFormatIndia($vpo_tot_balance); ?></b></p>	
					
				</div>
				
				<!--<?php if($vpo_invoice_date !='' && $vpo_invoice_ref_no !=''){ ?>
				<div class="col-md-auto mg-t-10">			
				
					<p class="">GRN-REF # : <b><?php echo $vpo_grn_ref_no; ?></b></p>	
					
				</div>
				<?php } ?>-->
			</div>
			
		</div>
		
	</div>

	<div class="divider-text">Payment options</div>
				
	<div class="card">
	
		<div class="card-body">
		
			<div class="form-group row">
			
				<div class="col-md-3 border-right ">
				
					<div class="text-uppercase">
					
					  <span class="">Vendor Info</span>
					  
					</div>
					
					<div class="text-muted mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
					
					  <span><?php echo $vendorname; ?></span>
					  
					</div>
					
				</div>
				
				<div class="col-md-3 border-right ">
				
					<div class="text-uppercase">
					
					  <span>P.O Date</span>
					  
					</div>
					
					<div class="text-muted mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
					
						  <span class="text-bold"><?php echo $vpo_date; ?></span>
						   
						</div>
						
				</div>
				
				<div class="col-md-3 border-right ">
				
					<div class="text-uppercase">
					
					  <span>P.O Sent on</span>
					  
					</div>
					
					<div class="text-muted mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
					
					  <span><?php echo $vpo_sent; ?></span>
					  
					</div>
					
				</div>
				
				<div class="marker  marker-ribbon p-2 marker-success marker-top-right pos-absolute t-10 r-0">
				Received </div>
				
				<div class="col-md-3">
				
					<div class="text-uppercase">
					
					  <span>P.O Received on</span>
					  
					</div>
					
					<div class="text-muted mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
					
					  <span><?php echo dateformat_datepicker ($vpo_received); ?></span>
					  
					</div>
					
				</div>
			
				
			</div>
		</div>
		
	</div>

	<div class="divider-text">Product details</div>
					
		<div class="mg-t-20">
			<table class="table table-bordered table-hover" width="100%">
			   <thead class="thead bg-gray-200">
				  <tr>
						<th  class="text-center">#</th>
						<th>Product Code</th>
						<th>Product Name</th>
						<th class="text-center">Requested</th>
						<th class="text-center">Received</th>
						
					</tr>
				
			   </thead>

			   <tbody id="fetch_amcparticular">
			   
				 
			   <?php  
									   
			$list_vendorpoitems_data = sqlQUERY_LABEL("SELECT * FROM `js_vendor_po_items` where vpo_id = '$id' and deleted = '0'") or die("#1-Unable to get PRODUCT CATEGORY:".sqlERROR_LABEL());

			$count_cateogry_list = sqlNUMOFROW_LABEL($list_vendorpoitems_data);
			//$counter_value = '1';
			while($row_value = sqlFETCHARRAY_LABEL($list_vendorpoitems_data)){
			  $counter_value_preview++;
			  $vpo_item_id = $row_value["vpo_item_id"];
			  $vpo_id = $row_value["vpo_id"];
			  $prdt_id = $row_value["prdt_id"];
			  $prdt_serialno = $row_value["prdt_serialno"];
			  $vpo_item_qty = $row_value["vpo_item_qty"];
			  $vpo_item_price = $row_value["vpo_item_price"];
			  $vpo_item_tax = $row_value["vpo_item_tax"];
			  $vpo_item_tax1 = $row_value["vpo_item_tax1"];
			  $vpo_item_tax2 = $row_value["vpo_item_tax2"];
			  $vpo_item_total = $row_value["vpo_item_total"];
			  $vpo_item_received = $row_value["vpo_item_received"];
			  $vpo_item_approved = $row_value["vpo_item_approved"];
			  $vpo_item_difference = $row_value["vpo_item_difference"];
			  $vpo_item_expirydate = $row_value["vpo_item_expirydate"];
			  $vpo_item_grn_status = $row_value["vpo_item_grn_status"];
			  $status = $row_value["status"];
			  $product_code = getPRODUCTDETAIL($prdt_id, 'code');
			  $product_name = getPRODUCTDETAIL($prdt_id, 'name');
			  ?>
				<tr>
					<td class="wd-5p"><?php echo $counter_value_preview; ?></td>
					<td class="wd-15p"><?php echo $product_code; ?></td>
					<td class="wd-15p"><?php echo $product_name; ?><br /><small class="text-muted">S.No: <?php echo $prdt_serialno; ?></small><br><small class="text-danger"><?php if($vpo_item_approved=='0'){ echo "This Product was Rejected by Admin.";}?></small></td>
					<td class="wd-15p"><?php echo $vpo_item_qty; ?></td>
					<td class="wd-15p"><?php echo $vpo_item_received; ?></td>
			</tr>
			<?php } ?>	
			   </tbody>

			</table>
		</div>	
		
		<!--<div class="row">	
		
		<?php
			
  $list_parentcategory_datas = sqlQUERY_LABEL("SELECT * FROM `js_vendorpo` where `vpo_id` = '$id'") or die("#1-Unable to get records:".sqlERROR_LABEL());

  $count_parentcateogry_list = sqlNUMOFROW_LABEL($list_parentcategory_datas);

	  while($row = sqlFETCHARRAY_LABEL($list_parentcategory_datas)){
		
	  $vpo_id = $row["vpo_id"];
	  $vendor_id = $row["vendor_id"];
	  $vpo_invoice_date = $row["vpo_invoice_date"];
	  $vpo_invoice_ref_no = $row["vpo_invoice_ref_no"];
	  $vpo_grn_ref_no = $row["vpo_grn_ref_no"];
	  $vpo_dispatchthrough = $row["vpo_dispatchthrough"];
	  $vpo_approvedby = $row["vpo_approvedby"];
	  $vpo_deliveredby = $row["vpo_deliveredby"];
	  $vpo_receivedby = $row["vpo_receivedby"];
	  $vpo_grn_remarks = $row["vpo_grn_remarks"];
	  $status = $row["status"]; 
	  $vendorname = getVENDORNAME($vendor_id,'label');
	  if($vpo_invoice_ref_no !=''){ $vpo_invoice_ref_no = $vpo_invoice_ref_no; } else { $vpo_invoice_ref_no = '--';}
	  } ?>
			<div class="form-group col-sm-2">
				<label class="control-label">Dispatched Through:</label><br>
				<span class="tx-bold"><?php echo $vpo_dispatchthrough; ?></span>
			</div>
			<div class="form-group col-sm-2">
				<label class="control-label">Quality Approved By:</label><br>
				<span class="tx-bold"><?php echo $vpo_approvedby; ?></span>			
			</div>
			<div class="form-group col-sm-2">
				<label class="control-label">Delivered By:</label><br>
				<span class="tx-bold"><?php echo $vpo_deliveredby; ?></span>		
			</div>	
			<div class="form-group col-sm-2">
				<label class="control-label">Received By:</label><br>
				<span class="tx-bold"><?php echo $vpo_receivedby; ?></span>			
			</div>
			<div class="form-group col-sm-2">
				<label class="control-label">Invoice Date:</label><br>
				<span class="tx-bold"><?php echo dateformat_datepicker($vpo_invoice_date); ?></span>			
			</div>
			<div class="form-group col-sm-2">
				<label class="control-label">Invoice Ref No:</label><br>
				<span class="tx-bold"><?php echo $vpo_invoice_ref_no; ?></span>			
			</div>
		</div>-->		
		
		<!--<div class="row">	
		
			<div class="form-group col-sm-8">
			
				<label class="control-label">Remarks:</label><br>
				
				<span class="tx-bold"><?php echo $vpo_grn_remarks; ?></span>					
				
			</div>
			
		</div>-->
		

<!--GRN REF LIST START -->
		<div data-label="Example" class="df-example demo-table table-responsive">
			<table id="VPO_GRN_LIST" class="table table-bordered" width="100%">
				<thead>
					<tr>
						<th><?php echo $__contentsno ?></th>
						<th>Product Code</th>
						<th class="wd-5p">Invocie Date</th>
						<th>Invoice #</th>
						<th>GRN Date</th>
						<th>GRN Ref #</th>
						<th>Received Qty</th>
						<th>Dispatched Through</th>
						<th>Quality <br>Approved By</th>
						<th>Delivered By</th>
						<th>Received By</th>
						<th>Remarks</th>
					</tr>
				</thead>
				<tbody id="fetch_amcparticular">
			   <?php  
				$list_vendorpoitems_grn_report = sqlQUERY_LABEL("SELECT * FROM `js_vpo_prdt_grn_report` where vpo_id='$id' and deleted = '0'") or die("#1-Unable to get PRODUCT CATEGORY:".sqlERROR_LABEL());

				$count_grn_report_list = sqlNUMOFROW_LABEL($list_vendorpoitems_grn_report);
				//$counter_value = '1';
				while($row_grn_report = sqlFETCHARRAY_LABEL($list_vendorpoitems_grn_report)){
				  $counter_grn_report++;
				  $vpo_prdt_grn_id = $row_grn_report["vpo_prdt_grn_id"];
				  $vpo_id = $row_grn_report["vpo_id"];
				  $prdt_id = $row_grn_report["prdt_id"];
				  $vpo_grn_on = $row_grn_report["vpo_grn_on"];
				  $vpo_invoice_date = $row_grn_report["vpo_invoice_date"];
				  $vpo_invoice_ref_no = $row_grn_report["vpo_invoice_ref_no"];
				  $vpo_grn_ref_no = $row_grn_report["vpo_grn_ref_no"];
				  $vpo_received_qty = $row_grn_report["vpo_received_qty"];
				  $vpo_dispatchthrough = $row_grn_report["vpo_dispatchthrough"];
				  $vpo_approvedby = $row_grn_report["vpo_approvedby"];
				  $vpo_deliveredby = $row_grn_report["vpo_deliveredby"];
				  $vpo_receivedby = $row_grn_report["vpo_receivedby"];
				  $vpo_grn_remarks = $row_grn_report["vpo_grn_remarks"];
				  $status = $row_grn_report["status"];
				  $product_code = getPRODUCTDETAIL($prdt_id, 'code');
				  $product_name = getPRODUCTDETAIL($prdt_id, 'name');
				  if($vpo_grn_ref_no =='') { $vpo_grn_ref_no = '--';}
				  if($vpo_invoice_ref_no =='') { $vpo_invoice_ref_no = '--';}
				  if($vpo_invoice_date =='') { $vpo_invoice_date = '--';}
			  ?>
				<tr>
					<td class="text-center"><?php echo $counter_grn_report; ?></td>
					<td class="wd-10p"><?php echo $product_code; ?></td>
					<td class="wd-10p"><?php echo dateformat_datepicker($vpo_invoice_date); ?></td>
					<td class="wd-10p"><?php echo $vpo_invoice_ref_no; ?></td>
					<td><?php echo dateformat_datepicker($vpo_grn_on); ?></td>
					<td class="wd-10p"><?php echo $vpo_grn_ref_no; ?></td>
					<td class="text-center wd-10p"><?php echo $vpo_received_qty; ?></td>
					<td><?php echo $vpo_dispatchthrough; ?></td>
					<td class="wd-10p"><?php echo $vpo_approvedby; ?></td>
					<td><?php echo $vpo_deliveredby; ?></td>
					<td><?php echo $vpo_receivedby; ?></td>
					<td><?php echo $vpo_grn_remarks; ?></td>
				</tr>
			<?php } ?>
			   </tbody>
			</table>
		</div>
<!--GRN REF LIST END -->		
		<div class="row">	
			<div class="col-md-4 offset-sm-6">
				<a  class="btn btn-secondary ember-view" href="vendorspo.php?route=list&formtype=preview&id=<?php echo $vpo_id; ?>">Back to PO</a>
			</div>
		</div>	
		
	
				<?php } if($formtype=='import'){ ?>
					<form id="mainform" method="post" enctype="multipart/form-data" action="">
                        <div class="row justify-content-center">
                             <div class="col-lg-12">
	                      	   <h3 class="form-title text-center">
	                              	 Import Items 
		                        </h3>
		                        </div>
                            <div class="col-md-6 col-lg-6 col-xl-6 mx-auto">

            

                                <div class="card mb-4 mt-4">

                                    <div class="card-body">

                                        <div class="form-group">                                

                                            <div class="row">  

                                            

                                             <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 

                                                 <div class="form-group">

                                                       <label class="control-label">Upload your file  <span class="text-danger">*</span></label>

                                                          <div class="valitor">

                                                             <input name="cvs" type="file" class="span6 m-wrap" />

                                                             <span class="help-block"> -Import .CSV format files only. Allowed size 5MB.<br> <a href="sample_vdr.csv">Click to download sample</a><br /></span>

                                                           </div>

                                                    </div>

                                             </div>

                                             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 

                                                
			                               	<button class="btn btn-primary buttonalign_save" type="submit" name=   "upload" value="import">
			                                   	<i class="fa fa-upload">&nbsp;</i> Upload
			                                	</button>
 
                                                </button>

                                               <a href="vendorspo.php?msg=success"class="btn btn-default">Return</a></a>

                                             </div>

                                            

                                            </div> 

                                        </div>                      

                                    </div>

                                </div>

            

                            </div>

                        </div>

                	</form>
          <?php		  
	          //include viewpath('__categorysidebar.php'); 
          ?>
		  </div>
          <?php } ?> 
      </div><!-- container -->
    </div><!-- content -->
