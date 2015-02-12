<?php
App::uses('AppController', 'Controller');
/**
 * Problems Controller
 *
 * @property Problem $Problem 
 * @property PaginatorComponent $Paginator
 */
class ProblemsController extends AppController {

/**
 *  Layout
 *
 * @var string
 */
	public $layout = 'bootstrap';

/**
 * Helpers
 *
 * @var array
 */
	public $helpers = array('TwitterBootstrap.BootstrapHtml', 'TwitterBootstrap.BootstrapForm', 'TwitterBootstrap.BootstrapPaginator');
/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
/**
 * index method
 *
 * @return void
 */
    public function index() {
        // Sessionメッセージの設定
        $this->Session->setFlash(__('Please select Year and Grade of Test or Original Test.'), 
            'alert', 
            array(
                'plugin' => 'TwitterBootstrap',
                'class' => 'alert',
            ),
            'NoSelect'
        );
        $this->Session->setFlash(__('Data is Empty. Please Select a different Year and Grade for Test.'), 
            'alert', 
            array(
                'plugin' => 'TwitterBootstrap',
                'class' => 'alert-error',
            ),
            'NoData'
        );

        // 過去問題の年度と級を選んだとき
        if ($this->request->is('post')){
            if ($this->request->data['Problems']['ProblemsType'] == 0){ // オリジナル問題の場合
                $year = 0;
                $grade = 0;
            }else{
                $year = $this->request->data['Problems']['year']['year'];
                $grade = $this->request->data['Problems']['grade'];
            }
            // 問題情報を取得
            $problems = $this->Problem->getProblemsData($year, $grade);

            $this->set('problems', $problems['response']);
            $this->set(compact('year', 'grade'));
    	}
    }

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($year = null, $grade = null, $id = null) {
        $problems = $this->Problem->getProblemsData($year, $grade);
        
        $n_problem = $problems['response'][$id]['MoridaiQuestion'];
        // 問題情報整理（問題文、正答、誤答のみにする）
        $problem = $this->Problem->getOrderProblem($n_problem);

		$this->set('problem', $problem);
        $this->set(compact('year', 'grade'));

        // 問題ID取得
        $p_id = $problems['response'][$id]['MoridaiQuestion']['id'];
        $this->loadModel('ProblemPattern');
        $already = $this->ProblemPattern->find('first', array('conditions' => array('problem_id' => $p_id)));
        $kb = '';
        $pattern = '';
        $al_flg = 0; // 0の場合は登録されていない

        if (empty($already)){ // まだ登録されていない問題の場合
            $kb = $this->Problem->convertProblem($problem, $year, $grade); // 知識ベースの各要素を取得
            if ($kb === 'timeout'){
                $this->Session->setFlash(__('Error: DBpedia is timeout. Please try again.'),
                    'alert', 
                    array(
                        'plugin' => 'TwitterBootstrap',
                        'class' => 'alert',
                    ),
                    'timeout'
                );
            }
            $kb['ProblemId'] = $p_id;
            $this->Session->write('KnowledeBase', $kb);
        }else{ // 登録済みの問題の場合
            $this->Session->setFlash(__('Already this problem has been saved.'),
                'alert', 
                array(
                    'plugin' => 'TwitterBootstrap',
                    'class' => 'alert',
                ),
                'already'
            );
            //$pattern = $this->Pattern->find('first', array('conditions' => array('id' => $already['ProblemPattern']['pattern_id'])));

            // DBから各要素を取得
            $pattern = $already['Pattern']; // BelongsToにより

            $conditions = array('problem_id' => $p_id);
            $this->loadModel('ProblemTargetKnowledge');
            $t_knows = $this->ProblemTargetKnowledge->find('all', array('conditions' => $conditions)); // 対象知識は複数の場合もあるため
            $this->loadModel('ProblemCategory');
            $category = $this->ProblemCategory->find('first', array('conditions' => $conditions));
            $this->loadModel('ProblemProperty');
            $properties = $this->ProblemProperty->find('all', array('conditions' => $conditions)); // プロパティは複数の場合もあるため
            $this->loadModel('ProblemObjectData');
            $objects = $this->ProblemObjectData->find('all', array('conditions' => $conditions)); // オブジェクトも複数の場合もあるため
            $al_flg = 1;
            
            // 取ってきた値を$kbに格納
            foreach($t_knows as $key => $value){
                $kb['knowledge']['tknows'][$key] = $value['TargetKnowledge']['name'];
            }
            $kb['Category']['name'] = $category['Category']['name'];

            foreach($properties as $key => $value){
                $kb['knowledge']['properties'][$key] = $value['Property']['name'];
            }

            foreach($objects as $key => $value){
                $kb['knowledge']['objects'][$key] = $value['ObjectData']['name'];
            }

            $kb['Pattern'] = $pattern; 
        }
        $this->set(compact('kb', 'al_flg'));
	}
}
