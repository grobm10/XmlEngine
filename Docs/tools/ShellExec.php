<?php
/**
 * @author	David Curras
 * @version	Mar 6, 2012
 */

die('Comment this line to use the ShellExec.php file');

/**
 *	system() executes the command,
 *	shows the output automatically
 *	and saves the return status in $retval.
 *	Returns the status value
 *
 *	@param 	int	$retval
 *
 */
echo '<pre>';
$last_line = system('ls -lua ../../', $retval);
var_dump($retval);
var_dump($last_line);
echo '</pre>';


echo '<hr /><hr /><hr />';

/**
 *	exec() executes the command, 
 *	saves each output line as an array item
 *	and saves the return status in $retval.
 *	Returns the status value.
 *
 *	@param 	array	$lines
 *	@param 	int		$retval
 *	@return	string	last output line
 */
$lines = array();
$retval;
$last_line = exec('ls -lua ../../', $lines, $retval);
echo '<pre>';
var_dump($lines);
var_dump($retval);
var_dump($last_line);
echo '</pre>';
