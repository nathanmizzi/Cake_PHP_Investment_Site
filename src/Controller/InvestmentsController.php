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
        $investmentsTable = $this->fetchTable('investments')->find()->contain(['tickers'])->order(['created' => 'DESC'])->all();
        $this->set("allInvestments", $investmentsTable);
	}

    public function add(){

        $tickersTable = $this->fetchTable('tickers');

        $tickers = $tickersTable->find('list')->toArray();

        $this->set("tickers", $tickers);

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
