<?php
/** 
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/Server/Ssh2.php
 */

class Ssh2 {

	private $connection = null;
	private $sftp = null;
	public $shellStream = null;

	/** 
	 * Tries to performs the SSH connection
	 * 
	 * @param	string	$host
	 * @param	string	$port
	 */
	public function __construct($host, $port=null) {
		if(empty($host)){
			throw new Exception('Host can not be null');
		}
		if(empty($port)){
			$port = '22';
		}
		$this->connection = ssh2_connect($host, $port);
		if(empty($this->connection)) {
			throw new Exception('Can not connected to '.$host.':'.$port);
		}
	}

	/** 
	 * Tries to Authenticate the user
	 * 
	 * @param	string	$user
	 * @param	string	$password
	 * @return	bool
	 */
	public function auth($user, $password) {
		if(empty($user) || empty($password)){
			throw new Exception('User and password can not be null');
		}
		if(!ssh2_auth_password($this->connection, $user, $password)) {
			throw new Exception('Authentication failed!');
		}
		return true;
	}

	/** 
	 * Execute a command on a remote server
	 * Expects a variable
	 * 
	 * @param	string	$command
	 * @return	Array|string
	 * @see		http://php.net/manual/en/function.ssh2-exec.php
	 * @see		http://php.net/manual/en/function.func-get-args.php
	 */
	public function exec() {
		$argumentList = func_get_args();
		foreach($argumentList as $arg){
			if(!is_string($arg)){
				throw new Exception('Unexpected non string arguments');
			}
		}
		$cmd = implode(" &amp;&amp; ", $argumentList);
		$stream = ssh2_exec($this->connection, $cmd);
		stream_set_blocking($stream, true);
		$output = array(
				'output'=>stream_get_contents($stream),
				'errors'=>stream_get_contents(ssh2_fetch_stream($stream, SSH2_STREAM_STDERR))
			);
		return $output;
	}

	/** 
	 * Creates a remote folder via SFTP. If folder already exists it fails.
	 * 
	 * @param	string	$dirPath
	 * @return	bool
	 * @see		http://php.net/manual/en/function.ssh2-sftp-mkdir.php
	 */
	public function createDir($dirPath) {
		if(empty($this->sftp)){
			$this->sftp = ssh2_sftp($this->connection);
		}
		if(!ssh2_sftp_mkdir($this->sftp, $dirPath)){
			throw new Exception('Can not create folder: ' . $dirPath);
		}
		return true;
	}

	/** 
	 * Removes a remote folder via SFTP
	 * 
	 * @param	string	$dirPath
	 * @return	bool
	 * @see		http://php.net/manual/en/function.ssh2-sftp-rmdir.php
	 */
	public function removeDir($dirPath) {
		if(empty($this->sftp)){
			$this->sftp = ssh2_sftp($this->connection);
		}
		if(!ssh2_sftp_rmdir($this->sftp, $dirPath)){
			throw new Exception('Can not remove folder: ' . $dirPath);
		}
		return true;
	}

	/** 
	 * Sends a file via SCP. If file already exists it will be overwrited
	 * 
	 * @param	string	$localFile
	 * @param	string	$remoteFile
	 * @param	int		$permision
	 * @return	bool
	 * @see		http://php.net/manual/en/function.ssh2-scp-send.php
	 */
	public function uploadFile($localFile,$remoteFile,$permision) {
		if(file_exists($localFile)){
			if (ssh2_scp_send($this->connection, $localFile, $remoteFile, $permision)) {
				throw new Exception('Can not transfer file: ' . $localFile);
			}
			return true;
		} else {
			throw new Exception($localFile . ' not exist');
		}
	}

	/** 
	 * Gets a file via SCP
	 * 
	 * @param	string	$remoteFile
	 * @param	string	$localFile
	 * @return	bool
	 * @see		http://php.net/manual/en/function.ssh2-scp-recv.php
	 */
	public function downloadFile($remoteFile, $localFile) {
		if (!ssh2_scp_recv($this->connection, $remoteFile, $localFile)) {
			throw new Exception('Can not receive file: ' . $localFile);
		}
		return true;
	}

	/** 
	 * Renames a remote file via SFTP
	 * 
	 * @param	string	$oldFilePath
	 * @param	string	$newFilePath
	 * @return	bool
	 * @see		http://php.net/manual/en/function.ssh2-sftp-rename.php
	 */
	public function rename($oldFilePath, $newFilePath) {
		if(empty($this->sftp)){
			$this->sftp = ssh2_sftp($this->connection);
		}
		if(!ssh2_sftp_rename($this->sftp, $oldFilePath, $newFilePath)){
			throw new Exception('Can not rename file: ' . $oldFilePath);
		}
		return true;
	}

	/** 
	 * Deletes a remote file via SFTP
	 * 
	 * @param	string	$filePath
	 * @return	bool
	 * @see		http://php.net/manual/en/function.ssh2-sftp-unlink.php
	 */
	public function removeFile($filePath) {
		if(empty($this->sftp)){
			$this->sftp = ssh2_sftp($this->connection);
		}
		if(!ssh2_sftp_unlink($this->sftp, $filePath)){
			throw new Exception('Can not remove file: ' . $filePath);
		}
		return true;
	}

	/** 
	 * Request an interactive shell. In UNIX systems you can open a
	 * terminal and run "echo $TERM" to see the $shellType value
	 * 
	 * @param	string	$shellType
	 * @return	bool
	 * @see		http://php.net/manual/en/function.ssh2-shell.php
	 * @see		http://manpages.ubuntu.com/manpages/oneiric/es/man5/termcap.5.html
	 * @example $mySsh2->openShell('xterm');
	 */
	public function openShell($shellType) {
		if (empty($shellType)){
			throw new Exception('User and password can not be null');
		}
		$this->shellStream = ssh2_shell($this->connection, $shellType);
        stream_set_blocking($this->shellStream, true);
		if(empty($this->shellStream)){
			throw new Exception('Shell connection failed!');
		}
		return true;
	}

	/** 
	 * Write commands into the current shell
	 * Warning: Once openShell method is used, exec does not work
	 *
	 * @param	string	$command
	 * @return	bool
	 */
	public function writeShellLine($command) {
		if(empty($this->shellStream)){
			throw new Exception('Can not write in a non opened shell');
		}
		if(!empty($command) && is_string($command)){
			fwrite($this->shellStream, $command);
			return true;
		}
		return false;
	}

	/** 
	 * Write commands into the current shell
	 * 
	 * @param	string	$command
	 */
	public function disconnect() {
		if (function_exists('ssh2_disconnect')) {
			ssh2_disconnect($this->connection);
		} else {
			unset($this->conn);
		}
	}
}