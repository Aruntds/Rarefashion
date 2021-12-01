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

extract($_REQUEST);
include_once('../jackus.php');

if($type == 'preview'){
	
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
		$od_refno = " <span class='text-primary'>#".$od_refno."</span>";
		$shipping = getCUSTOMERADDRESS($id,'shipping');	
		$billing = getCUSTOMERADDRESS($id,'billing');	
		$status = getodSTATUS($fetch_records['od_status']);
		$od_status = $fetch_records['od_status'];
		$od_shipping_type = $fetch_records['od_shipping_type'];
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
	<div class="col-lg-12">
		   <div class="row row-xs mg-b-25">
				<div class="col-md-6 col-sm-12 text-left">
					<h5 class="mr-auto pd-t-10">ORDER <?php echo $od_refno; ?></h5>
				</div>
				<div class="col-md-6 col-sm-12 text-right">
				<span><?php echo $status; ?></span>
				</div>
		   </div>
            <div class="row row-xs mg-b-25 mg-t-20">
				<div class="col-md-6 col-sm-12">
					<h6 class="mr-auto pd-t-10">BILLING ADDRESS</h6>
					<span class="mr-auto text-muted"><?php echo $billing; ?></span>
				</div>
				<div class="col-md-6 col-sm-12 text-right">
					<h6 class="mr-auto pd-t-10">SHIPPING ADDRESS</h6>
					<span class="mr-auto text-muted"><?php echo $shipping; ?></span>
				</div>
            </div><!-- row -->
			 <div class="row row-xs mg-b-25">
				<div class="col-md-3 col-sm-12">
					<h6 class="mr-auto pd-t-10">EMAIL</h6>
					<span class="mr-auto text-muted"><?php echo $customer_email; ?></span>
				</div>
				<div class="col-md-3 col-sm-12">
					<h6 class="mr-auto pd-t-10">SHIPPING METHOD</h6>
					<span class="mr-auto text-muted"><?php echo $od_shipping_type; ?></span>
				</div>
				<div class="col-md-3 col-sm-12">
					<h6 class="mr-auto pd-t-10">MOBILE NO</h6>
					<span class="mr-auto text-muted"><?php echo $customer_mobile; ?></span>
				</div>
				<div class="col-md-3 col-sm-12">
					<h6 class="mr-auto pd-t-10">PAYMENT VIA</h6>
					<span class="mr-auto text-muted"><?php echo strtoupper($od_payment_mode); ?></span>
				</div>
			 </div>
			 <div class="row row-xs mg-b-25">
				<div class="col-md-3 col-sm-12">
					<h6 class="mr-auto pd-t-10">PRODUCT NAME</h6>
				</div>
				<div class="col-md-3 col-sm-12">
					<h6 class="mr-auto pd-t-10">OUANTITY</h6>
				</div>
				<div class="col-md-3 col-sm-12">
					<h6 class="mr-auto pd-t-10">TAX(%)</h6>
				</div>
				<div class="col-md-3 col-sm-12">
					<h6 class="mr-auto pd-t-10">TOTAL</h6>
				</div>
				
				<div class="col-md-12 col-sm-12">
					<hr />
				</div>
				<?php 
				$list_Product_details = sqlQUERY_LABEL("SELECT js_shop_order.od_shipping_cost, js_shop_order_item.pd_id, js_shop_order_item.od_qty, js_shop_order_item.od_price, js_product.producttitle, js_product.productsellingprice, js_product.producttax FROM js_shop_order, js_shop_order_item, js_product WHERE js_shop_order_item.od_id = '$id' AND js_shop_order_item.pd_id = js_product.productID AND js_shop_order.od_id = '$id' ") or die("Unable to get records:".sqlERROR_LABEL());

				$fetch_product_list = sqlNUMOFROW_LABEL($list_Product_details);

				while($fetch_records = sqlFETCHARRAY_LABEL($list_Product_details)){
					
				$product_counter++;
				
				$product_id = $fetch_records['pd_id'];
				$product_name = $fetch_records['producttitle'];
				$product_qty = $fetch_records['od_qty'];
				$product_od_price = $fetch_records['od_price'];
				$product_price = $fetch_records['productsellingprice'];
				$shipping_price = $fetch_records['od_shipping_cost'];
				$product_tax = $fetch_records['producttax'];
				$item_subtotal += $product_od_price;
				?>
				<div class="col-md-3 col-sm-12 pd-t-10">
					<span class="mr-auto text-muted"><?php echo $product_name; ?></span>
				</div>
				<div class="col-md-3 col-sm-12 pd-t-10">
					<span class="mr-auto text-muted"><?php echo $product_qty; ?></span>
				</div>
				<div class="col-md-3 col-sm-12 pd-t-10">
					<span class="mr-auto text-muted"><?php echo $product_tax; ?></span>
				</div>
				<div class="col-md-3 col-sm-12 pd-t-10">
					<span class="mr-auto text-muted pd-t-10"><?php echo $product_price ?></span>
				</div>
				<?php } ?>
			</div>
          </div>
		  <?php
}


if($type == 'delete') {
	
	$get_productID = sqlQUERY_LABEL("select productID from js_product where productID = '$delete_id' and deleted='0'") or die(mysql_error());
	
	$count_rows = sqlNUMOFROW_LABEL($get_productID);
	
	if($count_rows == '1' ) { 
		
			echo "<div class='col-lg-12'>This action cannot be revoked...!!!<br /><br />";
			echo "<hr><a href='product.php?action=delete&id=".$delete_id."' class='btn btn-success btn-sm'>Delete</a>";
			echo "<a href='javascript:;' class='btn btn-danger btn-sm' data-dismiss='modal' style='margin-left:20px'> Close</a></div>";
			
	} else {
		echo "<div class='col-lg-12'>Sorry cannot delete Product<br /><br />
			<b class='text-danger'>Reason</b>
			- No Product available to delete.<br /><br />
			</div>";
		echo "<hr><a href='javascript:;' class='btn btn-danger btn-sm' data-dismiss='modal' style='margin-left:20px'> Close</a></div>";
	}
	
}

if($type == 'changestatus') {
	
	if($oldstatus == '1') {
		$product_status = '0';
	} elseif($oldstatus == '0') {
		$product_status = '1';
	}
	
	//Update query
	$arrFields=array('`status`');

	$arrValues=array("$product_status");

	$sqlWhere= "productID=$productID";

	return sqlACTIONS("UPDATE","js_product",$arrFields,$arrValues, $sqlWhere);
}

if($type == 'changestockstatus') {
	
	if($oldstatus == '1') {
		$productstock_status = '0';
	} elseif($oldstatus == '0') {
		$productstock_status = '1';
	}
	
	//Update query
	$arrFields=array('`productstockstatus`');

	$arrValues=array("$productstock_status");

	$sqlWhere= "productID=$productID";

	return sqlACTIONS("UPDATE","js_product",$arrFields,$arrValues, $sqlWhere);
}