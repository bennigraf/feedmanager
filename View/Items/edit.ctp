<div class="items form">
<?php echo $this->Form->create('Item');?>
	<fieldset>
		<legend>Edit Item</legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title');
		echo $this->Form->input('author');
		echo $this->Form->input('summary');
		// echo $this->Form->input('Feed');
	?>
	</fieldset>
<?php echo $this->Form->end('Save');?>
</div>