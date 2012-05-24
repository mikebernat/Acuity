<?php

require_once 'PHPUnit/Framework.php';

class Library_Db_AbstractTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        if (!extension_loaded('pdo_sqlite'))
        {
            $this->markTestSkipped('Sqlite pdo extension not installed');
        }
    }

    public function tearDown()
    {

    }

    public function testUpdate()
    {
        $config = array(
               'driver' => 'sqlite',
               'file'     =>    ':memory:',
        );

        $stub = $this->getMock(
               'Acuity_Db_Abstract', 
        array('query'),
        array(
        sprintf('sqlite:%s', $config['file'])
        )
        );
         
        $stub->expects($this->any())
        ->method('query')
        ->will($this->returnArgument('0'));
         
        $result = $stub->update('testTable', array('name' => 'john', 'type' => 'member'), 'id = 1');
         
        $expected = "UPDATE testTable SET name = 'john',type = 'member' WHERE id = 1";
        $this->assertEquals($expected, $result);
    }
     
    public function testInsert()
    {
        $config = array(
               'driver' => 'sqlite',
               'file'     =>    ':memory:',
        );

        $stub = $this->getMock(
               'Acuity_Db_Abstract', 
        array('query'),
        array(
        sprintf('sqlite:%s', $config['file'])
        )
        );
         
        $expected = "INSERT INTO testTable(name,type) VALUES('john','member')";
        $stub->expects($this->any())
        ->method('query')
        ->with($this->equalTo($expected));
         
        $stub->insert('testTable', array('name' => 'john', 'type' => 'member'));
    }
}