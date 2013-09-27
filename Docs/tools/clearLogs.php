<?php
/**  
 * @author David Curras
 * @version		June 6 2012
 */

die('Comment this line to use the clearLog.php file');
$directories = array(
		'../../logs'
	);

echo '<hr />' ;
echo '<hr />' ;
echo '<hr />' ;
echo '<h1>Clearing Logs:</h1>' ;
foreach($directories as $dir){
	echo '<hr /><h3>Processing: <i>' . $dir . '</i>.</h3>' ;
	clearFoldersAndFiles($dir, $directories);
	echo '<h4>&#11088; &#11088; &#11088; Process finished successfully &#11088; &#11088; &#11088;</h4>' ;
}

echo '<h2>Done!!!</h2>';