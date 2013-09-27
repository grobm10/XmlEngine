<?php

/**
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/MTV/XmlCreators/FcsXmlCreator.php
 */
class FcsXmlCreator extends AbstractXmlCreator {
	
	/**
	 * This is the listing of database field not included in xml files
	 *
	 * @var		string
	 * @static
	 */
	public static $NonFcsXmlFields = array(
			'id',
			'video_id',
			'language_code',
			'region_language_code',
			'region_language_alt',
			'region_language_name',
			'video_id',
			'video_metadata_id',
			'metadata_id',
			'partner_id',
			'partner_name',
			'entityId'
	);
	
	/**
	 * Creates the Fcs Short Form XML
	 * 
	 * @param		Bundle				$bundle
	 * @param		string				$destFolder
	 * @param		string				$fileName
	 * @return		bool
	 * @static
	 */
	public static function CreateXML($bundle, $destFolder, $fileName=null){
		if(!empty($fileName)){
			$filePath = $destFolder.$fileName;
		} else {
			//TODO: Check if it's the best way to find the file name
			$fileName = File::GetNameFromPath($bundle->getVideo()->getFileName());
			$filePath = $destFolder.File::GetNameWithoutExtension($fileName).'.xml';
		}
		$parser = new FcsXmlParser();
		
		// Start the new XML
		$xmlRoot = new SimpleXMLElement("<FinalCutServer></FinalCutServer>");      
		// Add 1st level childs
		$rootRequest = $xmlRoot->addChild("request");
		// Add 2nd level childs
		$requestParams = $rootRequest->addChild("params");
		//Add 3th level childs
		$bundleArray = array();
		$bundle->convertToSingleFullArray($bundleArray);
		foreach ($bundleArray as $key => $value){
			if(!in_array($key, self::$NonFcsXmlFields)){
				$parser->getFcsField($key);
				$paramsMdValue = $requestParams->addChild('mdValue', $value);
				$paramsMdValue->addAttribute('fieldName', $parser->getFcsField($key));
				$paramsMdValue->addAttribute('dataType', $parser->getFcsFieldType($key));
			}
		}
		// Add attributes
		$rootRequest->addAttribute("reqId", "setMd"); //1st level
		$rootRequest->addAttribute("entityId", $bundle->getEntityId()); //1st level
		
		$outputXML = self::GetPrettyXml($xmlRoot);
		$fh = fopen($filePath, 'w') or die('can\'t open file');
		fwrite($fh, $outputXML);
		fclose($fh);
		if(is_file($filePath)){
			chmod($filePath, 0775);
		}
		return $outputXML;  
	}
}
