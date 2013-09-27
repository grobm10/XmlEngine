<?php

/**
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/MTV/XmlParsers/AbstractXmlParser.php
 */
abstract class AbstractXmlParser {

	/**
	 * List of required fields
	 *
	 * @var 	array|string
	 */
	protected $requiredFields = array();
	
	/**
	 * Returns the partner required field list
	 * 
	 * @return  array|string
	 */
	public function getRequiredFields(){
		return $this->requiredFields;
	}

	/**
	 * Returns an array with the partner fields extracted from the given bundle. 
	 * 
	 * @param   	Bundle			$bundle
	 * @return  	array|string
	 */
	public function getPartnerXmlFields($bundle){
		$bundleArray = array();
		$bundle->convertToSingleFullArray($bundleArray);
		$partnerXmlFields = array();
		foreach($this->requiredFields as $key){
			$partnerXmlFields[$key] = '';
			$fcsField = $this->getFcsField($key);
			foreach($fcsField as $field){
				$value = trim($bundleArray[$field]);
				if(!empty($value)){
					$partnerXmlFields[$key] = $value;
					break;
				}
			}
		}
		return $partnerXmlFields;
	}

	/**
	 * Parses the value trying to set the Language and Region for the current bundle
	 * 
	 * @param		Object		$bundle
	 * @param		string		$value
	 * @static
	 */
	public static function SetLanguageAndRegion(&$bundle, $value){
		$isAlreadySetted = is_object($bundle->getRegion()) &&
							is_string($bundle->getRegion()->getCode()) &&
							is_object($bundle->getLanguage()) &&
							is_string($bundle->getLanguage()->getCode()) &&
							($bundle->getLanguage()->getCode() != $bundle->getRegion()->getLanguage()->getCode());
		if($isAlreadySetted){
			return;
		}
		$region = null;
		$language = LanguageModel::FindById(strtoupper(trim($value)));
		if(empty($language)){
			$language = LanguageModel::FindBy(array('alt'=>strtoupper(trim($value))), true);
			if(empty($language)){
				$language = LanguageModel::FindBy(array('name'=>strtoupper(trim($value))), true);
				if(empty($language)){
					$parsedValue = explode('-', $value);
					$language = LanguageModel::FindBy(array('alt'=>strtoupper(trim($parsedValue[0]))), true);
					$region = RegionModel::FindById(strtoupper(trim($parsedValue[1])));
				}
			}
		}
		if(is_object($language) && (!is_object($bundle->getLanguage()) || !is_string($bundle->getLanguage()->getCode()))){
			$bundle->setLanguage($language);
		}
		if(is_object($region) && (!is_object($bundle->getRegion()) || !is_string($bundle->getRegion()->getCode()))){
			$bundle->setRegion($region);
		}
	}

	/**
	 * Parses the value trying to set the Region for the current bundle
	 * 
	 * @param		Object		$bundle
	 * @param		string		$value
	 * @static
	 */
	public static function SetRegion(&$bundle, $value){
		$isAlreadySetted = is_object($bundle->getRegion()) &&
							is_string($bundle->getRegion()->getCode()) &&
							is_object($bundle->getLanguage()) &&
							is_string($bundle->getLanguage()->getCode()) &&
							($bundle->getLanguage()->getCode() != $bundle->getRegion()->getLanguage()->getCode());
		if($isAlreadySetted){
			return;
		}
		$region = RegionModel::FindById(strtoupper(trim($value)));
		if(empty($region)){
			$region = RegionModel::FindBy(array('country'=>strtoupper(trim($value))), true);
		}
		if(is_object($region)){
			$bundle->setRegion($region);
			if(!is_object($bundle->getLanguage()) || !is_string($bundle->getLanguage()->getCode())){
				$bundle->setLanguage($bundle->getRegion()->getLanguage());
			}
		}
	}

	/**
	 * Returns an array with the required fcs fields for the given partner field. 
	 * 
	 * @param   	string			$partnerField
	 * @return  	array|string
	 */
	public abstract function getFcsField($partnerField);

	/**
	 * Parses the Partner xml file and return a Bundle object.
	 * 
	 * @param 		string 		$xmlFilePath
	 * @return 		Bundle
	 */
	public abstract function getBundleFromXml($xmlFilePath);
}