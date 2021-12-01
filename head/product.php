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

	$sqlWhere= "productID=$id";

	if(sqlACTIONS("UPDATE","js_product",$arrFields,$arrValues, $sqlWhere)) {
		echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
		echo "<script type='text/javascript'>window.location = 'product.php?code=5'; </script>";
	}
}

if($action == 'delete_variant' && $id != '' && $parant_prdt_id !=''){
	
	//Insert query
	$arrFields=array('`deleted`');

	$arrValues=array("1");

	$sqlWhere= "variant_ID=$id";

	if(sqlACTIONS("UPDATE","js_productvariants",$arrFields,$arrValues, $sqlWhere)) {
		echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
		echo "<script type='text/javascript'>window.location = 'product.php?route=step5&parentproduct=$parant_prdt_id&code=5'; </script>";
	}
}
//Generating dynamic file names to step1/step2/step3/step4/step5/edit/delete O/P:  s1_{module-name}.php
$generateINCLUDE = productviewGENERATOR($currentpage, $route);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
   
    <title><?php include publicpath('__pagetitle.php'); ?> | <?php echo $_SITETITLE; ?></title>
    <?php 
    //$use_datable = 'N';
    include publicpath('__commonscripts.php'); 
    ?>
	<link rel="stylesheet" href="<?php echo BASEPATH; ?>/public/integration/EasyAutocomplete-1.3.5/easy-autocomplete.css" > 
	  <link rel="stylesheet" href="<?php echo BASEPATH; ?>/public/css/dropzone.min.css">
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
			if(!in_array($route,array('preview', 'step1', 'step2', 'step3', 'step4', 'step5', 'step6'))){ ?>
			  <a href="?route=import_images" class="btn btn-xs btn-info btn-icon"><i data-feather="upload-cloud"></i> Import Product Images</a>
			  <a href="?route=import_Variant" class="btn btn-xs btn btn-warning"><i data-feather="upload"></i> Import variant</a>
			  <a href="?route=import" class="btn btn-xs btn-danger btn-icon"><i data-feather="upload"></i> Import</a>
              <a href="?route=step1" class="btn btn-xs btn-success btn-icon"><i data-feather="plus"></i> Add</a>
			  
            <?php 
			} /*else {
			?>
              <a href="#offproductSUMMARY" class="btn btn-xs btn-info btn-icon off-canvas-menu"><i data-feather="bar-chart-2"></i> Summary</a>
            <?php } */ ?>

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
	<script src="<?php echo BASEPATH; ?>/public/integration/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/select2/js/select2.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/cleave.js/cleave.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/tinymce/tinymce.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/parsleyjs/parsley.min.js"></script>
	<script src="<?php echo BASEPATH; ?>/public/integration/jqueryui/jquery-ui.min.js"></script>
	<script src="<?php echo BASEPATH; ?>/public/js/dropzone.min.js"></script>
	<script src="<?php echo BASEPATH; ?>/public/js/jquery.form.min.js"></script>

    <script>
	
	
	
	Dropzone.options.imageUpload = {  
		addRemoveLinks: true,
		removedfile: function(file) {
			var name = file.name;        
			$.ajax({
				type: 'POST',
				url: 'ajaxupload.php',
				data: "id="+name,
				dataType: 'html'
			});
		var _ref;
		return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;        
		},
		maxFilesize:5,  
		acceptedFiles: ".jpeg,.jpg,.png,.gif"  
	}; 
	
      $(function(){
        'use strict'
				
        <?php if($route == '') {  ?>	

        $('#productLIST').DataTable({
          //responsive: true,
          'ajax': 'engine/json/JSONproduct.php?show=<?php echo $show; ?>',
           "columns": [
            { "data": "count" },
            { "data": "productsku" },
            { "data": "producttitle" },
            { "data": "productsellingprice" },
            { "data": "productMRPprice" },
            { "data": "productstockstatus" },
            //{ "data": "productopeningstock" },
            { "data": "productavailablestock" },
            { "data": "status" },
            { "data": "modify" }
          ],
		  "columnDefs": [{
			  	"targets": 0,
				"data": "count",
				"searchable": false
		  }, {
			  	"targets": 1,
				"data": "productsku",
				"render": function ( data, type, row ) {
					return '<a href="<?php echo $currentpage; ?>?route=preview&parentproduct='+row.modify+'">'+data+'</a>';
					//return '';
				}
			 }, {
			  	"targets": 2,
				"data": "producttitle",
				"render": function ( data, type, row ) {
					return '<a data-toggle="tooltip" title="Edit Product" href="<?php echo $currentpage; ?>?route=step1&parentproduct='+row.modify+'">'+data+'</a>';
					//return '';
				}
			 }, {
			  	"targets": 5,
				"data": "productstockstatus",
				"searchable": false,
				"render": function ( data, type, row ) {
				  switch(data) {
					   case '1' : return '<div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input" name="productstockstatus-'+row.modify+'" id="productstockstatus'+row.modify+'" checked="" onChange="togglestockstatusITEM('+row.modify+', '+data+');"> <label class="custom-control-label" for="productstockstatus'+row.modify+'">Yes</label></div>'; break;
					   case '0' : return '<div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input" name="productstockstatus--'+row.modify+'" id="productstockstatus'+row.modify+'" onChange="togglestockstatusITEM('+row.modify+', '+data+');"> <label class="custom-control-label" for="productstockstatus'+row.modify+'">Yes</label></div>'; break;
					}
				}
			 }, {			  	
			 	"targets": 7,
				"data": "status",
				"searchable": false,
				"render": function ( data, type, row ) {
				  switch(data) {
					   case '1' : return '<div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input" name="productstatus-'+row.modify+'" id="productstatus'+row.modify+'" checked="" onChange="togglestatusITEM('+row.modify+', '+data+');"> <label class="custom-control-label" for="productstatus'+row.modify+'">Yes</label></div>'; break;
					   case '0' : return '<div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input" name="productstatus--'+row.modify+'" id="productstatus'+row.modify+'" onChange="togglestatusITEM('+row.modify+', '+data+');"> <label class="custom-control-label" for="productstatus'+row.modify+'">Yes</label></div>'; break;
					}
				}
			 }, {
			  	"targets": 8,
				"data": "modify",
				"searchable": false,
				"render": function ( data, type, full, meta ) {
					return '<a title="Click to edit" href="<?php echo $currentpage; ?>?route=step1&parentproduct='+data+'" class="btn btn-light btn-icon"><i class="fa fa-pencil-alt"></i></a> <a href="javascript:void(0);" onClick ="deleteITEM('+data+');" title="Click to delete" class="btn btn-dark btn-icon"><i class="fa fa-trash"></i></a>';
					//return '';
				}
			 } 
		  ],
          language: 
		  {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ Items/Page',
          }
        });

        // Select2
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
		
    <?php 
		}
//////////////////////////////////      
		if($route == 'step1') {  ?>

	/* var sku_options = {
	url: function(phrase) {
		return "engine/json/JSONestoreprdtsearch.php?title=" + encodeURIComponent(phrase) + "&format=json";
	},
		getValue: "title", //prdt_name
		list: {
			onChooseEvent: function() {
				showProduct_RECORD();
			},	
			match: {
				enabled: false
			},
			hideOnEmptyPhrase: true
		},
		theme: "square"
	};
	$("#productecomcode").easyAutocomplete(sku_options);

	function showProduct_RECORD()
	{
		var productDETAIL = document.getElementById( "productecomcode" ).value;	
		//alert('#dummy_po_list_'+po_prdt_id);
	   if(productDETAIL)
	   {
		   $('#progress_sales_table').show();
		   $.ajax({
				   type: 'post', url: 'engine/ajax/ajax_estore_product_data.php?type=getestoreproductinfo',
				   data: { product_info:productDETAIL,
			   },
			   success: function (response) {
				   $('#hide_defalut_prdt_title').hide();
				   $('#hide_deafult_price_value').hide();
				   $('#show_ajax_prdt_title').html(response);				   
				   if(response=="OK") {  return true;  } else { return false; }
			  }
		   });
		}
	}

		if($(".producteditor").length > 0){
			tinymce.init({
				selector: "textarea.producteditor",
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
		
		//productsellingprice
		new Cleave('#productsellingprice', {
		  numeral: true,
		  numeralThousandsGroupStyle: 'lakh'
		});
		//productMRPprice
		new Cleave('#productMRPprice', {
		  numeral: true,
		  numeralThousandsGroupStyle: 'lakh'
		});
		//productpurchaseprice
		new Cleave('#productpurchaseprice', {
		  numeral: true,
		  numeralThousandsGroupStyle: 'lakh'
		}); */
		
	<?php } 

		if($route=='step3') {
	?>
		$('.related_product').select2({
			ajax: { 
			   url: "engine/ajax/AJOSproductlist.php?parentproduct=<?php echo $parentproduct; ?>",
			   type: "post",
			   dataType: 'json',
			   delay: 250,
			   data: function (params) {
				return {
				  q: params.term // search term
				};
			   },
			   processResults: function (response) {
				 return {
					results: response
				 };
			   },
			   cache: true
			  },
			  placeholder: 'Choose one',
			  searchInputPlaceholder: 'Type to Search...',
			  maximumSelectionLength: 10,
			  minimumInputLength: 1
        });	

		$('.upsell_product').select2({
			ajax: { 
			   url: "engine/ajax/AJOSproductlist.php?parentproduct=<?php echo $parentproduct; ?>",
			   type: "post",
			   dataType: 'json',
			   delay: 250,
			   data: function (params) {
				return {
				  q: params.term // search term
				};
			   },
			   processResults: function (response) {
				 return {
					results: response
				 };
			   },
			   cache: true
			  },
			  placeholder: 'Choose one',
			  searchInputPlaceholder: 'Type to Search...',
			  maximumSelectionLength: 10,
			  minimumInputLength: 1
        });		

		//productrelated_show
		$("#related_productshow").click(function () {
			if ($(this).is(":checked")) {
				$("#related_listproducts").show();
			} else {
				$("#related_listproducts").hide();
			}
		});

		//productupsell_show
		$("#upsell_productshow").click(function () {
			if ($(this).is(":checked")) {
				$("#upsell_listproducts").show();
			} else {
				$("#upsell_listproducts").hide();
			}
		});
		
	<?php
		}
		
		if($route=='step2') {
	?>

	function uploadImage(input){
		if (input.files && input.files[0]) {
		  var url = URL.createObjectURL(input.files[0]);
		  $('#imagePreview').attr('style', 'background-image:url(' + url + ')');
		  $('#imagePreview').hide();
		  $('#imagePreview').fadeIn(650);
		}
	}

	$("#productmediagalleryurl").change(function() {
		uploadImage(this);         
	});

	<?php } 
	
		if(in_array($route,array('step1', 'step2', 'step3', 'step4', 'step5', 'step6'))){
	?>
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
	<?php	
	}
		
		if($route == 'preview') {
		?>

        $('.off-canvas-menu').on('click', function(e){
          e.preventDefault();
          var target = $(this).attr('href');
          $(target).addClass('show');
        });


        $('.off-canvas .close').on('click', function(e){
          e.preventDefault();
          $(this).closest('.off-canvas').removeClass('show');
        })
				
		<?php 
		}
	?>

  });

	<?php
	if($route == 'step5') {
	?>	

/* 	var sku_options = {
	url: function(phrase) {
		return "engine/json/JSONestoreprdtsearch.php?title=" + encodeURIComponent(phrase) + "&format=json";
	},
		getValue: "title", //prdt_name
		list: {
			onChooseEvent: function() {
				showProduct_RECORD();
			},	
			match: {
				enabled: false
			},
			hideOnEmptyPhrase: true
		},
		theme: "square"
	};
	$("#sku_code").easyAutocomplete(sku_options); */

/* 	function showProduct_RECORD()
	{
		var productDETAIL = document.getElementById( "sku_code" ).value;	
		//alert('#dummy_po_list_'+po_prdt_id);
	   if(productDETAIL)
	   {
		   $('#progress_sales_table').show();
		   $.ajax({
				   type: 'post', url: 'engine/ajax/ajax_estore_product_data.php?type=addproduct&variantID=<?php echo $variantid; ?>',
				   data: { product_info:productDETAIL,
			   },
			   success: function (response) {
				   $('#hide_default').hide();
				   $('#additem').html(response);				   
				   if(response=="OK") {  return true;  } else { return false; }
			  }
		   });
		}
	} */

        $('#variantLIST').DataTable({
          //responsive: true,
          'ajax': 'engine/json/JSONvariantprdtlist.php?show=<?php echo $show; ?>&parentproduct=<?php echo $parentproduct; ?>',
           "columns": [
            { "data": "count" },
			{ "data": "variant_name" },
			{ "data": "variant_code" },
			{ "data": "variant_stock" },
			{ "data": "variant_mrp_price" },
			{ "data": "variant_msp_price" },
            { "data": "modify" }
          ],
		  "columnDefs": [{
			  	"targets": 0,
				"data": "count",
				"searchable": false
		  }, {
			  	"targets": 1,
				"data": "variant_name",
				"searchable": false,
				"render": function ( data, type, row, full, meta ) {
					return '<a title="Click to edit" href="product.php?route=step5&parentproduct='+row.parentproduct+'&variantid='+row.modify+'" >'+data+'</a>';
				}
			 }, {
			  	"targets": 3,
				"data": "variant_stock",
				"searchable": false,
				"render": function ( data, type, row ) {
				  switch(data) {
					   case '1' : return '<span class="text-success">In-Stock</span>'; break;
					   case '0' : return '<span class="text-danger">Out of Stock</span>'; break;
					}
				}
			 }, {
			  	"targets": 6,
				"data": "modify",
				"searchable": false,
				"render": function ( data, type, row, full, meta ) {
					return '<a href="javascript:void(0);" onClick ="deletevariantITEM('+data+','+row.parentproduct+');" title="Click to delete" class="btn btn-dark btn-icon"><i class="fa fa-trash"></i></a>';
					//return '';
				}
			 } 
		  ],
          language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
          }
        });

        // Select2
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

	function  deletevariantITEM(deleting_id,parant_prdt_ID) { 
		var SELECTED_ID = deleting_id;
		var PARANT_PRDT_ID = parant_prdt_ID;
		//alert(SELECTED_ID);
		$('#pleasewait-loader').show();
		$('.receiving-delete-data').load('view/x__<?php echo $currentpage; ?>?type=variant_delete&delete_id='+SELECTED_ID+'&parant_prdt_id='+PARANT_PRDT_ID +'',function(){
			$('#pleasewait-loader').hide();
			$('#deleteDATA').modal({show:true});
		});
	}
	<?php	
	}
	?>
	
	<?php
	if($route =='step6') {
	?>	
	 $("#productgiftmessage").click(function () {
		if ($(this).is(":checked")) {
			$("#gift_wrapping").show();
		} else {
			$("#gift_wrapping").hide();
		}
	});
	
	//productgiftwrappingprice
	new Cleave('#productgiftwrappingprice', {
	  numeral: true,
	  numeralThousandsGroupStyle: 'lakh'
	});
	
	<?php	
	}
	?>

	function  deleteITEM(deleting_id) { 
		var SELECTED_ID = deleting_id;
		//alert(SELECTED_ID);
		$('#pleasewait-loader').show();
		$('.receiving-delete-data').load('view/x__<?php echo $currentpage; ?>?type=delete&delete_id='+SELECTED_ID+'',function(){
			$('#pleasewait-loader').hide();
			$('#deleteDATA').modal({show:true});
		});
	}

	function  togglestockstatusITEM(product_id, status) { 
		var SELECTED_ID = product_id;
		var SELECTED_STATUS = status;
		//alert(SELECTED_ID);
		$('#pleasewait-loader').show();
		$('.receiving-delete-data').load('view/x__<?php echo $currentpage; ?>?type=changestockstatus&productID='+SELECTED_ID+'&oldstatus='+SELECTED_STATUS+'',function(){
			$('#pleasewait-loader').hide();
			location.reload();
		});
	}
	
	function  togglestatusITEM(product_id, status) { 
		var SELECTED_ID = product_id;
		var SELECTED_STATUS = status;
		//alert(SELECTED_ID);
		$('#pleasewait-loader').show();
		$('.receiving-delete-data').load('view/x__<?php echo $currentpage; ?>?type=changestatus&productID='+SELECTED_ID+'&oldstatus='+SELECTED_STATUS+'',function(){
			$('#pleasewait-loader').hide();
			location.reload();
		});
	}
			
	function deleteRECORD(idurl)
	{
		go_on = confirm("Do you want to delete ? ");
		if(go_on)
		{
		document.location.href=idurl;
		}
	}
	
  <?php
    if($code == '-1') { 
      $displayMSG_globalclass->displayMSG($code, "Info", 'Step Skipped Successfully', 'info');
    }

    if($code == '1') { 
      $displayMSG_globalclass->displayMSG($code, "Success", 'Product Saved Successfully', 'success');
    }
	 if($code == '5') { 
      $displayMSG_globalclass->displayMSG($code, "Success", 'Product Deleted Successfully', 'success');
    }

    if($code == '11') { 
      $displayMSG_globalclass->displayMSG($code, "Success", 'Product Updated Successfully', 'success');
    }
 
    if($code == '22') { 
      $displayMSG_globalclass->displayMSG($code, "Success", 'Product Image Saved Successfully', 'success');
    }
 
    if($code == '2') { 
      $displayMSG_globalclass->displayMSG($code, "Deleted", 'Product Image removed Successfully', 'info');
    }
 
    if($code == '3') { 
      $displayMSG_globalclass->displayMSG($code, "Updated", 'Featured Image Set Successfully', 'success');
    }
 
    if($code == '4') { 
      $displayMSG_globalclass->displayMSG($code, "Updated", 'Product Video Saved Successfully', 'success');
    }
	 
    if($code == '0') {
      $displayMSG_globalclass->displayMSG($code, "Error", 'Unable to Add Product.', 'error');  
    }

    if(!empty($err))  {
  ?>
      toastr.error('<?php foreach ($err as $e) { echo "$e <br>"; } ?>', 'Error', {timeOut: 6000})
  <?php } ?>
  
</script>


  </body>
</html>	
