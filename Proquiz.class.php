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
class Proquiz {
    
    var $modules;
    var $instid;
    var $qstn_str = "|";
    var $qstn_type_str = "|";
    var $total_time = 0;
    var $total_qstn = 0;
    static $total_cont = 0;
    var $category = "|";
    function __construct(){
        global $modules;
        $this->modules = $modules;
        
        if(!isset($_SESSION)){
            session_start();
        }
        $_SESSION['SCRIPTQUIZ']['modules']['path'] = './modules/';
        $_SESSION['SCRIPTQUIZ']['modules'] = $modules; 
    }
    
    // Get total questions in selected categorys and subs
    function getTotalQstn($db,$cat){
        $query = "SELECT count(*) as `num` FROM `".QUIZTABLE."`";
        if(!empty($cat) && $cat[0]!='All'){
            $query .= " WHERE ";
            foreach($cat as $key=>$cat_arr){
                $cat_val = explode("_",$cat_arr);
                $query_arr[$key] = " (`category` = '".$db->escape($cat_val[0])."'";
                if($cat_val[1]!= 'All'){
                    $query_arr[$key] .= "AND `sub_cat` = '".$db->escape($cat_val[1])."') ";
                }else{
                    $query_arr[$key] .= ")";
                } 
            
            }
         $query .= implode(" OR ",$query_arr);   
                
        }
        $rec_count = $db->fetch_all_array($query);
        return $rec_count[0]['num'];
    }
    
    // Get Questions for Quiz
    function getQuestion($db,$cat,$qstn,$qtime){
        $query = "SELECT * FROM `".QUIZTABLE."`";
        if(!empty($cat) && $cat[0]!='All'){
            $query .= " WHERE ";
            foreach($cat as $key=>$cat_arr){
                $cat_val = explode("_",$cat_arr);
                $query_arr[$key] = " (`category` = '".$db->escape($cat_val[0])."'";
                if($cat_val[1]!= 'All'){
                    $query_arr[$key] .= "AND `sub_cat` = '".$db->escape($cat_val[1])."') ";
                }else{
                    $query_arr[$key] .= ")";
                } 
            
            }
         $query .= implode(" OR ",$query_arr);   
                
        }
        $query .= " ORDER BY `count`";
        $rec_arr = $db->fetch_all_array($query);
        $sub_arr = array();
        $quiz_qstn = array();
        for($i=0;$i<$qstn;$i++){
            while(1){
                $rid = rand(0,count($rec_arr)-1);
                if(!in_array($rid,$sub_arr)){
                    $sub_arr[$i] = $rid;
                    $quiz_qstn[$i]['qid'] = $rec_arr[$i]['qid'];
                    $quiz_qstn[$i]['category'] = $rec_arr[$i]['category'];
                    $quiz_qstn[$i]['questions'] = $rec_arr[$i]['question'];
                    $quiz_qstn[$i]['answers'] = $rec_arr[$i]['answer'];
                    $quiz_qstn[$i]['types'] = $rec_arr[$i]['type'];
                    $quiz_qstn[$i]['options'] = $rec_arr[$i]['options'];
                    $this->qstn_str .= $rec_arr[$i]['qid']."|";
                    $this->qstn_type_str .= $rec_arr[$i]['type']."|";
                    $this->category .= $rec_arr[$i]['category']."|";
                    $this->incrQIDcount($db,$rec_arr[$i]['qid']);
                    break;
                }    
            }
        }
        $this->qstn_str = trim($this->qstn_str,"|");
        $this->qstn_type_str = trim($this->qstn_type_str,"|");
        $this->category = trim($this->category,"|");
        $this->total_time = $qtime;
        $this->total_qstn = $qstn;
        
        return $quiz_qstn;
    }
    
    
    // Function for new Quiz Instance
    function newInstance($db,$ua_details){
        $data['instid'] =$this->instid;
        $data['user'] = $ua_details['randid'];
        $data['quiz_inst_ts'] = time();
        $data['questions_arr'] = $this->qstn_str;
        $data['type_arr'] = $this->qstn_type_str;
        $data['cat_arr'] = $this->category;
        $data['total_qstn'] = $this->total_qstn;
        $data['total_time'] = $this->total_time;
        $data['created_by'] = "system";
        $id = $db->query_insert(QUIZDB,$data);
        if(!empty($id)){
            return $data;
        }else{
            return false;
        }
    }
    
    // Function for generating Unique ID
    function getUniqueID($db){
        while(1){
            $nob = rand(1000000000,9999999999);
            $sql = "SELECT * FROM `".QUIZDB."` WHERE `instid` = '".$nob."'";
            $record = $db->query_first($sql);
            if(empty($record)){
               break; 
            }   
        }
        $this->instid = $nob;
        return $nob;
    }
    
    
    // Function to increment the question usage counter
    function incrQIDcount($db,$qid){
        $data['count'] = "INCREMENT(1)";
        $db->query_update(QUIZTABLE,$data,"`qid`=$qid");
    }
    
    
    /// Quiz Started TS
    function start_quiz_ts($db,$id){
        $data['quiz_start_ts'] = time();
        $db->query_update(QUIZDB,$data,"instid='".$id."'");
        return $data['quiz_start_ts'];
    }

    // Process Quiz Results
    function processQuiz($db,$quiz,$post){
        $total_correct = 0;
        $total_wrong = 0;
        $total_blank = 0;
        $pq_arr['quiz_end_ts'] = $quiz['PARAMS']['quiz_end_ts'];
        foreach($quiz['DATA'] as $data){
            if(empty($post[$data['qid']])){
                $pq_arr['answers_arr'] .= "0|";
            }else{
                $pq_arr['answers_arr'] .= $post[$data['qid']]."|";    
            }
            $pq_arr['canswers_arr'] .= $data['answers']."|";
            if(empty($quiz['ANSWERS'][$data['qid']]['ts'])){
                $pq_arr['timing_arr'] .= "0|";
            }else{
                $pq_arr['timing_arr'] .= $quiz['ANSWERS'][$data['qid']]['ts']."|";    
            }
            
            if($data['answers'] == $post[$data['qid']]){
                $total_correct++;
            }else{
                if(empty($post[$data['qid']])){
                    $total_blank++;
                }else{
                    $total_wrong++;
                }
            }
            
            
        }
        
        $diff = $quiz['PARAMS']['quiz_end_ts'] - $quiz['PARAMS']['quiz_start_ts'];
        if($diff > $quiz['PARAMS']['total_time']*60){
            $pq_arr['time_used'] = $quiz['PARAMS']['total_time']*60;
        }else{
            $pq_arr['time_used'] = $diff;
        } 
        $pq_arr['total_correct'] = $total_correct;
        $pq_arr['total_wrong'] = $total_wrong;
        $pq_arr['answers_arr'] = trim($pq_arr['answers_arr'],"|");
        $pq_arr['canswers_arr'] = trim ($pq_arr['canswers_arr'],"|");
        $pq_arr['timing_arr'] = trim($pq_arr['timing_arr'],"|");
        $pq_arr['percentage'] = round(($total_correct/$quiz['PARAMS']['total_qstn'])*100,2);
        $db->query_update(QUIZDB,$pq_arr,"instid='".$quiz['INSTID']."'");
        $pq_arr['rank'] = $this->getRank($db,$pq_arr['percentage'],$pq_arr['time_used']/$quiz['PARAMS']['total_qstn']);
        $pq_arr['percentile'] = $this->getPercentile($pq_arr['rank']); 
        $pq_arr['total_blank'] = $total_blank;
        $pq_arr['total_time'] = $quiz['PARAMS']['total_time'];
        $pq_arr['time_unused'] = $quiz['PARAMS']['total_time']*60 - $pq_arr['time_used'];
        $pq_arr['total_question'] = $quiz['PARAMS']['total_qstn'];
        $pq_arr['instid'] = $quiz['PARAMS']['instid'];
        return $pq_arr;
    }
    
    // get rank
    function getRank($db,$p,$avg_time){ //(database,persentage,average time / question)
        $sql = "SELECT `percentage` FROM ".QUIZDB." WHERE `created_by` = 'system' ORDER BY `percentage` DESC";
        $per = $db->query($sql);
        $rank = 0;
        $offset = 0;
        Proquiz::$total_cont = mysql_num_rows($per);
        while($per_s = $db->fetch_array($per)){
            if($p == $per_s['percentage']){
                $offset = Proquiz::getRankOffset($db,$p,$avg_time);
                break;
            }
            $rank++;
        }       
        return $rank+$offset+1;
        
    }
    
    // get Rank Offset
    function getRankOffset($db,$p,$avg_time){
        $offset = 0;
        $sql = "SELECT * FROM ".QUIZDB." WHERE `created_by` = 'system' AND `percentage` = '".$p."'";
        $p_arr = $db->fetch_all_array($sql);
        foreach($p_arr as $elements){
            if($avg_time > ($elements['time_used']/$elements['total_qstn'])){
                $offset++;
            }
        }
        return $offset;
    }
    
    // get percentile
    function getPercentile($rank){
        
        $percentile = ((Proquiz::$total_cont - $rank)/Proquiz::$total_cont)*100;
        return round($percentile,2);
    }
    
    // Get Summary
    function getSummary($db,$qid){
        $sql = "SELECT * FROM ".QUIZDB." WHERE `instid` = '".$qid."' ";
        return $db->query_first($sql);
    }
    
    
    
    /// Add Question Function
    function pqAddQuestion($db,$post_vars,$ua_details,$type){
        $j = (int)$post_vars['opt_count'];
        $data['qid'] = $this->getQID($db);
        $data['question'] = $post_vars['pq_qstn'];
        for($i=1;$i<=$j;$i++){
            $data['options'] .= $this->checkSpceChar($post_vars['option_'.$i])."|";
        }
        $data['options'] = trim($data['options'],"|");
        $data['answer'] = $this->checkSpceChar($post_vars['option_'.$post_vars['opt_ans']]);
        $data['type'] = $type;
        $data['category'] = $post_vars['quiz_category'];
        $data['sub_cat'] = $post_vars['quiz_sub_category'];
        $data['added_by'] = $ua_details['randid'];
        $data['open_quiz'] = $post_vars['open_quiz'];
        $data['count'] = 0;
        if($ua_details['level']=='admin'){
            $data['active'] = 1;
        }else{
            $data['active'] = 0;
        }
        if($db->query_insert(QUIZTABLE,$data)){
            return true;
        }else{
            return false;
        }
    }
    
    /// Add Question Function
    function pqEditQuestion($db,$post_vars,$ua_details,$type,$qid){
        $j = (int)$post_vars['opt_count'];
        $data['question'] = html_entity_decode($post_vars['pq_qstn']);
        for($i=1;$i<=$j;$i++){
            $data['options'] .= html_entity_decode($this->checkSpceChar($post_vars['option_'.$i]))."|";
        }
        $data['options'] = trim($data['options'],"|");
        $data['answer'] = $this->checkSpceChar(html_entity_decode($post_vars['option_'.$post_vars['opt_ans']]));
        $data['type'] = $type;
        $data['category'] = $post_vars['quiz_category'];
        $data['sub_cat'] = $post_vars['quiz_sub_category'];
        $data['open_quiz'] = $post_vars['open_quiz'];
        if($ua_details['level']=='admin'){
            $data['active'] = 1;
        }else{
            $data['active'] = 0;
        }
        if($db->query_update(QUIZTABLE,$data," `qid` = '".$qid."' AND `added_by` = '".$ua_details['randid']."'")){
            return true;
        }else{
            return false;
        }
    }
    
    // Function for generating Unique Quiz ID
    function getQID($db){
        while(1){
            $nob = rand(1000000000,9999999999);
            $sql = "SELECT * FROM `".QUIZTABLE."` WHERE `qid` = '".$nob."'";
            $record = $db->query_first($sql);
            if(empty($record)){
               break; 
            }   
        }
        return $nob;
    }
    
    
    function checkSpceChar($var_data){
        return str_replace("|","_",$var_data);
    }
    
}
?>