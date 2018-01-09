<?php
namespace TaskManager;

interface ParameterBagInterface
{
    public function exists($name);
    public function get($name);
    public function put($name, $value);
    public function delete($name);
}