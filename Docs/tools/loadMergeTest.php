<?php
/**  
 * @author David Curras
 * @version		June 6 2012
 */

die('Comment this line to use the loadMerge.php file');
$directories = array(
		'../../assets/inbox-test/merge/fcs' => '../../inbox/merge/fcs',
		'../../assets/inbox-test/merge/itunesdto' => '../../inbox/merge/itunesdto',
		'../../assets/inbox-test/merge/sonydto' => '../../inbox/merge/sonydto',
		'../../assets/inbox-test/merge/xboxdto' => '../../inbox/merge/xboxdto',
		'../../assets/inbox-test/merge/starhubdto' => '../../inbox/merge/starhubdto',
		
		'../../assets/outbox-test/merge/fcs' => '../../outbox/merge/fcs',
		'../../assets/outbox-test/merge/itunesdto' => '../../outbox/merge/itunesdto',
		'../../assets/outbox-test/merge/sonydto' => '../../outbox/merge/sonydto',
		'../../assets/outbox-test/merge/xboxdto' => '../../outbox/merge/xboxdto',
		'../../assets/outbox-test/merge/starhubdto' => '../../outbox/merge/starhubdto'
	);

echo '<hr />' ;
echo '<hr />' ;
echo '<hr />' ;
echo '<h1>Loading Merge files:</h1>' ;
foreach($directories as $source => $destination){
	echo '<hr /><h3>Processing: <i>' . $destination . '</i>.</h3>' ;
	copyFromAssets($source, $destination);
	echo '<h4>&#11088; &#11088; &#11088; Process finished successfully &#11088; &#11088; &#11088;</h4>' ;
}

echo '<h2>Done!!!</h2>';