DROP TABLE IF EXISTS `{TBLPRE}category`;
{SEPR}
CREATE TABLE IF NOT EXISTS `{TBLPRE}category` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `cat` varchar(100) DEFAULT NULL,
  `subcat` varchar(100) DEFAULT NULL,
  `added_by` int(10) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='category table' AUTO_INCREMENT=1 ;
{SEPR}
DROP TABLE IF EXISTS `{TBLPRE}contents`;
{SEPR}
CREATE TABLE IF NOT EXISTS `{TBLPRE}contents` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `value` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;
{SEPR}
INSERT INTO `{TBLPRE}contents` (`id`, `name`, `value`) VALUES
(1, 'index_contents', '<p><span style="font-size: medium;"><span style="color: #0000ff;"><strong>&nbsp;&nbsp;&nbsp;&nbsp; ProQuiz</strong></span> Ver 2.0.0 is a Professional Quiz Maker Software capable of Generating Quizzes                  of all types by simple user interface. Its easy User-friendly interface makes it stand apart                  from other softwares in this category. <br /><br /><span style="color: #ff6600; font-size: large;"><strong><span style="text-decoration: underline;">Features</span>:</strong></span></span></p>\r\n<p style="padding-left: 30px;"><img src="images/correct.png" alt="List Item" width="15" height="15" />&nbsp;<span style="font-size: medium; color: #0000ff;"> Multiple Choice Questions Supported</span><br /><span style="color: #0000ff;"><img src="images/correct.png" alt="List Item" width="15" height="15" />&nbsp; <span style="font-size: medium;">Fully Customizable</span></span><br /><span style="color: #0000ff;"><img src="images/correct.png" alt="List Item" width="15" height="15" />&nbsp; <span style="font-size: medium;">Detailed Summary Report</span></span><br /><span style="color: #0000ff;"><img src="images/correct.png" alt="List Item" width="15" height="15" />&nbsp; <span style="font-size: medium;">Reports Charts Displayed<br /></span></span><span style="color: #0000ff;"><img src="images/correct.png" alt="List Item" width="15" height="15" />&nbsp; <span style="font-size: medium;">Good Ajax Support<br /></span></span><span style="color: #0000ff;"><img src="images/correct.png" alt="List Item" width="15" height="15" />&nbsp; <span style="font-size: medium;">Timing Chart Display<br /></span></span><span style="color: #0000ff;"><img src="images/correct.png" alt="List Item" width="15" height="15" />&nbsp; <span style="font-size: medium;">Displays Online Users</span></span><br /><span style="color: #0000ff;"><img src="images/correct.png" alt="List Item" width="15" height="15" />&nbsp; <span style="font-size: medium;">Full Admin Customizable Control Panel</span></span></p>\r\n<p style="padding-left: 30px;"><span style="color: #0000ff;"> <span style="font-size: medium;">For complete list of features, <strong><a href="http://proquiz.softon.org/features.php">Click Here</a></strong></span></span></p>'),
(2, 'my_panel', '<p><span style="color: #0000ff; font-family: arial black,avant garde; font-size: medium;"><br />This Panel helps to do the following changes:</span></p>\r\n<ul>\r\n<li><span style="color: #0000ff;"><span style="color: #ff6600;"><strong>Quiz</strong></span> : Here You Can </span></li>\r\n</ul>\r\n<ol> </ol>\r\n<blockquote style="padding-left: 30px;"><span style="color: #0000ff;">1. Add / Edit Quiz Questions<br />2. Add / Edit Categories &amp; Sub-Categories<br />3. View Installed Modules</span><ol> </ol></blockquote>\r\n<ul>\r\n<li><span style="color: #0000ff;"><span style="color: #ff6600;"><strong>Results</strong></span> : Here You Can</span></li>\r\n</ul>\r\n<ol> </ol>\r\n<blockquote style="padding-left: 30px;"><span style="color: #0000ff;">1. View Your Quiz Results.<br />2. View Custom Quiz Results<br />3. View All Results</span><ol> </ol></blockquote>\r\n<ul>\r\n<li><span style="color: #0000ff;"><span style="color: #ff6600;"><strong>Profile</strong></span> : Here You Can</span></li>\r\n</ul>\r\n<ol> </ol>\r\n<blockquote style="padding-left: 30px;"><span style="color: #0000ff;">1. Edit Your Profile.</span><ol> </ol></blockquote>\r\n<ul>\r\n<li><span style="color: #0000ff;"><span style="color: #ff6600;"><strong>Contact Admin</strong></span> : Here You can send messages to all the admins requesting for activation of your categories,sub-categories &amp;&nbsp; quiz questions.</span></li>\r\n</ul>'),
(3, 'admin_panel', '<p><strong><span style="color: #0000ff; font-size: small;"><br />This Panel helps to do the following changes:</span></strong></p>\r\n<ul>\r\n<li><span style="color: #0000ff;"><span style="color: #ff6600;"><strong>Activate</strong></span> : Here You can </span></li>\r\n</ul>\r\n<ol> </ol>\r\n<blockquote style="padding-left: 30px;"><span style="color: #0000ff;">1. Activate Quiz Questions<br />2. Activate Categories &amp; Sub-Categories</span><ol> </ol></blockquote>\r\n<ul>\r\n<li><span style="color: #0000ff;"><span style="color: #ff6600;"><strong>Manage Users</strong> </span>: Here You Can Manage Users.</span></li>\r\n</ul>\r\n<ul>\r\n<li><span style="color: #0000ff;"><span style="color: #ff6600;"><strong>Content Management</strong></span> : Here You Can</span></li>\r\n</ul>\r\n<ol> </ol>\r\n<blockquote style="padding-left: 30px;"><span style="color: #0000ff;">1. Edit Your Website Contents.</span><ol> </ol></blockquote>\r\n<ul>\r\n<li><span style="color: #0000ff;"><span style="color: #ff6600;"><strong>Settings</strong></span> : Here You can change necessary settings for proper working of the script.</span></li>\r\n</ul>');
{SEPR}
DROP TABLE IF EXISTS `{TBLPRE}online`;
{SEPR}
CREATE TABLE IF NOT EXISTS `{TBLPRE}online` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `php_sess_id` varchar(200) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `last_activity` int(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;
{SEPR}
INSERT INTO `{TBLPRE}online` (`id`, `php_sess_id`, `username`, `last_activity`) VALUES
(1, 's3h6du1v3o1mvfv1ab5soj3s66', 'guest', 1296580432),
(2, 'tks1tet3n2jeoght2ejqk07ug3', 'admin', 1296580429);
{SEPR}
DROP TABLE IF EXISTS `{TBLPRE}qdb`;
{SEPR}
CREATE TABLE IF NOT EXISTS `{TBLPRE}qdb` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `instid` int(10) DEFAULT NULL,
  `user` int(10) DEFAULT NULL,
  `quiz_inst_ts` varchar(100) DEFAULT NULL,
  `quiz_start_ts` varchar(100) DEFAULT NULL,
  `quiz_end_ts` varchar(100) DEFAULT NULL,
  `questions_arr` text,
  `type_arr` text,
  `answers_arr` text,
  `canswers_arr` text,
  `cat_arr` text,
  `timing_arr` text,
  `total_qstn` int(5) DEFAULT '0',
  `total_correct` int(5) DEFAULT '0',
  `total_wrong` int(5) DEFAULT '0',
  `total_time` int(5) DEFAULT '0',
  `time_used` int(5) DEFAULT '0',
  `percentage` float DEFAULT '0',
  `created_by` varchar(10) DEFAULT NULL,
  `locked_quiz` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `instid` (`instid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Proquiz Db for all the Test' AUTO_INCREMENT=1 ;
{SEPR}
DROP TABLE IF EXISTS `{TBLPRE}quest`;
{SEPR}
CREATE TABLE IF NOT EXISTS `{TBLPRE}quest` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `qid` varchar(10) DEFAULT NULL,
  `question` text,
  `options` text,
  `answer` text,
  `why` text,
  `type` varchar(3) DEFAULT NULL,
  `category` varchar(32) DEFAULT 'Default',
  `sub_cat` varchar(32) DEFAULT NULL,
  `added_by` int(10) DEFAULT NULL,
  `open_quiz` tinyint(1) DEFAULT '1',
  `count` int(5) DEFAULT '0',
  `active` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `qid` (`qid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Quiz Questions Table' AUTO_INCREMENT=1 ;
{SEPR}
DROP TABLE IF EXISTS `{TBLPRE}settings`;
{SEPR}
CREATE TABLE IF NOT EXISTS `{TBLPRE}settings` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `value` text,
  `details` text,
  `type` varchar(100) DEFAULT NULL,
  `group` varchar(100) DEFAULT NULL,
  `param` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;
{SEPR}
INSERT INTO `{TBLPRE}settings` (`id`, `name`, `value`, `details`, `type`, `group`, `param`) VALUES
(1, 'gquiz', '1', 'General Quiz|This is the most simplest form of quiz where you can select desired number of questions &amp; any amount of time you require and the desired categories.', 'checkbox', 'Modules', 'installed'),
(2, 'oquiz', '', 'Open Quiz|In this type of Quiz users get many predefined Question sets and restricted timimg to select from which are made by other users. ', 'checkbox', 'Modules', 'notinstalled'),
(3, 'lquiz', '', 'Locked Quiz| Same as Open Quiz but here the Users who can take the Quiz is also pre-defined.', 'checkbox', 'Modules', 'notinstalled'),
(4, 'wwwquiz', '', 'WWW Quiz|In this type of Quiz users who are online can compete among themselves or with a bot if no users are found online.', 'checkbox', 'Modules', 'notinstalled'),
(5, 'shdquiz', '', 'Scheduled Quiz|In this quiz users can schedule their Quizzes to a specific Date & Time, users can take quiz only if the Scheduled Date and Time have reached.', 'checkbox', 'Modules', 'notinstalled'),
(6, 'remquiz', '', 'Remote Quiz|In this type of Quiz the User have the privilege to start the quiz remotely.Once the Quiz starts then new users can''t take the quiz. ', 'checkbox', 'Modules', 'notinstalled'),
(7, 'brdmail', '1', 'Board Mails', 'checkbox', 'Mail', 'installed'),
(8, 'smtpmail', '', 'SMTP Mails', 'checkbox', 'Mail', 'installed'),
(9, 'gmailuser', 'md@trdc.in', 'Gmail Username', 'text', 'Mail', 'installed'),
(10, 'gmailpass', 'v0HMfGVFyE', 'Gmail Username', 'text', 'Mail', 'installed');
{SEPR}
DROP TABLE IF EXISTS `{TBLPRE}userauth`;
{SEPR}
CREATE TABLE IF NOT EXISTS `{TBLPRE}userauth` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `randid` int(10) DEFAULT NULL,
  `fname` varchar(32) DEFAULT NULL COMMENT 'First Name',
  `lname` varchar(32) DEFAULT NULL COMMENT 'Last Name',
  `email` varchar(100) DEFAULT NULL,
  `username` varchar(32) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `profile` text,
  `dob` varchar(10) DEFAULT NULL,
  `gender` varchar(1) DEFAULT NULL,
  `photo` varchar(200) DEFAULT NULL,
  `level` varchar(10) DEFAULT 'user',
  `rating` smallint(2) DEFAULT '0',
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `randid` (`randid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;
{SEPR}
INSERT INTO `{TBLPRE}userauth` (`id`, `randid`, `fname`, `lname`, `email`, `username`, `password`, `profile`, `dob`, `gender`, `photo`, `level`, `rating`, `active`) VALUES
(1, 1, 'System', 'Account', 'sys', 'sys', 'sys', 'sys', '00-00-0000', '0', '0', 'system', 0, 0);