<?php
 /**
  * StepIn Solutions venture
  * 
  *
  * @package Stepone
  */
  class file
  {
       /*
       * This function copy the image from source and paste it to the given path
       * Upload file from one place and copy to the local path given in $sPath
       */
        public function upload($sTempFileName,$sPath)
        {  
            copy($sTempFileName,$sPath);
        }
  }
                  
 
