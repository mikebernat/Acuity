<?php

require_once 'PHPUnit/Framework.php';
 
class Library_Form_HiddenTest extends PHPUnit_Framework_TestCase
{
	
	public function setUp()
	{

	}
	
	public function tearDown()
	{
		
	}
    
   	public function testInstantiation()
   	{
   		$element = new Acuity_Form_Hidden('testHidden');
   		
   		$expected = '<input type="hidden" name="testHidden" id="inputtestHidden" value="" />';
   		$this->assertEquals($expected, (string) $element);
   	}
   	
}