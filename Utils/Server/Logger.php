<?php

/** 
 * @author			David Curras
 * @version			October 6, 2012
 * @filesource		/Utils/Server/Log.php
 */
class Logger {
	
	const LOW_VERBOSITY = 'LOW';
	const MEDIUM_VERBOSITY = 'MEDIUM';
	const FULL_VERBOSITY = 'FULL';
	
	const HTML_H1_OUTPUT = 'H1';
	const HTML_H2_OUTPUT = 'H2';
	const HTML_H3_OUTPUT = 'H3';
	const HTML_HR_PRE_OUTPUT = 'HR';
	const HTML_HR_POS_OUTPUT = 'HR/';
	const HTML_BOLD_OUTPUT = 'B';
	const HTML_ITALIC_OUTPUT = 'I';
	const HTML_UNDERLINE_OUTPUT = 'U';
	const HTML_OPEN_BLOC = 'PRE';
	const HTML_CLOSE_BLOC = '/PRE';
	
	/**
	 *	The log verbosity level
	 */
	private static $Verbosity;
	
	/**
	 *	The log file path to write
	 */
	private $textFilePath;
	
	/**
	 *	The html file path to write
	 */
	private $htmlFilePath;
	
	/**
	 *	The errors log file path to write
	 */
	private $errorsFilePath;
	
	/**
	 * Initializes properties
	 */
	public function __construct() {
		$fileName = LOCAL_LOG_FOLDER . strtoupper(AbstractController::GetPartner()).'/'.self::$Verbosity.'-'.Shell::GetSystemDate('%Y-%m-%d--%H-%M-%S');
		$this->textFilePath = $fileName.'.log';
		$this->htmlFilePath = $fileName.'.html';
		$this->htmlFilePath = $fileName.'-errors.log';
	}
	
	/**
	 * Sets the verbosity level
	 */
	public function SetVerbosity($level) {
		switch(strtoupper($level)){
			case '3':
			case 'FULL':
			case 'F':
			case 'HIGH':
			case 'H':
				self::$Verbosity = self::FULL_VERBOSITY;
				break;
			case '2':
			case 'MEDIUM':
			case 'M':
				self::$Verbosity = self::MEDIUM_VERBOSITY;
				break;
			case '1':
			case 'LOW':
			case 'L':
			default:
				self::$Verbosity = self::LOW_VERBOSITY;
				break;
		}
	}
	
	/**
	 *	Writes into the text file and the html file
	 *
	 *	@param		string		$logText
	 *	@example	$log->writeFile();
	 */
	public function setHtmlWrappers($text, $wrappers){
		$pre = array();
		$pos = array();
		$wrap = array();
		foreach($wrappers as $wrapper){			
			switch($wrapper){
				case self::HTML_H1_OUTPUT:
					array_push($wrap, $wrapper);
					break;
				case self::HTML_H2_OUTPUT:
					array_push($wrap, $wrapper);
					break;
				case self::HTML_H3_OUTPUT:
					array_push($wrap, $wrapper);
					break;
				case self::HTML_HR_PRE_OUTPUT:
					array_push($pre, '<hr />');
					break;
				case self::HTML_HR_POS_OUTPUT:
					array_push($pos, '<hr />');
					break;
				case self::HTML_BOLD_OUTPUT:
					array_push($wrap, $wrapper);
					break;
				case self::HTML_ITALIC_OUTPUT:
					array_push($wrap, $wrapper);
					break;
				case self::HTML_UNDERLINE_OUTPUT:
					array_push($wrap, $wrapper);
					break;
				case self::HTML_OPEN_BLOC:
					array_push($pre, '<pre>');
					break;
				case self::HTML_CLOSE_BLOC:
					array_push($pos, '</pre>');
					break;
			}
		}
		foreach($pre as $wrapper){
			$text = $wrapper . $text;
		}
		foreach($wrap as $wrapper){
			switch($wrapper){
				case self::HTML_H1_OUTPUT:
					$text = '<h1>'.$text.'</h1>';
				case self::HTML_H2_OUTPUT:
					$text = '<h2>'.$text.'</h2>';
				case self::HTML_H3_OUTPUT:
					$text = '<h3>'.$text.'</h3>';
				case self::HTML_BOLD_OUTPUT:
					$text = '<b>'.$text.'</b>';
				case self::HTML_ITALIC_OUTPUT:
					$text = '<i>'.$text.'</i>';
				case self::HTML_UNDERLINE_OUTPUT:
					$text = '<u>'.$text.'</u>';
			}
		}
		foreach($pos as $wrapper){
			$text = $wrapper . $text;
		}
		return $text;
	}
	
	/**
	 *	Writes into the text file and the html file
	 *
	 *	@param		string		$logText
	 *	@example	$log->writeFile();
	 */
	public function addText($text='', $verbosity=self::LOW_VERBOSITY, $htmlWrappers=array()){
		$html = $this->setHtmlWrappers($text, $htmlWrappers);
		
	}
	
	/**
	 *	Writes into the text file and the html file
	 *
	 *	@param		string		$logText
	 *	@example	$log->writeFile();
	 */
	public function writeFile($logText=''){
		$logText .= "\n";
		$fh = fopen($this->textFilePath, 'a') or die('Can not open log file');
		fwrite($fh, $logText);
		fclose($fh);
	}
}