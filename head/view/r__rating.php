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
	
		$mailcontent = htmlentities($_REQUEST['mail_content']);
	trim ($mailcontent);
	
	$mailcontent = str_replace("'", "\'", $mailcontent);

	
		$arrFields=array('`mail_content`', '`status`');

		$arrValues=array("$mailcontent","2");

		$sqlWhere= "review_ID=$id";

		if(sqlACTIONS("UPDATE","cj_review",$arrFields,$arrValues, $sqlWhere)) {
//$mailcontent=html_entity_decode($mail_content);

$subject = 'Rare Fashions RESPONSE';
$to = $customer_email;// $project_email;//
$cc = $admin_emailid;//info@touchmarkdes.com
$Bcc = ''; //info@touchmarkdes.com
$from = "Rare Fashions - Complaint Response <notification@rarefashions.com>";
 
$mail_template = '<table style="border:#000000 solid 1px;background:#ffffff" width="599" cellspacing="0" cellpadding="0" border="0" align="center">
  <tbody>
    <tr>
      <td style="background: #000;text-align: center;align-content: center;" valign="top" align="center"><img alt="CARSJOCKEY Logo" style="padding:18px 10px 10px;" class="CToWUd" src="'.SEOURL.'images/logo-white.png" width="100" height="50" border="0"></td>
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
        
//echo $from,$to,$cc,$Bcc,$subject,$mail_template; 
    if(send_mail($from,$to,$cc,$Bcc,$subject,$mail_template)) {
	  
			?>
			<script type="text/javascript">window.location = 'complaints.php' </script>
		<?php
		exit();
       } else {
         if (!send_mail($from,$to,$cc,$Bcc,$subject,$mail_template, false)) {
         
            if (!empty($error)) { echo $error; } 
           }     
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
			  <table id="LIST" class="table table-bordered">
			    <thead>
			        <tr>
						<th class="wd-5p"><?php echo $__contentsno ?></th>
						<th class="wd-20p">Product Name</th>
						<th class="wd-20p">Order Ref. No.</th>
			            <th class="wd-20p">Customer Name</th>
			            <th class="wd-5p">Review</th>
			            <th class="wd-5p">Review Type</th>
			            <th class="wd-20p">Review Date & Time</th>
			            <th class="wd-5p">Status</th>
			            <th class="wd-20p">Discription</th>
			            
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
				$list_datas = sqlQUERY_LABEL("SELECT * FROM `cj_review` where  deleted = '0' and review_ID = $id ") or die("Unable to get records:".sqlERROR_LABEL());

					$fetch_list = sqlNUMOFROW_LABEL($list_datas);
				 
					$fetch_records = sqlFETCHARRAY_LABEL($list_datas);

						$review_content = html_entity_decode($fetch_records['review_content']);
					if($review_content==''){
					  $review_content='N/A';  
					}
				$review_type = $fetch_records['review_type'];
						
						$updatedon = $fetch_records['updatedon'];
						$date = date('d M y, l', strtotime($updatedon));
							if($review_type == 1){
								  $imag=SEOURL."images/sad.png"; 
								   $review="Bad";
							  }elseif($review_type== 2){
								  $imag=SEOURL."images/happy.png"; 
								   $review="Good";
							  }elseif($review_type == 3){
								  $imag=SEOURL."images/smiling.png";
								   $review="Excellent";
							  }else{
								$imag=SEOURL."images/sad.png"; 
								   $review="No Rating";  
							  }
							 // echo $imag;
						
					echo '<div class="row">
					<div class="col-lg-3 mg-t-15">
					<label>Rating</label> 
					</div>
					<div class="col-lg-9">
					 :<span align="center"><img src="'.$imag.'">'.$review.'</span>
					</div>
					</div>
					<div class="row mg-t-5">
					<div class="col-lg-3">
					<label>Review</label> 
					</div>
					<div class="col-lg-9">
					 <p>: '. $review_content.'</p>
					</div>
					</div>
					<div class="row mg-t-5">
					<div class="col-lg-3">
					<label>Given On</label> 
					</div>
					<div class="col-lg-9">
					 <p>: '. $date.'</p>
					</div>
					</div>';
					
				}
				if($route=='preview' && $id!=''){
					 
						$list_datas = sqlQUERY_LABEL("SELECT * FROM `cj_review` where  deleted = '0' and review_ID='$id' order by review_ID desc") or die("Unable to get records:".sqlERROR_LABEL());

						$fetch_list = sqlNUMOFROW_LABEL($list_datas);
					 
					 while($fetch_records = sqlFETCHARRAY_LABEL($list_datas)){

							$counter++;
							$review_ID = $fetch_records['review_ID'];
							$booking_id = $fetch_records['booking_id'];
							$review_type = $fetch_records['review_type'];
							$review_content = html_entity_decode($fetch_records['review_content']);
							$mail_content = html_entity_decode($fetch_records['mail_content']);
							$customer_ID = $fetch_records['customer_ID'];
							$driver_ID = $fetch_records['driver_ID'];
							$customer = getCUSTOMERNAME($customer_ID,'customer_name');
							$driver = getDRIVERNAME($driver_ID,'driver_name');
							$updatedon = $fetch_records['updatedon'];
							$status = $fetch_records['status'];
						$date = date('d M y, l', strtotime($updatedon));
					 			 
							if($status==1){
											$complaint_status = "<span class='text-success'>OPEN</span>";
										 }
										 if($status==2){
											$complaint_status = "<span class='text-danger'>CLOSED</span>";
										 }
							if($review_type == 1){
								  $imag=SEOURL."images/sad.png"; 
								   $review="Bad";
							  }elseif($review_type== 2){
								  $imag=SEOURL."images/happy.png"; 
								   $review="Good";
							  }elseif($review_type == 3){
								  $imag=SEOURL."images/smiling.png";
								   $review="Excellent";
							  }
						//	$type = "<span><img src='//$imag'> $review</span>";
							$type =  $review;
							$booking_id = getSINGLEDBVALUE('booking_reference_id',"booking_ID='$booking_id'",'js_booking','label');	
					 
						$customer = getCUSTOMERNAME($customer_ID,'customer_name');
						$driver = getDRIVERNAME($driver_ID,'driver_name');
							
						$customer_mobile = getSINGLEDBVALUE('customer_mobile',"customer_ID='$customer_ID'",'js_customers','label');	
						$customer_email = getSINGLEDBVALUE('customer_email',"customer_ID='$customer_ID'",'js_customers','label');	
						$driver_email = getSINGLEDBVALUE('driver_email',"driver_ID='$driver_ID'",'cj_driver_registration','label');	
						$driver_mobile = getSINGLEDBVALUE('driver_mobile',"driver_ID='$driver_ID'",'cj_driver_registration','label');	

					 }
					 ?>
				
				<div class="row">
			<div id="stick-here"></div>
			<div id="stickThis" class="form-group row mg-b-0" style="width: 1185px;">
				<div class="col-3 col-sm-6">
					
				</div>
				<div class="col-9 col-sm-6 text-right">
					 <!--<a href="javascript:;" data-toggle="modal" data-target="#quickupdate" data-toggle="tooltip" data-original-title="Click to Download" class="btn btn-success md-quick-update-hide sm-quick-update btn-md" onclick="add_payment();"><i class="fa fa-credit-card"></i> ADD TOPUP</a>
					 <button class="btn btn-success btn-sm" onclick="add_payment()"><i class="fa fa-credit-card"></i> ADD TOPUP</button>-->
					<a href="complaints.php" class="btn btn-warning"><?php echo $__back; ?></a>
				</div>
			</div>
				
			<div class="col-12 mg-t-20 mg-b-20">
			<div class="card">
				<h5 class="card-header">
				<span class="mr-auto text-muted">BOOKING ID :</span>
				<span class="mr-auto text-primary"><?php echo $booking_id ?></span>
				<span class="float-right "><?php echo $complaint_status ?></span>
				</h5>
				<div class="card-body">
					
				<div class="row">
					
					<div class="col-lg-6">
					<div class="divider-text">Customer Details</div>
					<div class="row">
					
						<div class="col-md-4 col-sm-12">
						<h6 class="mr-auto"> Name </h6>
						<span class="mr-auto text-muted"><?php echo $customer; ?></span>
						</div>
						<div class="col-md-4 col-sm-12">
						<h6 class="mr-auto"> Mobile </h6>
						<span class="mr-auto text-muted"><?php echo $customer_email; ?></span>
						</div>
						<div class="col-md-4 col-sm-12">
						<h6 class="mr-auto"> Email </h6>
						<span class="mr-auto text-muted"><?php echo $customer_mobile; ?></span>
						</div>
						
					</div>
					</div>				
					<div class="col-lg-6">
					<div class="divider-text">Driver Details</div>
					<div class="row">
					
						<div class="col-md-4 col-sm-12">
						<h6 class="mr-auto"> Name </h6>
						<span class="mr-auto text-muted"><?php echo $driver; ?></span>
						</div>
						<div class="col-md-4 col-sm-12">
						<h6 class="mr-auto"> Mobile </h6>
						<span class="mr-auto text-muted"><?php echo $driver_email; ?></span>
						</div>
						<div class="col-md-4 col-sm-12">
						<h6 class="mr-auto"> Email </h6>
						<span class="mr-auto text-muted"><?php echo $driver_mobile; ?></span>
						</div>
						
					</div>
					</div>
					
					
					
					</div>	
				
				<div class="row">
				<div class="col-12">
					<div class="divider-text">About complaint</div>
					<div class="row">
					<div class="col-lg-6">
					<div class="divider-text">COMPLAINT DETAILS</div>
					
						<div class="col-md-12 col-sm-12 pd-b-20">
						<h6 class="mr-auto"> Complaint </h6>
						<span class="mr-auto text-muted"><?php echo $review_content; ?></span>
						</div>
						<div class="col-md-12 col-sm-12">
						<h6 class="mr-auto"> Raised on </h6>
						<span class="mr-auto text-muted"><?php echo $date; ?></span>
						</div>
						
					
					</div>
					<div class="col-lg-6">
					<div class="divider-text">Cj Response</div>
					
					<form action='' method='post'>
					<?php if($status ==1){?>
						 <div class="form-group row">
				    <h6 for="mail_content" class="col-sm-4 col-form-label">Response/Reply Mail</h6>
				    <div class="col-sm-12">
				    	<textarea class="form-control" rows="2"  name="mail_content" id="mail_content" style="height: 150px;"><?php echo $mail_content ?></textarea>
				    	<input type="hidden" name="customer" id="customer" value="<?php echo $customer?>">
				    	<input type="hidden" name="customer_email" id="customer_email" value="<?php echo $customer_email?>">
				    </div>
					  </div>
					  <button class="btn- btn-xs btn-primary float-right" id="send" name="send" value="send">Send Mail
					  </button>
					<?php }else{?>
					<div class="form-group row">
				    <h6 for="mail_content" class="col-sm-4 col-form-label">Response/Reply Mail</h6>
				    <div class="col-sm-12">
				    	<p class="form-control"   style="height: 150px;"><?php echo $mail_content ?></p>
				    	
				    </div>
					  </div>
					<?php }?>
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
      
