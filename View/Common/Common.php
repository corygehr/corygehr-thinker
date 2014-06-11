<?php
	/**
	 * Common.php
	 * Contains the THINKER_View_Common class inherited by all Views
	 *
	 * @author Cory Gehr
	 */

class THINKER_View_Common extends THINKER_View
{
	protected $section = null; // Section being used

	/**
	 * __construct()
	 * Constructor for the THINKER_View_Common class
	 *
	 * @author Cory Gehr
	 * @access public
	 */
	public function __construct(THINKER_Section $section)
	{
		// Set the local section
		$this->section = $section;
	}
}
?>