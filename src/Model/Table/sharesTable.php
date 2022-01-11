<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class sharesTable extends Table{

    public function initialize(array $config): void{

        $this->hasMany('investments');
        $this->hasMany('users');
        
    }
    
}