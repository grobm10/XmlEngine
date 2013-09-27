<?php
/**
 * @author		David Curras
 * @version		February 25, 2013
 */

class Process extends AbstractEntity {

	/**
	 * @var		int
	 */
	protected $id = null;

	/**
	 * @var		Type
	 */
	protected $type = null;

	/**
	 * @var		State
	 */
	protected $state = null;

	/**
	 * @var		date
	 */
	protected $processDate = null;

	/**
	 * @var		Bundle
	 */
	protected $bundle = null;

	/**
	 * @var		string
	 */
	protected $issues = null;

	/**
	 * @param		int		$id
	 */
	public function setId($id){
		$this->id = intval($id);
	}

	/**
	 * @param		Type		$type
	 */
	public function setType($type){
		if(is_object($type)){
			$this->type = $type;
		} else {
			throw new Exception('Function expects an object as param. (Process->setType($type))');
		}
	}

	/**
	 * @param		State		$state
	 */
	public function setState($state){
		if(is_object($state)){
			$this->state = $state;
		} else {
			throw new Exception('Function expects an object as param. (Process->setState($state))');
		}
	}

	/**
	 * @param		date		$processDate
	 */
	public function setProcessDate($processDate){
		$this->processDate = substr(strval($processDate), 0, 32);
	}

	/**
	 * @param		Bundle		$bundle
	 */
	public function setBundle($bundle){
		if(is_object($bundle)){
			$this->bundle = $bundle;
		} else {
			throw new Exception('Function expects an object as param. (Process->setBundle($bundle))');
		}
	}

	/**
	 * @param		string		$issues
	 */
	public function setIssues($issues){
		$this->issues = substr(strval($issues), 0, 4096);
	}

	/**
	 * @return		int
	 */
	public function getId(){
		return $this->id;
	}

	/**
	 * @return		Type
	 */
	public function getType(){
		return $this->type;
	}

	/**
	 * @return		State
	 */
	public function getState(){
		return $this->state;
	}

	/**
	 * @return		date
	 */
	public function getProcessDate(){
		return $this->processDate;
	}

	/**
	 * @return		Bundle
	 */
	public function getBundle(){
		return $this->bundle;
	}

	/**
	 * @return		string
	 */
	public function getIssues(){
		return $this->issues;
	}

}