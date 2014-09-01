<?php
	/**
	 * _TEMPLATE_.php
	 * Contains the Class for the _TEMPLATE_ Section
	 *
	 * @author Cory Gehr
	 */

class THINKER_Section__TEMPLATE_ extends THINKER_Section
{
	// All public functions will be accessible by users via the 'subsection' URL parameter
	// Therefore, functions should only be public if they'll be accessed by the user to
	// grab data (ex. URL/index.php?section=MySection&subsection=info)
	// Others that simply manipulate data should be private.

	/**
	 * info()
	 * Passes data back for the 'info' subsection
	 *
	 * @access public
	 */
	public function info()
	{
		// All of these subsection functions should return true
		return true;
	}
}
?>