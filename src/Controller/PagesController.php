<?php
namespace App\Controller;

class PagesController extends AppController
{

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['index']);
    }

    public function index() {
        return $this->redirect(array('controller' => 'investments', 'action' => 'homepage'));
	}
}
