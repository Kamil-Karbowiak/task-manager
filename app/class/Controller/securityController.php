<?php
namespace TaskManager\Controller;

use TaskManager\Core\Controller;
use TaskManager\Login;
use TaskManager\Redirect;
use TaskManager\Register;
use TaskManager\Repository\EntityRepository;

class SecurityController extends Controller
{
	public function index()
    {
        $data = [];
	    if($this->request->getRequest()->exists('submit')){
            $email    = htmlspecialchars($_POST['email']);
			$password = $_POST['password'];
			$userRepo = new EntityRepository($this->db,'TaskManager\Model\User', 'users');
            if(Login::login($userRepo, $email, $password)){
                Redirect::redirect('home/index');
            }else{
                $data['errors'] = Login::getErrors();
			}
		}
		$data['message'] = $this->session->flashMessage();
		$this->view("security/loginForm.php", $data);
	}
	
	public function register()
    {
        $data = [];
        if($this->request->getRequest()->exists('submit')){
			$email = htmlspecialchars($_POST['email']);
			$username = htmlspecialchars($_POST['username']);
			$password = $_POST['password'];
			$userRepo = new EntityRepository($this->db, 'TaskManager\Model\User', 'users');
            if(Register::register($userRepo, $email, $username, $password)){
                $this->session->flashMessage("WELCOME! You Are Successfully Registered. You can now log in.");
                Redirect::redirect('security/index');
            }else{
                $data['errors'] = Register::getErrors();
            }
		}
		$data['message'] = $this->session->flashMessage();
		$this->view("security/registerForm.php", $data);
	}
	
	public function logout()
    {
	    Login::logout();
		Redirect::redirect("security");
	}
}