<?php
	/**
	 * Error.php
	 * Contains the Class for the Error Controller
	 *
	 * @author Cory Gehr
	 */

class Error extends \Thinker\Framework\Controller
{
	// Allow all users to access this section
	protected $allowOpenAccess = true;

	/**
	 * defaultSubsection()
	 * Returns the default subsection for this Controller
	 *
	 * @access public
	 * @static
	 * @return string Subsection Name
	 */
	public static function defaultSubsection()
	{
		return 'info';
	}

	/**
	 * info()
	 * Passes data back for the 'info' subsection
	 *
	 * @access public
	 */
	public function info()
	{
		// Error number
		$no = \Thinker\Http\Request::get('no', true);

		$description = 'An unspecified error has occurred.';
		$message = 'Please contact the server administrator.';

		switch($no)
		{
			case 403:
				$description = 'Unauthorized';
				$message = 'You are not authorized to view this content. If you feel you have reached this message in error, please contact your administrator.';
			break;

			case 404:
				$description = 'The page specified could not be found.';
				$message = 'Please check the URL you attempted to reach and try again.';
			break;
		}

		$this->set('description', $description);
		$this->set('message', $message);
		$this->set('number', $no);

		return true;
	}
}
?>