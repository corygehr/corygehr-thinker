<?php
	/**
	 * View.php
	 * Contains the THINKER_View Class that all Views will inherit
	 * Uses the Factory Design Pattern to generate the view
	 * 
	 * @author Cory Gehr
	 */

class THINKER_View
{
	/**
	 * factory()
	 * Draws the presentation layer for a section
	 *
	 * @author Cory Gehr
	 * @access public
	 * @static
	 * @param $view: View we want to use
	 * @param $section: Section being displayed
	 * @return View of Section, or Error on Failure
	 */
	public static function factory($view, THINKER_Section $section)
	{
		// Generate the View's File Name
		$viewFile = "View/$view/$view.php";
		
		// Attempt to include the View
		if(include($viewFile))
		{
			// View Class Name
			$viewClass = 'THINKER_View_' . $view;
			
			// Create the new class if it exists
			if(class_exists($viewClass))
			{
				// Create the view with the model as its parameter
				$view = new $viewClass($section);
				// Ensure we have a valid view
				if($view instanceof THINKER_View_Common)
				{
					// Return the view
					return $view;
				}
			}
			else
			{
				// Throw an exception
				throw new Exception("View could not be loaded.");
			}
		}
		else
		{
			// Throw an exception
			throw new Exception("Specified View File does not exist.");
		}
		
	}
}
	 
?>