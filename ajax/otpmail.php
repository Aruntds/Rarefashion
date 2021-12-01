<?php 

extract($_REQUEST);

include '../head/jackus.php';

// $otpmsg = rand(1000,9999);
ob_start();
	session_start();
	$session_id = session_id();

//echo $otpmsg;
if($type ==''){
	
	
			$arrFields=array('`session_id`','`otp`','`otp_type`','`status`');

			$arrValues=array("$session_id","$otpmsg","2","1");

			if(sqlACTIONS("INSERT","js_otp",$arrFields,$arrValues, '')){
			
				$query= "SELECT * FROM `js_users` where `useremail` = '$email' ";
				
			  $result = sqlQUERY_LABEL($query);
			  $num = sqlNUMOFROW_LABEL($result);
				if($num > 0){
					 $_SESSION['mobile'] = 	$email;
			  while($row = sqlFETCHARRAY_LABEL($result))
				{	
				$customer_name = $row['username'];							
				$customer_email = $row['useremail'];	
				}
			$time = date('jS, M Y, h:i: A');				
			$subject = 'Your Verification OTP is '.$otpmsg;
			$to = $customer_email;// $project_email;//
			$cc = $cc_mail;//info@touchmarkdes.com
			$Bcc = $bcc_mail ; //info@touchmarkdes.com
			$from = "Rarefashion - Forgot Password Request <notification@touchmarkdes.space>";


					$mail_template = '<table style="border:#000000 solid 1px;background:#ffffff" width="599" cellspacing="0" cellpadding="0" border="0" align="center">
					  <tbody>
						<tr>
						  <td style="background: #000;text-align: center;align-content: center;" valign="top" align="center"><img alt="Rarefashion Logo" style="padding:18px 10px 10px;" class="CToWUd" src="'.SEOURL.'assets/images/logo-light.png" width="100" height="50" border="0"></td>
						</tr>
						<tr>
						  <td style="padding: 25px 10px 10px;" valign="top" align="center"><table width="535" cellspacing="0" cellpadding="0" border="0">
							  <tbody>
								<tr>
								  <td valign="top" align="left"><strong style="font-size: 16px;line-height: 30px;padding-bottom: 15px;display: block;">Dear '.$customer_name.',</strong></td>
								</tr>
								<tr>
								  <td valign="top" align="left">Your <span>OTP is</span>  '.$otpmsg.' to confirm <span>your</span> <span>email</span>. <span>OTP</span> is valid for 3 minutes.</td>
								</tr>
								<tr>
								  <td valign="top" align="left">Your <span>OTP Send Time: </span>  '.$time.'</td>
								</tr>
								<tr>
								  <td valign="top" align="left"> For any queries, please contact <a href="touchmarkdes.space/rarefashions/">Rarefashion</a>.<br>
									<br>
									Regards,<br>
									Team <span>Rarefashion</span></td>
								</tr>
								<tr>
								  <td style="padding:0 0 20px 0" valign="top" align="left"><img src="https://i.imgur.com/qe8OmqF.jpg" style="display:block" alt="" class="CToWUd" width="535" height="2" border="0"></td>
								</tr>
								<tr>
								  <td valign="top" align="center"> © 2021. All rights reserved</td>
								</tr>          </tbody>
							</table></td>
						</tr>
						<tr>
						  <td>&nbsp;</td>
						</tr>
					  </tbody>
					</table>';
  // echo $subject,$to,$cc,$bcc,$mail_template;exit();

        if(send_mail($from,$to,$cc,$Bcc,$subject,$mail_template)) {
		  
		   $data = array('status' => 'Success', 'msg' => 'Mail sended' );

       }
	    else {
           if (!send_mail($from,$to,$cc,$Bcc,$subject,$mail_template, false)) {
         
               if (!empty($error)) { echo $error; } 
             }     
           } 
	}else{
		
	$data = array('status' => 'Error', 'msg' => 'Email is InCorrect');
	
	}
}
}

if($type == 'verify'){
	
	$session_id = session_id();		
	$query= "SELECT * FROM `js_otp` where session_id='$session_id' order by otp_ID ASC ";
		// echo $query;
			
	  $result = sqlQUERY_LABEL($query);
	  $num = sqlNUMOFROW_LABEL($result);
		if($num > 0){
	  while($row = sqlFETCHARRAY_LABEL($result))
		{	
		$saved_otp = $row['otp'];							
		}
		}
		//echo $session_id;
		if($saved_otp == $otp){
		  $data = array('status' => 'Success', 'msg' => 'Mail sended' );
		}else{
		$data = array('status' => 'Error', 'msg' => 'Number is InCorrect');
		}
	}


if($type == 'Resetpwd'){
	 
	if($new_pwd == $cnfm_pwd){
		
		$pwd = PwdHash($new_pwd,substr('',0,9));
		
		$arrFields = array('`password`');

		$arrValues = array("$pwd");
		$email = $_SESSION['mobile'];
		$sqlWhere = "useremail = '$email' or user_phone = '$email'";

		if(sqlACTIONS("UPDATE", "js_users", $arrFields, $arrValues, $sqlWhere)){
			
		  $data = array('status' => 'Success', 'msg' => 'Mail sended' );
		} 
	} else {
		$data = array('status' => 'Error', 'msg' => 'Number is InCorrect');
	}
	
}


header('Content-Type: application/json');
echo json_encode($data);
       

?>