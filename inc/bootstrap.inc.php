<?php
/**
 * StepIn Solutions venture, an MVC framework
 * Bootstrap file
 *
 * @package stepOne 
 */
 require("config.inc.php");
 require("functions.inc.php");
 require(getconfig('rootDir')."/i18n/en.php");
 require(getconfig('rootDir')."/controllers/".$sAppName."/config/config.inc.php");
 $oUser = new users();
 $oSession = new sessionManager();