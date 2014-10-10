<?php
	/**
	 * Session.php 
	 * Contains the THINKER_Session class
	 *
	 * @author Cory Gehr
	 */
	 
class THINKER_Session
{
	private static $instance; // Instance variable
	public $sessionID;	      // Session ID

	/**
	 * __construct()
	 * Constructor for the THINKER_Session Class
	 *
	 * @author Cory Gehr
	 * @access protected
	 */
	protected function __construct()
	{
		global $_INFO;

		// Start session
		session_start();

		// Get and store the Session ID
		$this->sessionID = session_id();

		// Create a CSRF token
		$_SESSION['CSRF_TOKEN'] = base64_encode(openssl_random_pseudo_bytes(32));
	}
	
	/**
	 * __clone()
	 * Disables PHP5's cloning method for sessions
	 * Removes ability to make copies of a session
	 *
	 * @author Joe Stump <joe@joestump.net>
	 * @access public
	 */
	public function __clone()
	{
		trigger_error('Clone is not allowed for ' . __CLASS__, E_USER_ERROR);
	}
	
	/**
	 * __destruct()
	 * Destructor for the THINK_Session class
	 *
	 * @access public
	 */
	public function __destruct()
	{
		// Write a session closure to the PHP log
		session_write_close();
	}

	/**
	 * __get()
	 * Returns a requested Session Variable
	 *
	 * @author Cory Gehr
	 * @access public
	 * @param $var: Index in $_SESSION (can be a Key ex: email)
	 * @return Session Details
	 */
	public function __get($var)
	{
		return $_SESSION[$var];
	}
	
	/**
	 * __set()
	 * Sets a session variable
	 *
	 * @access public
	 * @param $var: Session Variable Name
	 * @param $val: Value to set Variable to
	 * @return True if Successful, False if Failure
	 */
	public function __set($var, $val)
	{
		return ($_SESSION[$var] = $val);
	}
	
	/**
	 * auth()
	 * Checks user access to an object
	 *
	 * @author Cory Gehr
	 * @access public
	 * @param $objType: Object Type (default: section)
	 * @param $params: Object parameters (default: Empty Array)
	 * @return True if Granted, False if Denied
	 */
	public function auth($objType = 'section', $params = array())
	{
		return true;
	}

	/**
	 * destroy()
	 * Destroys a session
	 *
	 * @author Cory Gehr
	 * @access public
	 */
	public function destroy()
	{
		// Clear all session variables
		foreach($_SESSION as $var => $val)
		{
			$_SESSION[$var] = null;
		}
		
		// Destroy the session
		session_destroy();
	}

	/**
	 * singleton()
	 * Returns a single instance of the session class
	 *
	 * @author Joe Stump <joe@joestump.net>
	 * @access public
	 * @return mixed Instance of Session
	 */
	public static function singleton()
	{
		if(!isset(self::$instance))
		{
			$className = SESSION_CLASS;
			self::$instance = new $className;
		}
		
		return self::$instance;
	}

	/**
	 * varExists()
	 * Checks for the existence of a Session Variable
	 *
	 * @access public
	 * @param $var: Session Variable Name
	 * @return True if Exists, False if Nonexistent
	 */
	public function varExists($var)
	{
		return isset($_SESSION[$var]);
	}

	/**
	 * verifyCsrfToken()
	 * Verifies that a csrfToken input matches that for the session
	 *
	 * @access public
	 * @param $inputVarName: Name of the CSRF Token Parameter (default: csrfToken)
	 * @return True if Valid Token, False if Invalid
	 */
	public function verifyCsrfToken($inputVarName = 'csrfToken')
	{
		return (getPageVar($inputVarName, 'str', 'REQUEST', true, false) == $_SESSION['CSRF_TOKEN']);
	}
}