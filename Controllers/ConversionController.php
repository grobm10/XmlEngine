<?php
/** 
 * @author David Curras
 * @version		June 6, 2012
 */

class ConversionController extends AbstractController {

	/** 
	 * Creates a new TransporterController object.
	 *
	 * @param		string		$partner
	 */
	public function __construct($partner){
		self::SetPartner($partner);
		$this->setXmlFiles(LOCAL_INBOX_CONVERSION . strtolower(self::$Partner->getName()) . 'dto/');
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
						'type' => TypeModel::FindById(CONVERSION_PROCESS_ID),
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
	 * @param		string		$xmlFilePath
	 */
	public function run($xmlFilePath){
		try{
			//TODO: Compare xml metadata values with real values and log errors
			//TODO: Rewrite the xml metadata with validated values
			//TODO: Find a way to merge two bundles giving priority to some properties of bundle1 and others of bundle2
			//TODO: Make the mergeBundles function to overwrite video and metadata properties but not language and region
			//TODO: Replace all is_object validations with the Validation::IsInstanceOf method
			//TODO: Improve clean up function to parse each partner case
			//TODO: Log errors
			$inboxFolder = LOCAL_INBOX_CONVERSION . strtolower(self::$Partner->getName()) . 'dto/';
			$bundle = self::GetBundleFromFileName($xmlFilePath, true);
			$xmlBundle = $this->getBundle($xmlFilePath, FCS);
			//TODO: Improve this validation out of this file
			$md5 = $bundle->getVideo()->getMD5Hash();
			$fname = $bundle->getVideo()->getFileName();
			$size = $bundle->getVideo()->getSize();
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
				throw new Exception('Xml Metadata Errors: '.$issues);
			}
			$bundle = $this->mergeBundles($xmlBundle, $bundle);
			$this->fillWithStoredValues($bundle);
			MetadataModel::Save($bundle->getVideo()->getMetadata());
			VideoModel::Save($bundle->getVideo());
			BundleModel::Save($bundle);
			self::$Process->setBundle($bundle);
			self::$Process->setState(StateModel::FindById(STARTED));
			ProcessModel::Save(self::$Process);
			$success = $this->startConversion($bundle);
			if($success){
				self::$Process->setState(StateModel::FindById(SUCCESS));
				$fileName = File::GetNameWithoutExtension($bundle->getVideo()->getFileName());
				$fileExtension = File::GetExtensionFromPath($bundle->getVideo()->getFileName());
				$this->cleanUp(array('name'=>$fileName, 'extension'=>$fileExtension));
			} else {
				self::$Process->setState(StateModel::FindById(FAILED));
			}
			ProcessModel::Save(self::$Process);
		} catch(Exception $e){//TODO: improve this code
			$query = new Query();
			$state = 5;
			if(self::$Process->getState()->getId() == SUCCESS){
				$state = 3;
			}
			$query->createUpdate('processes', array("stateId" => $state, "issues" => $e->getMessage()), 'id = "'.self::$Process->getId().'"');
			$query->execute();
			$fh = fopen(ROOT_FOLDER.'logs/conversion-'.self::$Process->getId().'.log', 'w') or die('can\'t open file');
			fwrite($fh, $xmlFilePath.' - '.$e->getMessage()."\n\n\n".$e);
			fclose($fh);
			echo '<br />Error: '.$xmlFilePath.' - '.$e->getMessage().'<br />See log file for more details.<br /><br />';
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
	protected function startConversion($bundle){
		switch (strtolower(self::$Partner->getName())){
			case ITUNES:
				$destFolder = LOCAL_OUTBOX_CONVERSION . ITUNES . 'dto/';
				return ITunesXmlCreator::CreateXML($bundle, $destFolder);
			case SONY:
				$destFolder = LOCAL_OUTBOX_CONVERSION . SONY . 'dto/';
				return SonyXmlCreator::CreateXML($bundle, $destFolder);
			case STARHUB:
				$destFolder = LOCAL_OUTBOX_CONVERSION . STARHUB . 'dto/';
				return StarHubXmlCreator::CreateXML($bundle, $destFolder);
			case XBOX:
				$destFolder = LOCAL_OUTBOX_CONVERSION . XBOX . 'dto/';
				return XboxXmlCreator::CreateXML($bundle, $destFolder);
			default:
				throw new Exception('Unexpected partner name "'.self::$Partner->getName().'". ConversionController->startConversion().');
		}
	}
	
	/**
     * Cleans up the processed files
	 *
	 * @param		array|string		$files
	 */
	public function cleanUp($files){
		$sourceFolder = LOCAL_INBOX_CONVERSION . strtolower(self::$Partner->getName()) . 'dto/';
		$destinationFolder = LOCAL_OUTBOX_CONVERSION . strtolower(self::$Partner->getName()) . 'dto/';
		$xmlFile = $files['name'].'.xml';
		$binaryFile = $files['name'] . '.' . $files['extension'];
		rename($sourceFolder.$xmlFile, $destinationFolder.$xmlFile);
		rename($sourceFolder.$binaryFile, $destinationFolder.$binaryFile);
		if(file_exists($destinationFolder.$binaryFile)){
			//chmod($destinationFolder.$binaryFile, 0775);
			if(file_exists($sourceFolder.$xmlFile)){
				unlink($sourceFolder.$xmlFile);
			}
			if(file_exists($sourceFolder.$binaryFile)){
				unlink($sourceFolder.$binaryFile);
			}
			if(file_exists($destinationFolder.$binaryFile) && file_exists($destinationFolder.$xmlFile)){
				if(strtolower(self::$Partner->getName()) == ITUNES){
					ITunesTransporter::PackageFiles(array('xml' => $destinationFolder.$xmlFile, 'binary' => $destinationFolder.$binaryFile));
				}
			} else {
				throw new Exception('Conversion folder clean up failed. ConversionController->cleanUp()');
			}
		} else {
			throw new Exception('Conversion folder clean up failed. ConversionController->cleanUp()');
		}
	}
}