<?php
/**  
 * @author David Curras
 * @version		June 6 2012
 */

die('Comment this line to use the clearOutbox.php file');
$directories = array(
		'../../outbox/merge/fcs',
		'../../outbox/merge/itunesdto',
		'../../outbox/merge/sonydto',
		'../../outbox/merge/starhubdto',
		'../../outbox/merge/xboxdto',
		
		'../../outbox/conversion/itunesdto',
		'../../outbox/conversion/sonydto',
		'../../outbox/conversion/starhubdto',
		'../../outbox/conversion/xboxdto',
		
		'../../outbox/transportation/itunesdto',
		'../../outbox/transportation/sonydto',
		'../../outbox/transportation/starhubdto',
		'../../outbox/transportation/xboxdto'
	);

echo '<hr />' ;
echo '<hr />' ;
echo '<hr />' ;
echo '<h1>Clearing Outbox:</h1>' ;
foreach($directories as $dir){
	echo '<hr /><h3>Processing: <i>' . $dir . '</i>.</h3>' ;
	clearFoldersAndFiles($dir, $directories);
	echo '<h4>&#11088; &#11088; &#11088; Process finished successfully &#11088; &#11088; &#11088;</h4>' ;
}

echo '<h2>Done!!!</h2>';