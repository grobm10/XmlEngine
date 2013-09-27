<?php

require_once '../siteConfig.php';
require_once '../Utils/Bootstrap.php';

FileJoiner::Run();
die();

/**
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/Code/FileJoiner.php
 */
class FileJoiner
{
	/** 
	 * The file that is wirtting right now
	 */
	private static $CurrentFile = '';
	
	/** 
	 * All files contained into the specified folders will be included.
	 */
	private static $TypesToJoin = array(
		'.php' => array(
				'Utils', 
				'Entities', 
				'Models', 
				'Controllers', 
				'Utils'
			),
		'.js' => array(
				'resources/js/controllers',
				'resources/js/entities',
				'resources/js/models',
				'resources/js/utils',
				'resources/js/views'
			)
	);
	
	/** 
	 * Creates the joint files for each type
	 *
	 * @todo	Obfuscate	http://www.refresh-sf.com/yui/#output	http://www.fopo.com.ar/
	 * @todo	Add try catch blocks
	 */
	public static function Run(){
		foreach(self::$TypesToJoin as $type => $foldersToJoin){
			$fileName = ROOT_FOLDER.'Docs/general' . $type;
			self::$CurrentFile = fopen($fileName , 'a') or die("can't open file");
			$initialContent = '// http://www.refresh-sf.com/yui/#output		http://www.fopo.com.ar/' . "\n";
			fwrite(self::$CurrentFile, $initialContent);
			foreach($foldersToJoin as $folderName){
				self::ExtractContents($type, ROOT_FOLDER.$folderName);
			}
			fclose(self::$CurrentFile);
			if(is_file($fileName)){
				chmod($fileName, 0774);
			}
		}
	}
	
	/** 
	 * Looks for all files and foldes inside a folder and extracts the content
	 * from each requested file type
	 *
	 * @param 		string		$type
	 * @param 		string		$folderPath
	 */
	private static function ExtractContents($type, $folderPath){
		try{
			if (is_dir($folderPath)){
				if ($dh = opendir($folderPath)){
					//Make sure that it is a readable file
					while (($file = readdir($dh)) !== false){
						if(($file != '.') && ($file != '..') && ($file != '.svn')){
							$tmpPath = $folderPath . DIR_SEPARATOR . $file;
							if (is_dir($tmpPath)){
								self::ExtractContents($type, $tmpPath);
							} else if(substr($tmpPath, (strlen($type)*(-1))) == $type){
								$fileArray = file($tmpPath);
								foreach ($fileArray as $index => $line) {
									fwrite(self::$CurrentFile, $line);
								}
							}
						}
					}
					closedir($dh);
				}
			}
		} catch(Exception $e){
			throw new Exception($e);
		}
		return;
	}
}
