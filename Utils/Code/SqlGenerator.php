<?php

/**
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/Code/SqlGenerator.php
 */
class SqlGenerator {
	
	/**
	 * The folder path where the .sql file will be created
	 *
	 * @var		string
	 */
	protected static $Folder = array();

	/**
	 * The output code
	 *
	 * @var		string
	 */
	protected static $Code = '';
	
	/**
	 * The foreing key list
	 *
	 * @var		string
	 */
	protected static $FkList = array();
	
	/**
	 * Loads the folders table and other initial values
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
		self::CreateHeader();
		self::CreateTables();
		self::CreateRelationships();
		self::CreateFile();
	}
	
	/**
	 * Creates the header
	 * 
	 * @static
	 */
	public static function CreateHeader(){
		self::$Code = 'SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";' . "\n";
		self::$Code  .= 'SET time_zone = "+00:00";' . "\n\n";
		self::$Code .= 'CREATE DATABASE `'. ProjectGenerator::$DbName .'` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;' . "\n";
		self::$Code .= 'USE `'. ProjectGenerator::$DbName .'`;' . "\n\n";
		self::$Code .= '-- --------------------------------------------------------' . "\n\n";
	}
	
	/**
	 * Creates the tables
	 *
	 * @static
	 */
	public static function CreateTables(){
		foreach(ProjectGenerator::$Entities as $entity){
			$table = (string) $entity->table['name'];
			self::$Code .= 'CREATE TABLE IF NOT EXISTS `'. $table .'` (' . "\n";
			$autoincrement = trim(strtolower($entity->table['autoincrement'])) == 'true';
			//Prepare array of Primary Keys
			$pkList = array();
			foreach($entity->pk as $keys){
				array_push($pkList,(string)$keys->field['name']);
			}
			//Adding Foreing Keys array
			self::$FkList[$table] = array();
			//Adding fields
			$fieldList = array();
			foreach($entity->fields->field as $field){
				$fieldName = '';
				$fieldType = '';
				$fieldRequired = trim(strtolower($field['required'])) == 'true';
				$fieldLength = '';
				switch (strtoupper($field['type'])) {
					case 'STRING':
						$fieldLength = (string)$field['length'];
					case 'TEXT':
					case 'INT':
					case 'FLOAT':
					case 'DATE':
					case 'BOOL':
						$fieldName = (string)$field['name'];
						$fieldType = (string)$field['type'];
						break;
					default:
						$xmlRelatedEntityId = ProjectGenerator::$Entities->xpath('/entities/entity[@name="'.$field['type'].'"]/pk/field/@name');
						$relatedEntityId = (string) $xmlRelatedEntityId[0]->name;
						$fieldName = strtolower($field['type']) . ucfirst($relatedEntityId);
						$xmlRelatedEntityType = ProjectGenerator::$Entities->xpath('/entities/entity[@name="'.$field['type'].'"]/fields/field[@name="'.$relatedEntityId.'"]/@type');
						$fieldType = (string) $xmlRelatedEntityType[0]->type;
						if(strtoupper($fieldType) == 'STRING'){
							$xmlRelatedEntityLength = ProjectGenerator::$Entities->xpath('/entities/entity[@name="'.$field['type'].'"]/fields/field[@name="'.$relatedEntityId.'"]/@length');
							$fieldLength = (string) $xmlRelatedEntityLength[0]->length;
						}
						//Prepare array of Foreing Keys
						$xmlForeingTable = ProjectGenerator::$Entities->xpath('/entities/entity[@name="'.$field['type'].'"]/table/@name');
						$foreingTable = (string) $xmlForeingTable[0]->name;
						self::$FkList[$table][$fieldName] = array($foreingTable, $relatedEntityId);
						break;
				}
				$settingsArray = array();
				switch (strtoupper($fieldType)) {
					case 'STRING':
						array_push($settingsArray, 'varchar('.$fieldLength.')');
						break;
					case 'TEXT':
						array_push($settingsArray, 'text');
						break;
					case 'INT':
						array_push($settingsArray, 'int(11)');
						break;
					case 'FLOAT':
						array_push($settingsArray, 'decimal(11,3)');
						break;
					case 'DATE':
						array_push($settingsArray, 'datetime');
						break;
					case 'BOOL':
						array_push($settingsArray, 'tinyint(1)');
						break;
					default:
						throw new Exception('Unable to recognize field type. ProjectGenerator::CreateSqlCode');
						break;
				}
				//check if required
				if($fieldRequired){
					array_push($settingsArray, 'NOT NULL');
				} else {
					array_push($settingsArray, 'DEFAULT NULL');
				}
				//check is pk and autoincrement
				if(in_array($fieldName, $pkList) && $autoincrement){
					array_push($settingsArray, 'AUTO_INCREMENT');
				}
				self::$Code .= "\t" . '`'. $fieldName .'` '. implode(' ', $settingsArray) .',' . "\n";
				array_push($fieldList, $fieldName);
			}
			//Adding primary and regular keys
			self::$Code .= "\t" . 'PRIMARY KEY (`'. implode('`, `', $pkList) .'`),' . "\n";
			foreach(self::$FkList[$table] as $field => $relation){
				self::$Code .= "\t" . 'KEY `'. $field .'` (`'. $field .'`),' . "\n";
			}
			//Closing the table declaration
			self::$Code = substr(self::$Code, 0, -2) . "\n"; //Deletes the last "end-line" and "comma" chars
			self::$Code .= ') ENGINE=InnoDB DEFAULT CHARSET=utf8';
			if($autoincrement){
				self::$Code .= ' AUTO_INCREMENT=1';
			}
			self::$Code .= ';' . "\n\n";
			//Creating inserts lines for the current table
			$inserts = ProjectGenerator::$Inserts->xpath('/inserts/entries[@table="'.$table.'"]/entry');
			$insertArray = array();
			foreach($inserts as $entry){
				$data = array();
				foreach($entry->field as $field){
					$fieldData = (string)$field;
					array_push($data, $fieldData);
				}
				array_push($insertArray, $data);
			}
			if(!empty($insertArray)){
				self::$Code .= 'INSERT INTO `'.$table.'` (`' . implode('`, `', $fieldList) . '`) VALUES' . "\n";
				$insertStrings = array();
				foreach($insertArray as $values){
					array_push($insertStrings, '(\'' . implode('\', \'', $values) . '\')');
				}
				self::$Code .= "\t" . str_ireplace('\'NULL\'', 'NULL', implode(",\n\t", $insertStrings)) . ';' . "\n\n";;
			}
			self::$Code .= '-- --------------------------------------------------------' . "\n\n";
		}
	}
	
	/**
	 * Creates the relationships
	 *
	 * @static
	 */
	public static function CreateRelationships(){
		foreach(self::$FkList as $table => $fkList){
			if(!empty($fkList)){
				self::$Code .= 'ALTER TABLE `'. $table .'`' . "\n";
				$i = 1;
				foreach($fkList as $field => $relation){
					self::$Code .= "\t" . 'ADD CONSTRAINT `'. $table .'_ibfk_'. $i .'` FOREIGN KEY (`' . $field . '`) REFERENCES `' . $relation[0] . '` (`' . $relation[1] . '`),' . "\n";
					++$i;
				}
				self::$Code = substr(self::$Code, 0, -2) . ";\n\n"; //Deletes the last "end-line" and "comma" chars
			}
		}
	}
	
	/**
	 * Creates the .sql file
	 *
	 * @static
	 */
	public static function CreateFile(){
		$fileName = self::$Folder . ProjectGenerator::$DbName . '.sql';
		$fh = fopen($fileName , 'w') or die("can't open file");
		fwrite($fh, self::$Code);
		fclose($fh);
		if(is_file($fileName)){
			chmod($fileName, 0774);
		}
		echo '<b>File created:</b>' . $fileName . '<br />';
	}
}