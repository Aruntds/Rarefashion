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
       <div class="row mg-t-25">
          <div class="col-lg-12">
            <div class="row row-xs mg-b-25">
			<div data-label="Example" class="df-example demo-table table-responsive">
			  <table id="invoiceLIST" class="table table-bordered" width="99%">
			    <thead>
			        <tr>
						<th class="wd-5p">S.No</th>
						<th class="wd-10p">Order Ref. No.</th>
			            <th class="wd-10p">Order Date</th>
						<th class="wd-15p">Customer Name</th>
			            <th class="wd-5p">Quantity</th>
			            <th class="wd-15p">Total Amount (<?php echo general_currency_symbol; ?>)</th>
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
