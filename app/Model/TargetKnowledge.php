<?php
App::uses('AppModel', 'Model');
/**
 * TargetKnowledge Model
 *
 */
class TargetKnowledge extends AppModel {

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
}
