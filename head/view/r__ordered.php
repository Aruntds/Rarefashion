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
	$filter_date = " and DATE(A.createdon) between '$since_from' and '$since_to'";
}

 $list_producttype_data = sqlQUERY_LABEL("SELECT A.od_refno, B.pd_id, B.od_qty as OD_QTY, B.od_price as OD_PRICE, B.createdon FROM js_shop_order A, js_shop_order_item B WHERE A.od_id = B.od_id AND A.od_status = 1 {$filter_date} GROUP BY B.pd_id" ) or die("#1-Unable to get PRODUCT UNIT:".sqlERROR_LABEL());

  $count_producttype_list = sqlNUMOFROW_LABEL($list_producttype_data);

  while($row = sqlFETCHARRAY_LABEL($list_producttype_data)){
	  $counter++;
	  $order_quantity = $row["OD_QTY"];
	  $total_qty += $order_quantity;
	  $order_price = $row["OD_PRICE"];
	  $total_price += $order_price;
	  
	  if($total_qty == '' || $total_qty == '0'){
		  $total_qty = '0';
	  }
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
						<a href="ordered.php" class="btn btn-light">Clear</a>
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
				<div class="col-md-4">
				<div class="media mg-t-20 mg-sm-t-0 mg-sm-l-15 mg-md-l-100">
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
						<th class="wd-10p">Order Reference no</th>
						<th class="wd-15p">Product name</th>
						<th class="wd-5p">Order Quantity</th>
						<th class="wd-5p">Order Price</th>
						<th class="wd-5p">Order Date</th>
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
