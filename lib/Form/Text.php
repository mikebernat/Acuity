<?php
/**
 * Text.php
 * Acuity_Form_Text
 *
 * PHP version 5.2.*
 *
 * @category Testing
 * @package  Acuity
 * @author   Mike Bernat <mike@mikebernat.com>
 * @name     Acuity_Form_Text
 * @license  Private http://www.acuityproject.com/
 * @version  SVN: $Id$
 * @link     http://www.acuityproject.com/
 * @since    .01
 * @created  Jan 28, 2010
 *
 */
 
 
 /**
 * Generate a form text input element
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
class Acuity_Form_Text extends Acuity_Form_Abstract
{
	/**
	 * Adds a text input element
	 * 
	 * @param string $name    Name of the input element
	 * @param array  $options Options
	 * 
	 * @return void
	 */
	public function __construct($name, $options = array())
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
			'<div class="formfield text %s %s" id="%s">', 
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
			'<input type="text" id="%s" value="%s" name="%s" />', 
			$options['inputid'],
			$options['value'],
			$options['name']
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