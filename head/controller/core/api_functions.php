<?php
/*
* JACKUS - An In-house Framework for TDS Apps
*
* Author: Touchmark Descience Private Limited. 
* https://touchmarkdes.com
* Version 4.0.1
* Copyright (c) 2018-2019 Touchmark Descience Pvt Ltd
*
*/

include_once('../../jackus.php');

/*************
API CALLS
1. RTW / MTO Product details
2. Get MTO Product from RTW INVENTORY
*************/
//$accessrequest_api /json_customerdata_online.php

$sitekey_status = $composer_VALIDATELICENSE->LICENSEVALID('0', 'LICENSE_SITE_KEY', '../../package.json', $accessaccess_auth, $logged_user_id);
$accesskey_status = $composer_VALIDATELICENSE->LICENSEVALID('1', 'LICENSE_ACCESS_KEY', '../../package.json', $accessaccess_auth, $logged_user_id);

if($sitekey_status != '1' || $accesskey_status != '1') {
	
	echo $__licenseexpirymessage;
	exit();
	
} else {
	
	//0 API call URI
	function commonAPIURI() {
		
		global $accessrequest_api;  //api access url
		$data_file = $accessrequest_api.'json_APIfunctions_online.php';

		return $data_file;
	}

	//1. RTW / MTO Product details
	function apiOPCPRODUCTDETAILS($requestprdtTYPE, $requestedID, $requestTYPE) 
	{
		$appURI = commonAPIURI();
		
		//add get-variables
		$productTYPE = "producttype=$requestprdtTYPE";
		$productID = "productid=$requestedID";
		
		//show result based on request
		if($requestTYPE == 'productCODE') {
			
			//auto-generate type variable
			$requestCALL = "type=$requestTYPE";
			
			//construct API URI
			$generateCALL = $appURI.'?'.$productTYPE.'&'.$productID.'&'.$requestCALL;  
			
			$readjson = file_get_contents($generateCALL);
			$received_response_data = json_decode($readjson, true);  //Decode JSON
			
			if($received_response_data['session'] == 'valid') {
				return $received_response_data['productCODE'];
			} else {
				return '--';
			}
		}
		
		//show product units request
		if($requestTYPE == 'productUNIT') {
			
			//auto-generate type variable
			$requestCALL = "type=$requestTYPE";
			
			//construct API URI
			$generateCALL = $appURI.'?'.$productTYPE.'&'.$productID.'&'.$requestCALL;  
			
			$readjson = file_get_contents($generateCALL);
			$received_response_data = json_decode($readjson, true);  //Decode JSON
			
			if($received_response_data['session'] == 'valid') {
				return $received_response_data['productUNIT'];
			} else {
				return '--';
			}
		}
		
		//show product units request
		if($requestTYPE == 'productCATID') {
			
			//auto-generate type variable
			$requestCALL = "type=$requestTYPE";
			
			//construct API URI
			$generateCALL = $appURI.'?'.$productTYPE.'&'.$productID.'&'.$requestCALL;  

			$readjson = file_get_contents($generateCALL);
			$received_response_data = json_decode($readjson, true);  //Decode JSON
			
			if($received_response_data['session'] == 'valid') {
				return $received_response_data['productCATID'];
			} else {
				return '--';
			}
		}
		
	}
	
	//2. Get MTO Product from RTW INVENTORY
	function apiOPCCHOOSINGONLINEPRODUCTS($requestprdtTYPE, $outletID, $choosenprdtID, $requestTYPE) 
	{
		global $logged_user_id;
		
		$appURI = commonAPIURI();

		//add get-variables
		$productTYPE = "producttype=$requestprdtTYPE&loggedUSERID=$logged_user_id&outletID=$outletID";

		$encoded_choosen_productID = 'choosedPRDTID='.$choosenprdtID;
		
		if($requestTYPE == 'mtoonlineproductINVENTORY') {
			
			//auto-generate type variable
			$requestCALL = "type=$requestTYPE";
			
			//construct API URI
			$generateCALL = $appURI.'?'.$productTYPE.'&'.$encoded_choosen_productID.'&'.$requestCALL;  
			
			$readjson = file_get_contents($generateCALL);
			$received_response_data = json_decode($readjson, true);  //Decode JSON
						
			if($received_response_data['session'] == 'valid') {
				return $received_response_data['mtoonlineproductINVENTORY'];
			} else {
				return '--';
			}

		}
		
	}

}
