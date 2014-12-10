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
	define('SECTION', \Thinker\Http\Request::get('s', true));
}
else
{
	define('SECTION', $_APP_CONFIG['general']['default_section']);
}

// Create the full local class name
$localClass = "\\".APP_NAMESPACE."\\".SECTION;

// Determine where the specified class comes from (local app or shared)
$fullClass = null;

// First see if the local class exists
if(class_exists($localClass))
{
	// Set class
	$fullClass = $localClass;
}
// See if there's a full class
elseif(class_exists(SECTION))
{
	// Set class
	$fullClass = SECTION;
	// Change the App directory to the shared space, but load as normal
	$_APP_CONFIG['general']['directory'] = 'shared';
}

// If there's no full class by this point, it doesn't exist in this application
if($fullClass)
{
	// Check for sub-section
	if(isset($_GET['su']))
	{
		$subsectionName = \Thinker\Http\Request::get('su', true);
		define('SUBSECTION', $subsectionName);
	}
	else
	{
		// Load subsection from class
		try
		{
			$subsectionName = $fullClass::defaultSubsection();
			define('SUBSECTION', $subsectionName);
		}
		catch(Exception $ex)
		{
			trigger_error("Could not determine the subsection to load.", E_USER_ERROR);
		}
	}

	// Create instance of section
	$instance = new $fullClass;

	// Attempt to load subsection
	if(method_exists($fullClass, $subsectionName))
	{
		// Call method
		$result = $instance->$subsectionName();
	}
	else
	{
		// Error redirect
		\Thinker\Http\Redirect::error(404);
	}

	// Compile info array
	$_INFO['environment'] = $_CONFIG['core']['environment'];
	$_INFO['section'] = SECTION;
	$_INFO['subsection'] = SUBSECTION;

	// Create a view
	$fullView = null;

	// First, see if the view is local
	$localView = "\\".APP_NAMESPACE."\\{$instance->view}";

	if(class_exists($localView))
	{
		$fullView = $localView;
	}
	// If not local, look for a shared view
	elseif(class_exists("\\".$instance->view))
	{
		$fullView = "\\".$instance->view;
	}
	// If we're here and still no view, throw an error below...

	if($fullView)
	{
		$view = \Thinker\Framework\View::factory($fullView, $instance);

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
		trigger_error("View '{$instance->view}' was not found.", E_USER_ERROR);
	}
}
else
{
	// Error redirect
	\Thinker\Http\Redirect::error(404);
}

// Close database connection
$_DB = null;
?>