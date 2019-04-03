<?php use Cake\Core\Configure; ?>
<div class="content-box-large">
	<div class="panel-heading">
		<div class="panel-title">ユーザー編集</div>
	</div>
	<div class="panel-body">
		<div id="rootwizard">
			<?= $this->Form->create($user, ['class' => 'form-horizontal', 'novalidate']) ?>
			<?php // echo $this->Form->create('User', ['class' => 'form-horizontal', 'novalidate']);?>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">表示順<span class="required">*</span></label>
					<div class="col-sm-1">
						<?php echo $this->Form->input('User.disp_no', ['type' => 'text', 'label' => false, 'required' => false, 'class' => 'form-control']); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">有効/無効<span class="required">*</span></label>
					<div class="col-sm-3">
						<?php echo $this->Form->input('User.is_valid', ['label' => false, 'type' => 'select', 'required' => false, 'class' => 'form-control', 'options' => Configure::read('is_valid'), 'default' => '1']); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">ユーザー名<span class="required">*</span></label>
					<div class="col-sm-10">
						<?php echo $this->Form->input('User.name', ['type' => 'text', 'label' => false, 'required' => false, 'class' => 'form-control']); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">音声タイプ<span class="required">*</span></label>
					<div class="col-sm-3">
						<?php echo $this->Form->input('User.voice_type', ['label' => false, 'type' => 'select', 'required' => false, 'class' => 'form-control', 'options' => Configure::read('voice_type'), 'empty' => '選択してください']); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">誕生日<span class="required">*</span></label>
					<div class="col-sm-2" bfh-datepicker-toggle" data-toggle="bfh-datepicker">
						<?php echo $this->Form->input('User.birthday', ['type' => 'text', 'label' => false, 'required' => false, 'class' => 'form-control datepicker', 'div' => false]); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">ログインID<span class="required">*</span></label>
					<div class="col-sm-6">
						<?php echo $this->Form->input('User.login_id', ['type' => 'text', 'label' => false, 'required' => false, 'class' => 'form-control']); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">パスワード<span class="required">*</span></label>
					<div class="col-sm-6">
						<?php echo $this->Form->input('User.password', ['type' => 'password', 'label' => false, 'required' => false, 'class' => 'form-control', 'value' => '']); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">塾<span class="required">*</span></label>
					<div class="col-sm-4">
						<?php echo $this->Form->input('User.cram_school_id', ['label' => false, 'type' => 'select', 'empty' => '選択してください', 'required' => false, 'class' => 'form-control']); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">電話番号<span class="required">*</span></label>
					<div class="col-sm-10">
						<?php echo $this->Form->input('User.tel', ['type' => 'text', 'label' => false, 'required' => false, 'class' => 'form-control']); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">郵便番号</label>
					<div class="col-sm-10">
						<?php echo $this->Form->input('User.zip', ['type' => 'text', 'label' => false, 'required' => false, 'class' => 'form-control']); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">住所</label>
					<div class="col-sm-10">
						<?php echo $this->Form->input('User.address', ['type' => 'text', 'label' => false, 'required' => false, 'class' => 'form-control']); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">メモ</label>
					<div class="col-sm-10">
						<?php echo $this->Form->input('User.memo', ['type' => 'textarea', 'label' => false, 'required' => false, 'class' => 'form-control']); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">PC名、IP</label>
					<div class="col-sm-10">
						<?php echo $this->Form->input('User.host', ['type' => 'text', 'label' => false, 'required' => false, 'class' => 'form-control']); ?>
					</div>
				</div>

				<div class="form-actions">
					<div class="row text-center">
						<div class="col-md-12">
							<a href="#" class="btn btn-default">戻る</a>
							<button class="btn btn-primary" type="submit" id="save-btn"><i class="fa fa-save"></i>登録</button>
						</div>
					</div>
				</div>


				<?= $this->Form->control('User.id', ['value' => $user->id]); ?>
			<?= $this->Form->end() ?>
		</div>
	</div>
</div>

<?= $this->Html->scriptStart(['inline' => true]); ?>
<?= $this->Html->scriptEnd(); ?>
