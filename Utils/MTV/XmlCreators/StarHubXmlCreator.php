<?php

/**
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/MTV/XmlCreators/StarHubXmlCreator.php
 */
class StarHubXmlCreator extends AbstractXmlCreator {

	/**
	 * Creates the StarHub Short Form XML
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
		$parser = new StarHubXmlParser();
		$starHubXmlFields = $parser->getPartnerXmlFields($bundle);
		$xmlRoot = new SimpleXMLElement("<Product></Product>");
		//Root level childs
		$rootType = $xmlRoot->addChild("Type", "TV-EPISODE");
		$rootSeasonBundleID = $xmlRoot->addChild("SeasonBundleID", $starHubXmlFields['seasonBundleID']);
		$rootProvider = $xmlRoot->addChild("Provider", "Viacom");
		$rootGlobalSeriesName = $xmlRoot->addChild("GlobalSeriesName", $starHubXmlFields['globalSeriesName']);
		$rootGlobalSeasonName = $xmlRoot->addChild("GlobalSeasonName", $starHubXmlFields['globalSeasonName']);
		$rootGlobalEpisodeName = $xmlRoot->addChild("GlobalEpisodeName", $starHubXmlFields['globalEpisodeName']);
		$rootCountryOfOrigin = $xmlRoot->addChild("CountryOfOrigin", $starHubXmlFields['countryOfOrigin']);
		$rootProductId = $xmlRoot->addChild("ProductId", $starHubXmlFields['productId']);
		$rootCopyRightNotice = $xmlRoot->addChild("CopyRightNotice",$starHubXmlFields['copyRightNotice']);
		$rootCountries = $xmlRoot->addChild("Countries");
		$rootGenres = $xmlRoot->addChild("Genres");
		$rootRuntime = $xmlRoot->addChild("Runtime", $starHubXmlFields['runtime']);
		//2nd level childs
		$countriesCountry = $rootCountries->addChild("Country");
		$genresGenre = $rootGenres->addChild("Genre", $starHubXmlFields['genre']);
		//3rd level childs
		$countryLanguages = $countriesCountry->addChild("Languages");
		$countryAirDate = $countriesCountry->addChild("InitialAirDate", $starHubXmlFields['initialAirDate']);
		$countryContentRatings = $countriesCountry->addChild("ContentRatings");
		$countryOffers = $countriesCountry->addChild("Offers");
		$countryCastMembers = $countriesCountry->addChild("CastMembers");
		$countryCrewMembers = $countriesCountry->addChild("CrewMembers");
		//4th level childs
		$languagesLanguage = $countryLanguages->addChild("Language"); 
		//5th level childs
		$languageLocalSeriesName = $languagesLanguage->addChild("LocalSeriesName", $starHubXmlFields['localSeriesName']);
		$languageLocalSeriesDesc = $languagesLanguage->addChild("LocalSeriesDescription", $starHubXmlFields['localSeriesDescription']);
		$languageLocalSeasonName = $languagesLanguage->addChild("LocalSeasonName", $starHubXmlFields['localSeasonName']);
		$languageLocalSeasonDesc = $languagesLanguage->addChild("LocalSeasonDescription", $starHubXmlFields['localSeasonDescription']);
		$languageLocalEpisodeName = $languagesLanguage->addChild("LocalEpisodeName", $starHubXmlFields['localEpisodeName']);
		$languageEpisodeNumber = $languagesLanguage->addChild("EpisodeNumber", $starHubXmlFields['episodeNumber']);
		$languageContainerPosition = $languagesLanguage->addChild("ContainerPosition", $starHubXmlFields['containerPosition']);
		$languageShortDesc = $languagesLanguage->addChild("ShortDescription", $starHubXmlFields['shortDescription']);
		$languageLongDesc = $languagesLanguage->addChild("LongDescription", $starHubXmlFields['longDescription']);
		$languageDisplayNetwork = $languagesLanguage->addChild("DisplayNetwork", $starHubXmlFields['displayNetwork']);
		//Attributes
		$rootRuntime->addAttribute("format", "hh:mm:ss"); //1st Level       
		$countriesCountry->addAttribute("code", $starHubXmlFields['countryOfOrigin']); //2nd Level
		$countryAirDate->addAttribute("format", "yyyy-mm-dd"); //3rd Level
		$languagesLanguage->addAttribute("code", $starHubXmlFields['code']); //4th Level
		
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
