<?php

require_once 'PHPUnit/Framework.php';
 
class Library_Helper_HtmlTest extends PHPUnit_Framework_TestCase
{
	
	public function setUp()
	{

	}
	
	public function tearDown()
	{

	}
	
	public function testCycle()
	{
		$result = Acuity_Helper_Html::cycle('even', 'odd');
		
		$this->assertEquals('even', $result);
		
		$result = Acuity_Helper_Html::cycle('even', 'odd');
		
		$this->assertEquals('odd', $result);
	}
	
	public function testLink()
	{
		$result = Acuity_Helper_Html::link('testLabel', '/href');
		
		$expected = '<a href="/href" title="testLabel", target="">testLabel</a>';
		$this->assertEquals($expected, $result);
	}
}