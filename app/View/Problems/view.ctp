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
<?php
    if ($kb === 'timeout'){
        echo $this->Session->flash('timeout');
    }else{
?>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('List %s', __('Problems')), array('action' => 'index')); ?> </li>
		</ul>
		</div>
	</div>
    <div class="span9" style='margin-left:0;'>
        <h3>knowledgeBase</h3>
        <dl>
            <dt>出題パターン</dt>
            <dd><?php echo $kb['Pattern']['id'].': '. $kb['Pattern']['name']; ?></dd>
            <dt>対象知識</dt>
            <dd><?php
                foreach($kb['knowledge']['tknows'] as $value){
                    echo $value.'<br />';
                }
            ?></dd>
            <dt>カテゴリ</dt>
            <dd><?php echo $kb['Category']['name']; ?></dd>
            <dt>プロパティ</dt>
            <dd><?php
                foreach($kb['knowledge']['properties'] as $value){
                    echo $value.'<br />';
                }
            ?></dd>
            <dt>オブジェクト</dt>
            <dd><?php
                foreach($kb['knowledge']['objects'] as $value){
                    echo $value.'<br />';
                }
            ?></dd>
        </dl>
    </div>
    <div class="span9" style='margin-left:0;'>
    <?php
        echo $this->BootstrapForm->create('KnowledgeBase', array('url' => array('controller' => 'TargetKnowledges', 'action' => 'add')));
        echo $this->BootstrapForm->submit('この問題を登録', array('id' => 'add_button', 'class' => 'btn btn-primary'));
        echo $this->BootstrapForm->end();
    ?>
    </div>
</div>
<?php
    if ($al_flg == 1){ // 既に登録されている場合
        $this->Html->scriptStart(array('inline' => false));
?>
    // 既に登録されている場合は登録ボタンを表示しない
    $(function(){
        $("#add_button").hide();
    }); 
<?php
        $this->Session->flash('already');
        $this->Html->scriptEnd();
    }
?>
<?php } ?>
