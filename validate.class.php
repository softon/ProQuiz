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

class Validate {
	
	var $fields = array();
	var $messages = array();
	var $check_4html = false;
	var $language;
	
	function Validate() {
		$this->language = "en";
	}
	
	function check_url($url_val) {
			$url_pattern = "http\:\/\/[[:alnum:]\-\.]+(\.[[:alpha:]]{2,4})+";
			$url_pattern .= "(\/[\w\-]+)*"; // folders like /val_1/45/
			$url_pattern .= "((\/[\w\-\.]+\.[[:alnum:]]{2,5})?"; // filename like index.(s)html
			$url_pattern .= "|"; // end with filename or ?
			$url_pattern .= "\/?)"; // trailing slash or not
			$error_count = 0;
			if (strpos($url_val, "?")) {
				$url_parts = explode("?", $url_val);
				if (!preg_match("/^".$url_pattern."$/", $url_parts[0])) {
					$error_count++;
				}
				if (!preg_match("/^(&?[\w\-]+=\w*)+$/", $url_parts[1])) {
					$error_count++;
				}
			} else {
				if (!preg_match("/^".$url_pattern."$/", $url_val)) {
					$error_count++;
				}
			}
			if ($error_count > 0) {
					return false;
			} else {
				return true;
			}
	}
	function check_num_val($num_val,$num_len = 0) {
			$pattern = ($num_len == 0) ? "/^\-?[0-9]*$/" : "/^\-?[0-9]{0,".$num_len."}$/";
			if (preg_match($pattern, $num_val)) {
				return true;
			} else {
				return false;
			}
	}
	function check_text($text_val,$text_len = 0) {
			if ($text_len > 0) {
				if (strlen($text_val) > $text_len) {
					return false;
				} else {
					return true;
				}
			} else {
				return true;
			}
	}
	function check_check_box($req_value, $element) {
			if (!empty($req_value)) {
				if ($req_value != $_REQUEST[$element]) {
					return false;
				} else {
					return true;
				}
			} else {
				return true;
			}
	}
	function check_decimal($dec_val,$decimals = 2) {
			$pattern = "/^[-]*[0-9][0-9]*\.[0-9]{".$decimals."}$/";
			if (preg_match($pattern, $dec_val)) {
				return true;
			} else {
				return false;
			}

	}
    function check_alpha($dec_val,$char = 2) {
			$pattern = "/^[a-zA-Z]+$/";
			if (preg_match($pattern, $dec_val)) {
				return true;
			} else {
				return false;
			}

	}
    
    function check_alphanum($dec_val,$char = 2) {
			$pattern = "/^[-_.a-zA-Z0-9]+$/";
			if (preg_match($pattern, $dec_val)) {
				return true;
			} else {
				return false;
			}

	}
    
    
	function check_date($date, $version = "eu") {
            $date = trim($date);
			$date_parts = explode("-", $date);
			$month = $date_parts[1];
				$day = $date_parts[0];
				$year = $date_parts[2];
			if (checkdate(intval($month), intval($day), intval($year))) {
				return true;
			} else {
				return false;
			}
	}
	function check_email($mail_address) {
			if (preg_match("/^[0-9a-z]+(([\.\-_])[0-9a-z]+)*@[0-9a-z]+(([\.\-])[0-9a-z-]+)*\.[a-z]{2,}$/i", $mail_address)) {
				return true;
			} else {
				return false;
			}

	}
	function check_html_tags($value) {
		if (preg_match("/<[a-z1-6]+((\s[a-z]{2,}=['\"]?(.*)['\"]?)+(\s?\/)?)*>(<\/[a-z1-6]>)?/i", $value)) {
			return false;
		} else {
			return true;
		}
	}


}
?>