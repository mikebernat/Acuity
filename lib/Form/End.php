<?php
/**
 * End.php
 * Acuity_Form_End
 *
 * PHP version 5.2.*
 *
 * @category Testing
 * @package  Acuity
 * @author   Mike Bernat <mike@mikebernat.com>
 * @name     Acuity_Form_End
 * @license  Private http://www.acuityproject.com/
 * @version  SVN: $Id$
 * @link     http://www.acuityproject.com/
 * @since    .01
 * @created  Jan 28, 2010
 *
 */


/**
 * Close a form
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
class Acuity_Form_End extends Acuity_Form_Abstract
{

    /**
     * Close a form
     *
     * @param string $name    Not used
     * @param array  $options Options
     *
     * @return void
     */
    public function __construct($name = null, $options = array())
    {
        $options_default = array(
        );

        $options = array_merge($options_default, $options);

        $output = array();

        $output[] = '</form>';
        $output[] = '</div>';


        $this->output = implode(PHP_EOL, $output);
    }
}