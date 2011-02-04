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
function getMCQresult($value,$ans,$key){

        $qstn_opt = explode("|",$value['options']);
        $tot_opt = count($qstn_opt);


?>
<div id="qstn<?php echo $key+1; ?>" class="pq_container">
            <div class="pq_qno">Q.<?php echo $key+1; ?></div>
            <div class="pq_cat"><?php echo $value['category']; ?></div>
            <div class="pq_question_hld">                            
                <div class="pq_qtn"><?php echo $value['question']; ?></div>
                <div class="pq_opt_hld">
                    <div class="pq_opt_col1">
                    <?php for($i=0;$i<$tot_opt;$i=$i+2){ ?> 
                        <div id="<?php echo ($key+1).'_'.$i; ?>" class="<?php echo getResultsClass($qstn_opt[$i],$ans,$value['answer']); ?>"><span></span><?php echo $qstn_opt[$i]; ?></div>
                     <?php } ?>
                    </div>
                    <div class="pq_opt_col2"> 
                    <?php for($i=1;$i<$tot_opt;$i=$i+2){ ?>
                        <div id="<?php echo ($key+1).'_'.$i; ?>" class="<?php echo getResultsClass($qstn_opt[$i],$ans,$value['answer']); ?>"><span></span><?php echo $qstn_opt[$i]; ?></div>
                    <?php } ?>
                    </div>
                </div>
            </div>
         </div>
         <div style="clear: both;"></div>
         
<?php
}
?>