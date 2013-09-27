<?php

/**
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/Data/DataConverter.php
 */
class DataConverter
{
	/** 
	 * Associates xml encode values with ISO characters. Must use utf8_decode() for ISO.
	 */
	public static $xmlToIso = array('&#161;'=>'¡', '&#162;'=>'¢', '&#163;'=>'£', '&#164;'=>'€',
			'&#165;'=>'¥', '&#166;'=>'Š', '&#167;'=>'§', '&#168;'=>'š', '&#169;'=>'©',
			'&#170;'=>'ª', '&#171;'=>'«', '&#172;'=>'¬', '&#174;'=>'®', '&#175;'=>'¯', 
			'&#176;'=>'°', '&#177;'=>'±', '&#178;'=>'²', '&#179;'=>'³', '&#180;'=>'Ž', 
			'&#181;'=>'µ', '&#182;'=>'¶', '&#183;'=>'·', '&#184;'=>'ž', '&#185;'=>'¹', 
			'&#186;'=>'º', '&#187;'=>'»', '&#188;'=>'Œ', '&#189;'=>'œ', '&#190;'=>'Ÿ', 
			'&#191;'=>'¿', '&#192;'=>'À', '&#193;'=>'Á', '&#194;'=>'Â', '&#195;'=>'Ã', 
			'&#196;'=>'Ä', '&#197;'=>'Å', '&#198;'=>'Æ', '&#199;'=>'Ç', '&#200;'=>'È', 
			'&#201;'=>'É', '&#202;'=>'Ê', '&#203;'=>'Ë', '&#204;'=>'Ì', '&#205;'=>'Í', 
			'&#206;'=>'Î', '&#207;'=>'Ï', '&#208;'=>'Ð', '&#209;'=>'Ñ', '&#210;'=>'Ò', 
			'&#211;'=>'Ó', '&#212;'=>'Ô', '&#213;'=>'Õ', '&#214;'=>'Ö', '&#215;'=>'×', 
			'&#216;'=>'Ø', '&#217;'=>'Ù', '&#218;'=>'Ú', '&#219;'=>'Û', '&#220;'=>'Ü', 
			'&#221;'=>'Ý', '&#222;'=>'Þ', '&#223;'=>'ß', '&#224;'=>'à', '&#225;'=>'á', 
			'&#226;'=>'â', '&#227;'=>'ã', '&#228;'=>'ä', '&#229;'=>'å', '&#230;'=>'æ', 
			'&#231;'=>'ç', '&#232;'=>'è', '&#233;'=>'é', '&#234;'=>'ê', '&#235;'=>'ë', 
			'&#236;'=>'ì', '&#237;'=>'í', '&#238;'=>'î', '&#239;'=>'ï', '&#240;'=>'ð', 
			'&#241;'=>'ñ', '&#242;'=>'ò', '&#243;'=>'ó', '&#244;'=>'ô', '&#245;'=>'õ', 
			'&#246;'=>'ö', '&#247;'=>'÷', '&#248;'=>'ø', '&#249;'=>'ù', '&#250;'=>'ú', 
			'&#251;'=>'û', '&#252;'=>'ü', '&#253;'=>'ý', '&#254;'=>'þ', '&#255;'=>'ÿ' 
		);

	/** 
	 * Associates ISO characters with xml encode values. Must use utf8_decode() for ISO.
	 */
	public static $isoToXml = array('¡'=>'&#161;', '¢'=>'&#162;', '£'=>'&#163;', '€'=>'&#164;',
			'¥'=>'&#165;', 'Š'=>'&#166;', '§'=>'&#167;', 'š'=>'&#168;', '©'=>'&#169;',
			'ª'=>'&#170;', '«'=>'&#171;', '¬'=>'&#172;','®'=>'&#174;', '¯'=>'&#175;',
			'°'=>'&#176;', '±'=>'&#177;', '²'=>'&#178;', '³'=>'&#179;', 'Ž'=>'&#180;',
			'µ'=>'&#181;', '¶'=>'&#182;', '·'=>'&#183;', 'ž'=>'&#184;', '¹'=>'&#185;',
			'º'=>'&#186;', '»'=>'&#187;', 'Œ'=>'&#188;', 'œ'=>'&#189;', 'Ÿ'=>'&#190;',
			'¿'=>'&#191;', 'À'=>'&#192;', 'Á'=>'&#193;', 'Â'=>'&#194;', 'Ã'=>'&#195;',
			'Ä'=>'&#196;', 'Å'=>'&#197;', 'Æ'=>'&#198;', 'Ç'=>'&#199;', 'È'=>'&#200;',
			'É'=>'&#201;', 'Ê'=>'&#202;', 'Ë'=>'&#203;', 'Ì'=>'&#204;', 'Í'=>'&#205;',
			'Î'=>'&#206;', 'Ï'=>'&#207;', 'Ð'=>'&#208;', 'Ñ'=>'&#209;', 'Ò'=>'&#210;',
			'Ó'=>'&#211;', 'Ô'=>'&#212;', 'Õ'=>'&#213;', 'Ö'=>'&#214;', '×'=>'&#215;',
			'Ø'=>'&#216;', 'Ù'=>'&#217;', 'Ú'=>'&#218;', 'Û'=>'&#219;', 'Ü'=>'&#220;',
			'Ý'=>'&#221;', 'Þ'=>'&#222;', 'ß'=>'&#223;', 'à'=>'&#224;', 'á'=>'&#225;',
			'â'=>'&#226;', 'ã'=>'&#227;', 'ä'=>'&#228;', 'å'=>'&#229;', 'æ'=>'&#230;',
			'ç'=>'&#231;', 'è'=>'&#232;', 'é'=>'&#233;', 'ê'=>'&#234;', 'ë'=>'&#235;',
			'ì'=>'&#236;', 'í'=>'&#237;', 'î'=>'&#238;', 'ï'=>'&#239;', 'ð'=>'&#240;',
			'ñ'=>'&#241;', 'ò'=>'&#242;', 'ó'=>'&#243;', 'ô'=>'&#244;', 'õ'=>'&#245;',
			'ö'=>'&#246;', '÷'=>'&#247;', 'ø'=>'&#248;', 'ù'=>'&#249;', 'ú'=>'&#250;',
			'û'=>'&#251;', 'ü'=>'&#252;', 'ý'=>'&#253;', 'þ'=>'&#254;', 'ÿ'=>'&#255;'
		);

	/** 
	 * Converts  the given $value to $type and return that value
	 * 
	 * @static	static
	 * @param	string	$data
	 * @param	string	$type
	 * @return	mixed
	 */
	public static function convertTo($data, $type){
		$converted = null;
		switch (strtoupper($type)){
			case 'INTEGER':
			case 'INT64':
			case 'INT':
				$converted = (int)$data;
				break;
			case 'FLOAT':
			case 'DECIMAL':
			case 'FRACTION':
				$converted = (float)$data;
				break;
			case 'STRING':
				$converted = self::convertIsoToEntities((string)$data);
				break;
			case 'BOOL':
			case 'BOOLEAN':
				if((strtoupper($data) == 'FALSE') || ($data == '0')){
					$converted = false;
				}else{
					$converted = (bool)$data;
				}
				break;
			case 'DATE':
			case 'DATETIME':
				if (($timestamp = strtotime($data)) === false) {
					$converted = date(Date::MYSQL_DATETIME_FORMAT);
					ErrorLogger::writeLine('Invalid datetime format: ' . $data, false);
				} else {
					$converted = date(Date::MYSQL_DATETIME_FORMAT, $timestamp);
				}
				break;
			case 'TIMECODE':
			case 'COORDS':
			default:
				$converted = $data;
		}
		return $converted;
	}
	
	/** 
	 * Finds and replaces all ISO-8859-1 chars in $text to a XML compatible format
	 * Don't work with some Greek and French characters.
	 * 
	 * @static	static
	 * @param	string	$text
	 * @return	string
	 */
	public static function convertIsoToEntities($text){
		$text = utf8_decode($text);
		$text = htmlspecialchars($text);
	    return strtr($text, self::$isoToXml);
	}
	
	/**
	 * Decodes a text with XML compatible format to ISO-8859-1 characters
	 * 
	 * @static	static
	 * @param	string	$text
	 * @return	string
	 */
	public static function convertEntitiesToIso($text){
		$text = strtr($text, self::$xmlToIso);
	    return utf8_decode($text);
	}
	
	/**
	 * Decodes a text with PHP compatible format
	 * 
	 * @static	static
	 * @param	string	$text
	 * @param	bool	$nl2br
	 * @return	string
	 */
	public static function FormsToPhp($text, $nl2br=true){
		if($nl2br){
			return nl2br(htmlentities(utf8_decode(trim($text)), ENT_COMPAT, 'UTF-8', false));
		} else {
			return htmlentities(utf8_decode(trim($text)), ENT_COMPAT, 'UTF-8', false);
		}
	}
	
	/**
	 * Encodes a text to HTML form compatible format
	 * 
	 * @static	static
	 * @param	string	$text
	 * @param	bool	$br2nl
	 * @return	string
	 */
	public static function PhpToForms($text, $br2nl=true){
		if($br2nl){
			return str_replace('<br />', "\n", utf8_encode(html_entity_decode(trim($text))));
		} else {
			return utf8_encode(html_entity_decode(trim($text)));
		}
	}
}