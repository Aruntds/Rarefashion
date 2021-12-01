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
	$filter_date = " billdate between '$since_from' and '$since_to' and ";
}

?>
    <div class="content">
      <div class="container pd-x-12 pd-lg-x-12 pd-xl-x-12">
          <div class="col-lg-12">
		  			<?php if($route == ''){ ?>
					
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
						<a href="<?php echo BASEPATH; ?>bestsellers.php" class="btn btn-light">Clear</a>
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
					
					<?php
				  $list_producttype_data = sqlQUERY_LABEL("SELECT PRDT.producttitle AS PRODUCT_NAME, VARIANT.variant_name AS VARIANT_NAME, ORDER_ITEM.pd_id, SUM(ORDER_ITEM.od_qty) AS TOTAL_QTY, SUM(ORDER_ITEM.od_price) AS OD_PRICE, ORDER_ITEM.variant_id FROM `js_shop_order_item` ORDER_ITEM LEFT JOIN `js_shop_order` SHOP_ORDER ON SHOP_ORDER.od_id = ORDER_ITEM.od_id LEFT JOIN `js_product` PRDT ON PRDT.productID = ORDER_ITEM.pd_id and ORDER_ITEM.variant_id = '0' LEFT JOIN `js_productvariants` VARIANT ON VARIANT.variant_ID = ORDER_ITEM.variant_id GROUP BY ORDER_ITEM.pd_id,ORDER_ITEM.variant_id ORDER BY SUM(ORDER_ITEM.od_price) DESC") or die("#1-Unable to get PRODUCT UNIT:".sqlERROR_LABEL());

				  $count_producttype_list = sqlNUMOFROW_LABEL($list_producttype_data);

				  while($row = sqlFETCHARRAY_LABEL($list_producttype_data)){
					  $counter++;
					  $order_quantity = $row["TOTAL_QTY"];
					  $total_qty += $order_quantity;
					  $order_price += $row["OD_PRICE"];
				  }
					?>
					
					

			<div class="row mg-md-b-20">
				<div class="col-md-4">
				<div class="media">
					<div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-success tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-5">
					  <i data-feather="bar-chart-2"></i>
					</div>
					<div class="media-body">
					  <h6 class="tx-sans tx-uppercase tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8">Total Products</h6>
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
				<h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo general_currency_symbol.formatCASH($order_price); ?></h3>
					</div> 
				</div>	
				</div>
				<div class="col-md-4">
				<div class="media mg-t-20 mg-sm-t-0 mg-sm-l-15 mg-md-l-90">
					<div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-pink tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-5">
					  <i data-feather="bar-chart-2"></i>
					</div>
					<div class="media-body">
					  <h6 class="tx-sans tx-uppercase tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8">Total Quantity</h6>
				<h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $total_qty; ?></h3>
					</div>
				</div>
				</div>
			</div>
		
          

		  <div class="row">
			<div data-label="Example" class="df-example demo-table table-responsive">
			 <table id="customersalesreportLIST" class="table table-bordered" width="99%">
			    <thead>
			        <tr>
						<th class="wd-5p"><?php echo $__contentsno ?></th>
						<th class="wd-25p">Product name</th>
						<th class="wd-15p">Order Quantity</th>
						<th class="wd-15p">Order Price</th>
			        </tr>
			    </thead>
			</table>	
			</div>
          </div>
		  <?php } if($route == 'preview'){ ?>

		  <?php } ?>	
        </div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->
