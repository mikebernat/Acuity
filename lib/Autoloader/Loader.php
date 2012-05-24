<?php
/**
 * Loader.php
 * Acuity_Autoloader_Loader
 *
 * Abstract autoloader
 *
 * PHP version 5.2.*
 *
 * @category Testing
 * @package  Acuity
 * @author   Mike Bernat <mike@mikebernat.com>
 * @name     Acuity_Autoloader_Loader
 * @license  Private http://www.acuityproject.com/
 * @version  SVN: $Id$
 * @link     http://www.acuityproject.com/
 * @since    .01
 * @created  Jan 28, 2010
 *
 */


/**
 * Abstract autoloader
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
abstract class Acuity_Autoloader_Loader
{
    /**
     * Given a className, attempts to find and include its file
     *
     * @param string $className The class to include
     *
     * @return boolean true on success or failure
     */
    public abstract function load($className);
}