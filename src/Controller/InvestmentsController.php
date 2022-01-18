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

        $likesTable = $this->fetchTable('likes')->find()->contain(["users","investments"])->toArray();

        $investmentsTable = $this->fetchTable('investments')->find()
        ->contain(['tickers'])
        ->contain(['users'])
        ->order(['created' => 'DESC'])
        ->where(['investments.user_id' => $this->loggedInUser->id])
        ->all();
        
        $this->set("allLikes", $likesTable);
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

        $likesTable = $this->fetchTable('likes')->find()->contain(["users","investments"])->toArray();
        $this->set("allLikes", $likesTable);

        //pr($likesTable);
        //die;

        //load tickers for future use
        $tickersTable = $this->fetchTable('tickers');
        $tickers = $tickersTable->find('list')->toArray();
        $this->set("tickers", $tickers);

        //getting public and user-made investments
        $investmentsTable = $this->fetchTable('investments')->find()
        ->contain(['tickers','users'])
        ->order(['created' => 'DESC'])
        ->where(['OR' => [['privacy' => 0], ['investments.user_id' => $this->loggedInUser->id]]])
        ->all();

        //getting shared likes
        $investmentSharesTable = $this->fetchTable('investmentshares')->find()
        ->contain(['users','investments','investments.tickers','investments.users'])
        ->where(['investmentshares.user_id' => $this->loggedInUser->id])
        ->all();

        $this->set("publicInvestments", $investmentsTable);
        $this->set("sharedInvestments", $investmentSharesTable);

        //Gets user to share to
        $usersTable = $this->fetchTable('users')
        ->find('list')
        ->where(['email !=' => $this->loggedInUser->email])
        ->toArray();
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

                $this->log('Investment Added Succesfully!, User: '.$this->loggedInUser->email.', User ID: '.$this->loggedInUser->id.', IP Address: '.$_SERVER['REMOTE_ADDR'].', Investment ID: '.$newInvestment->id,'info', ['scope' => ['investment']]);

                return $this->redirect(['action' => 'index']);
                
            }else {
                $errors = $newInvestment->getErrors();
        
                $error_messages = "";
                foreach ($errors as $value) {
                    $error_messages .= array_values($value)[0]."<br>";
                }

                $this->log('Failed To Add Investment!, User: '.$this->loggedInUser->email.', User ID: '.$this->loggedInUser->id.', IP Address: '.$_SERVER['REMOTE_ADDR'],'error', ['scope' => ['investment']]);
        
                $this->Flash->error("Something wrong happened<br>$error_messages", ['escape' => false]);
            }

        }
    }

    public function edit($id){

        //Edits an investment
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

                return $this->redirect(['action' => 'my_investments']);
                
            }else{
                $errors = $investmentToEdit->getErrors();
        
                $error_messages = "";
                foreach ($errors as $value) {
                    $error_messages .= array_values($value)[0]."<br>";
                }
        
                $this->Flash->error("Something wrong happened<br>$error_messages", ['escape' => false]);
            }

            return $this->redirect(['action' => 'my_investments']);
        }

    }

    public function like($investmentID){

        $likesTable = $this->fetchTable("likes");

        $data = [];

        $data['investment_id'] = $investmentID;
        $data['user_id'] = $this->loggedInUser->id;

        $newlike = $likesTable->newEntity($data);

        $query = $likesTable->find()->select(['investment_id','user_id'])->where(['investment_id' => $investmentID,'user_id' => $this->loggedInUser->id])->first();

        if($query != null){

            $this->log('Couldn\'t add like, User: '.$this->loggedInUser->email.', User ID: '.$this->loggedInUser->id.', IP Address: '.$_SERVER['REMOTE_ADDR'].', Investment ID: '.$investmentID,'error', ['scope' => ['like']]);

            $this->Flash->error("Like Already Exists!");

            return $this->redirect(['action' => 'homepage']);
        }

        if($likesTable->save($newlike)){

            $this->log('Like Added Succesfully!, User: '.$this->loggedInUser->email.', User ID: '.$this->loggedInUser->id.', IP Address: '.$_SERVER['REMOTE_ADDR'].', Investment ID: '.$investmentID,'info', ['scope' => ['like']]);

            $this->Flash->success("The Like has been added.");

            return $this->redirect(['action' => 'homepage']);
            
        }else {
            $this->log('Couldn\'t add like, User: '.$this->loggedInUser->email.', User ID: '.$this->loggedInUser->id.', IP Address: '.$_SERVER['REMOTE_ADDR'].', Investment ID: '.$investmentID,'error', ['scope' => ['like']]);

            $this->Flash->error("Couldn't add like");
        }

        return $this->redirect(['action' => 'homepage']);
    }

    public function dislike($investmentID){

        $likesTable = $this->fetchTable("likes");

        $query = $likesTable->find()->select(['investment_id','user_id'])->where(['investment_id' => $investmentID,'user_id' => $this->loggedInUser->id])->first();

        if($query != null){

            $likeToDelete = $likesTable->get([$investmentID,$this->loggedInUser->id]);

            if ($likesTable->delete($likeToDelete)){
                $this->log('Disliked Succesfully!','info', ['scope' => ['like']]);
                $this->Flash->success("Like has been removed!");
            }
            else{
                $this->log('Couldn\'t remove like','error', ['scope' => ['like']]);
                $this->Flash->error("Couldn't remove like!");
            }

            return $this->redirect(['action' => 'homepage']);

        }else{
            $this->log('Couldn\'t remove like','error', ['scope' => ['like']]);
            $this->Flash->error("Couldn't remove like!");
            return $this->redirect(['action' => 'homepage']);
        }
    }

    public function listLikedUsers($investmentID){

        $likesTable = $this->fetchTable("likes")->find()
        ->contain(["users","investments"])
        ->where(['investment_id' => $investmentID])
        ->toArray();

        $this->set("likedBy", $likesTable);

    }

    public function share($investmentID){

        if($this->request->is('post')){

            $sharesTable = $this->fetchTable('investmentshares');

            $query = $sharesTable->find()->select(['investment_id','user_id'])->where(['investment_id' => $investmentID,'user_id' => $this->request->getData('user_id')])->first();

            if($query != null){
                $this->Flash->error("Share Already Exists!");
                return $this->redirect(['action' => 'homepage']);
            }

            $data = $this->request->getData();
            $data['investment_id'] = $investmentID;
            $data['user_id'] = trim(strip_tags($this->request->getData('user_id')));

            $newShare = $sharesTable->newEntity($data);

            if($sharesTable->save($newShare)){

                $this->Flash->success("The Share has been saved.");

                return $this->redirect(['action' => 'homepage']);
                
            }else {
                $errors = $newShare->getErrors();
        
                $error_messages = "";
                foreach ($errors as $value) {
                    $error_messages .= array_values($value)[0]."<br>";
                }
        
                $this->Flash->error("Something wrong happened<br>$error_messages", ['escape' => false]);
            }

            return $this->redirect(['action' => 'homepage']);

        }

    }

    public function delete($id){

        $investmentsTable = $this->fetchTable("investments");

        $investmentToDelete = $investmentsTable->get($id);

        if ($investmentsTable->delete($investmentToDelete))
            $this->Flash->success("Investment has been deleted!");
        else
            $this->Flash->error("Cannot delete Investment!");

        return $this->redirect(['action' => "my_investments"]);
    }



}
