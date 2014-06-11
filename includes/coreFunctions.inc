<?php
	/**
	 * coreFunctions.php
	 * Contains the system critical functions for THINKer
	 *
	 * @author Cory Gehr
	 */
	 
/**
 * __autoload()
 * PHP Function that runs when a selected class cannot be loaded
 * Attempts to locate the class so we don't have to include them everywhere
 *
 * @author Cory Gehr
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
 * createUrl()
 * Creates a local, internal URL
 *
 * @author Cory Gehr
 * @param $section: Section Name
 * @param $subsection: Subsection Name (default: null)
 * @param $params: URL Parameters (default: empty array)
 * @return Full URL to Item
 */
function createUrl($section, $subsection = null, $params = array())
{
	$url =	BASE_URL . 'index.php?section=' . urlencode($section);

	if($subsection)
	{
		$url .= "&subsection=" . urlencode($subsection);
	}
	
	// Add URL Parameters
	if(count($params) > 0)
	{
		foreach($params as $key => $value)
		{
			$url .= ("&$key=" . urlencode($value));
		}
	}
	
	return $url;
}

/**
 * errorRedirect()
 * Redirects to an error page
 *
 * @author Cory Gehr
 * @param $no: Error Number (default: 404)
 */
function errorRedirect($no = 404)
{
	// Call current redirect function
	redirect('Error', 'info', array('no' => $no));
}

/**
 * getPageVar()
 * Gets a variable submitted to the page
 *
 * @author Cory Gehr
 * @param $name: Variable Name
 * @param $type: Variable Type (default: str)
 * @param $source: Variable source (GET, POST, COOKIE)
 * @param $required: Flag to tell if the variable is required (default: false)
 * @param $allowHtml: Flag for allowing HTML (default: false)
 * @return Variable Value, or NULL if Validation Fails
 */
function getPageVar($name, $type = 'str', $source, $required = false, $allowHtml = false)
{
	switch($source)
	{
		case 'GET':
			$value = (isset($_GET[$name]) == true ? $_GET[$name] : null);
		break;

		case 'POST':
			$value = (isset($_POST[$name]) == true ? $_POST[$name] : null);
		break;

		case 'COOKIE':
			$value = (isset($_COOKIE[$name]) == true ? $_COOKIE[$name] : null);
		break;
	}

	if($value)
	{
		// Sanitize
		$value = trim($value);

		if(!$allowHtml)
		{
			$value = stripslashes($value);
			$value = htmlspecialchars($value);
		}

		return $value;
	}
	elseif($required)
	{
		// Throw error
		trigger_error("Required variable '$name' was not specified");
	}

	return null;
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

/**
 * pushMessage()
 * Pushes a message to the message cache
 *
 * @author Cory Gehr
 * @param $text: Message Text
 * @param $level: Message Level (info, error, warning, success) (default: info)
 * @param $overrwrite: Flag that would remove all other messages and add this one (default: false)
 */
function pushMessage($text, $level = 'info', $overwrite = false)
{
	global $_MESSAGES;

	if($overwrite)
	{
		$_MESSAGES = array();
	}

	// Set message
	$_MESSAGES[] = array(
		0 => $text,
		1 => $level
		);
}

/**
 * redirect()
 * Redirects the user to the specified area
 *
 * @author Cory Gehr
 * @param $section: Section Name
 * @param $subsection: Subsection Name (default: null)
 * @param $params: URL Parameters in an associative array (default: empty array)
 */
function redirect($section, $subsection = null, $params = array())
{
	// Create URL
	$url = createUrl($section, $subsection, $params);

	// Perform redirect
	header('Location: ' . $url);
	exit();
}

/**
 * thinkerErrorHandler()
 * Error Handler for THINKer
 *
 * @author Cory Gehr
 * @param $errNo: Error Level
 * @param $errMsg: Error String
 * @param $errFile: Error File
 * @param $errLine: Error Line
 * @param $errContext: Error Context Array
 */
function thinkerErrorHandler($errNo, $errMsg, $errFile, $errLine, $errContext)
{
	if ($errNo == E_USER_ERROR || $errNo == E_ERROR || $errNo == E_CORE_ERROR)
	{
		// Stop the execution of the page
		// Normally, errors are displayed at a specific point, but since the program is
		// stopping, the errors should be displayed right now.
		
		echo "
		A fatal error has occurred in this application. If you continue to see this message, 
		please contact the server administrator. Additional details are below:
		";
		
		echo "<br/>\n";
		
		echo "<pre>";
		echo "Error $errNo: $errMsg on Line $errLine in $errFile.";
		echo "</pre>";
		
		die();
	}
	else
	{
		// Compile message and push to message cache
		$message = "An error has occurred at Line $errLine in $errFile. Details: <i>$errMsg</i>.";
		pushMessage($message, 'error');
	}
}

/**
 * timestamp()
 * Gets the current date/time
 *
 * @author Cory Gehr
 * @return Date in Y-m-d H:i:s format
 */
function timestamp()
{
	// Get the current date
	date_default_timezone_set('America/New_York');
	return date('Y-m-d H:i:s');
}
?>