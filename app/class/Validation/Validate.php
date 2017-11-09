<?php
namespace TaskManager\Validation;

class Validate
{
	private $errors = [];
	private $inputs = [];
	private $passed = true;

    public function add(Input $input)
    {
        $this->inputs[] = $input;
	}

    public function getErrors()
    {
        $errors = $this->errors;
        $this->errors = [];
        return $errors;
    }

	public function isValid()
    {
        $this->validate();
		$result = $this->passed;
        $this->inputs = [];
        $this->passed = true;
     	return $result;
	}

    private function validate()
    {
		foreach($this->inputs as $input){
		    $this->checkRequirements($input);
		}
	}

	private function checkRequirements(Input $input)
    {
        while ($requirement = $input->getRequirement()) {
            $conditionName  = $requirement->getName();
            $conditionValue = $requirement->getRequire();
            if($conditionName == 'required' && $conditionValue == 'true' && !$input->getValue()){
                $this->errors[] = $input->getName()." field is required.";
                $this->passed = false;
                return;
            }else{
                switch($conditionName){
                    case 'minLength':
                        $this->checkMinLength($input, $conditionValue);
                        break;
                    case 'maxLength':
                        $this->checkMaxLength($input, $conditionValue);
                        break;
                    case 'equal':
                        $this->isEqual($input, $conditionValue);
                        break;
                    case 'type':
                        $this->validateType($input, $requirement);
                        break;
                    case 'values':
                        $this->checkValues($input, $conditionValue);
                        break;
                }
            }
        }
	}

    private function checkMinLength(Input $input, $length)
    {
        if(strlen($input->getValue()) < $length){
            $this->errors[] = $input->getName()." field has a minimum length of ".$length." characters.";
            $this->passed = false;
        }
    }

    private function checkMaxLength(Input $input, $length)
    {
        if(strlen($input->getValue()) > $length){
            $this->errors[] = $input->getName()." field has a maximum length of ".$length." characters.";
            $this->passed = false;
        }
    }

    private function isEqual(Input $input, $secondInputName)
    {
        $secondInput = $this->getInputByName($secondInputName);
        if($input->getValue() !== $secondInput->getValue()){
            $this->errors[] = $input->getName()." and ".$secondInput->getName()." field are not the same.";
            $this->passed = false;
        }
    }

    private function validateType(Input $input, Requirement $requirement)
    {
        switch($requirement->getRequire()){
            case 'email':
                $this->validateEmail($input->getValue());
                break;
            case 'dateTime':
                $this->validateDateTime($input->getValue());
                break;
        }
    }

    private function validateEmail($email)
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Email address is not in a valid email format";
            $this->passed = false;
        }
    }

    private	function validateDateTime($date)
    {
        $d = \DateTime::createFromFormat('Y-m-d\TH:i', $date);
        $isValid = $d && $d->format('Y-m-d\TH:i') === $date;
        if(!$isValid){
            $this->errors[] = "Enter valid due date please";
            $this->passed = false;
        }
    }

	private function checkValues(Input $input, $requiredValues)
    {
		$value = $input->getValue();
		if(!in_array($value, $requiredValues)){
			$this->errors[] = "Enter valid ".$input->getName()." please";
			$this->passed = false;
		}
	}

    private function getInputByName($name)
    {
        foreach ($this->inputs as $input) {
            if($input->getName() == $name){
                return $input;
            }
        }
        return false;
    }
}