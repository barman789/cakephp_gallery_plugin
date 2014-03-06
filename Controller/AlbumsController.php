<?php
/**
 *
 * Copyright 2014, Sandeep Barman
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2014, Sandeep Barman
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('GalleryManagerAppController', 'GalleryManager.Controller');

/**
 * CakePHP GalleryManager Plugin
 *
 * GalleryManager AlbumController
 *
 */
class AlbumsController extends GalleryManagerAppController {

/**
 * helpers variable
 *
 * @var array
 */
	public $helpers = array ('Html', 'Form', 'Js' => 'Jquery');
	
/**
 * components variable
 *
 * @var array
 */
        public $components = array('Paginator');	
	
/**
 * Uses Array
 *
 * @var array
 */
	public $uses = array('GalleryManager.GalleryAlbum');

/**
 * Callback Function
 *
 * @param none
 */
        public function beforeFilter() {
                parent::beforeFilter();
        }
	
/**
 * Displays all the albums in a paginated view
 *
 * @param none
 */
        public function admin_index() {

                $this->Paginator->settings = array(
                        'conditions' => array('GalleryAlbum.deleted' => 0),
                        'contain' => false,
                        'order' => 'GalleryAlbum.id DESC',
                        'limit' => 25
                );
                $albums = $this->Paginator->paginate('GalleryAlbum');             
                $this->set('albums', $albums);
        }

/**
 * Add an Album
 *
 * @param none
 */
        public function admin_add() {
                
                if ($this->request->is('post')) {
                        $this->GalleryAlbum->create();
                        $this->request->data['GalleryAlbum']['user_id'] = $this->Auth->user('id');

                        if ($this->GalleryAlbum->save($this->request->data)) {
                                $this->Session->setFlash(__('Gallery has been added'));
                                $this->redirect(array('action' => 'index'));
                        } else {
                                $this->Session->setFlash(__('Gallery could not be saved. Please, try again.'));
                        }
                }
        }

/**
 * Edit an Album
 *
 * @param integer $id
 */
        public function admin_edit($id = null) {

                if ($this->request->is('post') || $this->request->is('put')) {
                        if ($this->GalleryAlbum->save($this->request->data)) {
                                $this->Session->setFlash(__('Gallery has been saved'));
                                $this->redirect(array('action' => 'index'));
                        } else {
                                $this->Session->setFlash(__('Gallery could not be saved. Please, try again.'));
                        }
                } else {
                        $this->request->data = $this->GalleryAlbum->find('first', array('conditions' => array('GalleryAlbum.id' => $id, 'GalleryAlbum.deleted' => 0), 'contain' => false));
                        if(empty($this->request->data)) {
                            throw new NotFoundException('Album Not Found');
                        }
                }
        }
    
/**
 * Show Slideshow
 *
 * @param integer $id
 */
        public function admin_show($id = null) {

                $result = $this->GalleryAlbum->find('first', array('conditions' => array('GalleryAlbum.id' => $id, 'GalleryAlbum.deleted' => 0), 'contain' => 'GalleryImage'));
                if(empty($result)) {
                        throw new NotFoundException('Not Found');
                }
                $this->set('result', $result);
        }
    
/**
 * Change the Status of the Album
 *
 * @param integer id
 */
        public function admin_status($id = null) {
   
                if($this->request->is('ajax')) {
                        $this->layout = false;
                        $this->GalleryAlbum->toggleField('status', $id);
                        $album = $this->GalleryAlbum->find('first', array('conditions' => array('GalleryAlbum.id' => $id), 'fields' => array('status', 'id'), 'recursive' => -1));
                        $this->set('album', $album);
                        $this->viewPath = 'elements'.DS.'Albums';
                        $this->render('admin_status');
                } else {
                        throw new NotFoundException('Not Found');
                }
        }

/**
 * Delete an Album
 *
 * @param integer $id
 */
        public function admin_delete($id = null) {
   
                if($this->request->is('ajax')) {
                        $this->layout = false;
                        $result = $this->GalleryAlbum->find('first', array('conditions' => array('GalleryAlbum.id' => $id, 'GalleryAlbum.deleted' => 0), 'contain' => false));
                        $this->autoRender = false;
    
                        if(!empty($result)) {
                                $data['GalleryAlbum']['id'] = $id;
                                $data['GalleryAlbum']['deleted'] = 1;
                                $this->GalleryAlbum->save($data);
                        }
                } else {
                        throw new NotFoundException('Not Found');
                }
        }         
}