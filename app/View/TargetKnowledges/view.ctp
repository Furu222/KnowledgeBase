<div class="row-fluid">
	<div class="span9">
		<h2><?php  echo __('Target Knowledge');?></h2>
		<dl>
			<dt><?php echo __('Target Knowledge'); ?></dt>
			<dd>
				<?php echo h($targetKnowledge['TargetKnowledge']['name']); ?>
				&nbsp;
			</dd>
            <dt><?php echo __('Problems'); ?></dt>
            <dd>
                <?php
                    foreach($problems as $val){
                        echo $this->Html->link(__($val['sentence']), array('controller' => 'Problems', 'action' => 'view', $val['employ'], $val['grade'], $val['number'] - 1));
                        echo '<br /><br />';
                    }
                ?>
            </dd>
		</dl>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('List %s', __('Target Knowledges')), array('action' => 'index')); ?> </li>
		</ul>
		</div>
	</div>
</div>

