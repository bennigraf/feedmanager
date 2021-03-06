<?php 
/* App schema generated on: 2012-01-11 17:51:01 : 1326300661*/
class AppSchema extends CakeSchema {
	var $file = 'schema_4.php';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $assets = array(
		'uid' => array('type' => 'string', 'null' => true),
		'id' => array('type' => 'integer', 'null' => false, 'length' => 11, 'key' => 'primary'),
		'item_id' => array('type' => 'integer', 'null' => true),
		'path' => array('type' => 'string', 'null' => true),
		'format' => array('type' => 'string', 'null' => true),
		'datatype' => array('type' => 'string', 'null' => true),
		'length' => array('type' => 'integer', 'null' => true),
		'indexes' => array(),
		'tableParameters' => array()
	);
	var $feeds = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => true),
		'subtitle' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'description' => array('type' => 'text', 'null' => true),
		'slug' => array('type' => 'string', 'null' => true),
		'itunesu-item-category' => array('type' => 'text', 'null' => true),
		'feedimage' => array('type' => 'string', 'null' => true),
		'keywords' => array('type' => 'text', 'null' => true),
		'indexes' => array(),
		'tableParameters' => array()
	);
	var $feeds_items = array(
		'id' => array('type' => 'integer', 'null' => false, 'length' => 11, 'key' => 'primary'),
		'feed_id' => array('type' => 'integer', 'null' => true),
		'item_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array(),
		'tableParameters' => array()
	);
	var $items = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'uid' => array('type' => 'string', 'null' => true),
		'title' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'author' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'summary' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'path' => array('type' => 'string', 'null' => true),
		'indexes' => array(),
		'tableParameters' => array()
	);
}
?>