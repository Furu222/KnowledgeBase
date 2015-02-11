<?php
App::uses('AppController', 'Controller');
/**
 * TargetKnowledges Controller
 *
 * @property TargetKnowledge $TargetKnowledge
 * @property PaginatorComponent $Paginator
 */
class TargetKnowledgesController extends AppController {

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
        $this->TargetKnowledge->recursive = 0;

        // Categoryのルートがあるかを判定
        $this->loadModel('Category');
        if($this->Category->find('count') == 0){ // Categoryがなにもないとき
            $this->Session->setFlash(__('At first please decide root category for KnowledgeBase.'), 'alert', 
                array(
                    'plugin' => 'TwitterBootstrap',
                    'class' => 'alert-error',
                )
            );
            $this->redirect(array('controller' => 'Categories', 'action' => 'add')); // ルートの追加
        }else if ($this->TargetKnowledge->find('count') == 0){ // 対象知識がないとき
            $this->Session->setFlash(__('Please select problems list for construct knowledgebase.'),
                'alert', 
                array(
                    'plugin' => 'TwitterBootstrap',
                    'class' => 'alert-error',
                )
            );
            $this->redirect(array('controller' => 'Problems', 'action' => 'index'));
        }else{
		    $this->set('targetKnowledges', $this->Paginator->paginate());
        }
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->TargetKnowledge->id = $id;
		if (!$this->TargetKnowledge->exists()) {
			throw new NotFoundException(__('Invalid %s', __('target knowledge')));
		}
		$this->set('targetKnowledge', $this->TargetKnowledge->read(null, $id));
        $problems = $this->TargetKnowledge->getProblems($id); // 対象知識の問題一覧を取得
        $this->set('problems', $problems);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->TargetKnowledge->create();
			if ($this->TargetKnowledge->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('target knowledge')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('target knowledge')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		}
	}
}
