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

//database server
define('DB_SERVER', "{DB_SERVER}");

//database login name
define('DB_USER', "{DB_USER}");
//database login password
define('DB_PASS', "{DB_PASS}");

//database name
define('DB_DATABASE', "{DB_DATABASE}");

// table prefix
define('PQPRE', "{PQPRE}");

//smart to define your table names also
define('QUIZTABLE', PQPRE."_quest");
define('QUIZDB', PQPRE."_qdb");
define('UA_TABLE', PQPRE."_userauth");
define('QUIZCAT', PQPRE."_category");
define('SETTINGS', PQPRE."_settings");
define('CONTENTS', PQPRE."_contents");
define('ONLINE', PQPRE."_online");
///////// Other Configs

// image upload dir
define('IMG_DIR',"images/upload/users/");
define('CAPTCHA_FILE',"captcha/securimage.php");
define('VALIDATE_FILE',"validate.class.php");
define('FUPLOAD_FILE',"Fupload.class.php");
define('DETAIL_SEP',"^|^");
define('SITENAME',"{SITENAME}");
define('SITETITLE',"{SITETITLE}");
define('SITE_LINK',"{SITE_LINK}");
define('NO_PARAM',"UA_DETAILS");



// Other Config
global $modules;
$modules = array('mcq'=>"modules/mcq.php");
global $modulesR;
$modulesR = array('mcqr'=>"modules/mcqr.php");


////////////////  Menu Dynamic
/////////   0 = always
/////////   1 = if not auth
/////////   2 = if  auth
global $headMenu;
$headMenu = array(0 => array("link" => "index.php","title" => "Home","level" => "user","auth" => 0),
				 1 => array("link" => "quiz_menu.php","title" => "Quiz Menu","level" => "user","auth" => 0),
				 2 => array("link" => "register.php","title" => "Register","level" => "user","auth" => 1),
				 3 => array("link" => "login.php","title" => "Login","level" => "user","auth" => 1),
				 4 => array("link" => "admin.php","title" => "Admin","level" => "admin","auth" => 2),
                 5 => array("link" => "my_account.php","title" => "My Panel","level" => "user","auth" => 2),
				 6 => array("link" => "logout.php","title" => "Logout","level" => "user","auth" => 2)				 
				 );

$regField = array("fname" => array("dname" => "First Name","name" => "fname","reqd" => "y","type" => "text","max" => 32),
				 "lname" => array("dname" => "Last Name","name" => "lname","reqd" => "y","type" => "text","max" => 32),
				 "email" => array("dname" => "Email ID","name" => "email","reqd" => "y","type" => "email","max" => 100),
				 "username" => array("dname" => "Username","name" => "username","reqd" => "y","type" => "uname","max" => 32),
				 "password" => array("dname" => "Password","name" => "password","reqd" => "y","type" => "pass","max" => 32,"min"=>4),
				 "profile" => array("dname" => "Profile Details","name" => "profile","reqd" => "n","type" => "nohtml","max" => 1024*100),
                 "dob" => array("dname" => "Date Of Birth","name" => "dob","reqd" => "n","type" => "date","max" => 10),
                 "gender" => array("dname" => "Gender","name" => "gender","reqd" => "y","type" => "text","max" => 1),
                 "photo" => array("dname" => "Profile Photo","name" => "photo","reqd" => "n","type" => "file","max" => 200)				 
				 );
global $regField;
define('PKEY','85550694285145230823');
define('MODULOUS','99809143352650341179');
define('COPYR','62132882231753774684 35705344074593681294 86247023688584780640 41061136505522547058 33999777817727484814 15993484261544630051 51934040895098876423 18078288772383042078 97315770009978196795 86092902277377396613 14261840901906181910 1762580371986572927 95880649859268412333 1607972403612240702 42058033449355072287 66254384765430192500 96126307325861520552 78180373957641606588 22365270530544589677 30596053409641248599 93375664478344290827 3521614606208');

				

?>