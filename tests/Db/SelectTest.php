<?php

require_once 'PHPUnit/Framework.php';

class Library_Db_SelectTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		if (!extension_loaded('pdo_sqlite')) {
			$this->markTestSkipped('Sqlite pdo extension not installed');
		}
		
		$config = array(
   			'driver' => 'sqlite',
   			'file'	 =>	':memory:',
   		);
   		
   		$this->db = Acuity_Db_Factory::load($config);
   		$this->select = new Library_Db_SelectTester($this->db);
	}
	
	public function tearDown()
	{
		
	}
    
   	public function testBlankSelectAssembly()
   	{
   		$result = $this->select;
   		
   		$this->assertType('Acuity_Db_Select', $result);
   	}
   	
	public function testSimpleAssembly()
   	{
   		$result = $this->select->from('sites')
								->joinLeft('links_sites', 'sites.id = links_sites.site_id', array('id', 'u' => 'url'))
								->where('sites.id = ?', 1);

		$this->assertType('Acuity_Db_Select', $result);
		
		$expected = 'SELECT sites.*,links_sites.id,links_sites.url as u FROM sites LEFT JOIN links_sites ON sites.id = links_sites.site_id WHERE sites.id = ?';
		$this->assertEquals($expected, $this->select->assemble());
   	}
   	
   	public function testSimplerAssembly()
   	{
   		$result = $this->select->from('sites')
								->join('links_sites', 'sites.id = links_sites.site_id', array('id', 'u' => 'url'))
								->where('sites.id = ?', 1)
								->limit(1)
								->order('sites.name asc');

		$this->assertType('Acuity_Db_Select', $result);
		
		$expected = 'SELECT sites.*,links_sites.id,links_sites.url as u FROM sites INNER JOIN links_sites ON sites.id = links_sites.site_id WHERE sites.id = ? ORDER BY sites.name asc LIMIT 1';
		$this->assertEquals($expected, $this->select->assemble());
   	}
   	
	public function testComplexAssembly()
   	{
   		$result = $this->select->from(array('tableAlias' => 'table'))
   								->join('join1', 'tableAlias.id = join1.table_id', array('field1', 'field2'))
   								->join(array('joinAlias' => 'join2'), 'joinAlias.id = join1.joinAlias_id', array('fieldAlias1' => 'field1', 'field2'))
   								->where('id = ?', 5)
   								->where('name = ?', '6')
   								->where('type = ?', 'strict')
   								->group('id')
   								->order('name')
   								->order('value')
   								->limit('15');

   		$this->assertType('Acuity_Db_Select', $result);
   		
   		$expected = 'SELECT tableAlias.*,join1.field1,join1.field2,joinAlias.field1 as fieldAlias1,joinAlias.field2 FROM table as tableAlias INNER JOIN join1 ON tableAlias.id = join1.table_id INNER JOIN join2 as joinAlias ON joinAlias.id = join1.joinAlias_id WHERE id = ? AND name = ? AND type = ? ORDER BY name,value GROUP BY id LIMIT 15';
   		$this->assertEquals($expected, $this->select->assemble());
   	}
   	
   	public function testSelectNoFields()
   	{
   		$result = $this->select->from('table', array());
   		
   		$this->assertType('Acuity_Db_Select', $result);
   		
   		$expected = 'SELECT  FROM table';
   		$this->assertEquals($expected, $this->select->assemble());
   	}
   	
   	/**
   	 * 
   	 * @expectedException Acuity_Db_Exception
   	 */
   	public function testSelectNoFrom()
   	{   		
   		$this->select->assemble();
   	}
   	
   	public function testQuery()
   	{
   		$config = array(
   			'file'	 =>	':memory:',
   		);
   		
   		$conn_string = sprintf('sqlite:%s', $config['file']);
   		
   		$statement_stub = $this->getMock(
   			'PDOStatement',
   			array('execute')
   		);
   		
   		$statement_stub->expects($this->any())
   			->method('execute')
   			->will($this->returnValue('TRUE'));
   		
				
		$db_stub = $this->getMock(
   			'Acuity_Db_Abstract', 
   			array('prepare'), 
   			array(
   				sprintf('sqlite:%s', $config['file'])
   			)
   		);
   		
   		$expected = array('id' => 1);
   		
   		$db_stub->expects($this->any())
   			->method('prepare')
   			->with($this->equalTo('SELECT test.* FROM test WHERE id = ?'))
   			->will($this->returnValue($statement_stub));
   		
   		$select = new Acuity_Db_Select($db_stub);
   		
   		$select->from('test')
   			->where('id = ?', 1);

   		$select->query();
   	}
}

class Library_Db_SelectTester extends Acuity_Db_Select
{
	public function __get($name)
	{
		return $this->$name;
	}
	
	public function __call($name, $args)
	{
		return $this->$name();
	}
}