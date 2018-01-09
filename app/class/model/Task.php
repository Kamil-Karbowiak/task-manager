<?php
namespace TaskManager\Model;

use TaskManager\Validation\Input;
use TaskManager\Validation\Validate;

class Task implements EntityInterface
{
    private static $tableName     = 'tasks';
    private static $columnsToFill = ['name', 'description', 'dueDate', 'priority', 'userId', 'addDate', 'status'];
    private static $primaryKey    = 'id';
    private $id;
    private $name;
    private $description;
    private $dueDate;
    private $addDate;
    private $priority;
    private $userId;
	private $status;
    private $validation;

	public function __construct($name = null, $description = null, $dueDate = null, $priority = null, $userId = null, $addDate = null, $status = null){
		$this->name = $name;
		$this->description = $description;
		$this->dueDate = date("Y-m-d\TH:i", strtotime($dueDate));
		$this->addDate = date('Y-m-d\TH:i:sP');
		$this->priority = $priority;
		$this->userId = $userId;
		$this->status = 'todo';
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

	public function getDescription()
    {
		return $this->description;
	}

	public function setDescription($description)
    {
		$this->description = $description;
	}

	public function getDueDate()
    {
		return $this->dueDate;
	}

	public function setDueDate($date)
    {
		$this->dueDate = date("Y-m-d\TH:i", strtotime($date));
	}

	public function getAddDate()
    {
		return $this->addDate;
	}

	public function setAddDate($date)
    {
		$this->addDate = $date;
	}

	public function getPriority()
    {
		return $this->priority;
	}

	public function setPriority($priority)
    {
		$this->priority = $priority;
	}

	public function getUserId()
    {
		return $this->userId;
	}

	public function setUserId($id)
    {
		$this->userId = $id;
	}

	public function getStatus()
    {
		return $this->status;
	}

	public function setStatus($status)
    {
		$this->status = $status;
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

    public function isValid()
    {
        $this->validation->add(new Input('Name', $this->name, ['required' => true, 'maxLength' => 30]));
        $this->validation->add(new Input('Description', $this->description, ['required' => true,]));
        $this->validation->add(new Input('Priority', $this->priority, ['required' => true, 'values' =>['low', 'medium', 'high']]));
        $this->validation->add(new Input('Due Date', $this->dueDate, ['required' => true, 'type' => 'dateTime']));
        return $this->validation->isValid();
    }

    public function getValidationErrors()
    {
        return $this->validation->getErrors();
    }
}