<?php

require_once 'PHPUnit/Framework.php';

class Library_Db_FactoryTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		if (!extension_loaded('pdo_sqlite')) {
			$this->markTestSkipped('Sqlite pdo extension not installed');
		}
	}
	
	public function tearDown()
	{
		
	}
    
   	public function testSqliteInstantiation()
   	{
   		$config = array(
   			'driver' => 'sqlite',
   			'file'	 =>	':memory:',
   		);
   		
   		$result = Acuity_Db_Factory::load($config);
   		
   		$this->assertType('Acuity_Db_Abstract', $result);
   		$this->assertType('Acuity_Db_Driver', $result);
   	}
   	
   	/**
   	 * 
   	 * @expectedException Acuity_Db_Exception
   	 */
   	public function testNonExistingDriver()
   	{
   		$config = array(
   			'driver' => 'jibberish',
   		);
   		
   		$result = Acuity_Db_Factory::load($config);
   	}
   	
	/**
   	 * 
   	 * @expectedException Acuity_Db_Exception
   	 */
   	public function testNullDriver()
   	{
   		$config = array(

   		);
   		
   		$result = Acuity_Db_Factory::load($config);
   	}
   	
	/**
   	 * 
   	 * @expectedException Acuity_Db_Exception
   	 */
   	public function testExistingDriverNullFileDriver()
   	{
   		$config = array(
   			'driver' => 'sqlite',
   		);
   		
   		$result = Acuity_Db_Factory::load($config);
   	}
}