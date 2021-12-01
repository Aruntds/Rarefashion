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

	$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_review` where deleted = '0' order by review_ID desc") or die("Unable to get records:".sqlERROR_LABEL());

	$fetch_list = sqlNUMOFROW_LABEL($list_datas);
 
 while($fetch_records = sqlFETCHARRAY_LABEL($list_datas)){

		$counter++;
		$review_ID = $fetch_records['review_ID'];
		$product_ID = $fetch_records['product_ID'];
		$ticket_ID = $fetch_records['ticket_ID'];
		$review_name = $fetch_records['review_name'];
		$review_discription = $fetch_records['review_discription'];
		$product = getSINGLEDBVALUE('producttitle',"productID='$product_ID'",'js_product','label');	
		$product_sku = getSINGLEDBVALUE('productsku',"productID='$product_ID'",'js_product','label');	
		$product_seo_url = getSINGLEDBVALUE('productseourl',"productID='$product_ID'",'js_product','label');	
		$status = $fetch_records['status'];
		
		$rating = $fetch_records['rating'];
		$review_type = $fetch_records['review_type'];
		$rating_date = $fetch_records['createdon'];
	
		$od_id = $fetch_records['od_id'];
		$od_ref_no = getORDERREF_USING_ODID($od_id);
		//$od_ref_no = '';
		
		if($rating_date == '0000-00-00 00:00:00' || $rating_date == ''){$rating_date = 'N/A';}else{
			$rating_date = date('jS M, Y, h:i A',strtotime($rating_date));
		}
		if($rating == '5'){$rating = "5 Star";}
		if($rating == '4'){$rating = "4 Star";}
		if($rating == '3'){$rating = "3 Star";}
		if($rating == '2'){$rating = "2 Star";}
		if($rating == '1'){$rating = "1 Star";}
		
		if($review_type == '1'){
			$review_type = "<span class='text-success'>Review For Product</span>";
		}
		if($review_type == '2'){
			$review_type = "<span class='text-warning'>Review For Order</span>";
		}
		//echo $od_ref_no;
		
		if($od_ref_no == '' || $od_ref_no == '0'){$od_ref_no = EMPTYFIELD;}
		
		// $booking_id = getSINGLEDBVALUE('booking_reference_id',"booking_ID='$booking_id'",'js_booking','label');	
		$content = "<a title='Click to Preview' onclick='view_complaint($review_ID)' class='btn btn-light btn-icon'><i class='fa fa-eye'></i></a>";
	 	   $datas .= "{";
			   $datas .= '"count": "'.$counter.'",';
			   $datas .= '"product": "'.$product.'",';
			   $datas .= '"rating": "'.$rating.'",';
			   $datas .= '"od_ref_no": "'.$od_ref_no.'",';
			   $datas .= '"review_type": "'.$review_type.'",';
			   $datas .= '"od_id": "'.$od_id.'",';
			   $datas .= '"rating_date": "'.$rating_date.'",';
			   $datas .= '"product_ID": "'.$product_ID.'",';
			   $datas .= '"product_seo_url": "'.$product_seo_url.'",';
			   $datas .= '"customer": "'.$review_name.'",';
			   $datas .= '"status": "'.$status.'",';
			   $datas .= '"review_discription": "'.$review_discription.'",';
			   $datas .= '"modify": "'.$review_ID.'",';
			   $datas .= '"content": "'.$content.'"';
			   
		   $datas .= "},";
			} //end of while loop

//echo '{"count":"", "categoryname":"", "status":"", "modify":"" }';
$data_formatted = substr(trim($datas), 0, -1);
echo $data_formatted;
echo "]}";
?>