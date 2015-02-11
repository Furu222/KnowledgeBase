<?php
App::uses('AppModel', 'Model');
/**
 * ProblemObject Model
 *
 * @property Object $Object
 */
class ProblemObject extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Object' => array(
			'className' => 'Object',
			'foreignKey' => 'object_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
