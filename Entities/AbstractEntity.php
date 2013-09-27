<?php
/**  
 * @author David Curras
 * @version		June 10 2012
 */

abstract class AbstractEntity {
	
	/**
	 * Constructor method for this video object to populate the video given elements.
	 * @param   array|string $params
	 */
	public function __construct($params = null){
		if (null !== $params) {
			$this->populate($params);
		}
	}
	
	/**
	 * Populate this video object with given elements
	 * 
	 * @param   array|string $fields
	 * @return  DTOVideo
	 */
	public function populate($fields){
		if (is_array($fields)){
			$fields = new ArrayObject($fields, ArrayObject::ARRAY_AS_PROPS);
		}
		$methods = get_class_methods($this);
		foreach ($fields as $key => $value){
			$method = 'set' . ucfirst($key);
			if (in_array($method, $methods)){
				if(is_string($value))
					$value = trim($value);
				$this->$method($value);
			}
		}
		return $this;
	}
	
	/**
	 * Extract the name of each property of this class in an array; 
	 * 
	 * @return  array|string
	 */
	public function getPropertiesNameList() {
		$arrayProperties = get_class_vars(get_class($this));
		$propertiesNameList = array();
		foreach ($arrayProperties as $key => $defaultValue){
			array_push($propertiesNameList, $key);
		}
		return $propertiesNameList;
	}
	
	/**
	 * Extracts each property name and value in an array. Only for not empty properties|
	 * If need to exclude some property just push property name in $notIncluded  
	 * 
	 * @param 	array|string $excludedProperties
	 * @return	array|string
	 */
	public function convertToArray($excludedProperties=array()) {
		$propertiesNameList = $this->getPropertiesNameList();
		$arrayParsed = array();
		foreach ($propertiesNameList as $propertyName){
			$method = 'get' . ucfirst($propertyName);
			$value = $this->$method();
			$mustAdd = !empty($value) && !in_array($propertyName, $excludedProperties);
			if ($mustAdd){
				if(is_object($value)){
					$arrayParsed[$propertyName] = $value->convertToArray();
				} elseif(is_array($value)) {
					$arrayParsed[$propertyName] = array();
					foreach($value as $index => $innerValue){
						if(is_object($innerValue)){
							$arrayParsed[$propertyName][$index] = $innerValue->convertToArray();
						} else {
							$arrayParsed[$propertyName][$index] = $innerValue;
						}
					}
				} else {
					$arrayParsed[$propertyName] = $value;
				}
			}
		}
		return $arrayParsed;
	}
	
	/**
	 * Extracts each property recursively from the current object
	 * and pushes those values in an unidimensional array.
	 * 
	 * @param 	array|string &$notIncluded
	 */
	public function convertToSingleFullArray(&$refArray=array(), $prefix='') {
		$propertiesNameList = $this->getPropertiesNameList();
		foreach ($propertiesNameList as $propertyName){
			$method = 'get' . ucfirst($propertyName);
			$value = $this->$method();
			if(is_object($value)){
				$value->convertToSingleFullArray($refArray, $prefix . lcfirst($propertyName) . '_');
			} else {
				if(!empty($prefix)){
					$propertyName = $prefix . lcfirst($propertyName);
				}
				$refArray[$propertyName] = $value;
			}
		}
	}
}