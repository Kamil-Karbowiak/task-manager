<?php
namespace TaskManager;

class Redirect
{
	public static function redirect($url, $data = [], $statusCode = 303)
	{
	    if(!empty($data)){
            $url .= self::prepareParams($data);
	    }
        header('Location: ' . '/task-manager/web/'.$url,$statusCode);
        die();
	}

	private static function prepareParams($data)
    {
        $tempArray = [];
        foreach($data as $key => $value){
            $tempArray[] = $key."=".$value;
        }
        return "?".implode('&', $tempArray);
    }
}