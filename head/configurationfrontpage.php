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

?>
<!DOCTYPE html>
<html lang="en">
  <head>
   
    <title><?php include publicpath('__pagetitle.php'); ?> | <?php echo $_SITETITLE; ?></title>
    <?php 
    $use_datable = '';
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

    <script src="<?php echo BASEPATH; ?>/public/integration/select2/js/select2.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/parsleyjs/parsley.min.js"></script>
    
    <script>

//$('#featuredproducts').focus();	
      $(function(){
        'use strict'

		$('.catalogue_searchproduct').select2({
			  ajax: { 
			   url: "engine/ajax/AJOSproductlist.php",
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

		//$('#frontpage_featuredproducts').select2().select2('val', "1")

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

      });

//frontpage_categoryshow
	$("#frontpage_categoryshow").click(function () {
		if ($(this).is(":checked")) {
			$("#settings_frontpage_categorylistproducts").show();
		} else {
			$("#settings_frontpage_categorylistproducts").hide();
		}
	});

//frontpage_featuredshow
	$("#frontpage_featuredshow").click(function () {
		if ($(this).is(":checked")) {
			$("#settings_frontpage_featuredproducts").show();
		} else {
			$("#settings_frontpage_featuredproducts").hide();
		}
	});

//frontpage_blogsettings
	$("#frontpage_blogshow").click(function () {
		if ($(this).is(":checked")) {
			$("#settings_frontpage_blog").show();
		} else {
			$("#settings_frontpage_blog").hide();
		}
	});
		
  <?php
    if($code == '1') { 
      $displayMSG_globalclass->displayMSG($code, "Success", 'Settings created Successfully', 'success');
    }
	
    if($code == '2') { 
      $displayMSG_globalclass->displayMSG($code, "Updated", 'Settings Updated Successfully', 'success');
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