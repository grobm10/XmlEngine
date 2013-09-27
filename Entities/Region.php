<?php
/**
 * @author		David Curras
 * @version		December 4, 2012
 */

class Region extends AbstractEntity {

	/**
	 * @var		string
	 */
	protected $code = null;

	/**
	 * @var		string
	 */
	protected $country = null;

	/**
	 * @var		Language
	 */
	protected $language = null;

	/**
	 * @param		string		$code
	 */
	public function setCode($code){
		$this->code = substr(strval($code), 0, 2);
	}

	/**
	 * @param		string		$country
	 */
	public function setCountry($country){
		$this->country = substr(strval($country), 0, 255);
	}

	/**
	 * @param		Language		$language
	 */
	public function setLanguage($language){
		if(is_object($language)){
			$this->language = $language;
		} else {
			throw new Exception('Function expects an object as param. (Region->setLanguage($language))');
		}
	}

	/**
	 * @return		string
	 */
	public function getCode(){
		return $this->code;
	}

	/**
	 * @return		string
	 */
	public function getCountry(){
		return $this->country;
	}

	/**
	 * @return		Language
	 */
	public function getLanguage(){
		return $this->language;
	}

}