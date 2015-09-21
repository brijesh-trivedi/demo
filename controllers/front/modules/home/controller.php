<?php
 /**
  * StepIn Solutions venture
  * 
  *
  * @package stepOne 
  */
  class homeController
  {
  	public $aLayout = array('index'=>'main');
	public function callIndex()
	{   
            require("index.tpl.php");
        }
        
  }
