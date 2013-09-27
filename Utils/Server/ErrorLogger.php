<?php
/** 
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/Server/ErrorLogger.php
 */

class ErrorLogger
{
	/**
	 *	The unique instance of the class
	 */
	private static $instance;
	
	/**
	 *	An array of Log objects to save in database
	 */
	private $dbLogs;
	
	/**
	 *	An array of text lines to print in a log file
	 */
	private $fileLogs;
	
	/**
	 *	The current process type
	 */
	private $processType;
	
	/**
	 *	The current Bundle partner
	 */
	private $partner;
	
	/**
	 *	The processing bundle
	 */
	private $bundleFileName;
	
	/**
	 *	The log file name for the current process
	 */
	private $logFileName;
	
	/**
	 *	The processing bundle id
	 */
	private $currentBundleId;
	
	/**
	 * This class is a Singleton, 
	 * so must be intanciated with the static method getInstance()
	 */
	private function __construct() {
		$this->dbLogs = array();
		$this->fileLogs = array();
		$this->processType = Type::UNDEFINED;
		$this->partner = null;
		$this->bundleFileName = '';
		$this->setLogFileName();
		$this->currentBundleId = null;
	}
	
	/**
	 *	The error logger is automatically initialized if it wasn't.
	 *
	 *	@example	$errorLogger = ErrorLogger::getInstance();
	 *	@return		object	The instance of 'ErrorLogger'
	 */
	public static function getInstance()
	{
		if ( !isset(self::$instance) || empty(self::$instance)){
			self::$instance = new self;
		}
		return self::$instance;
	}
	
	/**
	 *	Unsets the current instance
	 *
	 *	@example	ErrorLogger::destroy();
	 */
	public static function destroy()
	{
		if (isset(self::$instance)){
			self::$instance = null;
		}
	}

	/**
	 *	Sets the current Process Type
	 */
	public function setProcessType($processType)
	{
		$this->processType = $processType;
		$this->setLogFileName();
	}
	
	/**
	 *	Sets the current log file name with processType
	 *
	 *	@example	$this->setLogFileName();
	 */
	private function setLogFileName()
	{
		switch ($this->processType) {
			case Type::MERGE:
				$this->logFileName = date(Date::MYSQL_DATE_FORMAT).'_MERGE'.LOGS_FILE_EXTENSION;
				break;
			case Type::CONVERSION:
				$this->logFileName = date(Date::MYSQL_DATE_FORMAT).'_CONVERSION'.LOGS_FILE_EXTENSION;
				break;
			case Type::TRANSPORTER:
				$this->logFileName = date(Date::MYSQL_DATE_FORMAT).'_TRANSPORTER'.LOGS_FILE_EXTENSION;
				break;
			case Type::FRONTEND:
			case Type::UNDEFINED:
			default:
				$this->logFileName = date(Date::MYSQL_DATE_FORMAT).'_UNDEFINED_PROCESS_TYPE'.LOGS_FILE_EXTENSION;
				break;
		}
	}

	/**
	 *	Sets the current Partner
	 */
	public function setPartner($partner)
	{
		switch (strtolower($partner)){
			case SONY_DTO_FOLDER_NAME:
			case 'sony':
				$this->partner = 'SONY';
				break;
			case ITUNES_DTO_FOLDER_NAME:
			case 'itunes':
				$this->partner = 'ITUNES';
				break;
			case STARHUB_DTO_FOLDER_NAME:
			case 'starhub':
				$this->partner = 'STARHUB';
				break;
			default:
				$this->partner = 'UNDEFINED_PARTNER';
		}
	}

	/**
	 *	Sets the processing file
	 */
	public function setBundleFileName($bundleFileName)
	{
		if(!empty($bundleFileName) && is_string($bundleFileName)){
			$this->bundleFileName = $bundleFileName;
		}
	}

	/**
	 *	Sets the processing bundle id
	 */
	public function setCurrentBundleId($currentBundleId)
	{
		$id = intval($currentBundleId);
		if($id > 0){
			$this->currentBundleId = $currentBundleId;
		}
	}
	
	/**
	 *	Saves the error into the database or a lof file properly
	 *
	 *	@param		String 		$description
	 *	@param		Bool 		$isError
	 *	@example	$errorLogger->addDbLog('Exception message', true);
	 */
	public function addDbLog($description, $isError=true)
	{
		if(is_string($description)){
			$log = new Log(array(
					'description'=>$description,
					'isError'=>$isError,
					'active'=>true
				));
			array_push($this->dbLogs, $log);
		} else {
			$this->addFileLog('Can\'t find the log description.');
		}
	}

	/**
	 *	Saves the error into the database or a lof file properly
	 *
	 *	@param		string 		$logDescription
	 *	@example	$errorLogger->addFileLog();
	 */
	public function addFileLog($logDescription)
	{
		array_push($this->fileLogs, $logDescription);
	}

	/**
	 *	Saves the error into the database or a log file properly, 
	 *	then clears the logs arrays 
	 *
	 *	@example	$errorLogger->saveError();
	 */
	public function saveErrors()
	{
		if(!empty($this->fileLogs) || !empty($this->dbLogs)){
			//set the log process header text for file logs
			$headerText;
			if(!empty($this->bundleFileName)){
				$headerText = $this->partner . ': ' . $this->bundleFileName;
			} else {
				$headerText = $this->partner . ': UNDEFINED_FILE_NAME';
			}
			$headerUnderline = '';
			for ($i = 0; $i < strlen($headerText); $i++) {
				$headerUnderline .= '=';
			}
			$this->writeLogLine($headerText, false);
			$this->writeLogLine($headerUnderline, false);
			
			//save errors
			$lastLogId = 0;
			foreach($this->fileLogs as $logLine){
				$this->writeLogLine($logLine);
			}
			foreach($this->dbLogs as $dbLog){
				if(!empty($this->currentBundleId)){
					$dbLog->setBundleId($this->currentBundleId);
					LogModel::save($dbLog);
					$lastLogId = $dbLog->getLogId(); 
				} else {
					$logDescription = $dbLog->getDescription();
					$this->writeLogLine('Bundle id is empty. Cannot save error log in Data Base:');
					$this->writeLogLine($logDescription);
				}
			}
			if(count($this->dbLogs) > 1){
				$this->writeLogLine('Data base logs saved with ids ' . ($lastLogId - count($this->dbLogs) + 1) . ' - ' . $lastLogId);
			} elseif(count($this->dbLogs) == 1){
				$this->writeLogLine('Data base log saved with id ' . $lastLogId);
			}
			//write an empty line and clear the logs arrays
			$this->writeLogLine('', false);
			self::clear();
		}
	}

	/**
	 *	Inserts a new log line into the $this->logFilePath
	 *
	 *	@param		Log 		$fileLogLine
	 *	@example	$errorLogger->writeLogLine();
	 */
	public function writeLogLine($logLine='', $addsTimePrefix=true)
	{
		if($addsTimePrefix){
			$logLine = Shell::GetSystemDate() . "\t" . $logLine . "\n";
		} else {
			$logLine .= "\n";
		}
		$logFilePath = LOGS_FOLDER.$this->logFileName;
		$fh = fopen($logFilePath, 'a') or die("can't open error log file");
		fwrite($fh, $logLine);
		fclose($fh);
	}

	/**
	 *	Return true if the current process has errors
	 */
	public function hasErrors()
	{
		$hasErrors = false;
		if(count($this->fileLogs) > 0){
			$hasErrors = true;
		}
		if(!$hasErrors && !empty($this->dbLogs)){
			foreach ($this->dbLogs as $log){
				if($log->getIsError()){
					$hasErrors = true;
					break;
				}
			}
		}
		return $hasErrors;
	}
	
	/**
	 *  Returns the log list
	 */
	public function getLogList()
	{
		$logArray = array();
		if(!empty($this->fileLogs) || !empty($this->dbLogs)){
			foreach ($this->dbLogs as $log){
				array_push($logArray, $log->getDescription());
			}
			foreach ($this->fileLogs as $log){
				array_push($logArray, $log);
			}
		}
		return $logArray;
	}
	
	/**
	 *	Clears the logs arrays 
	 */
	public static function clear()
	{
		self::$instance->fileLogs = array();
		self::$instance->dbLogs = array();
	}
}