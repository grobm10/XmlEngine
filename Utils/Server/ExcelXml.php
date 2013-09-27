<?php

/** 
 * Uses the excel XML-specification to generate a native
 * XML document, readable/processable by excel.
 *  
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/Server/ExcelXml.php
 * @see				http://msdn.microsoft.com/en-us/library/aa140066%28v=office.10%29.aspx
 * @see				http://www.stylusstudio.com/xmldev/200306/post80340.html
 */
class ExcelXml{

	private $xmlHeader = '';
	private $styles = '';
	private $rows = '';
	private $xmlWorksheet = '';
	private $numOfColumns = 0;
	private $numOfRows = 0;
	
	public function __construct($style=0){
		$this->createXmlHeader();
		$this->createStyles($style);
	}
	
	private function createXmlHeader(){
		$this->addXmlLine($this->xmlHeader, '<?xml version="1.0"?>', 0);
		$this->addXmlLine($this->xmlHeader, '<?mso-application progid="Excel.Sheet"?>', 0);
		$this->addXmlLine($this->xmlHeader, '<Workbook', 0);
		$this->addXmlLine($this->xmlHeader, ' xmlns="urn:schemas-microsoft-com:office:spreadsheet"', 1);
		$this->addXmlLine($this->xmlHeader, ' xmlns:o="urn:schemas-microsoft-com:office:office"', 1);
		$this->addXmlLine($this->xmlHeader, ' xmlns:x="urn:schemas-microsoft-com:office:excel"', 1);
		$this->addXmlLine($this->xmlHeader, ' xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"', 1);
		$this->addXmlLine($this->xmlHeader, ' xmlns:html="http://www.w3.org/TR/REC-html40">', 1);
		$this->addXmlLine($this->xmlHeader, '<DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">', 1);
		$this->addXmlLine($this->xmlHeader, '<Author>MTV Digital Media Operations</Author>', 2);
		$this->addXmlLine($this->xmlHeader, '<Created>'.date(Date::MYSQL_DATE_FORMAT).'T'.date(Date::MYSQL_TIME_FORMAT).'Z</Created>', 2);
		$this->addXmlLine($this->xmlHeader, '</DocumentProperties>', 1);
		$this->addXmlLine($this->xmlHeader, '<OfficeDocumentSettings xmlns="urn:schemas-microsoft-com:office:office">', 1);
		$this->addXmlLine($this->xmlHeader, '<AllowPNG/>', 2);
		$this->addXmlLine($this->xmlHeader, '</OfficeDocumentSettings>', 1);
		$this->addXmlLine($this->xmlHeader, '<ExcelWorkbook xmlns="urn:schemas-microsoft-com:office:excel">', 1);
		$this->addXmlLine($this->xmlHeader, '<WindowHeight>10000</WindowHeight>', 2);
		$this->addXmlLine($this->xmlHeader, '<WindowWidth>10000</WindowWidth>', 2);
		$this->addXmlLine($this->xmlHeader, '<WindowTopX>120</WindowTopX>', 2);
		$this->addXmlLine($this->xmlHeader, '<WindowTopY>120</WindowTopY>', 2);
		$this->addXmlLine($this->xmlHeader, '<ProtectStructure>False</ProtectStructure>', 2);
		$this->addXmlLine($this->xmlHeader, '<ProtectWindows>False</ProtectWindows>', 2);
		$this->addXmlLine($this->xmlHeader, '</ExcelWorkbook>', 1);
	}
	
	private function createStyles($styleId){
		$this->addXmlLine($this->styles, '<Styles>', 1);
		//Default Style
		$this->addXmlLine($this->styles, '<Style ss:ID="Default" ss:Name="Normal">', 2);
		$this->addXmlLine($this->styles, '<Alignment ss:Vertical="Bottom" />', 3);
		$this->addXmlLine($this->styles, '<Borders/>', 3);
		$this->addXmlLine($this->styles, '<Font ss:FontName="Arial" x:Family="Swiss" ss:Size="10" ss:Color="#000000" />', 3);
		$this->addXmlLine($this->styles, '<Interior ss:Color="#FFFFFF" ss:Pattern="Solid" />', 3);
		$this->addXmlLine($this->styles, '<NumberFormat/>', 3);
		$this->addXmlLine($this->styles, '<Protection/>', 3);
		$this->addXmlLine($this->styles, '</Style>', 2);
		//Columns Style
		$this->addXmlLine($this->styles, '<Style ss:ID="GeneralColumn">', 2);
		$this->addXmlLine($this->styles, '<Alignment ss:Horizontal="Center" ss:Vertical="Center" />', 3);
		$this->addXmlLine($this->styles, '<Font ss:FontName="Arial" x:Family="Swiss" ss:Size="10" ss:Color="#000000" />', 3);
		$this->addXmlLine($this->styles, '</Style>', 2);
		$this->addXmlLine($this->styles, '<Style ss:ID="NumericColumn">', 2);
		$this->addXmlLine($this->styles, '<Alignment ss:Horizontal="Center" ss:Vertical="Center" />', 3);
		$this->addXmlLine($this->styles, '<Font ss:FontName="Arial" x:Family="Swiss" ss:Size="10" ss:Color="#000000" />', 3);
		$this->addXmlLine($this->styles, '<NumberFormat ss:Format="0" />', 3);
		$this->addXmlLine($this->styles, '</Style>', 2);
		$this->addXmlLine($this->styles, '<Style ss:ID="DateColumn">', 2);
		$this->addXmlLine($this->styles, '<Alignment ss:Horizontal="Center" ss:Vertical="Center" />', 3);
		$this->addXmlLine($this->styles, '<Font ss:FontName="Arial" x:Family="Swiss" ss:Size="10" ss:Color="#000000" />', 3);
		$this->addXmlLine($this->styles, '<NumberFormat ss:Format="m/d/yy\ h:mm;@" />', 3);
		$this->addXmlLine($this->styles, '</Style>', 2);
		//Header Style
		$this->addXmlLine($this->styles, '<Style ss:ID="HeaderCell">', 2);
		$this->addXmlLine($this->styles, '<Alignment ss:Horizontal="Center" ss:Vertical="Center" />', 3);
		$this->addXmlLine($this->styles, '<Borders>', 3);
		$this->addXmlLine($this->styles, '<Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" />', 4);
		$this->addXmlLine($this->styles, '<Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" />', 4);
		$this->addXmlLine($this->styles, '<Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" />', 4);
		$this->addXmlLine($this->styles, '<Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" />', 4);
		$this->addXmlLine($this->styles, '</Borders>', 3);
		$this->addXmlLine($this->styles, '<Font ss:FontName="Arial" x:Family="Swiss" ss:Color="#000000" ss:Bold="1" />', 3);
		if($styleId == 1){
			$this->addXmlLine($this->styles, '<Interior ss:Color="#A6A6A6" ss:Pattern="Solid" />', 3);
		} elseif($styleId == 2){
			$this->addXmlLine($this->styles, '<Interior ss:Color="#76933C" ss:Pattern="Solid" />', 3);
		} elseif($styleId == 3){
			$this->addXmlLine($this->styles, '<Interior ss:Color="#538DD5" ss:Pattern="Solid" />', 3);
		} else {
			$this->addXmlLine($this->styles, '<Interior ss:Color="#FFFFFF" ss:Pattern="Solid" />', 3);
		}
		$this->addXmlLine($this->styles, '</Style>', 2);
		//Row cells Style
		$this->addXmlLine($this->styles, '<Style ss:ID="GeneralRowCell">', 2);
		$this->addXmlLine($this->styles, '<Alignment ss:Horizontal="Left" ss:Vertical="Center" />', 3);
		$this->addXmlLine($this->styles, '<Borders>', 3);
		$this->addXmlLine($this->styles, '<Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" />', 4);
		$this->addXmlLine($this->styles, '<Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" />', 4);
		$this->addXmlLine($this->styles, '<Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" />', 4);
		$this->addXmlLine($this->styles, '<Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" />', 4);
		$this->addXmlLine($this->styles, '</Borders>', 3);
		$this->addXmlLine($this->styles, '<Font ss:FontName="Arial" ss:Size="10" ss:Color="#000000" />', 3);
		if($styleId == 1){
			$this->addXmlLine($this->styles, '<Interior ss:Color="#D9D9D9" ss:Pattern="Solid" />', 3);
		} elseif($styleId == 2){
			$this->addXmlLine($this->styles, '<Interior ss:Color="#D8E4BC" ss:Pattern="Solid" />', 3);
		} elseif($styleId == 3){
			$this->addXmlLine($this->styles, '<Interior ss:Color="#C5D9F1" ss:Pattern="Solid" />', 3);
		} else {
			$this->addXmlLine($this->styles, '<Interior ss:Color="#FFFFFF" ss:Pattern="Solid" />', 3);
		}
		$this->addXmlLine($this->styles, '</Style>', 2);
		$this->addXmlLine($this->styles, '<Style ss:ID="NumericRowCell">', 2);
		$this->addXmlLine($this->styles, '<Alignment ss:Horizontal="Center" ss:Vertical="Center" />', 3);
		$this->addXmlLine($this->styles, '<Borders>', 3);
		$this->addXmlLine($this->styles, '<Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" />', 4);
		$this->addXmlLine($this->styles, '<Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" />', 4);
		$this->addXmlLine($this->styles, '<Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" />', 4);
		$this->addXmlLine($this->styles, '<Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" />', 4);
		$this->addXmlLine($this->styles, '</Borders>', 3);
		$this->addXmlLine($this->styles, '<Font ss:FontName="Arial" ss:Size="10" ss:Color="#000000" />', 3);
		if($styleId == 1){
			$this->addXmlLine($this->styles, '<Interior ss:Color="#D9D9D9" ss:Pattern="Solid" />', 3);
		} elseif($styleId == 2){
			$this->addXmlLine($this->styles, '<Interior ss:Color="#D8E4BC" ss:Pattern="Solid" />', 3);
		} elseif($styleId == 3){
			$this->addXmlLine($this->styles, '<Interior ss:Color="#C5D9F1" ss:Pattern="Solid" />', 3);
		} else {
			$this->addXmlLine($this->styles, '<Interior ss:Color="#FFFFFF" ss:Pattern="Solid" />', 3);
		}
		$this->addXmlLine($this->styles, '<NumberFormat ss:Format="0" />', 3);
		$this->addXmlLine($this->styles, '</Style>', 2);
		$this->addXmlLine($this->styles, '<Style ss:ID="DateRowCell">', 2);
		$this->addXmlLine($this->styles, '<Alignment ss:Horizontal="Center" ss:Vertical="Center" />', 3);
		$this->addXmlLine($this->styles, '<Borders>', 3);
		$this->addXmlLine($this->styles, '<Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" />', 4);
		$this->addXmlLine($this->styles, '<Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" />', 4);
		$this->addXmlLine($this->styles, '<Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" />', 4);
		$this->addXmlLine($this->styles, '<Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" />', 4);
		$this->addXmlLine($this->styles, '</Borders>', 3);
		$this->addXmlLine($this->styles, '<Font ss:FontName="Arial" ss:Size="10" ss:Color="#000000" />', 3);
		if($styleId == 1){
			$this->addXmlLine($this->styles, '<Interior ss:Color="#D9D9D9" ss:Pattern="Solid" />', 3);
		} elseif($styleId == 2){
			$this->addXmlLine($this->styles, '<Interior ss:Color="#D8E4BC" ss:Pattern="Solid" />', 3);
		} elseif($styleId == 3){
			$this->addXmlLine($this->styles, '<Interior ss:Color="#C5D9F1" ss:Pattern="Solid" />', 3);
		} else {
			$this->addXmlLine($this->styles, '<Interior ss:Color="#FFFFFF" ss:Pattern="Solid" />', 3);
		}
		$this->addXmlLine($this->styles, '<NumberFormat ss:Format="m/d/yy\ h:mm;@" />', 3);
		$this->addXmlLine($this->styles, '</Style>', 2);
		
		$this->addXmlLine($this->styles, '</Styles>', 1);
	}

	private function addHeaderRow($columns){
		$this->numOfColumns = count($columns);
		//Add Columns Structure
		$i = 0;
		foreach($columns as $column){
			$columnText = '<Column ss:Index="'.++$i.'" ss:StyleID="' . $column['style'] . '" ss:AutoFitWidth="' . $column['auto'] . '" ss:Width="' . $column['width'] . '" />';
			$this->addXmlLine($this->rows, $columnText, 3);
		}
		//Add Header Rows
		$this->addXmlLine($this->rows, '<Row ss:AutoFitHeight="1">', 3);
		foreach($columns as $column){
			$cellText = '<Cell ss:StyleID="HeaderCell"><Data ss:Type="String">' . $column['value'] . '</Data></Cell>';
			$this->addXmlLine($this->rows, $cellText, 4);
		}
		$this->addXmlLine($this->rows, '</Row>', 3);
	}
	
	private function addRow($row){
		//Add Header Rows
		$this->addXmlLine($this->rows, '<Row ss:AutoFitHeight="1">', 3);
		foreach($row as $rowCell){
			$cellText = '<Cell ss:StyleID="' . $rowCell['style'] . '"><Data ss:Type="'.$rowCell['type'].'">' . $rowCell['value'] . '</Data></Cell>';
			$this->addXmlLine($this->rows, $cellText, 4);
		}
		$this->addXmlLine($this->rows, '</Row>', 3);
	}

	public function addRowsFromArray($rows, $addHeader=false){
		$this->numOfRows = count($rows);
		foreach($rows as $index => $row){
			if($addHeader && ($index == 0)){
				$this->addHeaderRow($row);
			} else {
				$this->addRow($row);
			}
		}
		if($this->numOfColumns == 0){
			$this->numOfColumns = count($rows[0]);
		}
	}

	private function createXmlWorksheet(){
		$xmlWorksheet = '';
		$this->addXmlLine($xmlWorksheet, '<Worksheet ss:Name="Sheet1">', 1);
		$this->addXmlLine($xmlWorksheet, '<Table ss:ExpandedColumnCount="' . $this->numOfColumns . '" ss:ExpandedRowCount="' . $this->numOfRows . '"', 2);
		$this->addXmlLine($xmlWorksheet, 'x:FullColumns="1" x:FullRows="1" ss:StyleID="GeneralColumn"', 3);
		$this->addXmlLine($xmlWorksheet, 'ss:DefaultColumnWidth="60" ss:DefaultRowHeight="14.25">', 3);
		$xmlWorksheet .= $this->rows;
		$this->addXmlLine($xmlWorksheet, '</Table>', 2);
		$this->addXmlLine($xmlWorksheet, '<WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">', 2);
		$this->addXmlLine($xmlWorksheet, '<ProtectObjects>False</ProtectObjects>', 3);
		$this->addXmlLine($xmlWorksheet, '<ProtectScenarios>False</ProtectScenarios>', 3);
		$this->addXmlLine($xmlWorksheet, '</WorksheetOptions>', 2);
		$this->addXmlLine($xmlWorksheet, '</Worksheet>', 1);
		return $xmlWorksheet;
	}
	
	public function generate($filename='Xml-Engine-Report'){
		header("Content-disposition: attachment; filename=\"" . $filename . ".xls\"");
		header("Content-Type: application/vnd.ms-excel; charset='UTF-8'");
		$filename = preg_replace('/[^aA-zZ0-9\_\-]/', '', $filename);
		$xml = $this->xmlHeader;
		$xml .= $this->styles;
		$xml .= $this->createXmlWorksheet();
		$this->addXmlLine($xml, '</Workbook>', 0);
		echo $xml;
		//echo('<pre>');var_dump($this->xmlHeader, stripslashes(sprintf($this->xmlHeader, $this->encoding)));echo('</pre>');die();
	}

	/**
	 * Adds a xml line with tabs to the current xml string var
	 * 
	 * @param string $xmlVar
	 * @param string $line
	 * @param int $tabsLevel
	 **/
	private function addXmlLine(&$xmlVar, $line, $tabsLevel){
		for ($i = 0; $i < $tabsLevel; $i++) {
			$xmlVar .= "\t";
		}
		$xmlVar .= $line . "\n";
	}	
}