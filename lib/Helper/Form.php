<?php
/**
 * Form.php
 * Acuity_Helper_Form
 *
 * PHP version 5.2.*
 *
 * @category Testing
 * @package  Acuity
 * @author   Mike Bernat <mike@mikebernat.com>
 * @name     Acuity_Helper_Form
 * @license  Private http://www.acuityproject.com/
 * @version  SVN: $Id$
 * @link     http://www.acuityproject.com/
 * @since    .01
 * @created  Jan 28, 2010
 *
 */


/**
 * Form helper
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
class Acuity_Helper_Form extends Acuity_Helper_Abstract
{
    public $elements = array();

    /**
     * Start a new form
     *
     * @param Acuity_Model_Entity $model If passed, the form will
     *                                      auto-magically be created
     *
     * @return void
     */
    public function __construct(Acuity_Model_Entity $model = null)
    {
        if ($model) {
            $fields = $model->getData();

            if (empty($fields)) {
                $fields = $model->getFields();
                $fields = array_flip($fields);
                foreach ($fields as $key => $value) {
                    $fields[$key] = '';
                }
            }

            $elements = array();
            $elements[] = new Acuity_Form_Begin(get_class($model));
            foreach ($fields as $name => $value) {
                if ($name == 'id') {
                    $elements[] = new Acuity_Form_Hidden(
                    $name,
                    array(
                            'value' => $value
                    )
                    );
                } else {
                    $elements[] = new Acuity_Form_Text(
                    $name,
                    array('value' => $value)
                    );
                }
            }
            $elements[] = new Acuity_Form_Submit(null);
            $elements[] = new Acuity_Form_End(null);

            $this->elements = $elements;
        }
    }

    /**
     * Loops through all auto-magically created elements and return them
     *
     * @return string
     */
    public function __toString()
    {
        $output = '';
        foreach ($this->elements as $element) {
            $output .= $element->__toString();
        }

        return $output;
    }

    /**
     * Return a begin element
     *
     * @param string $name    Element name
     * @param array  $options Options
     *
     * @return Acuity_Form_Begin
     */
    public function begin($name, $options = array())
    {
        return new Acuity_Form_Begin($name, $options);
    }

    /**
     * Return a hidden element
     *
     * @param string $name    Element name
     * @param array  $options Options
     *
     * @return Acuity_Form_Hidden
     */
    public function hidden($name, $options = array())
    {
        return new Acuity_Form_Hidden($name, $options);
    }

    /**
     * Return a new text element
     *
     * @param string $name    Name of element
     * @param array  $options Options
     *
     * @return Acuity_Form_Text
     */
    public function text($name, $options = array())
    {
        return new Acuity_Form_Text($name, $options);
    }

    /**
     * Add a submit element
     *
     * @param string $name    Name
     * @param array  $options Options
     *
     * @return void
     */
    public function submit($name = 'Submit', $options = array())
    {
        return new Acuity_Form_Submit($name, $options);
    }

    /**
     * Ends a form
     *
     * @param string $name    Name
     * @param array  $options Options
     *
     * @return Acuity_Form_End
     */
    public function end($name = null, $options = array())
    {
        return new Acuity_Form_End($name, $options);
    }

    /**
     * Added a multiselect element
     *
     * @param string $name    Name
     * @param array  $data    Data
     * @param array  $options Options
     *
     * @return Acuity_Form_Multiselect
     */
    public function multiselect($name, $data, $options = array())
    {
        return new Acuity_Form_Multiselect($name, $data, $options);
    }

    /**
     * Added a Select element
     *
     * @param string $name    Name
     * @param array  $data    Data
     * @param array  $options Options
     *
     * @return Acuity_Form_Select
     */
    public function select($name, $data, $options = array())
    {
        return new Acuity_Form_Select($name, $data, $options);
    }
}