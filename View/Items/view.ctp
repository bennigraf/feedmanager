<div class="items view">
<h2><?php  echo __('Item');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($item['Item']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Uid'); ?></dt>
		<dd>
			<?php echo h($item['Item']['uid']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($item['Item']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Author'); ?></dt>
		<dd>
			<?php echo h($item['Item']['author']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Summary'); ?></dt>
		<dd>
			<?php echo h($item['Item']['summary']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Item'), array('action' => 'edit', $item['Item']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Item'), array('action' => 'delete', $item['Item']['id']), null, __('Are you sure you want to delete # %s?', $item['Item']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Items'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Item'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Assets'), array('controller' => 'assets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Asset'), array('controller' => 'assets', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Feeds'), array('controller' => 'feeds', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Feed'), array('controller' => 'feeds', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Assets');?></h3>
	<?php if (!empty($item['Asset'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Item Id'); ?></th>
		<th><?php echo __('Linktofile'); ?></th>
		<th><?php echo __('Format'); ?></th>
		<th><?php echo __('Datatype'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($item['Asset'] as $asset): ?>
		<tr>
			<td><?php echo $asset['id'];?></td>
			<td><?php echo $asset['item_id'];?></td>
			<td><?php echo $asset['linktofile'];?></td>
			<td><?php echo $asset['format'];?></td>
			<td><?php echo $asset['datatype'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'assets', 'action' => 'view', $asset['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'assets', 'action' => 'edit', $asset['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'assets', 'action' => 'delete', $asset['id']), null, __('Are you sure you want to delete # %s?', $asset['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Asset'), array('controller' => 'assets', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Feeds');?></h3>
	<?php if (!empty($item['Feed'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Title'); ?></th>
		<th><?php echo __('Subtitle'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($item['Feed'] as $feed): ?>
		<tr>
			<td><?php echo $feed['id'];?></td>
			<td><?php echo $feed['title'];?></td>
			<td><?php echo $feed['subtitle'];?></td>
			<td><?php echo $feed['description'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'feeds', 'action' => 'view', $feed['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'feeds', 'action' => 'edit', $feed['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'feeds', 'action' => 'delete', $feed['id']), null, __('Are you sure you want to delete # %s?', $feed['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Feed'), array('controller' => 'feeds', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
