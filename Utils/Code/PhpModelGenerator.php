<?php

/**
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/Code/PhpModelGenerator.php
 */
class PhpModelGenerator {

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
	 * Loads the model structure and other initial values
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
			self::CreateSave($class, $entity);
			self::CreateFindById($class, $entity);
			self::CreateFindBy($class, $entity);
			self::CreateFindByMultipleValues($class, $entity);
			self::CreateFindByInnerObjectProperties($class, $entity);
			self::CreateFetchAll($class, $entity);
			self::CreateSearch($class, $entity);
			self::CreateGetCount($entity);
			self::CreateDelete($class, $entity);
			self::GenerateCreateBundleFromArray($class, $entity);
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
		self::$Code = '<?php'."\n";
		self::$Code .= '/**'."\n";
		self::$Code .= ' * @author'."\t\t".ProjectGenerator::$Author."\n";
		self::$Code .= ' * @version'."\t\t".date("F j, Y"). "\n";
		self::$Code .= ' * @filesource'."\t\t".'/Models/'.$class.'Model.php'."\n";
		self::$Code .= ' */'."\n\n";
		self::$Code .= 'class '.$class.'Model extends AbstractModel {'."\n\n";
	}
	
	/**
	 * Creates the Save method
	 * 
	 * @param		string					$class
	 * @param		SimpleXmlElement		$entity
	 * @static
	 */
	public static function CreateSave($class, $entity){
		self::$Code .= "\t".'/**'."\n";
		self::$Code .= "\t".' * Saves the '.$class.' in the Data Base'."\n";
		self::$Code .= "\t".' * '."\n";
		self::$Code .= "\t".' * @param'."\t\t".$class."\t\t".'$'.lcfirst($class)."\n";
		self::$Code .= "\t".' * @static'."\n";
		self::$Code .= "\t".' */'."\n";
		self::$Code .= "\t".'public static function Save(&$'.lcfirst($class).'){'."\n";
		//TODO: Improve this to allow more than one primary key field
		$pkName = (string)$entity->pk[0]->field['name'];
		$xmlPkType = ProjectGenerator::$Entities->xpath('/entities/entity[@name="'.$class.'"]/fields/field[@name="'.$pkName.'"]/@type');
		$pkType = (string) $xmlPkType[0]->type;
		$autoincrement = trim($entity->table['autoincrement']) == 'true';
		self::$Code .= "\t\t".'$id = $'.lcfirst($class).'->get'.ucfirst($pkName).'();'."\n";
		//Prepare the properties, required and non required objects list
		$properties = array();
		$requiredFields = array();
		$nonRequiredObjects = array();
		foreach($entity->fields->field as $field){
			$fieldName = (string)$field['name'];
			//TODO: Improve this to compare with more than one pk field
			if($fieldName != $pkName){
				$fieldType = (string)$field['type'];
				$fieldRequired = trim(strtolower($field['required'])) == 'true';
				switch(strtoupper($fieldType)){
					case 'STRING':
					case 'TEXT':
						array_push($properties, "\t\t\t\t".'"'.lcfirst($fieldName).'" => self::$IsUsingUtf8 ? htmlentities(utf8_decode($'.lcfirst($class).'->get'.ucfirst($fieldName).'()), ENT_COMPAT, self::$Charset, false) : htmlentities($'.lcfirst($class).'->get'.ucfirst($fieldName).'(), ENT_COMPAT, self::$Charset, false)');
						break;
					case 'INT':
					case 'FLOAT':
						array_push($properties, "\t\t\t\t".'"'.lcfirst($fieldName).'" => $'.lcfirst($class).'->get'.ucfirst($fieldName).'()');
						break;
					case 'BOOL':
						array_push($properties, "\t\t\t\t".'"'.lcfirst($fieldName).'" => intval($'.lcfirst($class).'->get'.ucfirst($fieldName).'())');
						break;
					case 'DATE':
						array_push($properties, "\t\t\t\t".'"'.lcfirst($fieldName).'" => Date::ParseDate($'.lcfirst($class).'->get'.ucfirst($fieldName).'())');
						break;
					default:
						$xmlRelatedEntityId = ProjectGenerator::$Entities->xpath('/entities/entity[@name="'.$fieldType.'"]/pk/field/@name');
						$relatedEntityId = (string) $xmlRelatedEntityId[0]->name;
						$fieldName = lcfirst($fieldType) . ucfirst($relatedEntityId);
						if($fieldRequired){
							array_push($properties, "\t\t\t\t".'"'.lcfirst($fieldName).'" => $'.lcfirst($class).'->get'.$fieldType.'()->get'.ucfirst($relatedEntityId).'()');					
						} else {
							array_push($properties, "\t\t\t\t".'"'.lcfirst($fieldName).'" => null');
							$nonRequiredObjects[$fieldName] = array($fieldType, $relatedEntityId);
						}
						break;
				}
				if($fieldRequired){
					array_push($requiredFields, $fieldName);
				}
			}
		}
		//Adding properties
		self::$Code .= "\t\t".'$properties = array('."\n";
		self::$Code .= implode(",\n", $properties)."\n";
		self::$Code .= "\t\t\t".');'."\n";
		foreach($nonRequiredObjects as $field => $type){
			self::$Code .= "\t\t".'if(is_object($'.lcfirst($class).'->get'.$type[0].'())){'."\n";
			self::$Code .= "\t\t\t".'$properties["'.lcfirst($field).'"] = $'.lcfirst($class).'->get'.$type[0].'()->get'.ucfirst($type[1]).'();'."\n";
			self::$Code .= "\t\t".'}'."\n";
		}
		//Validating
		self::$Code .= "\t\t".'$emptyValues = \'\';'."\n";
		if(($pkType != 'int') || !$autoincrement){
			self::$Code .= "\t\t".'if(empty($id)){'."\n";
			self::$Code .= "\t\t\t".'$emptyValues .= \' '.$pkName.'\';'."\n";
			self::$Code .= "\t\t".'}'."\n";
		}
		foreach($requiredFields as $field){
			self::$Code .= "\t\t".'if(empty($properties["'.$field.'"])){'."\n";
			self::$Code .= "\t\t\t".'$emptyValues .= \' '.$field.'\';'."\n";
			self::$Code .= "\t\t".'}'."\n";
		}
		self::$Code .= "\t\t".'if(empty($emptyValues)){'."\n";
		//Adding queries
		self::$Code .= "\t\t\t".'$query = new Query();'."\n";
		if(($pkType == 'int') && $autoincrement){
			self::$Code .= "\t\t\t".'if(!empty($id) && is_int($id)){'."\n";
		} else {
			self::$Code .= "\t\t\t".'$db'.$class.' = self::FindById($id);'."\n";
			self::$Code .= "\t\t\t".'if(!empty($db'.$class.')){'."\n";
		}
		self::$Code .= "\t\t\t\t".'$query->createUpdate(\''.$entity->table['name'].'\', $properties, \''.$pkName.' = "\'.$id.\'"\', true);'."\n";
		self::$Code .= "\t\t\t\t".'$isExecuted = $query->execute();'."\n";
		self::$Code .= "\t\t\t\t".'if(!$isExecuted){'."\n";
		self::$Code .= "\t\t\t\t\t".'throw new Exception(\'Unable to update '.$class.' "\'.$'.$pkName.'.\'" in database. ('.$class.'Model::save())\');'."\n";
		self::$Code .= "\t\t\t\t".'}'."\n";
		self::$Code .= "\t\t\t".'} else {'."\n";
		if(($pkType != 'int') || ($autoincrement != true)){
			self::$Code .= "\t\t\t\t".'$properties[\''.$pkName.'\'] = $id;'."\n";
		}
		self::$Code .= "\t\t\t\t".'$query->createInsert(\''.$entity->table['name'].'\', $properties, true);'."\n";
		self::$Code .= "\t\t\t\t".'$isExecuted = $query->execute();'."\n";
		if(($pkType == 'int') && ($autoincrement == true)){
			self::$Code .= "\t\t\t\t".'if($isExecuted){'."\n";
			self::$Code .= "\t\t\t\t\t".'//get the last inserted id'."\n";
			self::$Code .= "\t\t\t\t\t".'$query->createSelect(array(\'MAX('.$pkName.') as '.$pkName.'\'), \''.$entity->table['name'].'\');'."\n";
			self::$Code .= "\t\t\t\t\t".'$value = $query->execute();'."\n";
			self::$Code .= "\t\t\t\t\t".'$'.lcfirst($class).'->set'.ucfirst($pkName).'($value[\''.$pkName.'\']);'."\n";
			self::$Code .= "\t\t\t\t".'} else {'."\n";
			self::$Code .= "\t\t\t\t\t".'throw new Exception(\'Unable to insert '.$class.' in database. ('.$class.'Model::save())\');'."\n";
			self::$Code .= "\t\t\t\t".'}'."\n";
		} else {
			self::$Code .= "\t\t\t\t".'if(!$isExecuted){'."\n";
			self::$Code .= "\t\t\t\t\t".'throw new Exception(\'Unable to insert '.$class.' in database. ('.$class.'Model::save())\');'."\n";
			self::$Code .= "\t\t\t\t".'}'."\n";
		}
		self::$Code .= "\t\t\t".'}'."\n";
		self::$Code .= "\t\t".'} else {'."\n";
		self::$Code .= "\t\t\t".'throw new Exception(\'Unable to save '.$class.' with empty required values:\'.$emptyValues.\'. ('.$class.'Model::save())\');'."\n";
		self::$Code .= "\t\t".'}'."\n";
		self::$Code .= "\t\t".'return true;'."\n";
		self::$Code .= "\t".'}'."\n\n";
	}
	
	/**
	 * Creates the FindById method
	 * 
	 * @param		string					$class
	 * @param		SimpleXmlElement		$entity
	 * @static
	 */
	public static function CreateFindById($class, $entity){
		self::$Code .= "\t".'/**'."\n";
		self::$Code .= "\t".' * Finds a '.$class.' by id'."\n";
		self::$Code .= "\t".' * '."\n";
		self::$Code .= "\t".' * @param'."\t\t".'int'."\t\t".'$id'."\n";
		self::$Code .= "\t".' * @return'."\t\t".$class."\n";
		self::$Code .= "\t".' * @static'."\n";
		self::$Code .= "\t".' */'."\n";
		self::$Code .= "\t".'public static function FindById($id){'."\n";
		self::$Code .= "\t\t".'$query = new Query();'."\n";
		//TODO: Improve this to allow more than one primary key field
		$pkName = (string)$entity->pk[0]->field['name'];
		self::$Code .= "\t\t".'$query->createSelect(array(\'*\'), \''.$entity->table['name'].'\', array(), \''.$pkName.' = "\'.$id.\'"\');'."\n";
		self::$Code .= "\t\t".'$'.lcfirst($class).'Array = $query->execute();'."\n";
		self::$Code .= "\t\t".'$'.lcfirst($class).' = false;'."\n";
		self::$Code .= "\t\t".'if(!empty($'.lcfirst($class).'Array)){'."\n";
		self::$Code .= "\t\t\t".'$'.lcfirst($class).' = self::CreateObjectFromArray($'.lcfirst($class).'Array);'."\n";
		self::$Code .= "\t\t".'}'."\n";
		self::$Code .= "\t\t".'return $'.lcfirst($class).';'."\n";
		self::$Code .= "\t".'}'."\n\n";
	}
	
	/**
	 * Creates the FindBy method
	 * 
	 * @param		string					$class
	 * @param		SimpleXmlElement		$entity
	 * @static
	 */
	public static function CreateFindBy($class, $entity){
		self::$Code .= "\t".'/**'."\n";
		self::$Code .= "\t".' * Finds stored '.ucfirst($entity->table['name']).' by specific values'."\n";
		self::$Code .= "\t".' * '."\n";
		self::$Code .= "\t".' * @param'."\t\t".'array|string'."\t\t".'$params'."\n";
		self::$Code .= "\t".' * @param'."\t\t".'bool'."\t\t\t\t".'$expectsOne'."\n";
		self::$Code .= "\t".' * @return'."\t\t".'array|'.$class."\n";
		self::$Code .= "\t".' * @static'."\n";
		self::$Code .= "\t".' */'."\n";
		self::$Code .= "\t".'public static function FindBy($params, $expectsOne=false){'."\n";
		self::$Code .= "\t\t".'$'.$entity->table['name'].'Array = array();'."\n";
		self::$Code .= "\t\t".'if(is_array($params)){'."\n";
		self::$Code .= "\t\t\t".'$params = self::CheckParams($params);'."\n";
		self::$Code .= "\t\t\t".'$where = \'\';'."\n";
		self::$Code .= "\t\t\t".'if(is_array($params[\'where\'])){'."\n";
		self::$Code .= "\t\t\t\t".'//TODO: Use Query::Make() !!!'."\n";
		self::$Code .= "\t\t\t\t".'$whereArray = array();'."\n";
		self::$Code .= "\t\t\t\t".'foreach ($params[\'where\'] as $key => $value){'."\n";
		self::$Code .= "\t\t\t\t\t".'if(!empty($value)){'."\n";
		self::$Code .= "\t\t\t\t\t\t".'$parsedValue = self::$IsUsingUtf8 ? htmlentities(utf8_decode($value), ENT_COMPAT, self::$Charset, false) : htmlentities($value, ENT_COMPAT, self::$Charset, false);'."\n";
		self::$Code .= "\t\t\t\t\t\t".'array_push($whereArray, $key.\' = "\'.$parsedValue.\'"\');'."\n";
		self::$Code .= "\t\t\t\t\t".'}'."\n";
		self::$Code .= "\t\t\t\t".'}'."\n";
		self::$Code .= "\t\t\t\t".'$where = implode(\' AND \', $whereArray);'."\n";
		self::$Code .= "\t\t\t".'} else {'."\n";
		self::$Code .= "\t\t\t\t".'$where = trim($params[\'where\']);'."\n";
		self::$Code .= "\t\t\t".'}'."\n";
		self::$Code .= "\t\t\t".'$orderBy = array();'."\n";
		self::$Code .= "\t\t\t".'if(!empty($params[\'orderBy\'])){'."\n";
		self::$Code .= "\t\t\t\t".'$orderBy = implode(\',\', $params[\'orderBy\']);'."\n";
		self::$Code .= "\t\t\t".'}'."\n";
		self::$Code .= "\t\t\t".'$limit = \'\';'."\n";
		self::$Code .= "\t\t\t".'if(!empty($params[\'from\'])){'."\n";
		self::$Code .= "\t\t\t\t".'$limit = \'\'.$params[\'from\'];'."\n";
		self::$Code .= "\t\t\t\t".'if(!empty($params[\'amount\'])){'."\n";
		self::$Code .= "\t\t\t\t\t".'$limit .= \', \'.$params[\'amount\'];'."\n";
		self::$Code .= "\t\t\t\t".'} else {'."\n";
		self::$Code .= "\t\t\t\t\t".'$limit .= \', 10\';'."\n";
		self::$Code .= "\t\t\t\t".'}'."\n";
		self::$Code .= "\t\t\t".'}'."\n";
		self::$Code .= "\t\t\t".'$query = new Query();'."\n";
		self::$Code .= "\t\t\t".'$query->createSelect(array(\'*\'), \''.$entity->table['name'].'\', null, $where, $orderBy, $limit);'."\n";
		self::$Code .= "\t\t\t".'$arrayArrays'.$class.' = $query->execute(true);'."\n";
		self::$Code .= "\t\t\t".'if(!empty($arrayArrays'.$class.')){'."\n";
		self::$Code .= "\t\t\t\t".'if($expectsOne){'."\n";
		self::$Code .= "\t\t\t\t\t".'return self::CreateObjectFromArray($arrayArrays'.ucfirst($class).'[0]);'."\n";
		self::$Code .= "\t\t\t\t".'}'."\n";
		self::$Code .= "\t\t\t\t".'foreach($arrayArrays'.$class.' as $array'.ucfirst($class).'){'."\n";
		self::$Code .= "\t\t\t\t\t".'array_push($'.$entity->table['name'].'Array, self::CreateObjectFromArray($array'.ucfirst($class).'));'."\n";
		self::$Code .= "\t\t\t\t".'}'."\n";
		self::$Code .= "\t\t\t".'} elseif($expectsOne){'."\n";
		self::$Code .= "\t\t\t\t".'return false;'."\n";
		self::$Code .= "\t\t\t".'}'."\n";
		self::$Code .= "\t\t".'} else {'."\n";
		self::$Code .= "\t\t\t".'throw new Exception(\'Invalid argument passed, expects param to be Array in '.ucfirst($class).'Model::FindBy()\');'."\n";
		self::$Code .= "\t\t".'}'."\n";
		self::$Code .= "\t\t".'return $'.$entity->table['name'].'Array;'."\n";
		self::$Code .= "\t".'}'."\n\n";
	}
	
	/**
	 * Creates the FindByMultipleValues method
	 * 
	 * @param		string					$class
	 * @param		SimpleXmlElement		$entity
	 * @static
	 */
	public static function CreateFindByMultipleValues($class, $entity){
		self::$Code .= "\t".'/**'."\n";
		self::$Code .= "\t".' * Finds stored '.ucfirst($entity->table['name']).' by multiple values of an specific field'."\n";
		self::$Code .= "\t".' * '."\n";
		self::$Code .= "\t".' * @param'."\t\t".'array|string'."\t\t".'$params'."\n";
		self::$Code .= "\t".' * @return'."\t\t".'array|'.$class."\n";
		self::$Code .= "\t".' * @static'."\n";
		self::$Code .= "\t".' */'."\n";
		self::$Code .= "\t".'public static function FindByMultipleValues($params, $expectsOne=false){'."\n";
		self::$Code .= "\t\t".'$'.$entity->table['name'].'Array = array();'."\n";
		self::$Code .= "\t\t".'if(is_array($params)){'."\n";
		self::$Code .= "\t\t\t".'$params = self::CheckParams($params);'."\n";
		self::$Code .= "\t\t\t".'//TODO: Use Query::Make() !!!'."\n";
		self::$Code .= "\t\t\t".'$whereArray = array();'."\n";
		self::$Code .= "\t\t\t".'foreach ($params[\'where\'] as $key => $value){'."\n";
		self::$Code .= "\t\t\t\t".'if(!empty($value) && is_array($value)){'."\n";
		self::$Code .= "\t\t\t\t\t".'array_push($whereArray, $key.\' IN (\'.implode(\', \', $value).\')\');'."\n";
		self::$Code .= "\t\t\t\t".'} else {'."\n";
		self::$Code .= "\t\t\t\t\t".'throw new Exception(\'Invalid param, array expected in '.ucfirst($class).'Model::FindByMultipleValues()\');'."\n";
		self::$Code .= "\t\t\t\t".'}'."\n";
		self::$Code .= "\t\t\t".'}'."\n";
		self::$Code .= "\t\t\t".'$where = implode(\' OR \', $whereArray);'."\n";
		self::$Code .= "\t\t\t".'$orderBy = array();'."\n";
		self::$Code .= "\t\t\t".'if(!empty($params[\'orderBy\'])){'."\n";
		self::$Code .= "\t\t\t\t".'$orderBy = implode(\',\', $params[\'orderBy\']);'."\n";
		self::$Code .= "\t\t\t".'}'."\n";
		self::$Code .= "\t\t\t".'$limit = \'\';'."\n";
		self::$Code .= "\t\t\t".'if(!empty($params[\'from\'])){'."\n";
		self::$Code .= "\t\t\t\t".'$limit = \'\'.$params[\'from\'];'."\n";
		self::$Code .= "\t\t\t\t".'if(!empty($params[\'amount\'])){'."\n";
		self::$Code .= "\t\t\t\t\t".'$limit .= \', \'.$params[\'amount\'];'."\n";
		self::$Code .= "\t\t\t\t".'} else {'."\n";
		self::$Code .= "\t\t\t\t\t".'$limit .= \', 10\';'."\n";
		self::$Code .= "\t\t\t\t".'}'."\n";
		self::$Code .= "\t\t\t".'}'."\n";
		self::$Code .= "\t\t\t".'$query = new Query();'."\n";
		self::$Code .= "\t\t\t".'$query->createSelect(array(\'*\'), \''.$entity->table['name'].'\', null, $where, $orderBy, $limit);'."\n";
		self::$Code .= "\t\t\t".'$arrayArrays'.$class.' = $query->execute(true);'."\n";
		self::$Code .= "\t\t\t".'if(!empty($arrayArrays'.$class.')){'."\n";
		self::$Code .= "\t\t\t\t".'foreach($arrayArrays'.$class.' as $array'.ucfirst($class).'){'."\n";
		self::$Code .= "\t\t\t\t\t".'array_push($'.$entity->table['name'].'Array, self::CreateObjectFromArray($array'.ucfirst($class).'));'."\n";
		self::$Code .= "\t\t\t\t".'}'."\n";
		self::$Code .= "\t\t\t".'}'."\n";
		self::$Code .= "\t\t".'} else {'."\n";
		self::$Code .= "\t\t\t".'throw new Exception(\'Invalid param, array expected in '.ucfirst($class).'Model::FindByMultipleValues()\');'."\n";
		self::$Code .= "\t\t".'}'."\n";
		self::$Code .= "\t\t".'return $'.$entity->table['name'].'Array;'."\n";
		self::$Code .= "\t".'}'."\n\n";
	}
	
	/**
	 * Creates methods to find object by inner object properties
	 * 
	 * @param		string					$class
	 * @param		SimpleXmlElement		$entity
	 * @static
	 */
	public static function CreateFindByInnerObjectProperties($class, $entity){
		foreach($entity->fields->field as $field){
			$fieldType = (string)$field['type'];
			//Validates that it is an object
			if((strtoupper($fieldType) != 'STRING') && (strtoupper($fieldType) != 'TEXT') && (strtoupper($fieldType) != 'INT') && (strtoupper($fieldType) != 'FLOAT') && (strtoupper($fieldType) != 'BOOL') && (strtoupper($fieldType) != 'DATE')){
				$xmlRelatedEntityId = ProjectGenerator::$Entities->xpath('/entities/entity[@name="'.$fieldType.'"]/pk/field/@name');
				$relatedEntityId = (string) $xmlRelatedEntityId[0]->name;
				$fieldName = lcfirst($fieldType) . ucfirst($relatedEntityId);
				self::$Code .= "\t".'/**'."\n";
				self::$Code .= "\t".' * Finds stored '.ucfirst($entity->table['name']).' by related '.ucfirst($fieldType).' properties'."\n";
				self::$Code .= "\t".' * '."\n";
				self::$Code .= "\t".' * @param'."\t\t".'array|string'."\t\t".'$params'."\n";
				self::$Code .= "\t".' * @param'."\t\t".'bool'."\t\t\t\t".'$expectsOne'."\n";
				self::$Code .= "\t".' * @return'."\t\t".'array|'.$class."\n";
				self::$Code .= "\t".' * @static'."\n";
				self::$Code .= "\t".' */'."\n";
				self::$Code .= "\t".'public static function FindBy'.ucfirst($fieldType).'Properties($params, $expectsOne=false){'."\n";
				self::$Code .= "\t\t".'$'.$entity->table['name'].'Array = array();'."\n";
				self::$Code .= "\t\t".'if(is_array($params)){'."\n";
				self::$Code .= "\t\t\t".'$params = self::CheckParams($params);'."\n";
				self::$Code .= "\t\t\t".'$selectFields = array('."\n";
				$properties = array();
				foreach($entity->fields->field as $tempField){
					$tempFieldType = (string)$tempField['type'];
					$tempFieldName = (string)$tempField['name'];
					if((strtoupper($tempFieldType) != 'STRING') && (strtoupper($tempFieldType) != 'TEXT') && (strtoupper($tempFieldType) != 'INT') && (strtoupper($tempFieldType) != 'FLOAT') && (strtoupper($tempFieldType) != 'BOOL') && (strtoupper($tempFieldType) != 'DATE')){
						$tempXmlRelatedEntityId = ProjectGenerator::$Entities->xpath('/entities/entity[@name="'.$tempFieldType.'"]/pk/field/@name');
						$tempRelatedEntityId = (string) $tempXmlRelatedEntityId[0]->name;
						$tempFieldName = lcfirst($tempFieldType) . ucfirst($tempRelatedEntityId);
					}
					array_push($properties, lcfirst($tempFieldName));
				}
				self::$Code .= "\t\t\t\t\t'".$entity->table['name'].'.'.implode("',\n\t\t\t\t\t'".$entity->table['name'].'.', $properties)."'\n";
				self::$Code .= "\t\t\t\t".');'."\n";
				$relatedEntity = ProjectGenerator::$Entities->xpath('/entities/entity[@name="'.(string)$field['type'].'"]');
				self::$Code .= "\t\t\t".'$joinArray = array(\''.$relatedEntity[0]->table['name'].'\'=>\''.$relatedEntity[0]->table['name'].'.'.$relatedEntity[0]->pk->field['name'].' = '.$entity->table['name'].'.'.lcfirst($fieldName).'\');'."\n";
				self::$Code .= "\t\t\t".'$whereArray = array();'."\n";
				self::$Code .= "\t\t\t".'foreach ($params[\'where\'] as $key => $value){'."\n";
				self::$Code .= "\t\t\t\t".'if(!empty($value)){'."\n";
				self::$Code .= "\t\t\t\t\t".'$parsedValue = self::$IsUsingUtf8 ? htmlentities(utf8_decode($value), ENT_COMPAT, self::$Charset, false) : htmlentities($value, ENT_COMPAT, self::$Charset, false);'."\n";
				self::$Code .= "\t\t\t\t\t".'array_push($whereArray, \''.$relatedEntity[0]->table['name'].'.\'.$key.\' = "\'.$parsedValue.\'"\');'."\n";
				self::$Code .= "\t\t\t\t".'}'."\n";
				self::$Code .= "\t\t\t".'}'."\n";
				self::$Code .= "\t\t\t".'$where = implode(\' AND \', $whereArray);'."\n";
				self::$Code .= "\t\t\t".'$orderBy = array();'."\n";
				self::$Code .= "\t\t\t".'if(!empty($params[\'orderBy\'])){'."\n";
				self::$Code .= "\t\t\t\t".'$orderBy = implode(\',\', $params[\'orderBy\']);'."\n";
				self::$Code .= "\t\t\t".'}'."\n";
				self::$Code .= "\t\t\t".'$limit = \'\';'."\n";
				self::$Code .= "\t\t\t".'if(!empty($params[\'from\'])){'."\n";
				self::$Code .= "\t\t\t\t".'$limit = \'\'.$params[\'from\'];'."\n";
				self::$Code .= "\t\t\t\t".'if(!empty($params[\'amount\'])){'."\n";
				self::$Code .= "\t\t\t\t\t".'$limit .= \', \'.$params[\'amount\'];'."\n";
				self::$Code .= "\t\t\t\t".'} else {'."\n";
				self::$Code .= "\t\t\t\t\t".'$limit .= \', 10\';'."\n";
				self::$Code .= "\t\t\t\t".'}'."\n";
				self::$Code .= "\t\t\t".'}'."\n";
				self::$Code .= "\t\t\t".'$query = new Query();'."\n";
				self::$Code .= "\t\t\t".'$query->createSelect(array(\'*\'), \''.$entity->table['name'].'\', $joinArray, $where, $orderBy, $limit);'."\n";
				self::$Code .= "\t\t\t".'$arrayArrays'.$class.' = $query->execute(true);'."\n";
				self::$Code .= "\t\t\t".'if(!empty($arrayArrays'.$class.')){'."\n";
				self::$Code .= "\t\t\t\t".'if($expectsOne){'."\n";
				self::$Code .= "\t\t\t\t\t".'return self::CreateObjectFromArray($arrayArrays'.ucfirst($class).'[0]);'."\n";
				self::$Code .= "\t\t\t\t".'}'."\n";
				self::$Code .= "\t\t\t\t".'foreach($arrayArrays'.$class.' as $array'.ucfirst($class).'){'."\n";
				self::$Code .= "\t\t\t\t\t".'array_push($'.$entity->table['name'].'Array, self::CreateObjectFromArray($array'.ucfirst($class).'));'."\n";
				self::$Code .= "\t\t\t\t".'}'."\n";
				self::$Code .= "\t\t\t".'} elseif($expectsOne){'."\n";
				self::$Code .= "\t\t\t\t".'return false;'."\n";
				self::$Code .= "\t\t\t".'}'."\n";
				self::$Code .= "\t\t".'} else {'."\n";
				self::$Code .= "\t\t\t".'throw new Exception(\'Invalid param, array expected in '.ucfirst($class).'Model::FindBy'.ucfirst($fieldType).'Properties()\');'."\n";
				self::$Code .= "\t\t".'}'."\n";
				self::$Code .= "\t\t".'return $'.$entity->table['name'].'Array;'."\n";
				self::$Code .= "\t".'}'."\n\n";
			}
		}
	}
	
	/**
	 * Creates the FetchAll method
	 * 
	 * @param		string					$class
	 * @param		SimpleXmlElement		$entity
	 * @static
	 */
	public static function CreateFetchAll($class, $entity){
		self::$Code .= "\t".'/**'."\n";
		self::$Code .= "\t".' * Retrieves all '.ucfirst($entity->table['name']).' stored in the data base'."\n";
		self::$Code .= "\t".' * '."\n";
		self::$Code .= "\t".' * @return'."\t\t".'array|'.$class."\n";
		self::$Code .= "\t".' * @static'."\n";
		self::$Code .= "\t".' */'."\n";
		self::$Code .= "\t".'public static function FetchAll($params=array(\'orderBy\', \'from\', \'amount\')){'."\n";
		self::$Code .= "\t\t".'$'.$entity->table['name'].'Array = array();'."\n";
		self::$Code .= "\t\t".'$params = self::CheckParams($params, self::FetchAll);'."\n";
		self::$Code .= "\t\t".'$orderBy = array();'."\n";
		self::$Code .= "\t\t".'if(!empty($params[\'orderBy\'])){'."\n";
		self::$Code .= "\t\t\t".'$orderBy = implode(\',\', $params[\'orderBy\']);'."\n";
		self::$Code .= "\t\t".'}'."\n";
		self::$Code .= "\t\t".'$limit = \'\';'."\n";
		self::$Code .= "\t\t".'if(!empty($params[\'from\'])){'."\n";
		self::$Code .= "\t\t\t".'$limit = \'\'.$params[\'from\'];'."\n";
		self::$Code .= "\t\t\t".'if(!empty($params[\'amount\'])){'."\n";
		self::$Code .= "\t\t\t\t".'$limit .= \', \'.$params[\'amount\'];'."\n";
		self::$Code .= "\t\t\t".'} else {'."\n";
		self::$Code .= "\t\t\t\t".'$limit .= \', 10\';'."\n";
		self::$Code .= "\t\t\t".'}'."\n";
		self::$Code .= "\t\t".'}'."\n";
		self::$Code .= "\t\t".'$query = new Query();'."\n";
		self::$Code .= "\t\t".'$query->createSelect(array(\'*\'), \''.$entity->table['name'].'\', null, null, $orderBy, $limit);'."\n";
		self::$Code .= "\t\t".'$arrayArrays'.$class.' = $query->execute(true);'."\n";
		self::$Code .= "\t\t".'if(!empty($arrayArrays'.$class.')){'."\n";
		self::$Code .= "\t\t\t".'foreach($arrayArrays'.$class.' as $array'.ucfirst($class).'){'."\n";
		self::$Code .= "\t\t\t\t".'array_push($'.$entity->table['name'].'Array, self::CreateObjectFromArray($array'.ucfirst($class).'));'."\n";
		self::$Code .= "\t\t\t".'}'."\n";
		self::$Code .= "\t\t".'}'."\n";
		self::$Code .= "\t\t".'return $'.$entity->table['name'].'Array;'."\n";
		self::$Code .= "\t".'}'."\n\n";
	}
	
	/**
	 * Creates the FetchAll method
	 * 
	 * @param		string					$class
	 * @param		SimpleXmlElement		$entity
	 * @static
	 */
	public static function CreateSearch($class, $entity){
		self::$Code .= "\t".'/**'."\n";
		self::$Code .= "\t".' * Retrieves all '.ucfirst($entity->table['name']).' that matches the search text'."\n";
		self::$Code .= "\t".' * '."\n";
		self::$Code .= "\t".' * @param'."\t\t".'array|string'."\t\t".'$params'."\n";
		self::$Code .= "\t".' * @param'."\t\t".'bool'."\t\t\t\t".'$expectsOne'."\n";
		self::$Code .= "\t".' * @return'."\t\t".'array|'.$class."\n";
		self::$Code .= "\t".' * @static'."\n";
		self::$Code .= "\t".' */'."\n";
		self::$Code .= "\t".'public static function Search($params, $expectsOne=false){'."\n";
		self::$Code .= "\t\t".'$'.$entity->table['name'].'Array = array();'."\n";
		self::$Code .= "\t\t".'if(is_array($params)){'."\n";
		self::$Code .= "\t\t\t".'$params = self::CheckParams($params);'."\n";
		self::$Code .= "\t\t\t".'if(is_array($params[\'where\']) && isset($params[\'where\'][\'text\']) && isset($params[\'where\'][\'fields\'])){'."\n";
		self::$Code .= "\t\t\t\t".'$text = trim($params[\'where\'][\'text\']);'."\n";
		self::$Code .= "\t\t\t\t".'$searchs = array();'."\n";
		self::$Code .= "\t\t\t\t".'foreach($params[\'where\'][\'fields\'] as $field){'."\n";
		self::$Code .= "\t\t\t\t\t".'array_push($searchs, trim($field).\' LIKE "%\'.$text.\'%"\');'."\n";
		self::$Code .= "\t\t\t\t".'}'."\n";
		self::$Code .= "\t\t\t\t".'$where = implode(\' OR \', $searchs);'."\n";
		self::$Code .= "\t\t\t\t".'$orderBy = array();'."\n";
		self::$Code .= "\t\t\t\t".'if(!empty($params[\'orderBy\'])){'."\n";
		self::$Code .= "\t\t\t\t\t".'$orderBy = implode(\',\', $params[\'orderBy\']);'."\n";
		self::$Code .= "\t\t\t\t".'}'."\n";
		self::$Code .= "\t\t\t\t".'$limit = \'\';'."\n";
		self::$Code .= "\t\t\t\t".'if(!empty($params[\'from\'])){'."\n";
		self::$Code .= "\t\t\t\t\t".'$limit = \'\'.$params[\'from\'];'."\n";
		self::$Code .= "\t\t\t\t\t".'if(!empty($params[\'amount\'])){'."\n";
		self::$Code .= "\t\t\t\t\t\t".'$limit .= \', \'.$params[\'amount\'];'."\n";
		self::$Code .= "\t\t\t\t\t".'} else {'."\n";
		self::$Code .= "\t\t\t\t\t\t".'$limit .= \', 10\';'."\n";
		self::$Code .= "\t\t\t\t\t".'}'."\n";
		self::$Code .= "\t\t\t\t".'}'."\n";
		self::$Code .= "\t\t\t\t".'$query = new Query();'."\n";
		self::$Code .= "\t\t\t\t".'$query->createSelect(array(\'*\'), \''.$entity->table['name'].'\', null, $where, $orderBy, $limit);'."\n";
		self::$Code .= "\t\t\t\t".'$arrayArrays'.$class.' = $query->execute(true);'."\n";
		self::$Code .= "\t\t\t\t".'if(!empty($arrayArrays'.$class.')){'."\n";
		self::$Code .= "\t\t\t\t\t".'if($expectsOne){'."\n";
		self::$Code .= "\t\t\t\t\t\t".'return self::CreateObjectFromArray($arrayArrays'.ucfirst($class).'[0]);'."\n";
		self::$Code .= "\t\t\t\t\t".'}'."\n";
		self::$Code .= "\t\t\t\t\t".'foreach($arrayArrays'.$class.' as $array'.ucfirst($class).'){'."\n";
		self::$Code .= "\t\t\t\t\t\t".'array_push($'.$entity->table['name'].'Array, self::CreateObjectFromArray($array'.ucfirst($class).'));'."\n";
		self::$Code .= "\t\t\t\t\t".'}'."\n";
		self::$Code .= "\t\t\t\t".'} elseif($expectsOne){'."\n";
		self::$Code .= "\t\t\t\t\t".'return false;'."\n";
		self::$Code .= "\t\t\t\t".'}'."\n";
		self::$Code .= "\t\t\t".'} else {'."\n";
		self::$Code .= "\t\t\t\t".'throw new Exception(\'Unable to perform search with invalid params. '.ucfirst($class).'Model::Search()\');'."\n";
		self::$Code .= "\t\t\t".'}'."\n";
		self::$Code .= "\t\t".'} else {'."\n";
		self::$Code .= "\t\t\t".'throw new Exception(\'Unable to perform search with invalid params. '.ucfirst($class).'Model::Search()\');'."\n";
		self::$Code .= "\t\t".'}'."\n";
		self::$Code .= "\t\t".'return $'.$entity->table['name'].'Array;'."\n";
		self::$Code .= "\t".'}'."\n\n";
	}
	
	/**
	 * Creates the GetCount method
	 * 
	 * @param		SimpleXmlElement		$entity
	 * @static
	 */
	public static function CreateGetCount($entity){
		self::$Code .= "\t".'/**'."\n";
		self::$Code .= "\t".' * Retrieves the number of '.ucfirst($entity->table['name']).' stored in the data base'."\n";
		self::$Code .= "\t".' * '."\n";
		self::$Code .= "\t".' * @return'."\t\t".'int'."\n";
		self::$Code .= "\t".' * @static'."\n";
		self::$Code .= "\t".' */'."\n";
		self::$Code .= "\t".'public static function GetCount(){'."\n";
		self::$Code .= "\t\t".'$query = new Query();'."\n";
		self::$Code .= "\t\t".'$query->push(\'SELECT count(*) as count FROM '.$entity->table['name'].'\');'."\n";
		self::$Code .= "\t\t".'$result = $query->execute();'."\n";
		self::$Code .= "\t\t".'return $result[\'count\'];'."\n";
		self::$Code .= "\t".'}'."\n\n";
	}
	
	/**
	 * Creates the Delete method
	 * 
	 * @param		string					$class
	 * @param		SimpleXmlElement		$entity
	 * @static
	 */
	public static function CreateDelete($class, $entity){
		$pkName = (string)$entity->pk[0]->field['name'];
		$xmlPkType = ProjectGenerator::$Entities->xpath('/entities/entity[@name="'.$class.'"]/fields/field[@name="'.$pkName.'"]/@type');
		$pkType = (string) $xmlPkType[0]->type;
		$autoincrement = trim(strtolower($entity->table['autoincrement'])) == 'true';
		self::$Code .= "\t".'/**'."\n";
		self::$Code .= "\t".' *  Deletes '.ucfirst($class).' by id'."\n";
		self::$Code .= "\t".' * '."\n";
		self::$Code .= "\t".' * @param'."\t\t".'int'."\t\t".'$id'."\n";
		self::$Code .= "\t".' * @static'."\n";
		self::$Code .= "\t".' */'."\n";
		self::$Code .= "\t".'public static function Delete($id){'."\n";
		self::$Code .= "\t\t".'$query = new Query();'."\n";
		//TODO: Improve this to allow more than one primary key field
		if(($pkType == 'int') && $autoincrement){
			self::$Code .= "\t\t".'$query->createDelete(\''.$entity->table['name'].'\', $id);'."\n";
		} else {
			self::$Code .= "\t\t".'$query->createDelete(\''.$entity->table['name'].'\', array(\''.$pkName.'\'=>$id));'."\n";
		}
		self::$Code .= "\t\t".'return $query->execute();'."\n";
		self::$Code .= "\t".'}'."\n\n";
	}
	
	/**
	 * Generates the CreateBundleFromArray method
	 * 
	 * @param		string					$class
	 * @param		SimpleXmlElement		$entity
	 * @static
	 */
	public static function GenerateCreateBundleFromArray($class, $entity){
		self::$Code .= "\t".'/**'."\n";
		self::$Code .= "\t".' *  Creates '.ucfirst($class).' object from the basic properties'."\n";
		self::$Code .= "\t".' * '."\n";
		self::$Code .= "\t".' * @param'."\t\t".'array|string'."\t\t".'$properties'."\n";
		self::$Code .= "\t".' * @return'."\t\t".$class."\n";
		self::$Code .= "\t".' * @static'."\n";
		self::$Code .= "\t".' */'."\n";
		self::$Code .= "\t".'public static function CreateObjectFromArray($properties){'."\n";
		//TODO: Improve this to allow more than one primary key field
		$pkName = (string)$entity->pk[0]->field['name'];
		$xmlPkType = ProjectGenerator::$Entities->xpath('/entities/entity[@name="'.$class.'"]/fields/field[@name="'.$pkName.'"]/@type');
		$pkType = (string) $xmlPkType[0]->type;
		$autoincrement = trim($entity->table['autoincrement']) == 'true';
		$requiredFields = array();
		foreach($entity->fields->field as $field){
			$fieldName = (string)$field['name'];
			if(trim(strtolower($field['required'])) == 'true'){
				$fieldType = (string)$field['type'];
				if((strtoupper($fieldType) != 'STRING') && (strtoupper($fieldType) != 'TEXT') && (strtoupper($fieldType) != 'INT') && (strtoupper($fieldType) != 'FLOAT') && (strtoupper($fieldType) != 'BOOL') && (strtoupper($fieldType) != 'DATE')){
					$xmlRelatedEntityId = ProjectGenerator::$Entities->xpath('/entities/entity[@name="'.$fieldType.'"]/pk/field/@name');
					$relatedEntityId = (string) $xmlRelatedEntityId[0]->name;
					$fieldName = lcfirst($fieldType) . ucfirst($relatedEntityId);
				}
				array_push($requiredFields, $fieldName);
			}
		}
		//Validating
		self::$Code .= "\t\t".'$emptyValues = \'\';'."\n";
		foreach($requiredFields as $field){
			self::$Code .= "\t\t".'if(empty($properties["'.$field.'"])){'."\n";
			self::$Code .= "\t\t\t".'$emptyValues .= \' '.$field.'\';'."\n";
			self::$Code .= "\t\t".'}'."\n";
		}
		self::$Code .= "\t\t".'if(empty($emptyValues)){'."\n";
		foreach($entity->fields->field as $field){
			$fieldType = (string)$field['type'];
			$fieldName = (string)$field['name'];
			$fieldRequired = trim(strtolower($field['required'])) == 'true';
			if((strtoupper($fieldType) != 'STRING') && (strtoupper($fieldType) != 'TEXT') && (strtoupper($fieldType) != 'INT') && (strtoupper($fieldType) != 'FLOAT') && (strtoupper($fieldType) != 'BOOL') && (strtoupper($fieldType) != 'DATE')){
				$xmlRelatedEntityId = ProjectGenerator::$Entities->xpath('/entities/entity[@name="'.$fieldType.'"]/pk/field/@name');
				$relatedEntityId = (string) $xmlRelatedEntityId[0]->name;
				$fieldName = lcfirst($fieldType) . ucfirst($relatedEntityId);
				if($fieldRequired){
					self::$Code .= "\t\t\t".'$properties[\''.lcfirst($fieldType).'\'] = '.ucfirst($fieldType).'Model::FindById($properties[\''.$fieldName.'\']);'."\n";
					self::$Code .= "\t\t\t".'if(empty($properties[\''.lcfirst($fieldType).'\'])){'."\n";
					self::$Code .= "\t\t\t\t".'throw new Exception(\'Unable to find the '.ucfirst($fieldType).' for the '.$class.'.('.$class.'Model::CreateObjectFromArray())\');'."\n";
					self::$Code .= "\t\t\t".'}'."\n";
				} else {
					self::$Code .= "\t\t\t".'if(!empty($properties[\''.$fieldName.'\'])){'."\n";
					self::$Code .= "\t\t\t\t".'$properties[\''.lcfirst($fieldType).'\'] = '.ucfirst($fieldType).'Model::FindById($properties[\''.$fieldName.'\']);'."\n";
					self::$Code .= "\t\t\t\t".'if(empty($properties[\''.lcfirst($fieldType).'\'])){'."\n";
					self::$Code .= "\t\t\t\t\t".'throw new Exception(\'Unable to find the '.ucfirst($fieldType).' for the '.$class.'.('.$class.'Model::CreateObjectFromArray())\');'."\n";
					self::$Code .= "\t\t\t\t".'}'."\n";
					self::$Code .= "\t\t\t".'}'."\n";
				}
			}
		}
		self::$Code .= "\t\t\t".'return new '.$class.'($properties);'."\n";
		self::$Code .= "\t\t".'} else {'."\n";
		self::$Code .= "\t\t\t".'throw new Exception(\'Unable to create '.$class.' with empty required values:\'.$emptyValues.\' for '.$class.' "\'.$properties[\''.lcfirst($pkName).'\'].\'". ('.$class.'Model::CreateObjectFromArray())\');'."\n";
		self::$Code .= "\t\t".'}'."\n";
		self::$Code .= "\t".'}'."\n";
	}
	
	/**
	 * Creates the .php file
	 *
	 * @param		string		$class
	 * @static
	 */
	public static function CreateFile($class){
		$fileName = self::$Folder.$class.'Model.php';
		$fh = fopen($fileName , 'w') or die("can't open file");
		fwrite($fh, self::$Code);
		fclose($fh);
		if(is_file($fileName)){
			chmod($fileName, 0774);
		}
		echo '<b>File created:</b>'.$fileName.'<br />';
	}
}