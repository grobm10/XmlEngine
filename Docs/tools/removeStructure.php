<?php
/**  
 * @author David Curras
 * @version		June 6 2012
 */

die('Comment this line to use the removeStructure.php file');
require_once '../../siteConfig.php';

$directories = array(
		'../../inbox',
		'../../outbox',
		'../../logs'
	);

echo '<hr />' ;
echo '<hr />' ;
echo '<hr />' ;
echo '<h1>Removing Structure:</h1>' ;
foreach($directories as $dir){
	echo '<hr /><h3>Processing: <i>' . $dir . '</i>.</h3>' ;
	clearFoldersAndFiles($dir);
	echo '<h4>&#11088; &#11088; &#11088; Process finished successfully &#11088; &#11088; &#11088;</h4>' ;
}

echo '<h2>Done!!!</h2>';

/** 
 * Clear the real inbox and outbox folders recursively
 *
 * @param	string		$folder
 */
function clearFoldersAndFiles($folder) {
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
			if(rmdir($folder)){
				echo '<b>Folder removed:</b> ' . $folder . ' <br />';
			}
		}
	}
}
