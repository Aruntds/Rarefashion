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
if($route == 'import'){ob_start();session_start();}

include_once('jackus.php');

reguser_protect();
 include_once('check_restricted.php');
//update query
if ($route == "delete" && $id != '' && $restricted_access !="0") {
	//Insert query
	$arrFields=array('`deleted`');

	$arrValues=array("1");

	$sqlWhere= "vpo_id=$id";

	if(sqlACTIONS("UPDATE","js_vendorpo",$arrFields,$arrValues, $sqlWhere)) {
		echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
		echo "<script type='text/javascript'>window.location = 'supplierpo.php?code=1'; </script>";
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
	<link rel="stylesheet" href="<?php echo BASEPATH; ?>/public/integration/bootstrap/css/bootstrap-select.min.css">
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
			if(!in_array($route,array('add', 'edit', 'list','preview','import'))){ ?>
              <a href="?route=add" class="btn btn-xs btn-success btn-icon mg-r-2"><i data-feather="plus"></i><?php echo $__create ?></a>
            <?php } ?>
			<?php 
			if($route!='' && $formtype=='import_response'){ ?>
              <a href="supplierpo.php?route=add&id=<?php echo $id; ?>&switch=Y" class="btn btn-xs btn-warning btn-icon mg-r-2"><i data-feather=""></i> Back to Po List</a>
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
		$invoice_logo = $site_url.'public/img/arm_logo.jpg';
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
	<script src="<?php echo BASEPATH; ?>/public/integration/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="<?php echo BASEPATH; ?>/public/integration/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.min.js"/></script>
	<script src="<?php echo BASEPATH; ?>/public/integration/bootstrap/js/bootstrap-select.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/pdfmake/pdfmake.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/pdfmake/vfs_fonts.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/buttons.flash.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/jszip.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/buttons.html5.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/buttons.print.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/dataTables.select.min.js"></script>
	<script src="<?php echo BASEPATH; ?>/public/integration/tableExport/tableExport.js"></script>
	<script type="text/javascript" src="<?php echo BASEPATH; ?>/public/integration/tableExport/jquery.base64.js"></script>
	<script>

	// $(document).ready(function(){
		// $("#myModal").modal('show');
	// });\
		
		$('#offers_start_date').datetimepicker({
			dateFormat: 'dd/mm/yy',
			showOtherMonths: true,
			selectOtherMonths: true,
			changeMonth: true,
			changeYear: true, 
			minDate: 0
		});
				
		$('#offers_expiry_date').datetimepicker({
			dateFormat: 'dd/mm/yy',
			showOtherMonths: true,
			selectOtherMonths: true,
			changeMonth: true,
			changeYear: true,
			minDate: 0
		});
		
      $(function(){
        'use strict'
        <?php if($route == '') {  ?>
	
        $('#VendorpoLIST').DataTable({
          responsive: true,
		  dom: 'Bfrtip',
          'ajax': 'engine/json/JSONoffers.php',
           "columns": [
            { "data": "count" },
            { "data": "offers_name" },
            { "data": "start_date" },
            { "data": "expiry_date" },
			{ "data": "offer_status" },
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
				 
					return '<a title="Click to Edit" href="offers.php?route=add&&id='+data+'&switch=N" class="btn btn-light btn-icon"><i class="fa fa-pen"></i></a> ';
				 
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
	if($route == 'add' && $id != ''){ ?>
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
		
		function get_productdtls_List()
		{
			var get_prdt_id =document.getElementById( "product-data" ).value;
			
			// alert(vpo_id);
			
		   if(get_prdt_id)
		   {
			   $('#progress_table').show();
			   $.ajax({
					   type: 'post', url: 'engine/ajax/ajax_generatecode.php?type=product_type_search',
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
		
		function get_offer_product_List()
		{ 
			var po_vpo_id =  '<?php echo $id; ?>';
			var po_vendor = '<?php echo $selected_vpo_vendor_id; ?>';
			var po_prdt_id =document.getElementById( "choosen_prdt_id" ).value;	
			var po_prdt_qty = document.getElementById( "prdt_roq" ).value;
			var po_prdt_price = document.getElementById( "prdt_purchase_price" ).value;
			var po_prdt_tax = document.getElementById( "prdt_tax" ).value;	          
			var po_tax_type = document.getElementById( "tax_type" ).value;	     
			var po_prdt_unit = document.getElementById( "ajax_prdt_unit" ).value;	     
			var po_prdt_unit_count = document.getElementById( "prdt_unit_count" ).value;	     
			var po_prdt_expiry_on = document.getElementById( "prdt_expiry_on" ).value;	     
		
		   if(po_prdt_id !='' && po_prdt_expiry_on !='' && po_prdt_unit_count !='' && po_prdt_unit !='')
		   {
			   $('#progress_table').show();
			   $.ajax({
					   type: 'post', url: 'engine/ajax/ajax_generatecode.php?type=product_add_item',
					   data: { po_main_refid:po_vpo_id, po_vendor_type:po_vendor, po_product_id:po_prdt_id, po_product_qty:po_prdt_qty, po_product_price:po_prdt_price, po_product_tax:po_prdt_tax, po_tax_type:po_tax_type,po_product_expiry_on:po_prdt_expiry_on, po_product_unit:po_prdt_unit, po_product_unit_count:po_prdt_unit_count,

				   },
				   
				   success: function (response) {
					   $('#progress_table').hide();
					   $('#quickbill_offer_details').html(response);
					   $('input[type=text]').val('');
					   $("#product-data").focus();
					   if(response=="OK") {  return true;  } else { return false; }
				  }
			   });
			} else {
			    alert('All the Fields are Required');
			}
		}

		
	<?php } ?>
	
      });
	  
   function check_offer_value() {
    var offertype = document.getElementById("offertype");
    var selectedValue = offertype.options[offertype.selectedIndex].value;
     if(selectedValue == '0'){
		$("#offer_val_div").hide();
 	 }
	 if(selectedValue == '1'){
		$("#offer_val_div").show();
		$("#offer_val").html('Offer Qty');
		if( selectedValue =='<?php echo $selected_type_id ?>'){
		$("#offer_value").val('<?php echo $offer_value ?>');
		}else{
		$("#offer_value").val('');	
		}
	 }
	 if(selectedValue == '2'){
		$("#offer_val_div").show();
		$("#offer_val").html('Offer Amount');
		if( selectedValue =='<?php echo $selected_type_id ?>'){
		$("#offer_value").val('<?php echo $offer_value ?>');
		}else{
		$("#offer_value").val('');	
		}
	 }
	 if(selectedValue == '3'){
		$("#offer_val_div").show();
		$("#offer_val").html('Offer Percentage');
		if( selectedValue =='<?php echo $selected_type_id ?>'){
		$("#offer_value").val('<?php echo $offer_value ?>');
		}else{
		$("#offer_value").val('');	
		}
	 }
   }
           function uploadImage(input){
            if (input.files && input.files[0]) {
              var url = URL.createObjectURL(input.files[0]);
              $('#imagePreview').attr('style', 'background-image:url(' + url + ')');
              $('#imagePreview').hide();
              $('#imagePreview').fadeIn(650);
            }
        }

        //document.querySelector("input").onchange = function(){uploadImage(this)};

        $("#offersimage").change(function() {
            uploadImage(this);         
        });
		function get_productitem_List()
		{ 
			var id =  '<?php echo $id; ?>';
 			var prdt_id = document.getElementById( "choosen_prdt_id" ).value;	     
 			var prdt_price = document.getElementById( "prdt_purchase_price" ).value;	     
 			var prdt_name = document.getElementById( "producttitle" ).value;	     
 			var prdt_code = document.getElementById( "productsku" ).value;	     
 			var start_date = document.getElementById( "start_date" ).value;	     
 		// alert(start_date)
		   
			   $('#progress_table').show();
			   $.ajax({
					   type: 'post', url: 'engine/ajax/ajax_add_offer_products.php?type=product_add_item',
					   data: { prdt_code:prdt_code, prdt_name:prdt_name, prdt_price:prdt_price, prdt_id:prdt_id,start_date:start_date, id:id 
				   },
				   
				   success: function (response) {
					   $('#progress_table').hide();
 					   $("#product-data").val('');
 					   $("#quickbill_offer_details").load(" #quickbill_offer_details");
 					   $("#show_product_list").load(" #show_product_list");
 					   $(".investment-summary").load(" .investment-summary");
					    if(response =='1'){
					    $("#msg_success").html("Product Successfully Added");
						}
						if(response =='2'){
					    $("#msg_warning").html("Unable to add the product");
						}
						setTimeout(function () { $("#msg_success").html(""); $("#msg_warning").html("") }, 3000);
					   if(response=="OK") {  return true;  } else { return false; }
				  }
			   });
			 
		}
		function remove_productitem_List(id)
		{ 
			var offer_id =  id;
 			   
 			   $('#progress_table').show();
			   $.ajax({
					   type: 'post', url: 'engine/ajax/ajax_add_offer_products.php?type=remove_added_item',
					   data: { offer_id:offer_id 
				   },
				   
				   success: function (response) {
					   $('#progress_table').hide();
					   $("#product-data").val('');
 					   $("#quickbill_offer_details").load(" #quickbill_offer_details");
 					   $("#show_product_list").load(" #show_product_list");
					   $(".investment-summary").load(" .investment-summary");
					   
					   if(response=="OK") {  return true;  } else { return false; }
				  }
			   });
			 
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
    }); 

	$(document).ready(function () {
		$('.group-checkable_DELETE').on('click', function () {
		$(this).closest('table').find('tbody :checkbox')
		.prop('checked', this.checked)
		.closest('tr').toggleClass('selected', this.checked);
		});
		
		$('tbody :checkbox').on('click', function () {
		$(this).closest('tr').toggleClass('selected', this.checked); //Classe de seleção na row
		
		$(this).closest('table').find('.group-checkable_DELETE').prop('checked', ($(this).closest('table').find('tbody :checkbox:checked').length == $(this).closest('table').find('tbody :checkbox').length)); 
		});
    });   

		
		
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
  
    </script>
  </body>
</html>	
