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
?>
<!DOCTYPE html>
<html lang="en">
  <head>
   
    <title><?php include publicpath('__pagetitle.php'); ?> | <?php echo $_SITETITLE; ?></title>
    <?php 
    $use_datable = 'N';
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
   
    <div class="content">
      <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="row">
          <div class="col-lg-9">
            <div class="mg-b-25">

        <form method="post" enctype="multipart/form-data" data-parsley-validate>
          
          <div id="stick-here"></div>
          <div id="stickThis" class="form-group row mg-b-0">
          <div class="col-3 col-sm-6">
              <a href="category.php" class="btn btn-secondary" type="cancel">Cancel</a>
            </div>
            <div class="col-9 col-sm-6 text-right">
              <button type="submit" name="save" value="save" class="btn btn-success">Save</button>
              <button type="submit" name="save_close" value="save_close" class="btn btn-success">Save & Close</button>
            </div>
          </div>

        <!-- BASIC Starting -->
        <div id="basic">
          <div class="divider-text">Basic Info</div>
          <div class="form-group row">
            <label for="categorystatus" class="col-sm-2 col-form-label">Active</label>
          <div class="col-sm-7">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" name="categorystatus" id="categorystatus" checked="">
              <label class="custom-control-label" for="categorystatus">Yes</label>
            </div>
          </div>
          </div>

          <div class="form-group row">
            <label for="categoryparentID" class="col-sm-2 col-form-label">Parent Category</label>
            <div class="col-sm-7">
            <select name="categoryparentID" id="categoryparentID" class="custom-select">              
              <?php echo getPARENTCategory($categoryID, 'select'); ?>
            </select>             
            </div>
          </div>

          <div class="form-group row">
            <label for="categoryname" class="col-sm-2 col-form-label">Category Name</label>
            <div class="col-sm-7">
              <input type="text" class="form-control" name="categoryname" id="categoryname" placeholder="Category Name" required data-parsley-error-message="Please enter category name">
            </div>
          </div>

          <div class="form-group row">
            <label for="imageupload" class="col-sm-2 col-form-label">Category Image</label>
                        
            <div class="col-sm-7">

            <div class="custom-file">
              <input type="file" class="custom-file-input" name="categoryimage" id="categoryimage">
              <label class="custom-file-label" for="customFile">Choose file</label>
            </div>

            <div class="media-upload">
                <div class="avatar-preview">
                    <div id="imagePreview" style="background-image: url(public/img/blank-placeholder.jpg);">
                    </div>
                </div>
            </div>

          </div>

          </div>

          <div class="form-group row">
            <label for="categorydescrption" class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-7">
              <textarea class="form-control" rows="2"  name="categorydescrption" id="categorydescrption"></textarea>
            </div>
          </div>
        </div>
        <!-- End of BASIC -->

        <!-- SEO Settings -->
        <div id="seo">

          <div class="divider-text">SEO Settings</div>

          <div class="form-group row">
            <label for="categoryseourl" class="col-sm-2 col-form-label">SEO URL</label>
            <div class="col-sm-7">
              <input type="text" class="form-control" name="categoryseourl" id="categoryseourl" placeholder="SEO URL">
            </div>
          </div>

          <div class="form-group row">
            <label for="categorymetatitle" class="col-sm-2 col-form-label">Meta Title</label>
          <div class="col-sm-7">
              <input type="text" class="form-control" placeholder="Meta Title" name="categorymetatitle" id="categorymetatitle" >
          </div>
          </div>

          <div class="form-group row">
            <label for="categorymetakeywords" class="col-sm-2 col-form-label">Meta Keywords</label>
          <div class="col-sm-7">
              <input type="text" class="form-control" placeholder="Meta Keywords" name="categorymetakeywords" id="categorymetakeywords" >
          </div>
          </div>

          <div class="form-group row">
            <label for="categorymetadescrption" class="col-sm-2 col-form-label">Meta Description</label>
          <div class="col-sm-7">
              <textarea class="form-control" rows="2"  name="categorymetadescrption" id="categorymetadescrption"></textarea>
          </div>
          </div>

        </div>
        <!-- End of SEO Settings -->

        <!-- Design Settings -->
        <div id="design">

          <div class="divider-text">Design Settings</div>

          <div class="form-group row">
            <label for="categorydesignsettings" class="col-sm-2 col-form-label">Display</label>
            <div class="col-sm-7">
            <select name="categorydesignsettings" id="categorydesignsettings" class="custom-select">
              <option value="1" selected>Product List Only</option>
              <option value="2">Content Only</option>
              <option value="3">Product & Content Only</option>
            </select>             
            </div>
          </div>

        </div>
        <!-- End of Design Settings -->

        </form>

            </div><!-- row -->
          </div><!-- col -->
          
          <?php 
            $category_sidebar_view_type='create';
            include viewpath('__generalsidebar.php'); 
          ?>

        </div><!-- row -->
      </div><!-- container -->
    </div><!-- content -->   


    <!-- Footer -->
    <?php include publicpath('__footer.php'); ?>
    <!-- End of Footer -->

    <script src="<?php echo BASEPATH; ?>/public/integration/parsleyjs/parsley.min.js"></script>
    
    <script>
      $(function(){
        'use strict'
    
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