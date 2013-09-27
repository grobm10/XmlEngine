<?php

/**
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/MTV/Transporters/XboxTransporter.php
 */
class XboxTransporter extends AbstractTransporter {
	
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
	protected static $Authentication = 'ASPERA_SCP_PASS=\!JgKpNn%';
	
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
	 * Uses the ASCP app to transport Xbox packages.
	 * 
	 * @param	Bundle	$bundle
	 * @param	bool	$isRemote
	 * @return 	bool
	 * @static
	 */
	public static function Upload($bundle, $isRemote=false){
		//TODO: add the remove after success option to aspera when transporting the binary
		//TODO: Check if it's the best way to find the file name
		$xmlName = File::GetNameWithoutExtension($bundle->getVideo()->getFileName()) . '.xml' ;
		$binaryName = $bundle->getVideo()->getFileName();
		$seasonId = $bundle->getVideo()->getMetadata()->getDTOSeasonID();
		$xboxFolder = $isRemote ? REMOTE_INBOX.'transportation/xboxdto/' : LOCAL_INBOX_TRANSPORTATION.'xboxdto/';
		$command1 = $command2 = self::$Authentication.' '.self::$ClientCommand.' -QT -k2 -d -l 45M -L '.$xboxFolder.'logs/';
		$command1 .= ' '.$xboxFolder.$xmlName.' '.self::$User.'@'.self::$Host.':'.$seasonId;
		$command2 .= ' '.$xboxFolder.$binaryName.' '.self::$User.'@'.self::$Host.':'.$seasonId;
		echo 'Running: '.$command1."\n\n";
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
				throw new Exception('An error has ocurred during the authentication. XboxTransporter::Upload().');
			}
		} else {
			exec($command1, $lines);
			if(self::ParseClientOutput($lines)){
				exec($command2, $lines);
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
		Debug::Show($outputLines, false);
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
