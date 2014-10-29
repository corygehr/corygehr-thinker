<?php
	/**
	 * Open.php
	 * Contains the 'Open' session class
	 * No Authentication Required / Open Site
	 *
	 * @author Cory Gehr
	 */

class Open extends Thinker\Framework\Session
{
	/**
	 * __construct()
	 * Constructor for the Session\Open class
	 *
	 * @access protected
	 */
	protected function __construct()
	{
		// Call parent constructor
		parent::__construct();
	}

	/**
	 * auth()
	 * Checks current user's access to an object
	 *
	 * @author Cory Gehr
	 * @param string $objType Object Type (default: section)
	 * @param array $params Object Parameters (default: empty array)
	 * @return boolean True if Authorized, False if Denied
	 */
	public function auth($objType = 'section', $params = array())
	{
		return true;
	}
}