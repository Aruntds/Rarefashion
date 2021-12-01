<?php 
extract($_REQUEST);

include '../../jackus.php';

		if($order_note_type == '1'){
			
			$description = "Order Notes Added for Private";
			
		} if($order_note_type == '2'){
			
			$description = "Order Notes Added for Customer";
			$od_user_id = getSINGLEDBVALUE('od_userid',"od_id='$id'",'js_shop_order','label');
			$customer_name = getSINGLEDBVALUE('customerfirst',"user_id='$od_user_id'",'js_customer','label');
					
			$subject = 'Order Notes ';
			$to = $customer_email;// $project_email;//
			$cc = 'mohan@touchmarkdes.com';//info@touchmarkdes.com
			$Bcc = ''; //info@touchmarkdes.com
			$from = "Velaanmandi - Order Status<notification@velaanmandi.com>";
			 
			$mail_template = '<table style="border:#000000 solid 1px;background:#ffffff" width="599" cellspacing="0" cellpadding="0" border="0" align="center">
  <tbody>
    <tr>
      <td style="background: #000;text-align: center;align-content: center;" valign="top" align="center"><img alt="Velaanmandi Logo" style="padding:18px 10px 10px;" class="CToWUd" src="'.SEOURL.'assets/images/logo-light.png" height="50" border="0"></td>
    </tr>
    <tr>
      <td style="padding: 25px 10px 10px;" valign="top" align="center"><table width="535" cellspacing="0" cellpadding="0" border="0">
          <tbody>
            <tr>
              <td valign="top" align="left"><strong style="font-size: 16px;line-height: 30px;padding-bottom: 15px;display: block;">Dear '.$customer_name.',</strong></td>
            </tr>
            <tr>
              <td valign="top" align="left"> <b>'.$order_notes.'</b> </td>
            </tr>
            <tr>
              <td valign="top" align="left"> For any queries, please contact<br>
                <br>
                Regards,<br>
                Team <span>Velaanmandi</span></td>
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
	 // echo $from,$to,$cc,$Bcc,$subject,$mail_template;
	
	 if(send_mail($from,$to,$cc,$Bcc,$subject,$mail_template)) {
      } else {
         if (!send_mail($from,$to,$cc,$Bcc,$subject,$mail_template, false)) {
         
           if (!empty($error)) { echo $error; } 
          }     
        } 
			
		}
		
		$arrFields_log = array('`pd_id`', '`od_id`', '`log_description`','`status`');
		
		$arrValues_log = array("$product_id", "$id", "$description", "1");

		if(sqlACTIONS("INSERT","js_shop_order_log",$arrFields_log,$arrValues_log, '')){
			
			$data = array('status' => 'Success', 'msg' => 'order_note_added' );
			
		}
	

header('Content-Type: application/json');
echo json_encode($data);


?>