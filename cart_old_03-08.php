<?php 
extract($_REQUEST);
include 'head/jackus.php'; 
include 'shopfunction.php'; 
include '___class__home.inc';
//print_r($_SESSION); exit();
//echo $sid;
if($update_cart == 'update_cart'){
	
	foreach ($hidden_cart_ID as $key => $val) {
		
			$count = count($hidden_cart_ID);
			//echo $count.'<br>';
			$selected_CARTID = $_POST['hidden_cart_ID'][$key];

			$selected_PRDTID = $_POST['hidden_PRDT_ID'][$key];
			
			$selected_PRDTQTY = $_POST['quantity'][$key];

			if($selected_PRDTID !='' && $selected_CARTID !=''){
			$check_selecteditem = sqlQUERY_LABEL("select `item_tax`, `item_tax_type`, `pd_id`, `variant_id`, `od_colorid`, `od_size_id`, `od_qty`, `od_price`, `item_tax1`, `item_tax2` from js_shop_order_item where user_id = '$logged_user_id' and pd_id = '$selected_PRDTID' and cart_id = '$selected_CARTID'") or die(sqlERROR_LABEL());

				while($collect_selecteditem = sqlFETCHARRAY_LABEL($check_selecteditem)) {

					$quantity = $collect_selecteditem['od_qty'];
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
					// echo $quantity;
					// echo "<br>";
					// echo $qty;
					// echo "<br>";
					// echo $old_total_price;
					// echo "<br>";
					// echo $newtotal_price;
					// echo "<br>";

				$PRDT_CODE = getPRDT_CODE($selected_PRDTID, $variant_id, 'get_prdt_code');
				//echo $PRDT_CODE.'<br>'; 
				///CHECK PRODUCT ESTORE STOCK VIA API
					$list_producttype_data = sqlQUERY_LABEL("select `productopeningstock`,`productavailablestock` from js_product where productsku = '$PRDT_CODE'");
					$count_producttype_list = sqlNUMOFROW_LABEL($list_producttype_data);
					if($count_producttype_list > 0){
						//echo 'A<br>';
						while($get_product_data = sqlFETCHARRAY_LABEL($list_producttype_data)) {
							$prdt_opening_qty = $get_product_data['productopeningstock'];
							$prdt_available_qty = $get_product_data['productavailablestock'];
						}
					} else {
						//echo 'B<br>';
						//echo "select `variant_available_stock`,`variant_opening_stock` from js_productvariants where variant_code = '$PRDT_CODE'"; exit();
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
				//echo "<br />";
				//echo "UPDATE `js_shop_order_item` SET `od_price` = '$newtotal_price', `od_qty`='$selected_PRDTQTY', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_user_id' and user_id = '$logged_user_id' and pd_id = '$selected_PRDTID' and cart_id = '$selected_CARTID'<br />";
				//exit();
				if($selected_PRDTQTY <= $prdt_available_qty){
					//echo "UPDATE `js_shop_order_item` SET `od_price` = '$newtotal_price', `od_qty`='$selected_PRDTQTY', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_user_id' and user_id = '$logged_user_id' and pd_id = '$selected_PRDTID' and cart_id = '$selected_CARTID'<br />";
					sqlQUERY_LABEL("UPDATE `js_shop_order_item` SET `od_price` = '$newtotal_price', `od_qty`='$selected_PRDTQTY', `item_tax1`='$taxsplit_price', `item_tax2`='$taxsplit_price' WHERE createdby = '$logged_user_id' and user_id = '$logged_user_id' and pd_id = '$selected_PRDTID' and cart_id = '$selected_CARTID'") or die(sqlERROR_LABEL());
					$message = "Cart updated...!!!";
				} else {
					//echo $selected_PRDTID;
					if($variant_id !='0'){
						$get_variant_name = ' ('.getVARIANT_CODE($variant_id,'variant_name_from_variant_ID').')';
					} else {
						$get_variant_name = '';
					}
					$get_prdt_name = getPRDT_CODE($selected_PRDTID,'','get_prdt_name');
					$err .= "Stock not availabe for ".$get_prdt_name.$get_variant_name.'<br />';
				}
			}

		}  //end of 1st for loop
		//exit();
		if(empty($err)) {
		?>
		<script type="text/javascript">window.location = 'cart.php?msg=cart_updated' </script>
		<?php
		} else {
		?>
		<script type="text/javascript">window.location = 'cart.php?errormsg=<?php echo $err; ?>' </script>
		<?php
		}
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
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
        <main class="main">
        	<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">Shopping Cart<span>Shop</span></h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="shop.php">Shop</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
            	<div class="cart">
	                <div class="container">
						<form method="post">
	                	<div class="row">
	                		<div class="col-lg-9">
	                			<table class="table table-cart table-mobile">
									<thead>
										<tr>
											<th>Product</th>
											<th>Price</th>
											<th>Quantity</th>
											<th style="width: 12%;">Total</th>
											<th></th>
										</tr>
									</thead>
									<?php
									
									if(!empty($logged_user_id)){
										$cart_query= "SELECT * FROM `js_shop_order_item` WHERE user_id ='$logged_user_id' and deleted='0' and `status` ='1' ORDER BY pd_id";
										
									}else{
										
										$cart_query= "SELECT * FROM `js_shop_order_item` WHERE  od_session = '$sid' and deleted='0' and `status` ='1' ORDER BY pd_id";
									}
									
									
									
									// echo $query;
									$cart_result = sqlQUERY_LABEL($cart_query);
									while($cart_row = sqlFETCHARRAY_LABEL($cart_result))
									{
										$cart_id = $cart_row['cart_id'];
										$product_ID = $cart_row['pd_id'];
										$od_id = $cart_row['od_id'];
										$product_qty = $cart_row['od_qty'];
										$total_product_price = $cart_row['od_price'];
										$product_variant_id = $cart_row['variant_id'];
										// $total_price = $product_qty * $product_price;
										$cart_product = sqlQUERY_LABEL("SELECT `producttitle`, `productsellingprice` FROM `js_product` where productID='$product_ID' and deleted = '0' and status = '1'") or die("#1-Unable to get records:".mysqli_error());
										while($featured_product = sqlFETCHARRAY_LABEL($cart_product)){
										$product_title = $featured_product["producttitle"];
										
										$total_cart_price += ($product_qty * $product_price);
										
										$product_price = $featured_product["productsellingprice"];
										
										$variant_product_price = getVRIANTPRODUCTPRICE($product_ID, $product_variant_id);
										
										$total_price += $product_price + $variant_product_price;
										
										$get_variant_tax_split1 = $group_limit = getSINGLEDBVALUE('variant_taxsplit1',"parentproduct='$product_ID' and variant_ID = '$product_variant_id'",'js_productvariants','label');
										$get_variant_tax_split2 = $group_limit = getSINGLEDBVALUE('variant_taxsplit2',"parentproduct='$product_ID' and variant_ID = '$product_variant_id'",'js_productvariants','label');
										$get_variant_tax_value = $group_limit = getSINGLEDBVALUE('variant_tax_value',"parentproduct='$product_ID' and variant_ID = '$product_variant_id'",'js_productvariants','label');
										$total_tax_amount = $get_variant_tax_split1 + $get_variant_tax_split2;
										$tot_taxt_amt_for_od_qty = ($total_tax_amount * $product_qty);
										}
										$od_discount_amount = number_format(getSINGLEDBVALUE('od_discount_amount',"od_id='$od_id'",'js_shop_order','label'),2);
										$discount_added = getSINGLEDBVALUE('od_discount_type',"od_id='$od_id'",'js_shop_order','label');
										//echo $od_discount_amount; exit();
									?>
									
									<tbody>
									<?php if(sqlNUMOFROW_LABEL($cart_result) == 0) { ?>
										<tr>
											<td class="product-col" colspan="5"> Your bag is empty </td>
										</tr>
									<?php } else { if($product_qty > 0){ ?>
										<tr id="delete-cart<?php echo $cart_id; ?>">
											<td class="product-col">
												<div class="product">
													<figure class="product-media">
														<a href="#">
														<?php
														$productmedia_datas = sqlQUERY_LABEL("SELECT productmediagalleryID, productmediagalleryurl, productmediagallerytype FROM `js_productmediagallery` where productID='$product_ID' and deleted = '0' order by productmediagalleryurl ASC") or die("#2-Unable to get records:".mysqli_error());														  $count_productmedia_availablecount = sqlNUMOFROW_LABEL($productmedia_datas);	while($row = sqlFETCHARRAY_LABEL($productmedia_datas)){
														  $productmediagalleryID = $row["productmediagalleryID"];
														  $productmediagalleryurl = $row["productmediagalleryurl"];
														  $productmediagallerytype = $row["productmediagallerytype"];
														  //image path
														  $media_path = "uploads/productmediagallery/$productmediagalleryurl";
																												
														} //end of count
														?>													
															<img src="<?php echo $media_path; ?>" alt="product side">
														</a>
													</figure>

													<h3 class="product-title">
														<a href="product.php?token=<?php echo $product_ID.'-'.convertSEOURL($product_title).'-'.$productsku; ?>" title="<?php echo $product_title; ?>"><?php echo $product_title; ?></a><br><?php if($product_variant_id !='0'){ ?><small><?php echo 'Size: '.getVARIANT_CODE($product_variant_id,'variant_name_from_variant_ID'); ?></small><?php } ?>
													</h3><!-- End .product-title -->
												</div><!-- End .product -->
											</td>
											<td class="price-col" id="product-price"><span class="product-price text-dark" style="padding-top:15px;"><?php echo general_currency_symbol; ?> <?php if($product_variant_id == '0'){echo number_format($product_price,2);}else{echo number_format($variant_product_price,2).'<span style="color:#fcb941;"><small>Tax '. $get_variant_tax_value.' % ( '.$total_tax_amount.' ) </small></span>';} ?></span></td>
											<td class="quantity-col">
                                                <div class="cart-product-quantity">
                                                    <input type="number" class="form-control" id="dispaly-qty" value="<?php echo $product_qty; ?>" min="1" max="10" step="1" data-decimals="0" name="quantity[]" required>
                                                </div><!-- End .cart-product-quantity -->
                                            </td>
											<td class="total-col" id="total-price"><span class="product-price" style="padding-top:15px;"><?php echo general_currency_symbol; ?> <?php echo number_format($total_product_price+$tot_taxt_amt_for_od_qty,2); ?></span></td>
											<td class="remove-col"><button class="btn-remove" id="remove_product" onClick="remove_quickitem_List(<?php echo $cart_id; ?>);"><i class="icon-close"></i></button></td>
											<input type="hidden" id="hidden_cart_ID" name="hidden_cart_ID[]" value="<?php echo $cart_id; ?>">
									   <input type="hidden" id="hidden_PRDT_ID" name="hidden_PRDT_ID[]" value="<?php echo $product_ID; ?>">
										</tr>
									<?php } } ?>
									</tbody>
									<?php } ?>
								</table><!-- End .table table-wishlist -->

	                			<div class="cart-bottom">
			            			<div class="cart-discount">
			            					<div class="input-group">
				        						<input type="text" class="form-control" placeholder="coupon code" id="coupon_code">
				        						<input type="hidden" class="form-control" id="order_total" value="<?php echo getTotal_cart_amount($product_ID, $logged_user_id,$sid,'total'); ?>">
				        						<input type="hidden" class="form-control" id="od_id" value="<?php echo $od_id; ?>">
				        						<div class="input-group-append">
													<?php if($discount_added == 0 ) { ?>
													<button class="btn btn-outline-primary-2" type="button" onclick = "validate_coupon()">&nbsp;&nbsp;Apply<i class="icon-long-arrow-right"></i></button>
													<?php } else { ?>
													&nbsp;&nbsp;&nbsp;&nbsp;
													<button class="btn btn-outline-secondary" type="button" onclick = "remove_coupon()">&nbsp;&nbsp;Remove<i class="icon-long-arrow-right"></i></button>
													<?php } ?>
												</div><!-- .End .input-group-append -->
			        						</div><!-- End .input-group -->
			            			</div><!-- End .cart-discount -->
			            		<button type="submit" class="btn btn-outline-dark-2" name="update_cart" value="update_cart"><span>UPDATE CART</span><i class="icon-refresh"></i></button>
		            			</div><!-- End .cart-bottom -->
	                		</div><!-- End .col-lg-9 -->
	                		<aside class="col-lg-3">
							<a href="shop.php" class="btn btn-outline-primary-2 btn-order btn-block" >CONTINUE SHOPPING</a>
	                			<div class="summary summary-cart" style="margin-top:20px;">
	                				<h3 class="summary-title">Cart Total</h3><!-- End .summary-title -->

	                				<table class="table table-summary">
	                					<tbody>
	                						<tr class="summary-subtotal">
	                							<td>Subtotal:</td>
												<?php if(sqlNUMOFROW_LABEL($cart_product) == 0) {?>
												<td ><span class="product-price text-dark" style="padding-top:15px;"><?php echo general_currency_symbol; ?> 0.00</span></td>
												<?php } else { ?>
	                							<td id="sub-total"><span class="product-price text-dark" style="padding-top: 15px;"><?php echo general_currency_symbol; ?> <?php echo getTotal_cart_amount($product_ID, $logged_user_id, $sid,'subtotal'); ?></span></td>
												<?php }?>
	                						</tr>
											<!-- End .summary-subtotal -->
	                						<?php /*<tr class="summary-shipping">
	                							<td>Shipping:</td>
	                							<td>&nbsp;</td>
	                						</tr>

	                						<tr class="summary-shipping-row">
	                							<td>
													<div class="custom-control custom-radio">
														<input type="radio" id="free-shipping" name="shipping" data-target="#free-shiping-collapse" data-toggle="collapse" class="custom-control-input">
														<label class="custom-control-label" for="free-shipping">Free Shipping</label>
													</div><!-- End .custom-control -->
	                							</td>
	                							<td>INR 0.00</td>
	                						</tr><!-- End .summary-shipping-row -->
											<tr class="summary-shipping-row">
												<td>
													<div class="collapse " id="free-shiping-collapse" style="width: 120%;text-align: left !important;">
														<div class="card card-body custom-control">
														Free shipping is a marketing tactic used primarily by online vendors and mail-order catalogs as a sales strategy to attract customers.
														</div>
													</div>
												</td>
											</tr>
											<tr class="summary-shipping-row">
	                							<td>
	                								<div class="custom-control custom-radio">
														<input type="radio" id="standart-shipping" name="shipping" data-target="#standard-shiping-collapse" data-toggle="collapse" class="custom-control-input">
														<label class="custom-control-label" for="standart-shipping">Standard</label>
													</div><!-- End .custom-control -->
	                							</td>
	                							<td>INR 10.00</td>
	                						</tr><!-- End .summary-shipping-row -->
											<tr class="summary-shipping-row">
												<td>
													<div class="collapse " id="standard-shiping-collapse" style="width: 120%;text-align: left !important;">
														<div class="card card-body custom-control">
														Free shipping is a marketing tactic used primarily by online vendors and mail-order catalogs as a sales strategy to attract customers.
														</div>
													</div>
												</td>
											</tr>
	                						<tr class="summary-shipping-row">
	                							<td>
	                								<div class="custom-control custom-radio">
														<input type="radio" id="express-shipping" name="shipping" data-target="#express-shiping-collapse" data-toggle="collapse" class="custom-control-input">
														<label class="custom-control-label" for="express-shipping">Express</label>
													</div><!-- End .custom-control -->
	                							</td>
	                							<td>INR 20.00</td>
	                						</tr><!-- End .summary-shipping-row -->
											<tr class="summary-shipping-row">
												<td>
													<div class="collapse " id="express-shiping-collapse" style="width: 120%;text-align: left !important;">
														<div class="card card-body custom-control">
														Free shipping is a marketing tactic used primarily by online vendors and mail-order catalogs as a sales strategy to attract customers.
														</div>
													</div>
												</td>
											</tr>
	                						<tr class="summary-shipping-estimate">
	                							<td><a href="">Change address</a></td>
	                							<td>&nbsp;</td>
	                						</tr><!-- End .summary-shipping-estimate -->*/?>  
											<tr class="summary-total">
	                							<td>Discount:</td>
												<?php if(sqlNUMOFROW_LABEL($cart_product) == 0) {?>
	                							<td ><span class="product-price text-dark" style="padding-top:15px;"><?php echo general_currency_symbol; ?> 0.00</span></td>
												<?php } else { ?>
												<td ><span class="product-price" style="padding-top:15px;"><?php echo general_currency_symbol; ?> <?php echo $od_discount_amount; ?></span></td>
												<?php } ?>
	                						</tr><!-- End .summary-total -->
										
	                						<tr class="summary-total">
	                							<td>Total:</td>
												<?php if(sqlNUMOFROW_LABEL($cart_product) == 0) {?>
	                							<td ><span class="product-price text-dark" style="padding-top:15px;"><?php echo general_currency_symbol; ?> 0.00</span></td>
												<?php } else {?>
												<?php if($od_discount_amount == '0.00'){?>
												<td ><span class="product-price" style="padding-top:15px;"><?php echo general_currency_symbol; ?> <?php echo getTotal_cart_amount($product_ID, $logged_user_id,$sid,'total'); ?></span></td>
												<?php }else{?>
												<td ><span class="product-price" style="padding-top:15px;"><?php echo general_currency_symbol; ?> <?php echo number_format(getTotal_cart_amount($product_ID, $logged_user_id,$sid,'total')-($od_discount_amount),2); ?></span></td>
												
												<?php }} ?>
	                						</tr><!-- End .summary-total -->	
	                					</tbody>
	                				</table><!-- End .table table-summary -->
									<?php if(sqlNUMOFROW_LABEL($cart_product) == 0) { ?>
	                				<a href="shop.php" class="btn btn-outline-primary-2 btn-order btn-block">CONTINUE SHOPPING</a>
									<?php } else { ?>
									<?php if($logged_user_id) {?>
									<a href="checkout.php" class="btn btn-outline-primary-2 btn-order btn-block">CONTINUE TO CHECKOUT</a>
									<?php } else { ?> 
									<a href="#signin-modal" data-toggle="modal" class="btn btn-outline-primary-2 btn-order btn-block" role="button" aria-haspopup="true" aria-expanded="false" data-display="static" title="Compare Products" aria-label="Compare Products">CONTINUE TO CHECKOUT</a>
									
									<?php } }?>
	                			</div><!-- End .summary -->

	                		</aside><!-- End .col-lg-3 -->
	                	</div><!-- End .row -->
						</form>
	                </div><!-- End .container -->
                </div><!-- End .cart -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->

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
