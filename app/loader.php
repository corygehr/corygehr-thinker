<?php
	/**
	 * loader.php
	 * Loads the controller specified in the request
	 *
	 * @author Cory Gehr
	 */

// Include app-specific globals
require_once('globals.php');

// Load specified section
if(isset($_GET['s']))
{
	define('SECTION', Thinker\Http\Request::get('s', true));
}
else
{
	define('SECTION', $_CONFIG['thinker_general']['default_section']);
}

// Check if the section specified exists
if(class_exists(SECTION))
{
	// Declare sectionName in variable so it can be used in strings, as function calls, etc.
	$sectionName = SECTION;

	// Check for sub-section
	if(isset($_GET['su']))
	{
		$subsectionName = Thinker\Http\Request::get('su', true);
		define('SUBSECTION', $subsectionName);
	}
	else
	{
		// Load subsection from class
		try
		{
			$subsectionName = $sectionName::defaultSubsection();
			define('SUBSECTION', $subsectionName);
		}
		catch(Exception $ex)
		{
			trigger_error("Could not determine the subsection to load.", E_USER_ERROR);
		}
	}

	// Create instance of section
	$instance = new $sectionName;

	// Attempt to load subsection
	if(method_exists($sectionName, $subsectionName))
	{
		// Call method
		$result = $instance->$subsectionName();
	}
	else
	{
		// Error redirect
		Thinker\Http\Redirect::error(404);
	}

	// Compile info array
	$_INFO['environment'] = $_CONFIG['thinker_general']['environment'];
	$_INFO['section'] = $_SECTION;
	$_INFO['subsection'] = $_SUBSECTION;

	// Create a view
	$view = Thinker\Framework\View::factory($instance->view, $instance);

	if($view)
	{
		$view->display();
	}
	else
	{
		trigger_error("Failed to generate the View.", E_USER_ERROR);
	}
}
else
{
	// Error redirect
	Thinker\Http\Redirect::error(404);
}

// Close database connection
$_DB = null;
?>