<?php

/**
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/Bootstrap.php
 */
class Bootstrap
{
	/** 
	 * All files contained into the specified folders will be included.
	 * Must be ordered by priority.
	 */
	private static $FoldersToInclude = array(
			'Utils',
			'Entities',
			'Models',
			'Controllers'
		);
	
	/** 
	 * Perform include_once for all required php files
	 */
	public static function SetRequiredFiles(){
		foreach(self::$FoldersToInclude as $folderName){		
			$arrayPath = array();
			self::FindFiles($arrayPath, ROOT_FOLDER.$folderName);
			sort($arrayPath);
			foreach($arrayPath as $file){
				if(!in_array($file, self::GetFilesToExclude())){
					require_once $file;
				}
			}
		}
	}
	
	/** 
	 * Looks for all files and foldes inside a folder and fill the array given by ref
	 * This feature lookup recursively into subfolders
	 *
	 * @param 	Array|string 	$arrayPath
	 * @param 	string 			$folderPath
	 */
	private static function FindFiles(&$arrayPath, $folderPath)
	{
		try{
			if (is_dir($folderPath)){
				if ($dh = opendir($folderPath)){
					//Make sure it is a readable file
					while (($file = readdir($dh)) !== false){
						if(($file != '.') && ($file != '..') && ($file != '.svn')){
							$tmpPath = $folderPath . DIR_SEPARATOR . $file;
							if (is_dir($tmpPath)){
								self::FindFiles($arrayPath, $tmpPath);
							} else if(substr($tmpPath, -4) == '.php'){
								array_push($arrayPath, $tmpPath);
							}
						}
					}
					closedir($dh);
				}
			}
		} catch(Exception $e){
			throw new Exception($e);
		}
		return ;
	}
	
	/** 
	 * Returns files to be exculded
	 *
	 * @return	Array|string
	 */
	private static function GetFilesToExclude(){
		$filesToExclude = array(
			ROOT_FOLDER.'Utils'.DIR_SEPARATOR.'Bootstrap.php',
			ROOT_FOLDER.'Utils'.DIR_SEPARATOR.'Code'.DIR_SEPARATOR.'FileJoiner.php',
			ROOT_FOLDER.'Utils'.DIR_SEPARATOR.'Code'.DIR_SEPARATOR.'ProjectGenerator.php',
			ROOT_FOLDER.'Utils'.DIR_SEPARATOR.'Code'.DIR_SEPARATOR.'SqlInsertsToXml.php',
			ROOT_FOLDER.'Utils'.DIR_SEPARATOR.'Server'.DIR_SEPARATOR.'Ajax.php'
		);
		return $filesToExclude;
	}
}
