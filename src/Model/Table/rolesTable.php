<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class rolesTable extends Table{

    public function initialize(array $config): void{

        $this->hasMany('users');

        $this->setDisplayField('role_name');
    }
    
}