<?php
App::uses('Model', 'Model');
class AppModel extends Model {
	
	public $actsAs = array('Containable');
	
	// http://www.whatstyle.net/articles/52/generate_unique_slugs_in_cakephp
	function createSlug ($string, $id=null) {
		$slug = Inflector::slug ($string,'-');
		$slug = strtolower($slug);
		$i = 0;
		$params = array ();
		$params ['conditions']= array();
		$params ['conditions'][$this->name.'.slug']= $slug;
		if (!is_null($id)) {
			$params ['conditions']['not'] = array($this->name.'.id'=>$id);
		}
		while (count($this->find ('all',$params))) {
			if (!preg_match ('/-{1}[0-9]+$/', $slug )) {
				$slug .= '-' . ++$i;
			} else {
				$slug = preg_replace ('/[0-9]+$/', ++$i, $slug );
			}
			$params ['conditions'][$this->name . '.slug']= $slug;
		}
		return $slug;
	}
	
}
