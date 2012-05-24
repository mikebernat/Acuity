<?php
/**
 * Multiselect.php
 * Acuity_Form_Multiselect
 *
 * PHP version 5.2.*
 *
 * @category Testing
 * @package  Acuity
 * @author   Mike Bernat <mike@mikebernat.com>
 * @name     Acuity_Form_Multiselect
 * @license  Private http://www.acuityproject.com/
 * @version  SVN: $Id$
 * @link     http://www.acuityproject.com/
 * @since    .01
 * @created  Jan 30, 2010
 *
 */
 
 
 /**
 * Multi-select form element
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
class Acuity_Form_Multiselect extends Acuity_Form_Abstract
{
	
	/**
	 * Constructor
	 * 
	 * @param string $name    Name of the element
	 * @param array  $data    Data for the element
	 * @param array  $options Options
	 * 
	 * @return void
	 */
	public function __construct($name, $data, $options = array())
	{
		$options_default = array(
			'label'		=> $name,
			'required'	=> true,
			'error'		=> false,
			'before'	=> false,
			'after'		=> false,
			'class'		=> '',
			'id'		=> 'form' . $name,
			'value'		=> '',
			'inputid'	=> 'input' . $name,
			'name'		=> $name,
		);
		
		$options = array_merge($options_default, $options);
		
		$output = array();
		
		$output[] = sprintf(
			'<div class="formfield multiselect %s %s" id="%s">', 
			$options['class'], 
			($options['required']) ? 'required' : '', 
			$options['id']
		);
							
		if ($options['before']) {
			$output[] = sprintf(
				'<span class="before">%s</span>', 
				$options['before']
			);
		}
		
		$output[] = sprintf(
			'<label for="%s">%s</label>', 
			$options['inputid'], 
			$options['label']
		);
		
		$output[] = sprintf(
			'<select multiple="multiple" id="%s" name="%s[]" >', 
			$options['inputid'],
			$options['name']
		);
		
		foreach ($data as $values) {
			$output[] = sprintf(
				'<option value="%s" %s>%s</option>',
				$values['value'],
				@($values['selected']) ? 'selected="selected"' : '',
				@($values['name']) ? $values['name'] : $values['value']
			);
		}
		
		$output[] = sprintf(
			'</select>'
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