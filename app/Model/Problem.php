<?php
App::uses('AppModel', 'Model');
/**
 * TargetKnowledge Model
 *
 */
class Problem extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
	);

/**
 * 問題情報取得関数
 * @param int $year 出題年度
 * @param int $grade 出題級 
 * @return json[] $problems 問題情報
 */
    public function getProblemsData($year, $grade){
        $url = "http://sakumon.jp/app/maker/moridai/pasttest/".$grade."/".$year.".json";
		$problems = json_decode(file_get_contents($url), true);

        return $problems;        
    }
}
