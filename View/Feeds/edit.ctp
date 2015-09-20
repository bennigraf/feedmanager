<div class="feeds form">
<?php echo $this->Form->create('Feed', array('type' => 'file'));?>
	<fieldset>
		<legend>Edit Feed</legend>
	<?php
		echo $this->Form->input('id');
		echo '<fieldset>';
		echo $this->Form->input('title', array(
			'after' => '<div class="description important">Changing the feed title also affects the address of the feed! If 
						you want the address to stay the same, you have to check the checkbox to the left!</div>'
		));
		echo $this->Form->input('noaddrupdate', array(
			'type' => 'checkbox',
			'label' => 'Don\'t update address',
			'checked' => 'checked'
		));
		echo '</fieldset>';
		echo $this->Form->input('subtitle');
		echo $this->Form->input('author', array(
			'after' => '<div class="description">Default if left empty: '.Configure::read('feed.default-author').'</div>'
			));
		echo $this->Form->input('language', array(
			'type' => 'select',
			'options' => $languages));
		echo $this->Form->input('itunesu-item-category', array(
				'label' => 'Category of contained items',
				'type' => 'select',
				'options' => $itemCategories));
		echo $this->Form->input('description');
		echo $this->Form->input('keywords', array(
			'after' => '<div class="description">up to 12 comma-seperated keywords</div>'
		));
		echo $this->Form->input('inclaudioonlyassets', array('type' => 'checkbox', 'label' => 'Include audio-only assets in video-feeds'));
	?>
	</fieldset>
<?php echo $this->Form->end('Save');?>
</div>