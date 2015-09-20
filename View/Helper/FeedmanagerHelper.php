<?php

App::uses('AppHelper', 'View/Helper');

class FeedmanagerHelper extends AppHelper {

	// rewrites url to asset from coded pseudo-url, see Config/feedmanager.php -> asseturl for details
	public function createAssetUrl($item, $asset) {
		
		$url = Configure::read('asseturl');
		$item_raw = trim($item['path'], '/');
		$item_arr = explode('/', $item_raw);
		$item_date = $item_arr[0];
		$item_uid = $item_arr[1];
		
		$asset_arr = explode('.', $asset['path']);
		$asset_uid = $asset_arr[0];
		$asset_ext = $asset_arr[1];
		
		$fullurl = str_replace('%item_date%', $item_date, $url);
		$fullurl = str_replace('%item_uid%', $item_uid, $fullurl);
		$fullurl = str_replace('%asset_uid%', $asset_uid, $fullurl);
		$fullurl = str_replace('%asset_ext%', $asset_ext, $fullurl);
		
		
		return $fullurl;
	}

}