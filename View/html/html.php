<?php
	/**
	 * html.php
	 * Contains the THINKER_View_html class
	 *
	 * @author Cory Gehr
	 */

class THINKER_View_html extends THINKER_View_Common
{
	/**
	 * display()
	 * Outputs the HTML
	 *
	 * @access public
	 */
	public function display()
	{
		global $_DB, $_CONFIG, $_MESSAGES, $_SECTION, $_SUBSECTION;

		// Get the style used
		$style = $_CONFIG['thinker_view_html']['template'];
		$styleDir = "View/html/style/$style";
		
		// Get the filename for the section's action template
		$tplFile = 'Section/' . $_SECTION . '/html/' . $_SUBSECTION . '.tpl';
		$iniFile = 'Section/' . $_SECTION . '/config.ini';

		// Ensure file exists
		if(!file_exists($tplFile) || !file_exists($iniFile))
		{
			// Redirect to error
			errorRedirect(404);
			exit();
		}

		// Parse ini file
		$viewSettings = parse_ini_file($iniFile, true);

		// Start HTML output
?>
<!DOCTYPE html>
<html>
<head>
<?php
		// Include head items
		include_once($styleDir . "/head.inc");
?>
</head>
<body>
<?php
		// Include heading
		include_once($styleDir . "/bodyHeading.inc");

		// Include body data
		include_once($tplFile);

		// Include footer
		include_once($styleDir . "/bodyFooter.inc");
?>
</body>
</html>
<?php
	}

	/**
	 * authPageSection()
	 * Checks authorization to a specific section of the page
	 *
	 * @author Cory Gehr
	 * @param $token: Section token
	 * @param $errorAction: Action to take on error (default: suppress)
	 * @param $customError: Custom error to display if unauthorized (default: null)
	 * @return True if Authorized, False on Failure
	 */
	private function authPageSection($token, $errorAction = 'suppress', $customError = null)
	{
		// Check authorization
		if($this->section->session->auth('pageSection', array('section' => $_SECTION, 'subsection' => $_SUBSECTION, 'token' => $token)))
		{
			// Authorized
			return true;
		}
		else
		{
			// Unauthorized, check error actions
			switch($errorAction)
			{
				case 'inline':
					// Error message
					if(!$customError)
					{
						$message = "<p>[Access Denied to '$token']</p>";
					}
					else
					{
						$message = $customError;
					}

					echo $message;
				break;
			}

			return false;
		}
	}

	/**
	 * get()
	 * Gets an item from the $data array, if it exists
	 *
	 * @access private
	 * @param $name: Index Name
	 * @param $nullBehavior: Error display behavior if item doesn't exist (default: 'suppress')
	 * @param $customError: Custom error to display if item doesn't exist (default: null)
	 * @return Data item if value exists, Error if not
	 */
	private function get($name, $nullBehavior = 'suppress', $customError = null)
	{
		// Check if item exists in $data
		$val = $this->section->getVal($name);

		if($val != null)
		{
			return $val;
		}
		else
		{
			// Error message
			if(!$customError)
			{
				$message = "['$name' is unspecified]";
			}
			else
			{
				$message = $customError;
			}

			// Throw error, based on specified behavior
			switch($nullBehavior)
			{
				case 'suppress':
					return null;
				break;

				case 'inline':
					return $message;
				break;
			}
		}
	}
}
?>