<?php
/**
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/Server/Security.php
*/

class Security
{
	/**
	 * Authenticates the user
	 *
	 * @param		User		$user
	 * @return		boolean  
	 */
	public static function Authenticate($user=null){
		$mySession = Session::getInstance();
		if (is_object($user)){
			$mySession->userName = $userName;
			$mySession->lastAccess = Shell::GetSystemDate();
			$mySession->isLogged = true;
			return true;
		} else{
			if ($mySession->isLogged){
				$mySession->lastAccess = Shell::GetSystemDate();
				return true;
			} 
		}
		return false;
	}
	
	/**
	 *  Closes the session of the user
	 */
	public static function unAuthenticate(){
		$mySession = Session::getInstance();
		$mySession->destroy();
		header('Location: ../Views/login.php?auth=0');
	}
}