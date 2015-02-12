<?php
App::uses('AppModel', 'Model');
/**
 * ProblemObjectData Model
 *
 * @property ObjectData $ObjectData
 */
class ProblemObjectData extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ObjectData' => array(
			'className' => 'ObjectData',
			'foreignKey' => 'object_data_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
