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
protectpg_includes();
if($formtype == 'preview' && $id != '') {
	//echo "SELECT * FROM `js_staff` where deleted = '0' and `staff_id`='$id'";exit();
	$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_staff` where `staff_id`='$id' and deleted = '0'") or die("Unable to get records:".sqlERROR_LABEL());		
	$check_record_availabity = sqlNUMOFROW_LABEL($list_datas);			

	while($row = sqlFETCHARRAY_LABEL($list_datas)){
	  $staff_id = $row["staff_id"];
	  $staff_code = $row["staff_code"];
	  $first_name = $row["staff_fname"];
	  $last_name = $row["staff_lname"];
	  $staff_email = strtolower($row["staff_email"]);
	  $staff_mobile = $row["staff_mobile"];
	  $staff_gender = $row["staff_gender"];
	  $address1 = $row["staff_address1"];
	  $address2 = $row["staff_address2"];
	  $postal_code = $row["staff_postalcode"];
	  // $state = getCOUNTRYLIST($row["staff_state"],'state_label');
	  // $city = getCOUNTRYLIST($row["staff_city"],'city_label');
	  // $staff_country = getCOUNTRYLIST($row["staff_country"],'country_label');
	  $staffroleid = $row["staffroleid"];
	  $status = $row["status"];
	  $staff_aadhar = $row["staff_aadhar"];
	  if($staff_aadhar !=''){$staff_aadhar = $staff_aadhar; } else { $staff_aadhar = 'N/A';}
	  $staff_pf = $row["staff_pf"];
	  if($staff_pf !=''){$staff_pf = $staff_pf; } else { $staff_pf = 'N/A';}
	  $staff_pan = $row["staff_pan"];
	  if($staff_pan !=''){$staff_pan = $staff_pan; } else { $staff_pan = 'N/A';}
	  $staff_comments = $row["staff_comments"];
	  $staff_bankdetails_bank = $row["staff_bankdetails_bank"];
	  if($staff_bankdetails_bank !=''){$staff_bankdetails_bank = $staff_bankdetails_bank; } else { $staff_bankdetails_bank = 'N/A';}
	  $staff_bankdetails_bank_branch = $row["staff_bankdetails_bank_branch"];
	  if($staff_bankdetails_bank_branch !=''){$staff_bankdetails_bank_branch = $staff_bankdetails_bank_branch; } else { $staff_bankdetails_bank_branch = 'N/A';}
	  $staff_bankdetails_bank_ac = $row["staff_bankdetails_bank_ac"];
	  if($staff_bankdetails_bank_ac !=''){$staff_bankdetails_bank_ac = $staff_bankdetails_bank_ac; } else { $staff_bankdetails_bank_ac = 'N/A';}
	  $staff_bankdetails_bank_neft = $row["staff_bankdetails_bank_neft"];
	  if($staff_bankdetails_bank_neft !=''){$staff_bankdetails_bank_neft = $staff_bankdetails_bank_neft; } else { $staff_bankdetails_bank_neft = 'N/A';}
	  $staff_altemail = $row["staff_altemail"];
	  if($staff_altemail !=''){$staff_altemail = $staff_altemail; } else { $staff_altemail = 'N/A';}
	  $staff_profile = $row["staff_profile"];
	  $staff_userpassword = $row["staff_userpassword"];
	  $staff_username = strtolower($row["staff_username"]);
	  $staff_password = $row["staff_password"];
	  $password = $row["password"];
	   $imgpath = "uploads/staffprofile/";
	   $img = $imgpath.$staff_profile;
	  if($staff_comments !=''){$staff_comments = $staff_comments; } else { $staff_comments = 'N/A';}
	  if($address1 !=''){
		  $staff_address = $address1;
	  }
	  if($address2 !=''){
		  $staff_address = $staff_address .' ,'.$address1;
	  }
	  if($state !=''){
		  $staff_address = $staff_address .' ,'.$state;
	  }
	  if($city !=''){
		  $staff_address = $staff_address .' ,'.$city;
	  }
	  if($postal_code !=''){
		  $staff_address = $staff_address .'-'.$postal_code;
	  }
	  if($staff_country !=''){
		  $staff_address = $staff_address .' ,'.$staff_country;
	  }
	}
}
?>
    <div class="content">
      <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <?php  if($formtype==''){ ?>
		<div class="row">
          <div class="col-lg-12 w-xs mg-b-25">

			<div data-label="Example" class="df-example demo-table table-responsive">
			  <table id="staffID" class="table table-bordered" width="99%">
			    <thead>
			        <tr>         
						<th class="wd-5p"><?php echo $__contentsno ?></th>
						<th><?php echo 'Staff Code'; ?></th>
						<th><?php echo 'Staff name'; ?></th>
						<th><?php echo $__email ?></th>
						<th><?php echo $__mobile ?></th>
						<th><?php echo 'Staff Role'; ?></th>
						<th><?php echo $__status ?></th>
						<th><?php echo $__status ?></th>
						<!--NOTE: [This is Status Label(Active/Inactive)] Above Status Used for Export the List Data This Field Hide in the List Table So Dont Remove this Field -->
						<th><?php echo $__options ?></th>
			        </tr>
			    </thead>
			</table>
			</div>

            </div><!-- row -->
          </div><!-- col -->
			<?php
	          //include viewpath('__staffsidebar.php'); 
			?> 
          	 <?php } if($formtype=='preview'){ ?>
			<!--<form>
					<div class="row mg-b-30">
						<div class="col-2 ml-auto">
							<label for="month">Filter By Months</label>
								<div class="input-group mg-b-10">
								  <input type="text" class="form-control" placeholder="MM/YYYY" aria-label="Recipient's username" aria-describedby="basic-addon2" name="month" id="month" value="<?php echo $_GET['month']; ?>" >
								  <div class="input-group-append">
									<span class="input-group-text" id="basic-addon2"><i class="far fa-calendar-alt"></i></span>
								  </div>
								</div>
						</div>
						<div class="mg-t-30 mg-l-20 text-right">
							<a href="staff.php?formtype=preview&id=<?php echo $id; ?>" name="submit" class="btn btn-info">Apply Filter</a>
							<a href="staff.php?formtype=preview&id=<?php echo $id; ?>" class="btn btn-light">Clear</a>
						</div>						
					</div>
				</form>-->
			<div class="row">
				<div id="stick-here"></div>
					<div id="stickThis" class="form-group row mg-b-0" style="width: 1185px;">
                    <div class="col-12 col-sm-12 text-right">
                    <a href="staff.php"  class="btn btn-warning"><?php echo $__back; ?></a>
                    </div>
				  </div>
				  </hr>
				  <div class="py-1 px-5 col-lg-12">
				<h3 class="text-center text-muted text-uppercase">Staff Details</h3>
			</div>
                   
			<div class="card">
			<h4 class="card-header text-muted text-uppercase">Name - <span class="text-muted text-uppercase"><?php echo $first_name.' '. $last_name ?></span></h4>
				<div class="card-body">
				<div class="form-group row">
					<div class="col-md-3 border-right ">
						<div class="text-uppercase">
						  <span>STAFF CODE</span>
						</div>
						<div class="text-muted mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
						  <span><?php echo $staff_code ;?></span>
						</div>
					</div>
					<div class="col-md-3 border-right ">
						<div class="text-uppercase">
						  <span>Staff Role </span>
						</div>
						<div class="text-muted mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
						  <span> <?php echo getrole($staffroleid, 'label'); ?></span>
						</div>
					</div>
					<div class="col-md-4 border-right">
						<div class="text-uppercase">
						  <span>Email </span>
						</div>
						<div class="text-muted mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
						  <span><?php echo $staff_email ;?></span>
						</div>
					</div>
					<div class="col-md-2">
					<?php if($staff_profile != ''){ ?>
						<img src="<?php echo $img; ?>" class="img-fluid img wd-100 ht-100" alt="Staff_Profile">
					<?php } else { ?>
						<img src="<?php echo BASEPATH; ?>/public/img/no-image-available.png" class="img-fluid img wd-100 ht-100" alt="no-image-available">
					<?php } ?>							
					</div>
					<div class="col-md-3 border-right mg-t-20">
						<div class="text-uppercase">
						  <span>Alternative Email </span>
						</div>
						<div class="text-muted mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
						  <span><?php echo $staff_altemail ;?></span>
						</div>
					</div>
					<div class="col-md-3 border-right mg-t-20">
						<div class="text-uppercase">
						  <span>Mobile No</span>
						</div>
						<div class="text-muted mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
						  <span><?php echo $staff_mobile ;?></span>
						</div>
					</div>
					<div class="col-md-3 border-right mg-t-20">
						<div class="text-uppercase ">
						  <span>Gender </span>
						</div>
						<div class="text-muted mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
						  <span><?php echo getGENDERTYPE($staff_gender, 'label'); ?>  </span>
						</div>
					</div>
					<div class="col-md-3 mg-t-20 border-right">
						<div class="text-uppercase ">
						  <span>Aadhar Card No. </span>
						</div>
						<div class="text-muted mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
						  <span><?php echo $staff_aadhar ;?></span>
						</div>
					</div>					
					<div class="col-md-3 mg-t-20 border-right">
						<div class="text-uppercase ">
						  <span>PF No. </span>
						</div>
						<div class="text-muted mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
						  <span><?php echo $staff_pf ;?></span>
						</div>
					</div>
					<div class="col-md-3 mg-t-20 border-right">
						<div class="text-uppercase ">
						  <span>PAN No. </span>
						</div>
						<div class="text-muted mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
						  <span><?php echo $staff_pan ;?></span>
						</div>
					</div>
					<div class="col-md-3 mg-t-20 border-right">
						<div class="text-uppercase ">
						  <span>Bank Name </span>
						</div>
						<div class="text-muted mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
						  <span><?php echo $staff_bankdetails_bank ;?></span>
						</div>
					</div>					
					<div class="col-md-3 mg-t-20 border-right">
						<div class="text-uppercase ">
						  <span>Branch Name </span>
						</div>
						<div class="text-muted mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
						  <span><?php echo $staff_bankdetails_bank_branch ;?></span>
						</div>
					</div>					
					<div class="col-md-3 mg-t-20 border-right">
						<div class="text-uppercase ">
						  <span>A/C Number </span>
						</div>
						<div class="text-muted mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
						  <span><?php echo $staff_bankdetails_bank_ac ;?></span>
						</div>
					</div>
					<div class="col-md-3 mg-t-20 border-right">
						<div class="text-uppercase ">
						  <span>NEFT Code </span>
						</div>
						<div class="text-muted mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
						  <span><?php echo $staff_bankdetails_bank_neft ;?></span>
						</div>
					</div>
					<div class="col-md-3 border-right mg-t-20">
						<div class="text-uppercase">
						  <span>Staff User Name</span>
						</div>
						<div class="text-muted mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
						  <span><?php echo $staff_username ;?></span>
						</div>
					</div>
					<div class="col-md-3 mg-t-20">
						<div class="text-uppercase">
						  <span>Staff Password </span>
						</div>
						<div class="text-muted mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
						  <span>********</span>
						</div>
					</div>					
					<div class="col-md-6 mg-t-20">
						<div class="text-uppercase ">
						  <span>Address </span>
						</div>
						<div class="text-muted mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
						  <span> <?php echo $staff_address ;?></span>
						</div>
					</div>
					<div class="col-md-6 mg-t-20">
						<div class="text-uppercase ">
						  <span>Comments </span>
						</div>
						<div class="text-muted mg-t-10 text-uppercase" style="letter-spacing: 0.0825em;">
						  <span> <?php echo $staff_comments ;?></span>
						</div>
					</div>
				</div>
                </div>
            </div>
        </div><!-- row -->
        <div class="mt-4">
            <div class="form-group row">
            	<div class="col-sm-12">
                <span class="text-warning" id="msg_loading" style="display:none;text-align:center;">Loading...</span>
                <p id="msg">
                    <?php $query_result= "SELECT * FROM `js_proofdocument` where form_primaryID = '$id' and deleted ='0'";
					$result_query = sqlQUERY_LABEL($query_result);
					while($rows = sqlFETCHARRAY_LABEL($result_query))
					{	

					$document_ID  = $rows['document_ID'];
					//$type_form  = $rows['form_type'];
					$document_type = getproofattach($rows['document_type'],'label');	
					$document_name = $rows['document_name'];	
					// echo $document_ID;
					?>
                    <span style="cursor:pointer;" class="badge badge-info" onClick="remove_quickitem_List('<?php echo $document_ID; ?>','<?php echo $id; ?>','<?php echo $document_name; ?>')">
                        <?php echo $document_type.' '; ?> X</span>
                    <?php	} ?>
                </p>
                </div>
            
                <div class="col-sm-4">
                	    <label for="staff_proof" class="col-sm-4 mt-2 control-label">Choose Proof</label>
                    <select class="form-control" id="staff_proof" name="staff_proof">
                        <?php echo getproofattach('','select'); ?>
                    </select>
                </div>
                <div class="col-sm-4">
                	 <label for="staff_proof" class="col-sm-4 mt-2 control-label">Attach Proof</label>
                    <input type="file" name="file" id="file" class="form-control" />
                     <small class="text-muted col-sm-4 ">PDF, JPEG, DOCX ONLY</small> 
                </div>
                <div class="col-sm-4">
    				
                    <a href="javascript:;" id="upload" class="btn btn-warning btn-sm" style="margin-top: 37px">Upload</a>
                
                </div>
        </div>
		<div data-label="Example" class="df-example demo-table">
            <table id="staffproofLIST" class="table table-bordered ">
                <thead>
                    <tr>
                        <th class="wd-5p">#</th>
                        <th scope="col">Document Type</th>
                        <th scope="col">Attachement</th>
                        <th scope="col">Modify</th>
                    </tr>
                </thead>
            </table>
        </div>
        <input type="hidden" id="hidden_id" value="<?php echo $id; ?>">
        <div class="col-12">
            <div class="col-xs-12 col-md-12 col-lg-12 row mg-t-20 mt-5 mg-md-l-0">
                <div class="media mg-t-20 mg-sm-t-0 mg-sm-l-15 mg-md-l-0">
                    <div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-teal tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-5">
                        <i data-feather="bar-chart-2"></i>
                    </div>
                    <style>
                    .clear-all:hover {
                        text-decoration: underline;
                    }
                    </style>
                    <div class="media-body">
                        <h6 class="tx-sans tx-uppercase tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8"><a href="staff.php?formtype=preview&id=<?php echo $id;?>" class="clear-all text-secondary">Total Leads</a></h6>
                        <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">
                            <?php echo getstaffLEAD($staff_id,'total',''); ?>
                        </h3>
                    </div>
                </div>
                <div class="media mg-t-20 mg-sm-t-0 mg-sm-l-15 mg-md-l-20">
                    <div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-success tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-5">
                        <i data-feather="bar-chart-2"></i>
                    </div>
                    <div class="media-body">
                        <h6 class="tx-sans tx-uppercase tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8"><a href="staff.php?formtype=preview&id=<?php echo $id;?>&hot_leadstatus=2" class="clear-all text-secondary">Total Hot Leads</a></h6>
                        <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">
                            <?php echo getstaffLEAD($staff_id,'hotlead','2'); ?>
                        </h3>
                    </div>
                </div>
                <div class="media mg-t-20 mg-sm-t-0 mg-sm-l-15 mg-md-l-20">
                    <div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-danger tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-5">
                        <i data-feather="bar-chart-2"></i>
                    </div>
                    <div class="media-body">
                        <h6 class="tx-sans tx-uppercase tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8"><a href="staff.php?formtype=preview&id=<?php echo $id;?>&cold_leadstatus=1" class="clear-all text-secondary">Total Cold Leads</a></h6>
                        <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">
                            <?php echo getstaffLEAD($staff_id,'coldlead','1'); ?>
                        </h3>
                    </div>
                </div>
                <div class="media mg-t-20 mg-sm-t-0 mg-sm-l-15 mg-md-l-20">
                    <div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-warning tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-5">
                        <i data-feather="bar-chart-2"></i>
                    </div>
                    <div class="media-body">
                        <h6 class="tx-sans tx-uppercase tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8"><a href="staff.php?formtype=preview&id=<?php echo $id;?>&dead_leadstatus=3" class="clear-all text-secondary">Total Dead Leads</a></h6>
                        <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">
                            <?php echo getstaffLEAD($staff_id,'deadlead','3'); ?>
                        </h3>
                    </div>
                </div>
                <div class="media mg-t-20 mg-sm-t-0 mg-sm-l-15 mg-md-l-40">
                    <div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-orange tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-5">
                        <i data-feather="bar-chart-2"></i>
                    </div>
                    <div class="media-body">
                        <h6 class="tx-sans tx-uppercase tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8"><a href="staff.php?formtype=preview&id=<?php echo $id;?>&dead_leadstatus=3" class="clear-all text-secondary">Total Closed Lead</a></h6>
                        <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">
                            <?php echo getstaffLEAD($staff_id,'closedlead','4'); ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-header mt-4">
            <h3 class="text-muted text-uppercase">LEAD Details</h3>
        </div>
        <div data-label="Example" class="df-example demo-table">
            <table id="staffleadLIST" class="table table-bordered ">
                <thead>
                    <tr>
                        <th class="wd-5p">#</th>
                        <th scope="col">Lead Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Mobile No.</th>
                        <th scope="col">Status</th>
                        <th scope="col">Last Updatedon</th>
                        <th scope="col">Preview</th>
                    </tr>
                </thead>
            </table>
        </div>
        <?php } ?>
    </div><!-- row -->
</div><!-- container -->
</div><!-- content -->