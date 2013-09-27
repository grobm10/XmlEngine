<?php
/** 
 * @author David Curras
 * @version		June 6, 2012
 */

class ImportationController extends AbstractController {

	/** 
	 * Creates a new ImportationController object.
	 *
	 * @param		string		$partner
	 */
	public function __construct($partner){
		self::SetPartner($partner);
		$this->getTxtInfo(LOCAL_INBOX_IMPORTATION . strtolower(self::$Partner->getName()) . 'dto/');
		$this->runForAll();
	}
		
	/**
	 * Sets the xml files for the importer stacks.
	 *
	 * @param		string		$source
	 */
	protected function getTxtInfo($source){
		//TODO: improve this feature and make it generic
		$txtFiles = File::GetFilesList($source, array('.txt'));
		$this->xmlFiles = array();
		foreach ($txtFiles as $fileName){
			if(is_file($fileName)){
				$fileLines = file($fileName);
				$keys = explode("\t", substr(array_shift($fileLines), 0, -2));
				foreach($fileLines as $line){
					$infoArray = array();
					$values = explode("\t", substr($line,0,-2));
					foreach($values as $index => $value){
						$infoArray[$keys[$index]] = $value; 
					}
					array_push($this->xmlFiles, $infoArray);
				}
			} else {
				echo 'File not found '.$fileName.'.';
			}
		}
	}
	
	
	/**
	 * Executes the transporter process for all requested files.
	 */
	public function runForAll(){
		if (count($this->xmlFiles) > 0){
			foreach($this->xmlFiles as $data){
				//sleep(1); //Makes sure that waits at least 1 second beetwen processes
				self::$Process = new Process(array(
						'type' => TypeModel::FindById(IMPORTATION_PROCESS_ID),
						'state' => StateModel::FindById(NON_STARTED),
						'processDate' => date(Date::MYSQL_DATETIME_FORMAT)
					));
				ProcessModel::Save(self::$Process);
				$this->run($data);
			}
		}
	}
	
	/**
	 * Import the requested file with the appropiate partner application
	 * 
	 * @param		string		$data
	 */
	public function run($data){
		try{
			//TODO: Compare xml metadata values with real values and log errors
			//TODO: Rewrite the xml metadata with validated values
			//TODO: Replace all is_object validations with the Validation::IsInstanceOf method
			//TODO: Log errors
			
			$bundle = new Bundle(array(
					'language'=> new Language(),
					'partner' => AbstractController::GetPartner(),
					'region'=> new Region(),
					'video'=> new Video(array('metadata'=> new Metadata()))
			));
			
			foreach($data as $key => $value){
				if(strpos(strtolower($key), 'vendor') === 0){
					$bundle->getVideo()->getMetadata()->setNetwork($value);
				} elseif(strpos(strtolower($key), 'language of metadata') === 0){
					//TODO:improve        AbstractXmlParser::SetLanguageAndRegion($bundle, $value);
				} elseif(strpos(strtolower($key), 'country of metadata') === 0){
					AbstractXmlParser::SetRegion($bundle, $value);
				} elseif(strpos(strtolower($key), 'title of series') === 0){
					$bundle->getVideo()->getMetadata()->setSeriesName($value);
				} elseif(strpos(strtolower($key), 'original title of series') === 0){
					$bundle->getVideo()->getMetadata()->setSeriesName($value);
				} elseif(strpos(strtolower($key), 'language of original title') === 0){
					//TODO: match this field
				} elseif(strpos(strtolower($key), 'season number') === 0){
					$bundle->getVideo()->getMetadata()->setSeasonNumber($value);
				} elseif(strpos(strtolower($key), 'series description') === 0){
					$bundle->getVideo()->getMetadata()->setSeriesDescription($value);
				} elseif(strpos(strtolower($key), 'season synopsis for series') === 0){
					$bundle->getVideo()->getMetadata()->setSeasonDescription($value);
				} elseif(strpos(strtolower($key), 'episode number') === 0){
					$bundle->getVideo()->getMetadata()->setEpisodeNumber($value);
				} elseif(strpos(strtolower($key), 'episode name') === 0){
					$bundle->getVideo()->getMetadata()->setDTOEpisodeName($value);
				} elseif(strpos(strtolower($key), 'original title of episode') === 0){
					$bundle->getVideo()->getMetadata()->setEpisodeName($value);
				} elseif(strpos(strtolower($key), 'episode synopsis') === 0){
					$bundle->getVideo()->getMetadata()->setDTOShortDescription($value);
					$bundle->getVideo()->getMetadata()->setDTOShortEpisodeDescription($value);
					$bundle->getVideo()->getMetadata()->setDTOLongDescription($value);
					$bundle->getVideo()->getMetadata()->setDTOLongEpisodeDescription($value);
				} elseif(strpos(strtolower($key), 'release year') === 0){
					$bundle->getVideo()->getMetadata()->setReleaseYear($value);
				} elseif(strpos(strtolower($key), 'tv air date') === 0){
					$bundle->getVideo()->getMetadata()->setAirDate($value);
				} elseif(strpos(strtolower($key), 'country of origin') === 0){
					//TODO: match this field
				} elseif(strpos(strtolower($key), 'original language of content') === 0){
					//TODO: match this field
				} elseif(strpos(strtolower($key), 'run time') === 0){
					//TODO: match this field
				} elseif(strpos(strtolower($key), "country's rating") === 0){
					//TODO: match this field
				} elseif(strpos(strtolower($key), "country's rating reason") === 0){
					//TODO: match this field
				} elseif(strpos(strtolower($key), 'genre') === 0){
					$bundle->getVideo()->getMetadata()->setGenre($value);
				} elseif(strpos(strtolower($key), 'creator') === 0){
					//TODO: match this field
				} elseif(strpos(strtolower($key), 'cast list') === 0){
					//TODO: match this field
				} elseif(strpos(strtolower($key), 'other notes') === 0){
					//TODO: match this field
				} elseif(strpos(strtolower($key), 'original us rating') === 0){
					//TODO: match this field
				} else {
					//TODO: throw exception
				}
			}
			$bundle->getVideo()->getMetadata()->setDTOEpisodeID(str_replace(' ', '', strtoupper($bundle->getRegion()->getCode() .'_'.
					 $bundle->getVideo()->getMetadata()->getNetwork() .'_'.
					 $bundle->getVideo()->getMetadata()->getSeriesName() .'_'.
					 $bundle->getVideo()->getMetadata()->getSeasonNumber().
					$bundle->getVideo()->getMetadata()->getEpisodeNumber())));
			
			$bundle->getVideo()->getMetadata()->setDTOSeasonID(str_replace(' ', '', strtoupper($bundle->getRegion()->getCode() .'_'.
					$bundle->getVideo()->getMetadata()->getNetwork() .'_'.
					$bundle->getVideo()->getMetadata()->getSeriesName() .'_'.
					$bundle->getVideo()->getMetadata()->getSeasonNumber())));
			
			$bundle->getVideo()->getMetadata()->setDTOSeriesID(str_replace(' ', '', strtoupper($bundle->getRegion()->getCode() .'_'.
					$bundle->getVideo()->getMetadata()->getNetwork() .'_'.
					$bundle->getVideo()->getMetadata()->getSeriesName())));
			//TODO: FileName could be diferent than getDTOEpisodeID
			$bundle->getVideo()->setFileName(strtoupper($bundle->getVideo()->getMetadata()->getDTOEpisodeID().'.mpg'));
			$bundle->getVideo()->setMD5Hash(md5($bundle->getVideo()->getMetadata()->getDTOEpisodeID().'.mpg'));
			$bundle->getVideo()->setSize(1);
			
			MetadataModel::Save($bundle->getVideo()->getMetadata());
			VideoModel::Save($bundle->getVideo());
			BundleModel::Save($bundle);
			self::$Process->setBundle($bundle);
			self::$Process->setState(StateModel::FindById(STARTED));
			ProcessModel::Save(self::$Process);
			$success = FcsXmlCreator::CreateXML($bundle, LOCAL_OUTBOX_IMPORTATION.strtolower(self::$Partner->getName()).'dto/', $bundle->getVideo()->getMetadata()->getDTOEpisodeID().'.xml');
			if($success){
				self::$Process->setState(StateModel::FindById(SUCCESS));
				//$this->cleanUp($fileName);
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