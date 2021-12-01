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

if($since_from !='' && $since_to !=''){
	$filterby_date = " and DATE(createdon) between '$since_from' and '$since_to'";
}

$list_producttype_data = sqlQUERY_LABEL("SELECT B.`od_price` as PRICE, B.`od_qty` as QTY, B.`item_tax_type` as TAX, B.`pd_id` as PD_ID FROM `js_shop_order` as A, `js_shop_order_item` as B WHERE B.`od_id` = A.`od_id` AND A.`status` = 0 AND A.`deleted` = 0 AND DATE(B.createdon) = CURRENT_DATE() {$filterby_date}") or die("#1-Unable to get Cart List:".sqlERROR_LABEL());

  $count_producttype_list = sqlNUMOFROW_LABEL($list_producttype_data);
   while($row = sqlFETCHARRAY_LABEL($list_producttype_data)){
	  $counter++;
	  $product_price = general_currency_symbol.' '.convertCASH($row["PRICE"]);
	  $order_quantity = $row["QTY"];
	  $total_order_quantity += $order_quantity;
	  $item_tax = $row["TAX"];
	  $product_name = getPRODUCTNAME($row["PD_ID"]);
	  $order_price = $row["PRICE"];
	  $total_order_price += $order_price;
   }
?>
    <div class="content">
      <div class="container pd-x-12 pd-lg-x-12 pd-xl-x-12">
          <div class="row mg-md-b-20">
		  			<?php if($route == ''){ ?>
						

					<style>
						.clear-all:hover {
						text-decoration: underline;
						}
					</style>
			<div class="col-md-4">
				
				<div class="media">
					<div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-success tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-5">
					  <i data-feather="bar-chart-2"></i>
					</div>
					<div class="media-body">
					  <h6 class="tx-sans tx-uppercase tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8">Total Products</h6>
				<h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $count_producttype_list; ?></h3>
					</div> </div>
				</div>

				<div class="col-md-4">
				<div class="media mg-t-20 mg-sm-t-0 mg-sm-l-15 mg-md-l-50">
					<div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-primary tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-5">
					  <i data-feather="bar-chart-2"></i>
					</div>
					<div class="media-body">
					  <h6 class="tx-sans tx-uppercase tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8">Total Order Quantity</h6>
				<h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php
				if($total_order_quantity == ''){
					echo '0';
				} else {
						echo $total_order_quantity; 
				}
				?>
				</h3>
					</div> 
				</div>	
				</div>
				<div class="col-md-4">
				<div class="media mg-t-20 mg-sm-t-0 mg-sm-l-15 mg-md-l-90">
					<div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-pink tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-5">
					  <i data-feather="bar-chart-2"></i>
					</div>
					<div class="media-body">
					  <h6 class="tx-sans tx-uppercase tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8">Total Value</h6>
				<h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo general_currency_symbol.formatCASH($total_order_price); ?></h3>
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
						<th class="wd-30p">Product name</th>
						<th class="wd-10p">Product Price</th>
						<th class="wd-10p">Order Quantity</th>
						<th class="wd-10p">Order Price</th>
			        </tr>
			    </thead>
			</table>	
			</div>
          </div>
		  <?php } if($route == 'preview'){ ?>

		  <?php } ?>	
        	</div>
		
		</div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->
