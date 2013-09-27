<?php
/**
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/Server/Debug.php
 */

class Debug {
	
	/**
	 * Shows the content of $var with var_dump
	 *
	 * @param		mixed			$var
	 * @param		bool			$mustDie
	 */
	public static function Show($var, $mustDie=false){
		echo '<hr /><pre>';var_dump($var);echo '</pre><hr />';
		if($mustDie){
			die();
		}
	}
	
	/**
	 * Shows the content of the variables with var_dump
	 *
	 * @param		array|mixed		$vars
	 * @param		bool			$mustDie
	 */
	public static function ShowAll($vars, $mustDie=false){
		echo '<hr /><pre>';
		if(is_array($vars)){
			foreach($vars as $var){
				var_dump($var);
				echo '<hr />';
			}
		} else {
			var_dump($vars);
		}
		echo '</pre><hr />';
		if($mustDie){
			die();
		}
	}
}