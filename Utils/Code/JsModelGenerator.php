<?php

/**
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/Code/JsModelGenerator.php
 */
class JsModelGenerator {

	/**
	 * The folder path where the .js file will be created
	 *
	 * @var		string
	 */
	protected static $Folder = array();

	/**
	 * The output code
	 *
	 * @var		string
	 */
	protected static $Code = array();
	
	/**
	 * Loads the classes and other initial values
	 *
	 * @param		string		$author
	 * @param		array		$models
	 * @param		string		$folder
	 * @static
	 */
	public static function LoadInitialValues($folder){
		self::$Folder = $folder;
	}
	
	/**
	 * This function handles the process
	 *
	 * @static
	 */
	public static function Run(){
		foreach(ProjectGenerator::$Entities as $entity){
			$class = (string) $entity['name'];
			self::CreateHeader($class);
			self::CreateSave($class);
			self::CreateFindById($class);
			self::CreateFindBy($class);
			self::CreateFindByMultipleValues($class);
			self::CreateFindByInnerObjectProperties($class, $entity);
			self::CreateFetchAll($class);
			self::CreateSearch($class);
			self::CreateGetCount($class);
			self::CreateFile($class);
		}
	}
	
	/**
	 * Creates the header
	 *
	 * @param		string		$class
	 * @static
	 */
	public static function CreateHeader($class){
		self::$Code = '/**' . "\n";
		self::$Code .= ' * This class  performs server queries for ' . $class . "\n";
		self::$Code .= ' *' . "\n";
		self::$Code .= ' * @author' . "\t\t" . ProjectGenerator::$Author . "\n";
		self::$Code .= ' * @version' . "\t\t" . date("F j, Y"). "\n";
		self::$Code .= ' */' . "\n";
		self::$Code .= 'var ' . $class . 'Model = function(){ };' . "\n\n";
	}
	
	/**
	 * Creates the Save method
	 *
	 * @param		string		$class
	 * @static
	 */
	public static function CreateSave($class){
		self::$Code .= '/**' . "\n";
		self::$Code .= ' * Saves a ' . $class . ' in the server'. "\n";
		self::$Code .= ' *' . "\n";
		self::$Code .= ' * @param' . "\t\t" . $class . "\t\t\t" . lcfirst($class) . "\n";
		self::$Code .= ' * @param' . "\t\t" . 'function' . "\t\t" . 'uiFunction' . "\n";
		self::$Code .= ' * @param' . "\t\t" . 'object' . "\t\t\t" . 'uiExtraParams' . "\n";
		self::$Code .= ' * @static' . "\n";
		self::$Code .= ' */' . "\n";
		self::$Code .= $class . 'Model.Save = function('. lcfirst($class) .', uiFunction, uiExtraParams){' . "\n";
		self::$Code .= "\t" . 'var ajaxParams = {' . "\n";
		self::$Code .= "\t\t" . "obj : '". lcfirst($class) ."'," . "\n";
		self::$Code .= "\t\t" . "action : 'save'," . "\n";
		self::$Code .= "\t\t" . 'params : '. lcfirst($class) . "\n";
		self::$Code .= "\t" . '};' . "\n";
		self::$Code .= "\t" . 'var callbackFunction = function(data, callbackExtraParams){' . "\n";
		self::$Code .= "\t\t\t" . 'if(data){' . "\n";
		self::$Code .= "\t\t\t\t" . 'uiFunction(data, callbackExtraParams);' . "\n";
		self::$Code .= "\t\t\t" . '} else {' . "\n";
		self::$Code .= "\t\t\t\t" . 'console.error("Unable to parse server response.'. $class .'Model.Save()");' . "\n";
		self::$Code .= "\t\t\t" . '}' . "\n";
		self::$Code .= "\t\t" . '};' . "\n";
		self::$Code .= "\t" . 'Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);' . "\n";
		self::$Code .= '};' . "\n\n";
	}
	
	/**
	 * Creates the FindById method
	 *
	 * @param		string		$class
	 * @static
	 */
	public static function CreateFindById($class){
		self::$Code .= '/**' . "\n";
		self::$Code .= ' * Retrieves a ' . $class . ' from the server and gives it to the callback function'. "\n";
		self::$Code .= ' *' . "\n";
		self::$Code .= ' * @param' . "\t\t" . 'int' . "\t\t\t\t" . lcfirst($class) . 'Id' . "\n";
		self::$Code .= ' * @param' . "\t\t" . 'function' . "\t\t" . 'uiFunction' . "\n";
		self::$Code .= ' * @param' . "\t\t" . 'object' . "\t\t\t" . 'uiExtraParams' . "\n";
		self::$Code .= ' * @static' . "\n";
		self::$Code .= ' */' . "\n";
		self::$Code .= $class . 'Model.FindById = function('. lcfirst($class) .'Id, uiFunction, uiExtraParams){' . "\n";
		self::$Code .= "\t" . 'var ajaxParams = {' . "\n";
		self::$Code .= "\t\t" . "obj : '". lcfirst($class) ."'," . "\n";
		self::$Code .= "\t\t" . "action : 'FindById'," . "\n";
		self::$Code .= "\t\t" . 'params : ' . lcfirst($class) . 'Id' . "\n";
		self::$Code .= "\t" . '};' . "\n";
		self::$Code .= "\t" . 'var callbackFunction = function(data, callbackExtraParams){' . "\n";
		self::$Code .= "\t\t\t" . 'if(data){' . "\n";
		self::$Code .= "\t\t\t\t" . 'var genericObject = JSON.parse(data);' . "\n";
		self::$Code .= "\t\t\t\t" . 'uiFunction(new ' . $class . '(genericObject), callbackExtraParams);' . "\n";
		self::$Code .= "\t\t\t" . '} else {' . "\n";
		self::$Code .= "\t\t\t\t" . 'console.error("Unable to parse server response.'. $class .'Model.FindById()");' . "\n";
		self::$Code .= "\t\t\t" . '}' . "\n";
		self::$Code .= "\t\t" . '};' . "\n";
		self::$Code .= "\t" . 'Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);' . "\n";
		self::$Code .= '};' . "\n\n";
	}
	
	/**
	 * Creates the FindBy method
	 *
	 * @param		string		$class
	 * @static
	 */
	public static function CreateFindBy($class){
		self::$Code .= '/**' . "\n";
		self::$Code .= ' * Retrieves ' . $class . 's from the server that matches the queryParams'. "\n";
		self::$Code .= ' * filters and gives it to the callback function'. "\n";
		self::$Code .= ' *' . "\n";
		self::$Code .= ' * @param' . "\t\t" . 'object' . "\t\t\t" . 'queryParams' . "\n";
		self::$Code .= ' * @param' . "\t\t" . 'function' . "\t\t" . 'uiFunction' . "\n";
		self::$Code .= ' * @param' . "\t\t" . 'object' . "\t\t\t" . 'uiExtraParams' . "\n";
		self::$Code .= ' * @static' . "\n";
		self::$Code .= ' */' . "\n";
		self::$Code .= $class . 'Model.FindBy = function(queryParams, uiFunction, uiExtraParams){' . "\n";
		self::$Code .= "\t" . 'var ajaxParams = {' . "\n";
		self::$Code .= "\t\t" . "obj : '". lcfirst($class) ."'," . "\n";
		self::$Code .= "\t\t" . "action : 'FindBy'," . "\n";
		self::$Code .= "\t\t" . 'params : queryParams' . "\n";
		self::$Code .= "\t" . '};' . "\n";
		self::$Code .= "\t" . 'var callbackFunction = function(data, callbackExtraParams){' . "\n";
		self::$Code .= "\t\t\t" . 'if(data){' . "\n";
		self::$Code .= "\t\t\t\t" . 'var genericObjectsArray = JSON.parse(data);' . "\n";
		self::$Code .= "\t\t\t\t" . 'var '. lcfirst($class) .'sArray = new Array();' . "\n";
		self::$Code .= "\t\t\t\t" . '$.each(genericObjectsArray, function(index, genericObject){' . "\n";
		self::$Code .= "\t\t\t\t\t" . lcfirst($class) .'sArray.push(new '. $class .'(genericObject));' . "\n";
		self::$Code .= "\t\t\t\t" . '});' . "\n";
		self::$Code .= "\t\t\t\t" . 'uiFunction('. lcfirst($class) .'sArray, callbackExtraParams);' . "\n";
		self::$Code .= "\t\t\t" . '} else {' . "\n";
		self::$Code .= "\t\t\t\t" . 'console.error("Unable to parse server response.'. $class .'Model.FindBy()");' . "\n";
		self::$Code .= "\t\t\t" . '}' . "\n";
		self::$Code .= "\t\t" . '};' . "\n";
		self::$Code .= "\t" . 'Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);' . "\n";
		self::$Code .= '};' . "\n\n";
	}
	
	/**
	 * Creates the FindByMultipleValues method
	 *
	 * @param		string		$class
	 * @static
	 */
	public static function CreateFindByMultipleValues($class){
		self::$Code .= '/**' . "\n";
		self::$Code .= ' * Retrieves ' . $class . 's from the server that matches the queryParams'. "\n";
		self::$Code .= ' * filters and gives it to the callback function'. "\n";
		self::$Code .= ' *' . "\n";
		self::$Code .= ' * @param' . "\t\t" . 'object' . "\t\t\t" . 'queryParams' . "\n";
		self::$Code .= ' * @param' . "\t\t" . 'function' . "\t\t" . 'uiFunction' . "\n";
		self::$Code .= ' * @param' . "\t\t" . 'object' . "\t\t\t" . 'uiExtraParams' . "\n";
		self::$Code .= ' * @static' . "\n";
		self::$Code .= ' */' . "\n";
		self::$Code .= $class . 'Model.FindByMultipleValues = function(queryParams, uiFunction, uiExtraParams){' . "\n";
		self::$Code .= "\t" . 'var ajaxParams = {' . "\n";
		self::$Code .= "\t\t" . "obj : '". lcfirst($class) ."'," . "\n";
		self::$Code .= "\t\t" . "action : 'FindByMultipleValues'," . "\n";
		self::$Code .= "\t\t" . 'params : queryParams' . "\n";
		self::$Code .= "\t" . '};' . "\n";
		self::$Code .= "\t" . 'var callbackFunction = function(data, callbackExtraParams){' . "\n";
		self::$Code .= "\t\t\t" . 'if(data){' . "\n";
		self::$Code .= "\t\t\t\t" . 'var genericObjectsArray = JSON.parse(data);' . "\n";
		self::$Code .= "\t\t\t\t" . 'var '. lcfirst($class) .'sArray = new Array();' . "\n";
		self::$Code .= "\t\t\t\t" . '$.each(genericObjectsArray, function(index, genericObject){' . "\n";
		self::$Code .= "\t\t\t\t\t" . lcfirst($class) .'sArray.push(new '. $class .'(genericObject));' . "\n";
		self::$Code .= "\t\t\t\t" . '});' . "\n";
		self::$Code .= "\t\t\t\t" . 'uiFunction('. lcfirst($class) .'sArray, callbackExtraParams);' . "\n";
		self::$Code .= "\t\t\t" . '} else {' . "\n";
		self::$Code .= "\t\t\t\t" . 'console.error("Unable to parse server response.'. $class .'Model.FindByMultipleValues()");' . "\n";
		self::$Code .= "\t\t\t" . '}' . "\n";
		self::$Code .= "\t\t" . '};' . "\n";
		self::$Code .= "\t" . 'Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);' . "\n";
		self::$Code .= '};' . "\n\n";
	}
	
	/**
	 * Creates the FindByInnerObjectProperties methods
	 *
	 * @param		string				$class
	 * @param		array|string		$innerObjects
	 * @static
	 */
	public static function CreateFindByInnerObjectProperties($class, $entity){
		foreach($entity->fields->field as $field){
			$fieldType = (string)$field['type'];
			if((strtoupper($fieldType) != 'STRING') && (strtoupper($fieldType) != 'TEXT') && (strtoupper($fieldType) != 'INT') && (strtoupper($fieldType) != 'FLOAT') && (strtoupper($fieldType) != 'BOOL') && (strtoupper($fieldType) != 'DATE')){
				self::$Code .= '/**' . "\n";
				self::$Code .= ' * Retrieves ' . $class . 's from the server that matches the queryParams'. "\n";
				self::$Code .= ' * filters and gives it to the callback function'. "\n";
				self::$Code .= ' *' . "\n";
				self::$Code .= ' * @param' . "\t\t" . 'object' . "\t\t\t" . 'queryParams' . "\n";
				self::$Code .= ' * @param' . "\t\t" . 'function' . "\t\t" . 'uiFunction' . "\n";
				self::$Code .= ' * @param' . "\t\t" . 'object' . "\t\t\t" . 'uiExtraParams' . "\n";
				self::$Code .= ' * @static' . "\n";
				self::$Code .= ' */' . "\n";
				self::$Code .= $class . 'Model.FindBy'.ucfirst($fieldType).'Properties = function(queryParams, uiFunction, uiExtraParams){' . "\n";
				self::$Code .= "\t" . 'var ajaxParams = {' . "\n";
				self::$Code .= "\t\t" . "obj : '". lcfirst($class) ."'," . "\n";
				self::$Code .= "\t\t" . 'action : \'FindBy'.ucfirst($fieldType).'Properties\',' . "\n";
				self::$Code .= "\t\t" . 'params : queryParams' . "\n";
				self::$Code .= "\t" . '};' . "\n";
				self::$Code .= "\t" . 'var callbackFunction = function(data, callbackExtraParams){' . "\n";
				self::$Code .= "\t\t\t" . 'if(data){' . "\n";
				self::$Code .= "\t\t\t\t" . 'var genericObjectsArray = JSON.parse(data);' . "\n";
				self::$Code .= "\t\t\t\t" . 'var '. lcfirst($class) .'sArray = new Array();' . "\n";
				self::$Code .= "\t\t\t\t" . '$.each(genericObjectsArray, function(index, genericObject){' . "\n";
				self::$Code .= "\t\t\t\t\t" . lcfirst($class) .'sArray.push(new '. $class .'(genericObject));' . "\n";
				self::$Code .= "\t\t\t\t" . '});' . "\n";
				self::$Code .= "\t\t\t\t" . 'uiFunction('. lcfirst($class) .'sArray, callbackExtraParams);' . "\n";
				self::$Code .= "\t\t\t" . '} else {' . "\n";
				self::$Code .= "\t\t\t\t" . 'console.error("Unable to parse server response.'. $class .'Model.FindBy'.ucfirst($fieldType).'Properties()");' . "\n";
				self::$Code .= "\t\t\t" . '}' . "\n";
				self::$Code .= "\t\t" . '};' . "\n";
				self::$Code .= "\t" . 'Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);' . "\n";
				self::$Code .= '};' . "\n\n";
			}
		}
	}
	
	/**
	 * Creates the FetchAll method
	 *
	 * @param		string		$class
	 * @static
	 */
	public static function CreateFetchAll($class){
		self::$Code .= '/**' . "\n";
		self::$Code .= ' * Retrieves all ' . $class . 's from the server and gives it to the callback function'. "\n";
		self::$Code .= ' *' . "\n";
		self::$Code .= ' * @param' . "\t\t" . 'object' . "\t\t\t" . 'queryParams' . "\n";
		self::$Code .= ' * @param' . "\t\t" . 'function' . "\t\t" . 'uiFunction' . "\n";
		self::$Code .= ' * @param' . "\t\t" . 'object' . "\t\t\t" . 'uiExtraParams' . "\n";
		self::$Code .= ' * @static' . "\n";
		self::$Code .= ' */' . "\n";
		self::$Code .= $class . 'Model.FetchAll = function(queryParams, uiFunction, uiExtraParams){' . "\n";
		self::$Code .= "\t" . 'var ajaxParams = {' . "\n";
		self::$Code .= "\t\t" . "obj : '". lcfirst($class) ."'," . "\n";
		self::$Code .= "\t\t" . "action : 'FetchAll'," . "\n";
		self::$Code .= "\t\t" . 'params : queryParams' . "\n";
		self::$Code .= "\t" . '};' . "\n";
		self::$Code .= "\t" . 'var callbackFunction = function(data, callbackExtraParams){' . "\n";
		self::$Code .= "\t\t\t" . 'if(data){' . "\n";
		self::$Code .= "\t\t\t\t" . 'var genericObjectsArray = JSON.parse(data);' . "\n";
		self::$Code .= "\t\t\t\t" . 'var '. lcfirst($class) .'sArray = new Array();' . "\n";
		self::$Code .= "\t\t\t\t" . '$.each(genericObjectsArray, function(index, genericObject){' . "\n";
		self::$Code .= "\t\t\t\t\t" . lcfirst($class) .'sArray.push(new '. $class .'(genericObject));' . "\n";
		self::$Code .= "\t\t\t\t" . '});' . "\n";
		self::$Code .= "\t\t\t\t" . 'uiFunction('. lcfirst($class) .'sArray, callbackExtraParams);' . "\n";
		self::$Code .= "\t\t\t" . '} else {' . "\n";
		self::$Code .= "\t\t\t\t" . 'console.error("Unable to parse server response.'. $class .'Model.FetchAll()");' . "\n";
		self::$Code .= "\t\t\t" . '}' . "\n";
		self::$Code .= "\t\t" . '};' . "\n";
		self::$Code .= "\t" . 'Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);' . "\n";
		self::$Code .= '};' . "\n\n";
	}
	
	/**
	 * Creates the Search method
	 *
	 * @param		string		$class
	 * @static
	 */
	public static function CreateSearch($class){
		self::$Code .= '/**' . "\n";
		self::$Code .= ' * Retrieves all ' . $class . 's from the server that matches'. "\n";
		self::$Code .= ' * the searchText and gives it to the callback function'. "\n";
		self::$Code .= ' *' . "\n";
		self::$Code .= ' * @param' . "\t\t" . 'object' . "\t\t\t" . 'queryParams' . "\n";
		self::$Code .= ' * @param' . "\t\t" . 'function' . "\t\t" . 'uiFunction' . "\n";
		self::$Code .= ' * @param' . "\t\t" . 'object' . "\t\t\t" . 'uiExtraParams' . "\n";
		self::$Code .= ' * @static' . "\n";
		self::$Code .= ' */' . "\n";
		self::$Code .= $class . 'Model.Search = function(queryParams, uiFunction, uiExtraParams){' . "\n";
		self::$Code .= "\t" . 'var ajaxParams = {' . "\n";
		self::$Code .= "\t\t" . "obj : '". lcfirst($class) ."'," . "\n";
		self::$Code .= "\t\t" . "action : 'Search'," . "\n";
		self::$Code .= "\t\t" . 'params : queryParams' . "\n";
		self::$Code .= "\t" . '};' . "\n";
		self::$Code .= "\t" . 'var callbackFunction = function(data, callbackExtraParams){' . "\n";
		self::$Code .= "\t\t\t" . 'if(data){' . "\n";
		self::$Code .= "\t\t\t\t" . 'var genericObjectsArray = JSON.parse(data);' . "\n";
		self::$Code .= "\t\t\t\t" . 'var '. lcfirst($class) .'sArray = new Array();' . "\n";
		self::$Code .= "\t\t\t\t" . '$.each(genericObjectsArray, function(index, genericObject){' . "\n";
		self::$Code .= "\t\t\t\t\t" . lcfirst($class) .'sArray.push(new '. $class .'(genericObject));' . "\n";
		self::$Code .= "\t\t\t\t" . '});' . "\n";
		self::$Code .= "\t\t\t\t" . 'uiFunction('. lcfirst($class) .'sArray, callbackExtraParams);' . "\n";
		self::$Code .= "\t\t\t" . '} else {' . "\n";
		self::$Code .= "\t\t\t\t" . 'console.error("Unable to parse server response.'. $class .'Model.Search()");' . "\n";
		self::$Code .= "\t\t\t" . '}' . "\n";
		self::$Code .= "\t\t" . '};' . "\n";
		self::$Code .= "\t" . 'Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);' . "\n";
		self::$Code .= '};';
	}
	
	/**
	 * Creates the GetCount method
	 *
	 * @param		string		$class
	 * @static
	 */
	public static function CreateGetCount($class){
		self::$Code .= '/**' . "\n";
		self::$Code .= ' * Retrieves the number of '.ucfirst($class).' stored in the server'. "\n";
		self::$Code .= ' *' . "\n";
		self::$Code .= ' * @param' . "\t\t" . 'object' . "\t\t\t" . 'queryParams' . "\n";
		self::$Code .= ' * @param' . "\t\t" . 'function' . "\t\t" . 'uiFunction' . "\n";
		self::$Code .= ' * @param' . "\t\t" . 'object' . "\t\t\t" . 'uiExtraParams' . "\n";
		self::$Code .= ' * @static' . "\n";
		self::$Code .= ' */' . "\n";
		self::$Code .= $class . 'Model.GetCount = function(queryParams, uiFunction, uiExtraParams){' . "\n";
		self::$Code .= "\t" . 'var ajaxParams = {' . "\n";
		self::$Code .= "\t\t" . "obj : '". lcfirst($class) ."'," . "\n";
		self::$Code .= "\t\t" . "action : 'GetCount'," . "\n";
		self::$Code .= "\t\t" . 'params : queryParams' . "\n";
		self::$Code .= "\t" . '};' . "\n";
		self::$Code .= "\t" . 'var callbackFunction = function(data, callbackExtraParams){' . "\n";
		self::$Code .= "\t\t\t" . 'if(data){' . "\n";
		self::$Code .= "\t\t\t\t" . 'var '. lcfirst($class) .'Count = parseInt(data.replace(\'"\',\'\'));' . "\n";
		self::$Code .= "\t\t\t\t" . 'uiFunction('. lcfirst($class) .'Count, callbackExtraParams);' . "\n";
		self::$Code .= "\t\t\t" . '} else {' . "\n";
		self::$Code .= "\t\t\t\t" . 'console.error("Unable to parse server response.'. $class .'Model.GetCount()");' . "\n";
		self::$Code .= "\t\t\t" . '}' . "\n";
		self::$Code .= "\t\t" . '};' . "\n";
		self::$Code .= "\t" . 'Ajax.Perform(ajaxParams, callbackFunction, uiExtraParams);' . "\n";
		self::$Code .= '};';
	}
	
	/**
	 * Creates the .js file
	 *
	 * @param		string		$class
	 * @static
	 */
	public static function CreateFile($class){
		$fileName = self::$Folder . $class . 'Model.js';
		$fh = fopen($fileName , 'w') or die("can't open file");
		fwrite($fh, self::$Code);
		fclose($fh);
		if(is_file($fileName)){
			chmod($fileName, 0774);
		}
		echo '<b>File created:</b>' . $fileName . '<br />';
	}
}