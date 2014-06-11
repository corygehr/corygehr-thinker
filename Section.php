<?php
	/**
	 * Section.php 
	 * Contains the THINKER_Section class
	 *
	 * @author Cory Gehr
	 */
	 
abstract class THINKER_Section
{
	protected $reflectionClass; // Contains information about the class (ReflectionClass)
	protected $data;            // Contains the data being passed back from the Section
	protected $session;         // Contains session data
	
	public $view;      // Contains the view being loaded for the section
	
	/**
	 * __construct()
	 * Constructor for the THINKER_Section Class
	 *
	 * @author Cory Gehr
	 * @access public
	 */
	public function __construct()
	{
		// Initialize classInfo with information about the target class
		$this->reflectionClass = new ReflectionClass($this);
		$this->data = array();

		// Override view if necessary
		if(isset($_GET['view']))
		{
			$this->view = getPageVar('view', 'str', 'GET', true);
		}
		else
		{
			$this->view = DEFAULT_VIEW;
		}

		// Get the session information
		$sessionClass = SESSION_CLASS;
		
		$this->session = $sessionClass::singleton();
	}

	/**
	 * getData()
	 * Passes back the data array from this section
	 *
	 * @access public
	 * @return Data Array
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * getVal()
	 * Gets a value from this object
	 *
	 * @access public
	 * @param $name: Name of the Variable
	 * @return Variable Value, or NULL on non-existence
	 */
	public function getVal($name)
	{
		if(isset($this->data[$name]))
		{
			return $this->data[$name];
		}
		else
		{
			return null;
		}
	}

	/**
	 * set()
	 * Sets a value in the local data array
	 *
	 * @access public
	 * @param $key: Array key
	 * @param $value: Value
	 */
	public function set($key, $value)
	{
		$this->data[$key] = $value;
	}

	/**
	 * toArray()
	 * Returns an object's variables as an associative array
	 * 
	 * @author Joe Stump <joe@joestump.net>
	 * @access public
	 * @return Array of Variables (VarName => Value)
	 */
	public function toArray()
	{
		$defaults = $this->reflectionClass->getDefaultProperties();
		$return = array();
		
		foreach($defaults as $var => $val)
		{
			if($this->$var instanceof THINKER_Object)
			{
				$return[$var] = $this->$var->toArray();
			}
			else
			{
				$return[$var] = $this->$var;
			}
		}
		
		return $return;
	}
}