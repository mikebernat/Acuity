<?php
/**
 * Breadcrumb.php
 * Acuity_Helper_Breadcrumb
 *
 * PHP version 5.2.*
 *
 * @category Testing
 * @package  Acuity
 * @author   Mike Bernat <mike@mikebernat.com>
 * @name     Acuity_Helper_Breadcrumb
 * @license  Private http://www.acuityproject.com/
 * @version  SVN: $Id$
 * @link     http://www.acuityproject.com/
 * @since    .01
 * @created  Jan 31, 2010
 *
 */


/**
 * Simple breadcrumb class
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
class Acuity_Helper_Breadcrumb extends Acuity_Helper_Abstract
{
    public static $crumbs = array();

    /**
     * Add a breadcrumb to the stack
     *
     * @param string $name Name or label of the crumb
     * @param string $link Link (url)
     *
     * @return void
     */
    public static function add($name, $link)
    {
        self::$crumbs[] = compact('name', 'link');
    }

    /**
     * Return the array of crumbs
     *
     * @return array
     */
    public static function get()
    {
        return self::$crumbs;
    }

    /**
     * Get an array of just the titles
     *
     * @return array
     */
    public static function getTitles()
    {
        $titles = array();
        foreach (self::$crumbs as $crumb) {
            $titles[] = $crumb['name'];
        }

        return $titles;
    }

    public static function clear()
    {
        self::$crumbs = '';
    }

}