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
include_once('../../jackus.php');

if($reviewtype)
{
	$filterby = " and review_type = '$reviewtype' ";
}

echo "{";
echo '"data":[';

	$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_feedback` where deleted = '0' order by feedback_ID desc") or die("Unable to get records:".sqlERROR_LABEL());

	$fetch_list = sqlNUMOFROW_LABEL($list_datas);
 
 while($fetch_records = sqlFETCHARRAY_LABEL($list_datas)){

		$counter++;
		$product_ID = $fetch_records['product_ID'];
		$feedback_ID = $fetch_records['feedback_ID'];
		$feedback_name = $fetch_records['feedback_name'];
		$feedback_date = $fetch_records['createdon'];
		$feedback_name = $fetch_records['feedback_name'];
		$review_discription = $fetch_records['feedback_discription'];
		$product = getSINGLEDBVALUE('producttitle',"productID='$product_ID'",'js_product','label');	
		$product_seo_url = getSINGLEDBVALUE('productseourl',"productID='$product_ID'",'js_product','label');
		$status = $fetch_records['status'];
		if($feedback_date == '0000-00-00 00:00:00' || $feedback_date == ''){$feedback_date = 'N/A';}else{
			$feedback_date = date('jS M, Y, h:i A',strtotime($feedback_date));
		}
		// $booking_id = getSINGLEDBVALUE('booking_reference_id',"booking_ID='$booking_id'",'js_booking','label');	
		
	 	   $datas .= "{";
			   $datas .= '"count": "'.$counter.'",';
			   $datas .= '"product": "'.$product.'",';
			   $datas .= '"customer": "'.$feedback_name.'",';
			   $datas .= '"feedback_date": "'.$feedback_date.'",';
			   $datas .= '"review_discription": "'.$review_discription.'",';
			  
			   $datas .= '"modify": "'.$feedback_ID.'",';
			   $datas .= '"product_ID": "'.$product_ID.'",';
			   $datas .= '"product_seo_url": "'.$product_seo_url.'",';
			   $datas .= '"content": "'.$content.'"';
			   
		   $datas .= "},";
			} //end of while loop

//echo '{"count":"", "categoryname":"", "status":"", "modify":"" }';
$data_formatted = substr(trim($datas), 0, -1);
echo $data_formatted;
echo "]}";
?>