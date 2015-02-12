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

        $tknows = '';
        $objects = '';
        $properties = '';
        $tknows_flg = 0;
        $objects_flg = 0;
        $properties_flg = 0;
        $categoris_flg = 0;
        $categories['ProblemCategory']['problem_id'] = $data['ProblemId'];
        $pattern['problem_id'] = $data['ProblemId'];
        $pattern['pattern_id'] = $data['Pattern']['id'];

        // 各要素を抽出
        foreach($data['knowledge']['tknows'] as $val){
            $uni_conf = $this->find('first', array('conditions' => array('name' => $val))); // 重複確認
            if (!$uni_conf){ // データがない場合
                $tknows[] = array('TargetKnowledge' => array('name' => $val), 'ProblemTargetKnowledge' => array(array('problem_id' => $data['ProblemId'])));
            }else{
                $tknows[] = array('ProblemTargetKnowledge' => array('problem_id' => $data['ProblemId'], 'target_knowledge_id' => $uni_conf['TargetKnowledge']['id']));
                $tknows_flg = 1;
            }
        }

        $categories['Category']['name'] = $data['Category']['name'];
        $uni_conf = $this->Category->find('first', array('conditions' => array('Category.name' => $categories['Category']['name'])));
        if ($uni_conf){ // 重複あるとき
            $categories['ProblemCategory']['category_id'] = $uni_conf['Category']['id']; 
            $categoris_flg = 1;
        }else{
            $res = $this->Category->find('first', array('conditions' => array('Category.name' => $data['Category']['parent'][0])));
            if ($res){ // 親カテゴリの判定
                $categories['Category']['parent_id'] = $res['Category']['id'];
            }
        }

        foreach($data['knowledge']['objects'] as $val){
            $uni_conf = $this->ObjectData->find('first', array('conditions' => array('ObjectData.name' => $val)));
            if (!$uni_conf){
                $objects[] = array('ObjectData' => array('name' => $val), 'ProblemObjectData' => array(array('problem_id' => $data['ProblemId'])));
            }else{
                $objects[] = array('ProblemObjectData' => array('problem_id' => $data['ProblemId'], 'object_data_id' => $uni_conf['ObjectData']['id']));
                $objects_flg = 1;
            }
        }

        foreach($data['knowledge']['properties'] as $val){
            $properties[] = array('Property' =>  array('name' => $val), 'ProblemProperty' => array(array('problem_id' => $data['ProblemId'])));
        }

        // save
        $this->create();
        if ($tknows_flg == 0){ 
            $this->saveMany($tknows, array('deep' => true));
        }else{
            $this->ProblemTargetKnowledge->saveMany($tknows);
        }
 
        $this->Category->create();
        if ($categoris_flg == 0){
            $this->Category->save($categories['Category']);
            $categories['ProblemCategory']['category_id'] = $this->Category->id;
        }
            $this->Category->ProblemCategory->save($categories['ProblemCategory']);

        $this->ObjectData->create();
        if ($objects_flg == 0){
            $this->ObjectData->saveMany($objects, array('deep' => true));
        }else{
            $this->ObjectData->ProblemObjectData->saveMany($objects);
        }
 
        $this->Property->create();
        $this->Property->saveMany($properties, array('deep' => true));

        $this->ProblemPattern->create();
        $this->ProblemPattern->save($pattern);
    }
}
