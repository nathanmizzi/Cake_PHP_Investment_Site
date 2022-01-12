<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class usersTable extends Table{

    public function initialize(array $config): void{

        $this->belongsTo('roles');
        $this->hasMany('investments');
        $this->hasMany('investmentshares');
        $this->hasMany('likes');

        $this->setDisplayField('email');
    }
    
}