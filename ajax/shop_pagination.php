<?php
include '../head/jackus.php';
require_once("../dbcontroller.php");
require_once("../pagination.class.php");
extract($_REQUEST);

$db_handle = new DBController();
	$perPage = new PerPage();
	// if($filterby){
		// $filterby = implode("','", $filterby ) ;
		// $filterby =" and productcategory IN('$filterby')";
		// //echo $filterby;exit();
	// }	
	
	$search_token_ = trim($token);
	$category_token_ = strbefore($search_token_, '-');
	if($category_token_){
		$filterby_nocomma_token[] = $category_token_;	
		// print_r($filterby_nocomma); exit();
		$sql_query_token = sqlQUERY_LABEL("SELECT `productID`, `productsku`, `productcategory`, `producttitle`, `productsellingprice`, `productMRPprice`, `productstockstatus`, `productavailablestock` FROM `js_product` where deleted = '0' and status = '1'") or die("#STATUS-SELECT: Getting Status: ".sqlERROR_LABEL());
		while($set_sql_query_token = sqlFETCHARRAY_LABEL($sql_query_token)){
			$productID_token = $set_sql_query_token['productID'];
			$category_token = $set_sql_query_token['productcategory'];
			$category_token = explode(',',$category_token);	
			foreach($category_token as $val_token) {
				$category_token = $val_token;
				if(in_array($category_token, $filterby_nocomma_token)){
					$counter_token++;
					$filter_productID_category_token = $productID_token;
					$filterby_comma_product_token[$counter_token] = $filter_productID_category_token ;
				}
			}
		}
		
		$filterby_comma_token = implode("','", $filterby_comma_product_token ) ;
		$filterby_category_comma_token =" and productID IN ('$filterby_comma_token')";
	}	
	if($filterby){
		$filterby_nocomma = $filterby;	
		// print_r($filterby_nocomma);
		$sql_query = sqlQUERY_LABEL("SELECT `productID`, `productsku`, `productcategory`, `producttitle`, `productsellingprice`, `productMRPprice`, `productstockstatus`, `productavailablestock` FROM `js_product` where deleted = '0' and status = '1'") or die("#STATUS-SELECT: Getting Status: ".sqlERROR_LABEL());
		while($set_sql_query = sqlFETCHARRAY_LABEL($sql_query)){
			$productID = $set_sql_query['productID'];
			$category = $set_sql_query['productcategory'];
			$category = explode(',',$category);	
			foreach($category as $val) {
				$category = $val;
				if(in_array($category, $filterby_nocomma)){
					$counter++;
					$filter_productID_category = $productID;
					$filterby_comma_product[$counter] = $filter_productID_category ;
				}
			}
		}
		
		$filterby_comma = implode("','", $filterby_comma_product ) ;
		$filterby_category_comma =" and productID IN ('$filterby_comma')";
	}	
	if($filterby_color){
		$filterby_nocomma_color = $filterby_color;	
		// print_r($filterby_nocomma_color);
		$sql_query_color = sqlQUERY_LABEL("SELECT `productID`, `productsku`, `productcolor`, `producttitle`, `productsellingprice`, `productMRPprice`, `productstockstatus`, `productavailablestock` FROM `js_product` where deleted = '0' and status = '1'") or die("#STATUS-SELECT: Getting Status: ".sqlERROR_LABEL());
		while($set_sql_query_color = sqlFETCHARRAY_LABEL($sql_query_color)){
			$productID_color = $set_sql_query_color['productID'];
			$color = $set_sql_query_color['productcolor'];
			$color = explode(',',$color);	
			foreach($color as $val) {
				$color = $val;
				if(in_array($color, $filterby_nocomma_color)){
					$counter_color++;
					$filter_productID_color = $productID_color;
					$filterby_comma_product[$counter_color] = $filter_productID_color ;
				}
			}
		}
		
		$filterby_color = implode("','", $filterby_comma_product ) ;
		$filterby_color_comma =" and productID IN ('$filterby_color')";
	}	
	if($filterby_material){
		$filterby_nocomma_material = $filterby_material;	
		// print_r($filterby_nocomma_material);
		$sql_query_material = sqlQUERY_LABEL("SELECT `productID`, `productsku`, `productmaterial`, `producttitle`, `productsellingprice`, `productMRPprice`, `productstockstatus`, `productavailablestock` FROM `js_product` where deleted = '0' and status = '1'") or die("#STATUS-SELECT: Getting Status: ".sqlERROR_LABEL());
		while($set_sql_query_material = sqlFETCHARRAY_LABEL($sql_query_material)){
			$productID_material = $set_sql_query_material['productID'];
			$material = $set_sql_query_material['productmaterial'];
			$material = explode(',',$material);	
			foreach($material as $val) {
				$material = $val;
				if(in_array($material, $filterby_nocomma_material)){
					$counter_material++;
					$filter_productID_material = $productID_material;
					$filterby_comma_material[$counter_material] = $filter_productID_material ;
				}
			}
		}
		
		$filterby_material = implode("','", $filterby_comma_material ) ;
		$filterby_material_comma =" and productID IN ('$filterby_material')";
	}	
	if($filterby_type){
		$filterby_nocomma_type = $filterby_type;	
		// print_r($filterby_nocomma_type);
		$sql_query_type = sqlQUERY_LABEL("SELECT `productID`, `productsku`, `producttype`, `producttitle`, `productsellingprice`, `productMRPprice`, `productstockstatus`, `productavailablestock` FROM `js_product` where deleted = '0' and status = '1'") or die("#STATUS-SELECT: Getting Status: ".sqlERROR_LABEL());
		while($set_sql_query_type = sqlFETCHARRAY_LABEL($sql_query_type)){
			$productID_type = $set_sql_query_type['productID'];
			$type = $set_sql_query_type['producttype'];
			$type = explode(',',$type);	
			foreach($type as $val) {
				$type = $val;
				if(in_array($type, $filterby_nocomma_type)){
					$counter_type++;
					$filter_productID_type = $productID_type;
					$filterby_comma_type[$counter_type] = $filter_productID_type ;
				}
			}
		}
		
		$filterby_type = implode("','", $filterby_comma_type ) ;
		$filterby_type_comma =" and productID IN ('$filterby_type')";
	}	
	if($filterby_price){
		$filterby_nocomma_price = $filterby_price;	
		// echo $filterby_nocomma_price[1][1];exit();
		$low = $filterby_nocomma_price[0][1];
		$high = $filterby_nocomma_price[1][1];
		if($low != ''){
			$filterby_price_comma_low =" and (productsellingprice + ((productsellingprice * (producttax/100))/2)) > $low";
		}
		if($high != ''){
			$filterby_price_comma_high =" and (productsellingprice + ((productsellingprice * (producttax/100))/2)) < $high";
		}
		// echo $filterby_price_comma_low; exit();
	}	
	if($filterby_size){
		// print_r($filterby_size);
		// echo "SELECT variant_ID, parentproduct FROM `js_productvariants` where deleted = '0' and status = '1' and variantstockstatus='1' and variant_name='$filterby_size'";
		$sql_query_size = sqlQUERY_LABEL("SELECT variant_ID, parentproduct FROM `js_productvariants` where deleted = '0' and status = '1' and variantstockstatus='1' and variant_name='$filterby_size[0]'") or die("#STATUS-SELECT: Getting Status: ".sqlERROR_LABEL());
		while($set_sql_query_size = sqlFETCHARRAY_LABEL($sql_query_size)){
			$counter_size++;
			$variant_ID = $set_sql_query_size['variant_ID'];
			$parentproduct = $set_sql_query_size['parentproduct'];
			
			$filterby_comma_size[$counter_size] = $parentproduct ;
		}
		
		$filterby_varient = implode("','", $filterby_comma_size ) ;
		$filterby_size_comma ="  and productID IN ('$filterby_varient')";
	}	
	if($filterby_hightolow){
		$sql_query_product_hightolow = sqlQUERY_LABEL("SELECT PRODUCT.`productID`, PRODUCT_VARIENT.`variant_mrp_price`, PRODUCT_VARIENT.`variant_msp_price`, PRODUCT_VARIENT.`variant_taxsplit1`, PRODUCT_VARIENT.`variant_taxsplit2`, (PRODUCT_VARIENT.`variant_msp_price` + PRODUCT_VARIENT.`variant_taxsplit1` + PRODUCT_VARIENT.`variant_taxsplit2`) AS PRODUCT_VARIENT_SELLING_WITH_TAX, (productsellingprice + ((productsellingprice * (producttax/100))/2)) AS PRODUCT_SELLING_WITH_TAX FROM `js_product` AS PRODUCT LEFT JOIN `js_productvariants` AS PRODUCT_VARIENT ON PRODUCT.deleted = '0' and PRODUCT.status = '1' and PRODUCT_VARIENT.deleted = '0' and PRODUCT_VARIENT.status = '1' and PRODUCT_VARIENT.variantstockstatus='1' and PRODUCT_VARIENT.`parentproduct`=PRODUCT.`productID` ORDER BY IF( ISNULL(PRODUCT_VARIENT_SELLING_WITH_TAX), PRODUCT_SELLING_WITH_TAX, PRODUCT_VARIENT_SELLING_WITH_TAX ) DESC") or die("#STATUS-SELECT: Getting Status: ".sqlERROR_LABEL());
		
		while($set_product_hightolow = sqlFETCHARRAY_LABEL($sql_query_product_hightolow)){
			$counter_hightolow++;
			$product_ID_hightolow = $set_product_hightolow['productID'];
			$filterby_comma_hightolow[$counter_hightolow] = $product_ID_hightolow ;
		}
		
		$filterby_hightolow = implode("','", $filterby_comma_hightolow ) ;
		$filterby_hightolow_comma ="  and productID IN ('$filterby_hightolow') ORDER BY FIELD(productID, '$filterby_hightolow')";
	}	
	if($filterby_lowtohigh){
		$sql_query_product_lowtohigh = sqlQUERY_LABEL("SELECT PRODUCT.`productID`, PRODUCT_VARIENT.`variant_mrp_price`, PRODUCT_VARIENT.`variant_msp_price`, PRODUCT_VARIENT.`variant_taxsplit1`, PRODUCT_VARIENT.`variant_taxsplit2`, (PRODUCT_VARIENT.`variant_msp_price` + PRODUCT_VARIENT.`variant_taxsplit1` + PRODUCT_VARIENT.`variant_taxsplit2`) AS PRODUCT_VARIENT_SELLING_WITH_TAX, (productsellingprice + ((productsellingprice * (producttax/100))/2)) AS PRODUCT_SELLING_WITH_TAX FROM `js_product` AS PRODUCT LEFT JOIN `js_productvariants` AS PRODUCT_VARIENT ON PRODUCT.deleted = '0' and PRODUCT.status = '1' and PRODUCT_VARIENT.deleted = '0' and PRODUCT_VARIENT.status = '1' and PRODUCT_VARIENT.variantstockstatus='1' and PRODUCT_VARIENT.`parentproduct`=PRODUCT.`productID` ORDER BY IF( ISNULL(PRODUCT_VARIENT_SELLING_WITH_TAX), PRODUCT_SELLING_WITH_TAX, PRODUCT_VARIENT_SELLING_WITH_TAX ) ASC") or die("#STATUS-SELECT: Getting Status: ".sqlERROR_LABEL());
		
		while($set_product_lowtohigh = sqlFETCHARRAY_LABEL($sql_query_product_lowtohigh)){
			$counter_lowtohigh++;
			$product_ID_lowtohigh = $set_product_lowtohigh['productID'];
			$filterby_comma_lowtohigh[$counter_lowtohigh] = $product_ID_lowtohigh ;
		}
		
		$filterby_lowtohigh = implode("','", $filterby_comma_lowtohigh ) ;
		$filterby_lowtohigh_comma ="  and productID IN ('$filterby_lowtohigh') ORDER BY FIELD(productID, '$filterby_lowtohigh')";
	}	
	if($filterby_rating){
		//SELECT REVIEW.product_ID, PRODUCT.productID, COUNT(REVIEW.review_ID) AS COUNT_REVIEWS FROM js_product AS PRODUCT, js_review AS REVIEW WHERE REVIEW.product_ID=PRODUCT.productID GROUP BY REVIEW.product_ID ORDER BY COUNT_REVIEWS DESC
		
		$sql_query_product_rating = sqlQUERY_LABEL("SELECT REVIEW.product_ID, PRODUCT.productID, COUNT(REVIEW.review_ID) AS COUNT_REVIEWS FROM js_product AS PRODUCT, js_review AS REVIEW WHERE REVIEW.product_ID=PRODUCT.productID GROUP BY REVIEW.product_ID ORDER BY COUNT_REVIEWS DESC") or die("#STATUS-SELECT: Getting Status: ".sqlERROR_LABEL());
		
		while($set_product_rating = sqlFETCHARRAY_LABEL($sql_query_product_rating)){
			$counter_rating++;
			$product_ID_rating = $set_product_rating['productID'];
			$filterby_comma_rating[$counter_rating] = $product_ID_rating ;
		}
		
		$filterby_rating = implode("','", $filterby_comma_rating ) ;
		$filterby_rating_comma ="  and productID IN ('$filterby_rating') ORDER BY FIELD(productID, '$filterby_rating')";
	}	
	if($filterby_popularity){
		$filterby_popularity =" ORDER BY productviewed DESC";
	}	


if($s!= '' || $token != '') {
//echo $token;
	$s = trim($s);
	 
	if(strlen($s) > 2) {
		$filter_phrase = "(producttitle LIKE '%$s%' OR productsku LIKE '$s%' OR productmetakeywords LIKE '%$s%') and";		
	}
	
	// $search_token = trim($token);
	// $category_token = strbefore($search_token, '-');
	
	// if($category_token != '') {
		// $filter_phrase = " productcategory IN ($category_token) and";				
	// }
		$sql = "SELECT `productID`, `productsku`, `producttitle`, `productsellingprice`, `productMRPprice`, `productstockstatus`, `productavailablestock` FROM `js_product` where {$filter_phrase} deleted = '0' and status = '1' {$filterby_category_comma} {$filterby_color_comma} {$filterby_material_comma} {$filterby_type_comma} {$filterby_price_comma_low} {$filterby_price_comma_high} {$filterby_category_ID} {$filterby_size_comma} {$filterby_hightolow_comma} {$filterby_lowtohigh_comma} {$filterby_popularity} {$filterby_rating_comma} {$filterby_category_comma_token}";
	
} else {

		$sql = "SELECT `productID`, `productsku`, `producttitle`, `productsellingprice`, `productMRPprice`, `productstockstatus`, `productavailablestock` FROM `js_product` where deleted = '0' and status = '1'  {$filterby_category_comma} {$filterby_color_comma} {$filterby_material_comma} {$filterby_type_comma} {$filterby_price_comma_low} {$filterby_price_comma_high} {$filterby_category_ID} {$filterby_size_comma} {$filterby_hightolow_comma} {$filterby_lowtohigh_comma} {$filterby_popularity} {$filterby_rating_comma} {$filterby_category_comma_token}";	
	}
//echo $sql;
// echo $sql;
$paginationlink = "ajax/shop_pagination.php?search_value=".$s."&token=".$token."&page=";
$pagination_setting = $_GET["pagination_setting"];
// echo $pagination_setting;			
$page = 1;
if(!empty($_GET["page"])) {
	$page = $_GET["page"];
}

$start = ($page-1)*$perPage->perpage;
//echo $start;exit();
if($start < 0) $start = 0;

$query =  $sql . " limit " . $start . "," . $perPage->perpage; 
$faq = $db_handle->runQuery($query);
// echo $query;
if($_GET["rowcount"]=='') {
	$_GET["rowcount"] = $db_handle->numRows($sql);
}
// if($pagination_setting == "prev-next") {
	// $perpageresult = $perPage->getPrevNext($_GET["rowcount"], $paginationlink,$pagination_setting);	
// } else {
	$perpageresult = $perPage->getAllPageLinks($_GET["rowcount"], $paginationlink,$pagination_setting);	
// }

// echo 'A'; exit();
//echo $faq ;
$output = '';
  // echo $sql ;
  if($perPage->perpage < $_GET["rowcount"]){
	  $page_per_filter = $perPage->perpage;
  } else {
	  $page_per_filter = $_GET["rowcount"];
  }
  if($_GET["rowcount"] != '0'){
 $output .='<div class="text-center mt-0 col-12 mb-2">
                            <div class="toolbox-info">
                                Showing <span class="total_products">'.$page_per_filter.' of '.$_GET["rowcount"].'</span> Products
                            </div><!-- End .toolbox-info -->
                        </div><!-- End .toolbox-center -->';
  }
foreach($faq as $k=>$v) {
	
	
	$payment_ref = $faq[$k]['payment_ref'];
	
	  $productID = $faq[$k]["productID"];
	  $productsku = $faq[$k]["productsku"];
	  $producttitle = html_entity_decode($faq[$k]["producttitle"], ENT_QUOTES, "UTF-8");
	  $producttitle = str_replace("\'","'",$producttitle); //$row["producttitle"];
	  $productsellingprice = formatCASH($faq[$k]["productsellingprice"]);
	  $productMRPprice = formatCASH($faq[$k]["productMRPprice"]);
	  $productavailablestock = $faq[$k]["productavailablestock"];
	  $productstockstatus = $faq[$k]["productstockstatus"];  //stock status
	  
	  //product title
	  $custom_producttitle = limit_words($producttitle, 3);
	  if(strlen($custom_producttitle) > 35) { $add_moredots='...'; } 
		
		//check price difference percentage
		if($faq[$k]["productMRPprice"] > $faq[$k]["productsellingprice"]) {
			$__productprice_difference = number_format(((($faq[$k]["productMRPprice"] - $faq[$k]["productsellingprice"])/$faq[$k]["productsellingprice"]) * 100), 0);
			$shop_discount_percentage = '<span class="onsale"><span class="number">-'.$__productprice_difference.'%</span></span>';
			$shop_offer_strike_price = '<del><span class="kreen-Price-amount amount"><span class="kreen-Price-currencySymbol">₹</span>'.$productMRPprice.'</span></del>';
		} else {
			$shop_discount_percentage = '';
			$shop_offer_strike_price = '';
		}
		
		//button variable
		if($productstockstatus == 0 || $productavailablestock == 0) {
			$shop_buttonclass_m = 'nostock-cart';
			$shop_buttonclass = 'nostock-cart_button';
			$shop_button_label = 'Out of Stock';
		} else {
			$shop_buttonclass_m = 'add-to-cart';
			$shop_buttonclass = 'add_to_cart_button';
			$shop_button_label = 'Add to Cart';
		}							
	$output .= '<div class="col-6 col-md-4 col-lg-4 col-xl-3">
									<div class="product">
										<figure class="product-media">';
										if($productstockstatus == '0') {
	$output .= '<span class="product-label label-new">'.$outofstock_label.'</span>'; 
											}
	$output .= '<a href="product.php?token='.$productID.'-'.$productsku.'" target="_blank">';
												
												
												$featured_product_image = sqlQUERY_LABEL("SELECT `productmediagallerytitle`, `productmediagalleryurl` FROM `js_productmediagallery` where productID='$productID' and productmediagalleryfeatured='1' and productmediagallerytype='1' and deleted = '0' and status = '1'") or die("#1-Unable to get records:".mysqli_error());
												  while($featured_image = sqlFETCHARRAY_LABEL($featured_product_image)){
													  $productmediagallerytitle = $featured_image["productmediagallerytitle"];
													  $productmediagalleryurl = $featured_image["productmediagalleryurl"];
												
$output .= '<img class="product-image" src="uploads/productmediagallery/'.$productmediagalleryurl.'" title="'.$productmediagallerytitle.'" alt="'.$productmediagallerytitle.'">';
												
												  }
												
	$output .= '</a>
	<div class="product-action-vertical">';
	
	$list_variant_size = sqlQUERY_LABEL("SELECT variant_name,variant_ID FROM js_productvariants WHERE parentproduct = '$productID' and deleted = '0' LIMIT 1") or die ("#1-Unable to get records:".mysqli_error());
									//if(sqlNUMOFROW_LABEL($list_variant_size)){
									$check_list_variant_size = sqlNUMOFROW_LABEL($list_variant_size);
									//echo $check_list_variant_size;exit();
									if($check_list_variant_size > 0){
										while($list_variant_size_data = sqlFETCHARRAY_LABEL($list_variant_size)){
									$variant_name = $list_variant_size_data['variant_name'];
									$variant_IDs = $list_variant_size_data['variant_ID'];
									}
									}else{
										$variant_IDs = '';
									}
									
									
	$output .= '<input type="hidden" name="product_size" id="product_size" value='.$variant_IDs.'>';
									
												$output .= '<a onClick="product_wishlist('.$productID.','.$variant_IDs.')" href="javascript:void(0);" class="btn-product-icon btn-wishlist btn-expandable"><span>add to wishlist</span></a>';
												
												
												 
										   $show_variant_size = sqlQUERY_LABEL("SELECT variant_name,variant_ID FROM js_productvariants WHERE parentproduct = '$productID' and deleted = '0'") or die ("#1-Unable to get records:".mysqli_error());
										   if(sqlNUMOFROW_LABEL($show_variant_size)){
											   $output .= '
												<a href="#" class="btn-product-icon btn-quickview btn-expandable" title="Sizes"><span style="font-weight:600;">';
											   while($show_variant_size_data = sqlFETCHARRAY_LABEL($show_variant_size)){
												$variant_name = $show_variant_size_data['variant_name'];
												//$variant_ID = $show_variant_size_data['variant_ID'];
										
												$output .= ''.$variant_name.' | ';
												 }
												$output .= '</span></a>';
												  } 
											$output .= '</div>';
											
										$output .= '</figure>

										<div class="product-body">
											<h3 class="product-title">
											<a href="product.php?token='.$productID.'-'.$productsku.'" target="_blank">';
											if(strlen($custom_producttitle) > 35) { $add_moredots='...'; } 
												
	$output .= $custom_producttitle.$add_moredots.'</a></h3>
											<div class="product-price">
												'.checkproductPRICE($productID).'
											</div>
										</div>
									</div>
								</div>';	
}
if($output ==''){
	$output .= '
				
                        <div id="pagination" style="margin: auto; padding: 10px;">
						
				
				<h2 class="text-align:center">Sorry, no results found!</h2></br>
			
				<div><p class="text-align:center">Please check the spelling or try searching for something else</p></br>
				<div class="text-center">
                <a type="button" class="btn button btn-outline-primary-2" href="index.php" class="text-align:center">Go To Home</a>
				</div>
			</div>
			
			
			
			</div>
			
               
               ';
}
if(!empty($perpageresult)) {
	
	$output .= '<div class="col-12 mb-5">
				<div class="row">
                        <div id="pagination" style="margin: auto; padding: 10px;">' . $perpageresult . '</div>

                </div> 
                </div>';
}
print $output;
?>