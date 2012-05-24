<?php

require_once 'PHPUnit/Framework.php';
 
class Library_Form_TextTest extends PHPUnit_Framework_TestCase
{
	
	public function setUp()
	{

	}
	
	public function tearDown()
	{
		
	}
    
   	public function testInstantiation()
   	{
   		$element = new Acuity_Form_Text('testText');
   		
   		$expected = '<div class="formfield text  required" id="formtestText">'
   			 . PHP_EOL . 
   			 '<label for="inputtestText">testText</label>'
   			 . PHP_EOL . 
   			 '<input type="text" id="inputtestText" value="" name="testText" />'
   			 . PHP_EOL .
   			 '</div>'
   			 . PHP_EOL;
   		$this->assertEquals($expected, (string) $element);
   	}
   	
   	public function testBefore()
   	{
   		$options = array('before' => 'testBefore');
   		$element = new Acuity_Form_Text('testText', $options);
   		
   		$expected = '<div class="formfield text  required" id="formtestText">'
   			 . PHP_EOL . 
   			 '<span class="before">testBefore</span>'
   			 . PHP_EOL . 
   			 '<label for="inputtestText">testText</label>'
   			 . PHP_EOL . 
   			 '<input type="text" id="inputtestText" value="" name="testText" />'
   			 . PHP_EOL . 
   			 '</div>'
   			 . PHP_EOL;
   		$this->assertEquals($expected, (string) $element);
   	}
   	
   	public function testAfter()
   	{
   		$options = array('after' => 'testAfter');
   		$element = new Acuity_Form_Text('testText', $options);
   		
   		$expected = '<div class="formfield text  required" id="formtestText">'
   			 . PHP_EOL . 
   			 '<label for="inputtestText">testText</label>'
   			 . PHP_EOL . 
   			 '<input type="text" id="inputtestText" value="" name="testText" />'
   			 . PHP_EOL .
   			 '<span class="after">testAfter</span>'
   			  . PHP_EOL .  
   			 '</div>'
   			 . PHP_EOL;
   		$this->assertEquals($expected, (string) $element);
   	}
   	
}