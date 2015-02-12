<?php
App::uses('AppModel', 'Model');
/**
 * Property Model
 *
 */
class Property extends AppModel {

    public $hasMany = array(
        'ProblemProperty' => array(
            'className' => 'ProblemProperty',
            'foreignKey' => 'property_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    
}
