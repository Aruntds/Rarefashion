<?php
extract($_REQUEST);
include_once('../head/jackus.php');

$return_arr = array();

$fetch = sqlQUERY_LABEL("SELECT productID,producttitle, productsku  FROM js_product WHERE producttitle='$productinfo' and status = '1' and deleted ='0' LIMIT 0,10"); 

 if(sqlNUMOFROW_LABEL($fetch)) {
	while ($row = sqlFETCHARRAY_LABEL($fetch, MYSQL_ASSOC)) {
		$productID = $row['productID'];
		$producttitle = $row['producttitle'];
		$token = $row['productsku'];
		
		echo SEOURL.'product.php?token='.$productID.'-'.$token;
	} 
} 

// header('Content-Type: application/json');
// echo json_encode($data);

?>