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
include_once('check_restricted.php');

//Generating dynamic file names to view/add/edit/delete O/P:  r_{module-name}.php
$generateINCLUDE = viewGENERATOR($currentpage, $route);

$get_selected_id = $_GET['id'];

?>
<!DOCTYPE html>
<html lang="en">
  <head>
   
    <title><?php include publicpath('__pagetitle.php'); ?> | <?php echo BASEPATH; ?></title>
	<link rel="stylesheet" href="<?php echo BASEPATH; ?>/public/integration/EasyAutocomplete-1.3.5/easy-autocomplete.css">
	<link rel="stylesheet" href="<?php echo BASEPATH; ?>/public/css/timedropper.min.css">
	<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    
	<?php 
    //$use_datable = 'N';
    include publicpath('__commonscripts.php'); 
    ?>
  </head>
  <body style="overflow-x:hidden">

	  <!-- main header -->
	  <?php include publicpath('__header.php'); ?>
	  <!-- main header ends -->
  
    <div class="content content-fixed bd-b">
      <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="d-sm-flex align-items-center justify-content-between">
          
            <?php include publicpath('__breadcrumb.php'); ?>

          <div class="mg-t-20 mg-sm-t-0">
		  <?php 
			if(!in_array($route,array('add','edit','list','preview'))){ ?>
              <!--<a href="javascript:;" onclick="show_filterdiv();" id="show_filter" class="btn btn-xs btn-secondary btn-icon mg-r-2"> <i data-feather="filter"></i>Filter</a>-->
            <?php } if(in_array($route,array('preview'))){ ?>
             <a href="<?php echo BASEPATH; ?>order.php" class="btn btn-xs btn-success btn-icon mg-r-2"> <?php echo $__back; ?></a>
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
	
	<div class="modal fade" id="previewORDER" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content tx-14">
          <div class="modal-header">
            <h6 class="modal-title" id="exampleModalLabel2">Order Preview</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body receiving-preview-data"></div>
		  
        </div>
      </div>
    </div>
	
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
 
    <div class="modal fade" id="previewDATA" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-dialog-centered" role="document">
		  <div class="modal-content tx-14">
          <div class="modal-header">
            <h6 class="modal-title" id="exampleModalLabel2">Billing Details</h6>
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
	
	<script src="<?php echo BASEPATH; ?>/public/integration/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/chart.js/Chart.bundle.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/dataTables.dataTables.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-responsive-dt/js/responsive.dataTables.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/select2/js/select2.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/parsleyjs/parsley.min.js"></script>   
	<script src="<?php echo BASEPATH; ?>/public/integration/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/jqueryui/jquery-ui.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/pdfmake/pdfmake.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/pdfmake/vfs_fonts.js"></script>
	<script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/buttons.flash.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/jszip.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/buttons.html5.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/buttons.print.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/dataTables.select.min.js"></script>
	<script src="<?php echo BASEPATH; ?>/public/js/timedropper.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  
    <script>
	
	$(document).ready(function() {
		$("#show_filter").click(function() {
			$("#filter_content").slideToggle("slow");
		});
	});
	
		$('#since_from').datepicker({
	  showOtherMonths: true,
	  selectOtherMonths: true,
	  changeMonth: true,
	  dateFormat: 'dd/mm/yy',
	  changeYear: true,
	  maxDate : 0
	});
	$('#since_to').datepicker({
	  showOtherMonths: true,
	  selectOtherMonths: true,
	  changeMonth: true,
	  dateFormat: 'dd/mm/yy',
	  changeYear: true,
	  maxDate : 0
	});

	
	$("#note_display").hide();
	        <?php if($route == '') {  ?>
	
        $('#amcLIST').DataTable({
          responsive: true,
		  dom: 'Bfrtip',
          'ajax': 'engine/json/JSONorder.php?filter_customer=<?php echo $filter_customer; ?>&since_from=<?php echo $since_from; ?>&since_to=<?php echo $since_to; ?>',
           "columns": [
            { "data": "count" },
			{ "data": "order" },			
			{ "data": "date" },
			{ "data": "customer_name" },
			{ "data": "od_qty" },
			{ "data": "total" },
			{ "data": "payment" },
			{ "data": "orderstatus" },
			{ "data": "modify" }
			
          ],
		  "columnDefs": [{
			  	"targets": 0,
				"data": "count",
				"searchable": false
		  },
		  
		  {
			  	"targets": 1,
				"data": "order",
				"searchable": false,
				"render": function ( data, type, row, full, meta ) {
					return '<a title="Click to Preview" href="<?php echo BASEPATH; ?>order.php?route=preview&id='+row.modify+'">'+row.order+'</a>';
					//return '';
				}
			},
		  
		   {
			  	"targets": 8,
				"data": "modify",
				"searchable": false,
				"render": function ( data, type, full, meta ) {
					return '<a title="Click to Preview" href="javascript:void(0);" onClick ="previewORDER('+data+');" class="btn btn-light btn-icon"><i class="fa fa-eye"></i></a> ';
					//return '';
				}
			}
		  ],
		buttons: [
		{
			extend: 'excel',
			text: window.excelButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4, 5], // Only name, email and role
			}
		},
		{
			extend: 'csv',
			text: window.csvButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4, 5], // Only name, email and role
			}
		},		
		{
			extend: 'pdf',
			text: window.pdfButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4, 5], // Only name, email and role
			}
		}
        ],
          language: {
            searchPlaceholder: 'Search...',
            lengthMenu: '_MENU_ items/page',
          },
		select: true
        });

        // Select2
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
    
	<?php } ?>
	
	var count = document.getElementById('delivery_count').value;
	
	$('#shipping_date').datepicker({
	  showOtherMonths: true,
	  selectOtherMonths: true,
	  changeMonth: true,
	  changeYear: true,
	  dateFormat: 'dd/mm/yy'
	});
	
	$( function() {
	   			$( "#delivery_date" ).datepicker({
	   				minDate: 0
	   			});
	  		});
	
	// $('#delivery_date').datepicker({
	  // showOtherMonths: true,
	  // selectOtherMonths: true,
	  // changeMonth: true,
	  // changeYear: true,
	  // dateFormat: 'dd/mm/yy'
	// });
	
	if(count == '0'){

		$("#time_from").timeDropper();
		$("#time_to").timeDropper();
		
	} else {
		
		$("#time_from").timeDropper({setCurrentTime: false});
		$("#time_to").timeDropper({setCurrentTime: false});
		
	}

	$(function(){
        'use strict'
        <?php if($formtype == 'preview') {  ?>
		
	
	  $('#example').DataTable({
  language: {
    searchPlaceholder: 'Search...',
    sSearch: '',
    lengthMenu: '_MENU_ items/page',
  }
});
	  $('#example1').DataTable({
  language: {
    searchPlaceholder: 'Search...',
    sSearch: '',
    lengthMenu: '_MENU_ items/page',
  }
});

	  $('#triphistory').DataTable({
          
		  dom: 'Bfrtip',
          'ajax': 'engine/json/JSONtrip_history.php?id=<?php echo $id ?>',
           "columns": [
            { "data": "count" },
			{ "data": "place" },
			{ "data": "customer" },
			{ "data": "start_date" },
			{ "data": "end_date" },
            { "data": "status" }
						   
          ],
		  "columnDefs": [{
			  	"targets": 0,
				"data": "count",
				"searchable": false
		  }
		 
		  ],
		buttons: [
		{
			extend: 'copy',
			text: window.copyButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4, 5], // Only name, email and role
			}
		},
		{
			extend: 'excel',
			text: window.excelButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4, 5], // Only name, email and role
			}
		},
		{
			extend: 'csv',
			text: window.csvButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4, 5], // Only name, email and role
			}
		},		
		{
			extend: 'pdf',
			text: window.pdfButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4, 5], // Only name, email and role
			}
		},		
		{
			extend: 'print',
			text: window.printButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4, 5], // Only name, email and role
			}
		}
        ],		  
  language: {
    searchPlaceholder: 'Search...',
    sSearch: '',
    lengthMenu: '_MENU_ items/page',
  }
});
    
	  $('#payment_history').DataTable({
          
		  dom: 'Bfrtip',
          'ajax': 'engine/json/JSONpayment_history.php?id=<?php echo $id ?>',
           "columns": [
            { "data": "count" },
			{ "data": "payment_ref_no" },
			{ "data": "customer" },
			{ "data": "payment_date" },
			{ "data": "amount" },
            { "data": "status" }
						   
          ],
		  "columnDefs": [{
			  	"targets": 0,
				"data": "count",
				"searchable": false
		  }
		 
		  ],
		buttons: [
		{
			extend: 'copy',
			text: window.copyButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4, 5], // Only name, email and role
			}
		},
		{
			extend: 'excel',
			text: window.excelButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4, 5], // Only name, email and role
			}
		},
		{
			extend: 'csv',
			text: window.csvButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4, 5], // Only name, email and role
			}
		},		
		{
			extend: 'pdf',
			text: window.pdfButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4, 5], // Only name, email and role
			}
		},		
		{
			extend: 'print',
			text: window.printButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4, 5], // Only name, email and role
			}
		}
        ],		  
  language: {
    searchPlaceholder: 'Search...',
    sSearch: '',
    lengthMenu: '_MENU_ items/page',
  }
});
    
	<?php } ?>
    
	});
	
//////////////////////////////////      
    <?php  if($route == 'add' || $route == 'edit') {  ?>
 
        /*tinyMCE.init({
            mode : "textareas",
            theme : "advanced"
        });*/
		


/////////////////////////////////
        //fix submit buttons to top on scroll
        function sticktothetop() {
            var window_top = $(window).scrollTop();
            var top = $('#stick-here').offset().top;
            if (window_top > top) {
                $('#stickThis').addClass('stick');
                $('#stick-here').height($('#stickThis').outerHeight());
            } else {
                $('#stickThis').removeClass('stick');
                $('#stick-here').height(0);
            }
        }

        $(window).scroll(sticktothetop);
        sticktothetop();

	<?php } ?>



	<?php if($formtype == 'preview'){ ?>	  			
	var ctx = document.getElementById('chartBar1');
	var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr'],
        datasets: [{
            label: 'Monthly Bookings',
            data: [1000, 2050, 3000, 2070],
            backgroundColor: '#f10075',
        },{
			label: 'Monthly Earnings',
			data: [2000, 3000, 4500, 1500],
			backgroundColor: 'blue',
		}]
    },
	
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});


	<?php } ?>
	

	function  deleteITEM(deleting_id) { 
		var SELECTED_ID = deleting_id;
		//alert(SELECTED_ID);
		$('#pleasewait-loader').show();
		$('.receiving-delete-data').load('view/x__order.php?type=delete&delete_id='+SELECTED_ID+'',function(){
			$('#pleasewait-loader').hide();
			$('#deleteDATA').modal({show:true});
		});
	}
	
	function  previewITEM(id) { 
		var SELECTED_ID = id;
		//alert(SELECTED_ID);
		$('#pleasewait-loader').show();
		$('.receiving-delete-data').load('view/x__order.php?type=preview&id='+SELECTED_ID+'',function(){
			$('#pleasewait-loader').hide();
			$('#previewDATA').modal({show:true});
		});
	}
	
	function  togglestatusITEM(page_ID, status) { 
		var SELECTED_ID = page_ID;
		var SELECTED_STATUS = status;
		//alert(SELECTED_ID);
		$('#pleasewait-loader').show();
		$('.receiving-delete-data').load('view/x__driver.php?type=changestatus&driver_ID='+SELECTED_ID+'&oldstatus='+SELECTED_STATUS+'',function(){
			$('#pleasewait-loader').hide();
			location.reload();
		});
	}
	
	function  previewORDER(id) { 
		var SELECTED_ID = id;
		//alert(SELECTED_ID);
		$('#pleasewait-loader').show();
		$('.receiving-preview-data').load('view/x__order.php?type=preview&id='+SELECTED_ID+'',function(){
			$('#pleasewait-loader').hide();
			$('#previewORDER').modal({show:true});
		});
	}
  
$("#details_edit").hide();
function editDeliverdetails(){
	
	$("#details_preview").hide();
	$("#details_edit").show();
}

function updateDeliverydetails(){
		
	var carrier = document.getElementById('delivery_agent').value;
	//var shipping_date = document.getElementById('shipping_date').value;
	var delivery_date = document.getElementById('delivery_date').value;
	var time_from = document.getElementById('time_from').value;
	var time_to = document.getElementById('time_to').value;
	var count = document.getElementById('delivery_count').value;
	
	$.ajax({
			
			 url: 'engine/ajax/ajax_add_delivery_details.php?id=<?php echo $id; ?>',
			 data: {
					carrier:carrier, delivery_date:delivery_date, time_from:time_from, time_to:time_to, count:count
					},
					//shipping_date:shipping_date,
					success: function(data) {
					var x = data;
					//var y = JSON.parse(x);
					//if(y.status == 'Error') {
				
					//if(y.status == 'Success') {	
					if (x['status'] == "Success") {
						
						$("#details_preview").show();
						//$('#details_preview').load('#details_preview'));
						$("#details_preview").load(window.location.href + " #details_preview" );
						$("#details_edit").hide();
					}
					document.location = "order.php?route=preview&id=<?php echo $id; ?>&code=5";
					return true;
					}
			});
	
}

function order_status_update(){
	
	var order_status = document.getElementById('order_status').value;
	var mail_send = document.getElementById('customCheck3');
	 var customer_email = document.getElementById('customeremail').value;
// alert(customer_email) ;
	var product_id = '<?php echo $product_id; ?>';
	
	if(mail_send.checked){
	var status_mail = 1;	
	}else{
	var status_mail = 0;	
	}
	// alert (status_mail) ;exit();	
		$.ajax({
			
			 url: 'engine/ajax/ajax_order_status_update.php?id=<?php echo $id; ?>',
			 data: {
					order_status:order_status,send_mail:status_mail, product_id:product_id,customer_email:customer_email
					},
					
					success: function(data) {
					var x = data;
					//var y = JSON.parse(x);
					//if(y.status == 'Error') {
				
					//if(y.status == 'Success') {	
					if (x['status'] == "Success") {	
					}
					document.location = "order.php?route=preview&id=<?php echo $id; ?>&code=3";					
					return true;
					}
			});
		 
	
}

function addOrdernote(){
	
	var order_note = document.getElementById("order_notes").value;
	var order_note_type = document.getElementById("order_note_type").value;
	 var customer_email = document.getElementById('customeremail').value;
	 var order_notes = document.getElementById('order_notes').value;
 // alert(customer_email) ;
		
		if(order_notes != ''){
	$.ajax({
			
			 url: 'engine/ajax/ajax_add_order_note.php?id=<?php echo $id; ?>',
			 data: {
					order_note:order_note, order_note_type:order_note_type,customer_email:customer_email,order_notes:order_notes
					},
					
					success: function(data) {
						$("#log_history").load(location.href + " #log_history");
					var x = data;
					//var y = JSON.parse(x);
					//if(y.status == 'Error') {
				
					//if(y.status == 'Success') {	
					if (x['status'] == "Success") {
						
						$("#note_display").show();
						document.querySelector('#note_display').innerHTML = order_note;
					}
					return true;
					}
			});
					} else {
						
						<?php 
						$displayMSG_globalclass->displayMSG($code, "Error", 'Please Insert a Note.', 'error');
						?>
						$('#order_notes').focus();
						
					}
	
}


function send_review_request(){
	var customer_email = document.getElementById('customeremail').value;
	var id_ref_no = document.getElementById('id_ref_no').value;
	
	$.ajax({
			
			 url: 'engine/ajax/ajax_send_request_for_review.php',
			 data: {
					id_ref_no: id_ref_no, customer_email:customer_email
					},
					
					success: function(data) {
					var x = data;
					//var y = JSON.parse(x);
					//if(y.status == 'Error') {
				
					//if(y.status == 'Success') {	
					if (x['status'] == "Success") {
					document.location = "order.php?route=preview&id=<?php echo $id; ?>&code=4";					
					}
					return true;
					}
			});
	
}


	// function mail_send(){
		// <?php 
		// $displayMSG_globalclass->displayMSG($code, "Success", 'Mail Send Successfully', 'success');
		// ?>
	// }

	// function deliveryDetailsUpdated(){
		// <?php 
		// $displayMSG_globalclass->displayMSG($code, "Success", 'Delivery Details Updated', 'success');
		// ?>
	// }
	// function status_updated(){
		// <?php 
		// $displayMSG_globalclass->displayMSG($code, "Success", 'Order Status Updated', 'success');
		// ?>
	// }
	$('#delivery_agent, #order_status').select2({
	  selectOnClose: true
	});
	
	<?php
    if($code == '1') { 
      $displayMSG_globalclass->displayMSG($code, "Success", 'Record Created Successfully', 'success');
    }

    if($code == '2') { 
      $displayMSG_globalclass->displayMSG($code, "Success", 'Record Deleted Successfully', 'success');
    }
  
    if($code == '0') {
      $displayMSG_globalclass->displayMSG($code, "Error", 'Unable to Add Category.', 'error');  
    }
	
	if($code == '3'){
	  $displayMSG_globalclass->displayMSG($code, "Success", 'Order Status Updated', 'success');
	}
	if($code == '4'){
		$displayMSG_globalclass->displayMSG($code, "Success", 'Mail Send Successfully', 'success');
	}
	if($code == '5'){
		$displayMSG_globalclass->displayMSG($code, "Success", 'Delivery Details Updated', 'success');
	}
	
    if(!empty($err))  {
  ?>
      toastr.error('Error', '<?php foreach ($err as $e) { echo "$e <br>"; } ?>', {timeOut: 6000})
  <?php } ?>
  
  $('#filter_customer').select2({
	  selectOnClose: true
	});
  
   </script>
  </body>
</html>	