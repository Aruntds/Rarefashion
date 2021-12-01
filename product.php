<?php 
extract($_REQUEST);
include 'head/jackus.php'; 
include 'shopfunction.php'; 
include '___class__home.inc'; 
//echo $sid;
$product_token = strbefore($token, '-');

 $getIPaddress = getUserIpAddr();
//echo "INSERT into `js_total_product_vistors_list` (`userID`, `prdtID`, `IPaddress`,  `createdon`,`status`) VALUES ('$logged_customer_id', '$product_token', '$getIPaddress', '".date('Y-m-d H:i:s')."','1')";////exit();
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
	// echo $commontitle; //exit();
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
		echo "NOT VARIANT PRODUCT STATMENT";
		echo "<br>";
		//exit();
		$featured_product_data = sqlQUERY_LABEL("SELECT `productID`, `productsellingprice`, `producttax`, `producttaxtype`  FROM `js_product` where productID='$PRDT_ID' and deleted = '0' and status = '1'") or die("#1-Unable to get records:".sqlERROR_LABEL());
	  while($featured_data = sqlFETCHARRAY_LABEL($featured_product_data)){
		  $productID = $featured_data["productID"];
		  $productsellingprice = $featured_data["productsellingprice"];
		  $producttax = $featured_data["producttax"];
		  $producttaxtype = $featured_data["producttaxtype"];
	  }											

	if($PRDT_ID !='' && $current_SESSION_ID !=''){
		echo "OPENING STATMENT";
		echo "<br>";
		//exit();
		$check_selecteditem = sqlQUERY_LABEL("select `pd_id`, `od_colorid`, `od_size_id`, `od_qty`, `od_price`, `item_tax1`, `item_tax2` from js_shop_order_item where user_id = '$logged_user_id' and od_session = '$current_SESSION_ID' and pd_id = '$PRDT_ID' and `offer_id` = '0' and `offer_type` = '0'") or die(sqlERROR_LABEL());
		
		if(sqlNUMOFROW_LABEL($check_selecteditem) == 0) {
			echo "NUMROWS ZERO STATMENT";
			echo "<br>";
			//exit();
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
				echo "NUMROWS ZERO PRODUCT QTY LESS THAN EQUAL TO STOCK AVAILABILITY";
				echo "<br>";
				//exit();

			} else {
				?>
				<script type="text/javascript">window.location = 'product.php?token=<?php echo $token; ?>&prdt_error=outofstock1' </script>
				<?php
			}
		} else {
			echo "NUMROWS GREATER THAN ZERO STATMENT";
			echo "<br>";
			//exit();
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
				echo "NUMROWS GREATER THAN ZERO PRODUCT QTY LESS TAHN EQUAL TO STOCK AVAILABILITY";
				echo "<br>";
				//exit();
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
	echo "VARIANT PRODUCT STATMENT";
	echo "<br>";
	//exit();
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
		echo "VARIANT ID NOT EMPTY STATMENT";
		echo "<br>";
		//exit();
			$check_selecteditem1 = sqlQUERY_LABEL("select `pd_id`, `variant_id`, `od_colorid`, `od_size_id`, `od_qty`, `od_price`, `item_tax1`, `item_tax2` from js_shop_order_item where user_id = '$logged_user_id' and od_session = '$current_SESSION_ID' and pd_id = '$PRDT_ID' and variant_id='$variant_ID' and `offer_id` = '0' and `offer_type` = '0'") or die(sqlERROR_LABEL());
			
			if(sqlNUMOFROW_LABEL($check_selecteditem1) == 0) {
				echo "VARIANT PRODUCT COUNT ZERO STATMENT";
				echo "<br>";
				//exit();
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
				echo "VARIANT PRODUCT COUNT ZERO STOCK CHECKING STATMENT";
				echo "<br>";
				$check_product_offer_eligibility_count = commonNOOFROWS_COUNT('js_offer_eligibility',"`prdt_id`='$PRDT_ID' and `od_session_id`='$current_SESSION_ID' and `status` = '1' and `deleted` = '0'");
				echo $check_product_offer_eligibility_count;
				echo "<br>";
				//exit();
				if($product_qty == 1 && $check_product_offer_eligibility_count == 0){
					echo "PRODUCT COUNT 1 AND OFFERS 0 STATMENT";
					echo "<br>";
					//exit();
					$total_CART_ADDED_QTY_WITHOUT_OFFER_QTY = get_OD_QTY_FROM_SESSION($PRDT_ID, $current_SESSION_ID, $variant_ID, 'get_total_cart_od_qty_without_offer_qty');

					$updated_final_QTY = ($total_CART_ADDED_QTY_WITHOUT_OFFER_QTY+$product_qty);
					$get_auto_eligible_offer_ID = get_OFFER_ELIGIBILITY_ID($updated_final_QTY, $PRDT_ID, 'get_auto_assign_offer_id_based_on_bulk_qty');
					$get_auto_eligible_offer_TYPE = get_OFFER_ELIGIBILITY_ID($updated_final_QTY,$PRDT_ID, 'get_auto_assign_offer_type_based_on_bulk_qty');
					$_PRDT_OFFER_TYPE = get_OFFER_ELIGIBILITY_ID($updated_final_QTY,$PRDT_ID, 'get_prdt_offer_type');

					if($_PRDT_OFFER_TYPE == 1){
						$check_shop_order_product_count = commonNOOFROWS_COUNT('js_shop_order_item',"`pd_id`='$PRDT_ID' and `od_session`='$current_SESSION_ID' and `variant_id` = '$variant_ID' and `offer_id` = '0'");
						$productsellingprice = ($updated_final_QTY * $variant_prdt_final_price);

						if($variant_taxtype == 'Y') {
							$taxsplit_price = ($productsellingprice * ($variant_tax_value/100))/2;
							$total_price = ($productsellingprice - ($taxsplit_price* 2));
						} else {
							$taxsplit_price = (($productsellingprice * ($variant_tax_value/100))/2);
							$total_price = $productsellingprice;
						}
						if($check_shop_order_product_count == '0'){
						echo "PRODUCT COUNT 0 STATMENT @ SHOP ORDER ITEM";
						echo "<br>";
						echo $get_auto_eligible_offer_ID;
						//exit();
						echo "INSERT into `js_shop_order_item` (`createdby`, `pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$product_qty', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price','1')";
						echo "<br>";
							$insert_without_offer_products = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`, `pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$product_qty', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price','1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
							$message = "Cart added...!!!";
							$inserted_cart_ID = sqlINSERTID_LABEL();
						} else {
						echo "PRODUCT COUNT GREATER THAN ZERO STATMENT @ SHOP ORDER ITEM";
						echo "<br>";
						//exit();
						echo "UPDATE `js_shop_order_item` SET `od_price` = '$total_price', `od_qty`='$updated_final_QTY', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_user_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_user_id' and pd_id = '$PRDT_ID' and variant_id = '$variant_ID' and `offer_id` = '0' and `offer_type` = '0'";
						echo "<br>";										  
							$total_CART_ADDED_WIHOUT_SELECTED_VARIANT_QTY_WITHOUT_OFFER_QTY = get_OD_QTY_FROM_SESSION($PRDT_ID, $current_SESSION_ID, $variant_ID, 'get_total_cart_without_selected_variant_od_qty_without_offer_qty');
							$UPDATED_FINAL_QTY = ($total_CART_ADDED_WIHOUT_SELECTED_VARIANT_QTY_WITHOUT_OFFER_QTY+$product_qty);
							$get_auto_eligible_offer_ID = get_OFFER_ELIGIBILITY_ID($UPDATED_FINAL_QTY, $PRDT_ID, 'get_auto_assign_offer_id_based_on_bulk_qty');
							$get_auto_eligible_offer_TYPE = get_OFFER_ELIGIBILITY_ID($UPDATED_FINAL_QTY,$PRDT_ID, 'get_auto_assign_offer_type_based_on_bulk_qty');
							$update_the_without_offer_product_QTY = sqlQUERY_LABEL("UPDATE `js_shop_order_item` SET `od_price` = '$total_price', `od_qty`='$updated_final_QTY', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_user_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_user_id' and pd_id = '$PRDT_ID' and variant_id = '$variant_ID' and `offer_id` = '0' and `offer_type` = '0'") or die(sqlERROR_LABEL());
							$message = "Cart updated...!!!";
						}
						echo "UPDATE OFFER ELIGIPLITY DATA";
						echo "<br>";
						//exit();
						$current_date_time = date('Y-m-d H:i:s');
						
						$remove_exisiting_added_offer_QTY = sqlQUERY_LABEL("DELETE FROM `js_offer_eligibility` WHERE `od_session_id` = '$current_SESSION_ID' and `prdt_id` = '$PRDT_ID' and `deleted` = '0'") or die(sqlERROR_LABEL());

						$check_shop_order_product_count_offer_applied_already = commonNOOFROWS_COUNT('js_shop_order_item',"`pd_id`='$PRDT_ID' and `od_session`='$current_SESSION_ID' and `offer_id` = '$get_auto_eligible_offer_ID'");

						if($get_auto_eligible_offer_ID != '' && $get_auto_eligible_offer_ID != '0' && $check_shop_order_product_count_offer_applied_already == 0){
							echo "INSERT into `js_offer_eligibility` (`prdt_id`, `cart_id`, `offer_id`, `offer_type`, `od_session_id`, `createdby`, `createdon`, `status`) VALUES ('$PRDT_ID', '$inserted_cart_ID', '$get_auto_eligible_offer_ID', '$get_auto_eligible_offer_TYPE', '$current_SESSION_ID', '$logged_user_id', '$current_date_time','1')";
							$insert_offer_eligibility = sqlQUERY_LABEL("INSERT into `js_offer_eligibility` (`prdt_id`, `cart_id`, `offer_id`, `offer_type`, `od_session_id`, `createdby`, `createdon`, `status`) VALUES ('$PRDT_ID', '$inserted_cart_ID', '$get_auto_eligible_offer_ID', '$get_auto_eligible_offer_TYPE', '$current_SESSION_ID', '$logged_user_id', '$current_date_time','1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
						}
					} else if($_PRDT_OFFER_TYPE == 2){
						echo "MAIN LOOP PRDT OFFER TYPE 2";
						echo "<br>";
						//exit();						
						$check_shop_order_product_offer_count = commonNOOFROWS_COUNT('js_shop_order_item',"`pd_id`='$PRDT_ID' and `od_session`='$current_SESSION_ID' and `variant_id` = '$variant_ID'");
						echo $check_shop_order_product_offer_count;
						//exit();
						if($check_shop_order_product_offer_count == '0'){
							$total_CART_ADDED_WIHOUT_SELECTED_VARIANT_QTY_WITHOUT_OFFER_QTY = get_OD_QTY_FROM_SESSION($PRDT_ID, $current_SESSION_ID, $variant_ID, 'get_total_cart_without_selected_variant_od_qty_without_offer_qty');
							$updated_final_QTY = ($total_CART_ADDED_WIHOUT_SELECTED_VARIANT_QTY_WITHOUT_OFFER_QTY+$product_qty);
							$get_auto_eligible_offer_ID = get_OFFER_ELIGIBILITY_ID($updated_final_QTY, $PRDT_ID, 'get_auto_assign_offer_id_based_on_bulk_qty');
							$get_auto_eligible_offer_TYPE = get_OFFER_ELIGIBILITY_ID($updated_final_QTY,$PRDT_ID, 'get_auto_assign_offer_type_based_on_bulk_qty');
							$get_max_buying_offer_QTY = getOFFERS($get_auto_eligible_offer_ID,'offer_qty');
							$get_eligible_FLAT_OFFER_PRICE = getOFFERS($get_auto_eligible_offer_ID,'offer_value');
							echo "<br>";
							echo $get_auto_eligible_offer_ID;
							echo "<br>";
							echo "$get_max_buying_offer_QTY == $updated_final_QTY";
							//exit();
							if($get_max_buying_offer_QTY == $updated_final_QTY){
								$get_manage_qty = $updated_final_QTY/$get_max_buying_offer_QTY;
								$get_eligible_FLAT_OFFER_ITEM_PRICE = ($get_eligible_FLAT_OFFER_PRICE/$updated_final_QTY);
								if($variant_taxtype == 'Y') {
									$taxsplit_price = ($get_eligible_FLAT_OFFER_ITEM_PRICE * ($variant_tax_value/100))/2;
									$total_price = ($get_eligible_FLAT_OFFER_ITEM_PRICE - ($taxsplit_price * 2));
								} else {
									$taxsplit_price = (($get_eligible_FLAT_OFFER_ITEM_PRICE * ($variant_tax_value/100))/2);
									$total_price = $get_eligible_FLAT_OFFER_ITEM_PRICE;
								}
								$__get_cart_id = getSINGLEDBVALUE('cart_id', " deleted = '0' and status = '1' and pd_id = '$PRDT_ID' and od_session = '$current_SESSION_ID'", 'js_shop_order_item', 'label');
								echo "UPDATE `js_shop_order_item` SET `offer_id`='$get_auto_eligible_offer_ID', `offer_type`='$get_auto_eligible_offer_TYPE', `od_price` = '$total_price', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_user_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_user_id' and pd_id = '$PRDT_ID' and cart_id = '$__get_cart_id' and `offer_id` = '0' and `offer_type` = '0'";
								echo "<br>";
								$update_the_product_details = sqlQUERY_LABEL("UPDATE `js_shop_order_item` SET `offer_id`='$get_auto_eligible_offer_ID', `offer_type`='$get_auto_eligible_offer_TYPE', `od_price` = '$total_price', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_user_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_user_id' and pd_id = '$PRDT_ID' and cart_id = '$__get_cart_id' and `offer_id` = '0' and `offer_type` = '0'") or die(sqlERROR_LABEL());
								
								echo "INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$get_manage_qty', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1')";
								echo "<br>";
								$insert_without_offer_products = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`, `offer_id`, `offer_type`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$get_manage_qty', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1', '$get_auto_eligible_offer_ID', '$get_auto_eligible_offer_TYPE')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
							} else {
								$newtotal_price = $variant_prdt_final_price * $product_qty;
								if($variant_taxtype == 'Y') {
									$taxsplit_price = ($newtotal_price * ($variant_tax_value/100))/2;
									$total_price = ($newtotal_price - ($taxsplit_price * 2));
								} else {
									$taxsplit_price = (($newtotal_price * ($variant_tax_value/100))/2);
									$total_price = $newtotal_price;
								}
								echo "INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$product_qty', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1')";
								echo "<br>";
								$insert_without_offer_products = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$product_qty', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
							}
						} else {
							$total_CART_ADDED_VARIANT_QTY_WITHOUT_OFFER_QTY = get_OD_QTY_FROM_SESSION($PRDT_ID, $current_SESSION_ID, $variant_ID, 'get_total_cart_variant_od_qty_without_offer_qty');
							$get_auto_eligible_offer_ID = get_OFFER_ELIGIBILITY_ID($updated_final_QTY, $PRDT_ID, 'get_auto_assign_offer_id_based_on_bulk_qty');
							$get_auto_eligible_offer_TYPE = get_OFFER_ELIGIBILITY_ID($updated_final_QTY,$PRDT_ID, 'get_auto_assign_offer_type_based_on_bulk_qty');
							$get_max_buying_offer_QTY = getOFFERS($get_auto_eligible_offer_ID,'offer_qty');
							$get_eligible_FLAT_OFFER_PRICE = getOFFERS($get_auto_eligible_offer_ID,'offer_value');
							$updated_final_QTY = ($total_CART_ADDED_VARIANT_QTY_WITHOUT_OFFER_QTY+$product_qty);
							if($variant_taxtype == 'Y') {
								$taxsplit_price = ($get_eligible_FLAT_OFFER_PRICE * ($variant_tax_value/100))/2;
								$total_price = ($get_eligible_FLAT_OFFER_PRICE - ($taxsplit_price * 2));
							} else {
								$taxsplit_price = (($get_eligible_FLAT_OFFER_PRICE * ($variant_tax_value/100))/2);
								$total_price = $get_eligible_FLAT_OFFER_PRICE;
							}
							echo "UPDATE `js_shop_order_item` SET  `od_qty`='$updated_final_QTY', `offer_id`='$get_auto_eligible_offer_ID', `offer_type`='$get_auto_eligible_offer_TYPE' WHERE createdby = '$logged_user_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_user_id' and pd_id = '$PRDT_ID' and variant_id = '$variant_ID' and `offer_id` != '0' and `offer_type` != '0'";
							echo "<br>";
							$update_the_without_offer_product_QTY = sqlQUERY_LABEL("UPDATE `js_shop_order_item` SET  `od_qty`='$updated_final_QTY', `offer_id`='$get_auto_eligible_offer_ID', `offer_type`='$get_auto_eligible_offer_TYPE' WHERE createdby = '$logged_user_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_user_id' and pd_id = '$PRDT_ID' and variant_id = '$variant_ID' and `offer_id` != '0' and `offer_type` != '0'") or die(sqlERROR_LABEL());
							if($get_auto_eligible_offer_ID != '' && $get_auto_eligible_offer_ID != '0'){
								$current_date_time =  date('Y-m-d H:i:s');
								echo "INSERT into `js_offer_eligibility` (`prdt_id`, `cart_id`, `offer_id`, `offer_type`, `od_session_id`, `createdby`, `createdon`, `status`) VALUES ('$PRDT_ID', '$inserted_cart_ID', '$get_auto_eligible_offer_ID', '$get_auto_eligible_offer_TYPE', '$current_SESSION_ID', '$logged_user_id', '$current_date_time','1')";
								echo "<br>";
								$insert_offer_eligibility = sqlQUERY_LABEL("INSERT into `js_offer_eligibility` (`prdt_id`, `cart_id`, `offer_id`, `offer_type`, `od_session_id`, `createdby`, `createdon`, `status`) VALUES ('$PRDT_ID', '$inserted_cart_ID', '$get_auto_eligible_offer_ID', '$get_auto_eligible_offer_TYPE', '$current_SESSION_ID', '$logged_user_id', '$current_date_time','1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
							}
						}
					}
					//exit();
				} else if($product_qty > 1 && $check_product_offer_eligibility_count == 0){
					echo "PRODUCT QTY GREATER THEN 1 AND OFFERS 0 STATMENT";
					echo "<br>";
					//exit();
					$remove_exisiting_added_offer_QTY = sqlQUERY_LABEL("DELETE FROM `js_shop_order_item` WHERE `od_session` = '$current_SESSION_ID' and `pd_id` = '$PRDT_ID' and `offer_id` != '0'") or die(sqlERROR_LABEL());

					$total_CART_ADDED_VARIANT_QTY_WITHOUT_OFFER_QTY = get_OD_QTY_FROM_SESSION($PRDT_ID, $current_SESSION_ID, $variant_ID, 'get_total_cart_variant_od_qty_without_offer_qty');
					$updated_final_QTY = ($total_CART_ADDED_VARIANT_QTY_WITHOUT_OFFER_QTY+$product_qty);
					$get_auto_eligible_offer_ID = get_OFFER_ELIGIBILITY_ID($updated_final_QTY, $PRDT_ID, 'get_auto_assign_offer_id_based_on_bulk_qty');
					$get_auto_eligible_offer_TYPE = get_OFFER_ELIGIBILITY_ID($updated_final_QTY,$PRDT_ID, 'get_auto_assign_offer_type_based_on_bulk_qty');
					$_PRDT_OFFER_TYPE = get_OFFER_ELIGIBILITY_ID($updated_final_QTY,$PRDT_ID, 'get_prdt_offer_type');

					if($_PRDT_OFFER_TYPE == 1){
					echo "CHECK OFFERS TYPE 1";
					echo "<br>";
					//exit();
						$get_max_buying_offer_QTY = getOFFERS($get_auto_eligible_offer_ID,'offer_qty');
						$get_eligible_offer_QTY = getOFFERS($get_auto_eligible_offer_ID,'offer_value');
						$WITHOUT_OFFER_QTY = ($updated_final_QTY - $get_eligible_offer_QTY);
						// echo $updated_final_QTY;
						// echo "<br>";
						// echo $get_max_buying_offer_QTY;
						// echo "<br>";
						// echo $get_eligible_offer_QTY;
						// echo "<br>";
						//exit();
						if($updated_final_QTY > $get_max_buying_offer_QTY){
							echo "CHECK QTY EXCESS THE MAX OFFER ELIGIBLE QTY";
							echo "<br>";
							//exit();
							if($WITHOUT_OFFER_QTY){
								echo "CHECK WITHOUT OFFER QTY AVAILABLE";
								echo "<br>";
								//exit();
								$newtotal_price = $variant_prdt_final_price * $WITHOUT_OFFER_QTY;
								if($variant_taxtype == 'Y') {
									$taxsplit_price = ($newtotal_price * ($variant_tax_value/100))/2;
									$total_price = ($newtotal_price - ($taxsplit_price * 2));
								} else {
									$taxsplit_price = (($newtotal_price * ($variant_tax_value/100))/2);
									$total_price = $newtotal_price;
								}
								echo "INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$WITHOUT_OFFER_QTY', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1')";
								$check_shop_order_product_count = commonNOOFROWS_COUNT('js_shop_order_item',"`pd_id`='$PRDT_ID' and `od_session`='$current_SESSION_ID' and `variant_id` = '$variant_ID'");
								if($check_shop_order_product_count == '0'){
									$insert_without_offer_products = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$WITHOUT_OFFER_QTY', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
								} else {
									$update_the_without_offer_product_QTY = sqlQUERY_LABEL("UPDATE `js_shop_order_item` SET `od_price` = '$total_price', `od_qty`='$WITHOUT_OFFER_QTY', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_user_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_user_id' and pd_id = '$PRDT_ID' and variant_id = '$variant_ID' and `offer_id` = '0' and `offer_type` = '0'") or die(sqlERROR_LABEL());

								}
							}
								echo "INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`, `offer_id`, `offer_type`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$get_eligible_offer_QTY', '0', '0', '0', '0', '0', '1', '$get_auto_eligible_offer_ID', '$get_auto_eligible_offer_TYPE')";
							if($get_max_buying_offer_QTY){
								$check_shop_order_product_offer_count = commonNOOFROWS_COUNT('js_shop_order_item',"`pd_id`='$PRDT_ID' and `od_session`='$current_SESSION_ID' and `variant_id` = '$variant_ID' and `offer_id` != '0'");
								if($check_shop_order_product_offer_count == '0'){
									$insert_offer_products = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`, `offer_id`, `offer_type`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$get_eligible_offer_QTY', '0', '0', '0', '0', '0', '1', '$get_auto_eligible_offer_ID', '$get_auto_eligible_offer_TYPE')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
								} else {
									$update_the_without_offer_product_QTY = sqlQUERY_LABEL("UPDATE `js_shop_order_item` SET  `od_qty`='$d', `offer_id`='$get_auto_eligible_offer_ID', `offer_type`='$get_auto_eligible_offer_TYPE' WHERE createdby = '$logged_user_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_user_id' and pd_id = '$PRDT_ID' and variant_id = '$variant_ID' and `offer_id` != '0' and `offer_type` != '0'") or die(sqlERROR_LABEL());
								}
							}
						} else {
							echo "CHECK QTY CANNOT EXCESS THE MAX OFFER ELIGIBLE QTY";
							echo "<br>";
							//exit();
							$newtotal_price = $variant_prdt_final_price * $updated_final_QTY;
							if($variant_taxtype == 'Y') {
								$taxsplit_price = ($newtotal_price * ($variant_tax_value/100))/2;
								$total_price = ($newtotal_price - ($taxsplit_price * 2));
							} else {
								$taxsplit_price = (($newtotal_price * ($variant_tax_value/100))/2);
								$total_price = $newtotal_price;
							}
							
							$check_shop_order_product_count = commonNOOFROWS_COUNT('js_shop_order_item',"`pd_id`='$PRDT_ID' and `od_session`='$current_SESSION_ID' and `variant_id` = '$variant_ID'");
							if($check_shop_order_product_count == '0'){
								echo "CHECK QTY CANNOT EXCESS THE MAX OFFER ELIGIBLE QTY SHOP ORDER COUNT 0";
								echo "<br>";
								echo $get_auto_eligible_offer_ID;
								//exit();
								echo "INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$updated_final_QTY', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1')";
								$insert_without_offer_product_QTY = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$updated_final_QTY', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
							} else {
								echo "CHECK QTY CANNOT EXCESS THE MAX OFFER ELIGIBLE QTY SHOP ORDER COUNT GREATER THEN 0";
								echo "<br>";
								//exit();
								echo "UPDATE `js_shop_order_item` SET `od_price` = '$total_price', `od_qty`='$updated_final_QTY', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_user_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_user_id' and pd_id = '$PRDT_ID' and variant_id = '$variant_ID' and `offer_id` = '0' and `offer_type` = '0'";
								$update_the_without_offer_product_QTY = sqlQUERY_LABEL("UPDATE `js_shop_order_item` SET `od_price` = '$total_price', `od_qty`='$updated_final_QTY', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_user_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_user_id' and pd_id = '$PRDT_ID' and variant_id = '$variant_ID' and `offer_id` = '0' and `offer_type` = '0'") or die(sqlERROR_LABEL());
								$message = "Cart updated...!!!";
							}
							$total_CART_ADDED_WIHOUT_SELECTED_VARIANT_QTY_WITHOUT_OFFER_QTY = get_OD_QTY_FROM_SESSION($PRDT_ID, $current_SESSION_ID, $variant_ID, 'get_total_cart_without_selected_variant_od_qty_without_offer_qty');
							$UPDATED_FINAL_QTY = ($total_CART_ADDED_WIHOUT_SELECTED_VARIANT_QTY_WITHOUT_OFFER_QTY+$product_qty);
							$get_auto_eligible_offer_ID = get_OFFER_ELIGIBILITY_ID($UPDATED_FINAL_QTY, $PRDT_ID, 'get_auto_assign_offer_id_based_on_bulk_qty');
							$get_auto_eligible_offer_TYPE = get_OFFER_ELIGIBILITY_ID($UPDATED_FINAL_QTY,$PRDT_ID, 'get_auto_assign_offer_type_based_on_bulk_qty');
							if($get_auto_eligible_offer_ID != '' && $get_auto_eligible_offer_ID != '0'){
								echo "INSERT into `js_offer_eligibility` (`prdt_id`, `cart_id`, `offer_id`, `offer_type`, `od_session_id`, `createdby`, `createdon`, `status`) VALUES ('$PRDT_ID', '$inserted_cart_ID', '$get_auto_eligible_offer_ID', '$get_auto_eligible_offer_TYPE', '$current_SESSION_ID', '$logged_user_id', '$current_date_time','1')";
								//exit();
								$insert_offer_eligibility = sqlQUERY_LABEL("INSERT into `js_offer_eligibility` (`prdt_id`, `cart_id`, `offer_id`, `offer_type`, `od_session_id`, `createdby`, `createdon`, `status`) VALUES ('$PRDT_ID', '$inserted_cart_ID', '$get_auto_eligible_offer_ID', '$get_auto_eligible_offer_TYPE', '$current_SESSION_ID', '$logged_user_id', '$current_date_time','1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
							}
						}
					//exit();
					} else if($_PRDT_OFFER_TYPE == 2){
						echo "OFFER 2 CHECK QTY EXCESS THE MAX OFFER ELIGIBLE QTY";
						echo "<br>";
						echo "ELSE PART OFFER TYPE 2 LOOP 2";
						echo "<br>";
						//exit();
						//Flat Discount
						$check_shop_order_product_offer_count = commonNOOFROWS_COUNT('js_shop_order_item',"`pd_id`='$PRDT_ID' and `od_session`='$current_SESSION_ID' and `variant_id` = '$variant_ID'");

						if($check_shop_order_product_offer_count == '0'){
							$total_CART_ADDED_QTY_WITHOUT_OFFER_QTY = get_OD_QTY_FROM_SESSION($PRDT_ID, $current_SESSION_ID, $variant_ID, 'get_total_cart_od_qty_without_offer_qty');
							$updated_final_QTY = ($total_CART_ADDED_QTY_WITHOUT_OFFER_QTY+$product_qty);
							$get_auto_eligible_offer_ID = get_OFFER_ELIGIBILITY_ID($updated_final_QTY, $PRDT_ID, 'get_auto_assign_offer_id_based_on_bulk_qty');
							$get_auto_eligible_offer_TYPE = get_OFFER_ELIGIBILITY_ID($updated_final_QTY,$PRDT_ID, 'get_auto_assign_offer_type_based_on_bulk_qty');
							$get_max_buying_offer_QTY = getOFFERS($get_auto_eligible_offer_ID,'offer_qty');
							$get_eligible_FLAT_OFFER_PRICE = getOFFERS($get_auto_eligible_offer_ID,'offer_value');

							if($get_max_buying_offer_QTY == $updated_final_QTY){
								$__get_cart_id = getSINGLEDBVALUE('cart_id', " deleted = '0' and status = '1' and pd_id = '$PRDT_ID' and od_session = '$current_SESSION_ID'", 'js_shop_order_item', 'label');
								if($__get_cart_id != '' && $__get_cart_id != '0' && $__get_cart_id != 'N/A'){
									$get_manage_qty = $updated_final_QTY/$get_max_buying_offer_QTY;
									$get_eligible_FLAT_OFFER_ITEM_PRICE = ($get_eligible_FLAT_OFFER_PRICE/$updated_final_QTY);
									if($variant_taxtype == 'Y') {
										$taxsplit_price = ($get_eligible_FLAT_OFFER_ITEM_PRICE * ($variant_tax_value/100))/2;
										$total_price = ($get_eligible_FLAT_OFFER_ITEM_PRICE - ($taxsplit_price * 2));
									} else {
										$taxsplit_price = (($get_eligible_FLAT_OFFER_ITEM_PRICE * ($variant_tax_value/100))/2);
										$total_price = $get_eligible_FLAT_OFFER_ITEM_PRICE;
									}
								}
								if($__get_cart_id != '' && $__get_cart_id != '0' && $__get_cart_id != 'N/A'){
								echo "UPDATE `js_shop_order_item` SET `offer_id`='$get_auto_eligible_offer_ID', `offer_type`='$get_auto_eligible_offer_TYPE', `od_price` = '$total_price', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_user_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_user_id' and pd_id = '$PRDT_ID' and cart_id = '$__get_cart_id' and `offer_id` = '0' and `offer_type` = '0'";
								echo "<br>";
								$update_the_product_details = sqlQUERY_LABEL("UPDATE `js_shop_order_item` SET `offer_id`='$get_auto_eligible_offer_ID', `offer_type`='$get_auto_eligible_offer_TYPE', `od_price` = '$total_price', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_user_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_user_id' and pd_id = '$PRDT_ID' and cart_id = '$__get_cart_id' and `offer_id` = '0' and `offer_type` = '0'") or die(sqlERROR_LABEL());
								}
								if($variant_taxtype == 'Y') {
									$taxsplit_price = ($get_eligible_FLAT_OFFER_PRICE * ($variant_tax_value/100))/2;
									$total_price = ($get_eligible_FLAT_OFFER_PRICE - ($taxsplit_price * 2));
								} else {
									$taxsplit_price = (($get_eligible_FLAT_OFFER_PRICE * ($variant_tax_value/100))/2);
									$total_price = $get_eligible_FLAT_OFFER_PRICE;
								}
								
								echo "INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$updated_final_QTY', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1')";
								echo "<br>";
								$insert_without_offer_products = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`, `offer_id`, `offer_type`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$updated_final_QTY', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1', '$get_auto_eligible_offer_ID', '$get_auto_eligible_offer_TYPE')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
							} else {
								$newtotal_price = $variant_prdt_final_price * $product_qty;
								if($variant_taxtype == 'Y') {
									$taxsplit_price = ($newtotal_price * ($variant_tax_value/100))/2;
									$total_price = ($newtotal_price - ($taxsplit_price * 2));
								} else {
									$taxsplit_price = (($newtotal_price * ($variant_tax_value/100))/2);
									$total_price = $newtotal_price;
								}
								echo "INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$product_qty', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1')";
								echo "<br>";
								$insert_without_offer_products = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$product_qty', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
							}
						} else {
							$total_CART_ADDED_VARIANT_QTY_WITHOUT_OFFER_QTY = get_OD_QTY_FROM_SESSION($PRDT_ID, $current_SESSION_ID, $variant_ID, 'get_total_cart_variant_od_qty_without_offer_qty');
							$get_auto_eligible_offer_ID = get_OFFER_ELIGIBILITY_ID($updated_final_QTY, $PRDT_ID, 'get_auto_assign_offer_id_based_on_bulk_qty');
							$get_auto_eligible_offer_TYPE = get_OFFER_ELIGIBILITY_ID($updated_final_QTY,$PRDT_ID, 'get_auto_assign_offer_type_based_on_bulk_qty');
							$get_max_buying_offer_QTY = getOFFERS($get_auto_eligible_offer_ID,'offer_qty');
							$get_eligible_FLAT_OFFER_PRICE = getOFFERS($get_auto_eligible_offer_ID,'offer_value');
							$updated_final_QTY = ($total_CART_ADDED_VARIANT_QTY_WITHOUT_OFFER_QTY+$product_qty);
							if($variant_taxtype == 'Y') {
								$taxsplit_price = ($get_eligible_FLAT_OFFER_PRICE * ($variant_tax_value/100))/2;
								$total_price = ($get_eligible_FLAT_OFFER_PRICE - ($taxsplit_price * 2));
							} else {
								$taxsplit_price = (($get_eligible_FLAT_OFFER_PRICE * ($variant_tax_value/100))/2);
								$total_price = $get_eligible_FLAT_OFFER_PRICE;
							}
							echo "UPDATE `js_shop_order_item` SET  `od_qty`='$updated_final_QTY', `offer_id`='$get_auto_eligible_offer_ID', `offer_type`='$get_auto_eligible_offer_TYPE' WHERE createdby = '$logged_user_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_user_id' and pd_id = '$PRDT_ID' and variant_id = '$variant_ID' and `offer_id` != '0' and `offer_type` != '0'";
							echo "<br>";
							$update_the_without_offer_product_QTY = sqlQUERY_LABEL("UPDATE `js_shop_order_item` SET  `od_qty`='$updated_final_QTY', `offer_id`='$get_auto_eligible_offer_ID', `offer_type`='$get_auto_eligible_offer_TYPE' WHERE createdby = '$logged_user_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_user_id' and pd_id = '$PRDT_ID' and variant_id = '$variant_ID' and `offer_id` != '0' and `offer_type` != '0'") or die(sqlERROR_LABEL());
							
							if($get_auto_eligible_offer_ID != '' && $get_auto_eligible_offer_ID != '0'){
								$current_date_time =  date('Y-m-d H:i:s');
								echo "INSERT into `js_offer_eligibility` (`prdt_id`, `cart_id`, `offer_id`, `offer_type`, `od_session_id`, `createdby`, `createdon`, `status`) VALUES ('$PRDT_ID', '$inserted_cart_ID', '$get_auto_eligible_offer_ID', '$get_auto_eligible_offer_TYPE', '$current_SESSION_ID', '$logged_user_id', '$current_date_time','1')";
								echo "<br>";
								$insert_offer_eligibility = sqlQUERY_LABEL("INSERT into `js_offer_eligibility` (`prdt_id`, `cart_id`, `offer_id`, `offer_type`, `od_session_id`, `createdby`, `createdon`, `status`) VALUES ('$PRDT_ID', '$inserted_cart_ID', '$get_auto_eligible_offer_ID', '$get_auto_eligible_offer_TYPE', '$current_SESSION_ID', '$logged_user_id', '$current_date_time','1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
							}
						}
						//exit();
					} else if($_PRDT_OFFER_TYPE == 3){
						echo "ELSE PART OFFER TYPE 3 CHECK ONE";
						//exit();
						//Percenatge
						$total_CART_ADDED_VARIANT_QTY_WITHOUT_OFFER_QTY = get_OD_QTY_FROM_SESSION($PRDT_ID, $current_SESSION_ID, $variant_ID, 'get_total_cart_variant_od_qty_without_offer_qty');
						$updated_final_QTY = ($total_CART_ADDED_VARIANT_QTY_WITHOUT_OFFER_QTY+$product_qty);
						$get_auto_eligible_offer_ID = get_OFFER_ELIGIBILITY_ID($updated_final_QTY, $PRDT_ID, 'get_auto_assign_offer_id_based_on_bulk_qty');
						$get_auto_eligible_offer_TYPE = get_OFFER_ELIGIBILITY_ID($updated_final_QTY,$PRDT_ID, 'get_auto_assign_offer_type_based_on_bulk_qty');
						$get_max_buying_offer_QTY = getOFFERS($get_auto_eligible_offer_ID,'offer_qty');
						$get_eligible_FLAT_OFFER_PERCENTAGE = getOFFERS($get_auto_eligible_offer_ID,'offer_value');
						$WITHOUT_FLAT_OFFER_PERCENTAGE = ($updated_final_QTY - $get_max_buying_offer_QTY);
						echo $get_auto_eligible_offer_ID;
						//exit();
						$remove_exisiting_added_offer_QTY = sqlQUERY_LABEL("DELETE FROM `js_shop_order_item` WHERE `od_session` = '$current_SESSION_ID' and `pd_id` = '$PRDT_ID' and `offer_id` != '0'") or die(sqlERROR_LABEL());
						$newtotal_price = ($variant_prdt_final_price * $updated_final_QTY);
						$TOTAL_DISCOUNT_VALUE = (($newtotal_price * $get_eligible_FLAT_OFFER_PERCENTAGE)/100);
						if($variant_taxtype == 'Y') {
							$taxsplit_price = ($newtotal_price * ($variant_tax_value/100))/2;
							$total_price = ($newtotal_price - ($taxsplit_price* 2));
						} else {
							$taxsplit_price = (($newtotal_price * ($variant_tax_value/100))/2);
							$total_price = $newtotal_price;
						}
						
						$check_shop_order_product_count = commonNOOFROWS_COUNT('js_shop_order_item',"`pd_id`='$PRDT_ID' and `od_session`='$current_SESSION_ID' and `variant_id` = '$variant_ID'");
						if($check_shop_order_product_count == '0'){
							if($get_auto_eligible_offer_ID != '' && $get_auto_eligible_offer_ID != '0'){
								$insert_offer_products = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`offer_id`, `offer_type`, `od_item_discount`, `createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$get_auto_eligible_offer_ID', '$get_auto_eligible_offer_TYPE', '$TOTAL_DISCOUNT_VALUE', '$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$updated_final_QTY', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
							} else {
								$insert_offer_products = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$updated_final_QTY', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
							}
						} else {
							if($get_auto_eligible_offer_ID != '' && $get_auto_eligible_offer_ID != '0'){
								$update_FLAT_OFFER_ITEM = sqlQUERY_LABEL("UPDATE `js_shop_order_item` SET `offer_id` = '$get_auto_eligible_offer_ID', `offer_type` = '$get_auto_eligible_offer_TYPE', `od_item_discount` = '$TOTAL_DISCOUNT_VALUE', `od_price` = '$total_price', `od_qty`='$updated_final_QTY', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_customer_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_customer_id' and pd_id = '$PRDT_ID' and `offer_id` = '0' and `offer_type` = '0'") or die(sqlERROR_LABEL());
								$message = "Cart updated...!!!";
							} else {
								$update_FLAT_OFFER_ITEM = sqlQUERY_LABEL("UPDATE `js_shop_order_item` SET  `od_price` = '$total_price', `od_qty`='$updated_final_QTY', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_customer_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_customer_id' and pd_id = '$PRDT_ID' and `offer_id` = '0' and `offer_type` = '0'") or die(sqlERROR_LABEL());
							}
						}
					}
					} else if ($product_qty > 0 && $check_product_offer_eligibility_count == 1){
						echo "OFFER AVAILABILITY CHECK IF STATEMENT";
						echo "<br>";
						//exit();
						$get_selected_product_offers = sqlQUERY_LABEL("select `offer_eligible_ID`, `offer_id`, `offer_type` FROM `js_offer_eligibility` where `prdt_id`='$PRDT_ID' and `od_session_id`='$current_SESSION_ID' and `status` = '1' and `deleted` = '0'") or die(sqlERROR_LABEL());
						while($fetch_product_offer_id = sqlFETCHARRAY_LABEL($get_selected_product_offers)) {
							$offer_eligible_ID = $fetch_product_offer_id['offer_eligible_ID'];
							$offer_ID = $fetch_product_offer_id['offer_id'];
							$offer_TYPE = $fetch_product_offer_id['offer_type'];
						}
						if($offer_TYPE == '1'){
							//BOGO OFFER - STARTED
							echo "BOGO OFFER TYPE 1";
							//exit();
							$get_eligible_OFFERT_QTY = get_OFFER_ELIGIBILITY_ID($offer_ID, $PRDT_ID, 'get_offer_qty');

							$get_offer_added_item_OFFER_ID = get_OD_QTY_FROM_SESSION($PRDT_ID, $current_SESSION_ID, 'get_added_offer_product_offer_id');
							
							$remove_exisiting_added_offer_QTY = sqlQUERY_LABEL("DELETE FROM `js_shop_order_item` WHERE `offer_id` = '$get_offer_added_item_OFFER_ID' and `od_session` = '$current_SESSION_ID' and `pd_id` = '$PRDT_ID' and `offer_id` != '0'") or die(sqlERROR_LABEL());

							$insert_offer_products = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`, `pd_id`, `variant_id`, `offer_id`, `offer_type`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$offer_ID', '$offer_TYPE', '$logged_user_id', '$current_SESSION_ID', '$get_eligible_OFFERT_QTY', '0', '0', '0', '0', '0','1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());

							$update_the_applied_offer_id_deleted_sttaus = sqlQUERY_LABEL("UPDATE `js_offer_eligibility` SET `deleted` = '1' WHERE `offer_eligible_ID` = '$offer_eligible_ID'") or die(sqlERROR_LABEL());
						}
					} else {
						echo "SOMETHING NEW STATEMENT CHECK IN IF STATEMENT";
						//exit();
					}
				} else {
					?>
					<script type="text/javascript">window.location = 'product.php?token=<?php echo $token; ?>&prdt_error=outofstock2' </script>
					<?php
				}
			} else {
				echo "VARIANT PRODUCT COUNT GREATER THAN ZERO STATMENT";
				echo "<br>";
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
					echo "MAIN ELSE PART VARIANT PRODUCT COUNT GREATER THAN ZERO STOCK CHECKING STATMENT";
					echo "<br>";
					//exit();
				$check_product_offer_eligibility_count = commonNOOFROWS_COUNT('js_offer_eligibility',"`prdt_id`='$PRDT_ID' and `od_session_id`='$current_SESSION_ID' and `status` = '1' and `deleted` = '0'");
				echo $check_product_offer_eligibility_count;
				echo "<br>";
				//exit();
				if($quantity == 1 && $check_product_offer_eligibility_count == 0){
					echo "MAIN ELSE PART PRODUCT COUNT 1 AND OFFERS 0 STATMENT";
					echo "<br>";
					//exit();
					$total_CART_ADDED_VARIANT_QTY_WITHOUT_OFFER_QTY = get_OD_QTY_FROM_SESSION($PRDT_ID, $current_SESSION_ID, $variant_ID, 'get_total_cart_variant_od_qty_without_offer_qty');
					$updated_final_QTY = ($total_CART_ADDED_VARIANT_QTY_WITHOUT_OFFER_QTY+$quantity);
					$get_auto_eligible_offer_ID = get_OFFER_ELIGIBILITY_ID($updated_final_QTY, $PRDT_ID, 'get_auto_assign_offer_id_based_on_bulk_qty');
					$get_auto_eligible_offer_TYPE = get_OFFER_ELIGIBILITY_ID($updated_final_QTY,$PRDT_ID, 'get_auto_assign_offer_type_based_on_bulk_qty');

					$check_shop_order_product_count = commonNOOFROWS_COUNT('js_shop_order_item',"`pd_id`='$PRDT_ID' and `od_session`='$current_SESSION_ID' and `variant_id` = '$variant_ID'");

					$newtotal_price = ($old_total_price * $updated_final_QTY);
					if($variant_taxtype == 'Y') {
						$taxsplit_price = ($newtotal_price * ($variant_tax_value/100))/2;
						$total_price = ($newtotal_price - ($taxsplit_price* 2));
					} else {
						$taxsplit_price = (($newtotal_price * ($variant_tax_value/100))/2);
						$total_price = $newtotal_price;
					}
					if($check_shop_order_product_count == '0'){
					echo "MAIN ELSE PART PRODUCT COUNT 0 STATMENT @ SHOP ORDER ITEM";
					echo "<br>";
					//exit();
					echo "INSERT into `js_shop_order_item` (`createdby`, `pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$updated_final_QTY', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price','1')";
					echo "<br>";
						$insert_without_offer_products = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`, `pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$updated_final_QTY', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price','1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
						$message = "Cart added...!!!";
						$inserted_cart_ID = sqlINSERTID_LABEL();
					} else {
					echo "MAIN ELSE PART PRODUCT COUNT GREATER THAN ZERO STATMENT @ SHOP ORDER ITEM";
					echo "<br>";
					//exit();
					echo "UPDATE `js_shop_order_item` SET `od_price` = '$total_price', `od_qty`='$updated_final_QTY', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_user_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_user_id' and pd_id = '$PRDT_ID' and variant_id = '$variant_ID' and `offer_id` = '0' and `offer_type` = '0'";
					echo "<br>";
						$update_the_without_offer_product_QTY = sqlQUERY_LABEL("UPDATE `js_shop_order_item` SET `od_price` = '$total_price', `od_qty`='$updated_final_QTY', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_user_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_user_id' and pd_id = '$PRDT_ID' and variant_id = '$variant_ID' and `offer_id` = '0' and `offer_type` = '0'") or die(sqlERROR_LABEL());
						$message = "Cart updated...!!!";
					}
					echo "MAIN ELSE PART UPDATE OFFER ELIGIPLITY DATA";
					echo "<br>";
					//////exit();
					$current_date_time = date('Y-m-d H:i:s');
					echo "DELETE FROM `js_offer_eligibility` WHERE `od_session_id` = '$current_SESSION_ID' and `prdt_id` = '$PRDT_ID' and `deleted` = '0'";
					echo "<br>";
					$remove_exisiting_added_offer_QTY = sqlQUERY_LABEL("DELETE FROM `js_offer_eligibility` WHERE `od_session_id` = '$current_SESSION_ID' and `prdt_id` = '$PRDT_ID' and `deleted` = '0'") or die(sqlERROR_LABEL());
					echo "INSERT into `js_offer_eligibility` (`prdt_id`, `cart_id`, `offer_id`, `offer_type`, `od_session_id`, `createdby`, `createdon`, `status`) VALUES ('$PRDT_ID', '$inserted_cart_ID', '$get_auto_eligible_offer_ID', '$get_auto_eligible_offer_TYPE', '$current_SESSION_ID', '$logged_user_id', '$current_date_time','1')";
					echo "<br>";
					$insert_offer_eligibility = sqlQUERY_LABEL("INSERT into `js_offer_eligibility` (`prdt_id`, `cart_id`, `offer_id`, `offer_type`, `od_session_id`, `createdby`, `createdon`, `status`) VALUES ('$PRDT_ID', '$inserted_cart_ID', '$get_auto_eligible_offer_ID', '$get_auto_eligible_offer_TYPE', '$current_SESSION_ID', '$logged_user_id', '$current_date_time','1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
					//exit();
				} else if($quantity > 1 && $check_product_offer_eligibility_count == 0){
					echo "MAIN ELSE PART PRODUCT QTY GREATER THEN 1 AND OFFERS 0 STATMENT";
					echo "<br>";
					//exit();
					//$total_CART_ADDED_VARIANT_QTY_WITHOUT_OFFER_QTY = get_OD_QTY_FROM_SESSION($PRDT_ID, $current_SESSION_ID, $variant_ID, 'get_total_cart_variant_od_qty_without_offer_qty');
					$_PRDT_OFFER_TYPE = get_OFFER_ELIGIBILITY_ID($updated_final_QTY,$PRDT_ID, 'get_prdt_offer_type');

					echo $_PRDT_OFFER_TYPE;
					echo "<br>";
					//exit();
					if($_PRDT_OFFER_TYPE == 1){
					//BOGO OFFER - STARTED
					$updated_final_QTY = ($quantity);
					$get_auto_eligible_offer_ID = get_OFFER_ELIGIBILITY_ID($updated_final_QTY, $PRDT_ID, 'get_auto_assign_offer_id_based_on_bulk_qty');
					$get_auto_eligible_offer_TYPE = get_OFFER_ELIGIBILITY_ID($updated_final_QTY,$PRDT_ID, 'get_auto_assign_offer_type_based_on_bulk_qty');
					echo "MAIN ELSE PART CHECK OFFERS TYPE 1";
					echo "<br>";
						$get_max_buying_offer_QTY = getOFFERS($get_auto_eligible_offer_ID,'offer_qty');
						$get_eligible_offer_QTY = getOFFERS($get_auto_eligible_offer_ID,'offer_value');
						$WITHOUT_OFFER_QTY = ($updated_final_QTY - $get_eligible_offer_QTY);
						if($updated_final_QTY > $get_max_buying_offer_QTY){
							echo "true";
						} else {
							echo "false";
						}
					echo "$updated_final_QTY > $get_max_buying_offer_QTY";
					echo "<br>";
					//exit();
						if($updated_final_QTY > $get_max_buying_offer_QTY){
					
							$remove_exisiting_added_offer_QTY = sqlQUERY_LABEL("DELETE FROM `js_shop_order_item` WHERE `od_session` = '$current_SESSION_ID' and `pd_id` = '$PRDT_ID' and `offer_id` != '0'") or die(sqlERROR_LABEL());

							echo "MAIN ELSE PART CHECK QTY EXCESS THE MAX OFFER ELIGIBLE QTY";
							echo "<br>";
							//exit();
							if($WITHOUT_OFFER_QTY){
								echo "MAIN ELSE PART CHECK WITHOUT OFFER QTY AVAILABLE";
								echo "<br>";
								//exit();
								$newtotal_price = $old_total_price * $WITHOUT_OFFER_QTY;
								if($variant_taxtype == 'Y') {
									$taxsplit_price = ($newtotal_price * ($variant_tax_value/100))/2;
									$total_price = ($newtotal_price - ($taxsplit_price * 2));
								} else {
									$taxsplit_price = (($newtotal_price * ($variant_tax_value/100))/2);
									$total_price = $newtotal_price;
								}
								$check_shop_order_product_count = commonNOOFROWS_COUNT('js_shop_order_item',"`pd_id`='$PRDT_ID' and `od_session`='$current_SESSION_ID' and `variant_id` = '$variant_ID'");
								if($check_shop_order_product_count == '0'){
									echo "INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$WITHOUT_OFFER_QTY', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1')";
									echo "<br>";
									$insert_without_offer_products = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$WITHOUT_OFFER_QTY', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
								} else {
									echo "UPDATE `js_shop_order_item` SET `od_price` = '$total_price', `od_qty`='$WITHOUT_OFFER_QTY', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_user_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_user_id' and pd_id = '$PRDT_ID' and variant_id = '$variant_ID' and `offer_id` = '0' and `offer_type` = '0'";
									echo "<br>";
									$update_the_without_offer_product_QTY = sqlQUERY_LABEL("UPDATE `js_shop_order_item` SET `od_price` = '$total_price', `od_qty`='$WITHOUT_OFFER_QTY', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_user_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_user_id' and pd_id = '$PRDT_ID' and variant_id = '$variant_ID' and `offer_id` = '0' and `offer_type` = '0'") or die(sqlERROR_LABEL());
								}
							}
							if($get_eligible_offer_QTY){
								$check_shop_order_product_offer_count = commonNOOFROWS_COUNT('js_shop_order_item',"`pd_id`='$PRDT_ID' and `od_session`='$current_SESSION_ID' and `variant_id` = '$variant_ID' and `offer_id` != '0'");
								if($check_shop_order_product_offer_count == '0'){
									echo "INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`, `offer_id`, `offer_type`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$get_eligible_offer_QTY', '0', '0', '0', '0', '0', '1', '$get_auto_eligible_offer_ID', '$get_auto_eligible_offer_TYPE')";
									echo "<br>";
									$insert_offer_products = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`, `offer_id`, `offer_type`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$get_eligible_offer_QTY', '0', '0', '0', '0', '0', '1', '$get_auto_eligible_offer_ID', '$get_auto_eligible_offer_TYPE')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
								} else {
									echo "UPDATE `js_shop_order_item` SET  `od_qty`='$get_eligible_offer_QTY', `offer_id`='$get_auto_eligible_offer_ID', `offer_type`='$get_auto_eligible_offer_TYPE' WHERE createdby = '$logged_user_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_user_id' and pd_id = '$PRDT_ID' and variant_id = '$variant_ID' and `offer_id` != '0' and `offer_type` != '0'";
									echo "<br>";
									$update_the_without_offer_product_QTY = sqlQUERY_LABEL("UPDATE `js_shop_order_item` SET  `od_qty`='$get_eligible_offer_QTY', `offer_id`='$get_auto_eligible_offer_ID', `offer_type`='$get_auto_eligible_offer_TYPE' WHERE createdby = '$logged_user_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_user_id' and pd_id = '$PRDT_ID' and variant_id = '$variant_ID' and `offer_id` != '0' and `offer_type` != '0'") or die(sqlERROR_LABEL());
								}
							}
							//exit();
						} else {
							echo "MAIN ELSE PART CHECK QTY CANNOT EXCESS THE MAX OFFER ELIGIBLE QTY";
							echo "<br>";
							//exit();
							$newtotal_price = $old_total_price * $updated_final_QTY;
							if($variant_taxtype == 'Y') {
								$taxsplit_price = ($newtotal_price * ($variant_tax_value/100))/2;
								$total_price = ($newtotal_price - ($taxsplit_price * 2));
							} else {
								$taxsplit_price = (($newtotal_price * ($variant_tax_value/100))/2);
								$total_price = $newtotal_price;
							}
							
							$check_shop_order_product_count = commonNOOFROWS_COUNT('js_shop_order_item',"`pd_id`='$PRDT_ID' and `od_session`='$current_SESSION_ID' and `variant_id` = '$variant_ID'");
							echo $check_shop_order_product_count;
							//exit();
							if($check_shop_order_product_count == '0'){
								echo "MAIN ELSE PART CHECK QTY CANNOT EXCESS THE MAX OFFER ELIGIBLE QTY SHOP ORDER COUNT 0";
								echo "<br>";
								//exit();
								echo "INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$updated_final_QTY', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1')";
								$insert_without_offer_product_QTY = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$updated_final_QTY', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
							} else {
								echo "<br>";
								echo "MAIN ELSE PART CHECK QTY CANNOT EXCESS THE MAX OFFER ELIGIBLE QTY SHOP ORDER COUNT GREATER THEN 0";
								echo "<br>";
								//exit();
								echo "UPDATE `js_shop_order_item` SET `od_price` = '$total_price', `od_qty`='$updated_final_QTY', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_user_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_user_id' and pd_id = '$PRDT_ID' and variant_id = '$variant_ID' and `offer_id` = '0' and `offer_type` = '0'";
								echo "<br>";
								$update_the_without_offer_product_QTY = sqlQUERY_LABEL("UPDATE `js_shop_order_item` SET `od_price` = '$total_price', `od_qty`='$updated_final_QTY', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_user_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_user_id' and pd_id = '$PRDT_ID' and variant_id = '$variant_ID' and `offer_id` = '0' and `offer_type` = '0'") or die(sqlERROR_LABEL());
								$message = "Cart updated...!!!";
							}
							$total_CART_ADDED_WIHOUT_SELECTED_VARIANT_QTY_WITHOUT_OFFER_QTY = get_OD_QTY_FROM_SESSION($PRDT_ID, $current_SESSION_ID, $variant_ID, 'get_total_cart_without_selected_variant_od_qty_without_offer_qty');
							$UPDATED_FINAL_QTY = ($total_CART_ADDED_WIHOUT_SELECTED_VARIANT_QTY_WITHOUT_OFFER_QTY+$updated_final_QTY);
							$get_auto_eligible_offer_ID = get_OFFER_ELIGIBILITY_ID($UPDATED_FINAL_QTY, $PRDT_ID, 'get_auto_assign_offer_id_based_on_bulk_qty');
							$get_auto_eligible_offer_TYPE = get_OFFER_ELIGIBILITY_ID($UPDATED_FINAL_QTY,$PRDT_ID, 'get_auto_assign_offer_type_based_on_bulk_qty');

							$check_shop_order_product_offer_already_applied = commonNOOFROWS_COUNT('js_shop_order_item',"`pd_id`='$PRDT_ID' and `od_session`='$current_SESSION_ID' and `offer_id` = '$get_auto_eligible_offer_ID'");

							if($get_auto_eligible_offer_ID != '' && $get_auto_eligible_offer_ID != '0' && $check_shop_order_product_offer_already_applied == 0){
								$remove_exisiting_added_offer_QTY = sqlQUERY_LABEL("DELETE FROM `js_shop_order_item` WHERE `od_session` = '$current_SESSION_ID' and `pd_id` = '$PRDT_ID' and `offer_id` != '0'") or die(sqlERROR_LABEL());

								$current_date_time =  date('Y-m-d H:i:s');
								echo "INSERT into `js_offer_eligibility` (`prdt_id`, `cart_id`, `offer_id`, `offer_type`, `od_session_id`, `createdby`, `createdon`, `status`) VALUES ('$PRDT_ID', '$inserted_cart_ID', '$get_auto_eligible_offer_ID', '$get_auto_eligible_offer_TYPE', '$current_SESSION_ID', '$logged_user_id', '$current_date_time','1')";
								echo "<br>";
								$insert_offer_eligibility = sqlQUERY_LABEL("INSERT into `js_offer_eligibility` (`prdt_id`, `cart_id`, `offer_id`, `offer_type`, `od_session_id`, `createdby`, `createdon`, `status`) VALUES ('$PRDT_ID', '$inserted_cart_ID', '$get_auto_eligible_offer_ID', '$get_auto_eligible_offer_TYPE', '$current_SESSION_ID', '$logged_user_id', '$current_date_time','1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
							}
						}
						//exit();
					} else if($_PRDT_OFFER_TYPE == 2){
						echo "ELSE PART OFFER TYPE 2";
						echo "<br>";
						echo $quantity;
						//exit();
						//Flat Discount
						$updated_final_QTY = ($quantity);
						$get_auto_eligible_offer_ID = get_OFFER_ELIGIBILITY_ID($updated_final_QTY, $PRDT_ID, 'get_auto_assign_offer_id_based_on_bulk_qty');
						$get_auto_eligible_offer_TYPE = get_OFFER_ELIGIBILITY_ID($updated_final_QTY,$PRDT_ID, 'get_auto_assign_offer_type_based_on_bulk_qty');
						$get_max_buying_offer_QTY = getOFFERS($get_auto_eligible_offer_ID,'offer_qty');
						$get_eligible_FLAT_OFFER_PRICE = getOFFERS($get_auto_eligible_offer_ID,'offer_value');
						$WITHOUT_FLAT_OFFER_QTY = ($updated_final_QTY - $get_max_buying_offer_QTY);
						
						//$remove_exisiting_added_offer_QTY = sqlQUERY_LABEL("DELETE FROM `js_shop_order_item` WHERE `od_session` = '$current_SESSION_ID' and `pd_id` = '$PRDT_ID'") or die(sqlERROR_LABEL());
						
						echo "$updated_final_QTY > $get_max_buying_offer_QTY";
						//exit();
						if($updated_final_QTY > $get_max_buying_offer_QTY){
							echo "OFFER 2 ELSE PART CHECK QTY EXCESS THE MAX OFFER ELIGIBLE QTY CHECK ONE";
							echo "<br>";
							//exit();
							if($WITHOUT_FLAT_OFFER_QTY){
								echo "OFFER 2 ELSE PART CHECK WITHOUT OFFER QTY AVAILABLE CHECK ONE";
								echo "<br>";
								//exit();
								$newtotal_price = ($old_total_price * $WITHOUT_FLAT_OFFER_QTY);
								if($variant_taxtype == 'Y') {
									$taxsplit_price = ($newtotal_price * ($variant_tax_value/100))/2;
									$total_price = ($newtotal_price - ($taxsplit_price* 2));
								} else {
									$taxsplit_price = (($newtotal_price * ($variant_tax_value/100))/2);
									$total_price = $newtotal_price;
								}
								echo "INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$WITHOUT_FLAT_OFFER_QTY', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1')";
								echo "<br>";
								$insert_offer_products = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$WITHOUT_FLAT_OFFER_QTY', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
							}
							if($variant_taxtype == 'Y') {
								$taxsplit_price = ($get_eligible_FLAT_OFFER_PRICE * ($variant_tax_value/100))/2;
								$total_price = ($get_eligible_FLAT_OFFER_PRICE - ($taxsplit_price * 2));
							} else {
								$taxsplit_price = (($get_eligible_FLAT_OFFER_PRICE * ($variant_tax_value/100))/2);
								$total_price = $get_eligible_FLAT_OFFER_PRICE;
							}
							echo "INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`, `offer_id`, `offer_type`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$get_max_buying_offer_QTY', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1', '$get_auto_eligible_offer_ID', '$get_auto_eligible_offer_TYPE')";
							echo "<br>";
							$insert_offer_products = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`, `offer_id`, `offer_type`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$get_max_buying_offer_QTY', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1', '$get_auto_eligible_offer_ID', '$get_auto_eligible_offer_TYPE')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
						} else {
							echo "sefef";
							//exit();
							$newtotal_price = ($old_total_price * $updated_final_QTY);
							if($variant_taxtype == 'Y') {
								$taxsplit_price = ($newtotal_price * ($variant_tax_value/100))/2;
								$total_price = ($newtotal_price - ($taxsplit_price* 2));
							} else {
								$taxsplit_price = (($newtotal_price * ($variant_tax_value/100))/2);
								$total_price = $newtotal_price;
							}
							$check_shop_order_product_count = commonNOOFROWS_COUNT('js_shop_order_item',"`pd_id`='$PRDT_ID' and `od_session`='$current_SESSION_ID' and `variant_id` = '$variant_ID'");
							echo $check_shop_order_product_count;
							//exit();
							if($check_shop_order_product_count == '0'){
								echo "INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$updated_final_QTY', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1')";
								echo "<br>";
								$insert_offer_products = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`,`pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$updated_final_QTY', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price', '1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
							} else {
								echo "UPDATE `js_shop_order_item` SET `od_price` = '$total_price', `od_qty`='$updated_final_QTY', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_user_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_user_id' and pd_id = '$PRDT_ID' and variant_id = '$variant_ID' and `offer_id` = '0' and `offer_type` = '0'";
								echo "<br>";
								$update_the_without_offer_product_QTY = sqlQUERY_LABEL("UPDATE `js_shop_order_item` SET `od_price` = '$total_price', `od_qty`='$updated_final_QTY', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_user_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_user_id' and pd_id = '$PRDT_ID' and variant_id = '$variant_ID' and `offer_id` = '0' and `offer_type` = '0'") or die(sqlERROR_LABEL());
								$message = "Cart Update..";
							}
							if($get_auto_eligible_offer_ID != '' && $get_auto_eligible_offer_ID != '0'){
								$current_date_time =  date('Y-m-d H:i:s');
								echo "INSERT into `js_offer_eligibility` (`prdt_id`, `cart_id`, `offer_id`, `offer_type`, `od_session_id`, `createdby`, `createdon`, `status`) VALUES ('$PRDT_ID', '$inserted_cart_ID', '$get_auto_eligible_offer_ID', '$get_auto_eligible_offer_TYPE', '$current_SESSION_ID', '$logged_user_id', '$current_date_time','1')";
								echo "<br>";
								$insert_offer_eligibility = sqlQUERY_LABEL("INSERT into `js_offer_eligibility` (`prdt_id`, `cart_id`, `offer_id`, `offer_type`, `od_session_id`, `createdby`, `createdon`, `status`) VALUES ('$PRDT_ID', '$inserted_cart_ID', '$get_auto_eligible_offer_ID', '$get_auto_eligible_offer_TYPE', '$current_SESSION_ID', '$logged_user_id', '$current_date_time','1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
							}
							//exit();
						}
						
					} else if($_PRDT_OFFER_TYPE == 3){
						echo "ELSE PART OFFER TYPE 3";
						echo "<br>";
						//exit();
						//Percenatge
						$updated_final_QTY = ($quantity);
						$get_auto_eligible_offer_ID = get_OFFER_ELIGIBILITY_ID($updated_final_QTY, $PRDT_ID, 'get_auto_assign_offer_id_based_on_bulk_qty');
						$get_auto_eligible_offer_TYPE = get_OFFER_ELIGIBILITY_ID($updated_final_QTY,$PRDT_ID, 'get_auto_assign_offer_type_based_on_bulk_qty');
						$get_max_buying_offer_QTY = getOFFERS($get_auto_eligible_offer_ID,'offer_qty');
						$get_eligible_FLAT_OFFER_PERCENTAGE = getOFFERS($get_auto_eligible_offer_ID,'offer_value');
						$WITHOUT_FLAT_OFFER_PERCENTAGE = ($updated_final_QTY - $get_max_buying_offer_QTY);
						echo $get_auto_eligible_offer_ID;
						//exit();
						$remove_exisiting_added_offer_QTY = sqlQUERY_LABEL("DELETE FROM `js_shop_order_item` WHERE `od_session` = '$current_SESSION_ID' and `pd_id` = '$PRDT_ID' and `offer_id` != '0'") or die(sqlERROR_LABEL());
						$newtotal_price = ($old_total_price * $updated_final_QTY);
						$TOTAL_DISCOUNT_VALUE = (($newtotal_price * $get_eligible_FLAT_OFFER_PERCENTAGE)/100);
						if($variant_taxtype == 'Y') {
							$taxsplit_price = ($newtotal_price * ($variant_tax_value/100))/2;
							$total_price = ($newtotal_price - ($taxsplit_price* 2));
						} else {
							$taxsplit_price = (($newtotal_price * ($variant_tax_value/100))/2);
							$total_price = $newtotal_price;
						}

						if($get_auto_eligible_offer_ID != '' && $get_auto_eligible_offer_ID != '0'){
							$update_FLAT_OFFER_ITEM = sqlQUERY_LABEL("UPDATE `js_shop_order_item` SET `offer_id` = '$get_auto_eligible_offer_ID', `offer_type` = '$get_auto_eligible_offer_TYPE', `od_item_discount` = '$TOTAL_DISCOUNT_VALUE', `od_price` = '$total_price', `od_qty`='$quantity', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_customer_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_customer_id' and pd_id = '$PRDT_ID' and `offer_id` = '0' and `offer_type` = '0'") or die(sqlERROR_LABEL());
							$message = "Cart updated...!!!";
						} else {
							$update_FLAT_OFFER_ITEM = sqlQUERY_LABEL("UPDATE `js_shop_order_item` SET  `od_price` = '$total_price', `od_qty`='$quantity', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_customer_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_customer_id' and pd_id = '$PRDT_ID' and `offer_id` = '0' and `offer_type` = '0'") or die(sqlERROR_LABEL());
						}
					}
					//exit();
				} else if ($quantity > 0 && $check_product_offer_eligibility_count == 1){
					echo "OFFER AVAILABILITY CHECK";
					echo "<br>";
					//exit();
					$get_selected_product_offers = sqlQUERY_LABEL("select `offer_eligible_ID`, `offer_id`, `offer_type` FROM `js_offer_eligibility` where `prdt_id`='$PRDT_ID' and `od_session_id`='$current_SESSION_ID' and `status` = '1' and `deleted` = '0'") or die(sqlERROR_LABEL());
					while($fetch_product_offer_id = sqlFETCHARRAY_LABEL($get_selected_product_offers)) {
						$offer_eligible_ID = $fetch_product_offer_id['offer_eligible_ID'];
								$offer_ID = $fetch_product_offer_id['offer_id'];
						$offer_TYPE = $fetch_product_offer_id['offer_type'];
					}
					if($offer_TYPE == '1'){
						//BOGO OFFER - STARTED
						echo "OFFER COUNT AVAIL AND OFFER TYPE 1";
						//exit();
						$get_eligible_OFFERT_QTY = get_OFFER_ELIGIBILITY_ID($offer_ID, $PRDT_ID, 'get_offer_qty');

						$get_offer_added_item_OFFER_ID = get_OD_QTY_FROM_SESSION($PRDT_ID, $current_SESSION_ID, '', 'get_added_offer_product_offer_id');

						$remove_exisiting_added_offer_QTY = sqlQUERY_LABEL("DELETE FROM `js_shop_order_item` WHERE `offer_id` = '$get_offer_added_item_OFFER_ID' and `od_session` = '$current_SESSION_ID' and `pd_id` = '$PRDT_ID' and `offer_id` != '0'") or die(sqlERROR_LABEL());

						$insert_offer_products = sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`, `pd_id`, `variant_id`, `offer_id`, `offer_type`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id','$PRDT_ID', '$variant_ID', '$offer_ID', '$offer_TYPE', '$logged_user_id', '$current_SESSION_ID', '$get_eligible_OFFERT_QTY', '0', '0', '0', '0', '0','1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());

						$update_the_applied_offer_id_deleted_sttaus = sqlQUERY_LABEL("UPDATE `js_offer_eligibility` SET `deleted` = '1' WHERE `offer_eligible_ID` = '$offer_eligible_ID'") or die(sqlERROR_LABEL());

					} else if($offer_TYPE == '3'){
						echo "OFFER COUNT AVAIL AND OFFER TYPE 3";
						//exit();
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
						// //exit();
						if($get_eligible_FLAT_OFFER_PERCENTAGE){
							$update_FLAT_OFFER_ITEM = sqlQUERY_LABEL("UPDATE `js_shop_order_item` SET `offer_id` = '$offer_ID', `offer_type` = '$offer_TYPE', `od_item_discount` = '$TOTAL_DISCOUNT_VALUE', `od_price` = '$total_price', `od_qty`='$quantity', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_customer_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_customer_id' and pd_id = '$PRDT_ID' and `offer_id` = '0' and `offer_type` = '0'") or die(sqlERROR_LABEL());
							$message = "Cart updated...!!!";
						} else {
							$update_FLAT_OFFER_ITEM = sqlQUERY_LABEL("UPDATE `js_shop_order_item` SET `od_price` = '$total_price', `od_qty`='$quantity', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_customer_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_customer_id' and pd_id = '$PRDT_ID' and `offer_id` = '0' and `offer_type` = '0'") or die(sqlERROR_LABEL());
							$message = "Cart updated...!!!";
						}
						$update_the_applied_offer_id_deleted_sttaus = sqlQUERY_LABEL("UPDATE `js_offer_eligibility` SET `deleted` = '1' WHERE `offer_eligible_ID` = '$offer_eligible_ID'") or die(sqlERROR_LABEL());
					}
				} else {
					echo "SOMETHING NEW STATEMENT CHECK";
					//exit();
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
