<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class tickersTable extends Table{

    public function initialize(array $config): void{

        $this->hasMany('investments');

        $this->setDisplayField('ticker_name');
    }
    
}