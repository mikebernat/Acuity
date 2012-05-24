<?php

require_once 'PHPUnit/Framework.php';
 
class Library_Helper_BreadcrumbTest extends PHPUnit_Framework_TestCase
{
	
	public function setUp()
	{

	}
	
	public function tearDown()
	{
		Acuity_Helper_Breadcrumb::clear();
	}
    
   	public function testBreadcrumb()
   	{
   		Acuity_Helper_Breadcrumb::add('test', '/testlink');
   		
   		$result = Acuity_Helper_Breadcrumb::get();
   		
   		$this->assertEquals(array(array('name' => 'test', 'link' => '/testlink')), $result);
   	}
   	
   	
   	public function testBreadcrumbTitles()
   	{
   		Acuity_Helper_Breadcrumb::add('test', '/testlink');
   		
   		$result = Acuity_Helper_Breadcrumb::getTitles();
   		
   		$this->assertEquals(array('test'), $result);
   	}
   	
}