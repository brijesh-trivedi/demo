<?php
 /**
  * StepIn Solutions venture
  * 
  *
  * @package Stepone 
  */
  class sessionManager
  {
  	 // constructor
        public function __construct() 
        {
            
            if (session_id()=='')
            {
                session_start();
            }
                
             
        }
        // Set session
        public function setSession($sSessionName,$sSessionValue) 
        {
                        
            $_SESSION[$sSessionName] = $sSessionValue; 
        }
        // Get session
        public function getSession($sSessionName,$sSessionOneTime = false) 
        {
            if(!isset ($_SESSION[$sSessionName]))
                return false;
            
            $sOldSessionName = $_SESSION[$sSessionName];
            if ($sSessionOneTime == true)
            {
                unset($_SESSION[$sSessionName]);
            }
            return $sOldSessionName;
        }
        public function removeSession($sIndividualSession = false) 
        {
            if(!$sIndividualSession)
            {
                session_unset();
            }
            else
            {
               unset($_SESSION[$sIndividualSession]); 
            }
            
        }
        // Error
        public function hasError($sSessionName) 
        {
            if($this->getSession($sSessionName))
            {
                return true;
            }
            else
            {
                return false;
            }
            
        }
        public function setError($sErrorName,$sErrorMessage) 
        {
              return $this->setSession($sErrorName,$sErrorMessage);
        }
        public function getError($sErrorName) 
        {
            return $this->getSession($sErrorName,1);
        }
        
  }
  
