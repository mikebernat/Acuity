<?php
/**
 * RegistryTest.php
 * Library_AppTest
 *
 * Acuity_App unit tests
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
 
class Library_AppTest extends PHPUnit_Framework_TestCase
{
	
	public function setUp()
	{

	}
	
	public function tearDown()
	{
		
	}
    
   	public function testInstantiation()
   	{
   		$app = new Acuity_App();
   		
   		$this->assertInstanceOf('Acuity_App', $app);
   	}
   	
   	public function testAutoLoader()
   	{
   		$app = new Acuity_App();
   		
   		$app->autoLoader();
   		
   		$this->assertTrue(true);
   	}
   	
   	public function testConfig()
   	{
   		Acuity_Registry::clearInstance();
   		
   		$app = new Acuity_App();
   		
   		$app->config();
   		
   		$this->assertInstanceOf('Acuity_Config', Acuity_Registry::get('config'));
   	}
   	
   	public function testDebug()
   	{
   		Acuity_Registry::clearInstance();
   		
   		$config = Acuity_Registry::get('config');
   		$config->debug = true;
   		Acuity_Registry::set('config', $config);
   		$app = new Acuity_App();
   		
   		$app->debug();
   		
   		$this->assertTrue((bool) ini_get('display_errors'));
   		
   		$config->debug = false;
   		Acuity_Registry::set('config', $config);
   		
   		$app->debug();
   		
   		$this->assertFalse((bool) ini_get('display_errors'));
   	}
   	
   	public function testRequest()
   	{
   		$this->markTestSkipped('This test needs to be refactored. The dispatch method got much more complicated');
   		$_SERVER['REQUEST_URI'] = '/testcontroller/testaction';
   		
   		Acuity_Request::clearInstance();
   		$app = new Acuity_App();
   		
   		$result = $app->dispatch();
   		
   		$this->assertTrue(!empty($result));
   	}
   	
}

class Controllers_Testcontroller extends Acuity_Controller_Abstract
{
	public function testaction()
	{
		
	}
}
