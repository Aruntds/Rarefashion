<?php 

extract($_REQUEST);

include 'head/jackus.php';

if($to ==''){
//echo $mobile_number; 
	$query= "SELECT * FROM `js_users` where useremail='$email' and deleted='0'";
				// echo $query;
		$result = sqlQUERY_LABEL($query);
			 while($row = sqlFETCHARRAY_LABEL($result))
				{	
				$username = $row['username'];							
					
				}
				if($username==''){$username ='user';}
$subject = 'Your Verification OTP is '.$otpmsg;
$to = $email;// $project_email;//
$cc = $cc_mail;//info@touchmarkdes.com
$Bcc = $bcc_mail; //info@touchmarkdes.com
$from = "RareFashion - Login Request <".$from_mail.">";


$mail_template = '<table style="border:#000000 solid 1px;background:#ffffff" width="599" cellspacing="0" cellpadding="0" border="0" align="center">
  <tbody>
    <tr>
      <td style="background: #000;text-align: center;align-content: center;" valign="top" align="center"><img alt="RareFashion Logo" style="padding:18px 10px 10px;" class="CToWUd" src="'.SEOURL.'assets/images/logo-light.png" height="50" border="0"></td>
    </tr>
    <tr>
      <td style="padding: 25px 10px 10px;" valign="top" align="center"><table width="535" cellspacing="0" cellpadding="0" border="0">
          <tbody>
            <tr>
              <td valign="top" align="left"><strong style="font-size: 16px;line-height: 30px;padding-bottom: 15px;display: block;">Dear '.$username.',</strong></td>
            </tr>
            <tr>
              <td valign="top" align="left">Your <span>OTP is</span>  '.$otpmsg.' to confirm <span>your</span> <span>email</span>. <span>OTP</span> is valid for 10 minutes.</td>
            </tr>
            <tr>
              <td valign="top" align="left"> For any queries, please contact<br>
                <br>
                Regards,<br>
                Team <span>RareFashion</span></td>
            </tr>
            <tr>
              <td style="padding:0 0 20px 0" valign="top" align="left"><img src="https://i.imgur.com/qe8OmqF.jpg" style="display:block" alt="Seprator image" class="CToWUd" width="535" height="2" border="0"></td>
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


 //echo $from,$to,$cc,$Bcc,$subject,$mail_template; exit();
      if(send_mail($from,$to,$cc,$Bcc,$subject,$mail_template)) {
      } else {
         if (!send_mail($from,$to,$cc,$Bcc,$subject,$mail_template, false)) {
         
           if (!empty($error)) { echo $error; } 
          }     
        } 
}
?>