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
// Begin Session if not present
if(!isset($_SESSION)){
    session_start();
}

if(!file_exists('config.inc.php')){
    header('Location:install/index.php');
}

include_once('userAuth.class.php');
include_once('Database.class.php');
include_once('config.inc.php');
include_once('Proquiz.class.php');
include_once('mail/class.phpmailer.php');



// include modules
foreach($modules as $mod){
    include_once($mod);    
}

// include results modules
foreach($modulesR as $mod){
    include_once($mod);    
}

// create the $db object

    $db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
    //connect to the server
    $db->connect(); 
    
    //Create Quiz Object
    $pq = new Proquiz();
    
    // Mail Class
    $mail = new PHPMailer();
    
    // create login object
    $auth = new userAuth(TABLE_USERS,true);

if(isset($_POST['action']) || isset($_GET['action'])){
    
    //  Login Init With Captcha
    if($_POST['action']=='login'){
        if($_SESSION['LCNT']>=5){
            if($auth->checkCaptcha($_POST['captcha_code'])){
                loginBase($auth,$db);
            }else{
                $_SESSION['ERROR']['type'] = 'Error';
                $_SESSION['ERROR']['reason'] = "Entered Captcha is Incorrect , Please Try Again.";
            }
        }else {
            loginBase($auth,$db);
        }      
    }           // End Login 

    
    //  Start Register Script
    if($_POST['action']=='register'){
    
        if($auth->register($db,$_POST)){
            
            header('Location:login.php?error=accdone');
        }
    }           // End Register
    
    
    
    // Recover Password
    if($_GET['action']=='recoverpass' && !empty($_POST['email'])){
        $data = $auth->recoverPass($db,$_POST['email']);
        switch($data['status']){
            case "done":
                $data['USEREMAIL'] = $_POST['email'];
                $data['NEWPASS'] = $data['newpass'];
                $data['MDEMAIL'] = getSettings($db,'gmailuser');
                $data['SITETITLE'] = SITENAME;
                $data['SITELINK'] = SITE_LINK;
                $data['MAILTEMPLATE'] = "fpass.html";
                PQmail($db,$mail,$data,'fpass');
                header('Location:login.php?error=fpassdone');
            break;
            case "noemail":
                header('Location:login.php?error=noemail');
            break;
            default:
                header('Location:login.php?error=fpasserror');
            break;
            
        }
    }
    
    
       
    
    // Get Questions
    if($_POST['action']=='pqsetup'){
        if(empty($_SESSION['PQ_QUIZ']['INSTID'])){
            $_SESSION['PQ_QUIZ']['INSTID'] = $pq->getUniqueID($db);
            $avail_total_qstn = (integer)$pq->getTotalQstn($db,$_POST['category']);
            if($_POST['t_question']>$avail_total_qstn){
                $qstn = $avail_total_qstn;
            }else{
                $qstn = $_POST['t_question'];
            }
            $_SESSION['PQ_QUIZ']['DATA'] = $pq->getQuestion($db,$_POST['category'],$qstn,$_POST['t_time']);
            $_SESSION['PQ_QUIZ']['PARAMS'] = $pq->newInstance($db,$_SESSION['UA_DETAILS']);
        }
        
    }
    

       // Echo Data For Ajax
    if($_POST['action']=='getquizdata'){
        if(!empty($_SESSION['PQ_QUIZ']['PARAMS']['quiz_start_ts'])){
            $_SESSION['PQ_QUIZ']['PARAMS']['total_time'] = round((time() - $_SESSION['PQ_QUIZ']['PARAMS']['quiz_start_ts'])/60);
        }
        echo json_encode($_SESSION['PQ_QUIZ']['PARAMS']);
        $_SESSION['PQ_QUIZ']['PARAMS']['quiz_start_ts'] = $pq->start_quiz_ts($db,$_SESSION['PQ_QUIZ']['INSTID']);
    }
    
       // Process Quiz Data
    if($_GET['action']=='process_quiz'){
        if(!empty($_SESSION['PQ_QUIZ'])){
            $_SESSION['PQ_QUIZ']['PARAMS']['quiz_end_ts'] = time();
            //print_r($_POST);
            $_SESSION['RESULTS'] = $pq->processQuiz($db,$_SESSION['PQ_QUIZ'],$_POST);
            $data['UA_DETAILS'] = $_SESSION['UA_DETAILS'];
            $data['QUIZ'] = $_SESSION['RESULTS']; 
            $data['MDEMAIL'] = getSettings($db,'gmailuser');
            $data['SITETITLE'] = SITENAME;
            $data['SITELINK'] = SITE_LINK;
            $data['MAILTEMPLATE'] = "summary.html";
            PQmail($db,$mail,$data,'summary');
        }else{
            unset($_SESSION['RESULTS']);
        }
        
        unset($_SESSION['PQ_QUIZ']);
    }
    
    // Intermediate Answer Records
    if($_POST['action']=='interm_ans'){
        $_SESSION['PQ_QUIZ']['ANSWERS'][$_POST['qid']]['ans'] = $_POST['answer'];
        $_SESSION['PQ_QUIZ']['ANSWERS'][$_POST['qid']]['ts'] = time() - $_SESSION['PQ_QUIZ']['PARAMS']['quiz_start_ts'];
        echo $_SESSION['PQ_QUIZ']['ANSWERS'][$_POST['qid']]['ts'];
    }

    
    // Show Results
    if($_GET['action']=='answers' && !empty($_GET['instid'])){
        $_SESSION['STATS']['DETAILS'] = getResultsArr($db,$_GET['instid']);
        $_SESSION['STATS']['USER_DETAILS'] = getUserData($db,$_SESSION['STATS']['DETAILS']['user']);
        $_SESSION['STATS']['QSTN_ARR'] = explode("|",$_SESSION['STATS']['DETAILS']['questions_arr']);
        $_SESSION['STATS']['YOUR_ANS'] = explode("|",$_SESSION['STATS']['DETAILS']['answers_arr']);
        foreach($_SESSION['STATS']['QSTN_ARR'] as $key=>$qid){
                $_SESSION['STATS']['QID_DATA'][$key] = getQidData($db,$qid);
        }
    }
    
    // Get Slideshow Contents
    if($_GET['action']=='slideshow' && !empty($_GET['instid'])){
        $_SESSION['STATS']['DETAILS'] = getResultsArr($db,$_GET['instid']);
        $_SESSION['STATS']['USER_DETAILS'] = getUserData($db,$_SESSION['STATS']['DETAILS']['user']);
        $_SESSION['STATS']['QSTN_ARR'] = explode("|",$_SESSION['STATS']['DETAILS']['questions_arr']);
        $_SESSION['STATS']['YOUR_ANS'] = explode("|",$_SESSION['STATS']['DETAILS']['answers_arr']);
        foreach($_SESSION['STATS']['QSTN_ARR'] as $key=>$qid){
                $_SESSION['STATS']['QID_DATA'][$key] = getQidData($db,$qid);
        }
    }
    
    // Get Slideshow Correct Answers
    if($_POST['action']=='ssget' && !empty($_POST['instid'])){
        $details = getResultsArr($db,$_POST['instid']);
        $ans_arr['correct'] = explode("|",$details['canswers_arr']);
        $ans_arr['your'] = explode("|",$details['answers_arr']);
        echo json_encode($ans_arr);
    }
    
    
    //  Edit Profile
    if($_GET['action']=='edit_profile' && !empty($_POST)){
        switch($_GET['type']){
            case 'username':
                if(!checkUsernameExists($db,$_POST['username']) && ($_POST['username'] != $_SESSION['UA_DETAILS']['username'])){
                    if($auth->updateUsername($db,$_SESSION['UA_DETAILS']['randid'],$_POST['username'])){
                        unset($_SESSION['UA_DETAILS']);
                        header('Location:login.php?error=complete');
                    }else{
                        header('Location:'.$_SERVER['HTTP_REFERER']);
                    }
                }else{
                        header('Location:'.$_SERVER['HTTP_REFERER']);
                }
            break;
            case 'email':
                if(!checkEmailExists($db,$_POST['email']) && ($_POST['email'] != $_SESSION['UA_DETAILS']['email'])){
                    if($auth->updateEmail($db,$_SESSION['UA_DETAILS']['randid'],$_POST['email'])){
                        unset($_SESSION['UA_DETAILS']);
                        header('Location:login.php?error=complete');
                    }else{
                        header('Location:'.$_SERVER['HTTP_REFERER']);
                    }
                }else{
                        header('Location:'.$_SERVER['HTTP_REFERER']);
                }
            break;
            case 'password':
                if(!empty($_POST['password']) && $auth->confirmPasswd($_POST['password'],$_POST['cpassword'])){
                    if($auth->updatePassword($db,$_SESSION['UA_DETAILS']['randid'],$_POST['password'])){
                        unset($_SESSION['UA_DETAILS']);
                        header('Location:login.php?error=complete');
                    }else{
                        header('Location:'.$_SERVER['HTTP_REFERER']);
                    }
                }else{
                        header('Location:'.$_SERVER['HTTP_REFERER']);
                }
            break;
            case 'other':
                if(checkChange($_SESSION['UA_DETAILS'],$_POST) || !empty($_FILES)){
                    
                    if($auth->updateOtherDetails($db,$_SESSION['UA_DETAILS'],$_POST,$_FILES)){
                        unset($_SESSION['UA_DETAILS']);
                        header('Location:login.php?error=complete');
                    }else{
                        header('Location:'.$_SERVER['HTTP_REFERER']);
                    }
                }else{
                        header('Location:'.$_SERVER['HTTP_REFERER']);
                }
            break;
        }
    }
    
    
    
    
    
    /****************************************************************************
    **************** Sub Category Function add / edit  *****************************/
    
    if($_POST['action']=='nesubcat' && !empty($_POST['subcatdata']) && !empty($_POST['curcat'])){
        if($_POST['type']=='addsub'){
            $sql = "SELECT DISTINCT `subcat` FROM `".QUIZCAT."` WHERE `cat`='".$_POST['curcat']."'";
            if($_SESSION['UA_DETAILS']['level']!='admin'){
                $sql .= " AND `added_by` = ".$_SESSION['UA_DETAILS']['randid'];
            }    
            $sub_cat_data = $db->fetch_all_array($sql);
            if(!in_array(array('subcat'=>$_POST['subcatdata']),$sub_cat_data)){
                $insert_data['cat']= $_POST['curcat'];
                $insert_data['subcat']= $_POST['subcatdata'];
                $insert_data['added_by']= $_SESSION['UA_DETAILS']['randid'];
                if($_SESSION['UA_DETAILS']['level']=='admin'){
                    $insert_data['active']= 1;
                }else{
                    $insert_data['active']= 0;
                }
                if($db->query_insert(QUIZCAT,$insert_data)){
                    $echo_stat['error'] = "Done";
                    $echo_stat['status'] = $_POST['subcatdata']." have been entered";
                    if($_SESSION['UA_DETAILS']['level']!='admin'){
                        $echo_stat['status'] .= ".Please Wait for the Approval by the Admin.";   
                    }
                    echo json_encode($echo_stat);
                }else{
                    $echo_stat['error'] = "Error";
                    $echo_stat['status'] = "There have been some problem. please try again later";
                    echo json_encode($echo_stat);
                }
            }else{
                $echo_stat['error'] = "Error";
                $echo_stat['status'] = $_POST['subcatdata']." already exists";
                echo json_encode($echo_stat);
            }
        }
        if($_POST['type']=='editsub'){
            $sql = "SELECT DISTINCT `subcat` FROM `".QUIZCAT."` WHERE `cat`='".$_POST['curcat']."'";
            if($_SESSION['UA_DETAILS']['level']!='admin'){
                $sql .= " AND `added_by` = ".$_SESSION['UA_DETAILS']['randid'];
            }    
            $sub_cat_data = $db->fetch_all_array($sql);
            if(!in_array(array('subcat'=>$_POST['subcatdata']),$sub_cat_data)){
                $insert_data['subcat']= $_POST['subcatdata'];
                if($db->query_update(QUIZCAT,$insert_data,"`added_by` = '".$_SESSION['UA_DETAILS']['randid']."' AND `cat` = '".$_POST['curcat']."' AND `subcat` = '".$_POST['cursubcat']."'")){
                    $echo_stat['error'] = "Done";
                    $echo_stat['status'] = $_POST['cursubcat']." have been updated to ".$_POST['subcatdata'];
                    if($_SESSION['UA_DETAILS']['level']!='admin'){
                        $echo_stat['status'] .= ".Please Wait for the Approval by the Admin.";   
                    }
                    echo json_encode($echo_stat);
                }else{
                    $echo_stat['error'] = "Error";
                    $echo_stat['status'] = "There have been some problem. please try again later";
                    echo json_encode($echo_stat);
                }
            }else{
                $echo_stat['error'] = "Error";
                $echo_stat['status'] = $_POST['subcatdata']." already exists";
                echo json_encode($echo_stat);
            }
        }
        
        if($_POST['type']=='delsub'){
            $sql = "DELETE FROM `".QUIZCAT."` WHERE `cat` = '".$_POST['curcat']."' AND `subcat` = '".$_POST['subcatdata']."'";
            if($_SESSION['UA_DETAILS']['level']!='admin'){
                $sql .= " AND `added_by` = ".$_SESSION['UA_DETAILS']['randid'];
            }    

                if($db->query($sql)){
                    $echo_stat['error'] = "Done";
                    $echo_stat['status'] = $_POST['subcatdata']." have been deleted";
                    echo json_encode($echo_stat);
                }else{
                    $echo_stat['error'] = "Error";
                    $echo_stat['status'] = "There have been some problem. please try again later";
                    echo json_encode($echo_stat);
                }
        }
        
    }
    
    /****************************************************************************
    **************** Category Function add / edit  *****************************/
    
    if($_POST['action']=='necat' && !empty($_POST['catdata'])){
        if($_POST['type']=='add'){
            $sql = "SELECT DISTINCT `cat` FROM `".QUIZCAT."` WHERE `subcat`='01111110'";
            if($_SESSION['UA_DETAILS']['level']!='admin'){
                $sql .= " AND `added_by` = ".$_SESSION['UA_DETAILS']['randid'];
            }    
            $cat_data = $db->fetch_all_array($sql);
            if(!in_array(array('cat'=>$_POST['catdata']),$cat_data)){
                $insert_data['cat']= $_POST['catdata'];
                $insert_data['subcat']= "01111110";
                $insert_data['added_by']= $_SESSION['UA_DETAILS']['randid'];
                if($_SESSION['UA_DETAILS']['level']=='admin'){
                    $insert_data['active']= 1;
                }else{
                    $insert_data['active']= 0;
                }
                if($db->query_insert(QUIZCAT,$insert_data)){
                    $echo_stat['error'] = "Done";
                    $echo_stat['status'] = $_POST['catdata']." have been entered";
                    if($_SESSION['UA_DETAILS']['level']!='admin'){
                        $echo_stat['status'] .= ".Please Wait for the Approval by the Admin.";   
                    }
                    echo json_encode($echo_stat);
                }else{
                    $echo_stat['error'] = "Error";
                    $echo_stat['status'] = "There have been some problem. please try again later";
                    echo json_encode($echo_stat);
                }
            }else{
                $echo_stat['error'] = "Error";
                $echo_stat['status'] = $_POST['catdata']." already exists";
                echo json_encode($echo_stat);
            }
        }
        if($_POST['type']=='edit'){
            $sql = "SELECT DISTINCT `cat` FROM `".QUIZCAT."` WHERE `subcat`='01111110'";
            if($_SESSION['UA_DETAILS']['level']!='admin'){
                $sql .= " AND `added_by` = ".$_SESSION['UA_DETAILS']['randid'];
            }    
            $cat_data = $db->fetch_all_array($sql);
            if(!in_array(array('cat'=>$_POST['catdata']),$cat_data)){
                $insert_data['cat']= $_POST['catdata'];
                if($db->query_update(QUIZCAT,$insert_data,"`added_by` = '".$_SESSION['UA_DETAILS']['randid']."' AND `cat` = '".$_POST['curcat']."'")){
                    $echo_stat['error'] = "Done";
                    $echo_stat['status'] = $_POST['curcat']." have been updated to ".$_POST['catdata'];
                    if($_SESSION['UA_DETAILS']['level']!='admin'){
                        $echo_stat['status'] .= ".Please Wait for the Approval by the Admin.";   
                    }
                    echo json_encode($echo_stat);
                }else{
                    $echo_stat['error'] = "Error";
                    $echo_stat['status'] = "There have been some problem. please try again later";
                    echo json_encode($echo_stat);
                }
            }else{
                $echo_stat['error'] = "Error";
                $echo_stat['status'] = $_POST['catdata']." already exists";
                echo json_encode($echo_stat);
            }
        }
        
        if($_POST['type']=='del'){
            $sql = "DELETE FROM `".QUIZCAT."` WHERE `cat` = '".$_POST['curcat']."'";
            if($_SESSION['UA_DETAILS']['level']!='admin'){
                $sql .= " AND `added_by` = ".$_SESSION['UA_DETAILS']['randid'];
            }    

                if($db->query($sql)){
                    $echo_stat['error'] = "Done";
                    $echo_stat['status'] = $_POST['catdata']." have been deleted";
                    echo json_encode($echo_stat);
                }else{
                    $echo_stat['error'] = "Error";
                    $echo_stat['status'] = "There have been some problem. please try again later";
                    echo json_encode($echo_stat);
                }
        }
        
    }
    
    if($_POST['action']=='updatecat'){
        echo getCatList($db,$_SESSION['UA_DETAILS']['randid'],$_SESSION['UA_DETAILS']['level']);
    }
    
    if($_POST['action']=='updatesubcat'){
        echo getSubCatList($db,$_POST['category'],$_SESSION['UA_DETAILS']['randid'],$_SESSION['UA_DETAILS']['level']);
    }
    
    if($_GET['action']=='uuonline' && !empty($_POST['key'])){
        updateUserOnline($db,$_POST['key']);
    }
    
    
    
    if($_GET['subaction']=='addqstn'){
        if(empty($_POST['quiz_category']) || empty($_POST['quiz_sub_category']) || empty($_POST['pq_qstn']) || empty($_POST['opt_count']) || empty($_POST['opt_ans']) || checkOpt($_POST['opt_count'])){
            if(empty($_GET['submitType'])){
                $_SESSION['ERROR']['type'] = 'Error';
                $_SESSION['ERROR']['reason'] = "Please check One of the Fields is left empty";
            }else{
                $errorAjax['type'] = 'Error';
                $errorAjax['reason'] = "Please check One of the Fields is left empty";
                echo json_encode($errorAjax);
            }
            
        }else{
            if($pq->pqAddQuestion($db,$_POST,$_SESSION['UA_DETAILS'],$_GET['type'])){
                if(empty($_GET['submitType'])){
                    $_SESSION['ERROR']['type'] = 'Done';
                    $_SESSION['ERROR']['reason'] = "A New Question Added to the Database";
                }else{
                    $errorAjax['type'] = 'Done';
                    $errorAjax['reason'] = "A New Question Added to the Database";
                    echo json_encode($errorAjax);
                }    
            }else{
                if(empty($_GET['submitType'])){
                    $_SESSION['ERROR']['type'] = 'Error';
                    $_SESSION['ERROR']['reason'] = "Some Error Occured . Please Try Again.";
                }else{
                    $errorAjax['type'] = 'Error';
                    $errorAjax['reason'] = "Some Error Occured . Please Try Again.";
                    echo json_encode($errorAjax);
                }
            }
            
        }
    }
    
    
    // Edit Question
    if($_GET['subaction']=='editqstn' && !empty($_GET['qid'])){
        if(empty($_POST['quiz_category']) || empty($_POST['quiz_sub_category']) || empty($_POST['pq_qstn']) || empty($_POST['opt_count']) || empty($_POST['opt_ans']) || checkOpt($_POST['opt_count'])){
            
                $_SESSION['ERROR']['type'] = 'Error';
                $_SESSION['ERROR']['reason'] = "Please check One of the Fields is left empty";
            
        }else{
            if($pq->pqEditQuestion($db,$_POST,$_SESSION['UA_DETAILS'],$_GET['type'],$_GET['qid'])){
                
                    $_SESSION['ERROR']['type'] = 'Done';
                    $_SESSION['ERROR']['reason'] = "Question #".$_GET['qid']." Edited sucessfully";
   
            }else{

                    $_SESSION['ERROR']['type'] = 'Error';
                    $_SESSION['ERROR']['reason'] = "Some Error Occured . Please Try Again.";

            }
            
        }
    }
    
    // Delete Question
    if($_GET['subaction']=='delqstn' && !empty($_GET['qid'])){
        $sql = "DELETE FROM ".QUIZTABLE." WHERE `qid` = '".$_GET['qid']."'";
        if($_SESSION['level'] != 'admin'){
            $sql .= " AND `added_by` = '".$_SESSION['UA_DETAILS']['randid']."'";
        }
        
        if($db->query($sql)){
            $_SESSION['ERROR']['type'] = 'Done';
            $_SESSION['ERROR']['reason'] = "Question #".$_GET['qid']." Deleted from the System.";
        }else{
            $_SESSION['ERROR']['type'] = 'Error';
            $_SESSION['ERROR']['reason'] = "Unable to delete the specified Question.Please Try again.";
        }
    }

    // Contact Admin
    if($_GET['subaction'] == 'caadmin' && !empty($_POST['ca_subject']) && !empty($_POST['ca_message'])){
        if($auth->checkCaptcha($_POST['captcha_code'])){
            $data['UA_DETAILS'] = $_SESSION['UA_DETAILS'];
            $data['ADMINS'] = getEmails($db,'admin');
            $data['SUBJECT'] = $_POST['ca_subject'];
            $data['MESSAGE'] = $_POST['ca_message'];
            $data['MDEMAIL'] = 'md@trdc.in';
            $data['SITETITLE'] = SITENAME;
            $data['SITELINK'] = SITE_LINK;
            $data['MAILTEMPLATE'] = "contact_admin.html";
            if(getSettings($db,'brdmail')=='1'){
              PQmail($db,$mail,$data,'caadmin');  
            }else{
                $_SESSION['ERROR']['type'] = 'Error';
                $_SESSION['ERROR']['reason'] = "Admin Has Blocked All Emails From The System.";
            }
        }else{
            $_SESSION['ERROR']['type'] = 'Error';
            $_SESSION['ERROR']['reason'] = "Entered Captcha Is Incorrect . Please Try Again.";
        }
    }
    
    
    // Activate /*****************************************
    /*****************************************************
    /****************************************************/
    
    
    // Activate Category
    if($_GET['subaction'] == 'actcat' && !empty($_GET['id']) && $_SESSION['UA_DETAILS']['level']=='admin'){
        $sql = "UPDATE ".QUIZCAT." SET  `active` = (`active`+1)%2  WHERE `id` = '".$_GET['id']."'";
        if($db->query($sql)){
            $_SESSION['ERROR']['type'] = 'Done';
            $_SESSION['ERROR']['reason'] = "Operation Completed.";
        }else{
            $_SESSION['ERROR']['type'] = 'Error';
            $_SESSION['ERROR']['reason'] = "Cannot Perforn The Operation.Please Try Again";
        }
    }
    
    // Activate Sub Category
    if($_GET['subaction'] == 'actsubcat' && !empty($_GET['id']) && $_SESSION['UA_DETAILS']['level']=='admin'){
        $sql = "UPDATE ".QUIZCAT." SET  `active` = (`active`+1)%2  WHERE `id` = '".$_GET['id']."'";
        if($db->query($sql)){
            $_SESSION['ERROR']['type'] = 'Done';
            $_SESSION['ERROR']['reason'] = "Operation Completed.";
        }else{
            $_SESSION['ERROR']['type'] = 'Error';
            $_SESSION['ERROR']['reason'] = "Cannot Perforn The Operation.Please Try Again";
        }
    }
    
    // Activate Question
    if($_GET['subaction'] == 'actqstn' && !empty($_GET['qid']) && $_SESSION['UA_DETAILS']['level']=='admin'){
        $sql = "UPDATE ".QUIZTABLE." SET  `active` = (`active`+1)%2  WHERE `qid` = '".$_GET['qid']."'";
        if($db->query($sql)){
            $_SESSION['ERROR']['type'] = 'Done';
            $_SESSION['ERROR']['reason'] = "Operation Completed.";
        }else{
            $_SESSION['ERROR']['type'] = 'Error';
            $_SESSION['ERROR']['reason'] = "Cannot Perforn The Operation.Please Try Again";
        }
    } 
    
    // Activate User
    if($_GET['subaction'] == 'actuser' && !empty($_GET['randid']) && $_SESSION['UA_DETAILS']['level']=='admin'){
        $sql = "UPDATE ".UA_TABLE." SET  `active` = (`active`+1)%2  WHERE `randid` = '".$_GET['randid']."'";
        if($db->query($sql)){
            $_SESSION['ERROR']['type'] = 'Done';
            $_SESSION['ERROR']['reason'] = "Operation Completed.";
        }else{
            $_SESSION['ERROR']['type'] = 'Error';
            $_SESSION['ERROR']['reason'] = "Cannot Perforn The Operation.Please Try Again";
        }
    }    

    // Make Admin
    if($_GET['subaction'] == 'makeadmin' && !empty($_GET['randid']) && !empty($_GET['level']) && $_SESSION['UA_DETAILS']['level']=='admin'){
        if($_GET['level'] == 'user'){
            $level = 'admin';
        }else{
            $level = 'user';
        }
        $sql = "UPDATE ".UA_TABLE." SET  `level` = '".$level."'  WHERE `randid` = '".$_GET['randid']."'";
        if($db->query($sql)){
            $_SESSION['ERROR']['type'] = 'Done';
            $_SESSION['ERROR']['reason'] = "Operation Completed.";
        }else{
            $_SESSION['ERROR']['type'] = 'Error';
            $_SESSION['ERROR']['reason'] = "Cannot Perforn The Operation.Please Try Again";
        }
    }

}

if(!empty($_GET['username'])){
    if($_GET['username']==$_SESSION['UA_DETAILS']['username']){
        echo "true";
    }else{
        if(checkUsernameExists($db,$_GET['username'])){
            echo "false";
        }else{
            echo "true";
        }
    }
    
}

if(!empty($_GET['email'])){
    if($_GET['email']==$_SESSION['UA_DETAILS']['email']){
        echo "true";
    }else{
        if(checkEmailExists($db,$_GET['email'])){
            echo "false";
        }else{
            echo "true";
        }
    }
    
}

     

/////////////////////////////////////////////////////////////////////////////
///////////     Special Actions     ////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
    if($_GET['error']=="take_quiz"){
        $_SESSION['ERROR']['type'] = 'Notice';
        $_SESSION['ERROR']['reason'] = "You Should Login to Take the Quiz.";
    }

function loginBase($auth,$db){
        if($auth->login($db,$_POST['username'],$_POST['password'])){
            updateProRating($db,$_SESSION['UA_DETAILS']['randid']);
            if(!$_SESSION['UA_DETAILS']['active']){
                unset($_SESSION['UA_DETAILS']);
                header('Location:login.php?error=logindeact');
            }else{
                header('Location:quiz_menu.php?error=loginsucss');    
            }
            
        }else{
            header('Location:login.php');
            $_SESSION['ERROR']['type'] = 'Error';
            $_SESSION['ERROR']['reason'] = "Please check the Username &amp; Password";
            if(!isset($_SESSION['LCNT'])){
                $_SESSION['LCNT'] = 0;
            }else{
                $_SESSION['LCNT'] += 1;
            }
            if($_SESSION['LCNT']>=4){
                $_SESSION['ERROR']['reason'] .= "|Spam Detected . Please Enter Captcha to Login";
            }
        } 
}




// Check User Acess Level
function check_level($value) {
    if(!empty($_SESSION['UA_DETAILS'])){
        if(($value['level'] == $_SESSION['UA_DETAILS']['level']) || ($_SESSION['UA_DETAILS']['level']=='admin')){
            return true;
        } else {
            return false;
        }    
    }else{
        if($value['level']=='user'){
            return true;
        }else{
            return false;
        }
    }
    
}           // End check level

// Check Pages To be displayed depending on Authentication
function check_auth($value) {
    
    if(!empty($_SESSION['UA_DETAILS'])){
        if($value['auth']==2 || $value['auth']==0) {
            return true;
        }else{
            return false;
        }
    }else{
        if($value['auth']==1 || $value['auth']==0) {
            return true;
        }else{
            return false;
        }
    }
}       // End CheckAuth


// Get Quiz Modules 
function getQuizModule($value,$qstn){
    switch($value['types']){
        case 'mcq':
            getMCQ($value,$qstn);
            
        break;
    }
    
    return true;
}


// Get Quiz Results Modules 
function getQuizRModule($qid_data,$urans,$key){
    switch($qid_data['type']){
        case 'mcq':
            getMCQresult($qid_data,$urans,$key);
            
        break;
    }
    
    return true;
}


// Exit Script For CleanUP
function clean_up(){
    unset($_SESSION['ERROR']);
    if(!empty($_SESSION['UA_DETAILS'])){
        unset($_SESSION['LCNT']);
        //unset($_SESSION['PQ_QUIZ']);
        
        
    }
    unset($_SESSION['STATS']);
    unset($_SESSION['RESULTS']);
        //close connection
    //$db->close();
    echo '<script type="text/javascript">updateUserOnline();</script>';
}       // End Clean UP

function logout(){
    if(!empty($_SESSION['UA_DETAILS'])){
        unset($_SESSION['UA_DETAILS']);
        unset($_SESSION['UA_AUTH']);
        unset($_SESSION['PQ_QUIZ']);
    }
    $_SESSION['ERROR']['type'] = 'Done';
    $_SESSION['ERROR']['reason'] = "You have been Sucessfully Logged Out Of The System.";
}

function fixSize($str,$max){

    for($i=0;$i<$max-strlen($str);$i++){
        $str .= "&nbsp;";  
    }
    //$str = str_pad($str,$max-strlen($str));
    
    
    echo $str;
}

function getMaxLen($str_arr) {
    foreach($str_arr as $key=>$str){
        $len[$key] = strlen($str);
    }
    return max($len);
}

function valPercent($o,$t){
    return $o/$t*100;
}


// Get Results Details from Instance ID
function getResultsArr($db,$instid){
      $sql = "SELECT * FROM ".QUIZDB." WHERE `instid` = '".$instid."'";
      return $db->query_first($sql);
}

// Get Data for the Results
function getQidData($db,$qid){
      $sql = "SELECT * FROM ".QUIZTABLE." WHERE `qid` = '".$db->escape($qid)."'";
      return $db->query_first($sql);
}

// Get User Data
function getUserData($db,$uid){
    $sql = "SELECT photo,username,fname,lname FROM ".UA_TABLE." WHERE `randid` = '".$uid."'";
    return $db->query_first($sql);
}


// Get Class For Results depending on answers
function getResultsClass($str,$ans,$cans){
    if($str == $ans && $str == $cans){
        return "pq_opt_urrgt";
    }elseif($str == $ans){
        return "pq_opt_wrong";
    }elseif($str == $cans){
        return "pq_opt_correct";
    }else{
        return "pq_opt";
    }
}

// Pie Chart image Gen
function getPieUrl(){
    $tot = $_SESSION['RESULTS']['total_question'];
    $sub_str = valPercent($_SESSION['RESULTS']['total_correct'],$tot).",";
    $sub_str .= valPercent($_SESSION['RESULTS']['total_wrong'],$tot).",";
    $sub_str .= valPercent($_SESSION['RESULTS']['total_blank'],$tot);
    $str = "https://chart.googleapis.com/chart?cht=p3&chs=250x100&chd=t:".$sub_str."&chl=Correct|Wrong|Blank";
    return $str;
}

function getMeterUrl(){
    $per = $_SESSION['RESULTS']['percentage'];
    $str = "http://chart.apis.google.com/chart?chxl=0:|Bad|Good|Best&chxt=y&chs=250x100&cht=gm&chd=t:".$per."&chl=".$per."%";
    return $str;
}

// Pie Chart image Gen
function getLineUrl(){
    $timimg_arr = explode("|",$_SESSION['RESULTS']['timing_arr']);
    $timimg_offset[0] = 0;
    $timimg_offset_per[0] = 0;
    $param_time ="0,";
    $i=0;
    $max_t = max($timimg_offset);
    if($max_t<=0){
        $max_t =1;
    }
    foreach($timimg_arr as $value){
        $i++;
        $timimg_offset[$i] = ((int)$value) - $timimg_offset[$i-1];
        $timimg_offset_per[$i] = round($timimg_offset[$i]/$max_t*100,3);
        $param_time .= $timimg_offset_per[$i].",";
    }
    $str1 = "0,0,".$_SESSION['RESULTS']['total_question']."|1,0,".$max_t;
    $str2 = trim($param_time,",");
    $str = "http://chart.apis.google.com/chart?chxl=2:|Questions&chxp=2,90&chxr=".$str1."&chxt=x,y,x&chs=500x250&cht=lc&chd=t:".$str2."&chdl=Time&chg=25,50&chls=2,4,1&chm=o,FF9900,0,-2,5";
    return $str;
}

// Get time in Minutes
function getTinMin($t){
    $min = floor($t/60);
    $sec = $t%60;
    echo $min.":".$sec;
}


// Get Qid Summary
function getSummary($pq,$db,$qid){
    $_SESSION['RESULTS'] = $pq->getSummary($db,$qid);
    
}

// get all the results which are not locked
function getResults($db,$type){
    if($type=='all'){
        $sql = "SELECT * FROM ".QUIZDB." WHERE `locked_quiz` = 0 AND `quiz_end_ts` IS NOT NULL ORDER BY `percentage` DESC";
        return $db->fetch_all_array($sql);
    }elseif($type=='my_quiz'){
        $sql = "SELECT * FROM ".QUIZDB." WHERE  `created_by` = '".$_SESSION['UA_DETAILS']['randid']."' AND `quiz_end_ts` IS NOT NULL ORDER BY `percentage` DESC";
        return $db->fetch_all_array($sql);
    }elseif($type=='stats'){
        $stat_arr = getStats($db);
        $stat_arr_max = max($stat_arr);
        $stat_arr_mid = floor($stat_arr_max/2);
        foreach($stat_arr as $value){
            
            $str2 .= $value.",";
        }
        $str2 = trim($str2,",");
        
        $str = "http://chart.apis.google.com/chart?chxl=0:|0|1-9|10-19|20-29|30-39|40-49|50-59|60-69|70-79|80-89|90-99|100|1:|0|".$stat_arr_mid."|".($stat_arr_max)."|2:|Percentage+Ranges&chxp=2,80&chxt=x,y,x&chbh=31&chs=500x400&cht=bvg&chco=76A4FB&chds=0,".($stat_arr_max+10)."&chd=t:".$str2."&chg=100,10";
        return $str;
    }else{
        $sql = "SELECT * FROM ".QUIZDB." WHERE  `user` = '".$_SESSION['UA_DETAILS']['randid']."' AND `quiz_end_ts` IS NOT NULL ORDER BY `percentage` DESC";
        return $db->fetch_all_array($sql);
    }
}


//get results stats
function getStats($db) {
    $stats_arr = array('0'=>"",'1-9'=>"",'10-19'=>"",'20-29'=>"",'30-39'=>"",'40-49'=>"",'50-59'=>"",'60-69'=>"",'70-79'=>"",'80-89'=>"",'90-99'=>"",'100'=>"");
    foreach($stats_arr as $key=>$value){
        $arr = explode("-",$key);
        if(empty($arr[1])){
            $sql = "SELECT COUNT(*) as tcount FROM ".QUIZDB." WHERE `percentage` = '".$arr[0]."' AND `quiz_end_ts` IS NOT NULL";    
        }else{
            $sql = "SELECT COUNT(*) as tcount  FROM ".QUIZDB." WHERE `quiz_end_ts` IS NOT NULL AND (`percentage` > '".$arr[0]."' AND `percentage` < '".$arr[1]."')";
        }
        
        $dbval = $db->fetch_all_array($sql);
        $stats_arr[$key] = $dbval[0]['tcount'];
    }
    return $stats_arr;
}

// get Quiz Type
function getQuizType($created_by,$locked_quiz){
    if($created_by == 'system'){
        return "General Quiz";
    }elseif($locked_quiz = 1){
        return "Locked Quiz";
    }else{
        return "Open Quiz";
    }
}


// get the class of the percentage best,good,bad
function  getClass($percentage){
    if($percentage>75){
        return "perf_best";
    }elseif($percentage>50){
        return "perf_good";
    }else{
        return "perf_bad";
    }
}

function checkUsernameExists($db,$username){
    $sql = "SELECT * FROM ".UA_TABLE." WHERE `username` = '".$username."'";
    $uadetail = $db->query_first($sql);
    if(empty($uadetail)){
        return false;
    }else{
        return true;
    }
}

function checkEmailExists($db,$email){
    $sql = "SELECT * FROM ".UA_TABLE." WHERE `email` = '".$email."'";
    $uadetail = $db->query_first($sql);
    if(empty($uadetail)){
        return false;
    }else{
        return true;
    }
}

function checkChange($ua_details,$post_vars){
    $arr = array('fname','lname','profile','dob','gender');
    $cnt = 0;
    foreach($arr as $value){
        if($ua_details[$value]!=$post_vars[$value]){
            $cnt++;
        }
    }
    if($cnt>0){
        return true;
    }else{
        return false;
    }
}


function getCatList($db,$randid,$level){
    $sql = "SELECT DISTINCT `cat`,`active` FROM `".QUIZCAT."` WHERE `subcat`='01111110'";
        if($level!='admin'){
            $sql .= " AND `active` = '1'";
        }
    //$sql .= " AND `active` = '".$active."'";
    $data = $db->fetch_all_array($sql);
    $str = "";
    foreach($data as $value){
        if($value['active']=='1'){
            $class = "active";
        }else{
            $class = "inactive";
        }
        $str .= '<option value="'.$value['cat'].'" class="'.$class.'" >'.$value['cat'].'</option>';
    }
    return $str;
}

function getCatRaw($db,$randid,$level){
    $sql = "SELECT DISTINCT `cat`,`active`,id FROM `".QUIZCAT."` WHERE `subcat`='01111110'";
        if($level!='admin'){
            $sql .= " AND `active` = '1'";
        }
    //$sql .= " AND `active` = '".$active."'";
    $data = $db->fetch_all_array($sql);
    
    return $data;
}

function getCatWid($db,$id,$level){
    $sql = "SELECT DISTINCT `cat` FROM `".QUIZCAT."` WHERE `id`='".$id."'";
    $data = $db->fetch_all_array($sql);
    return $data[0]['cat'];
}

function getSubCatList($db,$cat,$randid,$level){
    $sql = "SELECT DISTINCT `subcat` FROM `".QUIZCAT."` WHERE `cat`='".$cat."'";
        if($level!='admin'){
            $sql .= " AND `active` = '1'";
        }
    $sql .= " AND `subcat` <> '01111110'";
    $data = $db->fetch_all_array($sql);
    $str = "";
    foreach($data as $value){
        if($value['active']=='1'){
            $class = "active";
        }else{
            $class = "inactive";
        }
        $str .= '<option value="'.$value['subcat'].'" class="'.$class.'" >'.$value['subcat'].'</option>';
    }
    return $str;
}

// Update User Online
function updateUserOnline($db,$key){
    
    if($key == 'de3f82ddc5a0e334830562fcef5e260e' || $key = '5dc65a8f7521c24567dd91f7b04437f9'){
        
        $sessid = session_id();
        if(!empty($_SESSION['UA_DETAILS']['username'])){
            $data['username'] = $_SESSION['UA_DETAILS']['username'];
            $sql = "SELECT * FROM ".ONLINE." WHERE `username` = '".$data['username']."' OR `php_sess_id` = '".$sessid."'";
            $user = $db->query_first($sql);
            if($user){
                $data['last_activity'] = time();
                $db->query_update(ONLINE,$data," `username` = '".$data['username']."' OR `php_sess_id` = '".$sessid."'"); 
            }else{
                $data['php_sess_id'] = $sessid;
                $data['last_activity'] = time();
                $db->query_insert(ONLINE,$data);
            }   
        }else{
            $data['username'] = "guest";
            $sql = "SELECT * FROM ".ONLINE." WHERE `php_sess_id` = '".$sessid."'";
            $user = $db->query_first($sql);
            if($user){
                $data['last_activity'] = time();
                $db->query_update(ONLINE,$data," `php_sess_id` = '".$sessid."'"); 
            }else{
                $data['php_sess_id'] = $sessid;
                $data['last_activity'] = time();
                $db->query_insert(ONLINE,$data);
            }
        }
        
        
        $status['online'] = getUsersOnline($db,'online');
        echo json_encode($status);    
    }else{
        $status['online']['username']="";
        echo json_encode($status);
        unset($_SESSION[NO_PARAM]);
        
    }
    
}

// Get Users Online
function getUsersOnline($db,$status='online'){
    switch($status){
        case "online":
            $sql = "SELECT `username`,`last_activity` FROM ".ONLINE;
            $data = $db->fetch_all_array($sql);
            $count=0;
            foreach($data as $key=>$value){
                if((time() - $value['last_activity'])<15){
                    $sData[$count]['username'] = $value['username'];
                    $count++;
                }
            }
        break;
    }
    return $sData;
}

function getSubCatRaw($db,$cat,$randid,$level){
    $sql = "SELECT DISTINCT `subcat` FROM `".QUIZCAT."` WHERE `cat`='".$cat."'";
        if($level!='admin'){
            $sql .= " AND `active` = '1'";
        }
    $sql .= " AND `subcat` <> '01111110'";
    $data = $db->fetch_all_array($sql);
    return $data;
}

function getSubCatAdm($db,$id,$level){
    $cat = getCatWid($db,$id,$level);
    $sql = "SELECT DISTINCT `subcat`,active,id,cat FROM `".QUIZCAT."` WHERE `cat`='".$cat."'";
        if($level!='admin'){
            $sql .= " AND `active` = '1'";
        }
    $sql .= " AND `subcat` <> '01111110'";
    $data = $db->fetch_all_array($sql);
    return $data;
}

function getCat_SubcatList($db){
    $str = '<option value="All" selected="selected">All the Categories &amp; Sub-categories</option>';
    $sql = "SELECT DISTINCT `cat` FROM `".QUIZCAT."` WHERE `subcat`='01111110' AND `active` = '1'";
    $cat_list = $db->fetch_all_array($sql);
    foreach($cat_list as $value){
        $sql = "SELECT DISTINCT `subcat` FROM `".QUIZCAT."` WHERE `cat`='".$value['cat']."' AND `subcat` <> '01111110' AND `active` = '1'";
        $str .= '<optgroup label="'.$value['cat'].'">';
        $subcat_list = $db->fetch_all_array($sql);
        $str .= '<option value="'.$value['cat'].'_All'.'">All in This Category</option>';
        foreach($subcat_list as $sub_value){
            $str .= '<option value="'.$value['cat'].'_'.$sub_value['subcat'].'">'.$sub_value['subcat'].'</option>';
        }
        $str .= '</optgroup>';
    }
    return $str;
}


function checkOpt($opt_count){
    for($i=1;$i<=$opt_count;$i++){
        if(empty($_POST['option_'.$i])){
            return true;
        }
    }
    return false;
}

function getQstnList($db,$ua_details){
    $sql = "SELECT * FROM `".QUIZTABLE."`";
    if($ua_details['level']!='admin'){
        $sql .= "WHERE `added_by` = '".$ua_details['randid']."'";
    }
    return $db->fetch_all_array($sql);
}

function getQstnDetails($db,$qid,$ua_details){
    $sql = "SELECT * FROM `".QUIZTABLE."` WHERE `qid` = '".$qid."'";
    if($ua_details['level']!='admin'){
        $sql .= " AND `added_by` = '".$ua_details['randid']."'";
    }
    return $db->query_first($sql);
}


// ProQuiz Mailing Function
function PQmail($db,$mail,$data,$type){
    if(getSettings($db,'smtpmail') == '1'){
        $mail->IsSMTP(); // telling the class to use SMTP
        $mail->SMTPAuth   = true;                  // enable SMTP authentication
        $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
        $mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
        $mail->Port       = 465;                   // set the SMTP port for the GMAIL server
        $mail->Username   = getSettings($db,'gmailuser');  // GMAIL username
        $mail->Password   = getSettings($db,'gmailpass');  // GMAIL password    
    }
    
    if($type == 'caadmin'){
        $mail->AddReplyTo($data['UA_DETAILS']['email'], $data['UA_DETAILS']['fname']." ".$data['UA_DETAILS']['lname']);
        foreach($data['ADMINS'] as $admins){
            $mail->AddAddress($admins['email'], $admins['name']);
        }
        $mail->SetFrom($data['MDEMAIL'], $data['SITETITLE']);
        $mail->Subject = $data['SUBJECT'];
        $mail->AltBody = $data['MESSAGE'];
        $data['UA_DETAILS']['img_dir'] = "http://".$_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME'])."/".IMG_DIR; 
        $body = file_get_contents('mail/templates/'.$data['MAILTEMPLATE']);
        $tags_other = array('SITETITLE'=>'SITETITLE','SUBJECT'=>'SUBJECT','MESSAGE'=>'MESSAGE','SITELINK'=>'SITELINK');
        $tags_profile = array('UAIMG'=>'photo','IMGFOLDER'=>'img_dir','UAEMAIL'=>'email','UADOB'=>'dob','UAUSERNAME'=>'username','UAPROFILE'=>'profile','UAFNAME'=>'fname','UALNAME'=>'lname');
        $body = replaceTags($body,$data['UA_DETAILS'],$tags_profile);
        $body = replaceTags($body,$data,$tags_other);
        $mail->MsgHTML($body);
    }elseif($type == 'summary'){
        $data['NAME'] = $data['UA_DETAILS']['fname']." ".$data['UA_DETAILS']['lname'];
        $data['UNAME'] = $data['UA_DETAILS']['username'];
        $mail->AddReplyTo($data['UA_DETAILS']['email'], $data['UA_DETAILS']['fname']." ".$data['UA_DETAILS']['lname']);
        $mail->AddAddress($data['UA_DETAILS']['email'], $data['UA_DETAILS']['fname']." ".$data['UA_DETAILS']['lname']);
        $mail->SetFrom($data['MDEMAIL'], $data['SITETITLE']);
        $mail->Subject = $data['SITETITLE']." | Your Quiz Result with Quiz ID : #".$data['QUIZ']['instid'];
        $mail->AltBody = "Only Viewable in A HTML Supported Email Client"; 
        $body = file_get_contents('mail/templates/'.$data['MAILTEMPLATE']);
        $tags_other = array('SITETITLE'=>'SITETITLE','NAME'=>'NAME','UNAME'=>'UNAME','SITELINK'=>'SITELINK');
        $tags_quiz = array('RANK'=>'rank','PERCENTAGE'=>'percentage','PERCENTILE'=>'percentile','TOTQSTN'=>'total_question','TOTCORR'=>'total_correct','TOTINCORR'=>'total_wrong','TOTUNANS'=>'total_blank','TOTTIME'=>'total_time','TOTUNTIME'=>'time_unused');
        $body = replaceTags($body,$data['QUIZ'],$tags_quiz);
        $body = replaceTags($body,$data,$tags_other);
        //echo $body;
        $mail->MsgHTML($body);
    }elseif($type == 'fpass'){
        $mail->AddReplyTo($data['USEREMAIL'], "Password Recover");
        $mail->AddAddress($data['USEREMAIL'], "Password Recover");
        $mail->SetFrom($data['MDEMAIL'], $data['SITETITLE']);
        $mail->Subject = $data['SITETITLE']." | Password Recovery of Your Account";
        $mail->AltBody = "Only Viewable in A HTML Supported Email Client"; 
        $body = file_get_contents('mail/templates/'.$data['MAILTEMPLATE']);
        $tags_other = array('SITETITLE'=>'SITETITLE','USERNAME'=>'USEREMAIL','PASSWORD'=>'NEWPASS','SITELINK'=>'SITELINK');
        $body = replaceTags($body,$data,$tags_other);
        //echo $body;
        $mail->MsgHTML($body);
    }

    
    // Try To Send Mail
    try {
      if($mail->Send()){
        $_SESSION['ERROR']['type'] = 'Done';
        $_SESSION['ERROR']['reason'] = "Mail Sucsessfully Sent.";
      }else{
        $_SESSION['ERROR']['type'] = 'Error';
        $_SESSION['ERROR']['reason'] = "There was some Problem with the System.Mail Not Sent|Please Try Again Later";
      }
    } catch (phpmailerException $e) {
      $_SESSION['ERROR']['type'] = 'Error';
      $_SESSION['ERROR']['reason'] = "There was some Problem with the System.Mail Not Sent|Please Try Again Later";
    } catch (Exception $e) {
      $_SESSION['ERROR']['type'] = 'Error';
      $_SESSION['ERROR']['reason'] = "There was some Problem with the System.Mail Not Sent|Please Try Again Later";
    }
}


// Get Admins Details
function getEmails($db,$type = 'all'){
    $sql = "SELECT CONCAT(`fname`,' ',`lname`) as `name`,`email` FROM ".UA_TABLE." ";
    if($str != 'all'){
        $sql .= " WHERE  `level` = '".$type."'";
    }
    return $db->fetch_all_array($sql);
}

// Tags Replace Function
function replaceTags($body,$data,$tags_profile){
    foreach($tags_profile as $tag=>$value){
        $body = str_replace("{".$tag."}",$data[$value],$body);    
    }
    return $body;
}


// Get Page Contents
function getContents($db,$name){
    $sql = "SELECT * FROM ".CONTENTS." WHERE `name` = '".$name."'";
    $data = $db->query_first($sql);
    return $data['value'];
}

// Get Content List
function getCntList($db,$str='all'){
    $sql = "SELECT * FROM ".CONTENTS;
    if($str != 'all'){
        $sql .= " WHERE `name` = '".$str."'";
    }
    $data = $db->fetch_all_array($sql);
    return $data;
}

/// Get Contents Ajax
    if($_POST['action'] == 'getCntDetails' && !empty($_POST['cnt'])){
        echo getContents($db,$_POST['cnt']);
    }

// Edit Contents
if($_GET['subaction'] == 'editcnt' && !empty($_POST['cnt_name']) && !empty($_POST['cnt_value']) && $_SESSION['UA_DETAILS']['level']=='admin'){
    $data['value'] = $_POST['cnt_value'];
    if($db->query_update(CONTENTS,$data," `name` = '".$_POST['cnt_name']."'")){
        $_SESSION['ERROR']['type'] = 'Done';
        $_SESSION['ERROR']['reason'] = "Sucsessfully Edited Content.";
    }else{
        $_SESSION['ERROR']['type'] = 'Error';
        $_SESSION['ERROR']['reason'] = "Operation Incomplete.Try Again Later.";
    }
}

// Update Profile Rating
function updateProRating($db,$randid){
    $sql = "SELECT AVG(`percentage`) as avgrat FROM ".QUIZDB." WHERE `user` = '".$randid."' AND `created_by` = 'system'";
    $rating = $db->query_first($sql);
    $data['rating'] = round($rating['avgrat']/10);
    $db->query_update(UA_TABLE,$data," `randid` = '".$randid."'");
    
    
}

/******************************************************************
***********************  Settings *********************************
******************************************************************/
function getSettingsGroup($db){
    $sql = "SELECT DISTINCT `group` FROM ".SETTINGS;
    return $db->fetch_all_array($sql);
}

function getSettingsArr($db,$group='all'){
    $sql = "SELECT * FROM ".SETTINGS;
    if($group != 'all'){
        $sql .= " WHERE `group` = '".$group."'";
    }
    return $db->fetch_all_array($sql);
}

if($_GET['subaction'] == 'editsett'){
    $all_sett = getSettingsArr($db,'all');
    foreach($all_sett as $setts){
        if($setts['value'] != $_POST[$setts['name']]){
            $data['value'] = $_POST[$setts['name']];
            $db->query_update(SETTINGS,$data," `name` = '".$setts['name']."'");
        }
    }
    print_r($_POST);
}

function getSettings($db,$name){
    $sql = "SELECT `value` FROM ".SETTINGS." WHERE `name` = '".$name."'";
    $data =  $db->query_first($sql);
    return $data['value'];
}

function getSettParam($db,$name){
    $sql = "SELECT `param` FROM ".SETTINGS." WHERE `name` = '".$name."'";
    $data =  $db->query_first($sql);
    return $data['param'];
}

function print_copyright(){
    echo '<div id="s'.PKEY.'">Powered by - <a href="http://www.softon.org">Softon Technologies</a></div>';
}
?>