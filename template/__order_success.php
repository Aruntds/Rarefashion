<main class="main">
	<nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
		<div class="container d-flex align-items-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="index.php">Home</a></li>
				<li class="breadcrumb-item"><a href="#">Payment Process</a></li>
				<li class="breadcrumb-item"><a href="#">Order Placed</a></li>
				<li class="breadcrumb-item active" aria-current="page"><?php echo $commontitle; ?></li>
			</ol>
		</div><!-- End .container -->
	</nav><!-- End .breadcrumb-nav -->

	<div class="page-content">
		<div class="container jackus">
		 <div class="row">
			<div class="main-content col-md-12">
				<div class="page-main-content">
					<div class="kreen">
						<?php
						if($logged_user_id){
							$__main_order_details_query = sqlQUERY_LABEL("select * FROM `js_shop_order` where `od_userid`='$logged_user_id' and `od_id`='$__main_orderID'") or die(sqlERROR_LABEL());
						} else {
							$__main_order_details_query = sqlQUERY_LABEL("select * FROM `js_shop_order` where `od_sesid`='$__main_orderSESSION' and `od_id`='$__main_orderID'") or die(sqlERROR_LABEL());
						}

						$check_main_order_num_rows = sqlNUMOFROW_LABEL($__main_order_details_query);
						
						if($check_main_order_num_rows > 0) {
							$__main_order_data = sqlFETCHASSOC_LABEL($__main_order_details_query);
								
							$orderID = $__main_order_data['od_id'];
							$od_refno = $__main_order_data['od_refno'];
							$orderDATE = $__main_order_data['od_date'];
							$orderpaymentMODE = $__main_order_data['od_payment_mode'];
							$orderTOTAL = $__main_order_data['od_total'];
							$orderSTATUS = $__main_order_data['od_status'];
							$created_orderDATE = strtotime($orderDATE);
							$created_orderDATE = date('M d, Y', $created_orderDATE);
							
							if($orderpaymentMODE == 'cod') {
								$orderpaymentMODE_ext = 'Cash on Delivery';
							} elseif($orderpaymentMODE == 'razor') {
								$orderpaymentMODE_ext = 'Razor Pay';
							}
							
							//Payment/Shipping Address
							$_checkout_shipping_fname = $__main_order_data['od_shipping_first_name'];
							$_checkout_shipping_lname = $__main_order_data['od_shipping_last_name'];
							$_checkout_shipping_street1 = $__main_order_data['od_shipping_address1'];
							$_checkout_shipping_street2 = $__main_order_data['od_shipping_address2'];
							$_checkout_shipping_email = $__main_order_data['od_shipping_email'];
							$_checkout_shipping_phone = $__main_order_data['od_shipping_phone'];
							$_checkout_shipping_city = $__main_order_data['od_shipping_city'];
							$_checkout_shipping_state = $__main_order_data['od_shipping_state'];
							$_checkout_shipping_pin = $__main_order_data['od_shipping_postal_code'];
							$_checkout_shipping_country = $__main_order_data['od_shipping_country'];
							
							//Billing Address
							$_checkout_payment_fname = $__main_order_data['od_payment_first_name'];
							$_checkout_payment_lname = $__main_order_data['od_payment_last_name'];
							$_checkout_payment_street1 = $__main_order_data['od_payment_address1'];
							$_checkout_payment_street2 = $__main_order_data['od_payment_address2'];
							$_checkout_payment_email = $__main_order_data['od_payment_email'];
							$_checkout_payment_phone = $__main_order_data['od_payment_phone'];
							$_checkout_payment_city = $__main_order_data['od_payment_city'];
							$_checkout_payment_state = $__main_order_data['od_payment_state'];
							$_checkout_payment_pin = $__main_order_data['od_payment_postal_code'];
							$_checkout_payment_country = $__main_order_data['od_payment_country'];
						
						?>
					<div class="row">
					<div class="col-lg-7">
						<span id="summary-cart">
	                			<div class="summary summary-cart text-center" style="margin-top:9%; background-color: #008000ad; color:#fff;height:800px;">
	                				<h2 class="summary-title" style="font-size: 2rem;  color:#fff;">Thank you. Your order has been received.</h2><!-- End .summary-title -->
										<!--<div class="center">
												  <div class="ring">
											</div>
											<span><i class="fa fa-check-circle mt-0" style="font-size: 90px;"></i></span>
										</div>-->
										<i class="fa fa-check-circle mt-12" style="font-size: 90px;"></i>
										<h2 class="mt-2" style="font-size: 2rem;  color:#fff;">ORDER CONFIRMED</h2>
										<div class="card_details ml-auto mr-auto mb-5 mt-5" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);text-align: center;border-radius: 2px; width: 50%;padding: 10px;border-radius: 25px;background-color: #fff;">
										  <div class="header_details" style="background-color: #fff;color: white;padding: 10px;font-size: 40px;height:250px; padding: 26% 20% 20%; ">
										  <h6 class="mt-2">Order Number</h6>
											<h4 style="color:#c66;"><?php echo $od_refno; ?></h4>
										  </div>

										  
										</div>
							</div><!-- End .summary -->
						</span>
					</div>
					<div class="col-lg-5">
						<div class="row">
							<div class="col-md-12 text-right">
								<a href="<?php echo SITEHOME; ?>myorders.php?mode=preview&odid=<?php echo $__main_order_data['od_id'];?>" class="btn btn-outline-primary-2 btn-order btn-block" style="width: 30px;">Back to orders</a>
							</div>
						</div>
						<div class="clearfix mt-3"></div>
						
							<?php
										$featured_product_data = sqlQUERY_LABEL("SELECT SHOP_ITEM.`cart_id`, SHOP_ITEM.`od_id`, SHOP_ITEM.`pd_id`, SHOP_ITEM.`variant_id`, SHOP_ITEM.`od_qty`, SHOP_ITEM.`od_price`, SHOP_ITEM.`item_tax_type`, SHOP_ITEM.`item_tax`, SHOP_ITEM.`item_tax1`, SHOP_ITEM.`item_tax2`, PRDT.`producttitle`, PRDT.`productsku` FROM `js_shop_order_item` AS SHOP_ITEM, `js_product` AS PRDT where SHOP_ITEM.`pd_id` = PRDT.`productID` and SHOP_ITEM.`od_id` = '$__main_orderID' and SHOP_ITEM.deleted = '0' and SHOP_ITEM.status = '0'") or die("#1-Unable to get records:".mysqli_error());
										$check_product_data_num_rows = sqlNUMOFROW_LABEL($featured_product_data);
										
										if($check_product_data_num_rows >0) {
										while($featured_data = sqlFETCHARRAY_LABEL($featured_product_data)){
											  $cart_id = $featured_data["cart_id"];
											  $od_id = $featured_data["od_id"];
											  $pd_id = $featured_data["pd_id"];
											  $producttitle = $featured_data["producttitle"];
											  $producttitle = str_replace("\'","'",$producttitle); //$row["producttitle"];
											  $productsku = $featured_data["productsku"];
											  $variant_id = $featured_data["variant_id"];
											  $od_qty = $featured_data["od_qty"];
											  $od_price = $featured_data["od_price"];
											  $item_tax_type = $featured_data["item_tax_type"];
											  $item_tax = $featured_data["item_tax"];
											  $item_tax1 = $featured_data["item_tax1"];
											  $item_tax2 = $featured_data["item_tax2"];
											  $item_taxonly = ($item_tax1 + $item_tax2);
											  $item_total = $od_price + $item_tax1 + $item_tax2;
										?>
							
							<div class="card_details ml-auto mr-auto mb-2" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);text-align: center;border-radius: 2px;">
											<div class="product" style="display: flex;">

												<figure class="product-media ml-0 mr-0" style="margin-left: auto; margin-right: auto; height=20%; width: 20%;">
														<a href="product.php?token=<?php echo $pd_id.'-'.convertSEOURL($producttitle).'-'.$productsku; ?>">
														<?php
														$productmedia_datas = sqlQUERY_LABEL("SELECT productmediagalleryID, productmediagalleryurl, productmediagallerytype FROM `js_productmediagallery` where productID='$pd_id' and deleted = '0' order by productmediagalleryurl ASC") or die("#2-Unable to get records:".mysqli_error());														  $count_productmedia_availablecount = sqlNUMOFROW_LABEL($productmedia_datas);	while($row = sqlFETCHARRAY_LABEL($productmedia_datas)){
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
											<div class="mt-auto mb-auto" style="text-align: left; padding-left:40px; padding-right:40px; ">
													<div class="mb-0"><a href="product.php?token=<?php echo $pd_id.'-'.convertSEOURL($producttitle).'-'.$productsku; ?>">
												<?php echo $producttitle; ?>
												</a>
												<strong class="product-quantity"> × <?php echo $od_qty; ?></strong></div>
												<?php if($variant_id !='0'){ ?>
													<small class="align-center"><?php echo '<b>Size: </b>'.getVARIANT_CODE($variant_id,'variant_name_from_variant_ID'); ?></small>
												<?php } ?>
												<br>
												<span class="kreen-Price-amount amount text-dark">
												<del style="color:#c66;"><span class="kreen-Price-amount amount text-light"><span class="kreen-Price-currencySymbol text-light"><?php echo general_currency_symbol; ?></span><?php echo (getMRPprice($pd_id, $variant_id,$od_qty)); ?></span> </del>
												&nbsp;
												<small style="font-family: 'Jost', sans-serif; font-size : 100% !important; color: #666;"><?php echo general_currency_symbol; ?></small>&nbsp;<?php echo formatCASH($item_total -$item_taxonly); ?>&nbsp;
												<small style="font-size:70%">( + <?php echo $item_taxonly; ?> TAX )</small>&nbsp;	
												
												</span>
												</div>
												</div>
										 
										</div>
										
						<?php 
						}
						} ?>
						
						<div class="card_details ml-auto mr-auto mb-2" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);text-align: center;border-radius: 2px;">
										  

										  <div class="container_details" style="background-color: #fff; color: #333; padding: 20px 40px 20px; text-align: left !important;">
											<h6>DETAILS & DELIVERY</h6>
											<div class="row col-md-12">
												<div class="col-md-4" style="font-size: 13px">
												<b>Name</b></br>
												<b>Email</b></br>
												<b>Mobile</b></br>
												<b>Order Date</b></br>
												<b>Address</b></br>
												</div>
												<div class="col-md-8" style="font-size: 13px">
												<?php echo $_checkout_shipping_fname.' '.$_checkout_shipping_lname; ?></br>
												<?php echo $_checkout_shipping_email;  ?></br>
												<?php echo $_checkout_shipping_phone;  ?></br>
												<?php echo $created_orderDATE;  ?></br>
												<?php 
													echo $_checkout_shipping_street1.', ';
													if($_checkout_shipping_street2 != ''){
													echo $_checkout_shipping_street2.', ';
													}
													echo $_checkout_shipping_city.', '.$_checkout_shipping_state.', <br>';
													echo $_checkout_shipping_country.' - '.$_checkout_shipping_pin.'';
												?>
												</div>
											</div>
									<!--<div style="font-size: 13px"><b>Name : </b>&nbsp;&nbsp;&nbsp;<?php echo $_checkout_shipping_fname.' '.$_checkout_shipping_lname; ?></br></div>
									<div style="font-size: 13px"><b>Email : </b>&nbsp;&nbsp;&nbsp;<?php echo $_checkout_shipping_email;  ?></br></div>
									<div style="font-size: 13px"><b>Mobile : </b>&nbsp;&nbsp;&nbsp;<?php echo $_checkout_shipping_phone;  ?></br></div>
									<div style="font-size: 13px"><b>Order Date : </b>&nbsp;&nbsp;&nbsp;<?php echo $created_orderDATE;  ?></br></div>
									<div style="font-size: 13px"><b>Address : </b></i>&nbsp;&nbsp;&nbsp;
									 <?php 
										// echo $_checkout_shipping_street1.', ';
										// if($_checkout_shipping_street2 != ''){
										// echo $_checkout_shipping_street2.', ';
										// }
										// echo $_checkout_shipping_city.', '.$_checkout_shipping_state.', ';
										// echo $_checkout_shipping_country.' - '.$_checkout_shipping_pin.'';
									?>							
									</div>-->
									
									<h6 class="mt-1">PAYMENT</h6>
									<div class="row">
									<?php
									
										if($orderpaymentMODE == 'cod') {
											$orderpaymentMODE_ext = 'Cash on Delivery';
											?>
											<!--<i class="fa fa-money-bill" style="font-size:13px;color: green;"></i>&nbsp;&nbsp;&nbsp;<?php echo $orderpaymentMODE_ext; ?></br>-->
											<div class="col-md-4" style="font-size:13px;"><b>Payment Method</b></div>
											<div class="col-md-8" style="font-size:13px;"><?php echo $orderpaymentMODE_ext; ?></div>
											<?php
										} else if($orderpaymentMODE == 'razor') {
											$orderpaymentMODE_ext = 'Razor Pay';
											?>
											<div class="col-md-4" style="font-size:13px;"><b>Payment Method</b></div>
											<div class="col-md-8" style="font-size:13px;"><?php echo $orderpaymentMODE_ext; ?></div>
											<!--<div><i class="fa fa-credit-card"  style="font-size:13px;color: #c66;"></i>&nbsp;&nbsp;&nbsp;<?php echo $orderpaymentMODE_ext; ?></br></div>-->
											<?php
										}
									?>
									</div>
										  </div>
										</div>
						
								<span  id="summary-cart">
	                			<div class="summary summary-cart" style="margin-top:10px;">
	                				<h3 class="summary-title">Cart Total</h3><!-- End .summary-title -->
	                				<table class="table table-summary">
	                					<tbody>
	                						<tr class="summary-subtotal">
	                							<td>Subtotal:</td>
	                							<td id="sub-total"><span class="product-price text-dark" style="padding-top: 15px;"><?php echo general_currency_symbol; ?> <?php echo formatCASH(orderTOTALSUMMARY($__main_orderID, 'subtotal')); ?></span></td>
	                						</tr>
	                						<tr class="summary-subtotal">
	                							<td>Tax:</td>
	                							<td id="sub-total"><span class="product-price text-dark" style="padding-top: 15px;"><?php echo general_currency_symbol; ?> <?php echo formatCASH(orderTOTALSUMMARY($__main_orderID, 'taxtotal')); ?></span></td>
	                						</tr>
											<!-- End .summary-subtotal -->
											
										<?php if(orderTOTALSUMMARY($__main_orderID, 'discounttotal') > 0){ ?>	
											<tr class="summary-total">
	                							<td>Discount:</td>
												<td ><span class="product-price" style="padding-top:15px;"><?php echo general_currency_symbol; ?> <?php echo formatCASH(orderTOTALSUMMARY($__main_orderID, 'discounttotal')); ?></span></td>
	                						</tr><!-- End .summary-total -->
											<?php } ?>
										
	                						<tr class="summary-total">
	                							<td>Total:</td>
												<td ><span class="product-price" style="padding-top:15px;"><?php echo general_currency_symbol; ?> <?php echo formatCASH(orderTOTALSUMMARY($__main_orderID, 'ordertotal')); ?></span></td>
												
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
								</span>
						
						<?php 
						} else { ?>
							<h4 class="thankyou-order-received text-center">Unable to process your request. Open your <a class="text-success" href="<?php echo SITEHOME; ?>my-orders.php">Orders</a> and try again.</h4>
						<?php } ?>
						</div>
						</div>
						</div>
					</div>
				</div>
			</div>
		</div><!-- End .container -->
	</div><!-- End .page-content -->
</main><!-- End .main -->
