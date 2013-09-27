<?php

//die('Comment this line to use the ProjectGenerator.php file');
require '../../siteConfig.php';
require '../Bootstrap.php';

Bootstrap::SetRequiredFiles();
ProjectGenerator::Run();
die();

/**
 * @author			David Curras
 * @version			Obctober 3, 2012
 * @filesource		/Utils/Code/ProjectGenerator.php
 */
class ProjectGenerator {
	
	/**
	 * The Author name
	 * 
	 * @var		string
	 */
	public static $Author = '';
	
	/**
	 * The data base name
	 * 
	 * @var		string
	 */
	public static $DbName = '';
	
	/**
	 * The folder basic structure for the project
	 * 
	 * @var		array
	 */
	public static $Folders = array();
	
	/**
	 * The entities that represent the Object Model Classes
	 * 
	 * @var		array
	 */
	public static $Entities = array();
	
	/**
	 * The entries to be inserted in the data base
	 * 
	 * @var		array
	 */
	public static $Inserts = array();
	
	/**
	 * This function handles the process
	 *
	 * @static
	 */
	public static function Run(){
		self::LoadInitialValues();
		self::CreateFolders(ROOT_FOLDER, self::$Folders);
		self::CreateSqlStructure();
		self::CreatePhpClasses();
		self::CreatePhpModels();
		self::CreateJsClasses();
		self::CreateJsModels();
	}
	
	/**
	 * Loads the folders structure and other initial values
	 *
	 * @static
	 */
	public static function LoadInitialValues(){
		self::$Author = 'David Curras';
		self::$DbName = 'xmle_dev';
		self::$Folders = Xml::XmlFileToObject(ROOT_FOLDER.'/Docs/folders.xml');
		self::$Entities = Xml::XmlFileToObject(ROOT_FOLDER.'/Docs/entities.xml');
		self::$Inserts = Xml::XmlFileToObject(ROOT_FOLDER.'/Docs/inserts.xml');
	}
	
	/**
	 * Checks the basic folder structure and fix it if needed
	 *
	 * @var			string 				$root
	 * @var 		array|string		$folderStructure
	 * @static
	 */
	public static function CreateFolders($root, $folders){
		foreach($folders as $folder){
			$folderName = $root . $folder['name'];
			if (!is_dir($folderName)){
				if(mkdir($folderName)){
					echo '<b>Folder created:</b> ' . $folderName;
					if(chmod($folderName, 0775)){
						echo ' - <b>Premissions 0775 added</b>.';
					}
					echo '<br />';
				}
			}
			self::CreateFolders($folderName.'/', $folder);
		}
		echo '<br />Folders for '.$root.' created.<hr /><br />';
	}
	
	/**
	 * Creates the sql tables structure and triggers the sql code generator
	 *
	 * @static
	 */
	public static function CreateSqlStructure(){
		SqlGenerator::LoadInitialValues(ROOT_FOLDER.'Docs/');
		SqlGenerator::Run();
		echo '<br /><hr /><br />';
	}
	
	/**
	 * Creates the php classes structure and triggers the php class generator
	 *
	 * @static
	 */
	public static function CreatePhpClasses(){
		PhpClassGenerator::LoadInitialValues(ROOT_FOLDER.'Entities/');
		PhpClassGenerator::Run();
		echo '<br /><hr /><br />';
	}
	
	/**
	 * Creates the php model classes structure and triggers the php model generator
	 *
	 * @static
	 */
	public static function CreatePhpModels(){
		PhpModelGenerator::LoadInitialValues(ROOT_FOLDER.'Models/');
		PhpModelGenerator::Run();
		echo '<br /><hr /><br />';
	}
	
	/**
	 * Creates the js classes structure and triggers the js class generator
	 *
	 * @static
	 */
	public static function CreateJsClasses(){
		JsClassGenerator::LoadInitialValues(ROOT_FOLDER.'resources/js/entities/');
		JsClassGenerator::Run();
		echo '<br /><hr /><br />';
	}
	
	/**
	 * Creates the js model classes structure and triggers the js model generator
	 *
	 * @static
	 */
	public static function CreateJsModels(){
		JsModelGenerator::LoadInitialValues(ROOT_FOLDER.'resources/js/models/');
		JsModelGenerator::Run();
		echo '<br /><hr /><br />';
	}
}
