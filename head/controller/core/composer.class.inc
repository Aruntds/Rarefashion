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

if ($accesscontrol_license =='1') {

	//$currentpage
	class composerLICENSEKEY
	{
	
		//check license-valid
		public function LICENSEVALID($id, $type, $accessfile, $accesstoken, $auth_manager)
		{
			$readjson = file_get_contents(BASEPATH.'package.json'); //package.json
			$data = json_decode($readjson, true);  //Decode JSON
			//echo $data[0]["LICENSE_SITE_KEY"].', '.$data[1]["LICENSE_ACCESS_KEY"];
			
			if($type != '') {
				
				//checking license validity
				$license_data = $data[$id][$type];
				
				//main server - access
				$apicheck_path = $accesstoken."/validate-api-access.php";   //validate-access.php
				
				//design variable
				$apicheck_variables = "?type=$type&data=$license_data&auth_manager=$auth_manager";
				//echo $apicheck_path.$apicheck_variables;
				return file_get_contents($apicheck_path.$apicheck_variables);
				
			}
			
		}	
		
	} //End of class

	$composer_VALIDATELICENSE = new composerLICENSEKEY();
	
	//exit();

} else {
	
	echo $__licenseexpirymessage;
	exit();
	
}