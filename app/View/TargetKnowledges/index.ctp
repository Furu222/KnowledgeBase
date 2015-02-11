<div class="row-fluid">
	<div class="span9">
		<h2><?php echo __('List %s', __('Target Knowledges'));?></h2>

		<p>
			<?php echo $this->BootstrapPaginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));?>
		</p>

		<table class="table">
			<tr>
				<th><?php echo $this->BootstrapPaginator->sort('name');?></th>
				<th class="actions"><?php echo __('Problems');?></th>
			</tr>
		<?php foreach ($targetKnowledges as $targetKnowledge): ?>
			<tr>
				<td><?php echo h($targetKnowledge['TargetKnowledge']['name']); ?>&nbsp;</td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('action' => 'view', $targetKnowledge['TargetKnowledge']['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>

		<?php echo $this->BootstrapPaginator->pagination(); ?>
	</div>
	<!-- <div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
		</ul>
		</div>
    </div>
    -->
</div>
