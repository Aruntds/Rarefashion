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

if($filter_customer !='' && $filter_customer !='0'){
	$filter_by_customer = " and user_id = '$filter_customer' ";
}

if($since_from !='' && $since_to !=''){
	$filterby_date = " and DATE(B.createdon) between '$since_from' and '$since_to'";
}
echo "{";
echo '"data":[';

	$list_datas = sqlQUERY_LABEL("SELECT A.user_id as USER_ID, A.customerID as CUSID, A.customerfirst as CUS_FIRST, COUNT(A.user_id) as COUNT_USER, SUM(B.od_total) as OD_TOTAL, B.od_discount_type as OD_DIS FROM js_customer A, js_shop_order B WHERE A.user_id = B.od_userid {$filter_by_customer} {$filterby_date} GROUP BY A.user_id") or die("Unable to get records:".sqlERROR_LABEL());

	$fetch_list = sqlNUMOFROW_LABEL($list_datas);

	while($row = sqlFETCHARRAY_LABEL($list_datas)){
			
	  $counter++;
	  $customerid = $row["CUSID"];
	  $customers_name = $row["CUS_FIRST"];
	  $customerorder = $row["COUNT_USER"];
	  $customersales = general_currency_symbol.' '.formatCASH($row["OD_TOTAL"]);
	  $customerdiscount =  $row["OD_DIS"];
	  
		   $datas .= "{";
			   $datas .= '"count": "'.$counter.'",';
			   $datas .= '"customers_name": "'.$customers_name.'",';
			   $datas .= '"customerorder": "'.$customerorder.'",';
			   $datas .= '"customersales": "'.$customersales.'",';
			   $datas .= '"customerdiscount": "'.$customerdiscount.'"';
		   $datas .= "},";
			} //end of while loop

//echo '{"count":"", "categoryname":"", "status":"", "modify":"" }';
$data_formatted = substr(trim($datas), 0, -1);
echo $data_formatted;
echo "]}";

?>