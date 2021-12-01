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
require 'plugin/phpmail/PHPMailer/PHPMailerAutoload.php';
require 'plugin/phpmail/PHPMailer/class.phpmailer.php';  //to send email
require 'plugin/phpmail/PHPMailer/class.smtp.php';  //to send email
include_once('check_restricted.php');

$month_and_year = $_GET['monthlyreport'];

if($month_and_year != '') {
	//get month and year seperately
	$month_n_year = explode('/', $month_and_year);
	$filterbills = $month_n_year[0];
	$filteryear = $month_n_year[1];
	
	$filter_by_month = "and  MONTH(billdate)='$filterbills' and YEAR(billdate)='$filteryear'";
}

//Generating dynamic file names to view/add/edit/delete O/P:  r_{module-name}.php
$generateINCLUDE = viewGENERATOR($currentpage, $route);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
   
    <title><?php include publicpath('__pagetitle.php'); ?> | <?php echo BASEPATH; ?></title>
	<link rel="stylesheet" href="<?php echo BASEPATH; ?>/public/integration/EasyAutocomplete-1.3.5/easy-autocomplete.css">
    <?php 
    //$use_datable = 'N';
    include publicpath('__commonscripts.php'); 
    ?>
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
			if(!in_array($route,array('add','edit','list','preview'))){ ?>
              
            <?php } if(in_array($route,array('preview'))){ ?>
				<a href="<?php echo BASEPATH; ?>abandonedcarts"  class="btn btn-xs btn-secondary btn-icon mg-r-2">Back</a>
            <?php } pageREFRESH(curPageURL(), $__refresh); ?>

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
	
	<script src="<?php echo BASEPATH; ?>/public/integration/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/dataTables.dataTables.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-responsive-dt/js/responsive.dataTables.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/select2/js/select2.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/parsleyjs/parsley.min.js"></script>
	<!--<script src="<?php echo BASEPATH; ?>/public/js/bootstrap-datepicker.js"></script>-->
    <script src="<?php echo BASEPATH; ?>/public/integration/jqueryui/jquery-ui.min.js"></script>
	<script src="<?php echo BASEPATH; ?>/public/pdfmake/pdfmake.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/pdfmake/vfs_fonts.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/buttons.flash.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/jszip.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/buttons.html5.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/buttons.print.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/dataTables.select.min.js"></script>
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
	  changeYear: true
	});
	$('#since_to').datepicker({
	  showOtherMonths: true,
	  selectOtherMonths: true,
	  changeMonth: true,
	  dateFormat: 'dd/mm/yy',
	  changeYear: true
	});

	$('#ledger_from').datepicker({
	  showOtherMonths: true,
	  selectOtherMonths: true,
	  changeMonth: true,
	  dateFormat: 'dd/mm/yy',
	  changeYear: true
	});
	
	$('#ledger_to').datepicker({
	  showOtherMonths: true,
	  selectOtherMonths: true,
	  changeMonth: true,
	  dateFormat: 'dd/mm/yy',
	  changeYear: true
	});

	$('#bill_from').datepicker({
	  showOtherMonths: true,
	  selectOtherMonths: true,
	  changeMonth: true,
	  dateFormat: 'dd/mm/yy',
	  changeYear: true
	});
	
	$('#bill_to').datepicker({
	  showOtherMonths: true,
	  selectOtherMonths: true,
	  changeMonth: true,
	  dateFormat: 'dd/mm/yy',
	  changeYear: true
	});

	$('#monthlyreport').datepicker({
	autoclose: true,
	minViewMode: 1,
	format: 'mm/yyyy'
	 });
      $(function(){
        'use strict'
        <?php if($route == '') {  ?>
	
        $('#customersalesreportLIST').DataTable({
          //responsive: true,
		  	dom: 'Bfrtip',
          'ajax': 'engine/json/JSONabandonedcarts.php?filter_customer=<?php echo $filter_customer; ?>&since_from=<?php echo $since_from; ?>&since_to=<?php echo $since_to; ?>',
           "columns": [
            { "data": "count" },
			{ "data": "product_name" },
			{ "data": "product_price" },
			{ "data": "order_quantity" },
			{ "data": "order_price" }        
			],
		  "columnDefs": [{
			  	"targets": 0,
				"data": "count",
				"searchable": false
		  },
			{
			  	"targets": 4,
				"data": "product_name",
				"searchable": false
			}
		  ],
		buttons: [
		{
			extend: 'copy',
			text: window.copyButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4, 5, 6], // Only name, email and role
			}
		},
		{
			extend: 'excel',
			text: window.excelButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4, 5, 6], // Only name, email and role
			}
		},
		{
			extend: 'csv',
			text: window.csvButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4, 5, 6], // Only name, email and role
			}
		},		
		{
			extend: 'pdf',
			text: window.pdfButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4, 5, 6], // Only name, email and role
			}
		},		
		{
			extend: 'print',
			text: window.printButtonTrans,
			exportOptions: {
				columns: [0, 1, 2, 3, 4, 5, 6], // Only name, email and role
			}
		}
        ],

          language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ Items/Page',
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

      });
	  
	
		<?php if($cusid != ''){ ?>
		
		$('#customersalesreportsummaryLIST').DataTable({
          //responsive: true,
		  	dom: 'Bfrtip',
          'ajax': 'engine/json/JSONproductsincart.php?customerid=<?php echo $cusid; ?>&bill_from=<?php echo $bill_from; ?>&bill_to=<?php echo $bill_to; ?>',
           "columns": [
            { "data": "count" },
			{ "data": "order_price" },
			{ "data": "order_quantity" },
			{ "data": "item_tax" },
			{ "data": "product_name" },
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
            lengthMenu: '_MENU_ Items/Page',
          },
		select: true  
        });
	<?php } ?>
  
		  <?php
			if($code == '1') { 
			  $displayMSG_globalclass->displayMSG($code, "Success", 'Record created Successfully', 'success');
			}
		  
			if($code == '0') {
			  $displayMSG_globalclass->displayMSG($code, "Error", 'Unable to Add Client.', 'error');  
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
