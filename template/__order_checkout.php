<main class="main">
	<nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-2" style="background-color:#f9f9f9;">
		<div class="container d-flex align-items-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="index.php">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Checkout</li>
			</ol>
		</div><!-- End .container -->
	</nav><!-- End .breadcrumb-nav -->

	<div class="page-content"><!--Start .page-content -->
		<div class="container"><!-- Start .container -->
		<form name="checkout" method="post" class="checkout kreen-checkout" action="" enctype="multipart/form-data" data-parsley-validate>
		<div class="row">
			<div class="col-md-7">
				<div class="billing-address">
				<div class="row">
					<style>
					.labl > input:checked + div{ /* (RADIO CHECKED) DIV STYLES */
						background-color: #ffd6bb;
						border: 1px solid #ff6600;
					}
					</style>
	<div class="modal fade" id="addressDATA" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-14" style="border-radius: 20px;padding: 5px;">
		
          <div class="modal-header">
		 
          <div class="row">
			<h4 class=" col-12">Use Saved Address</h5><hr></hr>
						<?php 
							$list_data_ship = sqlQUERY_LABEL("SELECT * FROM `js_shipping_address` where deleted = '0' and `customerID`='$logged_user_id'") or die("Unable to get records:".sqlERROR_LABEL());			
							$check_record_availabity = sqlNUMOFROW_LABEL($list_data_ship);		
							if($check_record_availabity != 0){
								$display = 'style="display:none;"';
							} else {
								$display = 'style="display:block;"';
							}
						while($row_ships = sqlFETCHARRAY_LABEL($list_data_ship)){
						  $shipping_id = $row_ships["Id"];
						  $ship_fname = $row_ships["ship_fname"];
						  $ship_lname = $row_ships["ship_lname"];
						  $ship_company = $row_ships["ship_company"];
						  $ship_country = $row_ships["ship_country"];
						  $ship_phone = $row_ships["ship_phone"];
						  $ship_street1 = $row_ships["ship_street1"];
						  $ship_street2 = $row_ships["ship_street2"];
						  $ship_city = $row_ships["ship_city"];
						  $ship_state = $row_ships["ship_state"];
						  $ship_pin = $row_ships["ship_pin"]; 
							?>
						<p align='center' id='check' class=''></p>
						<div class="col-md-6 mb-3">
						
						
						<div id="demo1" onmouseover="mouseOver()" onmouseout="mouseOut()" class="card labl element" style="height:100%;border-radius: 15px;padding: 3px; width:270px">
							<div class="card-body row">
							<div class="col-10">
							<h6 class="card-title"><b><?php echo $ship_fname.' '.$ship_lname;?></b></h6>
							</div>
							<div class="col-2">
							<input type="radio" name="radioname" value="<?php echo $shipping_id ?>"  onclick="check_address(<?php echo $shipping_id ?>);" style="height:15px; width:15px;"/>
							</div><hr/>
							<p class="card-text" style="padding-left:13px">
							<?php
							if($ship_phone != ''){
								$mobile_number = ',</br> Mobile Number: '.$ship_phone;
							}
							if($ship_street2 == ''){
								$ship_address = $ship_street1.', </br> '.$ship_city.',</br>'.$ship_state.' - '.$ship_pin.',</br> '.$ship_country.$mobile_number;
							} else {
								$ship_address = $ship_street1.', '.$ship_street2.',</br> '.$ship_city.', '.$ship_state.' - '.$ship_pin.',</br> '.$ship_country.$mobile_number;
							}
							echo $ship_address; ?>
							</p>
						  </div>
						</div>
						<input type="hidden" name="card_id" id="card_id" class="card_id" value="<?php echo $shipping_id; ?>"/>
						
						</div>
					
						<?php } ?>
						 </div> <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">Cancel</span>
            </button>
						 </div>
           
        </div>
      </div>
    </div>	
					</div>
				<div class="row">
				<div class="col-md-6">
				<h3>Addresses</h3>
				</div>
					<?php
							$list_data_ship = sqlQUERY_LABEL("SELECT * FROM `js_shipping_address` where deleted = '0' and `customerID`='$logged_user_id'") or die("Unable to get records:".sqlERROR_LABEL());			
								$check_record_availabity = sqlNUMOFROW_LABEL($list_data_ship);		
								if($check_record_availabity != '0'){
					  ?>
						<div class="text-right col-md-6"> <a href="javascript:;" class="add_address" onclick="form_display_shipping_address();"> + Use Saved Address </a></div>
					<?php } else { ?>
						<div class="text-right col-md-6"></div>
					<?php } ?>
					<div class="col-md-6">
						<label for="billing_first_name"> First Name <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="billing_first_name" id="billing_first_name" value="<?php echo $_checkout_payment_fname; ?>"  maxlength="30" value="" placeholder="First Name" data-parsley-trigger="keyup" autocomplete="off" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" required>
					</div>
					<div class="col-md-6">
						<label for="billing_last_name"> Last Name</label>
						<input type="text" class="form-control" name="billing_last_name" id="billing_last_name" value="<?php echo $_checkout_payment_lname; ?>" maxlength="30" value="" placeholder="Last Name" data-parsley-trigger="keyup" autocomplete="off" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)">
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<label for="billing_phone"> Mobile Number <span class="text-danger">*</span></label>
						<input type="tel" class="form-control" id="billing_phone" name="billing_phone" data-parsley-whitespace="trim" data-parsley-type="number" data-parsley-trigger="keyup" maxlength="10"  autocomplete="off" data-parsley-type="number" placeholder="Mobile Number" required value="<?php echo $_checkout_payment_phone; ?>">
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<label for="billing_email"> Email Address <span class="text-danger">*</span></label>
						<input type="email" class="form-control" id="billing_email" name="billing_email" maxlength="100" required data-parsley-whitespace="trim" data-parsley-type="email" data-parsley-trigger="keyup" autocomplete="off" placeholder="Email Address" value="<?php echo $_SESSION['reg_user_name']; ?>">
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<label for="billing_address_1"> Address #1 <span class="text-danger">*</span></label>
						<input class="form-control" id="billing_address_1" name="billing_address_1" placeholder="Address #1" data-parsley-whitespace="trim" data-parsley-trigger="keyup" autocomplete="off" value="" type="text" required value="<?php echo $_checkout_payment_street1; ?>">
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<label for="billing_address_2"> Address #2 <span class="text-danger"><small>(Optional)</small></span></label>
						<input class="form-control" name="billing_address_2" id="billing_address_2" value="<?php echo $_checkout_payment_street2; ?>" placeholder="Address #2 (Optional)" autocomplete="off" value="" type="text">
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<label for="billing_city"> City <span class="text-danger">*</span></label>
						<input class="form-control" name="billing_city" id="billing_city" value="<?php echo $_checkout_payment_city; ?>" placeholder="City"  data-parsley-whitespace="trim" data-parsley-trigger="keyup" autocomplete="off" value="" type="text" required>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<label for="billing_state"> State <span class="text-danger">*</span></label>
                        <input class="form-control" name="billing_state" id="billing_state" value="<?php echo $_checkout_payment_state; ?>" placeholder="State"  data-parsley-whitespace="trim" data-parsley-trigger="keyup" autocomplete="off" value="" type="text" required>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<label for="billing_postcode"> Pincode <span class="text-danger">*</span></label>
                        <input class="form-control" name="billing_postcode" id="billing_postcode" value="<?php echo $_checkout_payment_pin; ?>" placeholder="Pin Code"  data-parsley-whitespace="trim" maxlength="6" data-parsley-trigger="keyup" autocomplete="off" value="" type="text" required>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<label for="billing_country"> Country <span class="text-danger">*</span></label>
						<input class="form-control" name="billing_country" id="billing_country" value="<?php echo $_checkout_payment_country; ?>" placeholder="Country"  data-parsley-whitespace="trim" data-parsley-trigger="keyup" autocomplete="off" value="" type="text" required>
					</div>
				</div>
				
				<?php if(empty($logged_user_id)){ ?>
				<div class="row">
					<div class="col-md-12 form-check-inline">
						<input type="checkbox" class="form-check-input" name="create_account" id="create_account">
						<label for="create_account" style="padding-top:10px; font-weight:strong;"> <span class="text-danger">Create an account?</label>
					</div>
				</div>
				<?php } ?>
				<!--<div class="row">
					<div class="col-md-12 form-check-inline">
						<input type="checkbox" class="form-check-input" name="address_opt" id="different_address" value="1">
						<label for="different_address" style="padding-top:20px; font-weight:strong;"> <h4><span class="text-danger">Shipping To a different Address?</span></h4></label>
					</div>
				</div>-->
				
				<!--<div class="shipping_address" id="shipping_address">
				<h3>Shipping Details</h3>
				<div class="row">
					<div class="col-md-6">
						<label for="shipping_first_name"> First Name <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="shipping_first_name" id="shipping_first_name" value="" >
					</div>
					<div class="col-md-6">
						<label for="shipping_last_name"> Last Name <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="shipping_last_name" id="shipping_last_name" value="" >
					</div>
				</div>
				
						<div class="row">
							<div class="col-md-12">
								<label for="shipping_phone"> Phone <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="shipping_phone" id="shipping_phone" value="" maxlength="10" >
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<label for="shipping_email"> Email <span class="text-danger">*</span></label>
								<input type="email" class="form-control" name="shipping_email" id="shipping_email" value="" >
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<label for="shipping_address_1"> Street Address #1 <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="shipping_address_1" id="shipping_address_1" value="">
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<label for="shipping_address_2"> Street Address #2 <span class="text-danger"><small>*</small></span></label>
								<input type="text" class="form-control" name="shipping_address_2" id="shipping_address_2" value="" >
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<label for="shipping_city"> Town/City <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="shipping_city" id="shipping_city" value="" >
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<label for="shipping_state"> State <span class="text-danger">*</span></label>
								<select class="form-control" id="shipping_state" name="shipping_state">
									<option value="Tamil Nadu" selected="selected">Tamil Nadu</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<label for="shipping_country"> Country/Region <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="shipping_country" id="shipping_country" value="" >
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<label for="shipping_postcode"> Pincode <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="shipping_postcode" id="shipping_postcode" value="" maxlength="6">
							</div>
						</div>
					</div>-->
				
				<div class="row">
					<div class="col-md-12">
						<label for="pincode"> Order Notes <span class="text-danger"><small>(Optional)</small></span></label>
						<textarea class="form-control" name="order_notes" id="order_notes"></textarea>
					</div>
				</div>
			</div>
			
			</div>
			
			<aside class="col-md-5" style="padding-left:30px">
			<div class="summary">
				<h3 class="summary-title">Your Order</h3>
				<div class="row" style="background-color:#fafafa; padding:10px;">
					<?php 
					
					if(!empty($logged_user_id)){
						
						$featured_product_data = sqlQUERY_LABEL("SELECT SHOP_ITEM.`cart_id`, SHOP_ITEM.`od_id`, SHOP_ITEM.`pd_id`, SHOP_ITEM.`variant_id`, SHOP_ITEM.`od_qty`, SHOP_ITEM.`od_price`, SHOP_ITEM.`item_tax_type`, SHOP_ITEM.`item_tax`, SHOP_ITEM.`item_tax1`, SHOP_ITEM.`item_tax2`, PRDT.`producttitle`, PRDT.`productsku` FROM `js_shop_order_item` AS SHOP_ITEM, `js_product` AS PRDT where SHOP_ITEM.`pd_id` = PRDT.`productID` and SHOP_ITEM.`user_id` = '$logged_user_id'  and SHOP_ITEM.deleted = '0' and SHOP_ITEM.status = '1'") or die("#1-Unable to get records:".mysqli_error());
					}else{
						
						$featured_product_data = sqlQUERY_LABEL("SELECT SHOP_ITEM.`cart_id`, SHOP_ITEM.`od_id`, SHOP_ITEM.`pd_id`, SHOP_ITEM.`variant_id`, SHOP_ITEM.`od_qty`, SHOP_ITEM.`od_price`, SHOP_ITEM.`item_tax_type`, SHOP_ITEM.`item_tax`, SHOP_ITEM.`item_tax1`, SHOP_ITEM.`item_tax2`, PRDT.`producttitle`, PRDT.`productsku` FROM `js_shop_order_item` AS SHOP_ITEM, `js_product` AS PRDT where SHOP_ITEM.`pd_id` = PRDT.`productID` and SHOP_ITEM.od_session = '$sid' and SHOP_ITEM.deleted = '0' and SHOP_ITEM.status = '1'") or die("#1-Unable to get records:".mysqli_error());
					}
						
						
					
					
					$check_product_data_num_rows = sqlNUMOFROW_LABEL($featured_product_data);
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
						  $item_total = $od_price + $item_tax1 + $item_tax2;
						  
						  $cart_total += $item_total;
						  $variant_name = getVARIANT_CODE($variant_id,'variant_name_from_variant_ID');
						  $variant_mrp_price = getVARIANT_CODE($variant_id,'variant_mrp_price');
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
					<div class="col-md-3">
						<img src="<?php echo $media_path?>" style="padding:10px; background-color:white;">
					</div>
					<div class="col-md-9">
						<div class="row">
							<div class="col-md-12">
								<?php if($variant_name != '' ){ ?>
								<h6 class="mb-0"><?php echo $producttitle.'<small>('.$variant_name.')</small>'; ?></h6>
								<?php } else {?>
								<h6 class="mb-0"><?php echo $producttitle; ?></h6>
								<?php } ?>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<small style="font-size:1.5rem; color:black;">Quantity: <?php echo $od_qty;?></small>
							</div>
						</div>
						<div class="row">
							<div class="col-md-7">							
							<h6><p class="product-price">
						
							<span class="kreen-Price-amount amount"><span class="kreen-Price-currencySymbol"><?php echo general_currency_symbol; ?></span><?php echo formatCASH($item_total) ; ?></span>   &nbsp;
							
							<del><span class="kreen-Price-amount amount text-light"><span class="kreen-Price-currencySymbol text-light"><?php echo general_currency_symbol; ?></span><?php echo (getMRPprice($pd_id, $variant_id,$od_qty)) ?></span></del></p>
							</h6>							
							</div>
						</div>
					</div>
					  <?php } ?>
				</div>
				<?php 
				
				$selectod_discount_data = sqlQUERY_LABEL("select SUM(od_discount_amount) AS OD_TOTAL_DISCOUNT, od_discount_promo_ID FROM `js_shop_order` where `od_userid`='$logged_user_id' and `od_id`= '$od_id'") or die(sqlERROR_LABEL());

				$collect_od_discount_data = sqlFETCHASSOC_LABEL($selectod_discount_data);
				
				$OD_TOTAL_DISCOUNT = $collect_od_discount_data['OD_TOTAL_DISCOUNT'];
				$od_dicount_promo_ID = $collect_od_discount_data['od_dicount_promo_ID'];

				
				if(!empty($logged_user_id)){
					
					$selectpo_itemlist = sqlQUERY_LABEL("select count(*) as po_itemcount, SUM(od_price) AS OD_TOTAL, SUM(od_qty) AS OD_TOT_QTY, SUM(item_tax1) AS OD_totaltax1, SUM(item_tax2) AS OD_totaltax2 FROM `js_shop_order_item` where `user_id`='$logged_user_id' and deleted='0' and status='1'") or die(sqlERROR_LABEL());
					
				}else{
					
					$selectpo_itemlist = sqlQUERY_LABEL("select count(*) as po_itemcount, SUM(od_price) AS OD_TOTAL, SUM(od_qty) AS OD_TOT_QTY, SUM(item_tax1) AS OD_totaltax1, SUM(item_tax2) AS OD_totaltax2 FROM `js_shop_order_item` where `od_session` = '$sid' and deleted='0' and status='1'") or die(sqlERROR_LABEL());
					
				}
				

				$collect_itemlist_data = sqlFETCHASSOC_LABEL($selectpo_itemlist);
				
				$po_itemcount = $collect_itemlist_data['po_itemcount'];
				$OD_SUB_TOTAL = $collect_itemlist_data['OD_TOTAL'];
				$OD_TOT_QTY = $collect_itemlist_data['OD_TOT_QTY'];
				$OD_totaltax1 = $collect_itemlist_data['OD_totaltax1'];
				$OD_totaltax2 = $collect_itemlist_data['OD_totaltax2'];
				$OD_TOTAL = $OD_SUB_TOTAL+$OD_totaltax1 + $OD_totaltax2;	
				
				?>
				<table class="table table-summary">
				<tbody>
					<tr class="summary-subtotal">
						<td>Subtotal:</td>
						<td class="product-prices"><?php echo general_currency_symbol. number_format($OD_TOTAL,2); ?></td>
					</tr>
					<?php if($OD_TOTAL_DISCOUNT > 0){ ?>
					<tr>
						<td>Discount:</td>
						<td class="product-prices"><?php echo general_currency_symbol. number_format($OD_TOTAL_DISCOUNT,2);?></td>
					</tr>
					<?php } ?>
					<tr class="summary-total">
						<td>Total:</td>
						<td class="product-prices"><?php echo general_currency_symbol. number_format(($OD_TOTAL-$OD_TOTAL_DISCOUNT),2); ?></td>
					</tr>
				</tbody>
				</table>
				<!--<div class="row" style="padding-top:30px;">
					<div class="col-md-10">
						<div class="row">
							<div class="col-md-6">
								<h6>Subtotal:</h6> 
							</div>
							<div class="col-md-4">
								<h6 class="product-price text-dark"><?php echo general_currency_symbol. number_format($OD_TOTAL,2); ?></h6>
							</div>
						</div>
						<?php if($OD_TOTAL_DISCOUNT > 0){ ?>
						<div class="row">
							<div class="col-md-6">
								<h6>Discount:</h6> 
							</div>
							<div class="col-md-4">
								<h6 class="product-price text-dark"><?php echo general_currency_symbol. number_format($OD_TOTAL_DISCOUNT,2);?></h6>
							</div>
						</div>
						<?php } ?>
						<div class="row">
							<div class="col-md-6">
								<h6>Total:</h6> 
							</div>
							<div class="col-md-4">
								<h6 class="product-price text-dark"><?php echo general_currency_symbol. number_format(($OD_TOTAL-$OD_TOTAL_DISCOUNT),2); ?></h6>
							</div>
						</div>
					</div>
				</div>
				<div class="accordion-summary" id="accordion-payment">
					<div class="card">
						<div class="card-header" id="heading-1">
							<h2 class="card-title">
								<a role="button" data-toggle="collapse" href="#collapse-1" aria-expanded="true" aria-controls="collapse-1" class="" name="payment_type" id="cod" value="cod">
									Cash On Delivery
								</a>
							</h2>
						</div>
						<div id="collapse-1" class="collapse show" aria-labelledby="heading-1" data-parent="#accordion-payment" style="">
							<div class="card-body">
								Cash on delivery (COD) is a type of transaction where the recipient pays for a good at the time of delivery rather than using credit.
							</div>
						</div>
					</div>
					<div class="card">
						<div class="card-header" id="heading-1">
							<h2 class="card-title">
								<a class="collapsed" role="button" data-toggle="collapse" href="#collapse-2" aria-expanded="false" aria-controls="collapse-2" name="payment_type" id="razor_pay" value="razor">
									Razor Pay
								</a>
							</h2>
						</div>
						<div id="collapse-2" class="collapse" aria-labelledby="heading-1" data-parent="#accordion-payment" style="">
							<div class="card-body">
								Start Accepting Payments Instantly with Razorpay's Free Payment Gateway. Supports Netbanking, Credit, Debit Cards, UPI etc.
							</div>
						</div>
					</div>
				</div>-->

				<div class="row" style="padding-top:3%;">
					<div class="col-md-2 text-right">
						<input type="radio" class="" name="payment_type" id="cod" value="cod" checked>
					</div>
					<div class="col-md-10">
						<label for="cod" style="padding-top:5px;"><h6>Cash On Delivery</h6></label>
					</div>
				</div>
				<div class="row cod">
					<div class="col-md-2">
					</div>
					<div class="col-md-10">
						<p>Cash on delivery (COD) is a type of transaction where the recipient pays for a good at the time of delivery rather than using credit.</p>
					</div>
				</div>
				<div class="row" style="padding-top:3%;">
					<div class="col-md-2 text-right">
						<input type="radio" class="" name="payment_type" id="razor_pay" value="razor" required>
					</div>
					<div class="col-md-10">
						<label for="razor_pay" style="padding-top:5px;"><h6>Razor Pay</h6></label>
					</div>
				</div>
				<div class="row paypal_content">
					<div class="col-md-2">
					</div>
					<div class="col-md-10">
						<p>Start Accepting Payments Instantly with Razorpay's Free Payment Gateway. Supports Netbanking, Credit, Debit Cards, UPI etc.</p>
					</div>
				</div>
				<div class="kreen-terms-and-conditions-wrapper">
					<div class="kreen-privacy-policy-text"><p>Your personal data will be
						used to process your order, support your experience throughout this
						website, and for other purposes described in our <a href="pages.php?id=18" class="kreen-privacy-policy-link" target="_blank">privacy policy</a>.</p>
					</div>
				</div>
				<input type="hidden" name="hidden_session_id" id="hidden_session_id" value="<?php echo $sid; ?>">
				<input type="hidden" name="hidden_order_id" id="hidden_order_id" value="<?php echo $__main_order_data['od_id']; ?>">
				<input type="hidden" name="hidden_order_amt" id="hidden_order_amt" value="<?php echo number_format(($OD_TOTAL-$OD_TOTAL_DISCOUNT),2, '.', ''); ?>">
				<div class="row" style="padding-top:3%;">
					<div class="col-md-12 text-center">
						<!--<button type="submit" id="place_order" name="place_order" value="place_order" class="btn btn-outline-dark-3 col-md-12">Place Order</button>-->
						<button type="submit" class="btn btn-outline-primary-2 btn-order btn-block" id="place_order" name="place_order" value="place_order">
							<span class="btn-text">Place Order</span>
							<span class="btn-hover-text">Place Order</span>
						</button>
					</div>
				</div>
				</div>
			</aside>
		</div>
		</form>
		</div><!-- End .container -->
	</div><!-- End .page-content -->
</main><!-- End .main -->
