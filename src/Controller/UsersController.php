<?php
namespace App\Controller;

class UsersController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['login', 'add', 'loginWithFb']);
    }


    public function login()
    {
        $this->request->allowMethod(['get', 'post']);

        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        
        if ($result->isValid()) {
            // redirect to /articles after login success
            $this->log('Logged-In Succesfully!, User: '.$this->loggedInUser->email.', User ID: '.$this->loggedInUser->id.', IP Address: '.$_SERVER['REMOTE_ADDR'],'info', ['scope' => ['login']]);
            $redirect = $this->redirect(array('controller' => 'investments', 'action' => 'homepage'));
        }
        // display error if user submitted and authentication failed
        if ($this->request->is('post') && !$result->isValid()) {
            $this->log('Failed to Log-in!, IP Address: '.$_SERVER['REMOTE_ADDR'],'error', ['scope' => ['login']]);
            $this->Flash->error(__('Invalid username or password'));
        }
    }

    public function loginWithGoogle(){    

        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $roleId = $_POST['roleId'];
        $password = $_POST['password'];

        $usersTable = $this->fetchTable('users');
        $data = $this->request->getData();

        $data['firstName'] = trim(strip_tags($_POST['firstname']));
        $data['lastName'] = trim(strip_tags($_POST['lastname']));
        $data['role_id'] = $_POST['roleId'];
        $data['username'] = trim(strip_tags($_POST['email']));
        $data['password'] = $_POST['password'];

        $newUser = $usersTable->newEntity($data);

        $query = $usersTable->find('all')
        ->where(['users.email' => "$email"])->first();

        if($query == null){
            if($usersTable->save($newUser))
                echo "Account Created";
        }else{
            echo "Account Already Exists";
        }

        die;
    }

    public function logout()
    {
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in

        if ($result->isValid()) {
            $this->log('Logged-Out Succesfully!, User: '.$this->loggedInUser->email.', User ID: '.$this->loggedInUser->id.', IP Address: '.$_SERVER['REMOTE_ADDR'],'info', ['scope' => ['logout']]);
            $this->Authentication->logout();

            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }else{
            $this->log('Failed to Log-Out!, User: '.$this->loggedInUser->email.', User ID: '.$this->loggedInUser->id.', IP Address: '.$_SERVER['REMOTE_ADDR'],'error', ['scope' => ['logout']]);
        }
    }

    public function index() {
        
        $usersTable = $this->fetchTable('users')->find()->contain(['roles'])->all();

        $this->set("allUsers", $usersTable);
	}

    public function add() {

        if($this->request->is('post')){

            $usersTable = $this->fetchTable('users');

            $data = $this->request->getData();

            $data['firstName'] = trim(strip_tags($this->request->getData('firstName')));
            $data['lastName'] = trim(strip_tags($this->request->getData('lastName')));
            $data['role_id'] = 2;
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
