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

//conditioning
if(!empty($show)) {
	$showcondition = "and `status`='$show'";
}

//'`productcategory`','`productsku`','`producttitle`','`productdescrption`','`productpropertydescrption`','`productspecialnotes`','`productsellingprice`','`productMRPprice`','`productpurchaseprice`','`productyousaveprice`','`producttax`','`productstockstatus`','`productopeningstock`','`productavailablestock`','`productheight`', '`productheightunit`', '`productwidth`', '`productwidthunit`', '`productdepth`', '`productdepthunit`', '`productweight`', '`productweightunit`','`createdby`','`status`'

echo "{";
echo '"data":[';
//echo"SELECT `productID`, `productsku`, `producttitle`, `productsellingprice`, `productMRPprice`, `productstockstatus`, `productopeningstock`, `productavailablestock`, `status` FROM `js_product` where deleted = '0' order by productID DESC";exit();
  $list_product_datas = sqlQUERY_LABEL("SELECT `productID`, `productsku`, `producttitle`, `productsellingprice`, `productMRPprice`, `productstockstatus`, `productopeningstock`, `productavailablestock`, `status` FROM `js_product` where deleted = '0' order by productID  ASC") or die("#1-Unable to get records:".mysql_error());

  $count_product_list = sqlNUMOFROW_LABEL($list_product_datas);

  while($row = sqlFETCHARRAY_LABEL($list_product_datas)){
	  $counter++;
	  $productID = $row["productID"];
	  $productsku = $row["productsku"];
	  $producttitle = html_entity_decode(trim($row["producttitle"]), ENT_QUOTES, "UTF-8");
	  //$producttitle = $validation_globalclass->sanitize($producttitle); //html_entity_decode($row["producttitle"], ENT_QUOTES, "UTF-8");
	  $producttitle = trim(preg_replace('/\s\s+/', ' ', str_replace("<br />",'\n', $producttitle)));
	 $producttitle = trim(str_replace("\'","'",$producttitle));
	 
	// echo $producttitle;
	   $productsellingprice = general_currency_symbol.' '.moneyFormatIndia($row["productsellingprice"]);
	  $productMRPprice = general_currency_symbol.' '.moneyFormatIndia($row["productMRPprice"]);
	  // $productsellingprice = formatCASH($row["productsellingprice"]);
	  // $productMRPprice = formatCASH($row["productMRPprice"]);
	  $productopeningstock = $row["productopeningstock"];
	  $productavailablestock = $row["productavailablestock"];
	  $productstockstatus = $row["productstockstatus"];  //stock status
	  $status = $row["status"];  //product status	  
	  	
		   $datas .= "{";	
			   $datas .= '"count": "'.$counter.'",';
			   $datas .= '"productsku": "'.$productsku.'",';
			   $datas .= '"producttitle": "'.$producttitle.'",';
			   $datas .= '"productsellingprice": "'.$productsellingprice.'",';
			   $datas .= '"productMRPprice": "'.$productMRPprice.'",';
			   $datas .= '"productstockstatus": "'.$productstockstatus.'",';
			   //$datas .= '"productopeningstock": "'.$productopeningstock.'",';
			   $datas .= '"productavailablestock": "'.$productavailablestock.'",';
			   $datas .= '"status": "'.$status.'",';
			   $datas .= '"modify": "'.$productID.'"';
			$datas .= " },";
			
	}
//echo '{"count":"", "contentname":"", "status":"", "modify":"" }';
$data_formatted = substr(trim($datas), 0, -1);
echo $data_formatted;
echo "]}";
?>