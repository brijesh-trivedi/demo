<form name='searchForm' method='post' action=''>
    <div>
        <input type="text" name='search_text' id="search_text" value='<?php echo isset($_POST['search_text']) ? $_POST['search_text'] : ''; ?>'>
        <input type='submit' name='submit' value="Submit">
    </div>
</form>
<table border='1' >
    <tr style="background-color: #55555f">
        <th>User Id</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>User Name</th>
        <th>Gender</th>
        <th>Hobbies</th>
        <th>Adress</th>
        <th>Mobile</th>
        <th>Email</th>
        <th>Action</th>
    </tr>

<?php
foreach($aUserListing AS $aUserList)
{ ?>
    <tr>
        <td><?php echo $aUserList['user_id']; ?></td>
        <td><?php echo $aUserList['first_name']; ?></td>
        <td><?php echo $aUserList['last_name']; ?></td>
        <td><?php echo $aUserList['user_name']; ?></td>
        <td><?php echo $aUserList['gender']; ?></td>
        <td><?php echo $aUserList['hobbies']; ?></td>
        <td><?php echo $aUserList['address']; ?></td>
        <td><?php echo $aUserList['mobile']; ?></td>
        <td><?php echo $aUserList['email']; ?></td>
        <td><a href=''>Edit/Delete</a></td>
    <tr>

    
    
<?php } ?>
</table>
<table>
    <tr>
     <?php   
        $nCurrentPage = isset($_GET['start']) ? $_GET['start'] : '0';
    ?>
        <td><a href="<?php echo getConfig('siteUrl').'/users/listingforusers/start='.$nCurrentPage=0; ?>"> << </a>&nbsp;
            <?php
            $nCurrentPage = isset($_GET['start']) ? $_GET['start'] : '0';
            $nRecordRemainder = ($nTotalRecords%$nNumberOfPageShow);
             if($nCurrentPage == 0 && $nCurrentPage <= 0)
            {   
                 $nCurrentPage = 0;
            }
            else if($nRecordRemainder == $nCurrentPage)
            {
                $nRecordRemainder = ($nTotalRecords%$nNumberOfPageShow);
                $nCurrentPage =    $nTotalRecords-$nRecordRemainder;
            }
            else
            {
                $nCurrentPage = $nCurrentPage - $nNumberOfPageShow;
            }
            ?>
             <a href="<?php echo getConfig('siteUrl').'/users/listingforusers/start='.$nCurrentPage; ?>"> < &nbsp;&nbsp;
         </td>
    
        <?php
       $nCurrentRecord = isset($_GET['start']) ? $_GET['start'] : '0';
      
       $nOffset = ($nNumberOfPageShow % 2 == 0) ? ($nNumberOfPageShow / 2) : (($nNumberOfPageShow-1) / 2);
       $nStartIndex = (($nCurrentPage-$nOffset) > 0) ? ($nCurrentPage-$nOffset) : 1;
       $nLastIndex = (($nCurrentPage+$nOffset) >= $nTotalPages) ? $nTotalPages : $nCurrentPage;
       $nLastIndex = ($nLastIndex <= $nOffset) ? $nNumberOfPageShow : ($nCurrentPage+$nOffset);
       
       if($nLastIndex > $nTotalPages)
       {
           $nStartIndex = $nTotalPages - $nNumberOfPageShow+1;
           $nLastIndex = $nTotalPages;
       }
        for($nPageCount=$nStartIndex; $nPageCount <= $nLastIndex; $nPageCount++)
        {
            if($nPageCount == 1)
            {
                $nStartRecord = 0;
            }
            else
            {    
                $nStartRecord = ($nPageCount * $nRecordLimitOfPage)-$nRecordLimitOfPage;
            }
        ?>
            <td><a href="<?php echo getConfig('siteUrl').'/users/listingforusers/start='.$nStartRecord ?>"><?php echo $nPageCount; ?></a>&nbsp;</td>
        <?php
            
        }
       ?>
             <td>
       <?php
         $nCurrentPage = isset($_GET['start']) ? $_GET['start'] : '0';
        if($nCurrentPage > $nTotalRecords)
        {   
            $nRecordRemainder = ($nTotalRecords%$nNumberOfPageShow);
            $nCurrentPage = $nTotalRecords-$nRecordRemainder;     
        }
        else
        {
            $nCurrentPage = $nCurrentPage + $nNumberOfPageShow;
            if($nCurrentPage > $nTotalRecords)
            {
                $nRecordRemainder = ($nTotalRecords%$nNumberOfPageShow);
                $nCurrentPage = $nTotalRecords-$nRecordRemainder;     
            }
        }
        ?>
        <a href="<?php echo getConfig('siteUrl').'/users/listingforusers/start='.$nCurrentPage; ?>"> > &nbsp;&nbsp;

         <?php
             $nRecordRemainder = ($nTotalRecords%$nNumberOfPageShow);
            $nCurrentPage =    $nTotalRecords-$nRecordRemainder;
         ?>
          <a href="<?php echo getConfig('siteUrl').'/users/listingforusers/start='.$nCurrentPage; ?>"> >> </a>&nbsp; </td>
    </tr>        
</table>