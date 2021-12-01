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
$err = array();

// $amc_email = $validation_globalclass->sanitize(ucwords($_REQUEST['amc_email']));
// $amc_copy_email = $validation_globalclass->sanitize(ucwords($_REQUEST['amc_copy_email']));

if($_GET['type'] == 'vpo_reject')  
{

	  $arrFields=array('`status`','`vpo_reject_reason`');

      $arrValues=array("$status_id","$vpo_reject_reason");

      $sqlWhere= "`vpo_id`=$vpo_id";
        
         if(sqlACTIONS("UPDATE","js_vendorpo",$arrFields,$arrValues,$sqlWhere))
         {   
             //header("Location:emailsettings.php?code=2");    
         }
    
     else {

      $code = '0';
     }
	
}

?>

