<?php 
extract($_REQUEST);

include '../../jackus.php';

	$arrFields = array('`od_status`');

	$arrValues = array("$order_status",);

	$sqlWhere = "od_id = '$id'";
	$od_user_id = getSINGLEDBVALUE('od_userid',"od_id='$id'",'js_shop_order','label');
	$customer_name = getSINGLEDBVALUE('customerfirst',"user_id='$od_user_id'",'js_customer','label');
	$order_ref_no = getSINGLEDBVALUE('od_refno', "od_id='$id'",'js_shop_order','label');
	if(sqlACTIONS("UPDATE","js_shop_order",$arrFields,$arrValues, $sqlWhere)){
	
		$data = array('status' => 'Success', 'msg' => 'subscribed' );
		
		if($order_status == '1'){$description = "New Order";}
		if($order_status == '2'){$description = "Approved";}
		if($order_status == '3'){$description = "In-Progress";}
		if($order_status == '4'){$description = "Delivery Assigned";}
		if($order_status == '5'){$description = "Delivery In-Progress";}
		if($order_status == '6'){$description = "Delivered";}
		if($order_status == '7'){$description = "Canceled";}
		if($order_status == '8'){$description = "Refunded";}
		
		$arrFields_log = array('`pd_id`', '`od_id`', '`od_status`', '`log_description`', '`status`');
		
		$arrValues_log = array("$product_id", "$id", "$order_status", "$description", "1");

		$check_order_status_log = commonNOOFROWS_COUNT('js_shop_order_log', "pd_id = '$product_id' and od_id = '$id' and od_status = '$order_status'");

		if($check_order_status_log == 0){
		if(sqlACTIONS("INSERT","js_shop_order_log",$arrFields_log,$arrValues_log, '')){

			if($send_mail =='1'){
		
			$subject = 'Your Order - #'.$order_ref_no.' Status - '.$description ;
			$to = $customer_email;// $project_email;//
			$cc = $cc_mail;//info@touchmarkdes.com
			$Bcc = $bcc_mail; //info@touchmarkdes.com
			$from = "Rarefashion - Order Status<".$from_mail.">";
			 
			$mail_template = '<table style="border:#000000 solid 1px;background:#ffffff" width="599" cellspacing="0" cellpadding="0" border="0" align="center">
          <tbody>
            <tr>
              <td style="background: #000;text-align: center;align-content: center;" valign="top" align="center"><img alt="Rarefashion Logo" style="padding:18px 10px 10px;" class="CToWUd" src="'.SEOURL.'assets/images/logo-light.png" height="50" border="0"></td>
            </tr>
            <tr>
              <td style="padding: 25px 10px 10px;" valign="top" align="center"><table width="535" cellspacing="0" cellpadding="0" border="0">
                  <tbody>
                    <tr>
                      <td valign="top" align="left"><strong style="font-size: 16px;line-height: 30px;padding-bottom: 15px;display: block;">Dear '.$customer_name.',</strong></td>
                    </tr>
                    <tr>
                      <td valign="top" align="left">Your Order <b>'.$description.'</b> </td>
                    </tr>
                    <tr>
                      <td valign="top" align="left"> For any queries, please contact<br>
                        <br>
                        Regards,<br>
                        Team <span>Rarefashion</span></td>
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
	 //echo $from,$to,$cc,$Bcc,$subject,$mail_template;exit();
	
	 if(send_mail($from,$to,$cc,$Bcc,$subject,$mail_template)) {
      } else {
         if (!send_mail($from,$to,$cc,$Bcc,$subject,$mail_template, false)) {
         
           if (!empty($error)) { echo $error; } 
          }     
        } 
			}
			
		}
		}
	}
	
header('Content-Type: application/json');
echo json_encode($data);


?>