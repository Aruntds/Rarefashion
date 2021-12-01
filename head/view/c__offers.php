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
 
if($action == 'import'){$po_session_id = session_id();}
 
if($save == "setting_offer") {
 
	$offerstatus = $validation_globalclass->sanitize($_REQUEST['offerstatus']);
	//if($offerstatus == 'on') { $offerstatus = '1'; } else { $offerstatus = '0'; }
	$offertitle = $validation_globalclass->sanitize(ucwords($_REQUEST['offertitle']));
	$offertype = $validation_globalclass->sanitize($_REQUEST['offertype']);
	$offers_start_date = $validation_globalclass->sanitize($_REQUEST['offers_start_date']);
	$offers_expiry_date = $validation_globalclass->sanitize($_REQUEST['offers_expiry_date']);
	
	  $offers_start_date = ($offers_start_date);
	  $offers_expiry_date = ($offers_expiry_date);
// exit();

	$media_path = "public/uploads/offers_banner/";

	$valid_formats = array("jpg", "jpeg", "png", "gif", "bmp");
	$media_name = $_FILES['offersimage']['name'];
	$media_size = $_FILES['offersimage']['size'];

 //if($check_record_availabity == '0'){
	if(strlen($media_name))
	{
		
		list($txt, $ext) = explode(".", $media_name);
		if(in_array($ext,$valid_formats))
		{
			
		if($media_size <(1000*1000))
			{
			 
				$offersimage = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
				$tmp = $_FILES['offersimage']['tmp_name'];

				if(move_uploaded_file($tmp, $media_path.$offersimage)) {
				
				$offersimage = $offersimage;
				 
				} else { 
 				
					$err[] =  "failed"; 
				}
			} else { 
				$err[] = "Image file size max 1 MB";	 
			}
		} else { 
			$err[] =  "Invalid file format..";	 
		}
	}else{
		$offersimage = $old_categoryimage;
	} 
	
  // echo $media_name; exit();

    if($id == ''){
		
		//Insert query
		$arrFields=array('`offers_name`','`offers_type`','`offer_value`','`offer_qty`','`offers_start_date`','`offers_expiry_date`', '`offersimage`', '`offer_description`', '`offers_seourl`', '`offers_metatitle`', '`offers_metakeywords`', '`offers_metadescription`','`createdby`');

		$arrValues=array("$offertitle","$offertype","$offer_value","$offer_qty","$offers_start_date","$offers_expiry_date","$offersimage","$offer_description","$offers_seourl","$offers_metatitle","$offers_metakeywords","$offers_metadescription","$logged_user_id");

		if(sqlACTIONS("INSERT","js_offers",$arrFields,$arrValues,'')) {
		
			//log
			$vpo_id = sqlINSERTID_LABEL();
				?>
			<script type="text/javascript">window.location = 'offers.php?route=add&id=<?php echo $vpo_id; ?>&code=1&switch=Y' </script>
			<?php
		} 
	} else {
			
			$arrFields=array('`offers_name`','`offers_type`','`offer_value`','`offer_qty`','`offers_start_date`','`offers_expiry_date`', '`offersimage`', '`offer_description`', '`offers_seourl`', '`offers_metatitle`', '`offers_metakeywords`', '`offers_metadescription`','`createdby`');

			$arrValues=array("$offertitle","$offertype","$offer_value","$offer_qty","$offers_start_date","$offers_expiry_date","$offersimage","$offer_description","$offers_seourl","$offers_metatitle","$offers_metakeywords","$offers_metadescription","$logged_user_id");
			$sqlWhere= "offers_id='$id'";
			
			
			if(sqlACTIONS("UPDATE","js_offers",$arrFields,$arrValues, $sqlWhere)) {
				
					?>
				<script type="text/javascript">window.location = 'offers.php?route=add&id=<?php echo $id; ?>&code=1&switch=Y' </script>
				<?php
			}
		} 
}

if($save == "save-createnew" || $save == "save-draft") {
	if($save == "save-createnew"){
	$offer_status = "1";	
	}
	if($save == "save-draft"){
	$offer_status = "0";	
	}
	
			$arrFields=array('`offer_status`');

			$arrValues=array("$offer_status");
			
			$sqlWhere= "offers_id='$id'";
			
			
			if(sqlACTIONS("UPDATE","js_offers",$arrFields,$arrValues, $sqlWhere)) {
				
					?>
				<script type="text/javascript">window.location = 'offers.php?&code=1' </script>
				<?php
			}
}
if($delete == "delete_selected" ) {
	
	  $rowCount = count($_REQUEST["offers_item_id"]);
 	 // echo  $rowCount; exit();
	  if($rowCount > 0){
		  for($i=0;$i<=$rowCount;$i++) {
	 
			  $offers_item_id = $_REQUEST['offers_item_id'][$i];
				 sqlACTIONS("DELETE","js_offers_items",'','',"offers_item_id = '$offers_item_id'");
		   }
	
	  }
	 
	 ?>
	<script type="text/javascript">window.location = 'offers.php?route=add&id=<?php echo $id; ?>&code=1&switch=Y' </script>
   <?php
    exit();
   }

if($id != '') {
	$getvendor_polist = sqlQUERY_LABEL("select * from `js_offers` where `offers_id` = '$id' and deleted='0'") or die("Unable to get VENDOR detail: ".sqlERROR_LABEL());
	while($collect_vendor_polist = sqlFETCHARRAY_LABEL($getvendor_polist)) {
	   $offers_id = $collect_vendor_polist['offers_id'];
	   $offers_name = $collect_vendor_polist['offers_name'];
	   $offers_type_num = $collect_vendor_polist['offers_type'];
	   $selected_type_id = $collect_vendor_polist['offers_type'];
	   $offer_qty = $collect_vendor_polist['offer_qty'];
	   $offer_value = $collect_vendor_polist['offer_value'];
	   $offer_status = $collect_vendor_polist['offer_status'];
	   $start_date = $collect_vendor_polist['offers_start_date'];
	   $offersimage = $collect_vendor_polist['offersimage'];
	   $offer_description = $collect_vendor_polist['offer_description'];
	   $offers_seourl = $collect_vendor_polist['offers_seourl'];
	   $offers_metatitle = $collect_vendor_polist['offers_metatitle'];
	   $offers_metakeywords = $collect_vendor_polist['offers_metakeywords'];
	   $offers_metadescription = $collect_vendor_polist['offers_metadescription'];
	   if($offers_type_num == '0'){
		   $offers_type = EMPTYFIELD;
	   } else if($offers_type_num == '1'){
		   $offers_type = 'BOGO';
		   $offers_type_req = 'Offer Qty';
	   } else if($offers_type_num == '2'){
		   $offers_type = 'Flat Discount';
		   $offers_type_req = 'Offer Amount';
	   } else if($offers_type_num == '3'){
		   $offers_type = 'Percenatge Discount';
		   $offers_type_req = 'Offer Percentage';
	   }
		$offers_start_date = date_create($collect_vendor_polist['offers_start_date']);
		$offers_start_date = date_format($offers_start_date,"Y/m/d H:i");
		$offers_expiry_date = date_create($collect_vendor_polist['offers_expiry_date']);
		$offers_expiry_date = date_format($offers_expiry_date,"Y/m/d H:i");
		if(!empty($offersimage)) {
			//upload PATH
			$media_path = "public/uploads/offers_banner/$offersimage";
		} else {
			//upload PATH
			$media_path = "public/img/blank-placeholder.jpg";
		}
	
	}
	} else {
		$media_path = "public/img/blank-placeholder.jpg";
	}

?>
    <div class="content">
      <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="row">
          <div class="col-lg-12">
            <div class="mg-b-25">

				<form method="post" enctype="multipart/form-data" data-parsley-validate>
				  
				<!-- BASIC Starting -->
				<div id="basic">
				  
					<?php if($route == 'add'){
						if($id != ''  && $switch == 'Y') {  
					
					
?>	
			     <div class="divider-text"><?php echo $__hbasicoffers ?></div>

				<input type="hidden" id="id_offers" name="id_offers" value="<?php echo $offers_id; ?>" />
					<div class="card mb-3">
						<div class="card-body">	
							<div class="row col-md-12 ">
								<div class="col-md-1"></div>
								<div class="col-md-2">
									Offers Title: <br/><b><?php echo $offers_name; ?></b>
								</div>
								<div class="col-md-2">
									Offer Type: <br/><b><?php echo $offers_type ;?></b>
								</div>
  								<div class="col-md-2">
									Offers Start Date: <br/><b><?php echo $offers_start_date; ?></b>
								</div>
								<div class="col-md-2">
									Offers Expiry Date: <br/><b><?php echo $offers_expiry_date; ?></b>
								</div>
								<div class="col-md-3 pull-right">
								 <a href="offers.php?route=add&id=<?php echo $id; ?>&switch=N" class="text-danger">Exit Compact Mode</a>
								</div>
							</div>
						</div>
					</div>
						<?php
						} else {
							
						?>  
							<?php if($id != '') { ?>
							<div class="form-group row mg-b-0">
									<div class="col-3 col-sm-6">
										<?php pageCANCEL($currentpage, $__cancel); ?>
									</div>
									<div class="col-9 col-sm-6 text-right">
									<button type="submit" name="save" value="setting_offer"  class="btn btn-success"> Update & Continue</button>
									<div class="form-group mg-md-t-30">
									<a href="offers.php?route=add&id=<?php echo $id; ?>&switch=Y" class="text-danger">
									Next page
									</a>
								</div>
									</div>
								  </div>
								  
 							<?php }  else { ?>
								  <div class="form-group row mg-b-0">
									<div class="col-3 col-sm-6">
										<?php pageCANCEL($currentpage, $__cancel); ?>
									</div>
									<div class="col-9 col-sm-6 text-right">
									  <button type="submit" id="save" name="save" value="setting_offer" class="btn btn-primary ember-view">Save & Continue</button>
									</div>
								  </div>
							<?php } ?>
						<div id="basic">
						  <div class="divider-text"><?php echo $__hbasicoffers; ?></div>
						  
						  <div class="form-group row">
							<label for="offerstatus" class="col-sm-2 col-form-label"><?php echo $__active ?></label>
							<div class="col-sm-6">
								<div class="custom-control custom-switch">
								  <input type="checkbox" class="custom-control-input" name="offerstatus" id="offerstatus" checked="">
								  <label class="custom-control-label" for="offerstatus">Yes</label>
								</div>
							</div>
						  </div>

						  <div class="form-group row">
							<label for="categoryparentID" class="col-sm-2 col-form-label"><?php echo $__offertitle ?> <span class="tx-danger">*</span></label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="offertitle" id="offertitle" data-parsley-whitespace="trim" data-parsley-trigger="keyup" autocomplete="off" required placeholder="<?php echo $__offertitle ?>" value="<?php echo $offers_name ?>">  		      
							</div>
						  </div>

						  <div class="form-group row">
							<label for="categoryparentID" class="col-sm-2 col-form-label"><?php echo $__offertype; ?> <span class="tx-danger">*</span></label>
							<div class="col-sm-6">
								<select name="offertype" id="offertype" class="custom-select" onclick="check_offer_value()" required>
									<option value="0" <?php if($selected_type_id == '0'){ echo "selected"; } ?>>Select Type</option>
									<option value="1" <?php if($selected_type_id == '1'){ echo "selected"; } ?>>BOGO</option>
									<option value="2" <?php if($selected_type_id == '2'){ echo "selected"; } ?>>Flat Discount</option>
									<option value="3" <?php if($selected_type_id == '3'){ echo "selected"; } ?>>Percentage Discount</option>
								</select>
							</div>
						  </div>

						  <div class="form-group row">
							<label for="categoryparentID" class="col-sm-2 col-form-label"> Offer's Max Qty <span class="tx-danger">*</span></label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="offer_qty" id="offer_qty" data-parsley-whitespace="trim" data-parsley-trigger="keyup" autocomplete="off" required placeholder=" " value="<?php echo $offer_qty ?>">  		      
							</div>
						  </div>
						  <div class="form-group row" id="offer_val_div" <?php if($selected_type_id =='0'|| $id ==''){?>style="display:none" <?php } ?>>
							<label for="categoryparentID" class="col-sm-2 col-form-label"> <span id="offer_val" ><?php echo $offers_type_req ; ?></span> <span class="tx-danger">*</span></label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="offer_value" id="offer_value" data-parsley-whitespace="trim" data-parsley-trigger="keyup" autocomplete="off" required placeholder="" value="<?php echo $offer_value ?>">  		      
							</div>
						  </div>
						
						  <div class="form-group row">
							<label for="categoryparentID" class="col-sm-2 col-form-label"> Offer Start Date & time <span class="tx-danger">*</span></label>
							<div class="col-sm-6">
							<?php if($offer_status != '1'){ ?>
								<input type="text" class="form-control" name="offers_start_date" id="offers_start_date" value="<?php echo $offers_start_date; ?>" placeholder="DD/MM/YYYY" required>
							<?php }else{ ?>
								<input type="text" class="form-control" name="offers_start_date_" id="offers_start_date_" value="<?php echo $offers_start_date; ?>" placeholder="DD/MM/YYYY" disabled>
								<input type="hidden" name="offers_start_date" id="offers_start_date" value="<?php echo $offers_start_date; ?>" placeholder="DD/MM/YYYY" required>
							<?php } ?>
							</div>
						  </div>
						  <div class="form-group row">
							<label for="categoryparentID" class="col-sm-2 col-form-label">Offer End Date & time<span class="tx-danger">*</span></label>
							<div class="col-sm-6">
							<?php if($offer_status != '1'){ ?>
								<input type="text" class="form-control" name="offers_expiry_date" id="offers_expiry_date" value="<?php echo $offers_expiry_date; ?>" placeholder="DD/MM/YYYY" required>
							<?php }else{ ?>
								<input type="text" class="form-control" name="offers_expiry_date_" id="offers_expiry_date_" value="<?php echo $offers_expiry_date; ?>" placeholder="DD/MM/YYYY" disabled >
								<input type="hidden" name="offers_expiry_date" id="offers_expiry_date" value="<?php echo $offers_expiry_date; ?>" placeholder="DD/MM/YYYY" required>
							<?php } ?>
								
							</div>
						  </div>
						   <div class="form-group row">
							<label for="imageupload" class="col-sm-2 col-form-label">Banner Image</label>
												
							<div class="col-sm-6">
									<div class="custom-file">
									  <input type="file" class="custom-file-input" name="offersimage" id="offersimage" value="<?php echo $offersimage; ?>" >
									  <label class="custom-file-label" for="customFile"><?php echo $__categorieschoosefile ?></label>
									  <input type="hidden" name="old_categoryimage" value="<?php echo $offersimage; ?>">
									</div>

									<div class="media-upload">
										<div class="avatar-preview">
											<div id="imagePreview" style="background-image: url(<?php echo $media_path; ?>);">
											</div>
										</div>
									</div>
									 
							</div>
						  </div>
						    <div class="form-group row">
							<label for="categoryparentID" class="col-sm-2 col-form-label"> Offer Description <span class="tx-danger">*</span></label>
							<div class="col-sm-6">
								<textarea type="text" class="form-control" name="offer_description" id="offer_description" data-parsley-whitespace="trim" data-parsley-trigger="keyup" autocomplete="off" ><?php echo $offer_description ?></textarea>		      
							</div>
						  </div>
						  <div id="seo">

				  <div class="divider-text"><?php echo $__hseosettings ?></div>

				  <div class="form-group row">
				    <label for="offers_seourl" class="col-sm-2 col-form-label"><?php echo $__contentseourl ?></label>
				    <div class="col-sm-7">
				      <input type="text" class="form-control" name="offers_seourl" id="offers_seourl" placeholder="SEO URL" value="<?php echo $offers_seourl; ?>">
				    </div>
				  </div>

				  <div class="form-group row">
				  	<label for="offers_metatitle" class="col-sm-2 col-form-label"><?php echo $__contentmetatitle ?></label>
					<div class="col-sm-7">

						  <input type="text" class="form-control" placeholder="Meta Title" name="offers_metatitle" id="offers_metatitle" value="<?php echo $offers_metatitle; ?>">
					</div>
				  </div>

				  <div class="form-group row">
				  	<label for="offers_metakeywords" class="col-sm-2 col-form-label"><?php echo $__meta_keyword ?></label>
					<div class="col-sm-7">
						  <input type="text" class="form-control" placeholder="Meta Keywords" name="offers_metakeywords" id="offers_metakeywords" value="<?php echo $offers_metakeywords; ?>">
					</div>
				  </div>

				  <div class="form-group row">
				  	<label for="offers_metadescription" class="col-sm-2 col-form-label"><?php echo $__meta_desc ?></label>
					<div class="col-sm-7">
						  <textarea class="form-control" rows="2"  name="offers_metadescription" id="offers_metadescription"><?php echo $offers_metadescription; ?></textarea>
					</div>
				  </div>

				</div>
						</div>
					 <?php 
					}
					}
							?>
						<div class="clearfix"></div>
						<?php 
								if($id != '' && $route == "add" && $switch == 'Y') {  
								//if($offer_status == '0'){
								
								?>
							<div class="row">		
								<h4 class="mg-l-15">Add Products <span class="text-danger">*</span></h4>
							</div>							
							<div class="row">
								<div class="form-group col-md-5">
 								<input type="text" class="form-control" style="width: 278.5px;" name="product-data" placeholder="Start typing or scanning..." id="product-data">
								<input type="hidden" value="<?php echo $start_date; ?>" name="start_date" id="start_date">
								</div>
 								 <div class="col-lg-2">
 									<a href="offers.php?route=import&id=<?php echo $id; ?>" class="btn btn-sm btn-outline-danger">Import</a>
                                  </div> 
								</div>
								<span class="text-danger" id="msg_warning"></span>
								<span class="text-success" id="msg_success"></span>
 								 <!-- ajax for getting choosen product -->
							<div id="quickbill_offer_details">
								<div id="hidden_productcode">
									<div class="row">		
									<div class="form-group col-sm-2">
										<label class="control-label">Product Code</label>
										<input type="text" class="form-control" readonly="readonly" name="prdt_code" id="prdt_code" placeholder="Product Code">
									</div>
									<div class="form-group col-sm-4">
										<label class="control-label">Product Name</label>
										<input type="text" class="form-control" placeholder="Product Name" readonly="readonly" name="prdt_name" id="prdt_name">
									</div>
									 
									<div class="form-group col-sm-2">
										<label class="control-label">Product Price</label>
										<input type="text" class="form-control" placeholder="Product Price" readonly="readonly" name="prdt_purchase_price" id="prdt_purchase_price">
									</div>
									                      
								 </div>
								</div>
								 <!-- end of ajax -->    
							</div>
							
								<?php //} ?>
							</div>
							 
						<div id="progress_table" style="display:none;" class="text-center">Loading...</div>
							 <div class="float-right mg-b-10">
 									<button type="submit" value="delete_selected" name="delete" class="btn btn-sm btn-danger">Delete</button>
                                  </div> 
						<table class="table table-bordered" id="show_product_list">
							<thead >
							<tr>
								<td><input type="checkbox" id="cancel_check" value="0" class="group-checkable_DELETE" data-set="#contacts_list .checkboxes" onClick="checkboxfunction()"/></td>
								<th class="text-center">#</th>
								<th class="">Product Code</th>
								<th class="">Product Name</th>
 								<th class="text-center wd-20p">Item Price</th>
								 
							</tr>
							<tr>
							</thead>
							<tbody>
							 
										<?php
										
                                            $selectpo_itemlist = sqlQUERY_LABEL("select * FROM `js_offers_items` where `offers_id`='$id' ORDER BY `offers_item_id` DESC") or die(sqlERROR_LABEL());
                                            $count_itemlist = sqlNUMOFROW_LABEL($selectpo_itemlist);
                                            
                                            if($count_itemlist > 0) {
                                                while($collect_poitem_list = sqlFETCHARRAY_LABEL($selectpo_itemlist)) {
                                                    $counter++;
                                                    $offers_item_id = $collect_poitem_list['offers_item_id'];
                                                    $offers_product_code = $collect_poitem_list['offers_product_code'];
                                                    $offers_product_name = $collect_poitem_list['offers_product_name'];
                                                    $product_name =  html_entity_decode($offers_product_name, ENT_QUOTES, "UTF-8");
                                                    $offers_product_price = $collect_poitem_list['offers_product_price'];
                                                    
                                                    ?>
                                                    <tr id="dummy_po_list_<?php echo $item_id; ?>">
													<td><input type="checkbox" class="checkboxes cancel_check2" value="<?php echo  $offers_item_id;?>" name="offers_item_id[]" onClick="checkfunction()" /> </td>
                                                        <td class="text-center"><?php echo $counter; ?></td>
                                                        <td class="text-center"><?php echo $offers_product_code; ?></td>
                                                        <td class="text-center"><?php echo $product_name; ?></td>
 
                                                        <td class="text-center"> <?php echo $offers_product_price; ?></td>
                                                         
                                                    </tr>
                                                    <?php
                                                }  //end of vendor po item while loop
                                            } else {
                                                echo '<tr id="dummy_po_list"><td colspan="5" align="center">"Start adding Products"</td></tr>';
                                            }
                                        ?>
							</tbody>
					
					</table>                             

						<div class="bottom-60px"></div>
					 
						<div class="row fixed-actions mg-l-2">
							<div class="col-md-6 col-sm-12" id="show_po_product_total_list">
								<div class="investment-summary" style="float:left; padding-right: 20px;">
									<span class="info-label" style="display:inline;">Total Product:</span>
									<span class="inv-green"><strong><?php echo ($count_itemlist); ?></strong></span>
								</div>
							<input type="hidden" id="po_totalpaid" name="po_totalpaid" value="<?php echo $po_after_discounted_item_total; ?>" />
							<input type="hidden" id="po_totaltaxadded" name="po_totaltaxadded" value="<?php echo $po_totaltaxadded; ?>" />
							<input type="hidden" id="po_itemcount" name="po_itemcount" value="<?php echo $po_itemcount; ?>" />
							<input type="hidden" id="product_item_qty" name="product_item_qty" value="<?php echo $product_item_qty; ?>" />
							</div>
						<div class="col-sm-4 mg-t-10 mg-md-t-0 ml-auto md-text-right text-center">
								<input type="hidden" id="vpo_id_for_list" name="vpo_id_for_list" value="<?php echo $id; ?>" />
								<input type="hidden" id="po_vendor_no" name="po_vendor_no" value="<?php echo $selected_vpo_no; ?>" />
								<input type="hidden" id="po_vendor_id" name="po_vendor_id" value="<?php echo $selected_vpo_vendor_id; ?>" />
								<input type="hidden" id="po_vendor_status" name="po_vendor_status" value="<?php echo $selected_vpo_status; ?>" />
								
								<input type="hidden" id="po_created_date" name="po_created_date" value="<?php echo $selected_vpo_date; ?>" />
								
								<?php if($offer_status == '0') { ?>
								 
								<button type="submit" id="save" name="save" value="save-draft" class="btn btn-success ember-view mg-md-r-1 mg-t-20">Save as Draft</button>
								<button type="submit" id="save" name="save" value="save-createnew" class="btn btn-success ember-view mg-t-20">Save & Complete</button>
								<?php } ?>
								<a href="offers.php" class="btn btn-secondary mg-t-20 mg-md-t-20 mg-md-l-1">Cancel</a>
							</div>
						</div>
				</div>
				<!-- End of BASIC -->
					<?php }  ?>
				</form>

          </div><!-- col -->
          
          <?php 
	          // $vendorspo_sidebar_view_type='create';
	          // include viewpath('__vendorsposidebar.php'); 
          ?>
            </div><!-- row -->
			</div><!-- row -->
            </div><!-- row -->
        </div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->   