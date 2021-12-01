<?php 

extract($_REQUEST);
include '../head/jackus.php';

//quickITEMS - searchCART
if($_GET['type'] == 'add_to_cart')
{
	$PRDT_ID = $product_id; // VIA AJAX CALL
	$current_SESSION_ID = $sid;  // VALUES RECEIVE FROM CONFIG.PHP
	$ESTORE_CODE = getPRDT_CODE($PRDT_ID,'','get_prdt_code');
	$check_product_variants = commonNOOFROWS_COUNT('js_productvariants',"parentproduct = '$PRDT_ID'");
	
	if($check_product_variants == 0){

	$featured_product_data = sqlQUERY_LABEL("SELECT `productID`, `productsellingprice`, `producttax`, `producttaxtype`  FROM `js_product` where productID='$PRDT_ID' and deleted = '0' and status = '1'") or die("#1-Unable to get records:".mysqli_error());
	  while($featured_data = sqlFETCHARRAY_LABEL($featured_product_data)){
		  $productID = $featured_data["productID"];
		  $productsellingprice = $featured_data["productsellingprice"];
		  $producttax = $featured_data["producttax"];
		  $producttaxtype = $featured_data["producttaxtype"];
	  }											
	
	if($PRDT_ID !='' && $current_SESSION_ID !=''){
		$check_selecteditem = sqlQUERY_LABEL("select `pd_id`, `od_colorid`, `od_size_id`, `od_qty`, `od_price`, `item_tax1`, `item_tax2` from js_shop_order_item where user_id = '$logged_customer_id' and od_session = '$current_SESSION_ID' and pd_id = '$PRDT_ID'") or die(sqlERROR_LABEL());
		
		if(sqlNUMOFROW_LABEL($check_selecteditem) == 0) {
			
			/////////////////////// ADD MAIN BILL
			
			$check_bill = sqlQUERY_LABEL("select `od_id`,`od_sesid` from js_shop_order where od_sesid = '$current_SESSION_ID' and od_userid = '$logged_customer_id'");
				if(sqlNUMOFROW_LABEL($check_bill) == 0) {
					$creating_new_billrecord = sqlQUERY_LABEL("INSERT into `js_shop_order` (`od_userid`, `od_sesid`,  `createdon`, `createdby`) VALUES ('$logged_customer_id', '$current_SESSION_ID', '".date('Y-m-d H:i:s')."', '$logged_customer_id')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
					$od_id = sqlINSERTID_LABEL();
				} else {
					while($collect_bill = sqlFETCHARRAY_LABEL($check_bill)) {
					$od_id = $collect_bill['od_id'];
					$od_sesid = $collect_bill['od_sesid'];
					}
				}

			if($producttaxtype == 'Y') {
				$taxsplit_price = ($productsellingprice * ($producttax/100))/2;
				$total_price = ($productsellingprice - ($taxsplit_price* 2));
			} else {
				$taxsplit_price = (($productsellingprice * ($producttax/100))/2);
				$total_price = $productsellingprice;
			}
			$product_qty = 1;

			///CHECK PRODUCT ESTORE STOCK VIA API
			$list_producttype_data = sqlQUERY_LABEL("select `productopeningstock`,`productavailablestock` from js_product where productsku = '$ESTORE_CODE'");
			$count_producttype_list = sqlNUMOFROW_LABEL($list_producttype_data);
				while($get_product_data = sqlFETCHARRAY_LABEL($list_producttype_data)) {
					$prdt_opening_qty = $get_product_data['productopeningstock'];
					$prdt_available_qty = $get_product_data['productavailablestock'];
				}

			///////////////////////		ADD BILL-ITEM
			// echo "INSERT into `js_shop_order_item` (`createdby`, `od_id`, `pd_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_customer_id', '$od_id', '$PRDT_ID', '$logged_customer_id', '$current_SESSION_ID', '$product_qty', '$total_price', '$producttaxtype', '$producttax', '$taxsplit_price', '$taxsplit_price','1')";
			// exit();
			if($product_qty <= $estore_prdt_available_qty){
				sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`, `od_id`, `pd_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_customer_id', '$od_id', '$PRDT_ID', '$logged_customer_id', '$current_SESSION_ID', '$product_qty', '$total_price', '$producttaxtype', '$producttax', '$taxsplit_price', '$taxsplit_price','1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
				$message = "Cart added...!!!";
				exit();
			} else {
				echo "<script>addITEMACTION(3);</script>";
				exit();
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
			$list_producttype_data = sqlQUERY_LABEL("select `productopeningstock`,`productavailablestock` from js_product where productsku = '$ESTORE_CODE'");
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
			if($quantity <= $estore_prdt_available_qty){
				sqlQUERY_LABEL("UPDATE `js_shop_order_item` SET `od_price` = '$newtotal_price', `od_qty`='$quantity', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_customer_id' and od_session = '$current_SESSION_ID' and user_id = '$logged_customer_id' and pd_id = '$PRDT_ID'") or die(sqlERROR_LABEL());
				$message = "Cart updated...!!!";
				exit();
			} else {
				echo "<script>addITEMACTION(3);</script>";
				exit();
			}
		}
	}			
	} else {

	$featured_product_data = sqlQUERY_LABEL("SELECT `variant_ID`, `parentproduct`, `variant_msp_price`, `variant_taxtype`, `variant_tax_value`, `variant_taxsplit1`, `variant_taxsplit2`  FROM `js_productvariants` where parentproduct='$PRDT_ID' and variant_code = '' and deleted = '0' and status = '1'") or die("#1-Unable to get records:".mysqli_error());
	  while($featured_data = sqlFETCHARRAY_LABEL($featured_product_data)){
		  $variant_ID = $featured_data["variant_ID"];
		  $parentproduct = $featured_data["parentproduct"];
		  $variant_msp_price = $featured_data["variant_msp_price"];
		  $variant_taxtype = $featured_data["variant_taxtype"];
		  $variant_tax_value = $featured_data["variant_tax_value"];
		  $variant_taxsplit1 = $featured_data["variant_taxsplit1"];
		  $variant_taxsplit2 = $featured_data["variant_taxsplit2"];
	  }
		
	}

	$check_cart_item_list = commonNOOFROWS_COUNT('js_shop_order_item',"`user_id` = '$logged_customer_id' and status = '1' and deleted = '0'");

	?>
		<a class="block-link" href="cart.php">
			<span class="pe-7s-shopbag"></span>
			<span class="count"><?php echo $check_cart_item_list; ?></span>
		</a>
		
	<?php
}

	if($_GET['type'] == 'remove_item') {

		$cart_id = $_POST['cartID'];

		//$remove_branch_pr_id = mysql_query("UPDATE `oc_billitem` SET `billitem_deleted` = '1'  WHERE  billitemid = '$billitem_id'") or die(mysql_error());
		$remove_branch_pr_id =  sqlQUERY_LABEL("DELETE FROM js_shop_order_item WHERE cart_id = '$cart_id'")or die("There was a problem while deleting: ". sqlERROR_LABEL());
		//echo "Record Deleted";
	?>
		<script type="text/javascript">
			fetchcart_items_data();
			item_removed_from_cart();
			update_cart_data();
		</script>                      
	<?php
	}

	if($_GET['type'] == 'update_cart'){

		$check_cart_item_list = commonNOOFROWS_COUNT('js_shop_order_item',"`user_id` = '$logged_customer_id' and status = '1' and deleted = '0'");

	?>
		<a class="block-link" href="cart.php">
			<span class="pe-7s-shopbag"></span>
			<span class="count"><?php echo $check_cart_item_list; ?></span>
		</a>
		
	<?php
	}
	/*
	$list_producttype_data = sqlQUERY_LABEL("select `productopeningstock`,`productavailablestock` from js_product where productsku = '$ESTORE_CODE'");
			$count_producttype_list = sqlNUMOFROW_LABEL($list_producttype_data);
				while($get_product_data = sqlFETCHARRAY_LABEL($list_producttype_data)) {
					$prdt_opening_qty = $get_product_data['productopeningstock'];
					$prdt_available_qty = $get_product_data['productavailablestock'];
				}
	*/
	if($_GET['type'] == 'check_stock_status'){
		
		$variant_ID = $_POST['__variant_ID'];
		$variant_code = getVARIANT_CODE($variant_ID,'variant_code_from_variant_ID');
		if($variant_code){
			$list_producttype_data = sqlQUERY_LABEL("select `variant_opening_stock`,`variant_available_stock` from js_productvariants where variant_code = '$variant_code'");
			$count_producttype_list = sqlNUMOFROW_LABEL($list_producttype_data);
			if($count_producttype_list > 0){
				while($get_product_data = sqlFETCHARRAY_LABEL($list_producttype_data)) {
					$prdt_opening_qty = $get_product_data['variant_opening_stock'];
					$prdt_available_qty = $get_product_data['variant_available_stock'];
				}
			}
			//echo "select `productopeningstock`,`productavailablestock` from js_product where productsku = '$variant_code'";
			//select variant_opening_stock, variant_available_stock from js_productvariants where variant_code = 'VARS125TR' 
		}
		if($count_producttype_list > 0){
			if($prdt_available_qty > 0){ ?>
			<p class="stock in-stock" style="color:black;">Availability:<span class="text-success"> <?php echo 'In Stock'; ?> </span></p>
			<?php } else if($prdt_available_qty == 0) { ?>
			<p class="stock out-stock" style="color:black;">Availability: <span class="text-danger"> <?php echo 'Out of Stock'; ?> </span></p>
			<?php } 
		} else { ?>
			<p class="stock">Availability: <span> <?php echo ' N/A'; ?> </span></p>
	<?php }
}