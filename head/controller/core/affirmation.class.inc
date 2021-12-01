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
include_once('composer.class.inc');

class affirmativeLICENSEKEY extends composerLICENSEKEY
{

	public function checkVALIDATION()
	{
		$sitekey_status = $this->LICENSEVALID('0', 'LICENSE_SITE_KEY', '../../package.json', $accessaccess_auth, $logged_user_id);
		$accesskey_status = $this->LICENSEVALID('1', 'LICENSE_ACCESS_KEY', '../../package.json', $accessaccess_auth, $logged_user_id);
	}

} //End of class

$affirmative_LICENSE = new affirmativeLICENSEKEY();