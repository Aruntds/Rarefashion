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

//1. Stops mysql injection
function filter($data) {

	$data = trim(htmlentities(strip_tags($data)));
	if (get_magic_quotes_gpc())

		$data = stripslashes($data);
	$data = sqlREALESCAPESTRING_LABEL($data);
	return $data;

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
	


//2. Convert String to SEO URL

function EncodeURL($url)

{

$new = strtolower(ereg_replace(' ','_',$url));

return($new);

}



//3. Convert SEO URL to Normal String

function DecodeURL($url)

{

$new = ucwords(ereg_replace('_',' ',$url));

return($new);

}



//4. Remove number of letters from given string

function ChopStr($str, $len) 

{

    if (strlen($str) < $len)

        return $str;



    $str = substr($str,0,$len);

    if ($spc_pos = strrpos($str," "))

            $str = substr($str,0,$spc_pos);



    return $str . "...";

}	



//5. Email Validation

function isEmail($email){

  return preg_match('/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU', $email) ? TRUE : FALSE;

}



//6. Check if username is combination of Alpha-Numeric Table

function isUserID($username)

{

	if (preg_match('/^[a-z\d_]{5,20}$/i', $username)) {

		return true;

	} else {

		return false;

	}

 }	

 

//7. Check the given string as URL or not

function isURL($url) 

{

	if (preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $url)) {

		return true;

	} else {

		return false;

	}

} 



//8. Check two Passwords

function checkPwd($x,$y) 

{

if(empty($x) || empty($y) ) { return false; }

if (strlen($x) < 4 || strlen($y) < 4) { return false; }



if (strcmp($x,$y) != 0) {

 return false;

 } 

return true;

}



//9. Auto-Generate Password

function GenPwd($length = 7)

{

  $password = "";

  $possible = "0123456789bcdfghjkmnpqrstvwxyz"; //no vowels

  

  $i = 0; 

    

  while ($i < $length) { 



    

    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);

       

    

    if (!strstr($password, $char)) { 

      $password .= $char;

      $i++;

    }



  }



  return $password;

}



//10. Password encoding

function PwdHash($pwd, $salt = null)

{

    if ($salt === null)     {

        $salt = substr(md5(uniqid(rand(), true)), 0, SALT_LENGTH);

    }

    else     {

        $salt = substr($salt, 0, SALT_LENGTH);

    }

    return $salt . sha1($pwd . $salt);

}



//11. Getting file extension

function getExtension($str) {



         $i = strrpos($str,".");

         if (!$i) { return ""; } 



         $l = strlen($str) - $i;

         $ext = substr($str,$i+1,$l);

         return $ext;

}



//12. Limit number of words displayed without cutting any word.

function limit_words($string, $word_limit)

{

$words = explode(" ",$string);

return implode(" ",array_splice($words,0,$word_limit));

}

//eg.: $title = limit_words($categories->title,3);



//13. Converting Custom Date to Database Format

function dateformat_database($rawdate) {

	if($rawdate != '' && $rawdate != '0000-00-00') {

		$createdon_timestamp = str_replace('/', '-', $rawdate);

		$customer_createdon = date('Y-m-d', strtotime($createdon_timestamp));

		return $customer_createdon;

	} else {

		return '--';

	}

}



//14. Converting Database Date Format to Custom Date Format

function dateformat_datepicker($rawdate) {

	if($rawdate != '' && $rawdate != '0000-00-00') {

		$createdon_timestamp = str_replace('-', '/', $rawdate);

		$customer_createdon = date('d/m/Y', strtotime($createdon_timestamp));

		return $customer_createdon;

	} else {

		return '--';

	}

}



//15. Show Time stamp.  Eg.: few seconds ago

function time_stamp($session_time) 

{ 
//check if data available
	if($session_time !='' || $session_time =='0000-00-00 00:00:00') {
		$time_difference = time() - $session_time ; 
	
		$seconds = $time_difference ; 
	
		$minutes = round($time_difference / 60 );
	
		$hours = round($time_difference / 3600 ); 
	
		$days = round($time_difference / 86400 ); 
	
		$weeks = round($time_difference / 604800 ); 
	
		$months = round($time_difference / 2419200 ); 
	
		$years = round($time_difference / 29030400 ); 
		if($seconds <= 60)
	
		{
	
			echo"$seconds seconds ago"; 
	
		}
	
		else if($minutes <=60)
	
		{
	
		   if($minutes==1)  { echo"1 minute ago";  } else { echo"$minutes mins ago"; }
	
		}
	
		else if($hours <=24)
	
		{
	
		   if($hours==1) { echo"1 hour ago"; } else { echo"$hours hours ago"; }
	
		}
	
		else if($days <=7)
	
		{
	
		  if($days==1)  { echo"1 day ago"; } else { echo"$days days ago"; }
	
		}
	
		else if($weeks <=4)
	
		{
	
		  if($weeks==1) {  echo"1 week ago"; } else { echo"$weeks weeks ago"; }
	
		}
	
		else if($months <=12)
	
		{
	
		   if($months==1) { echo"1 month ago"; }  else { echo"$months months ago"; }
	
		}
	
		else
	
		{
	
			if($years==1) { echo"1 year ago"; }  else { echo"$years years ago"; }
	
		}
	} else {
		echo 'Never';
	}

}



//16. Convert Cash

function convertCASH($cash) {

	// strip any commas 

	$cash = (0 + str_replace(',', '', $cash));

 

	// make sure it's a number...

	if(!is_numeric($cash)){ return FALSE;}

 

	// filter and format it 

	if($cash>1000000000000){ 

		return round(($cash/1000000000000),2).' T';

	}elseif($cash>1000000000){ 

		return round(($cash/1000000000),2).' B';

	}elseif($cash>1000000){ 

		return round(($cash/1000000),2).' M';

	}elseif($cash>1000){ 

		return round(($cash/1000),2).' K';

	}

 

	return number_format($cash);

}



//17.  Format Currency.  eg.: 1,50,000.00

function formatCASH($amount) {

	return number_format($amount, 2);

}



//18. Remove ste4ing after a substring

function strafter($string, $substring) {

  $pos = strpos($string, $substring);

  if ($pos === false)

   return $string;

  else  

   return(substr($string, $pos+strlen($substring)));

}

//strafter($myvar,',');



//19. Remove string before a substring

function strbefore($string, $substring) {

  $pos = strpos($string, $substring);

  if ($pos === false)

   return $string;

  else  

   return(substr($string, 0, $pos));

} 		



//20. DAY - list from months

function dayLIST_group($choosenMONTH, $choosenYEAR) {

	$month = $choosenMONTH;

	$year = $choosenYEAR;
	for($d=1; $d<=31; $d++)

	{

		$time=mktime(12, 0, 0, $month, $d, $year);          

		if (date('m', $time)==$month)       

			$list[]=date('Y-m-d', $time);

			//$list=date('Y-m-d', $time).'<br />';

	}

	return $list;

}



//21. DAY - list from two dates

function getDatesBetween2Dates($startTime, $endTime) {

	$day = 86400;

	$format = 'Y-m-d';

	$startTime = strtotime($startTime);

	$endTime = strtotime($endTime);

	$numDays = round(($endTime - $startTime) / $day) + 1;

	$days = array();

		

	for ($i = 0; $i < $numDays; $i++) {

		$days[] = date($format, ($startTime + ($i * $day)));

	}

		

	return $days;

}



//22. Get date from date and time



function limit_date($string,$type)

{
	$datetime = explode(" ",$string);

	$date = $datetime[0];

	$time = $datetime[1];

	if($type == 'date'){

	return $date; }

	if($type == 'time'){

	return $time; }
}



//23 Page user protect



function reguser_protect() {

	session_start();

	global $db; 
	global $accessrequest_api;
	
	if (isset($_SESSION['HTTP_USER_AGENT']))
	{
		if ($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT']))
		{
			user_logout();
			exit;
		}
	}
	
	if (!isset($_SESSION['reg_user_id']) && !isset($_SESSION['reg_user_name']) ) 
	{	

		$cookie_user_id  = filter($_COOKIE['reg_user_id']);
		$cookie_user_name  = filter($_COOKIE['reg_user_name']);
		
		$cookie_user_id = $_COOKIE['reg_user_id'];
		
		$hashstring = base64_encode($cookie_user_name.'||'.$cookie_user_id);
		$data_file = $accessrequest_api.'/json_logsessiondata_online.php?token='.$hashstring;

		$readjson = file_get_contents($data_file);
		$received_logsession_data = json_decode($readjson, true);  //Decode JSON
		
		// coookie expiry
		if($received_loging_data['session'] == 'valid') {
			$received_loging_data['ctime'];
			if( (time() - $received_loging_data['ctime']) > 60*60*24*COOKIE_TIME_OUT) {
				user_logout();
			}
		}

	
		 if( !empty($ckey) && is_numeric($_COOKIE['au_id']) && isUserID($_COOKIE['au_name']) && $_COOKIE['au_ckey'] == sha1($ckey)  ) {

			  session_regenerate_id(); //against session fixation attacks.

			  $_SESSION['reg_user_id'] = $_COOKIE['reg_user_id'];

			  $_SESSION['reg_user_name'] = $_COOKIE['reg_user_name'];

			/* query user level from database instead of storing in cookies */	

			  $_SESSION['reg_user_level'] = $_COOKIE['reg_user_level'];

			  $_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
			  
		   } else {

		   user_logout();

		   }

	  }
	  
	}

	function user_logout()

	{
		//global $db;
		global $accessrequest_api;
		session_start();
		ob_start();

		if(isset($_SESSION['reg_user_id']) || isset($_COOKIE['reg_user_id'])) {

			$session_user_id = $_SESSION['reg_user_id'];
			$cookie_user_id = $_COOKIE['reg_user_id'];
			
			$hashstring = base64_encode($session_user_id.'||'.$cookie_user_id);
			$data_file = $accessrequest_api.'/json_logoutdata_online.php?token='.$hashstring;

			$received_logout_data = json_decode($readjson, true);  //Decode JSON
			//print_r($received_loging_data);
			//exit();
		}

		/************ Delete the sessions****************/
		unset($_SESSION['reg_user_id']);
		unset($_SESSION['reg_user_name']);
		unset($_SESSION['reg_outlet_id']);
		unset($_SESSION['reg_user_level']);
		unset($_SESSION['HTTP_USER_AGENT']);
		session_unset();
		session_destroy(); 

		/* Delete the cookies*******************/
		setcookie("reg_user_id", '', time()-60*60*24*COOKIE_TIME_OUT, "/");
		setcookie("reg_user_name", '', time()-60*60*24*COOKIE_TIME_OUT, "/");
		setcookie("reg_user_level", '', time()-60*60*24*COOKIE_TIME_OUT, "/");
		setcookie("reg_user_key", '', time()-60*60*24*COOKIE_TIME_OUT, "/");

		header("Location: index.php?msg=log_out");

	}

	
//24. To get Next 12 months from selected year

	function getEndMonth($year, $month) {
	
	$endmonth_year = Date("Y-m", strtotime("$year-$month +11 Month"));
	
	return $endmonth_year;
	
	}

//28. Generate Site-Key

	function genSITEKEY() {
	
		return strtoupper(md5(uniqid(rand(), true)));
	
	}

//29. Generate Access-Key

	function genACCESSKEY() {
	
		return strtoupper(md5(microtime().rand(1000, 9999)));
	
	}
	
	
//30. SMTP Email

	function smtpmailer($to, $from, $Bcc, $from_name, $subject, $body,$host=NULL,$port=NULL,$password=NULL) { 
		
		if($host == '' || $port == '' || $password == '' || $from == ''){
			$host = 'smtp.gmail.com';
			$password = 'tester@)13';
			$port = '465';
			$from = 'tester.developer@gmail.com';
		}
		 global $error;
		 $mail = new PHPMailer();
		 $mail ->IsSmtp();
		 $mail ->SMTPDebug = 0;
		 $mail ->SMTPAuth = true;
		 $mail ->SMTPSecure = 'ssl';
		 $mail ->Host = $host;
		 $mail ->Port = $port; // or 587;
		 $mail ->IsHTML(true);
		 $mail ->Username = $from;
		 $mail ->Password = $password;
		 $mail ->SetFrom($from, $from_name);
		 $mail->Subject = $subject;
		 $mail->Body = $body;
		 $mail->AddAddress($to);
		 $mail->AddBcc($Bcc);
		// $mail ->addAttachment('../rekhas-logo.gif');
		 if(!$mail->Send()) {
		 $error = 'Mail error: '.$mail->ErrorInfo; 
		 return $error;
		 } else {
		 $error = 'Message sent!';
		 return true;
		 }
	}
	
		
//31. Converting Database Date Format to Custom Date Format

function dateformat_datepickerhypen($rawdate) {

	if($rawdate != '' && $rawdate != '0000-00-00') {

		$createdon_timestamp = str_replace('-', '/', $rawdate);

		$customer_createdon = date('d-m-Y', strtotime($createdon_timestamp));

		return $customer_createdon;

	} else {

		return '--';

	}

}

//32.  get common total-row count
function commonNOOFROWS_COUNT($table_name, $filter_field) {
	
	if($filter_field != '') {
		$filter_field_data = "where ".$filter_field;
	}
	$getcommon_noofrows_count = sqlQUERY_LABEL("select * from $table_name {$filter_field_data}") or die(mysqli_error());
	return sqlNUMOFROW_LABEL($getcommon_noofrows_count);	
	
}

function removenumberFORMATTING($number, $dec_point=null) {
    if (empty($dec_point)) {
        $locale = localeconv();
        $dec_point = $locale['decimal_point'];
    }
    return floatval(str_replace($dec_point, '.', preg_replace('/[^\d'.preg_quote($dec_point).']/', '', $number)));
}

function convertSEOURL($orginalTAG) {
	$seo_strip=strip_tags($orginalTAG,"");
	$seo_name_splchar_removed = preg_replace('/[^A-Za-z0-9\s.\s-]/','',$seo_strip); 	
	$seo_name_removedash = str_replace("-"," ",$seo_name_splchar_removed);
	$seo_name_removedoublespacedash = str_replace("  ","",$seo_name_removedash);
	$seo_name_withdash = strtolower(str_replace(" ","-",$seo_name_removedoublespacedash));
	return $seo_name_withdash;
}

function breadcrumbGENERATOR ($page_module, $action, $show) {
	//all actions performed here
	$stripping_module_name = strbefore($page_module, '.');
	  
	if($action == 'list') {
	  $requested_page_action = 'List';
	} elseif($action == 'add') {
	  $requested_page_action = 'Add';
	} elseif($action == 'edit') {
	  $requested_page_action = 'Edit';
	} elseif($action == 'delete') {
	  $requested_page_action = 'Delete';
	} elseif($action == 'preview') {
	  $requested_page_action = 'Preview';
	} elseif($action == 'step1') {
	  $requested_page_action = 'Product Info';
	} elseif($action == 'step2') {
	  $requested_page_action = 'Image & Video';
	} elseif($action == 'step3') {
	  $requested_page_action = 'Related & Upsell Product';
	} elseif($action == 'step4') {
	  $requested_page_action = 'SEO Settings';
	} elseif($action == 'step5') {
	  $requested_page_action = 'Variants';
	} elseif($action == 'step6') {
	  $requested_page_action = 'Gift Option';
	} else {
	  $requested_page_action = 'List';
	}

	if($show == 'mainPAGE') {
	  return strtoupper($stripping_module_name);
	}

	if($show == 'subPAGE') {
	  return strtoupper($requested_page_action);
	}

	if($show == 'productsubPAGETITLE') {
	  return $requested_page_action;
	}

}

//not used
function breadcrumbTITLE ($page_module) {
	//all actions performed here
	$stripping_module_name = strbefore($page_module, '.');
		 
	return $stripping_module_name;  //$__{module-page-name}title

}

// Currency Format INDIA//

function moneyFormatIndia($num){
        $nums = explode(".",$num);
        if(count($nums)>2 || $num ==0 || $num ==''){
            return "0";
        }else{
        if(count($nums)==1){
            $nums[1]="00";
        }
		if(strlen($nums[1])>2){
			$split_string =  explode(".",number_format($num,2));//substr($nums[1],0,2);
			$dec_val = $split_string[1];
		}else{
			$dec_val = $nums[1];
		}
        $num = $nums[0];
        $explrestunits = "" ;
        if(strlen($num)>3){
            $lastthree = substr($num, strlen($num)-3, strlen($num));
            $restunits = substr($num, 0, strlen($num)-3); 
            $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; 
            $expunit = str_split($restunits, 2);
            for($i=0; $i<sizeof($expunit); $i++){

                if($i==0)
                {
                    $explrestunits .= (int)$expunit[$i].","; 
                }else{
                    $explrestunits .= $expunit[$i].",";
                }
            }
            $thecash = $explrestunits.$lastthree;
        } else {
            $thecash = $num;
        }
        return $thecash.".".($dec_val); 
        }
    }

/// CUSTOMER CREATION VIA API CURL JACKUS 4.0 to Dude TRANSFER DATA ///

	function curl_multiple($url , $data =[]){
		$handle = curl_init();
		curl_setopt($handle, CURLOPT_URL, $url);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($handle, CURLOPT_POST, true);
		curl_setopt($handle, CURLOPT_POSTFIELDS, ['data' => json_encode($data)]);      
		$result = curl_exec($handle);
		if(curl_errno($handle)):
			echo 'Request Error:' . curl_error($handle);
		endif;
		curl_close($handle);
		return $result;
	}
/// CUSTOMER CREATION VIA API CURL JACKUS 4.0 to Dude TRANSFER DATA ///    
// END OF CUrrency format //


	function getUserIpAddr(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
	}
	
	
	function xml_entities($text, $charset = 'Windows-1252'){
    // Debug and Test
    // $text = "test &amp; &trade; &amp;trade; abc &reg; &amp;reg; &#45;";
    // First we encode html characters that are also invalid in xml
    $text = trim(htmlentities($text, ENT_COMPAT, $charset, false));
    $text = sqlREALESCAPESTRING_LABEL($text);
   
    // XML character entity array from Wiki
    // Note: &apos; is useless in UTF-8 or in UTF-16
    $arr_xml_special_char = array("&quot;","&amp;","&apos;","&lt;","&gt;");
   
    // Building the regex string to exclude all strings with xml special char
    $arr_xml_special_char_regex = "(?";
    foreach($arr_xml_special_char as $key => $value){
        $arr_xml_special_char_regex .= "(?!$value)";
    }
    $arr_xml_special_char_regex .= ")";
   
    // Scan the array for &something_not_xml; syntax
    $pattern = "/$arr_xml_special_char_regex&([a-zA-Z0-9]+;)/";
   
    // Replace the &something_not_xml; with &amp;something_not_xml;
    $replacement = '&amp;${1}';
    return preg_replace($pattern, $replacement, $text);
}