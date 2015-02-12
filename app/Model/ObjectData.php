<?php
App::uses('AppModel', 'Model');
/**
 * ObjectData Model
 *
 */
class ObjectData extends AppModel {

	public $hasMany = array(
		'ProblemObjectData' => array(
			'className' => 'ProblemObjectData',
			'foreignKey' => 'object_data_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
