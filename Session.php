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
	 * @access private
	 */
	private function __construct()
	{
		// Start session
		session_start();

		// Get and store the Session ID
		$this->sessionID = session_id();
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
			$className = __CLASS__;
			self::$instance = new $className;
		}
		
		return self::$instance;
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
}