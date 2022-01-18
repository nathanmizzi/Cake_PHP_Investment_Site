<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class investmentsTable extends Table{

    
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->notBlank('ticker_id', 'Ticker is required')
            ->requirePresence('shares')
            ->notBlank('shares', 'Shares ammount required!')
            ->numeric('shares','Shares must be numeric!')
            ->greaterThan('shares', 0, 'Shares at needs to be greater than 0!')
            ->requirePresence('boughtAt')
            ->notBlank('boughtAt', 'Bought At is required')
            ->numeric('boughtAt','Bought At must be numeric!')
            ->greaterThan('boughtAt', 0, 'Bought at needs to be greater than 0!')
            ->allowEmptyString('notes')
            ->minLength('notes',20,'Notes must be more then 20 characters')
            ->requirePresence('imagePath', 'Image is required!')
            ->add('imagePath', [
                'validExtension' => [
                    'rule' => ['extension',[ 'jpeg', 'png', 'jpg']],
                    'message' => __('Must be a valid file extension')
                ]
            ]);

        return $validator;
    }
    

    public function initialize(array $config): void{

        $this->belongsTo('tickers');
        $this->belongsTo('users');

        $this->hasMany('investmentshares' , ['dependent' => true, 'cascadeCallbacks' => true]);
        $this->hasMany('likes', ['dependent' => true, 'cascadeCallbacks' => true]);

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created_at' => 'new',
                    'updated_at' => 'always',
                ],
                'Orders.completed' => [
                    'completed_at' => 'always'
                ]
            ]
        ]);
    }


}