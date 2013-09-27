<?php
/** 
 * @author David Curras
 * @version		June 6, 2012
 */

class MergeController extends AbstractController {

	/** 
	 * Creates a new TransporterController object.
	 *
	 * @param		string		$partner
	 */
	public function __construct($partner){
		self::SetPartner($partner);
		$this->setXmlFiles(LOCAL_INBOX_MERGE . strtolower(self::$Partner->getName()) . 'dto/');
		$this->runForAll();
	}
	
	/**
	 * Executes the transporter process for all requested files.
	 */
	public function runForAll(){
		if (count($this->xmlFiles) > 0){
			foreach($this->xmlFiles as $fileName => $filePath){
				//sleep(1); //Makes sure that waits at least 1 second beetwen processes
				if(is_file(LOCAL_INBOX_MERGE.'fcs/'.$fileName)){
					self::$Process = new Process(array(
							'type' => TypeModel::FindById(MERGE_PROCESS_ID),
							'state' => StateModel::FindById(NON_STARTED),
							'processDate' => date(Date::MYSQL_DATETIME_FORMAT)
						));
					ProcessModel::Save(self::$Process);
					$this->run($fileName);	
				}
			}
		}
	}

	/**
	 * Transports the requested file with the appropiate partner application
	 * 
	 * @param		string		$fileName
	 */
	public function run($fileName){
		try{
			//TODO: Compare xml metadata values with real values and log errors
			//TODO: Rewrite the xml metadata with validated values
			//TODO: Replace all is_object validations with the Validation::IsInstanceOf method
			//TODO: Log errors
			$fcsFolder = LOCAL_INBOX_MERGE.'fcs/';
			$partnerFolder = LOCAL_INBOX_MERGE.strtolower(self::$Partner->getName()) . 'dto/';
			$fileNameBundle = self::GetBundleFromFileName($fcsFolder.$fileName, false);
			$bundle = $this->getBundle($fcsFolder.$fileName, FCS);
			$bundle = $this->mergeBundles($fileNameBundle, $bundle);
			$partnerBundle = $this->getBundle($partnerFolder.$fileName);
			$bundle = $this->mergeBundles($bundle, $partnerBundle);
			$this->fillWithStoredValues($bundle);
			MetadataModel::Save($bundle->getVideo()->getMetadata());
			VideoModel::Save($bundle->getVideo());
			BundleModel::Save($bundle);
			self::$Process->setBundle($bundle);
			self::$Process->setState(StateModel::FindById(STARTED));
			ProcessModel::Save(self::$Process);
			$success = FcsXmlCreator::CreateXML($bundle, LOCAL_OUTBOX_MERGE.'fcs/', $fileName);
			if($success){
				self::$Process->setState(StateModel::FindById(SUCCESS));
				$this->cleanUp($fileName);
			} else {
				self::$Process->setState(StateModel::FindById(FAILED));
			}
			ProcessModel::Save(self::$Process);
		} catch(Exception $e){
			//TODO: improve this code
			$query = new Query();
			$state = 5;
			if(self::$Process->getState()->getId() == SUCCESS){
				$state = 3;
			}
			$query->createUpdate('processes', array("stateId" => $state, "issues" => $e->getMessage()), 'id = "'.self::$Process->getId().'"');
			$query->execute();
			$fh = fopen(ROOT_FOLDER.'logs/merge-'.self::$Process->getId().'.log', 'w') or die('can\'t open file');
			fwrite($fh, $fileName.' - '.$e->getMessage()."\n\n\n".$e);
			fclose($fh);
			echo '<br />Error: '.$fileName.' - '.$e->getMessage().'<br />See log file for more details.<br /><br />';
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
     * Cleans up the processed file
	 *
	 * @param		string		$fileName
	 * @return 		bool
	 */
	public function cleanUp($fileName){
		if(file_exists(LOCAL_OUTBOX_MERGE.'fcs/'.$fileName)){
			$fcsFolder = LOCAL_INBOX_MERGE.'fcs/';
			$partnerFolder = LOCAL_INBOX_MERGE.strtolower(self::$Partner->getName()) . 'dto/';
			unlink($partnerFolder.$fileName);
			//TODO: decide if remove the source fcs file from fcs inbox or rewrite it with the new one
			//unlink($fcsFolder.$fileName);
			copy(LOCAL_OUTBOX_MERGE.'fcs/'.$fileName, $fcsFolder.$fileName);
		} else {
			throw new Exception('No such file or directory: '.LOCAL_OUTBOX_MERGE.'fcs/'.$fileName .'. MergeController->cleanUp()');
		}
		return true;
	}
}