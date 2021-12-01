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

//update query
if ($action == "delete" && $id != '') {
	//Insert query
	$arrFields=array('`deleted`');

	$arrValues=array("1");

	$sqlWhere= "customerID=$id";

	if(sqlACTIONS("UPDATE","js_customer",$arrFields,$arrValues, $sqlWhere)) {
		echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
		echo "<script type='text/javascript'>window.location = 'customer.php?code=3'; </script>";
	}
}

//Generating dynamic file names to view/add/edit/delete O/P:  r_{module-name}.php
$generateINCLUDE = viewGENERATOR($currentpage, $route);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
   
    <title><?php include publicpath('__pagetitle.php'); ?> | <?php echo BASEPATH; ?></title>
    <?php 
    //$use_datable = 'N';
    include publicpath('__commonscripts.php'); 
    ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
			if(!in_array($route,array('add', 'edit'))){ ?>
              <a href="?route=add" class="btn btn-xs btn-success btn-icon"><i data-feather="plus"></i> Add</a>
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
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>   
    <script src="<?php echo BASEPATH; ?>/public/integration/parsleyjs/parsley.min.js"></script>
	<script src="<?php echo BASEPATH; ?>/public/pdfmake/pdfmake.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/pdfmake/vfs_fonts.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/buttons.flash.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/jszip.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/buttons.html5.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/buttons.print.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/dataTables.select.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/chart.js/Chart.bundle.min.js"></script>
    <script>

        <?php if($route == '') {  ?>
	
        $('#customerLIST').DataTable({
          //responsive: true,
          'ajax': 'engine/json/JSONcustomer.php?show=<?php echo $show; ?>',
           "columns": [
            { "data": "count" },
			{ "data": "name" },
            { "data": "customeremail" },			
			{ "data": "customerphone" },
			{ "data": "address" },
			{ "data": "customercity" },
			{ "data": "customerstate" },
			{ "data": "customercountry" },
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
				"data": "order",
				"searchable": false,
				"render": function ( data, type, row, full, meta ) {
					return '<a title="View to Preview" href="<?php echo BASEPATH; ?>customer.php?route=preview&formtype=preview&id='+row.modify+'">'+row.name+'</a>';
					//return '';
					//http://localhost/rarefashions/head/customer.php?route=preview&formtype=preview&id=4
				}
			},
		  
		  {
			  	"targets": 8,
				"data": "status",
				"searchable": false,
				"render": function ( data, type, row ) {
				  switch(data) {
					   case '1' : return '<div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input" name="status-'+row.modify+'" id="status'+row.modify+'" checked="" onChange="togglestatusITEM('+row.modify+', '+data+');"> <label class="custom-control-label" for="status'+row.modify+'">Yes</label></div>'; break;
					   case '0' : return '<div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input" name="status--'+row.modify+'" id="status'+row.modify+'" onChange="togglestatusITEM('+row.modify+', '+data+');"> <label class="custom-control-label" for="status'+row.modify+'">Yes</label></div>'; break;
					}
				}
			 }, {
			  	"targets": 9,
				"data": "modify",
				"searchable": false,
				"render": function ( data, type, full, meta ) {
					return '<a title="Click to edit" href="<?php echo BASEPATH; ?>customer.php?route=edit&id='+data+'" class="btn btn-light btn-icon"><i class="fa fa-pencil-alt"></i></a><a href="javascript:void(0);" onClick ="deleteITEM('+data+');" title="Click to delete" class="btn btn-dark btn-icon"><i class="fa fa-trash"></i></a>';
					//return '';
				}
			 } 
		  ],
          language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ Items/Page',
          }
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

		$('#dateofbirth').datepicker({
		  dateFormat: 'dd/mm/yy',
		  showOtherMonths: true,
		  selectOtherMonths: true,
		  changeMonth: true,
		  changeYear: true,
		  maxDate : 0
		});

		function generateusername() {

		var customeremail = document.getElementById('customeremail').value;

		document.getElementById('customers_username').value = customeremail.substring(0, customeremail.indexOf('@'));
		}
 
        function uploadImage(input){
            if (input.files && input.files[0]) {
              var url = URL.createObjectURL(input.files[0]);
              $('#imagePreview').attr('style', 'background-image:url(' + url + ')');
              $('#imagePreview').hide();
              $('#imagePreview').fadeIn(650);
            }
        }

	// CHECK EMAIL ALREADY EXIST IN js_customer //
	  $(document).ready(function(){
		$('#customeremail').parsley();
		var old_customer_emailDETAIL = document.getElementById( "existing_customer_email" ).value;
		window.ParsleyValidator.addValidator('checkemail', {
		  validateString: function(value)
		  {
			return $.ajax({
			  url:'engine/ajax/ajax_customer_check_email.php',
			  method:"POST",
			  data:{customeremail:value ,old_customeremail:old_customer_emailDETAIL},
			  dataType:"json",
			  success:function(data)
			  {
				return true;
			  }
			});
		  }
		});
	  });

	//CHECK MOBILENO ALREADY EXIST IN js_customer //
	 $(document).ready(function(){
	 $('#customerphone').parsley();
	  var old_customers_mobileDETAIL = document.getElementById( "existing_customers_mobile" ).value;
	  //alert(old_staff_mobileDETAIL);
		window.ParsleyValidator.addValidator('checkmobile', {
		  validateString: function(value)
		  {
			return $.ajax({
			  url:'engine/ajax/ajax_customer_check_mobile.php',
			  method:"POST",
			  data:{customerphone:value,old_customerphone:old_customers_mobileDETAIL },
			  dataType:"json",
			  success:function(data)
			  {
				return true;
			  }
			});
		  }
		});
	  });

	//CHECK USERNAME ALREADY EXIST IN js_users///
    $(document).ready(function(){

    $('#customers_username').parsley();
    var old_usernameDETAIL = document.getElementById( "existing_customer_username" ).value;
    window.ParsleyValidator.addValidator('checkusername', {
      validateString: function(value)
      {
        return $.ajax({
          url:'engine/ajax/ajax_fetch_username.php',
          method:"POST",
          data:{username:value ,old_username:old_usernameDETAIL},
          dataType:"json",
          success:function(data)
          {
            return true;
          }
        });
      }
    });

  });
  
	// CHECK EMAIL ALREADY EXIST IN js_users //
	  $(document).ready(function(){
		$('#customeremail').parsley();
		var old_useremailDETAIL = document.getElementById( "existing_customer_email" ).value;
		window.ParsleyValidator.addValidator('checkemail', {
		  validateString: function(value)
		  {
			return $.ajax({
			  url:'engine/ajax/ajax_fetch_user_email.php',
			  method:"POST",
			  data:{useremail:value ,old_useremail:old_useremailDETAIL},
			  dataType:"json",
			  success:function(data)
			  {
				return true;
			  }
			});
		  }
		});
	  });

	//CHECK MOBILENO ALREADY EXIST IN js_users //
	 $(document).ready(function(){
	 $('#customerphone').parsley();
	  var old_user_phoneDETAIL = document.getElementById( "existing_customers_mobile" ).value;
	  //alert(old_staff_mobileDETAIL);
		window.ParsleyValidator.addValidator('checkmobile', {
		  validateString: function(value)
		  {
			return $.ajax({
			  url:'engine/ajax/ajax_fetch_user_mobile.php',
			  method:"POST",
			  data:{user_phone:value,old_user_phone:old_user_phoneDETAIL },
			  dataType:"json",
			  success:function(data)
			  {
				return true;
			  }
			});
		  }
		});
	  });
	  
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
	
	<?php if($route == 'preview' && $formtype == 'preview' && $id !=''){ ?>
	
		$('#customersorderlist').DataTable({
          //responsive: true,
		  dom: 'Bfrtip',
          'ajax': 'engine/json/JSONorderlist.php?filter_customer=<?php echo $id; ?>',
           "columns": [
                    { data: "count" }, //0
                    { data: "ref_no" }, //1
                    { data: "od_date" }, //2
                    { data: "total_item" }, //4
                    { data: "overall_price" }, //4
                    { data: "tax" }, //5
                    { data: "payement_status" }, //5
                    { data: "order_status" } //5
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
            lengthMenu: '_MENU_ Items/Page',
          }
        });

		$('#customer_referal_list').DataTable({
          //responsive: true,
		  dom: 'Bfrtip',
          'ajax': 'engine/json/JSON_customer_referal_list.php?customer_id=<?php echo $id; ?>',
           "columns": [
				{ "data": "count" },
				//{ "data": "customergroup" },
				{ "data": "name" },
				{ "data": "customerphone" },
				{ "data": "total_orders" },
				{ "data": "total_sales" },
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
            lengthMenu: '_MENU_ Items/Page',
          }
        });

          /** PIE CHART **/
        var datapie = {
          labels: ['Total Orders', 'Total Sales'],
          datasets: [{
            data: [<?php echo CUSTOMERWISE_ORDER_DETAILS($user_id,'total_orders'); ?>,<?php echo CUSTOMERWISE_ORDER_DETAILS($user_id,'total_sales'); ?>],
            backgroundColor: ['#00CCCC','#FD7E14','#f10075']
          }]
        };

        var optionpie = {
          maintainAspectRatio: false,
          responsive: true,
          legend: {
            display: false,
          },
          animation: {
            animateScale: true,
            animateRotate: true
          }
        };

        // For a pie chart
        var ctx2 = document.getElementById('chartDonut');
        var myDonutChart = new Chart(ctx2, {
          type: 'pie',
          data: datapie,
          options: optionpie
        }); 
		
	<?php } ?>

	function  deleteITEM(deleting_id) { 
		var SELECTED_ID = deleting_id;
		//alert(SELECTED_ID);
		$('#pleasewait-loader').show();
		$('.receiving-delete-data').load('view/x__customer.php?type=delete&delete_id='+SELECTED_ID+'',function(){
			$('#pleasewait-loader').hide();
			$('#deleteDATA').modal({show:true});
		});
	}
	
	
	function  togglestatusITEM(customerID, status) { 
		var SELECTED_ID = customerID;
		var SELECTED_STATUS = status;
		//alert(SELECTED_ID);
		$('#pleasewait-loader').show();
		$('.receiving-delete-data').load('view/x__customer.php?type=changestatus&customerID='+SELECTED_ID+'&oldstatus='+SELECTED_STATUS+'',function(){
			$('#pleasewait-loader').hide();
			location.reload();
		});
	}

  <?php
    if($code == '1') { 
      $displayMSG_globalclass->displayMSG($code, "Success", 'Record created Successfully', 'success');
    }
	if($code == '2') { 
      $displayMSG_globalclass->displayMSG($code, "Success", 'Record Updated Successfully', 'success');
    }
	if($code == '3') { 
      $displayMSG_globalclass->displayMSG($code, "Success", 'Record Deleted Successfully', 'success');
    }
    if($code == '0') {
      $displayMSG_globalclass->displayMSG($code, "Error", 'Unable to Add Customer.', 'error');  
    }

    if(!empty($err))  {
  ?>
      toastr.error('Error', '<?php foreach ($err as $e) { echo "$e <br>"; } ?>', {timeOut: 6000})
  <?php } ?>
  
  $('#datepicker3').datepicker({
  showOtherMonths: true,
  selectOtherMonths: true,
  changeMonth: true,
  changeYear: true,
  maxDate : '-18y',
  dateFormat : 'dd/mm/yy'
});
    </script>
  </body>
</html>	