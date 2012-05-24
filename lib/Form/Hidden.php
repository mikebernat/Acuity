<?php
/**
 * Hidden.php
 * Acuity_Form_Hidden
 *
 * PHP version 5.2.*
 *
 * @category Testing
 * @package  Acuity
 * @author   Mike Bernat <mike@mikebernat.com>
 * @name     Acuity_Form_Hidden
 * @license  Private http://www.acuityproject.com/
 * @version  SVN: $Id$
 * @link     http://www.acuityproject.com/
 * @since    .01
 * @created  Jan 28, 2010
 *
 */


/**
 * Generate a hidden form element
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
class Acuity_Form_Hidden extends Acuity_Form_Abstract
{
    /**
     * Adds a hidden form element
     *
     * @param string $name    Name of element
     * @param array  $options Options
     *
     * @return void
     */
    public function __construct($name, $options = array())
    {
        $options_default = array(
            'value'        => '',
            'inputid'    => 'input' . $name,
        );

        $options = array_merge($options_default, $options);

        $output = array();

        $output[] = sprintf(
            '<input type="hidden" name="%s" id="%s" value="%s" />',
        $name,
        $options['inputid'],
        $options['value']
        );


        $this->output = implode(PHP_EOL, $output);
    }
}