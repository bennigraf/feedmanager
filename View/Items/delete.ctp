<div class="item">
	<h3>Are you sure?</h3>
	<p>
		You are deleting the item <strong><?php echo $item['Item']['title'] ?></strong> and all of it's
		<?php echo count($item['Asset']) ?> assets. <strong>This cannot be undone!</strong>
	</p>
	<?php
	if (!empty($item['Feed'])) {
		?>
		<p>
			This Item will thus be removed from the following feeds:
			<?php
			$feeds = array();
			foreach ($item['Feed'] as $feed) {
				$feeds[] = $feed['title'];
			}
			echo implode(', ', $feeds);
			?>
		</p>
		<?php
	}
	?>
	<p>
		<?php echo $this->Html->link('Yes, continue', '/items/delete/'.$item['Item']['id'].'/confirmed:true') ?>
		<?php echo $this->Html->link('No, please don\'t', '/items') ?>
	</p>
	
</div>