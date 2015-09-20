<div class="items form">
<?php echo $this->Form->create('Item');?>
	<fieldset>
		<legend><?php echo __('Add Item'); ?></legend>
	<?php
		echo $this->Form->input('title');
		echo $this->Form->input('author');
		echo $this->Form->input('summary');
		
		// hidden fields that store the linked files
		foreach ($selectedfiles as $file) {
			// print_r($file);
			echo $this->Form->input('Item.files.', array(
				'type'=>'hidden',
				'value'=>$file['id']
			));
		}
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>

<p>
	<strong>Selected files:</strong>
	<?php
	foreach ($selectedfiles as $file) {
		echo '"'.$file['path'].'" ';
	}
	?>
</p>