<?php
extract($_REQUEST);

include '../head/jackus.php';

	if($_GET['type'] == 'getorder_info') {
		
		$order_ref = trim($_POST['order_info']);   //Create as new Customer
		$order_EMAIL = trim($_POST['order_EMAIL']);   //Create as new Customer
		$order_record = getORDER_DETAILS($order_ref, 'get_od_ID_from_od_refno');
		//echo "SELECT COUNT(*) AS COUNT FROM js_users AS CUS, js_shop_order AS SHOP WHERE SHOP.od_userid = CUS.userID  and CUS.useremail = '$order_EMAIL' and SHOP.od_id ='$order_record' ";
		$check_customer_email_and_order_refno_verification = sqlQUERY_LABEL("SELECT COUNT(*) AS COUNT FROM js_users AS CUS, js_shop_order AS SHOP WHERE SHOP.od_userid = CUS.userID  and CUS.useremail = '$order_EMAIL' and SHOP.od_id ='$order_record' ") or die("#1-Unable to get records:".sqlERROR_LABEL());
		$check_count_verify_num_rows = sqlFETCHASSOC_LABEL($check_customer_email_and_order_refno_verification);
		$ACCOUNT_AND_ORDER_VERIFIED_COUNT = $check_count_verify_num_rows['COUNT'];

		if($ACCOUNT_AND_ORDER_VERIFIED_COUNT > 0) {
			?>
			<div class="text-right" id="back_to_track" style="padding: 15px;">
				<a class="btn btn-sm btn-dark" href="<?php echo SITEHOME; ?>order_tracking.php"><i class="fas fa-arrow-left"></i> Back</a>
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
					<td class="product-name text-left">
						<a href="<?php echo SITEHOME; ?>product?token=<?php echo $pd_id.'-'.convertSEOURL($producttitle).'-'.$productsku; ?>">
						<?php echo $producttitle; ?>
						</a>
						<strong class="product-quantity text-left"> × <?php echo $od_qty; ?></strong>
						<br>
							<?php if($variant_id !='0'){ ?>
								<small>Size: <?php echo getVARIANT_ESTORECODE($variant_id,'variant_name_from_variant_ID'); ?></small>
							<?php } ?>
					</td>
					<td class="product-total text-left">
										<span class="kreen-Price-amount amount"><span class="kreen-Price-currencySymbol"><?php echo general_currency_symbol; ?></span><?php echo formatCASH($item_total -$item_taxonly); ?>
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
	
	<?php
			
		} else { ?>
			<div class="row ml-5">
			<div class="col-md-12">
				<h4 class="text-center text-danger">ORDER REF NO #<?php echo $order_ref; ?> and Email ID [ <?php echo $order_EMAIL; ?> ] Does Not Match. Please Check...</h4>
			</div>
			</div>
			<div class="row">
			<div class="col-md-5"></div>
		    <div class="col-md-2 text-right">
				<a class="btn" href="<?php echo SITEHOME; ?>order-tracking" style="background-color: #80b82d;text-color: white;color: white;font-weight: 1000;">Back</a>
			</div>
			<div class="col-md-5"></div>
		<?php }
	}
?>
