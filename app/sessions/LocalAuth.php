<?php
	/**
	 * LocalAuth.php
	 * Contains a sample Local Authentication Session Class for THINKer
	 *
	 * @author Cory Gehr
	 */

class LocalAuth extends Thinker\Framework\Session
{
	/**
	 * __construct()
	 * Constructor for the THINKER_Session_LocalAuth class
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
	 * @param $objType: Object Type (default: section)
	 * @param $params: Object Parameters (default: empty array)
	 * @return True if Authorized, False if Denied
	 */
	public function auth($objType = 'section', $params = array())
	{
		switch($objType)
		{
			case 'pageSection':
				return false;
			break;

			case 'section':
				return true;
			break;

			default:
				return false;
			break;
		}

		return true;
	}
}