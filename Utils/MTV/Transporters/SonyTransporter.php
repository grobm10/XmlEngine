<?php

/**
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/MTV/Transporters/SonyTransporter.php
 */
class SonyTransporter extends AbstractTransporter {
	
	/**
	 * The ITMS client command
	 * @var			string
	 * @staticvar
	 */
	protected static $ClientCommand = 'ascp';
	
	/**
	 * The ASCP user
	 * @var			string
	 * @staticvar
	 */
	protected static $User = 'mtv_ny2';
	
	/**
	 * The sindication url
	 * @var			string
	 * @staticvar
	 */
	protected static $Host = 'aspera-drop.smss.sony.com';
	
	/**
	 * The ASCP host key
	 * @var			string
	 * @staticvar
	 */
	//protected static $Authentication = '/Library/Aspera/etc/SSHKeys/mtv_drop2 --ignore-host-key';	
	protected static $Authentication = '/opt/aspera/etc/SSHKeys/mtv_drop2 --ignore-host-key';
	
	/**
	 * The expected ITMS success message 
	 * @var			string
	 * @staticvar
	 */
	protected static $SuccessMessage = 'Completed:';
	
	/**
	 * The expected ITMS error message
	 * @var			string
	 * @staticvar
	 */
	protected static $ErrorMessage = 'Session Stop';
	
	/**
	 * Uses the ITMS app to transport Sony packages.
	 * 
	 * @param	Bundle	$bundle
	 * @param	bool	$isRemote
	 * @return 	bool
	 * @static
	 */
	public static function Upload($bundle, $isRemote=false){
		//TODO: add the remove after success option to aspera when transporting the binary
		//TODO: Check if it's the best way to find the file name
		echo '<pre>';
		$xmlName = File::GetNameWithoutExtension($bundle->getVideo()->getFileName()) . '.xml' ;
		$binaryName = $bundle->getVideo()->getFileName();
		$seasonId = $bundle->getVideo()->getMetadata()->getDTOSeasonID();
		$sonyFolder = $isRemote ? REMOTE_INBOX.'transportation/sonydto/' : LOCAL_INBOX_TRANSPORTATION.'sonydto/';
		$command1 = $command2 = self::$ClientCommand.' -QT -k2 -d -l 45M -i '.self::$Authentication.' -L '.$sonyFolder.'logs/';
		$command1 .= ' '.$sonyFolder.$xmlName.' '.self::$User.'@'.self::$Host.':'.$seasonId;
		$command2 .= ' '.$sonyFolder.$binaryName.' '.self::$User.'@'.self::$Host.':'.$seasonId;
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
				throw new Exception('An error has ocurred during the authentication. SonyTransporter::Upload().');
			}
		} else {
			exec($command1, $lines);
			var_dump($lines);
			echo '<hr /><hr />Running: '.$command2."\n\n";
			if(self::ParseClientOutput($lines)){
				exec($command2, $lines);
				var_dump($lines);
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
