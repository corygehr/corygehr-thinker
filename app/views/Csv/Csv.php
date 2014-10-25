<?php
	/**
	 * Csv.php
	 * Contains the View\Csv class
	 * Outputs a CSV file with the passed data
	 *
	 * @author Cory Gehr
	 */
class Csv extends Common
{
	/**
	 * __construct()
	 * Constructor for the CSV View Class
	 *
	 * @author Cory Gehr
	 * @access public
	 * @param Section $section: Section being displayed
	 */
	public function __construct(Section $section)
	{
		// Call the constructor in View\Common (sets the Section)
		parent::__construct($section);
	}

	/**
	 * display()
	 * Outputs the data
	 *
	 * @author Cory Gehr
	 * @access public
	 */
	public function display()
	{
		global $_SECTION;	
		// Call the constructor in View\Common
		
		// Headers to tell the browser to download a file
		header('Content-type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename="' . $_SECTION . '.csv"');
		header('Pragma: no-cache');
		header('Expires: 0');
		
		// Get the data
		$tmpData = $this->section->getData();
		
		// Get the resultset we should use
		$set = getPageVar('set', 'str');
		
		// Variables to store the data
		$header = null;
		$expdata = "";
		
		// Get the actual data we'll be working with
		if(isset($tmpData[$set]))
		{
			$resultData = $tmpData[$set];
		
			// Get the headers (just grab em from the first item since that should be there)
			$headings = array_keys($resultData[0]);
			
			$headerTitles = array();
			
			// Define headers
			foreach ($headings as $heading)
			{
				// Get rid of ints (see DB.inc for why these are there)
				if(is_string($heading))
				{
					$headerTitles[] = $heading;
					
					if($header)
					{
						$header .= ',' . $heading;
					}
					else
					{
						$header = $heading;
					}
				}
			}
			
			// Newline
			$header .= "\n";
			
			// Add data
			foreach ($resultData as $row)
			{
				$line = "";
				foreach ($row as $heading => $value)
				{
					if($heading !== 0 && in_array($heading, $headerTitles))
					{
						$value = trim($value);
						
						if(!empty($line))
						{
							$line .= ',"' . $value . '"';
						}
						else
						{
							$line .= '"' . $value . '"';
						}
					}
				}
				
				$expdata .= $line . "\n";
			}
			
			if ($expdata == "")
			{
				$expdata = "No Records Found!";
			}
		}
		else
		{
			$header = null;
			$expdata = "No Records Found or perhaps this Section does not support CSV Exporting.";
		}
		
		// Output data
		echo ($header .= $expdata);
	}
}

?>
