<?php

	if($currentpage == 'dashboard.php') { $active_home = "active"; } 
	if($currentpage == 'completedorder.php') { $active_completedorder = "active"; } 
	
	//Sales
	if($currentpage == 'order.php' || $currentpage == 'invoices.php' || $currentpage == 'orderdelivered.php' || $currentpage == 'orderrefund.php' || $currentpage == 'transaction.php') { $active_sales = "active"; }
	
	//Catalog
	if($currentpage == 'product.php' || $currentpage == 'category.php' || $currentpage == 'membership.php') { $active_catalog = "active"; }
	
	//Customer
	if($currentpage == 'customer.php' || $currentpage == 'customergroup.php' || $currentpage == 'subscriber.php') { $active_customer = "active"; }
	
	//Feedback
	if($currentpage == 'rating.php' || $currentpage == 'feedback.php' || $currentpage == 'support_ticket.php' || $currentpage == 'generalenquiry.php') { $active_feedback = "active"; }
	
	//Content
	if($currentpage == 'content.php' || $currentpage == 'footer.php' || $currentpage == 'footerone.php' || $currentpage == 'homeslider.php' || $currentpage == 'promobanner1.php' || $currentpage == 'homeicon.php' || $currentpage == 'promobanner2.php') { $active_content = "active"; }

	//Reports
	if($currentpage == 'productsincart.php' || $currentpage == 'abandonedcarts.php' || $currentpage == 'verifyaccount.php' || $currentpage == 'invoicereport.php' || $currentpage == 'orderdeliveredreport.php' || $currentpage == 'orderrefundreport.php' || $currentpage == 'couponwisediscountreport.php' || $currentpage == 'newcustomers.php' || $currentpage == 'inactivecustomers.php' || $currentpage == 'customersalesreport.php' || $currentpage == 'orderlist.php' || $currentpage == 'bestsellers.php' || $currentpage == 'lowstockproductlist.php' || $currentpage == 'ordered.php') { $active_reports = "active"; }

	//store
	if($currentpage == 'promocode.php'){
		$active_promocode = "active";
	}
	
	//Settings
	if($currentpage == 'configurationgeneral.php' || $currentpage == 'configurationfrontpage.php' || $currentpage == 'configurationcatalog.php' || $currentpage == 'configurationsecurity.php' || $currentpage == 'configurationcustomer.php' || $currentpage == 'configurationsales.php' || $currentpage == 'socialmedia.php' || $currentpage == 'referalcommission.php' || $currentpage == 'areamanager.php' || $currentpage == 'deliveryagent.php' || $currentpage == 'assigncustomer.php' || $currentpage == 'smtpconfig.php' || $currentpage == 'emailtemplate.php' || $currentpage == 'configurationgeneralcontact.php' || $currentpage == 'configurationgsalesrepresentative.php' || $currentpage == 'configurationcustomersupport.php' || $currentpage == 'pagemenu.php' || $currentpage == 'rolepermission.php') { $active_settings = "active"; }
	
?>
<div class="pace-progress" data-progress-text="100%" data-progress="99" style="transform: translate3d(100%, 0px, 0px);">
  <div class="pace-progress-inner"></div>
</div>
    <header class="navbar navbar-header navbar-header-fixed">
      <a href="" id="mainMenuOpen" class="burger-menu"><i data-feather="menu"></i></a>
      <div class="navbar-brand">
        <a href="index.php" class="df-logo">Rare<span>Fashions </span></a>
      </div><!-- navbar-brand -->
      <div id="navbarMenu" class="navbar-menu-wrapper">
        <div class="navbar-menu-header">
          <a href="index.php" class="df-logo">Rare<span>Fashions</span></a>
          <a id="mainMenuClose" href=""><i data-feather="x"></i></a>
        </div><!-- navbar-menu-header -->
        <ul class="nav navbar-menu">
          <li class="nav-label pd-l-20 pd-lg-l-25 d-lg-none">Main Navigation</li>
          <li class="nav-item <?php echo $active_home; ?>">
            <a href="dashboard.php" class="nav-link <?php echo $active_home; ?>"><i data-feather="pie-chart"></i> <?php echo $__menudashboard; ?></a>
          </li>
		  
          <?php 
		  $orders_sales_page_ID = checkmenu('List Order');
		  $invoices_sales_page_ID = checkmenu('List Invoices');
		  $membership_sales_page_ID = checkmenu('List Order Delivered');
		  $refunds_sales_page_ID = checkmenu('List Order Refund');
		  $transaction_sales_page_ID = checkmenu('List Transaction');
		  if(($orders_sales_page_ID !='' && checkrolemenu($orders_sales_page_ID,$logged_user_level)) || ($invoices_sales_page_ID !='' && checkrolemenu($invoices_sales_page_ID,$logged_user_level)) || ($membership_sales_page_ID !='' && checkrolemenu($membership_sales_page_ID,$logged_user_level)) || ($refunds_sales_page_ID !='' && checkrolemenu($refunds_sales_page_ID,$logged_user_level)) || ($transaction_sales_page_ID !='' && checkrolemenu($transaction_sales_page_ID,$logged_user_level))) { ?>
		  
          <li class="nav-item with-sub <?php $active_sales; ?>">
            <a href="" class="nav-link"><i data-feather="package"></i> <?php echo $__menusales; ?></a>
            <div class="navbar-menu-sub">
              <div class="d-lg-flex">
                <ul>
				<?php if(($orders_sales_page_ID !='' && checkrolemenu($orders_sales_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="order.php" class="nav-sub-link"><i data-feather="target"></i> <?php echo $__menuorders; ?></a></li>
				<?php } ?>
				<?php if(($invoices_sales_page_ID !='' && checkrolemenu($invoices_sales_page_ID,$logged_user_level))) { ?>
				  <li class="nav-sub-item"><a href="invoices.php" class="nav-sub-link"><i data-feather="book"></i> <?php echo $__menuinvoices; ?></a></li>
				<?php } if(($membership_sales_page_ID !='' && checkrolemenu($membership_sales_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="orderdelivered.php" class="nav-sub-link"><i data-feather="truck"></i> <?php echo $__menudelivered; ?></a></li>
				<?php } if( ($refunds_sales_page_ID !='' && checkrolemenu($refunds_sales_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="orderrefund.php" class="nav-sub-link"><i data-feather="thumbs-down"></i> <?php echo $__menurefund; ?></a></li>
				<?php } if(($transaction_sales_page_ID !='' && checkrolemenu($transaction_sales_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="transaction.php" class="nav-sub-link"><i data-feather="book-open"></i> <?php echo $__menutransactions; ?></a></li>
				<?php } ?>
                </ul>
              </div>
            </div><!-- nav-sub -->
          </li> 
		  <?php } ?>
		  
		  <?php 
		  $rating_customer_page_ID = checkmenu('List Rating');
		  $feedback_customer_page_ID = checkmenu('List Feedback');
		  $supportticket_customer_page_ID = checkmenu('List Support Ticket');
		  $generalenquiry_customer_page_ID = checkmenu('List General Enquiry');
		  if(($rating_customer_page_ID !='' && checkrolemenu($rating_customer_page_ID,$logged_user_level)) || ($feedback_customer_page_ID !='' && checkrolemenu($feedback_customer_page_ID,$logged_user_level)) || ($supportticket_customer_page_ID !='' && checkrolemenu($supportticket_customer_page_ID,$logged_user_level)) ||($generalenquiry_customer_page_ID !='' && checkrolemenu($generalenquiry_customer_page_ID,$logged_user_level))) { ?>
		  
		  <li class="nav-item with-sub <?php echo $active_feedback; ?>">
            <a href="" class="nav-link "><i data-feather="package"></i> Feedback </a>
            <div class="navbar-menu-sub">
              <div class="d-lg-flex">
                <ul>
				<?php if(($rating_customer_page_ID !='' && checkrolemenu($rating_customer_page_ID,$logged_user_level))) { ?>
				  <li class="nav-sub-item"><a href="rating.php" class="nav-sub-link"><i data-feather="book"></i> Rating</a></li>
				<?php } ?>
				<?php if(($feedback_customer_page_ID !='' && checkrolemenu($feedback_customer_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="feedback.php" class="nav-sub-link"><i data-feather="truck"></i> Feedback</a></li>
				<?php } ?>
				<?php if(($supportticket_customer_page_ID !='' && checkrolemenu($supportticket_customer_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="support_ticket.php" class="nav-sub-link"><i data-feather="thumbs-down"></i> Support Ticket </a></li>
				<?php } ?>
                </ul>
              </div>
            </div><!-- nav-sub -->
          </li>
		  <?php } ?>
		  <?php 
		  $products_catalog_page_ID = checkmenu('List Product');
		  $category_catalog_page_ID = checkmenu('List Category');
		  $membership_catalog_page_ID = checkmenu('List Membership');
		 if(($products_catalog_page_ID !='' && checkrolemenu($products_catalog_page_ID,$logged_user_level)) || ($category_catalog_page_ID !='' && checkrolemenu($category_catalog_page_ID,$logged_user_level))) { ?>
		 
          <li class="nav-item with-sub <?php echo $active_catalog; ?>">
            <a href="" class="nav-link"><i data-feather="tag"></i> <?php echo $__menucatalog; ?></a>
            <div class="navbar-menu-sub">
              <div class="d-lg-flex">
                <ul>
				<?php if(($products_catalog_page_ID !='' && checkrolemenu($products_catalog_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="product.php" class="nav-sub-link"><i data-feather="tag"></i> <?php echo $__menuproducts; ?></a></li>
				<?php } ?>
				<?php 
				if(($category_catalog_page_ID !='' && checkrolemenu($category_catalog_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="category.php" class="nav-sub-link"><i data-feather="list"></i> <?php echo $__menucategory; ?></a></li>
				<?php } ?>
                </ul>
              </div>
            </div><!-- nav-sub -->
          </li>
		  
		 <?php } ?>
		 <?php 
		  $all_customer_page_ID = checkmenu('List Customer');
		  $subscriber_customer_page_ID = checkmenu('List Subscriber');
		  if(($all_customer_page_ID !='' && checkrolemenu($all_customer_page_ID,$logged_user_level)) || ($customergroups_customer_page_ID !='' && checkrolemenu($customergroups_customer_page_ID,$logged_user_level)) || ($subscriber_customer_page_ID !='' && checkrolemenu($subscriber_customer_page_ID,$logged_user_level))) { ?>
          <li class="nav-item with-sub <?php echo $active_customer; ?>">
            <a href="" class="nav-link"><i data-feather="users"></i> <?php echo $__menucustomer; ?></a>
            <div class="navbar-menu-sub">
              <div class="d-lg-flex">
                <ul>
				<?php if(($all_customer_page_ID !='' && checkrolemenu($all_customer_page_ID,$logged_user_level))) { ?> 
                  <li class="nav-sub-item"><a href="customer.php" class="nav-sub-link"><i data-feather="user"></i> <?php echo $__menuallcustomer; ?></a></li>
				<?php } ?>
				<?php if(($subscriber_customer_page_ID !='' && checkrolemenu($subscriber_customer_page_ID,$logged_user_level))) { ?>
				  <li class="nav-sub-item"><a href="subscriber.php" class="nav-sub-link"><i data-feather="users"></i><?php echo $__menusubscriber; ?></a></li>
				<?php } ?>
                </ul>
              </div>
            </div><!-- nav-sub -->
          </li>
		  <?php } ?>
		  
		  <?php 
		  $content_customer_page_ID = checkmenu('List Content');
		  $footer1_customer_page_ID = checkmenu('List Footer #1');
		  $footer2_customer_page_ID = checkmenu('List Footer #2');
		  $homeslider_customer_page_ID = checkmenu('List Home Slider');
		  $promobanner1_customer_page_ID = checkmenu('List Promo Banner #1');
		  $promobanner2_customer_page_ID = checkmenu('List Promo Banner #2');
		  $homeicon_customer_page_ID = checkmenu('List Promo Home Icon');
		  $menu_page_ID = checkmenu('List Menu');
		  if(($content_customer_page_ID !='' && checkrolemenu($content_customer_page_ID,$logged_user_level)) || ($footer1_customer_page_ID !='' && checkrolemenu($footer1_customer_page_ID,$logged_user_level)) || ($footer2_customer_page_ID !='' && checkrolemenu($footer2_customer_page_ID,$logged_user_level)) || ($homeslider_customer_page_ID !='' && checkrolemenu($homeslider_customer_page_ID,$logged_user_level)) || ($promobanner1_customer_page_ID !='' && checkrolemenu($promobanner1_customer_page_ID,$logged_user_level)) || ($promobanner2_customer_page_ID !='' && checkrolemenu($promobanner2_customer_page_ID,$logged_user_level)) || ($homeicon_customer_page_ID !='' && checkrolemenu($homeicon_customer_page_ID,$logged_user_level)) || ($menu_page_ID !='' && checkrolemenu($menu_page_ID,$logged_user_level))) { ?>
		  
          <li class="nav-item with-sub <?php echo $active_content; ?>">
            <a href="" class="nav-link"><i data-feather="bar-chart"></i> <?php echo $__menucontent; ?></a>
            <div class="navbar-menu-sub">
              <div class="d-lg-flex">
                <ul>
                  <li class="nav-label"><?php echo $__menu_h_page; ?></li>
				  <?php if(($content_customer_page_ID !='' && checkrolemenu($content_customer_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="content.php" class="nav-sub-link"><i data-feather="codepen"></i> <?php echo $__menu_page_content; ?></a></li>
				  <?php } ?>
                  <li class="nav-label mg-t-20"><?php echo $__menu_h_homefooter; ?></li>
				  <?php if(($footer1_customer_page_ID !='' && checkrolemenu($footer1_customer_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="footerone.php" class="nav-sub-link"><i data-feather="codepen"></i> <?php echo $__menucontent_homefooter1; ?></a></li>
				  <?php } ?>
				  <?php if(($footer2_customer_page_ID !='' && checkrolemenu($footer2_customer_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="footer.php" class="nav-sub-link"><i data-feather="codepen"></i> <?php echo $__menucontent_homefooter2; ?></a></li>
				  <?php } ?>
                </ul>
                <ul>
                  <li class="nav-label"><?php echo $__menu_h_home; ?></li>
				 <?php if(($homeslider_customer_page_ID !='' && checkrolemenu($homeslider_customer_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="homeslider.php" class="nav-sub-link"><i data-feather="codepen"></i> <?php echo $__menucontent_homeslider; ?></a></li>
				 <?php } ?>
				<?php if(($promobanner1_customer_page_ID !='' && checkrolemenu($promobanner1_customer_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="promobanner1.php" class="nav-sub-link"><i data-feather="codepen"></i> <?php echo $__menucontent_promobanner1; ?></a></li>
				<?php } ?>
				<?php if(($promobanner2_customer_page_ID !='' && checkrolemenu($promobanner2_customer_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="promobanner2.php" class="nav-sub-link"><i data-feather="codepen"></i> <?php echo $__menucontent_promobanner2; ?></a></li>
				<?php } ?>
				<?php if(($homeicon_customer_page_ID !='' && checkrolemenu($homeicon_customer_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="homeicon.php" class="nav-sub-link"><i data-feather="codepen"></i> <?php echo $__menucontent_homeiconbox; ?></a></li>
				<?php } if(($menu_page_ID !='' && checkrolemenu($menu_page_ID,$logged_user_level))) { ?>
					<li class="nav-sub-item"><a href="menu.php" class="nav-sub-link"><i data-feather="codepen"></i> <?php echo $__menumenu; ?></a></li>
				<?php } ?>
                </ul>
              </div>
            </div><!-- nav-sub -->
          </li>
		  
		  <?php } ?>
		  
		  <?php 
		  $productsincart_reports_page_ID = checkmenu('List Products In Cart');
		  $abandonedcarts_reports_page_ID = checkmenu('List Abandoned Cart');
		  $verifyaccount_reports_page_ID = checkmenu('List Verify Account');
		  $orders_reports_page_ID = checkmenu('List Order Report');
		  $invoicereport_reports_page_ID = checkmenu('List Invoice Report');
		  $delivered_reports_page_ID = checkmenu('List Order Delivered Report');
		  $refund_reports_page_ID = checkmenu('List Refund Report');
		  $couponwisediscountreport_reports_page_ID = checkmenu('List Coupon Wise Discount Report');
		  $newcustomers_reports_page_ID = checkmenu('List New Customer');
		  $inactivecustomers_reports_page_ID = checkmenu('List Inactive Customer Report');
		  $customersalesreport_reports_page_ID = checkmenu('List Customer Sales Report');
		  $orderlistreport_reports_page_ID = checkmenu('List Order List Report');
		  $bestsellers_reports_page_ID = checkmenu('List Best Seller');
		  $lowstockproducts_reports_page_ID = checkmenu('List Low Stock Products');
		  $orderedlist_reports_page_ID = checkmenu('List Ordered Report');
		   $couponwisediscount_reports_page_ID = checkmenu('List Coupon Wise Discount Report');
		   
		  if(($productsincart_reports_page_ID !='' && checkrolemenu($productsincart_reports_page_ID,$logged_user_level)) || ($abandonedcarts_reports_page_ID !='' && checkrolemenu($abandonedcarts_reports_page_ID,$logged_user_level)) || ($verifyaccount_reports_page_ID !='' && checkrolemenu($verifyaccount_reports_page_ID,$logged_user_level)) || ($orders_reports_page_ID !='' && checkrolemenu($orders_reports_page_ID,$logged_user_level)) || ($invoicereport_reports_page_ID !='' && checkrolemenu($invoicereport_reports_page_ID,$logged_user_level)) || ($delivered_reports_page_ID !='' && checkrolemenu($delivered_reports_page_ID,$logged_user_level)) || ($refund_reports_page_ID !='' && checkrolemenu($refund_reports_page_ID,$logged_user_level)) || ($couponwisediscountreport_reports_page_ID !='' && checkrolemenu($couponwisediscountreport_reports_page_ID,$logged_user_level)) || ($newcustomers_reports_page_ID !='' && checkrolemenu($newcustomers_reports_page_ID,$logged_user_level)) || ($inactivecustomers_reports_page_ID !='' && checkrolemenu($inactivecustomers_reports_page_ID,$logged_user_level)) || ($customersalesreport_reports_page_ID !='' && checkrolemenu($customersalesreport_reports_page_ID,$logged_user_level)) || ($orderlistreport_reports_page_ID !='' && checkrolemenu($orderlistreport_reports_page_ID,$logged_user_level)) || ($bestsellers_reports_page_ID !='' && checkrolemenu($bestsellers_reports_page_ID,$logged_user_level)) || ($lowstockproducts_reports_page_ID !='' && checkrolemenu($lowstockproducts_reports_page_ID,$logged_user_level)) || ($orderedlist_reports_page_ID !='' && checkrolemenu($orderedlist_reports_page_ID,$logged_user_level)) || ($couponwisediscount_reports_page_ID !='' && checkrolemenu($couponwisediscount_reports_page_ID,$logged_user_level))) { ?>
		  
           <li class="nav-item with-sub <?php echo $active_reports; ?>">
            <a href="" class="nav-link"><i data-feather="bar-chart"></i> <?php echo $__menureports; ?></a>
            <div class="navbar-menu-sub">
              <div class="d-lg-flex">
                <ul>
				<?php
				  if(($productsincart_reports_page_ID !='' && checkrolemenu($productsincart_reports_page_ID,$logged_user_level)) || ($abandonedcarts_reports_page_ID !='' && checkrolemenu($abandonedcarts_reports_page_ID,$logged_user_level)) || ($verifyaccount_reports_page_ID !='' && checkrolemenu($verifyaccount_reports_page_ID,$logged_user_level)) || ($refund_reports_page_ID !='' && checkrolemenu($refund_reports_page_ID,$logged_user_level))) { ?>
                  <li class="nav-label"><?php echo $__menu_h_marketing; ?></li>
				<?php
				  if(($productsincart_reports_page_ID !='' && checkrolemenu($productsincart_reports_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="productsincart.php" class="nav-sub-link"><i data-feather="briefcase"></i> <?php echo $__menuproductsincart; ?></a></li>
				  <?php } ?>
				  <?php
				  if(($abandonedcarts_reports_page_ID !='' && checkrolemenu($abandonedcarts_reports_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="abandonedcarts.php" class="nav-sub-link"><i data-feather="briefcase"></i> <?php echo $__menuabandonedcarts; ?></a></li>
				  <?php } ?>
				  <?php
				  if(($verifyaccount_reports_page_ID !='' && checkrolemenu($verifyaccount_reports_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="verifyaccount.php" class="nav-sub-link"><i data-feather="briefcase"></i> <?php echo $__menuverifyaccount; ?></a></li>
				  <?php } ?>
                 <!-- <li class="nav-sub-item"><a href="#" class="nav-sub-link"><i data-feather="briefcase"></i> <?php echo $__menuforgotpassword; ?></a></li>-->
				  <?php } ?>
				  
				  <?php
				  if(($orders_reports_page_ID !='' && checkrolemenu($orders_reports_page_ID,$logged_user_level)) || ($invoicereport_reports_page_ID !='' && checkrolemenu($invoicereport_reports_page_ID,$logged_user_level)) || ($delivered_reports_page_ID !='' && checkrolemenu($delivered_reports_page_ID,$logged_user_level)) || ($refund_reports_page_ID !='' && checkrolemenu($refund_reports_page_ID,$logged_user_level))) { ?>
                  <li class="nav-label mg-t-20"><?php echo $__menu_h_sales; ?></li>
				  <?php
				  if(($orders_reports_page_ID !='' && checkrolemenu($orders_reports_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="order.php" class="nav-sub-link"><i data-feather="file-text"></i> <?php echo $__menuorders; ?></a></li>
				  <?php } ?>
				  <?php
				  if(($invoicereport_reports_page_ID !='' && checkrolemenu($invoicereport_reports_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="invoicereport.php" class="nav-sub-link"><i data-feather="file-text"></i> <?php echo $__menuinvoiced; ?></a></li>
				  <?php } ?>
				  <?php
				  if(($delivered_reports_page_ID !='' && checkrolemenu($delivered_reports_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="orderdeliveredreport.php" class="nav-sub-link"><i data-feather="file-text"></i> <?php echo $__menushipping; ?></a></li>
				  <?php } ?>
				  <?php
				  if(($refund_reports_page_ID !='' && checkrolemenu($refund_reports_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="orderrefundreport.php" class="nav-sub-link"><i data-feather="file-text"></i> <?php echo $__menurefunds; ?></a></li>
				  <?php } ?>
                 <!-- <li class="nav-sub-item"><a href="#" class="nav-sub-link"><i data-feather="file-text"></i> <?php echo $__menucoupons; ?></a></li>-->
				  <?php
				  if(($couponwisediscount_reports_page_ID !='' && checkrolemenu($couponwisediscount_reports_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="<?php echo BASEPATH; ?>couponwisediscountreport.php" class="nav-sub-link"><i data-feather="file-text"></i> <?php echo 'Coupon Wise Discount Reports'; ?></a></li>
				  <?php } ?>
				  <?php } ?>
                </ul>
                <ul>
                  <li class="nav-label"><?php echo $__menu_h_customers; ?></li>
				 <?php
				  if(($newcustomers_reports_page_ID !='' && checkrolemenu($newcustomers_reports_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="<?php echo BASEPATH; ?>newcustomers.php" class="nav-sub-link"><i data-feather="user-check"></i> <?php echo $__menunewcustomer; ?></a></li>
				  <?php } ?>
				  <?php
				  if(($inactivecustomers_reports_page_ID !='' && checkrolemenu($inactivecustomers_reports_page_ID,$logged_user_level))) { ?>
				  <li class="nav-sub-item"><a href="<?php echo BASEPATH; ?>inactivecustomers.php" class="nav-sub-link"><i data-feather="user-check"></i> <?php echo $__menuinactivecustomer; ?></a></li>
				  <?php } ?>
				  <?php
				  if(($customersalesreport_reports_page_ID !='' && checkrolemenu($customersalesreport_reports_page_ID,$logged_user_level))) { ?>
				   <li class="nav-sub-item"><a href="<?php echo BASEPATH; ?>customersalesreport.php" class="nav-sub-link"><i data-feather="user-check"></i> <?php echo $__menucustomersalesreport; ?></a></li>
				   <?php } ?>
				   <?php
				  if(($orderlistreport_reports_page_ID !='' && checkrolemenu($orderlistreport_reports_page_ID,$logged_user_level))) { ?>
				   <li class="nav-sub-item"><a href="<?php echo BASEPATH; ?>orderlist.php" class="nav-sub-link"><i data-feather="user-check"></i> <?php echo $__menuorderslist; ?></a></li>
				   <?php } ?>
                  <li class="nav-label mg-t-20"><?php echo $__menu_h_products; ?></li>
				  <?php
				  if(($bestsellers_reports_page_ID !='' && checkrolemenu($bestsellers_reports_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="<?php echo BASEPATH; ?>bestsellers.php" class="nav-sub-link"><i data-feather="box"></i> <?php echo $__menubestsellers; ?></a></li>
				  <?php } ?>
				  <?php
				  if(($lowstockproducts_reports_page_ID !='' && checkrolemenu($lowstockproducts_reports_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="<?php echo BASEPATH; ?>lowstockproductlist.php" class="nav-sub-link"><i data-feather="box"></i> <?php echo $__menulowstock; ?></a></li>
				  <?php } ?>
				  <?php
				  if(($orderedlist_reports_page_ID !='' && checkrolemenu($orderedlist_reports_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="<?php echo BASEPATH; ?>ordered.php" class="nav-sub-link"><i data-feather="box"></i> <?php echo $__menuordered; ?></a></li>
				  <?php } ?>
                </ul>
              </div>
            </div><!-- nav-sub -->
          </li>
		  <?php } ?>
   		  
		  <?php
		 $general_settings_page_ID = checkmenu('Add General');
		 $frontpage_settings_page_ID = checkmenu('List Front Page');
		 $catalog_settings_page_ID  = checkmenu('List Catalog');
		 $security_settings_page_ID = checkmenu('List Security');
		 $customer_settings_page_ID = checkmenu('List Customer Config');
		 $sales_settings_page_ID = checkmenu('List Sales Config');
		 $socialmedia_settings_page_ID = checkmenu('List Social Media');
		 $smtp_settings_page_ID = checkmenu('List SMTP Settings');
		 $emailtemplate_settings_page_ID = checkmenu('List Email Template');
		 $generalcontact_settings_page_ID = checkmenu('List General contact');
		 $salesrepresentative_settings_page_ID = checkmenu('List Sales Representative');
		 $customersupport_settings_page_ID = checkmenu('Add Customer Support');
		 $pagemenu_settings_page_ID = checkmenu('List Page Menu');
		 $rolepermission_settings_page_ID = checkmenu('List Role Permission');
		 $staff_settings_page_ID = checkmenu('List Staff');
		 $promocode_page_ID = checkmenu('List Promo Code');
		  $offers_page_ID = checkmenu('List of Offers');
		 if(($general_settings_page_ID !='' && checkrolemenu($general_settings_page_ID,$logged_user_level)) || ($frontpage_settings_page_ID !='' && checkrolemenu($frontpage_settings_page_ID,$logged_user_level)) || ($catalog_settings_page_ID !='' && checkrolemenu($catalog_settings_page_ID,$logged_user_level)) || ($security_settings_page_ID !='' && checkrolemenu($security_settings_page_ID,$logged_user_level)) || ($customer_settings_page_ID !='' && checkrolemenu($customer_settings_page_ID,$logged_user_level)) || ($sales_settings_page_ID !='' && checkrolemenu($sales_settings_page_ID,$logged_user_level)) || ($smtp_settings_page_ID !='' && checkrolemenu($smtp_settings_page_ID,$logged_user_level)) || ($emailtemplate_settings_page_ID !='' && checkrolemenu($emailtemplate_settings_page_ID,$logged_user_level)) || ($generalcontact_settings_page_ID !='' && checkrolemenu($generalcontact_settings_page_ID,$logged_user_level)) || ($socialmedia_settings_page_ID !='' && checkrolemenu($socialmedia_settings_page_ID,$logged_user_level)) || ($customersupport_settings_page_ID !='' && checkrolemenu($customersupport_settings_page_ID,$logged_user_level)) || ($pagemenu_settings_page_ID !='' && checkrolemenu($pagemenu_settings_page_ID,$logged_user_level)) || ($rolepermission_settings_page_ID !='' && checkrolemenu($rolepermission_settings_page_ID,$logged_user_level)) || ($staff_settings_page_ID !='' && checkrolemenu($staff_settings_page_ID,$logged_user_level)) || ($promocode_page_ID !='' && checkrolemenu($promocode_page_ID,$logged_user_level)) || ($offers_page_ID !='' && checkrolemenu($offers_page_ID,$logged_user_level))) 
		 {
		 ?>
		  
          <li class="nav-item with-sub <?php echo $active_settings; ?>">
            <a href="" class="nav-link"><i data-feather="settings"></i> <?php echo $__menusettings; ?></a>
            <div class="navbar-menu-sub">
              <div class="d-lg-flex">
                 <ul>
                  <li class="nav-label"><?php echo $__menu_h_configuration; ?></li>
				  <?php if(($general_settings_page_ID !='' && checkrolemenu($general_settings_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="configurationgeneral.php" class="nav-sub-link"><i data-feather="settings"></i> <?php echo $__menugeneral; ?></a></li>
					<?php } if(($frontpage_settings_page_ID !='' && checkrolemenu($frontpage_settings_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="configurationfrontpage.php" class="nav-sub-link"><i data-feather="settings"></i> Front Page</a></li>
				  <?php } if(($catalog_settings_page_ID !='' && checkrolemenu($catalog_settings_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="configurationcatalog.php" class="nav-sub-link"><i data-feather="book"></i> <?php echo $__menucatalog; ?></a></li>
				  <?php } if(($security_settings_page_ID !='' && checkrolemenu($security_settings_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="configurationsecurity.php" class="nav-sub-link"><i data-feather="shield"></i> <?php echo $__menusecurity; ?></a></li>
				  <?php } if(($customer_settings_page_ID !='' && checkrolemenu($customer_settings_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="configurationcustomer.php" class="nav-sub-link"><i data-feather="user"></i> <?php echo $__menucustomer; ?></a></li>
				  <?php } if(($sales_settings_page_ID !='' && checkrolemenu($sales_settings_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="configurationsales.php" class="nav-sub-link"><i data-feather="target"></i> <?php echo $__menusales; ?></a></li>
				  <?php } if(($socialmedia_settings_page_ID !='' && checkrolemenu($socialmedia_settings_page_ID,$logged_user_level))) { ?>
				  <li class="nav-sub-item"><a href="socialmedia.php" class="nav-sub-link"><i data-feather="users"></i> Social Media</a></li>
				  <?php } ?>
				  <?php if(($promocode_page_ID !='' && checkrolemenu($promocode_page_ID,$logged_user_level)) || ($offers_page_ID !='' && checkrolemenu($offers_page_ID,$logged_user_level))){ ?>
				   <li class="nav-label mg-t-10">Promotion</li>
				   				<?php if(($promocode_page_ID !='' && checkrolemenu($promocode_page_ID,$logged_user_level))) { ?>
				  <li class="nav-sub-item"><a href="promocode.php" class="nav-sub-link"><i data-feather="codepen"></i> <?php echo $__menupromocode; ?></a></li>
				<?php } ?>
				<?php if(($offers_page_ID !='' && checkrolemenu($offers_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="offers.php" class="nav-sub-link"><i data-feather="codepen"></i> <?php echo $__menuoffers; ?></a></li>
				<?php } ?>
				<?php } ?>

				</ul>
                 <ul>
                  <li class="nav-label"><?php echo $__menu_h_emailconfiguration; ?></li>
				  <?php if(($smtp_settings_page_ID !='' && checkrolemenu($smtp_settings_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="smtpconfig.php" class="nav-sub-link"><i data-feather="send"></i> <?php echo $__menuSMTPsettings; ?></a></li>
				  <?php } if(($emailtemplate_settings_page_ID !='' && checkrolemenu($emailtemplate_settings_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="emailtemplate.php" class="nav-sub-link"><i data-feather="mail"></i> <?php echo $__menuemailtemplate; ?></a></li>
				  <?php } if(($generalcontact_settings_page_ID !='' && checkrolemenu($generalcontact_settings_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="configurationgeneralcontact.php" class="nav-sub-link"><i data-feather="phone"></i> <?php echo $__menugeneralcontact; ?></a></li>
				   <?php } if(($customersupport_settings_page_ID !='' && checkrolemenu($customersupport_settings_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="configurationcustomersupport.php" class="nav-sub-link"><i data-feather="help-circle"></i> <?php echo $__menucustomersupport; ?></a></li>
					<?php } if(($pagemenu_settings_page_ID !='' && checkrolemenu($pagemenu_settings_page_ID,$logged_user_level))) { ?>
				  <li class="nav-label mg-t-10">Role Settings</li>
                  <li class="nav-sub-item"><a href="pagemenu.php" class="nav-sub-link"><i data-feather="users"></i> Page Menu</a></li>
					<?php } if(($rolepermission_settings_page_ID !='' && checkrolemenu($rolepermission_settings_page_ID,$logged_user_level))) { ?>
                  <li class="nav-sub-item"><a href="rolepermission.php" class="nav-sub-link"><i data-feather="help-circle"></i> Role Permission </a></li>
					<?php } if(($staff_settings_page_ID !='' && checkrolemenu($staff_settings_page_ID,$logged_user_level))) { ?>
				  <li class="nav-sub-item"><a href="staff.php" class="nav-sub-link"><i data-feather="users"></i> 
				  Staff </a></li>
					<?php } ?>
                
				
				</ul>
             </div>
            </div><!-- nav-sub -->
          </li>
		  
		 <?php } ?>
		 
        </ul>
      </div><!-- navbar-menu-wrapper -->
      <div class="navbar-right">
        <div class="dropdown dropdown-profile">
          <a href="" class="dropdown-link" data-toggle="dropdown" data-display="static">
            <div class="avatar avatar-sm" id="profileImage1"></div>
          </a><!-- dropdown-link -->
          <div class="dropdown-menu dropdown-menu-right tx-13">
            <div class="avatar avatar-lg mg-b-15" id="profileImage"></div>
			<?php $list_datas = sqlQUERY_LABEL("SELECT * FROM `js_users` where userID='$logged_user_id'") or die("Unable to get records:".mysqli_error());   
                  $check_record_availabity = sqlNUMOFROW_LABEL($list_datas);      
                  while($row = sqlFETCHARRAY_LABEL($list_datas)){
                    $username = $row["username"];
                    $useremail = $row["useremail"];
                    $roleID = $row["roleID"];
                  } ?>
            <h6 class="tx-semibold mg-b-5" id="username"><?php echo $useremail; ?></h6>
			<?php if($roleID == '3'){ ?>
            <p class="mg-b-25 tx-12 tx-color-03">Administrator</p>
			<?php } else { ?>
			<p class="mg-b-25 tx-12 tx-color-03">Staff</p>
			<?php } ?>
            <a href="changepassword.php" class="dropdown-item"><i data-feather="edit-3"></i> Change Password</a>
           <!-- <a href="page-profile-view.html" class="dropdown-item"><i data-feather="user"></i> View Profile</a>
            <div class="dropdown-divider"></div>
            <!--<a href="page-help-center.html" class="dropdown-item"><i data-feather="help-circle"></i> Help Center</a>
            <a href="" class="dropdown-item"><i data-feather="life-buoy"></i> Forum</a>
            <a href="" class="dropdown-item"><i data-feather="settings"></i>Account Settings</a>
            <a href="" class="dropdown-item"><i data-feather="settings"></i>Privacy Settings</a>-->
            <a href="logout.php" class="dropdown-item"><i data-feather="log-out"></i>Sign Out</a>
          </div><!-- dropdown-menu -->
        </div><!-- dropdown -->
      </div><!-- navbar-right -->
      <div class="navbar-search">
        <div class="navbar-search-header">
          <input type="search" class="form-control" placeholder="Type and hit enter to search...">
          <button class="btn"><i data-feather="search"></i></button>
          <a id="navbarSearchClose" href="" class="link-03 mg-l-5 mg-lg-l-10"><i data-feather="x"></i></a>
        </div><!-- navbar-search-header -->
        <div class="navbar-search-body">
          <label class="tx-10 tx-medium tx-uppercase tx-spacing-1 tx-color-03 mg-b-10 d-flex align-items-center">Recent Searches</label>
          <ul class="list-unstyled">
            <li><a href="dashboard-one.html">modern dashboard</a></li>
            <li><a href="app-calendar.html">calendar app</a></li>
            <li><a href="collections/modal.html">modal examples</a></li>
            <li><a href="components/el-avatar.html">avatar</a></li>
          </ul>

          <hr class="mg-y-30 bd-0">

          <label class="tx-10 tx-medium tx-uppercase tx-spacing-1 tx-color-03 mg-b-10 d-flex align-items-center">Search Suggestions</label>

          <ul class="list-unstyled">
            <li><a href="dashboard-one.html">cryptocurrency</a></li>
            <li><a href="app-calendar.html">button groups</a></li>
            <li><a href="collections/modal.html">form elements</a></li>
            <li><a href="components/el-avatar.html">contact app</a></li>
          </ul>
        </div><!-- navbar-search-body -->
      </div><!-- navbar-search -->
    </header><!-- navbar -->

