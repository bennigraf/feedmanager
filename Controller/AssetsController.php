<?php
App::uses('AppController', 'Controller');
/**
 * Assets Controller
 *
 * @property Asset $Asset
 */
class AssetsController extends AppController {
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('view');
	}
	
	public function view($asset) {
		// echo 'viewing stuff! yay!'."\n".$asset;
		// $this->autoRender = false;
		$this->viewClass = 'Media';
		
		// $asset contains filename incl. ending, we don't need that for uid...
		$uid = substr($asset, 0, strpos($asset, '.'));
		$ext = substr($asset, strpos($asset, '.'));
		
		$asset = $this->Asset->find('first', array(
			'conditions' => array('Asset.uid' => $uid),
			'contain' => array('Item')));
		
		// debug($asset);
		// echo Configure::read('Pcp.library-path').$asset['Item']['path'].DS.'Contents'.DS.'Resources'.DS.'Published'.DS.$asset['Asset']['path'];
		
		$params = array(
			// file name _with_ extension
			'id' => $asset['Asset']['path'],
			// file name _without_ extension, can be arbitrary
			'name' => $uid.$ext,
			// extension, important for mimetype
			'extension' => $ext,
			// download file or possibly open it in browser? _Don't_ set autoRender to false, doesn't work!!
			'download' 	=> false,
			// mime type array, needed for download, blank page otherwise...
			'mimeType'  => array(
			    $ext => $asset['Asset']['datatype']
			),
			// full path to folder containing file... with trailing /!
//			'path' => Configure::read('Pcp.library-path').$asset['Item']['path'].DS.'Contents'.DS.'Resources'.DS.'Published'.DS,
			'path' => Configure::read('Fdmngr.library-path').$asset['Item']['path'].DS
			
		);
		
		// debug($params);
	    $this->set($params);
	}
	
}
