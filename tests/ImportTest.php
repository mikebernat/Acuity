<?php
require_once 'PHPUnit/Framework.php';

class Library_ImportTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {

    }

    public function tearDown()
    {

    }

    /**
     * @expectedException Exception
     */
    public function testNonExistantClass()
    {
        $loader = Acuity_Import::getInstance();

        $result = $loader->load('doesNotExist');
    }
}