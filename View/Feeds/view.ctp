<div class="feeds view">
<h2><?php  echo __('Feed');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($feed['Feed']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($feed['Feed']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Subtitle'); ?></dt>
		<dd>
			<?php echo h($feed['Feed']['subtitle']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($feed['Feed']['description']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Feed'), array('action' => 'edit', $feed['Feed']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Feed'), array('action' => 'delete', $feed['Feed']['id']), null, __('Are you sure you want to delete # %s?', $feed['Feed']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Feeds'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Feed'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Items'), array('controller' => 'items', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Item'), array('controller' => 'items', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Items');?></h3>
	<?php if (!empty($feed['Item'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Uid'); ?></th>
		<th><?php echo __('Title'); ?></th>
		<th><?php echo __('Author'); ?></th>
		<th><?php echo __('Summary'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($feed['Item'] as $item): ?>
		<tr>
			<td><?php echo $item['id'];?></td>
			<td><?php echo $item['uid'];?></td>
			<td><?php echo $item['title'];?></td>
			<td><?php echo $item['author'];?></td>
			<td><?php echo $item['summary'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'items', 'action' => 'view', $item['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'items', 'action' => 'edit', $item['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'items', 'action' => 'delete', $item['id']), null, __('Are you sure you want to delete # %s?', $item['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Item'), array('controller' => 'items', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
