<?php
	/**
	 * bootstrap.php
	 * Initializes the web application
	 *
	 * @author Cory Gehr
	 */

/**
 * Global logic
 */

// Add autoloader
require_once(__DIR__.'/autoload.php');

// Import system configuration from shared
$_CONFIG = parse_ini_file(__DIR__.'/../shared/config/system.ini', true);

// Set error handler
set_error_handler(array('Thinker\Framework\Error', 'errorHandler'));

/**
 * App-loading logic
 */

// Determine the application requested, based on URI
$host = $_SERVER['HTTP_HOST'];
// Check global configurations to determine application
if(isset($_CONFIG['applications'][$host]))
{
	$_CONFIG['core']['application'] = $_CONFIG['applications'][$host];
}
else
{
	// Use default, if specified (or throw an error if not)
	if(!isset($_CONFIG['core']['application']))
	{
		// Throw exception
		trigger_error("Could not determine the application to load. Please check your system settings and try again.");
	}
}

// Load application configuration
$_APP_CONFIG = parse_ini_file(__DIR__."/../{$_CONFIG['core']['application']}/config/application.ini", true);

// Add-in globals
require_once(__DIR__.'/globals.php');

/**
 * Database Connections
 */

// Shared
$_DB_CONFIG = array();

if(file_exists(__DIR__."/../shared/config/database.ini"))
{
	$_DB_CONFIG = parse_ini_file(__DIR__."/../shared/config/database.ini", true);
}

// App-specific
if(file_exists(__DIR__."/../{$_CONFIG['core']['application']}/config/database.ini"))
{
	$_DB_CONFIG += parse_ini_file(__DIR__."/../{$_CONFIG['core']['application']}/config/database.ini", true);
}

if($_DB_CONFIG)
{
	foreach($_DB_CONFIG as $dbName => $dbSettings)
	{
		$_DB[$dbName] = new Thinker\DataSource\Database($dbSettings);
	}

	// Clear DB settings array
	$_DB_CONFIG = null;
}

/**
 * Load application!
 */

// Call the Controller Loader to get application started
require_once(__DIR__."/../{$_CONFIG['core']['application']}/loader.php");
?>
