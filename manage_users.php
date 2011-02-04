<?php
/*!
 * **************************************************************
 ****************  ProQuiz V2.0.0b ******************************
 ***************************************************************/
 /* documentation at: http://proquiz.softon.org/documentation/
 /* Designed & Maintained by
 /*                                    - Softon Technologies
 /* Developer
 /*                                    - Manzovi
 /* For Support Contact @
 /*                                    - proquiz@softon.org
 /* version 2.0.0 beta (2 Feb 2011)
 /* Licensed under GPL license:
 /* http://www.gnu.org/licenses/gpl.html
 */
?>
<div style="clear: both;"></div>
<div style="margin-top: 20px;">
<!-- Error Display Box Start  -->
<?php include('error.php'); ?>
<!-- Error Box End --></div>
 <div class="headDisp2">Manage Users :</div>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="activateQstn">
	<thead>
		<tr>
			<th>No.</th>
			<th>User Name</th>
            <th>Rating</th>
			<th>Make Admin</th>            
			<th>Activate</th>
		</tr>
	</thead>
	<tbody>
    <?php 
            $results_arr = $auth->getUsersList($db,$_SESSION['UA_DETAILS']);
            $no =0;
            foreach($results_arr as $value){
                $no++;
        ?>
		<tr>
			<td><?php echo $no; ?></td>
			<td><?php echo $value['username']; ?></td>
            <td><?php for($i=1;$i<=10;$i++){
                            if($i == $value['rating']){
                                echo '<input name="user_rating'.$no.'" type="radio" class="star {split:2}" checked="checked" disabled="disabled"/>';   
                            }else{
                                echo '<input name="user_rating'.$no.'" type="radio" class="star {split:2}" disabled="disabled"/>';
                            }
                        }                
                ?>
            </td>
            <td class="center"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=getpage&page=manage_users&subaction=makeadmin&level=<?php echo $value['level']; ?>&randid=<?php echo $value['randid']; ?>"><img src="images/<?php if($value['level']=='admin') { echo "admin";} else {echo "user";} ?>.png" width="32px" height="32px" /></a></td>
            <td class="center"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=getpage&page=manage_users&subaction=actuser&randid=<?php echo $value['randid']; ?>"><img src="images/<?php if($value['active']) { echo "act";} else {echo "actd";} ?>.png" width="32px" height="32px" /></a></td>
		</tr>
		<?php } ?>
	</tbody>
	<tfoot>

		<tr>
			<th>No.</th>
			<th>User Name</th>
            <th>Rating</th>
			<th>Make Admin</th>            
			<th>Activate</th>

		</tr>
	</tfoot>
</table>
<div style="clear: both;margin-top: 80px;"></div>