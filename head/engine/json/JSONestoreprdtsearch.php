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

$return_arr = array();
// OR `contact_fname` LIKE '%$customer%'
	$list_producttype_data = curl_multiple(GENERALAPIPATH_SEARCH_ESTORE_PRDT_DATA, ['sku_code' => $title] );

	$characters = json_decode($list_producttype_data); // decode the JSON feed

	$count_producttype_list = count($characters);
		
	if($count_producttype_list > 0){
			
		foreach ($characters as $character) {
			
			$counter++;
			$estore_prdt_code = $character->estore_prdt_code;
			$customer_data_array['title'] = $estore_prdt_code;

			//$row_array['prdt_name'] = $row['prdt_name'];
			array_push($return_arr,$customer_data_array);
		}
	} else {
		
	$customer_data_array['title'] = "$title - No Records Found";
	array_push($return_arr,$customer_data_array);
	
	}

  echo json_encode($return_arr);

?>