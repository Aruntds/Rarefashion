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

//Insert Operation
if( $save == "update" && $hidden_categoryID != '') {

	$categorytitle = $validation_globalclass->sanitize($_REQUEST['categorytitle']);

	$categorycode = $validation_globalclass->sanitize(ucwords($_REQUEST['categorycode']));

	$categorystatus = $_REQUEST['categorystatus']; //value='on' == 1 || value='' == 0
	if($categorystatus == 'on') { $category_status = '1'; } else { $category_status = '0'; }
	

					//Insert query
					$arrFields=array('`categorytitle`','`categorycode`','`createdby`','`status`');

					$arrValues=array("$categorytitle","$categorycode","$logged_user_id","$category_status");

					$sqlWhere= "categoryID=$hidden_categoryID";

					if(sqlACTIONS("UPDATE","js_category",$arrFields,$arrValues, $sqlWhere)) {
						
						echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";

						?>
						<script type="text/javascript">window.location = 'category.php?code=1' </script>
						<?php

						exit();

					} else {

						$err[] =  "Unable to Insert Record"; 


	}

}

if($route == 'edit' && $id != '') {

	//`categoryID`, `categoryparentID`, `categoryname`, `categoryimage`, `categorydescrption`, `categoryseourl`, `categorymetatitle`, `categorymetakeywords`, `categorymetadescrption`, `categorydesignsettings`, `createdby`, `createdon`, `updatedon`, `status`, `deleted` FROM `js_category`
	$list_datas = sqlQUERY_LABEL("SELECT * FROM `js_category` where deleted = '0' and `categoryID`='$id'") or die("Unable to get records:".sqlERROR_LABEL());			
	$check_record_availabity = sqlNUMOFROW_LABEL($list_datas);			

	while($row = sqlFETCHARRAY_LABEL($list_datas)){
	  $categoryID = $row["categoryID"];
	  $categorytitle = $row["categorytitle"];
	  $categorycode = $row["categorycode"];
	  $status = $row["status"];

	}
	
}
?>

    <div class="content">
      <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="row">
          <div class="col-lg-9">
            <div class="mg-b-25">

			<form method="post" enctype="multipart/form-data" data-parsley-validate>
				  
				  <div id="stick-here"></div>
				  <div id="stickThis" class="form-group row mg-b-0">
					<div class="col-3 col-sm-6">
				  		<?php pageCANCEL($currentpage, $__cancel); ?>
				    </div>
				    <div class="col-9 col-sm-6 text-right">
				      <button type="submit" name="save" value="update" class="btn btn-warning"><?php echo $__update ?></button>
                      <input type="hidden" name="hidden_categoryID" value="<?php echo $categoryID; ?>" />
				    </div>
				  </div>

				<!-- BASIC Starting -->
				<div id="basic">
				  <div class="divider-text"><?php echo $__hbasicinfo ?></div>
				  <div class="form-group row">
				  	<label for="categorystatus" class="col-sm-2 col-form-label"><?php echo $__active ?></label>
					<div class="col-sm-7">
						<div class="custom-control custom-switch">
						  <input type="checkbox" class="custom-control-input" name="categorystatus" id="categorystatus" checked="">
						  <label class="custom-control-label" for="categorystatus">Yes</label>
						</div>
					</div>
				  </div>
				
					<div class="card mb-3">
						<div class="card-body">	
							<div class="row col-md-12 ">
								<div class="col-md-2">
									PO No: <b>HSN</b>
								</div>
								<div class="col-md-2">
									PO Type: TEST</b>
								</div>
								<div class="col-md-3">
									PO Date: <b>22-10-2000</b>
								</div>
								<div class="col-md-3">
									Vendor: <b>NEW TEST</b><br />
								</div>
								<div class="pull-right">
								 <a href="create_vendorpo.php?vendor_porefno=<?php echo $getvendor_porefno; ?>&switch=N" class="text-danger">Exit Compact Mode</a>
								</div>
							</div>
						</div>
					</div>
					
					<div class="row col-md-12">
						<div class="form-group col-md-3">
							<label for="prdt_type" class="control-label">Product Type</label>
							<select name="prdt_type" id="prdt_type" class="form-control selectpicker" data-live-search="true">
								<option>--</option>
							</select>
						</div>
						<div class="form-group col-md-3"><!--onchange="get_product_list();" data-live-search="true"-->
							<label for="vendor_id" class="control-label">Vendor</label>
							<select name="vendor_id" id="vendor_id" class="form-control selectpicker" data-live-search="true">
								<option value="0">--</option>
							</select>
						</div>                                
						<div class="form-group col-sm-3">
							<label for="vpo_date" class="control-label">P.O Date</label>
							<input type="text" class="form-control" placeholder="DD/MM/YYYY" name="vpo_date" id="vpo_date">
						</div>

						<div class="form-group col-md-3 mg-t-30">
							<input type="hidden" name="vendor_porefno" value="<?php echo getPAYMENTMODE($getvendor_porefno); ?>" />
							<?php if($getbillrefno != '') { ?>
								<button type="submit" id="save" value="setting_purchaseorder" name="button" class="btn btn-success"> Update</button>
								<a href="create_vendorpo.php?vendor_porefno=<?php echo $getvendor_porefno; ?>&switch=Y" class="text-danger">
								Switch to Compact Mode
								</a>
							<?php }  else { ?>
								<button type="submit" id="save" name="button" value="setting_purchaseorder" class="btn btn-success ember-view">Save Vendor</button>
							<?php } ?>
						</div>

					</div>
					
						<div class="clearfix"></div>
				
								<h4 class="mg-l-15">Add Products</h4>
								<div class="row mg-l-1">
								<div class="form-group col-md-5">
								<input type="text" class="form-control" name="product-data" placeholder="Start typing or scanning..." id="product-data">
								</div>
								</div>
								
								<div class="row col-md-12">							
								 <!-- ajax for getting choosen product -->
									<div class="form-group col-sm-2">
									<label class="control-label">Product Code</label>
									<input type="text" class="form-control" readonly="readonly" name="prdt_code" id="prdt_code">
									</div>
									<div class="form-group col-sm-4">
									<label class="control-label">Product Name</label>
									<input type="text" class="form-control" placeholder="Product Name" readonly="readonly" name="prdt_name" id="prdt_name">
									</div>
									<div class="form-group col-sm-2">
									<label class="control-label">Product Qty</label>
									<input type="text" class="form-control" placeholder="Qty" readonly="readonly" name="prdt_roq" id="prdt_roq">
									</div>
									<div class="form-group col-sm-2">
									<label class="control-label">Product Price</label>
									<input type="text" class="form-control" placeholder="Price" readonly="readonly" name="prdt_purchase_price" id="prdt_purchase_price">
									</div>
									<div class="form-group col-sm-2">
									<label class="control-label">TAX (in %)</label>
									<input type="text" class="form-control" placeholder="Tax" readonly="readonly" name="prdt_tax" id="prdt_tax">
									</div>                          
								 </div>
								 <!-- end of ajax -->    
								
							</div>
						
						<div id="progress_table" style="display:none;" class="text-center">Loading...</div>

						<table class="table table-bordered table-responsive mg-l-15">
							<thead >
							<tr>
								<th rowspan="2" class="text-center">#</th>
								<th rowspan="2">Product Code</th>
								<th rowspan="2">Product Name</th>
								<th rowspan="2" class="text-center">Qty</th>
								<th width="15%" class="text-center">Item Price</th>
								<th colspan="2" class="text-center">Tax</th>
								<th width="15%" class="text-center">Item Total</th>
								<th rowspan="2">Option</th>
							</tr>
							<tr>
								<th class="text-center small">(in INR)</th>
								<th class="text-center small">CGST (INR)</th>
								<th class="text-center small">SGST (INR)</th>
								<th class="text-center small" style="border-right-width:1px;">(in INR)</th>
							</tr>
							</thead>
							<tbody id="show_po_product_list">
										<tr id="dummy_po_list_<?php echo $item_id; ?>">
											<td class="text-center">1</td>
											<td width="20%">HSN522</td>
											<td width="25%">BRITANIA</td>
											<td class="text-center">2</td>
											<td class="text-right">10.00</td>
											<td class="text-right">1.55</td>
											<td class="text-right">1.55</td>
											<td class="text-right">13.10</td>
											<td width="10%">
												<a href="javascript:;" onClick="remove_po_productitem_List(<?php echo $item_id; ?>);">
												Delete
												</a>
											</td>
										</tr>
							</tbody>
							<tfoot>
								  <tr>
									<td colspan="2" class="text-right">
									<b>Returned by:</b>
									</td>
									<td colspan="7">
										<select class="selectpicker" data-live-search="true" name="vpor_approvedby" required id="vpor_approvedby">

										<option>--</option>
										</select>                                                    
									</td>
								  </tr>                                       
								  <tr>
									<td colspan="2" class="text-right">
									<b>Notes (optional):</b>
									</td>
									<td colspan="7">
										<textarea class="form-control" name="vpor_remarks" rows="3" required><?php if($selected_vpor_remarks) { echo $selected_vpor_remarks; } ?></textarea>
									</td>
								  </tr>                                     
							</tfoot>
						</table>                             

						<div class="bottom-60px"></div>
						
						<div class="row fixed-actions mg-l-2">
							<div class="col-md-6" id="show_po_product_total_list">
								<div class="investment-summary" style="float:left; padding-right: 20px;">
									<span class="info-label" style="display:inline;">Total:</span>
									<span class="inv-green"><strong>13.10</strong></span>
								</div>
								<div class="investment-summary" style="float:left; padding-right: 20px;">
									<span class="info-label" style="display:inline;">Total Item:</span>
									<span class="inv-green"><strong>1</strong></span>
								</div>
								<div class="investment-summary" >
									<span class="info-label" style="display:inline;">Total Qty:</span>
									<span class="inv-green"><strong>2</strong></span>
								</div>
							</div>
							<div class="col-sm-2 text-right">
								<select class="form-control selectpicker" name="po_status">
									<option>--</option>
								</select>
							</div>
							<div class="col-sm-4 text-right">
								<input type="hidden" id="vpo_id_for_list" name="vpo_id_for_list" value="<?php echo $selected_vpo_id; ?>" />
								<input type="hidden" id="po_vendor_no" name="po_vendor_no" value="<?php echo $selected_vpo_no; ?>" />
								<input type="hidden" id="po_vendor_id" name="po_vendor_id" value="<?php echo $selected_vpo_vendor_id; ?>" />
								<input type="hidden" id="po_vendor_status" name="po_vendor_status" value="<?php echo $selected_vpo_status; ?>" />
								
								<input type="hidden" id="po_created_date" name="po_created_date" value="<?php echo $selected_vpo_date; ?>" />
								<?php if($prdt_id != '') { ?>
								<input type="hidden" name="selected_prdt_id" value="<?php echo $prdt_id; ?>" />
								<button type="submit" id="save" name="update" value="update-record" class="btn btn-success ember-view">Update</button>
								<?php } else { ?>
								<button type="submit" id="save" name="save" value="save-createnew" class="btn btn-success ember-view">Create</button>
								<?php } ?>
								<a href="manage_vendorpo.php" class="btn btn-secondary">Cancel</a>
							</div>
						</div>
	
				</div>
				<!-- End of BASIC -->

				</form>


            </div><!-- row -->
          </div><!-- col -->
          
          <?php 
	          $vendorporeturn_sidebar_view_type='create';
	          include viewpath('__vendorsporeturnsidebar.php'); 
          ?>

        </div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->   