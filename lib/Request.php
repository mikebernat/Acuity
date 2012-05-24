<?php
/**
 * Request.php
 * Acuity_Request
 *
 * Acuity Request
 *
 * PHP version 5.2.*
 *
 * @category Testing
 * @package  Acuity
 * @author   Mike Bernat <mike@mikebernat.com>
 * @name     Acuity_Request
 * @license  Private http://www.acuityproject.com/
 * @version  SVN: $Id$
 * @link     http://www.acuityproject.com/
 * @since    .01
 *
 */
 
 
 /**
 * Request object
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
class Acuity_Request
{
	/**
	 * Instance of class
	 * 
	 * @var Acuity_Request
	 */
	public static $instance;
	
	public $defaultController = 'index';
	public $defaultAction     = 'index';
	
	private $_controller;
	private $_action;
	private $_params = array();
	
	/**
	 * Constructor
	 * 
	 * @return void
	 */
	public function __construct()
	{
		$this->parseRequestUri();
	}
	
	/**
	 * Fetch singleton instance
	 * 
	 * @return Acuity_Request Singleton instance
	 */
	public static function getInstance()
	{
		if (empty(self::$instance)) {
			self::$instance = new Acuity_Request();
		}
		
		return self::$instance;
	}
	
	/**
	 * Parse the request
	 * 
	 * @param string $request The Request URI
	 * 
	 * @return void
	 */
	public function parseRequestUri($request = null)
	{
		if (!$request) {
			$request = @$_SERVER['REQUEST_URI'];
		}	
		
		if (empty($request)) {
			$request = '/';
		}
		
		$request_parts = $this->_splitRequest($request);
		
		$this->_controller = $this->_parseController($request_parts);
		$this->_action     = $this->_parseAction($request_parts);
		$this->_params     = $this->_parseParams($request_parts);
		
		
		$this->_currentUrl = $this->_parseCurrentUrl();
	}
	
	/**
	 * Parse and store the current url
	 * 
	 * @return string
	 */
	private function _parseCurrentUrl()
	{
		return @$_SERVER['REQUEST_URI'];
	}
	
	/**
	 * Return the current url
	 * 
	 * @return string
	 */
	public function getCurrentUrl()
	{
		return $this->_currentUrl;
	}
	
	/**
	 * Get the requested controller
	 * 
	 * @return string
	 */
	public function getController()
	{
		return $this->_controller;
	}
	
	/**
	 * Get the requested action
	 * 
	 * @return string
	 */
	public function getAction()
	{
		return $this->_action;
	}
	
	/**
	 * Get all params
	 * 
	 * @return array
	 */
	public function getParams()
	{
		return $this->_params;
	}
	
	/**
	 * Get specific param, if it doesn't exist return the default
	 * 
	 * @param string $name    Name of parameter to fetch
	 * @param mixed  $default Returned if param does not exist
	 * 
	 * @return mixed Parameter value
	 */
	public function getParam($name, $default = null)
	{		
		$params = $this->getParams();
		
		// @TODO abstract out offset checking
		if (empty($params[$name])) {
			return $default;
		}
		
		return $params[$name];
		
	}
	
	/**
	 * Parse the request for the controller
	 * 
	 * @param array $request_parts Request parts
	 * 
	 * @return string
	 */
	private function _parseController(array $request_parts)
	{
		$controller = @array_shift($request_parts);
		
		if (empty($controller)) {
			return $this->defaultController;
		}
		
		return $controller;
	}
	
	/**
	 * Parse the request for the action
	 * 
	 * @param array $request_parts Request parts
	 * 
	 * @return string Action name
	 */
	private function _parseAction($request_parts)
	{
		// Pop off the controller
		@array_shift($request_parts);
		
		$action = @array_shift($request_parts);
		
		if (empty($action)) {
			return $this->defaultAction;
		}
		
		return $action;
	}
	
	/**
	 * Parse the request for parameters
	 * 
	 * @param array $request_parts Request parts
	 * 
	 * @return array Parameters
	 */
	private function _parseParams($request_parts)
	{
		// Pop off the first 2 parts (controller and action)
		array_shift($request_parts);
		array_shift($request_parts);
		
		$params = array();
		while ($name = array_shift($request_parts)) {
			$name  = $this->_sanitize($name);
			$value = $this->_sanitize(array_shift($request_parts));
			
			$params[$name] = $value;
		}
		
		// Add the $_REQUEST vars to the params
		$params += $_REQUEST;
		
		return $params;
	}
	
	/**
	 * Split the request by the given delimeter
	 * 
	 * @param string $request   The raw request
	 * @param array  $delimeter The delimeter to split the request with
	 * 
	 * @return array The exploded request uri
	 */
	private function _splitRequest($request, $delimeter = '/')
	{
		// Trim off the leading delimeter
		$request = ltrim($request, $delimeter);
		
		return explode($delimeter, $request);
	}
	
	/**
	 * Sanitize a given string
	 * 
	 * @param string $string The string to sanitize
	 * 
	 * @return string Sanitized string
	 */
	private function _sanitize($string)
	{
		return @trim(urldecode($string));
	}
	
	/**
	 * Clears the singleton instance
	 * 
	 * @return void
	 */
	public static function clearInstance()
	{
		self::$instance = null;
	}
	
	/**
	 * Determines if the request has POST variables
	 * 
	 * @return boolean
	 */
	public function isPost()
	{
		if (!empty($_POST)) {
			return true;
		}
		
		return false;
	}
}