<?php
/**
 * RegistryTest.php
 * Library_RegistryTest
 *
 * Acuity_Registry unit tests
 *
 * PHP version 5.2.*
 *
 * @author       Mike Bernat <mike@mikebernat.com>
 * @since		 Jan 7, 2010
 * @name         Library_RegistryTest
 * @package      Acuity
 * 
 * 
 * See Git repository for a changelog
 */

require_once 'PHPUnit/Framework.php';
 
class Library_RegistryTest extends PHPUnit_Framework_TestCase
{
	
	public function setUp()
	{
		
	}
	
	public function tearDown()
	{
		// Clear the registry
		Acuity_Registry::clearInstance();
	}
    
   	public function testInstantiation()
   	{
   		$registry = Acuity_Registry::getInstance();
   		
   		$this->assertType('Acuity_Registry', $registry);
   	}
   	
   	public function testStoringValue()
   	{
   		Acuity_Registry::set('varName', 'testValue');
   		
   		$result = Acuity_Registry::get('varName');
   		
   		$this->assertEquals($result, 'testValue');
   	}
   	
   	public function testDefaultValue()
   	{
   		$result = Acuity_Registry::get('varName', 'defaultValue');
   		
   		$this->assertEquals($result, 'defaultValue');
   	}
   	
   	public function testNoValueNoDefault()
   	{
   		$result = Acuity_Registry::get('varName');
   		
   		$this->assertNull($result);
   	}
   	
   	/**
   	 * 
   	 * @expectedException Acuity_Exception
   	 */
   	public function testNoClone()
   	{
   		clone Acuity_Registry::getInstance();
   	}
}
