<?php

/**
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/Code/JsClassGenerator.php
 */
class JsClassGenerator {

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
	 * Loads the folders class and other initial values
	 *
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
			self::CreateProperties($entity);
			self::CreateConstructor($entity);
			self::CreateSetters($class, $entity);
			self::CreateGetters($entity);
			self::CreateConvertToArray($entity);
			self::CreateReturn($entity);
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
		self::$Code .= ' * This class represents a ' . $class . "\n";
		self::$Code .= ' *' . "\n";
		self::$Code .= ' * @author' . "\t\t" . ProjectGenerator::$Author . "\n";
		self::$Code .= ' * @version' . "\t\t" . date("F j, Y"). "\n";
		self::$Code .= ' */' . "\n";
		self::$Code .= 'var ' . $class . ' = function(genericObj) {' . "\n\n";
	}
	
	/**
	 * Creates the properties
	 *
	 * @param		array		$entity
	 * @static
	 */
	public static function CreateProperties($entity){
		foreach($entity->fields->field as $field){
			$fieldName = (string)$field['name'];
			$fieldType = self::GetJavaScriptType((string)$field['type']);
			self::$Code .= "\t" . '/**' . "\n";
			self::$Code .= "\t" . ' * @var' . "\t\t" . $fieldType . "\n";
			self::$Code .= "\t" . ' */' . "\n";
			switch(strtoupper($fieldType)){
				case 'STRING':
					self::$Code .= "\t" . 'var _' . lcfirst($fieldName) . ' = \'\';' . "\n\n";
					break;
				case 'NUMBER':
					self::$Code .= "\t" . 'var _' . lcfirst($fieldName) . ' = 0;' . "\n\n";
					break;
				case 'BOOLEAN':
					self::$Code .= "\t" . 'var _' . lcfirst($fieldName) . ' = false;' . "\n\n";
					break;
				case 'ARRAY':
					self::$Code .= "\t" . 'var _' . lcfirst($fieldName) . ' = new Array();' . "\n\n";
					break;
				default:
					self::$Code .= "\t" . 'var _' . lcfirst($fieldName) . ' = new ' . $fieldType . '();' . "\n\n";
			}
		}
	}
	
	/**
	 * Creates the properties
	 *
	 * @param		array		$entity
	 * @static
	 */
	public static function CreateConstructor($entity){
		self::$Code .= "\t" . '/**' . "\n";
		self::$Code .= "\t" . ' * Constructor' . "\n";
		self::$Code .= "\t" . ' */' . "\n";
		self::$Code .= "\t" . 'var init = function() {' . "\n";
		self::$Code .= "\t\t" . 'if(Validator.IsInstanceOf(\'Object\', genericObj)){' . "\n";
		self::$Code .= "\t\t\t" . '$.each(genericObj, function(property, value){' . "\n";
		self::$Code .= "\t\t\t\t" . "switch (property.toUpperCase()) {" . "\n";
		foreach($entity->fields->field as $field){
			$fieldName = (string)$field['name'];
			self::$Code .= "\t\t\t\t\t" . "case '" . strtoupper($fieldName) . "':" . "\n";
			self::$Code .= "\t\t\t\t\t\t_set" . ucfirst($fieldName) .  '(value);' . "\n";
			self::$Code .= "\t\t\t\t\t\t" . 'break;' . "\n";
		}
		self::$Code .= "\t\t\t\t" . "}" . "\n";
		self::$Code .= "\t\t\t" . '});' . "\n";
		self::$Code .= "\t\t" . '}' . "\n";
		self::$Code .= "\t" . '};' . "\n\n";
	}
	
	/**
	 * Creates the setter methods
	 *
	 * @param		string		$class
	 * @param		array		$entity
	 * @static
	 */
	public static function CreateSetters($class, $entity){
		foreach($entity->fields->field as $field){
			$fieldName = (string)$field['name'];
			$fieldType = self::GetJavaScriptType((string)$field['type']);
			self::$Code .= "\t" . '/**' . "\n";
			self::$Code .= "\t" . ' * @param' . "\t\t" . $fieldType . "\t\t" . lcfirst($fieldName) . "\n";
			self::$Code .= "\t" . ' */' . "\n";
			self::$Code .= "\t" . 'var _set' . ucfirst($fieldName) . ' = function(' . lcfirst($fieldName) . '){' . "\n";
			switch(strtoupper($fieldType)){
				case 'STRING':
					self::$Code .= "\t\t_" . lcfirst($fieldName) .  ' = String(' . lcfirst($fieldName) . ');' . "\n";
					break;
				case 'NUMBER':
					self::$Code .= "\t\t_" . lcfirst($fieldName) .  ' = Number(' . lcfirst($fieldName) . ');' . "\n";
					break;
				case 'BOOLEAN':
					self::$Code .= "\t\t_" . lcfirst($fieldName) .  ' = Boolean(' . lcfirst($fieldName) . ');' . "\n";
					break;
				case 'ARRAY':
					self::$Code .= "\t\t" . 'if($.isArray(' . lcfirst($fieldName) . ')){' . "\n";
					self::$Code .= "\t\t\t_" . lcfirst($fieldName) .  ' = ' . lcfirst($fieldName) . ';' . "\n";
					self::$Code .= "\t\t" . '} else {' . "\n";
					self::$Code .= "\t\t\t" . 'console.error(\'Function expects an array as param. ( '.$class.'.set' . ucfirst($fieldName) . ' ))' . "\n";
					self::$Code .= "\t\t" . '}' . "\n";
					break;
				default:
					self::$Code .= "\t\t" . 'if(Validator.IsInstanceOf(\'Object\', ' . lcfirst($fieldName) . ')){' . "\n";
					self::$Code .= "\t\t\t_" . lcfirst($fieldName) .  ' = new ' . ucfirst($fieldName) . '(' . lcfirst($fieldName) . ');' . "\n";
					self::$Code .= "\t\t" . '} else {' . "\n";
					self::$Code .= "\t\t\t" . 'console.error(\'Function expects an object as param. ( '.$class.'.set' . ucfirst($fieldName) . ' )\');' . "\n";
					self::$Code .= "\t\t" . '}' . "\n";
			}
			self::$Code .= "\t" . '};' . "\n\n";
		}
	}
	
	/**
	 * Creates the getter methods
	 *
	 * @param		array		$entity
	 * @static
	 */
	public static function CreateGetters($entity){
		foreach($entity->fields->field as $field){
			$fieldName = (string)$field['name'];
			$fieldType = self::GetJavaScriptType((string)$field['type']);
			self::$Code .= "\t" . '/**' . "\n";
			self::$Code .= "\t" . ' * @return' . "\t\t" . $fieldType . "\n";
			self::$Code .= "\t" . ' */' . "\n";
			self::$Code .= "\t" . 'var _get' . ucfirst($fieldName) . ' = function(){' . "\n";
			self::$Code .= "\t\t" . 'return _' . lcfirst($fieldName) . ';' . "\n";
			self::$Code .= "\t" . '};' . "\n\n";
		}
	}
	
	/**
	 * Creates the getter methods
	 *
	 * @param		array		$entity
	 * @static
	 */
	public static function CreateConvertToArray($entity){
		self::$Code .= "\t" . '/**' . "\n";
		self::$Code .= "\t" . ' * @return' . "\t\tJSON\n";
		self::$Code .= "\t" . ' */' . "\n";
		self::$Code .= "\t" . 'var _convertToArray = function(){' . "\n";
		self::$Code .= "\t\t" . 'return {' . "\n";
		$tempArray = array();
		foreach($entity->fields->field as $field){
			$fieldName = (string)$field['name'];
			array_push($tempArray, '"'.lcfirst($fieldName).'":_'.lcfirst($fieldName));
		}
		self::$Code .= "\t\t\t\t" . implode(",\n\t\t\t\t", $tempArray). "\n";
		self::$Code .= "\t\t\t" . '};' . "\n";
		self::$Code .= "\t" . '};' . "\n\n";
	}
	
	/**
	 * Creates the return statement and the public methods
	 *
	 * @param		array		$entity
	 * @static
	 */
	public static function CreateReturn($entity){
		self::$Code .= "\t" . '/**' . "\n";
		self::$Code .= "\t" . ' * Executes constructor' . "\n";
		self::$Code .= "\t" . ' */' . "\n";
		self::$Code .= "\t" . 'init();' . "\n\n";
		self::$Code .= "\t" . '/**' . "\n";
		self::$Code .= "\t" . ' * Returns public functions' . "\n";
		self::$Code .= "\t" . ' */' . "\n";
		self::$Code .= "\t" . 'return{' . "\n\n";
		foreach($entity->fields->field as $field){
			$fieldName = (string)$field['name'];
			$fieldType = self::GetJavaScriptType((string)$field['type']);
			self::$Code .= "\t\t" . '/**' . "\n";
			self::$Code .= "\t\t" . ' * @param' . "\t\t" . $fieldType . "\t\t" . lcfirst($fieldName) . "\n";
			self::$Code .= "\t\t" . ' */' . "\n";
			self::$Code .= "\t\t" . 'set' . ucfirst($fieldName) . ' : function(' . lcfirst($fieldName) . '){' . "\n";
			self::$Code .= "\t\t\t" . '_set' . ucfirst($fieldName) . '(' . lcfirst($fieldName) . ');' . "\n";
			self::$Code .= "\t\t" . '},' . "\n\n";
		}
		foreach($entity->fields->field as $field){
			$fieldName = (string)$field['name'];
			$fieldType = self::GetJavaScriptType((string)$field['type']);
			self::$Code .= "\t\t" . '/**' . "\n";
			self::$Code .= "\t\t" . ' * @return' . "\t\t" . $fieldType . "\n";
			self::$Code .= "\t\t" . ' */' . "\n";
			self::$Code .= "\t\t" . 'get' . ucfirst($fieldName) . ' : function(){' . "\n";
			self::$Code .= "\t\t\t" . 'return _get' . ucfirst($fieldName) . '();' . "\n";
			self::$Code .= "\t\t" . '},' . "\n\n";
		}
		self::$Code .= "\t\t" . '/**' . "\n";
		self::$Code .= "\t\t" . ' * @return' . "\t\tJSON\n";
		self::$Code .= "\t\t" . ' */' . "\n";
		self::$Code .= "\t\t" . 'convertToArray : function(){' . "\n";
		self::$Code .= "\t\t\t" . 'return _convertToArray();' . "\n";
		self::$Code .= "\t\t" . '}' . "\n";
		self::$Code .= "\t" . '};' . "\n";
		self::$Code .= '};';
	}
	
	/**
	 * Creates the .js file
	 *
	 * @param		string		$class
	 * @static
	 */
	public static function CreateFile($class){
		$fileName = self::$Folder . $class . '.js';
		$fh = fopen($fileName , 'w') or die("can't open file");
		fwrite($fh, self::$Code);
		fclose($fh);
		if(is_file($fileName)){
			chmod($fileName, 0775);
		}
		echo '<b>File created:</b>' . $fileName . '<br />';
	}
	
	/**
	 * Sets the proper JavaScript type
	 *
	 * @param		string		$phpType
	 * @return		string
	 * @static
	 */
	public static function GetJavaScriptType($phpType){
		$jsType = '';
		switch(strtoupper($phpType)){
			case 'STRING':
			case 'TEXT':
			case 'DATE': //TODO: set Date as a JavaScript new Object, not a string
				$jsType = 'String';
				break;
			case 'INT':
			case 'FLOAT':
				$jsType = 'Number';
				break;
			case 'BOOL':
				$jsType = 'Boolean';
				break;
			case 'ARRAY':
				$jsType = 'Array';
				break;
			default:
				$jsType = $phpType;
		}
		return $jsType;
	}
}