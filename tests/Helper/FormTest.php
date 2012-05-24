<?php

require_once 'PHPUnit/Framework.php';

class Library_Helper_FormTest extends PHPUnit_Framework_TestCase
{

	public function setUp()
	{

	}

	public function tearDown()
	{

	}

	public function testComplextConstruct()
	{
		$model = new Form_Helper_Mock();

		$form = new Acuity_Helper_Form($model);

		$expected = <<<EXPECTED
<div class="formstart begin " id="formstartForm_Helper_Mock">
<form action="" method="POST" name="Form_Helper_Mock"><input type="hidden" name="id" id="inputid" value="" /><div class="formfield text  required" id="formurl">
<label for="inputurl">url</label>
<input type="text" id="inputurl" value="" name="url" />
</div>
<div class="formfield text  required" id="formname">
<label for="inputname">name</label>
<input type="text" id="inputname" value="" name="name" />
</div>
<div class="formfield submit " id="form">
<input type="submit" id="input" value="Submit" />
</div>
</form>
</div>
EXPECTED;

		$this->assertEquals($expected, (string) $form);
	}

   	public function testInstantiation()
   	{
   		$result = new Acuity_Helper_Form();

   		$this->assertInstanceOf('Acuity_Helper_Form', $result);
   	}

	public function testBegin()
   	{
   		$form = new Acuity_Helper_Form();

   		$result = $form->begin('test');

   		$this->assertInstanceOf('Acuity_Form_Begin', $result);
   	}

	public function testHidden()
   	{
   		$form = new Acuity_Helper_Form();

   		$result = $form->hidden('test');

   		$this->assertInstanceOf('Acuity_Form_Hidden', $result);
   	}

	public function testText()
   	{
   		$form = new Acuity_Helper_Form();

   		$result = $form->text('test');

   		$this->assertInstanceOf('Acuity_Form_Text', $result);
   	}

	public function testSubmit()
   	{
   		$form = new Acuity_Helper_Form();

   		$result = $form->submit('test');

   		$this->assertInstanceOf('Acuity_Form_Submit', $result);
   	}

	public function testEnd()
   	{
   		$form = new Acuity_Helper_Form();

   		$result = $form->end('test');

   		$this->assertInstanceOf('Acuity_Form_End', $result);
   	}

	public function testMultiselect()
   	{
   		$form = new Acuity_Helper_Form();

   		$result = $form->multiselect('test', array());

   		$this->assertInstanceOf('Acuity_Form_Multiselect', $result);
   	}

	public function testSelect()
   	{
   		$form = new Acuity_Helper_Form();

   		$result = $form->select('test', array());

   		$this->assertInstanceOf('Acuity_Form_Select', $result);
   	}
}

class Form_Helper_Mock extends Acuity_Model_Entity
{
	public $fields = array(
		'id',
		'url',
		'name',
	);

	public function getSelect($primaryKey, $options = array())
	{

	}
}