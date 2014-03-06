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
 * GalleryManager ImagesController
 *
 */
class ImagesController extends GalleryManagerAppController {

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
	public $uses = array('GalleryManager.GalleryImage');
	
/**
 * Callback Function
 *
 * @param none
 */

        public function beforeFilter() {
                parent::beforeFilter();
        }
/**
 * Displays all the images for an album
 *
 * @param integer $id
 */
        public function admin_index($id = null) {

                $album = $this->GalleryImage->GalleryAlbum->find('first', array('conditions' => array('GalleryAlbum.id' => $id, 'GalleryAlbum.deleted' => 0), 'contain' => false));
                if(empty($album)) {
                        throw new NotFoundException('Album Not Found');  
                } 
                $this->set('album', $album);

                $images = $this->GalleryImage->find('all',  array('conditions' => array('GalleryImage.gallery_album_id' => $id), 'order' => 'GalleryImage.order', 'contain' => false));
                $this->set('images', $images);
        }
  

/**
 * Add an Image
 *
 * @param integer $gallery_album_id
 */
        public function admin_add($gallery_album_id = null) {

                if ($this->request->is('post')) {
                        $this->GalleryImage->create();
                        if ($this->GalleryImage->save($this->request->data)) {
                                $this->Session->setFlash(__('Image has been added'));
                                $this->redirect(array('controller' => 'images', 'action' => 'index', $this->request->data['GalleryImage']['gallery_album_id']));
                        } else {
                                $this->Session->setFlash(__('Image could not be saved. Please, try again.'));
                        }
                } else {
                        $result = $this->GalleryImage->GalleryAlbum->find('first', array('conditions' => array('GalleryAlbum.id' => $gallery_album_id, 'GalleryAlbum.deleted' => 0), 'contain' => false));
                        if(empty($result)) {
                                throw new NotFoundException('Album Not Found');
                        }            
                        $this->request->data['GalleryImage']['gallery_album_id'] = $gallery_album_id;
                }
        }

/**
 * Edit an Image
 *
 * @param integer $id
 */
        public function admin_edit($id = null) {

                if ($this->request->is('post') || $this->request->is('put')) {
                        if ($this->GalleryImage->save($this->request->data)) {
                                $this->Session->setFlash(__('Image has been saved'));
                                $this->redirect(array('controller' => 'images', 'action' => 'index', $this->request->data['GalleryImage']['gallery_album_id']));
                        } else {
                                $this->Session->setFlash(__('Image could not be saved. Please, try again.'));
                        }
                } else {
                        $this->request->data = $this->GalleryImage->find('first', array('conditions' => array('GalleryImage.id' => $id), 'contain' => false));
                        if(empty($this->request->data)) {
                                throw new NotFoundException('Image Not Found');
                        }
                }
        }
           
/**
 * Change the Status of the Image
 *
 * @param integer $id
 */
        public function admin_status($id = null) {
        
                if($this->request->is('ajax')) {
                        $this->layout = false;
                        $this->GalleryImage->toggleField('status', $id);
                        $image = $this->GalleryImage->find('first', array('conditions' => array('GalleryImage.id' => $id), 'fields' => array('status', 'id'), 'recursive' => -1));
                        $this->set('image', $image);
                        $this->viewPath = 'elements'.DS.'Images';
                        $this->render('admin_status');    
                } else {
                        throw new NotFoundException('Not Found');
                }
       }

/**
 * Delete an Image
 *
 * @param integer $id
 */
        public function admin_delete($id = null) {
   
                if($this->request->is('ajax')) {
                        $this->layout = false;
                        $result = $this->GalleryImage->updateOrderAndDelete($id);
                        $this->autoRender = false;
                } else {
                        throw new NotFoundException('Not Found');
                }
        }         
 
/**
 * Moveup an Image
 *
 * @param integer $id
 */
        public function admin_moveup($id = null) {
   
                if($this->request->is('ajax')) {
                        $this->layout = false;
                        $this->GalleryImage->moveup($id);
                        $this->autoRender = false;
                } else {
                        throw new NotFoundException('Not Found');
                }
        }    

/**
 * Movedown an Image
 *
 * @param integer $id
 */
        public function admin_movedown($id = null) {
   
                if($this->request->is('ajax')) {
                        $this->layout = false;
                        $this->GalleryImage->movedown($id);
                        $this->autoRender = false;
                } else {
                        throw new NotFoundException('Not Found');
                }
        }      
}