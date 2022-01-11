<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class usersTable extends Table{

    public function initialize(array $config): void{

        $this->belongsTo('roles');
        $this->belongsTo('shares');
        $this->hasMany('investments');

        $this->setDisplayField('email');
    }
    
}