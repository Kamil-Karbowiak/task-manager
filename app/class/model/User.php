<?php
namespace TaskManager\Model;

use TaskManager\Validation\Input;
use TaskManager\Validation\Validate;

class User implements EntityInterface
{
	private static $tableName     = 'users';
	private static $columnsToFill = ['email', 'name', 'passwordHash'];
	private static $primaryKey    = 'id';
	private $id;
	private $name;
	private $email;
	private $password;
	private $passwordHash;
	private $validation;

	function __construct($email = null, $name = null, $password = null)
    {
        $this->email = $email;
        $this->name = $name;
        $this->password = $password;
        $this->passwordHash = $this->hashingPassword($password);
        $this->validation = new Validate();
    }

    public function getId()
    {
		return $this->id;
	}

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getEmail()
    {
		return $this->email;
	}

	public function setEmail($email)
    {
		$this->email = $email;
	}

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
		$this->password = $password;
        $this->passwordHash = $this->hashingPassword($password);
	}

	public function getPasswordHash()
    {
	    return $this->passwordHash;
    }

    public function getObjectVars()
    {
        $allVars = get_object_vars($this);
        $temp = [];
        foreach(self::$columnsToFill as $column){
            if(array_key_exists($column, $allVars)){
                $temp[$column] = $allVars[$column];
            }
        }
        return $temp;
    }

    public static function getTableName()
    {
        return self::$tableName;
    }

    public static function getPrimaryKey()
    {
        return self::$primaryKey;
    }

    private function hashingPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function isValid()
    {
        $this->validation->add(new Input('Email', $this->email, ['required' => true, 'type' => 'email']));
        $this->validation->add(new Input('Name', $this->name, ['required' => true]));
        $this->validation->add(new Input('Password', $this->password, ['required' => true, 'minLength' => 6]));
        return $this->validation->isValid();
    }

    public function getValidationErrors()
    {
        return $this->validation->getErrors();
    }
}