<?php use Cake\Core\Configure; ?>
<div class="content-box-large">
	<div class="panel-heading">
		<div class="panel-title">塾 追加</div>
	</div>
	<div class="panel-body">
		<div id="rootwizard">
			<?= $this->Form->create($cramSchool, ['class' => 'form-horizontal', 'novalidate']) ?>
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
					<label for="" class="col-sm-2 control-label">塾名称<span class="required">*</span></label>
					<div class="col-sm-6">
						<?php echo $this->Form->input('name', ['type' => 'text', 'label' => false, 'required' => false, 'class' => 'form-control']); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">ログインID<span class="required">*</span></label>
					<div class="col-sm-4">
						<?php echo $this->Form->input('login_id', ['type' => 'text', 'label' => false, 'required' => false, 'class' => 'form-control']); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">パスワード<span class="required">*</span></label>
					<div class="col-sm-4">
						<?php echo $this->Form->input('password', ['type' => 'password', 'label' => false, 'required' => false, 'class' => 'form-control', 'value' => '']); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">電話番号<span class="required">*</span></label>
					<div class="col-sm-3">
						<?php echo $this->Form->input('tel', ['type' => 'text', 'label' => false, 'required' => false, 'class' => 'form-control', 'templates' => ['inputContainer' => '<div class="form-group text">{{content}}<span style="font-size:10px;">※半角で、ハイフン（-）を付けずに入力してください</span></div>']]); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">郵便番号</label>
					<div class="col-sm-3">
						<?php echo $this->Form->input('zip', ['type' => 'text', 'label' => false, 'required' => false, 'div' => false, 'class' => 'form-control', 'templates' => ['inputContainer' => '<div class="form-group text">{{content}}<span style="font-size:10px;">※半角で、ハイフン（-）を付けずに入力してください</span></div>']]); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">住所</label>
					<div class="col-sm-8">
						<?php echo $this->Form->input('address', ['type' => 'text', 'label' => false, 'required' => false, 'class' => 'form-control']); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">メモ</label>
					<div class="col-sm-8">
						<?php echo $this->Form->input('memo', ['type' => 'textarea', 'label' => false, 'required' => false, 'class' => 'form-control']); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">PC名、IP</label>
					<div class="col-sm-6">
						<?php echo $this->Form->input('host', ['type' => 'text', 'label' => false, 'required' => false, 'class' => 'form-control']); ?>
					</div>
				</div>

				<div class="form-actions">
					<div class="row text-center">
						<div class="col-md-12">
							<a href="<?= $this->Url->build(["controller" => "cramSchools", "action" => "index"], true); ?>" class="btn btn-default">戻る</a>
							<button class="btn btn-primary" type="submit" id="save-btn"><i class="fa fa-save"></i>登録</button>
						</div>
					</div>
				</div>

			<?= $this->Form->end() ?>
		</div>
	</div>
</div>

<?= $this->Html->scriptStart(['inline' => true]); ?>
<?= $this->Html->scriptEnd(); ?>
