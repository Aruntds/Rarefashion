<main class="main">
	<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
		<div class="container">
			<h1 class="page-title">My Account<span>Dashboard</span></h1>
		</div><!-- End .container -->
	</div><!-- End .page-header -->
	<nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
		<div class="container">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="index.php">Home</a></li>
				<li class="breadcrumb-item"><a href="shop.php">Shop</a></li>
				<li class="breadcrumb-item active" aria-current="page">My Account</li>
			</ol>
		</div><!-- End .container -->
	</nav><!-- End .breadcrumb-nav -->

	<div class="page-content">
		<div class="dashboard">
			<div class="container">
				<div class="row">
					<aside class="col-md-4 col-lg-3">
						<ul class="nav nav-dashboard flex-column mb-3 mb-md-0" role="tablist">
							<li class="nav-item">
								<a class="nav-link <?php echo $dashboard_active; ?>" href="dashboard.php">Dashboard</a>
							</li>
							<li class="nav-item">
								<a class="nav-link active" href="dashboard.php?nav=order">Orders</a>
							</li>
							
							<li class="nav-item">
								<a class="nav-link <?php echo $address_active; ?>" href="dashboard.php?nav=address" >Adresses</a>
							</li>
							<li class="nav-item">
								<a class="nav-link <?php echo $account_active; ?>" href="dashboard.php?nav=account">Account Details</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="logout.php">Sign Out</a>
							</li>
						</ul>
					</aside><!-- End .col-lg-3 -->
					<?php 
					//echo "SELECT `username` FROM js_users WHERE `userID` = '$logged_user_id' AND `deleted` = '0'";
					$get_user_name= sqlQUERY_LABEL("SELECT `username` FROM js_users WHERE `userID` = '$logged_user_id' AND `deleted` = '0'");
					while($row = sqlFETCHARRAY_LABEL($get_user_name)){

					$name = $row["username"];
					}
					?>
					<div class="col-md-8 col-lg-9">
					
						<div class="tab-content">
							<?php if($formtype == '') { ?>
							<div class="tab-pane fade" id="tab-dashboard" role="tabpanel" aria-labelledby="tab-dashboard-link">
								<p>Hello <span class="font-weight-normal text-dark"><?php echo $name; ?></span> (not <span class="font-weight-normal text-dark"><?php echo $name; ?></span>? <a href="logout.php">Log out</a>) 
								<br>
								From your account dashboard you can view your <a href="#tab-orders" class="tab-trigger-link link-underline">recent orders</a>, manage your <a href="#tab-address" class="tab-trigger-link">shipping and billing addresses</a>, and <a href="#tab-account" class="tab-trigger-link">edit your password and account details</a>.</p>
							</div><!-- .End .tab-pane -->
							<div class="tab-pane fade show active" id="tab-orders" role="tabpanel" aria-labelledby="tab-orders-link">
							<?php 
							if($logged_user_id != ''){
							$__main_order_details_query = sqlQUERY_LABEL("select * FROM `js_shop_order` where `od_userid`='$logged_user_id' and `od_id`='$odid'") or die(sqlERROR_LABEL());
							} else {
							$__main_order_details_query = sqlQUERY_LABEL("select * FROM `js_shop_order` where `od_id`='$odid'") or die(sqlERROR_LABEL());	
							}
							$check_main_order_num_rows = sqlNUMOFROW_LABEL($__main_order_details_query);
							$__main_order_data = sqlFETCHASSOC_LABEL($__main_order_details_query);	
							$orderID = $__main_order_data['od_id'];
							$order_ref_no = $__main_order_data['od_refno'];
							$orderDATE = $__main_order_data['od_date'];
							$orderpaymentMODE = $__main_order_data['od_payment_mode'];
							$orderTOTAL = $__main_order_data['od_total'];
							$orderSTATUS = $__main_order_data['od_status'];
							$created_orderDATE = strtotime($orderDATE);
							// $created_orderDATE = date('M d, Y', $created_orderDATE);
							$created_order_MONTH = date('M', $created_orderDATE);
							$created_order_DATE = date('d', $created_orderDATE);
							$created_order_YEAR = date('Y', $created_orderDATE);
							
							if($orderpaymentMODE == 'cod') {
								$orderpaymentMODE = 'Cash on Delivery';
							} elseif($orderpaymentMODE == 'razor') {
								$orderpaymentMODE = 'Razor Pay';
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
							<?php if($mode == 'preview') { ?>
							<div class="row mb-2">
								<div class="col-md-3">
									<div class="card_details" style="border: #c66 2px solid; text-align: center;">
									
									  <div class="container_details" >
										<p class="mb-0">Order Placed On</p>
									  </div>
									  <div class="header_details" style="background-color: #c66;color: #fff;padding: 10px;font-size: 40px;">
										<h6 class="mb-0" style="color:#fff;"><?php echo $created_order_MONTH; ?></h6>
										<h1 class="mb-0" style="color:#fff;"><?php echo $created_order_DATE; ?></h1>
										<h6 class="mb-0" style="color:#fff;"><?php echo $created_order_YEAR; ?></h6>
									  </div>

									</div>
								</div>
								<?php
									$review_for_order = sqlQUERY_LABEL("select * FROM `js_review` where `review_type`='2' and `od_id`='$odid' and `createdby` = '$logged_user_id'") or die(sqlERROR_LABEL());
									$count_review = sqlNUMOFROW_LABEL($review_for_order);
									while($fetch_review_data = sqlFETCHASSOC_LABEL($review_for_order)){
										$star_rating = $fetch_review_data['rating'];
										$review_description = $fetch_review_data['review_discription'];
										$createdon = $fetch_review_data['createdon'];
										$createdon = date('d, M, Y g:i A',  strtotime($createdon));
									}
								?>
								<div class="col-md-9">
									<div style="height: 50%; padding: 20px 0px 20px; text-align: center; ">
										<?php if($count_review == 0 || $count_review == '') { ?>
											<a class="btn btn-light" href="myorders.php?formtype=review&odid=<?php echo $odid;?>">Write a Review</a>
											<?php } 
											if(in_array($orderSTATUS, array(1,2,3))) {
										?>
										<a class="btn btn-danger" href="<?php echo SITEHOME; ?>myorders.php?mode=cancel&order=<?php echo $orderID; ?>">Cancel Order</a>
										<?php } ?>
										<?php 
											$order_email_data = sqlQUERY_LABEL("SELECT useremail from js_users where userID='$logged_user_id'");
										while($row_order_email = sqlFETCHARRAY_LABEL($order_email_data)){
											$order_email = $row_order_email["useremail"];
										}
											// $order_email = getSINGLEDBVALUE('customeremail', 'user_id=$logged_customer_id', 'js_customer', 'label');
										?>
										<a class="btn btn-success" href="order_tracking.php?mode=preview&od_refno=<?php echo base64_encode($order_ref_no); ?>&order_email=<?php echo base64_encode($order_email); ?>">Track Orders</a>
											<a class="btn btn-primary" href="dashboard.php?nav=order">Back To Orders</a>
									</div>
									<div style="height: 50%; padding: 20px 0px 20px; text-align: center;">
										<h5>Order #<?php echo $order_ref_no; ?> is currently <u><?php echo getorder_paymentSTATUS('2','', $orderSTATUS, 'label'); ?></u> order.</h5>
									</div>
								</div>
							</div>
							
							<?php if($count_review > 0) { ?>
							<div class="row mt-20">
								<div class="col-md-4">
									<h5>Rating:</h5>
									<?php if($star_rating == '1') {?>
									<div class="rating">
										<input type="radio" id="" name="rating" value="5" /><label for="star5" title="Rocks!">5 stars</label>
										<input type="radio" id="" name="rating" value="4" /><label for="star4" title="Pretty good">4 stars</label>
										<input type="radio" id="" name="rating" value="3" /><label for="star3" title="Meh">3 stars</label>
										<input type="radio" id="" name="rating" value="2" /><label for="star2" title="Kinda bad">2 stars</label>
										<input type="radio" id="" name="rating" value="1" checked /><label for="star1" title="Sucks big time">1 star</label>
									</div>
									<?php } if($star_rating == '2') {?>
									<div class="rating">
										<input type="radio" id="" name="rating" value="5" /><label for="star5" title="Rocks!">5 stars</label>
										<input type="radio" id="" name="rating" value="4" /><label for="star4" title="Pretty good">4 stars</label>
										<input type="radio" id="" name="rating" value="3" /><label for="star3" title="Meh">3 stars</label>
										<input type="radio" id="" name="rating" value="2" checked /><label for="star2" title="Kinda bad">2 stars</label>
										<input type="radio" id="" name="rating" value="1" /><label for="star1" title="Sucks big time">1 star</label>
									</div>
									<?php } if($star_rating == '3') {?>
									<div class="rating">
										<input type="radio" id="" name="rating" value="5" /><label for="star5" title="Rocks!">5 stars</label>
										<input type="radio" id="" name="rating" value="4" /><label for="star4" title="Pretty good">4 stars</label>
										<input type="radio" id="" name="rating" value="3" checked /><label for="star3" title="Meh">3 stars</label>
										<input type="radio" id="" name="rating" value="2" /><label for="star2" title="Kinda bad">2 stars</label>
										<input type="radio" id="" name="rating" value="1" /><label for="star1" title="Sucks big time">1 star</label>
									</div>
									<?php } if($star_rating == '4') {?>
									<div class="rating">
										<input type="radio" id="" name="rating" value="5" /><label for="star5" title="Rocks!">5 stars</label>
										<input type="radio" id="" name="rating" value="4" checked /><label for="star4" title="Pretty good">4 stars</label>
										<input type="radio" id="" name="rating" value="3" /><label for="star3" title="Meh">3 stars</label>
										<input type="radio" id="" name="rating" value="2" /><label for="star2" title="Kinda bad">2 stars</label>
										<input type="radio" id="" name="rating" value="1" /><label for="star1" title="Sucks big time">1 star</label>
									</div>
									<?php } if($star_rating == '5') {?>
									<div class="rating">
										<input type="radio" id="" name="rating" value="5" checked /><label for="star5" title="Rocks!">5 stars</label>
										<input type="radio" id="" name="rating" value="4" /><label for="star4" title="Pretty good">4 stars</label>
										<input type="radio" id="" name="rating" value="3" /><label for="star3" title="Meh">3 stars</label>
										<input type="radio" id="" name="rating" value="2" /><label for="star2" title="Kinda bad">2 stars</label>
										<input type="radio" id="" name="rating" value="1" /><label for="star1" title="Sucks big time">1 star</label>
									</div>
									<?php } ?>
								</div>
								<div class="col-md-5">
								<h5>Description:</h5>
									<p><?php echo $review_description;?></p>
								</div>
								<div class="col-md-3">
								<h5>Date & Time:</h5>
									<p><?php echo $createdon;?></p>
								</div>
							</div>
							<?php } ?>
							<div class="card_details ml-auto mr-auto" style="text-align: center;border-radius: 2px;">
										  <!--border: #9f989861 1px solid;-->

										  <div class="container_details" style="background-color: #fff; color: #333; padding: 20px 60px 20px; text-align: left !important;">
										  <div class="row">
										  <div class="col-md-3 mt-auto mb-auto">
												<h6>Shipping Address</h6>
												<p style="font-size: 1.3rem; color: #333">
												<b><?php echo $_checkout_shipping_fname.' '.$_checkout_shipping_lname; ?></b></br>
												<?php 
													echo $_checkout_shipping_street1.',<br />';
													if($_checkout_shipping_street2 != ''){
													echo $_checkout_shipping_street2.',<br />';
													}
													echo $_checkout_shipping_city.',<br /> '.$_checkout_shipping_state.',<br />';
													echo $_checkout_shipping_country.' - '.$_checkout_shipping_pin.'<br />';

												?>							
												</p>	
										  </div>
										<div class="col-md-4 mt-auto mb-auto" style="font-size: 1.3rem;">
										<!--<h5><b>DETAILS</b></h5>-->
											<h6 class="mb-0">Email</h6>
											<?php echo $_checkout_shipping_email; ?>
											<h6 class="mt-1 mb-0">Mobile</h6>
											<?php echo $_checkout_shipping_phone; ?>
											<h6 class="mt-1 mb-0">Payment</h6>
											<?php echo $orderpaymentMODE; ?>
										</div>
										<div class="col-md-5">
											<div class="card_details ml-auto mr-auto mb-1" style="text-align: center;border-radius: 2px; border: #9f989861 1px solid;">
											
												<div class="header_details" style="padding: 9px; background-color: #E3E4E8;color: #333;font-size: 40px;">
												
											<h5 class="summary-title mb-1" style="padding-bottom:5px;">Order Summary</h5>
											<?php 
												 if(orderTOTALSUMMARY($odid, 'ordertotal') > '1500') { ?>
													<div style="font-size: 1.2rem;">Order value is more than <small  style="font-family: 'Jost', sans-serif; font-size : 100% !important; color: #333;"><?php echo general_currency_symbol; ?></small> 1500</div>
												 <?php } ?>
												</div>
												 <?php if(orderTOTALSUMMARY($odid, 'ordertotal') > '1500') { ?>
												<div class="container_details" style="background-color: #fff; color: #c66; padding: 10px 1px 10px; font-size: 1.1rem;">
													<b>Cheers ! You got free delivery, Happy Shopping</b>
												</div>
											 <?php } ?>
											 
											</div>
										
											<span  id="summary-cart">
												<div class="summary summary-cart mb-0">
													<table class="table table-summary">
														<tbody>
															<tr class="summary-subtotal">
																<td style="font-size: 1.3rem;">Subtotal:</td>
																<td id="sub-total"><span class="product-price text-dark" style="padding-top: 15px;font-size: 1.35rem;"><?php echo general_currency_symbol; ?> <?php echo formatCASH(orderTOTALSUMMARY($odid, 'subtotal')); ?></span></td>
															</tr>
															<tr class="summary-subtotal">
																<td style="font-size: 1.3rem;">Tax:</td>
																<td id="sub-total"><span class="product-price text-dark" style="padding-top: 15px;font-size: 1.35rem;"><?php echo general_currency_symbol; ?> <?php echo formatCASH(orderTOTALSUMMARY($odid, 'taxtotal')); ?></span></td>
															</tr>
															<!-- End .summary-subtotal -->
															<?php if(orderTOTALSUMMARY($odid, 'discounttotal') > 0){ ?>
															<tr class="summary-subtotal">
																<td style="font-size: 1.3rem;">Discount:</td>
																<td><span class="product-price text-dark" style="padding-top:15px;font-size: 1.35rem;"><?php echo general_currency_symbol; ?> <?php echo formatCASH(orderTOTALSUMMARY($odid, 'discounttotal')); ?></span></td>
															</tr><!-- End .summary-total -->
															<?php } ?>
														
															<tr class="summary-total">
																<td style="font-size: 1.4rem;">Total:</td>
																<td ><span class="product-price" style="padding-top:15px; color: #c66 !important"><?php echo general_currency_symbol; ?> <?php echo formatCASH(orderTOTALSUMMARY($odid, 'ordertotal')); ?></span></td>
																
															</tr><!-- End .summary-total -->	
															
														</tbody>
													</table><!-- End .table table-summary -->
													
												</div><!-- End .summary -->
											</span>
										</div>
									</div>
										  </div>
										</div>
										
							<div class="row">
								<div class="col-md-12">
									<?php
										//echo "SELECT SHOP_ITEM.`cart_id`, SHOP_ITEM.`od_id`, SHOP_ITEM.`pd_id`, SHOP_ITEM.`variant_id`, SHOP_ITEM.`od_qty`, SHOP_ITEM.`od_price`, SHOP_ITEM.`item_tax_type`, SHOP_ITEM.`item_tax`, SHOP_ITEM.`item_tax1`, SHOP_ITEM.`item_tax2`, PRDT.`producttitle`, PRDT.`productsku` FROM `js_shop_order_item` AS SHOP_ITEM, `js_product` AS PRDT where SHOP_ITEM.`pd_id` = PRDT.`productID` and SHOP_ITEM.`od_id` = '$odid' and SHOP_ITEM.deleted = '0' and SHOP_ITEM.status = '1'";
										$featured_product_data = sqlQUERY_LABEL("SELECT SHOP_ITEM.`cart_id`, SHOP_ITEM.`od_id`, SHOP_ITEM.`pd_id`, SHOP_ITEM.`variant_id`, SHOP_ITEM.`od_qty`, SHOP_ITEM.`od_status_item`, SHOP_ITEM.`od_price`, SHOP_ITEM.`item_tax_type`, SHOP_ITEM.`item_tax`, SHOP_ITEM.`item_tax1`, SHOP_ITEM.`item_tax2`, PRDT.`producttitle`, PRDT.`productsku` FROM `js_shop_order_item` AS SHOP_ITEM, `js_product` AS PRDT where SHOP_ITEM.`pd_id` = PRDT.`productID` and SHOP_ITEM.`od_id` = '$odid' and SHOP_ITEM.deleted = '0'") or die("#1-Unable to get records:".mysqli_error());
										$check_product_data_num_rows = sqlNUMOFROW_LABEL($featured_product_data);
										
										if($check_product_data_num_rows > 0 ) {
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
											  $od_status_item = $featured_data["od_status_item"];
											  $item_taxonly = ($item_tax1 + $item_tax2);
											  $item_total = $od_price + $item_tax1 + $item_tax2;
											  $productmedia_datas = sqlQUERY_LABEL("SELECT productmediagalleryID, productmediagalleryurl, productmediagallerytype FROM `js_productmediagallery` where productID='$pd_id' and deleted = '0' order by productmediagalleryurl ASC") or die("#2-Unable to get records:".mysqli_error());			
												$count_productmedia_availablecount = sqlNUMOFROW_LABEL($productmedia_datas);	
												while($row = sqlFETCHARRAY_LABEL($productmedia_datas)){
												  $productmediagalleryID = $row["productmediagalleryID"];
												  $productmediagalleryurl = $row["productmediagalleryurl"];
												  $productmediagallerytype = $row["productmediagallerytype"];
												  //image path
												  $media_path = "uploads/productmediagallery/$productmediagalleryurl";
																										
												}
										?>
								
											
							<div class="card_details ml-auto mr-auto mb-2" style="text-align: center;border-radius: 2px;">
											<div class="product" style="display: flex;">

												<figure class="product-media ml-0 mr-0" style="margin-left: auto; margin-right: auto; height=18.5%; width: 18.5%;">
													<a href="product.php?token=<?php echo $pd_id.'-'.$productsku; ?>">									
														<img src="<?php echo $media_path; ?>" alt="product side">
													</a>
												</figure>
												<div class="row">
												<div class="col-md-8 mt-auto mb-auto" style="text-align: left; padding-left:40px; padding-right:40px; ">
														<div class="mb-0"><a href="product.php?token=<?php echo $pd_id.'-'.$productsku; ?>">
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
												
												<?php if($od_status_item != '7') { ?>
													<div class="col-md-3 mt-1 mb-1" style="text-align: right;">
														<a href="product.php?token=<?php echo $pd_id.'-'.$productsku; ?>&reviews=product-review-heading#product-review-heading" class="btn btn-outline-primary-2 btn-order btn-block" style="height: 30px; width: 200px;">Write a Product Review</a>
														<a href="dashboard.php?nav=orders&mode=cancel&orderID=<?php echo $od_id; ?>&productID=<?php  echo $pd_id; ?>" class="btn btn-outline-primary-2 btn-order btn-block" style="height: 30px; width: 200px;">Cancel Order</a>
													</div>
												<?php } else { ?>
													<div class="col-md-3 mt-1 mb-1" style="text-align: right; padding-right:40px; right:0px; left: 200px;">
														<span class="badge badge-danger">Product Cancelled </span>
													</div>
												<?php } ?>
												
												</div>
											</div>
										 
										</div>
										<hr>
										<?php } } ?>
									<!--<table class="table order_details table_order_preview table-bordered" style="padding-top:10px;">
									

									<tbody>
										<?php
										//echo "SELECT SHOP_ITEM.`cart_id`, SHOP_ITEM.`od_id`, SHOP_ITEM.`pd_id`, SHOP_ITEM.`variant_id`, SHOP_ITEM.`od_qty`, SHOP_ITEM.`od_price`, SHOP_ITEM.`item_tax_type`, SHOP_ITEM.`item_tax`, SHOP_ITEM.`item_tax1`, SHOP_ITEM.`item_tax2`, PRDT.`producttitle`, PRDT.`productsku` FROM `js_shop_order_item` AS SHOP_ITEM, `js_product` AS PRDT where SHOP_ITEM.`pd_id` = PRDT.`productID` and SHOP_ITEM.`od_id` = '$odid' and SHOP_ITEM.deleted = '0' and SHOP_ITEM.status = '1'";
										$featured_product_data = sqlQUERY_LABEL("SELECT SHOP_ITEM.`cart_id`, SHOP_ITEM.`od_id`, SHOP_ITEM.`pd_id`, SHOP_ITEM.`variant_id`, SHOP_ITEM.`od_qty`, SHOP_ITEM.`od_price`, SHOP_ITEM.`item_tax_type`, SHOP_ITEM.`item_tax`, SHOP_ITEM.`item_tax1`, SHOP_ITEM.`item_tax2`, PRDT.`producttitle`, PRDT.`productsku` FROM `js_shop_order_item` AS SHOP_ITEM, `js_product` AS PRDT where SHOP_ITEM.`pd_id` = PRDT.`productID` and SHOP_ITEM.`od_id` = '$odid' and SHOP_ITEM.deleted = '0'") or die("#1-Unable to get records:".mysqli_error());
										$check_product_data_num_rows = sqlNUMOFROW_LABEL($featured_product_data);
										
										if($check_product_data_num_rows > 0 ) {
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
											  $productmedia_datas = sqlQUERY_LABEL("SELECT productmediagalleryID, productmediagalleryurl, productmediagallerytype FROM `js_productmediagallery` where productID='$pd_id' and deleted = '0' order by productmediagalleryurl ASC") or die("#2-Unable to get records:".mysqli_error());			
												$count_productmedia_availablecount = sqlNUMOFROW_LABEL($productmedia_datas);	
												while($row = sqlFETCHARRAY_LABEL($productmedia_datas)){
												  $productmediagalleryID = $row["productmediagalleryID"];
												  $productmediagalleryurl = $row["productmediagalleryurl"];
												  $productmediagallerytype = $row["productmediagallerytype"];
												  //image path
												  $media_path = "uploads/productmediagallery/$productmediagalleryurl";
																										
												}
										?>
										<tr class="">
											<td class="product-name" width="75%">
												<div class="row">
												<div class="col-md-3">
												<a href="product.php?token=<?php echo $pd_id.'-'.$productsku; ?>" class="product-image">
													<img src="<?php echo $media_path?>" style="padding:10px; background-color:white; height:90%; width:90%;">
												</a></div>
												<div class="col-md-8 pt-3 pb-3">
												<a href="product.php?token=<?php echo $pd_id.'-'.convertSEOURL($producttitle).'-'.$productsku; ?>">
												<?php echo $producttitle; ?>
												</a>
												<strong class="product-quantity"> × <?php echo $od_qty; ?></strong>
												<br>
												<?php if($variant_id !='0'){ ?>
													<small><?php echo 'Size: '.getVARIANT_CODE($variant_id,'variant_name_from_variant_ID'); ?></small>
												<?php } ?>
												</div>
												</div>
											</td>
											<td class="">
												<span class="kreen-Price-amount amount"><span class="kreen-Price-currencySymbol"><?php echo general_currency_symbol; ?></span><?php echo formatCASH($item_total -$item_taxonly); ?>
												<small>( + <?php echo $item_taxonly; ?> TAX )</small>&nbsp;<br>	
												<del><span class="kreen-Price-amount amount text-light"><span class="kreen-Price-currencySymbol text-light"><?php echo general_currency_symbol; ?></span><?php echo (getMRPprice($pd_id, $variant_id,$od_qty)); ?></span> </del></span></span>
											</td>
										</tr>
										<?php } 
										}  else {
										?>
										<tr class="order_item">
											<td class="text-center" colspan="2">No Items Added</td>
										</tr>
										<?php
										}
										?>
									</tbody>
									
								</table>-->
								</div>
							</div>
							<?php } ?>
							</div><!-- .End .tab-pane -->
							<div class="tab-pane fade" id="tab-downloads" role="tabpanel" aria-labelledby="tab-downloads-link">
								<p>No downloads available yet.</p>
								<a href="category.html" class="btn btn-outline-primary-2"><span>GO SHOP</span><i class="icon-long-arrow-right"></i></a>
							</div><!-- .End .tab-pane -->

							<div class="tab-pane fade" id="tab-address" role="tabpanel" aria-labelledby="tab-address-link">
								<p>The following addresses will be used on the checkout page by default.</p>

								<div class="row">
									 <?php	$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_billing_address` where deleted = '0' and `customerID`='$logged_user_id'") or die("Unable to get records:".sqlERROR_LABEL());				
									$check_record_availabity = sqlNUMOFROW_LABEL($list_datas);			

									while($row = sqlFETCHARRAY_LABEL($list_datas)){
									  $bill_fname = $row["bill_fname"];
									  $bill_lname = $row["bill_lname"];
									  $bill_company = $row["bill_company"];
									  $bill_country = $row["bill_country"];
									  $bill_street1 = $row["bill_street1"];
									  $bill_street2 = $row["bill_street2"];
									  $bill_city = $row["bill_city"];
									  $bill_state = $row["bill_state"];
									  $bill_pin = $row["bill_pin"];
									}
									?>
									<div class="u-column1 col-lg-6 kreen-Address">
										<header class="kreen-Address-title title">
											<h3>Billing address</h3>
											<?php if($check_record_availabity > '0'){ ?>
											<a href="#"  onclick="billing_addresschange();" class="edit">Edit Billing Address</a>
											<?php }else{ ?>
											<a href="#"  onclick="billing_addresschange();" class="edit">Create Billing Address</a>
											<?php }  ?>
											
										</header>
										
										<form method='post' id="billing_address_edit" style="display:none">
										
										<div class="row">
											<div class="form-group col-6" >	
												<label for="bill_fname">First Name</label>									 
												<input type="text" class="form-control" id="bill_fname" name="bill_fname"  value="<?php echo $bill_fname ?>">
											</div>
											<div class="form-group col-6" >	
												<label for="bill_lname">Last Name</label>									 
												<input type="text" class="form-control" id="bill_lname" name="bill_lname"  value="<?php echo $bill_lname?>">
											</div>
											<div class="form-group col-6" >	
												<label for="bill_street1">Address #1</label>									 
												<input type="text" class="form-control" id="bill_street" name="bill_street1" value="<?php echo $bill_street1 ?>">
											</div>
											<div class="form-group col-6" >	
												<label for="bill_street2">Address #2</label>									 
												<input type="text" class="form-control" id="bill_street2" name="bill_street2" value="<?php echo $bill_street2 ?>">
											</div>
											<div class="form-group col-6" >	
												<label for="bill_city">Town/City</label>									 
												<input type="text" class="form-control" id="bill_city" name="bill_city" value="<?php echo $bill_city ?>">
											</div>
											<div class="form-group col-6" >	
												<label for="bill_state">State</label>									 
												<input type="text" class="form-control" id="bill_state" name="bill_state" value="<?php echo $bill_state ?>">
											</div><div class="form-group col-6" >	
												<label for="bill_country">Country</label>									 
												<input type="text" class="form-control" id="bill_country" name="bill_country"  value="<?php echo $bill_country?>">
											</div><div class="form-group col-6" >	
												<label for="bill_pin">Pin Code</label>									 
												<input type="text" class="form-control" id="bill_pin" name="bill_pin" value="<?php echo $bill_pin?>">
											</div>
										</div>
											   <button type="submit" class="btn btn-outline-primary-2 button col-12" name="addbilling_address" value="billing_address">Save</button>
										</form>
										
										<div  id="billing_address">
										
										<p><?php echo $bill_fname.' '.$bill_lname ?><br><?php echo $bill_company; ?><br><?php echo $bill_country; ?><br><?php echo $bill_street1; ?><br><?php echo $bill_city.','.$bill_state; ?><br><?php echo $bill_pin; ?></p>
										</div>
									
									</div>
									<?php	
									//echo "SELECT * FROM `js_shipping_address` where deleted = '0' and `customerID`='$logged_user_id'";
										$list_datas_ship = sqlQUERY_LABEL("SELECT * FROM `js_shipping_address` where deleted = '0' and `customerID`='$logged_user_id'") or die("Unable to get records:".sqlERROR_LABEL());			
										$check_record_availabity2 = sqlNUMOFROW_LABEL($list_datas_ship);			
											while($row_ship = sqlFETCHARRAY_LABEL($list_datas_ship)){
											  $ship_fname = $row_ship["ship_fname"];
											  $ship_lname = $row_ship["ship_lname"];
											  $ship_company = $row_ship["ship_company"];
											  $ship_country = $row_ship["ship_country"];
											  $ship_street1 = $row_ship["ship_street1"];
											  $ship_street2 = $row_ship["ship_street2"];
											  $ship_city = $row_ship["ship_city"];
											  $ship_state = $row_ship["ship_state"];
											  $ship_pin = $row_ship["ship_pin"];
											}
									?>
									<div class="u-column1 col-lg-6 kreen-Address">
										<header class="kreen-Address-title title">
											<h3>Shipping address</h3>
											<?php if($check_record_availabity2 > '0'){?>
											<a href="javascript:;"  onclick="shipping_addresschange();" class="edit">Edit Shipping Address</a>
											<?php }else{ ?>
											<a href="javascript:;"  onclick="shipping_addresschange();" class="edit">Create Shipping Address</a>
											<?php }?>
										</header>
										
										<form method='post' id="shipping_address_edit" style="display:none">
										<div class="row">
											<div class="form-group col-6" >	
												<label for="ship_fname">First Name</label>									 
												<input type="text" class="form-control" id="ship_fname" name="ship_fname" value="<?php echo $ship_fname ?>">
											</div>
											<div class="form-group col-6" >	
												<label for="ship_lname">Last Name</label>									 
												<input type="text" class="form-control" id="ship_lname" name="ship_lname" value="<?php echo $ship_lname ?>">
											</div>
											<div class="form-group col-6" >	
												<label for="ship_street1">Address #1</label>									 
												<input type="text" class="form-control" id="ship_street" name="ship_street1" value="<?php echo $ship_street1 ?>">
											</div>
											<div class="form-group col-6" >	
												<label for="ship_street2">Address #2</label>									 
												<input type="text" class="form-control" id="ship_street2" name="ship_street2" value="<?php echo $ship_street2 ?>">
											</div>
											<div class="form-group col-6" >	
												<label for="ship_city">Town/City</label>									 
												<input type="text" class="form-control" id="ship_city" name="ship_city" value="<?php echo $ship_city ?>">
											</div>
											<div class="form-group col-6" >	
												<label for="ship_state">State</label>									 
												<input type="text" class="form-control" id="ship_state" name="ship_state" value="<?php echo $ship_state ?>">
											</div>
											<div class="form-group col-6" >	
												<label for="ship_country">Country</label>									 
												<input type="text" class="form-control" id="ship_country" name="ship_country" value="<?php echo $ship_country ?>">
											</div><div class="form-group col-6" >	
												<label for="ship_pin">Pin Code</label>									 
												<input type="text" class="form-control" id="ship_pin" name="ship_pin" value="<?php echo $ship_pin ?>">
											</div>
										</div>
											   <button type="submit" class="btn button btn-outline-primary-2 col-12" name="addshiping_address" value="shiping_address">Save</button>
										</form>
										<div  id="shipping_address">
										
											<p><?php echo $ship_fname.' '.$ship_lname ?><br><?php echo $ship_company; ?><br><?php echo $ship_country; ?><br><?php echo $ship_street1; ?><br><?php echo $ship_city.','.$ship_state; ?><br><?php echo $ship_pin; ?></p>
										</div>
									</div>
								</div><!-- End .row -->
							</div><!-- .End .tab-pane -->

							<div class="tab-pane fade" id="tab-account" role="tabpanel" aria-labelledby="tab-account-link">
								<form action="#">
									<?php
									$query= "SELECT * FROM `js_users` where userID='$logged_user_id' and deleted='0'";
												// echo $query;
									$result = sqlQUERY_LABEL($query);
										 while($row = sqlFETCHARRAY_LABEL($result))
											{	
												$username = $row['username'];							
												$useremail = $row['useremail'];							
												$password = $row['password'];							
													
											}
									$query= "SELECT * FROM `js_customer` where customerID='$logged_user_id' and deleted='0'";
												// echo $query;
									$result = sqlQUERY_LABEL($query);
										 while($row = sqlFETCHARRAY_LABEL($result))
											{	
												$customeraddress1 = $row['customeraddress1'];							
												$customeraddress2 = $row['customeraddress2'];							
												//$password = $row['password'];							
													
											}
									?>

									<label>Name *</label>
									<input type="text" id="cus_name" name="cus_name" class="form-control" value="<?php echo $username ?>" required>
									<small class="form-text">This will be how your name will be displayed in the account section and in reviews</small>

									<label>Email address *</label>
									<input type="email" id="cus_email" name="cus_email" class="form-control" value="<?php echo $useremail ?>" required>
									<label>Billing address *</label>
									<textarea type="email" id="customeraddress1" name="customeraddress1" class="form-control" required style="min-height: 10px;"><?php echo $customeraddress1 ?></textarea>
									<label>Shipping address *</label>
									<textarea type="email" id="customeraddress2" name="customeraddress2" class="form-control"  required style="min-height: 10px;"><?php echo $customeraddress2 ?></textarea>

									<label>Current password (leave blank to leave unchanged)</label>
									<input type="password" id="cus_pwd" name="cus_pwd" class="form-control">
									
									<label>New password (leave blank to leave unchanged)</label>
									<input type="password" id="new_pwd" name="new_pwd" class="form-control">

									<label>Confirm new password</label>
									<input type="password" id="confirm_pwd" name="confirm_pwd" class="form-control mb-2">

									<button type="button" onclick="cus_profile();" class="btn btn-outline-primary-2">
										<span id="save_profile">SAVE CHANGES</span>
										<i class="icon-long-arrow-right"></i>
									</button>
								</form>
							</div><!-- .End .tab-pane -->
							<?php } else { 
							$order_ID = $odid;
							?>
							<div id="product-accordion-review" class="collapse show" aria-labelledby="product-review-heading" data-parent="#product-accordion" style="padding: 22px;">
								<p class="comment-notes"><span id="email-notes">Your email address will not be published.</span>
									
										Required fields are marked <span class="required">*</span></p>
								   
										<?php 
										$customer_name = getSINGLEDBVALUE('customerfirst',"user_id='$logged_user_id'",'js_customer','label');
										?>
									 <input type="hidden" name="order_id" id="order_id" value="<?php echo $odid?>">
										 <input size="25" class="form-control col-md-8" name="review_name" id="review_name" type="hidden" value="<?php echo $customer_name; ?>">
									
										<input size="25" type="hidden" class="form-control col-md-8" name="review_email" id="review_email" value="<?php echo $_SESSION['reg_user_name'];?>">
									<div class="comment-form-rating" style="margin-top:20px"><label for="rating">Your rating </label> <span class="required">*</span><br>
									 <div class="rating">
										<input type="radio" id="star5" name="ratings-val" value="5"><label for="star5" title="Rocks!">5 stars</label>
										<input type="radio" id="star4" name="ratings-val" value="4"><label for="star4" title="Pretty good">4 stars</label>
										<input type="radio" id="star3" name="ratings-val" value="3"><label for="star3" title="Meh">3 stars</label>
										<input type="radio" id="star2" name="ratings-val" value="2"><label for="star2" title="Kinda bad">2 stars</label>
										<input type="radio" id="star1" name="ratings-val" value="1"><label for="star1" title="Sucks big time">1 star</label>
									</div>
									</div>
									  <br><br>	
									 <label for="comment">Your review<span class="required">*</span></label>
										<textarea name="review_discription" id="review_discription" cols="60" rows="6" maxlength="150" onkeypress="return IsAlphaNumeric(event);" ondrop="return false;" onpaste="return false;" style="width:100%;" class="col-md-8 form-control"></textarea>
											<span id="error" style="color: Red; display: none;">* Special Characters not allowed.</span><br>
								<button type="button" name="Submit_review" id="Submit_review" onclick="add_order_review(<?php echo $order_ID; ?>);" class="btn button" value="Submit_review" style="background-color:black;color:white;width:150px;height:40px;"> Submit</button><br><br>
                               
								</div>
							<?php } ?>
							<?php if($mode == 'cancel'){ 
							
							$orderID = $order;
							
							$__main_order_details_query = sqlQUERY_LABEL("select * FROM `js_shop_order` where `od_userid`='$logged_user_id' and `od_id`='$orderID'") or die(sqlERROR_LABEL());
							$check_main_order_num_rows = sqlNUMOFROW_LABEL($__main_order_details_query);
							
							if($check_main_order_num_rows > 0) {
								$__main_order_data = sqlFETCHASSOC_LABEL($__main_order_details_query);	
								$orderID = $__main_order_data['od_id'];
								$od_refno = $__main_order_data['od_refno'];
								$orderSTATUS = $__main_order_data['od_status'];
								$customername = $__main_order_data['od_shipping_first_name'];
								$customeremail = $__main_order_data['od_payment_email'];
								
							}
							 
							
							if($action == '') {
							    
							?>
    							 <h4 class="text-center">Do you really want to cancel the Order #<?php echo $od_refno; ?>.</h4>
    							 <div class="text-center">
    								<?php
    								//check order status
    								if(in_array($orderSTATUS, array(1,2,3))) {
    								?>
    								<a class="btn btn-sm btn-danger" href="<?php echo SITEHOME; ?>myorders.php?mode=cancel&action=confirm&order=<?php echo $orderID; ?>">Yes, Cancel My Order</a>
    								<?php } ?>
    								<a class="btn btn-sm btn-dark" href="<?php echo SITEHOME; ?>myorders.php?mode=preview&odid=<?php echo $orderID; ?>">Back to Orders Details</a>
    							</div>
							<?php 
							    
							} else {
							  
							  
							    	$arrFields1 = array('`od_status`');
                                    $arrValues1 = array("7");
                                    $sqlWhere1  =  "od_id = $orderID and od_userid = $logged_user_id";
									 // echo $sqlWhere1;exit();
                                    if(sqlACTIONS("UPDATE","js_shop_order",$arrFields1, $arrValues1, $sqlWhere1)){
                                       
									     $arrFields = array('`od_status_item`');
									     $arrValues = array("7");
										 $sqlWhere  =  "od_id = $orderID and user_id = $logged_user_id";
										 sqlACTIONS("UPDATE","js_shop_order_item",$arrFields,$arrValues,$sqlWhere); 
                                        //upating log
                                        $description = "Order ".$od_refno." Cancelled";
										//echo $description;exit();
                                		$arrFields_log = array('`pd_id`', '`od_id`', '`od_status`', '`log_description`', '`status`');
                                		$arrValues_log = array("$product_id", "$orderID", "7", "$description", "1");
                                		sqlACTIONS("INSERT","js_shop_order_log",$arrFields_log,$arrValues_log, ''); 
										
										
										
            $subject = 'Your - #'.$od_refno.' Cancelled' ;
			$to = $customeremail;// $project_email;//
			$cc = 'mohan@touchmarkdes.com';//info@touchmarkdes.com
			$Bcc = ''; //info@touchmarkdes.com
			$from = "Rarefashion - Order Status<notification@touchmarkdes.space>";
			 
			$mail_template = '<table style="border:#000000 solid 1px;background:#ffffff" width="599" cellspacing="0" cellpadding="0" border="0" align="center">
          <tbody>
            <tr>
              <td style="background: #000;text-align: center;align-content: center;" valign="top" align="center"><img alt="Rarefashion Logo" style="padding:18px 10px 10px;" class="CToWUd" src="'.SEOURL.'assets/images/logo-light.png" height="50" border="0"></td>
            </tr>
            <tr>
              <td style="padding: 25px 10px 10px;" valign="top" align="center"><table width="535" cellspacing="0" cellpadding="0" border="0">
                  <tbody>
                    <tr>
                      <td valign="top" align="left"><strong style="font-size: 16px;line-height: 30px;padding-bottom: 15px;display: block;">Dear '.$customername.',</strong></td>
                    </tr>
                    <tr>
                      <td valign="top" align="left">Your Order <b> Cancelled</b> </td>
                    </tr>
                    <tr>
                      <td valign="top" align="left"> For any queries, please contact <a href="https://touchmarkdes.space/rarefashions/">Rarefashions</a> <br>
                        <br>
                        Regards,<br>
                        Team <span>Rarefashion</span></td>
                    </tr>
                    <tr>
                      <td style="padding:0 0 20px 0" valign="top" align="left"><img src="https://i.imgur.com/qe8OmqF.jpg" style="display:block" alt="Seprator image" class="CToWUd" width="535" height="2" border="0"></td>
                    </tr>
                    <tr>
                      <td valign="top" align="center"> © 2021. All rights reserved</td>
                    </tr>          </tbody>
                </table></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
          </tbody>
        </table>';
	  //echo $from,$to,$cc,$Bcc,$subject,$mail_template;  exit();
	
	 if(send_mail($from,$to,$cc,$Bcc,$subject,$mail_template)) {
      } else {
         if (!send_mail($from,$to,$cc,$Bcc,$subject,$mail_template, false)) {
         
           if (!empty($error)) { echo $error; } 
          }     
        }                                    
                                        // echo "select `pd_id`, `variant_id`, `od_qty` from js_shop_order_item where od_id = '$orderID'"; exit();
                                        //returning stocks
                                        $check_selecteditem = sqlQUERY_LABEL("select `pd_id`, `variant_id`, `od_qty` from js_shop_order_item where od_id = '$orderID'") or die(sqlERROR_LABEL());
                        				while($collect_selecteditem = sqlFETCHARRAY_LABEL($check_selecteditem)) {
                        
                        					$pd_id = $collect_selecteditem['pd_id'];
                        					$variant_id = $collect_selecteditem['variant_id'];                       		
                        					$od_qty = $collect_selecteditem['od_qty'];
											
											//product table updated
										if($variant_id == '0'){
											
											$check_master_stock = sqlQUERY_LABEL("select `productsku`,`productopeningstock`, `productavailablestock` from js_product where productID='$pd_id'") or die(sqlERROR_LABEL());

											while($collect_master_stock = sqlFETCHARRAY_LABEL($check_master_stock)) {
												$productopeningstock = $collect_master_stock['productopeningstock'];
												$productavailablestock = $collect_master_stock['productavailablestock'];
												$productsku = $collect_master_stock['productsku'];
											}
											
											if($productavailablestock >= $od_qty){

												$new_estore_qty = $productavailablestock + $od_qty;
												
											}
											
                        					$today = date('d/m/Y');
                        					$ord_ref_no = getORDERREF_USING_ODID($orderID);
											
                            				$log_description = "$od_qty Qty return for order #$ord_ref_no.  Opening Stock: $productavailablestock / Available Stock: $new_estore_qty Qty on $today";
                            				
                            				$arrFields_log = array('`od_id`', '`prdt_id`', '`variant_id`', '`od_qty`', '`estore_code`', '`log_description`', '`createdby`', '`status`');
                            				
                            				$arrValues_log = array("$orderID", "$pd_id", "$variant_id", "$od_qty", "$productsku", "$log_description", "$logged_customer_id");
											
                            				if(sqlACTIONS("INSERT","js_estore_stock_deduct_log",$arrFields_log,$arrValues_log, '')){
                            
                            				}
									
											$arrFields = array('`productavailablestock`');
												$arrValues = array("$new_estore_qty");
												$sqlwhere ="productID ='$pd_id'";
												if(sqlACTIONS("UPDATE","js_product",$arrFields,$arrValues, $sqlwhere)){
												}
											
										}else{
											
											//variant table updated
											
											// echo "select `variant_code`,`variant_opening_stock`,`variant_available_stock` from js_productvariants where variant_ID='$variant_id'"; exit();
											$check_master_stock = sqlQUERY_LABEL("select `variant_code`,`variant_opening_stock`,`variant_available_stock` from js_productvariants where variant_ID='$variant_id'") or die(sqlERROR_LABEL());

											while($collect_master_stock = sqlFETCHARRAY_LABEL($check_master_stock)) {
												$productopeningstock = $collect_master_stock['variant_opening_stock'];
												$productavailablestock = $collect_master_stock['variant_available_stock'];
												$productsku = $collect_master_stock['variant_code'];
											}
											
											// if($productavailablestock >= $od_qty){

												$new_estore_qty = $productavailablestock + $od_qty;
												
											// }
                        					$today = date('d/m/Y');
                        					$ord_ref_no = getORDERREF_USING_ODID($orderID);
											
                            				$log_description = "$od_qty Qty return for order #$ord_ref_no.  Opening Stock: $productavailablestock / Available Stock: $new_estore_qty Qty on $today";
                            				
                            				$arrFields_log = array('`od_id`', '`prdt_id`', '`variant_id`', '`od_qty`', '`estore_code`', '`log_description`', '`createdby`', '`status`');
                            				
                            				$arrValues_log = array("$orderID", "$pd_id", "$variant_id", "$od_qty", "$productsku", "$log_description", "$logged_user_id");
											
                            				if(sqlACTIONS("INSERT","js_estore_stock_deduct_log",$arrFields_log,$arrValues_log, '')){
                            
                            				}
									
											$arrFields = array('`variant_available_stock`');
												$arrValues = array("$new_estore_qty");
												$sqlwhere ="variant_ID ='$variant_id'";
												if(sqlACTIONS("UPDATE","js_productvariants",$arrFields,$arrValues, $sqlwhere)){
												}
											
											
										}
                            
											
                            			
                            			} //edn of while loop
                                       
                                       //on successful update re-direct
                                       ?>
                                            <script type="text/javascript">
                                                window.location = '<?php echo SITEHOME; ?>dashboard.php?nav=order'
                                            </script>
                                       <?php
                                    }
							
							?>
							
    							<div class="text-center">
        							<h4>Please wait while we cancel your order...</h4>
        							<p>Do not press back button or refresh button</p>
    							</div>
    							
							<?php }  } ?>
		
						</div>
					</div><!-- End .col-lg-9 -->
				</div><!-- End .row -->
			</div><!-- End .container -->
		</div><!-- End .dashboard -->
	</div><!-- End .page-content -->
</main><!-- End .main -->

</div><!-- End .page-wrapper -->
<button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

<!-- Mobile Menu -->
<div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

<div class="mobile-menu-container">
<div class="mobile-menu-wrapper">
	<span class="mobile-menu-close"><i class="icon-close"></i></span>

	<form action="#" method="get" class="mobile-search">
		<label for="mobile-search" class="sr-only">Search</label>
		<input type="search" class="form-control" name="mobile-search" id="mobile-search" placeholder="Search in..." required>
		<button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
	</form>
	
	<nav class="mobile-nav">
		<ul class="mobile-menu">
			<li class="active">
				<a href="index.html">Home</a>

				<ul>
					<li><a href="index-1.html">01 - furniture store</a></li>
					<li><a href="index-2.html">02 - furniture store</a></li>
					<li><a href="index-3.html">03 - electronic store</a></li>
					<li><a href="index-4.html">04 - electronic store</a></li>
					<li><a href="index-5.html">05 - fashion store</a></li>
					<li><a href="index-6.html">06 - fashion store</a></li>
					<li><a href="index-7.html">07 - fashion store</a></li>
					<li><a href="index-8.html">08 - fashion store</a></li>
					<li><a href="index-9.html">09 - fashion store</a></li>
					<li><a href="index-10.html">10 - shoes store</a></li>
					<li><a href="index-11.html">11 - furniture simple store</a></li>
					<li><a href="index-12.html">12 - fashion simple store</a></li>
					<li><a href="index-13.html">13 - market</a></li>
					<li><a href="index-14.html">14 - market fullwidth</a></li>
					<li><a href="index-15.html">15 - lookbook 1</a></li>
					<li><a href="index-16.html">16 - lookbook 2</a></li>
					<li><a href="index-17.html">17 - fashion store</a></li>
					<li><a href="index-18.html">18 - fashion store (with sidebar)</a></li>
					<li><a href="index-19.html">19 - games store</a></li>
					<li><a href="index-20.html">20 - book store</a></li>
					<li><a href="index-21.html">21 - sport store</a></li>
					<li><a href="index-22.html">22 - tools store</a></li>
					<li><a href="index-23.html">23 - fashion left navigation store</a></li>
					<li><a href="index-24.html">24 - extreme sport store</a></li>
				</ul>
			</li>
			<li>
				<a href="category.html">Shop</a>
				<ul>
					<li><a href="category-list.html">Shop List</a></li>
					<li><a href="category-2cols.html">Shop Grid 2 Columns</a></li>
					<li><a href="category.html">Shop Grid 3 Columns</a></li>
					<li><a href="category-4cols.html">Shop Grid 4 Columns</a></li>
					<li><a href="category-boxed.html"><span>Shop Boxed No Sidebar<span class="tip tip-hot">Hot</span></span></a></li>
					<li><a href="category-fullwidth.html">Shop Fullwidth No Sidebar</a></li>
					<li><a href="product-category-boxed.html">Product Category Boxed</a></li>
					<li><a href="product-category-fullwidth.html"><span>Product Category Fullwidth<span class="tip tip-new">New</span></span></a></li>
					<li><a href="cart.html">Cart</a></li>
					<li><a href="checkout.html">Checkout</a></li>
					<li><a href="wishlist.html">Wishlist</a></li>
					<li><a href="#">Lookbook</a></li>
				</ul>
			</li>
			<li>
				<a href="product.html" class="sf-with-ul">Product</a>
				<ul>
					<li><a href="product.html">Default</a></li>
					<li><a href="product-centered.html">Centered</a></li>
					<li><a href="product-extended.html"><span>Extended Info<span class="tip tip-new">New</span></span></a></li>
					<li><a href="product-gallery.html">Gallery</a></li>
					<li><a href="product-sticky.html">Sticky Info</a></li>
					<li><a href="product-sidebar.html">Boxed With Sidebar</a></li>
					<li><a href="product-fullwidth.html">Full Width</a></li>
					<li><a href="product-masonry.html">Masonry Sticky Info</a></li>
				</ul>
			</li>
			<li>
				<a href="#">Pages</a>
				<ul>
					<li>
						<a href="about.html">About</a>

						<ul>
							<li><a href="about.html">About 01</a></li>
							<li><a href="about-2.html">About 02</a></li>
						</ul>
					</li>
					<li>
						<a href="contact.html">Contact</a>

						<ul>
							<li><a href="contact.html">Contact 01</a></li>
							<li><a href="contact-2.html">Contact 02</a></li>
						</ul>
					</li>
					<li><a href="login.html">Login</a></li>
					<li><a href="faq.html">FAQs</a></li>
					<li><a href="404.html">Error 404</a></li>
					<li><a href="coming-soon.html">Coming Soon</a></li>
				</ul>
			</li>
			<li>
				<a href="blog.html">Blog</a>

				<ul>
					<li><a href="blog.html">Classic</a></li>
					<li><a href="blog-listing.html">Listing</a></li>
					<li>
						<a href="#">Grid</a>
						<ul>
							<li><a href="blog-grid-2cols.html">Grid 2 columns</a></li>
							<li><a href="blog-grid-3cols.html">Grid 3 columns</a></li>
							<li><a href="blog-grid-4cols.html">Grid 4 columns</a></li>
							<li><a href="blog-grid-sidebar.html">Grid sidebar</a></li>
						</ul>
					</li>
					<li>
						<a href="#">Masonry</a>
						<ul>
							<li><a href="blog-masonry-2cols.html">Masonry 2 columns</a></li>
							<li><a href="blog-masonry-3cols.html">Masonry 3 columns</a></li>
							<li><a href="blog-masonry-4cols.html">Masonry 4 columns</a></li>
							<li><a href="blog-masonry-sidebar.html">Masonry sidebar</a></li>
						</ul>
					</li>
					<li>
						<a href="#">Mask</a>
						<ul>
							<li><a href="blog-mask-grid.html">Blog mask grid</a></li>
							<li><a href="blog-mask-masonry.html">Blog mask masonry</a></li>
						</ul>
					</li>
					<li>
						<a href="#">Single Post</a>
						<ul>
							<li><a href="single.html">Default with sidebar</a></li>
							<li><a href="single-fullwidth.html">Fullwidth no sidebar</a></li>
							<li><a href="single-fullwidth-sidebar.html">Fullwidth with sidebar</a></li>
						</ul>
					</li>
				</ul>
			</li>
			<li>
				<a href="elements-list.html">Elements</a>
				<ul>
					<li><a href="elements-products.html">Products</a></li>
					<li><a href="elements-typography.html">Typography</a></li>
					<li><a href="elements-titles.html">Titles</a></li>
					<li><a href="elements-banners.html">Banners</a></li>
					<li><a href="elements-product-category.html">Product Category</a></li>
					<li><a href="elements-video-banners.html">Video Banners</a></li>
					<li><a href="elements-buttons.html">Buttons</a></li>
					<li><a href="elements-accordions.html">Accordions</a></li>
					<li><a href="elements-tabs.html">Tabs</a></li>
					<li><a href="elements-testimonials.html">Testimonials</a></li>
					<li><a href="elements-blog-posts.html">Blog Posts</a></li>
					<li><a href="elements-portfolio.html">Portfolio</a></li>
					<li><a href="elements-cta.html">Call to Action</a></li>
					<li><a href="elements-icon-boxes.html">Icon Boxes</a></li>
				</ul>
				</li>
			</ul>
		</nav><!-- End .mobile-nav -->

		<div class="social-icons">
			<a href="#" class="social-icon" target="_blank" title="Facebook"><i class="icon-facebook-f"></i></a>
			<a href="#" class="social-icon" target="_blank" title="Twitter"><i class="icon-twitter"></i></a>
			<a href="#" class="social-icon" target="_blank" title="Instagram"><i class="icon-instagram"></i></a>
			<a href="#" class="social-icon" target="_blank" title="Youtube"><i class="icon-youtube"></i></a>
		</div><!-- End .social-icons -->
	</div><!-- End .mobile-menu-wrapper -->
</div><!-- End .mobile-menu-container -->