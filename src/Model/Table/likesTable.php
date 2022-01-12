<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class likesTable extends Table{

    public function initialize(array $config): void{

        $this->belongsTo('users');
        $this->belongsTo('investments');
        
    }
    
}