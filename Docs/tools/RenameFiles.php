<?php
/**
 * @author	David Curras
 * @version	Mar 6, 2012
 */
die('Comment this line to use the RenameFiles.php file');

$sourceFolder = dirname(__FILE__) . '/toRename';
if ($dh = opendir($sourceFolder)){
	while (($file = readdir($dh)) !== false){
		if(($file !='.') && ($file != '..') && (substr($file, -4) != '.svn')){
			$originalFile = $sourceFolder . '/' . $file;
			$newFile = $sourceFolder . '/' . fileRename($file);
			if($originalFile != $newFile){
				if(copy($originalFile, $newFile)){
					echo '<b>File added:</b> ' . $newFile . '<br />';
				} else {
					die('File not copied');
				}
				if(unlink($originalFile)){
					echo '<b>File deleted:</b> ' . $originalFile . '<hr />';
				} else {
					die('File not deleted');
				}
			} else {
				die('fileRename function failed');
			}
		}
	}
	closedir($dh);
}

/** 
 * Algorithm to rename files and folders
 *
 * @param	string		$fileOrigianlName
 * @return	string
 */
function fileRename($fileOrigianlName) {
	$newName = 'test_' . $fileOrigianlName;
	return $newName;
}

die();