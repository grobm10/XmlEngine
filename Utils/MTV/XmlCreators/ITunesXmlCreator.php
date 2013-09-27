<?php

/**
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/MTV/XmlCreators/ITunesXmlCreator.php
 */
class ITunesXmlCreator extends AbstractXmlCreator {

	/**
	 * Creates the iTunes Short Form XML
	 * 
	 * @param		Bundle				$bundle
	 * @param		string				$destFolder
	 * @param		string				$fileName
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
		$parser = new ITunesXmlParser();
		$iTunesXmlFields = $parser->getPartnerXmlFields($bundle);
		//TODO: uncomment to switch test and live version
		$xmlRoot = new SimpleXMLElement('<package></package>');
		//Root level childs
		$rootProvider = $xmlRoot->addChild('provider', ITunesTransporter::$Provider);
		$rootLanguage = $xmlRoot->addChild('language', strtolower($bundle->getLanguage()->getAlt()).'-'.strtoupper($bundle->getRegion()->getCode()));
		$rootVideo = $xmlRoot->addChild('video');
		//2nd level childs
		$videoType = $rootVideo->addChild('type', $iTunesXmlFields['type']);
		$videoContainerId = $rootVideo->addChild('container_id', $iTunesXmlFields['container_id']);
		//$videoContainerId = $rootVideo->addChild('container_id', 'TEST_CONTAIN_ID');
		$videoContainerPosition = $rootVideo->addChild('container_position', $iTunesXmlFields['container_position']);
		$videoContainerPosition = $rootVideo->addChild('vendor_id', substr($bundle->getVideo()->getFileName(), 0, -4));
		$videoEpisodeProductionNumber = $rootVideo->addChild('episode_production_number', $iTunesXmlFields['episode_production_number']);
		$videoOriginalSpokenLocale = $rootVideo->addChild('original_spoken_locale', 'en-US');
		$videoTitle = $rootVideo->addChild('title', $iTunesXmlFields['title']);
		$videoDescription = $rootVideo->addChild('description', $iTunesXmlFields['description']);
		$videoNetworkName = $rootVideo->addChild('network_name', $iTunesXmlFields['network_name']);
		$videoReleaseDate = $rootVideo->addChild('release_date', $iTunesXmlFields['release_date']);
		$videoCopyrightCline = $rootVideo->addChild('copyright_cline', $iTunesXmlFields['copyright_cline']);
		$videoAssets = $rootVideo->addChild('assets');
		$videoPreview = $rootVideo->addChild('preview');
		$videoProducts = $rootVideo->addChild('products');
		//3rd level childs
		$assetsAsset = $videoAssets->addChild('asset');
		$productsProduct = $videoProducts->addChild('product');
		//4th level childs
		$assetDataFile = $assetsAsset->addChild('data_file');
		$productTerritory = $productsProduct->addChild('territory', $iTunesXmlFields['territory']);
		$productClearedForSale = $productsProduct->addChild('cleared_for_sale', 'true');
		$productSalesStartDate = $productsProduct->addChild('sales_start_date', $iTunesXmlFields['sales_start_date']);   
		//5th level childs
		$dataFileLocale = $assetDataFile->addChild('locale');   
		$dataFileFileName = $assetDataFile->addChild('file_name', $iTunesXmlFields['file_name']);
		$dataFileSize = $assetDataFile->addChild('size', $iTunesXmlFields['size']);
		$dataFileChecksum = $assetDataFile->addChild('checksum', $iTunesXmlFields['checksum']);
		//Attributes
		$xmlRoot->addAttribute('xmlns', 'http://apple.com/itunes/importer'); //root
		$xmlRoot->addAttribute('version', 'tv4.0'); //root
		$videoPreview->addAttribute('starttime', '360'); //2nd level
		$assetsAsset->addAttribute('type', 'full'); //3rd level
		$dataFileLocale->addAttribute('name', strtolower($bundle->getLanguage()->getAlt()).'-'.strtoupper($bundle->getRegion()->getCode())); //5th level
		$dataFileChecksum->addAttribute('type', 'md5'); //5th level

		$outputXML = self::GetPrettyXml($xmlRoot);
		$fh = fopen($filePath, 'w') or die('can\'t open file');
		fwrite($fh, $outputXML);
		fclose($fh);
		if(is_file($filePath)){
			chmod($filePath, 0775);
		} else {
			throw new Exception('Unable to create file "'.$filePath.'". ITunesXmlCreator::CreateXML().');
		}
		return true;  
	}
}
