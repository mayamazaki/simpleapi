<?php use Cake\Core\Configure; ?>
<div class="content-box-large">
	<div class="panel-heading">
		<div class="panel-title">ライセンスマスタ</div>
		<div class="panel-options">
			<a href="<?= $this->Url->build(["controller" => "licenses", "action" => "csv"], true); ?>" class="btn btn-success btn">CSV出力</a>
			&nbsp;
			<a href="<?= $this->Url->build(["controller" => "licenses", "action" => "add"], true); ?>" class="btn btn-primary btn">ライセンスを追加する</a>
		</div>
	</div>

	<div class="panel-body">

		<div class="row">
			<div class="col-xs-6">
				<div class="dataTables_info" id="example_info">
					<?= $this->Paginator->counter([
								'format' => __('{{start}}〜{{end}}件目 / 全{{count}}件')
						]);
					?>
				</div>
			</div>
		</div>

		<div class="table-responsive">
			<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered">
				<thead>
					<tr style="background-color:#E8F3FF;">
						<th>ID</th>
						<th>表示順</th>
						<th>有効/無効</th>
						<th>ライセンスコード</th>
						<th>ライセンス有効期間（開始日）</th>
						<th>ライセンス有効期間（終了日）</th>
						<th>認証日時</th>
						<th>認証に絡む情報１（予備）</th>
						<th>認証に絡む情報２（予備）</th>
						<th>認証に絡む情報３（予備）</th>
						<th scope="col" class="actions">&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($licenses as $license): ?>
					<tr>
						<td><?= $this->Number->format($license->id) ?></td>
						<td><?= $this->Number->format($license->disp_no) ?></td>
						<td><?= Configure::read('is_valid')[$this->Number->format($license->is_valid)] ?></td>
						<td><?= h($license->license_code) ?></td>
						<td><?= h($license->exp_s_dt) ?></td>
						<td><?= h($license->exp_f_dt) ?></td>
						<td><?= h($license->auth_datetime) ?></td>
						<td><?= h($license->auth_info1) ?></td>
						<td><?= h($license->auth_info2) ?></td>
						<td><?= h($license->auth_info3) ?></td>
						<td class="actions" style="vertical-align:middle;">
						<p>
							<?= $this->Html->link(__(' 編集'), ['action' => 'edit', $license->id], ['class' => "btn btn-primary btn-xs"]) ?>
						</p>
						<p>
							<?= $this->Form->postLink(__('無効'), ['action' => 'invalid', $license->id], ['confirm' => __('Are you sure you want to delete # {0}?', $license->id), 'class' => "btn btn-danger btn-xs"]) ?>
						</p>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

			<div class="row text-center">
				<div class="dataTables_paginate paging_bootstrap">
					<ul class="pagination">
						<?php echo $this->Paginator->prev(__('prev'), array('tag' => 'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a')); ?>
						<?php echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1, 'ellipsis' => '<li class="disabled"><a>...</a></li>')); ?>
						<?php echo $this->Paginator->next(__('next'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a')); ?>
					</ul>
				</div>
			</div>

			<div id="dialog" style="display: none"></div>
		</div>
	</div>
</div>

<?= $this->Html->scriptStart(array('inline' => true)); ?>
<?= $this->Html->scriptEnd(); ?>
