<?php
/**  
 * @author David Curras
 * @version		June 6 2012
 */

die('Comment this line to use the loadTransportationTest.php file');
$directories = array(
		'../../assets/inbox-test/transportation/itunesdto' => '../../inbox/transportation/itunesdto',
		'../../assets/inbox-test/transportation/sonydto' => '../../inbox/transportation/sonydto',
		'../../assets/inbox-test/transportation/xboxdto' => '../../inbox/transportation/xboxdto',
		'../../assets/inbox-test/transportation/starhubdto' => '../../inbox/transportation/starhubdto',
		
		'../../assets/outbox-test/transportation/itunesdto' => '../../outbox/transportation/itunesdto',
		'../../assets/outbox-test/transportation/sonydto' => '../../outbox/transportation/sonydto',
		'../../assets/outbox-test/transportation/xboxdto' => '../../outbox/transportation/xboxdto',
		'../../assets/outbox-test/transportation/starhubdto' => '../../outbox/transportation/starhubdto'
	);

echo '<hr />' ;
echo '<hr />' ;
echo '<hr />' ;
echo '<h1>Loading Transportation files:</h1>' ;
foreach($directories as $source => $destination){
	echo '<hr /><h3>Processing: <i>' . $destination . '</i>.</h3>' ;
	copyFromAssets($source, $destination);
	echo '<h4>&#11088; &#11088; &#11088; Process finished successfully &#11088; &#11088; &#11088;</h4>' ;
}

echo '<h2>Done!!!</h2>';
