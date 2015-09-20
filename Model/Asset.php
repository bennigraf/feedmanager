<?php
App::uses('AppModel', 'Model');
/**
 * Asset Model
 *
 * @property Item $Item
 */
class Asset extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'linktofile';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Item' => array(
			'className' => 'Item',
			'foreignKey' => 'item_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	
	public function findForFeedAndFormat($feed, $format) {
		$assets = array();
		
		$itemids = array();
		// debug($feed);
		if (!empty($feed['Item'])) {
			foreach ($feed['Item'] as $i) {
				$itemids[] = $i['id'];
			}
		}
		
		if ($format !== null) {
			$formats = Configure::read('itunesu-format-codes.'.$format);
			// maybe use Set::extract or sth alike here
		}

		if($feed['Feed']['inclaudioonlyassets'] == 0) {
			// find fitting formats, then find assets with itemids _and_ right format 
			$conditions = array();
			if ($format !== null) {
				foreach ($formats as $f) {
					$conditions['or'][] = array('Asset.format' => $f);
				}
			}
			$conditions = array_merge($conditions, array(
				'Asset.item_id IN ('.implode(',', $itemids).')'
				));
			// debug($conditions);
			$assets = $this->find('all', array(
				'recursive' => -1,
				'conditions' => $conditions
			));
		} else {
			// find all assets with for each itemid, see if asset of needed format is available, 
			// otherwise use audio-asset
			$audioformats = Configure::read('itunesu-format-codes.audio');
			foreach ($itemids as $iid) {
				$itemassets = $this->find('all', array(
					'recursive' => -1,
					'conditions' => array('Asset.item_id' => $iid)
				));
				$thisassets = array();
				$audioassets = array();
				foreach ($itemassets as $a) {
					if(in_array($a['Asset']['format'], $formats)) {
						$thisassets[] = $a;
					}
					if(in_array($a['Asset']['format'], $audioformats)) {
						$audioassets[] = $a;
					}
				}
				if (!empty($thisassets)) {
					$assets = array_merge($assets, $thisassets);
				} else if (empty($thisassets) && !empty($audioassets)) {
					$assets = array_merge($assets, $audioassets);
				}
			}
		}
		
		// debug($conditions);
		return $assets;
		
		
	}
	
	
}
