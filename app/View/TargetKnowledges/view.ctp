<div class="row-fluid">
	<div class="span9">
		<h2><?php  echo __('Target Knowledge');?></h2>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
			<dd>
				<?php echo h($targetKnowledge['TargetKnowledge']['id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Name'); ?></dt>
			<dd>
				<?php echo h($targetKnowledge['TargetKnowledge']['name']); ?>
				&nbsp;
			</dd>
		</dl>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('Edit %s', __('Target Knowledge')), array('action' => 'edit', $targetKnowledge['TargetKnowledge']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink(__('Delete %s', __('Target Knowledge')), array('action' => 'delete', $targetKnowledge['TargetKnowledge']['id']), null, __('Are you sure you want to delete # %s?', $targetKnowledge['TargetKnowledge']['id'])); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Target Knowledges')), array('action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Target Knowledge')), array('action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>

