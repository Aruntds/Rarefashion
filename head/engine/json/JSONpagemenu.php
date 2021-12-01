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

	$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_pagemenu` where deleted = '0' order by page_ID desc") or die("Unable to get records:".sqlERROR_LABEL());

	$fetch_list = sqlNUMOFROW_LABEL($list_datas);

	while($fetch_records = sqlFETCHARRAY_LABEL($list_datas)){

	
		$counter++;
		$page_ID = $fetch_records['page_ID'];
		$parent_ID = getParentmenu($fetch_records['parent_ID'],'label');
		if($parent_ID  == ''){ $parent_ID = '--';}
		$menu_title = $fetch_records['menu_title'];
		$page_name = $fetch_records['page_name'];
		if($page_name  == ''){ $page_name = '--';}
		$page_type = pageTYPE($fetch_records['page_type'],'label');
		if($page_type  == '' && $fetch_records['parent_ID']  == '0' ){ $page_type = 'Main Menu';}
		$sidebar_display = $fetch_records['sidebar_display'];
		if($sidebar_display == '1'){
			$sidebar_display = 'Yes';
		}else{
			$sidebar_display = 'No';
		}
		$status = $fetch_records['status'];
		
//		
	   echo "{";

	   echo '"count": "'.$counter.'",';
	   
	   echo '"menu_title": "'.$menu_title.'",';

	   echo '"page_type": "'.$page_type.'",';

	   echo '"page_name": "'.$page_name.'",';
	   
	   echo '"sidebar_display": "'.$sidebar_display.'",';
	   
	   echo '"Parent": "'.$parent_ID.'",';
		
	   echo '"status": "'.$status.'",';
	  
		echo '"modify": "'.$page_ID.'"';

	if ($counter > 0 && $counter != $fetch_list) {

			   echo " },";

			} else {

			   echo " }";

			}

	
		}
	

echo "]}";



?>