<?php
App::uses('AppController', 'Controller');
/**
 * Items Controller
 *
 * @property Item $Item
 */
class ItemsController extends AppController {
	
	
	public function assign() {
		if($this->request->is('ajax')) {
			// $itemid = $this->data['itemid'];
			// $feedids = $this->data['feedids'];
			$itemid = $this->request->query['itemid'];
			$feedids = $this->request->query['feedids'];
			// debug($this->request);
			// debug($feedids);
			
			// get all existing links
			$existingLinks = $this->Item->FeedsItem->find('all', array(
				'conditions' => array(
					'FeedsItem.item_id' => $itemid
				),
				'recursive' => -1
			));
			$existingLinksFeedIds = array();
			foreach ($existingLinks as $eL) {
				$existingLinksFeedIds[] = $eL['FeedsItem']['feed_id'];
			}
			
			if(is_array($feedids) && sizeof($feedids) > 0) {
				// add those that haven't been there already
				foreach ($feedids as $feedid) {
					// check if link was already made to prevent duplicates...
					if(!in_array($feedid, $existingLinksFeedIds)) {
						// count items in feed for order-field
						$itemsinfeed = $this->Item->FeedsItem->find('count', array(
							'conditions' => array(
								'FeedsItem.feed_id' => $feedids
							), 'recursive' => -1
						));
						$this->Item->FeedsItem->create();
						$this->Item->FeedsItem->save(array('FeedsItem' => array(
							'feed_id' => $feedid,
							'item_id' => $itemid,
							'order' => $itemsinfeed + 1
						)));
					} else {
						// remove id from $existingLinksFeedIds to keep track of the ones to be removed
						unset($existingLinksFeedIds[array_search($feedid, $existingLinksFeedIds)]);
					}
				}
			}
			
			// remove those that aren't there no more (and keep track of sorting order!)
			if(sizeof($existingLinksFeedIds) > 0) {
				foreach ($existingLinksFeedIds as $feedid) {
					$item = $this->Item->FeedsItem->find('first', array(
						'conditions' => array(
							'FeedsItem.feed_id' => $feedid,
							'FeedsItem.item_id' => $itemid
						)
					));
					
					// decrement all item-order-positioning-field-values of items after this one
					$fitems = $this->Item->FeedsItem->find('all', array(
						'conditions' => array(
							'FeedsItem.feed_id' => $feedid,
							'FeedsItem.order >' => $item['FeedsItem']['order']
						))
					);
					foreach ($fitems as $itm) {
						$this->Item->FeedsItem->id = $itm['FeedsItem']['id'];
						$this->Item->FeedsItem->saveField('order', $itm['FeedsItem']['order'] - 1);
					}

					// cascading is okay here since FeedsItem only belongsTo Feed and Item, would be troublesome on hasMany and habtm
					$this->Item->FeedsItem->delete($item['FeedsItem']['id']);
				}
			}
			
			// get the newly assigned feeds!
			$feedtitles = array();
			if(is_array($feedids) && sizeof($feedids) > 0) {
				$feeds = $this->Item->Feed->find('all', array(
					'conditions' => array('id in ('.implode($feedids, ',').')'),
					'recursive' => -1
				));
				foreach ($feeds as $feed) {
					$feedtitles[] = $feed['Feed']['title'];
				}
			} else {
			}
			$array = array(
				'pre-existing links:' => sizeof($existingLinks),
				'deleted links:' => sizeof($existingLinksFeedIds),
				'assignedTo' => $feedtitles
			);
			return new CakeResponse(array('body' => json_encode($array), 'status' => 200));
		}
		
		if (isset($this->request->named['itemid']) && isset($this->request->named['feedid'])) {
			
		}
		
		if (!empty($this->request->named['show'])) {
			$show = $this->request->named['show'];
		} else {
			$show = 'all';
		}
		
		$items = $this->Item->find('all', array(
			'contain' => array('Asset', 'Feed'),
			'order' => array('Item.id DESC'),
			'conditions' => array('Item.deleted' => 0)
		));
		
		if ($show == 'unassigned') {
			foreach ($items as $key => $item) {
				if (!empty($item['Feed'])) {
					unset($items[$key]);
				}
			}
		}
		
		foreach ($items as $key => $item) {
			$items[$key]['Item']['assignedFeedIds'] = array();
			foreach ($item['Feed'] as $fd) {
				$items[$key]['Item']['assignedFeedIds'][] = $fd['id'];
			}
		}
		
		$feeds = $this->Item->Feed->find('all', array(
			'recursive' => -1
		));
		
		$this->set(compact('items', 'feeds', 'show'));
	}
	
	
	
	public function unlink() {
		
		if (isset($this->request->named['itemid']) && isset($this->request->named['feedid'])) {	
			// get this link
			$item = $this->Item->FeedsItem->find('first', array(
				'conditions' => array(
					'FeedsItem.feed_id' => $this->request->named['feedid'],
					'FeedsItem.item_id' => $this->request->named['itemid']
				)
			));
			// decrement all item-order-positioning-field-values of items after this one
			$fitems = $this->Item->FeedsItem->find('all', array(
				'conditions' => array(
					'FeedsItem.feed_id' => $this->request->named['feedid'],
					'FeedsItem.order >' => $item['FeedsItem']['order']
				))
			);
			foreach ($fitems as $itm) {
				$this->Item->FeedsItem->id = $itm['FeedsItem']['id'];
				$this->Item->FeedsItem->saveField('order', $itm['FeedsItem']['order'] - 1);
			}
			
			// cascading is okay here since FeedsItem only belongsTo Feed and Item, would be troublesome on hasMany and habtm
			$this->Item->FeedsItem->delete($item['FeedsItem']['id']);
			$this->redirect(array('action'=>'assign'));
		}
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$items = $this->Item->find('all', array(
			'contain' => array('Asset'),
			'order' => array('Item.id DESC'),
			'conditions' => array('Item.deleted' => 0)
		));
		$this->set('items', $items);
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Item->id = $id;
		if (!$this->Item->exists()) {
			throw new NotFoundException(__('Invalid item'));
		}
		$this->set('item', $this->Item->read(null, $id));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Item->id = $id;
		if (!$this->Item->exists()) {
			throw new NotFoundException(__('Invalid item'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Item->save($this->request->data)) {
				$this->redirect('index');
			}
		} else {
			$this->request->data = $this->Item->read(null, $id);
		}
		// $feeds = $this->Item->Feed->find('list');
		// $this->set(compact('feeds'));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		/*
			!!! TODO: pcastconfig --sync_library !!!
		 */
		$this->Item->id = $id;
		if (!$this->Item->exists()) {
			throw new NotFoundException(__('Invalid item'));
		}
		if (isset($this->request->named['confirmed']) && $this->request->named == true) {
			$item = $this->Item->find('first', array('conditions' => array('Item.id' => $id)));
			
			// trying to delete data from harddisk
			$path = Configure::read('Fdmngr.library-path');
			$path .= $item['Item']['path'];
			if ($path == Configure::read('Fdmngr.library-path')) {
				die('Shit happens: '.$path);
			}
			$deletedDir = delete_directory($path);
			
			// if actual asset was deleted, delete db entry, otherwise set db item to 'deleted'
			if ($deletedDir) {
				$this->Item->delete(); // tried cascading, didn't work, doing it by hand...
				$this->Item->Asset->deleteAll(array('Asset.item_id' => $id));
			} else {
				$this->Item->id = $id;
				$this->Item->saveField('deleted', true);
			}
			$this->redirect('/items/index');
		} else {
			$item = $this->Item->find('first', array(
				'contain' => array('Asset', 'Feed'),
				'conditions' => array('Item.id' => $id)
			));
			$this->set(compact('item'));
		}
		
/*		if ($this->Item->delete()) {
			$this->flash(__('Item deleted'), array('action' => 'index'));
		}
		$this->flash(__('Item was not deleted'), array('action' => 'index'));
		$this->redirect(array('action' => 'index')); */
	}
	
	/**
	 * import method
	 * 
	 * used to import assets into media library and create an item from them
	 */
	public function import() {
		App::uses('Folder', 'Utility');
		App::uses('File', 'Utility');
		
		$path = Configure::read('Fdmngr.import-path');
		
		$dir = new Folder($path);
		list($dirs, $files) = $dir->read();
		
		// print_r($files);
		
		$this->set('files', $files);
		
	}

	/**
	 * add method
	 *
	 * @return void
	 */
		public function add() {
			App::uses('String', 'Utility'); // for uuid
			App::uses('Folder', 'Utility');
			App::uses('File', 'Utility');
			
			if ($this->request->is('post')) {
				// check if item data has been set or only assets have been selected
				// print_r($this->request->data['Item']['files']);
				
				// if no files have been selected yet, return to selection
				if(empty($this->request->data['Item']['files'])) {
					$this->redirect(array('action' => 'import'));
				} 
				
				// if files are selected, populize some fields with some data for later processing
				// (and listing under the form);
				if(!empty($this->request->data['Item']['files'])) {
					// get files to list them below the form
					$path = Configure::read('Fdmngr.import-path');
					$dir = new Folder($path);
					list($dirs, $files) = $dir->read();
					$selectedfiles = array();
					foreach ($this->request->data['Item']['files'] as $fileid) {
						array_push($selectedfiles, array('id'=>$fileid, 'path'=>$files[$fileid]));
					}
					// print_r($selectedfiles);
					$this->set('selectedfiles', $selectedfiles);
					
				}
				
				// if there is a title, we can copy the files and save the item and the asset objects
				if(!empty($this->request->data['Item']['title'])) {
					
					// used for parsing assets and retrieve format and duration in seconds
					App::import('Vendor', 'getid3/getid3');
					$getID3 = new getID3;
					
					// create the Item object for later saving
					$this->Item->create();
					$itemuid = String::uuid();
					$item = array(
						'Item' => array(
							'uid' => $itemuid,
							'title' => $this->request->data['Item']['title'],
							'author' => $this->request->data['Item']['author'],
							'summary' => $this->request->data['Item']['summary'],
							'path' => DS.date("Y")."-".date("m").DS.$itemuid,
							'pubDate' => date('r'),
							'deleted' => 0
						),
						'Asset' => array()
					);
					// print_r($item);
					
					// get some paths...
					$sourcepath = Configure::read('Fdmngr.import-path');
					$sourcedir = new Folder($sourcepath);
					$mediapath = Configure::read('Fdmngr.library-path');
					$mediadir = new Folder($mediapath);
					
					$itempath = $mediapath.$item['Item']['path'];
					$itemdir = new Folder();
					$itemdir->create($itempath);
					
					// copy selected files over to library and create assets for each one
					$assetscopied = true;
					foreach ($selectedfiles as $file) {
						$assetuid = String::uuid();
						$asset_file = new File($sourcepath.DS.$file['path']);
						$asset_ending = substr($file['path'], strrpos($file['path'], '.') + 1);
						$newassetpath = $itempath.DS.$assetuid.'.'.$asset_ending;
						
						if($asset_file->copy($newassetpath)) {
							// if copy was successfull, add asset object to item object 
							// this later stores everything together

							$asset_fileinfo = $getID3->analyze($newassetpath);
							$asset_format = shell_exec(Configure::read('mdls')." -name kMDItemContentType -raw '".$asset_file->path."'");
							
							// print_r($asset_fileinfo);
							
							$asset = array(
								'uid' => $assetuid,
								'path' => $assetuid.'.'.$asset_ending,
								'format' => $asset_format,
								'datatype' => $asset_fileinfo['mime_type'],
								'length' => $asset_file->size(),
								'duration' => round($asset_fileinfo['playtime_seconds'])
							);
							
							array_push($item['Asset'], $asset);
						} else {
							$assetscopied = false;
						}
					}	
					
					if($this->Item->saveAssociated($item)) {
						$asset_file->delete();
						$this->redirect(array('action' => 'index'));
					}
				}
				
				// if there is no title, generate one from the selected files
				// by setting the request data, the form gets populated automatically
				if(empty($this->request->data['Item']['title'])) {
					$titlegiver = $selectedfiles[0]['path'];
					$itemtitle = substr($titlegiver, 0, strrpos($titlegiver, '.'));
					$this->request->data['Item']['title'] = $itemtitle;
				}
				
				
				// print_r($this->request->data);
			
				
				// print_r($item);
			
				// if ($this->Item->save($this->request->data)) {
					// $this->flash(__('Item saved.'), array('action' => 'index'));
				// }
			}
			// $feeds = $this->Item->Feed->find('list');
			// $this->set(compact('feeds'));
		}
	
	
}
