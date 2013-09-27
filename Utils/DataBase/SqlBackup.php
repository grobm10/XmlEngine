<?php

/**
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/DataBase/Backup.php
 */
class SqlBackup {
	
	/**
	 * The final sql backup string
	 * @var		string
	 */
	private $backup = '';
	
	/**
	 * The constructor handles the backup
	 */
	public function __construct(){
		$this->createHeader();
		$tables = $this->getTables();
		foreach($tables as $table){
			$this->createTableStructure($table);
			$this->createTableInserts($table);
		}
	}
	
	/**
	 * Adds the header lines to the buckup string
	 */
	private function createHeader(){
		$this->backup = 'CREATE DATABASE `'.MYSQL_DB.'` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;'."\n";
		$this->backup .= 'USE `'.MYSQL_DB.'`;'."\n\n";
		$this->backup .= '-- --------------------------------------------------------'."\n\n";
	}
	
	/**
	 * Retrieves the table name for all tables in the database
	 */
	private function getTables(){
		$tables = array();
		$query = new Query();
		$query->push('SHOW TABLES');
		$result = $query->execute();
		foreach($result as $tableArray){
			array_push($tables, $tableArray['Tables_in_'.MYSQL_DB]);
		}
		return $tables;
	}
	
	/**
	 * Adds the sql structure of the current table
	 * 
	 * @param		string		$table
	 */
	private function createTableStructure($table){
		$query = new Query();
		$query->push('SHOW CREATE TABLE '.$table);
		$structure = $query->execute();
		$createText = str_replace('CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $structure['Create Table']);
		$this->backup .= $createText.';'."\n\n";
	}
	
	/**
	 * Adds the sql inserts of the current table
	 * 
	 * @param		string		$table
	 */
	private function createTableInserts($table){
		$query = new Query();
		$query->push('SELECT * FROM '.$table);
		$inserts = $query->execute(true);
		if(!empty($inserts)){
			$fields = array();
			foreach($inserts[0] as $field => $value){
				array_push($fields, $field);
			}
			$values = array();
			foreach($inserts as $index => $entry){
				$entryValues = array();
				foreach($entry as $field => $value){
					array_push($entryValues, $value);
				}
				$entrySql = '(\''.implode('\', \'', $entryValues).'\')';
				array_push($values, $entrySql);
			}
			$this->backup .= 'INSERT INTO `'.$table.'` (`'.implode('`, `', $fields).'`) VALUES '."\n";
			$this->backup .= implode(','."\n", $values).';'."\n\n";
			$this->backup .= '-- --------------------------------------------------------'."\n\n";
		}
	}
	
	/**
	 * Prints in the browser the database backup string inside a XHTML <code> element
	 */
	public function printInBrowser(){
		echo '<code>'.$this->backup.'</code>';
	}
	
	/**
	 * Saves the database backup string in a file
	 * 
	 * @param		$folderPath
	 */
	public function saveInFile($folderPath=DB_BACKUPS_FOLDER){
		if(is_dir($folderPath)){
			$filePath = $folderPath.'db-'.date(Date::MYSQL_DATE_FORMAT).'.sql';
			$fh = fopen($filePath, 'w') or die('can\'t open file');
			fwrite($fh, $this->backup);
			fclose($fh);
		} else {
			throw new Exception('SQL backups directory "'.$folderPath.'" does not exists.');
		}
	}
}