<?php
/**
 * Import.php
 * Acuity_Import
 *
 * Acuity Import
 *
 * PHP version 5.2.*
 *
 * @category Testing
 * @package  Acuity
 * @author   Mike Bernat <mike@mikebernat.com>
 * @name     Acuity_Import
 * @license  Private http://www.acuityproject.com/
 * @version  SVN: $Id$
 * @link     http://www.acuityproject.com/
 * @since    .01
 *
 */


/**
 * Autoloader-type object. Seeks out and includes files given a class name.
 *
 * Has the capacity to add autoloaders for custom inclusion logic.
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
class Acuity_Import
{

    // @TODO cache paths

    protected $autoloaders = array();

    public static $instance;

    /**
     * Singleton instance
     *
     * @return Acuity_Import
     */
    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new Acuity_Import();
        }

        return self::$instance;
    }


    /**
     * Load file containing the given class
     *
     * @param string $className Name of class
     *
     * @return boolean true on success
     */
    public function load($className)
    {
        if (empty($this->autoloaders)) {
            throw new Exception('No autoloaders present.');
        }

        foreach ($this->autoloaders as $loader) {
            if ($loader->load($className)) {
                return true;
            }
        }

        include_once dirname(__FILE__) . DS .'Exception.php';

        throw new Acuity_Exception('Failed loading class ' . $className);
    }

    /**
     * Add an autoloader to the stack
     *
     * @param Acuity_Autoloader_Loader $loader Autoloader
     *
     * @return void
     */
    public function addLoader(Acuity_Autoloader_Loader $loader)
    {
        $this->autoloaders[] = $loader;
    }
}