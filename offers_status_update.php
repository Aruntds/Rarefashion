<?php 
	include 'head/jackus.php'; 

   $list_parentcategory_datas = sqlQUERY_LABEL("SELECT * FROM `js_offers` where deleted = '0' and status!='3' order by offers_id DESC") or die("#1-Unable to get records:".mysql_error());

   $count_parentcateogry_list = sqlNUMOFROW_LABEL($list_parentcategory_datas);

   while($row = sqlFETCHARRAY_LABEL($list_parentcategory_datas)){
	 
	  $counter++;
	  $offers_id = $row["offers_id"];
	  $offers_name = $row["offers_name"];
 	  $offers_type = $row["offers_type"];
	  $status = $row["status"];
	  $offer_status = $row["offer_status"];
	  $offers_expiry_date = $row["offers_expiry_date"];
	  $offers_start_date = $row["offers_start_date"]; 
	  $expiry_date = dateformat_datepicker($offers_expiry_date);
	  $start_date = dateformat_datepicker($offers_start_date);
		   $start_date = date_create($offers_start_date);
		    
			$start_date = date_format($start_date,"d/m/Y H:i");
			$expiry_date = date_create($offers_expiry_date);
		    
			$expiry_date = date_format($expiry_date,"d/m/Y H:i");

	  $current_date =  date('Y-m-d H:i'); 
	  
	  
	  if($offer_status =='1'){
		  if($offers_start_date > $current_date)  {
			  
			  
			$arrFields=array('`status`');
			$arrValues=array("1");
			$sqlWhere= "offers_id='$offers_id'";
			
			if(sqlACTIONS("UPDATE","js_offers",$arrFields,$arrValues, $sqlWhere)) {
				  
					$arrFields1 =array('`status`');
					$arrValues1 =array("1");
					$sqlWhere= "offers_id='$offers_id'";
					
				if(sqlACTIONS("UPDATE","js_offers_items",$arrFields1,$arrValues1, $sqlWhere)) {
					echo "Updated Upcoming Offer's Product";
				}
			}
			
		  }elseif(($offers_expiry_date > $current_date) || ($offers_expiry_date == $current_date)) {
			  
			$arrFields=array('`status`');
			$arrValues=array("2");
			$sqlWhere= "offers_id='$offers_id'";
			
			if(sqlACTIONS("UPDATE","js_offers",$arrFields,$arrValues, $sqlWhere)) {
				  
					$arrFields1 =array('`status`');
					$arrValues1 =array("2");
					$sqlWhere= "offers_id='$offers_id'";
					
				if(sqlACTIONS("UPDATE","js_offers_items",$arrFields1,$arrValues1, $sqlWhere)) {
					echo "Updated On sale Offer's Product";
				}
			}
			
		  }else{
			  
			$arrFields=array('`status`');
			$arrValues=array("3");
			$sqlWhere= "offers_id='$offers_id'";
			
			if(sqlACTIONS("UPDATE","js_offers",$arrFields,$arrValues, $sqlWhere)) {
				  
					$arrFields1 =array('`status`');
					$arrValues1 =array("3");
					$sqlWhere= "offers_id='$offers_id'";
					
				if(sqlACTIONS("UPDATE","js_offers_items",$arrFields1,$arrValues1, $sqlWhere)) {
					echo "Updated Expired Offer's Product";
					
					$arrFields2 =array('`status`');
					$arrValues2 =array("0");
					$sqlWhere2 = "banner_offertype='$offers_id'";
					if(sqlACTIONS("UPDATE","js_promobanner",$arrFields2,$arrValues2, $sqlWhere2)) {
						
					}
					
				}
			}
			
		  }
	  }
  }
?>
