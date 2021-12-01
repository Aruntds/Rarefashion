<?php
ob_start();
session_start();
extract($_REQUEST);	
include 'head/jackus.php'; 
include '___class__home.inc';

$__main_orderID = ($order_key);
$__main_orderSESSION = $token;
$__main_orderstatus = $order_status;
$__main_pmode = base64_decode($pmode);
?>	
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="description" content="<?php echo $productmetadescrption; ?>"/>
    <meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1"/>
    <link rel="canonical" href="<?php echo curPageURL(); ?>" />
    <meta property="og:locale" content="en_GB" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="<?php echo $productmetatitle; ?>" />
    <meta property="og:description" content="<?php echo $productmetadescrption; ?>" />
    <meta property="og:url" content="<?php echo curPageURL(); ?>" />
    <meta property="og:site_name" content="HTML Online" />
    <meta property="og:updated_time" content="<?php echo time_stamp($updatedon); ?>" />
    <meta property="og:image" content="<?php echo SITEHOME; ?>head/uploads/productmediagallery/<?php echo $productmediagalleryurl; ?>" />
    <meta property="og:image:secure_url" content="<?php echo SITEHOME; ?>head/uploads/productmediagallery/<?php echo $productmediagalleryurl; ?>" />
    <meta property="og:image:width" content="542" />
    <meta property="og:image:height" content="241" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:description" content="<?php echo $productmetadescrption; ?>" />
    <meta name="twitter:title" content="<?php echo $productmetatitle; ?>" />
    <meta name="twitter:image" content="<?php echo SITEHOME; ?>head/uploads/productmediagallery/<?php echo $productmediagalleryurl; ?>" />
	<?php include '__styles.php'; ?>
</head>

<body>
    <!--[if lte IE 9]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
    <![endif]-->
	<div class="page-wrapper">
    <?php 
		
		//list of module view templates
		$loadFUNCTIONS = array(
		'__header'
		);
		
		echo $homepage_propertyclass->loadPAGE($loadFUNCTIONS); 
	
	?> 

        <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
                <div class="container d-flex align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="shop.php">Payment Process</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $commontitle; ?></li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
                <div class="container">
                 
				 <div class="row">
            <div class="main-content col-md-12">
                <div class="page-main-content">
                    <div class="kreen jackus text-center">
							<h4 class="thankyou-order-received">Please wait while we process your order.</h4>
							<p>Dont click Back button or Refresh the page.</p>
						<?php 						
													
							if($razorPAYID != '') {
								
								$shoporder_update =sqlQUERY_LABEL("UPDATE  js_shop_order SET  `od_payment_mode` = 'razorpay', `od_payment_status`='1', `od_razorpay_payment_id`='$razorPAYID', `od_status`='1' WHERE od_id='$__main_orderID'") or die(sqlERROR_LABEL());
								
								//reduce stock from warehouse
								
								require_once('__orderemailtemplate.php');	
								
								$mailheaders = "MIME-Version: 1.0\r\n";
								$mailheaders .= "Content-type: text/html; charset=iso-8859-1\r\n";
								$mailheaders .= "From: \"New Order for Velaan Mandi\" <notification@velaanmandi.com>\r\n";
								
								$mailheaders1 = "MIME-Version: 1.0\r\n";
								$mailheaders1 .= "Content-type: text/html; charset=iso-8859-1\r\n";
								$mailheaders1 .= "From: \"Order Detail - Velaan Mandi\" <notification@velaanmandi.com>\r\n";
								//echo stripslashes($message);
								//echo stripslashes($confirmation_email_admin);
								mail($_checkout_payment_email, "Your Order - ".$ord_id." Details - $site_title" ,stripslashes($message), $mailheaders1);
								//information to admin
								mail('info@touchmarkdes.com', "New Order" ,stripslashes($confirmation_email_admin), $mailheaders);
								
								?>
								<script type="text/javascript">window.location = 'order_success.php?order_status=placed&order_key=<?php echo base64_encode($__main_orderID); ?>&regen=y' </script>
								<?php								

							} else {
								
								$shoporder_update =sqlQUERY_LABEL("UPDATE  js_shop_order SET  `od_payment_mode` = 'razorpay', `od_payment_status`='2', `od_razorpay_payment_id`='$razorPAYID', `od_status`='1' WHERE od_id='$__main_orderID'") or die(sqlERROR_LABEL());
								
								?>
								<script type="text/javascript">window.location = 'order_success.php?order_status=placed&order_key=<?php echo base64_encode($__main_orderID); ?>&regen=y' </script>
								<?php
								
							}
						?>
					</div>
                </div>
            </div>
        </div>
				 
				</div><!-- End .container -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->

    <?php

		//list of module view templates
		$loadFUNCTIONS = array(
		'__footer',
		'__scripts'
		);
		
		echo $homepage_propertyclass->loadPAGE($loadFUNCTIONS); 
	
	?>
</div><!-- End .page-wrapper -->

</body>

</html>