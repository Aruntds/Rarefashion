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
extract($_REQUEST);
include_once('jackus.php');
include_once('check_restricted.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>

    <title><?php echo $__dashboard; ?> | <?php echo BASEPATH; ?></title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo BASEPATH; ?>/public/img/favicon.png">

	<!-- main header -->
	<?php include publicpath('__seo.php'); ?>
	<!-- main header ends -->
    <!-- vendor css -->
	
    <link href="<?php echo BASEPATH; ?>/public/integration/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="<?php echo BASEPATH; ?>/public/integration/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="<?php echo BASEPATH; ?>/public/integration/jqvmap/jqvmap.min.css" rel="stylesheet">
    <link href="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="<?php echo BASEPATH; ?>/public/integration/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet">
    <!-- DashForge CSS -->
    <link rel="stylesheet" href="<?php echo BASEPATH; ?>/public/css/dashforge.css">
    <link rel="stylesheet" href="<?php echo BASEPATH; ?>/public/css/dashforge.dashboard.css">
	<link rel="stylesheet" href="<?php echo BASEPATH; ?>/public/css/skin.gradient1.css">
	<link rel="stylesheet" href="<?php echo BASEPATH; ?>/public/css/header_profile_icon.css">
	<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

  </head>
  <body class="page-profile">

	<!-- main header -->
	<?php include publicpath('__header.php'); ?>
	<!-- main header ends -->

    <div class="content content-fixed">
      <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
          <div>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sales Monitoring</li>
              </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Welcome to Dashboard</h4>
          </div>
          <div class="d-none">
            <button class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i data-feather="mail" class="wd-10 mg-r-5"></i> Email</button>
            <button class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5"><i data-feather="printer" class="wd-10 mg-r-5"></i> Print</button>
            <button class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="file" class="wd-10 mg-r-5"></i> Generate Report</button>
          </div>
		  <div class="">
			<a href="javascript:;" id="show_filter" class="btn btn-xs btn-secondary btn-icon mg-r-2"> <i data-feather="filter"></i>Filter</a>
		  </div>
        </div>
		<?php 
			if($since_from != '' && $since_to != ''){
				$since_from = dateformat_database($since_from);
				$since_to = dateformat_database($since_to);
				$filterby_date = " and DATE(createdon) between '$since_from' and '$since_to'";
				$since_from_format = date('d-M, Y',  strtotime($since_from));
				$since_to_format = date('d-M, Y',  strtotime($since_to));
				$days_summary = " from $since_from_format to $since_to_format";
			} else {
				$filterby_date = " and createdon >= DATE(NOW()) - INTERVAL 7 DAY";
				$days_summary = ' last 7 days';
			}
		?>
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
						<a href="<?php echo BASEPATH; ?>dashboard.php" class="btn btn-light">Clear</a>
					</div>					
					</div>
				</div>
				</div>
				</form>
		<!--<?php //$total_vistors_count = commonNOOFROWS_COUNT('js_total_visiters', "status = '1' and DATE(createdon) = CURRENT_DATE() ");
		?>-->
        <div class="row row-xs">
		
		<?php if(checkdashboardmenu($logged_user_level,'1')){ ?>
		<!-- START - OVERALL SALES SUMMARY -->
		<div class="col-sm-12"><h6 class="mg-b-10"><b>OVERALL SALES SUMMARY</b></h6></div>
		<?php
			$overall_sales_summary = $order_quantity_summary = $overall_paid_sales_summary = $overall_cancelled_sales_summary = $overall_pending_sales_summary = $overall_sales_paid_summary = $total_orders_summary = $total_new_summary =  $total_approved_summary = $total_inprogress_summary = $total_deliveryassigned_summary = $total_deliveryinprogress_summary = $total_delivered_summary = $total_cancelled_summary = $total_refunded_summary = $avg_order_value = '0';
			
			//$overall_sales_summary= commonNOOFROWS_COUNT('js_shop_order',"od_payment_status != '0' and od_status != '0' and deleted = '0'{$filterby_date}");
			
			$list_order_list = sqlQUERY_LABEL("SELECT SUM(od_qty) as TOTALQTY, SUM(od_price) AS TOTALVALUE, SUM(od_price) AS TOTALPRICE FROM `js_shop_order_item` where deleted = '0' and status ='1'{$filterby_date}") or die("Unable to get records:".sqlERROR_LABEL());

			$fetch_order_list = sqlNUMOFROW_LABEL($list_order_list);

			while($fetch_records = sqlFETCHARRAY_LABEL($list_order_list)){
				
				$order_quantity_summary = $fetch_records['TOTALQTY'];
				$overall_order_summary= commonNOOFROWS_COUNT('js_shop_order', "deleted = '0'{$filterby_date}");
				$order_value_summary = $fetch_records['TOTALVALUE'];
				//$order_value_summary = $order_value_summary / $overall_order_summary;
				$overall_sales_summary = $fetch_records['TOTALPRICE'];	
			}
			
			$overall_paid_sales_summary= commonNOOFROWS_COUNT('js_shop_order',"od_payment_status = '1' and deleted = '0' {$filterby_date}");	
			$overall_cancelled_sales_summary= commonNOOFROWS_COUNT('js_shop_order',"od_payment_status = '2' and deleted = '0' {$filterby_date}");	
			$overall_pending_sales_summary= commonNOOFROWS_COUNT('js_shop_order',"od_payment_status = '3' and deleted = '0' {$filterby_date}");	
			$total_orders_summary= commonNOOFROWS_COUNT('js_shop_order_item',"deleted = '0'{$filterby_date}");
			$avg_order_value = $overall_sales_summary / $total_orders_summary;
			$total_new_summary= commonNOOFROWS_COUNT('js_shop_order',"od_status = '1' and deleted = '0' {$filterby_date}");	
			$total_approved_summary= commonNOOFROWS_COUNT('js_shop_order',"od_status = '2' and deleted = '0' {$filterby_date}");		
			$total_inprogress_summary= commonNOOFROWS_COUNT('js_shop_order',"od_status = '3' and deleted = '0' {$filterby_date}");	
			$total_deliveryassigned_summary= commonNOOFROWS_COUNT('js_shop_order',"od_status = '4' and deleted = '0' {$filterby_date}");	
			$total_deliveryinprogress_summary= commonNOOFROWS_COUNT('js_shop_order',"od_status = '5' and deleted = '0' {$filterby_date}");
			$total_delivered_summary= commonNOOFROWS_COUNT('js_shop_order',"od_status = '6' and deleted = '0' {$filterby_date}");	
			$total_cancelled_summary= commonNOOFROWS_COUNT('js_shop_order',"od_status = '7' and deleted = '0' {$filterby_date}");
			$total_refunded_summary= commonNOOFROWS_COUNT('js_shop_order',"od_status = '8' and deleted = '0' {$filterby_date}");				
		?>
          <div class="col-sm-6 col-lg-3">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Sales</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">₹ <?php echo round($overall_sales_summary); ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-sm-6 col-lg-3 mg-t-10 mg-sm-t-0">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Overall Paid Sales</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $overall_sales_paid_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
		  <div class="col-sm-6 col-lg-3">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Overall Pending Sales</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $overall_pending_sales_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-sm-6 col-lg-3">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Overall Cancelled Sales</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $overall_cancelled_sales_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3 mg-t-10">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Avg. Order Value</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">₹ <?php echo round($avg_order_value); ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-sm-6 col-lg-3 mg-t-10">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Order Quantity</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $order_quantity_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
		  
		  <div class="col-sm-6 col-lg-3 mg-t-10">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Orders</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $total_orders_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
		  <div class="col-sm-6 col-lg-3 mg-t-10">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total New Orders</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $total_new_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3 mg-t-10">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Approved Orders</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $total_approved_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-sm-6 col-lg-3 mg-t-10">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total In-Progress Orders</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $total_inprogress_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-sm-6 col-lg-3 mg-t-10">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Delivery Assigned</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $total_deliveryassigned_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
		  
		  <div class="col-sm-6 col-lg-3 mg-t-10">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Delivery In-Progress</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $total_deliveryinprogress_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-sm-6 col-lg-3 mg-t-10">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Delivered</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $total_delivered_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-sm-6 col-lg-3 mg-t-10">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Cancelled Orders</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $total_cancelled_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-sm-6 col-lg-3 mg-t-10">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Refunded Orders</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $total_refunded_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
		  <!--</div>-->
		  <!-- END - OVERALL SALES SUMMARY -->
		  <?php } ?>

		<?php if(checkdashboardmenu($logged_user_level,'2')){ ?>
		  <!-- START - OVERALL CATALOG SUMMARY -->
		  <div class="col-sm-12"><h6 class="mg-t-15 mg-b-10"><b>OVERALL CATALOG SUMMARY</b></h6></div>
		  <?php
			$total_category_summary = $total_products_summary = $total_varients_summary = '0';
			$total_category_summary= commonNOOFROWS_COUNT('js_category',"deleted = '0'");
			$total_products_summary= commonNOOFROWS_COUNT('js_product',"deleted = '0'");
			$total_varients_summary= commonNOOFROWS_COUNT('js_productvariants',"deleted = '0'");
		  ?>
          <div class="col-sm-6 col-lg-4">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Category</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $total_category_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"> Available</p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-sm-6 col-lg-4 mg-t-10 mg-sm-t-0">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Products</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $total_products_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"> Available</p>
              </div>
            </div>
          </div><!-- col -->
          <!--<div class="col-sm-6 col-lg-4 mg-t-10 mg-lg-t-0">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Varients</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $total_varients_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"> Available</p>
              </div>
            </div>
          </div><!-- col -->
		  
		  <div class="col-sm-6 col-lg-4">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Stock Value</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">
				<?php
				$TOTAL_STOCK_PRODUCT_VALUE = '0';
				//echo "SELECT SUM(productopeningstock) as TOTALQTY, SUM(productsellingprice) AS TOTALVALUE, SUM(productsellingprice) AS TOTALPRICE FROM `js_product` where deleted = '0' and status ='1'";
				$list_order_list1 = sqlQUERY_LABEL("SELECT SUM(productopeningstock) as TOTALQTY, SUM(productsellingprice) AS TOTALVALUE, SUM(productsellingprice) AS TOTALPRICE FROM `js_product` where deleted = '0' and status ='1'") or die("Unable to get records:".sqlERROR_LABEL());
				
				
				$fetch_order_list1 = sqlNUMOFROW_LABEL($list_order_list1);

			while($fetch_records = sqlFETCHARRAY_LABEL($list_order_list1)){
				
				$product_quantity_summary = $fetch_records['TOTALQTY'];
				//$overall_order_summary= commonNOOFROWS_COUNT('js_shop_order', "deleted = '0'{$filterby_date}");
				$product_value_summary = $fetch_records['TOTALVALUE'];
				//$order_value_summary = $order_value_summary / $overall_order_summary;
				$product_sales_summary = $fetch_records['TOTALPRICE'];	
			}
				// $list_producttype_data_stock_value = curl_multiple(GENERALAPIPATH_SELECT_SUMMARY_STOCKVALUE_ESTORE_PRDT_DATA);
				// echo $list_producttype_data_stock_value;
				// $characters_stock_value = json_decode($list_producttype_data_stock_value); 
				// $count_producttype_list_stock_value = count($characters_stock_value);

				// if($count_producttype_list_stock_value > 0){
					// foreach ($characters_stock_value as $character_stock_value) {
						// $TOTAL_STOCK_PRODUCT_VALUE = $character_stock_value->TOTAL_STOCK_PRODUCT_VALUE;
					// }
				// }
				echo general_currency_symbol.' '.formatCASH($product_value_summary);
				?>
				</h3>
                <p class="tx-11 tx-color-03 mg-b-0"> Available</p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-sm-6 col-lg-4 mg-t-10">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Stock Available</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">
				<?php
				//echo "SELECT COUNT(`ProductID`) FROM `js_product` where deleted = '0' and status = '1' and productavailablestock <= '5' order by  productID DESC LIMIT 10";
				
			
				// $TOTAL_STOCK_PRODUCT_AVAILABLE = '0';
				// $list_producttype_data_stock_available = curl_multiple(GENERALAPIPATH_SELECT_SUMMARY_STOCKAVAIL_ESTORE_PRDT_DATA);
				// $characters_stock_available = json_decode($list_producttype_data_stock_available); 
				// $count_producttype_list_stock_available = count($characters_stock_available);

				// if($count_producttype_list_stock_available > 0){
					// foreach ($characters_stock_available as $character_stock_available) {
						// $TOTAL_STOCK_PRODUCT_AVAILABLE = $character_stock_available->TOTAL_STOCK_PRODUCT_AVAILABLE;
					// }
				// }
				echo $product_quantity_summary;
				?>
				</h3>
                <p class="tx-11 tx-color-03 mg-b-0"> Qty</p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-sm-6 col-lg-4 mg-t-10">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Low stock Products</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">
				<?php
				
				$query ="SELECT COUNT(`ProductID` )AS totalcount FROM `js_product` where deleted = '0' and status = '1' and productavailablestock <= '5' order by  productID DESC LIMIT 10" or die("Unable to get records:".sqlERROR_LABEL());
				
				$result = sqlQUERY_LABEL($query);
						while($row = sqlFETCHARRAY_LABEL($result))
						{
							$total_sum_of_low_product = $row['totalcount'];
						}
						
				
				echo $total_sum_of_low_product;
				?>
				</h3>
                <p class="tx-11 tx-color-03 mg-b-0"> Available</p>
              </div>
            </div>
          </div><!-- col -->
          <!-- END - OVERALL CATALOG SUMMARY -->
		  <?php } ?>
		<?php if(checkdashboardmenu($logged_user_level,'3')){ ?>
		  <!-- START - OVERALL CUSTOMER SUMMARY -->
		  <div class="col-sm-12"><h6 class="mg-t-15 mg-b-10"><b>OVERALL CUSTOMER SUMMARY</b></h6></div>
		  <?php 
				$all_customer_summary = $new_customer_summary = $inactive_customer_summary = $subscriber_summary = '0';
				$all_customer_summary= commonNOOFROWS_COUNT('js_customer',"deleted = '0'");
				$new_customer_summary= commonNOOFROWS_COUNT('js_customer',"DATEDIFF(CURRENT_DATE(),js_customer.createdon) < 30 {$filterby_date} and deleted = '0'");
				$inactive_customer_summary= commonNOOFROWS_COUNT('js_customer',"DATEDIFF(CURRENT_DATE(),js_customer.createdon) > 30 {$filterby_date} and js_customer.customerID NOT IN ( SELECT js_shop_order.od_userid FROM js_shop_order) and deleted = '0'");
				$subscriber_summary= commonNOOFROWS_COUNT('js_subscriber',"deleted = '0' {$filterby_date}");				
			?>
          <div class="col-sm-6 col-lg-3">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Customers</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $all_customer_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"> Available</p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-sm-6 col-lg-3 mg-t-10 mg-sm-t-0">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total New Customers</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $new_customer_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-sm-6 col-lg-3 mg-t-10 mg-lg-t-0">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Inactive Customers</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $inactive_customer_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-sm-6 col-lg-3 mg-t-10 mg-lg-t-0">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Subscriber</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $subscriber_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
		
		  <!-- END - OVERALL CUSTOMER SUMMARY -->
		  <?php } ?>

		<?php if(checkdashboardmenu($logged_user_level,'4')){ ?>
		<!-- START - OVERALL CUSTOMER GROUP SUMMARY -->
		<div class="col-sm-12"><h6 class="mg-t-15 mg-b-10"><b>OVERALL CUSTOMER GROUP SUMMARY</b></h6></div>
		<?php 
				$tier1_summary = $tier2_summary = $tier3_summary = '0';
				$tier1_summary= commonNOOFROWS_COUNT('js_customer',"customergroup = '2' and deleted = '0'{$filterby_date}");
				$tier2_summary= commonNOOFROWS_COUNT('js_customer',"customergroup = '3' and deleted = '0'{$filterby_date}");
				$tier3_summary= commonNOOFROWS_COUNT('js_customer',"customergroup = '4' and deleted = '0'{$filterby_date}");				
			?>
		  <div class="col-sm-6 col-lg-4">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Tier-1 Customers</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $tier1_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-sm-6 col-lg-4">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Tier-2 Customers</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $tier2_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-sm-6 col-lg-4">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Tier-3 Customers</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $tier3_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
          <!-- END - OVERALL CUSTOMER GROUP SUMMARY -->
		  <?php } ?>
		
		<!--<?php if(checkdashboardmenu($logged_user_level,'5')){ ?>
		  
		  <div class="col-sm-12"><h6 class="mg-t-15"><b>OVERALL MEMBERSHIP SUMMARY</b></h6></div>
		  <?php 
				$total_count_membership_summary = '0';
				$total_count_membership_summary= commonNOOFROWS_COUNT('js_membership',"deleted = '0'");			
			?>
          <div class="col-sm-6 col-lg-3 mg-t-10">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Membership</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $total_count_membership_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div>
		  <?php 
			// $query= "SELECT `membership_title`, `membership_ID` FROM `js_membership` WHERE deleted = '0' ORDER BY `membership_ID`";
				// // echo $query;
				// $result = sqlQUERY_LABEL($query);
				// while($row = sqlFETCHARRAY_LABEL($result))
				// {
					// $membership_title = $row['membership_title'];
					// $membership_ID = $row['membership_ID'];
					// $total_MEMBERSHIP_summary= commonNOOFROWS_COUNT('js_customer',"`current_membership_id` = $membership_ID AND deleted = '0'{$filterby_date}");
		  ?>
          <div class="col-sm-6 col-lg-3 mg-t-10">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total <?php echo $membership_title; ?> Members</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $total_MEMBERSHIP_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div>
		<?php //} ?>
		 
		  <?php } ?> -->
		<?php if(checkdashboardmenu($logged_user_level,'6')){ ?>
		  <!-- START - OVERALL FEEDBACK SUMMARY -->
		  <div class="col-sm-12"><h6 class="mg-t-15 mg-b-10"><b>OVERALL FEEDBACK SUMMARY</b></h6></div>
		  <?php 
		  
				$total_review_summary = $total_revieworder_summary = $total_reviewproduct_summary = $total_enquires_summary = $total_feedback_summary = $total_newfeedback_summary = $total_openfeedback_summary = $total_resolvedfeedback_summary = '0';
				$total_review_summary= commonNOOFROWS_COUNT('js_review',"deleted = '0'{$filterby_date}");
				$total_revieworder_summary= commonNOOFROWS_COUNT('js_review',"review_type = '2' and deleted = '0'{$filterby_date}");
				$total_reviewproduct_summary= commonNOOFROWS_COUNT('js_review',"review_type = '1' and deleted = '0'{$filterby_date}");
				$total_enquires_summary= commonNOOFROWS_COUNT('js_generalenquiry',"deleted = '0'{$filterby_date}");
				$total_feedback_summary= commonNOOFROWS_COUNT('js_feedback',"deleted = '0' {$filterby_date}");	
				$total_newfeedback_summary= commonNOOFROWS_COUNT('js_support_ticket',"status = '1' and deleted = '0' {$filterby_date}");	
				$total_openfeedback_summary= commonNOOFROWS_COUNT('js_support_ticket',"status = '3' and deleted = '0' {$filterby_date}");	
				$total_resolvedfeedback_summary= commonNOOFROWS_COUNT('js_support_ticket',"status = '2' and deleted = '0' {$filterby_date}");	
				
				?>
          <div class="col-sm-6 col-lg-4">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Reviews</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $total_review_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-sm-6 col-lg-4 mg-t-10 mg-sm-t-0">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Review for Products</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $total_reviewproduct_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-sm-6 col-lg-4 mg-t-10 mg-lg-t-0">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Review for Orders</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $total_revieworder_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
		  
		  <div class="col-sm-6 col-lg-4 mg-t-10">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Expected Total reviews</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $total_vistors_count; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-sm-6 col-lg-4 mg-t-10">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Enquiries</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $total_enquires_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-sm-6 col-lg-4 mg-t-10">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Feedbacks</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $total_feedback_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
		  <div class="col-sm-6 col-lg-4 mg-t-10">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total New Tickets</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $total_newfeedback_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-sm-6 col-lg-4 mg-t-10">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Open Tickets</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $total_openfeedback_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-sm-6 col-lg-4 mg-t-10">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Resolved Tickets</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"> <?php echo $total_resolvedfeedback_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
          <!-- END - OVERALL FEEDBACK SUMMARY -->
		  <?php } ?>
	
		<?php if(checkdashboardmenu($logged_user_level,'7')){ ?>
        <div class="row row-xs">
			<!-- START - OVERALL CUSTOMER SUMMARY -->
		  <div class="col-sm-12"><h6 class="mg-t-15 mg-b-10"><b>OVERALL CUSTOMER SUMMARY</b></h6></div>
		  <?php 
				if($logged_user_id != '' && $logged_user_id != '0'){
				$get_am_ID = getAREAMANEGER_DETAILS($logged_user_id,'get_am_ID_from_user_ID');
				$filterby_area_manager_CUSTOMERSUMMARY = " and am_ID = '$get_am_ID'";
				}
				$all_customer_summary = $new_customer_summary = $inactive_customer_summary = $subscriber_summary = '0';
				$all_customer_summary= commonNOOFROWS_COUNT('js_customer',"deleted = '0' ");
				$new_customer_summary= commonNOOFROWS_COUNT('js_customer',"DATEDIFF(CURRENT_DATE(),js_customer.createdon) < 30 {$filterby_date} and deleted = '0' {$filterby_area_manager_CUSTOMERSUMMARY}");
				$inactive_customer_summary= commonNOOFROWS_COUNT('js_customer',"DATEDIFF(CURRENT_DATE(),js_customer.createdon) > 30 and js_customer.customerID NOT IN ( SELECT js_shop_order.od_userid FROM js_shop_order) and deleted = '0' {$filterby_date} {$filterby_area_manager_CUSTOMERSUMMARY}");

				$subscriber_summary= commonNOOFROWS_COUNT('js_subscriber',"deleted = '0' {$filterby_date} ");				
			?>
          <div class="col-sm-6 col-lg-3">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Customers</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $all_customer_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"> Available</p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-sm-6 col-lg-3 mg-t-10 mg-sm-t-0">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total New Customers</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $new_customer_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-sm-6 col-lg-3 mg-t-10 mg-lg-t-0">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Inactive Customers</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $inactive_customer_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-sm-6 col-lg-3 mg-t-10 mg-lg-t-0">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Subscriber</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $subscriber_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
		
		  <!-- END - OVERALL CUSTOMER SUMMARY -->
          <?php }?>

		<!--<?php if(checkdashboardmenu($logged_user_level,'8')){ ?>
		  <
		  <div class="col-sm-12"><h6 class="mg-t-15"><b>OVERALL MEMBERSHIP SUMMARY</b></h6></div>
		  <?php 
				$total_count_membership_summary = '0';
				$total_count_membership_summary= commonNOOFROWS_COUNT('js_membership',"deleted = '0'");
			?>
          <div class="col-sm-6 col-lg-3 mg-t-10">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Membership</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $total_count_membership_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0">Available</p>
              </div>
            </div>
          </div>
		  <?php 
			if($logged_user_id != '' && $logged_user_id != '0'){
				$get_am_ID = getAREAMANEGER_DETAILS($logged_user_id,'get_am_ID_from_user_ID');
				$filterby_area_manager_MEMBERSHIPSUMMARY = " and am_ID = '$get_am_ID'";
				}
			$query= "SELECT `membership_title`, `membership_ID` FROM `js_membership` WHERE deleted = '0' ORDER BY `membership_ID`";
				// echo $query;
				$result = sqlQUERY_LABEL($query);
				while($row = sqlFETCHARRAY_LABEL($result))
				{
					$membership_title = $row['membership_title'];
					$membership_ID = $row['membership_ID'];
					$total_MEMBERSHIP_summary= commonNOOFROWS_COUNT('js_customer',"`current_membership_id` = $membership_ID AND deleted = '0'{$filterby_date} {$filterby_area_manager_MEMBERSHIPSUMMARY}");
		  ?>
          <div class="col-sm-6 col-lg-3 mg-t-10">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total <?php echo $membership_title; ?> Members</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php echo $total_MEMBERSHIP_summary; ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div>
		<?php } ?>
		  
		<?php } ?>-->

		<?php if(checkdashboardmenu($logged_user_level,'9')){ ?>
		<!-- START - OVERALL SALES SUMMARY -->
		<!--<div class="card card-body">-->
		<div class="col-sm-12"><h6 class="mg-t-10 mg-b-10"><b>OVERALL SALES SUMMARY</b></h6></div>
		<?php
			if($logged_user_id != '' && $logged_user_id != '0'){
				$get_am_ID = getAREAMANEGER_DETAILS($logged_user_id,'get_am_ID_from_user_ID');
				$filterby_area_manager_SUMMARY = " and CUSTOMER.am_ID = '$get_am_ID'";
				}
			
			$query= "SELECT `customerfirst`, `customerlast`, `customerphone`, `customeremail`, `createdon`, `current_membership_id` FROM `js_customer` where `deleted` = '0' {$filterby_date} {$filterby_area_manager} and am_ID !='' and am_ID !='0' order by customerID";
			// echo $query;
			$result = sqlQUERY_LABEL($query);
			$recent_sales_summary = sqlNUMOFROW_LABEL($result);
			if($recent_sales_summary > 0) {
			//$overall_sales_summary = $order_quantity_summary = $overall_paid_sales_summary = $overall_cancelled_sales_summary = $overall_pending_sales_summary = $overall_sales_paid_summary = $total_orders_summary = $total_new_summary =  $total_approved_summary = $total_inprogress_summary = $total_deliveryassigned_summary = $total_deliveryinprogress_summary = $total_delivered_summary = $total_cancelled_summary = $total_refunded_summary = '0';
			
			$fetch_records_PAIDLIST = sqlQUERY_LABEL("SELECT COUNT(SHOP_ORDER.`od_userid`) AS `COUNT_SALES_PAID` FROM `js_shop_order` AS `SHOP_ORDER`, `js_customer` AS `CUSTOMER` where CUSTOMER.`user_id` = SHOP_ORDER.`od_userid` {$filterby_area_manager_SUMMARY} AND CUSTOMER.am_ID !='' AND CUSTOMER.am_ID !='0' AND SHOP_ORDER.`od_payment_status` = '1' AND SHOP_ORDER.`od_status` != '0' AND SHOP_ORDER.`deleted` = '0' AND CUSTOMER.`deleted` = '0' {$filterby_date}") or die("Unable to get records:".sqlERROR_LABEL());
			while($fetch_records_PAID = sqlFETCHARRAY_LABEL($fetch_records_PAIDLIST)){
				
				$overall_sales_paid_summary = $fetch_records_PAID['COUNT_SALES_PAID'];
			}
	
			$fetch_records_ORDERLIST = sqlQUERY_LABEL("SELECT COUNT(SHOP_ORDER.`od_userid`) AS `COUNT_SALES` FROM `js_shop_order` AS `SHOP_ORDER`, `js_customer` AS `CUSTOMER` where CUSTOMER.`user_id` = SHOP_ORDER.`od_userid` {$filterby_area_manager_SUMMARY} AND CUSTOMER.am_ID !='' AND CUSTOMER.am_ID !='0' AND SHOP_ORDER.`deleted` = '0' AND CUSTOMER.`deleted` = '0' {$filterby_date}") or die("Unable to get records:".sqlERROR_LABEL());
			while($fetch_records_ORDER = sqlFETCHARRAY_LABEL($fetch_records_ORDERLIST)){
				
				$total_orders_summary = $fetch_records_ORDER['COUNT_SALES'];
			}
	
			$list_order_list = sqlQUERY_LABEL("SELECT SUM(SHOP_ORDER.`od_qty`) as `TOTALQTY`, SUM(SHOP_ORDER.`od_price`) AS `TOTALPRICE` FROM `js_shop_order_item` AS `SHOP_ORDER`, `js_customer` AS `CUSTOMER` where CUSTOMER.`user_id` = SHOP_ORDER.`user_id` AND CUSTOMER.am_ID = '$get_am_ID' and CUSTOMER.am_ID !='' and CUSTOMER.am_ID !='0' AND SHOP_ORDER.`deleted` = '0' AND CUSTOMER.`deleted` = '0' {$filterby_date} {$filterby_date}") or die("Unable to get records:".sqlERROR_LABEL());

			$fetch_order_list = sqlNUMOFROW_LABEL($list_order_list);

			while($fetch_records = sqlFETCHARRAY_LABEL($list_order_list)){
				
				$order_quantity_summary = $fetch_records['TOTALQTY'];
				$overall_sales_summary = $fetch_records['TOTALPRICE'];	
				$avg_order_value = $overall_sales_summary / $total_orders_summary;
			}
			
			$fetch_records_CANCELLIST = sqlQUERY_LABEL("SELECT COUNT(SHOP_ORDER.`od_userid`) AS `COUNT_SALES_PAID` FROM `js_shop_order` AS `SHOP_ORDER`, `js_customer` AS `CUSTOMER` where CUSTOMER.`user_id` = SHOP_ORDER.`od_userid` {$filterby_area_manager_SUMMARY} AND CUSTOMER.am_ID !='' AND CUSTOMER.am_ID !='0' AND SHOP_ORDER.`od_payment_status` = '2' AND SHOP_ORDER.`od_status` != '0' AND SHOP_ORDER.`deleted` = '0' AND CUSTOMER.`deleted` = '0' {$filterby_date}") or die("Unable to get records:".sqlERROR_LABEL());
			while($fetch_records_CANCEL = sqlFETCHARRAY_LABEL($fetch_records_CANCELLIST)){
				
				$overall_cancelled_sales_summary = $fetch_records_CANCEL['COUNT_SALES_PAID'];
			}

			$fetch_records_PENDINGLIST = sqlQUERY_LABEL("SELECT COUNT(SHOP_ORDER.`od_userid`) AS `COUNT_SALES_PAID` FROM `js_shop_order` AS `SHOP_ORDER`, `js_customer` AS `CUSTOMER` where CUSTOMER.`user_id` = SHOP_ORDER.`od_userid` {$filterby_area_manager_SUMMARY} AND CUSTOMER.am_ID !='' AND CUSTOMER.am_ID !='0' AND SHOP_ORDER.`od_payment_status` = '3' AND SHOP_ORDER.`od_status` != '0' AND SHOP_ORDER.`deleted` = '0' AND CUSTOMER.`deleted` = '0' {$filterby_date}") or die("Unable to get records:".sqlERROR_LABEL());
			while($fetch_records_PENDING = sqlFETCHARRAY_LABEL($fetch_records_PENDINGLIST)){
				
				$overall_pending_sales_summary = $fetch_records_PENDING['COUNT_SALES_PAID'];
			}

			$fetch_records_NEWLIST = sqlQUERY_LABEL("SELECT COUNT(SHOP_ORDER.`od_userid`) AS `COUNT_SALES` FROM `js_shop_order` AS `SHOP_ORDER`, `js_customer` AS `CUSTOMER` where CUSTOMER.`user_id` = SHOP_ORDER.`od_userid` {$filterby_area_manager_SUMMARY} AND CUSTOMER.am_ID !='' AND CUSTOMER.am_ID !='0' AND SHOP_ORDER.`od_payment_status` != '0' AND SHOP_ORDER.`od_status` = '1' AND SHOP_ORDER.`deleted` = '0' AND CUSTOMER.`deleted` = '0' {$filterby_date}") or die("Unable to get records:".sqlERROR_LABEL());
			while($fetch_records_NEW = sqlFETCHARRAY_LABEL($fetch_records_NEWLIST)){
				
				$total_new_summary = $fetch_records_NEW['COUNT_SALES'];
			}

			$fetch_records_APPROVEDLIST = sqlQUERY_LABEL("SELECT COUNT(SHOP_ORDER.`od_userid`) AS `COUNT_SALES` FROM `js_shop_order` AS `SHOP_ORDER`, `js_customer` AS `CUSTOMER` where CUSTOMER.`user_id` = SHOP_ORDER.`od_userid` {$filterby_area_manager_SUMMARY} AND CUSTOMER.am_ID !='' AND CUSTOMER.am_ID !='0' AND SHOP_ORDER.`od_payment_status` != '0' AND SHOP_ORDER.`od_status` = '2' AND SHOP_ORDER.`deleted` = '0' AND CUSTOMER.`deleted` = '0' {$filterby_date}") or die("Unable to get records:".sqlERROR_LABEL());
			while($fetch_records_APPROVED = sqlFETCHARRAY_LABEL($fetch_records_APPROVEDLIST)){
				
				$total_approved_summary = $fetch_records_APPROVED['COUNT_SALES'];
			}	

			$fetch_records_INPROGRESSLIST = sqlQUERY_LABEL("SELECT COUNT(SHOP_ORDER.`od_userid`) AS `COUNT_SALES` FROM `js_shop_order` AS `SHOP_ORDER`, `js_customer` AS `CUSTOMER` where CUSTOMER.`user_id` = SHOP_ORDER.`od_userid` {$filterby_area_manager_SUMMARY} AND CUSTOMER.am_ID !='' AND CUSTOMER.am_ID !='0' AND SHOP_ORDER.`od_payment_status` != '0' AND SHOP_ORDER.`od_status` = '3' AND SHOP_ORDER.`deleted` = '0' AND CUSTOMER.`deleted` = '0' {$filterby_date}") or die("Unable to get records:".sqlERROR_LABEL());
			while($fetch_records_INPROGRESS = sqlFETCHARRAY_LABEL($fetch_records_INPROGRESSLIST)){
				
				$total_inprogress_summary = $fetch_records_INPROGRESS['COUNT_SALES'];
			}

			$fetch_records_DELIVERYASSIGNLIST = sqlQUERY_LABEL("SELECT COUNT(SHOP_ORDER.`od_userid`) AS `COUNT_SALES` FROM `js_shop_order` AS `SHOP_ORDER`, `js_customer` AS `CUSTOMER` where CUSTOMER.`user_id` = SHOP_ORDER.`od_userid` {$filterby_area_manager_SUMMARY} AND CUSTOMER.am_ID !='' AND CUSTOMER.am_ID !='0' AND SHOP_ORDER.`od_payment_status` != '0' AND SHOP_ORDER.`od_status` = '3' AND SHOP_ORDER.`deleted` = '0' AND CUSTOMER.`deleted` = '0' {$filterby_date}") or die("Unable to get records:".sqlERROR_LABEL());
			while($fetch_records_DELIVERYASSIGN = sqlFETCHARRAY_LABEL($fetch_records_DELIVERYASSIGNLIST)){
				
				$total_deliveryassigned_summary = $fetch_records_DELIVERYASSIGN['COUNT_SALES'];
			}

			$fetch_records_DELIVERYINPROGRESSLIST = sqlQUERY_LABEL("SELECT COUNT(SHOP_ORDER.`od_userid`) AS `COUNT_SALES` FROM `js_shop_order` AS `SHOP_ORDER`, `js_customer` AS `CUSTOMER` where CUSTOMER.`user_id` = SHOP_ORDER.`od_userid` {$filterby_area_manager_SUMMARY} AND CUSTOMER.am_ID !='' AND CUSTOMER.am_ID !='0' AND SHOP_ORDER.`od_payment_status` != '0' AND SHOP_ORDER.`od_status` = '3' AND SHOP_ORDER.`deleted` = '0' AND CUSTOMER.`deleted` = '0' {$filterby_date}") or die("Unable to get records:".sqlERROR_LABEL());
			while($fetch_records_DELIVERYINPROGRESS = sqlFETCHARRAY_LABEL($fetch_records_DELIVERYINPROGRESSLIST)){
				
				$total_deliveryinprogress_summary = $fetch_records_DELIVERYINPROGRESS['COUNT_SALES'];
			}

			$fetch_records_DELIVEREDLIST = sqlQUERY_LABEL("SELECT COUNT(SHOP_ORDER.`od_userid`) AS `COUNT_SALES` FROM `js_shop_order` AS `SHOP_ORDER`, `js_customer` AS `CUSTOMER` where CUSTOMER.`user_id` = SHOP_ORDER.`od_userid` {$filterby_area_manager_SUMMARY} AND CUSTOMER.am_ID !='' AND CUSTOMER.am_ID !='0' AND SHOP_ORDER.`od_payment_status` != '0' AND SHOP_ORDER.`od_status` = '3' AND SHOP_ORDER.`deleted` = '0' AND CUSTOMER.`deleted` = '0' {$filterby_date}") or die("Unable to get records:".sqlERROR_LABEL());
			while($fetch_records_DELIVERED = sqlFETCHARRAY_LABEL($fetch_records_DELIVEREDLIST)){
				
				$total_delivered_summary = $fetch_records_DELIVERED['COUNT_SALES'];
			}

			$fetch_records_CANCELLIST = sqlQUERY_LABEL("SELECT COUNT(SHOP_ORDER.`od_userid`) AS `COUNT_SALES` FROM `js_shop_order` AS `SHOP_ORDER`, `js_customer` AS `CUSTOMER` where CUSTOMER.`user_id` = SHOP_ORDER.`od_userid` {$filterby_area_manager_SUMMARY} AND CUSTOMER.am_ID !='' AND CUSTOMER.am_ID !='0' AND SHOP_ORDER.`od_payment_status` != '0' AND SHOP_ORDER.`od_status` = '3' AND SHOP_ORDER.`deleted` = '0' AND CUSTOMER.`deleted` = '0' {$filterby_date}") or die("Unable to get records:".sqlERROR_LABEL());
			while($fetch_records_CANCEL = sqlFETCHARRAY_LABEL($fetch_records_CANCELLIST)){
				
				$total_cancelled_summary = $fetch_records_CANCEL['COUNT_SALES'];
			}

			$fetch_records_REFUNDLIST = sqlQUERY_LABEL("SELECT COUNT(SHOP_ORDER.`od_userid`) AS `COUNT_SALES` FROM `js_shop_order` AS `SHOP_ORDER`, `js_customer` AS `CUSTOMER` where CUSTOMER.`user_id` = SHOP_ORDER.`od_userid` {$filterby_area_manager_SUMMARY} AND CUSTOMER.am_ID !='' AND CUSTOMER.am_ID !='0' AND SHOP_ORDER.`od_payment_status` != '0' AND SHOP_ORDER.`od_status` = '3' AND SHOP_ORDER.`deleted` = '0' AND CUSTOMER.`deleted` = '0' {$filterby_date}") or die("Unable to get records:".sqlERROR_LABEL());
			while($fetch_records_REFUND = sqlFETCHARRAY_LABEL($fetch_records_REFUNDLIST)){
				
				$total_refunded_summary = $fetch_records_REFUND['COUNT_SALES'];
			}			
			}
		?>
          <div class="col-sm-6 col-lg-3">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Sales</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">₹ <?php if($overall_sales_summary == '') { echo '0';} else { echo round($overall_sales_summary); } ?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-sm-6 col-lg-3 mg-t-10 mg-sm-t-0">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Overall Paid Sales</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php if($overall_sales_paid_summary == '') { echo '0';} else { echo $overall_sales_paid_summary; }?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
		  <div class="col-sm-6 col-lg-3">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Overall Pending Sales</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php if($overall_pending_sales_summary == '') { echo '0';} else { echo $overall_pending_sales_summary; }?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-sm-6 col-lg-3">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Overall Cancelled Sales</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php if($overall_cancelled_sales_summary == '') { echo '0';} else { echo $overall_cancelled_sales_summary; }?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3 mg-t-10">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Avg. Order Value</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">₹ <?php if($avg_order_value == '') { echo '0';} else { echo round($avg_order_value); }?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-sm-6 col-lg-3 mg-t-10">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Order Quantity</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php if($order_quantity_summary == '') { echo '0';} else { echo $order_quantity_summary; }?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
		  
		  <div class="col-sm-6 col-lg-3 mg-t-10">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Orders</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php if($total_orders_summary == '') { echo '0';} else { echo $total_orders_summary; }?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
		  <div class="col-sm-6 col-lg-3 mg-t-10">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total New Orders</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php if($total_new_summary == '') { echo '0';} else { echo $total_new_summary; }?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3 mg-t-10">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Approved Orders</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php if($total_approved_summary == '') { echo '0';} else { echo $total_approved_summary; }?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-sm-6 col-lg-3 mg-t-10">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total In-Progress Orders</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php if($total_inprogress_summary == '') { echo '0';} else { echo $total_inprogress_summary; }?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-sm-6 col-lg-3 mg-t-10">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Delivery Assigned</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php if($total_deliveryassigned_summary == '') { echo '0';} else { echo $total_deliveryassigned_summary; }?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
		  
		  <div class="col-sm-6 col-lg-3 mg-t-10">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Delivery In-Progress</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php if($total_deliveryinprogress_summary == '') { echo '0';} else { echo $total_deliveryinprogress_summary; }?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-sm-6 col-lg-3 mg-t-10">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Delivered</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php if($total_delivered_summary == '') { echo '0';} else { echo $total_delivered_summary; }?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-sm-6 col-lg-3 mg-t-10">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Cancelled Orders</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php if($total_cancelled_summary == '') { echo '0';} else { echo $total_cancelled_summary; }?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-sm-6 col-lg-3 mg-t-10">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Refunded Orders</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><?php if($total_refunded_summary == '') { echo '0';} else { echo $total_refunded_summary; }?></h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
		  <!--</div>-->
		  <!-- END - OVERALL SALES SUMMARY -->
		<?php } ?>
		
		<?php if(checkdashboardmenu($logged_user_level,'10')){ ?>
		<div class="row row-xs">
          <div class="col-sm-6 col-lg-3">
            <div class="card card-body">
			<?php
				if($logged_user_id !='' && $logged_user_id !='0'){
					$get_da_ID = getDELIVERAGENT_DETAILS($logged_user_id,'get_da_ID_from_user_ID');
					$filter_by_agent = " and DELIVERY_DETAILS.carrier_name = '$get_da_ID'";
				}
				$query= "SELECT ORDER_DETAILS.`od_id`, ORDER_DETAILS.`od_status` FROM `js_shop_order` AS ORDER_DETAILS, `js_delivery_details` AS DELIVERY_DETAILS WHERE ORDER_DETAILS.`od_id` = DELIVERY_DETAILS.`od_id` AND ORDER_DETAILS.`deleted` = '0'{$filterby_date} {$filter_by_agent} order by ORDER_DETAILS.`od_id`";
						// echo $query;
						$result = sqlQUERY_LABEL($query);
						$delivery_agent_customers = sqlNUMOFROW_LABEL($result);
			?> 
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Assigned Orders</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">
				<?php if($delivery_agent_customers == '') {echo '0';} else { echo $delivery_agent_customers;} ?>
				</h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-sm-6 col-lg-3 mg-t-10 mg-sm-t-0">
            <div class="card card-body">
			<?php
				
				$query= "SELECT ORDER_DETAILS.`od_id`, ORDER_DETAILS.`od_status` FROM `js_shop_order` AS ORDER_DETAILS, `js_delivery_details` AS DELIVERY_DETAILS WHERE ORDER_DETAILS.`od_id` = DELIVERY_DETAILS.`od_id` and ORDER_DETAILS.`od_status` = '5' AND ORDER_DETAILS.`deleted` = '0'{$filterby_date} {$filter_by_agent} order by ORDER_DETAILS.`od_id`";
						// echo $query;
						$result = sqlQUERY_LABEL($query);
						$delivery_agent_deliveryinprogress = sqlNUMOFROW_LABEL($result);
			?>
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Delivered In-Progress</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">
				<?php if($delivery_agent_deliveryinprogress == '') {echo '0';} else { echo $delivery_agent_deliveryinprogress; }?>
				</h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-sm-6 col-lg-3 mg-t-10 mg-lg-t-0">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">TOTAL Delivered</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">
				<?php
				
				$query= "SELECT ORDER_DETAILS.`od_id`, ORDER_DETAILS.`od_status` FROM `js_shop_order` AS ORDER_DETAILS, `js_delivery_details` AS DELIVERY_DETAILS WHERE ORDER_DETAILS.`od_id` = DELIVERY_DETAILS.`od_id` and ORDER_DETAILS.`od_status` = '6' {$filter_by_agent} order by ORDER_DETAILS.`od_id`";
						// echo $query;
						$result = sqlQUERY_LABEL($query);
						$delivery_agent_delivered = sqlNUMOFROW_LABEL($result);

				if($delivery_agent_delivered == '') {echo '0';} else { echo $delivery_agent_delivered; } ?>
				</h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-sm-6 col-lg-3 mg-t-10 mg-lg-t-0">
            <div class="card card-body">
              <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Total Cancelled</h6>
              <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">
				  <?php
				
				$query= "SELECT ORDER_DETAILS.`od_id`, ORDER_DETAILS.`od_status` FROM `js_shop_order` AS ORDER_DETAILS, `js_delivery_details` AS DELIVERY_DETAILS WHERE ORDER_DETAILS.`od_id` = DELIVERY_DETAILS.`od_id` and ORDER_DETAILS.`od_status` = '7' AND ORDER_DETAILS.`deleted` = '0'{$filterby_date} {$filter_by_agent} order by ORDER_DETAILS.`od_id`";
						// echo $query;
						$result = sqlQUERY_LABEL($query);
						$delivery_agent_cancelled = sqlNUMOFROW_LABEL($result);

				if($delivery_agent_cancelled == '') {echo '0';} else { echo $delivery_agent_cancelled; } ?>
				</h3>
                <p class="tx-11 tx-color-03 mg-b-0"><?php echo $days_summary;  ?></p>
              </div>
            </div>
          </div><!-- col -->
		<?php } ?>

		<?php if(checkdashboardmenu($logged_user_level,'11')){ ?>
          <!-- visitor chart + top selling product -->
		
          <div class="col-lg-8 col-xl-12 mg-t-10">
            <div class="card">
              <div class="card-header bd-b-0 pd-t-20 pd-lg-t-25 pd-l-20 pd-lg-l-25 d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
                <div>
                  <h6 class="mg-b-5">Visitor Vs Orders</h6>
                  <p class="tx-12 tx-color-03 mg-b-0">Comparison of total visitors with total orders of last 30 days.</p>
                </div>
                <div class="btn-group mg-t-20 mg-sm-t-0">
                  <button class="btn btn-xs btn-white btn-uppercase">Refresh</button>
                </div><!-- btn-group -->
              </div><!-- card-header -->
              <div class="card-body pd-lg-25">
                <div class="row align-items-sm-end">
                  <div class="col-lg-7 col-xl-8">
                    <div class="chart-six"><canvas id="chartBar1"></canvas></div>
                  </div>
                  <div class="col-lg-5 col-xl-4 mg-t-30 mg-lg-t-0">
                    <div class="row">
                      <div class="col-sm-6 col-lg-12">
                        <div class="d-flex align-items-center justify-content-between mg-b-5">
                          <h6 class="tx-uppercase tx-10 tx-spacing-1 tx-color-02 tx-semibold mg-b-0">New Users</h6>
                          
                        </div>
                        <div class="d-flex align-items-end justify-content-between mg-b-5">
                          <h5 class="tx-normal tx-rubik lh-2 mg-b-0">13,596</h5>
                          <h6 class="tx-normal tx-rubik tx-color-03 lh-2 mg-b-0">20,000</h6>
                        </div>
                        <div class="progress ht-4 mg-b-0 op-5">
                          <div class="progress-bar bg-teal wd-65p" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-lg-12 mg-t-30 mg-sm-t-0 mg-lg-t-30">
                        <div class="d-flex align-items-center justify-content-between mg-b-5">
                          <h6 class="tx-uppercase tx-10 tx-spacing-1 tx-color-02 tx-semibold mg-b-0">Total Visitors</h6>
                         
                        </div>
                        <div class="d-flex justify-content-between mg-b-5">
                          <h5 class="tx-normal tx-rubik mg-b-0">83,123</h5>
                          <h5 class="tx-normal tx-rubik tx-color-03 mg-b-0"><small>250,000</small></h5>
                        </div>
                        <div class="progress ht-4 mg-b-0 op-5">
                          <div class="progress-bar bg-orange wd-45p" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-lg-12 mg-t-30">
                        <div class="d-flex align-items-center justify-content-between mg-b-5">
                          <h6 class="tx-uppercase tx-10 tx-spacing-1 tx-color-02 tx-semibold mg-b-0">Total Orders</h6>
                          
                        </div>
                        <div class="d-flex justify-content-between mg-b-5">
                          <h5 class="tx-normal tx-rubik mg-b-0">16,869</h5>
                          <h5 class="tx-normal tx-rubik tx-color-03 mg-b-0"><small>85,000</small></h5>
                        </div>
                        <div class="progress ht-4 mg-b-0 op-5">
                          <div class="progress-bar bg-pink wd-20p" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                    </div><!-- row -->

                  </div>
                </div>
              </div><!-- card-body -->
            </div><!-- card -->
          </div>
		<?php } ?>

		<?php if(checkdashboardmenu($logged_user_level,'12')){ ?>
          <?php 
				$query= "SELECT * FROM `js_shop_order_item` ORDER BY `od_qty` DESC LIMIT 0,4";
				// echo $query;
				$result = sqlQUERY_LABEL($query);	
		  ?>
          <div class="col-md-6 col-lg-4 col-xl-3 mg-t-10">
            <div class="card">
              <div class="card-header">
                <h6 class="mg-b-0">Top Selling Products</h6>
              </div><!-- card-header -->
              <div class="card-body pd-lg-25">
                <div class="chart-seven"><canvas id="chartDonut"></canvas></div>
              </div><!-- card-body -->
              <div class="card-footer pd-20">
                <div class="row">
				<?php
				while($row = sqlFETCHARRAY_LABEL($result))
				{
					$product_ID = $row['pd_id'];
					$__producttitle = getSINGLEDBVALUE('producttitle', " productID='$product_ID' and deleted = '0'{$filterby_date} and status = '1'", 'js_product', 'label');
					$get_max_ordered = getSINGLEDBVALUE('MAX(od_qty)', " pd_id = '$product_ID' AND deleted = '0'{$filterby_date} ", 'js_shop_order_item', 'label');
					$sumof_od_qty = getSINGLEDBVALUE('SUM(od_qty)', " pd_id = '$product_ID' AND deleted = '0'{$filterby_date}", 'js_shop_order_item', 'label');
					$custom_producttitle = limit_words($__producttitle, 2);
					$order_ID = $row['od_id'];
					$order_price = $row['od_price'];
				?>
                  <div class="col-6">
                    <p class="tx-10 tx-uppercase tx-medium tx-color-03 tx-spacing-1 tx-nowrap mg-b-5"><?php echo $custom_producttitle; ?></p>
                    <div class="d-flex align-items-center">
                      <div class="wd-10 ht-10 rounded-circle bg-pink mg-r-5"></div>
                      <h5 class="tx-normal tx-rubik mg-b-0"><?php echo $order_price; ?> <small class="tx-color-04"><?php echo get_percentage($sumof_od_qty, $get_max_ordered).'%'; ?></small></h5>
                    </div>
                  </div><!-- col -->
				<?php } ?>
                </div><!-- row -->
              </div><!-- card-footer -->
            </div><!-- card -->
          </div>
          <!-- end of visitor chart + top selling product -->
          <?php } ?>
          
		<?php if(checkdashboardmenu($logged_user_level,'13')){ ?>
		  <!-- START - LIST OF MOST VISTED PRODUCTS -->
		  <div class="col-md-3 col-xl-4 mg-t-10">
		  <?php 
				$query= "SELECT COUNT(`prdtID`) AS COUNT_Prodt, `prdtID` FROM `js_total_product_vistors_list` WHERE deleted = '0' GROUP BY `prdtID` ORDER BY COUNT_Prodt DESC LIMIT 0,5";
						// echo $query;
						$result = sqlQUERY_LABEL($query);
						$most_visited_products = sqlNUMOFROW_LABEL($result);
						if($most_visited_products > 0) {
			  ?>
            <div class="card ht-100p">
              <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mg-b-0">Most Visited Products</h6>
                <div class="d-flex align-items-center tx-18">
                  <a href="" class="link-03 lh-0"><i class="icon ion-md-refresh"></i></a>
                </div>
              </div>
			  
				<div class="card-body pd-y-15 pd-x-10">
                <div class="table-responsive">
                  <table class="table table-borderless table-sm tx-13 tx-nowrap mg-b-0">
				  
                    <thead>
                      <tr class="tx-10 tx-spacing-1 tx-color-03 tx-uppercase">
                        <th class="wd-5p">Link</th>
                        <th>Product</th>
                        <!--<th class="text-right">Views</th>-->
                      </tr>
                    </thead>
					<?php 
						
						while($row = sqlFETCHARRAY_LABEL($result))
						{
							$product_ID = $row['prdtID'];
							$product_name = getPRODUCTNAME($product_ID);
							$count_product = $row['COUNT_Prodt'];
							$product_seo_url = getSINGLEDBVALUE('productseourl',"productID='$product_ID' AND deleted = '0'{$filterby_date}",'js_product','label');	
						?>
                    <tbody>
                      <tr>
                        <td class="align-middle text-center"><a href="<?php echo SITEHOME; ?>product?token=<?php echo $product_ID; ?>-<?php echo $product_seo_url; ?>" target="_blank"><i data-feather="external-link" class="wd-12 ht-12 stroke-wd-3"></i></a></td>
                        <td class="align-middle tx-medium"><?php echo $product_name; ?>
						<br/>
						<div class="wd-280 d-inline-block">
                            <div class="progress ht-4 mg-b-0">
                              <div class="progress-bar <?php echo progress_Bar('100','label');?>" role="progressbar" style="width: <?php echo $count_product.'%'; ?>" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                          </div>
						</td>
                        <!--<td class="align-middle text-right">
                          <div class="wd-150 d-inline-block">
                            <div class="progress ht-4 mg-b-0">
                              <div class="progress-bar <?php echo progress_Bar('100','label');?>" role="progressbar" style="width: <?php echo $count_product.'%'; ?>" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                          </div>
                        </td>-->
                      </tr>
						<?php } ?>
		
                 
                    </tbody>
                  </table>
				  
                </div>
              </div><!-- card-body -->
			  <?php } else { ?>
			  
            <div class="card ht-200p">
              <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mg-b-0">Most Visited Products</h6>
                <div class="d-flex align-items-center tx-18">
                  <a href="" class="link-03 lh-0"><i class="icon ion-md-refresh"></i></a>
                </div>
              </div>
			<div class="card-footer text-center tx-13">
                No Most Visited Products
              </div>
		<?php }?>
              <div class="card-footer text-center tx-13">
                <a href="<?php echo BASEPATH;?>bestsellers.php" class="link-03">View More Visted Products <i class="icon ion-md-arrow-down mg-l-5"></i></a>
              </div><!-- card-footer -->
            </div><!-- card -->
          </div>
		  <!-- END - LIST OF MOST VISTED PRODUCTS -->
		  <?php } ?>

		<?php if(checkdashboardmenu($logged_user_level,'14')){ ?>
		  <!-- START - LIST OF RECENT ORDERS -->
		  <div class="col-md-6 col-xl-4 mg-t-10">
            <div class="card ht-100p">
              <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mg-b-0">Recent orders</h6>
                <div class="d-flex tx-18">
                  <a href="" class="link-03 lh-0"><i class="icon ion-md-refresh"></i></a>
                  <a href="" class="link-03 lh-0 mg-l-10"><i class="icon ion-md-more"></i></a>
                </div>
              </div>
			  <ul class="list-group list-group-flush tx-13">
			  <?php
				$query= "SELECT `od_refno`, `od_userid`, `od_total`, `od_status`, `od_date` FROM `js_shop_order` WHERE deleted = '0'ORDER BY `od_date` DESC LIMIT 0,5 ";
						// echo $query;
						$result = sqlQUERY_LABEL($query);
						$recent_orders = sqlNUMOFROW_LABEL($result);
						if($recent_orders > 0) {
						while($row = sqlFETCHARRAY_LABEL($result))
						{
							$od_refno = $row['od_refno'];
							$od_userid = $row['od_userid'];
							$od_total = $row['od_total'];
							$od_status = $row['od_status'];
							$od_date = date('d, M, Y g:i A',  strtotime($row['od_date']));
							$od_username = getCUSTOMERDETAILS($od_userid, 'name');
							$od_statustitle = getorder_paymentSTATUS(2, '', $od_status, 'label');
			  ?>
              
                <li class="list-group-item d-flex pd-sm-x-20">
                  <div class="avatar d-none d-sm-block"><span class="avatar-initial rounded-circle bg-teal"><i class="icon ion-md-checkmark"></i></span></div>
                  <div class="pd-sm-l-10">
                    <p class="tx-medium mg-b-0"><?php echo $od_username;?> #<?php echo $od_refno; ?></p>
                    <small class="tx-12 tx-color-03 mg-b-0"><?php echo $od_date; ?></small>
                  </div>
                  <div class="mg-l-auto text-right">
                    <p class="tx-medium mg-b-0"><?php echo general_currency_symbol.' '.formatCASH($od_total);?></p>
                    <small class="tx-12 tx-success mg-b-0"><?php echo $od_statustitle;?></small>
                  </div>
                </li>
		<?php } 
		} else { ?>
			<div class="text-center tx-13">
                No Orders
              </div>
		<?php }?>
              </ul>
              <div class="card-footer text-center tx-13">
                <a href="<?php echo BASEPATH;?>order.php" class="link-03">View All Orders <i class="icon ion-md-arrow-down mg-l-5"></i></a>
              </div><!-- card-footer -->
            </div><!-- card -->
          </div>
		  <!-- END - LIST OF RECENT ORDERS -->
		  <?php } ?>
		  
		<?php if(checkdashboardmenu($logged_user_level,'15')){ ?>
		  <!-- START - LIST OF DELIVERED ORDERS -->
		  <div class="col-md-6 col-xl-4 mg-t-10">
            
			<?php
				$query= "SELECT `od_refno`, `od_userid`, `od_total`, `od_status`, `od_date` FROM `js_shop_order` WHERE `od_status` = '6' AND deleted = '0' ORDER BY `od_date` DESC LIMIT 0,5 ";
						// echo $query;
						$result = sqlQUERY_LABEL($query);
						$recent_delivered_orders = sqlNUMOFROW_LABEL($result);
						if($recent_delivered_orders > 0) {
			  ?>
			
			<div class="card ht-100p">
              <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mg-b-0">Recent Delivered Orders</h6>
                <div class="d-flex tx-18">
                  <a href="" class="link-03 lh-0"><i class="icon ion-md-refresh"></i></a>
                </div>
              </div>
              <?php 
				
						while($row = sqlFETCHARRAY_LABEL($result))
						{
							$od_refno = $row['od_refno'];
							$od_userid = $row['od_userid'];
							$od_total = $row['od_total'];
							$od_status = $row['od_status'];
							$od_date = date('d, M, Y g:i A',  strtotime($row['od_date']));
							$od_username = getCUSTOMERDETAILS($od_userid, 'name');
							$od_statustitle = getorder_paymentSTATUS(2, '', $od_status, 'label');
			  ?>
			  <ul class="list-group list-group-flush tx-13">
			  
				
				<li class="list-group-item d-flex pd-sm-x-20">
                  <div class="avatar d-none d-sm-block"><span class="avatar-initial rounded-circle bg-orange op-5"><i class="icon ion-md-bus"></i></span></div>
                  <div class="pd-sm-l-10">
                    <p class="tx-medium mg-b-0"><?php echo $od_username;?> #<?php echo $od_refno; ?></p>
                    <small class="tx-12 tx-color-03 mg-b-0"><?php echo $od_date; ?></small>
                  </div>
                  <div class="mg-l-auto text-right">
                    <p class="tx-medium mg-b-0"><?php echo general_currency_symbol.' '.formatCASH($od_total);?></p>
                    <small class="tx-12 tx-info mg-b-0"><?php echo $od_statustitle;?></small>
                  </div>
                </li>
		<?php } ?>
		
              </ul>
			  <?php } else { ?>
		<div class="card ht-200p">
              <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mg-b-0">Recent Delivered Orders</h6>
                <div class="d-flex tx-18">
                  <a href="" class="link-03 lh-0"><i class="icon ion-md-refresh"></i></a>
                  <a href="" class="link-03 lh-0 mg-l-10"><i class="icon ion-md-more"></i></a>
                </div>
              </div>
			<div class="card-footer text-center tx-13">
                No Orders
              </div>
		<?php }?>
              <div class="card-footer text-center tx-13">
                <a href="<?php echo BASEPATH;?>order.php" class="link-03">View All Orders <i class="icon ion-md-arrow-down mg-l-5"></i></a>
              </div><!-- card-footer -->
            </div><!-- card -->
          </div>
		  <!-- END - LIST OF DELIVERED ORDERS -->
		  <?php } ?>

		<?php if(checkdashboardmenu($logged_user_level,'17') || checkdashboardmenu($logged_user_level,'16')){ ?>
		  <!-- START - LIST OF FEEDBACK -->
		  <div class="col-md-8 col-xl-8 mg-t-10">
		
		<?php if(checkdashboardmenu($logged_user_level,'16')){ ?>
		  <?php
				$query= "SELECT `product_ID`, `feedback_name`, `feedback_discription` FROM `js_feedback` WHERE deleted = '0' ORDER BY `createdon` DESC LIMIT 0,10";
						// echo $query;
						$result = sqlQUERY_LABEL($query);
						$recent_Feedback = sqlNUMOFROW_LABEL($result);
						if($recent_Feedback > 0) {
			  ?>
            <div class="card ht-200p">
              <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mg-b-0">Recent Feedbacks</h6>
                <div class="d-flex align-items-center tx-18">
                  <a href="" class="link-03 lh-0"><i class="icon ion-md-refresh"></i></a>
                </div>
              </div>
			  
				<div class="card-body pd-y-15 pd-x-10">
                <div class="table-responsive">
                  <table class="table table-borderless table-sm tx-13 tx-nowrap mg-b-0">
                    <thead>
                      <tr class="tx-10 tx-spacing-1 tx-color-03 tx-uppercase">
                        <th class="wd-5p">Product name</th>
                        <th class="wd-5p">Customer name</th>
                        <th class="wd-5p">Feedback</th>
                        <!--<th class="text-right">Views</th>-->
                      </tr>
                    </thead>
                    <tbody>
					<?php 
						
						while($row = sqlFETCHARRAY_LABEL($result))
						{
							$product_ID = $row['product_ID'];
							$product_name = getPRODUCTNAME($product_ID);
							$feedback_name = $row['feedback_name'];
							$feedback_discription = $row['feedback_discription'];
							$product_seo_url = getSINGLEDBVALUE('productseourl',"productID='$product_ID'",'js_product','label');	
						?>
                      <tr>
                        <td class="align-middle text-left"><?php echo $product_name; ?></td>
                        <td class="align-middle tx-medium"><?php echo $feedback_name; ?></td>
						<td class="align-middle text-left"><?php echo $feedback_discription; ?></td>
                      </tr>
						<?php } ?>
                 
                    </tbody>
                  </table>
                </div>
              </div><!-- card-body -->
			  <?php } else { ?>
			  
            <div class="card ht-200p">
              <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mg-b-0">Recent Feedbacks</h6>
                <div class="d-flex align-items-center tx-18">
                  <a href="" class="link-03 lh-0"><i class="icon ion-md-refresh"></i></a>
                  <a href="" class="link-03 lh-0 mg-l-10"><i class="icon ion-md-more"></i></a>
                </div>
              </div>
			<div class="card-footer text-center tx-13">
                No Recent Feedbacks 
              </div>
		<?php }?>
              <div class="card-footer text-center tx-13">
                <a href="<?php echo BASEPATH;?>feedback.php" class="link-03">View More Feedbacks <i class="icon ion-md-arrow-down mg-l-5"></i></a>
              </div><!-- card-footer -->
            </div><!-- card -->
          <?php } ?>

		
		  <!-- START - LIST OF ENQUIRY -->
		  <div class="mg-t-10">
		
		  <?php
		 // echo "SELECT `customer_name`, `customer_email`, `customer_message` FROM `js_generalenquiry` WHERE deleted = '0' ORDER BY `createdon` DESC LIMIT 0,10";
			$query= "SELECT `customer_name`, `customer_email`, `customer_message` FROM `js_generalenquiry` WHERE deleted = '0' ORDER BY `createdon` DESC LIMIT 0,10";
						// echo $query;
						$result = sqlQUERY_LABEL($query);
						$recent_enquiry = sqlNUMOFROW_LABEL($result);
						if($recent_enquiry > 0) {
		  ?>
            <div class="card ht-200p">
              <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mg-b-0">Recent Enquiries</h6>
                <div class="d-flex align-items-center tx-18">
                  <a href="" class="link-03 lh-0"><i class="icon ion-md-refresh"></i></a>
                </div>
              </div>
				<div class="card-body pd-y-15 pd-x-10">
                <div class="table-responsive">
                  <table class="table table-borderless table-sm tx-13 tx-nowrap mg-b-0">
                    <thead>
                      <tr class="tx-10 tx-spacing-1 tx-color-03 tx-uppercase">
                        <th class="wd-5p">S.No.</th>
                        <th class="wd-5p">Customer name</th>
                        <th class="wd-5p">Customer email</th>
                        <th class="wd-5p">Message</th>
                        <!--<th class="text-right">Views</th>-->
                      </tr>
                    </thead>
                    <tbody>
					<?php 
						
						while($row = sqlFETCHARRAY_LABEL($result))
						{
							$counter_enquiry++;
							$customer_name = $row['customer_name'];
							$customer_email = $row['customer_email'];
							$customer_message = $row['customer_message'];
							if($customer_message == ''){ $customer_message = EMPTYFIELD;}
						?>
                      <tr>
                        <td class="align-middle text-left"><?php echo $counter_enquiry; ?></td>
                        <td class="align-middle text-left"><?php echo $customer_name; ?></td>
                        <td class="align-middle tx-medium"><?php echo $customer_email; ?></td>
						<td class="align-middle text-left"><?php echo $customer_message; ?></td>
                      </tr>
						<?php } ?>
                 
                    </tbody>
                  </table>
                </div>
              </div><!-- card-body -->
			  <?php } else { ?>
			  <div class="card ht-200p">
              <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mg-b-0">Recent Enquiries</h6>
                <div class="d-flex align-items-center tx-18">
                  <a href="" class="link-03 lh-0"><i class="icon ion-md-refresh"></i></a>
                  <a href="" class="link-03 lh-0 mg-l-10"><i class="icon ion-md-more"></i></a>
                </div>
              </div>
			<div class="card-footer text-center tx-13">
                No Recent Enquiries 
              </div>
		<?php } ?>
              <!--<div class="card-footer text-center tx-13">
                <a href="<?php echo BASEPATH;?>feedback" class="link-03">View More Feedbacks <i class="icon ion-md-arrow-down mg-l-5"></i></a>
              </div><!-- card-footer -->
            </div><!-- card -->
          </div>
		  <!-- END - LIST OF FEEDBACK -->
		  </div>
		  <!-- END - LIST OF FEEDBACK -->
		  <?php } ?>
			  
		<?php if(checkdashboardmenu($logged_user_level,'19') || checkdashboardmenu($logged_user_level,'18')){ ?>
		<!-- START - LIST OF REVIEW -->
		  <div class="col-6 col-md-3 col-lg-4 mg-t-10">
			
		<?php if(checkdashboardmenu($logged_user_level,'18')){ ?>
                <div class="card">
                  <div class="card-header pd-t-10 pd-b-0 bd-b-0">
                    <h6 class="lh-5 mg-b-5">Overall Rating</h6>
                    <p class="tx-12 tx-color-03 mg-b-0">Measures the quality or your support team’s efforts.</p>
                  </div><!-- card-header -->
				  <?php
				 //echo "SELECT COUNT(`rating`) AS COUNT_RATING, `rating` FROM `js_review` WHERE deleted = '0' GROUP BY `rating`";
						$rating_query= sqlQUERY_LABEL("SELECT COUNT(`rating`) AS COUNT_RATING, `rating` FROM `js_review` WHERE deleted = '0' GROUP BY `rating`");
						// echo $query;
						//$rating_result = sqlQUERY_LABEL($rating_query);
						while($row1 = sqlFETCHARRAY_LABEL($rating_query))
						{
							$COUNT_RATING = $row1['COUNT_RATING'];
							$rating = $row1['rating'];
							if($rating == '1'){
								$rating_one = $COUNT_RATING;
								$total_one_rate = $COUNT_RATING;
							} else if($rating == '2'){
								$rating_two = $COUNT_RATING;
								$total_two_rate = $COUNT_RATING;
							} else if($rating == '3'){
								$rating_three = $COUNT_RATING;
								$total_three_rate = $COUNT_RATING;
							} else if($rating == '4'){
								$rating_four = $COUNT_RATING;
								$total_four_rate = $COUNT_RATING;
							} else if($rating == '5'){
								$rating_five = $COUNT_RATING;
								$total_five_rate = $COUNT_RATING;
							}
							
							$total_ratings = commonNOOFROWS_COUNT('js_review', "deleted = '0'");
							$total_no_ratings = commonNOOFROWS_COUNT('js_review', "deleted = '0' GROUP BY `rating`");
							$total_rating_percentage = round($total_ratings / $total_no_ratings,2);
						}
						//echo $rating.'test1</br>';
						//echo $COUNT_RATING.'test2';
				  ?>
                  <div class="card-body pd-0">
                    <div class="pd-t-5 pd-b-5 pd-x-20 d-flex align-items-baseline">
                      <h1 class="tx-normal tx-rubik mg-b-0 mg-r-5"><?php echo$total_rating_percentage; ?></h1>
                      <?php $star_rating = star_rating($total_rating_percentage); echo $star_rating;?>
                    </div>
                    <div class="list-group list-group-flush tx-13">
                      <div class="list-group-item pd-y-5 pd-x-20 d-flex align-items-center">
                        <strong class="tx-12 tx-rubik">5.0</strong>
                        <div class="tx-16 mg-l-10">
                          <i class="icon ion-md-star lh-0 tx-orange"></i>
                          <i class="icon ion-md-star lh-0 tx-orange"></i>
                          <i class="icon ion-md-star lh-0 tx-orange"></i>
                          <i class="icon ion-md-star lh-0 tx-orange"></i>
                          <i class="icon ion-md-star lh-0 tx-orange"></i>
                        </div>
                        <div class="mg-l-auto tx-rubik tx-color-02"><?php if($total_five_rate == ''){ echo '0'; } else { echo $total_five_rate; }?></div>
                        <div class="mg-l-20 tx-rubik tx-color-03 wd-10p text-right"><?php if($rating_five == ''){ echo '0'; } else { echo (round($rating_five / $total_ratings , 2)*100); } ?>%</div>
                      </div>
                      <div class="list-group-item pd-y-5 pd-x-20 d-flex align-items-center">
                        <strong class="tx-12 tx-rubik">4.0</strong>
                        <div class="tx-16 mg-l-10">
                          <i class="icon ion-md-star lh-0 tx-orange"></i>
                          <i class="icon ion-md-star lh-0 tx-orange"></i>
                          <i class="icon ion-md-star lh-0 tx-orange"></i>
                          <i class="icon ion-md-star lh-0 tx-orange"></i>
                          <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                        </div>
                        <div class="mg-l-auto tx-rubik tx-color-02"><?php if($total_four_rate == ''){ echo '0'; } else { echo $total_four_rate; } ?></div>
                        <div class="mg-l-20 tx-rubik tx-color-03 wd-10p text-right"><?php if($rating_four == ''){ echo '0'; } else { echo (round($rating_four / $total_ratings , 2)*100);}?>%</div>
                      </div>
                      <div class="list-group-item pd-y-5 pd-x-20 d-flex align-items-center">
                        <strong class="tx-12 tx-rubik">3.0</strong>
                        <div class="tx-16 mg-l-10">
                          <i class="icon ion-md-star lh-0 tx-orange"></i>
                          <i class="icon ion-md-star lh-0 tx-orange"></i>
                          <i class="icon ion-md-star lh-0 tx-orange"></i>
                          <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                          <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                        </div>
                        <div class="mg-l-auto tx-rubik tx-color-02"><?php if($total_three_rate == ''){ echo '0'; } else { echo $total_three_rate; }?></div>
                        <div class="mg-l-20 tx-rubik tx-color-03 wd-10p text-right"><?php if($rating_three == ''){ echo '0'; } else { echo (round($rating_three / $total_ratings , 2)*100); }?>%</div>
                      </div>
                      <div class="list-group-item pd-y-5 pd-x-20 d-flex align-items-center">
                        <strong class="tx-12 tx-rubik">2.0</strong>
                        <div class="tx-16 mg-l-10">
                          <i class="icon ion-md-star lh-0 tx-orange"></i>
                          <i class="icon ion-md-star lh-0 tx-orange"></i>
                          <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                          <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                          <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                        </div>
                        <div class="mg-l-auto tx-rubik tx-color-02"><?php if($total_two_rate == ''){ echo '0'; } else { echo $total_two_rate; }?></div>
                        <div class="mg-l-20 tx-rubik tx-color-03 wd-10p text-right"><?php if($rating_two == ''){ echo '0'; } else { echo (round($rating_two / $total_ratings , 2)*100); }?>%</div>
                      </div>
                      <div class="list-group-item pd-y-5 pd-x-20 d-flex align-items-center bg-transparent">
                        <strong class="tx-12 tx-rubik">1.0</strong>
                        <div class="tx-16 mg-l-10">
                          <i class="icon ion-md-star lh-0 tx-orange"></i>
                          <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                          <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                          <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                          <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                        </div>
                        <div class="mg-l-auto tx-rubik tx-color-02"><?php if($total_one_rate == ''){ echo '0'; } else { echo $total_one_rate; }?></div>
                        <div class="mg-l-20 tx-rubik tx-color-03 wd-10p text-right"><?php if($rating_one == ''){ echo '0'; } else { echo (round($rating_one / $total_ratings , 2)*100); }?>%</div>
                      </div>
                    </div><!-- list-group -->
					<div class="card-footer text-center tx-13">
                <a href="<?php echo BASEPATH;?>feedback.php" class="link-03">View More Feedbacks <i class="icon ion-md-arrow-down mg-l-5"></i></a>
              </div>
                  </div><!-- card-body -->
                </div><!-- card -->
			<?php } ?>

		<?php if(checkdashboardmenu($logged_user_level,'19')){ ?>
		<!-- START - LIST OF NEW CUSTMERS -->
				<div class="mg-t-10 card ht-200p">
              <div class="card-header d-flex align-items-center pd-t-5 pd-b-5  justify-content-between">
                <h6 class="mg-b-0">New Customers</h6>
                <div class="d-flex align-items-center tx-18">
                  <a href="" class="link-03 lh-0"><i class="icon ion-md-refresh"></i></a>
                </div>
              </div>
              <ul class="list-group list-group-flush tx-13">
			  <?php
			  //echo "SELECT `customerID`,`customerfirst`, `customerlast`, `reference_code`, `customeremail`, `createdon` FROM `js_customer` AS CUSTOMER WHERE CUSTOMER.`deleted`=0 AND DATEDIFF(CURRENT_DATE(),CUSTOMER.createdon) < 30 order by CUSTOMER.`customerfirst` DESC LIMIT 0,10";
				$customer_query= "SELECT `customerID`,`customerfirst`, `customerlast`, `reference_code`, `customeremail`, `createdon` FROM `js_customer` AS CUSTOMER WHERE CUSTOMER.`deleted`=0 AND DATEDIFF(CURRENT_DATE(), CUSTOMER.createdon) < 30 order by CUSTOMER.customerfirst DESC LIMIT 0,10";
				// echo $query;
				$customer_result = sqlQUERY_LABEL($customer_query);
				while($customer_row = sqlFETCHARRAY_LABEL($customer_result))
				{
					$customerID = $customer_row['customerID'];
					//$__producttitle = getSINGLEDBVALUE('producttitle', "deleted='0' and status = '1'", 'js_product', 'label');
					//$custom_producttitle = limit_words($row['producttitle'],2);
					$customer_firstname= $customer_row['customerfirst'];
					$customer_lastname = $customer_row['customerlast'];
					$customer_email = $customer_row['customeremail'];
					$reference_code = $customer_row['reference_code'];
					$createdon = $customer_row['createdon'];
			  ?>
                <li class="list-group-item d-flex pd-t-5 pd-b-5 pd-sm-x-20">
                  <div class="avatar"><span class="avatar-initial rounded-circle bg-gray-600"><?php echo substr($customer_firstname, 0, 1); ?></span></div>
                  <div class="pd-l-10">
                    <p class="tx-medium mg-b-0"><?php echo $customer_firstname.' '.$customer_lastname; ?></p>
                    <small class="tx-12 tx-color-03 mg-b-0">Reference Code#<?php echo $reference_code;?></small>
                  </div>
                  <div class="mg-l-auto d-flex align-self-center">
                    <nav class="nav nav-icon-only">
                      <a href="mailto:<?php echo $customer_email; ?>" onclick="window.open(this.href,'_blank');return false;" class="nav-link d-none d-sm-block"><i data-feather="mail"></i></a>
                      <a href="<?php echo BASEPATH; ?>customer.php?route=preview&formtype=preview&id=<?php echo $customerID; ?>" onclick="window.open(this.href,'_blank');return false;" class="nav-link d-none d-sm-block"><i data-feather="user"></i></a>
                      <a href="" class="nav-link d-sm-none"><i data-feather="more-vertical"></i></a>
                    </nav>
                  </div>
                </li>
				<?php } ?>
              </ul>
              <div class="card-footer pd-t-5 pd-b-5 text-center tx-13">
                <a href="customer.php" class="link-03">View More Customers <i class="icon ion-md-arrow-down mg-l-5"></i></a>
              </div><!-- card-footer -->
            </div><!-- card -->
		<!-- END - LIST OF NEW CUSTMERS -->
		<?php } ?>
	  </div><!-- col -->
	  <!-- END - LIST OF REVIEW -->
<?php } ?>
			  
		<?php if(checkdashboardmenu($logged_user_level,'20')){ ?>	  
		<!-- START - LIST OF Support Tickets -->  
          <div class="col-md-12 mg-t-10">
			<?php
				$query= "SELECT `ticket_no`, `product_ID`, `ticket_name`, `ticket_discription`, `status`, `createdon` FROM `js_support_ticket` WHERE deleted = '0' ORDER BY `createdon` DESC LIMIT 0,10 ";
						// echo $query;
						$result = sqlQUERY_LABEL($query);
						$recent_support_ticket = sqlNUMOFROW_LABEL($result);
						if($recent_support_ticket > 0) {
			  ?>
            <div class="card ht-200p">
              <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mg-b-0">Recent Support Ticket</h6>
                <div class="d-flex align-items-center tx-18">
                  <a href="" class="link-03 lh-0"><i class="icon ion-md-refresh"></i></a>
                </div>
              </div>
			  
				<div class="card-body pd-y-15 pd-x-10">
                <div class="table-responsive">
                  <table class="table table-borderless table-sm tx-13 tx-nowrap mg-b-0">
                    <thead>
                      <tr class="tx-10 tx-spacing-1 tx-color-03 tx-uppercase">
                        <th class="wd-5p">S.No.</th>
                        <th class="wd-5p">Ticket Number</th>
                        <th class="wd-5p">Name</th>
                        <th class="wd-5p">Status</th>
                        <th class="wd-5p">Description</th>
                        <!--<th class="text-right">Views</th>-->
                      </tr>
                    </thead>
                    <tbody>
					<?php 
						
						while($row = sqlFETCHARRAY_LABEL($result))
						{
							$counter_ticket++;
							$ticket_discription = $row['ticket_discription'];
							$ticket_no = $row['ticket_no'];
							$ticket_ID = $row['ticket_ID'];
							$ticket_name = $row['ticket_name'];
							$status = $row['status'];
							$product_ID = $row['product_ID'];
							$createdon = date('d, M, Y g:i A',  strtotime($row['createdon']));
							$product = getSINGLEDBVALUE('producttitle',"productID='$product_ID'",'js_product','label');
							if($ticket_name == ''){
								$ticket_name = "Self";
							}
							if($status==1){
								$complaint_status = "NEW";
							}
							if($status==2){
								$complaint_status = "CLOSED";
							}
							if($status==3){
								$complaint_status = "REPLIED";
							}
						?>
                      <tr>
                        <td class="align-middle text-left"><?php echo $counter_ticket; ?></td>
                        <td class="align-middle text-left"><?php echo $ticket_no; ?></td>
                        <td class="align-middle tx-medium"><?php echo $ticket_name; ?></td>
                        <td class="align-middle tx-medium"><?php echo $complaint_status; ?></td>
						<td class="align-middle text-left"><?php echo $feedback_discription; ?></td>
                      </tr>
						<?php } ?>
                 
                    </tbody>
                  </table>
                </div>
              </div><!-- card-body -->
			  <?php } else { ?>
			  
            <div class="card ht-200p">
              <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mg-b-0">Recent Support Ticket</h6>
                <div class="d-flex align-items-center tx-18">
                  <a href="" class="link-03 lh-0"><i class="icon ion-md-refresh"></i></a>
                  <a href="" class="link-03 lh-0 mg-l-10"><i class="icon ion-md-more"></i></a>
                </div>
              </div>
			<div class="card-footer text-center tx-13">
                No Recent Support Ticket
              </div>
		<?php }?>
              <div class="card-footer text-center tx-13">
                <a href="<?php echo BASEPATH;?>supportticket.php" class="link-03">View More Support Ticket <i class="icon ion-md-arrow-down mg-l-5"></i></a>
              </div>
            </div>
		  
		  
          </div><!-- col -->
          <!-- END - LIST OF  Support Tickets -->
		<?php } ?>

		<?php if(checkdashboardmenu($logged_user_level,'21')){ ?>
			<div class="row row-xs mg-t-10">
			 <div class="col-lg-6">
				<div class="card mg-b-10">
				  <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
					<div>
					  <h6 class="mg-b-5">Sales Report</h6>
					</div>
				  </div><!-- card-header -->
			  <div class="card-body pd-0">
			  <div class="ht-250"><canvas id="chartBar3"></canvas></div>
			  </div>
			  </div><!-- card-body -->
			</div><!-- card -->
			<?php } ?>
			<?php if(checkdashboardmenu($logged_user_level,'22')){ ?>
			 <div class="col-lg-6">
				<div class="card mg-b-10">
				  <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
					<div>
					  <h6 class="mg-b-5">Payment Report</h6>
					</div>
				  </div><!-- card-header -->
				<div class="card-body pd-0">
				<div class="ht-250"><canvas id="chartBar4"></canvas></div>
				</div>
			  </div><!-- card-body -->
			</div><!-- card -->
		<?php } ?>
		<?php if(checkdashboardmenu($logged_user_level,'23')){ ?>
          <div class="col-md-6 col-lg-6 col-xl-6 mg-t-10">
            <div class="card">
              <div class="card-header">
                <h6 class="mg-b-0">Reward Status for This Month</h6>
              </div><!-- card-header -->
              <div class="card-body pd-lg-25">
                <div class="chart-seven"><canvas id="chartDonut_areamanager"></canvas></div>
              </div><!-- card-body -->
              <div class="card-footer pd-20">
                <div class="row">
                  <div class="col-6">
                    <p class="tx-10 tx-uppercase tx-medium tx-color-03 tx-spacing-1 tx-nowrap mg-b-5">Organic Search</p>
                    <div class="d-flex align-items-center">
                      <div class="wd-10 ht-10 rounded-circle bg-pink mg-r-5"></div>
                      <h5 class="tx-normal tx-rubik mg-b-0"><?php echo ORDER_STATUS_REPORT_DONAT_CHART(date('m'),$get_da_ID, 'TOTAL_ORDERS'); ?></h5>
                    </div>
                  </div><!-- col -->
                  <div class="col-6">
                    <p class="tx-10 tx-uppercase tx-medium tx-color-03 tx-spacing-1 tx-nowrap mg-b-5">Email</p>
                    <div class="d-flex align-items-center">
                      <div class="wd-10 ht-10 rounded-circle bg-primary mg-r-5"></div>
                      <h5 class="tx-normal tx-rubik mg-b-0"><?php echo ORDER_STATUS_REPORT_DONAT_CHART(date('m'),$get_da_ID, 'TOTAL_IN_PROGRESS_ORDERS'); ?></h5>
                    </div>
                  </div><!-- col -->
                  <div class="col-6">
                    <p class="tx-10 tx-uppercase tx-medium tx-color-03 tx-spacing-1 tx-nowrap mg-b-5">Referral</p>
                    <div class="d-flex align-items-center">
                      <div class="wd-10 ht-10 rounded-circle bg-orange mg-r-5"></div>
                      <h5 class="tx-normal tx-rubik mg-b-0"><?php echo ORDER_STATUS_REPORT_DONAT_CHART(date('m'),$get_da_ID, 'TOTAL_PENDING_ORDERS'); ?></h5>
                    </div>
                  </div><!-- col -->
                  <div class="col-6">
                    <p class="tx-10 tx-uppercase tx-medium tx-color-03 tx-spacing-1 tx-nowrap mg-b-5">Social Media</p>
                    <div class="d-flex align-items-center">
                      <div class="wd-10 ht-10 rounded-circle bg-teal mg-r-5"></div>
                      <h5 class="tx-normal tx-rubik mg-b-0"><?php echo ORDER_STATUS_REPORT_DONAT_CHART(date('m'),$get_da_ID, 'TOTAL_DELIVERED_ORDERS'); ?></h5>
                    </div>
                  </div><!-- col -->
                </div><!-- row -->
              </div><!-- card-footer -->
            </div><!-- card -->
          </div>
		<?php } ?>

		<?php if(checkdashboardmenu($logged_user_level,'24')){ ?>
			<!-- START - FREQUENT BUYERS -->
			<div class="col-md-6 mg-t-10">
                <?php
				if($logged_user_id != '' && $logged_user_id != '0'){
					$get_am_ID = getAREAMANEGER_DETAILS($logged_user_id,'get_am_ID_from_user_ID');
					$filterby_area_manager = " and am_ID = '$get_am_ID'";
				}
				$query= "SELECT COUNT(SHOP_ORDER.od_id) AS COUNT_OD, SUM(SHOP_ORDER.od_total) AS SUM_TOTAL, CUSTOMER.`user_id`,CUSTOMER.`customerfirst`, CUSTOMER.`customerlast`, CUSTOMER.`customerphone`, CUSTOMER.`customeremail`, CUSTOMER.`createdon`, CUSTOMER.`current_membership_id` FROM `js_customer` AS CUSTOMER, js_shop_order AS SHOP_ORDER WHERE SHOP_ORDER.`od_userid` = CUSTOMER.`user_id` AND SHOP_ORDER.`deleted` = '0' AND CUSTOMER.deleted = '0' {$filterby_area_manager} and CUSTOMER.am_ID !='' and CUSTOMER.am_ID !='0' GROUP BY CUSTOMER.`user_id` order by SUM_TOTAL DESC LIMIT 0,10 ";
						// echo $query;
						$result = sqlQUERY_LABEL($query);
						$recent_frequent_buyer = sqlNUMOFROW_LABEL($result);
						if($recent_frequent_buyer > 0) {
			  ?>
            <div class="card ht-200p">
              <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mg-b-0">Recent Frequent Buyers</h6>
                <div class="d-flex align-items-center tx-18">
                  <a href="" class="link-03 lh-0"><i class="icon ion-md-refresh"></i></a>
                </div>
              </div>
			  
				<div class="card-body pd-y-15 pd-x-10">
                <div class="table-responsive">
                  <table class="table table-borderless table-sm tx-13 tx-nowrap mg-b-0">
                    <thead>
                      <tr class="tx-10 tx-spacing-1 tx-color-03 tx-uppercase">
                        <th class="wd-5p">S.No.</th>
                        <th class="wd-5p">Customer name</th>
                        <th class="wd-5p">Total Order</th>
                        <th class="wd-5p">Order Value</th>
                        <th class="wd-5p">Membership</th>
                        <!--<th class="text-right">Views</th>-->
                      </tr>
                    </thead>
                    <tbody>
					<?php 
						while($row = sqlFETCHARRAY_LABEL($result))
						{
							$counter4++;
							$customerfirst = $row['customerfirst'];
							$customerlast = $row['customerlast'];
							$customerphone = $row['customerphone'];
							$user_id = $row['user_id'];
							$customer_total_order = $row['COUNT_OD'];
							$customer_total_order_value = $row['SUM_TOTAL'];
							$current_membership_title = getMEMBERSHIP_ELIGIBILITY_ID($row['current_membership_id'], 'get_membership_title');
						?>
                      <tr>
                        <td class="align-middle text-left"><?php echo $counter4; ?></td>
                        <td class="align-middle text-left"><?php echo $customerfirst.$customerlast; ?></td>
                        <td class="align-middle tx-medium"><?php echo $customer_total_order; ?></td>
                        <td class="align-middle tx-medium"><?php echo general_currency_symbol.' '.formatCASH($customer_total_order_value); ?></td>
                        <td class="align-middle tx-medium"><?php echo $current_membership_title; ?></td>
						</td>
                      </tr>
						<?php } ?>
                 
                    </tbody>
                  </table>
                </div>
              </div><!-- card-body -->
			  <?php } else { ?>
			  
            <div class="card ht-200p">
              <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mg-b-0">Recent Frequent Buyers</h6>
                <div class="d-flex align-items-center tx-18">
                  <a href="" class="link-03 lh-0"><i class="icon ion-md-refresh"></i></a>
                  <a href="" class="link-03 lh-0 mg-l-10"><i class="icon ion-md-more"></i></a>
                </div>
              </div>
			<div class="card-footer text-center tx-13">
                No Recent Frequent Buyers 
              </div>
		<?php }?>
              <!--<div class="card-footer text-center tx-13">
                <a href="<?php echo BASEPATH;?>feedback" class="link-03">View More Assigned Customers <i class="icon ion-md-arrow-down mg-l-5"></i></a>
              </div><!-- card-footer -->
              </div>
			  
			</div>
			<!-- END - FREQUENT BUYERS -->
			<?php } ?>

		<?php if(checkdashboardmenu($logged_user_level,'25')){ ?>
			<!-- START - LIST OF ASSIGNED CUSTOMER -->
		  <div class="col-md-8 col-xl-8 mg-t-10">
		  <?php
				if($logged_user_id != '' && $logged_user_id != '0'){
					$get_am_ID = getAREAMANEGER_DETAILS($logged_user_id,'get_am_ID_from_user_ID');
					$filterby_area_manager = " and am_ID = '$get_am_ID'";
				}
				$query= "SELECT `customerfirst`, `customerlast`, `customerphone`, `customeremail`, `createdon`, `current_membership_id` FROM `js_customer` where `deleted` = '0' {$filterby_area_manager} and am_ID !='' and am_ID !='0' order by customerID DESC  LIMIT 0,10";
						// echo $query;
						$result = sqlQUERY_LABEL($query);
						$recent_Feedback = sqlNUMOFROW_LABEL($result);
						if($recent_Feedback > 0) {
			  ?>
            <div class="card ht-200p">
              <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mg-b-0">Recent Assigned Customers</h6>
                <div class="d-flex align-items-center tx-18">
                  <a href="" class="link-03 lh-0"><i class="icon ion-md-refresh"></i></a>
                </div>
              </div>
			  
				<div class="card-body pd-y-15 pd-x-10">
                <div class="table-responsive">
                  <table class="table table-borderless table-sm tx-13 tx-nowrap mg-b-0">
                    <thead>
                      <tr class="tx-10 tx-spacing-1 tx-color-03 tx-uppercase">
                        <th class="wd-5p">S.No.</th>
                        <th class="wd-5p">Customer name</th>
                        <th class="wd-5p">Phone No</th>
                        <th class="wd-5p">Email Id</th>
                        <th class="wd-5p">Joined Date</th>
                        <th class="wd-5p">Membership</th>
                        <!--<th class="text-right">Views</th>-->
                      </tr>
                    </thead>
                    <tbody>
					<?php 
						while($row = sqlFETCHARRAY_LABEL($result))
						{
							$counter++;
							$customerfirst = $row['customerfirst'];
							$customerlast = $row['customerlast'];
							$customerphone = $row['customerphone'];
							$customeremail = $row['customeremail'];
							$createdon = dateformat_datepicker($row['createdon']);
							$current_membership_title = getMEMBERSHIP_ELIGIBILITY_ID($row['current_membership_id'], 'get_membership_title');
						?>
                      <tr>
                        <td class="align-middle text-left"><?php echo $counter; ?></td>
                        <td class="align-middle text-left"><?php echo $customerfirst.$customerlast; ?></td>
                        <td class="align-middle tx-medium"><?php echo $customerphone; ?></td>
                        <td class="align-middle tx-medium"><?php echo $customeremail; ?></td>
                        <td class="align-middle tx-medium"><?php echo $createdon; ?></td>
                        <td class="align-middle tx-medium"><?php echo $current_membership_title; ?></td>
						</td>
                      </tr>
						<?php } ?>
                 
                    </tbody>
                  </table>
                </div>
              </div><!-- card-body -->
			  <?php } else { ?>
			  
            <div class="card ht-200p">
              <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mg-b-0">Recent Assigned Customers</h6>
                <div class="d-flex align-items-center tx-18">
                  <a href="" class="link-03 lh-0"><i class="icon ion-md-refresh"></i></a>
                  <a href="" class="link-03 lh-0 mg-l-10"><i class="icon ion-md-more"></i></a>
                </div>
              </div>
			<div class="card-footer text-center tx-13">
                No Recent Assigned Customers 
              </div>
		<?php }?>
              <!--<div class="card-footer text-center tx-13">
                <a href="<?php echo BASEPATH;?>feedback" class="link-03">View More Assigned Customers <i class="icon ion-md-arrow-down mg-l-5"></i></a>
              </div><!-- card-footer -->
            </div><!-- card -->
          <?php } ?>

		<?php if(checkdashboardmenu($logged_user_level,'26')){ ?>
		  <!-- START - LIST OF INACTIVE CUSTOMER -->
		  <div class="mg-t-10">
		
		  <?php
			if($logged_user_id != '' && $logged_user_id != '0'){
					$get_am_ID = getAREAMANEGER_DETAILS($logged_user_id,'get_am_ID_from_user_ID');
					$filterby_area_manager = " and am_ID = '$get_am_ID'";
				}
				$query= "SELECT `user_id`,`customerfirst`, `customerlast`, `customerphone`, `customeremail`, `createdon`, `current_membership_id` FROM `js_customer` WHERE  DATEDIFF(CURRENT_DATE(),createdon) > 30 AND `deleted` = '0'  {$filterby_area_manager} and am_ID !='' and am_ID !='0' order by customerID DESC  LIMIT 0,10";
						// echo $query;
						$result = sqlQUERY_LABEL($query);
						$recent_inactive = sqlNUMOFROW_LABEL($result);
						if($recent_inactive > 0) {
		  ?>
            <div class="card ht-200p">
              <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mg-b-0">Recent Inactive Customers</h6>
                <div class="d-flex align-items-center tx-18">
                  <a href="" class="link-03 lh-0"><i class="icon ion-md-refresh"></i></a>
                  <a href="" class="link-03 lh-0 mg-l-10"><i class="icon ion-md-more"></i></a>
                </div>
              </div>
				<div class="card-body pd-y-15 pd-x-10">
                <div class="table-responsive">
                  <table class="table table-borderless table-sm tx-13 tx-nowrap mg-b-0">
                    <thead>
                      <tr class="tx-10 tx-spacing-1 tx-color-03 tx-uppercase">
                        <th class="wd-5p">S.No.</th>
                        <th class="wd-5p">Customer name</th>
                        <th class="wd-5p">Total Order</th>
                        <th class="wd-5p">Last Order On</th>
                        <th class="wd-5p">Membership</th>
                        <!--<th class="text-right">Views</th>-->
                      </tr>
                    </thead>
                    <tbody>
					<?php 
						
						while($row = sqlFETCHARRAY_LABEL($result))
						{
							$counter1++;
							$customerfirst = $row['customerfirst'];
							$customerlast = $row['customerlast'];
							$customerphone = $row['customerphone'];
							$user_id = $row['user_id'];
							$customer_total_order = commonNOOFROWS_COUNT('js_shop_order', "od_userid = '$user_id' and `deleted` = '0'");
							
						// echo $query;
						$result1 = sqlQUERY_LABEL("SELECT `od_userid`, `createdon` FROM `js_shop_order` WHERE  od_userid = '$user_id' and `deleted` = '0' order by createdon DESC  LIMIT 0,1");
						$recent_inactive = sqlNUMOFROW_LABEL($result1);
						if($recent_inactive > 0 && $recent_inactive != 0)
						{
							$row1 = sqlFETCHARRAY_LABEL($result1);
							$createdon = dateformat_datepicker($row1['createdon']);
						} else {
							$createdon = EMPTYFIELD;
						}
							
							$current_membership_title = getMEMBERSHIP_ELIGIBILITY_ID($row['current_membership_id'], 'get_membership_title');
						?>
                      <tr>
                        <td class="align-middle text-left"><?php echo $counter1; ?></td>
                        <td class="align-middle text-left"><?php echo $customerfirst.$customerlast; ?></td>
                        <td class="align-middle tx-medium"><?php echo $customer_total_order; ?></td>
                        <td class="align-middle tx-medium"><?php echo $createdon; ?></td>
                        <td class="align-middle tx-medium"><?php echo $current_membership_title; ?></td>
						</td>
                      </tr>
						<?php } ?>
                 
                    </tbody>
                  </table>
                </div>
              </div><!-- card-body -->
			  <?php } else { ?>
			  <div class="card ht-200p">
              <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mg-b-0">Recent Inactive Customers</h6>
                <div class="d-flex align-items-center tx-18">
                  <a href="" class="link-03 lh-0"><i class="icon ion-md-refresh"></i></a>
                  <a href="" class="link-03 lh-0 mg-l-10"><i class="icon ion-md-more"></i></a>
                </div>
              </div>
			<div class="card-footer text-center tx-13">
                No Recent Inactive Customers 
              </div>
		<?php }?>
              <!--<div class="card-footer text-center tx-13">
                <a href="<?php echo BASEPATH;?>feedback" class="link-03">View More Inactive Customers <i class="icon ion-md-arrow-down mg-l-5"></i></a>
              </div><!-- card-footer -->
            </div><!-- card -->
          </div>
		  <!-- END - LIST OF INACTIVE CUSTOMER -->
		  </div>
		  <!-- END - LIST OF ASSIGNED CUSTOMER -->
		<?php } ?>
		  <?php if(checkdashboardmenu($logged_user_level,'27')){ ?>
		  <!-- START - LIST OF REWARD POINTS -->
		  <div class="col-6 col-md-3 col-lg-4 mg-t-10">
                <?php
				if($logged_user_id != '' && $logged_user_id != '0'){
					$get_am_ID = getAREAMANEGER_DETAILS($logged_user_id,'get_am_ID_from_user_ID');
					$filterby_area_manager = " and am_ID = '$get_am_ID'";
				}
				$query2= "SELECT `user_id` FROM `js_customer` where `deleted` = '0' {$filterby_area_manager} and am_ID !='' and am_ID !='0' order by customerID DESC LIMIT 0,10";
						// echo $query;
						$result2 = sqlQUERY_LABEL($query2);
						$recent_reward = sqlNUMOFROW_LABEL($result2);
						if($recent_reward > 0) {
			  ?>
            <div class="card ht-200p">
              <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mg-b-0">Recent Reward Points</h6>
                <div class="d-flex align-items-center tx-18">
                  <a href="" class="link-03 lh-0"><i class="icon ion-md-refresh"></i></a>
                </div>
              </div>
			  
				<div class="card-body pd-y-15 pd-x-10">
                <div class="table-responsive">
                  <table class="table table-borderless table-sm tx-13 tx-nowrap mg-b-0">
                    <thead>
                      <tr class="tx-10 tx-spacing-1 tx-color-03 tx-uppercase">
                        <th class="wd-5p">S.No.</th>
                        <th class="wd-5p">Order Ref No</th>
                        <th class="wd-5p">Total Value</th>
                        <th class="wd-5p">Reward Points</th>
                        <!--<th class="text-right">Views</th>-->
                      </tr>
                    </thead>
                    <tbody>
					<?php 
						while($row3 = sqlFETCHARRAY_LABEL($result2))
						{
							
							$user_id = $row3['user_id'];
							$result_REWARD = sqlQUERY_LABEL("SELECT `user_ID`, `order_ID`, `order_value`, `points` FROM `js_membership_rewards` WHERE `user_ID` = '$user_id' AND `deleted` = '0'");
							$recent_reward = sqlNUMOFROW_LABEL($result_REWARD);
							 if($recent_reward > 0 && $recent_reward != 0)
							 {
								$row_REWARD = sqlFETCHARRAY_LABEL($result_REWARD);
								$counter3++;
								$order_ID = $row_REWARD['order_ID'];
								$od_ref = getORDERREF_USING_ODID($order_ID);
								$order_value = $row_REWARD['order_value'];
								$points = $row_REWARD['points'];
							
							 
						?>
                      <tr>
                        <td class="align-middle text-left"><?php echo $counter3; ?></td>
                        <td class="align-middle text-left"><?php echo $od_ref; ?></td>
                        <td class="align-middle tx-medium"><?php echo general_currency_symbol.' '.formatCASH($order_value); ?></td>
                        <td class="align-middle tx-medium"><?php echo $points; ?></td>
						</td>
                      </tr>
						<?php 
							 }
						} ?>
                 
                    </tbody>
                  </table>
                </div>
              </div><!-- card-body -->
			  <?php } else { ?>
			  
            <div class="card ht-200p">
              <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mg-b-0">Recent Reward Points</h6>
                <div class="d-flex align-items-center tx-18">
                  <a href="" class="link-03 lh-0"><i class="icon ion-md-refresh"></i></a>
                  <a href="" class="link-03 lh-0 mg-l-10"><i class="icon ion-md-more"></i></a>
                </div>
              </div>
			<div class="card-footer text-center tx-13">
                No Recent Reward Points 
              </div>
		<?php }?>
              <!--<div class="card-footer text-center tx-13">
                <a href="<?php echo BASEPATH;?>feedback" class="link-03">View More Assigned Customers <i class="icon ion-md-arrow-down mg-l-5"></i></a>
              </div><!-- card-footer -->
            </div><!-- card -->
	  </div><!-- col -->
	  <!-- END - LIST OF REWARD POINTS -->
		<?php  } ?>
		  
		<?php if(checkdashboardmenu($logged_user_level,'28')){ ?>
			<div data-label="Example" class="df-example demo-table table-responsive mt-3">
				<h5>Assigned Customer List</h5>
				<table id="assigned_customer_list" class="table table-bordered" width="99%">
				  <thead>
					<tr>
						<th class="wd-5p">S.No</th>
						<th class="wd-15p">Customer Group</th>
						<th class="wd-20p">Name</th>
						<th class="wd-10p">Phone</th>
						<th class="wd-15p">Address</th>
						<th class="wd-10p">Status</th>
					</tr>
				 </thead>
			   </table>
			</div>
		<?php } ?>

		<?php if(checkdashboardmenu($logged_user_level,'29')){ ?>
			<div data-label="Example" class="df-example demo-table mt-3">
				<h5>Order History</h5>
				<table id="customersorderlist" class="table table-bordered" width="99%">
				 <thead>
					<tr>
						<th>#</th>
						<th>Order Ref.No</th>
						<th>Order Date</th>
						<th>Customer Name</th>
						<th>Total Amount </th>
						<th>Total Discount</th>
						<th>Order Status</th>
						<th>Payment Status</th>
					</tr>
				 </thead>
			   </table>
			</div>
			<?php } ?>
	
			<?php if(checkdashboardmenu($logged_user_level,'30')){ ?>
			<div data-label="Example" class="df-example demo-table table-responsive mt-3">
				<h5>In Active In Last 30 Days Customer List</h5>
				<table id="inactive_customer_list" class="table table-bordered" width="99%">
				  <thead>
					<tr>
						<th class="wd-5p">S.No</th>
						<th class="wd-15p">Customer Group</th>
						<th class="wd-20p">Name</th>
						<th class="wd-10p">Phone</th>
						<th class="wd-15p">Address</th>
						<th class="wd-10p">Status</th>
					</tr>
				 </thead>
			   </table>
			</div>	
			<?php } ?>
		
		
       	<?php if(checkdashboardmenu($logged_user_level,'31')){ ?>
			<!-- START - LIST OF ASSIGNED ORDERS -->
		  <div class="col-md-6 col-xl-5 mg-t-10">
            <div class="card ht-200p">
              <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mg-b-0">Recent Assigned Orders</h6>
                <div class="d-flex tx-18">
                  <a href="" class="link-03 lh-0"><i class="icon ion-md-refresh"></i></a>
                </div>
              </div>
			  <ul class="list-group list-group-flush tx-13">
			  <?php
				$query= "SELECT ORDER_DETAILS.`od_userid` AS OD_USERID, ORDER_DETAILS.`od_date` AS OD_DATE, ORDER_DETAILS.`od_status` AS OD_STATUS , ORDER_DETAILS.`od_refno` AS OD_REFNO, ORDER_DETAILS.`od_total` AS OD_TOTAL FROM `js_shop_order` AS ORDER_DETAILS, `js_delivery_details` AS DELIVERY_DETAILS WHERE ORDER_DETAILS.`od_id` = DELIVERY_DETAILS.`od_id` AND ORDER_DETAILS.`deleted` = '0' {$filter_by_agent} order by ORDER_DETAILS.`od_id` DESC LIMIT 0,10 ";
						// echo $query;
						$result = sqlQUERY_LABEL($query);
						$recent_orders = sqlNUMOFROW_LABEL($result);
						if($recent_orders > 0) {
						while($row = sqlFETCHARRAY_LABEL($result))
						{
							$OD_REFNO = $row['OD_REFNO'];
							$od_userid = $row['OD_USERID'];
							$OD_TOTAL = $row['OD_TOTAL'];
							$OD_STATUS = $row['OD_STATUS'];
							$OD_DATE = date('d, M, Y g:i A',  strtotime($row['OD_DATE']));
							$od_username = getCUSTOMERDETAILS($od_userid, 'name');
							$od_statustitle = getorder_paymentSTATUS(2, '', $OD_STATUS, 'label');
			  ?>
              
                <li class="list-group-item d-flex pd-sm-x-20">
                  <div class="avatar d-none d-sm-block"><span class="avatar-initial rounded-circle bg-teal"><i class="icon ion-md-checkmark"></i></span></div>
                  <div class="pd-sm-l-10">
                    <p class="tx-medium mg-b-0"><?php echo $od_username;?> #<?php echo $OD_REFNO; ?></p>
                    <small class="tx-12 tx-color-03 mg-b-0"><?php echo $OD_DATE; ?></small>
                  </div>
                  <div class="mg-l-auto text-right">
                    <p class="tx-medium mg-b-0"><?php echo general_currency_symbol.' '.formatCASH($OD_TOTAL);?></p>
                    <small class="tx-12 tx-success mg-b-0"><?php echo $od_statustitle;?></small>
                  </div>
                </li>
		<?php } 
		} else { ?>
			<div class="card-footer text-center tx-13 pd-b-15 pd-t-20">
                No Assigned Orders 
              </div>
		<?php }?>
              </ul>
              
            </div><!-- card -->
          </div>
		  <!-- END - LIST OF RECENT ASSIGNED ORDERS -->
		  <?php } ?>
		  
		<?php if(checkdashboardmenu($logged_user_level,'32')){ ?>
		  <!-- START - LIST OF DELIVERED ORDERS -->
		  <div class="col-md-6 col-xl-4 mg-t-10">
            <div class="card ht-200p">
              <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mg-b-0">Recent Delivered Orders</h6>
                <div class="d-flex tx-18">
                  <a href="" class="link-03 lh-0"><i class="icon ion-md-refresh"></i></a>
                </div>
              </div>
              <ul class="list-group list-group-flush tx-13">
			  <?php
				$query= "SELECT ORDER_DETAILS.`od_userid` AS OD_USERID, ORDER_DETAILS.`od_date` AS OD_DATE, ORDER_DETAILS.`od_status` AS OD_STATUS , ORDER_DETAILS.`od_refno` AS OD_REFNO, ORDER_DETAILS.`od_total` AS OD_TOTAL FROM `js_shop_order` AS ORDER_DETAILS, `js_delivery_details` AS DELIVERY_DETAILS WHERE ORDER_DETAILS.`od_id` = DELIVERY_DETAILS.`od_id` AND `OD_STATUS`='6' AND ORDER_DETAILS.`deleted` = '0'{$filter_by_agent} order by ORDER_DETAILS.`od_id` DESC LIMIT 0,10 ";
						// echo $query;
						$result = sqlQUERY_LABEL($query);
						$recent_delivered = sqlNUMOFROW_LABEL($result);
						if($recent_delivered > 0) {
						while($row = sqlFETCHARRAY_LABEL($result))
						{
							$OD_REFNO = $row['OD_REFNO'];
							$od_userid = $row['OD_USERID'];
							$OD_TOTAL = $row['OD_TOTAL'];
							$OD_STATUS = $row['OD_STATUS'];
							$OD_DATE = date('d, M, Y g:i A',  strtotime($row['OD_DATE']));
							$od_username = getCUSTOMERDETAILS($od_userid, 'name');
							$od_statustitle = getorder_paymentSTATUS(2, '', $OD_STATUS, 'label');
			  ?>
				
				<li class="list-group-item d-flex pd-sm-x-20">
                  <div class="avatar d-none d-sm-block"><span class="avatar-initial rounded-circle bg-orange op-5"><i class="icon ion-md-bus"></i></span></div>
                  <div class="pd-sm-l-10">
                    <p class="tx-medium mg-b-0"><?php echo $od_username;?> #<?php echo $OD_REFNO; ?></p>
                    <small class="tx-12 tx-color-03 mg-b-0"><?php echo $OD_DATE; ?></small>
                  </div>
                  <div class="mg-l-auto text-right">
                    <p class="tx-medium mg-b-0"><?php echo general_currency_symbol.' '.formatCASH($OD_TOTAL);?></p>
                    <small class="tx-12 tx-info mg-b-0"><?php echo $od_statustitle;?></small>
                  </div>
                </li>
		<?php } 
		} else { ?>
			<div class="card-footer text-center tx-13 pd-b-15 pd-t-20">
                No Recent Delivered Orders 
              </div>
		<?php }?>
              </ul>
              <div class="card-footer text-center tx-13">
                <a href="<?php echo BASEPATH;?>completedorder.php" class="link-03">View All Delivered Orders <i class="icon ion-md-arrow-down mg-l-5"></i></a>
              </div><!-- card-footer -->
            </div><!-- card -->
          </div>
		  <!-- END - LIST OF DELIVERED ORDERS -->
		<?php } ?>
		  
        
		<?php if(checkdashboardmenu($logged_user_level,'33')){ ?>
		<div class="col-md-6 col-lg-4 col-xl-3">
            <div class="card">
              <div class="card-header">
                <h6 class="mg-b-0">Order Status for This Month</h6>
              </div><!-- card-header -->
              <div class="card-body pd-lg-25">
                <div class="chart-seven"><canvas id="chartDonut"></canvas></div>
              </div><!-- card-body -->
              <div class="card-footer pd-20">
                <div class="row">
                  <div class="col-6">
                    <p class="tx-10 tx-uppercase tx-medium tx-color-03 tx-spacing-1 tx-nowrap mg-b-5">Total Order</p>
                    <div class="d-flex align-items-center">
                      <div class="wd-10 ht-10 rounded-circle bg-pink mg-r-5"></div>
                      <h5 class="tx-normal tx-rubik mg-b-0"><?php echo ORDER_STATUS_REPORT_DONAT_CHART(date('m'),$get_da_ID, 'TOTAL_ORDERS'); ?></h5>
                    </div>
                  </div><!-- col -->
                  <div class="col-6">
                    <p class="tx-10 tx-uppercase tx-medium tx-color-03 tx-spacing-1 tx-nowrap mg-b-5">Total In-Progress</p>
                    <div class="d-flex align-items-center">
                      <div class="wd-10 ht-10 rounded-circle bg-primary mg-r-5"></div>
                      <h5 class="tx-normal tx-rubik mg-b-0"><?php echo ORDER_STATUS_REPORT_DONAT_CHART(date('m'),$get_da_ID, 'TOTAL_IN_PROGRESS_ORDERS'); ?></h5>
                    </div>
                  </div><!-- col -->
                  <div class="col-6">
                    <p class="tx-10 tx-uppercase tx-medium tx-color-03 tx-spacing-1 tx-nowrap mg-b-5">Total Pending</p>
                    <div class="d-flex align-items-center">
                      <div class="wd-10 ht-10 rounded-circle bg-orange mg-r-5"></div>
                      <h5 class="tx-normal tx-rubik mg-b-0"><?php echo ORDER_STATUS_REPORT_DONAT_CHART(date('m'),$get_da_ID, 'TOTAL_PENDING_ORDERS'); ?></h5>
                    </div>
                  </div><!-- col -->
                  <div class="col-6">
                    <p class="tx-10 tx-uppercase tx-medium tx-color-03 tx-spacing-1 tx-nowrap mg-b-5">Total Delivered</p>
                    <div class="d-flex align-items-center">
                      <div class="wd-10 ht-10 rounded-circle bg-teal mg-r-5"></div>
                      <h5 class="tx-normal tx-rubik mg-b-0"><?php echo ORDER_STATUS_REPORT_DONAT_CHART(date('m'),$get_da_ID, 'TOTAL_DELIVERED_ORDERS'); ?></h5>
                    </div>
                  </div><!-- col -->
                </div><!-- row -->
              </div><!-- card-footer -->
            </div><!-- card -->
          </div>
          <!-- end of visitor chart + top selling product -->
		  <?php } ?>
		  
		<?php if(checkdashboardmenu($logged_user_level,'34')){ ?>
          <!-- visitor chart + top selling product -->
          <div class="col-lg-8 col-xl-9 mg-t-10">
		  <form action="" method="post">
		  <div class="ml-1 mg-t-10">
			<div class="row row-xs mg-b-25">
			<span class="ml-auto " style="display:none;" id="show_status_list">
				<select class="custom-select-sm custom-select" name="order_status" id="order_status">
					<?php
						echo getorder_paymentSTATUS('2', $od_id, $od_status, 'select_in_delivery_agent');
					?>											
				</select>
			</span>
			<input type='submit' value='Update' style="display:none;" name='setupdate_order_status' class="btn btn-sm btn-success mb-3 mg-l-5" id='btn-approve' />
			<input type='submit' href="<?php echo BASEPATH; ?>dashboard.php" value='Reset' style="display:none;" name='cancel' class="btn btn-sm btn-danger mb-3 ml-2" id='btn-reject' />
			<div data-label="Example" class="df-example demo-table table-responsive">
				<table id="delivery_agent_order_list" class="table table-bordered" width="99%">
					<thead>
						<tr>
							<th class="wd-5p"><input name="select_all" id="example-select-all" class="example-select-all" type="checkbox"></th>
							<th class="wd-5p">S.No</th>
							<th class="wd-5p">Ord. Ref. No</th>
							<th class="wd-5p">Ord. Date</th>
							<th class="wd-15p">Customer Name</th>
							<th class="wd-15p">Customer Mobile</th>
							<th class="wd-10p">Order Status</th>
							<th class="wd-10p">Delivered On</th>
						</tr>
					</thead>
				</table>
			</div>
			</div><!-- row -->
		  </div><!-- col -->
		  </form>
		  </div>



		<?php } ?>
        </div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->
    
    <!-- Footer -->
    <?php include publicpath('__footer.php'); ?>
    <!-- End of Footer -->

    <script src="<?php echo BASEPATH; ?>/public/integration/jquery.flot/jquery.flot.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/jquery.flot/jquery.flot.stack.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/jquery.flot/jquery.flot.resize.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/chart.js/Chart.bundle.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/jqvmap/jquery.vmap.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/jqvmap/maps/jquery.vmap.usa.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/js/dashforge.sampledata.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/dataTables.dataTables.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-responsive-dt/js/responsive.dataTables.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/select2/js/select2.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/pdfmake/pdfmake.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/pdfmake/vfs_fonts.js"></script>
	<script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/buttons.flash.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/jszip.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/buttons.html5.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/buttons.print.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/dataTables.select.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
	<script src="<?php echo BASEPATH; ?>/public/integration/jqueryui/jquery-ui.min.js"></script>
    <script>
	
	$(document).ready(function() {
		$("#show_filter").click(function() {
			$("#filter_content").slideToggle("slow");
		});
	});
	
	$('#since_from').datepicker({
	  showOtherMonths: true,
	  selectOtherMonths: true,
	  changeMonth: true,
	  dateFormat: 'dd/mm/yy',
	  changeYear: true,
	  maxDate : 0
	});
	$('#since_to').datepicker({
	  showOtherMonths: true,
	  selectOtherMonths: true,
	  changeMonth: true,
	  dateFormat: 'dd/mm/yy',
	  changeYear: true,
	  maxDate : 0
	});
	<?php if($logged_user_level == '3'){ ?>

        /** PIE CHART **/
        var datapie = {
          labels: ['Organic Search', 'Email', 'Referral', 'Social Media'],
          datasets: [{
            data: [20,20,30,25],
            backgroundColor: ['#f77eb9', '#7ebcff','#7ee5e5','#fdbd88']
          }]
        };

        var optionpie = {
          maintainAspectRatio: false,
          responsive: true,
          legend: {
            display: false,
          },
          animation: {
            animateScale: true,
            animateRotate: true
          }
        };
        
        // For a pie chart
        var ctx2 = document.getElementById('chartDonut_areamanager');
        var myDonutChart = new Chart(ctx2, {
          type: 'doughnut',
          data: datapie,
          options: optionpie
        });

	$(function(){
	'use strict'
	
  //Stacked chart
  var ctxLabel = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
  var ctxData1 = [20,3,25,15,12,55,87,64,15,54,89,45];
  var ctxData2 = [20,3,25,15,12,55,87,64,15,54,89,45];

  var ctxColor1 = '#1ce1ac';
  var ctxColor2 = '#1b2e4b';
  //var ctxColor2 = '#001737';
  
  var ctx3 = document.getElementById('chartBar3').getContext('2d');
  new Chart(ctx3, {
    type: 'bar',
    data: {
      labels: ctxLabel,
      datasets: [{
		label: 'Credit Sales', 
        data: ctxData1,
        backgroundColor: ctxColor1
      },{
		label: 'Cash Sales', 
        data: ctxData2,
        backgroundColor: ctxColor2
      }
	  ]
    },
    options: {
      maintainAspectRatio: false,
      responsive: true,
      legend: {
        display: true,
        labels: {
          display: false
        }
      },
      scales: {
        yAxes: [{
          stacked: true,
          gridLines: {
            color: '#e5e9f2'
          },
          ticks: {
            beginAtZero:true,
            fontSize: 10,
            fontColor: '#182b49'
          }
        }],
        xAxes: [{
          stacked: true,
          gridLines: {
            display: false
          },
          barPercentage: 0.6,
          ticks: {
            beginAtZero:true,
            fontSize: 11,
            fontColor: '#182b49'
          }
        }]
      }
    }
  });
  
// Stacked chart
  var ctxLabel = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

  var ctxData1 = [20,3,25,15,12,55,87,64,15,54,89,45];
  var ctxData2 = [20,3,25,15,12,55,87,64,15,54,89,45];
  //var ctxColor1 = '#1ce1ac';
  var ctxColor1 = '#6f42c1';
  var ctxColor2 = '#ffc107';
  
  var ctx4 = document.getElementById('chartBar4').getContext('2d');
  new Chart(ctx4, {
    type: 'bar',
    data: {
      labels: ctxLabel,
      datasets: [{
		label: 'Total Paid', 
        data: ctxData1,
        backgroundColor: ctxColor1
      }, 
	  {
		label: 'Total Due', 
        data: ctxData2,
        backgroundColor: ctxColor2
      }
	  ]
    },
    options: {
      maintainAspectRatio: false,
      responsive: true,
      legend: {
        display: true,
        labels: {
          display: false
        }
      },
      scales: {
        yAxes: [{
          stacked: true,
          gridLines: {
            color: '#e5e9f2'
          },
          ticks: {
            beginAtZero:true,
            fontSize: 10,
            fontColor: '#182b49'
          }
        }],
        xAxes: [{
          stacked: true,
          gridLines: {
            display: false
          },
          barPercentage: 0.6,
          ticks: {
            beginAtZero:true,
            fontSize: 11,
            fontColor: '#182b49'
          }
        }]
      }
    }
  });
  
  });
  
		$('#customersorderlist').DataTable({
          //responsive: true,
		  dom: 'Bfrtip',
          'ajax': 'engine/json/JSON_areamanagerwise_customer_orderlist.php?am_logged_ID=<?php echo $logged_user_id; ?>',
           "columns": [
                    { data: "count" }, //0
                    { data: "od_refno" }, //1
                    { data: "od_date" }, //2
                    { data: "customer_name" }, //4
                    { data: "od_total" }, //4
                    { data: "od_discount_amount" }, //4
                    { data: "orderstatus" }, //4
                    { data: "paymentstatus" }
          ],
		  "columnDefs": [{
			  	"targets": 0,
				"data": "count",
				"searchable": false
			},
			{
			"targets": 1,
			"data": "ref_no",
			"render" : function ( data, type, row) {
				return '<a data-toggle="tooltip" data-original-title="Click to View" href="<?php echo BASEPATH; ?>order?route=preview&formtype=preview&id='+row.modify+'" target="_blank">'+data+'</a>';
			}
			}
		  ],
		buttons: [
		{
			extend: 'copy',
			text: window.copyButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4], // Only name, email and role
			}
		},
		{
			extend: 'excel',
			text: window.excelButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4], // Only name, email and role
			}
		},
		{
			extend: 'csv',
			text: window.csvButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4], // Only name, email and role
			}
		},		
		{
			extend: 'pdf',
			text: window.pdfButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4], // Only name, email and role
			}
		},		
		{
			extend: 'print',
			text: window.printButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4], // Only name, email and role
			}
		}
        ],
          language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ Items/Page',
          }
        });

		$('#assigned_customer_list').DataTable({
          //responsive: true,
		  dom: 'Bfrtip',
          'ajax': 'engine/json/JSON_areamanagerwise_customer_list.php?am_logged_ID=<?php echo $logged_user_id; ?>',
           "columns": [
				{ "data": "count" },
				{ "data": "customergroup" },
				{ "data": "name" },
				{ "data": "customerphone" },
				{ "data": "address" },
				{ "data": "status" }
          ],
		  "columnDefs": [{
			  	"targets": 0,
				"data": "count",
				"searchable": false
			}
		  ],
		buttons: [
		{
			extend: 'copy',
			text: window.copyButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4], // Only name, email and role
			}
		},
		{
			extend: 'excel',
			text: window.excelButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4], // Only name, email and role
			}
		},
		{
			extend: 'csv',
			text: window.csvButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4], // Only name, email and role
			}
		},		
		{
			extend: 'pdf',
			text: window.pdfButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4], // Only name, email and role
			}
		},		
		{
			extend: 'print',
			text: window.printButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4], // Only name, email and role
			}
		}
        ],
          language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ Items/Page',
          }
        });

		$('#inactive_customer_list').DataTable({
          //responsive: true,
		  dom: 'Bfrtip',
          'ajax': 'engine/json/JSON_customer_inactive_in_last_thirty_days.php?am_logged_ID=<?php echo $logged_user_id; ?>',
           "columns": [
				{ "data": "count" },
				{ "data": "customergroup" },
				{ "data": "name" },
				{ "data": "customerphone" },
				{ "data": "address" },
				{ "data": "status" }
          ],
		  "columnDefs": [{
			  	"targets": 0,
				"data": "count",
				"searchable": false
			}
		  ],
		buttons: [
		{
			extend: 'copy',
			text: window.copyButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4], // Only name, email and role
			}
		},
		{
			extend: 'excel',
			text: window.excelButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4], // Only name, email and role
			}
		},
		{
			extend: 'csv',
			text: window.csvButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4], // Only name, email and role
			}
		},		
		{
			extend: 'pdf',
			text: window.pdfButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4], // Only name, email and role
			}
		},		
		{
			extend: 'print',
			text: window.printButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4], // Only name, email and role
			}
		}
        ],
          language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ Items/Page',
          }
        });

	<?php } if($logged_user_level == '4'){ ?>

        /** PIE CHART **/
        var datapie = {
          labels: ['Total Orders', 'Total Inprogress', 'Total Pending', 'Total Delivered'],
          datasets: [{
            data: [<?php echo ORDER_STATUS_REPORT_DONAT_CHART(date('m'),$get_da_ID, 'TOTAL_ORDERS'); ?>, <?php echo ORDER_STATUS_REPORT_DONAT_CHART(date('m'),$get_da_ID, 'TOTAL_IN_PROGRESS_ORDERS'); ?>,<?php echo ORDER_STATUS_REPORT_DONAT_CHART(date('m'),$get_da_ID, 'TOTAL_PENDING_ORDERS'); ?>,<?php echo ORDER_STATUS_REPORT_DONAT_CHART(date('m'),$get_da_ID, 'TOTAL_DELIVERED_ORDERS'); ?>],
            backgroundColor: ['#f77eb9', '#7ebcff','#fdbd88','#7ee5e5']
          }]
        };

        var optionpie = {
          maintainAspectRatio: false,
          responsive: true,
          legend: {
            display: false,
          },
          animation: {
            animateScale: true,
            animateRotate: true
          }
        };
        
        // For a pie chart
        var ctx2 = document.getElementById('chartDonut');
        var myDonutChart = new Chart(ctx2, {
          type: 'doughnut',
          data: datapie,
          options: optionpie
        });

	  $(document).ready(function () {
		$('.example-select-all').on('click', function () {
		$(this).closest('table').find('tbody :checkbox')
		.prop('checked', this.checked)
		.closest('tr').toggleClass('selected', this.checked);
		if($(".example-select-all:checked").is(":checked") == true){
			 $('#show_status_list').show();
			 $('#btn-approve').show();
			 $('#btn-reject').show();
		} else {
			 $('#show_status_list').hide();
			 $('#btn-approve').hide(); 
			 $('#btn-reject').hide(); 
		}
		});

		$('#delivery_agent_order_list tbody').on('click','#example-select', function () {
		if($(".example-select:checked").is(":checked") == true){
			 $('#show_status_list').show();
			 $('#btn-approve').show();
			 $('#btn-reject').show();
		} else {
			 $('#show_status_list').hide(); 
			 $('#btn-approve').hide(); 
			 $('#btn-reject').hide(); 
		}
		});
	 });	

        $('#delivery_agent_order_list').DataTable({
          responsive: true,
		  dom: 'Bfrtip',
          'ajax': 'engine/json/JSON_agent_order_details_for_dashboard.php?filter_by_agent_ID=<?php echo $logged_user_id; ?>',
           "columns": [
            { "data": "count_checkbox" },
            { "data": "count" },
			{ "data": "od_refno" },
			{ "data": "od_date" },
			{ "data": "customer_name" },
			{ "data": "customer_phone" },
			{ "data": "orderstatus" },
			{ "data": "deleiveredon" }	   
          ],
		  "columnDefs": [{
			  	"targets": 0,
				"data": "text",                            
                "render": function(data, type, full, meta) {
                    return '<input name="od_update_ID[]" id="example-select"  value="'+data+'" class="example-select" type="checkbox">';
				}	
			},
			{
			  	"targets": 2,
				"data": "count",
				"searchable": false,
				"render": function ( data, type, row, full, meta ) {
					return '<a title="Click to Preview" href="<?php echo BASEPATH; ?>order?route=preview&formtype=preview&id='+row.modify+'">'+row.od_refno+'</a>';
					//return '';
				}
			}
		  ],
		buttons: [
		{
			extend: 'copy',
			text: window.copyButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4, 5], // Only name, email and role
			}
		},
		{
			extend: 'excel',
			text: window.excelButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4, 5], // Only name, email and role
			}
		},
		{
			extend: 'csv',
			text: window.csvButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4, 5], // Only name, email and role
			}
		},		
		{
			extend: 'pdf',
			text: window.pdfButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4, 5], // Only name, email and role
			}
		},		
		{
			extend: 'print',
			text: window.printButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4, 5], // Only name, email and role
			}
		}
        ],
          language: {
            searchPlaceholder: 'Search...',
			sSearch: '',
            lengthMenu: '_MENU_ Items/Page',
          },
		select: true
        });

	<?php
	if($code == '1') { 
	  $displayMSG_globalclass->displayMSG($code, "Success", 'Order Status Updated Successfully', 'success');
	}
    ?>
	<?php } if($logged_user_id == '1') { ?>
	 $(function(){
        'use strict'

        var ctx1 = document.getElementById('chartBar1').getContext('2d');
        new Chart(ctx1, {
          type: 'bar',
          data: {
            labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            datasets: [{
              data: [150,110,90,115,125,160,160,140,100,110,120,120],
              backgroundColor: '#66a4fb'
            },{
              data: [180,140,120,135,155,170,180,150,140,150,130,130],
              backgroundColor: '#65e0e0'
            }]
          },
          options: {
            maintainAspectRatio: false,
            legend: {
              display: false,
                labels: {
                  display: false
                }
            },
            scales: {
              xAxes: [{
                display: false,
                barPercentage: 0.5
              }],
              yAxes: [{
                gridLines: {
                  color: '#ebeef3'
                },
                ticks: {
                  fontColor: '#8392a5',
                  fontSize: 10,
                  min: 80,
                  max: 200
                }
              }]
            }
          }
        });

        /** PIE CHART **/
        var datapie = {
          labels: ['Organic Search', 'Email', 'Referral', 'Social Media'],
          datasets: [{
            data: [20,20,30,25],
            backgroundColor: ['#f77eb9', '#7ebcff','#7ee5e5','#fdbd88']
          }]
        };

        var optionpie = {
          maintainAspectRatio: false,
          responsive: true,
          legend: {
            display: false,
          },
          animation: {
            animateScale: true,
            animateRotate: true
          }
        };
        
        // For a pie chart
        var ctx2 = document.getElementById('chartDonut');
        var myDonutChart = new Chart(ctx2, {
          type: 'doughnut',
          data: datapie,
          options: optionpie
        });

        $.plot('#flotChart2', [{
          data: [[0,55],[1,38],[2,20],[3,70],[4,50],[5,15],[6,30],[7,50],[8,40],[9,55],[10,60],[11,40],[12,32],[13,17],[14,28],[15,36],[16,53],[17,66],[18,58],[19,46]],
          color: '#69b2f8'
        },{
          data: [[0,80],[1,80],[2,80],[3,80],[4,80],[5,80],[6,80],[7,80],[8,80],[9,80],[10,80],[11,80],[12,80],[13,80],[14,80],[15,80],[16,80],[17,80],[18,80],[19,80]],
          color: '#f0f1f5'
        }], {
          series: {
            stack: 0,
            bars: {
              show: true,
              lineWidth: 0,
              barWidth: .5,
              fill: 1
            }
          },
          grid: {
            borderWidth: 0,
            borderColor: '#edeff6'
          },
          yaxis: {
            show: false,
            max: 80
          },
          xaxis: {
            ticks:[[0,'Jan'],[4,'Feb'],[8,'Mar'],[12,'Apr'],[16,'May'],[19,'Jun']],
            color: '#fff',
          }
        });

        $.plot('#flotChart3', [{
            data: df4,
            color: '#9db2c6'
          }], {
    			series: {
    				shadowSize: 0,
            lines: {
              show: true,
              lineWidth: 2,
              fill: true,
              fillColor: { colors: [ { opacity: 0 }, { opacity: .5 } ] }
            }
    			},
          grid: {
            borderWidth: 0,
            labelMargin: 0
          },
    			yaxis: {
            show: false,
            min: 0,
            max: 60
          },
    			xaxis: { show: false }
    		});

        $.plot('#flotChart4', [{
            data: df5,
            color: '#9db2c6'
          }], {
    			series: {
    				shadowSize: 0,
            lines: {
              show: true,
              lineWidth: 2,
              fill: true,
              fillColor: { colors: [ { opacity: 0 }, { opacity: .5 } ] }
            }
    			},
          grid: {
            borderWidth: 0,
            labelMargin: 0
          },
    			yaxis: {
            show: false,
            min: 0,
            max: 80
          },
    			xaxis: { show: false }
    		});

        $.plot('#flotChart5', [{
            data: df6,
            color: '#9db2c6'
          }], {
    			series: {
    				shadowSize: 0,
            lines: {
              show: true,
              lineWidth: 2,
              fill: true,
              fillColor: { colors: [ { opacity: 0 }, { opacity: .5 } ] }
            }
    			},
          grid: {
            borderWidth: 0,
            labelMargin: 0
          },
    			yaxis: {
            show: false,
            min: 0,
            max: 80
          },
    			xaxis: { show: false }
    		});

        $.plot('#flotChart6', [{
            data: df4,
            color: '#9db2c6'
          }], {
    			series: {
    				shadowSize: 0,
            lines: {
              show: true,
              lineWidth: 2,
              fill: true,
              fillColor: { colors: [ { opacity: 0 }, { opacity: .5 } ] }
            }
    			},
          grid: {
            borderWidth: 0,
            labelMargin: 0
          },
    			yaxis: {
            show: false,
            min: 0,
            max: 60
          },
    			xaxis: { show: false }
    		});

        $('#vmap').vectorMap({
          map: 'usa_en',
          showTooltip: true,
          backgroundColor: '#fff',
          color: '#d1e6fa',
          colors: {
            fl: '#69b2f8',
            ca: '#69b2f8',
            tx: '#69b2f8',
            wy: '#69b2f8',
            ny: '#69b2f8'
          },
          selectedColor: '#00cccc',
          enableZoom: false,
          borderWidth: 1,
          borderColor: '#fff',
          hoverOpacity: .85
        });


        var ctxLabel = ['6am', '10am', '1pm', '4pm', '7pm', '10pm'];
        var ctxData1 = [20, 60, 50, 45, 50, 60];
        var ctxData2 = [10, 40, 30, 40, 55, 25];

        // Bar chart
        var ctx1 = document.getElementById('chartBar2').getContext('2d');
        new Chart(ctx1, {
          type: 'horizontalBar',
          data: {
            labels: ctxLabel,
            datasets: [{
              data: ctxData1,
              backgroundColor: '#69b2f8'
            }, {
              data: ctxData2,
              backgroundColor: '#d1e6fa'
            }]
          },
          options: {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
              display: false,
              labels: {
                display: false
              }
            },
            scales: {
              yAxes: [{
                gridLines: {
                  display: false
                },
                ticks: {
                  display: false,
                  beginAtZero: true,
                  fontSize: 10,
                  fontColor: '#182b49'
                }
              }],
              xAxes: [{
                gridLines: {
                  display: true,
                  color: '#eceef4'
                },
                barPercentage: 0.6,
                ticks: {
                  beginAtZero: true,
                  fontSize: 10,
                  fontColor: '#8392a5',
                  max: 80
                }
              }]
            }
          }
        });

      })
	<?php } ?>
	
		
    </script>
  </body>
</html>
