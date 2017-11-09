<?php
namespace TaskManager\Core;

use TaskManager\Database\Database;
use TaskManager\Pagination\Pagination;
use TaskManager\Request;
use TaskManager\Session;

abstract class Controller
{
    protected $session;
    protected $request;
    protected $pagination;
    protected $db;

    public function __construct()
    {
        $this->session = new Session();
        $this->request = new Request();
        $this->pagination = new Pagination();
        $this->db = new Database();
    }

    public function view($view, $data = [])
    {
		$loader = new \Twig_Loader_Filesystem(VIEWS_DIR);
		$twig = new \Twig_Environment($loader);
		echo $twig->render($view, $data);
		die();
	}
}