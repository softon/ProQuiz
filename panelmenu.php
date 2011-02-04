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
?><ul id="nav" class="dropdown dropdown-horizontal">
            	<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>">MainMenu</a></li>
            	<li><span class="dir">Quiz</span>
            		<ul>
            			<li><span class="dir">New</span>
                            <ul>
                                <li><span class="dir">Question</span>
            					    <ul>
                                        <li><a href="<?php echo $_SERVER['PHP_SELF'].'?action=getpage&page=newqstn&type=mcq'; ?>">Multiple Choice Question</a></li>
                                    </ul>
                                </li>
            					<li><a href="<?php echo $_SERVER['PHP_SELF'].'?action=getpage&page=newcategory'; ?>">Category &amp; Sub-Category</a></li>
            				</ul>
                        </li>
            			<li><span class="dir">Edit</span>
                            <ul>
            					<li><a href="<?php echo $_SERVER['PHP_SELF'].'?action=getpage&page=viewqstn'; ?>">Quiz Questions</a></li>
            					<li><a href="<?php echo $_SERVER['PHP_SELF'].'?action=getpage&page=newcategory'; ?>">Category &amp; Sub-Category</a></li>
            				</ul>
                        </li>
            			<li><span class="dir">Installed Modules</span>
            				<ul>
            					<li>MCQ - Multiple Choice Question</li>
            				</ul>
            			</li>
            		</ul>
            	</li>
            	<li><span class="dir">Results</span>
            		<ul>
            			<li><a href="<?php echo $_SERVER['PHP_SELF'].'?action=getpage&page=results&type='.$_SESSION['UA_DETAILS']['randid']; ?>">My Results</a></li>
                        <li><a href="<?php echo $_SERVER['PHP_SELF'].'?action=getpage&page=results&type=my_quiz'; ?>">My Quiz</a></li>
            			<li class="divider"><a href="<?php echo $_SERVER['PHP_SELF'].'?action=getpage&page=results&type=all'; ?>">Results Table</a></li>
            			<li><a href="<?php echo $_SERVER['PHP_SELF'].'?action=getpage&page=results&type=stats'; ?>">Statistics</a></li>
            		</ul>
            	</li>
            	<li><span class="dir">Profile</span>
            		<ul>
            			<li><a href="./" class="dir">Edit</a>
            				<ul>
            					<li><a id="edit_username" href="<?php echo $_SERVER['PHP_SELF'].'?action=getpage&page=edit_profile&type=username'; ?>">Username</a></li>
            					<li><a id="edit_email" href="<?php echo $_SERVER['PHP_SELF'].'?action=getpage&page=edit_profile&type=email'; ?>">Email</a></li>
                                <li><a id="edit_pass" href="<?php echo $_SERVER['PHP_SELF'].'?action=getpage&page=edit_profile&type=password'; ?>">Password</a></li>
                                <li><a id="edit_other" href="<?php echo $_SERVER['PHP_SELF'].'?action=getpage&page=edit_profile&type=other'; ?>">Other Details</a></li>
            				</ul>
            			</li>
            			
            		</ul>
            	</li>
            	<li><a href="<?php echo $_SERVER['PHP_SELF'].'?action=getpage&page=contact_admin'; ?>" id="contact_admin">Contact Admin</a></li>
            	
            </ul>