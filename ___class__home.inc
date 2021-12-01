<?php
/*
* JACKUS - An In-house Framework for TDS Apps
*
* Author: Touchmark Descience Private Limited. 
* https://touchmarkdes.com
* Version 4.0.1
* Copyright (c) 2018-2019 Touchmark Descience Pvt Ltd
*
*/
class __Properties__FrontPage
{
	
    public function loadPAGE($dir) {
		
        //print_r(array($dir));
		
		foreach ($dir as $dir_list) {
			$this->pagesINCLUDE($dir_list);
		}
		
    }
	
    public function pagesINCLUDE($includeFILE) // or any other method
    {
		extract($GLOBALS,EXTR_REFS);
        require_once 'template/'.$includeFILE.'.php';
    }
	
}
$homepage_propertyclass = new __Properties__FrontPage();