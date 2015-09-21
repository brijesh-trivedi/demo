<?php
/**
 * StepIn Solutions venture, an MVC framework
 * configuration  file
 *
 * @package stepOne 
 */

     /* Constants */
     
//     define("SITE_URL","http://".$_SERVER["HTTP_HOST"]);
//     define("ROOT_DIR","C:/wamp/www/Addmordel");
//     define("LANGUAGE","en");
//     define("HOME_MODULE","home");
//     define("HOME_ACTION","index");

                    $aConfig['common'] = array(
						'siteUrl' => "http://".$_SERVER["HTTP_HOST"],
						'rootDir' => '/home/stepin/projects/demo',
						'language'=>'en',
                                                'homeModule'=>'users',
                                                'homeAction'=>'login',
                                                'loginModule'=>'',
                                                'loginAction'=>'',
                                                'dbHost'=>'localhost',
                                                'dbUser'=>'root',
                                                'dbPassword'=>'',
                                                'dbName'=>'register',
                                                'nPagerLength'=>'',
                                                'nPerPageRecords'=>'',
                                                'sSessionName'=>'userSession'
                                              );

     /* Database Credentials */
//     $sDbHost = "";
//     $sDbUser = "";
//     $sDbPassword = "";
//     $sDbName = "";
//     $nPagerLength = "";
//     $nPerPageRecords = "";
     
