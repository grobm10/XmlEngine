<?php
/**  
 * @author David Curras
 * @version		June 6 2012
 */

die('Comment this line to use the loadConversionTest.php file');
$directories = array(
		'../../assets/inbox-test/conversion/itunesdto' => '../../inbox/conversion/itunesdto',
		'../../assets/inbox-test/conversion/sonydto' => '../../inbox/conversion/sonydto',
		'../../assets/inbox-test/conversion/xboxdto' => '../../inbox/conversion/xboxdto',
		'../../assets/inbox-test/conversion/starhubdto' => '../../inbox/conversion/starhubdto'
	);

echo '<hr />' ;
echo '<hr />' ;
echo '<hr />' ;
echo '<h1>Loading Conversion files:</h1>' ;
foreach($directories as $source => $destination){
	echo '<hr /><h3>Processing: <i>' . $destination . '</i>.</h3>' ;
	copyFromAssets($source, $destination);
	echo '<h4>&#11088; &#11088; &#11088; Process finished successfully &#11088; &#11088; &#11088;</h4>' ;
}

echo '<h2>Done!!!</h2>';