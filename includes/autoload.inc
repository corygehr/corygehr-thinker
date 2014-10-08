<?php
	/**
	 * autoload.inc
	 * Contains functions used for auto-loading classes
	 *
	 * @author Cory Gehr
	 */

/**
 * __autoload()
 * PHP Function that runs when a selected class cannot be loaded
 * Attempts to locate the class so we don't have to include them everywhere
 *
 * @param $class: Class being loaded
 */
function __autoload($class)
{	
	$path = getPath($class);

	if($path)
	{
		// Trim out class prefix
		$classInfo = explode('_', $class);
		$depth = count($classInfo);

		$class = $classInfo[$depth-1];

		require_once($path . "$class.php");
	}
	else
	{
		// Throw error
		trigger_error("An invalid class name ($class) was specified, cannot proceed.", E_USER_ERROR);	
	}
}

/**
 * getPath()
 * Gets the path to the specified class, relative to the site root
 *
 * @author Cory Gehr
 * @param $class: Class Name
 * @return Path to Class
 */
function getPath($class)
{
	// Get the type of object
	$classTypes = explode('_', $class);
	$depth = count($classTypes);

	if($depth <= 1)
	{
		// Usually means an invalid class name
		return null;
	}

	if($depth > '2')
	{
		// Build path
		$classFile = '';

		// Start at 1 to skip 'THINK'
		for($i=1; $i<$depth;$i++)
		{
			$classFile .= $classTypes[$i] . '/';
		}
	}
	else
	{
		// == 2 means it will be in the root directory (THINKER_Object, THINKER_Section, etc.)
		$classFile = './';
	}

	return $classFile;
}
?>