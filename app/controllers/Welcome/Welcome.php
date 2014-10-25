<?php
	/**
	 * Welcome.php
	 * Contains the Class for the Welcome Controller
	 *
	 * @author Cory Gehr
	 */

class Welcome extends Thinker\Controller
{
	private static $defaultSubsection = 'info';

	/**
	 * info()
	 * Passes data back for the 'info' subsection
	 *
	 * @access public
	 */
	public function info()
	{
		// Create a SampleObj object and play with it a bit
		$myMessage = "This is a test of the THINKer Framework.";

		$NewObject = new SampleObj($myMessage);

		$this->set('message1', $NewObject->getMessage());

		$newMessage = "This is a test of the THINKer Framework's object handling capabilities.";

		$NewObject->setMessage($newMessage);

		$this->set('message2', $NewObject->getMessage());

		return true;
	}
}
?>