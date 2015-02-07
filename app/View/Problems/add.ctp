<div class="row-fluid">
	<div class="span9">
		<?php echo $this->BootstrapForm->create('Problem', array('class' => 'form-horizontal'));?>
			<fieldset>
				<legend><?php echo __('Add %s', __('Problem')); ?></legend>
				<?php
				echo $this->BootstrapForm->input('sentence', array(
					'required' => 'required',
					'helpInline' => '<span class="label label-important">' . __('Required') . '</span>&nbsp;')
				);
				echo $this->BootstrapForm->input('right_answer', array(
					'required' => 'required',
					'helpInline' => '<span class="label label-important">' . __('Required') . '</span>&nbsp;')
				);
				echo $this->BootstrapForm->input('wrong_answer1');
				echo $this->BootstrapForm->input('wrong_answer2');
				echo $this->BootstrapForm->input('wrong_answer3');
				echo $this->BootstrapForm->input('description');
				echo $this->BootstrapForm->input('type', array(
					'required' => 'required',
					'helpInline' => '<span class="label label-important">' . __('Required') . '</span>&nbsp;')
				);
				echo $this->BootstrapForm->input('employ', array(
					'required' => 'required',
					'helpInline' => '<span class="label label-important">' . __('Required') . '</span>&nbsp;')
				);
				echo $this->BootstrapForm->input('grade');
				echo $this->BootstrapForm->input('number');
				echo $this->BootstrapForm->input('category_id', array(
					'required' => 'required',
					'helpInline' => '<span class="label label-important">' . __('Required') . '</span>&nbsp;')
				);
				echo $this->BootstrapForm->input('subcategory_id');
				echo $this->BootstrapForm->input('image');
				echo $this->BootstrapForm->input('latitude');
				echo $this->BootstrapForm->input('longitude');
				echo $this->BootstrapForm->input('reference');
				echo $this->BootstrapForm->input('user_id', array(
					'required' => 'required',
					'helpInline' => '<span class="label label-important">' . __('Required') . '</span>&nbsp;')
				);
				echo $this->BootstrapForm->input('kentei_id', array(
					'required' => 'required',
					'helpInline' => '<span class="label label-important">' . __('Required') . '</span>&nbsp;')
				);
				echo $this->BootstrapForm->input('spot_id');
				?>
				<?php echo $this->BootstrapForm->submit(__('Submit'));?>
			</fieldset>
		<?php echo $this->BootstrapForm->end();?>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('List %s', __('Problems')), array('action' => 'index'));?></li>
		</ul>
		</div>
	</div>
</div>