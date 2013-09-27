<?php

/**
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/MTV/XmlCreators/SonyXmlCreator.php
 */
class SonyXmlCreator extends AbstractXmlCreator {

	/**
	 * Creates the Sony Short Form XML
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
		$parser = new SonyXmlParser();
		$sonyXmlFields = $parser->getPartnerXmlFields($bundle);
		$xmlRoot = new SimpleXMLElement("<Product></Product>");
		//Root level childs
		$rootType = $xmlRoot->addChild("Type", "TV-EPISODE");
		$rootSeasonBundleID = $xmlRoot->addChild("SeasonBundleID", $sonyXmlFields['seasonBundleID']);
		$rootProvider = $xmlRoot->addChild("Provider", "Viacom");
		$rootGlobalSeriesName = $xmlRoot->addChild("GlobalSeriesName", $sonyXmlFields['globalSeriesName']);
		$rootGlobalSeasonName = $xmlRoot->addChild("GlobalSeasonName", $sonyXmlFields['globalSeasonName']);
		$rootGlobalEpisodeName = $xmlRoot->addChild("GlobalEpisodeName", $sonyXmlFields['globalEpisodeName']);
		$rootCountryOfOrigin = $xmlRoot->addChild("CountryOfOrigin", $sonyXmlFields['countryOfOrigin']);
		$rootProductId = $xmlRoot->addChild("ProductId", $sonyXmlFields['productId']);
		$rootCopyRightNotice = $xmlRoot->addChild("CopyRightNotice",$sonyXmlFields['copyRightNotice']);
		$rootCountries = $xmlRoot->addChild("Countries");
		$rootGenres = $xmlRoot->addChild("Genres");
		$rootRuntime = $xmlRoot->addChild("Runtime", $sonyXmlFields['runtime']);
		//2nd level childs
		$countriesCountry = $rootCountries->addChild("Country");
		$genresGenre = $rootGenres->addChild("Genre", $sonyXmlFields['genre']);
		//3rd level childs
		$countryLanguages = $countriesCountry->addChild("Languages");
		$countryAirDate = $countriesCountry->addChild("InitialAirDate", $sonyXmlFields['initialAirDate']);
		$countryContentRatings = $countriesCountry->addChild("ContentRatings");
		$countryOffers = $countriesCountry->addChild("Offers");
		$countryCastMembers = $countriesCountry->addChild("CastMembers");
		$countryCrewMembers = $countriesCountry->addChild("CrewMembers");
		//4th level childs
		$languagesLanguage = $countryLanguages->addChild("Language"); 
		//5th level childs
		$languageLocalSeriesName = $languagesLanguage->addChild("LocalSeriesName", $sonyXmlFields['localSeriesName']);
		$languageLocalSeriesDesc = $languagesLanguage->addChild("LocalSeriesDescription", $sonyXmlFields['localSeriesDescription']);
		$languageLocalSeasonName = $languagesLanguage->addChild("LocalSeasonName", $sonyXmlFields['localSeasonName']);
		$languageLocalSeasonDesc = $languagesLanguage->addChild("LocalSeasonDescription", $sonyXmlFields['localSeasonDescription']);
		$languageLocalEpisodeName = $languagesLanguage->addChild("LocalEpisodeName", $sonyXmlFields['localEpisodeName']);
		$languageEpisodeNumber = $languagesLanguage->addChild("EpisodeNumber", $sonyXmlFields['episodeNumber']);
		$languageContainerPosition = $languagesLanguage->addChild("ContainerPosition", $sonyXmlFields['containerPosition']);
		$languageShortDesc = $languagesLanguage->addChild("ShortDescription", $sonyXmlFields['shortDescription']);
		$languageLongDesc = $languagesLanguage->addChild("LongDescription", $sonyXmlFields['longDescription']);
		$languageDisplayNetwork = $languagesLanguage->addChild("DisplayNetwork", $sonyXmlFields['displayNetwork']);
		//Attributes
		$rootRuntime->addAttribute("format", "hh:mm:ss"); //1st Level       
		$countriesCountry->addAttribute("code", $sonyXmlFields['countryOfOrigin']); //2nd Level
		$countryAirDate->addAttribute("format", "yyyy-mm-dd"); //3rd Level
		$languagesLanguage->addAttribute("code", $sonyXmlFields['code']); //4th Level
		
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
