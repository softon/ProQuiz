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
?><?php if(!empty($_SESSION['ERROR'])) { ?>
<div class="pqSub<?php echo $_SESSION['ERROR']['type']; ?>">
    <ul>
    <?php
        $error_arr = explode('|',trim($_SESSION['ERROR']['reason'],'|'));
        foreach($error_arr as $value){
            echo  '<li>'.$value.'</li>';
        }
    ?>
    </ul>
</div>
<?php } ?>