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

	$sqlWhere= "footer_ID=$id";

	if(sqlACTIONS("UPDATE","js_footer",$arrFields,$arrValues, $sqlWhere)) {
		echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
		echo "<script type='text/javascript'>window.location = 'footer.php?code=3'; </script>";
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
    <script src="<?php echo BASEPATH; ?>/public/integration/tinymce/tinymce.min.js"></script>

    <!--<script src="<?php echo BASEPATH; ?>/public/integration/tiny_mce/tiny_mce.js"></script>-->
    <script src="<?php echo BASEPATH; ?>/public/integration/parsleyjs/parsley.min.js"></script>
    
    <script>
      $(function(){
        'use strict'
        <?php if($route == '') {  ?>
	
        $('#projectLIST').DataTable({
          //responsive: true,
          'ajax': 'engine/json/JSONfooter.php?show=<?php echo $show; ?>',
           "columns": [
            { "data": "count" },
            { "data": "footer_title" },
            { "data": "status" },
            { "data": "modify" }
          ],
		  "columnDefs": [{
			  	"targets": 0,
				"data": "count",
				"searchable": false
		  }, {
			  	"targets": 2,
				"data": "status",
				"searchable": false,
				"render": function ( data, type, row ) {
				  switch(data) {
					   case '1' : return '<div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input" name="categorystatus-'+row.modify+'" id="categorystatus'+row.modify+'" checked="" onChange="togglestatusITEM('+row.modify+', '+data+');"> <label class="custom-control-label" for="categorystatus'+row.modify+'">Yes</label></div>'; break;
					   case '0' : return '<div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input" name="categorystatus--'+row.modify+'" id="categorystatus'+row.modify+'" onChange="togglestatusITEM('+row.modify+', '+data+');"> <label class="custom-control-label" for="categorystatus'+row.modify+'">Yes</label></div>'; break;
					}
				}
			 }, {
			  	"targets": 3,
				"data": "modify",
				"searchable": false,
				"render": function ( data, type, full, meta ) {
					return '<a title="Click to edit" href="<?php echo BASEPATH; ?>footer.php?route=edit&id='+data+'" class="btn btn-light btn-icon"><i class="fa fa-pencil-alt"></i></a> <a href="javascript:void(0);" onClick ="deleteITEM('+data+');" title="Click to delete" class="btn btn-dark btn-icon"><i class="fa fa-trash"></i></a>';
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

	function  deleteITEM(deleting_id) { 
		var SELECTED_ID = deleting_id;
		//alert(SELECTED_ID);
		$('#pleasewait-loader').show();
		$('.receiving-delete-data').load('view/x__footer.php?type=delete&delete_id='+SELECTED_ID+'',function(){
			$('#pleasewait-loader').hide();
			$('#deleteDATA').modal({show:true});
		});
	}

	function  togglestatusITEM(footer_ID, status) { 
		var SELECTED_ID = footer_ID;
		var SELECTED_STATUS = status;
		//alert(SELECTED_ID);
		$('#pleasewait-loader').show();
		$('.receiving-delete-data').load('view/x__footer.php?type=changestatus&footer_ID='+SELECTED_ID+'&oldstatus='+SELECTED_STATUS+'',function(){
			$('#pleasewait-loader').hide();
			location.reload();
		});
	}
	
			if($("#footer_description").length > 0){
			tinymce.init({
				selector: "textarea#footer_description",
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



  <?php
    if($code == '1') { 
      $displayMSG_globalclass->displayMSG($code, "Success", 'Record created Successfully', 'success');
    }
	if($code == '2') { 
      $displayMSG_globalclass->displayMSG($code, "Success", 'Record updated Successfully', 'success');
    }
	if($code == '3') { 
      $displayMSG_globalclass->displayMSG($code, "Success", 'Record deleted Successfully', 'success');
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