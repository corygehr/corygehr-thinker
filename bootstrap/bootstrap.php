<?php
	/**
	 * bootstrap.php
	 * Initializes the web application
	 *
	 * @author Cory Gehr
	 */

// Add autoloader
require_once(__DIR__.'/autoload.php');

// Import system configurations
$_CONFIG = parse_ini_file(__DIR__.'/../app/config/sysConfig.ini', true);

// Add-in globals
require_once(__DIR__.'/globals.php');

// Set error handler
set_error_handler(array('Error', 'errorHandler'));

// Open database connections
$_DB_CONFIG = parse_ini_file(__DIR__.'/../app/config/dbConfig.ini', true);

foreach($_DB_CONFIG as $dbName => $dbSettings)
{
	$_DB[$dbName] = new Thinker\Database($dbSettings);
}

// Clear DB settings array
$_DB_CONFIG = null;

// Call the Controller Loader to get this application going!
require_once(__DIR__.'/../app/loader.php');
?>
