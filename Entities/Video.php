<?php
/**
 * @author		David Curras
 * @version		December 4, 2012
 */

class Video extends AbstractEntity {

	/**
	 * @var		int
	 */
	protected $id = null;

	/**
	 * @var		Metadata
	 */
	protected $metadata = null;

	/**
	 * @var		string
	 */
	protected $audioCodec = null;

	/**
	 * @var		string
	 */
	protected $createdBy = null;

	/**
	 * @var		date
	 */
	protected $creationDate = null;

	/**
	 * @var		string
	 */
	protected $dTOVideoType = null;

	/**
	 * @var		string
	 */
	protected $duration = null;

	/**
	 * @var		date
	 */
	protected $fileCreateDate = null;

	/**
	 * @var		date
	 */
	protected $fileModificationDate = null;

	/**
	 * @var		string
	 */
	protected $fileName = null;

	/**
	 * @var		string
	 */
	protected $imageSize = null;

	/**
	 * @var		date
	 */
	protected $lastAccessed = null;

	/**
	 * @var		date
	 */
	protected $lastModified = null;

	/**
	 * @var		string
	 */
	protected $mD5Hash = null;

	/**
	 * @var		bool
	 */
	protected $mD5HashRecal = null;

	/**
	 * @var		string
	 */
	protected $mimeType = null;

	/**
	 * @var		string
	 */
	protected $size = null;

	/**
	 * @var		string
	 */
	protected $storedOn = null;

	/**
	 * @var		string
	 */
	protected $timecodeOffset = null;

	/**
	 * @var		string
	 */
	protected $videoBitrate = null;

	/**
	 * @var		string
	 */
	protected $videoCodec = null;

	/**
	 * @var		string
	 */
	protected $videoElements = null;

	/**
	 * @var		string
	 */
	protected $videoFrameRate = null;

	/**
	 * @param		int		$id
	 */
	public function setId($id){
		$this->id = intval($id);
	}

	/**
	 * @param		Metadata		$metadata
	 */
	public function setMetadata($metadata){
		if(is_object($metadata)){
			$this->metadata = $metadata;
		} else {
			throw new Exception('Function expects an object as param. (Video->setMetadata($metadata))');
		}
	}

	/**
	 * @param		string		$audioCodec
	 */
	public function setAudioCodec($audioCodec){
		$this->audioCodec = substr(strval($audioCodec), 0, 255);
	}

	/**
	 * @param		string		$createdBy
	 */
	public function setCreatedBy($createdBy){
		$this->createdBy = substr(strval($createdBy), 0, 255);
	}

	/**
	 * @param		date		$creationDate
	 */
	public function setCreationDate($creationDate){
		$this->creationDate = substr(strval($creationDate), 0, 32);
	}

	/**
	 * @param		string		$dTOVideoType
	 */
	public function setDTOVideoType($dTOVideoType){
		$this->dTOVideoType = substr(strval($dTOVideoType), 0, 255);
	}

	/**
	 * @param		string		$duration
	 */
	public function setDuration($duration){
		$this->duration = substr(strval($duration), 0, 255);
	}

	/**
	 * @param		date		$fileCreateDate
	 */
	public function setFileCreateDate($fileCreateDate){
		$this->fileCreateDate = substr(strval($fileCreateDate), 0, 32);
	}

	/**
	 * @param		date		$fileModificationDate
	 */
	public function setFileModificationDate($fileModificationDate){
		$this->fileModificationDate = substr(strval($fileModificationDate), 0, 32);
	}

	/**
	 * @param		string		$fileName
	 */
	public function setFileName($fileName){
		$this->fileName = substr(strval($fileName), 0, 255);
	}

	/**
	 * @param		string		$imageSize
	 */
	public function setImageSize($imageSize){
		$this->imageSize = substr(strval($imageSize), 0, 255);
	}

	/**
	 * @param		date		$lastAccessed
	 */
	public function setLastAccessed($lastAccessed){
		$this->lastAccessed = substr(strval($lastAccessed), 0, 32);
	}

	/**
	 * @param		date		$lastModified
	 */
	public function setLastModified($lastModified){
		$this->lastModified = substr(strval($lastModified), 0, 32);
	}

	/**
	 * @param		string		$mD5Hash
	 */
	public function setMD5Hash($mD5Hash){
		$this->mD5Hash = substr(strval($mD5Hash), 0, 255);
	}

	/**
	 * @param		bool		$mD5HashRecal
	 */
	public function setMD5HashRecal($mD5HashRecal){
		$this->mD5HashRecal = $mD5HashRecal;
	}

	/**
	 * @param		string		$mimeType
	 */
	public function setMimeType($mimeType){
		$this->mimeType = substr(strval($mimeType), 0, 255);
	}

	/**
	 * @param		string		$size
	 */
	public function setSize($size){
		$this->size = substr(strval($size), 0, 255);
	}

	/**
	 * @param		string		$storedOn
	 */
	public function setStoredOn($storedOn){
		$this->storedOn = substr(strval($storedOn), 0, 255);
	}

	/**
	 * @param		string		$timecodeOffset
	 */
	public function setTimecodeOffset($timecodeOffset){
		$this->timecodeOffset = substr(strval($timecodeOffset), 0, 255);
	}

	/**
	 * @param		string		$videoBitrate
	 */
	public function setVideoBitrate($videoBitrate){
		$this->videoBitrate = substr(strval($videoBitrate), 0, 255);
	}

	/**
	 * @param		string		$videoCodec
	 */
	public function setVideoCodec($videoCodec){
		$this->videoCodec = substr(strval($videoCodec), 0, 255);
	}

	/**
	 * @param		string		$videoElements
	 */
	public function setVideoElements($videoElements){
		$this->videoElements = substr(strval($videoElements), 0, 255);
	}

	/**
	 * @param		string		$videoFrameRate
	 */
	public function setVideoFrameRate($videoFrameRate){
		$this->videoFrameRate = substr(strval($videoFrameRate), 0, 255);
	}

	/**
	 * @return		int
	 */
	public function getId(){
		return $this->id;
	}

	/**
	 * @return		Metadata
	 */
	public function getMetadata(){
		return $this->metadata;
	}

	/**
	 * @return		string
	 */
	public function getAudioCodec(){
		return $this->audioCodec;
	}

	/**
	 * @return		string
	 */
	public function getCreatedBy(){
		return $this->createdBy;
	}

	/**
	 * @return		date
	 */
	public function getCreationDate(){
		return $this->creationDate;
	}

	/**
	 * @return		string
	 */
	public function getDTOVideoType(){
		return $this->dTOVideoType;
	}

	/**
	 * @return		string
	 */
	public function getDuration(){
		return $this->duration;
	}

	/**
	 * @return		date
	 */
	public function getFileCreateDate(){
		return $this->fileCreateDate;
	}

	/**
	 * @return		date
	 */
	public function getFileModificationDate(){
		return $this->fileModificationDate;
	}

	/**
	 * @return		string
	 */
	public function getFileName(){
		return $this->fileName;
	}

	/**
	 * @return		string
	 */
	public function getImageSize(){
		return $this->imageSize;
	}

	/**
	 * @return		date
	 */
	public function getLastAccessed(){
		return $this->lastAccessed;
	}

	/**
	 * @return		date
	 */
	public function getLastModified(){
		return $this->lastModified;
	}

	/**
	 * @return		string
	 */
	public function getMD5Hash(){
		return $this->mD5Hash;
	}

	/**
	 * @return		bool
	 */
	public function getMD5HashRecal(){
		return $this->mD5HashRecal;
	}

	/**
	 * @return		string
	 */
	public function getMimeType(){
		return $this->mimeType;
	}

	/**
	 * @return		string
	 */
	public function getSize(){
		return $this->size;
	}

	/**
	 * @return		string
	 */
	public function getStoredOn(){
		return $this->storedOn;
	}

	/**
	 * @return		string
	 */
	public function getTimecodeOffset(){
		return $this->timecodeOffset;
	}

	/**
	 * @return		string
	 */
	public function getVideoBitrate(){
		return $this->videoBitrate;
	}

	/**
	 * @return		string
	 */
	public function getVideoCodec(){
		return $this->videoCodec;
	}

	/**
	 * @return		string
	 */
	public function getVideoElements(){
		return $this->videoElements;
	}

	/**
	 * @return		string
	 */
	public function getVideoFrameRate(){
		return $this->videoFrameRate;
	}

}