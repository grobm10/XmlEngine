<?php

/**
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/DataBase/Connection.php
 */
class Connection
{
	private $connection;
	private $database;
	private $charset;
	
	/**
	 * Creates a new MySql connection instance
	 * 
	 * @param	string	$host
	 * @param	string	$user
	 * @param	string	$pass
	 * @param	string	$db
	 * @throws Exception
	 */
	public function __construct($host=null, $user=null, $pass=null, $db=null){
		try{
			$this->createConnection($host, $user, $pass, $db);
		} catch(Exception $e) {
			throw new Exception("There was a low level fatal error connecting " 
									. "to Database. \n\t" . $e);
		}
	}	
			
	/** 
	 * Create the conection with mysql database
	 * @param	string	$host
	 * @param	string	$user
	 * @param	string	$pass
	 * @param	string	$db
	 */
	private function createConnection($host=null, $user=null, $pass=null, $db=null){
		if(empty($host)){
			$host = MYSQL_HOST;
		}
		if(empty($user)){
			$user = MYSQL_USER;
		}
		if(empty($pass)){
			$pass = MYSQL_PASS;
		}
		if(empty($db)){
			$db = MYSQL_DB;
		}
		$this->connection = mysql_connect($host, $user, $pass);
		$this->database = mysql_select_db($db);
		$this->charset = mysql_set_charset('utf8');
	}	
			
	/** 
	* Close the conection with mysql database
	*/
	public function close(){
		mysql_close($this->connection);
	}
}