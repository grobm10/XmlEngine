<?php
/**  
 * @author 		David Curras
 * @version		June 6, 2012
 */
require_once '../siteConfig.php';
require_once '../Utils/Bootstrap.php';

Bootstrap::SetRequiredFiles();
AbstractModel::$IsUsingUtf8 = false;

if($_POST){
	$allowedMimes = array('text/plain');	
	$allowedExts = array('txt');
	$extension = end(explode('.', $_FILES['file']['name']));
	if (in_array($_FILES['file']['type'], $allowedMimes) && ($_FILES['file']['size'] < 200000) && in_array($extension, $allowedExts)){
		if ($_FILES['file']['error'] > 0){
			echo 'Partner: ' . $_POST['partner'] . '<br />';
			echo 'Error Code: ' . $_FILES['file']['error'] . '<br />';
		} else {
			echo 'Partner: ' . $_POST['partner'] . '<br />';
			echo 'Upload: ' . $_FILES['file']['name'] . '<br />';
			echo 'Type: ' . $_FILES['file']['type'] . '<br />';
			echo 'Size: ' . $_FILES['file']['size'] . ' bytes<br />';
			echo 'Temp file: ' . $_FILES['file']['tmp_name'] . '<br />';
			if (file_exists(ROOT_FOLDER.'inbox/importation/'.$_POST['partner'].'dto/' . $_FILES['file']['name'])) {
				echo $_FILES['file']['name'] . ' overwrited. <br />';
			}
			move_uploaded_file($_FILES['file']['tmp_name'], ROOT_FOLDER.'inbox/importation/'.$_POST['partner'].'dto/'.$_FILES['file']['name']);
			echo 'Stored in: ' .ROOT_FOLDER.'inbox/importation/'.$_POST['partner'].'dto/' . $_FILES['file']['name'];
		}
	} else {
		echo 'Invalid file';
	}
}
$partners = PartnerModel::FetchAll();
echo '<pre>';
foreach($partners as $partner){
	echo '<h3><u>Importing '.$partner->getName().'</u></h3>';
	$controller = new ImportationController($partner->getName());
}
die('</pre><h1>Transportation Done!!!</h1>');
