<?php
	/**
	 * models/SampleObj.php 
	 * Contains the SampleObj class
	 *
	 * @author Cory Gehr
	 */

class SampleObj extends \Thinker\Framework\Model
{
	private $someMessage;

	/**
	 * __construct()
	 * Constructor for the SampleObj class
	 *
	 * @author Cory Gehr
	 * @access public
	 */
	public function __construct($message)
	{
		$this->someMessage = $message;
	}

	/**
	 * getMessage()
	 * Gets the value of the someMessage variable
	 *
	 * @access public
	 * @return someMessage Value
	 */
	public function getMessage()
	{
		return $this->someMessage;
	}

	/**
	 * setMessage()
	 * Sets a new value for the someMessage variable
	 *
	 * @access public
	 * @param $newMessage: New 'someMessage' Value
	 */
	public function setMessage($newMessage)
	{
		$this->someMessage = $newMessage;
	}
}