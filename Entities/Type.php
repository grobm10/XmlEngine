<?php
/**
 * @author		David Curras
 * @version		December 4, 2012
 */

class Type extends AbstractEntity {

	/**
	 * @var		int
	 */
	protected $id = null;

	/**
	 * @var		string
	 */
	protected $name = null;

	/**
	 * @param		int		$id
	 */
	public function setId($id){
		$this->id = intval($id);
	}

	/**
	 * @param		string		$name
	 */
	public function setName($name){
		$this->name = substr(strval($name), 0, 255);
	}

	/**
	 * @return		int
	 */
	public function getId(){
		return $this->id;
	}

	/**
	 * @return		string
	 */
	public function getName(){
		return $this->name;
	}

}