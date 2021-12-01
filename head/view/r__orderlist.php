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

if($filter_customer !='' && $filter_customer !='0'){
	$filter_by_customer = " and od_userid = '$filter_customer' ";
}

if($since_from !='' && $since_to !=''){
	$filterby_date = " and DATE(od_date) between '$since_from' and '$since_to'";
}

$total_bills = commonNOOFROWS_COUNT('js_shop_order', "");

?>
    <div class="content">
      <div class="container pd-x-12 pd-lg-x-12 pd-xl-x-12">
          <div class="col-lg-12">
		  	<?php if($route == ''){ 
			$fetch_list_total_order = commonNOOFROWS_COUNT('js_shop_order', "deleted = '0' {$filter_by_customer} {$filterby_date}");
			$count_pending_orders = commonNOOFROWS_COUNT('js_shop_order', "od_status = '3' {$filter_by_customer} {$filterby_date}");
			$count_delivered_orders = commonNOOFROWS_COUNT('js_shop_order', "od_status = '6' {$filter_by_customer} {$filterby_date}");
			?>
			<form>
				<div class="card mg-md-b-20" id="filter_content" style="display:none">
				<div class="card-body">
					<div class="row">
					<div class="col-3 ml-auto">
						<div class="">
						<label for="filter_customer" class="col-sm-9 mg-b-0 control-label">Filter By Customer</label>
							<div class="col-sm-12 ml-auto">
								<select type="text" class="form-control custom-select select2" style="width: 241px" name="filter_customer" id="filter_customer">
									<?php echo getCUSTOMERSELECT($filter_customer,'select'); ?>
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-2 col-sm-12">
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
						<a href="<?php echo BASEPATH; ?>orderlist.php" class="btn btn-light">Clear</a>
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
					  <h6 class="tx-sans tx-uppercase tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8">Total Order</h6>
				<h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $fetch_list_total_order; ?></h3>
					</div> 
				</div>	
				</div>
				<div class="col-md-4">
				<div class="media mg-t-20 mg-sm-t-0 mg-sm-l-15 mg-md-l-10">
					<div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-primary tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-5">
					  <i data-feather="bar-chart-2"></i>
					</div>
					<div class="media-body">
					  <h6 class="tx-sans tx-uppercase tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8">Inprogress Order</h6>
				<h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $count_pending_orders; ?></h3>
					</div> 
				</div>	
				</div>
				<div class="col-md-4">
				<div class="media mg-t-20 mg-sm-t-0 mg-sm-l-15 mg-md-l-100">
					<div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-pink tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-5">
					  <i data-feather="bar-chart-2"></i>
					</div>
					<div class="media-body">
					  <h6 class="tx-sans tx-uppercase tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8">Completed Order</h6>
				<h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $count_delivered_orders; ?></h3>
					</div>
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
						<th class="wd-5p">Reference No</th>
						<th class="wd-5p">Customer Name</th>
						<th class="wd-10p">Total Item</th>
						<th class="wd-10p">Overall price</th>
						<th class="wd-5p">Tax</th>
						<th class="wd-5p">Discount</th>
						<th class="wd-10p">Payment Status</th>
						<th class="wd-10p">Order Status</th>
			        </tr>
			    </thead>
			</table>	
			</div>
          </div>
		  <?php } if($route == 'preview'){ ?>

			<form action="" method="GET">
			<div class="row mb-3">
			<h4 class="text-dark mg-t-25">Customer Name - <?php echo getCUSTOMER_DATA($cusid,'customers_name'); ?></h4>
			<input type="hidden" name="route" id="route" value="preview">
			<input type="hidden" name="cusid" id="cusid" value="<?php echo $cusid; ?>">
				<div class="col-md-2 col-sm-12 ml-auto">
					<label for="bill_from" class="mg-b-0">From</label>
						<div class="input-group mg-md-b-10">
						  <input type="text" class="form-control" placeholder="DD/MM/YYYY" aria-label="Recipient's username" aria-describedby="basic-addon2" name="bill_from" id="bill_from" value="<?php echo $_GET['bill_from']; ?>" >
						  <div class="input-group-append">
							<span class="input-group-text" id="basic-addon2"><i class="far fa-calendar-alt"></i></span>
						  </div>
						</div>
				</div>
				<div class="col-md-2 col-sm-12">
				<label for="bill_to" class="mg-b-0">To</label>
					<div class="input-group mg-b-10">
					  <input type="text" class="form-control" placeholder="DD/MM/YYYY" aria-label="Recipient's username" aria-describedby="basic-addon2" name="bill_to" id="bill_to" value="<?php echo $_GET['bill_to']; ?>" >
					  <div class="input-group-append">
						<span class="input-group-text" id="basic-addon2"><i class="far fa-calendar-alt"></i></span>
					  </div>
					</div>
				</div>
				<div class="mg-md-t-20 mg-r-20">
					<button type="submit" class="btn btn-info">Apply Filter</button>
					<a href="<?php echo BASEPATH; ?>orderlist?route=preview&cusid=<?php echo $cusid; ?>" class="btn btn-light">Clear</a>
				</div>					
			</div>
			
			<div class="col-xs-12 col-md-12 col-lg-12 row mg-md-b-20">
				<div class="media mg-t-20 mg-sm-t-0 mg-sm-l-15 mg-md-l-80">
					<div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-info tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-5">
					  <i data-feather="bar-chart-2"></i>
					</div>
					<div class="media-body">
					  <h6 class="tx-sans tx-uppercase tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8"><a href="javascript:void(0);" class="text-secondary clear-all">Total Bills</a></h6>
				<h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo getTOTAL_SALES_REPORT_SUMMARY('total_bills',$bill_from,$bill_to,$cusid); ?></h3> 
					</div> 
				</div>
				<div class="media mg-t-20 mg-sm-t-0 mg-sm-l-15 mg-md-l-100">
					<div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-pink tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-5">
					  <i data-feather="bar-chart-2"></i>
					</div>
					<div class="media-body">
					  <h6 class="tx-sans tx-uppercase tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8"><a href="javascript:void(0);" class="text-secondary clear-all">Total Sales</a></h6>
				<h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php //echo general_currency_symbol.' '.convertCASH(getTOTAL_SALES_REPORT_SUMMARY('total_sales',$bill_from,$bill_to,$cusid)); ?></h3>
					</div>
				</div>
				<div class="media mg-t-20 mg-sm-t-0 mg-sm-l-15 mg-md-l-100">
					<div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-success tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-5">
					  <i data-feather="bar-chart-2"></i>
					</div>
					<div class="media-body">
					  <h6 class="tx-sans tx-uppercase tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8" id="total_hot"><a href="javascript:void(0);" class="text-secondary clear-all">Total Paid</a></h6>
				<h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php //echo general_currency_symbol.' '.convertCASH(getTOTAL_SALES_REPORT_SUMMARY('total_paid',$bill_from,$bill_to,$cusid)); ?></h3>
					</div>
				</div>
				<div class="media mg-t-20 mg-sm-t-0 mg-sm-l-15 mg-md-l-100">
					<div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-success tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-5">
					  <i data-feather="bar-chart-2"></i>
					</div>
					<div class="media-body">
					  <h6 class="tx-sans tx-uppercase tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8" id="total_hot"><a href="javascript:void(0);" class="text-secondary clear-all">Total Due</a></h6>
				<h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php //echo general_currency_symbol.' '.convertCASH(getTOTAL_SALES_REPORT_SUMMARY('total_due',$bill_from,$bill_to,$cusid)); ?></h3>
					</div>
				</div>			
			</div>
			<div class="row">
			<div class="col-md-12">
			<div data-label="Example" class="df-example demo-table table-responsive">
			 <table id="customersalesreportsummaryLIST" class="table table-bordered" width="99%">
			    <thead>
			        <tr>
						<th class="wd-5p"><?php echo $__contentsno ?></th>
						<th>Reference No</th>
						<th>Customer Name</th>
						<th>Total Item</th>
						<th>Overall price</th>
						<th>Tax</th>
						<th>Discount</th>
						<th>Payment Status</th>
						<th>Order Status</th>
			        </tr>
			    </thead>
			</table>	
			</div>

			<div class="row mg-t-20">
			<input type="hidden" name="route" id="route" value="preview">
			<input type="hidden" name="cusid" id="cusid" value="<?php echo $cusid; ?>">
				<div class="col-md-2 col-sm-12 ml-auto">
					<label for="ledger_from" class="mg-b-0">From</label>
						<div class="input-group mg-md-b-10">
						  <input type="text" class="form-control" placeholder="DD/MM/YYYY" aria-label="Recipient's username" aria-describedby="basic-addon2" name="ledger_from" id="ledger_from" value="<?php echo $_GET['ledger_from']; ?>" >
						  <div class="input-group-append">
							<span class="input-group-text" id="basic-addon2"><i class="far fa-calendar-alt"></i></span>
						  </div>
						</div>
				</div>
				<div class="col-md-2 col-sm-12">
				<label for="ledger_to" class="mg-b-0">To</label>
					<div class="input-group mg-b-10">
					  <input type="text" class="form-control" placeholder="DD/MM/YYYY" aria-label="Recipient's username" aria-describedby="basic-addon2" name="ledger_to" id="ledger_to" value="<?php echo $_GET['ledger_to']; ?>" >
					  <div class="input-group-append">
						<span class="input-group-text" id="basic-addon2"><i class="far fa-calendar-alt"></i></span>
					  </div>
					</div>
				</div>
				<div class="mg-md-t-20 mg-r-20">
					<button type="submit" class="btn btn-info">Apply Filter</button>
					<a href="<?php echo BASEPATH; ?>orderlist?route=preview&cusid=<?php echo $cusid; ?>" class="btn btn-light">Clear</a>
				</div>					
			</div>

			<div data-label="Example" class="df-example demo-table table-responsive mt-3">
				<table id="customer_transaction_ledger" class="table table-bordered" width="99%">
				  <thead>
					<tr>
						<th>#</th>
						<th>Trans Date</th>
						<th>Bill Ref. No.</th>
						<th>Tran Ref. No</th>
						<th>Particulars</th>
						<th>Received</th>
						<th>Trans Mode</th>
					</tr>
				 </thead>
			   </table>
			</div>
			</div>
          </div>
		  </form>
		  <?php } ?>	
        </div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->
