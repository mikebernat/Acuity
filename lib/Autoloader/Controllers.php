<?php
/**
 * Controllers.php
 * Acuity_Autoloader_Controllers
 *
 * Controller Autoloader Class
 *
 * PHP version 5.2.*
 *
 * @category Testing
 * @package  Acuity
 * @author   Mike Bernat <mike@mikebernat.com>
 * @name     Acuity_Autoloader_Controllers
 * @license  Private http://www.acuityproject.com/
 * @version  SVN: $Id$
 * @link     http://www.acuityproject.com/
 * @since    .01
 *
 */
 
 
 /**
 * Autoloads Controllers
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
class Acuity_Autoloader_Controllers extends Acuity_Autoloader_Loader
{
	/**
	 * Load a class
	 * 
	 * @param string $className Name of the class
	 * 
	 * @return true of class was loaded, false otherwise
	 */
	public function load($className)
	{
		$fileName = str_replace('_', DS, $className) . '.php';
		
		$paths = array(
			ROOT_PATH . DS . 'Controllers' . DS
		);
		
		foreach ($paths as $path) {
			if (file_exists($path . $fileName)) {
				include_once $path . $fileName;
				return true;
			}
		}
		
		return false;
	}
}