<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\License $license
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $license->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $license->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Licenses'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List License Partners'), ['controller' => 'LicensePartners', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New License Partner'), ['controller' => 'LicensePartners', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="licenses form large-9 medium-8 columns content">
    <?= $this->Form->create($license) ?>
    <fieldset>
        <legend><?= __('Edit License') ?></legend>
        <?php
            echo $this->Form->control('disp_no');
            echo $this->Form->control('is_valid');
            echo $this->Form->control('license_code');
            echo $this->Form->control('exp_s_dt', ['empty' => true]);
            echo $this->Form->control('exp_f_dt', ['empty' => true]);
            echo $this->Form->control('auth_datetime', ['empty' => true]);
            echo $this->Form->control('auth_info1');
            echo $this->Form->control('auth_info2');
            echo $this->Form->control('auth_info3');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
