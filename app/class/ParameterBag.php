<?php

namespace TaskManager;

class ParameterBag implements ParameterBagInterface
{
    private $method;
    private $data;

    public function __construct($method)
    {
        $this->method = $method;
        $this->initialize();
    }

    public function initialize()
    {
        $this->data =  $this->method == 'get' ? $_GET : $_POST;
    }

    public function exists($name)
    {
        return isset($this->data[$name]) ? true : false;
    }

    public function get($name, $default = null)
    {
        return $this->exists($name) ? $this->data[$name] : $default;
    }

    public function all()
    {
        return $this->data;
    }

    public function put($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function delete($name)
    {
        if (self::exists($name)) {
            unset($this->data[$name]);
        }
    }
}