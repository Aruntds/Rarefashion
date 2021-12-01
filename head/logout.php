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
user_logout();
    
//print_r($_SESSION);
//exit();
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover">
    <link rel="apple-touch-icon" href="<?php echo BASEPATH; ?>/public/img/favicon-apple.png">
    <link rel="icon" href="<?php echo BASEPATH; ?>/public/img/favicon.png">
    <title><?php echo $__logout; ?> | <?php echo $_SITETITLE; ?></title>
</head>
<body>
</body>
</html>