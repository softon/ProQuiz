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

class userAuth {
        //table fields
	    var $UA_TABLE = '';       //UserAuth table name
        var $UA_AUTH = false;  // User Authenticated
        var $UA_LEVEL = 'user';       //User Level
	     var $cnterror = 0;
	    //encryption
	    var $encrypt = false;       //set to true to use md5 encryption for the password
        
     // Constructor
        function __construct($UA_TABLE,$encrypt=false) {
        $this->UA_TABLE = $UA_TABLE;
        $this->encrypt = $encrypt;
     }  //end constructor
     
            //login function
	    function login($db ,$username, $password){  
	      
	        //check if encryption is used
	        if($this->encrypt == true){
	            $password = md5($password);
	        }else{
                $password = $db->escape($password);
	        }
	        //execute login Query
            $sql = "SELECT * FROM `".UA_TABLE."` WHERE (`username`= '".$db->escape($username)."' 
                                                            OR `email` = '".$db->escape($username)."') 
                                                            AND `password` = '$password'";
            
	        $record = $db->query_first($sql);
            if(!empty($record) && (($record['username'] == $username) || ($record['email'] == $username))){
                if(!isset($_SESSION)){
                    session_start();
                }
                    $_SESSION['UA_FLAG'] = $this->UA_AUTH = true;
                    unset($record['password']);
                    $_SESSION['UA_DETAILS'] = $record;
                    return true;
                
            }else{
                return false;
            }
	        	         
	    }      // end login
        
             //register function
	    function register($db ,$post_var){  
	       global $regField;
           
	      if($this->validate($db,$post_var)){
                $post_var_ins['randid']  = $this->genRandID($db);             // Generate Random ID
                $post_var_ins['fname']  = $post_var['fname'];
                $post_var_ins['lname']  = $post_var['lname'];
                $post_var_ins['email']  = $post_var['email'];
                $post_var_ins['username']  = $post_var['username'];
                $post_var_ins['password']  = $post_var['password'];
                $post_var_ins['profile']  = $post_var['profile'];
                $post_var_ins['dob']  = $post_var['dob'];
                $post_var_ins['gender']  = $post_var['gender'];
                $post_var_ins['level']  = "user";
                //check if encryption is used
                if($this->encrypt == true){
                    $post_var_ins['password'] = md5($post_var_ins['password']);
                }
                // File Upload
                if(isset($_FILES)){
                    $temp_file = $_FILES['photo']['tmp_name'];
                    $up_file  = IMG_DIR.$post_var_ins['randid'].strtolower(strrchr($_FILES['photo']['name'],'.'));
                    if(move_uploaded_file($temp_file,$up_file)){
                        $post_var_ins['photo'] = $post_var_ins['randid'].strtolower(strrchr($_FILES['photo']['name'],'.'));    
                    }else{
                        $post_var_ins['photo'] = $post_var['gender'].".png";
                    }
                    
                }else{
                    $post_var_ins['photo'] = $post_var['gender'].".png";
                }
                $primary_id = $db->query_insert(UA_TABLE,$post_var_ins);	
                if(!empty($primary_id)){
                    $_SESSION['ERROR']['type'] = 'Done';
                    $_SESSION['ERROR']['reason'] .= "|Your Account have been sucessfully created.";
                    return true;
                }else{
                    return false;
                }
	      }
          
                    
	    }      // end register
        
        
        
        ////////  Edit Profile
        function updateUsername($db,$randid,$username){
            $data['username'] = $username;
            if($db->query_update(UA_TABLE,$data,"`randid`='".$randid."'")){
                return true;
            }else{
                return false;
            } 
        }
        
        function updateEmail($db,$randid,$email){
            $data['email'] = $email;
            if($db->query_update(UA_TABLE,$data,"`randid`='".$randid."'")){
                return true;
            }else{
                return false;
            } 
        }
        
        
        function updatePassword($db,$randid,$password){
            $data['password'] = md5($password);
            
            if($db->query_update(UA_TABLE,$data,"`randid`='".$randid."'")){
                return true;
            }else{
                return false;
            } 
        }
        
        
        function updateOtherDetails($db,$ua_sess,$post_vars,$file){
            $arr = array('fname','lname','profile','dob','gender');
            foreach($arr as $value){
                $data[$value] = $post_vars[$value];
            }
            if(!empty($file)){                
                $temp_file = $file['photo']['tmp_name'];
                $up_file  = IMG_DIR.$ua_sess['randid'].strtolower(strrchr($file['photo']['name'],'.'));
                if(move_uploaded_file($temp_file,$up_file)){
                    $data['photo'] = $ua_sess['randid'].strtolower(strrchr($file['photo']['name'],'.'));    
                }
                
            }else{

                if($ua_sess['photo']=='m.png' || $ua_sess['photo']=='f.png'){
                    $data['photo'] = $post_vars['gender'].".png";
                }
            }
            if($db->query_update(UA_TABLE,$data,"`randid`='".$ua_sess['randid']."'")){
                return true;
            }else{
                return false;
            }
            
        }
        
            // special functions
            
        
            // login Check
        function checkLogin(){
            if(!isset($_SESSION)){
                    session_start();
                }
            if($_SESSION['UA_FLAG'] && isset($_SESSION['UA_USERNAME'])){
                return true;
            }else{
                return false;
            }
                    
        }       // end login check
        
            // generate Random ID
        function genRandID($db){
            while(1){
                $nob = rand(10000000,99999999);
                $sql = "SELECT * FROM `".UA_TABLE."` WHERE `randid` = '".$nob."'";
                $record = $db->query_first($sql);
                if(empty($record)){
                   break; 
                }   
            }
            return $nob;
        }       // end genrate Random ID
        
            // check Captcha
        function checkCaptcha($post_captcha){
            
                if(!class_exists('Securimage')){
                    include_once(CAPTCHA_FILE);
                }
                $captcha = new Securimage();
                if($captcha->check($post_captcha)){
                    return true;
                }else{
                    return false;
                }
            
        }   // end captcha
        
         // check validate
        function validate($db,$post_var){
            $this->cnterror = 0;
            if(!$captcha = $this->checkCaptcha($post_var['captcha_code'])){
               $_SESSION['ERROR']['type'] = 'Error';
               $_SESSION['ERROR']['reason'] .= "|".$this->error_text(3,'');
               $this->cnterror++;
            }
            
            if(!$cpaswd = $this->confirmPasswd($post_var['password'],$post_var['cpassword'])){             // check confirm password
                $this->cnterror++;
            }
            global $regField;
            foreach($regField as $fields) {
                if($fields['reqd']=='y'){
                    if($this->reqdField($post_var[$fields['name']])){
                        $this->validateFields($post_var[$fields['name']],$fields['type'],$fields['max'],$fields['dname']);
                    }else{
                        $_SESSION['ERROR']['reason'] .= "|".$this->error_text(1,$fields['dname']);
                        $this->cnterror++;
                    }
                }else{
                    $this->validateFields($post_var[$fields['name']],$fields['type'],$fields['max'],$fields['dname']);
                }
                
            }
            if($this->cnterror>0){
                $_SESSION['ERROR']['type'] = 'Error';
            }else{
                return true;
            }
            
        }   // end validate
        
        
        // Confirm Password
        function confirmPasswd($a,$b){
            global $regField;
            $min = $regField['password']['min'];
            $max = $regField['password']['max'];
            if($a==$b){
                if(strlen($a)>$max || strlen($a)<$min){
                    $msg = $this->error_text(5,'');
                    $msg = preg_replace('/__MIN__/',$min,$msg);
                    $msg = preg_replace('/__MAX__/',$max,$msg);
                    $_SESSION['ERROR']['reason'] .= "|".$msg;
                    $this->cnterror++;
                    return false;
                }else{
                    return true;
                }
            }else{
                $_SESSION['ERROR']['reason'] .= "|".$this->error_text(6,'');
                $this->cnterror++;
            }
        }
        // error_text
        function error_text($id,$field=''){
            $regField = array(0 => array("name" => "EMAX","reason" => "You Have Entered More than Maximum Allowed Characters in the $field Field"),
            				 1 => array("name" => "REQD","reason" => "$field is Required for Signup."),
            				 2 => array("name" => "INVEMAIL","reason" => "Invalid Email Entered"),
            				 3 => array("name" => "CAPTCHA","reason" => "Invalid CAPTCHA Entered"),
            				 4 => array("name" => "INVDATE","reason" => "$field should be in the format DD-MM-YYYY"),
            				 5 => array("name" => "INVPASS","reason" => "Password must be __MIN__ Character to __MAX__ Characters."),
                             6 => array("name" => "PASSMATCH","reason" => "Passwords did not Match."),
                             7 => array("name" => "INVNAME","reason" => "$field doesnt look like a name."),
                             8 => array("name" => "HTML","reason" => "HTML Tags found in  $field"),
                             9 => array("name" => "UNAME","reason" => "$field can contain only alphabets,numbers,-,_ ")				 
            				 );
            return $regField[$id]['reason'];
        }
        
        // Check Field Required Or Not (blank))
        function reqdField($data){
            if(!empty($data)){
                return true;
            }else{
                return false;
                $this->cnterror++;
            }
        }
        
        // validate class usage
        function validateFields($data,$type,$len,$dname){
            if(!class_exists('Validate')){
                include_once(VALIDATE_FILE);
            }
            $validate = new Validate();
            switch($type){
                case 'email':
                    if(!$validate->check_email($data)){
                        $this->cnterror++;
                        $_SESSION['ERROR']['reason'] .= "|".$this->error_text(2,$dname);
                    }
                    break;
                case 'alpha':
                    if(!$validate->check_alpha($data,$len)){
                        $this->cnterror++;
                        $_SESSION['ERROR']['reason'] .= "|".$this->error_text(7,$dname);
                    }
                    break;
                case 'nohtml':
                    if(!$validate->check_html_tags($data)){
                        $this->cnterror++;
                        $_SESSION['ERROR']['reason'] .= "|".$this->error_text(8,$dname);
                    }
                    break;
                case 'uname':
                    if(!$validate->check_alphanum($data,$len)){
                        $this->cnterror++;
                        $_SESSION['ERROR']['reason'] .= "|".$this->error_text(9,$dname);
                    }
                    break;
                case 'date':
                    if(!$validate->check_date($data,'')){
                        $this->cnterror++;
                        $_SESSION['ERROR']['reason'] .= "|".$this->error_text(4,$dname);
                    }
                    break;
                default:
                    return true;
            }
        }
        
        // Get Users List
        function getUsersList($db,$ua_details){
            $sql = "SELECT * FROM ".UA_TABLE." WHERE `level` <> 'system'";
            return $db->fetch_all_array($sql);
            
        }
        
        
        // Recover Pass
        function recoverPass($db,$email){
            $sql = "SELECT * FROM ".UA_TABLE." WHERE `email` = '".$email."' AND  `level` <> 'system'";
            if($db->query_first($sql)){
                $pass = rand(111111,999999);
                $data_f['password'] = md5($pass);
                if($db->query_update(UA_TABLE,$data_f," `email` = '".$email."'")){
                    $data['status'] = "done";
                    $data['newpass'] = $pass;
                }else{
                    $data['status'] = "error";
                }
            }else{
                $data['status'] = "noemail";
            }
            return $data;
        }
}

?>