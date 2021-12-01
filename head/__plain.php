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
?>
<!DOCTYPE html>
<html lang="en">
  <head>

    <title><?php echo $__sampletitle; ?> | <?php echo $_SITETITLE; ?></title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo BASEPATH; ?>/public/img/favicon.png">

    <link href="<?php echo BASEPATH; ?>/public/integration/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="<?php echo BASEPATH; ?>/public/integration/ionicons/css/ionicons.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo BASEPATH; ?>/public/css/dashforge.css">
    <link rel="stylesheet" href="<?php echo BASEPATH; ?>/public/css/dashforge.dashboard.css">
    <link rel="stylesheet" href="<?php echo BASEPATH; ?>/public/css/skin.gradient1.css">
  </head>
  <body>

	<!-- main header -->
	<?php include publicpath('__header.php'); ?>
	<!-- main header ends -->
  
    <!-- Footer -->
    <?php include publicpath('__footer.php'); ?>
    <!-- End of Footer -->
  </body>
</html>	