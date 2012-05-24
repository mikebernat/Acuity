<?php

require_once 'PHPUnit/Framework.php';

class Library_Db_RequestTest extends PHPUnit_Framework_TestCase
{
	public $original_uri;
	
	public function setUp()
	{
		$this->original_uri = @$_SERVER['REQUEST_URI'];
	}
	
	public function tearDown()
	{
		$_SERVER['REQUEST_URI'] = $this->original_uri;
	}
	
	public function testParseEmptyUri()
   	{
   		$_SERVER['REQUEST_URI'] = '';
   		
   		$request = new Acuity_Request();
   		
   		$this->assertEquals('index', $request->getController());
   		$this->assertEquals('index', $request->getAction());
   	}
    
   	public function testParseNearlyEmptyUri()
   	{
   		$_SERVER['REQUEST_URI'] = '/';
   		
   		$request = new Acuity_Request();
   		
   		$this->assertEquals('index', $request->getController() );
   		$this->assertEquals('index', $request->getAction() );
   	}
   	
	public function testParseControllerUri()
   	{
   		$_SERVER['REQUEST_URI'] = '/page';
   		
   		$request = new Acuity_Request();
   		
   		$this->assertEquals('page', $request->getController() );
   		$this->assertEquals('index', $request->getAction() );
   	}
   	
	public function testParseControllerActionUri()
   	{
   		$_SERVER['REQUEST_URI'] = '/page/view/';
   		
   		$request = new Acuity_Request();
   		
   		$this->assertEquals('page', $request->getController() );
   		$this->assertEquals('view', $request->getAction() );
   	}
   	
	public function testParseControllerActionParamsUri()
   	{
   		$_SERVER['REQUEST_URI'] = '/page/view/param1/1/param2/2';
   		
   		$request = new Acuity_Request();
   		
   		$this->assertEquals('page', $request->getController() );
   		$this->assertEquals('view', $request->getAction() );
   	}
   	
   	public function testParseParamsUri()
   	{
   		$_SERVER['REQUEST_URI'] = '/page/view/param1/1/param2/2';
   		
   		$request = new Acuity_Request();
   		
   		$this->assertEquals('1', $request->getParam('param1') );
   		$this->assertEquals('2', $request->getParam('param2') );
   	}
   	
	public function testParseNonExistantParamUri()
   	{
   		$_SERVER['REQUEST_URI'] = '/page/view/param1/1/param2/2';
   		
   		$request = new Acuity_Request();
   		
   		$this->assertNull( $request->getParam('notExists') );
   	}
   	
	public function testParseParamDefaultUri()
   	{
   		$_SERVER['REQUEST_URI'] = '/page/view/param1/1/param2/2';
   		
   		$request = new Acuity_Request();
   		
   		$this->assertEquals('default', $request->getParam('notExists', 'default') );
   	}
   	
	public function testParseMalformedParamsUri()
   	{
   		$_SERVER['REQUEST_URI'] = '/page/view/param1/1/param2/2/malformed';
   		
   		$request = new Acuity_Request();
   		
   		$this->assertNull( $request->getParam('malformed') );
   	}
   	
	public function testParseDuplicateParamsUri()
   	{
   		$_SERVER['REQUEST_URI'] = '/page/view/param1/1/param2/2/param2/5';
   		
   		$request = new Acuity_Request();
   		
   		$this->assertEquals(5, $request->getParam('param2') );
   	}
   	
   	public function testSingleton()
   	{
		$_SERVER['REQUEST_URI'] = '/page/view/param1/1/param2/2/param2/5';

   		$result = Acuity_Request::getInstance();
   		
   		$this->assertType('Acuity_Request', $result);
   	}
}
