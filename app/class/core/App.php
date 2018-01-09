<?php

class App
{
	protected $controller = 'home';
	protected $method     = 'index';
	protected $params     = [];
	
	public function __construct()
    {
		$url = $this->parseUrl();
		$controllerFromUrl = $url[0];
		if(file_exists(DIR_ROOT.DS."app".DS."class".DS."Controller".DS.$controllerFromUrl."Controller.php")){
			$this->controller = $controllerFromUrl;
			unset($url[0]);
		}
		$fullControllerName = "TaskManager\\Controller\\".$this->controller."Controller";
		$this->controller = new $fullControllerName;
		if(isset($url[1])){
			if(method_exists($this->controller, $url[1])){
				$this->method = $url[1];
				unset($url[1]);
			}
		}
		$this->params = $url ? array_values($url) : [];
		call_user_func_array([$this->controller, $this->method], $this->params);
	}
	
	private function parseUrl()
    {
		if(isset($_GET['url'])){
			return $url = explode('/',(filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL)));
		}
	}
}