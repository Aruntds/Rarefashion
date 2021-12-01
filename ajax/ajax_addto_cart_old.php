<?php 
extract($_REQUEST);

include '../head/jackus.php';
// session_start();
//Print_r ($_REQUEST);
	// color id - od_colorid
	// $ord_session = $_POST['current_session'];
	// $ord_product_id = $_POST['product_id'];
	// $ord_color_id = $_POST['product_color'];
	// $ord_size_id = $_POST['product_size'];
	// $ord_availablestock = $_POST['available_stock'];
	// $ord_qty = $_POST['qty'];
	// $ord_product_color = $_POST['product_color'];
	// $ord_product_price = $_POST['product_price'];
	// $ord_cart_item = $_POST['od_cart_item'];
	
	//echo $ord_qty.'>'.$ord_availablestock.'<br />';
	
	if ($ord_qty > $ord_availablestock) { 
		$typed_higher_quantity = true; 
	} else {
		if($ord_availablestock > 0) {
		//checking already session created ?
		
		$gettingorder_tabledtls = sqlQUERY_LABEL("select * from js_shop_order where od_sesid = '$ord_session' and od_status = '8'") or die(sqlERROR_LABEL());
		$checkingorder_availabel = sqlNUMOFROW_LABEL($gettingorder_tabledtls);
		
		if($checkingorder_availabel == 0) {	
			
			//adding first time orders in main table
			$new_orderdetail = sqlQUERY_LABEL("Insert into js_shop_order (`od_userid`, `od_sesid`, `od_date`, `od_status`) values ('$reguserid', '$ord_session', '".date('Y-m-d H:i:s')."', '8')") or die(sqlERROR_LABEL());
			
			$orderid = sqlINSERTID_LABEL();
			
			if($orderid) {
				
				$total_orderprice_qty = ($ord_qty*$ord_product_price);
				$formated_total_order=number_format($total_orderprice_qty, 2, '.', '');
				//echo "Insert into js_shop_order_item (`od_id`, `pd_id`, `od_colorid`, `od_size_id`, `od_qty`, `od_price`, `od_session`, `status`) values 
				//('$orderid', '$ord_product_id', '$ord_color_id', '$ord_size_id', '$ord_qty', '$formated_total_order', '$ord_session', '1')";exit();
				//`js_shop_order_item` (`od_id`, `pd_id`, `od_qty`, `od_price`)
				$new_order = sqlQUERY_LABEL("Insert into js_shop_order_item (`od_id`, `pd_id`, `od_colorid`, `od_size_id`, `od_qty`, `od_price`, `od_session`, `status`) values 
				('$orderid', '$ord_product_id', '$ord_color_id', '$ord_size_id', '$ord_qty', '$formated_total_order', '$ord_session', '1')") or die(sqlERROR_LABEL());
				
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
				$getold_quantity = sqlQUERY_LABEL("select * from js_shop_order_item where od_id = '$updateqty_ordid' and pd_id = '$ord_product_id' and od_session = '$ord_session'")
				 or die(sqlERROR_LABEL());
				
				//checking already the product included or not
				$check_product_inserted = sqlNUMOFROW_LABEL($getold_quantity);
				//$check_cart_item_inserted = mysql_num_rows($getold_quantity);
				while($existing_qty_dtl = sqlFETCHARRAY_LABEL($getold_quantity)) {
					$old_quantity_dtl = $existing_qty_dtl['od_qty'];
					//$old_cart_item_dtl = $existing_qty_dtl['od_cart_item'];
				}
				
				if($check_product_inserted) {
					$newquantity = ($old_quantity_dtl + $ord_qty);
					//$new_cart_item = ($old_cart_item_dtl + $ord_cart_item);
					//echo $new_cart_item; exit();
					//update quantity and price if product already avaialble
					$update_orderitems=sqlQUERY_LABEL("update js_shop_order_item set od_qty='$newquantity', `od_colorid`='$ord_color_id', `od_size_id`='$ord_size_id' where pd_id='".$ord_product_id."' and od_id='".$updateqty_ordid."'") or die(sqlERROR_LABEL());
					
				} else {

					//inserting product if qty not available
					
					//$total_orderprice_qty = ($ord_qty*$ord_product_price);
					$total_orderprice_qty = $ord_product_price;
					$formated_total_order=number_format($total_orderprice_qty, 2, '.', '');
	
					$new_order = sqlQUERY_LABEL("Insert into js_shop_order_item (`od_id`, `pd_id`, `od_colorid`, `od_size_id`, `od_qty`, `od_price`, `od_session`, `status`) values 
					('$updateqty_ordid', '$ord_product_id', '$ord_color_id', '$ord_size_id', '$ord_qty', '$formated_total_order', '$ord_session', '1')") or die(sqlERROR_LABEL());
				}
			}
				
				//start if quantity updated
				if($update_orderitems || $new_order) {

					$order_shopping_dtls = sqlQUERY_LABEL("select * from js_shop_order where od_sesid = '$sid' and od_status = '8'") or die(sqlERROR_LABEL());
					$checking_shopping_order_availabel = sqlNUMOFROW_LABEL($order_shopping_dtls);
					
					while($get_shoppingorder_dtls = sqlFETCHARRAY_LABEL($order_shopping_dtls )) {
						$shoppingqty_ordid = $get_shoppingorder_dtls['od_id'];
						
						//geting previous quantity
						$getold_quantity = sqlQUERY_LABEL("select * from js_shop_order_item where od_session = '$ord_session' and od_id = '$shoppingqty_ordid' and deleted='0' and status = '1'")
						 or die(sqlERROR_LABEL());
							while($getavailable_qty_rate = sqlFETCHARRAY_LABEL($getold_quantity)) {
								$product_id = $getavailable_qty_rate['pd_id'];
								$product_qty = $getavailable_qty_rate['od_qty'];
								$product_price = $getavailable_qty_rate['od_price'];
								
								$total_orderprice_qty += ($product_qty*$product_price);
								
							}
						$toupdate_check_total_order=number_format($total_orderprice_qty, 2, '.', '');
					
					//update order price
					$update_orderitems=sqlQUERY_LABEL("update js_shop_order set od_total='$toupdate_check_total_order' where od_sesid='".$ord_session."' and od_id='".$updateqty_ordid."'") or die(sqlERROR_LABEL());
					}

					if($update_orderitems) {
						$product_qty_update = true;
					}
					
				}
				
			}
		} else {
			$outof_stock_detail = true;
		}
		
		$query= "SELECT SUM(od_qty) AS totalsum FROM `js_shop_order_item` where od_session = '$ord_session' and deleted='0'";
		// echo $query;
		$result = sqlQUERY_LABEL($query);
		while($row = sqlFETCHARRAY_LABEL($result))
		{
			echo  $row['totalsum'];
		}				
	
	}

	
	
?>