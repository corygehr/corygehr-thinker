<?php
	/**
	 * globals.php
	 * Defines global variables for the site
	 *
	 * @author Cory Gehr
	 */

// General Settings
define('BASE_URL', ($_CONFIG['thinker_general']['use_ssl'] == true ? 'https://' : 'http://') . $_CONFIG['thinker_general']['base_url'] . '/');
define('ENVIRONMENT', $_CONFIG['thinker_general']['environment']);

// View Settings
define('DEFAULT_VIEW', $_CONFIG['thinker_view']['default_view']);

// System
$_DB       = null;    // Database connection
$_INFO     = array(); // Application Information
$_MESSAGES = array(); // Message storage

// Section variables
$_SECTION       = null; // Current section
$_SECTION_CLASS = null; // Section Class Name
$_SUBSECTION    = null; // Subsection
?>