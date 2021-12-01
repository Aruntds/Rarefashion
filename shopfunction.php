<?php
error_reporting(0);

if(basename(__FILE__) == basename($_SERVER['PHP_SELF']))
{
echo "How did you end up here.  <a href='index.php'>click here</a> we will take you to safe place.";
exit();

}


$server_date = date('Y-m-d H:i:s');
/************ Regsitered User Credentials ***************/
$reguserid = $_SESSION['reg_user_id'];  
$reguser_name = $_SESSION['reg_user_name'];
//$reguser_level = $_SESSION['reg_user_level'];

//get logged user level 

/************** UNDER CONSTRUCTION PAGE ********************/

if($currentpage != 'underconst.php') {
	if($site_active == '1') {
echo "<div style='width: 350px; text-align: center; margin: 20% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we redirect you...</div>";
		echo "<script type='text/javascript'>window.location = 'underconst.php'</script>";
	}
}

function deleteAbandonedCart()
{
	$yesterday = date('Y-m-d H:i:s', mktime(0,0,0, date('m'), date('d') - 1, date('Y')));
	$sql = "DELETE FROM js_shop_order WHERE od_date < '$yesterday' and od_status = '8'";
	$deletingorder = sqlQUERY_LABEL($sql);
	if($deletingorder) {
		//delete the ordered items also
		//`js_shop_order_item` (`od_id`, `pd_id`, `od_qty`, `od_price`)
		$sql = "DELETE FROM js_shop_order WHERE od_date < '$yesterday' and od_status = '8'";
			
	}
	
}


/********************        Adding full product to cart Common      **********************/
if(isset($_POST['submit_full_product']) == 'Add to cart' || isset($_POST['mini_submit_product']) == 'Add to cart') {
	
	//color id - od_colorid
	$ord_session = $_POST['current_session'];
	$ord_product_id = $_POST['product_id'];
	$ord_color_id = $_POST['product_color'];
	$ord_size_id = $_POST['product_size'];
	$ord_availablestock = $_POST['available_stock'];
	$ord_qty = $_POST['qty'];
	//$ord_product_color = $_POST['product_color'];
	$ord_product_price = $_POST['product_price'];
	$ord_cart_item = $_POST['od_cart_item'];
	
	//echo $ord_qty.'>'.$ord_availablestock.'<br />';
	
	if ($ord_qty > $ord_availablestock) { 
		$typed_higher_quantity = true; 
	} else {
		if($ord_availablestock > 0) {
		//checking already session created ?
		$gettingorder_tabledtls = sqlQUERY_LABEL("select * from js_shop_order where od_sesid = '$ord_session' and od_status = '8'") or die(mysqli_error());
		$checkingorder_availabel = sqlNUMOFROW_LABEL($gettingorder_tabledtls);
		
		if($checkingorder_availabel == 0) {	
			
			//adding first time orders in main table
			$new_orderdetail = sqlQUERY_LABEL("Insert into js_shop_order (`od_userid`, `od_sesid`, `od_date`, `od_status`) values ('$reguserid', '$ord_session', '".date('Y-m-d H:i:s')."', '8')") or die(mysqli_error());
			
			$orderid = mysqli_insert_id();
			
			if($orderid) {
				
				$total_orderprice_qty = ($ord_qty*$ord_product_price);
				$formated_total_order=number_format($total_orderprice_qty, 2, '.', '');
				echo "Insert into js_shop_order_item (`od_id`, `pd_id`, `od_colorid`, `od_size_id`, `od_qty`, `od_cart_item`, `od_price`) values 
				('$orderid', '$ord_product_id', '$ord_color_id', '$ord_size_id', '$ord_qty', '$ord_cart_item', '$formated_total_order')";exit();
				//`js_shop_order_item` (`od_id`, `pd_id`, `od_qty`, `od_price`)
				$new_order = sqlQUERY_LABEL("Insert into js_shop_order_item (`od_id`, `pd_id`, `od_colorid`, `od_size_id`, `od_qty`, `od_cart_item`, `od_price`) values 
				('$orderid', '$ord_product_id', '$ord_color_id', '$ord_size_id', '$ord_qty', '$ord_cart_item', '$formated_total_order')") or die(mysqli_error());
				
				if($new_order) {
					$new_product_insertion = true;
				}
				
			}
			
			} else {

			//already exist?		
			//getting order details
			while($getorder_dtls = sqlFETCHARRAY_LABEL($gettingorder_tabledtls )) {
				$updateqty_ordid = $getorder_dtls['od_id'];
				$updateqty_od_sesid = $getorder_dtls['od_sesid'];
				
				//geting previous quantity
				$getold_quantity = sqlQUERY_LABEL("select * from js_shop_order_item where od_id = '$updateqty_ordid' and pd_id = '$ord_product_id'")
				 or die(mysqli_error());
				
				//checking already the product included or not
				$check_product_inserted = sqlNUMOFROW_LABEL($getold_quantity);
				//$check_cart_item_inserted = sqlNUMOFROW_LABEL($getold_quantity);
				while($existing_qty_dtl = sqlFETCHARRAY_LABEL($getold_quantity)) {
					$old_quantity_dtl = $existing_qty_dtl['od_qty'];
					$old_cart_item_dtl = $existing_qty_dtl['od_cart_item'];
				}
				
				if($check_product_inserted) {
					$newquantity = ($old_quantity_dtl + $ord_qty);
					$new_cart_item = ($old_cart_item_dtl + $ord_cart_item);
					//echo $new_cart_item; exit();
					//update quantity and price if product already avaialble
					$update_orderitems=sqlQUERY_LABEL("update js_shop_order_item set od_qty='$newquantity', `od_cart_item`='$new_cart_item', `od_colorid`='$ord_color_id', `od_size_id`='$ord_size_id' where pd_id='".$ord_product_id."' and od_id='".$updateqty_ordid."'") or die(mysqli_error());
					
				} else {

					//inserting product if qty not available
					
					//$total_orderprice_qty = ($ord_qty*$ord_product_price);
					$total_orderprice_qty = $ord_product_price;
					$formated_total_order=number_format($total_orderprice_qty, 2, '.', '');
	
					$new_order = sqlQUERY_LABEL("Insert into js_shop_order_item (`od_id`, `pd_id`, `od_colorid`, `od_size_id`, `od_qty`, `od_cart_item`, `od_price`) values 
					('$updateqty_ordid', '$ord_product_id', '$ord_color_id', '$ord_size_id', '$ord_qty', '$ord_cart_item', '$formated_total_order')") or die(mysqli_error());
				}
			}
				
				//start if quantity updated
				if($update_orderitems || $new_order) {

					$order_shopping_dtls = sqlQUERY_LABEL("select * from js_shop_order where od_sesid = '$sid' and od_status = '8'") or die(mysqli_error());
					$checking_shopping_order_availabel = sqlNUMOFROW_LABEL($order_shopping_dtls);
					
					while($get_shoppingorder_dtls = sqlFETCHARRAY_LABEL($order_shopping_dtls )) {
						$shoppingqty_ordid = $get_shoppingorder_dtls['od_id'];
						
						//geting previous quantity
						$getold_quantity = sqlQUERY_LABEL("select * from js_shop_order_item where od_id = '$shoppingqty_ordid'")
						 or die(mysqli_error());
							while($getavailable_qty_rate = sqlFETCHARRAY_LABEL($getold_quantity)) {
								$product_id = $getavailable_qty_rate['pd_id'];
								$product_qty = $getavailable_qty_rate['od_qty'];
								$product_price = $getavailable_qty_rate['od_price'];
								
								$total_orderprice_qty += ($product_qty*$product_price);
								
							}
						$toupdate_check_total_order=number_format($total_orderprice_qty, 2, '.', '');
					
					//update order price
					$update_orderitems=sqlQUERY_LABEL("update js_shop_order set od_total='$toupdate_check_total_order' where od_sesid='".$ord_session."' and od_id='".$updateqty_ordid."'") or die(mysqli_error());
					}

					if($update_orderitems) {
						$product_qty_update = true;
					}
					
				}
				
			}
		
		} else {
			$outof_stock_detail = true;
		}
	
	}
}


/********************        Add product to wishlist list      **********************/
if($_GET['action'] == 'wishlist') {
	
	$get_productid = $_GET['product_id'];
	$returnurl = base64_decode($_GET['returnurl']);
	
	if($reguserid) {
	
	//checking wishlist already exist
	$checkwishlist = sqlQUERY_LABEL("select * from js_wishlist where wish_userid = '$reguserid' and wish_prdtid ='$get_productid'") or die(mysqli_error());
	$total_wishlist_count = sqlNUMOFROW_LABEL($checkwishlist); 
	
	if($total_wishlist_count == 0) {
	//`js_wishlist` (`wish_id`, `wish_userid`, `wish_prdtid`, `wish_createdon`)
	$wishlist_sql = "INSERT into js_wishlist (`wish_userid`, `wish_prdtid`, `wish_createdon`) values ('$reguserid','$get_productid','".date('Y-m-d H:i:s')."')";
	$wishlist_created = sqlQUERY_LABEL($wishlist_sql)or die("There was a problem while adding wishlist: ". mysqli_error()); 	
	} else {
		echo "<script type='text/javascript'>alert('This product is already in your wish list!!!');</script>";
	echo "<script type='text/javascript'>window.location = '$returnurl'</script>";
	}
	}
	
	//if($wishlist_created) { $prduct_addedto_wishlist = true; } else { $access_restricted = true; }
	
	/*echo "<div style='width: 350px; text-align: center; margin: 20% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update the cart list...</div>";*/
	
	if($wishlist_created) {
	//$prduct_addedto_wishlist = true;
	echo "<script type='text/javascript'>window.location = '$returnurl&prduct_addedto_wishlist=1'</script>";
	}
		
}


/******************* Getting Order detail globally  *******************/
//`js_shop_order` (`od_id`, `od_sesid`, `od_refno`, od_payment_mode, `od_date`, `od_last_update`, `od_status`, `od_memo`, `od_shipping_first_name`, `od_shipping_last_name`, `od_shipping_address1`, `od_shipping_address2`, `od_shipping_email`, `od_shipping_phone`, `od_shipping_city`, `od_shipping_state`, `od_shipping_postal_code`, `od_shipping_country`, `od_shipping_cost`, `od_payment_first_name`, `od_payment_last_name`, `od_payment_address1`, `od_payment_address2`, `od_payment_email`, `od_payment_phone`, `od_payment_city`, `od_payment_state`, `od_payment_postal_code`, `od_payment_country`, `od_total`)

//banktransfer - paypal

$getcurrentorder_tabledtls = sqlQUERY_LABEL("select * from js_shop_order where od_sesid = '$sid' and od_status = '8'") or die(mysqli_error());
while($active_order_detail = sqlFETCHARRAY_LABEL($getcurrentorder_tabledtls)) {
	$global_orderid = $active_order_detail['od_id'];
	$global_orderomemo = $active_order_detail['od_memo'];
	$global_shippingcost = $active_order_detail['od_shipping_cost'];
	$global_order_total = $active_order_detail['od_total'];
	$global_order_paymentmode = $active_order_detail['od_payment_mode'];
	$global_testimonials = $active_order_detail['od_testimonial'];
	
	//shipping/delivery records
	$global_shipping_first_name = $active_order_detail['od_shipping_first_name'];
	$global_shipping_last_name = $active_order_detail['od_shipping_last_name'];
	$global_shipping_address1 = $active_order_detail['od_shipping_address1'];
	$global_shipping_address2 = $active_order_detail['od_shipping_address2'];
	$global_shipping_email = $active_order_detail['od_shipping_email'];
	$global_shipping_phone = $active_order_detail['od_shipping_phone'];
	$global_shipping_city = $active_order_detail['od_shipping_city'];
	$global_shipping_country = $active_order_detail['od_shipping_country'];
	$global_shipping_postal_code = $active_order_detail['od_shipping_postal_code'];
	
	//getting country name
	//js_country_list - cl_id / cl_name
	$get_shipping_companylist = sqlQUERY_LABEL("select * from js_country_list where cl_id = '$global_shipping_country'") or die(mysqli_error());
	while($collecting_shipping_companyname = sqlFETCHARRAY_LABEL($get_shipping_companylist)) {
		$shipping_companyname = $collecting_shipping_companyname['cl_name'];
	}
	
	//getting a single result from different fields
	if($global_shipping_first_name && $global_shipping_address1 && $global_shipping_email && $global_shipping_phone && $global_shipping_country && $global_shipping_postal_code) { $no_shipping_address = true; }
	
	//payment/billing records
	$global_payment_first_name = $active_order_detail['od_payment_first_name'];
	$global_payment_last_name = $active_order_detail['od_payment_last_name'];
	$global_payment_address1 = $active_order_detail['od_payment_address1'];
	$global_payment_address2 = $active_order_detail['od_payment_address2'];
	$global_payment_email = $active_order_detail['od_payment_email'];
	$global_payment_phone = $active_order_detail['od_payment_phone'];
	$global_payment_city = $active_order_detail['od_payment_city'];
	$global_payment_country = $active_order_detail['od_payment_country'];
	$global_payment_postal_code = $active_order_detail['od_payment_postal_code'];
	
	//getting a single result from different fields
	if($global_payment_first_name && $global_payment_address1 && $global_payment_email && $global_payment_phone && $global_payment_country && $global_payment_postal_code) { $no_payment_address = true; }
	
	//getting total quantity
	//`js_shop_order_item` (`od_id`, `pd_id`, `od_qty`, `od_price`)
	$total_qty_tabledtls = sqlQUERY_LABEL("select * from js_shop_order_item where od_id = '$global_orderid'") or die(mysqli_error());
	$global_order_prdt_qty = sqlNUMOFROW_LABEL($total_qty_tabledtls);
}


?>        
