<?php
	/**
	 * globals.php
	 * Defines global variables for the site
	 *
	 * @author Cory Gehr
	 */

// General Settings
define('APPLICATION', $_CONFIG['core']['application']);
define('ENVIRONMENT', $_CONFIG['core']['environment']);

// System
$_DB       = null;    // Database connection
$_INFO     = array(); // Application Information
$_MESSAGES = array(); // Message storage

// Section variables
$_SECTION       = null; // Current section
$_SECTION_CLASS = null; // Section Class Name
$_SUBSECTION    = null; // Subsection
?>