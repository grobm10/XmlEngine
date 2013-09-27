<?php

/** 
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/Server/Shell.php
 */
class Shell {

	/** 
	 * Return true if php is running from command line, false if is http request
	 * 
	 * @return		bool
	 */
	public static function IsCommandLine(){
		return (php_sapi_name() == 'cli') && empty($_SERVER['REMOTE_ADDR']);
	}

	/** 
	 * Return true if php is running from command line, false if is http request
	 * 
	 * @param		string				$shortOpt
	 * @param		array|string		$longOpts
	 * @return		array|string
	 * @see			http://www.php.net/manual/en/function.getopt.php
	 */
	public static function GetOptions($shortOpts='', $longOpts=array()){
		if(!is_string($shortOpts)){
			$shortOpts = '';
		}
		if(!is_array($longOpts)){
			$longOpts = array();
		}
		return getopt($shortOpts, $longOpts);
	}

	/** 
	 * Return an array of all the arguments passed to the script when running from the command line. 
	 * 
	 * @return		array|string
	 * @see			http://www.php.net/manual/en/reserved.variables.argv.php
	 */
	public static function GetArgs(){
		return $argv;
	}
	
	/** 
	 * Returns the hard disk available space in Gb.
	 * It only works in linux since executes the 'df -h' command
	 * 
	 * @return		int
	 * @todo		Check if the server calculates the space in Tb
	 */
	public static function GetDiskFree() {
		$hardDiskName = '/dev/sda1';
		if(defined('LOCAL_HARD_DISK')){
			$hardDiskName = LOCAL_HARD_DISK;
		}
		$output = array();
		exec('df -h', $output);
		foreach($output as $line){
			if(substr($line, 0, strlen($hardDiskName)) == $hardDiskName){
				$lineArray = explode('G', str_replace(' ', '', $line));
				return intval($lineArray[2]);
			}
		}
		return false;
	}

	/** 
	 * Returns the system date with the format YYYY-MM-DD H:m:s
	 * 
	 * @return		string
	 * @todo		Allow custom formats
	 */
	public static function GetSystemDate($format=null) {
		if(!empty($format)){
			return shell_exec('echo `date +"'.$format.'"`');
		} else {
			return shell_exec('echo `date +"%Y-%m-%d %H:%M:%S"`');
		}
		
	}
}