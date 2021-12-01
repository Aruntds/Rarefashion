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
extract($_REQUEST);
include_once('jackus.php');

reguser_protect();
//include_once('check_restricted.php');
//update query
if ($route == "delete" && $id != '' && $restricted_access !="0") {
	//Insert query
	$arrFields=array('`deleted`');

	$arrValues=array("1");

	$sqlWhere= "vpor_id=$id";

	if(sqlACTIONS("UPDATE","js_vendor_po_return",$arrFields,$arrValues, $sqlWhere)) {
		echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
		echo "<script type='text/javascript'>window.location = 'vendorsporeturn.php?code=2'; </script>";
	}
}

//Generating dynamic file names to view/add/edit/delete O/P:  r_{module-name}.php
$generateINCLUDE = viewGENERATOR($currentpage, $route);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
   
    <title><?php include publicpath('__pagetitle.php'); ?> | <?php echo $_SITETITLE; ?></title>
	<link rel="stylesheet" href="<?php echo BASEPATH; ?>/public/integration/EasyAutocomplete-1.3.5/easy-autocomplete.css" > 
    <?php 
    //$use_datable = 'N';
    include publicpath('__commonscripts.php'); 
    ?>
	<link rel="stylesheet" type="text/css" href="<?php echo BASEPATH; ?>/public/integration/datetimepicker/jquery.datetimepicker.css"/>
  </head>
  <body>

	  <!-- main header -->
	  <?php include publicpath('__header.php'); ?>
	  <!-- main header ends -->
  
    <div class="content content-fixed bd-b">
      <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="d-sm-flex align-items-center justify-content-between">
          
            <?php include publicpath('__breadcrumb.php'); ?>

          <div class="mg-t-20 mg-sm-t-0">

            <?php
			if(!in_array($route,array('add', 'edit','list'))){ ?>
              <a href="?route=add" class="btn btn-xs btn-success btn-icon"><i data-feather="plus"></i><?php echo $__create ?></a>
            <?php } ?>

            <?php pageREFRESH(curPageURL(), $__refresh); ?>

          </div>

        </div>
      </div>
    </div>

    <!-- container -->
    <?php include ($generateINCLUDE); ?>

    <!-- Footer -->
    <?php include publicpath('__footer.php'); ?>
    <!-- End of Footer -->

    <div class="modal fade" id="deleteDATA" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-14">
          <div class="modal-header">
            <h6 class="modal-title" id="exampleModalLabel2">Please confirm your action</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body receiving-delete-data"></div>
        </div>
      </div>
    </div>
 
	<!-- onclick spinner -->
    <div class="modal fade effect-scale show" id="pleasewait-loader" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered wd-150" role="document">
        <div class="modal-content">
          <div class="modal-body text-center">
            <div class="spinner-border wd-80 ht-80" role="status">
              <span class="sr-only">Loading...</span>
            </div>     
          <p>working on it...</p>
          </div>
        </div>
      </div>
    </div>

    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/dataTables.dataTables.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-responsive-dt/js/responsive.dataTables.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/select2/js/select2.min.js"></script>
    
    <!--<script src="<?php echo BASEPATH; ?>/public/integration/tiny_mce/tiny_mce.js"></script>-->
    <script src="<?php echo BASEPATH; ?>/public/integration/parsleyjs/parsley.min.js"></script>
  
    <script src="<?php echo BASEPATH; ?>/public/integration/jqueryui/jquery-ui.min.js"></script> 
    
	<script src="<?php echo BASEPATH; ?>/public/integration/datetimepicker/jquery.datetimepicker.js"/></script>
	<script src="<?php echo BASEPATH; ?>/public/integration/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.min.js"/></script>
    <script src="<?php echo BASEPATH; ?>/public/pdfmake/pdfmake.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/pdfmake/vfs_fonts.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/buttons.flash.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/jszip.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/buttons.html5.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/buttons.print.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/dataTables.select.min.js"></script>
	<script>

	$('.pay-amt').keypress(function(event) {
		if(event.which < 46
		|| event.which > 59) {
			event.preventDefault();
		} // prevent if not number/dot

		if(event.which == 46
		&& $(this).val().indexOf('.') != -1) {
			event.preventDefault();
		} // prevent if already dot
	});


	$('input[name="received_qty[]"]').on('keyup', function(){     
	if ($(this).val() > $(this).attr('max')*1) {       
	$(this).val($(this).attr('max'));     
	}   
	});
	
	$('#vpor_date').datepicker({
	   dateFormat: 'dd/mm/yy',
	  showOtherMonths: true,
	  selectOtherMonths: true,
	  changeMonth: true,
	  changeYear: true
	});


$('#payment_date').datepicker({
   dateFormat: 'dd/mm/yy',
  showOtherMonths: true,
  selectOtherMonths: true,
  changeMonth: true,
  changeYear: true
});
	
	var customer_options = {
	url: function(phrase) {
		return "engine/json/JSON_vendorposearch.php?title=" + phrase + "&format=json";
	},
	getValue: "title", //prdt_name
	list: {
		onChooseEvent: function() {
			//showCustomer_RECORD();
		},	
		match: {
			enabled: false
		},
		hideOnEmptyPhrase: true
	},
	theme: "square"
};

$("#vpo_ref_no").easyAutocomplete(customer_options);
	
      $(function(){
        'use strict'
        <?php if($route == '') {  ?>
	
        $('#returnLIST').DataTable({
          responsive: true,
		  dom: 'Bfrtip',
          'ajax': 'engine/json/JSONvendorporeturn.php?show=<?php echo $show; ?>',
           "columns": [
            { "data": "count" },
            { "data": "vpor_no" },
            { "data": "vpor_date" },
            { "data": "selected_vpor_vpo_ref_no" },
            { "data": "status" },
            { "data": "modify" }
          ],
		  "columnDefs": [{
			  	"targets": 0,
				"data": "count",
				"searchable": false
		  },
		   {
			  	"targets": 5,
				"data": "modify",
				"searchable": false,
				"render": function ( data, type, row, meta ) {
						return '<a title="Click to Preview" href="vendorsporeturn.php?route=list&formtype=preview&id='+data+'" class="btn btn-light btn-icon"><i class="fa fa-eye"></i></a> <a href="javascript:void(0);" onClick ="deleteITEM('+data+');" title="Click to delete" class="btn btn-dark btn-icon"><i class="fa fa-trash"></i></a>';
					
				}
			 } 
		  ],
		buttons: [
		{
			extend: 'copy',
			text: window.copyButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4], // Only name, email and role
			}
		},
		{
			extend: 'excel',
			text: window.excelButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4], // Only name, email and role
			}
		},
		{
			extend: 'csv',
			text: window.csvButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4], // Only name, email and role
			}
		},		
		{
			extend: 'pdf',
			text: window.pdfButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4], // Only name, email and role
			}
		},		
		{
			extend: 'print',
			text: window.printButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4], // Only name, email and role
			}
		}
        ],
          language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
          },
		select: true  
        });

        // Select2
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
	
    <?php }  
//////////////////////////////////      
      if($route == 'add' || $route == 'edit') {  ?>
		$(window).keydown(function(event) {
		  if(event.which == 13) { 
			event.preventDefault(); 
		  }
		});	
	
        /*tinyMCE.init({
            mode : "textareas",
            theme : "advanced"
        });*/
		
        function uploadImage(input){
            if (input.files && input.files[0]) {
              var url = URL.createObjectURL(input.files[0]);
              $('#imagePreview').attr('style', 'background-image:url(' + url + ')');
              $('#imagePreview').hide();
              $('#imagePreview').fadeIn(650);
            }
        }

        //document.querySelector("input").onchange = function(){uploadImage(this)};

        $("#categoryimage").change(function() {
            uploadImage(this);         
        });
		
/////////////////////////////////
     

<?php } ?>

      });

	function  deleteITEM(deleting_id) { 
		var SELECTED_ID = deleting_id;
		//alert(SELECTED_ID);
		$('#pleasewait-loader').show();
		$('.receiving-delete-data').load('view/x__vendorsporeturn.php?type=delete&delete_id='+SELECTED_ID+'',function(){
			$('#pleasewait-loader').hide();
			$('#deleteDATA').modal({show:true});
		});
	}

	function  togglestatusITEM(category_id, status) { 
		var SELECTED_ID = category_id;
		var SELECTED_STATUS = status;
		//alert(SELECTED_ID);
		$('#pleasewait-loader').show();
		$('.receiving-delete-data').load('view/x__vendorsporeturn.php?type=changestatus&categoryID='+SELECTED_ID+'&oldstatus='+SELECTED_STATUS+'',function(){
			$('#pleasewait-loader').hide();
			location.reload();
		});
	}
<?php if($route == 'add' && $id != '') {  ?>
	
	var stock_record = {
			url: function(phrase) {
				///return "engine/json/JSON_custom_main_stockrecords.php?phrase=" + phrase + "&prvendor_id=<?php echo $selected_vpor_vendor_id; ?>&format=json";
				return "engine/json/JSON_vendorporeturnsearch.php?title=" + phrase + "&prvendor_id=<?php echo $selected_vpor_vendor_id; ?>&format=json";
			},
			getValue: "title",
			list: {
				onChooseEvent: function() {
					get_productdtls_List();
				},
                match: {
                    enabled: true
                },
				hideOnEmptyPhrase: true
            },
			theme: "square"
		};

        $("#product-data").easyAutocomplete(stock_record);
		
	//get_productdtls_List
		function get_productdtls_List()
		{
			var get_prdt_id =document.getElementById( "product-data" ).value;		   

		   if(get_prdt_id)
		   {
			   $('#progress_table').show();
			   $.ajax({
					   type: 'post', url: 'engine/ajax/ajax_generatecode.php?type=vendorpo_return&prvendor_id=<?php echo $selected_vpor_vendor_id; ?>&pr_branch_type=<?php echo $selected_vpor_prdttype_id; ?>',
					   data: { product_vpo:get_prdt_id
				   },
				   success: function (response) {
					   $('#progress_table').hide();
					   $('#hidden_productcode' ).remove();
					   $('#quickbill_offer_details').html(response);
					   $("#prdt_roq").focus(); 
					   if(response=="OK") {  return true;  } else { return false; }
				  }
			   });
			}
		}
		
	//getting Purchase Order Return Items
		function get_po_productitem_List()
		{
			var po_vpor_id =<?php echo $selected_vpor_id; ?>; //document.getElementById( "vpor_id_for_list" ).value;	
			//var po_type = <?php echo $selected_vpor_prdttype_id; ?>; //document.getElementById( "prdt_type" ).value;
			var po_vendor = <?php echo $selected_vpor_vendor_id; ?>; //document.getElementById( "vendor_id" ).value;
			var po_prdt_id =document.getElementById( "choosen_prdt_id" ).value;	
			var po_prdt_qty = document.getElementById( "prdt_roq" ).value;
			var po_prdt_price = document.getElementById( "prdt_purchase_price" ).value;
			var po_prdt_tax = document.getElementById( "prdt_tax" ).value;	     
			var vpo_id = document.getElementById( "vpo_id" ).value;
		   if(po_prdt_id)
		   {
			   $('#progress_table').show();
			   $.ajax({
					   type: 'post', url: 'engine/ajax/ajax_vendor_po_return_item.php?type=vendorpo',
					   data: { po_main_refid:po_vpor_id, vpo_id:vpo_id, po_vendor_type:po_vendor, po_product_id:po_prdt_id, po_product_qty:po_prdt_qty, po_product_price:po_prdt_price, po_product_tax:po_prdt_tax,
				   },
				   success: function (response) {
					   $('#progress_table').hide();
					  // $('#dummy_po_list' ).remove();
					  // $('#hidden_productcode' ).remove();
					   //$('#show_po_product_list').html(response);
					   $('#quickbill_offer_details').html(response);
					   
					 //  $('input[type=text]').val('');
					 //  $("#product-data").focus(); 
					 //  $('#product-data').attr('autofocus' , 'true');
					   if(response=="OK") {  return true;  } else { return false; }
				  }
			   });
			}
		}
	
		//removing Purchase Order Return Items
		function remove_po_productitem_List(deleting_itemid)
		{
			var po_vpor_id =document.getElementById( "vpor_id_for_list" ).value;	
			var po_prdt_id = deleting_itemid;	
			//alert('#dummy_po_list_'+po_prdt_id);
		   if(po_prdt_id)
		   {
			   $('#progress_table').show();
			   $.ajax({
					   type: 'post', url: 'engine/ajax/ajax_vendor_po_return_item.php?type=removepo',
					   data: { po_main_refid:po_vpor_id, po_product_id:po_prdt_id,
				   },
				   success: function (response) {
					   $('#progress_table').hide();
					   fetchvpor_data();
						fetchvpor_totals_data();
					   $('#dummy_po_list_'+po_prdt_id).remove();
					   if(response=="OK") {  return true;  } else { return false; }
				  }
			   });
			}
		}
	function fetchvpor_data(){
			 $.ajax({
			  url: 'engine/ajax/fetch_vendor_po_return_itemlist.php?vpor_id_ref=<?php echo $selected_vpor_id; ?>',
			  type: 'post',
			  success: function(response){
			   // Perform operation on the return value
			   $('#show_po_product_list').html(response);
			  }
			 });
		}

		function fetchvpor_totals_data(){
			 $.ajax({
			  url: 'engine/ajax/fetch_vendor_po_return_item_total.php?vpor_id_ref=<?php echo $selected_vpor_id; ?>&show=totals',
			  type: 'post',
			  success: function(response){
			   // Perform operation on the return value
			   $('#remove_po_product_total_list').remove();
		   $('#show_po_product_total_list').html(response);
			  }
			 });
		}
<?php } ?>


	//calculating balance after paid amt
	function CalcBALACNE(form) {
	  //total after discount
	  var storedbalance_amount = parseFloat(form.request_balance.value) - parseFloat(form.receivedamt.value); 
	  
	  if (isNaN(storedbalance_amount)) {
		  storedbalance_amount = '0';
	  }
	  //request_balance
		  form.balance.value = storedbalance_amount;
		  document.getElementById("total_balance").innerHTML = parseFloat(storedbalance_amount);
	  
	}    
	
	$('#vendor_id').select2({
	  selectOnClose: true
	});    
	
  <?php
    if($code == '1') { 
      $displayMSG_globalclass->displayMSG($code, "Success", 'Record created Successfully', 'success');
    }
  
    if($code == '0') {
      $displayMSG_globalclass->displayMSG($code, "Error", 'Unable to Return.Add Item or Check Available Qty.', 'error');  
    }

    if(!empty($err))  {
  ?>
      toastr.error('Error', '<?php foreach ($err as $e) { echo "$e <br>"; } ?>', {timeOut: 6000})
  <?php } ?>
  
    		var vendorPOreturn = {
		pageSize: 'A4',
			 // [left, top, right, bottom] or [horizontal, vertical]
			pageMargins: [ 10, 20, 10, 10 ],
			content: [
				//order - [Logo - barcode]
				<?php 
				 $list_parentcategory_datas = sqlQUERY_LABEL("SELECT * FROM `js_vendor_po_return` where `vpor_id` = '$id'") or die("#1-Unable to get records:".sqlERROR_LABEL());

  $count_parentcateogry_list = sqlNUMOFROW_LABEL($list_parentcategory_datas);

	  while($row = sqlFETCHARRAY_LABEL($list_parentcategory_datas)){
		  	
	  $vpor_id = $row["vpor_id"];
	  $vpor_no = $row["vpor_no"];
	  $vendor_id = $row["vendor_id"];
	  $vpor_returnedby = $row["vpor_returnedby"];
	  $vpor_date = dateformat_datepicker($row["vpor_date"]);
	  $vpo_vpo_ref_no = $row['vpo_ref_no'];
	  $get_VPO_ID = getVENDORPOdetails($vpor_vpo_ref_no,'vpoid','');
	 // $split_vpo_ref_no_1 = (explode("-",$vpor_vpo_ref_no)[0]);
	 // $split_vpo_ref_no_2 = (explode("-",$vpor_vpo_ref_no)[1]);
	 // $split_vpo_id = (explode("-",$vpor_vpo_ref_no)[2]);
	 // $selected_vpor_vpo_ref_no = $split_vpo_ref_no_1.'-'.$split_vpo_ref_no_2;
	  $status = $row["status"]; 
	  $vendorname = getVENDORNAME($vendor_id,'label');
	  
	  } ?>
				{ 
					text: 'Vendor PO Return', bold: true, alignment: 'center', fontSize: 15
				},
				{ 
					text: '\nVendor POR No:  <?php echo $vpor_no; ?>', bold: true, alignment: 'center', fontSize: 9 
				},
				
				//bill summary
				{
					style: 'dawTables',
					table: {
						widths: ['*', '*', '*', '*'],
						body: [
							[{text: 'Vendor Info', bold: true,  alignment: 'center', fontSize: 8},
							{text: 'P.O.R Date', bold: true,  alignment: 'center', fontSize: 8}, 
							{text: 'PO. Ref. No', bold: true,  alignment: 'center', fontSize: 8},
							{text: 'Returned By', bold: true,  alignment: 'center', fontSize: 8}],
							
							[{text: '<?php echo $vendorname; ?>', alignment: 'center', fontSize: 8},
							{text: '<?php echo dateformat_datepicker($vpor_date); ?>', alignment: 'center', fontSize: 8}, 
							{text: '<?php echo $vpo_vpo_ref_no; ?>', alignment: 'center', fontSize: 8}, 
							{text: '<?php echo $vpor_returnedby; ?>', alignment: 'center', fontSize: 8}],
						]
					},
					layout: 'noBorders'
				},
				//End of top section
				
				//itenarys list
				{
					style: 'dawOrderSummary',
					table: {
						headerRows: 2,
						dontBreakRows: true,
						keepWithHeaderRows: 1,					
						widths: [10,65,170,15,40,40,30,50,60],
						body: [

							[{text: '\n#', style: 'tableHeader', alignment: 'center', fontSize: 8, rowSpan:2}, 
							{text: '\nProduct Code', style: 'tableHeader', alignment: 'center', fontSize: 8, rowSpan:2}, 
							{text: '\nProduct Name', style: 'tableHeader', alignment: 'left', fontSize: 8, rowSpan:2}, 
							{text: 'Tax', style: 'tableHeader', alignment: 'center', fontSize: 8, colSpan:3},{},{}, 
							{text: '\nTotal Qty', style: 'tableHeader', alignment: 'left', fontSize: 8, rowSpan:2},
							{text: '\nItem Price', style: 'tableHeader', alignment: 'left', fontSize: 8, rowSpan:2},
							{text: '\nItem Total', style: 'tableHeader', alignment: 'left', fontSize: 8, rowSpan:2}],
							[{}, {}, {},
							{text: '%', style: 'tableHeader', alignment: 'center', fontSize: 8},
							{text: 'CGST', style: 'tableHeader', alignment: 'center', fontSize: 8},
							{text: 'SGST', style: 'tableHeader', alignment: 'center', fontSize: 8},
							 {}, {}],
							 <?php  
									   
							$list_vendorpoitems_data = sqlQUERY_LABEL("SELECT * FROM `js_vendor_po_items` where vpo_id='$get_VPO_ID' and deleted = '0'") or die("#1-Unable to get PRODUCT CATEGORY:".sqlERROR_LABEL());
								
							$count_cateogry_list = sqlNUMOFROW_LABEL($list_vendorpoitems_data);
							//$counter_value = '1';
							while($row_value = sqlFETCHARRAY_LABEL($list_vendorpoitems_data)){
							  $counter_list++;
							  $vpo_item_id = $row_value["vpo_item_id"];
							  $vpo_id = $row_value["vpo_id"];
							  $prdt_id = $row_value["prdt_id"];
							  $vpo_item_qty = $row_value["vpo_item_qty"];
							  $vpo_item_price = $row_value["vpo_item_price"];
							  $vpo_item_tax = $row_value["vpo_item_tax"];
							  $vpo_item_tax1 = $row_value["vpo_item_tax1"];
							  $vpo_item_tax2 = $row_value["vpo_item_tax2"];
							  $vpo_item_total = $row_value["vpo_item_total"];
							  $vpo_item_received = $row_value["vpo_item_received"];
							  $vpo_item_available = $row_value["vpo_item_available"];
							  $vpo_item_returned_qty = $row_value["vpo_item_returned_qty"];
							  $vpo_item_difference = $row_value["vpo_item_difference"];
							  $vpo_item_expirydate = $row_value["vpo_item_expirydate"];
							  $vpo_item_grn_status = $row_value["vpo_item_grn_status"];
							  $status = $row_value["status"];
							  $product_code = getPRODUCTDETAIL($prdt_id, 'code');
							  $product_name = getPRODUCTDETAIL($prdt_id, 'name');
							  ?>
			  
				[{text: '<?php echo $counter_list; ?>', alignment: 'center', fontSize: 8},
				{text: '<?php echo $product_code; ?>', alignment: 'center', fontSize: 8},
				{text: '<?php echo $product_name; ?>', alignment: 'left', fontSize: 8},
				{text: '<?php echo $vpo_item_tax; ?>', alignment: 'center', fontSize: 8},
				{text: '<?php echo moneyFormatIndia($vpo_item_tax1); ?>', alignment: 'center', fontSize: 8},
				{text: '<?php echo moneyFormatIndia($vpo_item_tax2); ?>', alignment: 'center', fontSize: 8},
				
				{text: '<?php echo $vpo_item_returned_qty; ?>', alignment: 'left', fontSize: 8},
				{text: '<?php echo moneyFormatIndia($vpo_item_price); ?>', alignment: 'left', fontSize: 8},
				{text: '<?php echo moneyFormatIndia($vpo_item_total); ?>', alignment: 'left', fontSize: 8}],
				
							<?php } ?>
						]
					}
				},
				//end of itenary	
			
				{
					style: 'dawOrderSummary',
					table: {
						widths: [150, '*', 150],
						body: [
							[
								{
									text: '\n \n \n \n for Office',
									fillColor: '#f5f5f5',alignment: 'center',
								}, {
									text: '\n',
								}, {
									text: '\n \n \n \n for Vendor',
									fillColor: '#f5f5f5',alignment: 'center',
								}
							],
						]
					},
					layout: 'noBorders'
				},

			],
			styles: {
				header: {
					fontSize: 14,
					bold: true,
					margin: [0, 0, 0, 10]
				},
				subheader: {
					fontSize: 12,
					bold: true,
					margin: [0, 10, 0, 5]
				},
				dawTables: {
					margin: [5, 10]
				},
				dawOrderSummary: {
					fontSize: 9,
					margin: [5, 10]
				},
				tableHeader: {
					bold: true,
					fontSize: 12,
					color: 'black'

				}
			}}

		function printINVOICE() { 
			pdfMake.createPdf(vendorPOreturn).open();
			//pdfMake.createPdf(branchPO).print();
			//pdfMake.createPdf(branchPO).download('optionalName.pdf');
		}
		
		function downloadBILL() { 
			pdfMake.createPdf(vendorPOreturn).download('Return #: <?php echo $vpor_no; ?>');
		}

    </script>
  </body>
</html>	