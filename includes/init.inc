<?php
	/**
	 * init.inc
	 * Initializes the framework
	 *
	 * @author Cory Gehr
	 */

// Import system configurations
$_CONFIG = parse_ini_file('includes/sysConfig.ini', true);

// Core Settings
define('CLASS_PREFIX', $_CONFIG['thinker_core']['class_prefix']);

// General Settings
define('BASE_URL', ($_CONFIG['thinker_general']['use_ssl'] == true ? 'https://' : 'http://') . $_CONFIG['thinker_general']['base_url'] . '/');
define('ENVIRONMENT', $_CONFIG['thinker_general']['environment']);
define('SESSION_CLASS', CLASS_PREFIX . 'Session_' . $_CONFIG['thinker_general']['session_class']);

// View Settings
define('DEFAULT_VIEW', $_CONFIG['thinker_view']['default_view']);

/*
 * Site global variables
 */

// Include functionSets
require_once('includes/dbconnect.inc');
require_once('includes/coreFunctions.inc');

// System
$_DB       = null;    // Database connection
$_INFO     = array(); // Application Information
$_MESSAGES = array(); // Message storage

// Section variables
$_SECTION       = null; // Current section
$_SECTION_CLASS = null; // Section Class Name
$_SUBSECTION    = null; // Subsection

// Set error handler
set_error_handler($_CONFIG['thinker_core']['error_handler']);

// Open database connections
$_DB_CONFIG = parse_ini_file('includes/dbConfig.ini', true);

foreach($_DB_CONFIG as $dbName => $dbSettings)
{
	$_DB[$dbName] = new DBConnection($dbSettings);
}

// Clear DB settings array
$_DB_CONFIG = null;
?>
