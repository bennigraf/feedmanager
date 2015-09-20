<div class="form">
<?php echo $this->Form->create('Feed');?>
	<fieldset>
		<legend>Add feed</legend>
	<?php
		echo $this->Form->input('title', array('label' => 'Title:'));
		echo $this->Form->input('subtitle', array('label' => 'Subtitle:'));
		echo $this->Form->input('author');
		echo $this->Form->input('language', array(
			'type' => 'select',
			'options' => $languages));
		echo $this->Form->input('itunesu-item-category', array(
				'label' => 'Category of contained items',
				'type' => 'select',
				'options' => $itemCategories));
		echo $this->Form->input('description', array('label' => 'Description:'));
		echo $this->Form->input('keywords', array(
			'after' => '<div class="description">up to 12 comma-seperated keywords</div>'
		));
		echo $this->Form->input('inclaudioonlyassets', array('type' => 'checkbox', 'label' => 'Include audio-only assets in video-feeds'));
		
	?>
	</fieldset>
<?php echo $this->Form->end('Save');?>
</div>