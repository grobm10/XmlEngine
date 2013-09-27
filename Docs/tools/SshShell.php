<?php
/**  
 * @author 		David Curras
 * @version		June 6, 2012
 */
 
die('Comment this line to use the SshShell.php file');
require_once '../../siteConfig.php';
require_once '../../Utils/Bootstrap.php';
Bootstrap::SetRequiredFiles();

echo '<pre>';

$ssh = new Ssh2(REMOTE_SERVER_IP);
if ($ssh->auth(REMOTE_SERVER_USER, REMOTE_SERVER_PASS)) {
	echo '1<br />';
	$ssh->openShell('xterm');
	echo '2<br />';
	$command = 'ascp -QT -k2 -d -l 45M -L';
	$command .= '/Volumes/VoigtKampff/DTO/XmlEngine_Assets/inbox/transportation/xboxdto/logs/ ';
	$command .= '/Volumes/VoigtKampff/DTO/XmlEngine_Assets/inbox/transportation/xboxdto/FR_GAMEONEFRANCE_NARUTOSHIPPUDEN_101.xml ';
	$command .= 'MTVNEurope@4.71.156.36:FR_GAMEONEFRANCE_NARUTOSHIPPUDEN_1';
	echo '3 '.$command.'<br />';
	$ssh->writeShellLine($command);
	sleep(4);
	echo '4 ';var_dump($ssh->shellStream);echo '<br />';
	$output = '';
	$i = 0;
	while ($buf = fgets($ssh->shellStream,4096)) {
		echo '5-'.$i.' '.$buf.'<br />';
		flush();
		$output .= $buf . "\n";
		if (strpos($buf, ' password:') !== false){
			$ssh->writeShellLine('!JgKpNn%');
			sleep(4);
			$i += 1;
		}
		if($i < 3){
			break;
		}
	}
	echo '6 <br />';
	fclose($ssh->shellStream);
	echo '7 <br />';
	$ssh->disconnect();
	echo '8 <br />';
	var_dump($output);
	die('OK');
}
die('FAIL');
