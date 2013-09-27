<?php
/** 
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/Server/Ajax.php
 */
require_once '../../siteConfig.php';
require_once '../Bootstrap.php';

Bootstrap::SetRequiredFiles();
AbstractModel::$IsUsingUtf8 = true;
AjaxHandler::Run();
die();

class AjaxHandler {

	/**
	 * @var		ErrorLogger
	 * @staticvar
	 */
	//protected static $ErrorLogger = null;
	
	/**
	 * @var		string
	 * @staticvar
	 */
	protected static $Object = null;
	
	/**
	 * @var		string
	 * @staticvar
	 */
	protected static $Action = null;
	
	/**
	 * @var		array|mixed
	 * @staticvar
	 */
	protected static $Params = null;
	
	/**
	 * @var		string
	 * @staticvar
	 */
	protected static $Result = null;
	
	/**
	 * Runs the ajax handler
	 * 
	 * @static
	 */
	public static function Run(){
		try{
			self::PrepareData();
			self::ExecuteAction();
			self::SendResults();
		} catch (Exception $e){
			//self::$ErrorLogger->addFileLog($e->getMessage());
			self::SendResults();
		}
	}

	/**
	 * Prepare the params to execute the requested action
	 * 
	 * @static
	 */
	private static function PrepareData(){
		if(empty($_POST)){
			$_POST = $_GET;
		}
		//self::$ErrorLogger = ErrorLogger::getInstance();
		//self::$ErrorLogger->setProcessType(Type::FRONTEND);
		if(!empty($_POST['obj']) && !empty($_POST['action'])){
			self::$Object = strtoupper($_POST['obj']);
			self::$Action = $_POST['action'];
		} else {
			throw new Exception('Unable to resolve ajax request, there are missed params.');
		}
		if(!empty($_POST['params'])){
			self::$Params = $_POST['params'];
		}
	}

	/**
	 * Executes the requested action
	 * 
	 * @static
	 * @todo		must be generics
	 */
	private static function ExecuteAction(){
		$action = self::$Action;
		switch (self::$Object){
			case 'ABSTRACT':
				self::$Result = AbstractModel::$action(self::$Params);
				break;
			case 'BUNDLE':
			case 'BUNDLES':
				self::$Result = BundleModel::$action(self::$Params);
				break;
			case 'LANGUAGE':
			case 'LANGUAGES':
				self::$Result = LanguageModel::$action(self::$Params);
				break;
			case 'LOG':
			case 'LOGS':
				self::$Result = LogModel::$action(self::$Params);
				break;
			case 'METADATA':
				self::$Result = MetadataModel::$action(self::$Params);
				break;
			case 'PARTNER':
			case 'PARTNERS':
				self::$Result = PartnerModel::$action(self::$Params);
				break;
			case 'PROCESS':
			case 'PROCESSES':
				self::$Result = ProcessModel::$action(self::$Params);
				break;
			case 'REGION':
			case 'REGIONS':
				self::$Result = RegionModel::$action(self::$Params);
				break;
			case 'ROLE':
			case 'ROLES':
				self::$Result = RoleModel::$action(self::$Params);
				break;
			case 'STATE':
			case 'STATES':
				self::$Result = StateModel::$action(self::$Params);
				break;
			case 'TYPE':
			case 'TYPES':
				self::$Result = TypeModel::$action(self::$Params);
				break;
			case 'USER':
			case 'USERS':
				self::$Result = RegionModel::$action(self::$Params);
				break;
			case 'VIDEO':
			case 'VIDEOS':
				self::$Result = VideoModel::$action(self::$Params);
				break;
			default:
				throw new Exception('Unable to recognize Model class "'.self::$Object.'". (AjaxHandler::ExecuteAction)');
		}
	}
	
	/**
	 * Sends the ajax request output
	 * 
	 * @static
	 */
	private static function SendResults(){
		//if(self::$ErrorLogger->hasErrors()){
		//	self::$ErrorLogger->saveErrors();
		//	echo 'false';
		//} else {
			$output = array();
			if(is_array(self::$Result)){
				foreach (self::$Result as $obj){
					array_push($output, $obj->convertToArray());
				}
			} elseif(is_object(self::$Result)) {
				$output = self::$Result->convertToArray();
			} else {
				$output = self::$Result;
			}
			$jsonOutput = str_replace('&quot;', '\\"', json_encode($output));
			$result = AbstractModel::$IsUsingUtf8 ? utf8_encode(html_entity_decode($jsonOutput)) : html_entity_decode($jsonOutput);
			echo $result;
		//}
	}
}