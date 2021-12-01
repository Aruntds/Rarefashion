<?php
/*
* JACKUS - An In-house Framework for TDS Apps
*
* Author: Touchmark De` Science Private Limited. 
* https://touchmarkdes.com
* Version 1.0.1
* Copyright (c) 2018 Touchmark De`Science
*
*/
extract($_REQUEST);
include_once('jackus.php');

?>
<!doctype html>
<html lang="en">

<head>

    <title><?php echo $__restricted; ?> | <?php echo $_SITETITLE; ?></title>
	<?php 
    //$use_datable = 'N';
    include publicpath('__commonscripts.php'); 
    ?>

</head>

<body class="fixed-header iconsibarbar sidebar-left-close">
    <!-- page loader -->
  
    <!-- page loader ends  -->

    <div class="wrapper">
        <!-- main header -->
        <?php include publicpath('__header.php'); ?>
        <!-- main header ends -->

        
        <!-- sidebar left ends -->

        <!-- content page title -->
        <div class="container-fluid bg-light-opac">

            
        </div>

		<div class="row align-items-center h-100 h-sm-auto">
		<div class="col-12 col-md-8 col-lg-6 mx-auto text-center mt-5">
		<h1 class="display-4 content-color-primary mt-5">You are not allowed to visit this page!</h1><br>
		<!--<a href="dashboard.php" class="btn btn-success btn-rounded mb-4" >
		<span class="icon fa fa-angle-double-left mr-2"> </span>Click to go back
		</a>-->
		</div>
	</div>
        </div>
        <!-- main container ends -->
	
    </div>
    
    <!-- Footer -->
    <?php include publicpath('__footer.php'); ?>
    <!-- End of Footer -->
        
    <!-- DataTable jquery file -->
    <!-- Application main common jquery file -->
    <script src="<?php echo BASEPATH; ?>/public/js/main.js"></script>
    

</body>

</html>
