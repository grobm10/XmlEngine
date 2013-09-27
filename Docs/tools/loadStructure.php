<?php
/**  
 * @author David Curras
 * @version		June 6 2012
 */

die('Comment this line to use the loadStructure.php file');
$directories = array(
		'../../inbox',
		'../../inbox/merge',
		'../../inbox/conversion',
		'../../inbox/transportation',
		
		'../../inbox/merge/fcs',
		'../../inbox/merge/itunesdto',
		'../../inbox/merge/sonydto',
		'../../inbox/merge/xboxdto',
		'../../inbox/merge/starhubdto',
		
		'../../inbox/conversion/itunesdto',
		'../../inbox/conversion/sonydto',
		'../../inbox/conversion/starhubdto',
		'../../inbox/conversion/xboxdto',
		
		'../../inbox/transportation/itunesdto',
		'../../inbox/transportation/sonydto',
		'../../inbox/transportation/starhubdto',
		'../../inbox/transportation/xboxdto',
		
		'../../outbox',
		'../../outbox/merge',
		'../../outbox/transportation',
		
		'../../outbox/merge/fcs',
		'../../outbox/merge/itunesdto',
		'../../outbox/merge/sonydto',
		'../../outbox/merge/xboxdto',
		'../../outbox/merge/starhubdto',
		
		'../../outbox/transportation/itunesdto',
		'../../outbox/transportation/sonydto',
		'../../outbox/transportation/starhubdto',
		'../../outbox/transportation/xboxdto',
		
		'../../logs'
	);

echo '<hr />' ;
echo '<hr />' ;
echo '<hr />' ;
echo '<h1>Creating Structure:</h1>' ;
echo '<hr />' ;
foreach($directories as $dir){
	if (!is_dir($dir)){
		if(mkdir($dir)){
			echo '<b>Folder created:</b> ' . $dir;
			if(chmod($dir, 0775)){
				echo ' - <b>Premissions 0775 added</b>.';
			}
			echo '<br />';
		}
	}
}
echo '<h4>&#11088; &#11088; &#11088; Process finished successfully &#11088; &#11088; &#11088;</h4>' ;
echo '<h2>Done!!!</h2>';