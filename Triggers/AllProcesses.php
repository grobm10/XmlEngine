<?php
/**  
 * @author 		David Curras
 * @version		June 6, 2012
 */
require_once '../siteConfig.php';
require_once '../Utils/Bootstrap.php';

Bootstrap::SetRequiredFiles();

$partners = PartnerModel::FetchAll();
$errorLogger = ErrorLogger::getInstance();
foreach($partners as $partner){
	echo '<h1>'.$partner->getPartnerName().'</h1>';
	$errorLogger->setPartner($partner->getPartnerName());
	echo '<h2><u>Merge</u></h2>';
	ProcessController::performMerge(Partner::FCS, $partner->getPartnerName(), Partner::FCS);
	echo '<h2><u>Conversion</u></h2>';
	ProcessController::performConversion(Partner::FCS, $partner->getPartnerName());
	echo '<h2><u>Transportation</u></h2>';
	ProcessController::performTransporter($partner->getPartnerName());
	echo '<hr /><hr /><hr />';
}

//TODO: Improve this feature
ProcessController::logProcessState('Process Stoped');

die();

//TODO: Error logger is not seeing when a file is not readable or miss permissions
//TODO: some bundle fields might have "" into the value and it produces an error in database
