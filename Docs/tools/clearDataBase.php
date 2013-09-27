<?php
/**  
 * @author David Curras
 * @version		June 6 2012
 */

die('Comment this line to use the clearDataBase.php file');
require_once '../../siteConfig.php';

echo '<hr />' ;
echo '<hr />' ;
echo '<hr />' ;
echo '<h1>Clearing Database:</h1>' ;

$connection = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
$database = mysql_select_db(MYSQL_DB);
$charset = mysql_set_charset('utf8');

$stmt = 'TRUNCATE TABLE `logs`';
$result = mysql_query($stmt);
$result = $result ? 'Success' : 'Fail';
echo 'Query: ' . $stmt . ' ... <b>' . $result . '</b><br />';
$stmt = 'TRUNCATE TABLE `bundle`';
$result = mysql_query($stmt);
$result = $result ? 'Success' : 'Fail';
echo 'Query: ' . $stmt . ' ... <b>' . $result . '</b><br />';
$stmt = 'TRUNCATE TABLE `videos`';
$result = mysql_query($stmt);
$result = $result ? 'Success' : 'Fail';
echo 'Query: ' . $stmt . ' ... <b>' . $result . '</b><br />';
$stmt = 'TRUNCATE TABLE `metadata`';
$result = mysql_query($stmt);
$result = $result ? 'Success' : 'Fail';
echo 'Query: ' . $stmt . ' ... <b>' . $result . '</b><br />';

mysql_close($connection);

echo '<h1>Done!!!</h1>';
