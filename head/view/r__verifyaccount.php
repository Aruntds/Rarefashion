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

//echo $since_from;die;
if($since_from !='' && $since_to !=''){
	$since_from = dateformat_database($since_from);
	$since_to = dateformat_database($since_to);
	$filterby_date = " and DATE(createdon) between '$since_from' and '$since_to'";
	//echo $filterby_date;
	$filter_date = "DATE(createdon) between '$since_from' and '$since_to'";
}

if($filter_customer !='' && $filter_customer !='0'){
	$filter_by_customer = " and user_id = '$filter_customer' ";
	$filter_by_customer1 = " and userID = '$filter_customer' ";
}

if(!empty($filter_date) || !empty($filter_by_customer)){$where = "WHERE ";}

$list_datas = sqlQUERY_LABEL("SELECT * FROM js_customer {$where} {$filter_date} {$filter_by_customer} ORDER BY customerfirst ASC") or die("Unable to get records:".sqlERROR_LABEL());
$total_customer = sqlNUMOFROW_LABEL($list_datas);

$total_emailverified = commonNOOFROWS_COUNT('js_users', "`email_verified` = 1 {$filterby_date} {$filter_by_customer1}");
$total_emailunverified = commonNOOFROWS_COUNT('js_users', "`email_verified` = 0 {$filterby_date} {$filter_by_customer1}");

?>
    <div class="content">
      <div class="container pd-x-12 pd-lg-x-12 pd-xl-x-12">
          <div class="col-lg-12">
		  			<?php if($route == ''){ ?>
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
						<a href="<?php echo BASEPATH; ?>verifyaccount.php" class="btn btn-light">Clear</a>
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
					<div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-primary tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-5">
					  <i data-feather="bar-chart-2"></i>
					</div>
					<div class="media-body">
					  <h6 class="tx-sans tx-uppercase tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8">Total Customer</h6>
				<h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $total_customer; ?></h3>
					</div> 
				</div>
				</div>
				<div class="col-md-4">
				<div class="media mg-t-20 mg-sm-t-0 mg-sm-l-15 mg-md-l-50">
					<div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-success tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-5">
					  <i data-feather="bar-chart-2"></i>
					</div>
					<div class="media-body">
					  <h6 class="tx-sans tx-uppercase tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8">Total Email Verified</h6>
				<h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $total_emailverified; ?></h3>
					</div> 
				</div>	
				</div>				
				<div class="col-md-4">
				<div class="media mg-t-20 mg-sm-t-0 mg-sm-l-15 mg-md-l-90">
					<div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-primary tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-5">
					  <i data-feather="bar-chart-2"></i>
					</div>
					<div class="media-body">
					  <h6 class="tx-sans tx-uppercase tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8">Total Email Unverified</h6>
				<h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $total_emailunverified; ?></h3>
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
						<th class="wd-20p">Customer Name</th>
						<th class="wd-20p">Email</th>
						<th class="wd-10p">Mobile Number</th>
						<th class="wd-10p">Date of Birth</th>
			        </tr>
			    </thead>
			</table>	
			</div>
          </div>
		  <?php } if($route == 'preview'){ ?>

		  <?php } ?>	
        </div><!-- row -->
      </div><!-- container -->
    <!--</div><!-- content -->
