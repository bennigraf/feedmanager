<?php
App::uses('AppController', 'Controller');
/**
 * Feeds Controller
 *
 * @property Feed $Feed
 */
class FeedsController extends AppController {
	
	public $components = array('RequestHandler');
	public $helpers = array('bRss');
	
	function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('view');
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		// $this->Feed->recursive = 0;
		// $this->set('feeds', $this->paginate());
		$feeds = $this->Feed->find('all', array(
			'contain' => array(
				'Item' => array(
					'conditions' => array('Item.deleted' => 0),
					// 'Asset'
				)
			)
		));
		
		// get assets seperatly for performance reasons
		// first get all assets
		$allassets = $this->Feed->Item->Asset->find('all');
		// rearrange them by asset id -- there's some automagic function for that but I'm to lazy to look it up right now
		$assetByItemId = array();
		// BUG: assetbyitemid overrides cases where multiple assests have the same itemid... duh!
		foreach ($allassets as $key => $asset) {
			$assetItemId = $asset['Asset']['item_id'];
			$assetByItemId[$assetItemId] = $asset['Asset'];
		}
		// assign assets to feed-items
		foreach ($feeds as $fkey => $feed) {
			foreach ($feed['Item'] as $ikey => $item) {
				if(isset($assetByItemId[$item['id']])) {
					$feeds[$fkey]['Item'][$ikey]['Asset'][] = $assetByItemId[$item['id']];
				}
			}
		}
		
		
		
		// find out if there are hd, sd and/or audio-only assets for each feed
		$confFormats = Configure::read('itunesu-format-codes');
		foreach ($feeds as $key => $feed) {
			// extract all formats from assets
			$formats = array();
			foreach ($feed['Item'] as $item) {
				if(isset($item['Asset'])) {
					foreach ($item['Asset'] as $asset) {
						if (!in_array($asset['format'], $formats)) {
							$formats[] = $asset['format'];
						}
					}
				}
			}
			
			$feedFormats = array(); // holds i.e. ['hd' => true, 'audio' => true] etc.
			// check if formats are for hd, sd, audio
			foreach ($confFormats as $form => $cF) {
				foreach ($formats as $f) {
					if (in_array($f, $cF)) {
						$feedFormats[$form] = true;
					}
				}
			}
			$feeds[$key]['Feed']['formats'] = $feedFormats;
		}
		$this->set(compact('feeds'));
	}
	
	
	public function order($feedid) {
		if (!empty($this->request->params['named']['item']) && !empty($this->request->params['named']['go'])) {
			$thislink = $this->Feed->FeedsItem->find('first', array(
				'conditions' => array('FeedsItem.feed_id' => $feedid, 'FeedsItem.item_id' => $this->request->named['item']),
				'recursive' => -1
			));
			if ($this->request->named['go'] == 'up') {
				$theotherlink = $this->Feed->FeedsItem->find('first', array(
					'conditions' => array('FeedsItem.feed_id' => $feedid, 
											'FeedsItem.order' => $thislink['FeedsItem']['order'] - 1),
					'recursive' => -1
				));
				$this->Feed->FeedsItem->updateAll(
					array('FeedsItem.order' => $thislink['FeedsItem']['order'] - 1),
					array('FeedsItem.item_id' => $this->request->named['item'],
							'FeedsItem.feed_id' => $feedid)
				);
				$this->Feed->FeedsItem->updateAll(
					array('FeedsItem.order' => $thislink['FeedsItem']['order']),
					array('FeedsItem.id' => $theotherlink['FeedsItem']['id'])
				);
			}
			if ($this->request->named['go'] == 'down') {
				$theotherlink = $this->Feed->FeedsItem->find('first', array(
					'conditions' => array('FeedsItem.feed_id' => $feedid, 
											'FeedsItem.order' => $thislink['FeedsItem']['order'] + 1),
					'recursive' => -1
				));
				$this->Feed->FeedsItem->updateAll(
					array('FeedsItem.order' => $thislink['FeedsItem']['order'] + 1),
					array('FeedsItem.item_id' => $this->request->named['item'],
							'FeedsItem.feed_id' => $feedid)
				);
				$this->Feed->FeedsItem->updateAll(
					array('FeedsItem.order' => $thislink['FeedsItem']['order']),
					array('FeedsItem.id' => $theotherlink['FeedsItem']['id'])
				);
			}
			$this->redirect('/feeds/order/'.$feedid);
		}
		
		$feed = $this->Feed->find('first', array(
			'contain' => array(
				'Item'
			),
			'conditions' => array('Feed.id' => $feedid)
		));
		$feed['Item'] = Set::sort($feed['Item'], '{n}.FeedsItem.order', 'ASC');
		
		$this->set(compact('feed'));
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($slug = null) {
		$this->layout = 'default';
		$this->helpers[] = 'Feedmanager';
		// pr($this->request);
		$assetConditions = array();
		$format = null;
		if (!empty($this->request->params['named']['format'])) {
			$format = $this->request->params['named']['format'];
		} else if (!empty($this->request->params['format'])) {
			$format = $this->request->params['format'];
		}

		// echo 'slughere: '; echo $slug;
		// pr($slug);
		// debug($slug);
		$feed = array();
		$feed = $this->Feed->find('first', array(
			'conditions' => array(
				'Feed.slug' => $slug
			),
			'contain' => array(
				'Item' => array('conditions' => array('Item.deleted' => 0))
			)
		));
		$assets = $this->Feed->Item->Asset->findForFeedAndFormat($feed, $format);
		// debug($assets);
		foreach ($feed['Item'] as $k => $i) {
			$asset = Set::extract('/Asset[item_id='.$i['id'].']/..', $assets);
			// some stupid resorting..., add empty asset if none was found for that item -- gets ignored in feed!
			if (!empty($asset)) {
				foreach ($asset as $a) {
					$feed['Item'][$k]['Asset'][] = $a['Asset'];
				}
			} else {
				$feed['Item'][$k]['Asset'] = array();
			}
		}
		// debug($feed);
		if(!empty($feed['Item'])) {
			$feed['Item'] = Set::sort($feed['Item'], '{n}.FeedsItem.order', 'ASC');
		}
		
		// debug($feed);
		$this->set('feed', $feed);
		
		switch ($format) {
			case 'hd':
				$sffx = ' - HD';
				break;
			case 'sd':
				$sffx = ' - SD';
				break;
			case 'audio':
				$sffx = ' - Audio';
				break;
			case null:
			default:
				$sffx = '';
				break;
		}
		$this->set('sffx', $sffx);
		$this->set('format', $format);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Feed->create();
			$data = $this->request->data;
			$data['Feed']['slug'] = $this->Feed->createSlug($data['Feed']['title']);
			// pr($data);
			$this->Feed->save($data);
			$this->redirect('index');
		}
		$itemCategories = Configure::read('itunesu-categories');
		$languages = Configure::read('itunesu-feed-languages');
		$this->set(compact('itemCategories', 'languages'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Feed->id = $id;
		if (!$this->Feed->exists()) {
			throw new NotFoundException(__('Invalid feed'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$data = $this->request->data;
			
			// need old feed entry for some data checks
			$feed = $this->Feed->find('first', array(
				'conditions' => array('Feed.id' => $id),
				'recursive' => -1));
				
			// generate new slug if feedtitle changed (and the checkbox has been checked...)
			if ($data['Feed']['noaddrupdate'] == 0 && $data['Feed']['title'] != $feed['Feed']['title']) {
				$data['Feed']['slug'] = $this->Feed->createSlug($data['Feed']['title']);
			}
			
			if ($this->Feed->save($data)) {
				$this->redirect('index');
			}
		} else {
			$this->request->data = $this->Feed->read(null, $id);
			$itemCategories = Configure::read('itunesu-categories');
			$languages = Configure::read('itunesu-feed-languages');
			$this->set(compact('itemCategories', 'languages'));
		}
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Feed->id = $id;
		if (!$this->Feed->exists()) {
			throw new NotFoundException(__('Invalid feed'));
		}
		if ($this->Feed->delete(null, false)) { // don't cascade!
			$this->redirect('index');
		}
		$this->flash(__('Feed was not deleted'), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	
	
	public function images($id = null) {
		$this->Feed->id = $id;
		if (!$this->Feed->exists()) {
			throw new NotFoundException('Invalid feed');
		}
		
		if ($this->request->is('post') || $this->request->is('put')) {
			$data = $this->request->data;
			$savedata = array('Feed' => array(
				'id' => $id
			));
			
			$feed = $this->Feed->find('first', array(
				'conditions' => array('Feed.id' => $id),
				'recursive' => -1));

			// check for file-upload	
			if (is_uploaded_file($data['Feed']['feedimage']['tmp_name'])) {
				// check for format, set $sffx
				switch ($data['Feed']['format']) {
					case 'hd':
						$sffx = '_hd';
						break;
					case 'sd':
						$sffx = '_sd';
						break;
					case 'audio':
						$sffx = '_audio';
						break;
					case 'default':
					default:
						$sffx = '';
						break;
				}
				
				// get name for new file: feedicon_[guid].[ext];
				$ext = strtolower(substr(
						$data['Feed']['feedimage']['name'],
						strrpos($data['Feed']['feedimage']['name'], '.' )));
				$newFileName = uniqid("feedicon_").$sffx.$ext;
				
				// check for old picture and delete it
				if (!empty($feed['Feed']['feedimage'.$sffx]) &&
					 is_file(WWW_ROOT.DS.'feedimgs'.DS.$feed['Feed']['feedimage'.$sffx])) {
					unlink(WWW_ROOT.DS.'feedimgs'.DS.$feed['Feed']['feedimage'.$sffx]);
				}
				
				// copy uploaded image to webroot and save path in data array
				move_uploaded_file($data['Feed']['feedimage']['tmp_name'], 
									WWW_ROOT.DS.'feedimgs'.DS.$newFileName);
				// $data['Feed']['feedimage'] = $newFileName;
				$savedata['Feed']['feedimage'.$sffx] = $newFileName;
			}
			if (is_array($data['Feed']['feedimage'])) {
				unset($data['Feed']['feedimage']);
			}

			if ($this->Feed->save($savedata)) {
				$this->redirect('images/'.$id);
			}
		}
		
		$feed = $this->Feed->find('first', array(
			'recursive' => -1,
			'conditions' => array('Feed.id' => $id)
		));
		$this->set(compact('feed', 'id'));
	}
	
	
	public function deleteimg($id = null, $format = null) {
		$this->Feed->id = $id;
		if (!$this->Feed->exists()) {
			throw new NotFoundException(__('Invalid feed'));
		}
		$feed = $this->Feed->find('first', array('recursive' => -1, 'conditions' => array('id' => $id)));
		
		if ($format != null) {
			switch ($format) {
				case 'hd':
					$sffx = '_hd';
					break;
				case 'sd':
					$sffx = '_sd';
					break;
				case 'audio':
					$sffx = '_audio';
					break;
			}
		} else {
			$sffx = '';
		}
		
		if (is_file(WWW_ROOT.DS.'feedimgs'.DS.$feed['Feed']['feedimage'.$sffx])) {
			unlink(WWW_ROOT.DS.'feedimgs'.DS.$feed['Feed']['feedimage'.$sffx]);
		}
		$feed['Feed']['feedimage'.$sffx] = '';
		$this->Feed->save($feed);
		
		$this->redirect('/feeds/images/'.$id);
	}
}
