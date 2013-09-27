<?php

/**
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/Code/PhpClassGenerator.php
 */
class PhpClassGenerator {
	
	/**
	 * The folder path where the .php file will be created
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
	 * Loads the class structure and other initial values
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
			$fields = $entity->fields->field;
			self::CreateHeader($class);
			self::CreateProperties($fields);
			self::CreateSetters($class, $fields);
			self::CreateGetters($fields);
			self::$Code .= '}';
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
		self::$Code = '<?php' . "\n";
		self::$Code .= '/**' . "\n";
		self::$Code .= ' * @author' . "\t\t" . ProjectGenerator::$Author . "\n";
		self::$Code .= ' * @version' . "\t\t" . date("F j, Y"). "\n";
		self::$Code .= ' */' . "\n\n";
		self::$Code .= 'class ' . $class . ' extends AbstractEntity {' . "\n\n";
	}
	
	/**
	 * Creates the properties
	 *
	 * @param		array		$fields
	 * @static
	 */
	public static function CreateProperties($fields){
		foreach($fields as $field){
			$fieldName = (string)$field['name'];
			$fieldType = (string)$field['type'];
			self::$Code .= "\t" . '/**' . "\n";
			self::$Code .= "\t" . ' * @var' . "\t\t" . $fieldType . "\n";
			self::$Code .= "\t" . ' */' . "\n";
			self::$Code .= "\t" . 'protected $' . lcfirst($fieldName) . ' = null;' . "\n\n";
		}
	}
	
	/**
	 * Creates the setter methods
	 *
	 * @param		string		$class
	 * @param		array		$fields
	 * @static
	 */
	public static function CreateSetters($class, $fields){
		foreach($fields as $field){
			$fieldName = (string)$field['name'];
			$fieldType = (string)$field['type'];
			self::$Code .= "\t" . '/**' . "\n";
			self::$Code .= "\t" . ' * @param' . "\t\t" . $fieldType . "\t\t" . '$' . lcfirst($fieldName) . "\n";
			self::$Code .= "\t" . ' */' . "\n";
			self::$Code .= "\t" . 'public function set' . ucfirst($fieldName) . '($' . lcfirst($fieldName) . '){' . "\n";
			switch(strtoupper($fieldType)){
				case 'STRING':
					self::$Code .= "\t\t" . '$this->' . lcfirst($fieldName) . ' = substr(strval($' . lcfirst($fieldName) . '), 0, ' . (string)$field['length'] . ');' . "\n";
					break;
				case 'TEXT':
					self::$Code .= "\t\t" . '$this->' . lcfirst($fieldName) . ' = substr(strval($' . lcfirst($fieldName) . '), 0, 4096);' . "\n";
					break;
				case 'DATE':
					self::$Code .= "\t\t" . '$this->' . lcfirst($fieldName) . ' = substr(strval($' . lcfirst($fieldName) . '), 0, 32);' . "\n";
					break;
				case 'INT':
					self::$Code .= "\t\t" . '$this->' . lcfirst($fieldName) . ' = intval($' . lcfirst($fieldName) . ');' . "\n";
					break;
				case 'FLOAT':
					self::$Code .= "\t\t" . '$this->' . lcfirst($fieldName) . ' = floatval($' . lcfirst($fieldName) . ');' . "\n";
					break;
				case 'BOOL':
					self::$Code .= "\t\t" . '$this->' . lcfirst($fieldName) . ' = $' . lcfirst($fieldName) . ';' . "\n";
					break;
				case 'ARRAY':
					self::$Code .= "\t\t" . 'if(is_array($' . lcfirst($fieldName) . ')){' . "\n";
					self::$Code .= "\t\t\t" . '$this->' . lcfirst($fieldName) . ' = $' . lcfirst($fieldName) . ';' . "\n";
					self::$Code .= "\t\t" . '} else {' . "\n";
					self::$Code .= "\t\t\t" . "throw new Exception('Function expects an array as param. (".$class."->set".ucfirst($fieldName)."($".lcfirst($fieldName)."))');" . "\n";
					self::$Code .= "\t\t" . '}' . "\n";
					break;
				default:
					self::$Code .= "\t\t" . 'if(is_object($' . lcfirst($fieldName) . ')){' . "\n";
					self::$Code .= "\t\t\t" . '$this->' . lcfirst($fieldName) . ' = $' . lcfirst($fieldName) . ';' . "\n";
					self::$Code .= "\t\t" . '} else {' . "\n";
					self::$Code .= "\t\t\t" . "throw new Exception('Function expects an object as param. (".$class."->set".ucfirst($fieldName)."($".lcfirst($fieldName)."))');" . "\n";
					self::$Code .= "\t\t" . '}' . "\n";
			}
			self::$Code .= "\t" . '}' . "\n\n";
		}
	}
	
	/**
	 * Creates the getter methods
	 *
	 * @param		array		$fields
	 * @static
	 */
	public static function CreateGetters($fields){
		foreach($fields as $field){
			$fieldName = (string)$field['name'];
			$fieldType = (string)$field['type'];
			self::$Code .= "\t" . '/**' . "\n";
			self::$Code .= "\t" . ' * @return' . "\t\t" . $fieldType . "\n";
			self::$Code .= "\t" . ' */' . "\n";
			self::$Code .= "\t" . 'public function get' . ucfirst($fieldName) . '(){' . "\n";
			self::$Code .= "\t\t" . 'return $this->' . lcfirst($fieldName) . ';' . "\n";
			self::$Code .= "\t" . '}' . "\n\n";
		}
	}
	
	/**
	 * Creates the .php file
	 *
	 * @param		string		$class
	 * @static
	 */
	public static function CreateFile($class){
		$fileName = self::$Folder . $class . '.php';
		$fh = fopen($fileName , 'w') or die("can't open file");
		fwrite($fh, self::$Code);
		fclose($fh);
		if(is_file($fileName)){
			chmod($fileName, 0774);
		}
		echo '<b>File created:</b>' . $fileName . '<br />';
	}
}