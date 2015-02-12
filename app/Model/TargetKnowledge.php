<?php
App::uses('AppModel', 'Model');
/**
 * TargetKnowledge Model
 *
 */
class TargetKnowledge extends AppModel {

	public $hasMany = array(
		'ProblemTargetKnowledge' => array(
			'className' => 'ProblemTargetKnowledge',
			'foreignKey' => 'target_knowledge_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * 対象知識の問題一覧を取得する関数
 * @param int $id 対象知識のID
 * @return string[] $result 問題一覧
 */
    public function getProblems($id){
        $problems = '';
        App::import('Model', 'ProblemTargetKnowledge');
        $this->ProblemTargetKnowledge = new ProblemTargetKnowledge;
        $p_ids = $this->ProblemTargetKnowledge->find('list', array('fields' => 'problem_id', 'conditions' => array('target_knowledge_id' => $id)));
        foreach($p_ids as $key => $val){
            $url = "http://sakumon.jp/app/maker/moridai/get_question/".$val.".json";
		    $problems[$key] = json_decode(file_get_contents($url), true);
        }
        return $problems;
    }

/**
 * tknow, category, property, object登録
 * @param string[] $data 知識ベースのデータ
 */
    public function tcopSave($data){
        App::import('Model', 'Category');
        $this->Category = new Category;
        App::import('Model', 'ObjectData');
        $this->ObjectData = new ObjectData;
        App::import('Model', 'Property');
        $this->Property = new Property;
        App::import('Model', 'ProblemPattern');
        $this->ProblemPattern = new ProblemPattern;

        $categories['ProblemCategory']['problem_id'] = $data['ProblemId'];
        $pattern['problem_id'] = $data['ProblemId'];
        $pattern['pattern_id'] = $data['Pattern']['id'];

        // 各要素を抽出
        foreach($data['knowledge']['tknows'] as $val){
            $tknows[] = array('TargetKnowledge' => array('name' => $val), 'ProblemTargetKnowledge' => array(array('problem_id' => $data['ProblemId'])));
        }

        $categories['Category']['name'] = $data['Category']['name'];
        $res = $this->Category->find('first', array('conditions' => array('Category.name' => $data['Category']['parent'][0])));
        if ($res){
            $categories['Category']['parent_id'] = $res['Category']['id'];
        }

        foreach($data['knowledge']['objects'] as $val){
            $objects[] = array('ObjectData' => array('name' => $val), 'ProblemObjectData' => array(array('problem_id' => $data['ProblemId'])));
        }

        foreach($data['knowledge']['properties'] as $val){
            $properties[] = array('Property' =>  array('name' => $val), 'ProblemProperty' => array(array('problem_id' => $data['ProblemId'])));
        }

        // save
        $this->create();
        $this->saveMany($tknows, array('deep' => true));
 
        $this->Category->create();
        $this->Category->save($categories['Category']);
        $categories['ProblemCategory']['category_id'] = $this->Category->id;
        $this->Category->ProblemCategory->save($categories['ProblemCategory']);

        $this->ObjectData->create();
        $this->ObjectData->saveMany($objects, array('deep' => true));
 
        $this->Property->create();
        $this->Property->saveMany($properties, array('deep' => true));

        $this->ProblemPattern->create();
        $this->ProblemPattern->save($pattern);
    }
}
