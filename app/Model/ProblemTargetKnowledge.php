<?php
App::uses('AppModel', 'Model');
/**
 * ProblemTargetKnowledge Model
 *
 * @property TargetKnowledge $TargetKnowledge
 */
class ProblemTargetKnowledge extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'TargetKnowledge' => array(
			'className' => 'TargetKnowledge',
			'foreignKey' => 'target_knowledge_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
