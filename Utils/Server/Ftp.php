<?php

/** 
 * @author			David Curras
 * @version			October 6, 2012
 * @filesource		/Utils/Server/FTP.php
 */
final class Ftp {

	/**
	 * FTP host
	 *
	 * @var		string		$_host
	 */
	private $_host;

	/**
	 * FTP port
	 *
	 * @var		int		$_port
	 */
	private $_port = 21;

	/**
	 * FTP password
	 *
	 * @var		string		$_password
	 */
	private $_password;
	
	/**
	 * FTP stream
	 *
	 * @var		resource		$_stream
	 */
	private $_stream;

	/**
	 * FTP timeout
	 *
	 * @var		int		$_timeout
	 */
	private $_timeout = 90;

	/**
	 * FTP user
	 *
	 * @var		string		$_user
	 */
	private $_user;

	/**
	 * FTP connected
	 *
	 * @var		bool		$_connected
	 */
	private $_connected = false;
	
	/**
	 * Last error
	 *
	 * @var		string		$error
	 */
	public $error;

	/**
	 * FTP passive mode flag
	 *
	 * @var		bool		$passive
	 */
	public $passive = false;

	/**
	 * SSL-FTP connection flag
	 *
	 * @var		bool		$ssl
	 */
	public $ssl = false;

	/**
	 * System type of FTP server
	 *
	 * @var		string		$systemType
	 */
	public $systemType;
	
	/**
	 * Connect to FTP server
	 * @param		string		$host
	 * @param		string		$user
	 * @param		string		$password
	 * @param		int			$port
	 * @param		int			$timeout (seconds)
	 *
	 * @return		bool
	 */
	public function connect($host, $user, $password, $port = 21, $timeout = 90) {
		if($this->_connected){
			$this->close();
		}
		$this->_host = $host;
		$this->_user = $user;
		$this->_password = $password;
		$this->_port = (int)$port;
		$this->_timeout = (int)$timeout;
		if(!$this->ssl) {
			// Attempt simple FTP connection
			if(!$this->_stream = ftp_connect($this->_host, $this->_port, $this->_timeout)) {
				$this->error = 'Failed to connect to "'.$this->_host.'"';
				return false;
			}
		} elseif(function_exists("ftp_ssl_connect")) {
			// Attempt FTP SSL connection
			if(!$this->_stream = ftp_ssl_connect($this->_host, $this->_port, $this->_timeout)) {
				$this->error = 'Failed to connect to "'.$this->_host.' (SSL connection)"';
				return false;
			}
		} else {
			$this->error = 'Failed to connect to "'.$this->_host.' (SSL connection are not available)"';
			return false;
		}
		if(ftp_login($this->_stream, $this->_user, $this->_password)) {
			// set passive mode
			ftp_pasv($this->_stream, (bool)$this->passive);
			// set system type
			$this->systemType = ftp_systype($this->_stream);
			$this->_connected = true;
			return true;
		} else {
			$this->error = 'Failed to connect to "'.$this->_host.' (Login failed)"';
			return false;
		}
	}

	/**
	 * Get current directory
	 *
	 * @return		string
	 */
	public function pwd() {
		return ftp_pwd($this->_stream);
	}

	/**
	 * Change currect directory on FTP server
	 *
	 * @param		string		$directory
	 * @return		bool
	 */
	public function cd($directory=null) {
		if(ftp_chdir($this->_stream, $directory)) {
			return true;
		} else {
			$this->error = 'Failed to change directory to "'.$directory.'"';
			return false;
		}
	}
	
	/**
	 * Returns a list with the names of the files and folders in the given directory
	 *
	 * @param		string		$directory
	 * @return		array
	 */
	public function ls($directory=null) {
		$list = ftp_nlist($this->_stream, $directory);
		if($list !== false) {
			return $list;
		} else {
			$this->error = 'Failed to get directory list "'.$directory.'"';
			return false;
		}
	}
	
	/**
	 * Returns a detailed list of files and folders in the given directory
	 *
	 * @param		string		$directory
	 * @return		array
	 */
	public function lsDetailed($directory=null, $recursive=false) {
		$list = ftp_rawlist($this->_stream, $directory, $recursive);
		if($list !== false) {
			return $list;
		} else {
			$this->error = 'Failed to get directory detailed list "'.$directory.'"';
			return false;
		}
	}

	/**
	 * Tells whether the current path is a dir
	 *
	 * @param		string		$path
	 * @return		array
	 */
	public function isDir($path) {
		if($this->_stream) {
			return is_dir('ftp://'.$this->_user.':'.$this->_password.'@'.$this->_host.'/'.$path);
		} else {
			$this->error = 'Failed to check dir. User must be logged.';
		}
	}

	/**
	 * Gets the current file size
	 *
	 * @param		string		$path
	 * @return		integer
	 */
	public function fileSize($path) {
		$size = ftp_size($this->_stream, $path);
		if($size !== false) {
			return $size;
		} else {
			$this->error = 'Failed to get file size "'.$directory.'"';
			return false;
		}
	}

	/**
	 * Executes a command in the ftp server
	 *
	 * @param		string		$command
	 * @return		mixed
	 * @todo		Implement exec function checking with ftp_exec and performing with ftp_raw
	 * @see			http://www.php.net/manual/es/function.ftp-exec.php
	 * @see			http://www.php.net/manual/es/function.ftp-raw.php
	 */
	public function execute($command) {
		throw new Exception('Non implemented method. Ftp->execute($command)');
	}
	
	/**
	 * Download file in ASCII mode from server
	 *
	 * @param		string		$remote_file
	 * @param		string		$local_file
	 * @param		bool		$isTextFile
	 * @return		bool
	 */
	public function get($remote_file, $local_file, $isTextFile=true) {
		if($isTextFile){
			if(ftp_get($this->_stream, $local_file, $remote_file, FTP_ASCII)) {
				return true;
			} else {
				$this->error = 'Failed to download file "'.$remote_file.'"';
				return false;
			}
		} else {
			return $this->nonBlockingGet($remote_file, $local_file);
		}
	}
	
	
	/**
	 * Download file in Non Blocking (BINARY) mode from server
	 *
	 * @param		string		$remote_file
	 * @param		string		$local_file
	 * @return		bool
	 */
	public function nonBlockingGet($remote_file, $local_file) {
		$fileSize = $this->fileSize($remote_file);
		//check if file has more tha 1 byte
		if($fileSize > 1){
			$stream = ftp_nb_get($this->_stream, $local_file, $remote_file, FTP_BINARY);
			$shownLoop = intval(($fileSize / 2000) / 20); //One loop takes about 2000 bytes
			$i = 0;
			while($stream == FTP_MOREDATA) {
				$stream = ftp_nb_continue($this->_stream);
				if(($shownLoop > 0) && ($i % $shownLoop) == 0){
					echo "\n".'Downloading '.round($i*2000/(1024*1024), 2).' MB (aprox) of '.round($fileSize/(1024*1024), 2).' MB';
				}
				++$i;
			}
			if ($stream != FTP_FINISHED) {
				echo "\n".'Download FAIL '."\n";
				$this->error = 'Failed to download file "'.$remote_file.'"';
				return false;
			} else {
				echo "\n".'Download SUCCESS';
				echo "\n".'Downloaded '.round(filesize($local_file)/(1024*1024), 2).' MB of '.round($fileSize/(1024*1024), 2)." MB\n";
				return true;
			}
		} else {
			echo "\n".'No such file "'.$remote_file.'" in FTP server'."\n";
			$this->error = 'Failed to download file "'.$remote_file.'"';
			return false;
		}
	}

	/**
	 * Create directory on FTP server
	 *
	 * @param		string		$directory
	 * @return		bool
	 */
	public function mkdir($directory) {
		if(ftp_mkdir($this->_stream, $directory)) {
			return true;
		} else {
			$this->error = 'Failed to create directory "'.$directory.'"';
			return false;
		}
	}
	
	/**
	 * Upload file to server
	 *
	 * @param		string		$local_file
	 * @param		string		$remote_file
	 * @param		bool		$isTextFile
	 * @return		bool
	 */
	public function put($local_file, $remote_file, $isTextFile=true) {
		if($isTextFile){
			if(ftp_put($this->_stream, $remote_file, $local_file, FTP_ASCII)) {
				return true;
			} else {
				$this->error = 'Failed to uploading file "'.$remote_file.'"';
				return false;
			}
		} else {
			return $this->nonBlockingPut($local_file, $remote_file);
		}
	}
	
	
	/**
	 * Upload file in Non Blocking (BINARY) mode from server
	 *
	 * @param		string		$local_file
	 * @param		string		$remote_file
	 * @return		bool
	 */
	public function nonBlockingPut($local_file, $remote_file) {
		//check if file has more tha 1 byte
		if(file_exists($local_file) && (($fileSize = filesize($local_file)) > 1)){
			$stream = ftp_nb_put($this->_stream, $remote_file, $local_file, FTP_BINARY);
			$shownLoop = intval(($fileSize / 4000) / 20); //One loop takes about 4000 bytes
			$i = 0;
			while($stream == FTP_MOREDATA) {
				$stream = ftp_nb_continue($this->_stream);
				if(($shownLoop > 0) && ($i % $shownLoop) == 0){
					echo "\n".'Uploading '.round($i*4000/(1024*1024), 2).' MB (aprox) of '.round($fileSize/(1024*1024), 2).' MB';
				}
				++$i;
			}
			if ($stream != FTP_FINISHED) {
				echo "\n".'Upload FAIL '."\n";
				$this->error = 'Failed to Upload file "'.$local_file.'"';
				return false;
			} else {
				echo "\n".'Upload SUCCESS';
				echo "\n".'Uploaded '.round($fileSize/(1024*1024), 2).' MB of '.round($this->fileSize($remote_file)/(1024*1024), 2)." MB\n";
				return true;
			}
		} else {
			echo "\n".'No such file "'.$local_file.'"'."\n";
			$this->error = 'Failed to upload file "'.$local_file.'"';
			return false;
		}
	}

	/**
	 * Rename file on FTP server
	 *
	 * @param		string		$old_name
	 * @param		string		$new_name
	 * @return		bool
	 */
	public function rename($old_name, $new_name) {
		if(ftp_rename($this->_stream, $old_name, $new_name)) {
			return true;
		} else {
			$this->error = 'Failed to rename file "'.$old_name.'"';
			return false;
		}
	}

	/**
	 * Set file permissions
	 *
	 * @param		int			$permissions (ex: 0644)
	 * @param		string		$remote_file
	 * @return		false
	 */
	public function chmod($permissions, $remote_file) {
		if(ftp_chmod($this->_stream, $permissions, $remote_file)) {
			return true;
		} else {
			$this->error = 'Failed to set file permissions for "'.$remote_file.'"';
			return false;
		}
	}
	
	/**
	 * Delete file on FTP server
	 *
	 * @param		string		$remote_file
	 * @return		bool
	 */
	public function delete($remote_file) {
		if(ftp_delete($this->_stream, $remote_file)) {
			return true;
		} else {
			$this->error = 'Failed to delete file "'.$remote_file.'"';
			return false;
		}
	}
	
	/**
	 * Remove directory on FTP server
	 *
	 * @param		string		$directory
	 * @return		bool
	 */
	public function rmdir($directory) {
		if(ftp_rmdir($this->_stream, $directory)) {
			return true;
		} else {
			$this->error = 'Failed to remove directory "'.$directory.'"';
			return false;
		}
	}
	
	/**
	 * Close FTP connection
	 */
	public function close() {
		if($this->_stream) {
			ftp_close($this->_stream);
			$this->_stream = false;
			$this->_connected = false;
		}
	}

	/**
	 *	Closes FTP connection before destruct
	 *
	 *	@return		bool
	 */
	public function __destruct() {
		self::$this->close();
	}
}