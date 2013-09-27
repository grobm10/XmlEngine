<?php
/**  
 * @author David Curras
 * @version		June 6 2012
 */
 
die('Comment this line to use the clearAll.php file');
/** 
 * Clear the real inbox and outbox folders recursively
 *
 * @param	string		$folder
 * @param	array		$directories
 */
function clearFoldersAndFiles($folder, $directories) {
	if (is_dir($folder)){
		if ($dh = opendir($folder)){
			while (($file = readdir($dh)) !== false){
				if(($file !='.') && ($file != '..')){
					$content = $folder . '/' . $file;
					if (is_dir($content)){
						clearFoldersAndFiles($content);
					} else {
						if(unlink($content)){
							echo '<b>File deleted:</b> ' . $content . ' <br />';
						}
					}
				}
			}
			closedir($dh);
			if(!in_array($folder, $directories)){
				if(rmdir($folder)){
					echo '<b>Folder removed:</b> ' . $folder . ' <br />';
				}
			}
		}
	}
}
 
require "clearDataBase.php";
require "clearInbox.php";
require "clearOutbox.php";
require "clearLogs.php";