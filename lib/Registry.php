<?php
/**
 * Registry.php
 * Acuity_Registry
 *
 * Acuity Registry
 *
 * PHP version 5.2.*
 *
 * @category Testing
 * @package  Acuity
 * @author   Mike Bernat <mike@mikebernat.com>
 * @name     Acuity_Registry
 * @license  Private http://www.acuityproject.com/
 * @version  SVN: $Id$
 * @link     http://www.acuityproject.com/
 * @since    .01
 *
 */
 
 
 /**
 * Registry object globally accessible - Use with care
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
class Acuity_Registry
{
	/**
	 * Singleton instance of Acuity_Registry
	 * @var Acuity_Registry
	 */
	public static $instance;
	
	/**
	 * Registry storage
	 * @var array
	 */
	private $_registry;
	
	/**
	 * Private constructor
	 * 
	 * @return void
	 */
	private function __construct() 
	{
	
	}
	
	/**
	 * Private clone method
	 * 
	 * @return void
	 */
	public function __clone() 
	{
		throw new Acuity_Exception('Acuity_Registry may not be cloned.');
	}
	
	/**
	 * Get instance of Acuity_Config
	 * 
	 * @return Acuity_Config
	 */
	public static function getInstance()
	{
		if (empty(self::$instance)) {
			self::$instance = new Acuity_Registry();
		}
		
		return self::$instance;
	}
	
	/**
	 * Clear the registry
	 * 
	 * @return void
	 */
	public static function clearInstance()
	{
		return self::$instance = null;
	}
	
	/**
	 * Set a registry value
	 * 
	 * @param string $name  Name
	 * @param mixed  $value Value
	 * 
	 * @return Acuity_Config
	 */
	public static function set($name, $value)
	{
		
		return self::getInstance()->_set($name, $value);
	}
	
	/**
	 * Set a value in the registry
	 * 
	 * @param string $name  Name of the value
	 * @param mixed  $value The value itself
	 * 
	 * @return void
	 */
	private function _set($name, $value)
	{
		$this->_registry[$name] = $value;
	}
	
	/**
	 * Get a value from the registry
	 * 
	 * @param string $name    Name of the registry value to get
	 * @param mixed  $default Used if name does not exist in registry
	 * 
	 * @return mixed Return value
	 */
	public static function get($name, $default = null)
	{
		return self::getInstance()->_get($name, $default);
	}
	
	/**
	 * Get a registry value
	 * 
	 * @param string $name    Name of the registry value
	 * @param mixed  $default Value to use if name does not exist
	 * 
	 * @return mixed Return value
	 */
	private function _get($name, $default = null)
	{
		if ($this->_offsetExists($name)) {
			return $this->_registry[$name];
		} elseif ($default) {
			return $default;
		}
		
		return null;
	}
	
	/**
	 * Determine if a key exists in the registry
	 * 
	 * @param string $name Name of offset
	 * 
	 * @return boolean result of offset exists
	 */
	private function _offsetExists($name)
	{
		if (empty($this->_registry[$name])) {
			return false;
		}
		
		return true;
	}
}