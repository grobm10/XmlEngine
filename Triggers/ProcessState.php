<?php
/**  
 * @author David Curras
 * @version		June 6 2012
 */
require_once '../../siteConfig.php';

echo '<pre>';
if(file_exists(PROCESS_STATE_LOG_FILE)){
	$lines = file(PROCESS_STATE_LOG_FILE);
	$processState = '';
	foreach ($lines as $line){
		$processState .= $line;
	}
	if(!empty($processState)){
		echo $processState;
	} else {
		echo 'Not running';
	}
} else {
	echo 'Not running';
}
echo '</pre>';

die();