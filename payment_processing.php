<?php 
extract($_REQUEST);
include 'head/jackus.php'; 
include 'shopfunction.php'; 
include '___class__home.inc'; 

$__main_orderID = base64_decode($order_key);
$__main_orderSESSION = $token;
$__main_orderstatus = $order_status;
$__main_pmode = base64_decode($pmode);

/***********************************/
  //get order basic informations//
/**********************************/
//filter by session
if($__main_orderSESSION != '') {
	$getsessionFILTER = " and `od_sesid`= '$__main_orderSESSION'";
}
  // echo "select * FROM `js_shop_order` where `od_id`='$__main_orderID' {$getsessionFILTER}"; exit();
  
$__main_order_details_query = sqlQUERY_LABEL("select * FROM `js_shop_order` where `od_id`='$__main_orderID' {$getsessionFILTER}") or die(sqlERROR_LABEL());
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
									<?php 
									if($__main_pmode == 'cod') { 
									
									?>
										<h4 class="thankyou-order-received">Please wait while we process your order.</h4>
										<p>Dont click Back button or Refresh the page.</p>
									<?php 	
										
										$ord_id = orderREFNOGENERATOR($__main_orderID);
										
										$shoporder_update =sqlQUERY_LABEL("UPDATE  js_shop_order SET  `od_payment_mode` = 'cod', `od_payment_status`='3', `od_refno`='$ord_id', `od_status`='1' WHERE od_id='$__main_orderID' and `od_sesid`= '$__main_orderSESSION'") or die(sqlERROR_LABEL());
										
										//reduce stock from warehouse
										 
										 require_once('template/__orderemailtemplate.php');	
										 if($_checkout_payment_email ==''){
											 $_checkout_payment_email = getSINGLEDBVALUE('useremail',"userID='$logged_user_id' ",'js_users','label');

										 }
										
											$subject = "Your Order - ".$ord_id." Details  ";
											$to = $_checkout_payment_email;// $project_email;//
											$cc = $cc_mail;//info@touchmarkdes.com
											$Bcc = $bcc_mail; //info@touchmarkdes.com
											$from = "Rare Fashion  <".$from_mail.">";
											  $mailtemplate =  stripslashes($message); 
												   //  echo $from,$to,$cc,$Bcc,$subject,$mailtemplate; 
												   if(send_mail($from,$to,$cc,$Bcc,$subject,$mailtemplate)) {
											   }
											 $subject2 = "New Order";
											$to2 = $cc_mail;// $project_email;//
											$cc2 = ' ';//info@touchmarkdes.com
											$Bcc2 = ''; //info@touchmarkdes.com
											$from2 = "Rare Fashion  <".$from_mail.">";
											  $mailtemplate2 =  stripslashes($message); 
												   // echo $from2,$to2,$cc2,$Bcc2,$subject2,$mailtemplate;exit();
												   if(send_mail($from2,$to2,$cc2,$Bcc2,$subject2,$mailtemplate)) {
											   }
											  
											   $check_master_stock1 = sqlQUERY_LABEL("SELECT `pd_id`,`variant_id`,`od_qty` FROM js_shop_order_item WHERE `od_id` = $__main_orderID AND `deleted` = '0'") or die(sqlERROR_LABEL());
			
													while($collect_selecteditem = sqlFETCHARRAY_LABEL($check_master_stock1)) {
													 
													 $pd_id      = $collect_selecteditem['pd_id'];
													 $variant_id = $collect_selecteditem['variant_id'];                       		
													 $od_qty     = $collect_selecteditem['od_qty'];
												
													if($variant_id == '0'){
											
											$check_master_stock = sqlQUERY_LABEL("select `productsku`,`productopeningstock`, `productavailablestock` from js_product where productID='$pd_id'") or die(sqlERROR_LABEL());

											while($collect_master_stock = sqlFETCHARRAY_LABEL($check_master_stock)) {
												$productopeningstock = $collect_master_stock['productopeningstock'];
												$productavailablestock = $collect_master_stock['productavailablestock'];
												$productsku = $collect_master_stock['productsku'];
											}
											
											if($productavailablestock >= $od_qty){

												$new_estore_qty = $productavailablestock - $od_qty;
												
											}
											
                        					// $today = date('d/m/Y');
                        					// $ord_ref_no = getORDERREF_USING_ODID($orderID);
											
                            				// $log_description = "$od_qty Qty return for order #$ord_ref_no.  Opening Stock: $productavailablestock / Available Stock: $new_estore_qty Qty on $today";
                            				
                            				// $arrFields_log = array('`od_id`', '`prdt_id`', '`variant_id`', '`od_qty`', '`estore_code`', '`log_description`', '`createdby`', '`status`');
                            				
                            				// $arrValues_log = array("$orderID", "$pd_id", "$variant_id", "$od_qty", "$productsku", "$log_description", "$logged_customer_id");
											
                            				// if(sqlACTIONS("INSERT","js_estore_stock_deduct_log",$arrFields_log,$arrValues_log, '')){
                            
                            				// }
									
											$arrFields = array('`productavailablestock`');
												$arrValues = array("$new_estore_qty");
												$sqlwhere ="productID ='$pd_id'";
												if(sqlACTIONS("UPDATE","js_product",$arrFields,$arrValues, $sqlwhere)){
												}
											
										}else{
											
											//variant table updated
											
											
											$check_master_stock = sqlQUERY_LABEL("select `variant_code`,`variant_opening_stock`,`variant_available_stock` from js_productvariants where variant_ID='$variant_id'") or die(sqlERROR_LABEL());

											while($collect_master_stock = sqlFETCHARRAY_LABEL($check_master_stock)) {
												$productopeningstock = $collect_master_stock['variant_opening_stock'];
												$productavailablestock = $collect_master_stock['variant_available_stock'];
												$productsku = $collect_master_stock['variant_code'];
											}
											
											if($productavailablestock >= $od_qty){

												$new_estore_qty = $productavailablestock - $od_qty;
												
											}
											
                        					// $today = date('d/m/Y');
                        					// $ord_ref_no = getORDERREF_USING_ODID($orderID);
											
                            				// $log_description = "$od_qty Qty return for order #$ord_ref_no.  Opening Stock: $productavailablestock / Available Stock: $new_estore_qty Qty on $today";
                            				
                            				// $arrFields_log = array('`od_id`', '`prdt_id`', '`variant_id`', '`od_qty`', '`estore_code`', '`log_description`', '`createdby`', '`status`');
                            				
                            				// $arrValues_log = array("$orderID", "$pd_id", "$variant_id", "$od_qty", "$productsku", "$log_description", "$logged_user_id");
											
                            				// if(sqlACTIONS("INSERT","js_estore_stock_deduct_log",$arrFields_log,$arrValues_log, '')){
                            
                            				// }
									
											$arrFields = array('`variant_available_stock`');
												$arrValues = array("$new_estore_qty");
												$sqlwhere ="variant_ID ='$variant_id'";
												if(sqlACTIONS("UPDATE","js_productvariants",$arrFields,$arrValues, $sqlwhere)){
												}
											
											
										}
                        
									}
											   
											  
										?>
										<script type="text/javascript">window.location = 'order_success.php?order_status=placed&regen=y&order_key=<?php echo ($order_key); ?>' </script>
										<?php

									} elseif($__main_pmode == 'razor') { 
										
										$ord_id = orderREFNOGENERATOR($__main_orderID);
										
										$shoporder_update =sqlQUERY_LABEL("UPDATE  js_shop_order SET  `od_payment_mode` = 'razorpay', `od_payment_status`='3', `od_refno`='$ord_id', `od_status`='1' WHERE od_id='$__main_orderID' and `od_sesid`= '$__main_orderSESSION'") or die(sqlERROR_LABEL());
				
										//strbefore  //strafter($myvar,',');  $billing_email|$billing_first_name|$hidden_order_amt
										$orginal_token = base64_decode($ptoken);
										$customeremail = strbefore($orginal_token, '|');
										$customername = strafter($orginal_token, '|');
										$orderamount = (base64_decode($pamount) * 100);
										
										require_once('template/__orderemailtemplate.php');	
										 if($_checkout_payment_email ==''){
											 $_checkout_payment_email = getSINGLEDBVALUE('useremail',"userID='$logged_user_id' ",'js_users','label');

										 }
											$subject = "Your Order - ".$ord_id." Details  ";
											$to = $_checkout_payment_email;// $project_email;//
											$cc = '';//info@touchmarkdes.com
											$Bcc = ''; //info@touchmarkdes.com
											$from = "Rare Fashion  <notification@touchmarkdes.space>";
											  $mailtemplate =  stripslashes($message); 
												  //  echo $from,$to,$cc,$Bcc,$subject,$mailtemplate; 
												   if(send_mail($from,$to,$cc,$Bcc,$subject,$mailtemplate)) {
											   }
											 $subject2 = "New Order";
											$to2 = 'info@touchmarkdes.com';// $project_email;//
											$cc2 = ' ';//info@touchmarkdes.com
											$Bcc2 = ''; //info@touchmarkdes.com
											$from2 = "Rare Fashion  <notification@touchmarkdes.space>";
											  $mailtemplate2 =  stripslashes($message); 
												  //  echo $from2,$to2,$cc2,$Bcc2,$subject2,$mailtemplate;exit();
												   if(send_mail($from2,$to2,$cc2,$Bcc2,$subject2,$mailtemplate)) {
											   }
											  
											 $check_master_stock1 = sqlQUERY_LABEL("SELECT `pd_id`,`variant_id`,`od_qty` FROM js_shop_order_item WHERE `od_id` = $__main_orderID AND `deleted` = '0'") or die(sqlERROR_LABEL());
			
													while($collect_selecteditem = sqlFETCHARRAY_LABEL($check_master_stock1)) {
													 
													 $pd_id      = $collect_selecteditem['pd_id'];
													 $variant_id = $collect_selecteditem['variant_id'];                       		
													 $od_qty     = $collect_selecteditem['od_qty'];
												
													if($variant_id == '0'){
											
											$check_master_stock = sqlQUERY_LABEL("select `productsku`,`productopeningstock`, `productavailablestock` from js_product where productID='$pd_id'") or die(sqlERROR_LABEL());

											while($collect_master_stock = sqlFETCHARRAY_LABEL($check_master_stock)) {
												$productopeningstock = $collect_master_stock['productopeningstock'];
												$productavailablestock = $collect_master_stock['productavailablestock'];
												$productsku = $collect_master_stock['productsku'];
											}
											
											if($productavailablestock >= $od_qty){

												$new_estore_qty = $productavailablestock - $od_qty;
												
											}
											
                        					// $today = date('d/m/Y');
                        					// $ord_ref_no = getORDERREF_USING_ODID($orderID);
											
                            				// $log_description = "$od_qty Qty return for order #$ord_ref_no.  Opening Stock: $productavailablestock / Available Stock: $new_estore_qty Qty on $today";
                            				
                            				// $arrFields_log = array('`od_id`', '`prdt_id`', '`variant_id`', '`od_qty`', '`estore_code`', '`log_description`', '`createdby`', '`status`');
                            				
                            				// $arrValues_log = array("$orderID", "$pd_id", "$variant_id", "$od_qty", "$productsku", "$log_description", "$logged_customer_id");
											
                            				// if(sqlACTIONS("INSERT","js_estore_stock_deduct_log",$arrFields_log,$arrValues_log, '')){
                            
                            				// }
									
											$arrFields = array('`productavailablestock`');
												$arrValues = array("$new_estore_qty");
												$sqlwhere ="productID ='$pd_id'";
												if(sqlACTIONS("UPDATE","js_product",$arrFields,$arrValues, $sqlwhere)){
												}
											
										}else{
											
											//variant table updated
											
											
											$check_master_stock = sqlQUERY_LABEL("select `variant_code`,`variant_opening_stock`,`variant_available_stock` from js_productvariants where variant_ID='$variant_id'") or die(sqlERROR_LABEL());

											while($collect_master_stock = sqlFETCHARRAY_LABEL($check_master_stock)) {
												$productopeningstock = $collect_master_stock['variant_opening_stock'];
												$productavailablestock = $collect_master_stock['variant_available_stock'];
												$productsku = $collect_master_stock['variant_code'];
											}
											
											if($productavailablestock >= $od_qty){

												$new_estore_qty = $productavailablestock - $od_qty;
												
											}
											
                        					// $today = date('d/m/Y');
                        					// $ord_ref_no = getORDERREF_USING_ODID($orderID);
											
                            				// $log_description = "$od_qty Qty return for order #$ord_ref_no.  Opening Stock: $productavailablestock / Available Stock: $new_estore_qty Qty on $today";
                            				
                            				// $arrFields_log = array('`od_id`', '`prdt_id`', '`variant_id`', '`od_qty`', '`estore_code`', '`log_description`', '`createdby`', '`status`');
                            				
                            				// $arrValues_log = array("$orderID", "$pd_id", "$variant_id", "$od_qty", "$productsku", "$log_description", "$logged_user_id");
											
                            				// if(sqlACTIONS("INSERT","js_estore_stock_deduct_log",$arrFields_log,$arrValues_log, '')){
                            
                            				// }
									
											$arrFields = array('`variant_available_stock`');
												$arrValues = array("$new_estore_qty");
												$sqlwhere ="variant_ID ='$variant_id'";
												if(sqlACTIONS("UPDATE","js_productvariants",$arrFields,$arrValues, $sqlwhere)){
												}
											
											
										}
                        
									}
										   
											   
										?>
										<h4 class="thankyou-order-received">Pay with razorpay.</h4>
										<p>Dont click Back button or Refresh the page.</p>
													
										<form action="paymentgateway_processing.php" method="POST">
											<!-- Note that the amount is in paise = 50 INR -->
											<script
												src="https://checkout.razorpay.com/v1/checkout.js"
												data-key="rzp_test_PpwhjVODvEQy0C"
												data-amount="<?php echo $orderamount; ?>"
												data-buttontext="Pay with Razorpay"
												data-name="rarefashions.com"
												data-description="Payment for Order <?php echo $ord_id; ?>"
												data-image="http://localhost/rare_new/assets/images/logo.png"
												data-prefill.name="<?php echo $customername; ?>"
												data-prefill.email="<?php echo $customeremail; ?>"
												data-theme.color="#80b82d"
											></script>
											<input type="hidden" value="<?php echo $ord_id; ?>" name="orderrefno">
											<input type="hidden" value="<?php echo $__main_orderID; ?>" name="order_key">
											<input type="hidden" value="<?php echo $__main_orderSESSION; ?>" name="token">
										</form>

									<?php } ?>
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