<?php
extract($_REQUEST);
include_once('../head/jackus.php');

$return_arr = array();

$fetch = sqlQUERY_LABEL("SELECT productID, producttitle, productsku,productcategory FROM js_product WHERE producttitle LIKE '%$product_info%' and status = '1' and deleted ='0' LIMIT 0,10"); 

 if(sqlNUMOFROW_LABEL($fetch)) {
	while ($row = sqlFETCHARRAY_LABEL($fetch, MYSQL_ASSOC)) {
		$productID = $row['productID'];
		$producttitle = $row['producttitle'];
		$token = $row['productsku'];
		$productcategory = $row['productcategory'];

		$categories = '';
		$cats = explode(",", $productcategory);
		foreach($cats as $cat) {
			$cat = trim($cat);
			$__category_title = getSINGLEDBVALUE('categoryname', " categoryID='$cat' and deleted='0' and status = '1'", 'js_category', 'label');
			$categories .= $__category_title . ",";
		}
		
		$row_array['product_details'] = $producttitle;
		// $row_array['product_details'] = $producttitle. '-' .substr($categories, 0, -1);
		//$row_array['prdt_name'] = $row['prdt_name'];

		$productmedia_datas = sqlQUERY_LABEL("SELECT productmediagalleryID, productmediagalleryurl, productmediagallerytype FROM `js_productmediagallery` where productID='$productID' and deleted = '0' order by productmediagalleryurl ASC") or die("#2-Unable to get records:".mysqli_error());														  
		$count_productmedia_availablecount = sqlNUMOFROW_LABEL($productmedia_datas);	
		while($row = sqlFETCHARRAY_LABEL($productmedia_datas)){
		  $productmediagalleryID = $row["productmediagalleryID"];
		  $productmediagalleryurl = $row["productmediagalleryurl"];
		  $productmediagallerytype = $row["productmediagallerytype"];
		  //image path
		  $media_path = "uploads/productmediagallery/$productmediagalleryurl";
		  $row_array['icon'] = $media_path;													
		}
		array_push($return_arr,$row_array);
	} 
} else {
	$media_path=SITEHOME."assets/images/newspopup.jpg";
	$row_array['icon'] = $media_path;
	$row_array['product_details'] = "$product_info";
	array_push($return_arr,$row_array);
}

  echo json_encode($return_arr);

?>