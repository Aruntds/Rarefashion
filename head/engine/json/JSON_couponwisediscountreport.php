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

if($since_from !='' && $since_to !=''){
	$filterby_date = " and DATE(od_date) between '$since_from' and '$since_to'";
}

echo "{";
echo '"data":[';

	$list_datas = sqlQUERY_LABEL("SELECT COUNT(od_discount_promo_ID) AS TOTAL_USED, od_discount_promo_ID, SUM(od_total) AS TOTAL_ORDER_AMT, SUM(od_discount_amount) AS TOTAL_DISCOUNT_AMT FROM `js_shop_order` where deleted = '0' and od_status NOT IN ('7','8') and status = '1' and od_payment_status IN('1', '3') and od_discount_promo_ID !='0' {$filterby_date} GROUP BY od_discount_promo_ID order by od_id desc") or die("Unable to get records:".sqlERROR_LABEL());

	$fetch_list = sqlNUMOFROW_LABEL($list_datas);

	while($fetch_records = sqlFETCHARRAY_LABEL($list_datas)){

		$counter++;		
		$TOTAL_ORDER_AMT = general_currency_symbol.' '.formatCASH($fetch_records['TOTAL_ORDER_AMT']);
		$TOTAL_DISCOUNT_AMT = general_currency_symbol.' '.formatCASH($fetch_records['TOTAL_DISCOUNT_AMT']);
		$AFTER_DISCOUNT_TOTAL = general_currency_symbol.' '.formatCASH($fetch_records['TOTAL_ORDER_AMT'] - $fetch_records['TOTAL_DISCOUNT_AMT']);
		$TOTAL_USED = $fetch_records['TOTAL_USED'];
		$od_discount_promo_ID = $fetch_records['od_discount_promo_ID'];
		$od_discount_promo_code = getPROMCODE_DETAILS($od_discount_promo_ID);

	 	   $datas .= "{";
			   $datas .= '"count": "'.$counter.'",';
			   $datas .= '"od_discount_promo_code": " '.$od_discount_promo_code.'",';
			   $datas .= '"TOTAL_USED": "'.$TOTAL_USED.'",';
			   $datas .= '"TOTAL_ORDER_AMT": "'.$TOTAL_ORDER_AMT.'",';
			   $datas .= '"TOTAL_DISCOUNT_AMT": "'.$TOTAL_DISCOUNT_AMT.'",';
			   $datas .= '"AFTER_DISCOUNT_TOTAL": "'.$AFTER_DISCOUNT_TOTAL.'"';
		   $datas .= "},";
			} //end of while loop

//echo '{"count":"", "categoryname":"", "status":"", "modify":"" }';
$data_formatted = substr(trim($datas), 0, -1);
echo $data_formatted;
echo "]}";

?>