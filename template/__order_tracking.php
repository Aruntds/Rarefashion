<main class="main">
	<nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
		<div class="container">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="index.php">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Order Tracking</li>
			</ol>
		</div><!-- End .container -->
	</nav><!-- End .breadcrumb-nav -->

	<div class="error-content text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
		<div class="container" style="padding-bottom:5%;">
		<?php if($mode=='') { ?>
			<h2 class="error-title">Order Tracking</h2><!-- End .error-title -->
			<p>Give Your Details to the below fields to track your order status</p>
			<div class="row">
				<div class="col-md-4">
				</div>
				<?php $get_order_REFNO = $_GET['order_ref_no']; ?>
						<?php if($get_order_REFNO == ''){ ?>
				<div class="col-md-4" id="hide_on_ajax_response" style="border: 1px solid #fcc056;padding: 20px;border-radius: 15px;box-shadow: 0px 0px 15px 10px gainsboro;background-color: white;">
					<div class="row">
						<div class="col-md-12 text-left">
							<label for="ord_ref_no">Order Ref. No. <span class="text-danger">*</span></label>
							<input type="text" id="ord_ref_no" name="ord_ref_no" value="<?php if($get_order_REFNO != ''){ echo $get_order_REFNO; } else { echo "";} ?>"class="form-control" required>
						</div>
						<div class="col-md-12 text-left">
							<label for="ord_email">Order Email <span class="text-danger">*</span></label>
							<input type="text" id="ord_email" name="ord_email" value="" onclick="collectOrder_RECORD" class="form-control" required>
						</div>
					</div>
					 <p class="form-row text-center">
                                <button class="btn btn-outline-primary-2 btn-minwidth-lg" type="button"  onclick="collectOrder_RECORD()" name="track" value="Track">Track Order</button>
								<!--<a href="order-tracking.php?mode=preview&order=<?php echo base64_encode($orderID); ?>">Track Order</a>-->
                            </p>
					
				</div>
					<?php } ?>
					<?php } ?>
				<div class="col-md-12">
				   
				   <span class="text-center" id="loadingORDER" style="display: none;">
								Loading
						</span>
						<span id="displayORDERDATA"></span>
					
						
	<?php  if($mode == 'preview') { 
		$order_ref = base64_decode($od_refno);
		$order_EMAIL = base64_decode($order_email);  
		$order_record = getORDER_DETAILS($order_ref, 'get_od_ID_from_od_refno');
		$orderID = getSINGLEDBVALUE('od_id', "od_refno='$order_ref'", 'js_shop_order', 'label');
		//echo "SELECT COUNT(*) AS COUNT FROM js_users AS CUS, js_shop_order AS SHOP WHERE SHOP.od_userid = CUS.userID  and CUS.useremail = '$order_EMAIL' and SHOP.od_id ='$order_record' ";
		$check_customer_email_and_order_refno_verification = sqlQUERY_LABEL("SELECT COUNT(*) AS COUNT FROM js_users AS CUS, js_shop_order AS SHOP WHERE SHOP.od_userid = CUS.userID  and CUS.useremail = '$order_EMAIL' and SHOP.od_id ='$order_record' ") or die("#1-Unable to get records:".sqlERROR_LABEL());
		// echo "SELECT COUNT(*) AS COUNT FROM js_users AS CUS, js_shop_order AS SHOP WHERE SHOP.od_userid = CUS.userID  and CUS.useremail = '$order_EMAIL' and SHOP.od_id ='$order_record'";
		$check_count_verify_num_rows = sqlFETCHASSOC_LABEL($check_customer_email_and_order_refno_verification);
		$ACCOUNT_AND_ORDER_VERIFIED_COUNT = $check_count_verify_num_rows['COUNT'];

		if($ACCOUNT_AND_ORDER_VERIFIED_COUNT > 0) {
			?>
			<div class="text-right" id="back_to_track" style="padding: 15px;">
				<a class="btn btn-primary btn-round" href="<?php echo SITEHOME; ?>myorders.php?mode=preview&odid=<?php echo $orderID; ?>"  >Back to Orders</a>
			
			</div>
			<div class = "row">
			<div class="col-md-7">
			<div class="card">
			  <div class="col-md-12 card-header pb-20" style="background-color: #333;">
				<div class="row">
					<div class="col-md-8 text-left pt-2 pb-1 pl-5">
					<h5 style="color: white">Order History <?php echo '# '.$order_ref; ?></h5>
					</div>
					
				</div>
			  </div>
			  <div class="card-body">
				<table class="table order_details">
				<thead>
					<tr>
						<th class="product-name col-md-8 text-left">Product</th>
						<th class="product-total text-left">Total <small>( TAX )</small></th>
					</tr>
				</thead>
				<tbody>
				<?php
				
					//echo "SELECT SHOP_ITEM.`pd_id`, SHOP_ITEM.`variant_id`, SHOP_ITEM.`od_qty`, SHOP_ITEM.`od_price`, SHOP_ITEM.`item_tax_type`, SHOP_ITEM.`item_tax`, SHOP_ITEM.`item_tax1`, SHOP_ITEM.`item_tax2`, PRDT.`producttitle`, PRDT.`productsku` FROM `js_shop_order_item` AS SHOP_ITEM, `js_product` AS PRDT where SHOP_ITEM.`pd_id` = PRDT.`productID` and SHOP_ITEM.`od_id` = '$order_record' and SHOP_ITEM.deleted = '0' and SHOP_ITEM.status = '1'";
					$featured_product_data = sqlQUERY_LABEL("SELECT SHOP_ITEM.`pd_id`, SHOP_ITEM.`variant_id`, SHOP_ITEM.`od_qty`, SHOP_ITEM.`od_price`, SHOP_ITEM.`item_tax_type`, SHOP_ITEM.`item_tax`, SHOP_ITEM.`item_tax1`, SHOP_ITEM.`item_tax2`, PRDT.`producttitle`, PRDT.`productsku` FROM `js_shop_order_item` AS SHOP_ITEM, `js_product` AS PRDT where SHOP_ITEM.`pd_id` = PRDT.`productID` and SHOP_ITEM.`od_id` = '$order_record' and SHOP_ITEM.deleted = '0' and SHOP_ITEM.status = '0'") or die("#1-Unable to get records:".sqlERROR_LABEL());
								$check_product_data_num_rows = sqlNUMOFROW_LABEL($featured_product_data);
								
								if($check_product_data_num_rows >0) {
								while($featured_data = sqlFETCHARRAY_LABEL($featured_product_data)){
									  $pd_id = $featured_data["pd_id"];
									  $producttitle = $featured_data["producttitle"];
									  $productsku = $featured_data["productsku"];
									  $variant_id = $featured_data["variant_id"];
									  $od_qty = $featured_data["od_qty"];
									  $od_price = $featured_data["od_price"];
									  $item_tax = $featured_data["item_tax"];
									  $item_tax1 = $featured_data["item_tax1"];
									  $item_tax2 = $featured_data["item_tax2"];
									  $item_taxonly = ($item_tax1 + $item_tax2);
									  $item_total = $od_price + $item_tax1 + $item_tax2;
					?>
				<tr class="order_item">
					<td class="product-name text-left" style="font-size:15px;">
						<a href="<?php echo SITEHOME; ?>product?token=<?php echo $pd_id.'-'.convertSEOURL($producttitle).'-'.$productsku; ?>">
						<?php echo $producttitle; ?>
						</a>
						<strong class="product-quantity text-left"> × <?php echo $od_qty; ?></strong>
						<br>
							<?php if($variant_id !='0'){ ?>
								<small><b>Size : </b><?php echo getVARIANT_ESTORECODE($variant_id,'variant_name_from_variant_ID'); ?></small>
							<?php } ?>
					</td>
					<td class="product-total text-left">
										<span class="product-price amount"><span class="kreen-Price-currencySymbol"><?php echo general_currency_symbol; ?>&nbsp;</span><?php echo formatCASH($item_total -$item_taxonly); ?>
										<small>( + <?php echo $item_taxonly; ?> TAX )</small>	
										</span>
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
				</table>
			  </div>
			  </div>
			</div>
		<div class="col-md-5 pd-t-10 mb-20">
			<div class="card">
			  <div class="card-header col-md-12" style="background-color: #333;">
				<div class="row">
					<div class="col-md-6 text-left pt-2 pb-1 pl-5">
					<h5 style="color: white">Log History</h5>
					</div>
					
				</div>
			  </div>
			  
			  
			  
			  <div class="card-body pl-60">

				<div class="timeline-group tx-13" id="log_history">
				
				<?php
				// echo "SELECT * FROM js_shop_order_log WHERE od_id = '$order_record' and deleted = '0' and od_status NOT IN ('1', '7', '8')";
					$list_log_details = sqlQUERY_LABEL("SELECT * FROM js_shop_order_log WHERE od_id = '$order_record' and deleted = '0' and od_status NOT IN ('1', '7', '8')") or die("Unable to get records:".sqlERROR_LABEL());

					$fetch_log_list = sqlNUMOFROW_LABEL($list_log_details);
				if($fetch_log_list != '0'){
					while($fetch_records = sqlFETCHARRAY_LABEL($list_log_details)){
						
						$log_description = $fetch_records['log_description'];
						$createdon = $fetch_records['createdon'];
						$createdon = date('d, M, Y g:i A',  strtotime($createdon));
					
				
				?>
				  <div class="timeline-item">
					<div class="timeline-time"><span class=""><?php echo $createdon;?></span></div>
					<div class="timeline-body">
					  <h6 class="mg-b-0"><?php echo $log_description ?></h6>
					  <p> <span class="text-primary"></span></p>
					</div><!-- timeline-body -->
				  </div>
				  
				    <?php } 
					} else {
					?>
						<h6 class="text-center  mt-3"> No Log Hsitory </h6>
					<?php } ?>
				  				  
				  </div>
				  </div>			
			  </div>
		</div>
	</div>
	
	<?php } 
		}
	?>
					
				</div>	
			</div>
		</div><!-- End .container -->
	</div><!-- End .error-content text-center -->
</main>