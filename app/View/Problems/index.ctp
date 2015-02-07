<div class="row-fluid">
	<div class="span9">
		<h2><?php echo __('List %s', __('Problems'));?></h2>

        <?php
            // 問題情報がないとき
            if (count($problems) == 1){
                if (isset($problems['response']))
                    $problems = $problems['response'];
                echo '<p>'.$problems.'</p>';
            }else{
        ?>

		<table class="table">
			<tr>
                <th>設問番号</th>
                <th>問題文</th>
                <th>選択肢1</th>
                <th>選択肢2</th>
                <th>選択肢3</th>
                <th>選択肢4</th>
                <th>解答</th>
                <th>詳細</th>
			</tr>
		<?php foreach ($problems as $key => $problem): ?>
			<tr>
				<td><?php echo $key + 1; ?>&nbsp;</td>
				<td><?php echo h($problem['MoridaiQuestion']['question']); ?>&nbsp;</td>
                <?php
                    // 多肢選択式か一問一答式かで表示内容分ける
                    if ($problem['MoridaiQuestion']['format'] === 'multiple-choice'){
                ?>
                    <td><?php echo h($problem['MoridaiQuestion']['option1']); ?>&nbsp;</td>
                    <td><?php echo h($problem['MoridaiQuestion']['option2']); ?>&nbsp;</td>
                    <td><?php echo h($problem['MoridaiQuestion']['option3']); ?>&nbsp;</td>
                    <td><?php echo h($problem['MoridaiQuestion']['option4']); ?>&nbsp;</td>
                    <?php $num = $problem['MoridaiQuestion']['right_answer'];?>
                    <td><?php echo h($problem['MoridaiQuestion']['option'. $num]);?>&nbsp;</td>
                <?php
                    }else{
                ?>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?php echo h($problem['MoridaiQuestion']['right_answer']);?>&nbsp;</td>
                <?php } ?>
				<td class="actions">
				    <?php echo $this->Html->link(__('View'), array('action' => 'view', $problem['MoridaiQuestion']['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>

    <?php } ?>

	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Select Test'); ?></li>
            <?php echo $this->BootstrapForm->create('Problems', array('calss' => 'form-horizontal'));?>
            <li><?php echo $this->BootstrapForm->input('year', array(
                    'type' => 'date',
                    'dateFormat' => 'Y',
                    'minYear' => 2006,
                    'maxYear' => date('Y') - 1,
                    'empty' => false,
                )); ?></li>
            <?php // $grade用配列 ?>
            <?php $grade = array(1 => '1級', 2 => '2級', 3=> '3級'); ?>
            <li><?php echo $this->BootstrapForm->input('grade', array('options' => $grade));?></li>
            <li><?php echo $this->BootstrapForm->end(__('送信')); ?>
		</ul>
		</div>
	</div>
</div>
