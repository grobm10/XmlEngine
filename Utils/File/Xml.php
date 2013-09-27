<?php

/** 
 * Defines basic Xml function
 * 
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/Data/Xml.php
 */
class Xml{

	/** 
	 * Opens an XML file path and returns a SimpleXml object.
	 * 
	 * @param		string				$filePath
	 * @return		SimpleXMLElement
	 * @see			http://php.net/manual/en/book.simplexml.php
	 * @static
	 */
	public static function XmlFileToObject($filePath){
		$xmlContent = '';
		if (file_exists($filePath)){
			if (is_readable($filePath)){
				$fileArray = file($filePath);
				foreach ($fileArray as $index => $line) {
					$xmlContent .= $line;
				}
			} else {
				throw new Exception('"'.$filePath.'" is not readable.');
			}
		} else {
			throw new Exception('"'.$filePath.'" not exist.');
		}
		//TODO: Catch non closed tag exception
		//TODO: Catch bad xml sintax exception
		//echo $filePath.'<br />';
		return new SimpleXMLElement($xmlContent);
	}
	
	/**
	 * Since the output from SimpleXML is hideous, this function uses DOM to pretty it.
	 * 
	 * @param		SimpleXMLElement		$xml
	 * @return		string
	 * @static
	 */
	public static function XmlObjectToString($xml){
		if (Validate::InstaceOf('SimpleXMLElement', $xml)){
			$doc = new DOMDocument('1.0');
			$doc->encoding = 'UTF-8';
			$doc->formatOutput = true;
			$domnode = dom_import_simplexml($xml);
			$domnode = $doc->importNode($domnode, true);
			$domnode = $doc->appendChild($domnode);
			return $doc->saveXML();
		}
	}
	
	/**
	 * Adds a xml line with tabs to the current xml content
	 * 
	 * @param	string		$xmlContent
	 * @param	string		$line
	 * @param	int			$tabsLevel
	 * @param	bool		$addNewLine
	 */
	public static function AddXmlLine(&$xmlContent, $line, $tabsLevel, $addNewLine=true){
		for ($i = 0; $i < $tabsLevel; $i++) {
			$xmlContent .= "\t";
		}
		$xmlContent .= $line;
		if($addNewLine){
			$xmlContent .= "\n";
		}
	}
}