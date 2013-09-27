<?php

/**
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/MTV/XmlCreators/XboxXmlCreator.php
 */
class XboxXmlCreator extends AbstractXmlCreator {

	/**
	 * Creates the Xbox Short Form XML
	 * 
	 * @param		Bundle				$bundle
	 * @param		string				$destFolder
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
		$parser = new XboxXmlParser();
		$xboxXmlFields = $parser->getPartnerXmlFields($bundle);
		$xmlRoot = new SimpleXMLElement("<Product></Product>");
		//Root level childs
		$rootType = $xmlRoot->addChild("Type", "TV-EPISODE");
		$rootSeasonBundleID = $xmlRoot->addChild("SeasonBundleID", $xboxXmlFields['seasonBundleID']);
		$rootProvider = $xmlRoot->addChild("Provider", "Viacom");
		$rootGlobalSeriesName = $xmlRoot->addChild("GlobalSeriesName", $xboxXmlFields['globalSeriesName']);
		$rootGlobalSeasonName = $xmlRoot->addChild("GlobalSeasonName", $xboxXmlFields['globalSeasonName']);
		$rootGlobalEpisodeName = $xmlRoot->addChild("GlobalEpisodeName", $xboxXmlFields['globalEpisodeName']);
		$rootCountryOfOrigin = $xmlRoot->addChild("CountryOfOrigin", $xboxXmlFields['countryOfOrigin']);
		$rootProductId = $xmlRoot->addChild("ProductId", $xboxXmlFields['productId']);
		$rootCopyRightNotice = $xmlRoot->addChild("CopyRightNotice",$xboxXmlFields['copyRightNotice']);
		$rootCountries = $xmlRoot->addChild("Countries");
		$rootGenres = $xmlRoot->addChild("Genres");
		$rootRuntime = $xmlRoot->addChild("Runtime", $xboxXmlFields['runtime']);
		//2nd level childs
		$countriesCountry = $rootCountries->addChild("Country");
		$genresGenre = $rootGenres->addChild("Genre", $xboxXmlFields['genre']);
		//3rd level childs
		$countryLanguages = $countriesCountry->addChild("Languages");
		$countryAirDate = $countriesCountry->addChild("InitialAirDate", $xboxXmlFields['initialAirDate']);
		$countryContentRatings = $countriesCountry->addChild("ContentRatings");
		$countryOffers = $countriesCountry->addChild("Offers");
		$countryCastMembers = $countriesCountry->addChild("CastMembers");
		$countryCrewMembers = $countriesCountry->addChild("CrewMembers");
		//4th level childs
		$languagesLanguage = $countryLanguages->addChild("Language"); 
		//5th level childs
		$languageLocalSeriesName = $languagesLanguage->addChild("LocalSeriesName", $xboxXmlFields['localSeriesName']);
		$languageLocalSeriesDesc = $languagesLanguage->addChild("LocalSeriesDescription", $xboxXmlFields['localSeriesDescription']);
		$languageLocalSeasonName = $languagesLanguage->addChild("LocalSeasonName", $xboxXmlFields['localSeasonName']);
		$languageLocalSeasonDesc = $languagesLanguage->addChild("LocalSeasonDescription", $xboxXmlFields['localSeasonDescription']);
		$languageLocalEpisodeName = $languagesLanguage->addChild("LocalEpisodeName", $xboxXmlFields['localEpisodeName']);
		$languageEpisodeNumber = $languagesLanguage->addChild("EpisodeNumber", $xboxXmlFields['episodeNumber']);
		$languageContainerPosition = $languagesLanguage->addChild("ContainerPosition", $xboxXmlFields['containerPosition']);
		$languageShortDesc = $languagesLanguage->addChild("ShortDescription", $xboxXmlFields['shortDescription']);
		$languageLongDesc = $languagesLanguage->addChild("LongDescription", $xboxXmlFields['longDescription']);
		$languageDisplayNetwork = $languagesLanguage->addChild("DisplayNetwork", $xboxXmlFields['displayNetwork']);
		//Attributes
		$rootRuntime->addAttribute("format", "hh:mm:ss"); //1st Level       
		$countriesCountry->addAttribute("code", $xboxXmlFields['countryOfOrigin']); //2nd Level
		$countryAirDate->addAttribute("format", "yyyy-mm-dd"); //3rd Level
		$languagesLanguage->addAttribute("code", $xboxXmlFields['code']); //4th Level
		
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
