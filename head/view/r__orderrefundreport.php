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


?>
  <div class="content">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
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
						<a href="orderrefund" class="btn btn-light">Clear</a>
					</div>					
					</div>
				</div>
				</div>
				</form>

	  <div class="row mg-md-b-20">
		<div class="col-md-4">
		<?php
		if($since_from != '' && $since_to != ''){
			$since_from = dateformat_database($since_from);
			$since_to = dateformat_database($since_to);
			$filter_date = " and DATE(createdon) between '$since_from' and '$since_to'";
		}

		$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_shop_order` WHERE od_status = '8' and deleted = '0' {$filter_date} ORDER BY od_id DESC") or die("Unable to get records:".sqlERROR_LABEL());

		$fetch_list = sqlNUMOFROW_LABEL($list_datas);
		while($fetch_records = sqlFETCHARRAY_LABEL($list_datas)){
		$subTotal = $fetch_records['od_total'];
		$id = $fetch_records['od_id'];
		$od_userid = $fetch_records['od_userid'];
		$ord_qty = getORDERQTY($id, $od_userid);
		$total_sales += $subTotal;
		$total_qty += $ord_qty;
		}
		if($total_qty == ''){
			$total_qty = '0';
		}
		?>
		<div class="media mg-t-20 mg-sm-t-0 mg-md-l-10">
			<div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-success tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-5">
			  <i data-feather="bar-chart-2"></i>
			</div>
			<div class="media-body">
				<h6 class="tx-sans tx-uppercase tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8">Total Refund Order</h6>
				<h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $fetch_list;?></h3>
			</div> 
		</div>
		</div>
		<div class="col-md-4">
		<div class="media mg-t-20 mg-sm-t-0 mg-sm-l-15 mg-md-l-50">
			<div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-success tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-5">
			  <i data-feather="bar-chart-2"></i>
			</div>
			<div class="media-body">
				<h6 class="tx-sans tx-uppercase tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8">Total Refund Amount</h6>
				<h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo general_currency_symbol.formatCASH($total_sales);?></h3>
			</div> 
		</div>
		</div>
		<div class="col-md-4">
		<div class="media mg-t-20 mg-sm-t-0 mg-sm-l-15 mg-md-l-100">
			<div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-success tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-5">
			  <i data-feather="bar-chart-2"></i>
			</div>
			<div class="media-body">
				<h6 class="tx-sans tx-uppercase tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8">Total Quantity</h6>
				<h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $total_qty;?></h3>
			</div> 
		</div>
		</div>
	  </div>
       <div class="row mg-t-25">
          <div class="col-lg-12">
            <div class="row row-xs mg-b-25">
			<div data-label="Example" class="df-example demo-table table-responsive">
			  <table id="refundLIST" class="table table-bordered" width="99%">
			    <thead>
			        <tr>
						<th class="wd-5p">S.No</th>
						<th class="wd-10p">Order Ref. No.</th>
			            <th class="wd-10p">Order Date</th>
						<th class="wd-20p">Customer Name</th>
			            <th class="wd-5p">Quantity</th>
			            <th class="wd-10p">Total</th>
						<th class="wd-10p">Payment Status</th>
			            <th class="wd-10p">Order Status</th>
			        </tr>
			    </thead>
			</table>
			</div>
            </div><!-- row -->
          </div><!-- col -->
          
        </div><!-- row -->
		<?php 
	  } //include viewpath('__amcsidebar.php'); 
	 ?>
		
		
    </div><!-- container -->
</div><!-- content -->
