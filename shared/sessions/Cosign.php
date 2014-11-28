<?php
	/**
	 * Cosign.php
	 * Contains the 'Cosign' session class
	 * Penn State WebAccess/Cosign Single-sign on
	 *
	 * @author Cory Gehr
	 */

class Cosign extends Thinker\Framework\Session
{
	private $validAuthTypes = array('Cosign');

	/**
	 * __construct()
	 * Constructor for the Session\Cosign class
	 *
	 * @access protected
	 */
	protected function __construct()
	{
		// Call parent constructor
		parent::__construct();

		// Cosign passes usernames through $_SERVER['REMOTE_USER'], so see if that's been set
		// Also ensure 
		if($this->getCosignUsername() && $this->verifyAuthType())
		{
			$this->__set('USERNAME', $this->getCosignUsername());
		}
		else
		{
			// No username -- at this point you can decide what you want to do
			// Default is to send user to 403
			\Thinker\Http\Redirect::error(403);
		}
	}

	/**
	 * auth()
	 * Checks current user's access to an object
	 *
	 * @author Cory Gehr
	 * @access public
	 * @param string $objType Object Type (default: section)
	 * @param array $params Object Parameters (default: empty array)
	 * @return boolean True if Authorized, False if Denied
	 */
	public function auth($objType = 'section', $params = array())
	{
		/*
		 * TODO: Add your own authentication schema here
		 * If you want public access to all pages, use the 'Open' Session instead
		 * !For now, all pages are open until you implement your own ACL!
		 * I recommend doing that through another class or library of your own
		 */
		return true;
	}

	/**
	 * getCosignUsername()
	 * Returns the username passed from the authentication server
	 *
	 * @author Cory Gehr
	 * @access protected
	 * @return string Username on Success, or NULL if no user provided
	 */
	protected function getCosignUsername()
	{
		return $_SERVER['REMOTE_USER'];
	}

	/**
	 * verifyAuthType()
	 * Ensures the proper AUTH_TYPE was used to pass the username
	 * (Always 'Cosign' for WebAccess)
	 *
	 * @author Cory Gehr
	 * @return boolean True if Valid, False if Invalid
	 */
	private function verifyAuthType()
	{
		return (in_array($_SERVER['AUTH_TYPE'], $this->validAuthTypes));
	}
}