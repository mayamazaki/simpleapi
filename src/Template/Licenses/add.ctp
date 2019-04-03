<?php use Cake\Core\Configure; ?>
<div class="content-box-large">
	<div class="panel-heading">
		<div class="panel-title">ライセンス 追加</div>
	</div>

	<div class="panel-body">
		<div id="rootwizard">
			<?= $this->Form->create($license, ['class' => 'form-horizontal', 'novalidate']) ?>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">表示順<span class="required">*</span></label>
					<div class="col-sm-2">
						<?php echo $this->Form->input('disp_no', ['type' => 'text', 'label' => false, 'required' => false, 'class' => 'form-control']); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">有効/無効<span class="required">*</span></label>
					<div class="col-sm-2">
						<?php echo $this->Form->input('is_valid', ['label' => false, 'type' => 'select', 'required' => false, 'class' => 'form-control', 'options' => Configure::read('is_valid'), 'default' => '1']); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">ライセンスコード<span class="required">*</span></label>
					<div class="col-sm-6">
						<?php echo $this->Form->input('license_code', ['type' => 'text', 'label' => false, 'required' => false, 'class' => 'form-control']); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">ライセンス有効期間（開始日）</label>
					<div class="col-sm-2" bfh-datepicker-toggle" data-toggle="bfh-datepicker">
						<?php echo $this->Form->input('exp_s_dt', ['type' => 'text', 'label' => false, 'required' => false, 'class' => 'form-control datepicker', 'div' => false]); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">ライセンス有効期間（終了日）</label>
					<div class="col-sm-2" bfh-datepicker-toggle" data-toggle="bfh-datepicker">
						<?php echo $this->Form->input('exp_f_dt', ['type' => 'text', 'label' => false, 'required' => false, 'class' => 'form-control datepicker', 'div' => false]); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">認証日時</label>
					<div class="col-sm-2" bfh-datepicker-toggle" data-toggle="bfh-datepicker">
						<?php echo $this->Form->input('auth_datetime', ['type' => 'text', 'label' => false, 'required' => false, 'class' => 'form-control datetimepicker', 'div' => false]); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">認証に絡む情報１（予備）</label>
					<div class="col-sm-6">
						<?php echo $this->Form->input('auth_info1', ['type' => 'text', 'label' => false, 'required' => false, 'class' => 'form-control']); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">認証に絡む情報２（予備）</label>
					<div class="col-sm-6">
						<?php echo $this->Form->input('auth_info2', ['type' => 'text', 'label' => false, 'required' => false, 'class' => 'form-control']); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">認証に絡む情報３（予備）</label>
					<div class="col-sm-6">
						<?php echo $this->Form->input('auth_info3', ['type' => 'text', 'label' => false, 'required' => false, 'class' => 'form-control']); ?>
					</div>
				</div>

				<div class="form-actions">
					<div class="row text-center">
						<div class="col-md-12">
							<a href="<?= $this->Url->build(["controller" => "licenses", "action" => "index"], true); ?>" class="btn btn-default">戻る</a>
							<button class="btn btn-primary" type="submit" id="save-btn"><i class="fa fa-save"></i>登録</button>
						</div>
					</div>
				</div>

			<?= $this->Form->end() ?>
		</div>
	</div>
</div>

<!-- jquery-ui -->
<link href="https://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" rel="stylesheet" media="screen">
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

<!-- datepicker -->
<?= $this->Html->script('jquery.ui.datepicker-ja.js'); ?>

<!-- datetimepicker -->
<?= $this->Html->script('jquery.datetimepicker.full.min.js'); ?>
<?= $this->Html->css('jquery.datetimepicker.min.css'); ?>

<?= $this->Html->scriptStart(['inline' => true]); ?>

$(function () {
	// datepicke
	$('.datepicker').datepicker({
		autoclose: true,
		format: 'yyyy-mm-dd',
		language: 'ja'
	});
	// datetimepicke
	$('.datetimepicker').datetimepicker({
		format: 'Y-m-d H:i:s',
		lang: 'ja'
	});
});

<?= $this->Html->scriptEnd(); ?>
