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
	public function view($id = null, $year = null, $grade = null) {
        $problems = $this->Problem->getProblemsData($year, $grade);
        $problem = $problems['response'][$id]['MoridaiQuestion'];
		$this->set('problem', $problem);
        $this->set(compact('year', 'grade'));
	}
}
