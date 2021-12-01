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
		<?php  if($formtype=='' && $route == ''){ ?> 
        <div class="row">
          <div class="col-lg-10">
            <div class="row row-xs mg-b-20">

			<div data-label="Example" class="df-example demo-table table-responsive">
			  <table id="customerLIST" class="table table-bordered">
			    <thead>
			        <tr>
                        <th class="wd-5p">S.No</th>
			            <!--<th class="wd-15p">Customer Group</th>-->
                        <th class="wd-15p">Name</th>
                        <th class="wd-15p">Email</th>
			            <th class="wd-5p">Phone</th>
			            <th class="wd-10p">Address</th>
			            <th class="wd-10p">City</th>
			            <th class="wd-10p">State</th>
			            <th class="wd-10p">Country</th>
			            <th class="wd-5p">Status</th>
			            <th class="wd-15p">Option</th>
			        </tr>
			    </thead>
			</table>
		   </div>

         </div><!-- row -->
        </div><!-- col -->

          <?php
		  		$display_quickbar = 'Y';
	          include viewpath('__customersidebar.php'); 
          ?>

        </div><!-- row -->
		<?php }  if($route == 'preview'&& $formtype == 'preview') { ?>
			<form action="" method="GET">
				 <div id="stick-here"></div>
					<div id="stickThis" class="form-group row mg-b-0 ml-auto mb-3">
						<div class="col-sm-12 mt-3">
							<a href="<?php echo BASEPATH; ?>customer.php" class="float-right btn btn-secondary">Back</a>
						</div>
					</div>
					<?php 
				  $list_parentcategory_datas = sqlQUERY_LABEL("SELECT * FROM `js_customer` where deleted = '0' and customerID = '$id' order by customerID desc") or die("#1-Unable to get records:".mysql_error());

				  $count_parentcateogry_list = sqlNUMOFROW_LABEL($list_parentcategory_datas);

				  while($row = sqlFETCHARRAY_LABEL($list_parentcategory_datas)){
					  $counter++;
					  $customerID = $row["customerID"];
					  $user_id = $row["user_id"];
					  $customergroup = $row["customergroup"];
					  $customerfirst = $row["customerfirst"];
					  $customerlast = $row["customerlast"];
					  $customeremail = $row["customeremail"];
					  $customerdob = dateformat_datepicker($row["customerdob"]);
					  if($customerdob == '--' ){ $customerdob = EMPTYFIELD;}
					  $customergender = $row["customergender"];
					  $customerphone = $row["customerphone"];
					  $customeraddress1 = $row["customeraddress1"];
					  $customeraddress2 = $row["customeraddress2"];
					  $customerpincode = $row["customerpincode"];
					  $customerstate = $row["customerstate"];
					  $status = $row["status"];
					  if($customergender == '1'){$customergender = "Male";}elseif($customergender == '2'){$customergender = 'Female';}elseif($customergender == '3'){$customergender = "Transgender";} else{$customergender = EMPTYFIELD;}
					  $fullname = $customerfirst." ".$customerlast;
					  $address = $customeraddress1.",".$customeraddress2.",".$customerstate.",".$customerpincode.".";
					  
					  if($customeraddress1 != ''){
						  $customeraddress1 = $customeraddress1.",";
					  }
					  if($customeraddress2 != ''){
						  $customeraddress2 = $customeraddress2.",";
					  }
					  if($customerstate != ''){
						  $customerstate = $customerstate.",";
					  }
					  if($customerpincode != ''){
						  $customerpincode = $customerpincode.".";
					  }
					  $address = $customeraddress1.$customeraddress2.$customerstate.$customerpincode;
					  if($address == ''){
							$address = EMPTYFIELD;
					  }

					}
					?>
					<div class="row">
						<div class="col-md-8 col-lg-8 col-xl-8">
							<div class="card">
							<h4 class="card-header text-muted text-uppercase">Customer Profile</h4>
								<div class="card-body form-group row">
									<!--<div class="col-md-4 border-right mg-t-20 ">
										<div class="text-uppercase">
											<span>Customer Group </span>
										</div>
										<div class="text-muted mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
											<span>
												<?php echo getcustomerGROUP($customergroup, 'label'); ?></span>
										</div>
									</div>-->
									<div class="col-md-4 border-right mg-t-20 ">
										<div class="text-uppercase">
											<span>Customer Name </span>
										</div>
										<div class="text-muted mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
											<span>
												<?php echo $fullname; ?></span>
										</div>
									</div>
									<div class="col-md-4 mg-t-20 ">
										<div class="text-uppercase">
											<span>Customer Email </span>
										</div>
										<div class="text-muted mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
											<span>
												<?php echo $customeremail; ?></span>
										</div>
									</div>
									<div class="col-md-4 mg-t-20 border-right">
										<div class="text-uppercase">
											<span>Customer Mobile </span>
										</div>
										<div class="text-muted mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
											<span>
												<?php echo $customerphone; ?></span>
										</div>
									</div>
									<div class="col-md-4 mg-t-20 border-right">
										<div class="text-uppercase">
											<span>Customer Gender </span>
										</div>
										<div class="text-muted mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
											<span>
												<?php echo $customergender; ?></span>
										</div>
									</div>
									<div class="col-md-4 mg-t-20 ">
										<div class="text-uppercase">
											<span>Customer DOB </span>
										</div>
										<div class="text-muted mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
											<span>
												<?php echo $customerdob; ?></span>
										</div>
									</div>
									<div class="col-md-9 mg-t-20">
										<div class="text-uppercase">
											<span>Customer Address</span>
										</div>
										<div class="text-muted mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
											<span>
												<?php echo $address; ?></span>
										</div>
									</div>
								</div>
							</div>

							<div class="modal fade" id="quickupdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							  <div class="modal-dialog" role="document">
								<div class="modal-content modalformcontent">

								</div>
							  </div>
							</div>

							<div data-label="Example" class="df-example demo-table mt-3">
								<h5>Order History</h5>
								<table id="customersorderlist" class="table table-bordered" width="99%">
								 <thead>
									<tr>
										<th class="wd-5p">#</th>
										<th class="wd-5p">Order Ref.No</th>
										<th class="wd-5p">Order Date</th>
										<th class="wd-5p">Total Items</th>
										<th class="wd-5p">Total Amounts</th>
										<th class="wd-5p">Total Taxes</th>
										<th class="wd-5p">Payment Status</th>
										<th class="wd-5p">Order Status</th>
									</tr>
								 </thead>
							   </table>
							</div>
						</div>

						<div class="col-md-4 col-lg-4 col-xl-4 mg-t-10 mg-lg-t-0">
							<div class="card">
							  <div class="card-header">
								<h5 class="mg-b-0">Sales Summary</h5>
							  </div><!-- card-header -->
							  <div class="card-body pd-lg-25">
								<div class="chart-seven"><canvas id="chartDonut"></canvas></div>
							  </div><!-- card-body -->
							  <div class="card-footer pd-20">
								<div class="row">
								  <div class="col-6 mg-b-10">
									<p class="tx-10 tx-uppercase tx-medium tx-color-03 tx-spacing-1 tx-nowrap mg-b-5">Total Orders</p>
									<div class="d-flex align-items-center">
									  <div class="wd-10 ht-10 rounded-circle bg-teal mg-r-5"></div>
									  <h5 class="tx-normal tx-rubik mg-b-0"><?php echo CUSTOMERWISE_ORDER_DETAILS($user_id,'total_orders'); ?></h5>
									</div>
								  </div><!-- col -->
								  <div class="col-6 mg-b-10">
									<p class="tx-10 tx-uppercase tx-medium tx-color-03 tx-spacing-1 mg-b-5">Total Sales</p>
									<div class="d-flex align-items-center">
									  <div class="wd-10 ht-10 rounded-circle bg-orange mg-r-5"></div>
									  <h5 class="tx-normal tx-rubik mg-b-0"><?php echo number_format(CUSTOMERWISE_ORDER_DETAILS($user_id, 'total_sales'),2); ?></h5>
									</div>
								  </div><!-- col -->
								  </div><!-- col -->
								</div><!-- row -->
							</div><!-- card-footer -->
						</div><!-- card -->
					</div>

					<!--<div data-label="Example" class="df-example demo-table table-responsive mt-3">
						<h5>Referral Customer List</h5>
						<table id="customer_referal_list" class="table table-bordered" width="99%">
						  <thead>
							<tr>
								<th class="wd-5p">S.No</th>
								
								<th class="wd-20p">Name</th>
								<th class="wd-10p">Phone</th>
								<th class="wd-15p">Total Orders</th>
								<th class="wd-15p">Total Amounts</th>
								<th class="wd-10p">Status</th>
							</tr>
						 </thead>
					   </table>
					</div>-->

				<!--<div class="row">
					<div class="col-md-6 col-lg-6 col-xl-6 mg-t-10 mg-lg-t-0">
						<div data-label="Example" class="df-example demo-table mt-3">
							<h5>Due Payment Report Generated List</h5>
							<table id="due_payment_report" class="table table-bordered" width="99%">
							 <thead>
								<tr>
									<th>#</th>
									<th>Generated On</th>
									<th>Due Balance Amount</th>
								</tr>
							 </thead>
						   </table>
						</div>
					</div>

					<div class="col-md-6 col-lg-6 col-xl-6 mg-t-10 mg-lg-t-0">
						<div data-label="Example" class="df-example demo-table mt-3">
							<h5>Payment History</h5>
							<table id="customer_bulk_payment_history" class="table table-bordered" width="99%">
							 <thead>
								<tr>
									<th class="wd-5p">#</th>
									<th class="wd-15p">Paid On</th>
									<th class="wd-15p">Amount</th>
									<th class="wd-15p">Payment mode</th>
									<th class="wd-15p">Notes</th>
								</tr>
							 </thead>
						   </table>
						</div>
					</div>
				</div>-->
				
			</form>
		<?php } ?>
      </div><!-- container -->
    </div><!-- content -->