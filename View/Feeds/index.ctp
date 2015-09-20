<?php $this->Html->script("views/feeds-index", array('inline' => false)) ?>

<p class="actions">
<?php 
echo $this->Html->link($this->Html->image('icons/add.png').' Add Feed', '/feeds/add', array('escape' => false)); 
?>
</p>

<p>
<select id="FeedFilter" data-placeholder="Filter Feeds" style="width: 100%;" multiple>
</select>
</p>

<?php
foreach ($feeds as $feed) {
	echo '<div class="item">';
	echo '<div class="feedicon">';
	if (!empty($feed['Feed']['feedimage'])) {
		echo $this->Html->image('/feedimgs/'.$feed['Feed']['feedimage']);
	} else if (!empty($feed['Feed']['feedimage_hd'])) {
		echo $this->Html->image('/feedimgs/'.$feed['Feed']['feedimage_hd']);
	} else if (!empty($feed['Feed']['feedimage_sd'])) {
		echo $this->Html->image('/feedimgs/'.$feed['Feed']['feedimage_sd']);
	} else if (!empty($feed['Feed']['feedimage_audio'])) {
		echo $this->Html->image('/feedimgs/'.$feed['Feed']['feedimage_audio']);
	}
	echo '</div>';
	echo '<h3>'.h($feed['Feed']['title']).'<span class="subtitle">'.$feed['Feed']['subtitle'].'</span></h3>';
	if (isset($feed['Feed']['author'])) {
		echo '<p><span class="fieldname">Author:</span> '.$feed['Feed']['author'].'</p>';
	}
	// debug($feed);
	echo '<p>'.h($feed['Feed']['description']).'</p>';
	echo '<p>Items: '.count($feed['Item']).'</p>';
	echo '<ul class="links">';
	echo '<li class="feed"> All items: ';
	echo $this->Html->link(Configure::read('urlprefix').'/feeds/'.$feed['Feed']['slug'].'.rss');
	echo '</li>';
	// if(isset($feed['Feed']['formats']['hd'])) {
		echo '<li class="feed">HD: '.$this->Html->link(Configure::read('urlprefix').'/feeds/hd/'.$feed['Feed']['slug'].'.rss').'</li>';
	// }
	// if(isset($feed['Feed']['formats']['sd'])) {
		echo '<li class="feed">SD: '.$this->Html->link(Configure::read('urlprefix').'/feeds/sd/'.$feed['Feed']['slug'].'.rss').'</li>';
	// }
	// if(isset($feed['Feed']['formats']['audio'])) {
		echo '<li class="feed">Audio: '.$this->Html->link(Configure::read('urlprefix').'/feeds/audio/'.$feed['Feed']['slug'].'.rss').'</li>';
	// }
	echo '</ul>';
	echo '<p class="actions">';
	echo $this->Html->link('edit', '/feeds/edit/'.$feed['Feed']['id']).' ';
	echo $this->Html->link('sort items', '/feeds/order/'.$feed['Feed']['id']).' ';
	echo $this->Html->link('manage images', '/feeds/images/'.$feed['Feed']['id']).' ';
	echo $this->Html->link('delete', '/feeds/delete/'.$feed['Feed']['id'], array('escape'=>false)).' ';
	echo '</p>';
	echo '</div>';
}
?>