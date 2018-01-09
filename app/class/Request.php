<?php
namespace TaskManager;

class Request
{
    public function getQuery(){
        $getMethodArray = new ParameterBag('get');
        return $getMethodArray;
    }

    public function getRequest(){
        $postMethodArray = new ParameterBag('post');
        return $postMethodArray;
    }
}