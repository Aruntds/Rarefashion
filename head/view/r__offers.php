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
  
if($upload == 'import') {
	
	$file_name = $_FILES['csv']['name'];
	$file_type 		= $_FILES['csv']['type'];
	$file_temp_loc 	= $_FILES['csv']['tmp_name'];
	$file_error_msg = $_FILES['csv']['error'];
	$file_size 		= $_FILES['csv']['size'];
	// echo $file_name;exit();
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
		
			$prdt_code = trim($data['0']);
		
			$prdt_id = getSINGLEDBVALUE('productID', " productsku='$prdt_code' and deleted = '0' and status = '1'", 'js_product', 'label');
 			$prdt_name = trim($data['1']);
			$prdt_name = str_replace('&quot;', "''", $prdt_name);
			$prdt_name = addslashes($prdt_name); //2
 			$prdt_price = trim($data['2']); //4
			
			if($prdt_gst_percentage == ''){
				$prdt_gst_percentage = '0';
			} else {
				$prdt_gst_percentage = $prdt_gst_percentage;
			}

			$arrFields=array('`csvtype`','`sessionID`','`field1`','`field2`','`field3`','`field4`','`status`');
			$arrValues=array("7","$product_session_id","$prdt_id","$prdt_code","$prdt_name","$prdt_price","1");

				if(sqlACTIONS("INSERT","js_tempcsv",$arrFields,$arrValues,'')) {
				//print_r($arrValues);
				}
			}//end of checking data
		} 
		$flag = false;
	}
	fclose($handle);
	unlink($csvFile); // delete csv after imported

		//RTW Product Log			
		echo "<div style='width: 350px; text-align: center; margin: 20% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we import loading...</div>";
		echo "<script type='text/javascript'>window.location = 'offers.php?route=import&id=$id&formtype=templist'</script>";
		exit();
?>
		<div class="form-group" id="process" style="display:none;">
        <div class="progress">
         <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
          <span id="process_data">0</span>
         </div>
        </div>
	   </div>

<?php
}

if( $import_product == "Import") {

	$rowCount = count($_REQUEST["temp_id"]);
    //verified
    $verifiedon = date('Y-m-d'); 
    $createdby = $logged_user_id;
	
	if($rowCount > 0){
	for($i=0;$i<=$rowCount;$i++) {
 
		$temp_id = $_REQUEST['temp_id'][$i];
		$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_tempcsv` where `temp_id`='$temp_id' and status='1'") or die("Unable to get records:".sqlERROR_LABEL());

		while($fetch_records = sqlFETCHARRAY_LABEL($list_datas)){

			$prdt_id = $fetch_records['field1'];
			$prdt_code = $fetch_records['field2'];
 			$prdt_name = trim($fetch_records['field3']);
			$prdt_name = str_replace('&quot;', "''", $prdt_name);
			$prdt_name = addslashes($prdt_name); //2
			$prdt_price = $fetch_records['field4'];
 				
				$start_date = getSINGLEDBVALUE('offers_start_date', " offers_id='$id' and deleted = '0'", 'js_offers', 'label');
 
				   $list_offer_datas = sqlQUERY_LABEL("SELECT COUNT(I.prdt_id) as total FROM `js_offers` AS O LEFT JOIN js_offers_items AS I ON I.prdt_id = '$prdt_id' WHERE CURRENT_TIMESTAMP < O.offers_expiry_date and '$start_date' between offers_start_date and offers_expiry_date ") or die("#1-Unable to get records:".mysql_error());

				  $count_offer_list = sqlNUMOFROW_LABEL($list_offer_datas);

				  while($row = sqlFETCHARRAY_LABEL($list_offer_datas)){
				 
					  $total = $row["total"];
				  }
				  
				  
				  
			if($total == 0 ) {
				$arrFields=array('`offers_id`','`prdt_id`','`offers_product_code`','`offers_product_name`','`offers_product_price`','`createdby`');
				
				$arrValues=array("$id","$prdt_id","$prdt_code","$prdt_name","$prdt_price", "$logged_user_id");
				// print_r($arrValues);
				// exit();
				if(sqlACTIONS("INSERT","js_offers_items",$arrFields,$arrValues,'')) {		
						$arrFields=array('`status`');
		
						$arrValues=array("2");
		
						$sqlWhere= "temp_id=$temp_id";

						if(sqlACTIONS("UPDATE","js_tempcsv", $arrFields, $arrValues, $sqlWhere)){
						
						} else {
							$code = '0';
						}

				} else {

					$code = '0';

					}

			} else {	

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
	echo "<script type='text/javascript'>window.location = 'offers.php?route=add&id=$id&code=1&switch=Y'</script>";
}

?>
    <div class="content">
	
      <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
	  
	   <?php  if($formtype=='' && $route !='import'){ ?>
	   
    <div class="row">
		
        <div class="col-lg-12">
		  
            <div class="row row-xs mg-b-25">

				<div data-label="Example" class="df-example demo-table table-responsive">
				
					<table id="VendorpoLIST" class="table table-bordered" width="100%">
					  
						<thead>
						
							<tr>
							
								<th><?php echo $__contentsno ?></th>
						  
								<th>Title</th>
								
								<th>Start Date</th>
								
								<th>Expiry Date</th>
								
								<th>Status</th>
								
								 
								
								<th><?php echo $__options ?></th>
								
							</tr>
							
						</thead>
						
					</table>
				
				</div>

            </div><!-- row -->
			
        </div><!-- col -->
<style>
.table td:first-child, .table th:first-child {
min-width: 40px;
max-width: 40px;
text-align:center;
}
tbody>tr>:nth-child(8){
 width:100px;
 min-width: 100px;
 max-width: 100px;
 text-align:left;
}
tbody>tr>:nth-child(9){
 width:100px;
 min-width: 100px;
 max-width: 100px;
 text-align:left;
}
tbody>tr>:nth-child(11){
 width:100px;
 min-width: 100px;
 max-width: 100px;
 text-align:left;
}
</style>
          <?php 
	          //include viewpath('__vendorsposidebar.php'); 
          ?>

    </div><!-- row -->
		<?php } if($route =='import' && $formtype ==''){?>
		                            <div class="col-md-4 col-lg-4 col-xl-4 mx-auto">
                                
								<div class="card mb-4">

                                    <div class="card-body">
										<form  method="post" enctype="multipart/form-data" >
                                        <div class="form-group">                                

                                            <div class="row">

                                             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 

                                                 <div class="form-group">

                                                       <label class="control-label">Upload your file  <span class="text-danger">*</span></label>

                                                          <div class="valitor">

                                                             <input name="csv" type="file" class="span6 m-wrap" /><br>

                                                             <span class="help-block"> Import .CSV format files only. Allowed size 5MB.<br> <a href="public/uploadedexcels/add_item_offer.csv">Click to download sample</a><br /></span>

                                                           </div>

                                                    </div>

                                             </div>

                                             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
												<input type="hidden" id="po_main_refid" name="po_main_refid" value="<?php echo $id; ?>" />
                                                <button class="btn btn-primary buttonalign_save" type="submit" name="upload" value="import">

                                                <i class="fa fa-upload">&nbsp;</i> Upload

                                                </button>

                                                <a href="offers.php?route=add&id=<?php echo $id; ?>&switch=Y"  class="btn btn-default">Return</a>

                                             </div>
                                             </div> 
                                         </div>                      
										</form>
								   </div>
                                 </div>
                             </div>
                    

		<?php } if($route =='import' && $formtype =='templist'){ ?>
			<form action="" method="post" id="templist" enctype="multipart/form-data">
					<div class="">
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
															<input type="submit" class="btn btn-sm btn-rounded btn-primary text-uppercase pr-3" name="import_product" value="Import" id="import_product"></h4>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="card-body">
									<table class="table table-bordered " id="contacts_list" width="100%">
										<thead>
											<tr>
												<th><input type="checkbox" id="cancel_check" value="0" class="group-checkable" data-set="#contacts_list .checkboxes" onClick="checkboxfunction()" /></th>
												<th class="wd-10p">
													Product Code 
												</th>
												<th class="wd-15p">
													Product Name
												</th>
 												<th>
													Purchase Price
												</th>
												 							
											</tr>
										</thead>
										<tbody>
										<?php
								$query= "SELECT * FROM `js_tempcsv` where `csvtype`='7' and `status`='1' and `sessionID` = '$product_session_id'";
								$result = sqlQUERY_LABEL($query);
								$num_row = sqlNUMOFROW_LABEL($result);
								while($row = sqlFETCHARRAY_LABEL($result))
								{
									$temp_id = $row['temp_id'];
									$field1 = $row['field1'];
									$field2 = $row['field2'];
									$field3 = $row['field3'];
									$field4 = $row['field4'];							
									 
								?>
								<tr>
									<td><input type="checkbox" class="checkboxes cancel_check2" value="<?php echo  $temp_id;?>" name="temp_id[]" onClick="checkfunction()" /> </td>
									<!-- <td> <input type="checkbox" class="checkboxes cancel_check2" value="<?php echo  $branch_id;?>" name="branch_id[]"/></td>-->
									<input type="hidden" class="checkboxes cancel_check2" value="<?php echo  $branch_id;?>" name="branch_id[]" />
									  
									<td>
										<?php echo $field2; ?>
									</td>
									<td>
										<?php echo $field3;?>
									</td>
									<td>
										<?php echo $field4;?>
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
      </div><!-- container -->
    </div><!-- content -->