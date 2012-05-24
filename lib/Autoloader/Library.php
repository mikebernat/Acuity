<?php
/**
 * Library.php
 * Acuity_Autoloader_Library
 *
 * Library Autoloader class
 *
 * PHP version 5.2.*
 *
 * @category Testing
 * @package  Acuity
 * @author   Mike Bernat <mike@mikebernat.com>
 * @name     Acuity_Autoloader_Library
 * @license  Private http://www.acuityproject.com/
 * @version  SVN: $Id$
 * @link     http://www.acuityproject.com/
 * @since    .01
 * @created  Jan 28, 2010
 *
 */


/**
 * Autoloads library files
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
class Acuity_Autoloader_Library extends Acuity_Autoloader_Loader
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
        $className = preg_replace('/^Acuity_/', '', $className);
        $fileName = str_replace('_', DS, $className) . '.php';

        $paths = array(
        dirname(dirname(__FILE__)) . DS
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