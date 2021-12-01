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

echo "{";
echo '"data":[';
  $list_parentcontent_datas = sqlQUERY_LABEL("SELECT * FROM `js_promobanner` where promobannerTYPE ='1' and deleted = '0'") or die("#1-Unable to get records:".mysql_error());

  $count_parentcateogry_list = sqlNUMOFROW_LABEL($list_parentcontent_datas);

  while($row = sqlFETCHARRAY_LABEL($list_parentcontent_datas)){
	  $counter++;
	  $promobannerID = $row["promobannerID"];
	  $promobannerTYPE = $row["promobannerTYPE"];
	  $promobanner_title = $row["promobanner_title"];
	  $promobanner_image = $row["promobanner_image"];
	  $display_order = $row["display_order"];
	  $display_size = $row["display_size"];
	  $display_imagesize = getDISPLAYIMAGESIZE($display_size,'label');
	  $banner_link = $row["banner_link"];
	  $status = $row["status"];
	 
	
		   $datas .= "{";	
			   $datas .= '"count": "'.$counter.'",';
			   $datas .= '"promobanner_title": "'.$promobanner_title.'",';
			   $datas .= '"display_order": "'.$display_order.'",';
			   //$datas .= '"display_imagesize": "'.$display_imagesize.'",';
			   $datas .= '"promobanner_image": "'.$promobanner_image.'",';
			   //$datas .= '"banner_link": "'.$banner_link.'",';
			   $datas .= '"status": "'.$status.'",';
			   $datas .= '"modify": "'.$promobannerID.'"';
			$datas .= " },";
			
	}
//echo '{"count":"", "contentname":"", "status":"", "modify":"" }';
$data_formatted = substr(trim($datas), 0, -1);
echo $data_formatted;
echo "]}";
?>