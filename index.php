<?php
	/**
	 * index.php
	 * Entry point for the web application
	 * This page handles most of the page load logic
	 * The rest is contains in the individual Section files
	 * 
	 * @author Cory Gehr <gehrc621@gmail.com>
	 */

// Get autoloader
require_once(__DIR__.'/includes/autoload.inc');

// Run initialization script
require_once(__DIR__.'/includes/init.inc');

/******************
  Controller Start  
*******************/

// Load specified section
if(isset($_GET['s']))
{
	$_SECTION = getPageVar('s', 'str', 'GET', true);
}
else
{
	$_SECTION = $_CONFIG['thinker_general']['default_section'];
}

// Assign section class
$_SECTION_CLASS = CLASS_PREFIX . 'Section_' . $_SECTION;

// Get path to section
$sectionPath = getPath($_SECTION_CLASS);
$sectionFile = $sectionPath . "$_SECTION.php";

// Check if the section specified exists
if(file_exists($sectionFile))
{
	require_once($sectionFile);

	// Create instance of section
	$instance = new $_SECTION_CLASS();

	// Load section configuration
	$sectionConfig = parse_ini_file($sectionPath . 'config.ini', true);

	// Check for sub-section
	if(isset($_GET['su']))
	{
		$_SUBSECTION = getPageVar('su', 'str', 'GET', true);
	}
	else
	{
		// Load subsection from config
		if(isset($sectionConfig['defaults']['default_subsection']))
		{
			$_SUBSECTION = $sectionConfig['defaults']['default_subsection'];
		}
		else
		{
			trigger_error("Could not determine the subsection to load.", E_USER_ERROR);
		}
	}

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
		$view = THINKER_View::factory($instance->view, $instance);

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
	errorRedirect(404);
}

// Close database connection
$_DB = null;
?>