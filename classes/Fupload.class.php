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

 
class Fupload {

    var $the_file;
	var $the_temp_file;
    var $upload_dir;
	var $replace;
	var $do_filename_check;
	var $max_length_filename = 100;
    var $extensions;
	var $ext_string;
	var $language;
	var $http_error;
	var $rename_file; // if this var is true the file copy get a new name
	var $file_copy; // the new name
	var $message = array();
	var $create_directory = true;

	var $fileperm = 0644;
	var $dirperm = 0777;
	
	function fupload() {
		$this->language = 'en'; // choice of en, nl, es
		$this->rename_file = false;
		$this->ext_string = '';
	}

	function set_file_name($new_name = '') { // this 'conversion' is used for unique/new filenames 
		if ($this->rename_file) {
			if ($this->the_file == '') return;
			$name = ($new_name == '') ? strtotime('now') : $new_name;
			sleep(3);
			$name = $name.$this->get_extension($this->the_file);
		} else {
			$name = str_replace(' ', '_', $this->the_file); // space will result in problems on linux systems
		}
		return $name;
	}
	function upload($to_name = '') {
		$new_name = $this->set_file_name($to_name);
		if ($this->check_file_name($new_name)) {
			if ($this->validateExtension()) {
				if (is_uploaded_file($this->the_temp_file)) {
					$this->file_copy = $new_name;
					if ($this->move_upload($this->the_temp_file, $this->file_copy)) {
						$this->message[] = $this->error_text($this->http_error);
						if ($this->rename_file) $this->message[] = $this->error_text(16);
						return true;
					}
				} else {
					$this->message[] = $this->error_text($this->http_error);
					return false;
				}
			} else {
				$this->show_extensions();
				$this->message[] = $this->error_text(11);
				return false;
			}
		} else {
			return false;
		}
	}
	function check_file_name($the_name) {
		if ($the_name != '') {
			if (strlen($the_name) > $this->max_length_filename) {
				$this->message[] = $this->error_text(13);
				return false;
			} else {
				if ($this->do_filename_check == 'y') {
					if (preg_match('/^[a-z0-9_]*\.(.){1,5}$/i', $the_name)) {
						return true;
					} else {
						$this->message[] = $this->error_text(12);
						return false;
					}
				} else {
					return true;
				}
			}
		} else {
			$this->message[] = $this->error_text(10);
			return false;
		}
	}
	function get_extension($from_file) {
		$ext = strtolower(strrchr($from_file,'.'));
		return $ext;
	}
	function validateExtension() {
		$extension = $this->get_extension($this->the_file);
		$ext_array = $this->extensions;
		if (in_array($extension, $ext_array)) { 
		
			return true;
		} else {
			return false;
		}
	}
	// this method is only used for detailed error reporting
	function show_extensions() {
		$this->ext_string = implode(' ', $this->extensions);
	}
	function move_upload($tmp_file, $new_file) {
		if ($this->existing_file($new_file)) {
			$newfile = $this->upload_dir.$new_file;
			if ($this->check_dir($this->upload_dir)) {
				if (move_uploaded_file($tmp_file, $newfile)) {
					umask(0);
					chmod($newfile , $this->fileperm);
					return true;
				} else {
					return false;
				}
			} else {
				$this->message[] = $this->error_text(14);
				return false;
			}
		} else {
			$this->message[] = $this->error_text(15);
			return false;
		}
	}
	function check_dir($directory) {
		if (!is_dir($directory)) {
			if ($this->create_directory) {
				umask(0);
				mkdir($directory, $this->dirperm);
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}
	function existing_file($file_name) {
		if ($this->replace == 'y') {
			return true;
		} else {
			if (file_exists($this->upload_dir.$file_name)) {
				return false;
			} else {
				return true;
			}
		}
	}


	function del_temp_file($file) {
		$delete = @unlink($file); 
		clearstatcache();
		if (@file_exists($file)) { 
			$filesys = eregi_replace('/','\\',$file); 
			$delete = @system('del $filesys');
			clearstatcache();
			if (@file_exists($file)) { 
				$delete = @chmod ($file, 0644); 
				$delete = @unlink($file); 
				$delete = @system('del $filesys');
			}
		}
	}

	function error_text($err_num) {
		

			$error[0] = 'File: <b>'.$this->the_file.'</b> successfully uploaded!';
			$error[1] = 'The uploaded file exceeds the max. upload filesize directive in the server configuration.';
			$error[2] = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the html form.';
			$error[3] = 'The uploaded file was only partially uploaded';
			$error[4] = 'No file was uploaded';
			$error[6] = 'Missing a temporary folder. ';
			$error[7] = 'Failed to write file to disk. ';
			$error[8] = 'A PHP extension stopped the file upload. ';
			
			// end  http errors
			$error[10] = 'Please select a file for upload.';
			$error[11] = 'Only files with the following extensions are allowed: <b>'.$this->ext_string.'</b>';
			$error[12] = 'Sorry, the filename contains invalid characters. Use only alphanumerical chars and separate parts of the name (if needed) with an underscore. <br>A valid filename ends with one dot followed by the extension.';
			$error[13] = 'The filename exceeds the maximum length of '.$this->max_length_filename.' characters.';
			$error[14] = 'Sorry, the upload directory does not exist!';
			$error[15] = 'Uploading <b>'.$this->the_file.'...Error!</b> Sorry, a file with this name already exitst.';
			$error[16] = 'The uploaded file is renamed to <b>'.$this->file_copy.'</b>.';
			$error[17] = 'The file %s does not exist.';

		return $error[$err_num];
	}
}
?>
