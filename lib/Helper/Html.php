<?php
/**
 * Html.php
 * Acuity_Helper_Html
 *
 * PHP version 5.2.*
 *
 * @category Testing
 * @package  Acuity
 * @author   Mike Bernat <mike@mikebernat.com>
 * @name     Acuity_Helper_Html
 * @license  Private http://www.acuityproject.com/
 * @version  SVN: $Id$
 * @link     http://www.acuityproject.com/
 * @since    .01
 * @created  Jan 28, 2010
 *
 */


/**
 * General html helper
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
class Acuity_Helper_Html extends Acuity_Helper_Abstract
{
    public static $color_current;

    /**
     * Return a formatted a tag
     *
     * @param string $label  Label
     * @param string $href   Href (Link)
     * @param string $title  Title
     * @param string $target Target
     *
     * @return string
     */
    public static function link($label, $href, $title = null, $target='')
    {
        if (!$title) {
            $title = $label;
        }

        return sprintf(
            '<a href="%s" title="%s", target="%s">%s</a>',
        $href,
        $title,
        $target,
        $label
        );
    }

    /**
     * Cycle between two values
     *
     * @param string $color1 Value 1
     * @param string $color2 Value 2
     *
     * @return string
     */
    public static function cycle($color1, $color2 = null)
    {
        if ($color1 == self::$color_current) {
            return self::$color_current = $color2;
        } else {
            return self::$color_current = $color1;
        }
    }
}