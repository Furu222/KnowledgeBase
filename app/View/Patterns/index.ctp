<div class="row-fluid">
	<div class="span9">
		<h2><?php echo __('List %s', __('Patterns'));?></h2>

		<p>
			<?php echo $this->BootstrapPaginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));?>
		</p>

		<table class="table">
			<tr>
				<th><?php echo $this->BootstrapPaginator->sort('id');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('name');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('appeared_tknow1');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('appeared_tknow2');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('appeared_property');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('appeared_object');?></th>
				<th class="actions"><?php echo __('Actions');?></th>
			</tr>
		<?php foreach ($patterns as $pattern): ?>
			<tr>
				<td><?php echo h($pattern['Pattern']['id']); ?>&nbsp;</td>
				<td><?php echo h($pattern['Pattern']['name']); ?>&nbsp;</td>
				<td><?php echo h($pattern['Pattern']['appeared_tknow1']); ?>&nbsp;</td>
				<td><?php echo h($pattern['Pattern']['appeared_tknow2']); ?>&nbsp;</td>
				<td><?php echo h($pattern['Pattern']['appeared_property']); ?>&nbsp;</td>
				<td><?php echo h($pattern['Pattern']['appeared_object']); ?>&nbsp;</td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('action' => 'view', $pattern['Pattern']['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $pattern['Pattern']['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $pattern['Pattern']['id']), null, __('Are you sure you want to delete # %s?', $pattern['Pattern']['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>

		<?php echo $this->BootstrapPaginator->pagination(); ?>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('New %s', __('Pattern')), array('action' => 'add')); ?></li>
		</ul>
		</div>
	</div>
</div>