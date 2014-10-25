<?php
	/**
	 * Common.php
	 * Contains the View\Common class inherited by all Views
	 *
	 * @author Cory Gehr
	 */

class Common extends View
{
	protected $section = null; // Section being used

	/**
	 * __construct()
	 * Constructor for the THINKER_View_Common class
	 *
	 * @author Cory Gehr
	 * @access public
	 */
	public function __construct(Section $section)
	{
		// Set the local section
		$this->section = $section;
	}
}
?>