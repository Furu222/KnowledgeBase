<div class="row-fluid">
	<div class="span9">
		<h3><?php  echo __('Default Problem');?></h3>
		<dl>
			<dt><?php echo __('問題文'); ?></dt>
			<dd>
				<?php echo h($problem['sentence']); ?>
				&nbsp;
			</dd>
            <dt><?php echo __('正答'); ?></dt>
            <dd><?php echo $problem['right_answer']; ?>&nbsp;</dd>
            <?php
                if (isset($problem['wrong_answer1'])){
                    echo '<dt>誤答</dt>';
                    echo '<dd>';
                    for ($i = 1; $i <= 3; $i++){
                        echo $problem['wrong_answer'.$i].'<br />';
                    }
                    echo '</dd>';
                }
            ?>
            <dt>出題年度</dt>
            <dd>
                <?php
                if ($year == 0){
                    echo "オリジナル問題";
                }else{
                    echo $year.'年';
                }
                ?>
            &nbsp;</dd>
            <dt>出題級</dt>
            <dd>
                <?php
                if ($grade == 0){
                    echo "オリジナル問題";
                }else{
                    echo $grade.'級';
                }
                ?>
            &nbsp;</dd>
		</dl>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('List %s', __('Problems')), array('action' => 'index')); ?> </li>
		</ul>
		</div>
	</div>
    <div class="span9" style='margin-left:0;'>
        <h3>KnowledgeBase</h3>
        <dl>
            <dt>対象知識</dt>
            <dd><?php echo $kb; ?></dd>
            <dt>カテゴリ</dt>
            <dd></dd>
            <dt>プロパティ</dt>
            <dd></dd>
            <dt>オブジェクト</dt>
            <dd></dd>
        </dl>
    </div>
</div>

