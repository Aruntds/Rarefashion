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

//List of modules per menu order

//1. Category  
/*
$page_module - Page name of the module on ./root folder
$action - Action performed in that module page

O/P:  r_{module-name}.php
*/
function viewGENERATOR ($page_module, $action) {
	//all actions performed here
	$stripping_module_name = strbefore($page_module, '.');
		
	if($action == 'list') {
		$requested_page_action = 'r__';
	} elseif($action == 'preview') {
		$requested_page_action = 'r__';
	} elseif($action == 'add') {
		$requested_page_action = 'c__';
	} elseif($action == 'edit') {
		$requested_page_action = 'u__';
	} elseif($action == 'delete') {
		$requested_page_action = 'x__';
	} else {
		$requested_page_action = 'r__';
	}
	
	$autoGENFILE = $requested_page_action.$stripping_module_name.'.php';

    $module_path = viewpath($autoGENFILE);

	return $module_path;
}

function productviewGENERATOR ($page_module, $action) {
	//all actions performed here
	$stripping_module_name = strbefore($page_module, '.');
		
	if($action == 'list') {
		$requested_page_action = 'r__';
	} elseif($action == 'preview') {
		$requested_page_action = 'r__';
	} elseif($action == 'step1') {
		$requested_page_action = 's1__'; //Product Info
	} elseif($action == 'step2') {
		$requested_page_action = 's2__'; //Image & Video
	} elseif($action == 'step3') {
		$requested_page_action = 's3__'; //Related & upsell Product
	} elseif($action == 'step4') {
		$requested_page_action = 's4__'; //SEO Settings
	} elseif($action == 'step5') {
		$requested_page_action = 's5__'; //Variant Settings
	} elseif($action == 'step6') {
		$requested_page_action = 's6__'; //Gift Option
	} elseif($action == 'delete') {
		$requested_page_action = 'x__';
	} else {
		$requested_page_action = 'r__';
	}
	
	$autoGENFILE = $requested_page_action.$stripping_module_name.'.php';

    $module_path = viewpath($autoGENFILE);

	return $module_path;
}