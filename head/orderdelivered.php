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
			if(in_array($route,array('preview'))){ ?>
             <a href="<?php echo BASEPATH; ?>orderdeliveredreport" class="btn btn-xs btn-success btn-icon mg-r-2"> <?php echo $__back; ?></a>
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
    <script>
	
	<?php if($route == '') {  ?>
	
        $('#deliveredorderLIST').DataTable({
          responsive: true,
		  dom: 'Bfrtip',
          'ajax': 'engine/json/JSONorderedreport.php?status=6',
           "columns": [
            { "data": "count" },
			{ "data": "order" },			
			{ "data": "date" },
			{ "data": "customer_name" },
			{ "data": "od_qty" },
			{ "data": "total" },
			{ "data": "payment" },
			{ "data": "orderstatus" }
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
					return '<a title="Click to Preview" href="<?php echo BASEPATH; ?>order?route=preview&formtype=preview&id='+row.modify+'">'+row.order+'</a>';
					//return '';
				}
			},
		  
		   {
			  	"targets": 7,
				"data": "orderstatus",
				"searchable": false
				/* "render": function ( data, type, full, meta ) {
					return '<a title="Click to Preview" href="javascript:void(0);" onClick ="previewORDER('+data+');" class="btn btn-light btn-icon"><i class="fa fa-eye"></i></a> ';
					return '';
				} */
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
			sSearch: '',
            lengthMenu: '_MENU_ Items/Page',
          },
		select: true
        });

        // Select2
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
    
	<?php } ?>

   </script>
  </body>
</html>	