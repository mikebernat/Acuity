<?php
/**
 * Response.php
 * Acuity_Response
 *
 * Acuity Response
 *
 * PHP version 5.2.*
 *
 * @category Testing
 * @package  Acuity
 * @author   Mike Bernat <mike@mikebernat.com>
 * @name     Acuity_Response
 * @license  Private http://www.acuityproject.com/
 * @version  SVN: $Id$
 * @link     http://www.acuityproject.com/
 * @since    .01
 *
 */
 
 
 /**
 * Response object
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
class Acuity_Response
{
	public static $instance;
	
	public $exitAfterRedirect = true;
	
	private $_headers = array();
	
	private $_body;
	
	/**
	 * Get singleton instance
	 * 
	 * @return Acuity_Response
	 */
	public static function getInstance()
	{
		if (empty(self::$instance)) {
			self::$instance = new Acuity_Response();
		}
		
		return self::$instance;
	}
	
	/**
	 * Redirect to a url. Note, if the existAfterRedirect property
	 * is set to true, the stack will be exited here.
	 * 
	 * @param string $url Url to redirecr to
	 * 
	 * @return void
	 */
	public function redirect($url)
	{
		$this->addHeader('Location: ' . $url);
		
		if ($this->exitAfterRedirect) {
			$this->sendHeaders();
			exit();
		}
	}
	
	/**
	 * Add header to the stack
	 * 
	 * @param string $header Header to add
	 * 
	 * @return void
	 */
	public function addHeader($header)
	{
		$this->_headers[] = $header;
	}
	
	/**
	 * Send headers to the browser
	 * 
	 * @return void
	 */
	public function sendHeaders()
	{
		if (empty($this->_headers)) {
			return;
		}
		
		foreach ($this->_headers as $header) {
			header($header);
		}
	}
	
	/**
	 * Output the body to the browser
	 * 
	 * @return int
	 */
	public function sendBody()
	{
		return print($this->_body);
	}
	
	/**
	 * Set the response body
	 * 
	 * @param string $response The body
	 * 
	 * @return void
	 */
	public function setBody($response)
	{
		if (!is_string($response)) {
			throw new Acuity_Exception(
				'Body response must be a string. ' . gettype($response) . ' given.'
			);
		}
		
		$this->_body = $response;
	}
	
	/**
	 * Send the response objects to the browser
	 * 
	 * @return void
	 */
	public function send()
	{
		$this->sendHeaders();
		$this->sendBody();
	}
}