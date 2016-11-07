<?php echo 'sai-nath';
 /**
  * StepIn Solutions venture, an MVC framework index file, landing page for the project
  * 
  *
  * @package stepOne 
  */
  ob_start();
  require("../../inc/bootstrap.inc.php");
  
  
  $sModule = isset($_GET['module']) ? $_GET['module'] : getconfig('homeModule');
  $sAction = isset($_GET['action']) ? $_GET['action'] : getconfig('homeAction');
  
   $getObject = isset($_GET['get_all']) && (strlen($_GET['get_all'])) ? explode("&",$_GET['get_all']): array();
  unset($_GET['get_all']);

  if(count($getObject))
  {
    foreach($getObject as $sGet)
    {
          $aGet = explode("=",$sGet);
          $_GET[$aGet[0]] = $aGet[1];
    }
  }

  
  if(file_exists(getconfig('rootDir')."/controllers/".$sAppName."/modules/".$sModule."/controller.php"))
  {
 	require(getconfig('rootDir')."/controllers/".$sAppName."/modules/".$sModule."/controller.php");
      
	$oMainController = eval("return new ".$sModule."Controller();");
	
	if(method_exists($oMainController,'call'.$sAction))
	{
            if($oMainController->aLayout[$sAction])
            {
                    require(getconfig('rootDir')."/controllers/".$sAppName."/templates/".$oMainController->aLayout[$sAction].".layout.php");
            }
            else
            {
                eval('$oMainController->call'.$sAction.'();');
            }
                
	}
  }
