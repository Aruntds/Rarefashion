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

if($total_qty == ''){
	$total_qty = '0';
}

?>
    <div class="content">
      <div class="container pd-x-12 pd-lg-x-12 pd-xl-x-12">
          <div class="col-lg-12">
	  <?php if($formtype == '' && $route == ''){ ?>
	  
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
							<a href="<?php echo BASEPATH; ?>lowstockproductlist" class="btn btn-light">Clear</a>
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
					
	  
       <div class="row mg-t-25">
          <div class="col-lg-12">
            <div class="row row-xs mg-b-25">
			<div data-label="Example" class="df-example demo-table table-responsive">
			  <table id="lowstockLIST" class="table table-bordered" width="99%">
			    <thead>
			        <tr>
						<th class="wd-5p">S.No</th>
						<th class="wd-10p">Product Name</th>
			            <th class="wd-10p">E-Store Code</th>
						<th class="wd-10p">MRP Price</th>
			            <th class="wd-10p">Selling Price</th>
			            <th class="wd-10p">Available Stock</th>
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
