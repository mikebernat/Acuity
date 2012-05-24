<?php
/**
 * View.php
 * Acuity_View
 *
 * View object
 *
 * PHP version 5.2.*
 *
 * @category Testing
 * @package  Acuity
 * @author   Mike Bernat <mike@mikebernat.com>
 * @name     Acuity_View
 * @license  Private http://www.acuityproject.com/
 * @version  SVN: $Id$
 * @link     http://www.acuityproject.com/
 * @since    .01
 *
 */


/**
 * View Object
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
class Acuity_View
{
    private $_viewVars = array();

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->_setScriptPaths();
    }

    /**
     * Set script paths
     *
     * @return void
     */
    private function _setScriptPaths()
    {
        set_include_path(ROOT_PATH . PATH_SEPARATOR . get_include_path());
        set_include_path(
        ROOT_PATH . DS . 'views' . PATH_SEPARATOR . get_include_path()
        );
    }

    /**
     * Setter
     *
     * @param string $name  Name
     * @param mixed  $value Value
     *
     * @return void
     */
    public function __set($name, $value)
    {
        $this->_viewVars[$name] = $value;
    }

    /**
     * Render a script
     *
     * @param string $name Name of template
     *
     * @return string output of template
     */
    public function render($name)
    {

        extract($this->_viewVars);

        ob_start();
        include_once $name;
        $result = ob_get_clean();

        return $result;
    }
}