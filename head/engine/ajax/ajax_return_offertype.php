<?php 

extract($_REQUEST);

include_once('../../jackus.php');


		$cart_product = sqlQUERY_LABEL("SELECT offers_type FROM `js_offers` where offers_id='$offer_id' and deleted = '0' and status != '3'") or die("#1-Unable to get records:". sqlERROR_LABEL());

			 while($getstatus_fetch = sqlFETCHARRAY_LABEL($cart_product)) {
					$offers_type = $getstatus_fetch['offers_type'];
 			 }	 
echo $offers_type;
	
	

// header('Content-Type: application/json');
// echo json_encode($data);
?>