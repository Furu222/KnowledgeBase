<?php
App::uses('AppModel', 'Model');
/**
 * ProblemPattern Model
 *
 * @property Pattern $Pattern
 */
class ProblemPattern extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Pattern' => array(
			'className' => 'Pattern',
			'foreignKey' => 'pattern_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
