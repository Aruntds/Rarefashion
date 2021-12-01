<?php 

extract($_REQUEST);

include '../head/jackus.php';

	if($selected_PRDTID !='' && $selected_CARTID !=''){
		$check_selecteditem = sqlQUERY_LABEL("select `offer_id`, `offer_type`, `item_tax`, `item_tax_type`,  `pd_id`, `variant_id`, `od_colorid`, `od_size_id`, `od_qty`, `od_price`, `item_tax1`, `item_tax2` from js_shop_order_item where user_id = '$logged_user_id' and pd_id = '$selected_PRDTID' and cart_id = '$selected_CARTID'") or die(sqlERROR_LABEL());

		while($collect_selecteditem = sqlFETCHARRAY_LABEL($check_selecteditem)) {

			$quantity = $collect_selecteditem['od_qty'];
			$cart_offer_id = $collect_selecteditem['offer_id'];
			$cart_offer_type = $collect_selecteditem['offer_type'];
			$variant_id = $collect_selecteditem['variant_id'];
			$total_price = $collect_selecteditem['od_price'];
			$item_tax1 = $collect_selecteditem['item_tax1'];
			$item_tax2 = $collect_selecteditem['item_tax2'];
			$item_tax = $collect_selecteditem['item_tax'];
			$item_tax_type = $collect_selecteditem['item_tax_type'];
			if($quantity > 1){
			$old_total_price = (($item_tax1 + $item_tax2 + $total_price)/$quantity);
			} else {
			$old_total_price = $item_tax1 + $item_tax2 + $total_price;
			}
			$newtotal_price = $old_total_price * $selected_PRDTQTY;
			
			$PRDT_CODE = getPRDT_CODE($selected_PRDTID, $variant_id, 'get_prdt_code');
			
			$list_producttype_data = sqlQUERY_LABEL("select `productopeningstock`,`productavailablestock` from js_product where productsku = '$PRDT_CODE'");
			$count_producttype_list = sqlNUMOFROW_LABEL($list_producttype_data);
				if($count_producttype_list > 0){
					while($get_product_data = sqlFETCHARRAY_LABEL($list_producttype_data)) {
						$prdt_opening_qty = $get_product_data['productopeningstock'];
						$prdt_available_qty = $get_product_data['productavailablestock'];
					}
				} else {
					
					$list_producttype_data_variant = sqlQUERY_LABEL("select `variant_available_stock`,`variant_opening_stock` from js_productvariants where variant_code = '$PRDT_CODE' and deleted='0'");
					//$count_producttype_list = sqlNUMOFROW_LABEL($list_producttype_data_variant);
					while($get_product_data_variant = sqlFETCHARRAY_LABEL($list_producttype_data_variant)) {
						$prdt_opening_qty = $get_product_data_variant['variant_available_stock'];
						$prdt_available_qty = $get_product_data_variant['variant_opening_stock'];
					}
				}
				if($item_tax_type == 'Y') {
					$taxsplit_price = ($newtotal_price * ($item_tax/100))/2;
					$newtotal_price = ($newtotal_price - ($taxsplit_price * 2));
				} else {
					$taxsplit_price = (($newtotal_price * ($item_tax/100))/2);
					$newtotal_price = $newtotal_price;
				}
		}
		
		if($selected_PRDTQTY <= $prdt_available_qty){
			$check_product_offer_eligibility_count = commonNOOFROWS_COUNT('js_offer_eligibility',"`prdt_id`='$selected_PRDTID' and `cart_id`='$selected_CARTID' and `status` = '1' and `deleted` = '0'");
			if($selected_PRDTQTY > 1 && $check_product_offer_eligibility_count == 0){
				$get_auto_eligible_offer_ID = get_OFFER_ELIGIBILITY_ID($selected_PRDTQTY, $selected_PRDTID, 'get_auto_assign_offer_id_based_on_bulk_qty');
				$get_auto_eligible_offer_TYPE = get_OFFER_ELIGIBILITY_ID($selected_PRDTQTY, $selected_PRDTID, 'get_auto_assign_offer_type_based_on_bulk_qty');
				$get_eligible_OFFERT_QTY = get_OFFER_ELIGIBILITY_ID($get_auto_eligible_offer_ID, $selected_PRDTID, 'get_offer_qty');

				$newtotal_price = $old_total_price * $get_eligible_OFFERT_QTY;
				if($item_tax_type == 'Y') {
					$taxsplit_price = ($newtotal_price * ($item_tax/100))/2;
					$newtotal_price = ($newtotal_price - ($taxsplit_price * 2));
				} else {
					$taxsplit_price = (($newtotal_price * ($item_tax/100))/2);
					$newtotal_price = $newtotal_price;
				}

				//$remove_exisiting_added_offer_QTY = sqlQUERY_LABEL("DELETE FROM `js_shop_order_item` WHERE `pd_id` = '$selected_PRDTID'") or die(sqlERROR_LABEL());

				$insert_offer_products = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`, `offer_id`, `offer_type`) VALUES ('$logged_user_id','$selected_PRDTID', '$variant_id', '$logged_user_id', '$current_SESSION_ID', '$get_eligible_OFFERT_QTY', '0', '0', '0', '0', '0','1', '$get_auto_eligible_offer_ID', '$get_auto_eligible_offer_TYPE')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());

				$insert_without_offer_products = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`, `pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$selected_PRDTID', '$variant_id', '$logged_user_id', '$current_SESSION_ID', '$get_eligible_OFFERT_QTY', '$newtotal_price', '$item_tax_type', '$item_tax', '$taxsplit_price', '$taxsplit_price','1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
				$message = "Cart added...!!!";

			} else if($check_product_offer_eligibility_count == 0) {
				sqlQUERY_LABEL("UPDATE `js_shop_order_item` SET `od_price` = '$newtotal_price', `od_qty`='$selected_PRDTQTY', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_user_id' and user_id = '$logged_user_id' and pd_id = '$selected_PRDTID' and cart_id = '$selected_CARTID'") or die(sqlERROR_LABEL());
				$message = "Cart updated...!!!";
				$data = array('status' => 'Success', 'msg' => 'INSERT');
			} else if($check_product_offer_eligibility_count > 0) {
				$get_selected_product_offers = sqlQUERY_LABEL("select `offer_eligible_ID`, `offer_id`, `offer_type` FROM `js_offer_eligibility` where `prdt_id`='$selected_PRDTID' and cart_id = '$selected_CARTID' and `status` = '1' and `deleted` = '0'") or die(sqlERROR_LABEL());
					while($fetch_product_offer_id = sqlFETCHARRAY_LABEL($get_selected_product_offers)) {
						$offer_eligible_ID = $fetch_product_offer_id['offer_eligible_ID'];
						$offer_ID = $fetch_product_offer_id['offer_id'];
						$offer_TYPE = $fetch_product_offer_id['offer_type'];
					}
			if($offer_TYPE == '1'){
				//echo "A5wewwww";
				//exit();
				//BOGO OFFER - STARTED
				$get_eligible_OFFERT_QTY = get_OFFER_ELIGIBILITY_ID($offer_ID, $selected_PRDTID, 'get_offer_qty');

				$get_offer_added_item_OFFER_ID = $cart_offer_id;
				
				$remove_exisiting_added_offer_QTY = sqlQUERY_LABEL("DELETE FROM `js_shop_order_item` WHERE `offer_id` = '$get_offer_added_item_OFFER_ID' and `pd_id` = '$selected_PRDTID' and `offer_id` != '0'") or die(sqlERROR_LABEL());

				$insert_offer_products = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`, `offer_id`, `offer_type`) VALUES ('$logged_user_id','$selected_PRDTID', '$variant_id', '$logged_user_id', '$current_SESSION_ID', '$get_eligible_OFFERT_QTY', '0', '0', '0', '0', '0','1', '$offer_ID', '$offer_TYPE')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
				$current_date_time = date('Y-m-d H:i:s');

				$update_the_applied_offer_id_deleted_sttaus = sqlQUERY_LABEL("UPDATE `js_offer_eligibility` SET `deleted` = '1' WHERE `offer_eligible_ID` = '$offer_eligible_ID'") or die(sqlERROR_LABEL());

			} else if($offer_TYPE == '2'){
				//echo "A5www";
				//exit();
				//Flat Discount
				$get_eligible_FLAT_OFFER_PRICE = get_OFFER_ELIGIBILITY_ID($offer_ID, $selected_PRDTID, 'get_offer_qty');

				$get_offer_added_item_OFFER_ID = $cart_offer_id;
				echo $product_qty;
				exit();
				$remove_exisiting_added_offer_QTY = sqlQUERY_LABEL("DELETE FROM `js_shop_order_item` WHERE `offer_id` = '$get_offer_added_item_OFFER_ID' and `pd_id` = '$selected_PRDTID' and `offer_id` != '0'") or die(sqlERROR_LABEL());

				if($item_tax_type == 'Y') {
					$taxsplit_price = ($get_eligible_FLAT_OFFER_PRICE * ($item_tax/100))/2;
					$total_price = ($get_eligible_FLAT_OFFER_PRICE - ($taxsplit_price * 2));
				} else {
					$taxsplit_price = (($get_eligible_FLAT_OFFER_PRICE * ($item_tax/100))/2);
					$total_price = $get_eligible_FLAT_OFFER_PRICE;
				}

				$update_FLAT_OFFER_ITEM = sqlQUERY_LABEL("UPDATE `js_shop_order_item` SET `offer_id` = '$offer_ID', `offer_type` = '$offer_TYPE', `od_price` = '$total_price', `od_qty`='$quantity', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_customer_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_customer_id' and pd_id = '$selected_PRDTID' and `offer_id` = '0' and `offer_type` = '0'") or die(sqlERROR_LABEL());
				$message = "Cart updated...!!!";

				$update_the_applied_offer_id_deleted_sttaus = sqlQUERY_LABEL("UPDATE `js_offer_eligibility` SET `deleted` = '1' WHERE `offer_eligible_ID` = '$offer_eligible_ID'") or die(sqlERROR_LABEL());

			} else if($offer_TYPE == '3'){
				//echo "Awqw6";
				//exit();
				//Percenatge
				$get_eligible_FLAT_OFFER_PERCENTAGE = get_OFFER_ELIGIBILITY_ID($offer_ID, $selected_PRDTID, 'get_offer_qty');

				$get_offer_added_item_OFFER_ID = $cart_offer_id;

				$remove_exisiting_added_offer_QTY = sqlQUERY_LABEL("DELETE FROM `js_shop_order_item` WHERE `offer_id` = '$get_offer_added_item_OFFER_ID' and `pd_id` = '$selected_PRDTID' and `offer_id` != '0'") or die(sqlERROR_LABEL());
				$newtotal_price = $old_total_price * $selected_PRDTQTY;
				$TOTAL_DISCOUNT_VALUE = (($newtotal_price * $get_eligible_FLAT_OFFER_PERCENTAGE)/100);
				if($item_tax_type == 'Y') {
					$taxsplit_price = ($newtotal_price * ($item_tax/100))/2;
					$total_price = ($newtotal_price - ($taxsplit_price * 2));
				} else {
					$taxsplit_price = (($newtotal_price * ($item_tax/100))/2);
					$total_price = $newtotal_price;
				}
				// echo "UPDATE `js_shop_order_item` SET `offer_id` = '$offer_ID', `offer_type` = '$offer_TYPE', `od_item_discount` = '$TOTAL_DISCOUNT_VALUE', `od_price` = '$total_price', `od_qty`='$quantity', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_customer_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_customer_id' and pd_id = '$PRDT_ID' and `offer_id` = '0' and `offer_type` = '0'";
				// exit();
				$update_FLAT_OFFER_ITEM = sqlQUERY_LABEL("UPDATE `js_shop_order_item` SET `offer_id` = '$offer_ID', `offer_type` = '$offer_TYPE', `od_item_discount` = '$TOTAL_DISCOUNT_VALUE', `od_price` = '$total_price', `od_qty`='$quantity', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_customer_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_customer_id' and pd_id = '$PRDT_ID' and `offer_id` = '0' and `offer_type` = '0'") or die(sqlERROR_LABEL());
				$message = "Cart updated...!!!";

				$update_the_applied_offer_id_deleted_sttaus = sqlQUERY_LABEL("UPDATE `js_offer_eligibility` SET `deleted` = '1' WHERE `offer_eligible_ID` = '$offer_eligible_ID'") or die(sqlERROR_LABEL());

			}
			} else {
				if($variant_id !='0'){
					$get_variant_name = ' ('.getVARIANT_CODE($variant_id,'variant_name_from_variant_ID').')';
				} else {
					$get_variant_name = '';
				}
				$get_prdt_name = getPRDT_CODE($selected_PRDTID,'','get_prdt_name');
				$err .= "Stock not availabe for ".$get_prdt_name.$get_variant_name.'<br />';
				$data = array('status' => 'Error_Stock', 'msg' => 'NoStock');
			}
		} else {
			$data = array('status' => 'Error', 'msg' => 'Updated');
		}
	}
header('Content-Type: application/json');
echo json_encode($data);
?>