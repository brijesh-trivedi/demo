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
        public $aLoginRequired = array('index'=>true);
       
	public function callIndex()
	{
            require("index.tpl.php");
	}
       
  }
