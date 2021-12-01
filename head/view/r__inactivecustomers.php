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
	$filterby_date = " and DATE(CUSTOMER.createdon) between '$since_from' and '$since_to'";
}

$list_inactive_cus_datas = sqlQUERY_LABEL("SELECT * FROM js_customer WHERE DATEDIFF(CURRENT_DATE(),js_customer.createdon) > 30 {$filterby_date} and js_customer.customerID NOT IN ( SELECT js_shop_order.od_userid FROM js_shop_order) and deleted='0'") or die("Unable to get records:".sqlERROR_LABEL());

$total_inactive_customer_count = sqlNUMOFROW_LABEL($list_inactive_cus_datas);


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
						<a href="<?php echo BASEPATH; ?>inactivecustomers" class="btn btn-light">Clear</a>
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
		<div class="media mg-t-20 mg-sm-t-0">
			<div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-success tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-5">
			  <i data-feather="bar-chart-2"></i>
			</div>
			<div class="media-body">
				<h6 class="tx-sans tx-uppercase tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8">Total Inactive Customers</h6>
				<h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $total_inactive_customer_count;?></h3>
			</div> 
		</div>
		</div>
	  </div>
       <div class="row mg-t-25">
          <div class="col-lg-12">
            <div class="row row-xs mg-b-25">
			<div data-label="Example" class="df-example demo-table table-responsive">
			  <table id="newcustomerLIST" class="table table-bordered" width="99%">
			    <thead>
			        <tr>
						<th class="wd-5p">S.No</th>
						<th class="wd-20p">Customer Name</th>
						<th class="wd-10p">Email</th>
			            <th class="wd-5p">Mobile No</th>
			            <th class="wd-10p">Date of Birth</th>
						<th class="wd-10p">Gender</th>
						<th class="wd-10p">Join Date</th>
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
