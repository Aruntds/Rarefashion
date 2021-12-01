<?php
//get customer basic informations
if(isset($logged_customer_id)) {
	
	$_global_customer_datas = sqlQUERY_LABEL("SELECT * FROM `js_customer` where deleted = '0' and `user_id`='$logged_customer_id'") or die("Unable to get records:".sqlERROR_LABEL());			
	$_globalcheck_record_availabity = sqlNUMOFROW_LABEL($_global_customer_datas);			
	
	if($_globalcheck_record_availabity > 0) {
		while($_global_customer_row = sqlFETCHARRAY_LABEL($_global_customer_datas)){
		  $__global_customerID = $_global_customer_row["user_id"];
		  $__global_referral_code = $_global_customer_row["referral_code"];
		  $__global_reference_code = $_global_customer_row["reference_code"];
		  $__global_customergroup = $_global_customer_row["customergroup"];
		  $__global_customerfirst = $_global_customer_row["customerfirst"];
		  $__global_customerlast = $_global_customer_row["customerlast"];
		  $__global_customeremail = $_global_customer_row["customeremail"];
		  $__global_customerdob = dateformat_datepicker($_global_customer_row["customerdob"]);
		  $__global_customergender = $_global_customer_row["customergender"];
		  $__global_customerphone = $_global_customer_row["customerphone"];
		  $__global_customeraddress1 = $_global_customer_row["customeraddress1"];
		  $__global_customeraddress2 = $_global_customer_row["customeraddress2"];
		  $__global_customerpincode = $_global_customer_row["customerpincode"];
		  $__global_customerstate = $_global_customer_row["customerstate"];
		  $__global_customercountry = $_global_customer_row["customercountry"];
		  $__global_status = $_global_customer_row["status"];
			
		}
	} else {
		customer_logout();
	}
	
	//BILLING ADDRESS
	$_global_customerbilling_datas = sqlQUERY_LABEL("SELECT * FROM `js_billing_address` where deleted = '0' and `customerID`='$__global_customerID'") or die("Unable to get records:".sqlERROR_LABEL());			
	$check_record_availabity = sqlNUMOFROW_LABEL($_global_customerbilling_datas);			

	while($_global_customerbilling_row = sqlFETCHARRAY_LABEL($_global_customerbilling_datas)){
		$__global_bill_fname = $_global_customerbilling_row["bill_fname"];
		$__global_bill_lname = $_global_customerbilling_row["bill_lname"];
		$__global_bill_company = $_global_customerbilling_row["bill_company"];
		$__global_bill_country = $_global_customerbilling_row["bill_country"];
		$__global_bill_street1 = $_global_customerbilling_row["bill_street1"];
		$__global_bill_street2 = $_global_customerbilling_row["bill_street2"];
		$__global_bill_city = $_global_customerbilling_row["bill_city"];
		$__global_bill_state = $_global_customerbilling_row["bill_state"];
		$__global_bill_pin = $_global_customerbilling_row["bill_pin"];
	}	
	
	//SHIPPING ADDRESS
	$_global_customershipping_datas = sqlQUERY_LABEL("SELECT * FROM `js_shipping_address` where deleted = '0' and `customerID`='$__global_customerID'") or die("Unable to get records:".sqlERROR_LABEL());			
	$check_record_availabity2 = sqlNUMOFROW_LABEL($_global_customershipping_datas);			

	while($_global_customershipping_row = sqlFETCHARRAY_LABEL($_global_customershipping_datas)){
		$__global_ship_fname = $_global_customershipping_row["ship_fname"];
		$__global_ship_lname = $_global_customershipping_row["ship_lname"];
		$__global_ship_company = $_global_customershipping_row["ship_company"];
		$__global_ship_country = $_global_customershipping_row["ship_country"];
		$__global_ship_street1 = $_global_customershipping_row["ship_street1"];
		$__global_ship_street2 = $_global_customershipping_row["ship_street2"];
		$__global_ship_city = $_global_customershipping_row["ship_city"];
		$__global_ship_state = $_global_customershipping_row["ship_state"];
		$__global_ship_pin = $_global_customershipping_row["ship_pin"];
	}

}

function orderTOTALSUMMARY($orderID, $request) {
	
	$selectod_discount_data = sqlQUERY_LABEL("select SUM(od_discount_amount) AS OD_TOTAL_DISCOUNT, od_discount_promo_ID FROM `js_shop_order` where `od_id`='$orderID'") or die(sqlERROR_LABEL());
	$collect_od_discount_data = sqlFETCHASSOC_LABEL($selectod_discount_data);
	
		if($request == 'discounttotal') {
			return $OD_TOTAL_DISCOUNT = $collect_od_discount_data['OD_TOTAL_DISCOUNT'];
		}
		$OD_TOTAL_DISCOUNT = $collect_od_discount_data['OD_TOTAL_DISCOUNT'];
		$od_dicount_promo_ID = $collect_od_discount_data['od_dicount_promo_ID'];

	$selectpo_itemlist = sqlQUERY_LABEL("select count(*) as po_itemcount, SUM(od_price) AS OD_TOTAL, SUM(od_qty) AS OD_TOT_QTY, SUM(item_tax1) AS OD_totaltax1, SUM(item_tax2) AS OD_totaltax2 FROM `js_shop_order_item` where  `od_id`='$orderID'") or die(sqlERROR_LABEL());
	$collect_itemlist_data = sqlFETCHASSOC_LABEL($selectpo_itemlist);
		
		$po_itemcount = $collect_itemlist_data['po_itemcount'];
		$OD_TOT_QTY = $collect_itemlist_data['OD_TOT_QTY'];
		$OD_totaltax1 = $collect_itemlist_data['OD_totaltax1'];
		$OD_totaltax2 = $collect_itemlist_data['OD_totaltax2'];
		$OD_SUB_TOTAL = $collect_itemlist_data['OD_TOTAL'];
		
		if($request == 'subtotal') {
			return $OD_SUB_TOTAL;
		}
		
		
		if($request == 'taxtotal') {
			return ($OD_totaltax1+$OD_totaltax2);
		}
		
		if($request == 'ordertotal') {
			return $OD_TOTAL = ($OD_SUB_TOTAL + $OD_totaltax1 + $OD_totaltax2)-($OD_TOTAL_DISCOUNT);
		}
		
}