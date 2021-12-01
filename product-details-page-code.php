<?php 
extract($_REQUEST);
include 'head/jackus.php'; 
include 'shopfunction.php'; 
include '___class__home.inc'; 
//echo $sid;
$product_token = strbefore($token, '-');

 $getIPaddress = getUserIpAddr();
//echo "INSERT into `js_total_product_vistors_list` (`userID`, `prdtID`, `IPaddress`,  `createdon`,`status`) VALUES ('$logged_customer_id', '$product_token', '$getIPaddress', '".date('Y-m-d H:i:s')."','1')";exit();
 sqlQUERY_LABEL("INSERT into `js_total_product_vistors_list` (`userID`, `prdtID`, `IPaddress`,  `createdon`,`status`) VALUES ('$logged_customer_id', '$product_token', '$getIPaddress', '".date('Y-m-d H:i:s')."','1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());

 
$list_product_datas = sqlQUERY_LABEL("SELECT * FROM `js_product` where productID = '$product_token' and deleted = '0' and status = '1'") or die("#1-Unable to get records:".sqlERROR_LABEL());

$count_product_list = sqlNUMOFROW_LABEL($list_product_datas);

if($count_product_list > 0) {
	 $list_product_datas_viewed = sqlQUERY_LABEL("SELECT COUNT(`prdtID`) AS COUNT_Prodt, `prdtID` FROM `js_total_product_vistors_list` WHERE prdtID = '$product_token' and deleted = '0' and status = '1' GROUP BY `prdtID`") or die("#1-Unable to get records:".sqlERROR_LABEL());

	$count_product_list_viewed = sqlNUMOFROW_LABEL($list_product_datas_viewed);
	if($count_product_list_viewed > 0) {
		while($row = sqlFETCHARRAY_LABEL($list_product_datas_viewed)){
			$COUNT_Prodt = $row["COUNT_Prodt"];
		}
		$arrFields=array('`productviewed`');

		$arrValues=array("$COUNT_Prodt");

		$sqlWhere= "productID=$product_token";

		if(sqlACTIONS("UPDATE","js_product",$arrFields,$arrValues, $sqlWhere)) {
		}
	}
	while($row = sqlFETCHARRAY_LABEL($list_product_datas)){
		$productID = $row["productID"];
		$productsku = $row["productsku"];
		$productcategory = $row["productcategory"];
		$producttitle = html_entity_decode($row["producttitle"], ENT_QUOTES, "UTF-8");
		$producttitle = str_replace("\'","'",$producttitle); //$row["producttitle"];
		$productdescrption = html_entity_decode($row["productdescrption"], ENT_QUOTES, "UTF-8");
		$productdescrption = str_replace("\'","'",$productdescrption); //$row["producttitle"];
		$productpropertydescrption = html_entity_decode($row["productpropertydescrption"], ENT_QUOTES, "UTF-8");
		$productpropertydescrption = str_replace("\'","'",$productpropertydescrption); //$row["producttitle"];
		$productspecialnotes = html_entity_decode($row["productspecialnotes"], ENT_QUOTES, "UTF-8");
		$productspecialnotes = str_replace("\'","'",$productspecialnotes); //$row["producttitle"];
		$sellingprice_unformatted = $row["productsellingprice"];
		$productsellingprice = formatCASH($row["productsellingprice"]);
		$productMRPprice = formatCASH($row["productMRPprice"]);
		$productyousaveprice = formatCASH($row["productyousaveprice"]);
		$productavailablestock = $row["productavailablestock"];
		$productstockstatus = $row["productstockstatus"];  //stock status
		$productseourl = $row['productseourl'];
		$productmetatitle = htmlentities($row['productmetatitle'], ENT_QUOTES);
		trim ($productmetatitle);
		$productmetakeywords = $row['productmetakeywords'];
		$productmetadescrption = $row['productmetadescrption'];
		$createdon = strtotime($row["createdon"]);
		$updatedon = strtotime($row["updatedon"]);

			$featured_product_image = sqlQUERY_LABEL("SELECT `productmediagallerytitle`, `productmediagalleryurl` FROM `js_productmediagallery` where productID='$productID' and productmediagalleryfeatured='1' and productmediagallerytype='1' and deleted = '0' and status = '1'") or die("#1-Unable to get records:".sqlERROR_LABEL());
			  while($featured_image = sqlFETCHARRAY_LABEL($featured_product_image)){
				  $productmediagallerytitle = $featured_image["productmediagallerytitle"];
				  $productmediagalleryurl = $featured_image["productmediagalleryurl"];
			  }
		
		if($productstockstatus == '0') {
			$stock_label = '<span class="text-danger">Out of Stock</span>';
		} else {
			$stock_label = '<span class="text-success">In Stock</span>';	
		}
	}
	//page title
	if($productmetatitle != ''){
		$commontitle = $productmetatitle.' ( '.$productsku.' )';
	} else {
		$commontitle = $producttitle.' ( '.$productsku.' )';
	}
	// echo $commontitle; exit();
} else {
	$producthero_text = "Something's not right!";	
	$productdescription = "We're sorry. The Web address you entered is not a functioning page on our site. ";
}



function explodeproductCATEGORY($categoryID) {

	$categorySPLIT = explode(",", $categoryID);
	////PREPARING OUTPUT
	for ($i = 0; $i <= count($categorySPLIT); $i++) {
		
		//getting product info of the cart item.
		if(!empty($categorySPLIT[$i])) {
			$_categoryHREF .= '<a href="shop.php?categoryID='.$categorySPLIT[$i].'" rel="tag">'.getPRODUCTCATEGORY($categorySPLIT[$i], '', 'label').'</a>, ';
		}
		
	}
	$categoryINFO = substr($_categoryHREF, 0, -2);
	return $categoryINFO;
	
}

if($add_to_cart_in_details == 'add_to_cart_in_details'){
	$PRDT_ID = $productID; 
	$VARIANT_ID = $product_size;
	$sku_CODE = getPRDT_CODE($PRDT_ID,'','get_prdt_code');
	$PRDT_QTY = $qty; 
	$current_SESSION_ID = $sid;  // VALUES RECEIVE FROM CONFIG.PHP
	$check_product_variants = commonNOOFROWS_COUNT('js_productvariants',"parentproduct = '$PRDT_ID'");

	if($check_product_variants == 0 && $VARIANT_ID == '' && $PRDT_ID !=''){

		$featured_product_data = sqlQUERY_LABEL("SELECT `productID`, `productsellingprice`, `producttax`, `producttaxtype`  FROM `js_product` where productID='$PRDT_ID' and deleted = '0' and status = '1'") or die("#1-Unable to get records:".sqlERROR_LABEL());
	  while($featured_data = sqlFETCHARRAY_LABEL($featured_product_data)){
		  $productID = $featured_data["productID"];
		  $productsellingprice = $featured_data["productsellingprice"];
		  $producttax = $featured_data["producttax"];
		  $producttaxtype = $featured_data["producttaxtype"];
	  }											

	if($PRDT_ID !='' && $current_SESSION_ID !=''){

		$check_selecteditem = sqlQUERY_LABEL("select `pd_id`, `od_colorid`, `od_size_id`, `od_qty`, `od_price`, `item_tax1`, `item_tax2` from js_shop_order_item where user_id = '$logged_user_id' and od_session = '$current_SESSION_ID' and pd_id = '$PRDT_ID' and `offer_id` = '0' and `offer_type` = '0'") or die(sqlERROR_LABEL());
		echo "2A";
		exit();
		if(sqlNUMOFROW_LABEL($check_selecteditem) == 0) {
			echo "34aa";
			exit();
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

			if($product_qty <= $prdt_available_qty){
				echo "3667aa";
				exit();
				$check_product_offer_eligibility_count = commonNOOFROWS_COUNT('js_offer_eligibility',"`prdt_id`='$PRDT_ID' and `od_session_id`='$current_SESSION_ID' and `status` = '1' and `deleted` = '0'");
				if($check_product_offer_eligibility_count == 0){
					sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$logged_user_id', '$current_SESSION_ID', '$product_qty', '$total_price', '$producttaxtype', '$producttax', '$taxsplit_price', '$taxsplit_price','1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
					$message = "Cart added...!!!";
					$redeem_offer_cart_id = sqlINSERTID_LABEL();
					$current_date_time = date('Y-m-d H:i:s');

					$get_total_added_cart_QTY = get_OD_QTY_FROM_SESSION($PRDT_ID, $current_SESSION_ID, 'get_total_cart_od_qty_without_offer_qty');
					$get_eligible_offer_ID = get_OFFER_ELIGIBILITY_ID($get_total_added_cart_QTY, $PRDT_ID, 'get_offer_id');
					$get_eligible_offer_TYPE = get_OFFER_ELIGIBILITY_ID($get_total_added_cart_QTY, $PRDT_ID, 'get_offer_type');

					$insert_offer_eligibility = sqlQUERY_LABEL("INSERT into `js_offer_eligibility` (`prdt_id`,`offer_id`, `offer_type`, `od_session_id`, `createdby`, `createdon`, `status`) VALUES ('$PRDT_ID','$get_eligible_offer_ID', '$get_eligible_offer_TYPE', '$current_SESSION_ID', '$logged_user_id', '$current_date_time','1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
				} else {
					echo "3867aa";
					exit();
					$get_selected_product_offers = sqlQUERY_LABEL("select `offer_eligible_ID`, `offer_id`, `offer_type` FROM `js_offer_eligibility` where `prdt_id`='$PRDT_ID' and `od_session_id`='$current_SESSION_ID' and `status` = '1' and `deleted` = '0'") or die(sqlERROR_LABEL());
						while($fetch_product_offer_id = sqlFETCHARRAY_LABEL($get_selected_product_offers)) {
							$offer_eligible_ID = $fetch_product_offer_id['offer_eligible_ID'];
							$offer_ID = $fetch_product_offer_id['offer_id'];
							$offer_TYPE = $fetch_product_offer_id['offer_type'];
						}
					
					if($offer_TYPE == '1'){
						echo "h98f";
						exit();
						//BOGO OFFERS - START
						$get_eligible_OFFERT_QTY = get_OFFER_ELIGIBILITY_ID($offer_ID, $PRDT_ID, 'get_offer_qty');

						$get_offer_added_item_OFFER_ID = get_OD_QTY_FROM_SESSION($PRDT_ID, $current_SESSION_ID, 'get_added_offer_product_offer_id');
						
						$remove_exisiting_added_offer_QTY = sqlQUERY_LABEL("DELETE FROM `js_shop_order_item` WHERE `offer_id` = '$get_offer_added_item_OFFER_ID' and `od_session` = '$current_SESSION_ID' and `pd_id` = '$PRDT_ID' and `offer_id` != '0'") or die(sqlERROR_LABEL());
						
						$insert_offer_products = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`, `offer_id`, `offer_type`) VALUES ('$logged_user_id','$PRDT_ID', '$logged_user_id', '$current_SESSION_ID', '$get_eligible_OFFERT_QTY', '0', '0', '0', '0', '0','1', '$offer_ID', '$offer_TYPE')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
						$current_date_time = date('Y-m-d H:i:s');

						$update_the_applied_offer_id_deleted_sttaus = sqlQUERY_LABEL("UPDATE `js_offer_eligibility` SET `deleted` = '1' WHERE `offer_eligible_ID` = '$offer_eligible_ID'") or die(sqlERROR_LABEL());
						//BOGO OFFERS - END
					}
				}
			} else {
				?>
				<script type="text/javascript">window.location = 'product.php?token=<?php echo $token; ?>&prdt_error=outofstock1' </script>
				<?php
			}
		} else {
			echo "aa";
			exit();
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

			if($quantity <= $prdt_available_qty){
			$check_product_offer_eligibility_count = commonNOOFROWS_COUNT('js_offer_eligibility',"`prdt_id`='$PRDT_ID' and `od_session_id`='$current_SESSION_ID' and `status` = '1' and `deleted` = '0'");
			if($check_product_offer_eligibility_count == 0){
				echo "A8";
				exit();
				$update_cart_item_QTY = sqlQUERY_LABEL("UPDATE `js_shop_order_item` SET `od_price` = '$newtotal_price', `od_qty`='$quantity', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_customer_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_customer_id' and pd_id = '$PRDT_ID' and `offer_id` = '0' and `offer_type` = '0'") or die(sqlERROR_LABEL());
				$message = "Cart updated...!!!";
				$current_date_time = date('Y-m-d H:i:s');

				$get_total_added_cart_QTY = get_OD_QTY_FROM_SESSION($PRDT_ID, $current_SESSION_ID, 'get_total_cart_od_qty_without_offer_qty');
				$get_eligible_offer_ID = get_OFFER_ELIGIBILITY_ID($get_total_added_cart_QTY, $PRDT_ID, 'get_offer_id');
				$get_eligible_offer_TYPE = get_OFFER_ELIGIBILITY_ID($get_total_added_cart_QTY, $PRDT_ID, 'get_offer_type');

				$insert_offer_eligibility = sqlQUERY_LABEL("INSERT into `js_offer_eligibility` (`prdt_id`,`offer_id`, `offer_type`, `od_session_id`, `createdby`, `createdon`, `status`) VALUES ('$PRDT_ID','$get_eligible_offer_ID', '$get_eligible_offer_TYPE', '$current_SESSION_ID', '$logged_user_id', '$current_date_time','1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());

			} else {
				echo "A9";
				exit();
				$get_selected_product_offers = sqlQUERY_LABEL("select `offer_eligible_ID`, `offer_id`, `offer_type` FROM `js_offer_eligibility` where `prdt_id`='$PRDT_ID' and `od_session_id`='$current_SESSION_ID' and `status` = '1' and `deleted` = '0'") or die(sqlERROR_LABEL());
					while($fetch_product_offer_id = sqlFETCHARRAY_LABEL($get_selected_product_offers)) {
						$offer_eligible_ID = $fetch_product_offer_id['offer_eligible_ID'];
						$offer_ID = $fetch_product_offer_id['offer_id'];
						$offer_TYPE = $fetch_product_offer_id['offer_type'];
					}

				if($offer_TYPE == '1'){
					//BOGO OFFER - STARTS
					echo "A71";
					echo $product_qty;
					exit();
					$get_eligible_OFFERT_QTY = get_OFFER_ELIGIBILITY_ID($offer_ID, $PRDT_ID, 'get_offer_qty');

					$get_offer_added_item_OFFER_ID = get_OD_QTY_FROM_SESSION($PRDT_ID, $current_SESSION_ID, 'get_added_offer_product_offer_id');
					
					$remove_exisiting_added_offer_QTY = sqlQUERY_LABEL("DELETE FROM `js_shop_order_item` WHERE `offer_id` = '$get_offer_added_item_OFFER_ID' and `od_session` = '$current_SESSION_ID' and `pd_id` = '$PRDT_ID' and `offer_id` != '0'") or die(sqlERROR_LABEL());
					
					$insert_offer_products = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`, `offer_id`, `offer_type`) VALUES ('$logged_user_id','$PRDT_ID', '$logged_user_id', '$current_SESSION_ID', '$get_eligible_OFFERT_QTY', '0', '0', '0', '0', '0','1', '$offer_ID', '$offer_TYPE')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
					$current_date_time = date('Y-m-d H:i:s');

					$update_the_applied_offer_id_deleted_sttaus = sqlQUERY_LABEL("UPDATE `js_offer_eligibility` SET `deleted` = '1' WHERE `offer_eligible_ID` = '$offer_eligible_ID'") or die(sqlERROR_LABEL());

				} else if($offer_TYPE == '2'){
					//Flat Discount
					echo "A00";
					exit();
					$get_eligible_FLAT_OFFER_PRICE = get_OFFER_ELIGIBILITY_ID($offer_ID, $PRDT_ID, 'get_offer_qty');

					$get_offer_added_item_OFFER_ID = get_OD_QTY_FROM_SESSION($PRDT_ID, $current_SESSION_ID, 'get_added_offer_product_offer_id');
					echo $product_qty;
					exit();
					$remove_exisiting_added_offer_QTY = sqlQUERY_LABEL("DELETE FROM `js_shop_order_item` WHERE `offer_id` = '$get_offer_added_item_OFFER_ID' and `od_session` = '$current_SESSION_ID' and `pd_id` = '$PRDT_ID' and `offer_id` != '0'") or die(sqlERROR_LABEL());

					if($producttaxtype == 'Y') {
						$taxsplit_price = ($get_eligible_FLAT_OFFER_PRICE * ($producttax/100))/2;
						$total_price = ($get_eligible_FLAT_OFFER_PRICE - ($taxsplit_price * 2));
					} else {
						$taxsplit_price = (($get_eligible_FLAT_OFFER_PRICE * ($producttax/100))/2);
						$total_price = $get_eligible_FLAT_OFFER_PRICE;
					}

					$update_FLAT_OFFER_ITEM = sqlQUERY_LABEL("UPDATE `js_shop_order_item` SET `offer_id` = '$offer_ID', `offer_type` = '$offer_TYPE', `od_price` = '$total_price', `od_qty`='$quantity', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_customer_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_customer_id' and pd_id = '$PRDT_ID' and `offer_id` = '0' and `offer_type` = '0'") or die(sqlERROR_LABEL());
					$message = "Cart updated...!!!";

					$update_the_applied_offer_id_deleted_sttaus = sqlQUERY_LABEL("UPDATE `js_offer_eligibility` SET `deleted` = '1' WHERE `offer_eligible_ID` = '$offer_eligible_ID'") or die(sqlERROR_LABEL());

				} else if($offer_TYPE == '3'){
					//Percenatge
					echo $product_qty;
					echo "A012";
					$get_eligible_FLAT_OFFER_PERCENTAGE = get_OFFER_ELIGIBILITY_ID($offer_ID, $PRDT_ID, 'get_offer_qty');

					$get_offer_added_item_OFFER_ID = get_OD_QTY_FROM_SESSION($PRDT_ID, $current_SESSION_ID, 'get_added_offer_product_offer_id');

					$remove_exisiting_added_offer_QTY = sqlQUERY_LABEL("DELETE FROM `js_shop_order_item` WHERE `offer_id` = '$get_offer_added_item_OFFER_ID' and `od_session` = '$current_SESSION_ID' and `pd_id` = '$PRDT_ID' and `offer_id` != '0'") or die(sqlERROR_LABEL());
					$newtotal_price = $old_total_price * $quantity;
					$TOTAL_DISCOUNT_VALUE = (($newtotal_price * $get_eligible_FLAT_OFFER_PERCENTAGE)/100);
					if($producttaxtype == 'Y') {
						$taxsplit_price = ($newtotal_price * ($producttax/100))/2;
						$total_price = ($newtotal_price - ($taxsplit_price * 2));
					} else {
						$taxsplit_price = (($newtotal_price * ($producttax/100))/2);
						$total_price = $newtotal_price;
					}
					// echo "UPDATE `js_shop_order_item` SET `offer_id` = '$offer_ID', `offer_type` = '$offer_TYPE', `od_item_discount` = '$TOTAL_DISCOUNT_VALUE', `od_price` = '$total_price', `od_qty`='$quantity', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_customer_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_customer_id' and pd_id = '$PRDT_ID' and `offer_id` = '0' and `offer_type` = '0'";
					// exit();
					$update_FLAT_OFFER_ITEM = sqlQUERY_LABEL("UPDATE `js_shop_order_item` SET `offer_id` = '$offer_ID', `offer_type` = '$offer_TYPE', `od_item_discount` = '$TOTAL_DISCOUNT_VALUE', `od_price` = '$total_price', `od_qty`='$quantity', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_customer_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_customer_id' and pd_id = '$PRDT_ID' and `offer_id` = '0' and `offer_type` = '0'") or die(sqlERROR_LABEL());
					$message = "Cart updated...!!!";

					$update_the_applied_offer_id_deleted_sttaus = sqlQUERY_LABEL("UPDATE `js_offer_eligibility` SET `deleted` = '1' WHERE `offer_eligible_ID` = '$offer_eligible_ID'") or die(sqlERROR_LABEL());

				}
			}
			} else {
				?>
				<script type="text/javascript">window.location = 'product.php?token=<?php echo $token; ?>&prdt_error=outofstock4' </script>
				<?php
			}
		}
		?>
		<script type="text/javascript">window.location = 'product.php?token=<?php echo $token; ?>&prdt_details=cart_added1' </script>
		<?php
	}			
	} else {
	
	$featured_product_data = sqlQUERY_LABEL("SELECT `variant_ID`, `parentproduct`, `variant_code`, `variant_msp_price`, `variant_taxtype`, `variant_tax_value`, `variant_taxsplit1`, `variant_taxsplit2`  FROM `js_productvariants` where parentproduct='$PRDT_ID' and variant_ID = '$VARIANT_ID' and deleted = '0' and status = '1'") or die("#1-Unable to get records:".sqlERROR_LABEL());
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
	  
		if($PRDT_ID !='' && $current_SESSION_ID !='' && $variant_ID !=''){

			$check_selecteditem1 = sqlQUERY_LABEL("select `pd_id`, `variant_id`, `od_colorid`, `od_size_id`, `od_qty`, `od_price`, `item_tax1`, `item_tax2` from js_shop_order_item where user_id = '$logged_user_id' and od_session = '$current_SESSION_ID' and pd_id = '$PRDT_ID' and variant_id='$variant_ID' and `offer_id` = '0' and `offer_type` = '0'") or die(sqlERROR_LABEL());
			
			if(sqlNUMOFROW_LABEL($check_selecteditem1) == 0) {

					$product_qty = $PRDT_QTY;

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

				/////////////////////// ADD BILL-ITEM

				if($product_qty <= $variant_prdt_available_qty){

					$check_product_offer_eligibility_count = commonNOOFROWS_COUNT('js_offer_eligibility',"`prdt_id`='$PRDT_ID' and `od_session_id`='$current_SESSION_ID' and `status` = '1' and `deleted` = '0'");
					if($product_qty > 1 && $check_product_offer_eligibility_count == 0){
						echo "A1";
						$get_auto_eligible_offer_ID = get_OFFER_ELIGIBILITY_ID($product_qty, $PRDT_ID, 'get_auto_assign_offer_id_based_on_bulk_qty');
						$get_auto_eligible_offer_TYPE = get_OFFER_ELIGIBILITY_ID($product_qty,$PRDT_ID, 'get_auto_assign_offer_type_based_on_bulk_qty');
						
						$remove_exisiting_added_offer_QTY = sqlQUERY_LABEL("DELETE FROM `js_shop_order_item` WHERE `od_session` = '$current_SESSION_ID' and `pd_id` = '$PRDT_ID'") or die(sqlERROR_LABEL());
						
						if($get_auto_eligible_offer_TYPE == 1){
							
							$get_eligible_OFFERT_QTY = get_OFFER_ELIGIBILITY_ID($get_auto_eligible_offer_ID, $PRDT_ID, 'get_offer_qty');
							$remaining_without_OFFER_ELIGIBLE_QTY = ($product_qty - $get_eligible_OFFERT_QTY);
							$productsellingprice = ($get_eligible_OFFERT_QTY * $variant_prdt_final_price);
							if($variant_taxtype == 'Y') {
								$taxsplit_price = ($productsellingprice * ($variant_tax_value/100))/2;
								$total_price = ($productsellingprice - ($taxsplit_price* 2));
							} else {
								$taxsplit_price = (($productsellingprice * ($variant_tax_value/100))/2);
								$total_price = $productsellingprice;
							}
							$insert_offer_products = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`, `offer_id`, `offer_type`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$get_eligible_OFFERT_QTY', '0', '0', '0', '0', '0','1', '$get_auto_eligible_offer_ID', '$get_auto_eligible_offer_TYPE')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
							$productsellingprice = ($remaining_without_OFFER_ELIGIBLE_QTY * $variant_prdt_final_price);
							if($variant_taxtype == 'Y') {
								$taxsplit_price = ($productsellingprice * ($variant_tax_value/100))/2;
								$total_price = ($productsellingprice - ($taxsplit_price* 2));
							} else {
								$taxsplit_price = (($productsellingprice * ($variant_tax_value/100))/2);
								$total_price = $productsellingprice;
							}
							$insert_without_offer_products = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`, `pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$remaining_without_OFFER_ELIGIBLE_QTY', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price','1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
							$message = "Cart added...!!!";
						} else if($get_auto_eligible_offer_TYPE == 2){
							echo "Adfs";
							//exit();
							$get_eligible_FLAT_OFFER_PRICE = get_OFFER_ELIGIBILITY_ID($get_auto_eligible_offer_ID, $PRDT_ID, 'get_offer_qty');
							$get_offer_added_item_OFFER_ID = get_OD_QTY_FROM_SESSION($PRDT_ID, $current_SESSION_ID, 'get_added_offer_product_offer_id');

							$remove_exisiting_added_offer_QTY = sqlQUERY_LABEL("DELETE FROM `js_shop_order_item` WHERE `offer_id` = '$get_offer_added_item_OFFER_ID' and `od_session` = '$current_SESSION_ID' and `pd_id` = '$PRDT_ID' and `offer_id` != '0'") or die(sqlERROR_LABEL());
							// echo $udated_cart_QTY;
							// exit();
							// echo "UPDATE `js_shop_order_item` SET `offer_id` = '$offer_ID', `offer_type` = '$offer_TYPE', `od_price` = '$total_price', `od_qty`='$udated_cart_QTY', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_customer_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_customer_id' and pd_id = '$PRDT_ID' and `offer_id` = '0' and `offer_type` = '0'";
							// exit();
							$get_max_buying_offer_QTY = getOFFERS($get_auto_eligible_offer_ID,'offer_qty');
							$WITHOUT_FLAT_OFFER_QTY = ($product_qty - $get_max_buying_offer_QTY);

							if($product_qty >= $get_max_buying_offer_QTY){
								//echo "A";
								if($WITHOUT_FLAT_OFFER_QTY){
									$productsellingprice = ($WITHOUT_FLAT_OFFER_QTY * $variant_prdt_final_price);
									if($variant_taxtype == 'Y') {
										$taxsplit_price = ($productsellingprice * ($variant_tax_value/100))/2;
										$total_price = ($productsellingprice - ($taxsplit_price* 2));
									} else {
										$taxsplit_price = (($productsellingprice * ($variant_tax_value/100))/2);
										$total_price = $productsellingprice;
									}
									
									$insert_offer_products = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$WITHOUT_FLAT_OFFER_QTY', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
								}
								if($variant_taxtype == 'Y') {
									$taxsplit_price = ($get_eligible_FLAT_OFFER_PRICE * ($variant_tax_value/100))/2;
									$total_price = ($get_eligible_FLAT_OFFER_PRICE - ($taxsplit_price * 2));
								} else {
									$taxsplit_price = (($get_eligible_FLAT_OFFER_PRICE * ($variant_tax_value/100))/2);
									$total_price = $get_eligible_FLAT_OFFER_PRICE;
								}
								//echo "<br>";
								//echo "INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`, `offer_id`, `offer_type`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$get_max_buying_offer_QTY', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1', '$get_auto_eligible_offer_ID', '$get_auto_eligible_offer_TYPE')";
								
								$insert_offer_products = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`, `offer_id`, `offer_type`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$get_max_buying_offer_QTY', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1', '$get_auto_eligible_offer_ID', '$get_auto_eligible_offer_TYPE')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
							} else {
								//echo "INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`, `offer_id`, `offer_type`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$get_max_buying_offer_QTY', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1', '$get_auto_eligible_offer_ID', '$get_auto_eligible_offer_TYPE')";
								//echo "<br>";
								$insert_offer_products = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$product_qty', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
							}
							//exit();
							$message = "Cart updated...!!!";

							$update_the_applied_offer_id_deleted_sttaus = sqlQUERY_LABEL("UPDATE `js_offer_eligibility` SET `deleted` = '1' WHERE `offer_eligible_ID` = '$get_auto_eligible_offer_ID'") or die(sqlERROR_LABEL());
						}
					} else {
					if($check_product_offer_eligibility_count == 0){
						echo "A2";
						//exit();
						$insert_without_offer_products = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`, `pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$product_qty', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price','1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
						$message = "Cart added...!!!";
						$inserted_cart_ID = sqlINSERTID_LABEL();
						$current_date_time = date('Y-m-d H:i:s');

						$get_total_added_cart_QTY = get_OD_QTY_FROM_SESSION($PRDT_ID, $current_SESSION_ID, 'get_total_cart_od_qty_without_offer_qty');
						$get_total_added_cart_without_bogo_OFFER_QTY = get_OD_QTY_FROM_SESSION($PRDT_ID, $current_SESSION_ID, 'get_total_cart_od_qty_without_bogo_offer_type');
						$total_CART_ADDED_QTY = ($get_total_added_cart_QTY+$get_total_added_cart_without_bogo_OFFER_QTY);
						$get_eligible_offer_ID = get_OFFER_ELIGIBILITY_ID($total_CART_ADDED_QTY, $PRDT_ID, 'get_offer_id');
						$get_eligible_offer_TYPE = get_OFFER_ELIGIBILITY_ID($total_CART_ADDED_QTY, $PRDT_ID, 'get_offer_type');

						$insert_offer_eligibility = sqlQUERY_LABEL("INSERT into `js_offer_eligibility` (`prdt_id`, `cart_id`, `offer_id`, `offer_type`, `od_session_id`, `createdby`, `createdon`, `status`) VALUES ('$PRDT_ID', '$inserted_cart_ID', '$get_eligible_offer_ID', '$get_eligible_offer_TYPE', '$current_SESSION_ID', '$logged_user_id', '$current_date_time','1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());

					} else {
						echo "A3";
						//exit();
						$get_selected_product_offers = sqlQUERY_LABEL("select `offer_eligible_ID`, `offer_id`, `offer_type` FROM `js_offer_eligibility` where `prdt_id`='$PRDT_ID' and `od_session_id`='$current_SESSION_ID' and `status` = '1' and `deleted` = '0'") or die(sqlERROR_LABEL());
						while($fetch_product_offer_id = sqlFETCHARRAY_LABEL($get_selected_product_offers)) {
							$offer_eligible_ID = $fetch_product_offer_id['offer_eligible_ID'];
							$offer_ID = $fetch_product_offer_id['offer_id'];
							$offer_TYPE = $fetch_product_offer_id['offer_type'];
						}
					if($offer_TYPE == '1'){
						echo "A4";
						//exit();
						//BOGO OFFER - STARTED
						$get_eligible_OFFERT_QTY = get_OFFER_ELIGIBILITY_ID($offer_ID, $PRDT_ID, 'get_offer_qty');

						$get_offer_added_item_OFFER_ID = get_OD_QTY_FROM_SESSION($PRDT_ID, $current_SESSION_ID, 'get_added_offer_product_offer_id');
						
						$remove_exisiting_added_offer_QTY = sqlQUERY_LABEL("DELETE FROM `js_shop_order_item` WHERE `offer_id` = '$get_offer_added_item_OFFER_ID' and `od_session` = '$current_SESSION_ID' and `pd_id` = '$PRDT_ID' and `offer_id` != '0'") or die(sqlERROR_LABEL());
						
						$insert_offer_products = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`, `offer_id`, `offer_type`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$get_eligible_OFFERT_QTY', '0', '0', '0', '0', '0','1', '$offer_ID', '$offer_TYPE')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
						$current_date_time = date('Y-m-d H:i:s');

						$update_the_applied_offer_id_deleted_sttaus = sqlQUERY_LABEL("UPDATE `js_offer_eligibility` SET `deleted` = '1' WHERE `offer_eligible_ID` = '$offer_eligible_ID'") or die(sqlERROR_LABEL());

					} else if($offer_TYPE == '2'){
						echo "A5";
						exit();
						//Flat Discount
						$get_eligible_FLAT_OFFER_PRICE = get_OFFER_ELIGIBILITY_ID($offer_ID, $PRDT_ID, 'get_offer_qty');

						$get_offer_added_item_OFFER_ID = get_OD_QTY_FROM_SESSION($PRDT_ID, $current_SESSION_ID, 'get_added_offer_product_offer_id');
						echo $product_qty;
						exit();
						$remove_exisiting_added_offer_QTY = sqlQUERY_LABEL("DELETE FROM `js_shop_order_item` WHERE `offer_id` = '$get_offer_added_item_OFFER_ID' and `od_session` = '$current_SESSION_ID' and `pd_id` = '$PRDT_ID' and `offer_id` != '0'") or die(sqlERROR_LABEL());

						if($producttaxtype == 'Y') {
							$taxsplit_price = ($get_eligible_FLAT_OFFER_PRICE * ($producttax/100))/2;
							$total_price = ($get_eligible_FLAT_OFFER_PRICE - ($taxsplit_price * 2));
						} else {
							$taxsplit_price = (($get_eligible_FLAT_OFFER_PRICE * ($producttax/100))/2);
							$total_price = $get_eligible_FLAT_OFFER_PRICE;
						}

						$update_FLAT_OFFER_ITEM = sqlQUERY_LABEL("UPDATE `js_shop_order_item` SET `offer_id` = '$offer_ID', `offer_type` = '$offer_TYPE', `od_price` = '$total_price', `od_qty`='$quantity', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_customer_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_customer_id' and pd_id = '$PRDT_ID' and `offer_id` = '0' and `offer_type` = '0'") or die(sqlERROR_LABEL());
						$message = "Cart updated...!!!";

						$update_the_applied_offer_id_deleted_sttaus = sqlQUERY_LABEL("UPDATE `js_offer_eligibility` SET `deleted` = '1' WHERE `offer_eligible_ID` = '$offer_eligible_ID'") or die(sqlERROR_LABEL());

					} else if($offer_TYPE == '3'){
						echo "A6";
						exit();
						//Percenatge
						$get_eligible_FLAT_OFFER_PERCENTAGE = get_OFFER_ELIGIBILITY_ID($offer_ID, $PRDT_ID, 'get_offer_qty');

						$get_offer_added_item_OFFER_ID = get_OD_QTY_FROM_SESSION($PRDT_ID, $current_SESSION_ID, 'get_added_offer_product_offer_id');

						$remove_exisiting_added_offer_QTY = sqlQUERY_LABEL("DELETE FROM `js_shop_order_item` WHERE `offer_id` = '$get_offer_added_item_OFFER_ID' and `od_session` = '$current_SESSION_ID' and `pd_id` = '$PRDT_ID' and `offer_id` != '0'") or die(sqlERROR_LABEL());
						$newtotal_price = $old_total_price * $quantity;
						$TOTAL_DISCOUNT_VALUE = (($newtotal_price * $get_eligible_FLAT_OFFER_PERCENTAGE)/100);
						if($producttaxtype == 'Y') {
							$taxsplit_price = ($newtotal_price * ($producttax/100))/2;
							$total_price = ($newtotal_price - ($taxsplit_price * 2));
						} else {
							$taxsplit_price = (($newtotal_price * ($producttax/100))/2);
							$total_price = $newtotal_price;
						}
						// echo "UPDATE `js_shop_order_item` SET `offer_id` = '$offer_ID', `offer_type` = '$offer_TYPE', `od_item_discount` = '$TOTAL_DISCOUNT_VALUE', `od_price` = '$total_price', `od_qty`='$quantity', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_customer_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_customer_id' and pd_id = '$PRDT_ID' and `offer_id` = '0' and `offer_type` = '0'";
						// exit();
						$update_FLAT_OFFER_ITEM = sqlQUERY_LABEL("UPDATE `js_shop_order_item` SET `offer_id` = '$offer_ID', `offer_type` = '$offer_TYPE', `od_item_discount` = '$TOTAL_DISCOUNT_VALUE', `od_price` = '$total_price', `od_qty`='$quantity', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_customer_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_customer_id' and pd_id = '$PRDT_ID' and `offer_id` = '0' and `offer_type` = '0'") or die(sqlERROR_LABEL());
						$message = "Cart updated...!!!";

						$update_the_applied_offer_id_deleted_sttaus = sqlQUERY_LABEL("UPDATE `js_offer_eligibility` SET `deleted` = '1' WHERE `offer_eligible_ID` = '$offer_eligible_ID'") or die(sqlERROR_LABEL());

					} else {
						echo "sfsdf";
						//exit();
						if(sqlNUMOFROW_LABEL($check_selecteditem1) == 0) {
							$insert_without_offer_products = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`, `pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$quantity', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price','1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
							$inserted_cart_ID = sqlINSERTID_LABEL();
						} else {
							$update_the_without_offer_product_QTY = sqlQUERY_LABEL("UPDATE `js_shop_order_item` SET `od_price` = '$newtotal_price', `od_qty`='$quantity', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_user_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_user_id' and pd_id = '$PRDT_ID' and variant_id = '$variant_ID' and `offer_id` = '0' and `offer_type` = '0'") or die(sqlERROR_LABEL());
						}
						$message = "Cart updated...!!!";
						$current_date_time = date('Y-m-d H:i:s');

						$get_total_added_cart_QTY = get_OD_QTY_FROM_SESSION($PRDT_ID, $current_SESSION_ID, 'get_total_cart_od_qty_without_offer_qty');
						$get_eligible_offer_ID = get_OFFER_ELIGIBILITY_ID($get_total_added_cart_QTY, $PRDT_ID, 'get_offer_id');
						$get_eligible_offer_TYPE = get_OFFER_ELIGIBILITY_ID($get_total_added_cart_QTY, $PRDT_ID, 'get_offer_type');
						$get_eligible_OFFERT_QTY = get_OFFER_ELIGIBILITY_ID($get_eligible_offer_ID, $PRDT_ID, 'get_offer_qty');

						$insert_offer_eligibility = sqlQUERY_LABEL("INSERT into `js_offer_eligibility` (`prdt_id`, `cart_id`, `offer_id`, `offer_type`, `od_session_id`, `createdby`, `createdon`, `status`) VALUES ('$PRDT_ID', '$inserted_cart_ID', '$get_eligible_offer_ID', '$get_eligible_offer_TYPE', '$current_SESSION_ID', '$logged_user_id', '$current_date_time','1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());

					}
					}
				}
				} else {
					?>
					<script type="text/javascript">window.location = 'product.php?token=<?php echo $token; ?>&prdt_error=outofstock2' </script>
					<?php
				}
			} else {
				echo "Aa";
				//exit();
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

				if($quantity <= $variant_prdt_available_qty){
					echo "Area";
					//exit();
					$check_product_offer_eligibility_count = commonNOOFROWS_COUNT('js_offer_eligibility',"`prdt_id`='$PRDT_ID' and `od_session_id`='$current_SESSION_ID' and `status` = '1' and `deleted` = '0'");
					if($check_product_offer_eligibility_count == 0){
					echo "sdAA";
					echo "<br>";
					exit();
						$get_auto_eligible_offer_ID = get_OFFER_ELIGIBILITY_ID($quantity, $PRDT_ID, 'get_auto_assign_offer_id_based_on_bulk_qty');
						$get_auto_eligible_offer_TYPE = get_OFFER_ELIGIBILITY_ID($quantity,$PRDT_ID, 'get_auto_assign_offer_type_based_on_bulk_qty');
						//echo $get_auto_eligible_offer_TYPE;
						//exit();							
						if($get_auto_eligible_offer_TYPE == 1){
							echo "Aasdsad";
							exit();
							$update_the_without_offer_product_QTY = sqlQUERY_LABEL("UPDATE `js_shop_order_item` SET `od_price` = '$newtotal_price', `od_qty`='$quantity', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_user_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_user_id' and pd_id = '$PRDT_ID' and variant_id = '$variant_ID' and `offer_id` = '0' and `offer_type` = '0'") or die(sqlERROR_LABEL());
							$inserted_cart_ID = sqlINSERTID_LABEL();
							$message = "Cart updated...!!!";
							$current_date_time = date('Y-m-d H:i:s');
							
							$get_total_added_cart_QTY = get_OD_QTY_FROM_SESSION($PRDT_ID, $current_SESSION_ID, 'get_total_cart_od_qty_without_offer_qty');
							$get_eligible_offer_ID = get_OFFER_ELIGIBILITY_ID($get_total_added_cart_QTY, $PRDT_ID, 'get_offer_id');
							$get_eligible_offer_TYPE = get_OFFER_ELIGIBILITY_ID($get_total_added_cart_QTY, $PRDT_ID, 'get_offer_type');
							$get_eligible_OFFERT_QTY = get_OFFER_ELIGIBILITY_ID($get_eligible_offer_ID, $PRDT_ID, 'get_offer_qty');

							$remove_exisiting_added_offer_QTY = sqlQUERY_LABEL("DELETE FROM `js_shop_order_item` WHERE `od_session` = '$current_SESSION_ID' and `pd_id` = '$PRDT_ID' and `offer_id` != '0'") or die(sqlERROR_LABEL());

							$insert_offer_products = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`, `offer_id`, `offer_type`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$get_eligible_OFFERT_QTY', '0', '0', '0', '0', '0', '1', '$get_eligible_offer_ID', '$get_eligible_offer_TYPE')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());

						} else if($get_auto_eligible_offer_TYPE == 2){
							echo "Adfsssa";
							exit();
							$get_total_added_cart_without_bogo_OFFER_QTY = get_OD_QTY_FROM_SESSION($PRDT_ID, $current_SESSION_ID, 'get_total_cart_od_qty_without_bogo_offer_type');
							$udated_cart_QTY = ($quantity+$get_total_added_cart_without_bogo_OFFER_QTY);
							//echo $udated_cart_QTY;
							//echo"DELETE FROM `js_shop_order_item` WHERE `offer_id` != '0' and `od_session` = '$current_SESSION_ID' and `pd_id` = '$PRDT_ID'";
							//exit();
							$remove_exisiting_added_offer_QTY = sqlQUERY_LABEL("DELETE FROM `js_shop_order_item` WHERE `od_session` = '$current_SESSION_ID' and `pd_id` = '$PRDT_ID'") or die(sqlERROR_LABEL());
							// exit();
							// echo "UPDATE `js_shop_order_item` SET `offer_id` = '$offer_ID', `offer_type` = '$offer_TYPE', `od_price` = '$total_price', `od_qty`='$udated_cart_QTY', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_customer_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_customer_id' and pd_id = '$PRDT_ID' and `offer_id` = '0' and `offer_type` = '0'";
							// exit();
							$get_auto_eligible_offer_ID = get_OFFER_ELIGIBILITY_ID($udated_cart_QTY, $PRDT_ID, 'get_auto_assign_offer_id_based_on_bulk_qty');
							$get_auto_eligible_offer_TYPE = get_OFFER_ELIGIBILITY_ID($udated_cart_QTY,$PRDT_ID, 'get_auto_assign_offer_type_based_on_bulk_qty');
							$get_eligible_FLAT_OFFER_PRICE = get_OFFER_ELIGIBILITY_ID($get_auto_eligible_offer_ID, $PRDT_ID, 'get_offer_qty');
							$get_max_buying_offer_QTY = getOFFERS($get_auto_eligible_offer_ID,'offer_qty');
							$WITHOUT_FLAT_OFFER_QTY = ($udated_cart_QTY - $get_max_buying_offer_QTY);

							if($udated_cart_QTY >= $get_max_buying_offer_QTY){
								//echo "A";
								if($WITHOUT_FLAT_OFFER_QTY){
									$productsellingprice = ($WITHOUT_FLAT_OFFER_QTY * $variant_prdt_final_price);
									if($variant_taxtype == 'Y') {
										$taxsplit_price = ($productsellingprice * ($variant_tax_value/100))/2;
										$total_price = ($productsellingprice - ($taxsplit_price* 2));
									} else {
										$taxsplit_price = (($productsellingprice * ($variant_tax_value/100))/2);
										$total_price = $productsellingprice;
									}
									//echo "INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$WITHOUT_FLAT_OFFER_QTY', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1')";
									//echo "<br>";
									$insert_offer_products = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$WITHOUT_FLAT_OFFER_QTY', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
								}
								if($variant_taxtype == 'Y') {
									$taxsplit_price = ($get_eligible_FLAT_OFFER_PRICE * ($variant_tax_value/100))/2;
									$total_price = ($get_eligible_FLAT_OFFER_PRICE - ($taxsplit_price * 2));
								} else {
									$taxsplit_price = (($get_eligible_FLAT_OFFER_PRICE * ($variant_tax_value/100))/2);
									$total_price = $get_eligible_FLAT_OFFER_PRICE;
								}
								//echo "<br>";
								//echo "INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`, `offer_id`, `offer_type`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$get_max_buying_offer_QTY', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1', '$get_auto_eligible_offer_ID', '$get_auto_eligible_offer_TYPE')";
								
								$insert_offer_products = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`, `offer_id`, `offer_type`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$get_max_buying_offer_QTY', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1', '$get_auto_eligible_offer_ID', '$get_auto_eligible_offer_TYPE')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
							} else {
								//echo "INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`, `offer_id`, `offer_type`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$get_max_buying_offer_QTY', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1', '$get_auto_eligible_offer_ID', '$get_auto_eligible_offer_TYPE')";
								//echo "<br>";
								$insert_offer_products = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$udated_cart_QTY', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
							}
							//exit();
							$message = "Cart updated...!!!";

							$update_the_applied_offer_id_deleted_sttaus = sqlQUERY_LABEL("UPDATE `js_offer_eligibility` SET `deleted` = '1' WHERE `offer_eligible_ID` = '$get_auto_eligible_offer_ID'") or die(sqlERROR_LABEL());
						}
						
					} else {
						echo "sfsf";
						//exit();
						$get_selected_product_offers = sqlQUERY_LABEL("select `offer_eligible_ID`, `offer_id`, `offer_type` FROM `js_offer_eligibility` where `prdt_id`='$PRDT_ID' and `od_session_id`='$current_SESSION_ID' and `status` = '1' and `deleted` = '0'") or die(sqlERROR_LABEL());
						while($fetch_product_offer_id = sqlFETCHARRAY_LABEL($get_selected_product_offers)) {
							$offer_eligible_ID = $fetch_product_offer_id['offer_eligible_ID'];
							$offer_ID = $fetch_product_offer_id['offer_id'];
							$offer_TYPE = $fetch_product_offer_id['offer_type'];
						}

					if($offer_TYPE == '1'){
						//BOGO OFFER - STARTED
						echo "AJHGJ";
						//exit();
						$get_eligible_OFFERT_QTY = get_OFFER_ELIGIBILITY_ID($offer_ID, $PRDT_ID, 'get_offer_qty');

						$get_offer_added_item_OFFER_ID = get_OD_QTY_FROM_SESSION($PRDT_ID, $current_SESSION_ID, 'get_added_offer_product_offer_id');
						
						$remove_exisiting_added_offer_QTY = sqlQUERY_LABEL("DELETE FROM `js_shop_order_item` WHERE `offer_id` = '$get_offer_added_item_OFFER_ID' and `od_session` = '$current_SESSION_ID' and `pd_id` = '$PRDT_ID' and `offer_id` != '0'") or die(sqlERROR_LABEL());

						$insert_offer_products = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`, `pd_id`, `variant_id`, `offer_id`, `offer_type`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$offer_ID', '$offer_TYPE', '$logged_user_id', '$current_SESSION_ID', '$get_eligible_OFFERT_QTY', '0', '0', '0', '0', '0','1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());

						$current_date_time = date('Y-m-d H:i:s');

						$update_the_applied_offer_id_deleted_sttaus = sqlQUERY_LABEL("UPDATE `js_offer_eligibility` SET `deleted` = '1' WHERE `offer_eligible_ID` = '$offer_eligible_ID'") or die(sqlERROR_LABEL());

					} else if($offer_TYPE == '2'){
						echo "Assw5";
						exit();
						//Flat Discount
						$get_total_added_cart_without_bogo_OFFER_QTY = get_OD_QTY_FROM_SESSION($PRDT_ID, $current_SESSION_ID, 'get_total_cart_od_qty_without_bogo_offer_type');
						$udated_cart_QTY = ($quantity+$get_total_added_cart_without_bogo_OFFER_QTY);
						$remove_exisiting_added_item_QTY = sqlQUERY_LABEL("DELETE FROM `js_shop_order_item` WHERE `od_session` = '$current_SESSION_ID' and `pd_id` = '$PRDT_ID'") or die(sqlERROR_LABEL());
						// echo $udated_cart_QTY;
						// exit();
						if($producttaxtype == 'Y') {
							$taxsplit_price = ($get_eligible_FLAT_OFFER_PRICE * ($variant_tax_value/100))/2;
							$total_price = ($get_eligible_FLAT_OFFER_PRICE - ($taxsplit_price * 2));
						} else {
							$taxsplit_price = (($get_eligible_FLAT_OFFER_PRICE * ($variant_tax_value/100))/2);
							$total_price = $get_eligible_FLAT_OFFER_PRICE;
						}
						// echo "UPDATE `js_shop_order_item` SET `offer_id` = '$offer_ID', `offer_type` = '$offer_TYPE', `od_price` = '$total_price', `od_qty`='$udated_cart_QTY', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_customer_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_customer_id' and pd_id = '$PRDT_ID' and `offer_id` = '0' and `offer_type` = '0'";
						// exit();
						$get_auto_eligible_offer_ID = get_OFFER_ELIGIBILITY_ID($udated_cart_QTY, $PRDT_ID, 'get_auto_assign_offer_id_based_on_bulk_qty');
						$get_auto_eligible_offer_TYPE = get_OFFER_ELIGIBILITY_ID($udated_cart_QTY,$PRDT_ID, 'get_auto_assign_offer_type_based_on_bulk_qty');
						
						$get_eligible_FLAT_OFFER_PRICE = get_OFFER_ELIGIBILITY_ID($get_auto_eligible_offer_ID, $PRDT_ID, 'get_offer_qty');
						$get_offer_added_item_OFFER_ID = get_OD_QTY_FROM_SESSION($PRDT_ID, $current_SESSION_ID, 'get_added_offer_product_offer_id');
						$get_max_buying_offer_QTY = getOFFERS($get_auto_eligible_offer_ID,'offer_qty');
						$WITHOUT_FLAT_OFFER_QTY = ($udated_cart_QTY - $get_max_buying_offer_QTY);

						if($udated_cart_QTY >= $get_max_buying_offer_QTY){
							//echo "A";
							if($WITHOUT_FLAT_OFFER_QTY){

								$newtotal_price = ($old_total_price * $udated_cart_QTY);
								
								if($variant_taxtype == 'Y') {
									$taxsplit_price = ($newtotal_price * ($variant_tax_value/100))/2;
									$total_price = ($newtotal_price - ($taxsplit_price* 2));
								} else {
									$taxsplit_price = (($newtotal_price * ($variant_tax_value/100))/2);
									$total_price = $newtotal_price;
								}
								//echo "INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$WITHOUT_FLAT_OFFER_QTY', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1')";
								//echo "<br>";
								$update_WITHOUT_FLAT_OFFER_ITEM_ONLY = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$WITHOUT_FLAT_OFFER_QTY', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
							}
							if($variant_taxtype == 'Y') {
								$taxsplit_price = ($get_eligible_FLAT_OFFER_PRICE * ($variant_tax_value/100))/2;
								$total_price = ($get_eligible_FLAT_OFFER_PRICE - ($taxsplit_price * 2));
							} else {
								$taxsplit_price = (($get_eligible_FLAT_OFFER_PRICE * ($variant_tax_value/100))/2);
								$total_price = $get_eligible_FLAT_OFFER_PRICE;
							}
							//echo "<br>";
							//echo "INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`, `offer_id`, `offer_type`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$get_max_buying_offer_QTY', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1', '$get_auto_eligible_offer_ID', '$get_auto_eligible_offer_TYPE')";
							
							$update_FLAT_OFFER_ITEM_ONLY = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`, `offer_id`, `offer_type`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$get_max_buying_offer_QTY', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1', '$get_auto_eligible_offer_ID', '$get_auto_eligible_offer_TYPE')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
						} else {

							//echo "INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`, `offer_id`, `offer_type`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$get_max_buying_offer_QTY', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1', '$get_auto_eligible_offer_ID', '$get_auto_eligible_offer_TYPE')";
							//echo "<br>";
							$update_WITHOUT_FLAT_OFFER_ITEM_ONLY = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$quantity', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
						}
						$message = "Cart updated...!!!";
						//exit();
						$update_the_applied_offer_id_deleted_sttaus = sqlQUERY_LABEL("UPDATE `js_offer_eligibility` SET `deleted` = '1' WHERE `offer_eligible_ID` = '$offer_eligible_ID'") or die(sqlERROR_LABEL());

					} else if($offer_TYPE == '3'){
						echo "A6dd";
						exit();
						//Percenatge
						$get_eligible_FLAT_OFFER_PERCENTAGE = get_OFFER_ELIGIBILITY_ID($offer_ID, $PRDT_ID, 'get_offer_qty');

						$get_offer_added_item_OFFER_ID = get_OD_QTY_FROM_SESSION($PRDT_ID, $current_SESSION_ID, 'get_added_offer_product_offer_id');

						$remove_exisiting_added_offer_QTY = sqlQUERY_LABEL("DELETE FROM `js_shop_order_item` WHERE `offer_id` = '$get_offer_added_item_OFFER_ID' and `od_session` = '$current_SESSION_ID' and `pd_id` = '$PRDT_ID' and `offer_id` != '0'") or die(sqlERROR_LABEL());
						$newtotal_price = $old_total_price * $quantity;
						$TOTAL_DISCOUNT_VALUE = (($newtotal_price * $get_eligible_FLAT_OFFER_PERCENTAGE)/100);
						if($producttaxtype == 'Y') {
							$taxsplit_price = ($newtotal_price * ($producttax/100))/2;
							$total_price = ($newtotal_price - ($taxsplit_price * 2));
						} else {
							$taxsplit_price = (($newtotal_price * ($producttax/100))/2);
							$total_price = $newtotal_price;
						}
						// echo "UPDATE `js_shop_order_item` SET `offer_id` = '$offer_ID', `offer_type` = '$offer_TYPE', `od_item_discount` = '$TOTAL_DISCOUNT_VALUE', `od_price` = '$total_price', `od_qty`='$quantity', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_customer_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_customer_id' and pd_id = '$PRDT_ID' and `offer_id` = '0' and `offer_type` = '0'";
						// exit();
						$update_FLAT_OFFER_ITEM = sqlQUERY_LABEL("UPDATE `js_shop_order_item` SET `offer_id` = '$offer_ID', `offer_type` = '$offer_TYPE', `od_item_discount` = '$TOTAL_DISCOUNT_VALUE', `od_price` = '$total_price', `od_qty`='$quantity', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_customer_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_customer_id' and pd_id = '$PRDT_ID' and `offer_id` = '0' and `offer_type` = '0'") or die(sqlERROR_LABEL());
						$message = "Cart updated...!!!";

						$update_the_applied_offer_id_deleted_sttaus = sqlQUERY_LABEL("UPDATE `js_offer_eligibility` SET `deleted` = '1' WHERE `offer_eligible_ID` = '$offer_eligible_ID'") or die(sqlERROR_LABEL());

					} else {
						echo "gdfG";
						//exit();
						$update_the_without_offer_product_QTY = sqlQUERY_LABEL("UPDATE `js_shop_order_item` SET `od_price` = '$newtotal_price', `od_qty`='$quantity', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_user_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_user_id' and pd_id = '$PRDT_ID' and variant_id = '$variant_ID' and `offer_id` = '0' and `offer_type` = '0'") or die(sqlERROR_LABEL());
						$inserted_cart_ID = sqlINSERTID_LABEL();
						$message = "Cart updated...!!!";
						$current_date_time = date('Y-m-d H:i:s');
						
						$get_total_added_cart_QTY = get_OD_QTY_FROM_SESSION($PRDT_ID, $current_SESSION_ID, 'get_total_cart_od_qty_without_offer_qty');
						$get_eligible_offer_ID = get_OFFER_ELIGIBILITY_ID($get_total_added_cart_QTY, $PRDT_ID, 'get_offer_id');
						$get_eligible_offer_TYPE = get_OFFER_ELIGIBILITY_ID($get_total_added_cart_QTY, $PRDT_ID, 'get_offer_type');
						$get_eligible_OFFERT_QTY = get_OFFER_ELIGIBILITY_ID($get_eligible_offer_ID, $PRDT_ID, 'get_offer_qty');

						$insert_offer_eligibility = sqlQUERY_LABEL("INSERT into `js_offer_eligibility` (`prdt_id`, `cart_id`, `offer_id`, `offer_type`, `od_session_id`, `createdby`, `createdon`, `status`) VALUES ('$PRDT_ID', '$inserted_cart_ID', '$get_eligible_offer_ID', '$get_eligible_offer_TYPE', '$current_SESSION_ID', '$logged_user_id', '$current_date_time','1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());

					}
					}

				} else {
					?>
					<script type="text/javascript">window.location = 'product.php?token=<?php echo $token; ?>&prdt_error=outofstock3' </script>
					<?php
				}
			}

		}
		?>
		<script type="text/javascript">window.location = 'product.php?token=<?php echo $token; ?>&prdt_details=cart_added2' </script>
		<?php
	}
}

	if($apply_coupon == "apply_coupon"){

	$coupon_code = $_POST['coupon_code'];
	$od_total_value = $_POST['od_total_value'];
	$hidden_od_id = $_POST['hidden_od_id'];
	$today = date('Y-m-d');
	$list_dicount_datas = sqlQUERY_LABEL("SELECT * FROM `js_promocode` where promocode_code='$coupon_code' and status= '1' and deleted = '0'") or die("Unable to get records:".mysqli_error());    

	$check_dicount_record_availabity = sqlNUMOFROW_LABEL($list_dicount_datas);      
	  
		if($check_dicount_record_availabity > 0) {

		  while($row = sqlFETCHARRAY_LABEL($list_dicount_datas)){
			$promocode_id = $row["promocode_id"];
			$promocode_name = $row["promocode_name"];
			$promocode_code = $row["promocode_code"];
			$discount_value = $row["promocode_value"];
			$promocode_expiry_date = $row["promocode_expiry_date"];
			$discount_type = $row["promocode_type"];
			$promocode_option = $row["promocode_option"];
			$status = $row["status"];
		  }
		
		if($today <= $promocode_expiry_date){
			if($discount_value > 0) { 
				//discount by amount
				if($discount_type == 1) {
					$discounted_item_price = ($od_total_value-$discount_value);
					$discountedamount_frm_fullprice = $discount_value;
				} else if($discount_type == 2) { // discount by percentage
					$discounted_item_price = (($od_total_value * $discount_value) / 100 );
					$discountedamount_frm_fullprice = $discounted_item_price;
				}
			}
		sqlQUERY_LABEL("UPDATE `js_shop_order` SET `od_discount_promo_ID` ='$promocode_id', `od_discount_type`='$discount_type', `od_discount_value`='$discount_value', `od_discount_amount`='$discountedamount_frm_fullprice' WHERE `od_sesid`='$sid' and od_userid = '$logged_customer_id' and od_id = '$hidden_od_id'") or die(sqlERROR_LABEL());

		?>
		<script type="text/javascript">window.location = 'cart?promo_code_msg=success' </script>
		<?php
		} else {
		?>
		<script type="text/javascript">window.location = 'cart?promo_error_code=1' </script>
		<?php
		}
		} else { 
		?>
		<script type="text/javascript">window.location = 'cart?promo_error_code=2' </script>
		<?php
		}
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
			'__productdetails1'
			);	
			echo $homepage_propertyclass->loadPAGE($loadbodyFUNCTIONS); 
			/*
			'__productdetails1' - Product Extended View
			'__productdetails2' - Default View
			'__productdetails3' - Sticky Info View
			'__productdetails4' - Gallery View
			
			*/
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
<script>
	$( document ).ready(function() {
		var urlParams = new URLSearchParams(window.location.search);
		
			if(urlParams.get('reviews')=="product-review-heading"){ 
	$('.collapse.show').removeClass(' show');
	$('#product-accordion-review').addClass(' show');
			}
		});

	var stock_record = {
			url: function(phrase) {
				return "ajax/ajax_search_products.php?product_info=" + phrase + "&format=json";
			},
			getValue: "product_details",
			template: {
				type: "iconRight",
				fields: {
				  iconSrc: "icon"
				}
			  },

			list: {
				onChooseEvent: function() {
					get_productdtls_List();
				},	
				match: {
                    enabled: false
                },
				
				hideOnEmptyPhrase: true
            },
			theme: "square"
		 };

        $("#productdata").easyAutocomplete(stock_record);
		
		
		function get_productdtls_List()
		{
			var productinfo =document.getElementById( "productdata" ).value;
			
			// alert(vpo_id);
			
		   if(productinfo)
		   {
			   //$('#progress_table').show();
			   $.ajax({
					   type: 'post', 
					   url: 'ajax/ajax_search_productname.php',
					   data: { productinfo:productinfo,
				   },
				   success: function (response) {
						location.assign(response);
					   if(response=="OK") {  return true;  } else { return false; }
				  }
			   });
			}
		}	
		
		
	</script>
</body>

</html>
