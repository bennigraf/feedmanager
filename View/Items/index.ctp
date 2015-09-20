<!-- <p class="actions">
<?php 
echo $this->Html->link($this->Html->image('icons/refresh.png').' Refresh Sources', '/items/sync', array('escape' => false)); 
?>
</p> -->
<?php
foreach ($items as $item) {
	echo '<div class="item">';
	echo "<h3>".$item['Item']['title']."</h3>";
	echo "<p class=\"summary\">".$item['Item']['summary']."</p>";
	echo '<p>Available assets ('.count($item['Asset']).'): ';
	$formats = array();
	foreach ($item['Asset'] as $asset) {
		$formats[] = $asset['format'];
	}
	echo implode($formats, ', ');
	echo '</p>';
	echo '<p class="actions">';
	echo $this->Html->link('edit', '/items/edit/'.$item['Item']['id']).' ';
	echo $this->Html->link($this->Html->image('icons/delete.png').' delete', '/items/delete/'.$item['Item']['id'], array('escape' => false));
	echo '</p>';
	echo '</div>';
}


?>