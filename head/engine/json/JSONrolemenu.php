<?php

/*
* JACKUS - An In-house Framework for TDS Apps
*
* Author: Touchmark Descience Private Limited. 
* https://touchmarkdes.com
* Version 1.0.1
* Copyright (c) 2018-2019 Touchmark De`Science
*
*/

extract($_REQUEST);

include_once('../../jackus.php');

echo "{";

echo '"data":[';

//billID`, `cusID`, `billrefno`, `billqty`, `billdate`, `billdeliverydate`, `billdeliveredon`, `billmodeone`, `billmodetwo`, `billsubtotal`, `billdiscount`, `billdiscountvalue`, `billtotal`, `billpaidone`, `billpaidtwo`, `billbalance`, `billmemo`, `billsession`, `createdby`, `createdon`, `updatedon`, `status`, `deleted`

	$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_rolemenu` where deleted = '0' order by role_ID desc") or die("Unable to get records:".sqlERROR_LABEL());

	$fetch_list = sqlNUMOFROW_LABEL($list_datas);

	while($fetch_records = sqlFETCHARRAY_LABEL($list_datas)){

	
		$counter++;
		$role_ID = $fetch_records['role_ID'];
		$role_name = $fetch_records['role_name'];
		$status = $fetch_records['status'];
		
//		
	   echo "{";

	   echo '"count": "'.$counter.'",';
	   
	   echo '"role_name": "'.$role_name.'",';
	   
	   echo '"status": "'.$status.'",';
	  
		echo '"modify": "'.$role_ID.'"';

	if ($counter > 0 && $counter != $fetch_list) {

			   echo " },";

			} else {

			   echo " }";

			}

	
		}
	

echo "]}";



?>