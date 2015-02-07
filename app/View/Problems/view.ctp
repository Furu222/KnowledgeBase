<div class="row-fluid">
	<div class="span9">
		<h2><?php  echo __('Problem');?></h2>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
			<dd>
				<?php echo h($problem['Problem']['id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Sentence'); ?></dt>
			<dd>
				<?php echo h($problem['Problem']['sentence']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Right Answer'); ?></dt>
			<dd>
				<?php echo h($problem['Problem']['right_answer']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Wrong Answer1'); ?></dt>
			<dd>
				<?php echo h($problem['Problem']['wrong_answer1']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Wrong Answer2'); ?></dt>
			<dd>
				<?php echo h($problem['Problem']['wrong_answer2']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Wrong Answer3'); ?></dt>
			<dd>
				<?php echo h($problem['Problem']['wrong_answer3']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Description'); ?></dt>
			<dd>
				<?php echo h($problem['Problem']['description']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Type'); ?></dt>
			<dd>
				<?php echo h($problem['Problem']['type']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Employ'); ?></dt>
			<dd>
				<?php echo h($problem['Problem']['employ']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Grade'); ?></dt>
			<dd>
				<?php echo h($problem['Problem']['grade']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Number'); ?></dt>
			<dd>
				<?php echo h($problem['Problem']['number']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Category Id'); ?></dt>
			<dd>
				<?php echo h($problem['Problem']['category_id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Subcategory Id'); ?></dt>
			<dd>
				<?php echo h($problem['Problem']['subcategory_id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Image'); ?></dt>
			<dd>
				<?php echo h($problem['Problem']['image']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Latitude'); ?></dt>
			<dd>
				<?php echo h($problem['Problem']['latitude']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Longitude'); ?></dt>
			<dd>
				<?php echo h($problem['Problem']['longitude']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Reference'); ?></dt>
			<dd>
				<?php echo h($problem['Problem']['reference']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('User Id'); ?></dt>
			<dd>
				<?php echo h($problem['Problem']['user_id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Kentei Id'); ?></dt>
			<dd>
				<?php echo h($problem['Problem']['kentei_id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Spot Id'); ?></dt>
			<dd>
				<?php echo h($problem['Problem']['spot_id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Created'); ?></dt>
			<dd>
				<?php echo h($problem['Problem']['created']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Modified'); ?></dt>
			<dd>
				<?php echo h($problem['Problem']['modified']); ?>
				&nbsp;
			</dd>
		</dl>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('Edit %s', __('Problem')), array('action' => 'edit', $problem['Problem']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink(__('Delete %s', __('Problem')), array('action' => 'delete', $problem['Problem']['id']), null, __('Are you sure you want to delete # %s?', $problem['Problem']['id'])); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Problems')), array('action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Problem')), array('action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>

