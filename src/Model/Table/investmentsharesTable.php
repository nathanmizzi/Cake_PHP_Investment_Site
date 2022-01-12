<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class investmentsharesTable extends Table{

    public function initialize(array $config): void{

        $this->belongsTo('users');
        $this->belongsTo('investments');
        
    }
    
}