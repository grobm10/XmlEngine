<?php
/**  
 * @author David Curras
 * @version		June 6, 2012
 */
require_once '../siteConfig.php';
require_once '../Utils/Bootstrap.php';
Bootstrap::SetRequiredFiles();

try {
	$csvType = 'csvSummary';
	if(!empty($_GET['type']) && strtolower($_GET['type']) == 'csvdetailed'){
		$csvType = 'csvDetailed';
	}
	$csvArray = csvDataBind(createCsvStructure($csvType), getCsvData(), $csvType);
	generateXlsFile($csvArray);
} catch (Exception $e) {
	throw $e;
}
die();

/**
 * Generates a two-dimensional array that represents columns for the xls file \
 * also adds header row.
 * 
 * @param	String	$csvType
 * @return	Array|Array
 */
function createCsvStructure($csvType) {
	$csvStructureArray = array();
	$headerRow = array();
	array_push($headerRow, array('value'=>'Proc Id', 'style'=>'NumericColumn', 'width'=>'50', 'type'=>'String', 'auto'=>'1'));
	array_push($headerRow, array('value'=>'File Name', 'style'=>'GeneralColumn', 'width'=>'200', 'type'=>'String', 'auto'=>'1'));
	array_push($headerRow, array('value'=>'Partner', 'style'=>'GeneralColumn', 'width'=>'60', 'type'=>'String', 'auto'=>'1'));
	array_push($headerRow, array('value'=>'Process Date', 'style'=>'GeneralColumn', 'width'=>'75', 'type'=>'String', 'auto'=>'1'));
	array_push($headerRow, array('value'=>'Show', 'style'=>'GeneralColumn', 'width'=>'80', 'type'=>'String', 'auto'=>'1'));
	array_push($headerRow, array('value'=>'Season', 'style'=>'NumericColumn', 'width'=>'50', 'type'=>'String', 'auto'=>'1'));
	array_push($headerRow, array('value'=>'Region', 'style'=>'GeneralColumn', 'width'=>'45', 'type'=>'String', 'auto'=>'1'));
	array_push($headerRow, array('value'=>'Language', 'style'=>'GeneralColumn', 'width'=>'65', 'type'=>'String', 'auto'=>'1'));
	array_push($headerRow, array('value'=>'Proc Type', 'style'=>'GeneralColumn', 'width'=>'95', 'type'=>'String', 'auto'=>'1'));
	array_push($headerRow, array('value'=>'Success', 'style'=>'GeneralColumn', 'width'=>'60', 'type'=>'String', 'auto'=>'1'));
	if(strtoupper($csvType) == 'CSVDETAILED'){
		array_push($headerRow, array('value'=>'Episode', 'style'=>'GeneralColumn', 'width'=>'135', 'type'=>'String', 'auto'=>'1'));
		array_push($headerRow, array('value'=>'Description', 'style'=>'NumericColumn', 'width'=>'150', 'type'=>'String', 'auto'=>'1'));
		array_push($headerRow, array('value'=>'Release Date', 'style'=>'DateColumn', 'width'=>'75', 'type'=>'String', 'auto'=>'1'));
		array_push($headerRow, array('value'=>'File Size', 'style'=>'DateColumn', 'width'=>'66', 'type'=>'String', 'auto'=>'1'));
		array_push($headerRow, array('value'=>'File MD5', 'style'=>'DateColumn', 'width'=>'175', 'type'=>'String', 'auto'=>'1'));
	}
	array_push($csvStructureArray, $headerRow);
	return $csvStructureArray;
}

/**
 * Retrieves the csv data from database
 * 
 * @return Array|string
 */
function getCsvData() {
	if(!empty($_GET['action'])){
		$action = $_GET['action'];
		$processes = array();
		if(!empty($_GET['params'])){
			$processes = ProcessModel::$action($_GET['params']);
		}else{
			$processes = ProcessModel::$action();
		}
		$csvData = array();
		foreach($processes as $process){
			if($process->getState()->getId() > 1){
				$data = array(
					'id' => $process->getId(),
					'fileName' => $process->getBundle()->getVideo()->getFileName(),
					'partner' => $process->getBundle()->getPartner()->getName(),
					'processDate' => $process->getProcessDate(),
					'show' => $process->getBundle()->getVideo()->getMetadata()->getSeriesName(),
					'season' => $process->getBundle()->getVideo()->getMetadata()->getSeasonNumber(),
					'region' => $process->getBundle()->getRegion()->getCode(),
					'language' => $process->getBundle()->getLanguage()->getCode(),
					'type' => $process->getType()->getName(),
					'success' => $process->getState()->getName(),
					'episode' => $process->getBundle()->getVideo()->getMetadata()->getEpisodeNumber().' - '.$process->getBundle()->getVideo()->getMetadata()->getDTOEpisodeName(),
					'description' => $process->getBundle()->getVideo()->getMetadata()->getDTOLongDescription(),
					'releaseDate' => $process->getBundle()->getVideo()->getMetadata()->getDTOReleaseDate(),
					'fileSize' => $process->getBundle()->getVideo()->getSize(),
					'fileMD5' => $process->getBundle()->getVideo()->getMD5Hash()
				);
				$key = 'p'.$process->getBundle()->getPartner()->getId();
				$key .= '_'.$process->getBundle()->getLanguage()->getCode();
				$key .= '_'.str_replace(array('.','-'), '_', $process->getBundle()->getVideo()->getFileName());
				$csvData[$key]= $data;
			}
		}
		return $csvData;
	} else {
		throw new Exception('Unable to recognize the data to export. CvsExporter->getCsvData()');
	}
}

/**
 * Fills the csv structure array with the database info
 * 
 * @param		array|array		$csvArray
 * @param		array|array		$csvData
 * @param		String			$csvType
 * @return		array|array
 */
function csvDataBind($csvArray, $csvData, $csvType){
	if (!empty($csvData) && is_array($csvData)){
	    foreach($csvData as $processData){
	        $dataRow = array();
			array_push($dataRow, array('value'=>$processData['id'], 'style'=>'NumericRowCell', 'width'=>'50', 'type'=>'Number', 'auto'=>'1'));
			array_push($dataRow, array('value'=>$processData['fileName'], 'style'=>'GeneralRowCell', 'width'=>'200', 'type'=>'String', 'auto'=>'1'));
			array_push($dataRow, array('value'=>$processData['partner'], 'style'=>'GeneralRowCell', 'width'=>'60', 'type'=>'String', 'auto'=>'1'));
			//Must replace the MySQL DateTime format to Excel DateTime format
			array_push($dataRow, array('value'=>str_replace(' ', 'T', $processData['processDate']), 'style'=>'DateRowCell', 'width'=>'75', 'type'=>'DateTime', 'auto'=>'1'));
			array_push($dataRow, array('value'=>$processData['show'], 'style'=>'GeneralRowCell', 'width'=>'80', 'type'=>'String', 'auto'=>'1'));
			array_push($dataRow, array('value'=>$processData['season'], 'style'=>'NumericRowCell', 'width'=>'50', 'type'=>'Number', 'auto'=>'1'));
			array_push($dataRow, array('value'=>$processData['region'], 'style'=>'GeneralRowCell', 'width'=>'45', 'type'=>'String', 'auto'=>'1'));
			array_push($dataRow, array('value'=>$processData['language'], 'style'=>'GeneralRowCell', 'width'=>'65', 'type'=>'String', 'auto'=>'1'));
			array_push($dataRow, array('value'=>$processData['type'], 'style'=>'GeneralRowCell', 'width'=>'95', 'type'=>'String', 'auto'=>'1'));
			array_push($dataRow, array('value'=>$processData['success'], 'style'=>'GeneralRowCell', 'width'=>'60', 'type'=>'String', 'auto'=>'1'));
			if(strtoupper($csvType) == 'CSVDETAILED'){
				array_push($dataRow, array('value'=>$processData['episode'], 'style'=>'GeneralRowCell', 'width'=>'135', 'type'=>'String', 'auto'=>'1'));
				array_push($dataRow, array('value'=>$processData['description'], 'style'=>'GeneralRowCell', 'width'=>'150', 'type'=>'String', 'auto'=>'0'));
				array_push($dataRow, array('value'=>$processData['releaseDate'], 'style'=>'GeneralRowCell', 'width'=>'75', 'type'=>'String', 'auto'=>'1'));
				array_push($dataRow, array('value'=>$processData['fileSize'], 'style'=>'NumericRowCell', 'width'=>'66', 'type'=>'Number', 'auto'=>'1'));
				array_push($dataRow, array('value'=>$processData['fileMD5'], 'style'=>'GeneralRowCell', 'width'=>'175', 'type'=>'String', 'auto'=>'1'));
			}
			array_push($csvArray, $dataRow);
	    }
	} else {
		throw new Exception('Unable to recognize the data to export. CvsExporter->csvDataBind().');
	}
	return $csvArray;
}

/**
 * Generates the xls file with given data structure
 * 
 * @param	Array|Array	$csvArray
 */
function generateXlsFile($csvArray) {
	$style = 0;
	if(!empty($_GET['style'])){
		$style = $_GET['style'];
	}
	$xls = new ExcelXml($style);
	$xls->addRowsFromArray($csvArray, true);
	$xls->generate('XmlEngineReport'.date('YmdHms'));
};