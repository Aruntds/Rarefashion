<?php 
extract($_REQUEST);
include 'head/jackus.php'; 
include 'shopfunction.php'; 
include '___class__home.inc'; 
//echo $sid;
$product_token = strbefore($token, '-');

$list_product_datas = sqlQUERY_LABEL("SELECT * FROM `js_product` where productID = '$product_token' and deleted = '0' and status = '1'") or die("#1-Unable to get records:".mysql_error());

$count_product_list = sqlNUMOFROW_LABEL($list_product_datas);

if($count_product_list > 0) {
	while($row = sqlFETCHARRAY_LABEL($list_product_datas)){
		$productID = $row["productID"];
		$productsku = $row["productsku"];
		$productcategory = $row["productcategory"];
		$producttitle = html_entity_decode($row["producttitle"], ENT_QUOTES, "UTF-8");
		$productdescrption = html_entity_decode($row["productdescrption"], ENT_QUOTES, "UTF-8");
		$productpropertydescrption = html_entity_decode($row["productpropertydescrption"], ENT_QUOTES, "UTF-8");
		$productspecialnotes = html_entity_decode($row["productspecialnotes"], ENT_QUOTES, "UTF-8");
		
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

			$featured_product_image = sqlQUERY_LABEL("SELECT `productmediagallerytitle`, `productmediagalleryurl` FROM `js_productmediagallery` where productID='$productID' and productmediagalleryfeatured='1' and productmediagallerytype='1' and deleted = '0' and status = '1'") or die("#1-Unable to get records:".mysql_error());
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
	$commontitle = $productmetatitle.' ( '.$productsku.' )';
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
			$check_bill = sqlQUERY_LABEL("select `od_id`,`od_sesid` from js_shop_order where od_sesid = '$current_SESSION_ID' and od_userid = '$logged_user_id'");
				if(sqlNUMOFROW_LABEL($check_bill) == 0) {
					
					$creating_new_billrecord = sqlQUERY_LABEL("INSERT into `js_shop_order` (`od_userid`, `od_sesid`,  `createdon`, `createdby`) VALUES ('$logged_user_id', '$current_SESSION_ID', '".date('Y-m-d H:i:s')."', '$logged_user_id')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
					$od_id = sqlINSERTID_LABEL();
				} else {
					while($collect_bill = sqlFETCHARRAY_LABEL($check_bill)) {
					$od_id = $collect_bill['od_id'];
					$od_sesid = $collect_bill['od_sesid'];
					}
				}
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
				sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`, `od_id`, `pd_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id', '$od_id', '$PRDT_ID', '$logged_user_id', '$current_SESSION_ID', '$product_qty', '$total_price', '$producttaxtype', '$producttax', '$taxsplit_price', '$taxsplit_price','1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
				$message = "Cart added...!!!";
			} else {
				?>
				<script type="text/javascript">window.location = 'product.php?token=<?php echo $token; ?>&prdt_error=outofstock1' </script>
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
				<script type="text/javascript">window.location = 'product.php?token=<?php echo $token; ?>&prdt_error=outofstock4' </script>
				<?php
			}
		}
		?>
		<script type="text/javascript">window.location = 'product.php?token=<?php echo $token; ?>&prdt_details=cart_added1' </script>
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
				$check_bill = sqlQUERY_LABEL("select `od_id`,`od_sesid` from js_shop_order where od_sesid = '$current_SESSION_ID' and od_userid = '$logged_user_id'");
					if(sqlNUMOFROW_LABEL($check_bill) == 0) {
						$creating_new_billrecord = sqlQUERY_LABEL("INSERT into `js_shop_order` (`od_userid`, `od_sesid`,  `createdon`, `createdby`) VALUES ('$logged_user_id', '$current_SESSION_ID', '".date('Y-m-d H:i:s')."', '$logged_user_id')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
						$od_id = sqlINSERTID_LABEL();
					} else {
						while($collect_bill = sqlFETCHARRAY_LABEL($check_bill)) {
						$od_id = $collect_bill['od_id'];
						$od_sesid = $collect_bill['od_sesid'];
						}
					}
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
					sqlQUERY_LABEL("INSERT into `js_shop_order_item` (`createdby`, `od_id`, `pd_id`, `variant_id`, `user_id`, `od_session`, `od_qty`, `od_price`, `item_tax_type`, `item_tax`, `item_tax1`, `item_tax2`,`status`) VALUES ('$logged_user_id', '$od_id', '$PRDT_ID', '$variant_ID', '$logged_user_id', '$current_SESSION_ID', '$product_qty', '$total_price', '$variant_taxtype', '$variant_tax_value', '$taxsplit_price', '$taxsplit_price','1')") or die("#1 Unable to add Quick Item:" . sqlERROR_LABEL());
					$message = "Cart added...!!!";
				} else {
					?>
					<script type="text/javascript">window.location = 'product.php?token=<?php echo $token; ?>&prdt_error=outofstock2' </script>
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
			'__productdetails4'
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
