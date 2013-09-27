<?php

/**
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/MTV/Transporters/StarHubTransporter.php
 */
class StarHubTransporter extends AbstractTransporter {
	
	/**
	 * The ASCP client command
	 * @var			string
	 * @staticvar
	 */
	protected static $ClientCommand = 'ascp';

	/**
	 * The ASCP user
	 * @var			string
	 * @staticvar
	 */
	protected static $User = 'MTVNEurope';
	
	/**
	 * The sindication url
	 * @var			string
	 * @staticvar
	 */
	protected static $Host = '4.71.156.36';
	
	/**
	 * The ASCP host key
	 * @var			string
	 * @staticvar
	 */
	protected static $Authentication = 'ASPERA_SCP_FILEPASS=!JgKpNn%';
	
	/**
	 * The expected ASCP success message 
	 * @var			string
	 * @staticvar
	 */
	protected static $SuccessMessage = 'Completed:';
	
	/**
	 * The expected ASCP error message
	 * @var			string
	 * @staticvar
	 */
	protected static $ErrorMessage = 'Session Stop';
	
	/**
	 * Uses the ASCP app to transport StarHub packages.
	 * 
	 * @param	Bundle	$bundle
	 * @param	bool	$isRemote
	 * @return 	bool
	 * @static
	 */
	public static function Upload($bundle, $isRemote=false){
	
		return false;
	
		//TODO: Check if it's the best way to find the file name
		$xmlName = File::GetNameWithoutExtension($bundle->getVideo()->getFileName()) . '.xml' ;
		$binaryName = $bundle->getVideo()->getFileName();
		$seasonId = $bundle->getVideo()->getMetadata()->getDTOSeasonID();
		$starhubFolder = $isRemote ? REMOTE_INBOX.'transportation/starhubdto/' : LOCAL_INBOX_TRANSPORTATION.'starhubdto/';
		$command1 = $command2 = self::$Authentication.' '.self::$ClientCommand.' -QT -k2 -d -l 45M -L '.$starhubFolder.'logs/';
		$command1 .= ' '.$starhubFolder.$xmlName.' '.self::$User.'@'.self::$Host.':'.$seasonId;
		$command2 .= ' '.$starhubFolder.$binaryName.' '.self::$User.'@'.self::$Host.':'.$seasonId;
		
		
		echo '<pre>';var_dump($command1, $command2);die();
		
		
		$lines = array();
		if($isRemote){
			$ssh = new Ssh2(REMOTE_SERVER_IP);
			if ($ssh->auth(REMOTE_SERVER_USER, REMOTE_SERVER_PASS)) {
				$output = $ssh->exec($command1);
				$lines = explode("\n", $output['output']);
				if(self::ParseClientOutput($lines)){
					$output = $ssh->exec($command2);
					$lines = explode("\n", $output['output']);
					return self::ParseClientOutput($lines);
				} else {
					return false;
				}
			} else {
				throw new Exception('An error has ocurred during the authentication. StarHubTransporter::Upload().');
			}
		} else {
			exec($command1, $lines);
			if(self::ParseClientOutput($lines)){
				$output = $ssh->exec($command2);
				$lines = explode("\n", $output['output']);
				return self::ParseClientOutput($lines);
			} else {
				return false;
			}
		}
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
			if(strpos(trim($line), self::$SuccessMessage) === false){
				$success = true;
				break;
			}
		}
		if(!$success){
			//TODO: improve the error parsing
			foreach ($outputLines as $line){
				$arrayError = explode('error', $line);
			}
		}
		return $success;
	}
}