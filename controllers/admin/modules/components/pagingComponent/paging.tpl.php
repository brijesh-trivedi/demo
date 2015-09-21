<br/>
<table>
    <tr>
        <td> 
                <?php if($nFirstPage < $nCurrentPage) 
                { 
                    ?>
                <a href="#" title="Go to First" onclick="pagging('commonForm',<?php echo $nFirstPage; ?>);">First</a>
                <?php } ?>
        </td>
        
        <td>
                <?php if($nPreviousPage >= $nFirstPage) 
                {
                    ?>
                <a href="#" title="Go to Previous" onclick="pagging('commonForm',<?php echo $nPreviousPage; ?>);">Previous</a>
                <?php } ?>
        </td>
        
        
<?php
    for( $start; $start<=$end; $start++ )
    {   
       ?>  
           <td id="page">
                <a href="#" title="Go to <?php echo $start ; ?>" onclick="pagging('commonForm',<?php echo $start; ?>);"><?php echo $start ; ?></a>
            </td>
  <?php   } ?>
            
            <td>
                <?php if($nNextPage <= $nLastPage) 
                {
                    ?>
                <a href="#" title="Go to Next" onclick="pagging('commonForm',<?php echo $nNextPage; ?>);">Next</a>
                <?php } ?>
            </td>
            
            <td>
                <?php if($nLastPage != $nCurrentPage) 
                {
                    ?>
                <a href="#"  title="Go to Last" onclick="pagging('commonForm',<?php echo $nLastPage; ?>);">Last</a>
                <?php } ?>
            </td>
     </tr>

  </table>
