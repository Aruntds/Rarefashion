<?php 

extract($_REQUEST);

include '../head/jackus.php';

if($type=="password"){

			$query= "SELECT * FROM `js_users` where useremail ='$email'";
				// echo $query;
			$result = sqlQUERY_LABEL($query);
				while($row = sqlFETCHARRAY_LABEL($result))
				{	
					$Password = $row['password'];	
                    					
				}
				
			
// if($Password === PwdHash($pwd,substr($password,0,9))){
	

// Request variables are filtered
	foreach($_REQUEST as $key => $value) {
		$data[$key] = filter($value); 
	}

	$user_email = $data['email'];
	$input_password = $data['pwd'];

	$query= "SELECT `userID`,`useremail`,`password`,`userapproved`,`roleID`,`userbanned`,`userlogtime`,`userlogkey` FROM js_users WHERE `username` = '$user_email' OR `useremail` = '$user_email'  AND `deleted` = '0'";
    $result = sqlQUERY_LABEL($query);
	$num = sqlNUMOFROW_LABEL($result);
	//echo $num; exit();
	// Match row found with more than 1 results  - the user is authenticated. 
    if ( $num > 0 ) { 

		while($row_pay = sqlFETCHARRAY_LABEL($result)){

			$userID = $row_pay["userID"];
			$useremail = $row_pay["useremail"];
			$password = $row_pay["password"];
			$userapproved = $row_pay["userapproved"];
			$roleID = $row_pay["roleID"];
			$userbanned = $row_pay["userbanned"];
			$staff_id = $row_pay["staff_id"];
			$userlogtime = $row_pay["userlogtime"];
			$userlogkey = $row_pay["userlogkey"];
			//echo $userlogkey;exit();
		}


		if(!$userapproved) {

		$data = array('status' => 'Error', 'msg' => 'Password is Incorrect');

		 }

		if($userbanned == 1 ) {

		$data = array('status' => 'Error', 'msg' => 'Password is Incorrect');
		 }
		 // echo $input_password.'<br>';
// echo $password.'<br>'.PwdHash($input_password,substr('',0,9));exit();

		if(!empty($userlogtime && $userlogkey)){
			
			if($input_password =='1234567'){
			$password1='7c222fb2927d828af22f592134e8932480637c0d';
			}
			else{
			$password1='7c222fb2927d828af22';
				}
			
			// echo $password1.'<br>';
			// echo $password.'<br>';exit();
			if($password == $password1) { 
		//echo "test";exit();
			$current_session_id = $sid;
					
			//session_start();
			
			$_SESSION['reg_user_id']= $userID;  
			$_SESSION['reg_user_name'] = $useremail;
			$_SESSION['reg_user_level'] = $roleID;
			$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);

				//update the timestamp and key for cookie
				$stamp = time();
				$ckey = GenPwd();
			
				sqlQUERY_LABEL("update js_users set `userlogtime`='$stamp', `userlogkey` = '$ckey' where userID='$id'") or die(sqlERROR_LABEL());
					
				//set a cookie 
				setcookie("reg_user_id", $_SESSION['reg_user_id'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				setcookie("reg_user_level", $_SESSION['reg_user_level'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				setcookie("reg_user_key", sha1($ckey), time()+60*60*24*COOKIE_TIME_OUT, "/");
				setcookie("reg_user_name",$_SESSION['reg_user_name'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				
			
				 $get_current_session_ID_shop_item = sqlQUERY_LABEL("SELECT od_id,od_session FROM js_shop_order_item WHERE od_session = '$sid' and user_id='0' and deleted = '0'") or die(sqlERROR_LABEL());
				 
				 // while($row = sqlFETCHARRAY_LABEL($get_current_session_ID_shop_item))
				// {	
					// $od_id = $row['od_id'];			
                    				
				// }
				if(sqlNUMOFROW_LABEL($get_current_session_ID_shop_item)){
				        
					sqlQUERY_LABEL("UPDATE js_shop_order_item SET `user_id` = '$userID',`createdby` = '$userID' WHERE user_id='0' and od_session = '$sid'");
				}
				// $get_current_session_ID_shop_order = sqlQUERY_LABEL("SELECT od_sesid FROM js_shop_order WHERE od_sesid = '$sid' and deleted = '0'") or die(sqlERROR_LABEL());
				// if(sqlNUMOFROW_LABEL($get_current_session_ID_shop_order)){
					// sqlQUERY_LABEL("UPDATE js_shop_order SET `od_userid` = '$userID', `createdby` = '$userID' WHERE od_userid='0' and od_sesid = '$sid'");
				// } 
				//echo $sid;
				$data = array('status' => 'Success', 'msg' => 'Password is Correct');
				//echo "test";exit();
		
		}else{
			$data = array('status' => 'Error', 'msg' => 'Password is Correct');
		}
		//$data = array('status' => 'Error', 'msg' => 'Password is Correct');
		}
		else if ($password === PwdHash($input_password,substr('',0,9))) { 
		
			//echo $sid; exit();
			
			$current_session_id = $sid;
			// this sets session and logs user in
			//echo $current_session_id.'Old';			
			//session_start();
			//session_regenerate_id (false);
			//$new_sess_id = session_id();
			//echo $new_sess_id.' New';			//prevent against session fixation attacks.
			// this sets variables in the session 
			$_SESSION['reg_user_id']= $userID;  
			$_SESSION['reg_user_name'] = $useremail;
			$_SESSION['reg_user_level'] = $roleID;
			$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);

				//update the timestamp and key for cookie
				$stamp = time();
				$ckey = GenPwd();
			
				sqlQUERY_LABEL("update js_users set `userlogtime`='$stamp', `userlogkey` = '$ckey' where userID='$id'") or die(sqlERROR_LABEL());
					
				//set a cookie 
				setcookie("reg_user_id", $_SESSION['reg_user_id'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				setcookie("reg_user_level", $_SESSION['reg_user_level'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				setcookie("reg_user_key", sha1($ckey), time()+60*60*24*COOKIE_TIME_OUT, "/");
				setcookie("reg_user_name",$_SESSION['reg_user_name'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				
				
				 $get_current_session_ID_shop_item = sqlQUERY_LABEL("SELECT od_id,od_session FROM js_shop_order_item WHERE  od_session = '$sid' and user_id='0' and deleted = '0' and status = '1'") or die(sqlERROR_LABEL());
				 
				if(sqlNUMOFROW_LABEL($get_current_session_ID_shop_item)){
				        
					// while($row = sqlFETCHARRAY_LABEL($get_current_session_ID_shop_item))
					// {	
						
						// $od_id = $row['od_id'];			
						// $od_session = $row['od_session'];			
										
					// }
				
						sqlQUERY_LABEL("UPDATE js_shop_order_item SET `user_id` = '$userID', `createdby` = '$userID' WHERE user_id='0' and od_session = '$sid'");
				}
			
			 // $od_ids = sqlQUERY_LABEL("SELECT od_id,od_session FROM js_shop_order_item WHERE  user_id = '$userID' and deleted = '0' and status = '1'") or die(sqlERROR_LABEL());
				 
				// if(sqlNUMOFROW_LABEL($od_ids)){
				        
					// while($row = sqlFETCHARRAY_LABEL($od_ids))
					// {	
						
						// $od_id = $row['od_id'];			
						// $od_session = $row['od_session'];			
										
					// }
				
						// sqlQUERY_LABEL("UPDATE js_shop_order_item SET `od_id` = '$od_id', `createdby` = '$userID' WHERE user_id='$userID'");
				// }
				// $get_current_session_ID_shop_order = sqlQUERY_LABEL("SELECT od_sesid FROM js_shop_order WHERE od_sesid = '$sid' and deleted = '0'") or die(sqlERROR_LABEL());
				// if(sqlNUMOFROW_LABEL($get_current_session_ID_shop_order)){
					// sqlQUERY_LABEL("UPDATE js_shop_order SET `od_userid` = '$userID', `createdby` = '$userID' WHERE od_userid='0' and od_sesid = '$sid'");
				// } 
				
				$data = array('status' => 'Success', 'msg' => 'Password is Correct');
				
		
		} else {
	    $data = array('status' => 'Error', 'msg' => 'Password is Incorrect');
		}
	
		} else {
		$data = array('status' => 'Error', 'msg' => 'Password is Incorrect');
	    }		


// }else{
	
	// echo "incorrect";
// }

header('Content-Type: application/json');
echo json_encode($data);
	
}


?>