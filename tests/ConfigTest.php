<?php
/**
 * ConfigTest.php
 * Library_ConfigTest
 * 
 * 
 * Acuity_Library unit tests
 *
 * PHP version 5.2.*
 *
 * @author       Mike Bernat <mike@mikebernat.com>
 * @since		 Jan 7, 2010
 * @name         Acuity_Library unit tests
 * @package      Acuity
 * 
 * 
 * See Git repository for a changelog
 */

require_once 'PHPUnit/Framework.php';
 
class Library_ConfigTest extends PHPUnit_Framework_TestCase
{
	private $_testConfigPath;
	
	public function setUp()
	{
		$config = <<<CONFIG
[application]
site = acuity
debug = true;
CONFIG;

		$this->_testConfigPath = ROOT_PATH . DS . 'tmp' . DS . 'test_config.ini';

		file_put_contents($this->_testConfigPath, $config);
	}
	
	public function tearDown()
	{
		unlink($this->_testConfigPath);
	}
	
    public function testConstructor()
    {
    	$config = new Acuity_Config($this->_testConfigPath);
    	
    	$this->assertInstanceOf('Acuity_Config', $config, 'instance returned was not of type Acuity_Config');
    }
    
    /**
     * @expectedException Acuity_Exception
     */
    public function testUnreadibleFile()
    {
    	$config = new Acuity_Config(uniqid());
    }
    
	/**
     * @expectedException Acuity_Exception
     */
    public function testNoFilePassed()
    {
    	$config = new Acuity_Config(NULL);
    }
    
    public function testExistingGet()
    {
    	$config = new Acuity_Config($this->_testConfigPath);
    	
    	$result = $config->get('site');
    	
    	$this->assertEquals('acuity', $result);
    }
    
    public function testNonExistingGet()
    {
    	$config = new Acuity_Config($this->_testConfigPath);
    	
    	$result = $config->get('doesNotExist');
    	
    	$this->assertNull($result);
    }
}