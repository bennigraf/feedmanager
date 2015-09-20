<?php $this->Html->script("views/items-assign", array('inline' => false)) ?>

<p class="actions">
<?php 
if ($show == 'all') {
	echo $this->Html->link('Only show unassigned items', '/items/assign/show:unassigned');
} else {
	echo $this->Html->link('Show all items', '/items/assign/show:all');
}
?>
</p>

<p>
<select id="ItemsAssignFilter" data-placeholder="Filter Items" style="width: 100%;" multiple>
</select>
</p>

<?php
foreach ($items as $item) {
	echo '<div class="item" data-itemid="'.$item['Item']['id'].'">';
	echo "<h3>".$item['Item']['title']."</h3>";
	echo "<p class=\"summary\">".$item['Item']['summary']."</p>";
	echo '<p>Available assets ('.count($item['Asset']).'): ';
	foreach ($item['Asset'] as $asset) {
		echo $asset['format'].' ';
	}
	echo '</p>';
	// echo "<p class=\"actions\">Assign to ";
	// foreach ($feeds as $feed) {
	// 	if (in_array($feed['Feed']['id'], $item['Item']['assignedFeedIds'])) {
	// 		echo '<span class="alreadylinked">'.$feed['Feed']['title'].'(';
	// 		echo $this->Html->link('x', '/items/unlink/show:'.$show.'/itemid:'.$item['Item']['id'].'/feedid:'.$feed['Feed']['id']);
	// 		echo ')</span> ';
	// 	} else {
	// 		echo $this->Html->link($feed['Feed']['title'], '/items/assign/show:'.$show.'/itemid:'.$item['Item']['id'].'/feedid:'.$feed['Feed']['id']).' ';
	// 	}
	// }
	echo '<p class="assignedTo">Assigned to: ';
	$linkedfeeds = array();
	foreach ($item['Feed'] as $feed) {
		$linkedfeeds[] = $feed['title'];
	}
	echo implode(", ", $linkedfeeds);
	echo '</p>';
	echo '<p class="actions">';
	echo '<span class="editassignmnt">';
	echo '<a class="editassglink" href="#">Edit assignment</a>';
	echo '<select class="itemsFeedsAssignment" multiple>';
	foreach ($feeds as $feed) {
		echo '<option value="'.$feed['Feed']['id'].'"';
		if (in_array($feed['Feed']['id'], $item['Item']['assignedFeedIds'])) {
			echo ' selected="selected"';
		}	
		echo '>'.$feed['Feed']['title'].'</option>';
	}
	echo '</select>';
	echo '<a class="saveassglink" href="#">Save selection</a>';
	echo '</span>';
	echo "</p>";
	echo '</div>';
}


?>