<?php
extract($_REQUEST);
include_once('head/jackus.php');
include 'shopfunction.php'; 
include '___class__home.inc';
//echo $sid;
//print_r($_SESSION);


if($add_to_cart_in_details == 'add_to_cart_in_details'){
// echo $productID; exit();
	$PRDT_ID = $productID; 
	$VARIANT_ID = $product_size;
	$sku_CODE = getPRDT_CODE($PRDT_ID,'','get_prdt_code');
	$PRDT_QTY = '1'; 
	$current_SESSION_ID = $sid;  // VALUES RECEIVE FROM CONFIG.PHP
	$check_product_variants = commonNOOFROWS_COUNT('js_productvariants',"parentproduct = '$PRDT_ID'");
	if($check_product_variants == 0 && $VARIANT_ID == '' && $PRDT_ID !=''){

		$featured_product_data = sqlQUERY_LABEL("SELECT `productID`, `productsellingprice`, `producttax`, `producttaxtype`  FROM `js_product` where productID='$PRDT_ID' and deleted = '0' and status = '1'") or die("#1-Unable to get records:".mysqli_error());
	  while($featured_data = sqlFETCHARRAY_LABEL($featured_product_data)){
		  $productID = $featured_data["productID"];
		  $productsellingprice = $featured_data["productsellingprice"];
		  $producttax = $featured_data["producttax"];
		  $producttaxtype = $featured_data["producttaxtype"];
	  }											
	//echo "A";
	if($PRDT_ID !='' && $current_SESSION_ID !=''){
		
		$check_selecteditem = sqlQUERY_LABEL("select `pd_id`, `od_colorid`, `od_size_id`, `od_qty`, `od_price`, `item_tax1`, `item_tax2` from js_shop_order_item where user_id = '$logged_user_id' and od_session = '$current_SESSION_ID' and pd_id = '$PRDT_ID'") or die(sqlERROR_LABEL());
		
		if(sqlNUMOFROW_LABEL($check_selecteditem) == 0) {
			
			/////////////////////// ADD MAIN BILL
			//echo $logged_user_id;
			// $check_bill = sqlQUERY_LABEL("select `od_id`,`od_sesid` from js_shop_order where od_sesid = '$current_SESSION_ID' and od_userid = '$logged_user_id'");
				// if(sqlNUMOFROW_LABEL($check_bill) == 0) {
					
					// $creating_new_billrecord = sqlQUERY_LABEL("INSERT into `js_shop_order` (`od_userid`, `od_sesid`,  `createdon`, `createdby`) VALUES ('$logged_user_id', '$current_SESSION_ID', '".date('Y-m-d H:i:s')."', '$logged_user_id')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
					// $od_id = sqlINSERTID_LABEL();
				// } else {
					// while($collect_bill = sqlFETCHARRAY_LABEL($check_bill)) {
					// $od_id = $collect_bill['od_id'];
					// $od_sesid = $collect_bill['od_sesid'];
					// }
				// }
				$product_qty = $PRDT_QTY;

			///CHECK PRODUCT ESTORE STOCK VIA API
			$list_producttype_data = sqlQUERY_LABEL("select `productopeningstock`,`productavailablestock` from js_product where productsku = '$sku_CODE'");
			$count_producttype_list = sqlNUMOFROW_LABEL($list_producttype_data);
				while($get_product_data = sqlFETCHARRAY_LABEL($list_producttype_data)) {
					$prdt_opening_qty = $get_product_data['productopeningstock'];
					$prdt_available_qty = $get_product_data['productavailablestock'];
				}

				$productsellingprice = ($product_qty * $productsellingprice);

				if($producttaxtype == 'Y') {
					$taxsplit_price = ($productsellingprice * ($producttax/100))/2;
					$total_price = ($productsellingprice - ($taxsplit_price* 2));
				} else {
					$taxsplit_price = (($productsellingprice * ($producttax/100))/2);
					$total_price = $productsellingprice;
				}

			///////////////////////		ADD BILL-ITEM

			// echo "INSERT into `js_shop_order_item` (`createdby`, `od_id`, `pd_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_customer_id', '$od_id', '$PRDT_ID', '$logged_customer_id', '$current_SESSION_ID', '$product_qty', '$total_price', '$producttaxtype', '$producttax', '$taxsplit_price', '$taxsplit_price','1')";
			// exit();
			if($product_qty <= $prdt_available_qty){
				sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$logged_user_id', '$current_SESSION_ID', '$product_qty', '$total_price', '$producttaxtype', '$producttax', '$taxsplit_price', '$taxsplit_price','1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
				$message = "Cart added...!!!";
			} else {
				?>
				<script type="text/javascript">window.location = 'dashboard.php?nav=order&prdt_error=outofstock1' </script>
				<?php
			}
		} else {
		
			while($collect_selecteditem = sqlFETCHARRAY_LABEL($check_selecteditem)) {

				$quantity = $collect_selecteditem['od_qty'] + 1;
				$total_price = $collect_selecteditem['od_price'];
				$item_tax1 = $collect_selecteditem['item_tax1'];
				$item_tax2 = $collect_selecteditem['item_tax2'];
				if($quantity > 1){
					$old_total_price = (($item_tax1 + $item_tax2 + $total_price)/$collect_selecteditem['od_qty']);
				} else {
					$old_total_price = $item_tax1 + $item_tax2 + $total_price;
				}
				$newtotal_price = $old_total_price * $quantity;
				// echo $quantity;
				// echo "<br>";
				// echo $qty;
				// echo "<br>";
				// echo $old_total_price;
				// echo "<br>";
				// echo $newtotal_price;
				// echo "<br>";
				
			///CHECK PRODUCT ESTORE STOCK VIA API
			$list_producttype_data = sqlQUERY_LABEL("select `productopeningstock`,`productavailablestock` from js_product where productsku = '$sku_CODE'");
			$count_producttype_list = sqlNUMOFROW_LABEL($list_producttype_data);
				while($get_product_data = sqlFETCHARRAY_LABEL($list_producttype_data)) {
					$prdt_opening_qty = $get_product_data['productopeningstock'];
					$prdt_available_qty = $get_product_data['productavailablestock'];
				}
				
				if($producttaxtype == 'Y') {
					$taxsplit_price = ($newtotal_price * ($producttax/100))/2;
					$newtotal_price = ($newtotal_price - ($taxsplit_price * 2));
				} else {
					$taxsplit_price = (($newtotal_price * ($producttax/100))/2);
					$newtotal_price = $newtotal_price;
				}
			}
			// echo "B";
			// echo "UPDATE `js_shop_order_item` SET `od_price` = '$newtotal_price', `od_qty`='$quantity', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_customer_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_customer_id' and pd_id = '$PRDT_ID'";
			// exit();
			if($quantity <= $prdt_available_qty){
			sqlQUERY_LABEL("UPDATE `js_shop_order_item` SET `od_price` = '$newtotal_price', `od_qty`='$quantity', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_customer_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_customer_id' and pd_id = '$PRDT_ID'") or die(sqlERROR_LABEL());
			$message = "Cart updated...!!!";
			} else {
				?>
				<script type="text/javascript">window.location = 'dashboard.php?nav=order&prdt_error=outofstock4' </script>
				<?php
			}
		}
		?>
		<script type="text/javascript">window.location = 'dashboard.php?nav=order&prdt_details=cart_added1' </script>
		<?php
	}			
	} else {
	/* print_r($_REQUEST);
	print_r($_SESSION); exit(); */
	
	$featured_product_data = sqlQUERY_LABEL("SELECT `variant_ID`, `parentproduct`, `variant_code`, `variant_msp_price`, `variant_taxtype`, `variant_tax_value`, `variant_taxsplit1`, `variant_taxsplit2`  FROM `js_productvariants` where parentproduct='$PRDT_ID' and variant_ID = '$VARIANT_ID' and deleted = '0' and status = '1'") or die("#1-Unable to get records:".mysqli_error());
	  while($featured_data = sqlFETCHARRAY_LABEL($featured_product_data)){
		  $variant_ID = $featured_data["variant_ID"];
		  $parentproduct = $featured_data["parentproduct"];
		  $variant_code = $featured_data["variant_code"];
		  $variant_msp_price = $featured_data["variant_msp_price"];
		  $variant_taxtype = $featured_data["variant_taxtype"];
		  $variant_tax_value = $featured_data["variant_tax_value"];
		  $variant_taxsplit1 = $featured_data["variant_taxsplit1"];
		  $variant_taxsplit2 = $featured_data["variant_taxsplit2"];
		  $variant_prdt_final_price = ($variant_msp_price + $variant_taxsplit1 + $variant_taxsplit2);
	  }
	  
	//  echo $PRDT_ID.'</br>'.$current_SESSION_ID.'</br>'.$variant_ID.'</br>'; 
	  
		if($PRDT_ID !='' && $current_SESSION_ID !='' && $variant_ID !=''){
			//echo "select `pd_id`, `variant_id`, `od_colorid`, `od_size_id`, `od_qty`, `od_price`, `item_tax1`, `item_tax2` from js_shop_order_item where user_id = '$logged_user_id' and od_session = '$current_SESSION_ID' and pd_id = '$PRDT_ID' and variant_id='$variant_ID'";
			$check_selecteditem1 = sqlQUERY_LABEL("select `pd_id`, `variant_id`, `od_colorid`, `od_size_id`, `od_qty`, `od_price`, `item_tax1`, `item_tax2` from js_shop_order_item where user_id = '$logged_user_id' and od_session = '$current_SESSION_ID' and pd_id = '$PRDT_ID' and variant_id='$variant_ID'") or die(sqlERROR_LABEL());
			
			if(sqlNUMOFROW_LABEL($check_selecteditem1) == 0) {
				
				/////////////////////// ADD MAIN BILL
				//echo 'Test'; exit();
				// $check_bill = sqlQUERY_LABEL("select `od_id`,`od_sesid` from js_shop_order where od_sesid = '$current_SESSION_ID' and od_userid = '$logged_user_id'");
					// if(sqlNUMOFROW_LABEL($check_bill) == 0) {
						// $creating_new_billrecord = sqlQUERY_LABEL("INSERT into `js_shop_order` (`od_userid`, `od_sesid`,  `createdon`, `createdby`) VALUES ('$logged_user_id', '$current_SESSION_ID', '".date('Y-m-d H:i:s')."', '$logged_user_id')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
						// $od_id = sqlINSERTID_LABEL();
					// } else {
						// while($collect_bill = sqlFETCHARRAY_LABEL($check_bill)) {
						// $od_id = $collect_bill['od_id'];
						// $od_sesid = $collect_bill['od_sesid'];
						// }
					// }
					$product_qty = $PRDT_QTY;
					//echo $variant_code; exit();
					///CHECK PRODUCT ESTORE STOCK VIA API
					$list_producttype_data = sqlQUERY_LABEL("select `variant_opening_stock`,`variant_available_stock` from js_productvariants where variant_code = '$variant_code'");
					$count_producttype_list = sqlNUMOFROW_LABEL($list_producttype_data);
						while($get_product_data = sqlFETCHARRAY_LABEL($list_producttype_data)) {
							$variant_prdt_opening_qty = $get_product_data['variant_opening_stock'];
							$variant_prdt_available_qty = $get_product_data['variant_available_stock'];
						}
						
					$productsellingprice = ($product_qty * $variant_prdt_final_price);

					if($variant_taxtype == 'Y') {
						$taxsplit_price = ($productsellingprice * ($variant_tax_value/100))/2;
						$total_price = ($productsellingprice - ($taxsplit_price* 2));
					} else {
						$taxsplit_price = (($productsellingprice * ($variant_tax_value/100))/2);
						$total_price = $productsellingprice;
					}

				///////////////////////		ADD BILL-ITEM
				//echo $productsellingprice.'</br>';
				//echo $taxsplit_price.'</br>';
				//echo "INSERT into `js_shop_order_item` (`createdby`, `od_id`, `pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id', '$od_id', '$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$product_qty', '$total_price', '$variant_taxtype', '$producttax', '$taxsplit_price', '$taxsplit_price','1')";
				//echo '</br>if';
				//exit();
				if($product_qty <= $variant_prdt_available_qty){
					sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`, `pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$product_qty', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price','1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
					$message = "Cart added...!!!";
				} else {
					?>
					<script type="text/javascript">window.location = 'dashboard.php?nav=order&prdt_error=outofstock2' </script>
					<?php
				}
			} else {
			
				while($collect_selecteditem = sqlFETCHARRAY_LABEL($check_selecteditem1)) {

					$quantity = $collect_selecteditem['od_qty'] + $PRDT_QTY;
					$total_price = $collect_selecteditem['od_price'];
					$item_tax1 = $collect_selecteditem['item_tax1'];
					$item_tax2 = $collect_selecteditem['item_tax2'];
					if($quantity > 1){
						$old_total_price = (($item_tax1 + $item_tax2 + $total_price)/$collect_selecteditem['od_qty']);
					} else {
						$old_total_price = $item_tax1 + $item_tax2 + $total_price;
					}
					$newtotal_price = $old_total_price * $quantity;
					// echo $quantity;
					// echo "<br>";
					// echo $qty;
					// echo "<br>";
					// echo $old_total_price;
					// echo "<br>";
					// echo $newtotal_price;
					// echo "<br>"; exit();

					// echo "select `productopeningstock`,`productavailablestock` from js_product where productsku = '$variant_code'"; exit();	
					///CHECK PRODUCT ESTORE STOCK VIA API
					$list_producttype_data = sqlQUERY_LABEL("select `variant_opening_stock`,`variant_available_stock` from js_productvariants where variant_code = '$variant_code'");
					$count_producttype_list = sqlNUMOFROW_LABEL($list_producttype_data);
						while($get_product_data = sqlFETCHARRAY_LABEL($list_producttype_data)) {
							$variant_prdt_opening_qty = $get_product_data['variant_opening_stock'];
							$variant_prdt_available_qty = $get_product_data['variant_available_stock'];
						}
					
					if($variant_taxtype == 'Y') {
						$taxsplit_price = ($newtotal_price * ($variant_tax_value/100))/2;
						$newtotal_price = ($newtotal_price - ($taxsplit_price * 2));
					} else {
						$taxsplit_price = (($newtotal_price * ($variant_tax_value/100))/2);
						$newtotal_price = $newtotal_price;
					}
				}
				//echo "UPDATE `js_shop_order_item` SET `od_price` = '$newtotal_price', `od_qty`='$quantity', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_user_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_user_id' and pd_id = '$PRDT_ID'";
				//echo '</br>else';
				//exit();
				if($quantity <= $variant_prdt_available_qty){
					sqlQUERY_LABEL("UPDATE `js_shop_order_item` SET `od_price` = '$newtotal_price', `od_qty`='$quantity', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_user_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_user_id' and pd_id = '$PRDT_ID'") or die(sqlERROR_LABEL());
					$message = "Cart updated...!!!";
				} else {
					?>
					<script type="text/javascript">window.location = 'dashboard.php?nav=order&prdt_error=outofstock3' </script>
					<?php
				}
			}

		}
		?>
		<script type="text/javascript">window.location = 'dashboard.php?nav=order&prdt_details=cart_added2' </script>
		<?php
	}
}

if($email != ''){
	$query= "SELECT * FROM `js_users` where useremail='$email'";
				// echo $query;
		$result = sqlQUERY_LABEL($query);
			while($row = sqlFETCHARRAY_LABEL($result))
			{ $user_email = $row['useremail']; }
				
// echo "SELECT * FROM `js_customers` where customer_mobile='$number'";

	// Request variables are filtered

	$query= "SELECT `userID`,`useremail`,`password`,`userapproved`,`roleID`,`userbanned` FROM js_users WHERE `username` = '$user_email' OR `useremail` = '$user_email'  AND `deleted` = '0'";
    $result = sqlQUERY_LABEL($query);
	$num = sqlNUMOFROW_LABEL($result);
	//echo $num,$user_email; exit();
	//Match row found with more than 1 results  - the user is authenticated. 

    if ( $num > 0 ) { 

		while($row_pay = sqlFETCHARRAY_LABEL($result)){

			$userID = $row_pay["userID"];
			$useremail = $row_pay["useremail"];
			$password = $row_pay["password"];
			$userapproved = $row_pay["userapproved"];
			$roleID = $row_pay["roleID"];$userbanned = $row_pay["userbanned"];
			$staff_id = $row_pay["staff_id"];
		}

		//list($userID,$useremail,$password,$userapproved,$roleID,$userbanned,$staff_id) = sqlFETCHROW_LABEL($result);

		if(!$userapproved) {

		echo "<script type='text/javascript'>window.location = 'index.php?session=invalid&code=2'</script>";
		//header("Location:index.php?session=invalid&code=2");

		 }

		if($userbanned == 1 ) {
		
		echo "<script type='text/javascript'>window.location = 'index.php?session=invalid&code=3'</script>";
		//header("Location:index.php?session=invalid&code=3");
		 }
		if ($useremail == $email) { 
			// this sets session and logs user in 
			$session_id_reg = $sid;

			session_start();
			session_regenerate_id (true); //prevent against session fixation attacks.

			// this sets variables in the session 
			$_SESSION['reg_user_id']= $userID;  
			$_SESSION['reg_user_name'] = $useremail;
			$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
								
					$result_reg_session_item = sqlQUERY_LABEL("SELECT * FROM `js_shop_order_item` WHERE  `od_session` = '$session_id_reg' and `deleted`='0' and `status` ='1'") or die(sqlERROR_LABEL());
					$result_reg_session = sqlQUERY_LABEL("SELECT * FROM `js_shop_order` WHERE  `od_sesid` = '$session_id_reg' and `deleted`='0' and `status` ='1'") or die(sqlERROR_LABEL());
					$num_reg_session_item = sqlNUMOFROW_LABEL($result_reg_session_item);
					$num_reg_session = sqlNUMOFROW_LABEL($result_reg_session);
					if($num_reg_session_item > 0 || $num_reg_session > 0 ){
						sqlQUERY_LABEL("UPDATE `js_shop_order_item` SET `user_id` = '$userID' WHERE `od_session` = '$session_id_reg' and `deleted`='0' and `status` ='1'") or die(sqlERROR_LABEL());
						sqlQUERY_LABEL("UPDATE `js_shop_order` SET `od_userid` = '$userID' WHERE `od_sesid` = '$session_id_reg' and `deleted`='0' and `status` ='1'") or die(sqlERROR_LABEL());
					}

				//update the timestamp and key for cookie
				$stamp = time();
				$ckey = GenPwd();
			
				sqlQUERY_LABEL("update js_users set `userlogtime`='$stamp', `userlogkey` = '$ckey' where userID='$id'") or die(sqlERROR_LABEL());
					
				//set a cookie 
				setcookie("reg_user_id", $_SESSION['reg_user_id'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				setcookie("reg_user_key", sha1($ckey), time()+60*60*24*COOKIE_TIME_OUT, "/");
				setcookie("reg_user_name",$_SESSION['reg_user_name'], time()+60*60*24*COOKIE_TIME_OUT, "/");
	
				echo "<script type='text/javascript'>window.location = 'dashboard.php?msg=login&type=information'</script>"; 
				
				
		
				
				exit();
		
		} else {
			
			echo "<script type='text/javascript'>window.location = 'index.php?session=invalid&code=4'</script>";
			//header("Location:index.php?session=invalid&code=4");
		}
	
		} else {
			echo "<script type='text/javascript'>window.location = 'index.php?session=invalid&code=5'</script>";
			//header("Location:index.php?session=invalid&code=5");
	    }		
	
	
	}
	
	// session_start();
 // print_r($_SESSION);

if($addshiping_address == 'shiping_address'){

	$arrFields=array('`customerID`', '`ship_fname`', '`ship_lname`', '`ship_company`', '`ship_country`', '`ship_street1`', '`ship_street2`', '`ship_city`', '`ship_state`', '`ship_phone`','`ship_pin`', '`status`', '`createdby`');

	$arrValues=array("$logged_user_id", "$ship_fname", "$ship_lname", "$ship_company", "$ship_country", "$ship_street1", "$ship_street2", "$ship_city", "$ship_state","$ship_phone", "$ship_pin", '1',"$logged_user_id");
 		
		if(sqlACTIONS("INSERT","js_shipping_address",$arrFields,$arrValues, '')){
			echo "<script type='text/javascript'>window.location = 'dashboard.php?nav=address&msg=add_address'</script>"; 
			exit();
		}
 }
 if($editshiping_address == 'edit_shiping_address'){

	$arrFields=array('`customerID`', '`ship_fname`', '`ship_lname`', '`ship_company`', '`ship_country`', '`ship_street1`', '`ship_street2`', '`ship_city`', '`ship_state`','`ship_phone`', '`ship_pin`', '`status`', '`createdby`');

	$arrValues=array("$logged_user_id", "$ship_fname", "$ship_lname", "$ship_company", "$ship_country", "$ship_street1", "$ship_street2", "$ship_city", "$ship_state","$ship_phone", "$ship_pin", '1',"$logged_user_id");
	// print_r($arrValues);
	// echo "SELECT * FROM `js_shipping_address` where deleted = '0' and `customerID`='$logged_customer_id' and Id=$card_id";exit();
	$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_shipping_address` where deleted = '0' and `customerID`='$logged_user_id' and Id=$card_id") or die("Unable to get records:".sqlERROR_LABEL());			
	$check_record_availabity = sqlNUMOFROW_LABEL($list_datas);	

	if($check_record_availabity != 0){
		$sqlwhere ="customerID ='$logged_user_id' and Id='$card_id'";
		//echo $sqlwhere;exit();
		if(sqlACTIONS("UPDATE","js_shipping_address",$arrFields,$arrValues, $sqlwhere)){
			echo "<script type='text/javascript'>window.location = 'dashboard.php?nav=address&msg=update_address'</script>"; 
			exit();
		}
	}

 }
 
 if(curPageURL() == SEOURL.'dashboard.php') {
	$dashboard_active = "active";
} else if(curPageURL() == SEOURL.'dashboard.php?nav=order'){
	$order_active = "active";
} else if(curPageURL() == SEOURL.'dashboard.php?nav=address'){
	$address_active = "active";
} else if(curPageURL() == SEOURL.'dashboard.php?nav=account'){
	$account_active = "active";
}
 
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<?php include '__styles.php'; ?>
</head>
<body>
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
		'__dashboard',
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
	<script>
		function getresult(url) {
	    var filterby = get_filter('filterby');
	    // var filterby_period = get_filter_period('filter_period');
	    var filterby_period = get_filter_period();
	    var filterby_year = get_filter_year();
	    var logged_user_id = '<?php echo $logged_user_id; ?>';
		// alert(filterby)
		$('#load-productscreen').show();
		$.ajax({
			url: url,
			type: "GET",
			data:  {rowcount:$("#rowcount").val(),"pagination_setting":"all-links", filterby:filterby, filterby_period:filterby_period, filterby_year:filterby_year, logged_user_id:logged_user_id },
			beforeSend: function(){$("#load-productscreen").show();},
			success: function(data){				
				$("#order-list-pagination").html(data);
				setInterval(function() {$("#load-productscreen").hide(); },500);
				//setInterval(function() {$("#load-productscreen").hide(); },500);
			},
			error: function() 
			{} 	        
		});
	}
	
	function get_filter(class_name)
    {
        var filter = [];
        $('.'+class_name+':checked').each(function(){
            filter.push($(this).attr('id'));
        });
        return filter;
    }	
	// function get_filter_period(class_name)
    // {
        // var filter = [];
        // $('.'+class_name+':checked').each(function(){
            // filter.push($('#period_date_start').attr('value'));
            // filter.push($('#period_date_end').attr('value'));
        // });
        // return filter;
    // }	
	function get_filter_period()
    {
        var filter = [];
		var urlParams = new URLSearchParams(window.location.search);
		filter.push(urlParams.get('period_date_start'));
		filter.push(urlParams.get('period_date_end'));
        return filter;
    }		
	function get_filter_year()
    {
        var filter = [];
		var urlParams = new URLSearchParams(window.location.search);
		filter.push(urlParams.get('particular_year'));
        return filter;
    }	
	$( document ).ready(function() {
		var urlParams = new URLSearchParams(window.location.search);
		
		if(urlParams.get('nav')=="order" && urlParams.get('mode')!="cancel"){ 
			getresult("ajax/order_list_pagination.php");
		}
		
		if(urlParams.get('period_date_start') != '' && urlParams.get('period_date_end') != ''){
			getresult("ajax/order_list_pagination.php");
		}
		
	});
	
	$('.period_filter').click(function(){
       getresult("ajax/order_list_pagination.php");
    });
	$('.year_filter').click(function(){
       getresult("ajax/order_list_pagination.php");
    });
	
	$('.common_selector_order').click(function(){
		if($('#filter_content:visible').length != '0'){
			$("#filter_content").slideToggle("slow");
		}
		if($('#filter_content_year:visible').length != '0'){
			$("#filter_content_year").slideToggle("slow");
		}
       getresult("ajax/order_list_pagination.php");
    });
	
	$('.sidebar-filter-clear').click(function(){
		location.assign("<?php echo SITEHOME; ?>dashboard.php?nav=order");
    });
	
	$('.filter_close').click(function(){
		$('body').removeClass('sidebar-filter-active');
    });
	
	$(".filter_period").click(function() {
		$("#filter_content").slideToggle("slow");
		if($('#filter_content_year:visible').length != '0'){
			$("#filter_content_year").slideToggle("slow");
		}
	});
	$(".filter_year").click(function() {
		$("#filter_content_year").slideToggle("slow");
		if($('#filter_content:visible').length != '0'){
			$("#filter_content").slideToggle("slow");
		}
	});
$(function () {
  $("#period_date_start").datepicker({ 
        autoclose: true, 
        todayHighlight: true,
		dateformat: 'mm/dd/yy',
  });
  
  $("#period_date_end").datepicker({ 
        autoclose: true, 
        todayHighlight: true,
		dateformat: 'mm/dd/yy',
  });
  
  $("#particular_year").datepicker({ 
        autoclose: true, 
        todayHighlight: true,
		dateformat: 'yyyy',
		viewMode: "years", 
		minViewMode: "years"
  });
});
		</script>
</body>

</html>