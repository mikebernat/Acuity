<?php
/**
 * Abstract.php
 * Acuity_Controller_Abstract
 *
 * Abstract controller class
 *
 * PHP version 5.2.*
 *
 * @category Testing
 * @package  Acuity
 * @author   Mike Bernat <mike@mikebernat.com>
 * @name     Acuity_Controller_Abstract
 * @license  Private http://www.acuityproject.com/
 * @version  SVN: $Id$
 * @link     http://www.acuityproject.com/
 * @since    .01
 * @created  Jan 28, 2010
 *
 */
 
 
 /**
 * Abstract controller
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
abstract class Acuity_Controller_Abstract
{
	public  $template_extension = '.tpl';
	
	public $view;
	
	/**
	 * Request object
	 * 
	 * @var Acuity_Request
	 */
	public $request;
	
	/**
	 * Constructor
	 * 
	 * @param Acuity_View    $view_object View object
	 * @param Acuity_Request $request     Request object
	 * 
	 * @return void
	 */
	public function __construct(Acuity_View $view_object, Acuity_Request $request)
	{
		$this->view    = $view_object;
		$this->request = $request;
	}
	
	/**
	 * Pre dispatch
	 * 
	 * @return void
	 */
	public function preDispatch()
	{
		$this->view->request = $this->request;
	}
	
	/**
	 * Post Dispatch
	 * 
	 * @return void
	 */
	public function postDispatch()
	{
		
	}
	
	/**
	 * Redirect
	 * 
	 * @param string $url Url to redirect
	 * 
	 * @return void
	 */
	public function redirect($url)
	{
		Acuity_Response::getInstance()->redirect($url);
	}
	
	/**
	 * Render a template
	 * 
	 * @param string $script_name Script name
	 * 
	 * @return string rendered template
	 */
	public function render($script_name = null)
	{
		if (!$script_name) {
			$script_name = Acuity_Request::getInstance()->getController() . 
				DS . Acuity_Request::getInstance()->getAction() . 
				$this->template_extension;
		}
		
		$result = $this->view->render('views' . DS . $script_name);
		
		return $result;
	}
	
}