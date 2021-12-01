<?php
include '../head/jackus.php';
require_once("../dbcontroller.php");
require_once("../pagination.class_orderlist.php");
extract($_REQUEST);

$db_handle = new DBController();
	$perPage = new PerPage();
	
	if($filterby){
		$filterby_nocomma = $filterby;	
		// print_r($filterby_nocomma);exit();
		$filterby_comma = implode("','", $filterby_nocomma ) ;
		if($filterby_comma == '1'){
			$filterby =" and DATEDIFF(CURRENT_DATE(),od_date) < 30";
		} else if($filterby_comma == '2'){
			$filterby =" and DATEDIFF(CURRENT_DATE(),od_date) < 90";
		} else if($filterby_comma == '3'){
			$filterby =" and YEAR(od_date) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 1 YEAR))";
		}
	}	
	
	if($filterby_period){
		$period_date_start = dateformat_database($filterby_period[0]);
		$period_date_end = dateformat_database($filterby_period[1]);
		if($period_date_start != '--' && $period_date_end != '--'){
			$filterby =" and od_date between '$period_date_start' and '$period_date_end'";
		}
	}	
	
	if($filterby_year){
		$particular_year_filter = $filterby_year[0];
		if($particular_year_filter!=''){
			$filterby =" and YEAR(od_date)= $particular_year_filter";
		}
	}
	$output .='<div class="">';
	if($logged_user_id == '' || $logged_user_id == '0'){
		
		$sql= "SELECT * FROM `js_shop_order` where od_sesid ='$sid'   and od_refno != 'NULL' {$filterby} ";
	} else if($logged_user_id) {
		//echo"SELECT * FROM `js_shop_order` where od_userid ='$logged_user_id'  and od_status !='7' and od_refno != 'NULL' {$filterby} ";exit();
		$sql= "SELECT * FROM `js_shop_order` where od_userid ='$logged_user_id'  and od_refno != 'NULL' {$filterby} ";	
	} 
	// echo $sql;
		$paginationlink = "ajax/order_list_pagination.php?page=";
		$pagination_setting = $_GET["pagination_setting"];
		$page = 1;
		if(!empty($_GET["page"])) {
			$page = $_GET["page"];
		}
// echo $page;
		$start = ($page-1)*$perPage->perpage;

		if($start < 0) $start = 0;

		$query =  $sql . "ORDER BY od_id DESC limit " . $start . "," . $perPage->perpage ; 
		// echo $query;
		$faq = $db_handle->runQuery($query);
		
		if($_GET["rowcount"]=='') {
			$_GET["rowcount"] = $db_handle->numRows($sql);
		}
		
		$perpageresult = $perPage->getAllPageLinks($_GET["rowcount"], $paginationlink, $pagination_setting);	

		// echo 'A'; exit();
		$output = '';
// echo $perPage->perpage;
		if($perPage->perpage < $_GET["rowcount"]){
			$page_per_filter = $perPage->perpage;
		} else {
			$page_per_filter = $_GET["rowcount"];
		}
		$output .='
						<div class="toolbox">
							<div class="toolbox-info toolbox-left"> 
								Showing <span class="total_products">&nbsp;'.$page_per_filter.' of '.$_GET["rowcount"].'&nbsp;</span> Products
							</div>
						</div>
						
						';
// echo $faq; 
foreach($faq as $k=>$v) {
		$od_id = $faq[$k]['od_id'];
		$od_refno = $faq[$k]['od_refno'];
		$created_orderDATE = strtotime($faq[$k]['od_date']);
		$od_date = date('M d, Y', $created_orderDATE);							
		$od_shipping_first_name = $faq[$k]['od_shipping_first_name'];							
		$od_shipping_last_name = $faq[$k]['od_shipping_last_name'];							
		$od_shipping_city = $faq[$k]['od_shipping_city'];							
		$od_status = $faq[$k]['od_status'];							
		$od_total = round($faq[$k]['od_total']);
		$od_total1=ODAMOUNTREDUES($od_id);		
		$sum_total =$od_total-$od_total1;
		
		$status = getorder_paymentSTATUS(2,'',$od_status,'label');
		if($status =='New'){
		$od_status	="<span style='color: orange'>New </span>";
		}elseif($status =='Approved'){
		$od_status	="<span style='color: gray'>Approved</span>";
		}elseif($status =='In-Progress'){
		$od_status	="<span style='color: blue'>In-Progress</span>";
		}elseif($status =='Delivery Assigned'){
		$od_status	="<span style='color: yellow'>Delivery Assigned</span>";
		}elseif($status == 'Delivery In-Progress'){
		$od_status	="<span style='color: Orange'>Delivery In-Progress</span>";
		}elseif($status == 'Delivered'){
		$od_status	="<span style='color: green'>Delivered</span>";
		}elseif($status == 'Cancelled'){
		$od_status	="<span style='color: Red'>Cancelled</span>";
		}elseif($status == 'Refunded'){
		$od_status	="<span style='color: Black'>Refunded</span>";
		} else {
		$od_status	="<span style='color: Black'>".EMPTYFIELD."</span>";	
		}
		if($od_refno == ''){
			$od_refno = EMPTYFIELD;
			$od_date = EMPTYFIELD;
			$od_shipping_first_name = EMPTYFIELD;
			$od_shipping_city = EMPTYFIELD;
			//$od_total = EMPTYFIELD;
		}
		
	$output .= '<div class="card_details ml-auto mr-auto mb-1" style="text-align: center;border-radius: 2px; border: #9f989861 1px solid;">											
				<div class="header_details" style="padding: 9px; background-color: #E3E4E875;color: #333;">
					<div class="row" style="font-size: 1.3rem; text-align: left;">
						<div class="col-md-2">
							<h6 class="mb-0" style="font-size: 1.5rem;">ORDER PLACED</h6>
							'.$od_date .'
						</div>
						<div class="col-md-2">
							<h6 class="mb-0" style="font-size: 1.5rem;">TOTAL</h6>
							<small  style="font-family: `Jost`, sans-serif; font-size : 100% !important; color: #3333339c;">'. general_currency_symbol.'</small> '.$sum_total.'
						</div>
						<div class="col-md-2">
							<h6 class="mb-0" style="font-size: 1.5rem;">SHIP TO</h6>
							'.$od_shipping_first_name.' '.$od_shipping_last_name.'
						</div>
						<div class="col-md-2">
							<h6 class="mb-0" style="font-size: 1.5rem;">STATUS</h6>
							'.$od_status.'
						</div>
						<div class="order_ref_no col-md-4 text-right">
							<h6 class="mb-0" style="font-size: 1.5rem;">ORDER NUMBER #'.$od_refno.'</h6>
							<a href="myorders.php?mode=preview&odid='.$od_id.'"><p class="text-primary">View Order Details</p></a>
						</div>
					</div>
				</div>';
										
	$output .= '<div class="container_details" style="background-color: #fff; color: #c66; padding: 10px 20px 10px;">';
										$featured_product_data = sqlQUERY_LABEL("SELECT SHOP_ITEM.`cart_id`, SHOP_ITEM.`od_id`, SHOP_ITEM.`pd_id`, SHOP_ITEM.`variant_id`, SHOP_ITEM.`od_qty`, SHOP_ITEM.`od_price`, SHOP_ITEM.`item_tax_type`, SHOP_ITEM.`item_tax`, SHOP_ITEM.`item_tax1`, SHOP_ITEM.`item_tax2`, PRDT.`producttitle`, PRDT.`productsku`, SHOP_ITEM.`od_status_item` FROM `js_shop_order_item` AS SHOP_ITEM, `js_product` AS PRDT where SHOP_ITEM.`pd_id` = PRDT.`productID` and SHOP_ITEM.`od_id` = '$od_id' and SHOP_ITEM.deleted = '0'") or die("#1-Unable to get records:".mysqli_error());
										$check_product_data_num_rows = sqlNUMOFROW_LABEL($featured_product_data);
										
										if($check_product_data_num_rows > 0 ) {
										while($featured_data = sqlFETCHARRAY_LABEL($featured_product_data)){
											  $cart_id = $featured_data["cart_id"];
											  $od_id = $featured_data["od_id"];
											  $pd_id = $featured_data["pd_id"];
											  $producttitle = $featured_data["producttitle"];
											  $producttitle = str_replace("\'","'",$producttitle); //$row["producttitle"];
											  $productsku = $featured_data["productsku"];
											  $variant_id = $featured_data["variant_id"];
											  $od_qty = $featured_data["od_qty"];
											  $od_price = $featured_data["od_price"];
											  $item_tax_type = $featured_data["item_tax_type"];
											  $item_tax = $featured_data["item_tax"];
											  $item_tax1 = $featured_data["item_tax1"];
											  $item_tax2 = $featured_data["item_tax2"];
											  $od_status_item = $featured_data["od_status_item"];
											  $item_taxonly = ($item_tax1 + $item_tax2);
											  $item_total = $od_price + $item_tax1 + $item_tax2;
											  $productmedia_datas = sqlQUERY_LABEL("SELECT productmediagalleryID, productmediagalleryurl, productmediagallerytype FROM `js_productmediagallery` where productID='$pd_id' and deleted = '0' order by productmediagalleryurl ASC") or die("#2-Unable to get records:".mysqli_error());			
												$count_productmedia_availablecount = sqlNUMOFROW_LABEL($productmedia_datas);	
												while($row = sqlFETCHARRAY_LABEL($productmedia_datas)){
												  $productmediagalleryID = $row["productmediagalleryID"];
												  $productmediagalleryurl = $row["productmediagalleryurl"];
												  $productmediagallerytype = $row["productmediagallerytype"];
												  //image path
												  $media_path = "uploads/productmediagallery/$productmediagalleryurl";
																										
												}
								
											
										$output .= '<div class="card_details ml-auto mr-auto mb-2" style="text-align: center;border-radius: 2px;">
											<div class="order_list_image" style="display: flex;">
											<!--<div class="product" style="display: flex;">-->

												<figure class="product-media ml-0 mr-0" style="margin-left: auto; margin-right: auto; height=18.5%; width: 18.5%;">
													<a href="product.php?token='.$pd_id.'-'.$productsku.'">									
														<img src="'.$media_path.'" alt="product side">
													</a>
												</figure>
												<div class="row">
												<div class="col-md-8 mt-auto mb-auto" style="text-align: left; padding-left:40px; padding-right:auto; ">
														<div class="mb-0"><a href="product.php?token='.$pd_id.'-'.$productsku.'">
													'.$producttitle.'
													</a>
													<strong class="product-quantity"> × '.$od_qty.'</strong></div>';
													if($variant_id !='0') {
														$output .= '<small class="align-center"><b>Size: </b>'.getVARIANT_CODE($variant_id,'variant_name_from_variant_ID').'</small>';
													 }
													$output .= '<br>
													<span class="kreen-Price-amount amount text-dark">  
													<del style="color:#c66;"><span class="kreen-Price-amount amount text-light"><span class="kreen-Price-currencySymbol text-light">'.general_currency_symbol.'</span>'.getMRPprice($pd_id, $variant_id,$od_qty).'</span> </del>
													&nbsp;
													<small style="font-family: `Jost`, sans-serif; font-size : 100% !important; color: #666;">'.general_currency_symbol.'</small>&nbsp;'. formatCASH($item_total -$item_taxonly).'&nbsp;
													<small style="font-size:70%">( + '.$item_taxonly.' TAX )</small>&nbsp;	
													
													</span>
													<br/>';
													
														$check_prdt_variant_datas = sqlQUERY_LABEL("SELECT * FROM `js_productvariants` where deleted = '0' and status = '1' and variantstockstatus='1' and `parentproduct`='$productID' and variant_available_stock > '0'") or die("Unable to get records:".sqlERROR_LABEL());	
																					
														$count_product_availablecount = sqlNUMOFROW_LABEL($check_prdt_variant_datas);

														if(($count_product_availablecount == 0)){
															$check_prdt_variant_datas = sqlQUERY_LABEL("SELECT * FROM `js_product` where deleted = '0' and status = '1' and productstockstatus='1' and `productID`='$productID' and productavailablestock > '0'") or die("Unable to get records:".sqlERROR_LABEL());	
														}							
														$count_productvariant_list = sqlNUMOFROW_LABEL($check_prdt_variant_datas);
														//for variant product only
														if($count_productvariant_list > 0) {
															$stock_label = 'In Stock';
															$stock_label_class = 'text-success';
															$cartbutton_disable = "";
														} else {
															$stock_label = 'Out Of Stock';
															$stock_label_class = 'text-danger';
															$cartbutton_disable = "disabled";
														}
													$output .= '<a href="dashboard.php?add_to_cart_in_details=add_to_cart_in_details&productID='.$pd_id.'&product_size='.$variant_id.'" class="btn btn-success buy_it_again" style="height: 30px; margin-top: 10px;"><i class="fa fa-shopping-cart fa-2x"></i>Bug it agian</a>
												</div>';
												
												if($od_status_item != '7') {
													$output .= '<div class="col-md-3 mt-1 mb-1" style="text-align: right;">
														<a href="product.php?token='.$pd_id.'-'.$productsku.'&reviews=product-review-heading#product-review-heading" class="btn btn-outline-primary-2 btn-order btn-block" style="height: 30px; width: 200px;">Write a Product Review</a>
														<a href="dashboard.php?nav=orders&mode=cancel&orderID='.$od_id.'&productID='.$pd_id.'" class="btn btn-outline-primary-2 btn-order btn-block" style="height: 30px; width: 200px;">Cancel Order</a>
													</div>';
												} else {
													$output .= '<div class="col-md-3 mt-1 mb-1" style="padding-right:40px;">
													<!--<div class="col-md-3 mt-1 mb-1" style="text-align: right; padding-right:40px; right:0px; left: 60%;">-->
														<span class="badge badge-danger">Product Cancelled </span>
													</div>';
												 }
												$output .= '</div>
											</div>
										 
										</div>
										<hr>';
										} } 
									$output .= '</div>
								 
								</div>';
	
}
	if($_GET["rowcount"] =='0'){
	$output .= '<div class="col-12" style="padding: 10px 340px 10px;">
	<p class="text-center">No order available.</p><br>
				<a href="shop.php" class="btn btn-outline-primary-2" style="width: 100%;"><span>GO SHOP</span><i class="icon-long-arrow-right"></i></a>
				</div>';
}										
if(!empty($perpageresult)) {
	
	$output .= '<div class="col-12">
				<div class="row">
                        <div id="pagination" style="margin: auto; padding: 10px;">' . $perpageresult . '</div>

                </div> 
                </div>';
}
$output .= '</div>';
print $output;
?>