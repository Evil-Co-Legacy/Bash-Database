<?php

// define paths
define('RELATIVE_BASH_DIR', '../');

//initialize package array
$packageDirs = array();

//include config
require_once(dirname(dirname(__FILE__)).'/config.inc.php');

//include WCF
require_once(RELATIVE_WCF_DIR.'global.php');
if(!count($packageDirs)) $packageDirs[] = BASH_DIR;
$packageDirs[] = WCF_DIR;

// starting acp
require_once(BASH_DIR.'lib/system/BASHACP.class.php');
new BASHACP();
?>
