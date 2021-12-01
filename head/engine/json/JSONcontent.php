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

//`contentID`, `contentname`, `contentimage`, `contentdescrption`, `contentseourl`, `contentmetatitle`, `contentmetakeywords`, `contentmetadescrption`, `contentdesignsettings`, `createdby`, `createdon`, `updatedon`, `status`, `deleted` FROM `js_content`

echo "{";
echo '"data":[';
  $list_parentcontent_datas = sqlQUERY_LABEL("SELECT `contentID`, `contentname`, `status` FROM `js_content` where deleted = '0' {$showcondition} order by contentID DESC") or die("#1-Unable to get records:".mysql_error());

  $count_parentcateogry_list = sqlNUMOFROW_LABEL($list_parentcontent_datas);

  while($row = sqlFETCHARRAY_LABEL($list_parentcontent_datas)){
	  $counter++;
	  $contentID = $row["contentID"];
	  $contentname = html_entity_decode($row["contentname"], ENT_QUOTES, "UTF-8");
	  $status = $row["status"];
	
		   $datas .= "{";	
			   $datas .= '"count": "'.$counter.'",';
			   $datas .= '"contentname": "'.$contentname.'",';
			   $datas .= '"status": "'.$status.'",';
			   $datas .= '"modify": "'.$contentID.'"';
			$datas .= " },";
			
	}
//echo '{"count":"", "contentname":"", "status":"", "modify":"" }';
$data_formatted = substr(trim($datas), 0, -1);
echo $data_formatted;
echo "]}";
?>