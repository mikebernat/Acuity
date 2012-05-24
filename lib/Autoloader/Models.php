<?php
/**
 * Models.php
 * Acuity_Autoloader_Models
 *
 * Model autoloader class
 *
 * PHP version 5.2.*
 *
 * @category Testing
 * @package  Acuity
 * @author   Mike Bernat <mike@mikebernat.com>
 * @name     Acuity_Autoloader_Models
 * @license  Private http://www.acuityproject.com/
 * @version  SVN: $Id$
 * @link     http://www.acuityproject.com/
 * @since    .01
 * @created  Jan 28, 2010
 *
 */
 
 
 /**
 * Autoloads models
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
class Acuity_Autoloader_Models extends Acuity_Autoloader_Loader
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
			ROOT_PATH . DS . 'Models' . DS
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