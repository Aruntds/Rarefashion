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

if($status !='')
{
	$filterby = "AND status='$status'  ";
}

echo "{";
echo '"data":[';

	$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_support_ticket` order by ticket_ID desc") or die("Unable to get records:".sqlERROR_LABEL());

	$fetch_list = sqlNUMOFROW_LABEL($list_datas);
 
 while($fetch_records = sqlFETCHARRAY_LABEL($list_datas)){

		$counter++;
		$product_ID = $fetch_records['product_ID'];
		$ticket_no = $fetch_records['ticket_no'];
		$ticket_ID = $fetch_records['ticket_ID'];
		$ticket_name = $fetch_records['ticket_name'];
		if($ticket_name == ''){
			$ticket_name = "Self";
		}
		$product = getSINGLEDBVALUE('producttitle',"productID='$product_ID'",'js_product','label');	
		$product_seo_url = getSINGLEDBVALUE('productseourl',"productID='$product_ID'",'js_product','label');	
		$status = $fetch_records['status'];
		if($status==1){
						$complaint_status = "<span class='text-success'>NEW</span>";
					 }
					 if($status==2){
						$complaint_status = "<span class='text-danger'>CLOSED</span>";
					 }
					 if($status==3){
						$complaint_status = "<span class='text-primary'>REPLIED</span>";
					 }
	 	   $datas .= "{";
			   $datas .= '"count": "'.$counter.'",';
			   $datas .= '"ticket_number": "'.$ticket_no.'",';
			   $datas .= '"ticket_id": "'.$ticket_ID.'",';
			   $datas .= '"product": "'.$product.'",';
			   $datas .= '"customer": "'.$ticket_name.'",';
			   $datas .= '"status": "'.$complaint_status.'",';
			   $datas .= '"product_ID": "'.$product_ID.'",';
			   $datas .= '"product_seo_url": "'.$product_seo_url.'",';
			   $datas .= '"modify": "'.$ticket_ID.'"';
			   
		   $datas .= "},";
			} //end of while loop

//echo '{"count":"", "categoryname":"", "status":"", "modify":"" }';
$data_formatted = substr(trim($datas), 0, -1);
echo $data_formatted;
echo "]}";
?>