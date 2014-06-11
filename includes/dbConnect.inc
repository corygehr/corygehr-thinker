<?php
	/**
	 * dbconnect.inc
	 * Contains the DBConnection class (extends the PHP PDO class)
	 * Note that this is the only class that does NOT extend from other (locally created) objects
	 *
	 * @author Cory Gehr
	 * @version 0.1
	 */
	
class DBConnection extends PDO
{
	// Private Class Variables
	private $engine; 
	private $host; 
	private $database; 
	private $user; 
	private $pass;

	/**
	 * __construct()
	 * Constructor for the DB Class
	 *
	 * @access public
	 * @param $settings: Connection Settings
	 */
	public function __construct($settings)
	{ 
		// Get desired configuration options
		$user = $settings['user'];
		$pass = $settings['password'];
		$type = $settings['driver'];

		// DSN Properties
		$host = $settings['host'];
		$port = $settings['port'];
		$schema = $settings['schema'];

		// PDO Options
		//$options = $settings['pdo_options'];

		// Data Source String
		$dsn = $type . ":dbname=$schema;host=$host;port=$port";

		// Attempt to make connection
		try
		{
			// '@' suppresses errors from this function. We output our own message if there's a problem
			@parent::__construct($dsn, $user, $pass);
		}
		catch(PDOException $err)
		{
			die("Unable to connect to the database server. Details: " . $err->getMessage() . ".");
		}
	}

	/**
	 * doQuery()
	 * Executes a MySQL Query
	 * Based on Adam Zydney's function from THINK Again
	 *
	 * @author Cory Gehr
	 * @access public
	 * @param $query: MySQL Query String
	 * @param $data: Parameters for the query
	 * @return Boolean value based on query success
	 */
	public function doQuery($query, $data = null)
	{
		// Prepare the entered query
		$prepQuery = parent::prepare($query);
		// Execute query, return result
		return $prepQuery->execute($data);
	}
	
	/**
	 * doQueryAns()
	 * Returns a single value from the database
	 * Based on Adam Zydney's function from THINK Again
	 *
	 * @author Cory Gehr
	 * @access public
	 * @param $query: MySQL Query String
	 * @param $data: Parameters for the query
	 * @return Single database value
	 */
	public function doQueryAns($query, $data = null)
	{
		// Prepare and execute the entered query
		$prepQuery = parent::prepare($query);
		$prepQuery->execute($data);
		
		// Return the first column, AKA the only column 
		return $prepQuery->fetchColumn(0);
	}
	
	/**
	 * doQueryArr()
	 * Returns an array of all returned objects
	 * Based on Adam Zydney's function from THINK Again
	 *
	 * @author Cory Gehr
	 * @access public
	 * @param $query: MySQL Query String
	 * @param $data: Parameters for the query
	 * @return Array of database values
	 */
	public function doQueryArr($query, $data = null)
	{
		// Prepare and execute the entered query
		$prepQuery = parent::prepare($query);
		$prepQuery->execute($data);
		
		// Return the entire result set
		return $prepQuery->fetchAll();
		// Calling fetchAll like this means we get the numerical and column-keyed index
		// Oracle and MSSQL support giving only the key using PDO::FETCH_ASSOC, but MySQL does not. Could be useful though?
	}
	
	/**
	 * doQueryOne()
	 * Returns a single row of data
	 * Based on Adam Zydney's function from THINK Again
	 *
	 * @author Cory Gehr
	 * @access public
	 * @param $query: MySQL Query String
	 * @param $data: Parameters for the query
	 * @return Database data row
	 */
	public function doQueryOne($query, $data = null)
	{
		// Prepare and execute the entered query
		$prepQuery = parent::prepare($query);
		$prepQuery->execute($data);
		
		// Since this function is only to return one row, only return the first row
		return $prepQuery->fetch();
	}
}
?>
