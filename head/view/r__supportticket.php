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
//Dont place PHP Close tag at the bottom
extract($_REQUEST);

include '../jackus.php';


protectpg_includes();

if($send =='send'){
	
	
		$arrFields1=array('`status`');

		$arrValues1=array("$status");

		$sqlWhere1= "ticket_ID=$id";

		if(sqlACTIONS("UPDATE","js_support_ticket",$arrFields1,$arrValues1, $sqlWhere1)) {
		if($mail_content!=''){
	
		$mailcontent = htmlentities($_REQUEST['mail_content']);
	trim ($mailcontent);
	
	$mailcontent = str_replace("'", "\'", $mailcontent);

	
		$arrFields=array('`type`','`complaint_ID`','`mail_content`','`booking_ref`', '`status`');

		$arrValues=array("1","$id","$mailcontent","$booking_ref","1");

		if(sqlACTIONS("INSERT","cj_complaint_email",$arrFields,$arrValues, '')) {
//$mailcontent=html_entity_decode($mail_content);

			
				$subject = $reason;
				$to = $customer_email;// $project_email;//
				$cc = $admin_emailid;//info@touchmarkdes.com
				$Bcc = ''; //info@touchmarkdes.com
				$from = "VELAANMANDI - Complaint Response <notification@itservicesingapore.com>";
				 
				$mail_template = '<table style="border:#000000 solid 1px;background:#ffffff" width="599" cellspacing="0" cellpadding="0" border="0" align="center">
				  <tbody>
					<tr>
					  <td style="background: #000;text-align: center;align-content: center;" valign="top" align="center"><img alt="VELAANMANDI Logo" style="padding:18px 10px 10px;" class="CToWUd" src="'.SEOURL.'images/logo-white.png" width="100" height="50" border="0"></td>
					</tr>
					<tr>
					  <td style="padding: 25px 10px 10px;" valign="top" align="center"><table width="535" cellspacing="0" cellpadding="0" border="0">
						  <tbody>
							<tr>
							  <td valign="top" align="left"><strong style="font-size: 16px;line-height: 30px;padding-bottom: 15px;display: block;">Dear '.$customer.',</strong></td>
							</tr>
							<tr>
							  <td valign="top" align="left">'.$mail_content.'</td>
							</tr>
							<tr>
							  <td valign="top" align="left"> For any queries, please contact  <a href="tel:917221842842">+91-7221842842</a>.<br>
								<br>
								Regards,<br>
								Team <span>VELAANMANDI</span></td>
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
						
				//echo $from,$to,$cc,$Bcc,$subject,$mail_template; 
					// if(send_mail($from,$to,$cc,$Bcc,$subject,$mail_template)) {
					  
							
						// echo "<script type='text/javascript'>window.location = 'support_ticket.php?route=preview&id=$id' </script>";
						// exit();
					   // } else {
						 // if (!send_mail($from,$to,$cc,$Bcc,$subject,$mail_template, false)) {
						 
							// if (!empty($error)) { echo $error; } 
						   // }     
						 // } 
									echo "<script type='text/javascript'>window.location = 'support_ticket.php?route=preview&id=$id' </script>";

			exit();
		}
		}else{
					echo "<script type='text/javascript'>window.location = 'supportticket?route=preview&id=' </script>";
					exit();
				}
			
		}
}


//Insert Operation
?>
  <div class="content">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
	   <?php if($route == ''){ ?>
       <div class="row mg-t-25">
          <div class="col-lg-12">
		 
            <div class="row row-xs mg-b-25">
			<div data-label="Example" class="df-example demo-table table-responsive">
			<h4>Complaints</h4> 
			  <table id="LIST" class="table table-bordered" width="99%">
			    <thead>
			        <tr>
						<th class="wd-5p"><?php echo $__contentsno ?></th>
						<th class="wd-5p">Ticket ID</th>
						<th class="wd-15p">Product Name</th>
			            <th class="wd-10p">Customer Name</th>
			            <th class="wd-10p">Status</th>
			            <th class="wd-5p">Complaint</th>
			        </tr>
			    </thead>
			</table>
			</div>
			
			
            </div><!-- row -->
			<!-- col -->
        </div><!-- row --> 
	</div><!-- container -->
	<?php } 
			if($route=='view' && $id!=''){
				$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_support_ticket` where  ticket_ID = $id ") or die("Unable to get records:".sqlERROR_LABEL());

				$fetch_list = sqlNUMOFROW_LABEL($list_datas);
			 
				$fetch_records = sqlFETCHARRAY_LABEL($list_datas);
				$ticket_name = $fetch_records['ticket_name'];
				if($ticket_name == ''){
					$ticket_name='Self';
				}
				$ticket_email = $fetch_records['ticket_email'];
				if($ticket_email == ''){
					$ticket_email = EMPTYFIELD;
				}
				$product_ID = $fetch_records['product_ID'];
				$product_name = getSINGLEDBVALUE('producttitle',"productID='$product_ID'",'js_product','label');
				// $type = getCOMPLAINTREASON($complaint_type,'label');
				$complaint_content = html_entity_decode($fetch_records['ticket_discription']);
				if($complaint_content==''){
					  $complaint_content=EMPTYFIELD;  
					}
				if($complaint_type== 0){
					  $type=EMPTYFIELD;  
					}
					
				$updatedon = $fetch_records['updatedon'];
						$date = date('d M y, l', strtotime($updatedon));
							
							 // echo $imag;
						
					echo '
					<div class="row mg-t-5">
						<div class="col-lg-4">
							<label><b>Name</b></label> 
						</div>
						<div class="col-lg-1">:</div>
						<div class="col-lg-6">
							<p>'. $ticket_name.'</p>
						</div>
					</div>
					<div class="row mg-t-5">
						<div class="col-lg-4">
							<label><b>Email</b></label> 
						</div>
						<div class="col-lg-1">:</div>
						<div class="col-lg-6">
							<p>'. $ticket_email.'</p>
						</div>
					</div>
					<div class="row mg-t-5">
						<div class="col-lg-4">
							<label><b>Product Name</b></label> 
						</div>
						<div class="col-lg-1">:</div>
						<div class="col-lg-6">
							<p>'. $product_name.'</p>
						</div>
					</div>
					<div class="row mg-t-5">
						<div class="col-lg-4">
							<label><b>Complaint</b></label> 
						</div>
						<div class="col-lg-1">:</div>
						<div class="col-lg-6">
							<p>'. $complaint_content.'</p>
						</div>
					</div>
					<div class="row mg-t-5">
						<div class="col-lg-4">
							<label><b>Given On</b></label> 
						</div>
						<div class="col-lg-1">:</div>
						<div class="col-lg-6">
							<p>'. $date.'</p>
						</div>
					</div>';
				 } 
				
				if($route=='preview' && $id!=''){
	$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_support_ticket` where ticket_ID = '$id' order by ticket_ID desc") or die("Unable to get records:".sqlERROR_LABEL());

	$fetch_list = sqlNUMOFROW_LABEL($list_datas);
 
 while($fetch_records = sqlFETCHARRAY_LABEL($list_datas)){

		$counter++;
		$product_ID = $fetch_records['product_ID'];
		$ticket_ID = $fetch_records['ticket_ID'];
		$ticket_name = $fetch_records['ticket_name'];
		if($ticket_name == ''){
			$ticket_name = 'Self';
		}
		$ticket_email = $fetch_records['ticket_email'];
		if($ticket_email == '') {
			$ticket_email = EMPTYFIELD;
		}
		$product = getSINGLEDBVALUE('producttitle',"productID='$product_ID'",'js_product','label');	
		$complaint_content = html_entity_decode($fetch_records['ticket_discription']);
		$status = $fetch_records['status'];
		if($status==1){
						$complaint_status = "<span class='text-success'>NEW</span>";
					 }
					 if($status==2){
						$complaint_status = "<span class='text-danger'>CLOSED</span>";
					 }
					 if($status==3){
						$complaint_status = "<span class='text-primary'>REPLIED</span>";
					 }
 }
					 ?>
				<div class="row">
			<div id="stick-here"></div>
			<div id="stickThis" class="form-group row mg-b-0" style="width: 1185px;">
				<div class="col-3 col-sm-6">
					<?php pageCANCEL($currentpage, $__cancel); ?>
				</div>
				<div class="col-9 col-sm-6 text-right">
					 <!--<a href="javascript:;" data-toggle="modal" data-target="#quickupdate" data-toggle="tooltip" data-original-title="Click to Download" class="btn btn-success md-quick-update-hide sm-quick-update btn-md" onclick="add_payment();"><i class="fa fa-credit-card"></i> ADD TOPUP</a>
					 <button class="btn btn-success btn-sm" onclick="add_payment()"><i class="fa fa-credit-card"></i> ADD TOPUP</button>-->
					<a href="<?php echo BASEPATH; ?>support_ticket.php" class="btn btn-warning"><?php echo $__back; ?></a>
				</div>
			</div>
				
			<div class="col-12 mg-t-20 mg-b-20">
			<div class="card">
				<h5 class="card-header">
				<span class="mr-auto text-muted">TICKET ID :</span>
				<span class="mr-auto text-primary"><?php echo $ticket_ID; ?></span>
				<span class="float-right "><?php echo $complaint_status ?></span>
				</h5>
				<div class="card-body">
				<div class="row">
					<div class="col-lg-6">
					<div class="row">
						<div class="col-md-3 col-sm-6">
						<h6 class="mr-auto"> Name </h6>
						</div>
						<div class="col-md-1 col-sm-6">:</div>
						<div class="col-md-6 col-sm-6">
						<span class="mr-auto text-muted"><?php echo $ticket_name; ?></span>
						</div>					
					</div>
					<div class="row">
					
						<div class="col-md-3 col-sm-6">
						<h6 class="mr-auto"> Email </h6>
						</div>
						<div class="col-md-1 col-sm-6">:</div>
						<div class="col-md-6 col-sm-6">
						<span class="mr-auto text-muted"><?php echo $ticket_email; ?></span>
						</div>					
					</div>				
					<div class="row">
					
						<div class="col-md-3 col-sm-6">
						<h6 class="mr-auto"> Product Name </h6>
						</div>
						<div class="col-md-1 col-sm-6">:</div>
						<div class="col-md-6 col-sm-6">
						<span class="mr-auto text-muted"><?php echo $product; ?></span>
						</div>					
					</div>				
					<div class="row">
					
						<div class="col-md-3 col-sm-6">
						<h6 class="mr-auto"> Complaint </h6>
						</div>
						<div class="col-md-1 col-sm-6">:</div>
						<div class="col-md-6 col-sm-6">
						<span class="mr-auto text-muted"><?php echo $complaint_content; ?></span>
						</div>					
					</div>				
					
					</div>	
				
				<div class=" row">
				<div class="col-12">
					<div class="row">
					<div class="col-lg-12">
					
					<form action='' method='post'>
					
						 <div class="form-group row">
				    <h6 for="mail_content" class="col-sm-6 col-form-label">Response/Reply Mail</h6>
				    <div class="col-sm-12">
				    	<textarea class="form-control" rows="2"  name="mail_content" id="mail_content" style="height: 150px;" ><?php echo $mail_content ?></textarea>
				    	<input type="hidden" name="reason" id="reason" value="<?php echo $type?>">
				    	<input type="hidden" name="booking_ref" id="booking_ref" value="<?php echo $booking_id?>">
				    	<input type="hidden" name="customer" id="customer" value="<?php echo $customer?>">
				    	<input type="hidden" name="customer_email" id="customer_email" value="<?php echo $customer_email?>">
				    </div>
					  </div>
					  <div class="">
					  <div class="row">
					  <div class="col-lg-6 float-right">
						<select class="form-control" name="status" id="status">
						 <option value="1" <?php if($status==1){ echo 'selected'; }?>> New </option>
						 <option value="2" <?php if($status==2){ echo 'selected'; }?>> Closed</option>
						 <option value="3" <?php if($status==3){ echo 'selected'; }?>> Replied</option>
						</select>
						</div>
						 <div class="col-lg-4">
						<button class="btn- btn-xs btn-primary float-right" id="send" name="send" value="send">Send Mail
					  </button>
					  </div>
					  </div>
					  
					
					  </form>
					</div>				
					
					</div>
					</div>
					
				</div>
				</div>
				 
				</div>
			
			
		
			</div>
		
			
		</div>
		
				 
				 <?php } ?>
  
  </div><!-- content -->

  </div>	
      
