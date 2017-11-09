<?php
namespace TaskManager\Validation;

class Input
{
    private $name;
    private $value;
    private $requirements;

    public function __construct($name, $value, $requirements = null)
    {
        $this->name  = $name;
        $this->value = $value;
        if ($requirements) {
            $this->initRequirements($requirements);
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getRequirement()
    {
        return $this->requirements ? array_pop($this->requirements) : false;
    }

    private function initRequirements($requirements = []){
       foreach ($requirements as $key => $value) {
                $this->requirements[] = new Requirement($key, $value);
            }
    }
}