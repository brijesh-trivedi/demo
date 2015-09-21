<?php
 /**
  * StepIn Solutions venture
  * 
  *
  * @package Stepone
  */
  class commonUpdate extends siCommon
  {
        //Constructer
  	public function __construct()
	{
            $sDbHost = getConfig('dbHost');
            $sDbUser = getConfig('dbUser');
            $sDbPassword = getConfig('dbPassword');
            $sDbName = getConfig('dbName');
            parent::__construct($sDbHost,$sDbUser,$sDbPassword,$sDbName);       
	}
        //Update Data
           public function updateRecord($sTableName,$aFields,$aData)
           {
               $sSetVal = (isset ($aFields[2])) ? ",".$aFields[2]." = '".$aData[2]."'" : '';
               $sAndWhere = $aFields[0]." = '".$aData[0]."'";
               $sQuery ="UPDATE ". 
                                $sTableName." 
                         SET ".$aFields[1]." = '".$aData[1]."'".$sSetVal."
                         WHERE ".$sAndWhere;
               
              return $this->executeQuery($sQuery);
           }
  }
                  
 
