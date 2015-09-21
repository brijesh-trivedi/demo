 <?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class usersController 
{ 
    public $aLayout = array('listingforusers'=>'main','login'=>'main');
    public $aLoginRequired = array('login'=>true,'listingforusers'=>false);

     public function __construct() 
        {
            global $sAction;
            global $oUser;
            global $oSession;
            
            
          
            
        }
         public function callLogin()
	{
           
            global $oSession;
            global $oUser;
           if($_POST)
           {    
                redirect(getConfig('siteUrl').'/users/listingforusers');
           }
                require 'login.tpl.php';
           
        }
       
   
   public function callListingForUsers()
   {
      $oUser = new users();
      $aUserListing = $oUser->getListingUser();
      
       require('listingPage.tpl.php');   
   }
}
           