<?php
namespace App\Controller;

class UsersController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['login', 'add']);
    }

    public function login()
    {
        $this->request->allowMethod(['get', 'post']);

        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        
        if ($result->isValid()) {
            // redirect to /articles after login success
            $redirect = $this->redirect(array('controller' => 'investments', 'action' => 'homepage'));
        }
        // display error if user submitted and authentication failed
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Invalid username or password'));
        }
    }

    public function logout()
    {
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in

        if ($result->isValid()) {
            $this->Authentication->logout();
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }

    public function index() {
        
        $usersTable = $this->fetchTable('users')->find()->contain(['roles'])->all();

        $this->set("allUsers", $usersTable);
	}

    public function add() {

        $rolesTable = $this->fetchTable('roles');

        $roles = $rolesTable->find('list')->toArray();

        $this->set("roles", $roles);

        if($this->request->is('post')){

            $usersTable = $this->fetchTable('users');

            $data = $this->request->getData();

            $data['firstName'] = trim(strip_tags($this->request->getData('firstName')));
            $data['lastName'] = trim(strip_tags($this->request->getData('lastName')));
            $data['roleId'] = $this->request->getData('role_id');
            $data['username'] = trim(strip_tags($this->request->getData('email')));
            $data['password'] = $this->request->getData('password');

            $newUser = $usersTable->newEntity($data);

            if($usersTable->save($newUser)){
                $this->Flash->success("The User has been saved.");

                return $this->redirect(['action' => 'index']);
                
            }else {
                $errors = $newUser->getErrors();
        
                $error_messages = "";
                foreach ($errors as $value) {
                    $error_messages .= array_values($value)[0]."<br>";
                }
        
                $this->Flash->error("Something wrong happened<br>$error_messages", ['escape' => false]);
            }

        }
	}

}
