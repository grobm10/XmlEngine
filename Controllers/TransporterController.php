<?php
/** 
 * @author David Curras
 * @version		June 6, 2012
 */

class TransporterController extends AbstractController {

    /**
     * This is a temporary hack to check if the metadata file
	 * is overwrited and the run process is executed twice.
	 *
     * @staticvar		$RunningTwice
     */
    protected static $RunningTwice = false;
	
	/** 
	 * Creates a new TransporterController object.
	 *
	 * @param		string		$partner
	 */
	public function __construct($partner){
		self::SetPartner($partner);
		$this->setXmlFiles(LOCAL_INBOX_TRANSPORTATION . strtolower(self::$Partner->getName()) . 'dto/');
		$this->runForAll();
	}
	
	/**
	 * Executes the transporter process for all requested files.
	 */
	public function runForAll(){
		if (count($this->xmlFiles) > 0){
			foreach($this->xmlFiles as $fileName => $filePath){
				//sleep(1); //Makes sure that waits at least 1 second beetwen processes
				self::$Process = new Process(array(
						'type' => TypeModel::FindById(TRANSPORTATION_PROCESS_ID),
						'state' => StateModel::FindById(NON_STARTED),
						'processDate' => date(Date::MYSQL_DATETIME_FORMAT)
					));
				ProcessModel::Save(self::$Process);
				$this->run($filePath);
			}
		}
	}

	/**
	 * Transports the requested file with the appropiate partner application
	 * 
	 * @param		string		$filePath
	 */
	public function run($filePath){
		try{
			//TODO: Compare xml metadata values with real values and log errors
			//TODO: Rewrite the xml metadata with validated values
			//TODO: Replace all is_object validations with the Validation::IsInstanceOf method
			//TODO: Log errors
			$inboxFolder = LOCAL_INBOX_TRANSPORTATION . strtolower(self::$Partner->getName()) . 'dto/';
			$bundle = self::GetBundleFromFileName($filePath, true);
			$xmlFilePath = $filePath;
			if(strtolower(self::$Partner->getName()) == 'itunes'){
				$xmlFilePath .= '/metadata.xml';
			}
			$xmlBundle = $this->getBundle($xmlFilePath);
			//TODO: Improve this validation out of this file and make it generic
			if(strtolower(self::$Partner->getName()) == 'itunes'){
				$md5 = $xmlBundle->getVideo()->getMD5Hash();
				$fname = $xmlBundle->getVideo()->getFileName();
				$size = $xmlBundle->getVideo()->getSize();
				$issues = '';
				if(empty($md5)){
					$issues .= 'MD5 Hash field is empty. ';
				}
				if(empty($fname)){
					$issues .= 'File Name is empty. ';
				}
				if(empty($size)){
					$issues .= 'Size field is empty.';
				}
				if(!empty($issues)){
					//TODO: improve this and make the same for all partners
					$bundle = $this->mergeBundles($xmlBundle, $bundle);
					if(!self::$RunningTwice){
						if(ITunesXmlCreator::CreateXML($bundle, File::GetParentFolderPath($filePath, true))){
							echo '<br />Overwriting iTunes Metadata: '.$filePath.' <br />';
							self::$RunningTwice = true;
							$this->run($filePath);
							self::$RunningTwice = false;
							return true;
						}
					} else {
						MetadataModel::Save($bundle->getVideo()->getMetadata());
						VideoModel::Save($bundle->getVideo());
						BundleModel::Save($bundle);
						self::$Process->setBundle($bundle);
						self::$Process->setState(StateModel::FindById(FAILED));
						ProcessModel::Save(self::$Process);
						throw new Exception('Xml Metadata Errors: '.$issues);
					}
				}
			}	
			$bundle = $this->mergeBundles($xmlBundle, $bundle);
			$this->fillWithStoredValues($bundle);
			MetadataModel::Save($bundle->getVideo()->getMetadata());
			VideoModel::Save($bundle->getVideo());
			BundleModel::Save($bundle);
			self::$Process->setBundle($bundle);
			self::$Process->setState(StateModel::FindById(STARTED));
			ProcessModel::Save(self::$Process);
			$success = $this->startTransportation($bundle);
			if($success){
				self::$Process->setState(StateModel::FindById(SUCCESS));
				$files = array();
				if(strtolower(self::$Partner->getName()) == ITUNES){
					//TODO: Check if it's the best way to find the file name
					$files = array(File::GetNameWithoutExtension($filePath) . '.itmsp');
				} else {
					//TODO: Check if it's the best way to find the file name
					$xmlName = File::GetNameWithoutExtension($filePath) . '.xml' ;
					$binaryName = $bundle->getVideo()->getFileName();
					$files = array($xmlName, $binaryName);
				}
				$this->cleanUp($files);
			} else {
				self::$Process->setState(StateModel::FindById(FAILED));
			}
			ProcessModel::Save(self::$Process);
		} catch(Exception $e){
			//TODO: improve this code
			echo '<br />Error: '.$filePath.' - '.$e->getMessage().'<br />See log file for more details.<br /><br />';
			$query = new Query();
			$state = 5;
			if(self::$Process->getState()->getId() == SUCCESS){
				$state = 3;
			}
			$query->createUpdate('processes', array("stateId" => $state, "issues" => $e->getMessage()), 'id = "'.self::$Process->getId().'"');
			$query->execute();
			$fh = fopen(ROOT_FOLDER.'logs/transport-'.self::$Process->getId().'.log', 'w') or die('can\'t open file');
			fwrite($fh, $filePath.' - '.$e->getMessage()."\n\n\n".$e);
			fclose($fh);
			echo '<br />Error: '.$filePath.' - '.$e->getMessage().'<br />See log file for more details.<br /><br />';
			/*
			if(self::$Process->getState()->getId() == SUCCESS){
				self::$Process->setState(StateModel::FindById(INCOMPLETE));
			} else {
				self::$Process->setState(StateModel::FindById(FAILED));
			}
			ProcessModel::Save(self::$Process);
			*/
		}
	}
	
	/**
	 * Uploads the current asset to the partner server
	 * 
	 * @param		Bundle			$bundle
	 * @return		bool
	 */
	protected function startTransportation($bundle){
		switch (strtolower(self::$Partner->getName())){
			case ITUNES:
				return ITunesTransporter::Upload($bundle);
			case SONY:
				return SonyTransporter::Upload($bundle);
			case STARHUB:
				return StarHubTransporter::Upload($bundle);
			case XBOX:
				return XboxTransporter::Upload($bundle);
			default:
				throw new Exception('Unexpected partner name "'.self::$Partner->getName().'". TransporterController->startTransportation().');
		}
	}
	
	/**
     * Cleans up the processed files
	 *
	 * @param		array|string		$files
	 * @return 		bool
	 */
	public function cleanUp($files){
		foreach($files as $fileName){
			$sourceFolder = LOCAL_INBOX_TRANSPORTATION . strtolower(self::$Partner->getName()) . 'dto/';
			$destinationFolder = LOCAL_OUTBOX_TRANSPORTATION . strtolower(self::$Partner->getName()) . 'dto/';
			rename($sourceFolder.$fileName, $destinationFolder.$fileName);
			if(file_exists($destinationFolder.$fileName)){
				//chmod($destinationFolder.$fileName, 0775);
				if(file_exists($sourceFolder.$fileName)){
					unlink($sourceFolder.$fileName);
				}
			} else {
				throw new Exception('Transportation folder clean up failed. TransporterController->cleanUp()');
			}
		}
		return true;
	}
}