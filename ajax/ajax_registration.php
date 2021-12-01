<?php 

extract($_REQUEST);

include '../head/jackus.php';


$pwd = PwdHash($pwd,substr($password,0,9));


$check_use_email = commonNOOFROWS_COUNT('js_users', "useremail = '$email' and status = '1' and deleted ='0'");

if($check_use_email == 0){
	
	$username = strbefore($email, '@');
	
$arrFields=array('`username`','`useremail`','`password`','`userapproved`','`roleID`','`status`');

$arrValues=array("$username","$email","$pwd","1","1","1");

if(sqlACTIONS("INSERT","js_users",$arrFields,$arrValues, $sqlWhere)){

             $id = sqlINSERTID_LABEL();
				   
			$arrFields=array('`customergroup`','`user_id`','`customerfirst`','`customeremail`','`customerphone`', '`status`','`createdby`');

			$arrValues=array("","$id","$username","$email", "","1","0");
			sqlACTIONS("INSERT","js_customer",$arrFields,$arrValues, '');
			
				   
			$subject = 'Registered Successfully';
			$to = $email;// $project_email;//
			$cc = 'mohan@touchmarkdes.com';//info@touchmarkdes.com
			$Bcc = ''; //info@touchmarkdes.com
			$from = "RareFashion - Registeration <notification@touchmarkdes.space>";
			 
			$mail_template = '<table style="border:#000000 solid 1px;background:#ffffff" width="599" cellspacing="0" cellpadding="0" border="0" align="center">
  <tbody>
    <tr>
      <td style="background: #000;text-align: center;align-content: center;" valign="top" align="center"><img alt="RareFashion Logo" style="padding:18px 10px 10px;" class="CToWUd" src="'.SEOURL.'assets/images/logo-light.png" height="50" border="0"></td>
    </tr>
    <tr>
      <td style="padding: 25px 10px 10px;" valign="top" align="center"><table width="535" cellspacing="0" cellpadding="0" border="0">
          <tbody>
            <tr>
              <td valign="top" align="left"><strong style="font-size: 16px;line-height: 30px;padding-bottom: 15px;display: block;">Hello ,'.$username.'</strong></td>
            </tr>
            <tr>
              <td valign="top" align="left">Succesfully you have registered in RareFashion. </td>
            </tr>
            <tr>
              <td valign="top" align="left"> For any queries, please contact Our Team RareFashion<br>
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
    echo '0';
	die;
}else{
	
	
	echo '1';
	die;
}

?>
