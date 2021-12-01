
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
if($action == 'import'){ob_start();session_start();}

include_once('jackus.php');

reguser_protect();
//include_once('check_restricted.php');
//update query
if ($route == "delete" && $id != '' && $restricted_access !="0") {
	//Insert query
	$arrFields=array('`deleted`');

	$arrValues=array("1");

	$sqlWhere= "vpo_id=$id";

	if(sqlACTIONS("UPDATE","js_vendorpo",$arrFields,$arrValues, $sqlWhere)) {
		echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
		echo "<script type='text/javascript'>window.location = 'vendorspo.php?code=1'; </script>";
	}
}

//Generating dynamic file names to view/add/edit/delete O/P:  r_{module-name}.php
$generateINCLUDE = viewGENERATOR($currentpage, $route);

?>
<!DOCTYPE html>
<html lang="en">
  <head><meta charset="windows-1252">
   
    <title><?php include publicpath('__pagetitle.php'); ?> | <?php echo $_SITETITLE; ?></title>
    <?php 
    //$use_datable = 'N';
    include publicpath('__commonscripts.php'); 
    ?>
	<link rel="stylesheet" type="text/css" href="<?php echo BASEPATH; ?>/public/integration/datetimepicker/jquery.datetimepicker.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo BASEPATH; ?>/public/integration/datetimepicker/jquery.autocomplete.min.css"/>
	<!--<link rel="stylesheet" href="<?php echo BASEPATH; ?>/public/integration/EasyAutocomplete-1.3.5/easy-autocomplete.css" > -->
	<link rel="stylesheet" type="text/css" href="<?php echo BASEPATH; ?>/public/integration/datetimepicker/jquery.autocomplete.themes.min.css"/>
	<link rel="stylesheet" href="<?php echo BASEPATH; ?>/public/integration/EasyAutocomplete-1.3.5/easy-autocomplete.css" > 
	<!--<link rel="stylesheet" type="text/css" href="<?php echo BASEPATH; ?>/public/integration/datetimepicker/main.css"/>-->
  </head>
  <body>

	  <!-- main header -->
	  <?php include publicpath('__header.php'); ?>
	  <!-- main header ends -->
  
    <div class="content content-fixed bd-b">
      <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="d-sm-flex align-items-center justify-content-between">
          
            <?php include publicpath('__breadcrumb.php'); ?>

          <div class="mg-sm-t-0 mg-t-20">
                                 
            <?php
			if(!in_array($route,array('add', 'edit', 'list','preview'))){ ?>
             <!-- <a href="?formtype=import" class="btn btn-xs btn-danger btn-icon mg-r-2"><i data-feather="upload"></i>Import</a>-->
            <?php } ?>  
            <?php
			if(!in_array($route,array('add', 'edit', 'list','preview'))){ ?>
              <a href="?route=add" class="btn btn-xs btn-success btn-icon mg-r-2"><i data-feather="plus"></i><?php echo $__create ?></a>
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
		 <input type="hidden" class="form-control" placeholder="Product Name" value="<?php echo $prdttype_id; ?>" name="prdttype_id" id="prdttype_id">
		 <input type="hidden" class="form-control" placeholder="Product Name" value="<?php echo $vendor_id; ?>" name="vendor_id" id="vendor_id">
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
	<?php
	  $list_gensetting_data = sqlQUERY_LABEL("SELECT * FROM `js_generalsettings` where status = '1' and deleted = '0'") or die("#1-Unable to get PRODUCT CATEGORY:".sqlERROR_LABEL());

	  $count_gensetting_list = sqlNUMOFROW_LABEL($list_gensetting_data);

	  while($row = sqlFETCHARRAY_LABEL($list_gensetting_data)){
		  $gensetting_id = $row["gensetting_id"];
		  $gensetting_sitetitle = $row["gensetting_sitetitle"];
		  $gensetting_sitelogo = $row["gensetting_sitelogo"];
		  $gensetting_gstin = $row["gensetting_gstin"];
		  $gensetting_contact_no = $row["gensetting_contact_no"];
		  $gensetting_email = $row["gensetting_email"];
		  $gensetting_address = $row["gensetting_address"];
		  $gensetting_pincode = $row["gensetting_pincode"];
		  $gensetting_amc_margin = $row["gensetting_amc_margin"];
		  $status = $row["status"];
		}
		if($gensetting_sitelogo !=''){
		$invoice_logo = $gensetting_sitelogo;
		} else {
		$invoice_logo = $site_url.'public/img/blank-placeholder.jpg';
		}
		$invoice_logo_data = file_get_contents($invoice_logo);
		$logo_dataUri = 'data:image/jpg;base64,' . base64_encode($invoice_logo_data);
	?>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/dataTables.dataTables.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-responsive-dt/js/responsive.dataTables.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/select2/js/select2.min.js"></script>
    
    <script src="<?php echo BASEPATH; ?>/public/integration/tinymce/tinymce.min.js"></script>
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

	// $(document).ready(function(){
		// $("#myModal").modal('show');
	// });

	$('input[name="received_qty[]"]').on('keyup', function(){     
	if ($(this).val() > $(this).attr('max')*1) {       
	$(this).val($(this).attr('max'));     
	}   
	});

	$('input[name="vpo_item[]"]').on('click', function(e){
		if ($(this).is(':checked')) {
		  var selected_id = ($(this).val());		
			$('.receiving-prdt-remarks').load('__receivingprdtremarks.php?type=show_remarks&vpo_item_ID='+selected_id+'',function(){
				$('#item_remarks_data').modal({show:true});
			});
	   }
	});
   
function vpo_reject_status(status_id) {

    var vpo_id = document.getElementById('seletced_vpo_id').value;
    var vpo_reject_reason = document.getElementById('vpo_reject_reason').value;

    if (vpo_id !='' && vpo_reject_reason !='') {
        $.ajax({
            type: 'post',
            url: 'engine/ajax/ajax_vpo_reject_status.php?type=vpo_reject',
            data: {
                status_id: status_id,
                vpo_id: vpo_id,
				vpo_reject_reason : vpo_reject_reason,
            },
            success: function(response) {
				window.location.href = 'vendorspo.php';
                if (response == "OK") { return true; } else { return false; }
            }
        });
    } else {
		alert("Please Enter the Reject Reason to Proceed");
	}

}

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
$('#vpo_date').datepicker({
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
$('#vpo_received').datepicker({
  dateFormat: 'dd/mm/yy',
  showOtherMonths: true,
  selectOtherMonths: true,
  changeMonth: true,
  changeYear: true
});
$('#vpo_sent').datepicker({
  dateFormat: 'dd/mm/yy',
  showOtherMonths: true,
  selectOtherMonths: true,
  changeMonth: true,
  changeYear: true
});
$('#items-expirydate').datepicker({
  dateFormat: 'dd/mm/yy',
  showOtherMonths: true,
  selectOtherMonths: true,
  changeMonth: true,
  changeYear: true
});

$('#vpo_invoice_date').datepicker({
  dateFormat: 'dd/mm/yy',
  showOtherMonths: true,
  selectOtherMonths: true,
  changeMonth: true,
  changeYear: true
});
// $('#vpo_date').datepicker({
  // showOtherMonths: true,
  // selectOtherMonths: true
// });

function get_grn_ref_no()
{	

var get_invoice_ref_no = document.getElementById('vpo_invoice_ref_no').value;
var get_invoice_date = document.getElementById('vpo_invoice_date').value;
	noSlashes = get_invoice_date.replace(/\//g,'');
	if(get_invoice_ref_no != '' && noSlashes != ''){
	var new_ref_no = noSlashes.concat(get_invoice_ref_no);
	document.getElementById('vpo_grn_ref_no').value = new_ref_no;
	}
}
		
      $(function(){
        'use strict'
        <?php if($route == '') {  ?>
	
        $('#VendorpoLIST').DataTable({
          responsive: true,
		  dom: 'Bfrtip',
          'ajax': 'engine/json/JSONvendorspo.php',
           "columns": [
            { "data": "count" },
            { "data": "vpo_no" },
            { "data": "vpo_date" },
            { "data": "vpo_grn_on" },
			{ "data": "vendor_name" },
            { "data": "vpo_tot_items" },
			{ "data": "vpo_tot_qty" },
			{ "data": "vpo_tot_value" },
			{ "data": "vpo_tot_tax" },
			{ "data": "status" },
            { "data": "modify" }
          ],
		  "columnDefs": [{
			  	"targets": 0,
				"data": "count",
				"searchable": false
		  },
		  {
			"targets": 1,
			"data": "vpo_no",
			"render" : function ( data, type, row) {
				return '<a data-toggle="tooltip" data-original-title="Click to View" href="vendorspo.php?route=preview&formtype=preview&id='+row.modify+'" target="_blank">'+data+'</a>';
			}
          },
		  {
			  	"targets": 10,
				"data": "modify",
				"searchable": false,
				"render": function ( data, type, row, meta ) {
				if(row.status_id == '0'){
					return '<a title="Click to Preview" href="vendorspo.php?route=preview&formtype=preview&id='+data+'" class="btn btn-light btn-icon"><i class="fa fa-eye"></i></a> <a href="javascript:void(0);" onClick ="deleteITEM('+data+');" title="Click to delete" class="btn btn-dark btn-icon"><i class="fa fa-trash"></i></a>';
					//return '';
				}else{
					return '<a title="Click to Preview" href="vendorspo.php?route=preview&formtype=preview&id='+data+'" class="btn btn-light btn-icon"><i class="fa fa-eye"></i></a> <a href="javascript:void(0);" onClick ="deleteITEM('+data+');" title="Click to delete" class="btn btn-dark btn-icon"><i class="fa fa-trash"></i></a>';
				}
			 } 
		   }
		  ],
		buttons: [
		{
			extend: 'copy',
			text: window.copyButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9], // Only name, email and role
			}
		},
		{
			extend: 'excel',
			text: window.excelButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9], // Only name, email and role
			}
		},
		{
			extend: 'csv',
			text: window.csvButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9], // Only name, email and role
			}
		},		
		{
			extend: 'pdf',
			text: window.pdfButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9], // Only name, email and role
			}
		},		
		{
			extend: 'print',
			text: window.printButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9], // Only name, email and role
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
		$('.receiving-delete-data').load('view/x__vendorspo.php?type=delete&delete_id='+SELECTED_ID+'',function(){
			$('#pleasewait-loader').hide();
			$('#deleteDATA').modal({show:true});
		});
	}

	function  togglestatusITEM(js_vendorpo, status) { 
		var SELECTED_ID = js_vendorpo;
		var SELECTED_STATUS = status;
		//alert(SELECTED_ID);
		$('#pleasewait-loader').show();
		$('.receiving-delete-data').load('view/x__vendorspo.php?type=changestatus&js_vendorpo='+SELECTED_ID+'&oldstatus='+SELECTED_STATUS+'',function(){
			$('#pleasewait-loader').hide();
			location.reload();
		});
	}
	
	//ADD Products In purcharse order
	<?php if($route == 'add' && $id != ''){ ?>
	var stock_record = {

			url: function(phrase) {
				return "engine/json/JSON_custom_main_stockrecords.php?phrase=" + encodeURIComponent(phrase) + "&prvendor_id=<?php echo $vendor_id; ?>&format=json";
			},
			getValue: "productsku",
			list: {
				onChooseEvent: function() {
					get_productdtls_List();
				},
                match: {
                    enabled: false
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
			
			// alert(vpo_id);
			
		   if(get_prdt_id)
		   {
			   $('#progress_table').show();
			   $.ajax({
					   type: 'post', url: 'engine/ajax/ajax_generatecode.php?type=vendorpo&prvendor_id=<?php echo $selected_vpo_vendor_id; ?>&pr_branch_type=<?php echo $selected_vpo_prdttype_id; ?>',
					   data: { product_id:get_prdt_id,
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
	
	//getting Purchase Order Items
		function get_po_productitem_List()
		{ 
			var po_vpo_id =  <?php echo $id; ?>;//document.getElementById( "vpo_id_for_list" ).value;	 alert(po_vpo_id);
			var po_type = <?php echo $selected_vpo_prdttype_id; ?>;//document.getElementById( "prdttype_id" ).value;
			var po_vendor = <?php echo $selected_vpo_vendor_id; ?>; //document.getElementById( "vendor_id" ).value;
			var po_prdt_id =document.getElementById( "choosen_prdt_id" ).value;	
			var po_prdt_qty = document.getElementById( "prdt_roq" ).value;
			var po_prdt_price = document.getElementById( "prdt_purchase_price" ).value;
			var po_prdt_tax = document.getElementById( "prdt_tax" ).value;	     
			var po_discount_value = document.getElementById( "discount_value" ).value;	     
		
		   if(po_prdt_id)
		   {
			   $('#progress_table').show();
			   $.ajax({
					   type: 'post', url: 'engine/ajax/ajax_vendor_po_item.php?type=vendorpo',
					   data: { po_main_refid:po_vpo_id, po_product_type:po_type, po_vendor_type:po_vendor, po_product_id:po_prdt_id, po_product_qty:po_prdt_qty, po_product_price:po_prdt_price, po_product_tax:po_prdt_tax,  po_discount_value:po_discount_value,

				   },
				   
				   success: function (response) {
					   $('#progress_table').hide();
//					   $('#hidden_productcode' ).remove();
					   //$('#show_po_product_list').html(response);
					   $('#quickbill_offer_details').html(response);
					   $('input[type=text]').val('');
					   $("#product-data").focus(); 
					 //  $('#product-data').attr('autofocus' , 'true');
					   if(response=="OK") {  return true;  } else { return false; }
				  }
			   });
			}
		}
		
		//removing Purchase Order Items
		function remove_po_productitem_List(deleting_itemid)
		{
			var po_vpo_id =document.getElementById( "vpo_id_for_list" ).value;	
			var po_prdt_id = deleting_itemid;	
			//alert('#dummy_po_list_'+po_prdt_id);
		   if(po_prdt_id)
		   {
			   $('#progress_table').show();
			   $.ajax({
					   type: 'post', url: 'engine/ajax/ajax_vendor_po_item.php?type=removepo',
					   data: { po_main_refid:po_vpo_id, po_product_id:po_prdt_id,
				   },
				   success: function (response) {
					   $('#progress_table').hide();
					   $('#dummy_po_list_'+po_prdt_id).remove();
					   fetchvpo_data();
					  fetchvpo_totals_data();
					   if(response=="OK") {  return true;  } else { return false; }
				  }
			   });
			}
		}
		
		function fetchvpo_data(){
			 $.ajax({
			  url: 'engine/ajax/fetch_vendor_po_itemlist.php?vpo_id_ref=<?php echo $selected_vpo_id; ?>',
			  type: 'post',
			  success: function(response){
			   // Perform operation on the return value
			   $('#show_po_product_list').html(response);
			  }
			 });
		}

		function fetchvpo_totals_data(){
			 $.ajax({
			  url: 'engine/ajax/fetch_vendor_po_item_total.php?vpo_id_ref=<?php echo $selected_vpo_id; ?>&show=totals',
			  type: 'post',
			  success: function(response){
			   // Perform operation on the return value
			   $('#show_po_product_total_list').html(response);
			  }
			 });
		}
	<?php } ?>
	
	//Customer Report
		$("#btnExport").click(function(e) {
            let file = new Blob([$('#barcodereport').html()], { type: "application/vnd.ms-excel" });

            let url = URL.createObjectURL(file);
            let a = $("<a />", {
                    href: url,
                    download: 'Barcode.xls'
                })
                .appendTo("body")
                .get(0)
                .click();
            e.preventDefault();
        });
		
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

	$(document).ready(function () {
    $('.group-checkable').on('click', function () {
    $(this).closest('table').find('tbody :checkbox')
    .prop('checked', this.checked)
    .closest('tr').toggleClass('selected', this.checked);
    });
    $('tbody :checkbox').on('click', function () {
    $(this).closest('tr').toggleClass('selected', this.checked); //Classe de seleção na row
    $(this).closest('table').find('.group-checkable').prop('checked', ($(this).closest('table').find('tbody :checkbox:checked').length == $(this).closest('table').find('tbody :checkbox').length));
    });
    })

	function reason_change(){
		var reason_id = document.getElementById("vpo_reasonid").value;
		if(reason_id == '1'){
			$('#show_sale_order').show();
			$('#show_stock').hide();
		}
		else if(reason_id == '2'){
			$('#show_sale_order').hide();
			$('#show_stock').show();
		} 
		else {
			$('#show_sale_order').hide();
			$('#show_stock').hide();
		}
	}

        <?php if($route == 'add' && $id!='' || $route == 'edit' && $id!='') {  ?>
		
				if($("#vpo_terms_and_conditions").length > 0){
				tinymce.init({
				selector: "textarea#vpo_terms_and_conditions",
				theme: "modern",
				menubar: false,
				min_height:300,
				plugins: 'image preview fullscreen code',
				toolbar: 'undo redo | styleselect bold italic | link image preview | bullist numlist outdent indent | alignleft aligncenter alignright alignjustify code',
				// enable title field in the Image dialog
				image_title: true, 
				// enable automatic uploads of images represented by blob or data URIs
				automatic_uploads: true,
				// add custom filepicker only to Image dialog
				file_picker_types: 'image',
				file_picker_callback: function(cb, value, meta) {
					var input = document.createElement('input');
					input.setAttribute('type', 'file');
					input.setAttribute('accept', 'image/*');
					
					input.onchange = function() {
					  var file = this.files[0];
					  var reader = new FileReader();
					  
					  reader.onload = function () {
						var id = 'blobid' + (new Date()).getTime();
						var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
						var base64 = reader.result.split(',')[1];
						var blobInfo = blobCache.create(id, file, base64);
						blobCache.add(blobInfo);
					
						// call the callback and populate the Title field with the file name
						cb(blobInfo.blobUri(), { title: file.name });
					  };
					  reader.readAsDataURL(file);
					};
					
					input.click();
				}

			});
		}
<?php } ?>
  <?php
    if($code == '1') { 
      $displayMSG_globalclass->displayMSG($code, "Success", 'Record created Successfully', 'success');
    }
  
    if($code == '0') {
      $displayMSG_globalclass->displayMSG($code, "Error", 'Unable to Add Category.', 'error');  
    }

    if(!empty($err))  {
  ?>
      toastr.error('Error', '<?php foreach ($err as $e) { echo "$e <br>"; } ?>', {timeOut: 6000})
  <?php } ?>
  
  <?php if($formtype = 'preview') { ?>
    var vendorPO = {
		pageSize: 'A4',
			 // [left, top, right, bottom] or [horizontal, vertical]
			pageMargins: [ 10, 20, 10, 10 ],
			content: [
				//order - [Logo - barcode]
				<?php
				   $list_parentcategory_datas = sqlQUERY_LABEL("SELECT * FROM `js_vendorpo` where `vpo_id` = '$id'") or die("#1-Unable to get records:".sqlERROR_LABEL());

  $count_parentcateogry_list = sqlNUMOFROW_LABEL($list_parentcategory_datas);

	  while($row = sqlFETCHARRAY_LABEL($list_parentcategory_datas))
	  {
		
	  $vpo_id = $row["vpo_id"];
	  $vendor_id = $row["vendor_id"];
	  $vpo_no = $row["vpo_no"];
	  $vpo_date = $row["vpo_date"];
	  $vpo_sent = $row["vpo_sent"];
	  $vpo_received = $row["vpo_received"];
	  $vpo_tot_items = $row["vpo_tot_items"];
	  $vpo_tot_qty = $row["vpo_tot_qty"];
	  $vpo_tot_tax = $row["vpo_tot_tax"];
	  $vpo_tot_paid = $row["vpo_tot_paid"];
	  $vpo_tot_value = $row["vpo_tot_value"];
	  $vpo_tot_balance = $row["vpo_tot_balance"];
	  $vpo_grn_status = $row["vpo_grn_status"];
	  $status = $row["status"]; 
	  $vendorname = getVENDORNAME($vendor_id,'label');
	  }
	  
	  
		$count_grn_status_list = sqlQUERY_LABEL("select `vpo_item_id` FROM `js_vendor_po_items` where `vpo_id`='$vpo_id'") or die(sqlERROR_LABEL());

		$count_vpo_grnlist = sqlNUMOFROW_LABEL($count_grn_status_list);

		

		//total item with grn updated count

		$count_grn_updated_list = sqlQUERY_LABEL("select `vpo_item_id` FROM `js_vendor_po_items` where `vpo_id`='$vpo_id' and `vpo_item_grn_status` = '1'") or die(sqlERROR_LABEL());

		$count_vpo_grnupdate = sqlNUMOFROW_LABEL($count_grn_updated_list);
		
?>

				{ 
					text: 'Vendor PO', bold: true, alignment: 'center', fontSize: 15
				},
				{ 
					text: '\nVendor PO No:  <?php echo $vpo_no; ?>', bold: true, alignment: 'center', fontSize: 9 
				},
				
				//bill summary
				{
					style: 'dawTables',
					table: {
						widths: ['*', '*', '*', '*'],
						body: [
							[{text: 'Vendor Info', bold: true,  alignment: 'center', fontSize: 8},
							{text: 'P.O Date', bold: true,  alignment: 'center', fontSize: 8}, 
							{text: 'P.O Sent on', bold: true,  alignment: 'center', fontSize: 8},
							{text: 'P.O Received on', bold: true,  alignment: 'center', fontSize: 8}],
							
							[{text: '<?php echo $vendorname; ?>', alignment: 'center', fontSize: 8},
							{text: '<?php echo dateformat_datepicker($vpo_date); ?>', alignment: 'center', fontSize: 8}, 
							{text: '<?php echo dateformat_datepicker($vpo_sent); ?>', alignment: 'center', fontSize: 8},
							{text: '<?php echo dateformat_datepicker($vpo_received); ?>', alignment: 'center', fontSize: 8}],
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
						widths: [10,80,170,'*','*','*','*','*'],
						body: [

							[{text: '\n#', style: 'tableHeader', alignment: 'center', fontSize: 8, rowSpan:2}, 
							{text: '\nProduct Code', style: 'tableHeader', alignment: 'left', fontSize: 8, rowSpan:2}, 
							{text: '\nProduct Name', style: 'tableHeader', alignment: 'left', fontSize: 8, rowSpan:2}, 
							{text: 'Qty', style: 'tableHeader', alignment: 'center', fontSize: 8, colSpan:3},{},{}, 
							{text: '\nItem Price', style: 'tableHeader', alignment: 'right', fontSize: 8, rowSpan:2}, 
							{text: '\nItem Total', style: 'tableHeader', alignment: 'right', fontSize: 8, rowSpan:2}],
							[{}, {}, {},
							{text: 'Requested', style: 'tableHeader', alignment: 'center', fontSize: 8},
							{text: 'Received', style: 'tableHeader', alignment: 'center', fontSize: 8},
							{text: 'Difference', style: 'tableHeader', alignment: 'center', fontSize: 8},
							 {}, {}],
							 
							 <?php  
									   
			$list_vendorpoitems_data = sqlQUERY_LABEL("SELECT * FROM `js_vendor_po_items` where vpo_id = '$id' and deleted = '0'") or die("#1-Unable to get PRODUCT CATEGORY:".sqlERROR_LABEL());

			$count_cateogry_list = sqlNUMOFROW_LABEL($list_vendorpoitems_data);
			if($count_cateogry_list > 0){
			while($row_value = sqlFETCHARRAY_LABEL($list_vendorpoitems_data)){
			  $counter1++;
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
			  $vpo_item_difference = $row_value["vpo_item_difference"];
			  $vpo_item_expirydate = $row_value["vpo_item_expirydate"];
			  $vpo_item_grn_status = $row_value["vpo_item_grn_status"];
			  $status = $row_value["status"];
			  $product_code = getPRODUCTDETAIL($prdt_id, 'code');
			  $product_name = getPRODUCTDETAIL($prdt_id, 'name');
			  $total_tax =  $vpo_item_tax1 +  $vpo_item_tax2;
			  $total_gross = $vpo_item_total - $total_tax;
			  ?>
							
									[{text: '<?php echo $counter1; ?>', alignment: 'center', fontSize: 8},
									{text: '<?php echo $product_code; ?>', alignment: 'left', fontSize: 8},
									{text: '<?php echo $product_name; ?>', alignment: 'left', fontSize: 8},
									{text: '<?php echo $vpo_item_qty; ?>', alignment: 'center', fontSize: 8},
									{text: '<?php echo $vpo_item_received; ?>', alignment: 'center', fontSize: 8},
									{text: '<?php echo $vpo_item_difference; ?>', alignment: 'center', fontSize: 8},
									
									{text: '<?php echo moneyFormatIndia($vpo_item_price); ?>', alignment: 'right', fontSize: 8},
									{text: '<?php echo moneyFormatIndia($vpo_item_total); ?>', alignment: 'right', fontSize: 8}],
									
							<?php	} } ?>
						
						]
					}
				},
				//end of itenary	
						
				
				{
					style: 'dawTables',
					table: {
						headerRows: 1,
						dontBreakRows: true,
						keepWithHeaderRows: 0,					
						widths: ['*','*','*','*','*'],
						body: [
							[{text: '# Total Item', alignment: 'center', fontSize: 8, bold: true},
							{text: 'Total Qty', alignment: 'center', fontSize: 8, bold: true},
							{text: 'Gross Total', alignment: 'right', fontSize: 8, bold: true}, 
							{text: 'Total Tax', alignment: 'right', fontSize: 8, bold: true},
							{text: 'Net Amount', alignment: 'right', fontSize: 8, bold: true}],
			
			<?php
			$list_vendorpoitems_data = sqlQUERY_LABEL("SELECT * FROM `js_vendor_po_items` where vpo_id = '$id' and deleted = '0'") or die("#1-Unable to get PRODUCT CATEGORY:".sqlERROR_LABEL());

			$count_cateogry_list = sqlNUMOFROW_LABEL($list_vendorpoitems_data);
			if($count_cateogry_list > 0){
			while($row_value = sqlFETCHARRAY_LABEL($list_vendorpoitems_data)){
			  $counter2++;
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
			  $vpo_item_difference = $row_value["vpo_item_difference"];
			  $vpo_item_expirydate = $row_value["vpo_item_expirydate"];
			  $vpo_item_grn_status = $row_value["vpo_item_grn_status"];
			  $status = $row_value["status"];
			  $product_code = getPRODUCTDETAIL($prdt_id, 'code');
			  $product_name = getPRODUCTDETAIL($prdt_id, 'name');
			  $total_tax =  $vpo_item_tax1 +  $vpo_item_tax2;
			  $total_gross = $vpo_item_total - $total_tax;
			  ?>		
							[{text: '<?php echo $counter2; ?>', alignment: 'center', fontSize: 8},
							{text: '<?php echo $vpo_item_qty; ?>', alignment: 'center', fontSize: 8},
							{text: '<?php echo moneyFormatIndia($total_gross); ?>', bold: true, alignment: 'right', fontSize: 8},
							{text: '<?php echo moneyFormatIndia($total_tax); ?>', bold: true, alignment: 'right', fontSize: 8},
							{text: '<?php echo moneyFormatIndia($vpo_item_total); ?>', bold: true, alignment: 'right', fontSize: 8}],
			<?php } } ?>				
						]
					}
					//layout: 'headerLineOnly' //lightHorizontalLines
				},
				
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

	var Vendor_PO_INVOICE = {
				pageSize: 'A4',
				 // [left, top, right, bottom] or [horizontal,portrait,vertical]
				pageOrientation: 'portrait',
				
				pageMargins: [40, 20, 20, 20],
				
		content: [
					
		{
			style: 'tableExample',
			table: {
				widths: [500],
				headerRows: 1,
				// keepWithHeaderRows: 1,
				body: [
					[{text: 'RARE FASHION PO', bold:true, alignment: 'center'}],
				]
			}
		},
		<?php
          
	 // echo $company_name;exit();
	 
	  $list_datas = sqlQUERY_LABEL("SELECT * FROM `js_invoice` where deleted = '0' and invoiceid='$id'") or die("Unable to get records:".sqlERROR_LABEL());		
	  
	  $check_record_availabity = sqlNUMOFROW_LABEL($list_datas);			

		while($row = sqlFETCHARRAY_LABEL($list_datas)){
		  $invoiceid = $row["invoiceid"];
		  $customerid = $row["customerid"];
		  $invoice_no = $row["invoice_no"];
		  $invoicedate = $row["invoicedate"];
		  $modeandtermsofpay = $row["modeandtermsofpay"];
		  $delivery_note_date = $row["delivery_note_date"];
		  $deliveredon = $row["deliveredon"];
		  $placeofsupply = $row["placeofsupply"];
		  $delivery_note = $row["delivery_note"];
		  $bankdetail = $row["bankdetail"];
		  $terms_delivery = $row["terms_delivery"];
		  $eway_billno = $row["eway_billno"];
		  $buyers_orderno = $row["buyers_orderno"];
		  $despatch_document_no = $row["despatch_document_no"];
		  $dispatched_through = $row["dispatched_through"];
		  $other_reference = $row["other_reference"];
		  $buyers_orderdate = $row["buyers_orderdate"];
		  $destination = $row["destination"];
		  $tds_amt = $row["tds_amt"];
		  $totalamount = $row["totalamount"];
		  $declaration = $row["declaration"];
		  
		  $notetoreceipent = $row["notetoreceipent"];
		  $total_tax_avg = $row["total_tax_avg"];
		  if($delivery_note != ''){ $delivery_note = $delivery_note; } else { $delivery_note = '--';}
		  if($modeandtermsofpay != ''){ $modeandtermsofpay = $modeandtermsofpay; } else { $modeandtermsofpay = '--';}
		  if($other_reference != ''){ $other_reference = $other_reference; } else { $other_reference = '--';}
		  if($despatch_document_no != ''){ $despatch_document_no = $despatch_document_no; } else { $despatch_document_no = '--';}
		  if($dispatched_through != ''){ $dispatched_through = $dispatched_through; } else { $dispatched_through = '--';}
		  if($destination != ''){ $destination = $destination; } else { $destination = '--';}
		  if($terms_delivery != ''){ $terms_delivery = $terms_delivery; } else { $terms_delivery = '--';}
		  if($notetoreceipent != ''){ $notetoreceipent = $notetoreceipent; } else { $notetoreceipent = '--';}
		 // echo $company_name;exit();
		 
		   $list_datas_cust = sqlQUERY_LABEL("SELECT * FROM `js_customer` where deleted = '0' and customerid='$customerid'") or die("Unable to get records:".sqlERROR_LABEL());		
			$check_record_availabity = sqlNUMOFROW_LABEL($list_datas_cust);			

			while($row_customer = sqlFETCHARRAY_LABEL($list_datas_cust)){
			  $customerid = $row_customer["customerid"];
			  $first_name = $row_customer["first_name"];
			  $last_name = $row_customer["last_name"];
			  $company_name = $row_customer["company_name"];
			  $office_address = $row_customer["office_address"];
			  $office_address = $row_customer["office_address"];
			  $gstin = strtoupper($row_customer["gstin"]);
			  $pan = strtoupper($row_customer["pan"]);
			
			}
		 
		}
        ?>
		{
			style: 'tableExample',
			table: {
				widths: [75,247,160],
				body: [
					[

					{border:[true,false,true,true], image: '<?php echo $logo_dataUri; ?>',alignment: 'center', margin:[0,2,0,2],width: 65, height: 80},

					<?php
					   $list_parentcategory_datas = sqlQUERY_LABEL("SELECT * FROM `js_vendorpo` where `vpo_id` = '$id'") or die("#1-Unable to get records:".sqlERROR_LABEL());

					  $count_parentcateogry_list = sqlNUMOFROW_LABEL($list_parentcategory_datas);

						  while($row = sqlFETCHARRAY_LABEL($list_parentcategory_datas))
						  {
							
						  $vpo_id = $row["vpo_id"];
						  $vendor_id = $row["vendor_id"];
						  $vpo_no = $row["vpo_no"];
						  $vpo_date = $row["vpo_date"];
						  $vpo_sent = $row["vpo_sent"];
						  $vpo_received = $row["vpo_received"];
						  $vpo_tot_items = $row["vpo_tot_items"];
						  $vpo_tot_qty = $row["vpo_tot_qty"];
						  $vpo_tot_tax = $row["vpo_tot_tax"];
						  $vpo_tot_paid = $row["vpo_tot_paid"];
						  $vpo_tot_value = $row["vpo_tot_value"];
						  $vpo_tot_balance = $row["vpo_tot_balance"];
						  $vpo_grn_status = $row["vpo_grn_status"];
						  $status = $row["status"]; 
						  $vendorname = getVENDORNAME($vendor_id,'pdf_label');
						  $vendor_address = getVENDORNAME($vendor_id,'vendor_address');
				    	  $vendor_address = htmlspecialchars_decode($vendor_address);
                    	  $vendor_address = preg_replace('/\s\s+/', '<br>', $vendor_address);
                    	  $vendor_address = html_entity_decode($vendor_address);
                    	  $vendor_address = str_replace('&amp;', '&', $vendor_address);
                    	  $vendor_address = str_replace('&nbsp;', '', $vendor_address);
						  $vendor_gst = getVENDORNAME($vendor_id,'vendor_gst');
						  $vendor_contactnumber = getVENDORNAME($vendor_id,'vendor_contactnumber');
						  $vendor_contactemail = getVENDORNAME($vendor_id,'vendor_contactemail');
						  }
					?>
					{margin:[5,0,0,0], border:[true,false,true,true], text: [
							{text:'Company\n', alignment:'left', fontSize: 10, bold:true, border:[false,false,true,false],lineHeight: 1.5},
							{text:'<?php echo $vendorname; ?>\n', alignment:'left', fontSize: 8, bold:true, border:[false,false,true,false],lineHeight: 1.5},
							{ text:'<?php echo $vendor_address; ?>\n', fontSize: 8, alignment:'left', border:[false,false,true,false],lineHeight: 1.3},
							{ text:'GSTIN :<?php echo $vendor_gst; ?>\n', fontSize: 8, border:[false,false,true,false],alignment:'left',lineHeight: 1.3},
							{ text:'Contact No :<?php echo $vendor_contactnumber; ?>\n',border:[false,false,false,true], fontSize: 8, alignment:'left',lineHeight: 1.3},
							{ text:'Email :<?php echo $vendor_contactemail; ?>',border:[false,false,false,true], fontSize: 8, alignment:'left'},
							
							]
					},
					{margin:[5,0,0,0], border:[true,false,true,true], text: [
							{text:'Purchase Order\n', alignment:'left', fontSize: 12, bold:true, border:[false,false,true,false],lineHeight: 1.5},
                            {text:'PO. No : <?php echo $vpo_no; ?>\n', alignment:'left', fontSize: 8, bold:true, border:[false,false,true,false],lineHeight: 1.5},
							{text:'PO. Date : <?php echo dateformat_datepicker($vpo_date); ?>\n', alignment:'left', fontSize: 8, bold:true, border:[false,false,true,false],lineHeight: 1.5}, 
							]
					},
									
					]
				]
			}
		},	
	
		{
			style: 'tableExample',
			table: {
				widths: [247,244],
				body: [
					[
					<?php
					  $list_printsettings_data = sqlQUERY_LABEL("SELECT * FROM `js_vendorpo` where `vpo_id` = '$id' and deleted = '0'") or die("#1-Unable to get PRODUCT CATEGORY:".sqlERROR_LABEL());

					  $count_printsettings_list = sqlNUMOFROW_LABEL($list_printsettings_data);

					  while($row = sqlFETCHARRAY_LABEL($list_printsettings_data)){
						  $vpo_bill_company_name = $row["vpo_bill_company_name"];
						  $vpo_bill_company_address = $row["vpo_bill_company_address"];
						  $vpo_bill_pincode = $row["vpo_bill_pincode"];
						  $vpo_bill_gstin = $row["vpo_bill_gstin"];
						  $vpo_bill_contact_no = $row["vpo_bill_contact_no"];
						  $vpo_bill_email = $row["vpo_bill_email"];
						  $vpo_ship_company_name = $row["vpo_ship_company_name"];
						  $vpo_ship_company_address = $row["vpo_ship_company_address"];
						  $vpo_ship_pincode = $row["vpo_ship_pincode"];
						  $vpo_ship_gstin = $row["vpo_ship_gstin"];
						  $vpo_ship_contact_no = $row["vpo_ship_contact_no"];
						  $vpo_ship_email = $row["vpo_ship_email"];
						  $addtional_charge = $row["addtional_charge"];
						  $payment_terms = $row["payment_terms"];
						  $delivery_lead_time = $row["delivery_lead_time"];
						  $packaging = $row["packaging"];
						  $warranty = $row["warranty"];
						  $vpo_terms_and_conditions = $row["vpo_terms_and_conditions"];
						  $status = $row["status"];
						}
					?>
					{margin:[5,0,0,5], border:[true,false,true,true], text: [
							{text:'Billing To\n', alignment:'left', fontSize: 10, bold:true, border:[false,false,true,false],lineHeight: 1.5},
							{text:'<?php echo $vpo_bill_company_name; ?>\n', alignment:'left', fontSize: 8, bold:true, border:[false,false,true,false],lineHeight: 1.5},
							{ text:'<?php echo $vpo_bill_company_address.'-'.$vpo_bill_pincode; ?>\n', fontSize: 8, alignment:'left', border:[false,false,true,false],lineHeight: 1.3},
							{ text:'GSTIN :<?php echo $vpo_bill_gstin; ?>\n', fontSize: 8, border:[false,false,true,false],alignment:'left',lineHeight: 1.3},
							{ text:'Contact No :<?php echo $vpo_bill_contact_no; ?>\n',border:[false,false,false,true], fontSize: 8, alignment:'left',lineHeight: 1.3},
							{ text:'Email :<?php echo $vpo_bill_email; ?>',border:[false,false,false,true], fontSize: 8, alignment:'left'},
							
							]
					},
					{margin:[5,0,0,5], border:[true,false,true,true], text: [
							{text:'Shipping To\n', alignment:'left', fontSize: 10, bold:true, border:[false,false,true,false],lineHeight: 1.5},
							{text:'<?php echo $vpo_ship_company_name; ?>\n', alignment:'left', fontSize: 8, bold:true, border:[false,false,true,false],lineHeight: 1.5},
							{ text:'<?php echo $vpo_ship_company_address.'-'.$vpo_ship_pincode; ?>\n', fontSize: 8, alignment:'left', border:[false,false,true,false],lineHeight: 1.3},
							{ text:'GSTIN :<?php echo $vpo_ship_gstin; ?>\n', fontSize: 8, border:[false,false,true,false],alignment:'left',lineHeight: 1.3},
							{ text:'Contact No :<?php echo $vpo_ship_contact_no; ?>\n',border:[false,false,false,true], fontSize: 8, alignment:'left',lineHeight: 1.3},
							{ text:'Email :<?php echo $vpo_ship_email; ?>',border:[false,false,false,true], fontSize: 8, alignment:'left'},
							
							]
					},
					]
				]
			}
		},
		{
			style: 'tableExample',
			table: {
				
				widths: [10,148,70,22,20,67,20,80],
				body: [
					[{text: 'S.No',bold:true,alignment:'center',border:[true,false,true,true], fontSize: 8}, {text: 'Description of Goods',bold:true,alignment:'center',border:[true,false,true,true], fontSize: 8},{text: 'Part No',bold:true,alignment:'center',border:[true,false,true,true], fontSize: 8},{text: 'GST%',alignment:'center',bold:true,border:[true,false,true,true], fontSize: 8},{text: 'Qty',alignment:'center',bold:true,border:[true,false,true,true], fontSize: 8},{text: 'Rate',bold:true,alignment:'center',border:[true,false,true,true], fontSize: 8},{text: 'UOM',bold:true,alignment:'center',border:[true,false,true,true], fontSize: 8},{text: 'Amount',bold:true,alignment:'center',border:[true,false,true,true], fontSize: 8}],
					
					<?php  
									   
						$list_vendorpoitems_data = sqlQUERY_LABEL("SELECT * FROM `js_vendor_po_items` where vpo_id = '$id' and deleted = '0'") or die("#1-Unable to get PRODUCT CATEGORY:".sqlERROR_LABEL());

						$count_cateogry_list = sqlNUMOFROW_LABEL($list_vendorpoitems_data);
						while($row_value = sqlFETCHARRAY_LABEL($list_vendorpoitems_data)){
						  $counter_product++;
						  $vpo_item_id = $row_value["vpo_item_id"];
						  $vpo_id = $row_value["vpo_id"];
						  $prdt_id = $row_value["prdt_id"];
						  $prdt_serialno = $row_value["prdt_serialno"];
						  $vpo_item_qty = $row_value["vpo_item_qty"];
						  $vpo_item_price = $row_value["vpo_item_price"];
						  $vpo_item_tax = $row_value["vpo_item_tax"];
						  $vpo_item_tax1 = $row_value["vpo_item_tax1"];
						  $vpo_item_tax2 = $row_value["vpo_item_tax2"];
						  $vpo_item_total = $row_value["vpo_item_total"];
						  $vpo_item_received = $row_value["vpo_item_received"];
						  $vpo_item_difference = $row_value["vpo_item_difference"];
						  $vpo_item_expirydate = $row_value["vpo_item_expirydate"];
						  $vpo_item_grn_status = $row_value["vpo_item_grn_status"];
						  $status = $row_value["status"];
						  $vpo_product_total = ($vpo_item_price * $vpo_item_qty);
						  $product_code = getPRODUCTDETAIL($prdt_id, 'code');
						  $product_name = getPRODUCTDETAIL($prdt_id, 'name');
						  $total_tax =  $vpo_item_tax1 +  $vpo_item_tax2;
						  $total_gross = $vpo_item_total - $total_tax;
					?>
					[{text: '<?php echo $counter_product; ?>',bold:true,margin:[0,5,0,0],alignment:'center',border:[true,false,true,false], fontSize: 8},
					
					{margin:[0,5,0,0],border:[true,false,true,false],text:
						[
							{text: '<?php echo nl2br($product_name);?>', bold:true,alignment:'left',border:[true,false,true,true], fontSize: 8},
							{text: '\n HSN.No: <?php echo ($prdt_serialno);?>', bold:true,alignment:'left',border:[true,false,true,true], fontSize: 8},
							
						]
					},	
					
					{text: '<?php echo $product_code;?>', margin:[0,5,0,0], bold:true,alignment:'center',border:[true,false,true,false], fontSize: 8},{text: '<?php echo $vpo_item_tax;?>%',alignment:'center',bold:true,border:[true,false,true,false], margin:[0,5,0,0], fontSize: 8},{text:'<?php echo $vpo_item_qty;?>',alignment:'center',bold:true,border:[true,false,true,false], margin:[0,5,0,0], fontSize: 8},{text: '<?php echo moneyFormatIndia($vpo_item_price);?>',bold:true, margin:[0,5,0,0],alignment:'right',border:[true,false,true,false], fontSize: 8},{text: 'Nos',bold:true,alignment:'center',border:[true,false,true,false], margin:[0,5,0,0], fontSize: 8},{text: '<?php echo moneyFormatIndia($vpo_product_total);?>',bold:true,alignment:'right',border:[true,false,true,false], margin:[0,5,0,0], fontSize: 8}],
					
					[{text: '',bold:true,alignment:'center',border:[true,false,true,true], fontSize: 8},
					<?php if($placeofsupply == substr($customer_gst, 0, 2)) {  ?>
					{margin:[0,10,0,0],border:[true,false,true,true],text:
						[
							{text: 'CGST@<?php  echo $vpo_item_tax /2; ?>%\n',bold:true,alignment:'right',border:[true,false,true,true], fontSize: 8},
							{text: 'SGST@<?php  echo $vpo_item_tax /2; ?>%\n', alignment:'right',border:[true,false,true,true], fontSize: 8, bold:true},
						]
					},
					<?php }else{ ?>
					{margin:[0,10,0,0],border:[true,false,true,true],text:
						[
							{text: 'IGST@<?php  echo $vpo_item_tax; ?>%\n',bold:true,alignment:'right',border:[true,false,true,true], fontSize: 8},
						]
					},
					<?php } ?>					
					{text: '',bold:true,alignment:'center',border:[true,false,true,true], fontSize: 8},{text: '',alignment:'center',bold:true,border:[true,false,true,true], fontSize: 8},{text: '',alignment:'center',bold:true,border:[true,false,true,true], fontSize: 8},{text: '',bold:true,alignment:'center',border:[true,false,true,true], fontSize: 8},{text: '',bold:true,alignment:'center',border:[true,false,true,true], fontSize: 8},
					<?php if($placeofsupply == substr($customer_gst, 0, 2)) {  ?>
					{margin:[0,10,0,0],border:[true,false,true,true],text:
						[
							{text: '<?php echo moneyFormatIndia($vpo_item_tax1);?>\n',bold:true,alignment:'right',border:[true,false,true,true], fontSize: 8},
							{text: '<?php echo moneyFormatIndia($vpo_item_tax2);?>\n', alignment:'right',border:[true,false,true,true], fontSize: 8, bold:true},
						]
					},
					<?php }else{ ?>
					{margin:[0,10,0,0],border:[true,false,true,true],text:
						[
							{text: '<?php echo moneyFormatIndia($vpo_item_tax1 + $vpo_item_tax2); ?>\n',bold:true,alignment:'right',border:[true,false,true,true], fontSize: 8},
						]
					},
					<?php } ?>					
					],
				<?php } ?>
					<?php if($addtional_charge !='' && $addtional_charge !='0'){ ?>
					[{text: '',bold:true,alignment:'center',border:[true,false,false,true], fontSize: 8}, {text: '',bold:true,alignment:'right',border:[false,false,false,true], fontSize: 8}, {text: '',alignment:'center',bold:true,border:[false,false,false,true], fontSize: 8},{text: '',bold:true,alignment:'center',border:[false,false,false,true], fontSize: 8},{text: '',bold:true,alignment:'center',border:[false,false,false,true], fontSize: 10},{colSpan:2,text: 'Addtional Charges',bold:true,alignment:'right',border:[true,false,false,true], fontSize: 10},{text: '',bold:true,alignment:'center',border:[false,false,false,true], fontSize: 9},{text: '<?php echo moneyFormatIndia($addtional_charge);?>',bold:true,alignment:'right',border:[true,false,true,true], fontSize: 10}],
					<?php } ?>
					[{text: '',bold:true,alignment:'center',border:[true,false,false,true], fontSize: 8}, {text: '',bold:true,alignment:'right',border:[false,false,false,true], fontSize: 8}, {text: '',alignment:'center',bold:true,border:[false,false,false,true], fontSize: 8},{text: '',bold:true,alignment:'center',border:[false,false,false,true], fontSize: 8},{text: '',bold:true,alignment:'center',border:[false,false,false,true], fontSize: 10},{colSpan:2, text: 'Net Value',bold:true,alignment:'right',border:[true,false,false,true], fontSize: 10},{text: '',bold:true,alignment:'center',border:[false,false,false,true], fontSize: 9},{text: '<?php echo moneyFormatIndia($vpo_tot_value);?>',bold:true,alignment:'right',border:[true,false,true,true], fontSize: 10}],
										
				]
			}
		
		},

		{
			style: 'tableExample',
			table: {
				widths: [254,237],
				body: [
					[
					<?php if($vpo_terms_and_conditions !='') { ?>	
					{border:[true,false,false,false],text:
						[
							{text: 'Other Details :\n',bold:true, alignment:'left',border:[true,false,true,true], fontSize: 8,lineHeight: 1.5},
							{text: 'Payment Terms : <?php echo $payment_terms; ?> \n',alignment:'left',border:[true,false,true,true], fontSize: 8,lineHeight: 1.3},
							{text: 'Delivery Lead Time : <?php echo $delivery_lead_time; ?> \n',alignment:'left',border:[true,false,true,true], fontSize: 8,lineHeight: 1.3},
							{text: 'Packaging : <?php echo $packaging; ?> \n',alignment:'left',border:[true,false,true,true], fontSize: 8,lineHeight: 1.3},
							{text: 'Warranty : <?php echo $warranty; ?> \n',alignment:'left',border:[true,false,true,true], fontSize: 8,lineHeight: 1.3},
						]
					},
					<?php } else { ?>
					{border:[true,false,false,true],text:
						[
							{text: 'Other Details : \n',bold:true, alignment:'left',border:[true,false,true,true], fontSize: 8,lineHeight: 1.5},
							{text: 'Payment Terms : <?php echo $payment_terms; ?> \n',alignment:'left',border:[true,false,true,true], fontSize: 8,lineHeight: 1.3},
							{text: 'Delivery Lead Time : <?php echo $delivery_lead_time; ?> \n',alignment:'left',border:[true,false,true,true], fontSize: 8,lineHeight: 1.3},
							{text: 'Packaging : <?php echo $packaging; ?> \n',alignment:'left',border:[true,false,true,true], fontSize: 8,lineHeight: 1.3},
							{text: 'Warranty : <?php echo $warranty; ?> \n',alignment:'left',border:[true,false,true,true], fontSize: 8,lineHeight: 1.3},
						]
					},
					<?php } ?>					
					<?php if($vpo_terms_and_conditions !='') { ?>
					{border:[false,false,true,false],text:
						[
							{text: 'For Rare Fashion\n\n\n\n\n',bold:true, alignment:'right',border:[true,false,true,true], fontSize: 8},
							{text:'Authorised Signatory',bold:true,alignment:'right',border:[true,false,true,true], fontSize: 8},
						]
					},
					<?php } else { ?>
					{border:[false,false,true,true],text:
						[
							{text: 'For Rare Fashion\n\n\n\n',bold:true, alignment:'right',border:[true,false,true,true], fontSize: 8},
							{text:'Authorised Signatory',bold:true,alignment:'right',border:[true,false,true,true], fontSize: 8},
						]
					},	
					<?php } ?>
					]
				]
			}
		},


		{
			style: 'tableExample',
			table: {
				widths: [354,137],
				body: [
					[
					{border:[true,false,false,true],text:
						[
							{text: 'We hereby accept the purchase order as per terms and conditions mentioned above.',bold:true, alignment:'left',border:[true,false,true,true], fontSize: 8,lineHeight: 1.5},
						]
					},
					{border:[false,false,true,true],margin:[0,50,0,0],text:
						[
							{text:'Authorised Signatory',bold:true,alignment:'right',border:[true,false,true,true], fontSize: 8},
						]
					},	
					]
				]
			}
		},
		
			],


			}

    <?php } ?>
    
		function printINVOICE() { 
			pdfMake.createPdf(Vendor_PO_INVOICE).open();
			//pdfMake.createPdf(branchPO).print();
			//pdfMake.createPdf(branchPO).download('optionalName.pdf');
		}
		
		function downloadBILL() { 
			pdfMake.createPdf(Vendor_PO_INVOICE).download('PO. No #:<?php echo $vpo_no; ?> .pdf');
		}
<?php if($route == 'add') { ?>
	$('#vendor_id').select2({
	  selectOnClose: true
	});  
<?php } ?>	
    </script>
  </body>
</html>	
