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
App::uses('GalleryManagerAppModel', 'GalleryManager.Model');

/**
 * CakePHP GalleryManager Plugin
 *
 * GalleryImage Model
 *
 */
class GalleryImage extends GalleryManagerAppModel {

/**
 * Validation rules
 *
 * @var array $validate
 */
	public $validate = array();

/**
 * Constructor
 *
 * Set the translateable validation messages in the constructor.
 *
 * @return void
 */
	public function __construct($id = false, $table = null, $ds = null) {

		$this->belongsTo['GalleryAlbum'] = array(
			'className' => 'GalleryAlbum',
			'foreignKey' => 'gallery_album_id');

                $this->actsAs = array(
                    'Upload.Upload' => array(
                        'pic' => array(
                            'fields' => array(
                                'dir' => 'pic_dir'
                            )
                        )
                    )
                );

                $this->validate = array(
                    'pic' => array(
                        'rule-1' => array(
                            'rule' => array('isValidExtension', array('jpg', 'png', 'jpeg', 'gif'), false),
                            'message' => 'File does not have a valid extension'
                        ),
                        'rule-2' => array(
                            'rule' => array('isValidMimeType', array('image/png', 'image/git', 'image/jpeg'), false),
                            'message' => 'File is not an Image'
                        ),
                        'rule-2' => array(
                            'rule' => array('isBelowMaxSize', 2 * 1024 * 1024, false),
                            'message' => 'File is larger than the maximum filesize'
                        ),
                        'rule-3' => array(
                            'rule' => 'isSuccessfulWrite',
                            'message' => 'File was unsuccessfully written to the server'
                        )
                    ),
                    'description' => array(
                        'rule' => 'notEmpty',
                        'message' => 'Please enter Description'
                    )
                );

		parent::__construct($id, $table, $ds);

	}

/**
 * Toggle the Field
 *
 * @param string $field
 * @param integer $id
 * @return boolean
 */
	public function toggleField($field, $id = null) {
                return $this->updateAll(array($field => '1 - '. $this->alias.'.'.$field), array($this->alias.'.id' => $id));
        }

/**
 * Move Up the Image in Album
 *
 * @param integer $id
 * @return void
 */
        public function moveup($id = null) {
                $result = $this->find('first', array('conditions' => array($this->alias.'.id' => $id), 'fields' => array('order', 'gallery_album_id')));
                if(empty($result)) {
                        return;
                }
                $currentOrder = $result[$this->alias]['order'];
                $albumId = $result[$this->alias]['gallery_album_id'];

                $newOrder = $currentOrder - 1;
                $this->updateAll(array('order' => $currentOrder), array('gallery_album_id' => $albumId, 'order' => $newOrder));

                $this->updateAll(array('order' => $newOrder), array($this->alias.'.id' => $id));

        }

/**
 * Move Up the Image in Album
 *
 * @param integer $id
 * @return void
 */
        public function movedown($id = null) {
                $result = $this->find('first', array('conditions' => array($this->alias.'.id' => $id), 'fields' => array('order', 'gallery_album_id')));
                if(empty($result)) {
                        return;
                }
                $currentOrder = $result[$this->alias]['order'];
                $albumId = $result[$this->alias]['gallery_album_id'];

                $newOrder = $currentOrder + 1;
                $this->updateAll(array('order' => $currentOrder), array('gallery_album_id' => $albumId, 'order' => $newOrder));

                $this->updateAll(array('order' => $newOrder), array($this->alias.'.id' => $id));

        }

/**
 * Delete the Image and adjust the order Field accordingly
 *
 * @param integer $id
 * @return void
 */
        public function updateOrderAndDelete($id = null) {
                $result = $this->find('first', array('conditions' => array($this->alias.'.id' => $id), 'fields' => array('order', 'gallery_album_id')));
                if(empty($result)) {
                        return;
                }
                $currentOrder = $result[$this->alias]['order'];
                $albumId = $result[$this->alias]['gallery_album_id'];

                $this->updateAll(array('order' => $this->alias.'.order - 1'), array('gallery_album_id' => $albumId, 'order >' => $currentOrder));
                $this->delete($id);
        }
/**
 * Callback
 *
 * @param integer $created
 * @return boolean
 */
        public function afterSave($created = null) {

                if(!$created) {
                        return true;
                }

                $order = $this->field('order', array($this->alias.'.gallery_album_id' => $this->data[$this->alias]['gallery_album_id']), 'order DESC');
                $this->saveField('order', $order + 1, array('callbacks' => false));
                return true;
        }
}