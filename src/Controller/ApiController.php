<?php
namespace App\Controller;

class ApiController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['index', 'view','add', 'delete']);
    }

    public function index()
    {
        $investmentsTbl = $this->fetchTable('investments')->find()->all();
        $this->set('investments', $investmentsTbl);
        $this->viewBuilder()->setOption('serialize', ['investments']);
    }

    public function view($id)
    {
        $investmentsTbl = $this->fetchTable('investments')->find()
        ->contain(['tickers','users'])
        ->order(['created' => 'DESC'])
        ->where(['investments.user_id' => $id])
        ->all();

        $cnt = 0;

        $likesTable = $this->fetchTable('likes')->find()
        ->contain(["users","investments","investments.users"])
        ->toArray();

        foreach($likesTable as $like){
            if($like->investment->user->id == $id){
                $cnt++;
            }
        }

        $this->set("Total_Likes", $cnt);

        $this->set('investments', $investmentsTbl);
        $this->viewBuilder()->setOption('serialize', ['Total_Likes','investments']);
    }

    public function add()
    {
        $investmentsTable = $this->fetchTable('investments');
            
        $fileObject = $this->request->getData('imagePath');

        if($fileObject != null){
            $partialTargetDir = dirname($_SERVER['PHP_SELF']).'/img/uploads/'.$fileObject->getClientFilename();
            $fullTargetDir = $_SERVER['DOCUMENT_ROOT'].$partialTargetDir;

            $data = [];
            $data['ticker_id'] = $this->request->getData('ticker_id');
            $data['shares'] = trim(strip_tags($this->request->getData('shares')));
            $data['boughtAt'] = trim(strip_tags($this->request->getData('boughtAt')));
            $data['notes'] = trim(strip_tags($this->request->getData('notes')));
            $data['imagePath'] = $partialTargetDir;
            $data['created'] = $this->request->getData('created_at');

            if($this->request->getData('privacy') == 0){
                $data['privacy'] = false;
            }else{
                $data['privacy'] = true;
            }

            $data['user_id'] = $this->request->getData('user_id');

            $newInvestment = $investmentsTable->newEntity($data);

            if($investmentsTable->save($newInvestment)){

                $fileObject->moveTo($fullTargetDir);

                $this->set('Status', "Success!");
                
            }else {
                $errors = $newInvestment->getErrors();

                $this->set('Status', $errors);
            }

            $this->viewBuilder()->setOption('serialize', ['Status']);
        }else{
            $this->set('Status', "No Image Was Sent!");
            $this->viewBuilder()->setOption('serialize', ['Status']);
        }

    }

    public function delete($id)
    {
        $investmentsTable = $this->fetchTable("investments");

        $investmentToDelete = $investmentsTable->get($id);

        if ($investmentsTable->delete($investmentToDelete))
            $this->set('deleteStatus', "Investment has been deleted!");
        else
            $this->set('deleteStatus', "Cannot delete Investment!");

        $this->viewBuilder()->setOption('serialize', ['deleteStatus']);
    }

}
