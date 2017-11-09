<?php

use Mvc2\temp\Input;
use PHPUnit\Framework\TestCase;
use Mvc2\temp\Validate;

class ValidateTest extends TestCase
{
	public function testCheckMinLength(){
		$validate = new Validate();
		$validate->add(new Input('Name', '123456789', ['minLength' => 10]));
	    $this->assertFalse($validate->isValid());
        $validate->add(new Input('Name', '11234567890', ['minLength' => 10]));
        $this->assertTrue($validate->isValid());
        $validate->add(new Input('Name', '', ['minLength' => 10]));
        $this->assertFalse($validate->isValid());
    }

    public function testCheckMaxLength(){
        $validate = new Validate();
        $validate->add(new Input('Name', '01234567891', ['maxLength' => 10]));
        $this->assertFalse($validate->isValid());
        $validate->add(new Input('Name', '', ['maxLength' => 10]));
        $this->assertTrue($validate->isValid());
        $validate->add(new Input('Name', '012345678', ['maxLength' => 10]));
        $this->assertTrue($validate->isValid());
    }
    public function testIsEqual(){
        $validate = new Validate();
        $validate->add(new Input('Name1', 'value1'));
        $validate->add(new Input('Name2', 'value1', ['equal' => 'Name1']));
        $this->assertTrue($validate->isValid());
        $validate = new Validate();
        $validate->add(new Input('Name1', 'value1'));
        $validate->add(new Input('Name2', 'value2', ['equal' => 'Name1']));
        $this->assertFalse($validate->isValid());
    }
    public function testCheckValues(){
        $validate = new Validate();
        $validate->add(new Input('Name', 'value1', ['values'=>['value1', 'value2']]));
        $this->assertTrue($validate->isValid());
        $validate->add(new Input('Name', 'value1', ['values'=>['value', 'value3']]));
        $this->assertFalse($validate->isValid());
    }
    public function testValidateEmail(){
        $validate = new Validate();
        $validate->add(new Input('Email','123@wp.pl', ['type'=>'email']));
        $this->assertTrue($validate->isValid());
        $validate->add(new Input('Email','', ['type'=>'email']));
        $this->assertFalse($validate->isValid());
    }
    public function testValidateDateTime(){
        $validate = new Validate();
        $validate->add(new Input('Test date', date('Y-m-d\TH:i'), ['type'=>'dateTime']));
        $this->assertTrue($validate->isValid());
        $validate->add(new Input('Test date', date('d-m-Y\TH:i'), ['type'=>'dateTime']));
        $this->assertFalse($validate->isValid());
        $validate->add(new Input('Test date', '', ['type'=>'dateTime']));
        $this->assertFalse($validate->isValid());
    }
}