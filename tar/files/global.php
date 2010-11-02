<?php

//initialize package array
$packageDirs = array();

//include config
require_once(dirname(__FILE__).'/config.inc.php');

//include WCF
require_once(RELATIVE_WCF_DIR.'global.php');
if(!count($packageDirs)) $packageDirs[] = BASH_DIR;
$packageDirs[] = WCF_DIR;

//starting application
require_once(BASH_DIR.'lib/system/BASHCore.class.php');
new BASHCore();
?>
