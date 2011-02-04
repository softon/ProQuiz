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
?><?php  
if($_GET['type']=='all'){
    $results_arr = getResults($db,'all');
?>
<div style="clear: both;"></div>
 <div class="headDisp2">All Results :</div>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="results">
	<thead>
		<tr>
            <th>Rank</th>
			<th>Quiz ID</th>
			<th>Username</th>
			<th>Type</th>
			<th>Date</th>
            <th>(%)</th>
			<th>Details</th>
		</tr>
	</thead>
	<tbody>
    <?php foreach($results_arr as $value){
            $user = getUserData($db,$value['user']);
            $type = getQuizType($value['created_by'],$value['locked_quiz']);
            $class = getClass($value['percentage']);
        ?>
		<tr class="<?php echo $class; ?>">
            <td><?php echo $pq->getRank($db,$value['percentage'],$value['time_used']/$value['total_qstn']); ?></td>
			<td>#<a href="summary.php?qid=<?php echo $value['instid']; ?>" target="_blank"><?php echo $value['instid']; ?></a></td>
			<td><?php echo $user['username']; ?></td>
			<td><?php echo $type; ?></td>
            <td class="center"><?php echo  date("d-m-Y",$value['quiz_inst_ts']); ?></td>
			<td class="center"><?php echo $value['percentage']; ?></td>
			<td class="center"><input type="button" class="spbutton" value="Go"  onclick="window.location='summary.php?qid=<?php echo $value['instid']; ?>'" /></td>
		</tr>
		<?php } ?>
	</tbody>
	<tfoot>

		<tr>
			<th>Rank</th>
            <th>Quiz ID</th>
			<th>Username</th>
			<th>Type</th>
			<th>Date</th>
            <th>%</th>
			<th>Details</th>

		</tr>
	</tfoot>
</table>
<div style="clear: both;margin-top: 80px;"></div>
<?php }elseif($_GET['type']=='my_quiz'){
    $results_arr = getResults($db,'my_quiz'); ?>
<div style="clear: both;"></div>
 <div class="headDisp2">My Quiz Results :</div>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="results">
	<thead>
		<tr>
			<th>Rank</th>
            <th>Quiz ID</th>
			<th>Username</th>
			<th>Type</th>
			<th>Percentage (%)</th>

			<th>Details</th>
		</tr>
	</thead>
	<tbody>
    <?php foreach($results_arr as $value){
            $user = getUserData($db,$value['user']);
            $type = getQuizType($value['created_by'],$value['locked_quiz']);
            $class = getClass($value['percentage']);
        ?>
		<tr class="<?php echo $class; ?>">
			<td><?php echo $pq->getRank($db,$value['percentage'],$value['time_used']/$value['total_qstn']); ?></td>
            <td>#<a href="summary.php?qid=<?php echo $value['instid']; ?>" target="_blank"><?php echo $value['instid']; ?></a></td>
			<td><?php echo $user['username']; ?></td>
			<td><?php echo $type; ?></td>
			<td class="center"><?php echo $value['percentage']; ?></td>
			<td class="center"><input type="button" class="spbutton" value="Go"  onclick="window.location='summary.php?qid=<?php echo $value['instid']; ?>'" /></td>
		</tr>
		<?php } ?>
	</tbody>
	<tfoot>

		<tr>
			<th>Rank</th>
            <th>Quiz ID</th>
			<th>Username</th>
			<th>Type</th>
			<th>Percentage</th>

			<th>Details</th>

		</tr>
	</tfoot>
</table>
<div style="clear: both;margin-top: 80px;"></div>
<?php }elseif($_GET['type']=='stats'){
    $results_arr = getResults($db,'stats'); ?>
<div style="clear: both;"></div>
 <div class="headDisp2">Overall Statistics :</div>
<div style="width: 500px;height: 400px;" id="statsImg">
    <?php if($sock = @fsockopen("chart.apis.google.com",80,$error_num,$error_str,5)){ ?>
        <img width="500px" height="400px" src="<?php echo $results_arr; ?>" />
    <?php } ?>
</div>

<div style="clear: both;margin-top: 80px;"></div>

    
<?php }else{ 
    $results_arr = getResults($db,$_GET['type']);
 ?>
<div style="clear: both;"></div>
 <div class="headDisp2">My Results :</div>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="results">
	<thead>
		<tr>
			<th>Rank</th>
            <th>Quiz ID</th>
			<th>Type</th>
            <th>Date</th>
			<th>Percentage (%)</th>

			<th>Details</th>
		</tr>
	</thead>
	<tbody>
    <?php foreach($results_arr as $value){
            $user = getUserData($db,$value['user']);
            $type = getQuizType($value['created_by'],$value['locked_quiz']);
            $class = getClass($value['percentage']);
        ?>
		<tr class="<?php echo $class; ?>">
			<td><?php echo $pq->getRank($db,$value['percentage'],$value['time_used']/$value['total_qstn']); ?></td>
            <td>#<a href="summary.php?qid=<?php echo $value['instid']; ?>" target="_blank"><?php echo $value['instid']; ?></a></td>
			<td><?php echo $type; ?></td>
            <td><?php echo date("d-m-Y",$value['quiz_inst_ts']); ?></td>
			<td class="center"><?php echo $value['percentage']; ?></td>
			<td class="center"><input type="button" class="spbutton" value="Go"  onclick="window.location='summary.php?qid=<?php echo $value['instid']; ?>'" /></td>
		</tr>
		<?php } ?>
	</tbody>
	<tfoot>

		<tr>
			<th>Rank</th>
            <th>Quiz ID</th>
			<th>Username</th>
			<th>Type</th>
			<th>Percentage</th>

			<th>Details</th>

		</tr>
	</tfoot>
</table>
<div style="clear: both;margin-top: 80px;"></div>

<?php } ?>