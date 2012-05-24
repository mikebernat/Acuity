<?php

require_once 'PHPUnit/Framework.php';
 
class Library_Form_EndTest extends PHPUnit_Framework_TestCase
{
	
	public function setUp()
	{

	}
	
	public function tearDown()
	{
		
	}
    
   	public function testInstantiation()
   	{
   		$element = new Acuity_Form_End();
   		
   		$expected = '</form>' . PHP_EOL . '</div>';
   		$this->assertEquals($expected, (string) $element);
   	}
   	
}