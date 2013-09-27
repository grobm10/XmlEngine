<?php

/** 
 * @author			David Curras
 * @version			October 6, 2012
 * @filesource		/Utils/Server/Curl.php
 */
class CUrl {

	/**
	 * Multiple cUrl sessions
	 *
	 * @var		array		$sessions
	 */
	public $sessions = array();
	
	/**
	 * Number of retries
	 *
	 * @var		int		$retry
	 */
	public $retry = 0;
	
	/**
	 * Last error
	 *
	 * @var		string		$error
	 */
	public $error = null;
	
	/**
	 *	The only instance of the class
	 */
	private static $Instance;
	
	/**
	 * This class is a Singleton so must be intanciated with the static method getInstance()
	 */
	private function __construct() {}
	
	
	/**
	 *	The CUrl objets is automatically initialized if it wasn't.
	 *
	 *	@return		object
	 */
	public static function GetInstance(){
		if (!isset(self::$Instance)){
			self::$Instance = new self;
		}
		return self::$Instance;
	}
	
	/**
	 * Adds a cURL session to stack
	 *
	 * @param		string		$sessionName
	 * @param		string		$url
	 * @param		bool		$returnString
	 * @param		int			$timeOut
	 * @param		array		$options
	 */
	public function addSession($sessionName, $url, $returnString=true, $timeOut=10, $options=array()){
		if(!empty($sessionName) && !empty($url)){
			$newSession = curl_init($url);
			$this->sessions[$sessionName] = $newSession;
			$this->setOption($sessionName, CURLOPT_RETURNTRANSFER, $returnString);
			$this->setOption($sessionName, CURLOPT_CONNECTTIMEOUT, $timeOut); //Default timeout: 10 seconds
			if(!empty($options)){
				$this->setMultipleOptions($sessionName, $options);
			}
			return true;
		} else {
			$this->error = 'Failed to add session "'.$sessionName.'" with url "'.$url.'"';
			return false;
		}
	}
	
	/**
	 * Sets one or more options to a cURL session
	 * 
	 * @param		string				$sessionName
	 * @param		array|string		$options
	 * @see			http://www.php.net/manual/en/function.curl-setopt.php
	 * @see			http://www.php.net/manual/en/function.curl-setopt-array.php
	 */
	public function setMultipleOptions($sessionName, $options){
		if(is_array($options)){
			foreach($options as $option){
				if(is_set($option['name']) && is_set($option['value'])){
					if(!$this->setOption($sessionName, $option['name'], $option['value'])){
						return false;
					}
				} else {
					$this->error = 'Wrong param format, expected array("name"=>$curlConstant, "value"=>$value)';
					return false;
				}
			}
			return true;
		} else {
			$this->error = 'Wrong param type, array expected in CUrl->setMultipleOptions()';
			return false;
		}
	}
	
	/**
	 * Sets one option to a cURL session
	 * 
	 *
	 * @param		string				$sessionName
	 * @param		constant			$name
	 * @param		string				$value
	 * @see			http://www.php.net/manual/en/function.curl-setopt.php
	 */
	public function setOption($sessionName, $name, $value){
		if(isset($this->sessions[$sessionName])){
			if(!empty($name) && !empty($value)){
				if(curl_setopt($this->sessions[$sessionName], $name, $value)){
					return true;
				} else {
					$this->error = 'Failed to add cURL option. Check that you are giving a proper cURL constant and value';
				}
			} else {
				$this->error = 'Failed to add option "'.$name.'" with value "'.$value.'" to the session "'.$sessionName.'"';
				return false;
			}
		} else {
			$this->error = 'CUrl session "'.$sessionName.'" does not exist';
			return false;
		}
	}
	
	/**
	 * Executes the requested CUrl session
	 *
	 * @param		string		$sessionName
	 * @return		mixed
	 */
	public function executeOne($sessionName){
		if(isset($this->sessions[$sessionName])){
			$tries = 0;
			while($tries <= $this->retry){
				if($result = curl_exec($this->sessions[$sessionName])){
					return $result;
				} else {
					$this->error = $this->getSessionError($sessionName);
					$responseCode = $this->info($sessionName, CURLINFO_HTTP_CODE);
					if(intval($responseCode) < 400){
						++$tries;
					} else {
						return false;
					}
				}
			}
		} else {
			$this->error = 'CUrl session "'.$sessionName.'" does not exist';
			return false;
		}
	}
	
	
	/**
	 * Executes all sessions
	 * 
	 * @return 		array
	 * @see			http://www.php.net/manual/en/function.curl-multi-exec.php
	 */
	public function executeAll(){
		$mh = curl_multi_init();
		foreach ($this->sessions as $sessionName => $session ){
			curl_multi_add_handle($mh, $session);
		}
		$active = null;
		do{
			$mrc = curl_multi_exec( $mh, $active );
		} while ($mrc == CURLM_CALL_MULTI_PERFORM );
	
		while ( $active && $mrc == CURLM_OK ){
			if ( curl_multi_select( $mh ) != -1 ){
				do{
					$mrc = curl_multi_exec( $mh, $active );
				} while ( $mrc == CURLM_CALL_MULTI_PERFORM );
			}
		}
		
		if ( $mrc != CURLM_OK ){
			$this->error = 'Curl multi read error '.$mrc;
		}
		$responses = array();
		#Get content foreach session, retry if applied
		foreach ($this->sessions as $sessionName => $session ){
			$responseCode = $this->info($sessionName, CURLINFO_HTTP_CODE);
			if(($responseCode > 0) && ($responseCode < 400)){
				$responses[$sessionName] = curl_multi_getcontent($this->sessions[$sessionName]);
			} else {
				$tries = 0;
				while($tries <= $this->retry){
					$responses[$sessionName] = $this->executeOne($sessionName);
					if($responses[$sessionName]){
						break;
					} else {
						++$tries;
					}
				}
			}
			curl_multi_remove_handle($mh, $this->sessions[$sessionName]);
		}
		curl_multi_close( $mh );
		return $responses;
	}
	
	/**
	 * Returns an array of session information
	 * 
	 * @param		string			$sessionName
	 * @param		constant		$option
	 * @return		mixed
	 * @see			http://www.php.net/manual/en/function.curl-getinfo.php
	 */
	public function getInfo($sessionName='', $option=false){
		if(!empty($sessionName)){
			if(isset($this->sessions[$sessionName])){
				if(!empty($option)){
					return curl_getinfo($this->sessions[$sessionName], $option);
				} else{
					return curl_getinfo($this->sessions[$sessionName]);
				}
			} else {
				$this->error = 'CUrl session "'.$sessionName.'" does not exist';
				return false;
			}
		} else {
			$info = array();
			foreach($this->sessions as $sessionName => $session ){
				if(!empty($option)){
					$info[$sessionName] = curl_getinfo($this->sessions[$sessionName], $option);
				} else{
					$info[$sessionName] = curl_getinfo($this->sessions[$sessionName]);
				}
			}
			return $info;
		}
	}
	
	/**
	 * Return a string or an array of string containing the last error for the session
	 * 
	 * @param		string			$sessionName
	 * @return		array|string
	 * @see			http://www.php.net/manual/en/function.curl-error.php
	 */
	public function getSessionErrors($sessionName=null){
		if(!empty($sessionName)){
			if(isset($this->sessions[$sessionName])){
				return curl_error($this->sessions[$sessionName]);
			} else {
				$this->error = 'CUrl session "'.$sessionName.'" does not exist';
				return false;
			}
		} else {
			$errors = array();
			foreach($this->sessions as $sessionName => $session){
				$errors[$sessionName] = curl_error($session);
			}
			return $errors;
		}
	}
	
	/**
	 * Closes one cURL session
	 * 
	 * @param		string			$sessionName
	 */
	public function closeSession($sessionName){
		if(isset($this->sessions[$sessionName])){
			return curl_close($this->sessions[$sessionName]);
		} else {
			$this->error = 'CUrl session "'.$sessionName.'" does not exist';
			return false;
		}
	}
	
	/**
	 * Removes all cURL sessions
	 */
	public function clear() {
		foreach($this->sessions as $sessionName => $session){
			if(closeSession($sessionName)){
				unset($this->sessions[$sessionName]);
			} else {
				$this->error = 'Failed to close session "'.$sessionName.'"';
				return false;
			}
		}
	}
	
	/**
	 *	Removes all cURL sessions and destroys the current object.
	 *
	 *	@return		bool
	 */
	public function destroy() {
		if(isset(self::$Instance)){
			self::$Instance->clear();
			self::$Instance = false;
			return true;
		}
		return false;
	}
}