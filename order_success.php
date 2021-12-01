<?php
ob_start();
session_start();
extract($_REQUEST);
include 'head/jackus.php'; 
include 'shopfunction.php'; 
include '___class__home.inc'; 

$__main_orderID = base64_decode($order_key);
$__main_orderSESSION = $token;

if($_GET['regen'] == 'y') { session_regenerate_id(); $sales_session_id=session_id(); 
	echo '<script language="javascript">window.location.href="order_success.php?order_status=placed&order_key='.base64_encode($__main_orderID).'";</script>';	 
}

/***********************************/
  //get order basic informations//
/**********************************/
//filter by session
if($__main_orderSESSION != '') {
	$getsessionFILTER = " and `od_sesid`= '$__main_orderSESSION'";
}

$__main_order_details_query = sqlQUERY_LABEL("select `od_id`, `od_memo`, `od_sesid`, `od_shipping_address_opt`, `od_shipping_first_name`, `od_shipping_last_name`, `od_shipping_address1`, `od_shipping_address2`, `od_shipping_email`, `od_shipping_phone`, `od_shipping_city`, `od_shipping_state`, `od_shipping_postal_code`, `od_shipping_country`, `od_shipping_type`, `od_shipping_cost`, `od_payment_first_name`, `od_payment_last_name`, `od_payment_address1`, `od_payment_address2`, `od_payment_email`, `od_payment_phone`, `od_payment_city`, `od_payment_state`, `od_payment_postal_code`, `od_payment_country` FROM `js_shop_order` where `od_id`='$__main_orderID' and `od_userid`='$logged_user_id' {$getsessionFILTER}") or die(sqlERROR_LABEL());
$check_main_order_num_rows = sqlNUMOFROW_LABEL($__main_order_details_query);

if($check_main_order_num_rows > 0) {
	$__main_order_data = sqlFETCHASSOC_LABEL($__main_order_details_query);	
} else {
	$commontitle = "Sorry Something went wrong";
	$__order_problem = true;
}
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
	<!--<style>
	.center{
  display: flex;
  text-align: center;
  justify-content: center;
  align-items: center;
  margin-top: 20%;
}
.ring{
  position: absolute;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  width: 80px;
  height: 80px;
  border-radius: 660px;
  animation: ring 3s linear infinite;
}
@keyframes ring {
  0%{
    transform: translate(0deg);
    box-shadow: 1px 5px 2px #fff;
  }
  50%{
    transform: rotate(180deg);
    box-shadow: 1px 5px 2px #fff;
  }
  100%{
    transform: rotate(360deg);
    box-shadow: 1px 5px 2px #fff;
  }
}
.ring:before{
  position: absolute;
  content: '';
  left: 0;
  top: 0;
  height: 100%;
  width: 100%;
  border-radius: 50%;
  box-shadow: 0 0 5px rgba(255,255,255,.3);
}
</style>-->
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
		<div class="fullwidth-template">
<?php 
	
	//list of module view templates
	$loadbodyFUNCTIONS = array(
	'__order_success'
	);	
	echo $homepage_propertyclass->loadPAGE($loadbodyFUNCTIONS); 

?>
</div>

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