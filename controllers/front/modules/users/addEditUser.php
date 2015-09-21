<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<html>
    <body>
        <form name='addEditUser' method='POST' action=''>
            <table style="background-color: #55555f">
                <tr>
                    <td><input type='text' name='first_name'></td>
                    <td><input type='text' name='last_name'></td>
                    <td><input type='text' name='user_name'></td>
                    <td><input type='password' name='password'></td>
                    <td><input type='radio' name='gender' value='male'><?php echo __('male'); ?>
                    <input type='radio' name='gender' value='male'><?php echo __('female'); ?></td>
                    <select name='hobbies'>
                        <option><?php echo __('cricket'); ?></option>
                        <option><?php echo __('reading'); ?></option>
                        <option><?php echo __('chess'); ?></option>
                    </select>
                </tr>
            </table>
        </form>
    </body>
</html>
