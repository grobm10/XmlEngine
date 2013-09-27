<?php
/**  
 * @author David Curras
 * @version		June 6 2012
 */

die('Comment this line to use the clearInbox.php file');
$directories = array(
		'../../inbox/merge/fcs',
		'../../inbox/merge/itunesdto',
		'../../inbox/merge/sonydto',
		'../../inbox/merge/starhubdto',
		'../../inbox/merge/xboxdto',
		
		'../../inbox/conversion/itunesdto',
		'../../inbox/conversion/sonydto',
		'../../inbox/conversion/starhubdto',
		'../../inbox/conversion/xboxdto',
		
		'../../inbox/transportation/itunesdto',
		'../../inbox/transportation/sonydto',
		'../../inbox/transportation/starhubdto',
		'../../inbox/transportation/xboxdto'
	);

echo '<hr />' ;
echo '<hr />' ;
echo '<hr />' ;
echo '<h1>Clearing Inbox:</h1>' ;
foreach($directories as $dir){
	echo '<hr /><h3>Processing: <i>' . $dir . '</i>.</h3>' ;
	clearFoldersAndFiles($dir, $directories);
	echo '<h4>&#11088; &#11088; &#11088; Process finished successfully &#11088; &#11088; &#11088;</h4>' ;
}

echo '<h2>Done!!!</h2>';