<?php

/**
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/MTV/XmlCreators/AbstractXmlCreator.php
 */
abstract class AbstractXmlCreator{

	/**
	 * The output from SimpleXML is hideous, this function uses DOM to pretty it.
	 * 
	 * @param		SimpleXMLElement 		$xml
	 * @return		string
	 * @static
	 */
	protected static function GetPrettyXml($xml){
		if ($xml){
			$doc = new DOMDocument('1.0');
			$doc->encoding = 'UTF-8';
			$doc->formatOutput = true;
			$domnode = dom_import_simplexml($xml);
			$domnode = $doc->importNode($domnode, true);
			$domnode = $doc->appendChild($domnode);
			return ($doc->saveXML());   
		}
	}
	
	/**
	 * Creates the XML with bundle metadata in the partner form 
	 * 
	 * @param		Bundle				$bundle
	 * @param		string				$destFolder
	 * @param		string				$fileName
	 * @return		SimpleXMLElement
	 * @static
	 */
	public static function CreateXML($bundle, $destFolder, $fileName=null){
		throw new Exception('Non implemented method AbstractXmlCreator::CreateXML');
	}
}