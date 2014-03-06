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
 * GalleryAlbum Model
 *
 */
class GalleryAlbum extends GalleryManagerAppModel {

/**
 * Validation rules
 *
 * @var array $validate
 */
        public $validate = array();

/**
 * Constructor
 *
 * Set the validation rules and associations  in the constructor.
 *
 * @return void
 */
	public function __construct($id = false, $table = null, $ds = null) {
		$userClass = Configure::read('App.UserClass');
		if (empty($userClass)) {
			$userClass = 'User';
		}

		$this->belongsTo['User'] = array(
			'className' => $userClass,
			'foreignKey' => 'user_id');
		$this->hasMany['GalleryImage'] = array(
			'className' => 'GalleryImage');
   			
		parent::__construct($id, $table, $ds);
		$rules = array(
			'notEmpty' => array(
				'rule' => 'notEmpty'));

		$this->validate = array(
			'name' => array(
				'required' => $rules['notEmpty']));
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
}