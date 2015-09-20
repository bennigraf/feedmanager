<p class="actions">
	<?php echo $this->Html->link('Back to overview', '/feeds') ?>
</p>
<div class="item form">
	<h3>Upload image for feed: <?php echo $feed['Feed']['title'] ?></h3>
	<?php 
	echo $this->Form->create('Feed', array('type' => 'file'));
	echo $this->Form->input('id');
	echo $this->Form->input('feedimage', array(
		'type' => 'file',
		'label' => 'Image file',
		'after' => '<div class="description">preferred format: .jpg, 600 by 600 px <br>An existing image
					will be overwritten</div>'
	));
	echo $this->Form->input('format', array(
		'type' => 'select',
		'options' => array('default' => 'Default', 'hd' => 'HD', 'sd' => 'SD', 'audio' => 'Audio'),
		'label' => 'Assign to format '
	));
	
	echo $this->Form->end('Upload image');
	
	?>
	
</div>
<div class="item feedicon">
	<h3>Default</h3>
	<?php if (!empty($feed['Feed']['feedimage'])) {
		echo $this->Html->image('/feedimgs/'.$feed['Feed']['feedimage']);
		echo '<p class="actions">';
		echo $this->Html->link('Delete image', '/feeds/deleteimg/'.$id);
		echo '</p>';
	} else { ?>
		<p>No image available</p>
	<?php } ?>
</div>

<div class="item feedicon">
	<h3>HD</h3>
	<?php if (!empty($feed['Feed']['feedimage_hd'])) {
		echo $this->Html->image('/feedimgs/'.$feed['Feed']['feedimage_hd']);
		echo '<p class="actions">';
		echo $this->Html->link('Delete image', '/feeds/deleteimg/'.$id.'/hd');
		echo '</p>';
	} else { ?>
		<p>No image available</p>
	<?php } ?>
</div>

<div class="item feedicon">
	<h3>SD</h3>
	<?php if (!empty($feed['Feed']['feedimage_sd'])) {
		echo $this->Html->image('/feedimgs/'.$feed['Feed']['feedimage_sd']);
		echo '<p class="actions">';
		echo $this->Html->link('Delete image', '/feeds/deleteimg/'.$id.'/sd');
		echo '</p>';
	} else { ?>
		<p>No image available</p>
	<?php } ?>
</div>

<div class="item feedicon">
	<h3>Audio</h3>
	<?php if (!empty($feed['Feed']['feedimage_audio'])) {
		echo $this->Html->image('/feedimgs/'.$feed['Feed']['feedimage_audio']);
		echo '<p class="actions">';
		echo $this->Html->link('Delete image', '/feeds/deleteimg/'.$id.'/audio');
		echo '</p>';
	} else { ?>
		<p>No image available</p>
	<?php } ?>
</div>
