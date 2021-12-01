<?php
/*
* JACKUS - An In-house Framework for TDS Apps
*
* Author: Touchmark Descience Private Limited. 
* https://touchmarkdes.com
* Version 4.0.1
* Copyright (c) 2018-2020 Touchmark De`Science
*
*/
//Dont place PHP Close tag at the bottom
protectpg_includes();

if($since_from != '' && $since_to != ''){
	$since_from = dateformat_database($since_from);
	$since_to = dateformat_database($since_to);
	$filter_date = " and DATE(createdon) between '$since_from' and '$since_to'";
}

$list_producttype_data = sqlQUERY_LABEL("SELECT * FROM `js_shop_order` where deleted = '0' and od_status != '0' and od_payment_status != '0' {$filter_date} order by od_id desc") or die("#1-Unable to get PRODUCT UNIT:".sqlERROR_LABEL());

  $count_producttype_list = sqlNUMOFROW_LABEL($list_producttype_data);

  while($row = sqlFETCHARRAY_LABEL($list_producttype_data)){
	  $counter++;
	  $od_total = $row["od_total"];
	  $total_price += $od_total;
  }
//$id = base64_decode($id);
//echo $id;
?>
  <div class="content">
      <div class="container pd-x-12 pd-lg-x-12 pd-xl-x-12">
          <div class="col-lg-12">
	  <?php if($formtype=='' && $route == ''){ ?>
	  <form>
				<div class="card mg-md-b-20" id="filter_content" style="display:none">
				<div class="card-body">
					<div class="row">
					<div class="col-md-2 col-sm-12 ml-auto">
						<label for="since_from" class="mg-b-0">From</label>
							<div class="input-group mg-md-b-10">
							  <input type="text" class="form-control" placeholder="DD/MM/YYYY" aria-label="Recipient's username" aria-describedby="basic-addon2" name="since_from" id="since_from" value="<?php echo $_GET['since_from']; ?>" >
							  <div class="input-group-append">
								<span class="input-group-text" id="basic-addon2"><i class="far fa-calendar-alt"></i></span>
							  </div>
							</div>
					</div>
					<div class="col-md-2 col-sm-12">
					<label for="since_to" class="mg-b-0">To</label>
						<div class="input-group mg-b-10">
						  <input type="text" class="form-control" placeholder="DD/MM/YYYY" aria-label="Recipient's username" aria-describedby="basic-addon2" name="since_to" id="since_to" value="<?php echo $_GET['since_to']; ?>" >
						  <div class="input-group-append">
							<span class="input-group-text" id="basic-addon2"><i class="far fa-calendar-alt"></i></span>
						  </div>
						</div>
					</div>
					<div class="mg-md-t-20 text-left col-md-3">
						<button type="submit" class="btn btn-info">Apply Filter</button>
						<a href="<?php echo BASEPATH; ?>order" class="btn btn-light">Clear</a>
					</div>					
					</div>
				</div>
				</div>
				</form>

					<style>
						.clear-all:hover {
						text-decoration: underline;
						}
					</style>					
					
			<div class="row mg-md-b-20">
				<div class="col-md-4">
				
				<div class="media mg-t-20 mg-sm-t-0 mg-md-l-1">
					<div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-success tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-5">
					  <i data-feather="bar-chart-2"></i>
					</div>
					<div class="media-body">
					  <h6 class="tx-sans tx-uppercase tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8">Total Orders</h6>
				<h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $count_producttype_list; ?></h3>
					</div> 
				</div>		
				</div>
				<div class="col-md-4">
				<div class="media mg-t-20 mg-sm-t-0 mg-sm-l-15 mg-md-l-50">
					<div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-primary tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-5">
					  <i data-feather="bar-chart-2"></i>
					</div>
					<div class="media-body">
					  <h6 class="tx-sans tx-uppercase tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8">Total Amount</h6>
				<h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo general_currency_symbol.formatCASH($total_price); ?></h3>
					</div> 
				</div>	
				</div>
			</div>
					
       <div class="row">
			<div data-label="Example" class="df-example demo-table table-responsive">
			  <table id="amcLIST" class="table table-bordered" width="99%">
			    <thead>
			        <tr>
						<th class="wd-5p">S.No</th>
						<th class="wd-10p">Order</th>
			            <th class="wd-5p">Date</th>
						<th class="wd-15p">Customer</th>
			            <th class="wd-5p">Quantity</th>
			            <th class="wd-10p">Total</th>
						<th class="wd-10p">Payment Status</th>
			            <th class="wd-10p">Order Status</th>
			            <th class="wd-5p">Option</th>
			            
			        </tr>
			    </thead>
			</table>
			</div>
            </div><!-- row -->
          </div><!-- col -->
          
        </div><!-- row -->
		<?php 
	  } //include viewpath('__amcsidebar.php'); 
	  if($route == 'preview' && $formtype == ''){ 
	  //$id='7';
		//$id = json_decode($encode_id);
		$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_shop_order` WHERE od_id = '$id'") or die("Unable to get records:".sqlERROR_LABEL());

		$fetch_list = sqlNUMOFROW_LABEL($list_datas);

		while($fetch_records = sqlFETCHARRAY_LABEL($list_datas)){

		$counter++;
		
		$id = $fetch_records['od_id'];
		$od_userid = $fetch_records['od_userid'];
		$od_qty = getORDERQTY($id, $od_userid);
		$customer_name = getCUSTOMERDETAILS($od_userid, 'name');
		$customer_email = getCUSTOMERDETAILS($od_userid, 'email');
		$customer_mobile = getCUSTOMERDETAILS($od_userid, 'phone');
		$od_refno = $fetch_records['od_refno'];
		$id_ref_no = $id;
		$firstName = $fetch_records['od_shipping_first_name'];	
		$od_refno = " <span class='text-primary'>#".$od_refno." ".$firstName."</span>";
		$shipping = getCUSTOMERADDRESS($id,'shipping');	
		$billing = getCUSTOMERADDRESS($id,'billing');	
		$status = getodSTATUS($fetch_records['od_status']);
		$od_status = $fetch_records['od_status'];
		$paymentstatus = getpaymentSTATUS($fetch_records['od_payment_status']);
		
		$payment ="<span class='text-primary'>fulfilled</span></br>";	
		$itemDiscount = $fetch_records['itemDiscount'];
		$subTotal = $fetch_records['od_total'];
		$line1 = $fetch_records['line1'];
		$city = $fetch_records['city'];
		$od_date = $fetch_records['od_date'];
		$od_payment_mode = $fetch_records['od_payment_mode'];
		$date = dateformat_datepicker($od_date);
		$name= " <span class='text-primary'>".$firstName.' '.$middleName.' '.$lastName."</span></br>";
		if($driver_email == ''){$driver_email = 'N/A';}
			if($od_qty == '' || $od_qty == '0'){$od_qty = 'N/A';}
		}
	  ?>
		  
		  <div class="row mg-t-25">
          <div class="col-lg-12">
            <div class="row row-xs mg-b-25">
				<div class="col-md-8">
					<div class="card">
					  <div class="card-header col-sm-12">
						<h5 class="mr-auto pd-t-10">ORDER <?php echo $od_refno; ?> Details</h5>
						<h6 class="mr-auto text-muted">Payment Via <?php echo $od_payment_mode; ?></h6>
					  </div>
					  <div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<h6 class="mr-auto pd-t-10">BILLING ADDRESS</h6>
								<span class="mr-auto text-muted"><?php echo $billing; ?></span>
							</div>
							<div class="col-md-6 text-right">
								<h6 class="mr-auto pd-t-10">SHIPPING ADDRESS</h6>
								<span class="mr-auto text-muted"><?php echo $shipping; ?></span>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<h6 class="mr-auto pd-t-10">EMAIL ID</h6>
								<span class="mr-auto text-muted"><?php echo $customer_email; ?></span>
								<h6 class="mr-auto pd-t-10">PHONE</h6>
								<span class="mr-auto text-muted"><?php echo $customer_mobile; ?></span>
							</div>
							<div class="col-md-6">
								
							</div>
						</div>
						<div class="divider-text">Product Details</div>
						<div class="row">
							<div class="col-md-3 col-sm-12">
								<h6 class="mr-auto pd-t-10">PRODUCT NAME</h6>
							</div>
							<div class="col-md-3 col-sm-12 text-center">
								<h6 class="mr-auto pd-t-10">QUANTITY</h6>
							</div>
							<div class="col-md-3 col-sm-12 text-right">
								<h6 class="mr-auto pd-t-10">TAX(%)</h6>
							</div>
							<div class="col-md-3 col-sm-12 text-right">
								<h6 class="mr-auto pd-t-10">TOTAL</h6>
							</div>
							<?php

							$featured_product_data = sqlQUERY_LABEL("SELECT SHOP_ITEM.`cart_id`, SHOP_ITEM.`od_id`, SHOP_ITEM.`pd_id`, SHOP_ITEM.`variant_id`, SHOP_ITEM.`od_qty`, SHOP_ITEM.`od_price`, SHOP_ITEM.`item_tax_type`, SHOP_ITEM.`item_tax`, SHOP_ITEM.`item_tax1`, SHOP_ITEM.`item_tax2`, PRDT.`producttitle`, PRDT.`productsku` FROM `js_shop_order_item` AS SHOP_ITEM, `js_product` AS PRDT where SHOP_ITEM.`pd_id` = PRDT.`productID` and SHOP_ITEM.`od_id` = '$id' and SHOP_ITEM.deleted = '0' and SHOP_ITEM.status = '0'") or die("#1-Unable to get records:".mysqli_error());
							$check_product_data_num_rows = sqlNUMOFROW_LABEL($featured_product_data);
							
							if($check_product_data_num_rows >0) {
							while($featured_data = sqlFETCHARRAY_LABEL($featured_product_data)){
								  $cart_id = $featured_data["cart_id"];
								  $od_id = $featured_data["od_id"];
								  $pd_id = $featured_data["pd_id"];
								  $producttitle = $featured_data["producttitle"];
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
							<div class="col-md-3 col-sm-12 pd-t-10">
								<a href="<?php echo BASEPATH; ?>product?token=<?php echo $pd_id.'-'.convertSEOURL($producttitle).'-'.$productsku; ?>">
								<?php echo $producttitle; ?>
								</a>
								<br>
								<?php if($variant_id !='0'){ ?>
									<small><?php echo getVARIANT_ESTORECODE($variant_id,'variant_name_from_variant_ID'); ?></small>
								<?php } ?>
							</div>
							<div class="col-md-3 col-sm-12 pd-t-10 text-center">
								<span class="mr-auto text-muted"><?php echo $od_qty; ?></span>
							</div>
							<div class="col-md-3 col-sm-12 pd-t-10 text-right">
								<span class="mr-auto text-muted"><?php echo $item_taxonly; ?> ( <?php echo $item_tax; ?> % )</span>
							</div>
							<div class="col-md-3 col-sm-12 pd-t-10 text-right">										
								<span class="mr-auto text-muted pd-t-10"><?php echo general_currency_symbol.' '.formatCASH($item_total -$item_taxonly); ?></span>
							</div>
							<?php
								} 
							} else {
							?>
							<div class="col-md-12 col-sm-12 pd-t-10 text-center">
								No product added.
							</div>
							<?php
							}
							?>
						</div>
						<hr/>
						<div class="row">
						<div class="col-md-6 text-right">
						</div>
						<div class="col-md-3 text-right">
							<h6 class="mr-auto pd-t-10">Item Subtotal :</h6>
							<h6 class="mr-auto pd-t-10">Shipping :</h6>
							<h6 class="mr-auto pd-t-10">Tax :</h6>
							<?php if(orderTOTALSUMMARY($id, 'discounttotal') > 0){ ?>
								<h6 class="mr-auto pd-t-10">Discount :</h6>
							<?php } ?>
							<h6 class="mr-auto pd-t-10">Order Total :</h6>
						</div>
						<div class="col-md-3 text-right">
							<h6 class="mr-auto pd-t-10 text-muted" id="item_subtotal">
								<?php echo general_currency_symbol; ?><?php echo formatCASH(orderTOTALSUMMARY($id, 'subtotal')); ?>
							</h6>
							<h6 class="mr-auto pd-t-10 text-muted" id="shipping_price">
							<?php echo EMPTYFIELD; ?>
							</h6>
							<h6 class="mr-auto pd-t-10 text-muted" id="product_tax">
								<?php echo general_currency_symbol; ?><?php echo formatCASH(orderTOTALSUMMARY($id, 'taxtotal')); ?>
							</h6>
							
							<?php if(orderTOTALSUMMARY($id, 'discounttotal') > 0){ ?>								
							<h6 class="mr-auto pd-t-10 text-muted" id="shipping_price">
								<?php echo general_currency_symbol; ?><?php echo formatCASH(orderTOTALSUMMARY($id, 'discounttotal')); ?>
							</h6>
							<?php } ?>
							<h6 class="mr-auto pd-t-10 text-muted" id="order_total">
								<?php echo general_currency_symbol; ?><?php echo formatCASH((orderTOTALSUMMARY($id, 'ordertotal')) - (orderTOTALSUMMARY($id, 'discounttotal'))); ?>
							</h6>
						</div>
					</div>
					  </div>
					</div>
					<?php
					$list_review_details = sqlQUERY_LABEL("SELECT * FROM js_review WHERE od_id = '$id' and deleted = '0'") or die("Unable to get records:".sqlERROR_LABEL());

					$fetch_review_list = sqlNUMOFROW_LABEL($list_review_details);

					while($fetch_records = sqlFETCHARRAY_LABEL($list_review_details)){
						
						$review_description = $fetch_records['review_discription'];
						$review_date = $fetch_records['createdon'];
						$review_type = $fetch_records['rating'];
						
						if($review_type == '5'){
											$review_type = '<div class="tx-18">
										<i class="icon ion-md-star lh-0 tx-orange"></i>
										<i class="icon ion-md-star lh-0 tx-orange"></i>
										<i class="icon ion-md-star lh-0 tx-orange"></i>
										<i class="icon ion-md-star lh-0 tx-orange"></i>
										<i class="icon ion-md-star lh-0 tx-orange"></i>
									  </div>';
										} if($review_type == '4'){
											$review_type = '<div class="tx-18">
										<i class="icon ion-md-star lh-0 tx-orange"></i>
										<i class="icon ion-md-star lh-0 tx-orange"></i>
										<i class="icon ion-md-star lh-0 tx-orange"></i>
										<i class="icon ion-md-star lh-0 tx-orange"></i>
										<i class="icon ion-md-star lh-0 tx-gray-300"></i>
									  </div>';
										} if($review_type == '3'){
											$review_type = '<div class="tx-18">
										<i class="icon ion-md-star lh-0 tx-orange"></i>
										<i class="icon ion-md-star lh-0 tx-orange"></i>
										<i class="icon ion-md-star lh-0 tx-orange"></i>
										<i class="icon ion-md-star lh-0 tx-gray-300"></i>
										<i class="icon ion-md-star lh-0 tx-gray-300"></i>
									  </div>';
										} if($review_type == '2'){
											$review_type = '<div class="tx-18">
										<i class="icon ion-md-star lh-0 tx-orange"></i>
										<i class="icon ion-md-star lh-0 tx-orange"></i>
										<i class="icon ion-md-star lh-0 tx-gray-300"></i>
										<i class="icon ion-md-star lh-0 tx-gray-300"></i>
										<i class="icon ion-md-star lh-0 tx-gray-300"></i>
									  </div>';
										} if($review_type == '1'){
											$review_type = '<div class="tx-18">
										<i class="icon ion-md-star lh-0 tx-orange"></i>
										<i class="icon ion-md-star lh-0 tx-gray-300"></i>
										<i class="icon ion-md-star lh-0 tx-gray-300"></i>
										<i class="icon ion-md-star lh-0 tx-gray-300"></i>
										<i class="icon ion-md-star lh-0 tx-gray-300"></i>
									  </div>';
										}
					}
					?>
					<div class="row">
						<div class="col-md-12 pd-t-10">
							<div class="card">
							  <div class="card-header col-md-12">
								<div class="row">
									<div class="col-md-6">
									<h5>Customer Review</h5>
									</div>
									<?php if($fetch_review_list == 0){ ?>
									<div class="col-md-6 text-right">
									<input type="hidden"  id="id_ref_no" value="<?php echo $id_ref_no; ?>">
									<button class="btn btn-xs btn-primary" onclick="send_review_request()">Send Request For Review</button>
									</div>
									<?php } ?>
								</div>
							  </div>
							  <div class="card-body">
								  <div class="row">
									 <?php if($fetch_review_list > 0) { ?>
									<div class="col-md-6">
										<?php echo $review_type; ?>
										<h6 class="pd-t-10"><?php echo $review_description; ?></h6>
									</div>
									<div class="col-md-6 text-right">
										<h6><?php echo date('jS, M Y',strtotime($review_date)); ?></h6>
										<h6><?php echo date('h:i:s A',strtotime($review_date)); ?></h6>
									</div>
									 <?php } else { ?>
									 
									 <div class="col-md-12 text-center">
										No Review Yet...!
									</div>
									 
									 <?php } ?>
								  </div>
							  </div>
							</div>
						</div><div class="col-md-12 pd-t-10">
							<div class="card">
							  <div class="card-header col-md-12">
								<div class="row">
									<div class="col-md-6">
									<h5>Order Log History</h5>
									</div>
									
								</div>
							  </div>
							  
							  <div class="card-body">
								

								<div class="timeline-group tx-13" id="log_history">
								<div class="timeline-label">Log History</div>
								<?php
									$list_log_details = sqlQUERY_LABEL("SELECT * FROM js_shop_order_log WHERE od_id = '$id' and deleted = '0'") or die("Unable to get records:".sqlERROR_LABEL());

									$fetch_log_list = sqlNUMOFROW_LABEL($list_log_details);

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
								  <?php } ?>
								  </div>  
									
							  </div>
							</div>
						</div>
					</div>
				</div>
				
				<?php if(getorder_paymentSTATUS('2', $id, $od_status, 'label') != 'Cancelled'){?>
				<div class="col-md-4">
					<div class="row">
						<div class="col-md-12">
							<div class="card">
							  <div class="card-header col-md-12">
								<div class="row">
									<div class="col-md-12">
										<h5>Order Status - <span><?php echo getorder_paymentSTATUS('2', $id, $od_status, 'label'); ?></span></h5>
									</div>
								</div>
							  <div class="card-body">
								<div class="row">
									<div class="col-md-12">
										<select class="custom-select" name="order_status" id="order_status" style="width: 267px">
											<?php
												echo getorder_paymentSTATUS('2', $id, $od_status, 'select');
											?>											
										</select>
									</div>
									<div class="col-md-12 pd-t-10">
										<div class="custom-control custom-checkbox">
										  <input type="checkbox" class="custom-control-input" id="customCheck3">
										
										  <label class="custom-control-label" for="customCheck3">Send Update To Customer</label>
										</div>
									</div>
									<div class="col-md-12 pd-t-10">
									  <input type="hidden"  id="customeremail" value="<?php echo $customer_email ?>">
										<button onclick="order_status_update()" class="btn btn-primary btn-sm">Update</button>
									</div>
								</div>
							  </div>
							</div>
						</div>
					</div>
						<div class="col-md-12 pd-t-10">
							<div class="card">
							  <div class="card-header col-md-12">
								<div class="row">
									<div class="col-md-6">
										<h5>Delivery Details</h5>
									</div>
									<div class="col-md-6 text-right">
										<button title="Click to Enter Details" onclick="editDeliverdetails()" class="btn btn-xs btn-secondary"><i class="fa fa-pencil-alt"></i></button>
									</div>
								</div>
								<?php 
								//echo "SELECT * FROM js_delivery_details WHERE od_id = '$id' and deleted = '0'";
								$list_delivery_details = sqlQUERY_LABEL("SELECT * FROM js_delivery_details WHERE od_id = '$id' and deleted = '0'") or die("Unable to get Delivery Details:".sqlERROR_LABEL());

								$fetch_delivery_list_count = sqlNUMOFROW_LABEL($list_delivery_details);
								//echo $fetch_delivery_list_count; exit();

								while($fetch_records = sqlFETCHARRAY_LABEL($list_delivery_details)){
									
									$carrier = $fetch_records['carrier_name'];
									$shipping_date = dateformat_datepicker($fetch_records['shipping_date']);
									$delivery_date = dateformat_datepicker($fetch_records['delivery_date']);
									$time_from = $fetch_records['time_from'];
									$time_to = $fetch_records['time_to'];
								}
								//echo $fetch_delivery_list_count; exit();
								?>
							  <div class="card-body">
								<div class="row" id="details_preview">
								<input type="hidden" name="delivery_count" id="delivery_count" value="<?php echo $fetch_delivery_list_count ;?>">
									
									<div class="col-md-12">
										<h6 class="mr-auto pd-t-10">Delivery Agent</h6>
										<span class="mr-auto text-muted"><?php  
										$deliveryagent = getDELIVERAGENT($carrier,'label');
										if($deliveryagent == '') {
											echo EMPTYFIELD;
										}else
										{
											echo $deliveryagent;
										}?></span>
									</div>
									<!--<div class="col-md-12">
										<h6 class="mr-auto pd-t-10">Shipping Date</h6>
										<span class="mr-auto text-muted"><?php echo $shipping_date; ?></span>
									</div>-->
									<div class="col-md-12">
										<h6 class="mr-auto pd-t-10">Delivery Date</h6>
										<span class="mr-auto text-muted"><?php 
										if($delivery_date == '') {
											echo EMPTYFIELD;
										}else
										{
											echo $delivery_date;
										}?></span>
									</div>
									<div class="col-md-12">
										<h6 class="mr-auto pd-t-10">Time Slot</h6>
										<span class="mr-auto text-muted"><?php echo date('h:i A',strtotime($time_from)).' - '.date('h:i A',strtotime($time_to)); ?></span>
									</div>
								</div>
								<div class="row" id="details_edit">
									
									<div class="col-md-12">
										<h6 class="mr-auto pd-t-10">Delivery Agent</h6>
										
										<select class="custom-select" id="delivery_agent" name="delivery_agent" style="width: 272px">
										<option>Choose Delivery Agent</option>
											<?php echo getDELIVERAGENT($carrier,'select'); ?>
										</select>
									</div>
									<!--<div class="col-md-12">
										<h6 class="mr-auto pd-t-10">Shipping Date</h6>
										<input id="shipping_date" name="shipping_date" type="text" class="form-control" value="<?php //echo $shipping_date; ?>">
									</div>-->
								
									<div class="col-md-12">
										<h6 class="mr-auto pd-t-10">Delivery Date</h6>
										<input id="delivery_date" name="delivery_date" type="text" class="form-control" value="<?php echo $delivery_date; ?>">
									</div>
									<div class="col-md-12">
										<h6 class="mr-auto pd-t-10">Time From</h6>
										<input id="time_from" name="time_from" type="text" class="form-control" value="<?php echo date('h:i A',strtotime($time_from)); ?>">
									</div>
									<div class="col-md-12">
										<h6 class="mr-auto pd-t-10">Time To</h6>
										<input id="time_to" name="time_to" type="text" class="form-control" <?php echo date('h:i A',strtotime($time_to)); ?>">
									</div>
									<div class="col-md-12 pd-t-10">
										<button onclick="updateDeliverydetails()" class="btn btn-primary btn-sm">Update</button>
									</div>
								</div>
							  </div>
							</div>
						</div>
					</div>
					<div class="col-md-12 pd-t-10">
							<div class="card">
							  <div class="card-header col-md-12">
								<div class="row">
									<div class="col-md-6">
										<h5>Order Notes</h5>
									</div>
								</div>
							  <div class="card-body">
								<div class="row">
									<div id="note_display" class="col-md-12" style="background: papayawhip;box-shadow: 0px 1px 5px 1px;padding: 20px;border-radius: 15px;color: black;">
										
									</div>
									<div class="col-md-12 pd-t-10">
										<h6 class="mr-auto pd-t-10">Note &nbsp;&nbsp; <i title="Add a note for your reference, or add a customer note (the user will be notified)." class="fa fa-question-circle"></i></h6>
										<textarea class="form-control" rows="2" placeholder="Text area" name="order_notes" id="order_notes"></textarea>
									</div>
									<div class="col-md-8 pd-t-10">
										<select class="custom-select" id="order_note_type" name="order_note_type">
											<option value="1" <?php if($order_note_type == '1') { echo "selected"; } ?> >Private Note</option>
											<option value="2" <?php if($order_note_type == '2') { echo "selected"; } ?>>Note To Customer</option>
										</select>
									</div>
									<div class="col-md-4 pd-t-10">
									<input type="hidden"  id="customeremail" value="<?php echo $customer_email ?>">
										<button onclick="addOrdernote()" class="btn btn-primary btn-sm">Add</button>
									</div>
								</div>
							  </div>
							</div>
						</div>
					</div>
				</div>
			</div><!-- row -->
	  <?php } else { ?>
			<div class="col-md-4">
					<div class="row">
						<div class="col-md-12">
							<div class="card">
							  <div class="card-header col-md-12">
								<div class="row">
									<div class="col-md-12">
										<h5>Order Status - <span><?php 
										$orderstatus = getorder_paymentSTATUS('2', $id, $od_status, 'label');
										if($orderstatus != '') 
										{
											echo getorder_paymentSTATUS('2', $id, $od_status, 'label');
										} else {
											echo EMPTYFIELD;
										}
										?></span></h5>
									</div>
								</div>
							</div>
						</div>
					</div>
						<div class="col-md-12 pd-t-10">
							<div class="card">
							  <div class="card-header col-md-12">
								<div class="row">
									<div class="col-md-6">
										<h5>Delivery Details</h5>
									</div>
								</div>
								<?php 
								//echo "SELECT * FROM js_delivery_details WHERE od_id = '$id' and deleted = '0'";
								$list_delivery_details = sqlQUERY_LABEL("SELECT * FROM js_delivery_details WHERE od_id = '$id' and deleted = '0'") or die("Unable to get Delivery Details:".sqlERROR_LABEL());

								$fetch_delivery_list_count = sqlNUMOFROW_LABEL($list_delivery_details);
								//echo $fetch_delivery_list_count; exit();

								while($fetch_records = sqlFETCHARRAY_LABEL($list_delivery_details)){
									
									$carrier = $fetch_records['carrier_name'];
									$shipping_date = dateformat_datepicker($fetch_records['shipping_date']);
									$delivery_date = dateformat_datepicker($fetch_records['delivery_date']);
									$time_from = $fetch_records['time_from'];
									$time_to = $fetch_records['time_to'];
								}
								//echo $fetch_delivery_list_count; exit();
								?>
							  <div class="card-body">
								<div class="row" id="details_preview">
								<input type="hidden" name="delivery_count" id="delivery_count" value="<?php echo $fetch_delivery_list_count ;?>">
									
									<div class="col-md-12">
										<h6 class="mr-auto pd-t-10">Delivery Agent</h6>
										<span class="mr-auto text-muted"><?php 
										 $deliveryagent = getDELIVERAGENT($carrier,'label');
											if($deliveryagent == '') {
												echo EMPTYFIELD;
											}else
											{
												echo $deliveryagent;
											}?></span>
									</div>
									<div class="col-md-12">
										<h6 class="mr-auto pd-t-10">Delivery Date</h6>
										<span class="mr-auto text-muted"><?php 
										if($delivery_date == '') {
											echo EMPTYFIELD;
										}else
										{
											echo $delivery_date;
										}?></span>
									</div>
									<div class="col-md-12">
										<h6 class="mr-auto pd-t-10">Time Slot</h6>
										<span class="mr-auto text-muted"><?php echo date('h:i A',strtotime($time_from)).' - '.date('h:i A',strtotime($time_to)); ?></span>
									</div>
								</div>
							  </div>
							</div>
						</div>
					</div>
				</div>
			</div><!-- row -->
	  <?php }?>
        </div><!-- col -->
          
      </div><!-- row -->
		  
	  <?php } 
	  if($route == 'preview' && $formtype == 'preview'){ 
	  
		$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_shop_order` WHERE od_id = '$id'") or die("Unable to get records:".sqlERROR_LABEL());

		$fetch_list = sqlNUMOFROW_LABEL($list_datas);

		while($fetch_records = sqlFETCHARRAY_LABEL($list_datas)){

		$counter++;
		
		$id = $fetch_records['od_id'];
		$od_userid = $fetch_records['od_userid'];
		$od_qty = getORDERQTY($id, $od_userid);
		$customer_name = getCUSTOMERDETAILS($od_userid, 'name');
		$customer_email = getCUSTOMERDETAILS($od_userid, 'email');
		$customer_mobile = getCUSTOMERDETAILS($od_userid, 'phone');
		$od_refno = $fetch_records['od_refno'];
		$firstName = $fetch_records['od_shipping_first_name'];	
		$od_refno = " <span class='text-primary'>#".$od_refno." ".$firstName."</span>";
		$shipping = getCUSTOMERADDRESS($id,'shipping');	
		$billing = getCUSTOMERADDRESS($id,'billing');	
		$status = getodSTATUS($fetch_records['od_status']);
		$od_status = $fetch_records['od_status'];
		$paymentstatus = getpaymentSTATUS($fetch_records['od_payment_status']);
		
		$payment ="<span class='text-primary'>fulfilled</span></br>";	
		$itemDiscount = $fetch_records['itemDiscount'];
		$subTotal = $fetch_records['od_total'];
		$line1 = $fetch_records['line1'];
		$city = $fetch_records['city'];
		$od_date = $fetch_records['od_date'];
		$od_payment_mode = $fetch_records['od_payment_mode'];
		$date = dateformat_datepicker($od_date);
		$name= " <span class='text-primary'>".$firstName.' '.$middleName.' '.$lastName."</span></br>";
		if($driver_email == ''){$driver_email = 'N/A';}
			if($od_qty == '' || $od_qty == '0'){$od_qty = 'N/A';}
		}
	  ?>
		  
		  <div class="row mg-t-25">
          <div class="col-lg-12">
            <div class="row row-xs mg-b-25">
				<div class="col-md-8">
					<div class="card">
					  <div class="card-header col-sm-12">
						<h5 class="mr-auto pd-t-10">ORDER <?php echo $od_refno; ?> Details</h5>
						<h6 class="mr-auto text-muted">Payment Via <?php echo $od_payment_mode; ?></h6>
					  </div>
					  <div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<h6 class="mr-auto pd-t-10">BILLING ADDRESS</h6>
								<span class="mr-auto text-muted"><?php echo $billing; ?></span>
							</div>
							<div class="col-md-6 text-right">
								<h6 class="mr-auto pd-t-10">SHIPPING ADDRESS</h6>
								<span class="mr-auto text-muted"><?php echo $shipping; ?></span>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<h6 class="mr-auto pd-t-10">EMAIL ID</h6>
								<span class="mr-auto text-muted"><?php echo $customer_email; ?></span>
								<h6 class="mr-auto pd-t-10">PHONE</h6>
								<span class="mr-auto text-muted"><?php echo $customer_mobile; ?></span>
							</div>
							<div class="col-md-6">
								
							</div>
						</div>
						<div class="divider-text">Product Details</div>
						<div class="row">
							<div class="col-md-3 col-sm-12">
								<h6 class="mr-auto pd-t-10">PRODUCT NAME</h6>
							</div>
							<div class="col-md-3 col-sm-12 text-center">
								<h6 class="mr-auto pd-t-10">OUANTITY</h6>
							</div>
							<div class="col-md-3 col-sm-12 text-right">
								<h6 class="mr-auto pd-t-10">TAX(%)</h6>
							</div>
							<div class="col-md-3 col-sm-12 text-right">
								<h6 class="mr-auto pd-t-10">TOTAL</h6>
							</div>
							<?php
							$featured_product_data = sqlQUERY_LABEL("SELECT SHOP_ITEM.`cart_id`, SHOP_ITEM.`od_id`, SHOP_ITEM.`pd_id`, SHOP_ITEM.`variant_id`, SHOP_ITEM.`od_qty`, SHOP_ITEM.`od_price`, SHOP_ITEM.`item_tax_type`, SHOP_ITEM.`item_tax`, SHOP_ITEM.`item_tax1`, SHOP_ITEM.`item_tax2`, PRDT.`producttitle`, PRDT.`productsku` FROM `js_shop_order_item` AS SHOP_ITEM, `js_product` AS PRDT where SHOP_ITEM.`pd_id` = PRDT.`productID` and SHOP_ITEM.`od_id` = '$id' and SHOP_ITEM.deleted = '0' and SHOP_ITEM.status = '0'") or die("#1-Unable to get records:".mysqli_error());
							$check_product_data_num_rows = sqlNUMOFROW_LABEL($featured_product_data);
							
							if($check_product_data_num_rows >0) {
							while($featured_data = sqlFETCHARRAY_LABEL($featured_product_data)){
								  $cart_id = $featured_data["cart_id"];
								  $od_id = $featured_data["od_id"];
								  $pd_id = $featured_data["pd_id"];
								  $producttitle = $featured_data["producttitle"];
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
							<div class="col-md-3 col-sm-12 pd-t-10">
								<a href="<?php echo BASEPATH; ?>product?token=<?php echo $pd_id.'-'.convertSEOURL($producttitle).'-'.$productsku; ?>">
								<?php echo $producttitle; ?>
								</a>
								<br>
								<?php if($variant_id !='0'){ ?>
									<small><?php echo getVARIANT_ESTORECODE($variant_id,'variant_name_from_variant_ID'); ?></small>
								<?php } ?>
							</div>
							<div class="col-md-3 col-sm-12 pd-t-10 text-center">
								<span class="mr-auto text-muted"><?php echo $od_qty; ?></span>
							</div>
							<div class="col-md-3 col-sm-12 pd-t-10 text-right">
								<span class="mr-auto text-muted"><?php echo $item_taxonly; ?> ( <?php echo $item_tax; ?> % )</span>
							</div>
							<div class="col-md-3 col-sm-12 pd-t-10 text-right">										
								<span class="mr-auto text-muted pd-t-10"><?php echo general_currency_symbol.' '.formatCASH($item_total -$item_taxonly); ?></span>
							</div>
							<?php
								} 
							} else {
							?>
							<div class="col-md-12 col-sm-12 pd-t-10 text-center">
								No product added.
							</div>
							<?php
							}
							?>
						</div>
						<hr/>
						<div class="row">
						<div class="col-md-6 text-right">
						</div>
						<div class="col-md-3 text-right">
							<h6 class="mr-auto pd-t-10">Item Subtotal :</h6>
							<h6 class="mr-auto pd-t-10">Shipping :</h6>
							<h6 class="mr-auto pd-t-10">Tax :</h6>
							<?php if(orderTOTALSUMMARY($id, 'discounttotal') > 0){ ?>
								<h6 class="mr-auto pd-t-10">Discount :</h6>
							<?php } ?>
							<h6 class="mr-auto pd-t-10">Order Total :</h6>
						</div>
						<div class="col-md-3 text-right">
							<h6 class="mr-auto pd-t-10 text-muted" id="item_subtotal">
								<?php echo general_currency_symbol; ?><?php echo formatCASH(orderTOTALSUMMARY($id, 'subtotal')); ?>
							</h6>
							<h6 class="mr-auto pd-t-10 text-muted" id="shipping_price"><?php echo EMPTYFIELD; ?></h6>
							<h6 class="mr-auto pd-t-10 text-muted" id="product_tax">
								<?php echo general_currency_symbol; ?><?php echo formatCASH(orderTOTALSUMMARY($id, 'taxtotal')); ?>
							</h6>
							
							<?php if(orderTOTALSUMMARY($id, 'discounttotal') > 0){ ?>								
							<h6 class="mr-auto pd-t-10 text-muted" id="shipping_price">
								<?php echo general_currency_symbol; ?><?php echo formatCASH(orderTOTALSUMMARY($orderID, 'discounttotal')); ?>
							</h6>
							<?php } ?>
							<h6 class="mr-auto pd-t-10 text-muted" id="order_total">
								<?php echo general_currency_symbol; ?><?php echo formatCASH(orderTOTALSUMMARY($id, 'ordertotal')); ?>
							</h6>
						</div>
					</div>
					  </div>
					</div>
					<?php
					$list_review_details = sqlQUERY_LABEL("SELECT * FROM js_review WHERE od_id = '$id' and deleted = '0'") or die("Unable to get records:".sqlERROR_LABEL());

					$fetch_review_list = sqlNUMOFROW_LABEL($list_review_details);

					while($fetch_records = sqlFETCHARRAY_LABEL($list_review_details)){
						
						$review_description = $fetch_records['review_description'];
						$review_date = $fetch_records['review_date'];
						$review_type = $fetch_records['rating'];
						
						if($review_type == '5'){
											$review_type = '<div class="tx-18">
										<i class="icon ion-md-star lh-0 tx-orange"></i>
										<i class="icon ion-md-star lh-0 tx-orange"></i>
										<i class="icon ion-md-star lh-0 tx-orange"></i>
										<i class="icon ion-md-star lh-0 tx-orange"></i>
										<i class="icon ion-md-star lh-0 tx-orange"></i>
									  </div>';
										} if($review_type == '4'){
											$review_type = '<div class="tx-18">
										<i class="icon ion-md-star lh-0 tx-orange"></i>
										<i class="icon ion-md-star lh-0 tx-orange"></i>
										<i class="icon ion-md-star lh-0 tx-orange"></i>
										<i class="icon ion-md-star lh-0 tx-orange"></i>
										<i class="icon ion-md-star lh-0 tx-gray-300"></i>
									  </div>';
										} if($review_type == '3'){
											$review_type = '<div class="tx-18">
										<i class="icon ion-md-star lh-0 tx-orange"></i>
										<i class="icon ion-md-star lh-0 tx-orange"></i>
										<i class="icon ion-md-star lh-0 tx-orange"></i>
										<i class="icon ion-md-star lh-0 tx-gray-300"></i>
										<i class="icon ion-md-star lh-0 tx-gray-300"></i>
									  </div>';
										} if($review_type == '2'){
											$review_type = '<div class="tx-18">
										<i class="icon ion-md-star lh-0 tx-orange"></i>
										<i class="icon ion-md-star lh-0 tx-orange"></i>
										<i class="icon ion-md-star lh-0 tx-gray-300"></i>
										<i class="icon ion-md-star lh-0 tx-gray-300"></i>
										<i class="icon ion-md-star lh-0 tx-gray-300"></i>
									  </div>';
										} if($review_type == '1'){
											$review_type = '<div class="tx-18">
										<i class="icon ion-md-star lh-0 tx-orange"></i>
										<i class="icon ion-md-star lh-0 tx-gray-300"></i>
										<i class="icon ion-md-star lh-0 tx-gray-300"></i>
										<i class="icon ion-md-star lh-0 tx-gray-300"></i>
										<i class="icon ion-md-star lh-0 tx-gray-300"></i>
									  </div>';
										}
					}
					?>
					<div class="row">
						<div class="col-md-12 pd-t-10">
							<div class="card">
							  <div class="card-header col-md-12">
								<div class="row">
									<div class="col-md-6">
									<h5>Customer Review</h5>
									</div>
									<!--<?php //if($fetch_review_list == 0){ ?>
									<div class="col-md-6 text-right">
									<button class="btn btn-xs btn-primary" onclick="send_review_request()">Send Request For Review</button>
									</div>
									<?php //} ?>-->
								</div>
							  </div>
							  <div class="card-body">
								  <div class="row">
									 <?php if($fetch_review_list > 0) { ?>
									<div class="col-md-6">
										<?php echo $review_type; ?>
										<h6 class="pd-t-10"><?php echo $review_description; ?></h6>
									</div>
									<div class="col-md-6 text-right">
										<h6><?php echo date('jS, M Y',strtotime($review_date)); ?></h6>
										<h6><?php echo date('h:i:s A',strtotime($review_date)); ?></h6>
									</div>
									 <?php } else { ?>
									 
									 <div class="col-md-12 text-center">
										No Review Yet...!
									</div>
									 
									 <?php } ?>
								  </div>
							  </div>
							</div>
						</div><div class="col-md-12 pd-t-10">
							<div class="card">
							  <div class="card-header col-md-12">
								<div class="row">
									<div class="col-md-6">
									<h5>Order Log History</h5>
									</div>
									
								</div>
							  </div>
							  
							  <div class="card-body">
								

								<div class="timeline-group tx-13" id="log_history">
								<div class="timeline-label">Log History</div>
								<?php
									$list_log_details = sqlQUERY_LABEL("SELECT * FROM js_shop_order_log WHERE od_id = '$id' and deleted = '0'") or die("Unable to get records:".sqlERROR_LABEL());

									$fetch_log_list = sqlNUMOFROW_LABEL($list_log_details);

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
								  <?php } ?>
								  </div>  
									
							  </div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="row">
						<div class="col-md-12">
							<div class="card">
							  <div class="card-header col-md-12">
								<div class="row">
									<div class="col-md-12">
										<h5>Order Status - <span><?php 
										$orderstatus = getorder_paymentSTATUS('2', $id, $od_status, 'label');
										if($orderstatus != '') 
										{
											echo getorder_paymentSTATUS('2', $id, $od_status, 'label');
										} else {
											echo EMPTYFIELD;
										}
										?></span></h5>
									</div>
								</div>
							</div>
						</div>
					</div>
						<div class="col-md-12 pd-t-10">
							<div class="card">
							  <div class="card-header col-md-12">
								<div class="row">
									<div class="col-md-6">
										<h5>Delivery Details</h5>
									</div>
								</div>
								<?php 
								//echo "SELECT * FROM js_delivery_details WHERE od_id = '$id' and deleted = '0'";
								$list_delivery_details = sqlQUERY_LABEL("SELECT * FROM js_delivery_details WHERE od_id = '$id' and deleted = '0'") or die("Unable to get Delivery Details:".sqlERROR_LABEL());

								$fetch_delivery_list_count = sqlNUMOFROW_LABEL($list_delivery_details);
								//echo $fetch_delivery_list_count; exit();

								while($fetch_records = sqlFETCHARRAY_LABEL($list_delivery_details)){
									
									$carrier = $fetch_records['carrier_name'];
									$shipping_date = dateformat_datepicker($fetch_records['shipping_date']);
									$delivery_date = dateformat_datepicker($fetch_records['delivery_date']);
									$time_from = $fetch_records['time_from'];
									$time_to = $fetch_records['time_to'];
								}
								//echo $fetch_delivery_list_count; exit();
								?>
							  <div class="card-body">
								<div class="row" id="details_preview">
								<input type="hidden" name="delivery_count" id="delivery_count" value="<?php echo $fetch_delivery_list_count ;?>">
									
									<div class="col-md-12">
										<h6 class="mr-auto pd-t-10">Delivery Agent</h6>
										<span class="mr-auto text-muted"><?php 
										 $deliveryagent = getDELIVERAGENT($carrier,'label');
											if($deliveryagent == '') {
												echo EMPTYFIELD;
											}else
											{
												echo $deliveryagent;
											}?></span>
									</div>
									<div class="col-md-12">
										<h6 class="mr-auto pd-t-10">Delivery Date</h6>
										<span class="mr-auto text-muted"><?php 
										if($delivery_date == '') {
											echo EMPTYFIELD;
										}else
										{
											echo $delivery_date;
										}?></span>
									</div>
									<div class="col-md-12">
										<h6 class="mr-auto pd-t-10">Time Slot</h6>
										<span class="mr-auto text-muted"><?php echo date('h:i A',strtotime($time_from)).' - '.date('h:i A',strtotime($time_to)); ?></span>
									</div>
								</div>
							  </div>
							</div>
						</div>
					</div>
				</div>
			</div><!-- row -->
        </div><!-- col -->
          
      </div><!-- row -->
		  
	  <?php } ?>
     </div>
		
		
    </div><!-- container -->
</div><!-- content -->
