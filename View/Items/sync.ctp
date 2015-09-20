<div class="item">
	<p>
		<?php echo $state['numItems'] ?> items found<br>
		<?php echo $state['added'] ?> items added to database (
		<?php echo $state['skipped'] ?> were already there)<br>
		<?php echo $state['assetsAdded'] ?> Assets added to database<br>
		
	</p>
	<p>
		<?php echo $this->Html->link('Back', '/items/') ?>
	</p>
</div>