<?php

require_once 'PHPUnit/Framework.php';
 
class Library_Form_BeginTest extends PHPUnit_Framework_TestCase
{
	
	public function setUp()
	{

	}
	
	public function tearDown()
	{
		
	}
    
   	public function testInstantiation()
   	{
   		$element = new Acuity_Form_Begin('testBegin');
   		
   		$expected = '<div class="formstart begin " id="formstarttestBegin">' . PHP_EOL . '<form action="" method="POST" name="testBegin">';
   		$this->assertEquals($expected, (string) $element);
   	}
   	
}