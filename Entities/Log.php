<?php
/**
 * @author		David Curras
 * @version		December 4, 2012
 */

class Log extends AbstractEntity {

	/**
	 * @var		int
	 */
	protected $id = null;

	/**
	 * @var		Process
	 */
	protected $process = null;

	/**
	 * @var		string
	 */
	protected $description = null;

	/**
	 * @var		bool
	 */
	protected $isError = null;

	/**
	 * @param		int		$id
	 */
	public function setId($id){
		$this->id = intval($id);
	}

	/**
	 * @param		Process		$process
	 */
	public function setProcess($process){
		if(is_object($process)){
			$this->process = $process;
		} else {
			throw new Exception('Function expects an object as param. (Log->setProcess($process))');
		}
	}

	/**
	 * @param		string		$description
	 */
	public function setDescription($description){
		$this->description = substr(strval($description), 0, 1023);
	}

	/**
	 * @param		bool		$isError
	 */
	public function setIsError($isError){
		$this->isError = $isError;
	}

	/**
	 * @return		int
	 */
	public function getId(){
		return $this->id;
	}

	/**
	 * @return		Process
	 */
	public function getProcess(){
		return $this->process;
	}

	/**
	 * @return		string
	 */
	public function getDescription(){
		return $this->description;
	}

	/**
	 * @return		bool
	 */
	public function getIsError(){
		return $this->isError;
	}

}