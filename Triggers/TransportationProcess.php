<?php
/**  
 * @author 		David Curras
 * @version		June 6, 2012
 */
require_once '../siteConfig.php';
require_once '../Utils/Bootstrap.php';

Bootstrap::SetRequiredFiles();

AbstractModel::$IsUsingUtf8 = false;
$partners = PartnerModel::FetchAll();
echo '<pre>';
foreach($partners as $partner){
	echo '<h3><u>Transporting '.$partner->getName().'</u></h3>';
	$controller = new TransporterController($partner->getName());
}
die('</pre><h1>Transportation Done!!!</h1>');

//TODO: Error logger is not seeing when a file is not readable or miss permissions
//TODO: some bundle fields might have "" into the value and it produces an error in database
