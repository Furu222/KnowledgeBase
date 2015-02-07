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
        // 過去問題の年度と級を選んだとき
        if ($this->request->is('post')){
            $year = $this->request->data["Problems"]['year']['year'];
            $grade = $this->request->data["Problems"]['grade'];
            // 問題情報を取得
            $problems = $this->Problem->getProblemsData($year, $grade);

            $this->set('problems', $problems['response']);
            $this->set(compact('year', 'grade'));
        }else{
            $this->set('problems', 'Please Select Year and Grade for Test');
        }
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
//		$this->Problem->id = $id;
//		if (!$this->Problem->exists()) {
//			throw new NotFoundException(__('Invalid %s', __('Problem')));
//		}
//		$this->set('problems', $this->Problem->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
//		if ($this->request->is('post')) {
//			$this->Problem->create();
//			if ($this->Problem->save($this->request->data)) {
//				$this->Session->setFlash(
//					__('The %s has been saved', __('problem')),
//					'alert',
//					array(
//						'plugin' => 'TwitterBootstrap',
//						'class' => 'alert-success'
//					)
//				);
//				$this->redirect(array('action' => 'index'));
//			} else {
//				$this->Session->setFlash(
//					__('The %s could not be saved. Please, try again.', __('problem')),
//					'alert',
//					array(
//						'plugin' => 'TwitterBootstrap',
//						'class' => 'alert-error'
//					)
//				);
//			}
//		}
	}
}
