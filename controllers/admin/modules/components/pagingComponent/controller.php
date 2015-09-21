<?php
 /**
  * StepIn Solutions venture
  * 
  *
  * @package stepOne 
  */
  class pagingComponentController
  {
       
        public $aLayout = array('paging'=>true);
        
	public function callComponent($aPaging=array())
	{  
            $nTotal = $aPaging['totalPages'];
            $nPerPageRecords = $aPaging['perPageRecords'];
            $nPagerLength = $aPaging['length'];
            $nCurrentPage = $aPaging['currentPage'];
            $nPreviousPage =($nCurrentPage - 1);
            $nNextPage =($nCurrentPage + 1);
            $nTotalPages = (floor($nTotal / $nPerPageRecords)) + ($nTotal % $nPerPageRecords > 0);
            $nFirstPage = 1;
            $nLastPage =  $nTotalPages;
            $start = max(($nCurrentPage - $nPagerLength), 1);
            $end = min(($nCurrentPage + $nPagerLength), $nTotalPages);
            $sPaging = true;
            
            require("paging.tpl.php");
	}
  }
