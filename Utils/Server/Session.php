<?php
/**
 * @author			David Curras
 * @version			June 6, 2012
 * @filesource		/Utils/Server/Session.php
 */

class Session
{
	const SESSION_STARTED = TRUE;
	const SESSION_NOT_STARTED = FALSE;

	/**
	 *	The state of the session
	 */
	private $sessionState = self::SESSION_NOT_STARTED;
	
	/**
	 *	The only instance of the class
	 */
	private static $instance;

	/**
	 * This class is a Singleton, 
	 * so must be intanciated with the static method getInstance()
	 */
	private function __construct() {}

	/**
	 *	Stores data in the session.
	 *
	 *	@example	$mySession->foo = 'bar'
	 *	@param		name	Name of the data property.
	 *	@param		value	The value for the data property.
	 *	@return		void
	 **/
	public function __set( $name , $value )
	{
		$_SESSION[$name] = $value;
	}

	/**
	 *	Gets datas from the session. 
	 *
	 *	@example	$mySession->foo
	 *	@param		name	Name of the data property to get.
	 *	@return		mixed	Data property stored in session.
	 **/
	public function __get( $name )
	{
		if ( isset($_SESSION[$name])){
			return $_SESSION[$name];
		}
	}
	
	/**
	 *	Asks if a property is setted or not 
	 *
	 *	@example	isset( $mySession->nickname )
	 *	@param		name	Name of the data property.
	 *	@return		bool	TRUE if the property is setted, else FALSE.
	 **/
	public function __isset( $name )
	{
		return isset($_SESSION[$name]);
	}
	
	/**
	 *	Destroys a specific data property 
	 *
	 *	@example	unset( $mySession->nickname )
	 *	@param		name	Name of the data property.
	 *	@return		void
	 **/
	public function __unset( $name )
	{
		unset( $_SESSION[$name] );
	}
	
	/**
	 *	The session is automatically initialized if it wasn't.
	 *
	 *	@example	$mySession = Session::getInstance();
	 *	@return		object	The instance of 'Session'
	 **/
	public static function getInstance()
	{
		if ( !isset(self::$instance)){
			self::$instance = new self;
		}
		self::$instance->startSession();
		return self::$instance;
	}

	/**
	 *	(Re)starts the session.
	 *
	 *	@example	$this->startSession()
	 *	@return		bool	TRUE if the session has been initialized, else FALSE.
	 **/
	private function startSession()
	{
		if ( $this->sessionState == self::SESSION_NOT_STARTED ){
			$this->sessionState = session_start();
		}
		return $this->sessionState;
	}

	/**
	 *	Destroys the current session.
	 *
	 *	@example	$mySession->destroy()
	 *	@return		bool	TRUE if session has been deleted, else FALSE.
	 **/
	public function destroy()
	{
		if ( $this->sessionState == self::SESSION_STARTED ){
			$this->sessionState = !session_destroy();
			unset( $_SESSION );
			return !$this->sessionState;
		}
		return false;
	}
}