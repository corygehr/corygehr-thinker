<?php
    /**
	 * Xml.php
	 * Contains the View\Xml class
	 *
	 * @author Cory Gehr
	 * @see http://stackoverflow.com/questions/1397036/how-to-convert-array-to-simplexml
	 */

class Xml extends \Common
{
    /**
	 * display()
	 * Outputs the data
	 *
	 * @access public
     */
    public function display()
    {
	    // Display the header
        header('Content-type: text/xml');
		
		// Get data
		$data = $this->section->getData();
		
		// Get the resultset we should use
		$set = getPageVar('set', 'int', 0);
		
        if(empty($data))
		{
            echo "<" . SECTION . ">\n<error>No data received from the object.</error>\n</" . SECTION . ">";
			exit();
        }
		else
		{
		    // Return the encoded data
			$xmlObject = new \SimpleXMLElement("<?xml version=\"1.0\"?><" . SECTION . "></" . SECTION. ">");
			
			$this->arrayToXml($data, $xmlObject);
			
			// Export
			echo $xmlObject->asXML();
        }
    }
	
	/**
	 * arrayToXml()
	 * Parses a PHP Array to XML
	 *
	 * @access private
	 */
	private function arrayToXml($dataArray, &$xmlObj)
	{
		foreach($dataArray as $key => $value)
		{
			if(is_array($value))
			{
				if(!is_numeric($key))
				{
					$subnode = $xmlObj->addChild("$key");
					$this->arrayToXml($value, $subnode);
				}
				else
				{
					$subnode = $xmlObj->addChild("Item$key");
					$this->arrayToXml($value, $subnode);
				}
			}
			else
			{
				// Sanitize Output
				$value = htmlspecialchars($value, ENT_QUOTES);

				if(!is_numeric($key))
				{
					$xmlObj->addChild("$key","$value");
				}
				// If you don't want numerical indexing for the actual values' tags, 
				// comment out this else. This is a site-wide change, so only do this with good reason!
				else
				{
					$xmlObj->addChild("Item$key","$value");
				}
			}
		}
	}
}

?>
