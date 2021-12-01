<?php
/*
* JACKUS - An In-house Framework for TDS Apps
*
* Author: Touchmark De` Science Private Limited. 
* https://touchmarkdes.com
* Version 1.0.1
* Copyright (c) 2018 Touchmark De`Science
*
*/

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if($conn == false)
{
	 echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

//0. Basic Query label
function sqlQUERY_LABEL($query) {
	
	global $conn;
	return mysqli_query($conn,$query);
}
function sqlFETCHARRAY_LABEL($query) {
	global $conn; 
	return  mysqli_fetch_array($query,MYSQLI_ASSOC);
}
function sqlERROR_LABEL() {
	global $conn; 
	return  mysqli_error($conn);
}
function sqlNUMOFROW_LABEL($query) {
	global $conn; 
	return mysqli_num_rows($query);
}
function sqlFETCHASSOC_LABEL($query) {
	global $conn; 
	return mysqli_fetch_assoc($query);
}
function sqlREALESCAPESTRING_LABEL($query) {
	global $conn; 
	return mysqli_real_escape_string($conn,$query);
}

function sqlINSERTID_LABEL() {
	global $conn; 
	return mysqli_insert_id($conn);
}

function sqlFETCHROW_LABEL($query) {
	global $conn; 
	return mysqli_fetch_row($query);
}

function sqlFETCHOBJECT_LABEL($query) {

	return mysqli_fetch_object($query);

}

//1. SQL Query
function sqlQUERY($query)
{
	global $conn; 
	if(mysqli_query($conn,$query))
	{
		  return true;
	}
	else
	{
  		  return die(mysqli_error($conn));
		  exit();
	}   
    
}

//2. SQL QUERY + Fetch Array
function sqlRETURNROWSET($query)
{
	
   global $conn; 
   if ($results=sqlQUERY($query))
      {
	   if ($row=mysqli_fetch_array($results))
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
	
   global $conn; 
   $result = sqlQUERY($query);
   while($val = mysqli_fetch_array($result))	
   {
     $row_count = $val['row_count'];
   }
   return $row_count;
}

//4. Get Single Value
function sqlSINGLEVALUE($sqlFrom,$sqlWhere,$getField)
{
	global $conn; 
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
	global $conn; 
    $sqlResult ="";  
	
    if ($sqlAction =="UPDATE")
     {
	 
		foreach($arrFields as $ind=>$field)
		{
			
			$sqlResult = $sqlResult.$field."=".singleQuote($arrValues[$ind],$sqlAction).","; 
		}
		$sqlResult = "UPDATE ".$tableName." SET ".substr($sqlResult,0,strlen($sqlResult)-1); // sub string is used to strip the last como
		$sqlResult =  $sqlResult.", updatedon='".date('Y-m-d H:i:s')."'";
		//echo $sqlResult; exit();
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
	global $conn; 
	$file = fopen ($outFile, "w");
	fwrite($file, $stringValue);
	fclose ($file);  
}  

//7. Single Quote for Updating Records
function singleQuote($value,$sqlAction)
 {
	 global $conn; 
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
