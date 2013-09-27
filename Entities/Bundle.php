<?php
/**
 * @author		David Curras
 * @version		December 4, 2012
 */

class Bundle extends AbstractEntity {

	/**
	 * @var		int
	 */
	protected $id = null;

	/**
	 * @var		Video
	 */
	protected $video = null;

	/**
	 * @var		Language
	 */
	protected $language = null;

	/**
	 * @var		Region
	 */
	protected $region = null;

	/**
	 * @var		Partner
	 */
	protected $partner = null;

	/**
	 * @var		string
	 */
	protected $entityId = null;

	/**
	 * @param		int		$id
	 */
	public function setId($id){
		$this->id = intval($id);
	}

	/**
	 * @param		Video		$video
	 */
	public function setVideo($video){
		if(is_object($video)){
			$this->video = $video;
		} else {
			throw new Exception('Function expects an object as param. (Bundle->setVideo($video))');
		}
	}

	/**
	 * @param		Language		$language
	 */
	public function setLanguage($language){
		if(is_object($language)){
			$this->language = $language;
		} else {
			throw new Exception('Function expects an object as param. (Bundle->setLanguage($language))');
		}
	}

	/**
	 * @param		Region		$region
	 */
	public function setRegion($region){
		if(is_object($region)){
			$this->region = $region;
		} else {
			throw new Exception('Function expects an object as param. (Bundle->setRegion($region))');
		}
	}

	/**
	 * @param		Partner		$partner
	 */
	public function setPartner($partner){
		if(is_object($partner)){
			$this->partner = $partner;
		} else {
			throw new Exception('Function expects an object as param. (Bundle->setPartner($partner))');
		}
	}

	/**
	 * @param		string		$entityId
	 */
	public function setEntityId($entityId){
		$this->entityId = substr(strval($entityId), 0, 255);
	}

	/**
	 * @return		int
	 */
	public function getId(){
		return $this->id;
	}

	/**
	 * @return		Video
	 */
	public function getVideo(){
		return $this->video;
	}

	/**
	 * @return		Language
	 */
	public function getLanguage(){
		return $this->language;
	}

	/**
	 * @return		Region
	 */
	public function getRegion(){
		return $this->region;
	}

	/**
	 * @return		Partner
	 */
	public function getPartner(){
		return $this->partner;
	}

	/**
	 * @return		string
	 */
	public function getEntityId(){
		return $this->entityId;
	}

}