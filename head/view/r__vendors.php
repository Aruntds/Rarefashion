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

if($route == 'import'){$vendor_session_id = session_id();}
//import expenses -- uploading from excel
if($upload == 'import') {
	$file_name = $_FILES['csv']['name']; 
	$file_type 		= $_FILES['csv']['type'];
	$file_temp_loc 	= $_FILES['csv']['tmp_name'];
	$file_error_msg = $_FILES['csv']['error'];
	$file_size 		= $_FILES['csv']['size'];
	
	/* 1. file upload handling */
	if(!$file_temp_loc) { // if not file selected
		echo "Error: please browse for a file before clicking the upload button.";
		exit();	
	} 
	if(!preg_match("/\.(csv)$/i", $file_name)) { // check file extension
		echo 'Error: your file is not CSV.';
		@unlink($file_temp_loc); // remove to the temp folder
		exit();
	}
	if($file_size > 5242880) { // file check size
		echo "Error: you file was larger than 5 Megabytes in size.";
		exit();	
	}
	if($file_error_msg == 1) { // 
		echo "Error: an error occured while processing the file, try agian.";
		exit();	
	}  
	
	$move_file = move_uploaded_file($file_temp_loc, "uploadedexcels/{$file_name}"); // temp loc, file name
	if($move_file != true) { // if not move to the temp location
		echo 'Error: File not uploaded, try again.';
		@unlink($file_temp_loc); // remove to the temp folder
		exit();
	}


	$csvFile  = 'uploadedexcels/'.$file_name;
	$csvFileLength = filesize($csvFile);
	$csvSeparator = ",";
	$handle = fopen($csvFile, 'r'); 
	$flag = true;
	$count = '';
	while(($data = fgetcsv($handle, $csvFileLength, $csvSeparator)) !== FALSE) { // while for each row
		if(!$flag) {
		$count += count($data[0]); // count imported
					
					
		/****************************
		Checking if record is empty
		****************************/
		if($data[0] != '') {
		
			foreach($_POST as $key => $value) {
				$data[$key] = filter($value);
			}
			
			$vendor_name = $data['0'];
			$vendor_nick_name = $data['1'];
			$contactperson = $data['2'];
			$contact_no = $data['3'];
			$contact_email = $data['4'];
			$address = trim($data['5']);
			$gstin =  $data['6'];
			$pan = $data['7'];			
			$tan_no = $data['8'];
			$msg_no = $data['9'];
			$bank_name = $data['10'];
			$account_no = $data['11'];
			$neft_code = $data['12'];
			$payment_terms = trim($data['13']);
			$comments = trim($data['14']);

			$arrFields=array('`csvtype`', '`sessionID`','`field1`','`field2`','`field3`','`field4`','`field5`','`field6`','`field7`','`field8`','`field9`','`field10`','`field11`','`field12`','`field13`','`field14`','`field15`','`status`');

			$arrValues=array("6","$vendor_session_id","$vendor_name","$vendor_nick_name","$contactperson","$contact_no","$contact_email","$address","$gstin","$pan","$tan_no","$msg_no","$bank_name","$account_no","$neft_code","$payment_terms","$comments","1");

					if(sqlACTIONS("INSERT","js_tempcsv",$arrFields,$arrValues,'')) {
					//print_r($arrFields);
					//print_r($arrValues); exit();
					}
							 
			}//end of checking data
		} 
		$flag = false;
	}
	fclose($handle);
	unlink($csvFile); // delete csv after imported

		//RTW Product Log			
		echo "<div style='width: 350px; text-align: center; margin: 20% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we import loading...</div>";
		echo "<script type='text/javascript'>window.location = 'vendors.php?route=import&formtype=templist'</script>";
		exit();
?>
	<div class="form-group" id="process" style="display:none;">
        <div class="progress">
         <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
          <span id="process_data">0</span>
         </div>
        </div>
	   </div>
<?php }

if( $cancel_invoice == "Import") {

	$rowCount = count($_REQUEST["temp_id"]);
    //verified
    $verifiedon = date('Y-m-d'); 
    $createdby = $logged_user_id;
	if($rowCount > 0){
	for($i=0;$i<=$rowCount;$i++) {

	
		$temp_id = $_REQUEST['temp_id'][$i];
		$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_tempcsv` where `temp_id`='$temp_id' and status='1'") or die("Unable to get records:".sqlERROR_LABEL());

		while($fetch_records = sqlFETCHARRAY_LABEL($list_datas)){
			
			$vendor_name = $fetch_records['field1'];
			$vendor_nick_name = $fetch_records['field2'];
			$vendor_refno = getnewVENDOR('vendor','');
			$contactperson = $fetch_records['field3'];
			$contact_no = $fetch_records['field4'];							
			$contact_email = $fetch_records['field5'];
			$address = $fetch_records['field6'];
			$gstin = $fetch_records['field7'];
			$pan = $fetch_records['field8'];			
			$tan_no = $fetch_records['field9'];
			$msg_no = $fetch_records['field10'];
		    $bank_name = $fetch_records['field11'];
			$account_no = $fetch_records['field12'];
			$neft_code = $fetch_records['field13'];
			$payment_terms = $fetch_records['field14'];
			$comments = $fetch_records['field15'];
			$ofc_address_two = $fetch_records['field16'];
			$exist_email = CHECK_VENDOR_DATA($contact_email,'checkemail','');
			$exist_mobile = CHECK_VENDOR_DATA($contact_no,'checkmobile','');
		
			if($exist_email == '0' && $exist_mobile == '0') {

			$arrFields=array('`vendor_name`','`vendor_nickname`','vendor_code','`vendor_contactperson`','`vendor_contactnumber`','`vendor_contactemail`','`vendor_gst`','`vendor_pan`','`vendor_tan`','`vendor_msg`','`vendor_bank`','`vendor_bank_ac`','`vendor_bank_neft`','`vendor_address`','`vendor_payment_terms`','`vendor_comments`','`status`');

			$arrValues=array("$vendor_name","$vendor_nick_name","$vendor_refno","$contactperson","$contact_no","$contact_email","$gstin","$pan","$tan_no","$msg_no","$bank_name","$account_no","$neft_code","$address","$payment_terms","$comments","1");

				if(sqlACTIONS("INSERT","js_vendor",$arrFields,$arrValues,'')) 	
					{		
						$arrFields=array('`status`');
		
						$arrValues=array("2");
		
						$sqlWhere= "temp_id=$temp_id";
		
						if(sqlACTIONS("UPDATE","js_tempcsv", $arrFields, $arrValues, $sqlWhere))
		
						{				
		
						} else {
		
							$code = '0';
		
						}

				} else {

					$code = '0';

					}

				}else{	
	
						$arrFields=array('`status`');
			
						$arrValues=array("3");
			
						$sqlWhere= "temp_id='$temp_id'";
			
						if(sqlACTIONS("UPDATE","js_tempcsv", $arrFields, $arrValues, $sqlWhere))
			
						{				
			
						} else {
			
							$code = '0';
			
						}
	
				}
	
				}
	}

		} 

			echo "<div style='width: 350px; text-align: center; margin: 20% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we import loading...</div>";
		echo "<script type='text/javascript'>window.location = 'vendors.php?route=import&formtype=import_response'</script>";

		}

?>
    <div class="content">
      <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="row">
		<?php  if($formtype=='' && $route!='import' && $route!='templist' && $route!='import_response'){ ?>
          <div class="col-lg-12">
            <div class="row row-xs mg-b-25">
			<div data-label="Example" class="df-example demo-table table-responsive">
			  <table id="categoryLIST" class="table table-bordered" width="99%">
			    <thead>
			        <tr>
                        <th><?php echo $__contentsno ?></th>
			            <th>Vendor Name</th>
			            <th>Vendor Code</th>
			            <th>Contact Person</th>
			            <th>Contact Number</th>
			            <th>Contact Email</th>
			            <th>Vendor Address</th>
			            <th><?php echo $__status ?></th>
			            <th><?php echo $__status ?></th>
						<!--NOTE: [This is Status Label(Active/Inactive)] Above Status Used for Export the List Data This Field Hide in the List Table So Dont Remove this Field -->
			            <th><?php echo $__options ?></th>
			        </tr>
			    </thead>
			</table>
			</div>
<style>
tbody>tr>:nth-child(2){
 width:90px;
 min-width: 90px;
 max-width: 90px;
 text-align:left;
}
</style>			
	<?php } if($route=='import' && $formtype==''){ ?>
<form id="mainform" method="post" enctype="multipart/form-data" action="">
                        <div class="row justify-content-center">
                             <div class="col-lg-12">
	                      	   <h3 class="form-title text-center">
	                              	 Import Items 
		                        </h3>
		                        </div>
                            <div class="col-md-6 col-lg-6 col-xl-6 mx-auto">

                                <div class="card mb-4 mt-4">

                                    <div class="card-body">

                                        <div class="form-group">                                

                                            <div class="row">  

                                             <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 

                                                 <div class="form-group">

                                                       <label class="control-label">Upload your file  <span class="text-danger">*</span></label>

                                                          <div class="valitor">

                                                             <input name="csv" type="file" class="span6 m-wrap" />

                                                             <span class="help-block text-danger"> -Import .CSV format files only. Allowed size 5MB.<br> <a href="sample_vendor.csv">Click to download sample</a><br /></span>

                                                           </div>

                                                    </div>

                                             </div>

                                             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 

                                                
			                               	<button class="btn btn-primary buttonalign_save" type="submit" name="upload" value="import">
			                                   	<i class="fa fa-upload">&nbsp;</i> Upload
			                                	</button>
 
                                                </button>

                                               <a href="vendors.php?msg=success"class="btn btn-default">Return</a>

                                             </div>

                                            </div> 

                                        </div>                      

                                    </div>

                                </div>

                            </div>

                        </div>

                	</form>
	<?php } if($route=='import'  && $formtype=='templist'){ ?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="container mt-4 main-container">
        <div class="col-sm-12 p-0">
            <div class="card mb-4 fullscreen">
                <div class="card-header">
                    <div class="media">
                        <div class="media-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h4 class="content-color-primary mb-0">
                                        <?php echo "List Import"; ?>
                                    </h4>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-auto ml-auto">
                                            <input type="submit" class="btn btn-sm btn-rounded btn-primary text-uppercase pr-3" name="cancel_invoice" value="Import" id="cancel_button"></h4>
                                        </div>
                                        <!--   <div class="col-md-auto">
                                    <select name="branch_name" class="form-control">
                                    </select>
                                    </div> -->
                                        <!-- <div class="col-md-auto">
                                    <input type="submit" class="btn btn-sm btn-rounded btn-warning text-uppercase pr-3" name="assign_branch" value="Assign" id="assign_branch"></h4>

                               </div> 
                                        <div class="col-md-auto">
                                            <input type="submit" class="btn btn-sm btn-rounded btn-danger text-uppercase" name="deleteall" value="Delete" id="deleteall"></h4>
                                        </div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-responsive" id="contacts_list" width="100%">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="cancel_check" value="0" class="group-checkable" data-set="#contacts_list .checkboxes" onClick="checkboxfunction()" /></th>
                                <th>
                                    Vendor Name 
                                </th>
                                <th>
                                    Vendor Nick Name
                                </th>
                                <th>
                                    Contact Person 
                                </th>
                                <th>
                                    Contact No
                                </th>
                                <th>
                                   Contact Email
                                </th>
                                <th>
                                   Address
                                </th>
                                <th>
                                   GSTIN
                                </th>
                                <th>
                                   PAN 
                                </th>
                                <th>
                                   TAN No
                                </th>
                                <th>
                                   MSG No.
                                </th>
                                <th>
                                    Bank Name
                                </th>
								<th>
                                    A/C No
                                </th>
								<th>
                                    Neft Code
                                </th>
								<th>
                                    Payment Terms
                                </th>
								<th>
                                    Comments
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                                    $query= "SELECT * FROM `js_tempcsv` where `csvtype`='6' and `status`='1' and `sessionID` = '$vendor_session_id'";

                                                    $result = sqlQUERY_LABEL($query);

                                                    $num_row = sqlNUMOFROW_LABEL($result);

                                                    while($row = sqlFETCHARRAY_LABEL($result))

                                                    {	

                                                        $temp_id = $row['temp_id'];							

                                                        $field1 = $row['field1'];	

                                                        $field2 = $row['field2'];							

                                                        $field3 = $row['field3'];

                                                        $field4 = $row['field4'];							
														$field5 = $row['field5'];
                                                        $field6 = $row['field6'];		

                                                        $field7 = $row['field7'];

                                                        $field8 = $row['field8'];

                                                        $field9 = $row['field9'];

                                                        $field10 = $row['field10'];

                                                        $field11 = $row['field11'];

                                                        $field12 = $row['field12'];
                                                        $field13 = $row['field13'];
                                                        $field14 = $row['field14'];
                                                        $field15 = $row['field15'];
                                                        $field16 = $row['field16'];

                                                    
                                                ?>
                            <tr>
                                <td><input type="checkbox" class="checkboxes cancel_check2" value="<?php echo  $temp_id;?>" name="temp_id[]" onClick="checkfunction()" /></td>
                                <!-- <td> <input type="checkbox" class="checkboxes cancel_check2" value="<?php echo  $branch_id;?>" name="branch_id[]"/></td>-->
                                <input type="hidden" class="checkboxes cancel_check2" value="<?php echo  $branch_id;?>" name="branch_id[]" />
                                <td>
                                    <?php echo $field1; ?>
                                </td>
                                <td>
                                    <?php echo $field2; ?>
                                </td>
                                <td>
                                    <?php echo $field3;?>
                                </td>
                                <td>
                                    <?php echo $field4;?>
                                </td>
                                <td>
                                    <?php echo $field5;?>
                                </td>
                                <td>
                                    <?php echo $field6; ?>
                                </td>
                                <td>
                                    <?php echo $field7; ?>
                                </td>
                                <td>
                                    <?php echo $field8; ?>
                                </td>
                                <td>
                                    <?php echo $field9; ?>
                                </td>
                                <td>
                                    <?php echo $field10; ?>
                                </td>
                                <td>
                                    <?php echo $field11; ?>
                                </td>
								<td>
                                    <?php echo $field12; ?>
                                </td>
								<td>
                                    <?php echo $field13; ?>
                                </td>
								<td>
                                    <?php echo $field14; ?>
                                </td>
								<td>
                                    <?php echo $field15; ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</form>
<?php } ?>

       <?php  if($route=='import' && $formtype == 'import_response') { 

					$query_imported = "SELECT * FROM `js_tempcsv` where `csvtype`='6'  and `sessionID`='$vendor_session_id'";

					$result_imported = sqlQUERY_LABEL($query_imported);

					$num_of_row_total = sqlNUMOFROW_LABEL($result_imported);

					

					$query= "SELECT * FROM `js_tempcsv` where `csvtype`='6' and `available`='0' and `status`='2' and `sessionID`='$vendor_session_id'";

					$result = sqlQUERY_LABEL($query);

					$num_of_row_imported = sqlNUMOFROW_LABEL($result);					

					$balance_row = $num_of_row_total - $num_of_row_imported;
		

			?>
                    <div class="row ">

                    

                    <?php if($balance_row > '0') { ?>

                    

                    <div class="col-sm-12 p-0 mt-3">

                            <h3 class="text-center">OUT OF <?php echo $num_of_row_total; ?>, <?php echo $num_of_row_imported; ?> IMPORTED </h3><h3 class="text-center mb-4"><br>And List that not imported are having Duplicate Email or Phone number or Company</h3>

                    </div>

                        <div class="col-sm-12 p-0">

                            <div class="card mb-4 fullscreen">

                                <div class="card-header">

                                    <div class="media">

                                        <div class="media-body">

                                            <h4 class="content-color-primary mb-0"><?php echo $__list_import; ?></h4>

                                        </div>

                                    </div>

                                </div>

                                <div class="card-body">

                                    <table class="table table-bordered table-responsive" id="import_list" width="99%">                                      
                        <thead>
                            <tr>
                                <th>
									S.No
								</th>
                                <th>
                                    Vendor Name 
                                </th>
                                <th>
                                    Vendor Nick Name
                                </th>
                                <th>
                                    Contact Person 
                                </th>
                                <th>
                                    Contact No
                                </th>
                                <th>
                                   Contact Email
                                </th>
                                <th>
                                   Address
                                </th>
                                <th>
                                   GSTIN
                                </th>
                                <th>
                                   PAN 
                                </th>
                                <th>
                                   TAN No
                                </th>
                                <th>
                                   MSG No.
                                </th>
                                <th>
                                    Bank Name
                                </th>
								<th>
                                    A/C No
                                </th>
								<th>
                                    Neft Code
                                </th>
								<th>
                                    Payment Terms
                                </th>
								<th>
                                    Comments
                                </th>
                            </tr>
                        </thead>
						<tbody>
				<?php

							$query= "SELECT * FROM `js_tempcsv` where  `csvtype`='6' and `status` = '3' and `sessionID` = '$vendor_session_id'";

							$result = sqlQUERY_LABEL($query);

							$num_row = sqlNUMOFROW_LABEL($result);
							if($num_row > 0){
							while($row = sqlFETCHARRAY_LABEL($result))

							{	
							$counter_csv++;
							$field1 = $row['field1'];
							$field2 = $row['field2'];
							$field3 = $row['field3'];
							$field4 = $row['field4'];							
							$field5 = $row['field5'];
							$field6 = $row['field6'];
							$field7 = $row['field7'];
							$field8 = $row['field8'];
							$field9 = $row['field9'];
							$field10 = $row['field10'];
							$field11 = $row['field11'];
							$field12 = $row['field12'];
							$field13 = $row['field13'];
							$field14 = $row['field14'];
							$field15 = $row['field15'];

						?>
                                <tr>
								<td>
                                    <?php echo $counter_csv; ?>
                                </td>
                                             
                                <td>
                                    <?php echo $field1; ?>
                                </td>
                                <td>
                                    <?php echo $field2; ?>
                                </td>
                                <td>
                                    <?php echo $field3;?>
                                </td>
                                <td>
                                    <?php echo $field4;?>
                                </td>
                                <td>
                                    <?php echo $field5;?>
                                </td>
                                <td>
                                    <?php echo $field6; ?>
                                </td>
                                <td>
                                    <?php echo $field7; ?>
                                </td>
                                <td>
                                    <?php echo $field8; ?>
                                </td>
                                <td>
                                    <?php echo $field9; ?>
                                </td>
                                <td>
                                    <?php echo $field10; ?>
                                </td>
                                <td>
                                    <?php echo $field11; ?>
                                </td>
								<td>
                                    <?php echo $field12; ?>
                                </td>
								<td>
                                    <?php echo $field13; ?>
                                </td>
								<td>
                                    <?php echo $field14; ?>
                                </td>
								<td>
                                    <?php echo $field15; ?>
                                </td>
                                </tr>
                                        <?php }}else{ ?>   
                                        <tr>
                                        <td class="text-center" colspan='22'>No data Available</td>
                                        </tr>
                                        <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php }  else { ?>
                    <div class="col-sm-12 p-0 mb-5 mt-3">
                            <h3 class="text-center">OUT OF <?php echo $num_of_row_total; ?>, <?php echo $num_of_row_imported; ?> IMPORTED</h3>
                    </div>
                    <?php }if($formtype == 'import_response'){session_regenerate_id(); $vendor_session_id = session_id();} ?>
					
                    </div>
            <?php } ?> 
            </div><!-- row -->
          </div><!-- col -->
        </div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->