<?php
	/**
	 * Error.php
	 * Contains the Class for the Error Section
	 *
	 * @author Cory Gehr
	 */

class THINKER_Section_Error extends THINKER_Section
{
	/**
	 * info()
	 * Passes data back for the 'info' subsection
	 *
	 * @access public
	 */
	public function info()
	{
		// Error number
		$no = getPageVar('no', 'int', 'GET');

		$description = 'An unspecified error has occurred.';
		$message = 'Please contact the server administrator.';

		switch($no)
		{
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