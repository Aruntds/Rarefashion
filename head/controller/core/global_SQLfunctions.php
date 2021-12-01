<?php
/*
* JACKUS - An In-house Framework for TDS Apps
*
* Author: Touchmark Descience Private Limited. 
* https://touchmarkdes.com
* Version 4.0.1
* Copyright (c) 2018-2019 Touchmark Descience Pvt Ltd
*
*/

$con=mysql_connect (DB_HOST, DB_USER, DB_PASSWORD);

if (!$con)
{
	echo "<font color=red face=verdane size=3>Mysql Connection Cannot Be Established</font>";
    //echo "<meta http-equiv=refresh content=0;url=".$curr_http_path."/?pgid=sys_error>";
}
else
{
	if(!mysql_select_db (DB_NAME, $con))
	{	   echo "<font color=red face=verdane size=3>Database Cannot Be Found</font>";

	   //echo "<meta http-equiv=refresh content=0;url=".$curr_http_path."/?pgid=sys_error>";
	}	
}

	function send_mail($from,$to,$cc,$bcc,$subject,$mail_template){
		//$cc = "mohan";
		
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headers .= "From:$from \r\n";
		$headers .= "Reply-To: $from\r\n";
		$headers .= "X-Priority: 1\r\n";
		$headers .= "X-MSMail-Priority: High\r\n";
		$headers .= "Cc: $cc\r\n";
		$headers .= "Bcc: $bcc\r\n";	
		
		$sending_email = mail($to,$subject,$mail_template,$headers);
		
		if($sending_email)
		{
		  //echo "Success: Message sent";  
		  return true;
		}
		else
		{ 
		  echo "Error: unable to send email";
		  return false;
		}
	} 
	


//0. Basic Query label
function sqlQUERY_LABEL($query) {
	return mysql_query($query);
}
function sqlFETCHARRAY_LABEL($query) {
	return mysql_fetch_array($query);
}
function sqlNUMOFROW_LABEL($query) {
	return mysql_num_rows($query);
}
function sqlERROR_LABEL() {
	return mysql_error();
}
function sqlFETCHOBJECT_LABEL($query) {

	return mysql_fetch_object($query);

}
//1. SQL Query
function sqlQUERY($query)
{
	
	if(mysql_query($query))
	{
		  return true;
	}
	else
	{
  		  return die(mysql_error());
		  exit();
	}   
    
}

//2. SQL QUERY + Fetch Array
function sqlRETURNROWSET($query)
{
   if ($results=sqlQUERY($query))
      {
	   if ($row=mysql_fetch_array($results))
		  { 
		  
		   return $row;
		  }
	  } else { 
		  return $results;
	  }
}  //$row = return_row_set($query);

//3. SQL Total Row Count
function sqlROWCOUNT($query)
{
   $result = sqlQUERY($query);
   while($val = mysql_fetch_array($result))	
   {
     $row_count = $val['row_count'];
   }
   return $row_count;
}

//4. Get Single Value
function sqlSINGLEVALUE($sqlFrom,$sqlWhere,$getField)
{
   $tmp_val="";
   $query ="SELECT ".$getField." FROM ".$sqlFrom." WHERE ".$sqlWhere;
   $row = sqlRETURNROWSET($query);
   if(empty($row)) { return ""; }
   $tmp_val = $row[$getField];
   if(empty($tmp_val))
     {
	     return "";
	 }
	 else
	 {
	     return $tmp_val; 
	 }
}

//5. INSERT || UPDATE || DELETE || SELECT Query
function sqlACTIONS($sqlAction,$tableName,$arrFields="",$arrValues="",$sqlWhere="")
{

    $sqlResult ="";  
    if ($sqlAction =="UPDATE")
     {
		foreach($arrFields as $ind=>$field)
		{
			$sqlResult = $sqlResult.$field."=".singleQuote($arrValues[$ind],$sqlAction).","; 
		}
		$sqlResult = "UPDATE ".$tableName." SET ".substr($sqlResult,0,strlen($sqlResult)-1); // sub string is used to strip the last como
		$sqlResult =  $sqlResult.", updatedon='".date('Y-m-d H:i:s')."'";
		
	 } //End of Update
	 
	 if ($sqlAction =="INSERT")
     {
	      $tmpField = "";
		  $tmpValue = ""; 
		  foreach($arrFields as $ind=>$field)
		  {
			     if(!empty($arrValues[$ind]) && trim($arrValues[$ind]) != "")
				   {
				    $tmpField = $tmpField.", ".$field;
			        $tmpValue = $tmpValue.", ".singleQuote($arrValues[$ind],$sqlAction);
				   }
		  }
		  $sqlResult = "INSERT INTO `".$tableName. "` ( ".substr($tmpField,1).", `updatedon`, `createdon` ) VALUES (".substr($tmpValue,1).",'".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."')"; 

	 }  //End of Insert
	 
	 if ($sqlAction =="DELETE")
     {	     
		   $sqlResult = "DELETE FROM ".$tableName."";
	 }//End of Delete
	 
	 if ($sqlAction =="SELECT")
     {	     
	 	$retfields="*";
	 	if(is_array($arrFields))
	 		$retfields=implode(",",$arrFields);

		   $sqlResult = "SELECT * FROM ".$tableName."";
		   
		if ($result=sqlQUERY($sqlResult)) // executs the SQl query and give result.
	    {
	      return true;
	    } 
		   
	 }
	 
	 if(!empty($sqlWhere))
	   {
	  $sqlResult = $sqlResult." WHERE ".$sqlWhere;		   		   		   
	   } 
	 
	 writeFile($sqlResult,"sqlQuery.txt"); 

	 if (sqlQUERY($sqlResult)) // executs the SQl query and give result.
	    {		  
	      return true;
	    }   
		else
		{
		   return false;
		}    	 
 }
 
//6. write into text file 
function writeFile($stringValue,$outFile)
{ 
	$file = fopen ($outFile, "w");
	fwrite($file, $stringValue);
	fclose ($file);  
}  

//7. Single Quote for Updating Records
function singleQuote($value,$sqlAction)
 {
 	//$value = htmlentities(addslashes(trim($value)));
    $value = htmlentities($value);
	 if ($sqlAction =="UPDATE")
     {
	    if(substr($value,0,1)=='[') { return substr($value,1,strlen($value)-2); } else { return $value = " '".$value."'";}
	 }
	 else
	 {
		if(!empty($value) && trim($value) != "")
		{	 	  
		  if(substr($value,0,1)=='[') { return substr($value,1,strlen($value)-2); } else { return $value = " '".$value."'";}
		}
     }      
 }
 
 function get_percentage($total, $number)
{
  if ( $total > 0 ) {
   return round($number * ($total / 100),2);
  } else {
	return 0;
  }
}

function progress_Bar($maximum_value)
{
	if($maximum_value >= 75){
		echo "bg-success progress-bar-striped progress-bar-animated";
	} else if($maximum_value >= 50 && $maximum_value < 75) {
		echo "bg-info progress-bar-striped progress-bar-animated";
	} else if($maximum_value >= 25 && $maximum_value < 50) {
		echo "bg-warning progress-bar-striped progress-bar-animated";
	} else {
		echo "bg-danger progress-bar-striped progress-bar-animated";
	}
}