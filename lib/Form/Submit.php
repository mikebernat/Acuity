<?php
/**
 * Submit.php
 * Acuity_Form_Submit
 *
 * PHP version 5.2.*
 *
 * @category Testing
 * @package  Acuity
 * @author   Mike Bernat <mike@mikebernat.com>
 * @name     Acuity_Form_Submit
 * @license  Private http://www.acuityproject.com/
 * @version  SVN: $Id$
 * @link     http://www.acuityproject.com/
 * @since    .01
 * @created  Jan 28, 2010
 *
 */


/**
 * Generate a submit form element
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
class Acuity_Form_Submit extends Acuity_Form_Abstract
{
    /**
     * Add a submit form element
     *
     * @param string $name    Name of element
     * @param array  $options Options
     *
     * @return unknown_type
     */
    public function __construct($name = null, $options = array())
    {
        $options_default = array(
            'before'    => false,
            'after'        => false,
            'class'        => '',
            'id'        => 'form' . $name,
            'value'        => 'Submit',
            'name'        => 'input' . $name,
        );

        $options = array_merge($options_default, $options);

        $output = array();

        $output[] = sprintf(
            '<div class="formfield submit %s" id="%s">', 
        $options['class'],
        $options['id']
        );

        if ($options['before']) {
            $output[] = sprintf(
                '<span class="before">%s</span>', 
            $options['before']
            );
        }

        $output[] = sprintf(
            '<input type="submit" id="%s" value="%s" />', 
        $options['name'],
        $options['value']
        );

        if ($options['after']) {
            $output[] = sprintf(
                '<span class="after">%s</span>', 
            $options['after']
            );
        }

        $output[] = '</div>' . PHP_EOL;

        $this->output = implode(PHP_EOL, $output);
    }
}