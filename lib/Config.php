<?php
/**
 * Config.php
 * Acuity_Config
 *
 * Config class
 *
 * PHP version 5.2.*
 *
 * @category Testing
 * @package  Acuity
 * @author   Mike Bernat <mike@mikebernat.com>
 * @name     Acuity_Config
 * @license  Private http://www.acuityproject.com/
 * @version  SVN: $Id$
 * @link     http://www.acuityproject.com/
 * @since    .01
 *
 */
 
 
 /**
 * Acuity Config Parses and stores application parameters
 *
 * @category  Testing
 * @package   Acuity
 * @author    Mike Bernat <mike@mikebernat.com>
 * @copyright 2010 Mike Bernat <mike@mikebernat.com>
 * @license   Private http://www.acuityproject.com/
 * @version   Release: .01
 * @link      http://www.acuityproject.com/
 * @since     .01
 */
class Acuity_Config
{
	/**
	 * The interperted configuration array
	 * 
	 * @var array
	 */
	public $config = array();
	
	/**
	 * Inantiate the config
	 * 
	 * @param string $filename Full path to config file
	 * @param string $section  Section of the ini file to parse
	 * 
	 * @return void
	 */
	public function __construct($filename, $section = null) 
	{
		if (empty($filename)) {
			throw new Acuity_Exception(
				'Full-path to the configuration file must be 
				provided when instantiating Acuity_Config.'
			);
		}
		
		if (!file_exists($filename) || !is_readable($filename)) {
			throw new Acuity_Exception(
				'Config file could not be found or is not readible: ' . $filename
			);
		}
		
		$this->config = $this->_parseFile($filename, $section);
	}
	
	/**
	 * Return a config value
	 * 
	 * @param string $name Value to retrieve
	 * 
	 * @return mixed
	 */
	public function __get($name)
	{
		return $this->get($name);
	}
	
	/**
	 * Parse the config file and return the values
	 * 
	 * @param string $config_path Full path to config file
	 * @param string $section     Section of config file to parse
	 * 
	 * @return array
	 */
	private function _parseFile($config_path, $section = null)
	{
		return parse_ini_file($config_path, $section);
	}
	
	/**
	 * Return a named config variable
	 * 
	 * @param string $name    Name of the config entry to return
	 * @param mixed  $default Default value to use if key does not exist
	 * 
	 * @return mixed
	 */
	public function get($name, $default = null)
	{
		return ($this->_getOffset($name)) ? $this->_getOffset($name) : $default;
	}
	
	/**
	 * Determine if a key exists in the config array
	 * 
	 * @param string $name Key name to check
	 * 
	 * @return boolean
	 */
	private function _offsetExists($name)
	{
		return array_key_exists($name, $this->_getConfig());
	}
	
	/**
	 * Return a value from the config array
	 * 
	 * @param string $name Name of offset to get
	 * 
	 * @return mixed value or false on failure
	 */
	private function _getOffset($name)
	{
		if ($this->_offsetExists($name)) {
			$config = $this->_getConfig();
			
			return $config[$name];
		}
		
		return false;
	}
	
	/**
	 * Return the config array
	 * 
	 * @return array
	 */
	private function _getConfig()
	{
		return $this->
		config;
	}
}