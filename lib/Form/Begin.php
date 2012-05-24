<?php
/**
 * Begin.php
 * Acuity_Form_Begin
 *
 * PHP version 5.2.*
 *
 * @category Testing
 * @package  Acuity
 * @author   Mike Bernat <mike@mikebernat.com>
 * @name     Acuity_Form_Begin
 * @license  Private http://www.acuityproject.com/
 * @version  SVN: $Id$
 * @link     http://www.acuityproject.com/
 * @since    .01
 * @created  Jan 28, 2010
 *
 */


/**
 * Output the start of a form
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
class Acuity_Form_Begin extends Acuity_Form_Abstract
{

    /**
     * Starts a form
     *
     * @param string $name    Name of the form
     * @param array  $options Options
     *
     * @return void
     */
    public function __construct($name, $options = array())
    {
        $options_default = array(
            'class'        => '',
            'id'        => 'formstart' . $name,
            'action'    => '',
            'method'    => 'POST',
        );

        $options = array_merge($options_default, $options);

        $output = array();

        $output[] = sprintf(
            '<div class="formstart begin %s" id="%s">', 
        $options['class'],
        $options['id']
        );

        $output[] = sprintf(
            '<form action="%s" method="%s" name="%s">',
        $options['action'],
        $options['method'],
        $name
        );

        $this->output = implode(PHP_EOL, $output);
    }
}