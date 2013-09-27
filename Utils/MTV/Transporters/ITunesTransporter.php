<?php

/**
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/MTV/Transporters/ITunesTransporter.php
 */
class ITunesTransporter extends AbstractTransporter {
	
	const CRITICAL_VERBOSE = 'critical';
	const EXTREME_VERBOSE = 'eXtreme';
	
	/**
	 * The ITMS provider name
	 * @var			string
	 * @staticvar
	 */ 
	public static $Provider = 'Viacom';
	//public static $Provider = 'testtvprovider';
	//For test purposes should change line 48 of ITunesXmlCreator
	
	/**
	 * The transportation service
	 * @var			string 
	 */
	public static $Service = 'Aspera';
	//public static $Service = 'Signiant';
	
	/**
	 * The verbosity of the output
	 * @var			string 
	 */
	public static $Verbose = 'eXtreme';
	//public static $Verbose = 'critical';
	
	/**
	 * The ITMS user
	 * @var			string
	 * @staticvar
	 */
	protected static $User = 'fcs_idmo@mtvne.com';
	
	/**
	 * The ITMS user password
	 * @var			string
	 * @staticvar
	 */
	protected static $Password = 'finalcut321';

	/**
	 * The ITMS client command
	 * @var			string
	 * @staticvar
	 */
	protected static $ClientCommand = '/usr/local/itms/bin/iTMSTransporter';
	
	/**
	 * The expected ITMS success message 
	 * @var			string
	 * @staticvar
	 */
	protected static $SuccessMessage = 'packages were uploaded successfully:';
	
	/**
	 * The expected ITMS error message
	 * @var			string
	 * @staticvar
	 */
	protected static $ErrorMessage = '1 package(s) were not uploaded';
	
	/**
	 * Overwrites the properties of $bundleOne with $bundleTwo not empty values.
	 * 
	 * @param		array|string		$files
	 */
	public static function PackageFiles($files){
		$fileInfo = File::GetInfo($files['binary']);
		$itmspPath = $fileInfo['parent_folder'].'/'.$fileInfo['name'].'.itmsp';
		if (!is_dir($itmspPath)){
			if(mkdir($itmspPath)){
				chmod($itmspPath, 0775);
			}
		}
		rename($files['xml'], $itmspPath.'/metadata.xml');
		rename($files['binary'], $itmspPath.'/'.$fileInfo['full_name']);
		if(file_exists($itmspPath.'/metadata.xml') && file_exists($itmspPath.'/'.$fileInfo['full_name'])){
			chmod($itmspPath.'/metadata.xml', 0775);
			chmod($itmspPath.'/'.$fileInfo['full_name'], 0775);
			if(file_exists($files['xml'])){
				unlink($files['xml']);
			}
			if(file_exists($files['binary'])){
				unlink($files['binary']);
			}
		} else {
			throw new Exception('ITMSP folder creation failed');
		}
	}
	
	/**
	 * Uses the ITMS app to transport iTunes packages.
	 * 
	 * @param	Bundle	$bundle
	 * @param	bool	$isRemote
	 * @return 	bool
	 * @static
	 */
	public static function Upload($bundle, $isRemote=false){
		//TODO: Check if it's the best way to find the file name
		$itmspName = File::GetNameWithoutExtension($bundle->getVideo()->getFileName()) . '.itmsp' ;
		$itmspPath = $isRemote ? REMOTE_INBOX.'transportation/itunesdto/'.$itmspName : LOCAL_INBOX_TRANSPORTATION.'itunesdto/'.$itmspName;
		$command = self::$ClientCommand.' -m upload -f '.$itmspPath;
		$command .= ' -u '.self::$User.' -p '.self::$Password.' -v ';
		$command .= self::$Verbose .' -s ' . self::$Provider . ' -t ' . self::$Service . ' -k 300000';
		echo 'Running: '.$command."\n\n";
		$lines = array();
		if($isRemote){
			$ssh = new Ssh2(REMOTE_SERVER_IP);
			if ($ssh->auth(REMOTE_SERVER_USER, REMOTE_SERVER_PASS)) {
				$output = $ssh->exec($command);
				$lines = explode("\n", $output['output']);
			} else {
				throw new Exception('An error has ocurred during the authentication. ITunesTransporter::Upload().');
			}
		} else {
			exec($command, $lines);
		}
		return self::ParseClientOutput($lines);
	}
	
	/**
	 * Parses the upload application output to know if the process success or fails.
	 * 
	 * @param	string	$folderName
	 * @return 	bool
	 * @static
	 */
	protected static function ParseClientOutput($outputLines){
		$success = false;
		foreach ($outputLines as $line){
			if(strpos(trim($line), self::$SuccessMessage)){
				$success = true;
				break;
			}
		}
		if(!$success){
			//TODO: improve the error parsing
			foreach ($outputLines as $line){
				$arrayError = explode('ERROR ITMS-', $line);
			}
		}
		return $success;
	}
}