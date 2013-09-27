<?php
/**
 * @author		David Curras
 * @version		December 4, 2012
 */

class User extends AbstractEntity {

	/**
	 * @var		string
	 */
	protected $id = null;

	/**
	 * @var		string
	 */
	protected $password = null;

	/**
	 * @var		string
	 */
	protected $name = null;

	/**
	 * @var		date
	 */
	protected $lastActionDate = null;

	/**
	 * @var		Role
	 */
	protected $role = null;

	/**
	 * @var		bool
	 */
	protected $active = null;

	/**
	 * @param		string		$id
	 */
	public function setId($id){
		$this->id = substr(strval($id), 0, 32);
	}

	/**
	 * @param		string		$password
	 */
	public function setPassword($password){
		$this->password = substr(strval($password), 0, 32);
	}

	/**
	 * @param		string		$name
	 */
	public function setName($name){
		$this->name = substr(strval($name), 0, 255);
	}

	/**
	 * @param		date		$lastActionDate
	 */
	public function setLastActionDate($lastActionDate){
		$this->lastActionDate = substr(strval($lastActionDate), 0, 32);
	}

	/**
	 * @param		Role		$role
	 */
	public function setRole($role){
		if(is_object($role)){
			$this->role = $role;
		} else {
			throw new Exception('Function expects an object as param. (User->setRole($role))');
		}
	}

	/**
	 * @param		bool		$active
	 */
	public function setActive($active){
		$this->active = $active;
	}

	/**
	 * @return		string
	 */
	public function getId(){
		return $this->id;
	}

	/**
	 * @return		string
	 */
	public function getPassword(){
		return $this->password;
	}

	/**
	 * @return		string
	 */
	public function getName(){
		return $this->name;
	}

	/**
	 * @return		date
	 */
	public function getLastActionDate(){
		return $this->lastActionDate;
	}

	/**
	 * @return		Role
	 */
	public function getRole(){
		return $this->role;
	}

	/**
	 * @return		bool
	 */
	public function getActive(){
		return $this->active;
	}

}