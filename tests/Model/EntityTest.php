<?php

require_once 'PHPUnit/Framework.php';
 
class Library_Model_EntityTest extends PHPUnit_Framework_TestCase
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
    
   	public function testSaveUpdate()
   	{
   		$config = array(
   			'driver' => 'sqlite',
   			'file'	 =>	':memory:',
   		);
   		
   		$dbMock = $this->getMock('Acuity_Db_Driver', array('update'), array(sprintf('sqlite:%s', $config['file'])));
   		$dbMock->expects($this->once())
   				->method('update')
   				->will($this->returnValue('a sql statement'));
   				
   		$model = new Acuity_Model_Entity_Test();
   		$model->setDb($dbMock);
   		$model->id = 1;
   		
   		$result = $model->save(array('dummy' => 'data'));
   		
   		$this->assertTrue($result);
   	}
   	
	public function testSaveUpdateBad()
   	{
   		$config = array(
   			'driver' => 'sqlite',
   			'file'	 =>	':memory:',
   		);
   		
   		$dbMock = $this->getMock('Acuity_Db_Driver', array('update'), array(sprintf('sqlite:%s', $config['file'])));
   		$dbMock->expects($this->once())
   				->method('update')
   				->will($this->returnValue(FALSE));
   				
   		$model = new Acuity_Model_Entity_Test();
   		$model->setDb($dbMock);
   		$model->id = 1;
   		
   		$result = $model->save(array('dummy' => 'data'));
   		
   		$this->assertFalse($result);
   	}
   	
   	public function testSaveInsert()
   	{
   		$config = array(
   			'driver' => 'sqlite',
   			'file'	 =>	':memory:',
   		);
   		
   		$dbMock = $this->getMock('Acuity_Db_Driver', array('insert', 'lastInsertId'), array(sprintf('sqlite:%s', $config['file'])));
   		$dbMock->expects($this->once())
   				->method('insert')
   				->will($this->returnValue('a sql statement'));
   		$dbMock->expects($this->once())
   				->method('lastInsertId')
   				->will($this->returnValue('1'));
   				
   		$model = new Acuity_Model_Entity_Test();
   		$model->setDb($dbMock);
   		
   		$result = $model->save(array('dummy' => 'data'));
   		
   		$this->assertTrue($result);
   		$this->assertTrue(is_numeric($model->id));
   	}
   	
   	public function testSaveInsertBad()
   	{
   		$config = array(
   			'driver' => 'sqlite',
   			'file'	 =>	':memory:',
   		);
   		
   		$dbMock = $this->getMock('Acuity_Db_Driver', array('insert', 'lastInsertId'), array(sprintf('sqlite:%s', $config['file'])));
   		
   		$dbMock->expects($this->once())
   				->method('insert')
   				->will($this->returnValue(FALSE));
   				
   		$dbMock->expects($this->once())
   				->method('lastInsertId')
   				->will($this->returnValue(FALSE));
   				
   		$model = new Acuity_Model_Entity_Test();
   		$model->setDb($dbMock);
   		
   		$result = $model->save(array('dummy' => 'data'));
   		
   		$this->assertFalse($result);
   		$this->assertFalse($model->id);
   	}
   	
   	public function testGetOptions()
   	{
   		$model = new Acuity_Model_Entity_Test(false, array('test'));
   		
   		$result = $model->getOptions();
   		
   		$this->assertTrue(!empty($result));
   	}
   	
   	public function testLoad()
   	{
   		$config = array(
   			'driver' => 'sqlite',
   			'file'	 =>	':memory:',
   		);
   				
   		$model = new Acuity_Model_Entity_Test(1);
   		
   		$result = $model->id;
   		
   		$this->assertEquals('value', $result);
   	}
   	
	public function testCustomGettersSetters()
   	{
   		$config = array(
   			'driver' => 'sqlite',
   			'file'	 =>	':memory:',
   		);
   				
   		$model = new Acuity_Model_Entity_Test(1);
   		
   		$model->name = 'testName';

   		$result = $model->name;
   		
   		$this->assertEquals('testName', $result);
   	}
   	
   	public function testGetData()
   	{
   		$model = new Acuity_Model_Entity_Test(1);
   		
   		$result = $model->getData();
   		
   		$this->assertTrue(!empty($result));   		
   	}
   	
   	public function testGetFields()
   	{
   		$model = new Acuity_Model_Entity_Test(1);
   		
   		$result = $model->getFields();
   		
   		$this->assertTrue(!empty($result));   
   	}
}

class Acuity_Model_Entity_Test extends Acuity_Model_Entity 
{
	public $fields = array('id');
	
	public function getSelect($primaryKey, $options = array())
	{
		return new Acuity_Db_Select_Test();
	}
	
	public function setDb($db)
	{
		$this->db = $db;
	}

	public function setName($name)
	{
		$this->data['name'] = $name;
	}
	
	public function getName()
	{
		return $this->data['name'];
	}
	
}

class Acuity_Db_Select_Test extends Acuity_Db_Select
{
	public function __construct()
	{
		
	}
	
	public function query()
	{
		return $this;
	}
	
	public function fetch($mode)
	{
		return array('id' => 'value', 'name' => 'value');
	}
}