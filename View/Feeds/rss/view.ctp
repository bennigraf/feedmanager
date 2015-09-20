<?php

$url = '/feeds/view/'.$feed['Feed']['slug'];
if (isset($format)) {
	$url .= '/'.$format;
}
$url .= '.rss';

$ituCats = Set::flatten(Configure::read('itunesu-categories'));
$thisCat = '';
foreach ($ituCats as $key => $value) {
	if (strpos($key, $feed['Feed']['itunesu-item-category']) !== FALSE) {
		$thisCat1 = substr($key, 0, strpos($key, '.'));
		$thisCat2 = $value;
	}
}
if (!empty($feed['Feed']['author'])) {
	$author = $feed['Feed']['author'];
} else {
	$author = Configure::read('feed.default-author');
}

$channelData = array(
	'title' => h($feed['Feed']['title'].$sffx),
    'link' => Configure::read('feed.channel-link'),
    'itunes:summary' => h($feed['Feed']['description']),
    'description' => h($feed['Feed']['description']),
	'itunes:subtitle' => h($feed['Feed']['subtitle']),
	'itunes:owner' => array(
		'itunes:name' => Configure::read('feed.channel-owner.name'),
		'itunes:email' => Configure::read('feed.channel-owner.email')
	),
	'itunes:author' => h($author),
	'copyright' => Configure::read('feed.copyright'),
    'language' => $feed['Feed']['language'],
	'generator' => 'iTunes U Feedmanager by Benjamin Graf (2012)',
);
if (!empty($feed['Feed']['feedimage_'.$format])) {
	$feedimage = $feed['Feed']['feedimage_'.$format];
} else {
	$feedimage = $feed['Feed']['feedimage'];
}
if (!empty($feedimage)) {
	$channelData = array_merge($channelData, array(
		'image' => array(
			'url' => Configure::read('urlprefix').'/feedimgs/'.$feedimage,
			'title' => h($feed['Feed']['title'].$sffx),
			'link' => Configure::read('feed.channel-link')
		),
		'itunes:image' => array(array('href' => Configure::read('urlprefix').'/feedimgs/'.$feedimage))
	));
}

$this->set('channelData', $channelData);

echo "\n";
// debug($item);
foreach ($feed['Item'] as $item) {
	foreach ($item['Asset'] as $asset) {
		
		if(!empty ($item['author'])) {
			$itemauthor = $item['author'];
		} else {
			$itemauthor = $author;
		}

		$asseturl = $this->Feedmanager->createAssetUrl($item, $asset);
		echo $this->bRss->renderData(array('item' => array(
			'title' => h($item['title']),
			'itunes:subtitle' => h($item['summary']),
			'itunes:summary' => h($item['summary']),
			'enclosure' => array(array(
				'url' => $asseturl, 
				'length' => $asset['length'],
				'type' => $asset['datatype'])),
			'guid' => $asseturl,
			'link' => $asseturl,
			'author' => Configure::read('feed.channel-owner.email'),
			'itunes:author' => h($itemauthor),
			'itunesu:category' => array(array('itunesu:code' => $feed['Feed']['itunesu-item-category'])),
			'itunes:keywords' => h($feed['Feed']['keywords']),
			'itunes:image' => array(array('href' => Configure::read('urlprefix').'/feedimgs/'.$feed['Feed']['feedimage'])),
			'pubDate' => $item['pubDate'],
			'itunes:duration' => $asset['duration'],
			'itunes:order' => $item['FeedsItem']['order']
		)))."\n";
	}
}

echo "\n";


?>