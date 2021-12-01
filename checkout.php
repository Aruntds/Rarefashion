<?php 
extract($_REQUEST);
include 'head/jackus.php'; 
include 'shopfunction.php'; 
include '___class__home.inc'; 
//echo $sid;
if($place_order == 'place_order'){
	//$create_account = $_REQUEST['create_account']; //value='on' == 1 || value='' == 0
	//if($create_account == 'on') { $create_account = '1'; } else { $create_account = '0'; }

	// if($create_account == '1'){
		
		// $username = strbefore($billing_email, '@');

		  // $new_pwd = PwdHash($username,substr('',0,9));

		// $arrFields=array('`username`','`useremail`','`password`','`userapproved`','`roleID`','`status`');

		// $arrValues=array("$username","$billing_email","$new_pwd","1","1","1");

		// if(sqlACTIONS("INSERT","js_users",$arrFields,$arrValues,'')) {
		// $user_id = sqlINSERTID_LABEL();
		// $arrFields=array('`user_id`','`customerfirst`','`customerlast`','`customeremail`','`customerphone`');

		// $arrValues=array("$user_id","$billing_first_name","$billing_last_name","$billing_email","$billing_phone");
		
		// sqlACTIONS("INSERT","js_customer",$arrFields,$arrValues,'');
		
		// }
	
	// } 
	//exit();
	
	$hidden_od_id = $hidden_order_id;
	$hidden_session_id = $sid;
	$hidden_order_amt = $hidden_order_amt;
	
	//billing - payment address
	$billing_first_name = $billing_first_name;
	$billing_last_name = $billing_last_name;
	$billing_phone = $billing_phone;
	$billing_email = $billing_email;
	$billing_address_1 = $billing_address_1;
	$billing_address_2 = $billing_address_2;
	$billing_state = $billing_state;
	$billing_city = $billing_city;
	$billing_country = $billing_country;
	$billing_postcode = $billing_postcode;
	
	if($address_opt == ''){
		//same shipping address
		$shipping_first_name = $billing_first_name;
		$shipping_last_name = $billing_last_name;
		$shipping_phone = $billing_phone;
		$shipping_email = $billing_email;
		$shipping_address_1 = $billing_address_1;
		$shipping_address_2 = $billing_address_2;
		$shipping_state = $billing_state;
		$shipping_city = $billing_city;
		$shipping_country = $billing_country;
		$shipping_postcode = $billing_postcode;
	} else if($address_opt == '1'){
		//different shipping address
		$shipping_first_name = $shipping_first_name;
		$shipping_last_name = $shipping_last_name;
		$shipping_phone = $shipping_phone;
		$shipping_email = $shipping_email;
		$shipping_address_1 = $shipping_address_1;
		$shipping_address_2 = $shipping_address_2;
		$shipping_state = $shipping_state;
		$shipping_city = $shipping_city;
		$shipping_country = $shipping_country;
		$shipping_postcode = $shipping_postcode;	
	}
	
	$order_comments = $order_comments;
	$payment_method = $payment_type;

	
		$order_status = '1'; // NEW 
		$payment_status = '3'; // PENDING 
	  if($logged_user_id==''){
		 $logged_user_id =0; 
	  }else{
		 $user_id  = $logged_user_id; 
	  }
		//if($hidden_od_id !=''){
			
			if($radioname==''){
			$arrFields=array('`customerID`', '`ship_fname`', '`ship_lname`', '`ship_country`', '`ship_street1`', '`ship_street2`', '`ship_city`', '`ship_state`', '`ship_pin`', '`status`', '`createdby`');

			$arrValues=array("$logged_user_id", "$shipping_first_name", "$shipping_last_name", "$shipping_country", "$shipping_address_1", "$shipping_address_2", "$shipping_city", "$shipping_state", "$shipping_postcode", '1',"$logged_user_id");

			if(sqlACTIONS("INSERT","js_shipping_address",$arrFields,$arrValues, '')){
			}
			}
			//echo 'test';die;
			
			$arrFields=array('`od_userid`','`od_sesid`','`od_shipping_address_opt`','`od_payment_mode`','`od_status`','`od_shipping_first_name`','`od_shipping_last_name`','`od_shipping_address1`','`od_shipping_address2`','`od_shipping_email`','`od_shipping_phone`','`od_shipping_city`','`od_shipping_state`','`od_shipping_postal_code`','`od_shipping_country`','`od_payment_first_name`','`od_payment_last_name`','`od_payment_address1`','`od_payment_address2`','`od_payment_email`','`od_payment_phone`','`od_payment_city`','`od_payment_state`','`od_payment_postal_code`','`od_payment_country`','`od_payment_status`','`od_memo`','`od_total`','`status`','`od_date`');

			$arrValues=array("$user_id","$sid","$address_opt","$payment_method","$order_status","$shipping_first_name","$shipping_last_name","$shipping_address_1","$shipping_address_2","$shipping_email","$shipping_phone","$shipping_city","$shipping_state","$shipping_postcode","$shipping_country","$billing_first_name","$billing_last_name","$billing_address_1","$billing_address_2","$billing_email","$billing_phone","$billing_city","$billing_state","$billing_postcode","$billing_country","$payment_status","$order_comments","$hidden_order_amt","1",date('Y-m-d h:i:sa'));
	//	print_r($arrValues);exit();
		$sqlwhere = "createdby = '$logged_user_id' and od_userid='$logged_user_id' and od_id = '$hidden_od_id' and od_sesid= '$sid'";

		 if(sqlACTIONS("INSERT","js_shop_order",$arrFields,$arrValues)){
           $last_od_id=sqlINSERTID_LABEL();
				 //  print_r($last_od_id);exit();
		 }
		 
			// sqlQUERY_LABEL("UPDATE `js_shop_order` SET `od_shipping_address_opt`='$address_opt', `od_payment_mode` ='$payment_method',`od_status` ='$order_status',`od_shipping_first_name` ='$shipping_first_name',`od_shipping_last_name` ='$shipping_last_name',`od_shipping_address1` ='$shipping_address_1',`od_shipping_address2` ='$shipping_address_2',`od_shipping_email` ='$shipping_email',`od_shipping_phone` ='$shipping_phone',`od_shipping_city` ='$shipping_city',`od_shipping_state` ='$shipping_state',`od_shipping_postal_code` ='$shipping_postcode',`od_shipping_country` ='$shipping_country',`od_payment_first_name` ='$billing_first_name',`od_payment_last_name` ='$billing_last_name',`od_payment_address1` ='$billing_address_1',`od_payment_address2` ='$billing_address_2',`od_payment_email` ='$billing_email',`od_payment_phone` ='$billing_phone',`od_payment_city` ='$billing_city',`od_payment_state` ='$billing_state',`od_payment_postal_code` ='$billing_postcode',`od_payment_country` ='$billing_country',`od_payment_status`='$payment_status', `od_memo`='$order_comments', `od_total` = '$hidden_order_amt' WHERE createdby = '$logged_user_id' and od_userid = '$logged_user_id' and od_id = '$hidden_od_id' and od_sesid= '$hidden_session_id'") or die(sqlERROR_LABEL());
			
			
		//}
		
		
		if($logged_user_id !=''){

			
			$arrFields=array('`status`','`od_id`');

			$arrValues=array("0","$last_od_id");
		
			$sqlwhere = "user_id='$logged_user_id' and status='1'";
			
		 sqlACTIONS("UPDATE","js_shop_order_item",$arrFields,$arrValues,$sqlwhere);

		
		}
		//exit();
		
	if($payment_method == 'cod'){
			
			?>
		<script type="text/javascript">window.location = 'payment_processing.php?order_status=placed&order_key=<?php echo base64_encode($last_od_id); ?>&token=<?php echo $sid; ?>&pmode=<?php echo base64_encode($payment_method); ?>' </script>
		<?php	
			
		
	}
	
	if($payment_method == 'razor'){
		
			$paymenttoken = base64_encode("$billing_email|$billing_first_name");
		    $paymentamount = base64_encode("$hidden_order_amt");
		?>
		<script type="text/javascript">window.location = 'payment_processing.php?order_status=placed&order_key=<?php echo base64_encode($last_od_id); ?>&token=<?php echo $sid; ?>&pmode=<?php echo base64_encode($payment_method); ?>&pamount=<?php echo $paymentamount; ?>&ptoken=<?php echo $paymenttoken; ?>' </script>
		<?php
	    }
}


/***********************************/
  //get order basic informations//
/**********************************/
		if($logged_user_id){
			
		$__main_order_details_query = sqlQUERY_LABEL("select `od_id`, `od_memo`, `od_sesid`, `od_shipping_address_opt`, `od_shipping_first_name`, `od_shipping_last_name`, `od_shipping_address1`, `od_shipping_address2`, `od_shipping_email`, `od_shipping_phone`, `od_shipping_city`, `od_shipping_state`, `od_shipping_postal_code`, `od_shipping_country`, `od_shipping_type`, `od_shipping_cost`, `od_payment_first_name`, `od_payment_last_name`, `od_payment_address1`, `od_payment_address2`, `od_payment_email`, `od_payment_phone`, `od_payment_city`, `od_payment_state`, `od_payment_postal_code`, `od_payment_country` FROM `js_shop_order` where `od_userid`='$logged_user_id' and `od_sesid` = '$sid'") or die(sqlERROR_LABEL());
		} else {
		$__main_order_details_query = sqlQUERY_LABEL("select `od_id`, `od_memo`, `od_sesid`, `od_shipping_address_opt`, `od_shipping_first_name`, `od_shipping_last_name`, `od_shipping_address1`, `od_shipping_address2`, `od_shipping_email`, `od_shipping_phone`, `od_shipping_city`, `od_shipping_state`, `od_shipping_postal_code`, `od_shipping_country`, `od_shipping_type`, `od_shipping_cost`, `od_payment_first_name`, `od_payment_last_name`, `od_payment_address1`, `od_payment_address2`, `od_payment_email`, `od_payment_phone`, `od_payment_city`, `od_payment_state`, `od_payment_postal_code`, `od_payment_country` FROM `js_shop_order` where `od_sesid` = '$sid'") or die(sqlERROR_LABEL());	
		}
$check_main_order_num_rows = sqlNUMOFROW_LABEL($__main_order_details_query);

if($check_main_order_num_rows > 0) {
	
	$__main_order_data = sqlFETCHASSOC_LABEL($__main_order_details_query);

	$od_shipping_address_opt = $__main_order_data['od_shipping_address_opt'];

	//Payment/Shipping Address
	if($__main_order_data['od_shipping_first_name'] != '') {
		$_checkout_shipping_fname = $__main_order_data['od_shipping_first_name'];
	} else if($_checkout_shipping_fname != '') {
		$_checkout_shipping_fname = $__global_ship_fname;
	} else { 
		$_checkout_shipping_fname = $__global_customerfirst; 
	}
	
	if($__main_order_data['od_shipping_last_name'] != '') {
		$_checkout_shipping_lname = $__main_order_data['od_shipping_last_name'];
	} else if($_checkout_shipping_lname != '') {
		$_checkout_shipping_lname = $__global_ship_lname;
	} else { 
		$_checkout_shipping_lname = $__global_customerlast; 
	}
	
	if($__main_order_data['od_shipping_address1'] != '') {
		$_checkout_shipping_street1 = $__main_order_data['od_shipping_address1'];
	} else { $_checkout_shipping_street1 = $__global_ship_street1;	}
	
	if($__main_order_data['od_shipping_address2'] != '') {
		$_checkout_shipping_street2 = $__main_order_data['od_shipping_address2'];
	} else { $_checkout_shipping_street2 = $__global_ship_street2; }
		  
	if($__main_order_data['od_shipping_email'] != '') {
		$_checkout_shipping_email = $__main_order_data['od_shipping_email'];
	} else { 
		$_checkout_shipping_email = $__global_customeremail; 
	} //else { $_checkout_shipping_email = $__global_ship_fname; }	
	
	if($__main_order_data['od_shipping_phone'] != '') {
		$_checkout_shipping_phone = $__main_order_data['od_shipping_phone'];
	} else { 
		$_checkout_shipping_phone = $__global_customerphone; 
	}// else { $_checkout_shipping_phone = $__global_ship_fname; }
	
	if($__main_order_data['od_shipping_city'] != '') {
		$_checkout_shipping_city = $__main_order_data['od_shipping_city'];
	} else { $_checkout_shipping_city = $__global_ship_city; }
	
	if($__main_order_data['od_shipping_state'] != '') {
		$_checkout_shipping_state = $__main_order_data['od_shipping_state'];
	} else { $_checkout_shipping_state = $__global_ship_state; }
	
	if($__main_order_data['od_shipping_postal_code'] != '') {
		$_checkout_shipping_pin = $__main_order_data['od_shipping_postal_code'];
	} else { $_checkout_shipping_pin = $__global_ship_pin; }	 
	
	if($__main_order_data['od_shipping_country'] != '') {
		$_checkout_shipping_country = $__main_order_data['od_shipping_country'];
	} else { $_checkout_shipping_country = $__global_ship_country; }


	//Billing Address
	if($__main_order_data['od_payment_first_name'] != '') {
		$_checkout_payment_fname = $__main_order_data['od_payment_first_name'];
	} else { $_checkout_payment_fname = $__global_bill_fname; }
	
	if($__main_order_data['od_payment_last_name'] != '') {
		$_checkout_payment_lname = $__main_order_data['od_payment_last_name'];
	} else { $_checkout_payment_lname = $__global_bill_lname; }
	
	if($__main_order_data['od_payment_address1'] != '') {
		$_checkout_payment_street1 = $__main_order_data['od_payment_address1'];
	} else { $_checkout_payment_street1 = $__global_bill_street1;	}
	
	if($__main_order_data['od_payment_address2'] != '') {
		$_checkout_payment_street2 = $__main_order_data['od_payment_address2'];
	} else { $_checkout_payment_street2 = $__global_bill_street2; }
	
	if($__main_order_data['od_payment_email'] != '') {
		$_checkout_payment_email = $__main_order_data['od_payment_email'];
	} else { 
		$_checkout_payment_email = $__global_customeremail; 
	} //else { $_checkout_payment_email = $__global_bill_fname; }	
	
	if($__main_order_data['od_payment_phone'] != '') {
		$_checkout_payment_phone = $__main_order_data['od_payment_phone'];
	} else { 
		$_checkout_payment_phone = $__global_customerphone; 
	}// else { $_checkout_payment_phone = $__global_bill_fname; }
	
	if($__main_order_data['od_payment_city'] != '') {
		$_checkout_payment_city = $__main_order_data['od_payment_city'];
	} else { $_checkout_payment_city = $__global_bill_city; }
	
	if($__main_order_data['od_payment_state'] != '') {
		$_checkout_payment_state = $__main_order_data['od_payment_state'];
	} else { $_checkout_payment_state = $__global_bill_state; }
	
	if($__main_order_data['od_payment_postal_code'] != '') {
		$_checkout_payment_pin = $__main_order_data['od_payment_postal_code'];
	} else { $_checkout_payment_pin = $__global_bill_pin; }	 
	
	if($__main_order_data['od_payment_country'] != '') {
		$_checkout_payment_country = $__main_order_data['od_payment_country'];
	} else { $_checkout_payment_country = $__global_bill_country; }
}

?>	
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="description" content="<?php echo $productmetadescrption; ?>"/>
    <meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1"/>
    <link rel="canonical" href="<?php echo curPageURL(); ?>" />
    <meta property="og:locale" content="en_GB" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="<?php echo $productmetatitle; ?>" />
    <meta property="og:description" content="<?php echo $productmetadescrption; ?>" />
    <meta property="og:url" content="<?php echo curPageURL(); ?>" />
    <meta property="og:site_name" content="HTML Online" />
    <meta property="og:updated_time" content="<?php echo time_stamp($updatedon); ?>" />
    <meta property="og:image" content="<?php echo SITEHOME; ?>head/uploads/productmediagallery/<?php echo $productmediagalleryurl; ?>" />
    <meta property="og:image:secure_url" content="<?php echo SITEHOME; ?>head/uploads/productmediagallery/<?php echo $productmediagalleryurl; ?>" />
    <meta property="og:image:width" content="542" />
    <meta property="og:image:height" content="241" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:description" content="<?php echo $productmetadescrption; ?>" />
    <meta name="twitter:title" content="<?php echo $productmetatitle; ?>" />
    <meta name="twitter:image" content="<?php echo SITEHOME; ?>head/uploads/productmediagallery/<?php echo $productmediagalleryurl; ?>" />
	<?php include '__styles.php'; ?>
</head>

<body>
    <!--[if lte IE 9]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
    <![endif]-->
	<div class="page-wrapper">
    <?php 
		
		//list of module view templates
		$loadFUNCTIONS = array(
		'__header'
		);
		
		echo $homepage_propertyclass->loadPAGE($loadFUNCTIONS); 
	
	?> 

        <div class="fullwidth-template">
		<?php 
			
			//list of module view templates
			$loadbodyFUNCTIONS = array(
			'__order_checkout'
			);	
			echo $homepage_propertyclass->loadPAGE($loadbodyFUNCTIONS); 

		?>
		</div>

    <?php

		//list of module view templates
		$loadFUNCTIONS = array(
		'__footer',
		'__scripts'
		);
		
		echo $homepage_propertyclass->loadPAGE($loadFUNCTIONS); 
	
	?>
</div><!-- End .page-wrapper -->

</body>

</html>