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
?><?php if(file_exists('../config.inc.php')){
    die('<center>Install Script Disabled.</center>');
}
?>
<?php include_once('functions.php'); ?>
<?php
if($_POST['step']=='install' ){
    $_SESSION['VALID'] = checkParam($_POST);
    //print_r($_SESSION['VALID']);
    if($_SESSION['VALID']['status']=='yes'){
        $_SESSION['step'] = 3; 
        processSetup();   
    }else{
        $_SESSION['step'] = 2;
        header('Location:step2.php?error=invalid');
    } 
      
}else{
    header('Location:index.php?error=nodirect');
}
global $i,$c;
function processSetup(){
    global $i,$c;
    $i=0;
    $c=0;
    // Database Connectivity Checking
    if($error = checkDb($_POST)){
        $_SESSION['ERROR'][$i]['type'] = 'Done';
        $_SESSION['ERROR'][$i]['reason'] = 'Connected to Database';
        $i++;
        $c++;
    }else{
        $_SESSION['ERROR'][$i]['type'] = 'Error';
        $_SESSION['ERROR'][$i]['reason'] = 'Error Connecting to Database :'.mysql_error();
        $i++;
    }
    
    
    // Database Name Check 
    if($error = selectDb($_POST)){
        $_SESSION['ERROR'][$i]['type'] = 'Done';
        $_SESSION['ERROR'][$i]['reason'] = 'Selected Database "'.$_POST['db_name'].'"';
        $i++;
        $c++;
    }else{
        $_SESSION['ERROR'][$i]['type'] = 'Error';
        $_SESSION['ERROR'][$i]['reason'] = 'Error Selecting Database :'.mysql_error();
        $i++;
    }
    
    
    // Creating Tables
    if($error = createTables($_POST)){
        $_SESSION['ERROR'][$i]['type'] = 'Done';
        $_SESSION['ERROR'][$i]['reason'] = 'Tables Created Successfully';
        $i++;
        $c++;
    }else{
        $_SESSION['ERROR'][$i]['type'] = 'Error';
        $_SESSION['ERROR'][$i]['reason'] = 'Error Creating Tables :'.mysql_error();
        $i++;
    }
    
    // Sample Questions
    if($_POST['sample_qstn']=='yes'){
        if($error = insertSQstn($_POST)){
            $_SESSION['ERROR'][$i]['type'] = 'Done';
            $_SESSION['ERROR'][$i]['reason'] = 'Sample Questions inserted Successfully';
            $i++;
        }else{
            $_SESSION['ERROR'][$i]['type'] = 'Error';
            $_SESSION['ERROR'][$i]['reason'] = 'Error Inserting Sample Questions :'.mysql_error();
            $i++;
        }
    }
    
    // Creating Admin Account
    if($error = createAdmin($_POST)){
        $_SESSION['ERROR'][$i]['type'] = 'Done';
        $_SESSION['ERROR'][$i]['reason'] = 'Admin Account Created Successfully';
        $i++;
        $c++;
    }else{
        $_SESSION['ERROR'][$i]['type'] = 'Error';
        $_SESSION['ERROR'][$i]['reason'] = 'Error Creating Admin Account :'.mysql_error();
        $i++;
    }
    
    // Creating Mail Settings
    if($error = addMailSett($_POST)){
        $_SESSION['ERROR'][$i]['type'] = 'Done';
        $_SESSION['ERROR'][$i]['reason'] = 'Mail Settings Updated Successfully';
        $i++;
    }else{
        $_SESSION['ERROR'][$i]['type'] = 'Error';
        $_SESSION['ERROR'][$i]['reason'] = 'Error Updating Mail Settings :'.mysql_error();
        $i++;
    }
    
    
    // Create Config File
if($c>=4){
    if($error = createConfig($_POST)){
        $_SESSION['ERROR'][$i]['type'] = 'Done';
        $_SESSION['ERROR'][$i]['reason'] = 'Config File Created Successfully';
        $mail = new PHPMailer();
        PQmail($mail,$_POST);
        $i++;
        $c++;
    }else{
        $_SESSION['ERROR'][$i]['type'] = 'Error';
        $_SESSION['ERROR'][$i]['reason'] = 'Error Creating Config File ';
        $i++;
    }
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>ProQuiz V2 - A Quiz Apart</title>
<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen" />	
<script type="text/javascript" src="../js/jquery.js"></script>
<link href="../css/login.css" type="text/css" rel="stylesheet" media="screen" />
<link rel="stylesheet" href="../css/quiz.css" type="text/css" media="screen" />
<script type="text/javascript" src="../js/jquery.corner.js"></script>
<script type="text/javascript">
    $('.headDisp').corner("5px");
    $('.divText div').corner("5px");
    $('.divData div').corner("5px");
    $('.listRows').corner('5px');
    $('.listCols').corner('5px');

</script>
</head>

<body>

<div id="wrapper">

	<div id="header"><img src="../images/banner.jpg" width="800px" width="154px" /></div>

	<!-- Menu Start  -->
    <div id="menu">
        <div class="corner-left"></div>
        <div id="menuCenter">
    	   <div id="menuCenter">
    	       <ul>
                    <li><a href="index.php" >STEP 1</a></li>
                    <li><a href="step2.php" >STEP 2</a></li>
                    <li><a href="install.php" class="current">STEP 3</a></li>
                    <li><a href="finish.php">FINISH</a></li>
                </ul>       
            </div>
        </div>
        <div class="corner-right"></div>
  </div>    <!-- menu End -->

<!-- Start Sidebar -->
<div id="sidebar">
    <div id="sideFooter">
        <div class="corner-bLeft"></div>
        <div id="sideBtmCenter"></div>
        <div class="corner-bRight"></div>
    </div>
</div>   <!-- sidebar End -->

	<div id="content">
		
		<div class="pqMain">
	    <div class="pqTitle"><a href="#">Installing ProQuiz V2: STEP 3</a></div>
			<div class="pqSubTitle">Please Follow the Instructions to Finish the Installation.</div>
                <?php 
                if(!empty($_SESSION[ERROR])){
                foreach($_SESSION['ERROR'] as $value){ ?>
                    <div class="pqSub<?php echo $value['type']; ?>">
                        <ul>
                        <?php
                            $error_arr = explode('|',trim($value['reason'],'|'));
                            foreach($error_arr as $value_in){
                                echo  '<li>'.$value_in.'</li>';
                            }
                        ?>
                        </ul>
                    </div>
                    <div style="height: 5px;"></div>
                <?php } }?>
   <form action="finish.php?error=<?php if($c>=5 && file_exists('../config.inc.php')){ echo "finish"; }else{ echo "error"; } ?>" method="post">
        <div class="cntHolder">
            
            <div class="pq_ft"> 
                <input type="hidden" name="step" value="finish" />
                <input type="reset" class="sbutton" value="Clear" />
                <input type="submit" class="sbutton" value="Submit" />
            </div>
			
        </div>
	</form>		
		</div>
	</div>    <!-- content End -->

	<!-- Footer Include -->
    <div id="footer">
    <div class="corner-bLeft"></div>
	<div id="footer-valid">
		<span><div id="s">Powered by - <a href="http://www.softon.org">Softon Technologies</a></div></span>
	</div>
    <div class="corner-bRight"></div></div> <!-- wrraper End -->
    <?php unset($_SESSION['ERROR']); ?>
</body>
</html>