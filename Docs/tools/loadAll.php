<?php
/**  
 * @author David Curras
 * @version		June 6 2012
 */

die('Comment this line to use the loadAll.php file');

/** 
 * Clear the inbox and outbox folders from assets examples recursively
 *
 * @param	string		$sourceFolder
 * @param	string		$destinationFolder
 */
function copyFromAssets($sourceFolder, $destinationFolder) {
	if (!is_dir($destinationFolder)){
		if(mkdir($destinationFolder)){
			echo '<b>Folder created:</b> ' . $destinationFolder;
			if(chmod($destinationFolder, 0775)){
				echo ' - <b>Premissions 0775 added</b>.';
			}
			echo '<br />';
		}
	}
	if ($dh = opendir($sourceFolder)){
		while (($file = readdir($dh)) !== false){
			if(($file !='.') && ($file != '..') && (substr($file, -4) != '.svn')){
				$source = $sourceFolder . '/' . $file;
				$destination = $destinationFolder . '/' . $file;
				if (is_dir($source)){
					copyFromAssets($source, $destination) ;
				} else {
					if(copy($source, $destination)){
						echo '<b>File added:</b> ' . $destination;
						if(chmod($destination, 0775)){
							echo ' - <b>Premissions 0775 added</b>.';
						}
						echo '<br />';
					}
				}
			}
		}
		closedir($dh);
	}
}
 
require "loadMergeTest.php";
require "loadConversionTest.php";
require "loadTransportationTest.php";