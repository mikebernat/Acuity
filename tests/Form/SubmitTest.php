<?php

require_once 'PHPUnit/Framework.php';

class Library_Form_SubmitTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {

    }

    public function tearDown()
    {

    }

    public function testInstantiation()
    {
        $element = new Acuity_Form_Submit('testSubmit');
         
        $expected = '<div class="formfield submit " id="formtestSubmit">'
        . PHP_EOL .
                '<input type="submit" id="inputtestSubmit" value="Submit" />'
                . PHP_EOL .
                '</div>'
                . PHP_EOL;
                $this->assertEquals($expected, (string) $element);
    }
     
    public function testBefore()
    {
        $options = array('before' => 'testBefore');
        $element = new Acuity_Form_Submit('testSubmit', $options);
         
        $expected = '<div class="formfield submit " id="formtestSubmit">'
        . PHP_EOL .
                '<span class="before">testBefore</span>'
                . PHP_EOL .
                '<input type="submit" id="inputtestSubmit" value="Submit" />'
                . PHP_EOL .
                '</div>'
                . PHP_EOL;
                $this->assertEquals($expected, (string) $element);
    }
     
    public function testAfter()
    {
        $options = array('after' => 'testAfter');
        $element = new Acuity_Form_Submit('testSubmit', $options);
         
        $expected = '<div class="formfield submit " id="formtestSubmit">'
        . PHP_EOL .
                '<input type="submit" id="inputtestSubmit" value="Submit" />'
                . PHP_EOL .
                '<span class="after">testAfter</span>'
                . PHP_EOL .
                '</div>'
                . PHP_EOL;
                $this->assertEquals($expected, (string) $element);
    }
     
}