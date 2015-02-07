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
		$this->set('targetKnowledges', $this->Paginator->paginate());
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

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->TargetKnowledge->id = $id;
		if (!$this->TargetKnowledge->exists()) {
			throw new NotFoundException(__('Invalid %s', __('target knowledge')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
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
		} else {
			$this->request->data = $this->TargetKnowledge->read(null, $id);
		}
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->TargetKnowledge->id = $id;
		if (!$this->TargetKnowledge->exists()) {
			throw new NotFoundException(__('Invalid %s', __('target knowledge')));
		}
		if ($this->TargetKnowledge->delete()) {
			$this->Session->setFlash(
				__('The %s deleted', __('target knowledge')),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('The %s was not deleted', __('target knowledge')),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}

}
