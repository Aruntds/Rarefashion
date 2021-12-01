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

echo "{";
echo '"data":[';
//echo "SELECT `productID`,`productsku`,`producttitle`,`productMRPprice`,`productsellingprice`,`productavailablestock` FROM `js_product` where deleted = '0' and status = '1' and productavailablestock <= '5' order by  productID DESC LIMIT 10";
  $list_vehicletype_datas = sqlQUERY_LABEL("SELECT `productID`,`productsku`,`producttitle`,`productMRPprice`,`productsellingprice`,`productavailablestock` FROM `js_product` where deleted = '0' and status = '1' and productavailablestock <= '5' order by  productID DESC LIMIT 10") or die("#1-Unable to get MAIN Product records:".sqlERROR_LABEL());

  $count_vehicletype_list = sqlNUMOFROW_LABEL($list_vehicletype_datas);

	while($row = sqlFETCHARRAY_LABEL($list_vehicletype_datas)){
		$counter++;
		$productID = $row["productID"];
		//$productestore_code = $row["productestore_code"];
		$productsku = $row["productsku"];
		$producttitle = $row["producttitle"];
		$productMRPprice = $row["productMRPprice"];
		$productsellingprice = $row["productsellingprice"];
		$productavailablestock = $row["productavailablestock"];
	
		//$list_producttype_data = curl_multiple(GENERALAPIPATH_SELECT_ESTORE_PRDT_DATA, ['sku_code' => $productestore_code] );
	     //echo'test';
	// $characters = json_decode($list_producttype_data); // decode the JSON feed
		// $count_producttype_list = count($characters);

		// if($count_producttype_list > 0){
			// foreach ($characters as $character) {
				// $estore_prdt_opening_qty = $character->estore_prdt_opening_qty;
				// $estore_prdt_available_qty = $character->estore_prdt_qty;
			// }
		// }
	
		//generated sub-category details
		// $list_subvehicle_datas = sqlQUERY_LABEL("SELECT * FROM `js_productvariants` where deleted = '0' and `parentproduct`='$productID' and variant_code != '' order by variant_ID ASC") or die("#2-Unable to get Variant Product records:".mysql_error());
		// $count_subvehicle_list = sqlNUMOFROW_LABEL($list_subvehicle_datas);
			// $counter++;
		   // $datas .= "{";
			   // $datas .= '"count": "'.$counter.'",';
			   // $datas .= '"producttitle": "<b>'.$producttitle.'</b>",';
			   // if($productestore_code == ''){
			   // $datas .= '"productestore_code": "<b>--</b>",';
			   // $datas .= '"productMRPprice": "<b--</b>",';
			   // $datas .= '"productsellingprice": "<b>--</b>",';
			   // $datas .= '"productestorestock": "<b>--</b>"';
			   // } else {
			   // $datas .= '"productestore_code": "<b>'.$productestore_code.'</b>",';
			   // $datas .= '"productMRPprice": "<b>'.general_currency_symbol.' '.moneyFormatIndia($productMRPprice).'</b>",';
			   // $datas .= '"productsellingprice": "<b>'.general_currency_symbol.' '.moneyFormatIndia($productsellingprice).'</b>",';
			   // $datas .= '"productestorestock": "<b>'.$estore_prdt_available_qty.'</b>"';
			   // }
			// $datas .= " },";
			
		
		//} //end of parent category check
	
		//checking sub category
		// if($count_subvehicle_list > 0) {
			// while($subrow = sqlFETCHARRAY_LABEL($list_subvehicle_datas)){
			  // $counter++;
			  // $variant_ID = $subrow["variant_ID"];
			  // $parentproduct = $subrow["parentproduct"];
			  // $variant_name = $subrow["variant_name"];
			  // $variant_code = $subrow["variant_code"];
			  // $variant_mrp_price = $subrow["variant_mrp_price"];
			  // $variant_msp_price = $subrow["variant_msp_price"];

			// $list_variant_product_data = curl_multiple(GENERALAPIPATH_SELECT_ESTORE_PRDT_DATA, ['sku_code' => $variant_code] );
			// $characters_variant = json_decode($list_variant_product_data); // decode the JSON feed
			// $count_product_variant_list = count($characters_variant);

			// if($count_product_variant_list > 0){
				// foreach ($characters_variant as $character_variant) {
					// $estore_prdt_opening_qty = $character_variant->estore_prdt_opening_qty;
					// $estore_prdt_variant_available_qty = $character_variant->estore_prdt_qty;
				// }
			// }
			
			//if($estore_prdt_variant_available_qty <= $estore_lowstock_level){
			   $datas .= "{";
				   $datas .= '"count": "'.$counter.'",';
				   $datas .= '"producttitle": "&nbsp &nbsp &nbsp'.$producttitle.'",';
				   $datas .= '"productestore_code": "'.$productsku.'",';
				   $datas .= '"productMRPprice": "'.general_currency_symbol.' '.($productMRPprice).'",';
				   $datas .= '"productsellingprice": "'.general_currency_symbol.' '.($productsellingprice).'",';
				   $datas .= '"productestorestock": "'.$productavailablestock.'"';
			   $datas .= " },";
			//}
			//} //end of while loop
		//} //end of sub catggory - count
	}
//echo '{"count":"", "categoryname":"", "status":"", "modify":"" }';
$data_formatted = substr(trim($datas), 0, -1);
echo $data_formatted;
echo "]}";
?>