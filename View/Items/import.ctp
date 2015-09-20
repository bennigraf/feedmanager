<p class="actions">
<?php 
echo $this->Html->link($this->Html->image('icons/refresh.png').' Refresh items', '/items/import', array('escape' => false)); 
?>
</p>
<p>Select assets and create a new item from them.</p>

<div class="form">
<?php echo $this->Form->create('Item', array('action' => 'add'));?>
<?php
echo $this->Form->select('Item.files', $files, array(
	'multiple' => 'checkbox',
	'class' => 'input checkbox'
));

?>
<?php echo $this->Form->end('Create Item');?>
</div>
