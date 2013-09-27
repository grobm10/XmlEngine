<?php

/**
 * @author			David Curras
 * @version			March 13, 2013
 * @filesource		/Utils/Data/Validate.php
 */
class Validate{
	
	/**
	 * Returns false if the given string is a valid email address
	 * otherwise return the valid email string
	 */
	public static function Email($string, $sanitize=true){
		if($sanitize){
			$string = filter_var($string, FILTER_SANITIZE_EMAIL);
		}
		return filter_var($string, FILTER_VALIDATE_EMAIL);
	}
	
	/**
	 * Returns false if the given string is a valid url address
	 * otherwise return the valid url string
	 */
	public static function URL($string, $sanitize=true){
		if($sanitize){
			$string = filter_var($string, FILTER_SANITIZE_URL);
		}
		return filter_var($string, FILTER_VALIDATE_URL);
	}
	
	/**
	 * Returns false if the given string is a valid ip address
	 * otherwise return the valid ip string
	 */
	public static function IP($string){
		return filter_var($string, FILTER_VALIDATE_IP);
	}
	
	/** 
	 * Parses an string and return true if only has alfa numeric chars
	 * 
	 * @param		string		$string
	 * @return		bool
	 * @static
	 */
	public static function StringAlphaNumeric($string){
		if(empty($string)){
			return false;
		}
		$chars = str_split($string);
		foreach($chars as $char){
			if(!self::StringAlpha($char) && !self::StringNumeric($char)){
				return false;
			}
		}
		return true;
	}
	
	/** 
	 * Parses an string and return true if only has alfa chars
	 * 
	 * @param		string		$string
	 * @return		bool
	 * @static
	 */
	public static function StringAlpha($string){
		if(empty($string)){
			return false;
		}
		$chars = str_split($string);
		foreach($chars as $char){
			if(ord($char) < 64 || (ord($char) > 90 && ord($char) < 97) || ord($char) > 122){
				return false;
			}
		}
		return true;
	}
	
	/** 
	 * Parses an string and return true if only has numeric chars
	 * 
	 * @param		string		$string
	 * @return		bool
	 * @static
	 */
	public static function StringNumeric($string){
		if(empty($string)){
			return false;
		}
		$chars = str_split($string);
		foreach($chars as $char){
			if(ord($char) < 48 || ord($char) > 57 ){
				return false;
			}
		}
		return true;
	}
	/**
	 * Adds a xml line with tabs to the current xml content
	 * 
	 * @param	string		$type
	 * @param	mixed		$var
	 */
	public static function InstaceOf($type, $var){
		$realType = gettype($var);	
		if(!empty($type)){
			switch(strtolower($type)){
				case 'string':
				case 'array':
				case 'boolean':
				case 'integer':
				case 'double':
					return $realType === strtolower($type);
				case 'bool':
					return $realType === 'bool';
				case 'int':
					return $realType === 'integer';
				case 'float':
				case 'decimal':
					return $realType === 'double';
				default:
					return strtolower($type) === strtolower(get_class($var));
			}
		} else {
			throw new Exception('Validate::InstaceOf expects parameter 1 to be string');
		}
	}
}