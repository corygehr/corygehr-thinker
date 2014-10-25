<?php
	/**
	 * loader.php
	 * Loads the controller specified in the request
	 *
	 * @author Cory Gehr
	 */

// Load specified section
if(isset($_GET['s']))
{
	define('SECTION', getPageVar('s', 'str', 'GET', true));
}
else
{
	define('SECTION', $_CONFIG['thinker_general']['default_section']);
}

// Check if the section specified exists
if(class_exists(SECTION))
{
	// Check for sub-section
	if(isset($_GET['su']))
	{
		define('SUBSECTION', getPageVar('su', 'str', 'GET', true));
	}
	else
	{
		// Load subsection from class
		try
		{
			$sectionName = SECTION;
			$_SUBSECTION = $sectionName::defaultSubsection();
		}
		catch(Exception $ex)
		{
			trigger_error("Could not determine the subsection to load.", E_USER_ERROR);
		}
	}

	// Create instance of section
	$instance = new $_SECTION_CLASS();

	// Attempt to load subsection
	if(method_exists($_SECTION_CLASS, $_SUBSECTION))
	{
		// Call method
		$result = $instance->$_SUBSECTION();
	}
	else
	{
		// Error redirect
		errorRedirect(404);
	}

	// Compile info array
	$_INFO['environment'] = $_CONFIG['thinker_general']['environment'];
	$_INFO['section'] = $_SECTION;
	$_INFO['subsection'] = $_SUBSECTION;

	if($result)
	{
		// Create a view
		$view = View::factory($instance->view, $instance);

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
		trigger_error("Subsection did not load successfully.", E_USER_ERROR);
	}
}
else
{
	// Error redirect
	Thinker\Redirect::error(404);
}

// Close database connection
$_DB = null;
?>