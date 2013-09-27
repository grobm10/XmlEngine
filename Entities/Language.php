<?php
/**
 * @author		David Curras
 * @version		December 4, 2012
 */

class Language extends AbstractEntity {

	/**
	 * @var		string
	 */
	protected $code = null;

	/**
	 * @var		string
	 */
	protected $alt = null;

	/**
	 * @var		string
	 */
	protected $name = null;

	/**
	 * @param		string		$code
	 */
	public function setCode($code){
		$this->code = substr(strval($code), 0, 3);
	}

	/**
	 * @param		string		$alt
	 */
	public function setAlt($alt){
		$this->alt = substr(strval($alt), 0, 2);
	}

	/**
	 * @param		string		$name
	 */
	public function setName($name){
		$this->name = substr(strval($name), 0, 255);
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
	public function getAlt(){
		return $this->alt;
	}

	/**
	 * @return		string
	 */
	public function getName(){
		return $this->name;
	}

}