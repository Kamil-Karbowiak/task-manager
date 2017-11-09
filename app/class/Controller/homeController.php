<?php
namespace TaskManager\Controller;

use TaskManager\Core\Controller;
use TaskManager\Login;
use TaskManager\Model\Task;
use TaskManager\Pagination\ArrayAdapter;
use TaskManager\Repository\EntityRepository;
use TaskManager\CsrfGuard;
use TaskManager\Redirect;

class homeController extends Controller
{
	public function index()
    {
        if (!Login::isLoggedIn()) {
			Redirect::redirect("security");
		}
        $data = [];
        $data['status'] = 'all';
        $data['taskHeader'] = 'All tasks';
		if ($status = $this->request->getQuery()->get('tasksStatus')) {
            switch ($status){
                case 'todo':
                    $data['status'] = $status;
                    $params['status'] = $status;
                    $data['taskHeader'] = 'Tasks to-do';
                    break;
                case 'completed':
                    $data['status'] = $status;
                    $params['status'] = 'done';
                    $data['taskHeader'] = 'Tasks completed';
                    break;
            }
        }
        $params['userId'] = $this->session->get('userId');
		$taskRepo = new EntityRepository($this->db, 'TaskManager\Model\Task', 'tasks');
        $tasks = new ArrayAdapter($taskRepo->findBy($params, ['dueDate'], 'ASC'));
        $limit = $this->request->getQuery()->get('itemsPerPage', 5);
        $page = $this->request->getQuery()->get('page', 1);
        $this->pagination->paginate($tasks, $limit, $page);

        $data['paginate']    = $this->pagination;
        $data['message']     = $this->session->flashMessage();
        $data['csrfToken']   = CsrfGuard::generateToken('csrfToken');
        $data['user']        = $this->session->get('userName');
		$this->view('home/index.php', $data);
	}
	public function add()
    {
        if (!Login::isLoggedIn()) {
            Redirect::redirect("security");
        }
        $data = [];
        $taskRepo = new EntityRepository($this->db, 'TaskManager\Model\Task', 'tasks');
		if ($this->request->getQuery()->exists('submit')) {
            $userId      = $this->session->get('userId');
            $name        = htmlspecialchars($this->request->getQuery()->get('name'));
            $description = htmlspecialchars($this->request->getQuery()->get('description'));
            $priority    = htmlspecialchars($this->request->getQuery()->get('priority'));
            $dueDate     = htmlspecialchars($this->request->getQuery()->get('dueDate'));
            $task = new Task($name, $description, $dueDate, $priority, $userId);
            if ($task->isValid()) {
                $taskRepo->persist($task);
                $this->session->flashMessage('A new task has been added');
                Redirect::redirect('home/add');
            }else{
                $data['errors'] = $task->getValidationErrors();
            }
	    }
        $data['user']        = $this->session->get('userName');
		$data['message'] = $this->session->flashMessage();
		$data['header']  = 'Add Task';
		$this->view('home/taskForm.php', $data);
	}

	public function done()
    {
        if (!Login::isLoggedIn()) {
            Redirect::redirect("security");
        }
        $taskRepo = new EntityRepository($this->db, 'TaskManager\Model\Task', 'tasks');
        $token = $this->request->getRequest()->get('csrfToken');
        if (CsrfGuard::validateToken('csrfToken', $token)) {
            $id = $this->request->getRequest()->get('taskId');
            $task = $taskRepo->findOneBy(['id' => $id]);
            if ($task) {
                $task->setStatus('done');
                $taskRepo->persist($task);
            }
        }
        $data = [];
        $data['page'] = $this->request->getQuery()->get('page', 1);
        $data['tasksStatus']  = $this->request->getQuery()->get('tasksStatus', 'all');
        $data['itemsPerPage']  = $this->request->getQuery()->get('itemsPerPage', 5);
        Redirect::redirect("home", $data);
	}
	public function edit()
    {
        if (!Login::isLoggedIn()) {
            Redirect::redirect("security");
        }
        $data = [];
        $taskRepo = new EntityRepository($this->db, 'TaskManager\Model\Task', 'tasks');
        if ($this->request->getQuery()->exists('submit')) {
            $requestParams = $this->request->getQuery()->all();
            $task = $taskRepo->findOneBy(['id'=> $requestParams['id']]);
            $task->setName(htmlspecialchars($requestParams['name']));
            $task->setDescription(htmlspecialchars($requestParams['description']));
            $task->setDueDate(htmlspecialchars($requestParams['dueDate']));
            $task->setPriority(htmlspecialchars($requestParams['priority']));
            $task->setStatus(htmlspecialchars($requestParams['status']));
            if ($task->isValid()) {
                $taskRepo->persist($task);
                $this->session->flashMessage('The task has been updated');
                Redirect::redirect('home');
            }else{
                $data['errors'] = $task->getValidationErrors();
            }
        }
        if ($id = $this->request->getRequest()->get('taskId')) {
            $task = $taskRepo->findOneBy(['id' => $id]);
            if (!$task) {
                $this->session->flashMessage('An error has occured while editing task');
                Redirect::redirect('home/index');
            }
            $data['task'] = $task;
        }
        $data['user']        = $this->session->get('userName');
        $data['message'] = $this->session->flashMessage();
        $data['header']  = 'Edit Task';
        $this->view('home/taskForm.php', $data);
	}

	public function delete()
    {
        if (!Login::isLoggedIn()) {
            Redirect::redirect("security");
        }
        $taskRepo = new EntityRepository($this->db, 'TaskManager\Model\Task', 'tasks');
		$token = $this->request->getRequest()->get('csrfToken');
            if (CsrfGuard::validateToken('csrfToken', $token)) {
                $id = $this->request->getRequest()->get('taskId');
                if(!$taskRepo->remove($id)){
                    $this->session->flashMessage('An error has occured while deleting task');
                }
            }
        $data = [];
		$data['page'] = $this->request->getQuery()->get('page', 1);
        $data['tasksStatus']  = $this->request->getQuery()->get('tasksStatus', 'all');
        $data['itemsPerPage']  = $this->request->getQuery()->get('itemsPerPage', 5);
        Redirect::redirect("home", $data);
	}
}