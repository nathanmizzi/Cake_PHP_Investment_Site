<?php
namespace App\Controller;

class InvestmentsController extends AppController
{

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['index']);
    }

    public function index() {
        $investmentsTable = $this->fetchTable('investments')->find()
        ->contain(['tickers'])
        ->contain(['users'])
        ->order(['created' => 'DESC'])
        ->where(['privacy' => 0])
        ->all();
        
        $this->set("allInvestments", $investmentsTable);
	}

    public function myInvestments(){
        $investmentsTable = $this->fetchTable('investments')->find()
        ->contain(['tickers'])
        ->contain(['users'])
        ->order(['created' => 'DESC'])
        ->where(['investments.user_id' => $this->loggedInUser->id])
        ->all();
        
        $this->set("allInvestments", $investmentsTable);
    }

    public function getUserInvestments($id){

        $investmentsTable = $this->fetchTable('investments')->find()
        ->contain(['tickers'])
        ->contain(['users'])
        ->order(['created' => 'DESC'])
        ->where(['investments.user_id' => $id])
        ->all();
        
        $this->set("userInvestments", $investmentsTable);
    }

    public function homepage(){

        $tickersTable = $this->fetchTable('tickers');

        $tickers = $tickersTable->find('list')->toArray();

        $userInvestmentsTable = $this->fetchTable('investments')->find()
            ->contain(['tickers'])
            ->contain(['users'])
            ->order(['created' => 'DESC'])
            ->where(['OR' => [['privacy' => 0], ['investments.user_id' => $this->loggedInUser->id]]])
            ->all();

        $this->set("allInvestments", $userInvestmentsTable);

        $this->set("tickers", $tickers);

        $usersTable = $this->fetchTable('users')->find('list')->toArray();

        $this->set("allUsers", $usersTable);

        if($this->request->is('post')){

            $investmentsTable = $this->fetchTable('investments');
            
            $fileObject = $this->request->getData('imagePath');
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

            $data['user_id'] = $this->loggedInUser->id;

            $newInvestment = $investmentsTable->newEntity($data);

            if($investmentsTable->save($newInvestment)){

                $fileObject->moveTo($fullTargetDir);

                $this->Flash->success("The Investment has been saved.");

                return $this->redirect(['action' => 'index']);
                
            }else {
                $errors = $newInvestment->getErrors();
                //pr($errors);
        
                $error_messages = "";
                foreach ($errors as $value) {
                    $error_messages .= array_values($value)[0]."<br>";
                }
        
                $this->Flash->error("Something wrong happened<br>$error_messages", ['escape' => false]);
            }

        }
    }

    public function edit($id){
        $tickersTable = $this->fetchTable('tickers');
        $tickers = $tickersTable->find('list')->toArray();

        $investmentsTable = $this->fetchTable('investments');
        $investmentToEdit = $investmentsTable->findById($id)->first();

        $this->set("tickers", $tickers);
        $this->set("investmentToEdit", $investmentToEdit);

        if($this->request->is('post', 'put')){

            $fileObject = $this->request->getData('imagePath');
            $partialTargetDir = dirname($_SERVER['PHP_SELF']).'/img/uploads/'.$fileObject->getClientFilename();
            $fullTargetDir = $_SERVER['DOCUMENT_ROOT'].$partialTargetDir;

            $data = $this->request->getData();
            $data['imagePath'] = $partialTargetDir;

            $investmentToEdit = $investmentsTable->patchEntity($investmentToEdit, $data);

            if($investmentsTable->save($investmentToEdit)){

                $fileObject->moveTo($fullTargetDir);

                $this->Flash->success("The Investment has been updated.");

                return $this->redirect(['action' => 'add']);
                
            }else{
                $errors = $investmentToEdit->getErrors();
                //pr($errors);
        
                $error_messages = "";
                foreach ($errors as $value) {
                    $error_messages .= array_values($value)[0]."<br>";
                }
        
                $this->Flash->error("Something wrong happened<br>$error_messages", ['escape' => false]);
            }

        }

    }

    public function share($investmentID){

        if($this->request->is('post')){

            $sharesTable = $this->fetchTable('shares');

            $data = $this->request->getData();
            $data['investment_id'] = $investmentID;
            $data['user_id'] = trim(strip_tags($this->request->getData('user_id')));

            $newShare = $sharesTable->newEntity($data);

            if($sharesTable->save($newShare)){

                $this->Flash->success("The Share has been saved.");

                return $this->redirect(['action' => 'homepage']);
                
            }else {
                $errors = $newShare->getErrors();
                //pr($errors);
        
                $error_messages = "";
                foreach ($errors as $value) {
                    $error_messages .= array_values($value)[0]."<br>";
                }
        
                $this->Flash->error("Something wrong happened<br>$error_messages", ['escape' => false]);
            }

        }

    }

    public function delete($id){

        $investmentsTable = $this->fetchTable("investments");

        $investmentToDelete = $investmentsTable->get($id);

        if ($investmentsTable->delete($investmentToDelete))
            $this->Flash->success("Investment has been deleted!");
        else
            $this->Flash->error("Cannot delete Investment!");

        return $this->redirect(['action' => "index"]);
    }



}
