<?php
/**
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/Server/HtmlPage.php
 */

class HtmlPage
{
	/**
	 *	The unique instance of the class
	 */
	private static $instance;
	private $layout;
	private $title;
	private $description;
	private $keywords;
	private $styleSheets;
	private $scripts;
	private $favicon;
		
	/**
	 * This class is a Singleton, 
	 * so must be intanciated with the static method getInstance()
	 */
	private function __construct() {
		$this->layout = 'main';
		$this->title = '';
		$this->description = '';
		$this->keywords = '';
		$this->styleSheets = array();
		$this->scripts = array();
		$this->favicon = '/XmlEngine.dev/resources/img/favicon.png';
	}

	/**
	 *	The HtmlPage is automatically initialized if it wasn't.
	 *
	 *	@example	$myHtmlPage = HtmlPage::getInstance();
	 *	@return		object	The instance of 'HtmlPage'
	 */
	public static function getInstance()
	{
		if (!isset(self::$instance)){
			self::$instance = new self;
		}
		return self::$instance;
	}

	/**
	 *	Sets the page layout name
	 */
	public function setLayout($layout)
	{
		self::$instance->layout = $layout;
	}

	/**
	 *	Sets the page title
	 */
	public function setTitle($title)
	{
		self::$instance->title = $title;
	}
	
	/**
	 *	Sets the page description
	 */
	public function setDescription($description)
	{
		self::$instance->description = $description;
	}
	
	/**
	 *	Sets the page keywords
	 */
	public function setKeywords($keywords)
	{
		self::$instance->keywords = $keywords;
	}
	
	/**
	 *	Adds stylesheets to the css array
	 */
	public function addStyleSheets($styleSheets)
	{
		if(is_array($styleSheets)){
			foreach($styleSheets as $css){
				array_push(self::$instance->styleSheets, $css);
			}
		} elseif(is_string($styleSheets)) {
			array_push(self::$instance->styleSheets, $styleSheets);
		} else {
			throw new Exception('Unexpected param type');
		}
	}
	
	/**
	 *	Adds scripts to the js array
	 */
	public function addScripts($scripts)
	{
		if(is_array($scripts)){
			foreach($scripts as $css){
				array_push(self::$instance->scripts, $css);
			}
		} elseif(is_string($scripts)) {
			array_push(self::$instance->scripts, $scripts);
		} else {
			throw new Exception('Unexpected param type');
		}
	}
	
	/**
	 *	Sets the page favicon
	 */
	public function setFavicon($favicon)
	{
		self::$instance->favicon = $favicon;
	}
	
	/**
	 *	Sets the page favicon
	 *
	 *	@param		string 		$controller
	 *	@param		string 		$action
	 *	@return		object		The instance of 'Bootstrap'
	 *	@example	$myHtmlPage->render($controller, $action));
	 */
	public function render($controller, $action)
	{
		$layoutFilePath = LAYOUT_PATH . DIR_SEPARATOR . self::$instance->layout . '.phtml';
		$contentFilePath = CONTENT_PATH . DIR_SEPARATOR . ucfirst(strtolower($controller)) .
						 DIR_SEPARATOR . ucfirst(strtolower($action)) . '.phtml';
		if(!is_file($layoutFilePath)){
			throw new Exception('Unable to open the layout file: ' . $layoutFilePath);
		} else if(!is_file($contentFilePath)){
			throw new Exception('Unable to open the content file: ' . $contentFilePath);
		}
		$xhtmlText = $this->generateXhtmlHeader();
		$xhtmlText .= $this->generateXhtmlBody($layoutFilePath, $contentFilePath);
		$xhtmlText .= $this->generateXhtmlClose();
		echo $xhtmlText;
	}
	
	/**
	 *	Creates the html header with the current properties
	 *
	 *	@return		string		The html header text
	 */
	private function generateXhtmlHeader(){
		$xhtmlText = '';
		Xml::addXmlLine($xhtmlText, '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" '.
						'"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">', 0);
		Xml::addXmlLine($xhtmlText, '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">', 0);
		Xml::addXmlLine($xhtmlText, '<head profile="http://www.w3.org/2005/10/profile">', 1);
		Xml::addXmlLine($xhtmlText, '<title>' . $this->title . '</title>', 2);
		Xml::addXmlLine($xhtmlText, '<meta name="Description" content="' . $this->description . '" />', 2);
		Xml::addXmlLine($xhtmlText, '<meta name="Keywords" content="' . $this->keywords . '" />', 2);
		Xml::addXmlLine($xhtmlText, '<meta http-equiv="Content-Type" content="text/html; charset=\'utf-8\'"/>', 2);
		foreach($this->styleSheets as $css){
			Xml::addXmlLine($xhtmlText, '<link rel="stylesheet" type="text/css" charset="utf-8" href="' . $css . '" />', 2);
		}
		foreach($this->scripts as $js){
			Xml::addXmlLine($xhtmlText, '<script type="text/javascript" src="' . $js . '"></script>', 2);
		}
		Xml::addXmlLine($xhtmlText, '<link rel="icon" type="image/png" href="' . $this->favicon . '"/>', 2);
		Xml::addXmlLine($xhtmlText, '</head>', 1);
		return $xhtmlText;
	}
	
	/**
	 *	Creates the html body from the layout and content files
	 *
	 *	@param		string 		$layoutFilePath
	 *	@param		string 		$contentFilePath
	 *	@return		string		The html body text
	 */
	private function generateXhtmlBody($layoutFilePath, $contentFilePath){
		$xhtmlText = '';
		Xml::addXmlLine($xhtmlText, '<body>', 1);
		$layoutFileArray = file($layoutFilePath);
		$contentFileArray = file($contentFilePath);
		foreach($layoutFileArray as $layoutLine){
			if(substr(trim($layoutLine), 0, 6) != '<phtml' ){
				Xml::addXmlLine($xhtmlText, $layoutLine, 2, false);
			} else {
				$this->addContent($xhtmlText, $layoutLine, $contentFileArray);
			}
		}
		return $xhtmlText;
	}
	
	/**
	 *	Parses the $contentFileArray to find the $phtmlLine and adds the lines
	 *
	 *	@param		string			&$xhtmlText
	 *	@param		string 			$phtmlLine
	 *	@param		Array|string 	$contentFileArray
	 */
	private function addContent(&$xhtmlText, $phtmlLine, $contentFileArray){
		$tmpNameArray = explode('name="', $phtmlLine);
		$phtmlName = substr($tmpNameArray[1], 0, strpos($tmpNameArray[1], '"'));
		$tmpTabArray = explode('tab="', $phtmlLine);
		$phtmlTab = intval(substr($tmpTabArray[1], 0, strpos($tmpTabArray[1], '"')));
		$found = false;
		foreach($contentFileArray as $contentLine){
			//if not found keep searching
			if(!$found){
				$isPhtmlTag = substr(trim($contentLine), 0, 6) == '<phtml';
				$isPhtmlName = strpos($contentLine, 'name="'.$phtmlName.'"');
				if($isPhtmlTag && $isPhtmlName){
					$found = true;
				}
			} else {
				//if found add all lines until find '</phtml>'
				if(substr(trim($contentLine), 0, 8) != '</phtml>' ){
					Xml::addXmlLine($xhtmlText, $contentLine, $phtmlTab, false);
				} else {
					break;
				}
			}
		}
		if(!$found){
			throw new Exception('Unable to found phtml tag with name: ' . $phtmlName);
		}
	}
	
	/**
	 *	Creates the html text to close body and html tags
	 *
	 *	@return		string		The html body text
	 */
	private function generateXhtmlClose(){
		$xhtmlText = '';
		Xml::addXmlLine($xhtmlText, '</body>', 1);
		Xml::addXmlLine($xhtmlText, '</html>', 0);
		return $xhtmlText;
	}
}