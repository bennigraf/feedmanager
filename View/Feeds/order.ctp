<p class="actions">
	<?php echo $this->Html->link('Back to overview', '/feeds/index') ?>
</p>

<?php

$cnt = 0;
foreach ($feed['Item'] as $item) {
	echo '<div class="item">';
	echo '<h3>'.' ';
	if ($cnt++ > 0) {
		echo $this->Html->link($this->Html->image('icons/up.png'), '/feeds/order/'.$feed['Feed']['id'].'/item:'.$item['id'].'/go:up', array('escape' => false));
	}
	if ($cnt != count($feed['Item'])) {
		echo $this->Html->link($this->Html->image('icons/down.png'), '/feeds/order/'.$feed['Feed']['id'].'/item:'.$item['id'].'/go:down', array('escape' => false));
	}
	echo ' '.$item['title'].'</h3>';
	echo '</div>';
}

?>