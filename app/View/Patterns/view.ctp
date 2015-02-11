<div class="row-fluid">
	<div class="span9">
		<h2><?php  echo __('Pattern');?></h2>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
			<dd>
				<?php echo h($pattern['Pattern']['id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Name'); ?></dt>
			<dd>
				<?php echo h($pattern['Pattern']['name']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Appeared Tknow1'); ?></dt>
			<dd>
				<?php echo h($pattern['Pattern']['appeared_tknow1']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Appeared Tknow2'); ?></dt>
			<dd>
				<?php echo h($pattern['Pattern']['appeared_tknow2']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Appeared Property'); ?></dt>
			<dd>
				<?php echo h($pattern['Pattern']['appeared_property']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Appeared Object'); ?></dt>
			<dd>
				<?php echo h($pattern['Pattern']['appeared_object']); ?>
				&nbsp;
			</dd>
		</dl>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('Edit %s', __('Pattern')), array('action' => 'edit', $pattern['Pattern']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink(__('Delete %s', __('Pattern')), array('action' => 'delete', $pattern['Pattern']['id']), null, __('Are you sure you want to delete # %s?', $pattern['Pattern']['id'])); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Patterns')), array('action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Pattern')), array('action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>

